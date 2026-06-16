<?php

class CartController extends BaseController
{
    private Cart $cart;
    private Product $productModel;

    public function __construct()
    {
        $this->cart         = new Cart();
        $this->productModel = new Product();
    }

    public function index(): void
    {
        $itens     = $this->cart->getItems();
        $total     = $this->cart->getTotal();
        $csrfToken = $this->generateCsrfToken();

        $this->render('cart/index', [
            'titulo'    => 'Carrinho de Compras',
            'itens'     => $itens,
            'total'     => $total,
            'csrfToken' => $csrfToken,
        ]);
    }

    public function add(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('cart', 'index');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('cart', 'index');
        }

        $produtoId  = (int) ($_POST['produto_id'] ?? 0);
        $quantidade = max(1, (int) ($_POST['quantidade'] ?? 1));

        $produto = $this->productModel->findById($produtoId);

        if (!$produto || !$produto['ativo']) {
            $this->setError('Produto não encontrado.');
            $this->redirectTo('products', 'index');
        }

        if ($produto['estoque'] < $quantidade) {
            $this->setError('Quantidade solicitada indisponível em estoque.');
            $this->redirect(APP_URL . '/index.php?controller=products&action=show&id=' . $produtoId);
        }

        $this->cart->addItem($produto, $quantidade);
        $this->setSuccess('Produto adicionado ao carrinho!');
        $this->redirect(APP_URL . '/index.php?controller=products&action=show&id=' . $produtoId);
    }

    public function update(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('cart', 'index');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('cart', 'index');
        }

        $produtoId  = (int) ($_POST['produto_id'] ?? 0);
        $quantidade = (int) ($_POST['quantidade'] ?? 0);

        $this->cart->updateQuantity($produtoId, $quantidade);
        $this->setSuccess('Carrinho atualizado.');
        $this->redirectTo('cart', 'index');
    }

    public function remove(): void
    {
        if (!$this->validateCsrfToken($_GET['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('cart', 'index');
        }

        $produtoId = (int) ($_GET['id'] ?? 0);
        $this->cart->removeItem($produtoId);
        $this->setSuccess('Item removido do carrinho.');
        $this->redirectTo('cart', 'index');
    }

    public function checkout(): void
    {
        $this->requireLogin();

        if ($this->cart->isEmpty()) {
            $this->setError('Seu carrinho está vazio.');
            $this->redirectTo('cart', 'index');
        }

        $csrfToken = $this->generateCsrfToken();
        $itens     = $this->cart->getItems();
        $total     = $this->cart->getTotal();

        $this->render('cart/checkout', [
            'titulo'    => 'Finalizar Pedido',
            'itens'     => $itens,
            'total'     => $total,
            'csrfToken' => $csrfToken,
        ]);
    }

    public function processCheckout(): void
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('cart', 'checkout');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('cart', 'checkout');
        }

        if ($this->cart->isEmpty()) {
            $this->setError('Carrinho vazio.');
            $this->redirectTo('cart', 'index');
        }

        $userId = (int) $_SESSION['usuario_id'];
        $itens  = $this->cart->getItems();
        $total  = $this->cart->getTotal();

        $itensArray = [];
        foreach ($itens as $item) {
            $itensArray[] = [
                'produto_id' => $item['produto_id'],
                'quantidade' => $item['quantidade'],
                'preco'      => $item['preco'],
            ];
        }

        $orderModel = new Order();
        $pedidoId   = $orderModel->createWithItems($userId, $itensArray, $total);

        if ($pedidoId) {
            $this->cart->clear();
            $this->setSuccess('Pedido #' . $pedidoId . ' realizado com sucesso!');
            $this->redirect(APP_URL . '/index.php?controller=orders&action=show&id=' . $pedidoId);
        } else {
            $this->setError('Erro ao processar pedido. Tente novamente.');
            $this->redirectTo('cart', 'checkout');
        }
    }

    public function clear(): void
    {
        if (!$this->validateCsrfToken($_GET['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('cart', 'index');
        }

        $this->cart->clear();
        $this->setSuccess('Carrinho esvaziado.');
        $this->redirectTo('cart', 'index');
    }
}
