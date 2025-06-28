<?php

use Models\Curso;
require_once "Utils.php";

class CursosOnDatabase{
    private $conexao;
    
    public function __construct($bdServidor = 'localhost', $bdUsuario = 'root', $bdSenha = 'root', $bdBanco = 'recappro', $port = '3306'){
        
        $this->conexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco, $port);
    }
    
    
    public function SelectAllCursos($idUsuario){
        $sqlBusca = "SELECT * FROM cursos WHERE cursos.idusuario = '{$idUsuario}' ";
        $resultado = mysqli_query($this->conexao, $sqlBusca);
        
        $cursos = [];
        while($curso = mysqli_fetch_assoc($resultado)){
            $cursos[] = $curso;
        }
        
        return $cursos;
    }

    public function Insert($curso){
        session_start();
        $curso['idUsuario'] = $_SESSION['usuario']->idUsuario;
        $sqlInsert = "INSERT INTO cursos (nome, areaConhecimento, quantidadeNovasTarefas, idUsuario)
                        VALUES(
                        '{$curso['nome']}',
                        '{$curso['areaConhecimento']}',
                        '{$curso['quantidadeNovasTarefas']}',
                        '{$curso['idUsuario']}'
                    )";
        return mysqli_query($this->conexao, $sqlInsert);
    }
    
    public function Update($curso){
        $sqlUpdate = "UPDATE cursos SET 
                    nome = '{$curso['nome']}',
                    areaConhecimento = '{$curso['areaConhecimento']}',
                    quantidadeNovasTarefas = '{$curso['quantidadeNovasTarefas']}'
                    WHERE
                    idCurso = '{$curso['idCurso']}' AND
                    idUsuario = '{$curso['idUsuario']}'";
        return mysqli_query($this->conexao, $sqlUpdate);
    }

    
    public function Delete($curso){
        $sqlDelete = "DELETE FROM cursos
                    WHERE
                    idCurso = '{$curso['idCurso']}' AND
                    idUsuario = '{$curso['idUsuario']}'";
        return mysqli_query($this->conexao, $sqlDelete);
    }
}