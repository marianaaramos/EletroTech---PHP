<?php  ?>

<div class="auth-container auth-container-lg">
    <div class="auth-card">
        <div class="auth-header">
            <h1>Criar Conta</h1>
            <p>Cadastre-se e aproveite os melhores preços em eletrônicos</p>
        </div>

        <form action="<?= APP_URL ?>/index.php?controller=auth&action=registerPost" method="POST" class="auth-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken, ENT_QUOTES, 'UTF-8') ?>">

            <?php $fd = $_SESSION['form_data'] ?? []; ?>

            <div class="form-row-2">
                <div class="form-group">
                    <label for="nome">Nome Completo *</label>
                    <input type="text" id="nome" name="nome" class="form-control"
                        placeholder="Seu nome completo"
                        value="<?= htmlspecialchars($fd['nome'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        required minlength="3">
                </div>

                <div class="form-group">
                    <label for="email">E-mail *</label>
                    <input type="email" id="email" name="email" class="form-control"
                        placeholder="seu@email.com"
                        value="<?= htmlspecialchars($fd['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        required>
                </div>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label for="cpf">CPF *</label>
                    <input type="text" id="cpf" name="cpf" class="form-control"
                        placeholder="000.000.000-00"
                        value="<?= htmlspecialchars($fd['cpf'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        required maxlength="14" oninput="mascaraCpf(this)">
                </div>

                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento *</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control"
                        value="<?= htmlspecialchars($fd['data_nascimento'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        required>
                </div>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input type="tel" id="telefone" name="telefone" class="form-control"
                    placeholder="(11) 99999-9999"
                    value="<?= htmlspecialchars($fd['telefone'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                    oninput="mascaraTelefone(this)">
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label for="senha">Senha *</label>
                    <div class="input-password">
                        <input type="password" id="senha" name="senha" class="form-control"
                            placeholder="Mínimo 6 caracteres" required minlength="6">
                        <button type="button" class="toggle-password" onclick="toggleSenha('senha')">👁</button>
                    </div>
                    <div class="password-strength" id="strength-bar"></div>
                </div>

                <div class="form-group">
                    <label for="confirma_senha">Confirmar Senha *</label>
                    <div class="input-password">
                        <input type="password" id="confirma_senha" name="confirma_senha" class="form-control"
                            placeholder="Repita a senha" required minlength="6">
                        <button type="button" class="toggle-password" onclick="toggleSenha('confirma_senha')">👁</button>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label class="checkbox-label">
                    <input type="checkbox" required>
                    <span>Concordo com os <a href="#">Termos de Uso</a> e <a href="#">Política de Privacidade</a></span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">Criar Conta</button>
        </form>

        <div class="auth-footer">
            <p>Já tem conta? <a href="<?= APP_URL ?>/index.php?controller=auth&action=login">Fazer Login</a></p>
        </div>
    </div>
</div>

<?php unset($_SESSION['form_data']); ?>

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

function mascaraTelefone(input) {
    let v = input.value.replace(/\D/g, '');
    if (v.length <= 10) {
        v = v.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    } else {
        v = v.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3');
    }
    input.value = v;
}

document.getElementById('senha').addEventListener('input', function() {
    const bar = document.getElementById('strength-bar');
    const len = this.value.length;
    if (len === 0) { bar.className = 'password-strength'; bar.style.width = '0'; return; }
    if (len < 6) { bar.className = 'password-strength weak'; }
    else if (len < 10) { bar.className = 'password-strength medium'; }
    else { bar.className = 'password-strength strong'; }
});
</script>
