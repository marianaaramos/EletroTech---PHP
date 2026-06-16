<?php

class UserController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index(): void
    {
        $this->requireAdmin();
        $page       = max(1, (int) ($_GET['page'] ?? 1));
        $usuarios   = $this->userModel->findAllPaginated($page, 15);
        $total      = $this->userModel->count();
        $totalPages = (int) ceil($total / 15);

        $this->render('users/index', [
            'titulo'     => 'Gerenciar Usuários',
            'usuarios'   => $usuarios,
            'total'      => $total,
            'page'       => $page,
            'totalPages' => $totalPages,
            'csrfToken'  => $this->generateCsrfToken(),
        ]);
    }

    public function create(): void
    {
        $this->requireAdmin();
        $this->render('users/create', [
            'titulo'    => 'Novo Usuário',
            'csrfToken' => $this->generateCsrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('users', 'create');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('users', 'create');
        }

        $erros = $this->validateUserData($_POST);

        if (!empty($erros)) {
            $_SESSION['flash_errors'] = $erros;
            $_SESSION['form_data']    = $_POST;
            $this->redirectTo('users', 'create');
        }

        $id = $this->userModel->create([
            'nome'            => $this->post('nome'),
            'email'           => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
            'cpf'             => preg_replace('/\D/', '', $_POST['cpf'] ?? ''),
            'telefone'        => $this->post('telefone'),
            'data_nascimento' => $_POST['data_nascimento'] ?? null,
            'senha'           => $_POST['senha'],
            'role'            => $_POST['role'] ?? 'cliente',
        ]);

        if ($id) {
            $this->setSuccess('Usuário criado com sucesso!');
            $this->redirectTo('users', 'index');
        } else {
            $this->setError('Erro ao criar usuário.');
            $this->redirectTo('users', 'create');
        }
    }

    public function edit(): void
    {
        $this->requireAdmin();
        $id      = (int) ($_GET['id'] ?? 0);
        $usuario = $this->userModel->findById($id);

        if (!$usuario) {
            $this->setError('Usuário não encontrado.');
            $this->redirectTo('users', 'index');
        }

        $this->render('users/edit', [
            'titulo'    => 'Editar: ' . $usuario['nome'],
            'usuario'   => $usuario,
            'csrfToken' => $this->generateCsrfToken(),
        ]);
    }

    public function update(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('users', 'index');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('users', 'index');
        }

        $id    = (int) ($_POST['id'] ?? 0);
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

        if ($this->userModel->emailExists($email, $id)) {
            $this->setError('E-mail já cadastrado para outro usuário.');
            $this->redirect(APP_URL . '/index.php?controller=users&action=edit&id=' . $id);
        }

        if ($this->userModel->update($id, [
            'nome'            => $this->post('nome'),
            'email'           => $email,
            'telefone'        => $this->post('telefone'),
            'data_nascimento' => $_POST['data_nascimento'] ?? null,
            'senha'           => $_POST['nova_senha'] ?? '',
            'role'            => $_POST['role'] ?? 'cliente',
        ])) {
            if ((int) $_SESSION['usuario_id'] === $id) {
                $_SESSION['usuario_nome']  = $this->post('nome');
                $_SESSION['usuario_email'] = $email;
            }
            $this->setSuccess('Usuário atualizado com sucesso!');
        } else {
            $this->setError('Erro ao atualizar usuário.');
        }

        $this->redirectTo('users', 'index');
    }

    public function destroy(): void
    {
        $this->requireAdmin();

        if (!$this->validateCsrfToken($_GET['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('users', 'index');
        }

        $id = (int) ($_GET['id'] ?? 0);

        if ($id === (int) $_SESSION['usuario_id']) {
            $this->setError('Você não pode excluir sua própria conta.');
            $this->redirectTo('users', 'index');
        }

        if ($this->userModel->delete($id)) {
            $this->setSuccess('Usuário excluído com sucesso!');
        } else {
            $this->setError('Erro ao excluir usuário.');
        }

        $this->redirectTo('users', 'index');
    }

    public function profile(): void
    {
        $this->requireLogin();
        $id      = (int) $_SESSION['usuario_id'];
        $usuario = $this->userModel->findById($id);

        $this->render('users/profile', [
            'titulo'    => 'Meu Perfil',
            'usuario'   => $usuario,
            'csrfToken' => $this->generateCsrfToken(),
        ]);
    }

    public function profileUpdate(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('users', 'profile');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('users', 'profile');
        }

        $id      = (int) $_SESSION['usuario_id'];
        $email   = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $usuario = $this->userModel->findById($id);

        if (!empty($_POST['nova_senha'])) {
            if (empty($_POST['senha_atual']) || !password_verify($_POST['senha_atual'], $usuario['senha'])) {
                $this->setError('Senha atual incorreta.');
                $this->redirectTo('users', 'profile');
            }
        }

        if ($this->userModel->update($id, [
            'nome'            => $this->post('nome'),
            'email'           => $email,
            'telefone'        => $this->post('telefone'),
            'data_nascimento' => $_POST['data_nascimento'] ?? null,
            'senha'           => $_POST['nova_senha'] ?? '',
            'role'            => $usuario['role'],
        ])) {
            $_SESSION['usuario_nome']  = $this->post('nome');
            $_SESSION['usuario_email'] = $email;
            $this->setSuccess('Perfil atualizado com sucesso!');
        } else {
            $this->setError('Erro ao atualizar perfil.');
        }

        $this->redirectTo('users', 'profile');
    }

    private function validateUserData(array $data): array
    {
        $erros = [];

        if (empty($data['nome']) || strlen(trim($data['nome'])) < 3) {
            $erros[] = 'Nome deve ter pelo menos 3 caracteres.';
        }

        $email = filter_var($data['email'] ?? '', FILTER_SANITIZE_EMAIL);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erros[] = 'E-mail inválido.';
        } elseif ($this->userModel->emailExists($email)) {
            $erros[] = 'E-mail já cadastrado.';
        }

        $cpf = preg_replace('/\D/', '', $data['cpf'] ?? '');
        if (strlen($cpf) !== 11) {
            $erros[] = 'CPF inválido.';
        } elseif ($this->userModel->cpfExists($cpf)) {
            $erros[] = 'CPF já cadastrado.';
        }

        if (empty($data['senha']) || strlen($data['senha']) < 6) {
            $erros[] = 'Senha deve ter pelo menos 6 caracteres.';
        }

        return $erros;
    }
}
