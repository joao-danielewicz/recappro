<?php
// A classe HomeController, assim como todos os controladores, herda da classe RendewView para que possa utilizar
// a função de carregamento da página de View, que informa qual o caminho dentro do diretório Views e quais as variáveis a serem passadas
// para que a View opere de modo correto.
// São de sua responsabilidade as operações relacionadas à qualidade de vida do Site, mas que não necessariamente se relacionam com os Modelos do projeto.
class HomeController extends RenderView{
    public function index(){
        $this->loadView('/Home/homepage', [
            'titulo' => "RecapPro - Início"
        ]);
    }

    public function Pomodoro(){
        $this->loadView('/Home/pomodoro');
    }
}