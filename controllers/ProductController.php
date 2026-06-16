<?php

class ProductController extends BaseController
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
        $page    = max(1, (int) ($_GET['page'] ?? 1));
        $catId   = (int) ($_GET['categoria'] ?? 0);
        $busca   = $this->get('busca');
        $perPage = ITEMS_PER_PAGE;

        if (!empty($busca)) {
            $produtos = $this->productModel->search($busca, $page, $perPage);
            $total    = $this->productModel->countSearch($busca);
        } elseif ($catId > 0) {
            $produtos = $this->productModel->findByCategory($catId, $page, $perPage);
            $total    = $this->productModel->countByCategory($catId);
        } else {
            $produtos = $this->productModel->findAllWithCategory($page, $perPage);
            $total    = $this->productModel->countActive();
        }

        $totalPages = (int) ceil($total / $perPage);
        $categorias = $this->categoryModel->findActive();

        $this->render('products/index', [
            'titulo'     => 'Produtos - EletroTech',
            'produtos'   => $produtos,
            'categorias' => $categorias,
            'total'      => $total,
            'page'       => $page,
            'totalPages' => $totalPages,
            'catId'      => $catId,
            'busca'      => $busca,
        ]);
    }

    public function show(): void
    {
        $id      = (int) ($_GET['id'] ?? 0);
        $produto = $this->productModel->findByIdWithCategory($id);

        if (!$produto || !$produto['ativo']) {
            $this->render('errors/404', ['titulo' => 'Produto não encontrado']);
            return;
        }

        $this->render('products/show', [
            'titulo'  => $produto['nome'] . ' - EletroTech',
            'produto' => $produto,
        ]);
    }

    public function create(): void
    {
        $this->requireAdmin();
        $categorias = $this->categoryModel->findActive();
        $csrfToken  = $this->generateCsrfToken();

        $this->render('products/create', [
            'titulo'     => 'Novo Produto',
            'categorias' => $categorias,
            'csrfToken'  => $csrfToken,
        ]);
    }

    public function store(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('products', 'create');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('products', 'create');
        }

        $erros = $this->validateProductData($_POST);

        if (!empty($erros)) {
            $_SESSION['flash_errors'] = $erros;
            $_SESSION['form_data']    = $_POST;
            $this->redirectTo('products', 'create');
        }

        $data = $_POST;

        if (!empty($_FILES['imagem']['name'])) {
            $nomeImg = $this->productModel->handleImageUpload($_FILES['imagem']);
            if ($nomeImg) {
                $data['imagem'] = $nomeImg;
            } else {
                $this->setError('Erro no upload da imagem. Verifique o formato e tamanho.');
                $this->redirectTo('products', 'create');
            }
        } else {
            $data['imagem'] = '';
        }

        $id = $this->productModel->create($data);

        if ($id) {
            $this->setSuccess('Produto cadastrado com sucesso!');
            $this->redirectTo('admin', 'products');
        } else {
            $this->setError('Erro ao cadastrar produto.');
            $this->redirectTo('products', 'create');
        }
    }

    public function edit(): void
    {
        $this->requireAdmin();
        $id      = (int) ($_GET['id'] ?? 0);
        $produto = $this->productModel->findById($id);

        if (!$produto) {
            $this->setError('Produto não encontrado.');
            $this->redirectTo('admin', 'products');
        }

        $categorias = $this->categoryModel->findActive();
        $csrfToken  = $this->generateCsrfToken();

        $this->render('products/edit', [
            'titulo'     => 'Editar: ' . $produto['nome'],
            'produto'    => $produto,
            'categorias' => $categorias,
            'csrfToken'  => $csrfToken,
        ]);
    }

    public function update(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('admin', 'products');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('admin', 'products');
        }

        $id    = (int) ($_POST['id'] ?? 0);
        $erros = $this->validateProductData($_POST);

        if (!empty($erros)) {
            $_SESSION['flash_errors'] = $erros;
            $this->redirect(APP_URL . '/index.php?controller=products&action=edit&id=' . $id);
        }

        $data = $_POST;

        if (!empty($_FILES['imagem']['name'])) {
            $nomeImg = $this->productModel->handleImageUpload($_FILES['imagem']);
            if ($nomeImg) {
                $produtoAtual = $this->productModel->findById($id);
                if ($produtoAtual && !empty($produtoAtual['imagem'])) {
                    $imgPath = UPLOAD_DIR . $produtoAtual['imagem'];
                    if (file_exists($imgPath)) {
                        unlink($imgPath);
                    }
                }
                $data['imagem'] = $nomeImg;
            }
        }

        if ($this->productModel->update($id, $data)) {
            $this->setSuccess('Produto atualizado com sucesso!');
        } else {
            $this->setError('Erro ao atualizar produto.');
        }

        $this->redirectTo('admin', 'products');
    }

    public function destroy(): void
    {
        $this->requireAdmin();

        if (!$this->validateCsrfToken($_GET['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('admin', 'products');
        }

        $id      = (int) ($_GET['id'] ?? 0);
        $produto = $this->productModel->findById($id);

        if (!$produto) {
            $this->setError('Produto não encontrado.');
            $this->redirectTo('admin', 'products');
        }

        if (!empty($produto['imagem'])) {
            $imgPath = UPLOAD_DIR . $produto['imagem'];
            if (file_exists($imgPath)) {
                unlink($imgPath);
            }
        }

        if ($this->productModel->delete($id)) {
            $this->setSuccess('Produto excluído com sucesso!');
        } else {
            $this->setError('Erro ao excluir produto.');
        }

        $this->redirectTo('admin', 'products');
    }

    private function validateProductData(array $data): array
    {
        $erros = [];

        if (empty($data['nome']) || strlen(trim($data['nome'])) < 3) {
            $erros[] = 'Nome deve ter pelo menos 3 caracteres.';
        }

        if (empty($data['preco']) || (float) str_replace(',', '.', $data['preco']) <= 0) {
            $erros[] = 'Preço inválido.';
        }

        if (empty($data['categoria_id'])) {
            $erros[] = 'Selecione uma categoria.';
        }

        if (!isset($data['estoque']) || (int) $data['estoque'] < 0) {
            $erros[] = 'Estoque deve ser um número positivo.';
        }

        return $erros;
    }
}
