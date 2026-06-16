<?php /* Gerenciar pedidos (admin) */ ?>

<div class="container admin-page">
    <div class="page-header">
        <h1>📦 Gerenciar Pedidos <span class="badge"><?= $total ?></span></h1>
    </div>

    <div class="card">
        <table class="data-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= $pedido['id'] ?></td>
                    <td><?= htmlspecialchars($pedido['usuario_nome'] ?? 'N/A') ?></td>
                    <td><strong>R$ <?= number_format($pedido['total'], 2, ',', '.') ?></strong></td>
                    <td>
                        <!-- Mini formulário para alterar status inline -->
                        <form action="<?= APP_URL ?>/index.php?controller=orders&action=updateStatus" method="POST" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                            <input type="hidden" name="id" value="<?= $pedido['id'] ?>">
                            <select name="status" class="form-control form-control-sm" onchange="this.form.submit()">
                                <?php foreach (['pendente','processando','enviado','entregue','cancelado'] as $s): ?>
                                    <option value="<?= $s ?>" <?= $pedido['status'] === $s ? 'selected' : '' ?>><?= ucfirst($s) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </td>
                    <td><?= date('d/m/Y H:i', strtotime($pedido['created_at'])) ?></td>
                    <td>
                        <a href="<?= APP_URL ?>/index.php?controller=orders&action=show&id=<?= $pedido['id'] ?>"
                           class="btn btn-sm btn-outline">👁 Ver</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if ($totalPages > 1): ?>
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="<?= APP_URL ?>/index.php?controller=orders&action=adminIndex&page=<?= $i ?>"
               class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</div>
