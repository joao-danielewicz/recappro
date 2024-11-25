<?php
require_once "TarefaScheduler.php";

// A classe TarefasController herda de RenderView para que possa exibir as páginas de visão.
// Possui o método de armazenamento, uma referência para o Id do usuário ativo e o Scheduler, que efetuará o agendamento do estudo das tarefas
// antes que estas sejam cadastradas ou atualizadas no banco de dados.
class TarefasController extends RenderView{
    private $method;
    private $scheduler;
    private int $idUsuario;
    
    public function __construct($method){
        $this->method = $method;
        $this->scheduler = new TarefaScheduler();
        if(!empty($_COOKIE)){
            session_start();
            $this->idUsuario = $_SESSION['usuario']->idUsuario;
            session_abort();
        }
    }

    // Na função index iremos guiar o usuário à página de listagem de todas as tarefas de um curso,
    // efetuando as validações necessárias para verificar se o curso pertence ao usuário ativo
    // e, caso positivo, se existem tarefas cadastradas nele.
    public function index($msg = '', $titulo = 'RecapPro - Detalhes do Curso'){
        if(empty($_COOKIE)){
            header('Location: /');
            die();
        }

        
        $tarefas = $this->GetTarefas($_GET['curso'], $this->idUsuario);

        if($tarefas != "Erro."){
            $this->loadView('/Tarefas/tarefas', [
                'titulo' => $titulo,
                'msg' => $msg,
                'tarefas' => $this->GetTarefas($_GET['curso'], $this->idUsuario)
            ]);
            die();
        }else{
            $this->loadView('/Tarefas/tarefas', [
                'titulo' => $titulo,
                'msg' => 'Este curso não pôde ser encontrado. Tente novamente.'
            ]);
            die();
        }
    }

    // A função estudo tem como objetivo receber as tarefas listadas como novas e aquelas que estão marcadas para estudo na data atual.
    // Verifica a integridade do curso e carrega a página para que o usuário estude as tarefas.
    public function estudo($msg = '', $titulo = 'RecapPro - Estudar'){
        if(empty($_COOKIE)){
            header('Location: /');
            die();
        }

        $tarefas = $this->GetTarefasByDateOrLevel($_GET['curso'], $this->idUsuario, new DateTime());

        if($tarefas != "Erro."){
            $this->loadView('/Tarefas/estudo', [
                'titulo' => $titulo,
                'tarefas' => $tarefas
            ]);
            die();    
        }
        
        $this->loadView('/Tarefas/estudo', [
            'titulo' => $titulo,
            'msg' => 'Este curso não pôde ser encontrado. Tente novamente.'
        ]);
        die();
    }

    // Antes de cadastrar no banco, a função InsertTarefa passa a tarefa para que receba seu agendamento inicial pelo Scheduler.
    public function InsertTarefa($tarefa){
        if(!empty($tarefa)){
            $tarefa = $this->scheduler->CadastroTarefa($tarefa);
            $this->method->Insert($tarefa);
            header("Location: /tarefas?curso=".$tarefa['idCurso']);
            die();
        }
        header("Location: /");
    }
    
    // A função BuildTarefas converte os Arrays associativos em Objetos da classe Tarefa.
    private function BuildTarefas($listaTarefas){
        $buildTarefas = [];
        if($listaTarefas != null){
            foreach($listaTarefas as $tarefa){
                if(empty($tarefa['midiaPergunta'])){
                    $tarefa['midiaPergunta'] = "";
                }
                if(empty($tarefa['midiaResposta'])){
                    $tarefa['midiaResposta'] = "";
                }
                
                $buildTarefas[] = new Tarefa(
                    $tarefa['idTarefa'], $tarefa['assunto'], $tarefa['pergunta'], $tarefa['resposta'],
                    $tarefa['midiaPergunta'], $tarefa['midiaResposta'],
                    new DateTime($tarefa['dataAdicao']),
                    new DateTime($tarefa['dataProximoEstudo']),
                    new DateTime($tarefa['dataUltimoEstudo']),
                    $tarefa['nivelEstudo'],
                    $tarefa['idCurso']
                );
            }
            return $buildTarefas;
        }
        return null;
    }

    // Esta função recebe as tarefas em Arrays associativos e chama a função BuildTarefas para convertê-los.
    public function GetTarefas($idCurso, $idUsuario){
        $listaTarefas = $this->method->SelectAllTarefas($idCurso, $idUsuario);
        if($listaTarefas != "Erro."){
            return $this->BuildTarefas($listaTarefas);
        }else{
            return "Erro.";
        }
    }
    
    // Recebe tarefas novas e marcadas para hoje.
    public function GetTarefasByDateOrLevel($idCurso, $idUsuario, $data){
        $listaTarefas = $this->method->SelectTarefasByDateOrLevel($idCurso, $idUsuario, $data);
        if($listaTarefas != "Erro."){
            return $this->BuildTarefas($listaTarefas);
        }else{
            return "Erro.";
        }
    }
    
    // Atualiza a tarefa.
    public function UpdateTarefa($tarefa){
        $tarefa['idUsuario'] = $this->idUsuario;
        return $this->method->Update($tarefa);
    }

    // Atualiza a tarefa após uma sessão de estudo.
    // Antes de passar para o banco, a Tarefa é tratada pelo Scheduler para receber uma nova data de estudo de acordo com a dificuldade encontrada.
    private function UpdateTarefaEstudo($tarefa){
        $tarefa = $this->scheduler->Estudar($tarefa);
        $this->UpdateTarefa($tarefa);
    }
    
    // Esta função recebe um conjunto de tarefas com seus IDs e a dificuldade que os usuários encontraram ao respondê-la.
    // Como todas as tarefas encontram-se no mesmo POST, é necessário "quebrá-lo" em partes menores com a função array_chunk.
    // A partir disso, obtemos os conjuntos de tarefas individuais, e podemos atualizá-las.
    public function estudartarefas($post){
        if(empty($post)){
            header('Location: /');
            die();
        }
        $tarefasEstudo = array_chunk($post,3);
        $i=0;
        foreach($this->method->SelectAllTarefas($tarefasEstudo[0][2], $this->idUsuario) as $tarefa){
            if($tarefa['idTarefa'] == $tarefasEstudo[$i][0]){
                $tarefa['estudar'] = $tarefasEstudo[$i][1];
                $this->UpdateTarefaEstudo($tarefa);
                $i++;
            }
        }
        header("Location: /meuscursos");
        die();
    }

    // Atualiza a tarefa conforme as informações passadas pelo usuário.
    // Difere do UpdateEstudo pois aqui só são passadas informaões possíveis de serem alteradas pelo estudante.
    public function UserUpdateTarefa($post){
        $this->method->UserUpdate($post);
        header("Location: /tarefas?curso=".$post['idCurso']);
        die();
    }

    // Exclui a tarefa do Banco de Dados.
    public function DeleteTarefa($post){
        $this->method->Delete($post);
        header("Location: /tarefas?curso=".$post['idCurso']);
        die();
    }
}