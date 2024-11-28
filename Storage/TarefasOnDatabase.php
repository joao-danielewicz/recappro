<?php

use Models\Tarefa;
require_once "Utils.php";


class TarefasOnDatabase{
    private $conexao;
    
    public function __construct($bdServidor = 'localhost', $bdUsuario = 'root', $bdSenha = 'root', $bdBanco = 'recappro', $port = '3306'){
        $this->conexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco, $port);
    }
    
    
    public function SelectAllTarefas($idCurso, $idUsuario){
        $sqlBusca = "SELECT cursos.idCurso FROM cursos WHERE 
                    cursos.idUsuario = '{$idUsuario}' ";
        $resultado = mysqli_query($this->conexao, $sqlBusca);
        $cursosDisponiveis = [];
        while($tarefa = mysqli_fetch_assoc($resultado)){
            $cursosDisponiveis[] = $tarefa['idCurso'];
        }
        

        if(in_array($idCurso, $cursosDisponiveis)){
            $sqlBusca = "SELECT tarefas.* FROM tarefas INNER JOIN
                        cursos on tarefas.idCurso = cursos.idCurso WHERE
                        tarefas.idCurso = '{$idCurso}' AND
                        cursos.idUsuario = '{$idUsuario}' ";
            $resultado = mysqli_query($this->conexao, $sqlBusca);
            
            $tarefas = [];
            while($tarefa = mysqli_fetch_assoc($resultado)){
                    $tarefas[] = $tarefa;
                }
                
                return $tarefas;
        }else{
            return "Erro.";
        }
    }
    
    public function SelectNovasTarefas($idCurso, $idUsuario){
        $sqlBusca = "SELECT cursos.idCurso FROM cursos WHERE 
                    cursos.idUsuario = '{$idUsuario}' ";
        $resultado = mysqli_query($this->conexao, $sqlBusca);
        $cursosDisponiveis = [];
        while($tarefa = mysqli_fetch_assoc($resultado)){
            $cursosDisponiveis[] = $tarefa['idCurso'];
        }
        

        if(in_array($idCurso, $cursosDisponiveis)){
            $sqlBusca = "SELECT * FROM tarefas INNER JOIN
                        cursos ON tarefas.idCurso = cursos.idCurso WHERE
                        tarefas.idCurso = '{$idCurso}' AND
                        cursos.idUsuario = '{$idUsuario}' AND
                        tarefas.nivelEstudo = 0";
            $resultado = mysqli_query($this->conexao, $sqlBusca);
            
            $tarefas = [];
            while($tarefa = mysqli_fetch_assoc($resultado)){
                $tarefas[] = $tarefa;
            }
            
            return $tarefas;
        }else{
            return "Erro.";
        }
    }

    public function SelectTarefasByDateOrLevel($idCurso, $idUsuario, $data){
        $sqlBusca = "SELECT cursos.idCurso FROM cursos WHERE 
                    cursos.idUsuario = '{$idUsuario}' ";
        $resultado = mysqli_query($this->conexao, $sqlBusca);
        $cursosDisponiveis = [];
        while($tarefa = mysqli_fetch_assoc($resultado)){
            $cursosDisponiveis[] = $tarefa['idCurso'];
        }
        
        
        $data = date_format($data, "Y-m-d");
        if(in_array($idCurso, $cursosDisponiveis)){
            $sqlBusca = "SELECT quantidadeNovasTarefas FROM cursos WHERE idCurso = '{$idCurso}' AND idUsuario = '{$idUsuario}'";
            $resultado = mysqli_query($this->conexao, $sqlBusca);
            $qtdTarefas = mysqli_fetch_assoc($resultado)['quantidadeNovasTarefas'];
            
            $sqlBusca = "SELECT * FROM tarefas INNER JOIN cursos on tarefas.idCurso = cursos.idCurso
	                    WHERE tarefas.idCurso = '{$idCurso}' 
                        AND cursos.idUsuario = '{$idUsuario}'
                        AND tarefas.nivelEstudo != 0
                        AND (CAST(tarefas.dataProximoEstudo as DATE) = '{$data}')
                        UNION
                        (SELECT * FROM tarefas INNER JOIN cursos on tarefas.idCurso = cursos.idCurso
		                WHERE tarefas.idCurso = '{$idCurso}'
                        AND cursos.idUsuario = '{$idUsuario}'
                        AND tarefas.nivelEstudo = 0
		                ORDER BY rand() LIMIT {$qtdTarefas} )";
            $resultado = mysqli_query($this->conexao, $sqlBusca);
            
            $tarefas = [];
            while($tarefa = mysqli_fetch_assoc($resultado)){
                $tarefas[] = $tarefa;
            }
            
            return $tarefas;
        }else{
            return "Erro.";
        }
    }

    private function pegarImagens($tarefa){
        if(!empty($_FILES['midiaPergunta']['name'])){
            $tarefa['midiaPergunta'] = pegarImagem($_FILES['midiaPergunta']);
        }else{
            $tarefa['midiaPergunta'] = null;
        }

        if(!empty($_FILES['midiaResposta']['name'])){
            $tarefa['midiaResposta'] = pegarImagem($_FILES['midiaResposta']);
        }else{
            $tarefa['midiaResposta'] = null;
        }
        return $tarefa;
    }

    public function Insert($tarefa){
        $tarefa = $this->pegarImagens($tarefa);

        $sqlInsert = "INSERT INTO tarefas (assunto, pergunta, resposta, dataadicao, dataultimoestudo, dataproximoestudo, midiapergunta, midiaresposta, nivelestudo, idcurso)
                VALUES(
                    '{$tarefa['assunto']}',
                    '{$tarefa['pergunta']}',                    
                    '{$tarefa['resposta']}',                    
                    '{$tarefa['dataAdicao']}',
                    '{$tarefa['dataUltimoEstudo']}',
                    '{$tarefa['dataProximoEstudo']}',
                    '{$tarefa['midiaPergunta']}',
                    '{$tarefa['midiaResposta']}',
                    '{$tarefa['nivelEstudo']}',
                    '{$tarefa['idCurso']}'
            )";
        return mysqli_query($this->conexao, $sqlInsert);
    }
    
    public function Update($tarefa){
        if(isset($tarefa['idUsuario'])){
            $sqlUpdate = "UPDATE usuarios SET qtdpontos = qtdPontos+1 WHERE idUsuario = '{$tarefa['idUsuario']}'";
            mysqli_query($this->conexao, $sqlUpdate);
        }
        
        $sqlUpdate = "UPDATE tarefas SET 
                    dataproximoestudo = '{$tarefa['dataProximoEstudo']}',
                    dataultimoestudo = '{$tarefa['dataUltimoEstudo']}',
                    nivelEstudo = '{$tarefa['nivelEstudo']}'
                    WHERE
                    idTarefa = '{$tarefa['idTarefa']}'";


        return mysqli_query($this->conexao, $sqlUpdate);
    }

    public function UserUpdate($tarefa){
        $tarefa = $this->pegarImagens($tarefa);
        $sqlUpdate = "UPDATE tarefas SET 
                    assunto = '{$tarefa['assunto']}',
                    pergunta = '{$tarefa['pergunta']}',
                    resposta = '{$tarefa['resposta']}'";

        if(isset($tarefa['midiaPergunta'])){
            $sqlUpdate .= ", midiaPergunta = '{$tarefa['midiaPergunta']}'";
        }
        if(isset($tarefa['midiaResposta'])){
            $sqlUpdate .= ", midiaResposta = '{$tarefa['midiaResposta']}'";
        }


        $sqlUpdate .= " WHERE idTarefa = '{$tarefa['idTarefa']}' AND
                       idCurso = '{$tarefa['idCurso']}'";

        return mysqli_query($this->conexao, $sqlUpdate);
    }
    
    public function Delete($tarefa){
        $sqlDelete = "DELETE FROM tarefas WHERE idTarefa = '{$tarefa['idTarefa']}'";
        return mysqli_query($this->conexao, $sqlDelete);
    }
}