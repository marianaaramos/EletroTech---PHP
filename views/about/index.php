<?php  ?>

<section class="about-hero">
    <div class="container">
        <h1>Sobre a <span class="highlight" style="color:#fff;">EletroTech</span></h1>
        <p class="lead">Há mais de 10 anos conectando brasileiros à melhor tecnologia do mundo.</p>
    </div>
</section>

<div class="container">
    <section class="section about-story">
        <div class="about-text">
            <h2>Nossa História</h2>
            <p>A EletroTech nasceu em 2014 com um sonho simples: democratizar o acesso à tecnologia no Brasil. Começamos com um pequeno estoque de smartphones e hoje somos uma das maiores lojas virtuais de eletrônicos do país.</p>
            <p>Nossa missão é oferecer produtos originais, com garantia, preços justos e o melhor atendimento ao cliente. Acreditamos que a tecnologia deve estar ao alcance de todos.</p>
            <p>Com mais de <strong>500 produtos</strong> no catálogo, <strong>50.000 clientes</strong> satisfeitos e presença em todos os estados do Brasil, continuamos crescendo e inovando.</p>
        </div>
        <div class="about-visual">
            <div class="about-img-placeholder">
                <div style="font-size:5rem;">⚡</div>
                <p>Desde 2014</p>
                <p>São Paulo, Brasil</p>
            </div>
        </div>
    </section>

    <section class="section">
        <h2 class="section-title">Nossos Diferenciais</h2>
        <div class="benefits-grid">
            <?php foreach ($diferenciais as $item): ?>
            <div class="benefit-card">
                <div class="benefit-icon"><?= $item['icone'] ?></div>
                <h3><?= htmlspecialchars($item['titulo']) ?></h3>
                <p><?= htmlspecialchars($item['texto']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="section">
        <h2 class="section-title">Nossa Equipe</h2>
        <div class="team-grid">
            <?php
            $equipe = [
                ['nome' => 'Carlos Silva',    'cargo' => 'CEO & Fundador',     'inicial' => 'C'],
                ['nome' => 'Ana Pereira',     'cargo' => 'Diretora Comercial', 'inicial' => 'A'],
                ['nome' => 'Lucas Santos',    'cargo' => 'Tech Lead',          'inicial' => 'L'],
                ['nome' => 'Mariana Costa',   'cargo' => 'UX Designer',        'inicial' => 'M'],
            ];

            foreach ($equipe as $membro):
            ?>
            <div class="team-card">
                <div class="team-avatar"><?= $membro['inicial'] ?></div>
                <h3><?= htmlspecialchars($membro['nome']) ?></h3>
                <p><?= htmlspecialchars($membro['cargo']) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="section section-gray" style="border-radius:16px;padding:40px;">
        <h2 class="section-title">EletroTech em Números</h2>
        <div class="stats-grid">
            <?php
            $numeros = [
                ['valor' => '10+',    'label' => 'Anos de experiência'],
                ['valor' => '500+',   'label' => 'Produtos no catálogo'],
                ['valor' => '50mil+', 'label' => 'Clientes satisfeitos'],
                ['valor' => '99%',    'label' => 'Avaliações positivas'],
            ];

            foreach ($numeros as $num):
            ?>
            <div class="stat-item">
                <strong><?= $num['valor'] ?></strong>
                <span><?= $num['label'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
</div>
