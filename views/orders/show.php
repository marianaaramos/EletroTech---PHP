<?php  ?>

<div class="container product-detail">
   
    <nav class="breadcrumb">
        <a href="<?= APP_URL ?>/index.php">Home</a> /
        <a href="<?= APP_URL ?>/index.php?controller=products&action=index">Produtos</a> /
        <?php if (!empty($produto['categoria_nome'])): ?>
            <a href="<?= APP_URL ?>/index.php?controller=products&action=index&categoria=<?= $produto['categoria_id'] ?>"><?= htmlspecialchars($produto['categoria_nome']) ?></a> /
        <?php endif; ?>
        <span><?= htmlspecialchars($produto['nome']) ?></span>
    </nav>

    <div class="product-detail-layout">
        <div class="product-detail-image">
            <?php if (!empty($produto['imagem'])): ?>
                <img src="<?= APP_URL ?>/assets/uploads/<?= htmlspecialchars($produto['imagem']) ?>"
                     alt="<?= htmlspecialchars($produto['nome']) ?>"
                     class="product-detail-img">
            <?php else: ?>
                <div class="product-detail-img-placeholder">
                    <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg></span>
                    <p>Sem imagem</p>
                </div>
            <?php endif; ?>

            <?php if ($produto['destaque']): ?>
                <span class="badge badge-destaque badge-lg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5z"/></svg> Produto em Destaque</span>
            <?php endif; ?>
        </div>

        <div class="product-detail-info">
            <?php if (!empty($produto['categoria_nome'])): ?>
                <span class="product-category-badge"><?= htmlspecialchars($produto['categoria_nome']) ?></span>
            <?php endif; ?>

            <h1 class="product-detail-name"><?= htmlspecialchars($produto['nome']) ?></h1>

            <?php if (!empty($produto['marca']) || !empty($produto['modelo'])): ?>
                <p class="product-detail-brand">
                    <?php if (!empty($produto['marca'])): ?>
                        <strong>Marca:</strong> <?= htmlspecialchars($produto['marca']) ?>
                    <?php endif; ?>
                    <?php if (!empty($produto['modelo'])): ?>
                        | <strong>Modelo:</strong> <?= htmlspecialchars($produto['modelo']) ?>
                    <?php endif; ?>
                </p>
            <?php endif; ?>

            <div class="product-detail-price">
                <?php if (!empty($produto['preco_promocional']) && $produto['preco_promocional'] > 0): ?>
                    <span class="price-original-lg">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                    <span class="price-promo-lg">R$ <?= number_format($produto['preco_promocional'], 2, ',', '.') ?></span>
                    <?php
                    $desconto = round((1 - $produto['preco_promocional'] / $produto['preco']) * 100);
                    ?>
                    <span class="discount-badge">-<?= $desconto ?>% OFF</span>
                <?php else: ?>
                    <span class="price-current-lg">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                <?php endif; ?>
                <p class="price-installments">ou 10x de R$ <?= number_format(($produto['preco_promocional'] ?: $produto['preco']) / 10, 2, ',', '.') ?> sem juros</p>
            </div>

            <div class="stock-status">
                <?php if ($produto['estoque'] <= 0): ?>
                    <span class="stock-badge stock-out"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg> Produto indisponível</span>
                <?php elseif ($produto['estoque'] <= 5): ?>
                    <span class="stock-badge stock-low"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg> Apenas <?= $produto['estoque'] ?> em estoque!</span>
                <?php else: ?>
                    <span class="stock-badge stock-ok"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg> Em estoque (<?= $produto['estoque'] ?> unidades)</span>
                <?php endif; ?>
            </div>

            <?php if ($produto['estoque'] > 0): ?>
            <?php
            if (empty($_SESSION['csrf_token'])) {
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
            ?>
            <form action="<?= APP_URL ?>/index.php?controller=cart&action=add" method="POST" class="add-to-cart-form">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
                <input type="hidden" name="produto_id" value="<?= $produto['id'] ?>">

                <div class="quantity-selector">
                    <label>Quantidade:</label>
                    <div class="qty-control">
                        <button type="button" onclick="changeQty(-1)">−</button>
                        <input type="number" id="quantidade" name="quantidade" value="1"
                               min="1" max="<?= $produto['estoque'] ?>" class="qty-input">
                        <button type="button" onclick="changeQty(1)">+</button>
                    </div>
                </div>

                <div class="product-actions">
                    <button type="submit" class="btn btn-primary btn-lg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0z"/></svg> Adicionar ao Carrinho</button>
                    <a href="<?= APP_URL ?>/index.php?controller=cart&action=index" class="btn btn-outline btn-lg">Ver Carrinho</a>
                </div>
            </form>
            <?php else: ?>
                <button class="btn btn-disabled btn-lg" disabled>Produto Indisponível</button>
            <?php endif; ?>

            <div class="product-benefits">
                <div class="benefit-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg> <span>Frete grátis acima de R$ 299</span></div>
                <div class="benefit-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg> <span>7 dias para devolução</span></div>
                <div class="benefit-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25z"/></svg> <span>Compra 100% segura</span></div>
                <div class="benefit-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5z"/></svg> <span>Produto original com garantia</span></div>
            </div>
        </div>
    </div>

    <?php if (!empty($produto['descricao'])): ?>
    <div class="product-description">
        <h2>Descrição do Produto</h2>
        <div class="description-content">
            <?= nl2br(htmlspecialchars($produto['descricao'], ENT_QUOTES, 'UTF-8')) ?>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
function changeQty(delta) {
    const input = document.getElementById('quantidade');
    const max   = parseInt(input.getAttribute('max'));
    let val     = parseInt(input.value) + delta;
    val = Math.max(1, Math.min(val, max));
    input.value = val;
}
</script>
