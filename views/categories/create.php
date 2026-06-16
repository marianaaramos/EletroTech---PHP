<?php  ?>

<div class="container admin-form-page">
    <div class="page-header">
        <h1><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M12 4.5v15m7.5-7.5h-15"/></svg> Novo Produto</h1>
        <a href="<?= APP_URL ?>/index.php?controller=admin&action=products" class="btn btn-outline btn-sm">← Voltar</a>
    </div>

    <div class="card">
        <form action="<?= APP_URL ?>/index.php?controller=products&action=store" method="POST"
              enctype="multipart/form-data" class="admin-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

            <?php $fd = $_SESSION['form_data'] ?? []; ?>

            <div class="form-section">
                <h3>Informações Básicas</h3>
                <div class="form-row-2">
                    <div class="form-group">
                        <label for="nome">Nome do Produto *</label>
                        <input type="text" id="nome" name="nome" class="form-control"
                            value="<?= htmlspecialchars($fd['nome'] ?? '') ?>" required minlength="3">
                    </div>
                    <div class="form-group">
                        <label for="categoria_id">Categoria *</label>
                        <select id="categoria_id" name="categoria_id" class="form-control" required>
                            <option value="">Selecione...</option>
                            <?php foreach ($categorias as $cat): ?>
                                <option value="<?= $cat['id'] ?>"
                                    <?= ($fd['categoria_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
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
                            value="<?= htmlspecialchars($fd['marca'] ?? '') ?>">
                    </div>
                    <div class="form-group">
                        <label for="modelo">Modelo</label>
                        <input type="text" id="modelo" name="modelo" class="form-control"
                            value="<?= htmlspecialchars($fd['modelo'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea id="descricao" name="descricao" class="form-control" rows="5"
                        placeholder="Descreva o produto detalhadamente..."><?= htmlspecialchars($fd['descricao'] ?? '') ?></textarea>
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
                                value="<?= htmlspecialchars($fd['preco'] ?? '') ?>" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="preco_promocional">Preço Promocional</label>
                        <div class="input-prefix">
                            <span>R$</span>
                            <input type="number" id="preco_promocional" name="preco_promocional" class="form-control"
                                step="0.01" min="0"
                                value="<?= htmlspecialchars($fd['preco_promocional'] ?? '') ?>"
                                placeholder="0.00">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="estoque">Estoque *</label>
                        <input type="number" id="estoque" name="estoque" class="form-control"
                            min="0" value="<?= htmlspecialchars($fd['estoque'] ?? '0') ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3>Imagem e Configurações</h3>
                <div class="form-row-2">
                    <div class="form-group">
                        <label for="imagem">Imagem do Produto</label>
                        <input type="file" id="imagem" name="imagem" class="form-control" accept="image/*"
                            onchange="previewImage(this)">
                        <small class="form-hint">JPG, PNG, GIF, WEBP — Máx. 5MB</small>
                        <img id="img-preview" src="" alt="Preview" style="display:none;max-width:150px;margin-top:8px;border-radius:8px;">
                    </div>
                    <div class="form-group">
                        <label>Opções</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" name="ativo" value="1"
                                    <?= !empty($fd['ativo']) ? 'checked' : 'checked' ?>>
                                <span>Produto ativo (visível na loja)</span>
                            </label>
                            <label class="checkbox-label">
                                <input type="checkbox" name="destaque" value="1"
                                    <?= !empty($fd['destaque']) ? 'checked' : '' ?>>
                                <span>Produto em destaque</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary btn-lg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/></svg> Salvar Produto</button>
                <a href="<?= APP_URL ?>/index.php?controller=admin&action=products" class="btn btn-outline btn-lg">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php unset($_SESSION['form_data']); ?>

<script>
function previewImage(input) {
    const preview = document.getElementById('img-preview');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { preview.src = e.target.result; preview.style.display = 'block'; };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
