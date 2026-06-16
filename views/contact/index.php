<?php ?>

<div class="container contact-page">
    <div class="page-header">
        <h1>Entre em Contato</h1>
        <p class="text-muted">Estamos aqui para ajudar! Envie sua mensagem e responderemos em até 24h.</p>
    </div>

    <div class="contact-layout">
        <div class="contact-form-wrapper">
            <div class="card">
                <h2>Enviar Mensagem</h2>
                <form action="<?= APP_URL ?>/index.php?controller=home&action=contactPost" method="POST" class="auth-form">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken) ?>">

                    <div class="form-row-2">
                        <div class="form-group">
                            <label for="nome">Nome *</label>
                            <input type="text" id="nome" name="nome" class="form-control"
                                placeholder="Seu nome" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail *</label>
                            <input type="email" id="email" name="email" class="form-control"
                                placeholder="seu@email.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="assunto">Assunto</label>
                        <select id="assunto" name="assunto" class="form-control">
                            <option value="">Selecione...</option>
                            <option value="duvida">Dúvida sobre produto</option>
                            <option value="pedido">Status do pedido</option>
                            <option value="devolucao">Devolução</option>
                            <option value="reclamacao">Reclamação</option>
                            <option value="sugestao">Sugestão</option>
                            <option value="outro">Outro</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="mensagem">Mensagem *</label>
                        <textarea id="mensagem" name="mensagem" class="form-control" rows="5"
                            placeholder="Descreva sua dúvida ou mensagem..." required minlength="10"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block btn-lg">Enviar Mensagem</button>
                </form>
            </div>
        </div>

        <div class="contact-info-wrapper">
            <div class="card">
                <h2>Informações de Contato</h2>
                <div class="contact-items">
                    <div class="contact-item">
                        <div class="contact-icon"></div>
                        <div>
                            <strong>Endereço</strong>
                            <p>Rua Tecnologia, 123<br>Centro - São Paulo/SP<br>CEP: 01310-100</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"></div>
                        <div>
                            <strong>Telefone</strong>
                            <p>(11) 9999-9999<br>(11) 3333-4444</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"></div>
                        <div>
                            <strong>E-mail</strong>
                            <p>contato@eletrotech.com.br<br>suporte@eletrotech.com.br</p>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"></div>
                        <div>
                            <strong>Horário de Atendimento</strong>
                            <p>Segunda a Sexta: 8h às 18h<br>Sábado: 8h às 12h</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top:20px;">
                <h3>Redes Sociais</h3>
                <div class="social-links-contact">
                    <a href="#" class="social-btn">Facebook</a>
                    <a href="#" class="social-btn">Instagram</a>
                    <a href="#" class="social-btn">Twitter</a>
                    <a href="#" class="social-btn">YouTube</a>
                </div>
            </div>
        </div>
    </div>
</div>
