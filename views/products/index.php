<?php ?>

<div class="container products-page">
    <div class="page-header">
        <div>
            <h1>Nossos Produtos</h1>
            <p class="text-muted">
                <?php if (!empty($busca)): ?>
                    <?= $total ?> resultado(s) para "<strong><?= htmlspecialchars($busca) ?></strong>"
                <?php elseif ($catId > 0): ?>
                    <?= $total ?> produto(s) encontrado(s) nesta categoria
                <?php else: ?>
                    <?= $total ?> produto(s) disponíveis
                <?php endif; ?>
            </p>
        </div>
        <div class="page-actions">
            <?php if (!empty($busca) || $catId > 0): ?>
                <a href="<?= APP_URL ?>/index.php?controller=products&action=index" class="btn btn-outline btn-sm">Limpar filtro</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="products-layout">
        <aside class="products-sidebar">
            <div class="sidebar-card">
                <h3>Buscar</h3>
                <form action="<?= APP_URL ?>/index.php" method="GET">
                    <input type="hidden" name="controller" value="products">
                    <input type="hidden" name="action" value="index">
                    <input type="search" name="busca" class="form-control"
                        placeholder="Buscar produtos..."
                        value="<?= htmlspecialchars($busca, ENT_QUOTES, 'UTF-8') ?>">
                    <button type="submit" class="btn btn-primary btn-sm btn-block" style="margin-top:8px;">Buscar</button>
                </form>
            </div>

            <div class="sidebar-card">
                <h3>Categorias</h3>
                <ul class="filter-list">
                    <li>
                        <a href="<?= APP_URL ?>/index.php?controller=products&action=index"
                           class="filter-link <?= $catId === 0 ? 'active' : '' ?>">
                            Todas as Categorias
                        </a>
                    </li>
                    <?php foreach ($categorias as $cat): ?>
                    <li>
                        <a href="<?= APP_URL ?>/index.php?controller=products&action=index&categoria=<?= $cat['id'] ?>"
                           class="filter-link <?= $catId === (int) $cat['id'] ? 'active' : '' ?>">
                            <?= htmlspecialchars($cat['nome']) ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>

        <div class="products-main">
            <?php if (!empty($produtos)): ?>
                <div class="products-grid">
                    <?php foreach ($produtos as $produto): ?>
                    <div class="product-card">
                        <a href="<?= APP_URL ?>/index.php?controller=products&action=show&id=<?= $produto['id'] ?>">
                            <?php if (!empty($produto['imagem'])): ?>
                                <img src="<?= APP_URL ?>/assets/uploads/<?= htmlspecialchars($produto['imagem']) ?>"
                                     alt="<?= htmlspecialchars($produto['nome']) ?>" class="product-img">
                            <?php else: ?>
                                <div class="product-img-placeholder"></div>
                            <?php endif; ?>

                            <?php if ($produto['destaque']): ?>
                                <span class="badge badge-destaque">Destaque</span>
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

                            <?php if ($produto['estoque'] <= 0): ?>
                                <span class="stock-badge stock-out">Sem estoque</span>
                            <?php elseif ($produto['estoque'] <= 5): ?>
                                <span class="stock-badge stock-low">Últimas unidades!</span>
                            <?php endif; ?>

                            <a href="<?= APP_URL ?>/index.php?controller=products&action=show&id=<?= $produto['id'] ?>"
                               class="btn btn-primary btn-sm btn-block <?= $produto['estoque'] <= 0 ? 'btn-disabled' : '' ?>">
                                <?= $produto['estoque'] > 0 ? 'Ver Produto' : 'Indisponível' ?>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <?php if ($totalPages > 1): ?>
                <div class="pagination">
                    <?php
                    $queryParams = [];
                    if (!empty($busca))  $queryParams[] = 'busca=' . urlencode($busca);
                    if ($catId > 0)       $queryParams[] = 'categoria=' . $catId;
                    $queryBase = 'controller=products&action=index' . (!empty($queryParams) ? '&' . implode('&', $queryParams) : '');
                    ?>

                    <?php if ($page > 1): ?>
                        <a href="<?= APP_URL ?>/index.php?<?= $queryBase ?>&page=<?= $page - 1 ?>" class="page-btn">← Anterior</a>
                    <?php endif; ?>

                    <?php for ($i = max(1, $page - 2); $i <= min($totalPages, $page + 2); $i++): ?>
                        <a href="<?= APP_URL ?>/index.php?<?= $queryBase ?>&page=<?= $i ?>"
                           class="page-btn <?= $i === $page ? 'active' : '' ?>"><?= $i ?></a>
                    <?php endfor; ?>

                    <?php if ($page < $totalPages): ?>
                        <a href="<?= APP_URL ?>/index.php?<?= $queryBase ?>&page=<?= $page + 1 ?>" class="page-btn">Próxima →</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            <?php else: ?>
                <div class="empty-state">
                    <h3>Nenhum produto encontrado</h3>
                    <p>Tente uma busca diferente ou navegue por todas as categorias.</p>
                    <a href="<?= APP_URL ?>/index.php?controller=products&action=index" class="btn btn-primary">Ver Todos os Produtos</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
