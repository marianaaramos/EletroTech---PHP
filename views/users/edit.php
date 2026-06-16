<?php /* Formulário de edição de usuário (Admin) */ ?>

<div class="container admin-form-page">
    <div class="page-header">
        <h1>✏️ Editar Usuário</h1>
        <a href="<?= APP_URL ?>/index.php?controller=users&action=index" class="btn btn-outline btn-sm">← Voltar</a>
    </div>

    <div class="card" style="max-width:700px;">
        <form action="<?= APP_URL ?>/index.php?controller=users&action=update" method="POST" class="admin-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">
            <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

            <div class="form-row-2">
                <div class="form-group">
                    <label for="nome">Nome Completo *</label>
                    <input type="text" id="nome" name="nome" class="form-control"
                        value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail *</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="<?= htmlspecialchars($usuario['email']) ?>" required>
                </div>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" class="form-control"
                        value="<?= htmlspecialchars($usuario['telefone'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control"
                        value="<?= htmlspecialchars($usuario['data_nascimento'] ?? '') ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="role">Perfil</label>
                <select id="role" name="role" class="form-control">
                    <option value="cliente" <?= $usuario['role'] === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                    <option value="admin"   <?= $usuario['role'] === 'admin'   ? 'selected' : '' ?>>Administrador</option>
                </select>
            </div>

            <div class="form-section">
                <h3>Alterar Senha <small>(deixe em branco para manter a atual)</small></h3>
                <div class="form-row-2">
                    <div class="form-group">
                        <label for="nova_senha">Nova Senha</label>
                        <input type="password" id="nova_senha" name="nova_senha" class="form-control"
                            placeholder="Mínimo 6 caracteres" minlength="6">
                    </div>
                    <div class="form-group">
                        <label for="confirma_senha">Confirmar Senha</label>
                        <input type="password" id="confirma_senha" name="confirma_senha" class="form-control"
                            placeholder="Repita a senha" minlength="6">
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Atualizar</button>
                <a href="<?= APP_URL ?>/index.php?controller=users&action=index" class="btn btn-outline">Cancelar</a>
            </div>
        </form>
    </div>
</div>
