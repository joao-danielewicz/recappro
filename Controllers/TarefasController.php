<?php
require_once "TarefaScheduler.php";

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


    public function InsertTarefa($tarefa){
        if(!empty($tarefa)){
            $tarefa = $this->scheduler->CadastroTarefa($tarefa);
            $this->method->Insert($tarefa);
            header("Location: /tarefas?curso=".$tarefa['idCurso']);
            die();
        }
        header("Location: /");
    }
    
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

    public function GetTarefas($idCurso, $idUsuario){
        $listaTarefas = $this->method->SelectAllTarefas($idCurso, $idUsuario);
        if($listaTarefas != "Erro."){
            return $this->BuildTarefas($listaTarefas);
        }else{
            return "Erro.";
        }
    }
    
    public function GetTarefasByDateOrLevel($idCurso, $idUsuario, $data){
        $listaTarefas = $this->method->SelectTarefasByDateOrLevel($idCurso, $idUsuario, $data);
        if($listaTarefas != "Erro."){
            return $this->BuildTarefas($listaTarefas);
        }else{
            return "Erro.";
        }
    }
    
    public function UpdateTarefa($tarefa){
        $tarefa['idUsuario'] = $this->idUsuario;
        return $this->method->Update($tarefa);
    }

    private function UpdateTarefaEstudo($tarefa){
        $tarefa = $this->scheduler->Estudar($tarefa);
        $this->UpdateTarefa($tarefa);
    }
    
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

    public function UserUpdateTarefa($post){
        $this->method->UserUpdate($post);
        header("Location: /tarefas?curso=".$post['idCurso']);
        die();
    }

    public function DeleteTarefa($post){
        $this->method->Delete($post);
        header("Location: /tarefas?curso=".$post['idCurso']);
        die();
    }
}