<?php /* Formulário de criação de usuário (Admin) */ ?>

<div class="container admin-form-page">
    <div class="page-header">
        <h1>➕ Novo Usuário</h1>
        <a href="<?= APP_URL ?>/index.php?controller=users&action=index" class="btn btn-outline btn-sm">← Voltar</a>
    </div>

    <div class="card" style="max-width:700px;">
        <form action="<?= APP_URL ?>/index.php?controller=users&action=store" method="POST" class="admin-form">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

            <?php $fd = $_SESSION['form_data'] ?? []; ?>

            <div class="form-row-2">
                <div class="form-group">
                    <label for="nome">Nome Completo *</label>
                    <input type="text" id="nome" name="nome" class="form-control"
                        value="<?= htmlspecialchars($fd['nome'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail *</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="<?= htmlspecialchars($fd['email'] ?? '') ?>" required>
                </div>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label for="cpf">CPF *</label>
                    <input type="text" id="cpf" name="cpf" class="form-control"
                        placeholder="000.000.000-00" required oninput="mascaraCpf(this)">
                </div>
                <div class="form-group">
                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" class="form-control">
                </div>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label for="telefone">Telefone</label>
                    <input type="tel" id="telefone" name="telefone" class="form-control"
                        placeholder="(11) 99999-9999" oninput="mascaraTelefone(this)">
                </div>
                <div class="form-group">
                    <label for="role">Perfil</label>
                    <select id="role" name="role" class="form-control">
                        <option value="cliente">Cliente</option>
                        <option value="admin">Administrador</option>
                    </select>
                </div>
            </div>

            <div class="form-row-2">
                <div class="form-group">
                    <label for="senha">Senha *</label>
                    <input type="password" id="senha" name="senha" class="form-control"
                        placeholder="Mínimo 6 caracteres" required minlength="6">
                </div>
                <div class="form-group">
                    <label for="confirma_senha">Confirmar Senha *</label>
                    <input type="password" id="confirma_senha" name="confirma_senha" class="form-control"
                        placeholder="Repita a senha" required minlength="6">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Criar Usuário</button>
                <a href="<?= APP_URL ?>/index.php?controller=users&action=index" class="btn btn-outline">Cancelar</a>
            </div>
        </form>
    </div>
</div>

<?php unset($_SESSION['form_data']); ?>
<script>
function mascaraCpf(input) {
    let v = input.value.replace(/\D/g, '');
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    input.value = v;
}
function mascaraTelefone(input) {
    let v = input.value.replace(/\D/g, '');
    v = v.length > 10
        ? v.replace(/(\d{2})(\d{5})(\d{0,4})/, '($1) $2-$3')
        : v.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
    input.value = v;
}
</script>
