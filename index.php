<?php
require_once __DIR__.'/Core/Core.php';
require_once __DIR__.'/Router/routes.php';


spl_autoload_register(function($file){
    if(file_exists(__DIR__."/utils/$file.php")){
        require_once __DIR__."/utils/$file.php";
    }else if(file_exists(__DIR__."/models/$file.php")){
        require_once __DIR__."/models/$file.php";
    }
});

$core = new Core();
$core->run($routes, $_POST);