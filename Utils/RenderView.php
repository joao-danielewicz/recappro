<?php

class RenderView{
    // Caso sejam passados parâmetros para serem utilizados na página, eles serão divididos em variáveis com o extract().
    // Faz a requisição da página solicitada no diretório views.
    public function loadView($view, $args = null){
        if(isset($args)){
            extract($args);
        }
        require_once __DIR__."/../views/$view.php";
    }
}