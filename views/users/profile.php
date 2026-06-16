<?php /* Perfil do usuário logado */ ?>

<div class="container profile-page">
    <h1>👤 Meu Perfil</h1>

    <div class="profile-layout">
        <!-- Sidebar do perfil -->
        <aside class="profile-sidebar">
            <div class="profile-avatar">
                <div class="avatar-circle"><?= strtoupper(substr($usuario['nome'], 0, 1)) ?></div>
                <h3><?= htmlspecialchars($usuario['nome']) ?></h3>
                <span class="badge <?= $usuario['role'] === 'admin' ? 'badge-danger' : 'badge-info' ?>">
                    <?= ucfirst($usuario['role']) ?>
                </span>
                <p class="text-muted"><?= htmlspecialchars($usuario['email']) ?></p>
                <p class="text-muted">Membro desde <?= date('d/m/Y', strtotime($usuario['created_at'])) ?></p>
            </div>

            <ul class="profile-menu">
                <li><a href="#dados" class="active">📋 Meus Dados</a></li>
                <li><a href="<?= APP_URL ?>/index.php?controller=orders&action=index">📦 Meus Pedidos</a></li>
                <li><a href="<?= APP_URL ?>/index.php?controller=cart&action=index">🛒 Carrinho</a></li>
                <li><a href="<?= APP_URL ?>/index.php?controller=auth&action=logout">🚪 Sair</a></li>
            </ul>
        </aside>

        <!-- Formulário de edição -->
        <div class="profile-content">
            <div class="card">
                <h2>Editar Dados</h2>
                <form action="<?= APP_URL ?>/index.php?controller=users&action=profileUpdate" method="POST" class="admin-form">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

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

                    <div class="form-section">
                        <h3>Alterar Senha</h3>
                        <div class="form-group">
                            <label for="senha_atual">Senha Atual</label>
                            <input type="password" id="senha_atual" name="senha_atual" class="form-control"
                                placeholder="Digite sua senha atual">
                        </div>
                        <div class="form-row-2">
                            <div class="form-group">
                                <label for="nova_senha">Nova Senha</label>
                                <input type="password" id="nova_senha" name="nova_senha" class="form-control"
                                    placeholder="Mínimo 6 caracteres" minlength="6">
                            </div>
                            <div class="form-group">
                                <label for="confirma_senha">Confirmar</label>
                                <input type="password" id="confirma_senha" name="confirma_senha" class="form-control"
                                    placeholder="Repita a nova senha" minlength="6">
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">💾 Salvar Alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
