<?php ?>

<div class="container" style="text-align:center;padding:80px 20px;">
    <div style="font-size:8rem;margin-bottom:20px;"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg></div>
    <h1 style="font-size:6rem;color:var(--primary);margin:0;">404</h1>
    <h2>Página não encontrada</h2>
    <p class="text-muted">Ops! A página que você procura não existe ou foi movida.</p>
    <div style="margin-top:30px;display:flex;gap:12px;justify-content:center;">
        <a href="<?= APP_URL ?>/index.php" class="btn btn-primary btn-lg"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg> Voltar ao Início</a>
        <a href="<?= APP_URL ?>/index.php?controller=products&action=index" class="btn btn-outline btn-lg">Ver Produtos</a>
    </div>
</div>
