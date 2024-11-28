<?php
require_once __DIR__.'/Core/Core.php';
require_once __DIR__.'/Router/routes.php';

// O arquivo .htaccess é usado para definir algumas configurações do servidor local. Nele, incluímos algumas regras que irão redirecionar o usuário para a página index caso a URL digitada não corresponda a um arquivo ou pasta acessível na árvore do servidor. 
// Além disso, há uma tratativa para que seja possível capturar tudo que seja passado após localhost:8000, o que nos faz capaz de encaminhar o usuário dinamicamente.

// Usamos esta função para carregar automaticamente todas as classes que iremos usar em nossa aplicação, como os Models, Controllers, Utils, etc.
spl_autoload_register(function($file){
    if(file_exists(__DIR__."/utils/$file.php")){
        require_once __DIR__."/utils/$file.php";
    }else if(file_exists(__DIR__."/models/$file.php")){
        require_once __DIR__."/models/$file.php";
    }
});

$core = new Core();
$core->run($routes, $_POST);