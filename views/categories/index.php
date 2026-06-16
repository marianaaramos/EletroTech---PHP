<?php ?>

<div class="container admin-page">
    <div class="page-header">
        <h1>Categorias</h1>
        <a href="<?= APP_URL ?>/index.php?controller=categories&action=create" class="btn btn-primary">+ Nova Categoria</a>
    </div>

    <div class="card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Slug</th>
                    <th>Descrição</th>
                    <th>Produtos</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categorias)): ?>
                    <?php foreach ($categorias as $cat): ?>
                    <tr>
                        <td><?= $cat['id'] ?></td>
                        <td><strong><?= htmlspecialchars($cat['nome']) ?></strong></td>
                        <td><code><?= htmlspecialchars($cat['slug']) ?></code></td>
                        <td><?= htmlspecialchars(substr($cat['descricao'] ?? '', 0, 60)) ?><?= strlen($cat['descricao'] ?? '') > 60 ? '...' : '' ?></td>
                        <td><span class="badge"><?= $cat['total_produtos'] ?></span></td>
                        <td>
                            <?php if ($cat['ativo']): ?>
                                <span class="badge badge-success">Ativo</span>
                            <?php else: ?>
                                <span class="badge badge-danger">Inativo</span>
                            <?php endif; ?>
                        </td>
                        <td class="actions">
                            <a href="<?= APP_URL ?>/index.php?controller=categories&action=edit&id=<?= $cat['id'] ?>"
                               class="btn btn-sm btn-outline">Editar</a>
                            <a href="<?= APP_URL ?>/index.php?controller=categories&action=destroy&id=<?= $cat['id'] ?>&csrf_token=<?= urlencode($csrfToken) ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Excluir a categoria \'<?= htmlspecialchars($cat['nome']) ?>\'? Esta ação não pode ser desfeita.')">
                               Excluir
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">Nenhuma categoria cadastrada.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
