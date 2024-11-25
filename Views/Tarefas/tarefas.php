<?php
require_once "Views/shared/layout/header.php";

if (!is_string($msg)) {
    $msg = '';
}
?>

<link rel="stylesheet" href="Views/Tarefas/css/tarefas.css">
<!-- Cria um título para a página -->
<title><?php echo ($titulo) ?></title>

<!-- Verifica se há alguma mensagem a ser passada ao usuário. Caso positivo, escreve-a. -->
<?php if (!empty($msg)): ?>
    <div class="position-absolute border border-danger rounded round m-3 bg-white p-3 shadow">
        <p class="m-0"><?php echo $msg ?></p>
    </div>
<?php endif; ?>


<div class="container mt-5" style="min-height: calc(100vh - 71px);">
    <div class="d-flex flex-column bg-white p-3 rounded round text-center shadow mb-3">
        <h3>Tarefas do curso</h3>
        <hr>

        <div class="d-flex justify-content-stretch ">

            <button type="button" class="w-100 button-roxo btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTarefa">
                Adicionar nova tarefa
            </button>
            <?php if (isset($tarefas)): ?>
                <a role="button" href="/estudo?curso=<?php echo ($_GET['curso']) ?>" class="ms-3 w-100 button-roxo btn btn-primary">
                    Estudar
                </a>
            <?php endif; ?>
        </div>

        <div class="modal fade" id="modalTarefa" tabindex="-1" aria-labelledby="cadastroTarefa" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cadastroTarefa">Adicionar nova tarefa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="cadtarefa" method="POST" enctype="multipart/form-data" class="d-flex flex-column p-3">
                            <div class="d-flex flex-column gap-3 align-items-center">
                                <input class="form-control" type="text" name="assunto" placeholder="Assunto" required>
                                <input class="form-control" type="text" name="pergunta" placeholder="Pergunta" required>
                                <input class="form-control" type="text" name="resposta" placeholder="Resposta" required>

                                <label for="midiapergunta">Mídia da pergunta</label>
                                <input class="form-control" id="midiapergunta" type="file" accept="image/*" name="midiaPergunta" placeholder="Imagem">

                                <label for="midiaresposta">Mídia da resposta</label>
                                <input class="form-control" id="midiaresposta" type="file" accept="image/*" name="midiaResposta" placeholder="Imagem">

                                <input class="form-control" type="number" name="idCurso" hidden value="<?php echo ($_GET['curso']) ?>">
                            </div>
                            <div class="modal-footer mt-3">
                                <button type="submit" class="button-roxo btn btn-primary">Cadastrar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <p class="m-0">Veja abaixo todas as tarefas deste curso.</p>
    </div>

    <div class="p-3 bg-white rounded round shadow">

        <?php if (isset($tarefas)): ?>
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Pergunta</th>
                        <th>Assunto</th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($tarefas as $tarefa): ?>
                        <tr>
                            <td><?php echo $tarefa->pergunta ?></td>
                            <td><?php echo $tarefa->assunto ?></td>
                            <td class="flex-shrink-1">
                                <!-- Button trigger modal -->
                                <a data-bs-toggle="modal" data-bs-target="#<?php echo ($tarefa->idTarefa) ?>">
                                    Detalhes...
                                </a>

                                <!-- Modal -->
                                <div class="modal fade" id="<?php echo ($tarefa->idTarefa) ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Detalhes da tarefa</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Adicionada em: <?php echo (date_format($tarefa->dataAdicao, 'd/m/Y')) ?> </p>

                                                <?php if ($tarefa->nivelEstudo != 0): ?>
                                                    <p>Você estudou esta tarefa pela última vez em: <?php echo (date_format($tarefa->dataUltimoEstudo, 'd/m/Y')) ?></p>
                                                <?php endif ?>

                                                <p>Data da próxima revisão: <?php echo (date_format($tarefa->dataProximoEstudo, 'd/m/Y')) ?> </p>
                                                <hr>

                                                <div class="d-flex text-center justify-content-around">
                                                    <div>

                                                        <?php if ($tarefa->midiaPergunta != null): ?>
                                                            <div>
                                                                <p class="m-0">Imagem da pergunta</p>
                                                                <img src="data:image/*; base64,<?= base64_encode($tarefa->midiaPergunta) ?>" />
                                                            </div>
                                                        <?php endif ?>

                                                        <?php if ($tarefa->midiaResposta != null): ?>
                                                            <div>
                                                                <p class="m-0">Imagem da Resposta</p>
                                                                <img src="data:image/*; base64,<?= base64_encode($tarefa->midiaResposta) ?>" />
                                                            </div>
                                                        <?php endif ?>
                                                    </div>

                                                    <form action="userupdatetarefa" method="POST" enctype="multipart/form-data" class="d-flex flex-column p-3">
                                                        <div class="d-flex flex-column gap-3 align-items-center">
                                                            <input class="form-control" value="<?php echo ($tarefa->assunto) ?>" type="text" name="assunto" placeholder="Assunto" required>
                                                            <input class="form-control" value="<?php echo ($tarefa->pergunta) ?>" type="text" name="pergunta" placeholder="Pergunta" required>
                                                            <input class="form-control" value="<?php echo ($tarefa->resposta) ?>" type="text" name="resposta" placeholder="Resposta" required>

                                                            <label for="midiapergunta">Mídia da pergunta</label>
                                                            <input class="form-control" id="midiapergunta" type="file" accept="image/*" name="midiaPergunta" placeholder="Imagem">

                                                            <label for="midiaresposta">Mídia da resposta</label>
                                                            <input class="form-control" id="midiaresposta" type="file" accept="image/*" name="midiaResposta" placeholder="Imagem">
                                                            <input class="form-control" type="number" name="idCurso" hidden value="<?php echo ($_GET['curso']) ?>">
                                                            <input class="form-control" type="number" name="idTarefa" hidden value="<?php echo ($tarefa->idTarefa) ?>">
                                                        </div>
                                                        <div class="modal-footer mt-3">
                                                            <button type="submit" class="button-roxo btn">Salvar alterações</button>
                                                            <button type="submit" formaction="deletetarefa" class="btn btn-danger">Excluir</button>
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                        </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <?php endif ?>
    </div>
</div>


<?php
require_once "Views/shared/layout/footer.php";
?>