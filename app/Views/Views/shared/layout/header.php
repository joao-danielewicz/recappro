<?php require_once "head.php" ?>

<header class="py-3 ">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="/">
            <div id="titulo">
                <p class="m-0">Recap</p>
                <p class="m-0">Pro</p>
            </div>
        </a>
        <div id="opcoes">
            <?php if (empty($_COOKIE)): ?>
                <a class="pe-3 border-end" href="/login">Entrar</a>
                <a class="ps-3" href="/cadastro">Crie sua conta</a>
            <?php else: ?>
                <a class="px-3 border-end" href="/loja">Loja de pontos</a>
                <a class="px-3 border-end" href="/meuscursos">Meus cursos</a>
                <a class="px-3 border-end" href="/perfil">Perfil</a>
                <a class="ps-3" href="/sair">Sair</a>
            <?php endif; ?>
        </div>
    </div>
</header>

<body>