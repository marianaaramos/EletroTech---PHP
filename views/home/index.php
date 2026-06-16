<?php ?>

<section class="hero">
    <div class="hero-content">
        <h1>Bem-vindo à <span class="highlight">EletroTech</span></h1>
        <p>Os melhores eletrônicos com preços incríveis e entrega rápida para todo o Brasil.</p>
        <div class="hero-btns">
            <a href="<?= APP_URL ?>/index.php?controller=products&action=index" class="btn btn-primary btn-lg">Ver Produtos</a>
            <a href="<?= APP_URL ?>/index.php?controller=home&action=about" class="btn btn-outline btn-lg">Saiba Mais</a>
        </div>
    </div>
    <div class="hero-visual">
        <div class="hero-img-placeholder">
            <p>Tecnologia de ponta</p>
        </div>
    </div>
</section>

<section class="stats-bar">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item">
                <strong><?= number_format($stats['total_produtos']) ?>+</strong>
                <span>Produtos</span>
            </div>
            <div class="stat-item">
                <strong><?= number_format($stats['total_categorias']) ?></strong>
                <span>Categorias</span>
            </div>
            <div class="stat-item">
                <strong>7 dias</strong>
                <span>Garantia de devolução</span>
            </div>
            <div class="stat-item">
                <strong>24/7</strong>
                <span>Suporte</span>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($categorias)): ?>
<section class="section">
    <div class="container">
        <h2 class="section-title">Comprar por Categoria</h2>
        <div class="categories-grid">
            <?php foreach ($categorias as $categoria): ?>
            <a href="<?= APP_URL ?>/index.php?controller=products&action=index&categoria=<?= $categoria['id'] ?>" class="category-card">
                <h3><?= htmlspecialchars($categoria['nome'], ENT_QUOTES, 'UTF-8') ?></h3>
                <span class="category-count"><?= $categoria['total_produtos'] ?> produto(s)</span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php if (!empty($produtos_destaque)): ?>
<section class="section section-gray">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Produtos em Destaque</h2>
            <a href="<?= APP_URL ?>/index.php?controller=products&action=index" class="btn btn-outline btn-sm">Ver Todos</a>
        </div>
        <div class="products-grid">
            <?php foreach ($produtos_destaque as $produto): ?>
            <div class="product-card">
                <a href="<?= APP_URL ?>/index.php?controller=products&action=show&id=<?= $produto['id'] ?>">
                    <?php if (!empty($produto['imagem'])): ?>
                        <img src="<?= APP_URL ?>/assets/uploads/<?= htmlspecialchars($produto['imagem']) ?>" alt="<?= htmlspecialchars($produto['nome']) ?>" class="product-img">
                    <?php else: ?>
                        <div class="product-img-placeholder"></div>
                    <?php endif; ?>
                </a>

                <div class="product-info">
                    <?php if (!empty($produto['categoria_nome'])): ?>
                        <span class="product-category"><?= htmlspecialchars($produto['categoria_nome']) ?></span>
                    <?php endif; ?>

                    <h3 class="product-name">
                        <a href="<?= APP_URL ?>/index.php?controller=products&action=show&id=<?= $produto['id'] ?>">
                            <?= htmlspecialchars($produto['nome']) ?>
                        </a>
                    </h3>

                    <?php if (!empty($produto['marca'])): ?>
                        <span class="product-brand"><?= htmlspecialchars($produto['marca']) ?></span>
                    <?php endif; ?>

                    <div class="product-price">
                        <?php if (!empty($produto['preco_promocional']) && $produto['preco_promocional'] > 0): ?>
                            <span class="price-original">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                            <span class="price-promo">R$ <?= number_format($produto['preco_promocional'], 2, ',', '.') ?></span>
                        <?php else: ?>
                            <span class="price-current">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                        <?php endif; ?>
                    </div>

                    <?php if ($produto['estoque'] > 0): ?>
                        <a href="<?= APP_URL ?>/index.php?controller=products&action=show&id=<?= $produto['id'] ?>" class="btn btn-primary btn-sm btn-block">
                            Comprar
                        </a>
                    <?php else: ?>
                        <button class="btn btn-disabled btn-sm btn-block" disabled>Sem Estoque</button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="section">
    <div class="container">
        <h2 class="section-title">Por que escolher a EletroTech?</h2>
        <div class="benefits-grid">
            <div class="benefit-card">
                <h3>Entrega Rápida</h3>
                <p>Receba em até 3 dias úteis em todo o Brasil com rastreamento em tempo real.</p>
            </div>
            <div class="benefit-card">
                <h3>Compra Segura</h3>
                <p>Ambiente 100% seguro com criptografia SSL e proteção total dos seus dados.</p>
            </div>
            <div class="benefit-card">
                <h3>Produtos Originais</h3>
                <p>Todos os produtos são originais e com nota fiscal, garantia do fabricante.</p>
            </div>
            <div class="benefit-card">
                <h3>7 Dias de Devolução</h3>
                <p>Não gostou? Devolvemos em até 7 dias sem burocracia, sem perguntas.</p>
            </div>
        </div>
    </div>
</section>
