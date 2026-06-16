<?php?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Entrar na EletroTech</h1>
            <p>Acesse sua conta para continuar comprando</p>
        </div>

        <form action="<?= APP_URL ?>/index.php?controller=auth&action=loginPost" method="POST" class="auth-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

            <div class="form-group">
                <label for="email">E-mail</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="form-control"
                    placeholder="seu@email.com"
                    value="<?= htmlspecialchars($_SESSION['form_data']['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    required
                    autocomplete="email"
                >
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <div class="input-password">
                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        class="form-control"
                        placeholder="••••••••"
                        required
                        autocomplete="current-password"
                    >
                    <button type="button" class="toggle-password" onclick="toggleSenha('senha')">👁</button>
                </div>
            </div>

            <div class="form-row">
                <label class="checkbox-label">
                    <input type="checkbox" name="lembrar" value="1">
                    <span>Lembrar de mim</span>
                </label>
                <a href="<?= APP_URL ?>/index.php?controller=auth&action=recover" class="link-small">Esqueci a senha</a>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">Entrar</button>
        </form>

        <div class="auth-footer">
            <p>Não tem conta? <a href="<?= APP_URL ?>/index.php?controller=auth&action=register">Cadastre-se grátis</a></p>
        </div>

        <div class="demo-creds">
            <p><strong>Credenciais de teste:</strong></p>
            <p>Admin: admin@eletrotech.com / admin123</p>
            <p>Cliente: cliente@teste.com / cliente123</p>
        </div>
    </div>
</div>

<?php unset($_SESSION['form_data']); ?>

<script>
function toggleSenha(id) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
