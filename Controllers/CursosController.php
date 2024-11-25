<?php

// A classe CursosController, assim como todos os controladores, herda da classe RendewView para que possa utilizar
// a função de carregamento da página de View, que informa qual o caminho dentro do diretório Views e quais as variáveis a serem passadas
// para que a View opere de modo correto.
// Ela ficará responsável por operações que se relacionam com o modelo Curso, como o CRUD.
class CursosController extends RenderView{
    private $method;

    // Na função construtora, recebemos o método de armazenamento.
    // Utilizamos a injeção de dependência para evitar o alto acoplamento e deixar o código pronto caso, em algum momento,
    // o tipo de armazenamento seja alterado. Caso isso ocorra, basta mudar a instância das classes OnDatabase no Core da aplicação.
    public function __construct($method){
        $this->method = $method;
    }

    // A função index tem como objetivo guiar o usuário à página que conterá uma listagem dos cursos que pertencem a ele.
    // Para isso, primeiro verificará se a superglobal COOKIE está inicializada. Isto, pela lógica que criamos, indica que 
    // há um usuário logado no sistema, e que poderemos acessar suas informações.
    // Caso a verificação falhe, o usuário será redirecionado à página inicial do aplicativo.
    // Caso haja sucesso, a função carregará a página de View, passando algumas variáveis úteis: uma eventual mensagem ao usuário,
    // o título da página e a listagem dos cursos encontrados.
    // A mensagem tem o valor padrão vazio, e a View será responsável por renderizá-la caso contenha algum texto.
    public function index($msg = ''){
        if(empty($_COOKIE)){
            header('Location: /');
            die();
        }
        session_start();
        $this->loadView('/Cursos/meuscursos', [
            'msg' => $msg,
            'titulo' => "RecapPro - Cursos",
            'cursos' => $this->GetCursos($_SESSION['usuario']->idUsuario)
        ]);
    }

    // Na função InsertCurso, realizaremos o cadastro de um novo curso na base de persistência.
    // Primeiro, verificamos se a variável $curso (que representa um $_POST) está vazia.
    // Tratamos este erro pois o usuário pode acessar esta função diretamente através da URL, e neste caso nenhum POST existirá, o que ocasiona um erro.
    // Caso $curso esteja vazia, enviamos o usuário à página inicial.
    // Caso contrário, chamamos o método de inserção da persistência e redirecionamos o usuário à mesma página onde efetuou o cadastro do curso.
    public function InsertCurso($curso){
        if(!empty($curso)){
            $this->method->Insert($curso);
            header("Location: /meuscursos");
            die();
        }
        header('Location: /');
    }
    
    // A função GetCursos tem como objetivo retornar, principalmente ao index, todos os cursos encontrados que pertencem ao usuário lado.
    // Para isso, utiliza a função SelectAllCursos, informando o ID do usuário do qual se desejam receber os cursos.
    // O método padrão do sistema, que é o Banco de Dados MYSQL, retornará um grande Array de Arrays associativos, cada um deles contendo os campos dos Cursos.
    // Como desejamos evidenciar a Orientação a Objetos, transformamos tais Arrays em objetos do tipo Curso.
    // Antes disso, verificamos se a lista dos cursos não é nula, caso este que indica que ainda não há nenhum curso cadastrado no armazenamento.
    private function GetCursos($idUsuario){
        $listaCursos = $this->method->SelectAllCursos($idUsuario);
        $buildCursos = [];
        if($listaCursos != null){
            foreach($listaCursos as $curso){
                $buildCursos[] = new Curso(
                    $curso['idCurso'],
                    $curso['nome'],
                    $curso['areaConhecimento'],
                    new DateTime($curso['dataAdicao']),
                    $curso['quantidadeNovasTarefas'],
                    $curso['idUsuario']
                );
            }
        }
        return $buildCursos;
    }
   
    // As funções de Update e Delete funcionam praticamente de maneira idêntica.
    // A única diferença, claro, é que chamarão funções diferentes do método de armazenamento.
    // Como as informações do curso a serem alteradas provêm de um formulário, é inviável que o usuário digite o próprio ID para
    // que possamos atualizar o curso correto na lógica do armazenamento.
    // Portanto, definimos uma nova chave do Array para que contenha a informação de qual usuário se deve retirar o curso.
    public function UpdateCurso($post){
        if(empty($post)){
            header("Location: /");
            die();
        }
        session_start();
        $post['idUsuario'] = $_SESSION['usuario']->idUsuario;
        session_abort();
        $this->method->Update($post);
        $this->index();
        die();
    }

    public function DeleteCurso($post){
        if(empty($post)){
            header("Location: /");
            die();
        }
        session_start();
        $post['idUsuario'] = $_SESSION['usuario']->idUsuario;
        session_abort();
        $this->method->Delete($post);
        $this->index();
        die();
    }
}