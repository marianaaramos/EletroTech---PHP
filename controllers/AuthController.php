<?php

class AuthController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirectTo('home', 'index');
        }

        $csrfToken = $this->generateCsrfToken();
        $this->render('auth/login', ['csrfToken' => $csrfToken]);
    }

    public function loginPost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('auth', 'login');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token de segurança inválido. Tente novamente.');
            $this->redirectTo('auth', 'login');
        }

        $email   = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $senha   = $_POST['senha'] ?? '';
        $lembrar = !empty($_POST['lembrar']);

        if (empty($email) || empty($senha)) {
            $this->setError('Por favor, preencha todos os campos.');
            $this->redirectTo('auth', 'login');
        }

        $usuario = $this->userModel->authenticate($email, $senha);

        if ($usuario) {
            session_regenerate_id(true);
            $_SESSION['usuario_id']    = $usuario['id'];
            $_SESSION['usuario_nome']  = $usuario['nome'];
            $_SESSION['usuario_email'] = $usuario['email'];
            $_SESSION['usuario_role']  = $usuario['role'];

            if ($lembrar) {
                $token = bin2hex(random_bytes(32));
                $this->userModel->saveRememberToken($usuario['id'], $token);
                setcookie(COOKIE_NAME, $token, time() + COOKIE_LIFETIME, '/', '', false, true);
            }

            $this->setSuccess('Bem-vindo(a), ' . $usuario['nome'] . '!');

            if ($usuario['role'] === 'admin') {
                $this->redirectTo('admin', 'dashboard');
            } else {
                $this->redirectTo('home', 'index');
            }
        } else {
            $this->setError('E-mail ou senha incorretos.');
            $this->redirectTo('auth', 'login');
        }
    }

    public function logout(): void
    {
        if (!empty($_SESSION['usuario_id'])) {
            $this->userModel->clearRememberToken($_SESSION['usuario_id']);
        }

        $_SESSION = [];
        session_destroy();

        if (isset($_COOKIE[COOKIE_NAME])) {
            setcookie(COOKIE_NAME, '', time() - 3600, '/');
        }

        $this->redirect(APP_URL . '/index.php?controller=auth&action=login');
    }

    public function register(): void
    {
        if ($this->isLoggedIn()) {
            $this->redirectTo('home', 'index');
        }

        $csrfToken = $this->generateCsrfToken();
        $this->render('auth/register', ['csrfToken' => $csrfToken]);
    }

    public function registerPost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('auth', 'register');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token de segurança inválido.');
            $this->redirectTo('auth', 'register');
        }

        $nome       = $this->post('nome');
        $email      = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $cpf        = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
        $telefone   = $this->post('telefone');
        $nascimento = $_POST['data_nascimento'] ?? '';
        $senha      = $_POST['senha'] ?? '';
        $confirma   = $_POST['confirma_senha'] ?? '';

        $erros = [];

        if (empty($nome) || strlen($nome) < 3) {
            $erros[] = 'Nome deve ter pelo menos 3 caracteres.';
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros[] = 'E-mail inválido.';
        } elseif ($this->userModel->emailExists($email)) {
            $erros[] = 'E-mail já cadastrado.';
        }

        if (strlen($cpf) !== 11) {
            $erros[] = 'CPF inválido.';
        } elseif ($this->userModel->cpfExists($cpf)) {
            $erros[] = 'CPF já cadastrado.';
        }

        if (empty($nascimento)) {
            $erros[] = 'Data de nascimento obrigatória.';
        }

        if (strlen($senha) < 6) {
            $erros[] = 'Senha deve ter pelo menos 6 caracteres.';
        } elseif ($senha !== $confirma) {
            $erros[] = 'Senhas não conferem.';
        }

        if (!empty($erros)) {
            $_SESSION['flash_errors'] = $erros;
            $_SESSION['form_data']    = $_POST;
            $this->redirectTo('auth', 'register');
        }

        $resultado = $this->userModel->create([
            'nome'            => $nome,
            'email'           => $email,
            'cpf'             => $cpf,
            'telefone'        => $telefone,
            'data_nascimento' => $nascimento,
            'senha'           => $senha,
            'role'            => 'cliente',
        ]);

        if ($resultado) {
            $this->setSuccess('Cadastro realizado com sucesso! Faça seu login.');
            $this->redirectTo('auth', 'login');
        } else {
            $this->setError('Erro ao criar conta. Tente novamente.');
            $this->redirectTo('auth', 'register');
        }
    }

    public function recover(): void
    {
        $csrfToken = $this->generateCsrfToken();
        $this->render('auth/recover', ['csrfToken' => $csrfToken, 'step' => 1]);
    }

    public function recoverPost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('auth', 'recover');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('auth', 'recover');
        }

        $step = (int) ($_POST['step'] ?? 1);

        if ($step === 1) {
            $cpf        = preg_replace('/\D/', '', $_POST['cpf'] ?? '');
            $nascimento = $_POST['data_nascimento'] ?? '';

            $usuario = $this->userModel->findForRecovery($cpf, $nascimento);

            if ($usuario) {
                $_SESSION['recover_user_id'] = $usuario['id'];
                $csrfToken = $this->generateCsrfToken();
                $this->render('auth/recover', [
                    'csrfToken' => $csrfToken,
                    'step'      => 2,
                    'usuario'   => $usuario,
                ]);
            } else {
                $this->setError('CPF ou data de nascimento não encontrados.');
                $this->redirectTo('auth', 'recover');
            }
        } elseif ($step === 2) {
            if (empty($_SESSION['recover_user_id'])) {
                $this->redirectTo('auth', 'recover');
            }

            $senha    = $_POST['nova_senha'] ?? '';
            $confirma = $_POST['confirma_senha'] ?? '';

            if (strlen($senha) < 6) {
                $this->setError('Senha deve ter pelo menos 6 caracteres.');
                $this->redirectTo('auth', 'recover');
            }

            if ($senha !== $confirma) {
                $this->setError('Senhas não conferem.');
                $this->redirectTo('auth', 'recover');
            }

            $userId = (int) $_SESSION['recover_user_id'];
            if ($this->userModel->updatePassword($userId, $senha)) {
                unset($_SESSION['recover_user_id']);
                $this->setSuccess('Senha alterada com sucesso! Faça o login.');
                $this->redirectTo('auth', 'login');
            } else {
                $this->setError('Erro ao alterar senha. Tente novamente.');
                $this->redirectTo('auth', 'recover');
            }
        }
    }
}
