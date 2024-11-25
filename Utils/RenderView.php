<?php

class RenderView{
    public function loadView($view, $args = null){
        if(isset($args)){
            extract($args);
        }
        require_once __DIR__."/../views/$view.php";
    }
}