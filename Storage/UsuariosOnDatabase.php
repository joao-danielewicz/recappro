<?php

use Models\Usuario;
require_once "Utils.php";


class UsuariosOnDatabase{
    private $conexao;
    
    public function __construct($bdServidor = 'localhost', $bdUsuario = 'root', $bdSenha = 'root', $bdBanco = 'recappro', $port = '3306'){
        $this->conexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco, $port);
    }

    private function EncryptPassword($senha){
        return (hash_pbkdf2("sha256", $senha, 'sdgb4433bn6bsfwbsf', 60000));
    }
    
    private function VerificarEmail($login){
        $sqlBusca = "SELECT * FROM usuarios WHERE usuarios.email = '{$login['email']}'";
        $resultado = mysqli_query($this->conexao, $sqlBusca);
        $usuario = mysqli_fetch_assoc($resultado);   

        if($usuario){
            return $usuario;
        }
        return false;
    }

    public function GetGaleria($idUsuario){
        $sqlBusca = "SELECT ic.* FROM itensCosmeticos AS ic, itensInventario AS iv WHERE
		            iv.idInventario = (SELECT idInventario FROM inventarios WHERE idUsuario = '{$idUsuario}') AND
                    iv.idItem = ic.idItem";
        $resultado = mysqli_query($this->conexao, $sqlBusca);

        $galeria = [];
        while($item = mysqli_fetch_assoc($resultado)){
            $galeria[] = $item;
        }

        if($galeria != null){
            return $galeria;
        }
        return "";
    }
    
    private function VerificarSenha($login){
        $usuario = $this->VerificarEmail($login);
        if($usuario){
            if($this->EncryptPassword($login['senha']) === $usuario['senha'] ){
                    $sqlBusca = "SELECT * FROM cursos WHERE cursos.idUsuario = '{$usuario['idUsuario']}'";
                    $resultado = mysqli_query($this->conexao, $sqlBusca);
                    $usuario['cursos'] = [];
                    while($curso = mysqli_fetch_assoc($resultado)){
                        $usuario['cursos'][] = $curso['idCurso'];
                    }

                    if($usuario['idFotoPerfil']!=0){
                        $sqlBusca = "SELECT ic.midia FROM itensCosmeticos AS ic, usuarios AS u WHERE
                                    u.idFotoPerfil = ic.idItem AND
                                    u.idUsuario = '{$usuario['idUsuario']}'";
                        $resultado = mysqli_query($this->conexao, $sqlBusca);
                        $usuario['fotoPerfil'] = mysqli_fetch_assoc($resultado)['midia'];; 
                    }else{
                        $usuario['fotoPerfil'] = '';
                    }

                    unset($usuario['senha']);
                    return $usuario;
                }
            }
            
            return false;
        }

    public function ValidarLogin($login){
        $usuario = $this->VerificarSenha($login);
        return $usuario;
    }

    public function SetFotoPerfil($idFoto, $idUsuario){
        $sqlUpdate = "UPDATE usuarios SET
                        idFotoPerfil = '{$idFoto}' WHERE
                        idUsuario = '{$idUsuario}'";
        return mysqli_query($this->conexao, $sqlUpdate);
    }

    public function Insert($usuario){
        if(!$this->VerificarEmail($usuario)){
                $usuario['senha'] = $this->EncryptPassword($usuario['senha']);
                $sqlInsert = "INSERT INTO usuarios (nome, email, senha, dataNascimento, telefone)
                    VALUES(
                        '{$usuario['nome']}',
                        '{$usuario['email']}',                    
                        '{$usuario['senha']}',
                        '{$usuario['dataNascimento']}',                    
                        '{$usuario['telefone']}'                    
                )";
            return mysqli_query($this->conexao, $sqlInsert);
        }
        return false;
    }
    
    
}