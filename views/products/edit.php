<?php  ?>

<div class="container admin-form-page">
    <div class="page-header">
        <h1><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931zm0 0L19.5 7.125"/></svg> Editar Produto</h1>
        <a href="<?= APP_URL ?>/index.php?controller=admin&action=products" class="btn btn-outline btn-sm">← Voltar</a>
    </div>

    <div class="card">
        <form action="<?= APP_URL ?>/index.php?controller=products&action=update" method="POST"
              enctype="multipart/form-data" class="admin-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
            <input type="hidden" name="id" value="<?= $produto['id'] ?>">

            <div class="form-section">
                <h3>Informações Básicas</h3>
                <div class="form-row-2">
                    <div class="form-group">
                        <label for="nome">Nome do Produto *</label>
                        <input type="text" id="nome" name="nome" class="form-control"
                            value="<?= htmlspecialchars($produto['nome']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="categoria_id">Categoria *</label>
                        <select id="categoria_id" name="categoria_id" class="form-control" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id'] ?>"
                                    <?= $produto['categoria_id'] == $cat['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat['nome']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row-2">
                    <div class="form-group">
                        <label for="marca">Marca</label>
                        <input type="text" id="marca" name="marca" class="form-control"
                            value="<?= htmlspecialchars($produto['marca'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="modelo">Modelo</label>
                        <input type="text" id="modelo" name="modelo" class="form-control"
                            value="<?= htmlspecialchars($produto['modelo'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="5"><?= htmlspecialchars($produto['descricao'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="form-section">
                <h3>Preço e Estoque</h3>
                <div class="form-row-3">
                    <div class="form-group">
                        <label for="preco">Preço *</label>
                        <div class="input-prefix">
                            <span>R$</span>
                            <input type="number" id="preco" name="preco" class="form-control"
                                step="0.01" min="0.01"
                                value="<?= number_format($produto['preco'], 2, '.', '') ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="preco_promocional">Preço Promocional</label>
                        <div class="input-prefix">
                            <span>R$</span>
                            <input type="number" id="preco_promocional" name="preco_promocional" class="form-control"
                                step="0.01" min="0"
                                value="<?= $produto['preco_promocional'] ? number_format($produto['preco_promocional'], 2, '.', '') : '' ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="estoque">Estoque *</label>
                        <input type="number" id="estoque" name="estoque" class="form-control"
                            min="0" value="<?= $produto['estoque'] ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Imagem e Configurações</h3>
                <div class="form-row-2">
                    <div class="form-group">
                        <label>Imagem Atual</label>
                        <?php if (!empty($produto['imagem'])): ?>
                            <img src="<?= APP_URL ?>/assets/uploads/<?= htmlspecialchars($produto['imagem']) ?>"
                                 alt="Imagem atual" style="max-width:120px;border-radius:8px;display:block;margin-bottom:8px;">
                        <?php else: ?>
                            <p class="text-muted">Sem imagem</p>
                        <?php endif; ?>
                        <label for="imagem">Nova Imagem (opcional)</label>
                        <input type="file" id="imagem" name="imagem" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <label>Opções</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="ativo" value="1" <?= $produto['ativo'] ? 'checked' : '' ?>>
                                <span>Produto ativo</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="destaque" value="1" <?= $produto['destaque'] ? 'checked' : '' ?>>
                                <span>Em destaque</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg> Atualizar Produto</button>
                <a href="<?= APP_URL ?>/index.php?controller=admin&action=products" class="btn btn-outline btn-lg">Cancelar</a>
            </div>
        </form>
    </div>
</div>
