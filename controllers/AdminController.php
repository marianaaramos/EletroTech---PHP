<?php

class AdminController extends BaseController
{
    private Product $productModel;
    private Category $categoryModel;
    private User $userModel;
    private Order $orderModel;

    public function __construct()
    {
        $this->productModel  = new Product();
        $this->categoryModel = new Category();
        $this->userModel     = new User();
        $this->orderModel    = new Order();
    }

    public function dashboard(): void
    {
        $this->requireAdmin();

        $stats = [
            'total_produtos'   => $this->productModel->countActive(),
            'total_categorias' => $this->categoryModel->count(),
            'total_usuarios'   => $this->userModel->count(),
            'total_pedidos'    => $this->orderModel->count(),
            'faturamento'      => $this->orderModel->totalRevenue(),
            'pedidos_recentes' => $this->orderModel->recentCount(),
        ];

        $estoque_baixo   = $this->productModel->findLowStock(5);
        $ultimos_pedidos = $this->orderModel->findAllWithUser(1, 5);

        $this->render('admin/dashboard', [
            'titulo'          => 'Painel Administrativo',
            'stats'           => $stats,
            'estoque_baixo'   => $estoque_baixo,
            'ultimos_pedidos' => $ultimos_pedidos,
        ]);
    }

    public function products(): void
    {
        $this->requireAdmin();
        $page       = max(1, (int) ($_GET['page'] ?? 1));
        $produtos   = $this->productModel->findAllWithCategory($page, 15);
        $total      = $this->productModel->count();
        $totalPages = (int) ceil($total / 15);

        $this->render('admin/products', [
            'titulo'     => 'Gerenciar Produtos',
            'produtos'   => $produtos,
            'total'      => $total,
            'page'       => $page,
            'totalPages' => $totalPages,
            'csrfToken'  => $this->generateCsrfToken(),
        ]);
    }
}
