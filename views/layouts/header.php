<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($titulo ?? APP_NAME, ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body data-theme="light">

<div class="topbar">
    <div class="container">
        <span><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M20.25 7.5l-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/></svg> Frete grátis acima de R$ 299 | <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25z"/></svg> (11) 9999-9999</span>
        <div class="topbar-right">
            <?php if (!empty($_SESSION['usuario_id'])): ?>
                <span>Olá, <strong><?= htmlspecialchars($_SESSION['usuario_nome'], ENT_QUOTES, 'UTF-8') ?></strong></span>
                <?php if (!empty($_SESSION['usuario_role']) && $_SESSION['usuario_role'] === 'admin'): ?>
                    <a href="<?= APP_URL ?>/index.php?controller=admin&action=dashboard"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28z"/><path d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg> Admin</a>
                <?php endif; ?>
                <a href="<?= APP_URL ?>/index.php?controller=users&action=profile"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0zM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632z"/></svg> Perfil</a>
                <a href="<?= APP_URL ?>/index.php?controller=auth&action=logout">Sair</a>
            <?php else: ?>
                <a href="<?= APP_URL ?>/index.php?controller=auth&action=login">Login</a>
                <a href="<?= APP_URL ?>/index.php?controller=auth&action=register">Cadastrar</a>
            <?php endif; ?>
            <button class="theme-toggle" onclick="toggleTheme()" title="Alternar tema"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998z"/></svg></button>
        </div>
    </div>
</div>

<header class="site-header">
    <div class="container">
        <a href="<?= APP_URL ?>/index.php" class="logo">
            <span class="logo-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg></span>
            <span class="logo-text">Eletro<strong>Tech</strong></span>
        </a>

        <form action="<?= APP_URL ?>/index.php" method="GET" class="search-form">
            <input type="hidden" name="controller" value="products">
            <input type="hidden" name="action" value="index">
            <input
                type="search"
                name="busca"
                placeholder="Buscar produtos..."
                value="<?= htmlspecialchars($_GET['busca'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                class="search-input"
            >
            <button type="submit" class="btn-search"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607z"/></svg></button>
        </form>

        <a href="<?= APP_URL ?>/index.php?controller=cart&action=index" class="cart-btn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 0 0-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 0 0-16.536-1.84M7.5 14.25 5.106 5.272M6 20.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0zm12.75 0a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0z"/></svg>
            <?php
            $carrinhoQtd = 0;
            if (!empty($_SESSION['carrinho'])) {
                // Demonstração de foreach
                foreach ($_SESSION['carrinho'] as $item) {
                    $carrinhoQtd += $item['quantidade'];
                }
            }
            ?>
            <?php if ($carrinhoQtd > 0): ?>
                <span class="cart-badge"><?= $carrinhoQtd ?></span>
            <?php endif; ?>
        </a>
    </div>
</header>

<nav class="main-nav">
    <div class="container">
        <ul class="nav-list">
            <li><a href="<?= APP_URL ?>/index.php?controller=home&action=index" class="nav-link <?= (($_GET['controller'] ?? 'home') === 'home' && ($_GET['action'] ?? 'index') === 'index') ? 'active' : '' ?>">Home</a></li>
            <li><a href="<?= APP_URL ?>/index.php?controller=products&action=index" class="nav-link <?= ($_GET['controller'] ?? '') === 'products' ? 'active' : '' ?>">Produtos</a></li>
            <li class="dropdown">
                <a href="#" class="nav-link">Categorias ▾</a>
                <ul class="dropdown-menu">
                    <?php
                    $catModel = new Category();
                    $navCats  = $catModel->findActive();
                    foreach ($navCats as $cat): ?>
                        <li>
                            <a href="<?= APP_URL ?>/index.php?controller=products&action=index&categoria=<?= $cat['id'] ?>">
                                <?= htmlspecialchars($cat['nome'], ENT_QUOTES, 'UTF-8') ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <?php if (empty($navCats)): ?>
                        <li><span style="padding:8px 16px;display:block;color:#999;">Nenhuma categoria</span></li>
                    <?php endif; ?>
                </ul>
            </li>
            <li><a href="<?= APP_URL ?>/index.php?controller=home&action=about" class="nav-link <?= ($_GET['action'] ?? '') === 'about' ? 'active' : '' ?>">Sobre</a></li>
            <li><a href="<?= APP_URL ?>/index.php?controller=home&action=contact" class="nav-link <?= ($_GET['action'] ?? '') === 'contact' ? 'active' : '' ?>">Contato</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="alert alert-success">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg> <?= htmlspecialchars($_SESSION['flash_success'], ENT_QUOTES, 'UTF-8') ?>
            <button onclick="this.parentElement.remove()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M6 18 18 6M6 6l12 12"/></svg></button>
        </div>
        <?php unset($_SESSION['flash_success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="alert alert-error">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg> <?= htmlspecialchars($_SESSION['flash_error'], ENT_QUOTES, 'UTF-8') ?>
            <button onclick="this.parentElement.remove()"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="1em" height="1em" aria-hidden="true" style="display:inline-block;vertical-align:-0.125em"><path d="M6 18 18 6M6 6l12 12"/></svg></button>
        </div>
        <?php unset($_SESSION['flash_error']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['flash_errors'])): ?>
        <div class="alert alert-error">
            <ul>
                <?php foreach ($_SESSION['flash_errors'] as $erro): ?>
                    <li><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php unset($_SESSION['flash_errors']); ?>
    <?php endif; ?>
</div>

<main class="main-content">
