<?php ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo"></div>
            <h1>Recuperar Senha</h1>
            <?php if (($step ?? 1) === 1): ?>
                <p>Informe seu CPF e data de nascimento para redefinir sua senha.</p>
            <?php else: ?>
                <p>Crie uma nova senha para sua conta.</p>
            <?php endif; ?>
        </div>

        <div class="steps">
            <div class="step <?= ($step ?? 1) >= 1 ? 'active' : '' ?>">
                <span>1</span> Verificar Identidade
            </div>
            <div class="step-divider"></div>
            <div class="step <?= ($step ?? 1) >= 2 ? 'active' : '' ?>">
                <span>2</span> Nova Senha
            </div>
        </div>

        <form action="<?= APP_URL ?>/index.php?controller=auth&action=recoverPost" method="POST" class="auth-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">
            <input type="hidden" name="step" value="<?= $step ?? 1 ?>">

            <?php if (($step ?? 1) === 1): ?>
                <div class="form-group">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" class="form-control"
                        placeholder="000.000.000-00"
                        required maxlength="14"
                        oninput="mascaraCpf(this)">
                </div>

                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">Verificar Identidade</button>

            <?php else: ?>
                <?php if (!empty($usuario)): ?>
                    <div class="alert alert-success" style="margin-bottom:16px;">
                         Identidade confirmada para: <strong><?= htmlspecialchars($usuario['nome']) ?></strong>
                    </div>
                <?php endif; ?>

                <div class="form-group">
                    <label for="nova_senha">Nova Senha</label>
                    <div class="input-password">
                        <input type="password" id="nova_senha" name="nova_senha" class="form-control"
                            placeholder="Mínimo 6 caracteres" required minlength="6">
                        <button type="button" class="toggle-password" onclick="toggleSenha('nova_senha')">👁</button>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirma_senha">Confirmar Nova Senha</label>
                    <div class="input-password">
                        <input type="password" id="confirma_senha" name="confirma_senha" class="form-control"
                            placeholder="Repita a senha" required minlength="6">
                        <button type="button" class="toggle-password" onclick="toggleSenha('confirma_senha')">👁</button>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg">Redefinir Senha</button>
            <?php endif; ?>
        </form>

        <div class="auth-footer">
            <a href="<?= APP_URL ?>/index.php?controller=auth&action=login">← Voltar ao Login</a>
        </div>
    </div>
</div>

<script>
function toggleSenha(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
function mascaraCpf(input) {
    let v = input.value.replace(/\D/g, '');
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    input.value = v;
}
</script>
