<?php

abstract class BaseController
{
    protected function render(string $view, array $data = [], bool $useLayout = true): void
    {
        extract($data);

        $viewPath = ROOT_PATH . '/views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            $this->render('errors/404', [], $useLayout);
            return;
        }

        if ($useLayout) {
            ob_start();
            require $viewPath;
            $content = ob_get_clean();

            require ROOT_PATH . '/views/layouts/header.php';
            echo $content;
            require ROOT_PATH . '/views/layouts/footer.php';
        } else {
            require $viewPath;
        }
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
        exit;
    }

    protected function redirectTo(string $controller, string $action = 'index', array $params = []): void
    {
        $url = APP_URL . '/index.php?controller=' . $controller . '&action=' . $action;
        foreach ($params as $key => $value) {
            $url .= '&' . $key . '=' . urlencode($value);
        }
        $this->redirect($url);
    }

    protected function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    protected function validateCsrfToken(string $token): bool
    {
        if (empty($_SESSION['csrf_token'])) return false;
        $valid = hash_equals($_SESSION['csrf_token'], $token);
        unset($_SESSION['csrf_token']);
        return $valid;
    }

    protected function isLoggedIn(): bool
    {
        return !empty($_SESSION['usuario_id']);
    }

    protected function isAdmin(): bool
    {
        return !empty($_SESSION['usuario_role']) && $_SESSION['usuario_role'] === 'admin';
    }

    protected function requireLogin(): void
    {
        if (!$this->isLoggedIn()) {
            $_SESSION['flash_error'] = 'Faça login para acessar esta página.';
            $this->redirectTo('auth', 'login');
        }
    }

    protected function requireAdmin(): void
    {
        $this->requireLogin();
        if (!$this->isAdmin()) {
            $_SESSION['flash_error'] = 'Acesso negado. Área restrita a administradores.';
            $this->redirectTo('home', 'index');
        }
    }

    protected function setSuccess(string $mensagem): void
    {
        $_SESSION['flash_success'] = $mensagem;
    }

    protected function setError(string $mensagem): void
    {
        $_SESSION['flash_error'] = $mensagem;
    }

    protected function sanitize(string $value): string
    {
        return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
    }

    protected function post(string $key, string $default = ''): string
    {
        return isset($_POST[$key]) ? $this->sanitize($_POST[$key]) : $default;
    }

    protected function get(string $key, string $default = ''): string
    {
        return isset($_GET[$key]) ? $this->sanitize($_GET[$key]) : $default;
    }

    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
