<?php
require_once "Views/shared/layout/header.php";
?>

<!-- Cria um título para a página -->
<title><?php echo ($titulo) ?></title>
<link rel="stylesheet" href="/Views/cosmetics/src/css/cosmetics.css">

<!-- Verifica se há alguma mensagem a ser passada ao usuário. Caso positivo, escreve-a. -->
<?php if (!empty($msg)): ?>
    <div class="position-absolute border border-danger rounded round m-3 bg-white p-3 shadow">
        <p class="m-0"><?php echo $msg ?></p>
    </div>
<?php endif; ?>


<div class="container mt-5">
    <div class="d-flex flex-column bg-white p-3 rounded round text-center shadow mb-3">
        <h3>Loja de Pontos</h3>
        <hr>
        <p class="m-0">Troque seus pontos por itens e exiba-os em seu perfil!</p>
    </div>


    <?php if ($itens): ?>
        <div class="row row-cols-lg-3 row-cols-sm-2 row-cols-1 g-3">
            <?php foreach ($itens as $item): ?>
                <div class="col">
                    <div class="card shadow" >
                    <img src="data:image/*; base64,<?= base64_encode($item->midia) ?>" class="card-img-top"/>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo($item->descricao)?></h5>
                            <p class="card-text">Preço: <?php echo($item->preco)?> pontos</p>
                            <form action="compraritem" method="POST">
                                <button type="submit" name="idItem" value="<?php echo($item->idItem)?>" href="#" class="btn button-roxo">Adquirir</a>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif ?>

</div>


<?php
require_once "Views/shared/layout/footer.php";
?>