<?php
require_once("Views/shared/layout/header.php");
?>

<link rel="stylesheet" href="/Views/Usuarios/css/perfil.css">

<div class="container mt-5">


    <div class="d-flex align-items-start">
        <div id="infoperfil" class="bg-white shadow rounded round p-3 me-3">
            <?php if (!empty($usuario->fotoPerfil)): ?>
                <div id="fotoPerfil" class="rounded-circle">

                    <img class="rounded-circle" src="data:image/*; base64,<?= base64_encode($usuario->fotoPerfil) ?>" />
                </div>
            <?php endif; ?>

            <div class="mt-3">
                <p class="m-0"><?php echo ($usuario->nome) ?></p>
                <p class="m-0"><?php echo ($usuario->email) ?></p>
                <p class="m-0"><?php echo ($usuario->telefone) ?></p>
                <p class="m-0">Saldo de pontos: <?php echo ($usuario->qtdPontos) ?></p>
                <?php if ($usuario->isAdmin): ?>
                    <a href="itensadmin" role="button" class="btn button-roxo w-100 mt-3'">Loja de pontos - Admin</a>
                <?php endif ?>
            </div>
        </div>

        <div id="galeria" class="text-center bg-white shadow rounded round p-3 flex-grow-1">
            <h2 class="my-3">Galeria</h2>
            <p>Clique num item abaixo para defini-lo como padrão.</p>

            <div class="row g-0 row-cols-lg-3 row-cols-sm-2 row-cols-1">
                <?php if (!empty($galeria)): foreach ($galeria as $item): ?>
                        <div class="col">
                            <a href="/mudarfotoperfil?idItem=<?php echo ($item['idItem']) ?>">
                                <img src="data:image/*; base64,<?= base64_encode($item['midia']) ?>" />
                            </a>
                        </div>
                <?php endforeach;
                endif; ?>
            </div>
        </div>
    </div>
</div>


<?php
require_once "Views/shared/layout/footer.php";
?>