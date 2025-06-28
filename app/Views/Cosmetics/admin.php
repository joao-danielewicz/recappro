<?php
require_once "Views/shared/layout/header.php";
?>

<!-- Cria um título para a página -->
<title><?php echo ($titulo) ?></title>
<link rel="stylesheet" href="/Views/cosmetics/src/css/cosmetics.css">


<div class="container mt-5">
    <div class="d-flex flex-column bg-white p-3 rounded round text-center shadow mb-3">
        <h3>Itens cosméticos</h3>
        <hr>

        <div class="d-flex justify-content-stretch ">

            <button type="button" class="w-100 button-roxo btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTarefa">
                Adicionar novo item
            </button>
        </div>

        <div class="modal fade" id="modalTarefa" tabindex="-1" aria-labelledby="cadastroTarefa" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="cadastroTarefa">Adicionar novo item</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="caditem" method="POST" enctype="multipart/form-data" class="d-flex flex-column p-3">
                            <div class="d-flex flex-column gap-3 align-items-center">
                                <input class="form-control" type="text" name="descricao" placeholder="Descrição" required>
                                <input class="form-control" type="text" name="tipo" placeholder="Tipo" required>
                                <input class="form-control" type="number" min="1" name="preco" placeholder="Preço" required>

                                <label for="midiapergunta">Mídia</label>
                                <input class="form-control" id="midiapergunta" type="file" accept="image/*" name="midia" required>

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
        <p class="m-0">Veja abaixo todos os itens cosméticos</p>
    </div>

    <div class="p-3 bg-white rounded round shadow">

        <?php if ($itens): ?>
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Preço</th>
                        <th width="10%"></th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($itens as $item): ?>
                        <tr>
                            <td><?php echo $item->descricao ?></td>
                            <td><?php echo $item->tipo ?></td>
                            <td><?php echo $item->preco ?></td>
                            <td class="flex-shrink-1">
                                <!-- Button trigger modal -->
                                <a data-bs-toggle="modal" data-bs-target="#<?php echo ($item->idItem) ?>">
                                    Detalhes...
                                </a>

                                <!-- Modal -->
                                <div class="modal fade" id="<?php echo ($item->idItem) ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Detalhes do Item</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="m-0 mb-2 text-center">Imagem do item</p>
                                                <div class="container">

                                                    <img src="data:image/*; base64,<?= base64_encode($item->midia) ?>" />
                                                </div>


                                                <form action="updateitem" method="POST" enctype="multipart/form-data" class="d-flex flex-column p-3">
                                                    <label for="descricao" class="form-label">Descrição</label>
                                                    <input class="form-control mb-3" value="<?php echo ($item->descricao) ?>" type="text" id="descricao" name="descricao" placeholder="Descrição" required>

                                                    <label for="tipo" class="form-label">Tipo do item</label>
                                                    <input class="form-control mb-3" value="<?php echo ($item->tipo) ?>" type="text" id="tipo" name="tipo" placeholder="Tipo" required>

                                                    <label for="preco" class="form-label">Preço</label>
                                                    <input class="form-control mb-3" value="<?php echo ($item->preco) ?>" type="number" min="1" id="preco" name="preco" placeholder="Preço" required>


                                                    <label for="midia">Mídia</label>
                                                    <input class="form-control" id="midia" type="file" accept="image/*" name="midia" placeholder="Imagem">

                                                    <input class="form-control" type="number" name="idItem" hidden value="<?php echo ($item->idItem) ?>">
                                                    <div class="modal-footer mt-3">
                                                        <button type="submit" class="button-roxo btn">Salvar alterações</button>
                                                        <button type="submit" formaction="deleteitem" class="btn btn-danger">Excluir</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                                                    </div>
                                                </form>
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