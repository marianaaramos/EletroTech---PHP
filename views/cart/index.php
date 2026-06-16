<?php ?>

<div class="container cart-page">
    <h1>Carrinho de Compras</h1>

    <?php if (!empty($itens)): ?>
    <div class="cart-layout">
        <div class="cart-items">
            <?php foreach ($itens as $item): ?>
            <div class="cart-item">
                <div class="cart-item-img">
                    <?php if (!empty($item['imagem'])): ?>
                        <img src="<?= APP_URL ?>/assets/uploads/<?= htmlspecialchars($item['imagem']) ?>"
                             alt="<?= htmlspecialchars($item['nome']) ?>">
                    <?php else: ?>
                        <div class="img-placeholder"></div>
                    <?php endif; ?>
                </div>

                <div class="cart-item-info">
                    <h3><?= htmlspecialchars($item['nome']) ?></h3>
                    <p class="cart-item-price">R$ <?= number_format($item['preco'], 2, ',', '.') ?> cada</p>
                </div>

                <form action="<?= APP_URL ?>/index.php?controller=cart&action=update" method="POST" class="cart-qty-form">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
                    <input type="hidden" name="produto_id" value="<?= $item['produto_id'] ?>">
                    <div class="qty-control">
                        <button type="button" onclick="this.nextElementSibling.stepDown(); this.form.submit()">−</button>
                        <input type="number" name="quantidade" value="<?= $item['quantidade'] ?>"
                               min="1" max="<?= $item['estoque'] ?>" class="qty-input"
                               onchange="this.form.submit()">
                        <button type="button" onclick="this.previousElementSibling.stepUp(); this.form.submit()">+</button>
                    </div>
                </form>

                <div class="cart-item-subtotal">
                    <strong>R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></strong>
                </div>

                <a href="<?= APP_URL ?>/index.php?controller=cart&action=remove&id=<?= $item['produto_id'] ?>&csrf_token=<?= urlencode($csrfToken) ?>"
                   class="cart-remove" title="Remover item"
                   onclick="return confirm('Remover este item do carrinho?')">
                    Remover
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-summary">
            <div class="summary-card">
                <h3>Resumo do Pedido</h3>

                <div class="summary-row">
                    <span>Subtotal</span>
                    <strong>R$ <?= number_format($total, 2, ',', '.') ?></strong>
                </div>
                <div class="summary-row">
                    <span>Frete</span>
                    <strong><?= $total >= 299 ? '<span class="text-success">Grátis</span>' : 'R$ 19,90' ?></strong>
                </div>

                <?php $totalComFrete = $total < 299 ? $total + 19.90 : $total; ?>
                <div class="summary-total">
                    <span>Total</span>
                    <strong>R$ <?= number_format($totalComFrete, 2, ',', '.') ?></strong>
                </div>

                <div class="summary-installments">
                    ou 10x de R$ <?= number_format($totalComFrete / 10, 2, ',', '.') ?> sem juros
                </div>

                <?php if (!empty($_SESSION['usuario_id'])): ?>
                    <a href="<?= APP_URL ?>/index.php?controller=cart&action=checkout" class="btn btn-primary btn-block btn-lg">
                        Finalizar Pedido
                    </a>
                <?php else: ?>
                    <a href="<?= APP_URL ?>/index.php?controller=auth&action=login" class="btn btn-primary btn-block btn-lg">
                        Login para Finalizar
                    </a>
                <?php endif; ?>

                <a href="<?= APP_URL ?>/index.php?controller=products&action=index" class="btn btn-outline btn-block" style="margin-top:8px;">
                    ← Continuar Comprando
                </a>

                <a href="<?= APP_URL ?>/index.php?controller=cart&action=clear&csrf_token=<?= urlencode($csrfToken) ?>"
                   class="btn btn-danger btn-sm btn-block" style="margin-top:8px;"
                   onclick="return confirm('Limpar todo o carrinho?')">
                    Limpar Carrinho
                </a>
            </div>

            <div class="security-badges">
                <div>Compra Segura</div>
                <div>7 dias para devolver</div>
                <div>Rastreamento</div>
            </div>
        </div>
    </div>

    <?php else: ?>
    <div class="empty-state">
        <h3>Seu carrinho está vazio</h3>
        <p>Adicione produtos ao carrinho para continuar comprando.</p>
        <a href="<?= APP_URL ?>/index.php?controller=products&action=index" class="btn btn-primary btn-lg">
            Ver Produtos
        </a>
    </div>
    <?php endif; ?>
</div>
