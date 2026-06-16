<?php ?>

<div class="container orders-page">
    <h1>Meus Pedidos</h1>

    <?php if (!empty($pedidos)): ?>
    <div class="orders-list">
        <?php foreach ($pedidos as $pedido): ?>
        <div class="order-card">
            <div class="order-header">
                <div>
                    <span class="order-id">Pedido #<?= $pedido['id'] ?></span>
                    <span class="order-date"><?= date('d/m/Y H:i', strtotime($pedido['created_at'])) ?></span>
                </div>
                <div>
                    <?php
                    switch ($pedido['status']) {
                        case 'pendente':    $badge = 'badge-warning'; break;
                        case 'processando': $badge = 'badge-info';    break;
                        case 'enviado':     $badge = 'badge-primary'; break;
                        case 'entregue':    $badge = 'badge-success'; break;
                        case 'cancelado':   $badge = 'badge-danger';  break;
                        default:            $badge = 'badge';
                    }
                    ?>
                    <span class="badge <?= $badge ?>">
                        <?= ucfirst($pedido['status']) ?>
                    </span>
                </div>
            </div>

            <div class="order-body">
                <div class="order-total">
                    <span>Total:</span>
                    <strong>R$ <?= number_format($pedido['total'], 2, ',', '.') ?></strong>
                </div>
                <a href="<?= APP_URL ?>/index.php?controller=orders&action=show&id=<?= $pedido['id'] ?>"
                   class="btn btn-outline btn-sm">
                    Ver Detalhes
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php else: ?>
    <div class="empty-state">
        <h3>Você ainda não fez nenhum pedido</h3>
        <p>Explore nossa loja e faça sua primeira compra!</p>
        <a href="<?= APP_URL ?>/index.php?controller=products&action=index" class="btn btn-primary btn-lg">
            Ver Produtos
        </a>
    </div>
    <?php endif; ?>
</div>
