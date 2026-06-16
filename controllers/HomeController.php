<?php

class HomeController extends BaseController
{
    private Product $productModel;
    private Category $categoryModel;

    public function __construct()
    {
        $this->productModel  = new Product();
        $this->categoryModel = new Category();
    }

    public function index(): void
    {
        $produtos_destaque = $this->productModel->findFeatured(8);
        $categorias        = $this->categoryModel->findWithProductCount();

        $stats = [
            'total_produtos'   => $this->productModel->countActive(),
            'total_categorias' => count($categorias),
        ];

        $this->render('home/index', [
            'produtos_destaque' => $produtos_destaque,
            'categorias'        => $categorias,
            'stats'             => $stats,
            'titulo'            => 'EletroTech - A melhor loja de eletrônicos',
        ]);
    }

    public function about(): void
    {
        $diferenciais = [
            ['icone' => '🚀', 'titulo' => 'Entrega Rápida',    'texto' => 'Entregamos em todo o Brasil em até 3 dias úteis.'],
            ['icone' => '🔒', 'titulo' => 'Compra Segura',     'texto' => 'Ambiente 100% seguro com criptografia SSL.'],
            ['icone' => '⭐', 'titulo' => 'Produtos Originais', 'texto' => 'Trabalhamos apenas com produtos originais e com garantia.'],
            ['icone' => '🎧', 'titulo' => 'Suporte 24/7',      'texto' => 'Nossa equipe está disponível a qualquer hora.'],
        ];

        $this->render('about/index', [
            'titulo'       => 'Sobre a EletroTech',
            'diferenciais' => $diferenciais,
        ]);
    }

    public function contact(): void
    {
        $csrfToken = $this->generateCsrfToken();
        $this->render('contact/index', [
            'titulo'    => 'Contato - EletroTech',
            'csrfToken' => $csrfToken,
        ]);
    }

    public function contactPost(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('home', 'contact');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('home', 'contact');
        }

        $nome     = $this->post('nome');
        $email    = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $mensagem = $this->post('mensagem');

        if (empty($nome) || empty($email) || empty($mensagem)) {
            $this->setError('Preencha todos os campos obrigatórios.');
            $this->redirectTo('home', 'contact');
        }

        $this->setSuccess('Mensagem enviada com sucesso! Retornaremos em breve.');
        $this->redirectTo('home', 'contact');
    }

    public function phpDemo(): void
    {
        $this->requireAdmin();
        $this->render('home/php_demo', ['titulo' => 'Demo PHP - Conceitos']);
    }
}
