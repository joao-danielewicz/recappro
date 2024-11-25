<?php 
class Database{
    private $conexao;

    public function __construct($bdServidor = 'localhost', $bdUsuario = 'root', $bdSenha = 'root', $bdBanco = 'recappro', $port = '3306'){
        $this->conexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco, $port);
    }
}