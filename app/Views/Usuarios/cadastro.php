<?php
// Importa o cabeçalho com as tags de estilos necessárias
require_once "Views/shared/layout/head.php";
if (!is_string($msg)) {
    $msg = '';
}
?>

<!-- Cria um título para a página -->
<title><?php echo($titulo)?></title>

<!-- Importa os estilos pertinentes à página de cadastro e login -->
<link rel="stylesheet" href="/Views/Usuarios/css/formuser.css">

<!-- Verifica se há alguma mensagem a ser passada ao usuário. Caso positivo, escreve-a. -->
<?php if(!empty($msg)):?>
    <div class="position-absolute border border-danger rounded round m-3 bg-white p-3 shadow">
        <p class="m-0"><?php echo $msg ?></p>
    </div>
<?php endif; ?>

<!-- Formulário de recebimento dos dados cadastrais do usuário -->
<div class="container w-50">
    <div class="border round rounded p-4 pb-5 bg-white shadow mt-3">
        <h3 class="text-center">Cadastre-se</h3>
        <form action="/caduser" method="post">
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <input class="form-control" type="text" id="nome" name="nome" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="telefone">Telefone</label>
                <input class="form-control" type="tel" id="telefone" name="telefone" required>
            </div>

            <div class="form-group">
                <label for="data-nascimento">Data de Nascimento</label>
                <input class="form-control" type="date" id="data-nascimento" name="dataNascimento" required>
            </div>

            <div class="form-group">
                <label for="senha">Senha</label>
                <input class="form-control" type="password" id="senha" name="senha" required>
            </div>

            <button class="button-roxo btn w-100" type="submit">Cadastrar</button>
        </form>
    </div>
</div>