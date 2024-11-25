<?php
// A classe NotFoundController, assim como todos os controladores, herda da classe RendewView para que possa utilizar
// a função de carregamento da página de View, que informa qual o caminho dentro do diretório Views e quais as variáveis a serem passadas
// para que a View opere de modo correto.
class NotFoundController{
    public function index(){
        header("Location: /");
    }
}