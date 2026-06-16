<?php /* Lista de Usuários (Admin) */ ?>

<div class="container admin-page">
    <div class="page-header">
        <h1>👥 Usuários <span class="badge"><?= $total ?></span></h1>
        <a href="<?= APP_URL ?>/index.php?controller=users&action=create" class="btn btn-primary">+ Novo Usuário</a>
    </div>

    <div class="card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>CPF</th>
                    <th>Perfil</th>
                    <th>Cadastro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($usuarios)): ?>
                    <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario['id'] ?></td>
                        <td><strong><?= htmlspecialchars($usuario['nome']) ?></strong></td>
                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                        <td><?= htmlspecialchars($usuario['cpf'] ? substr($usuario['cpf'], 0, 3) . '.***.***-' . substr($usuario['cpf'], -2) : '-') ?></td>
                        <td>
                            <?php if ($usuario['role'] === 'admin'): ?>
                                <span class="badge badge-danger">Admin</span>
                            <?php else: ?>
                                <span class="badge badge-info">Cliente</span>
                            <?php endif; ?>
                        </td>
                        <td><?= date('d/m/Y', strtotime($usuario['created_at'])) ?></td>
                        <td class="actions">
                            <a href="<?= APP_URL ?>/index.php?controller=users&action=edit&id=<?= $usuario['id'] ?>"
                               class="btn btn-sm btn-outline">✏️ Editar</a>
                            <?php if ($usuario['id'] != $_SESSION['usuario_id']): ?>
                                <a href="<?= APP_URL ?>/index.php?controller=users&action=destroy&id=<?= $usuario['id'] ?>&csrf_token=<?= urlencode($csrfToken) ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Excluir o usuário \'<?= htmlspecialchars($usuario['nome']) ?>\'?')">
                                   🗑️ Excluir
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" class="text-center">Nenhum usuário encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginação -->
    <?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= APP_URL ?>/index.php?controller=users&action=index&page=<?= $i ?>"
               class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>
