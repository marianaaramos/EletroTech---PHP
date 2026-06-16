<?php

class OrderController extends BaseController
{
    private Order $orderModel;

    public function __construct()
    {
        $this->orderModel = new Order();
    }

    public function index(): void
    {
        $this->requireLogin();
        $userId  = (int) $_SESSION['usuario_id'];
        $pedidos = $this->orderModel->findByUser($userId);

        $this->render('orders/index', [
            'titulo'  => 'Meus Pedidos',
            'pedidos' => $pedidos,
        ]);
    }

    public function show(): void
    {
        $this->requireLogin();
        $id     = (int) ($_GET['id'] ?? 0);
        $pedido = $this->orderModel->findWithItems($id);

        if (!$pedido) {
            $this->setError('Pedido não encontrado.');
            $this->redirectTo('orders', 'index');
        }

        if (!$this->isAdmin() && (int) $pedido['usuario_id'] !== (int) $_SESSION['usuario_id']) {
            $this->setError('Acesso negado.');
            $this->redirectTo('orders', 'index');
        }

        $this->render('orders/show', [
            'titulo'  => 'Pedido #' . $pedido['id'],
            'pedido'  => $pedido,
        ]);
    }

    public function adminIndex(): void
    {
        $this->requireAdmin();
        $page       = max(1, (int) ($_GET['page'] ?? 1));
        $pedidos    = $this->orderModel->findAllWithUser($page, 15);
        $total      = $this->orderModel->count();
        $totalPages = (int) ceil($total / 15);

        $this->render('orders/admin_index', [
            'titulo'     => 'Gerenciar Pedidos',
            'pedidos'    => $pedidos,
            'total'      => $total,
            'page'       => $page,
            'totalPages' => $totalPages,
            'csrfToken'  => $this->generateCsrfToken(),
        ]);
    }

    public function updateStatus(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('orders', 'adminIndex');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('orders', 'adminIndex');
        }

        $id     = (int) ($_POST['id'] ?? 0);
        $status = $this->post('status');

        if ($this->orderModel->updateStatus($id, $status)) {
            $this->setSuccess('Status do pedido atualizado!');
        } else {
            $this->setError('Erro ao atualizar status.');
        }

        $this->redirectTo('orders', 'adminIndex');
    }
}
