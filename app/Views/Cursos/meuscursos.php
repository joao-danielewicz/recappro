<?php
require_once "Views/shared/layout/header.php";

if (!is_string($msg)) {
    $msg = '';
}
?>


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
            <h3>Meus cursos</h3>
            <hr>
            <!-- Button trigger modal -->
            <button type="button" class="button-roxo btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCurso">
                Adicionar novo curso
            </button>

            <!-- Modal -->
            <div class="modal fade" id="modalCurso" tabindex="-1" aria-labelledby="cadastroCurso" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="cadastroCurso">Adicionar novo curso</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="cadcurso" method="POST" class="d-flex flex-column ">
                                <div class="d-flex flex-row gap-3 align-items-center mb-3">
                                    <input class="form-control" type="text" name="nome" placeholder="Nome do curso" required>
                                    <input class="form-control" type="text" name="areaConhecimento" placeholder="Área de conhecimento" required>
                                </div>

                                <div class="d-flex flex-row gap-3 align-items-center">
                                    <label class="w-50" for="qtdtarefas">Novas tarefas por dia</label>
                                    <input class="form-control" type="number" min="1" step="1" max="30" value="10" name="quantidadeNovasTarefas" required>
                                </div>
                                <div class="modal-footer mt-3">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                    <button type="submit" class="button-roxo btn btn-primary">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <p class="m-0">Veja abaixo todos os cursos que pertencem a você.</p>
        </div>

        <?php if ($cursos): ?>
            <?php foreach ($cursos as $curso): ?>
                <div class="d-flex flex-column bg-white rounded round shadow">
                    <div class="accordion" id="accordionPanelsStayOpenExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo ($curso->idCurso) ?>" aria-expanded="false" aria-controls="panelsStayOpen-collapseOne">
                                    <?php echo ($curso->nome) ?>

                                </button>
                            </h2>
                            <div id="<?php echo ($curso->idCurso) ?>" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <table class="table">

                                        <thead>
                                            <th>Nome</th>
                                            <th>Assunto</th>
                                            <th>Tarefas novas por dia</th>
                                            <th>Opções</th>
                                        </thead>
                                        <form action="updatecurso" method="post">
                                            <input type="hidden" name="idCurso" value=<?= $curso->idCurso  ?> readonly>
                                            <tbody>
                                                <td><input class="form-control" type="text" name="nome" value='<?= $curso->nome ?>'></td>
                                                <td><input class="form-control" type="text" name="areaConhecimento" value='<?= $curso->areaConhecimento ?>'></td>
                                                <td><input class="form-control" type="number" name="quantidadeNovasTarefas" value='<?= $curso->quantidadeNovasTarefas ?>'></td>
                                                <td class="d-flex justify-content-around">
                                                    <a href="/tarefas?curso=<?php echo($curso->idCurso)?>" class="button-roxo btn btn-primary">Acessar</a>
                                                    <button type="submit" class="btn btn-primary">Salvar</button>
                                                    <button type="submit" formaction="/deletecurso" class="btn btn-danger">Remover</button>
                                                </td>
                                            </tbody>
                                        </form>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        <?php endif ?>
</div>

<?php require_once "Views/shared/layout/footer.php" ?>