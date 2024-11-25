<?php
require_once "Views/shared/layout/header.php";
?>
<link rel="stylesheet" href="Views/Tarefas/css/tarefas.css">

<title><?php echo ($titulo) ?></title>
<div class="container">

    <div id="cards" class="bg-white rounded round text-center shadow mb-3 mt-5 align-content-center">
        <?php if ($tarefas == null): ?>
            <p>Você terminou seus estudos de hoje! Parabéns!</p>
        <?php else: ?>
            <div id="carouselExample" class="carousel slide" data-bs-theme="dark">
                <div class="carousel-inner container w-75">
                    <div class="carousel-item active">
                        <h4 class="mb-5">Início</h4>
                        <p>Você iniciará os estudos para o dia de hoje.<br>
                            Ao responder uma pergunta, indique com honestidade a dificuldade que teve ao lembrar da resposta.</p>
                        <hr class="mx-5">
                        <p>Ao final, clique no botão "salvar" para registrar sua sessão de estudos. <br>
                            Bom aprendizado!</p>
                    </div>

                    <?php foreach ($tarefas as $tarefa): ?>
                        <div class="carousel-item">
                            <div class="areaPergunta mb-3">
                                <div class="d-flex align-items-baseline justify-content-between">

                                    <h2><?php echo ($tarefa->pergunta) ?></h2>
                                    <p class="m-0 ms-3"><?php echo ($tarefa->assunto) ?></p>
                                </div>
                                <hr class=" mb-3">

                                <div>

                                    <button idTarefa="<?php echo($tarefa->idTarefa)?>" class="alternar btn button-roxo my-3">Mostrar resposta</button>

                                    <div class="<?php echo($tarefa->idTarefa)?>">
                                        <?php if ($tarefa->midiaPergunta): ?>
                                            <img class="mt-3" src="data:image/*; base64,<?= base64_encode($tarefa->midiaPergunta) ?>" />
                                        <?php endif ?>
                                    </div>

                                    <div style="display: none;" class="<?php echo($tarefa->idTarefa)?>">
                                        <h4 class="text-center mb-3"><?php echo ($tarefa->resposta) ?></h4>
                                        <div>
                                            <button value="<?php echo ($tarefa->idTarefa) ?>" type="button" class="facil btn btn-success">Fácil</button>
                                            <button value="<?php echo ($tarefa->idTarefa) ?>" type="button" class="dificil btn btn-success">Difícil</button>
                                        </div>
                                    </div>
                                    <div style="display: none;" class="<?php echo($tarefa->idTarefa)?>">
                                        <?php if ($tarefa->midiaResposta): ?>
                                            <img src="data:image/*; base64,<?= base64_encode($tarefa->midiaResposta) ?>" />
                                        <?php endif ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <div class="carousel-item">
                        <p>Você chegou ao fim da sessão de estudo!<br>
                            Verifique se respondeu todas as tarefas corretamente. <br>
                            Salve seu progresso usando o botão abaixo.</p>
                        <form method="POST" action="estudartarefa">
                            <?php foreach ($tarefas as $tarefa): ?>
                                <div style="display:none;">
                                    <input name="tarefa<?php echo ($tarefa->idTarefa) ?>" type="number" value="<?php echo ($tarefa->idTarefa) ?>">
                                    <input name="dificuldade<?php echo ($tarefa->idTarefa) ?>" id="<?php echo ($tarefa->idTarefa) ?>" type="text" value="">
                                    <input name="idCurso<?php echo ($tarefa->idTarefa) ?>" type="number" value="<?php echo ($tarefa->idCurso) ?>">
                                </div>
                            <?php endforeach; ?>
                            <button type="submit" class="btn btn-light">Finalizar</button>
                        </form>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        <?php endif ?>
    </div>
</div>

<script type="text/javascript">
    $(".alternar").click(function() {
        selector = ".".concat($(event.target).attr("idTarefa"));
        $(selector).toggle();
        if ($(event.target).text() == 'Mostrar resposta') {
            $(event.target).text('Esconder resposta')
        } else {
            $(event.target).text('Mostrar resposta')
        }
    })

    $(".facil").click(function() {
        let idtarefa = "#".concat($(event.target).val());
        $(idtarefa).attr('value', 'facil');
    })
    $(".dificil").click(function() {
        let idtarefa = "#".concat($(event.target).val());
        $(idtarefa).attr('value', 'dificil');
    })
</script>

<?php
require_once "Views/shared/layout/footer.php";
?>