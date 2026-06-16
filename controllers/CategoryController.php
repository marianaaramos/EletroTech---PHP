<?php

class CategoryController extends BaseController
{
    private Category $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new Category();
    }

    public function index(): void
    {
        $this->requireAdmin();
        $categorias = $this->categoryModel->findWithProductCount();

        $this->render('categories/index', [
            'titulo'     => 'Gerenciar Categorias',
            'categorias' => $categorias,
            'csrfToken'  => $this->generateCsrfToken(),
        ]);
    }

    public function create(): void
    {
        $this->requireAdmin();
        $this->render('categories/create', [
            'titulo'    => 'Nova Categoria',
            'csrfToken' => $this->generateCsrfToken(),
        ]);
    }

    public function store(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('categories', 'create');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('categories', 'create');
        }

        $nome      = $this->post('nome');
        $descricao = $this->post('descricao');

        if (empty($nome) || strlen($nome) < 2) {
            $this->setError('Nome deve ter pelo menos 2 caracteres.');
            $this->redirectTo('categories', 'create');
        }

        if ($this->categoryModel->nameExists($nome)) {
            $this->setError('Já existe uma categoria com este nome.');
            $this->redirectTo('categories', 'create');
        }

        $id = $this->categoryModel->create([
            'nome'      => $nome,
            'descricao' => $descricao,
            'ativo'     => isset($_POST['ativo']) ? '1' : '0',
        ]);

        if ($id) {
            $this->setSuccess('Categoria criada com sucesso!');
            $this->redirectTo('categories', 'index');
        } else {
            $this->setError('Erro ao criar categoria.');
            $this->redirectTo('categories', 'create');
        }
    }

    public function edit(): void
    {
        $this->requireAdmin();
        $id        = (int) ($_GET['id'] ?? 0);
        $categoria = $this->categoryModel->findById($id);

        if (!$categoria) {
            $this->setError('Categoria não encontrada.');
            $this->redirectTo('categories', 'index');
        }

        $this->render('categories/edit', [
            'titulo'    => 'Editar: ' . $categoria['nome'],
            'categoria' => $categoria,
            'csrfToken' => $this->generateCsrfToken(),
        ]);
    }

    public function update(): void
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirectTo('categories', 'index');
        }

        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('categories', 'index');
        }

        $id        = (int) ($_POST['id'] ?? 0);
        $nome      = $this->post('nome');
        $descricao = $this->post('descricao');

        if (empty($nome) || strlen($nome) < 2) {
            $this->setError('Nome inválido.');
            $this->redirect(APP_URL . '/index.php?controller=categories&action=edit&id=' . $id);
        }

        if ($this->categoryModel->nameExists($nome, $id)) {
            $this->setError('Já existe outra categoria com este nome.');
            $this->redirect(APP_URL . '/index.php?controller=categories&action=edit&id=' . $id);
        }

        if ($this->categoryModel->update($id, [
            'nome'      => $nome,
            'descricao' => $descricao,
            'ativo'     => isset($_POST['ativo']) ? '1' : '0',
        ])) {
            $this->setSuccess('Categoria atualizada com sucesso!');
        } else {
            $this->setError('Erro ao atualizar categoria.');
        }

        $this->redirectTo('categories', 'index');
    }

    public function destroy(): void
    {
        $this->requireAdmin();

        if (!$this->validateCsrfToken($_GET['csrf_token'] ?? '')) {
            $this->setError('Token inválido.');
            $this->redirectTo('categories', 'index');
        }

        $id = (int) ($_GET['id'] ?? 0);

        if ($this->categoryModel->delete($id)) {
            $this->setSuccess('Categoria excluída com sucesso!');
        } else {
            $this->setError('Erro ao excluir categoria. Verifique se há produtos vinculados.');
        }

        $this->redirectTo('categories', 'index');
    }
}
