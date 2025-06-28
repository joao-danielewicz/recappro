<?php

require_once "Utils.php";

class CosmeticsOnDatabase{
    private $conexao;
    
    public function __construct($bdServidor = 'localhost', $bdUsuario = 'root', $bdSenha = 'root', $bdBanco = 'recappro', $port = '3306'){
        
        $this->conexao = mysqli_connect($bdServidor, $bdUsuario, $bdSenha, $bdBanco, $port);
    }
    
    
    public function SelectAllCosmetics(){
        $sqlBusca = "SELECT * FROM itensCosmeticos";
        $resultado = mysqli_query($this->conexao, $sqlBusca);
        
        $cursos = [];
        while($curso = mysqli_fetch_assoc($resultado)){
            $cursos[] = $curso;
        }
        
        return $cursos;
    }

    public function Insert($itemCosmetico){
        $itemCosmetico['midia'] = pegarImagem($_FILES['midia']);

        $sqlInsert = "INSERT INTO itensCosmeticos (descricao, tipo, preco, midia)
                        VALUES(
                        '{$itemCosmetico['descricao']}',
                        '{$itemCosmetico['tipo']}',
                        '{$itemCosmetico['preco']}',
                        '{$itemCosmetico['midia']}'
                    )";
        return mysqli_query($this->conexao, $sqlInsert);
    }
    
    public function Update($item){
        $sqlUpdate = "UPDATE itensCosmeticos SET 
                    descricao = '{$item['descricao']}',
                    tipo = '{$item['tipo']}',
                    preco = '{$item['preco']}'";

        if(!empty($_FILES['midia']['name'])){
            $item['midia'] = pegarImagem($_FILES['midia']);
            $sqlUpdate .= ", midia = '{$item['midia']}'";
        }

        $sqlUpdate .= " WHERE idItem = '{$item['idItem']}'";
        return mysqli_query($this->conexao, $sqlUpdate);
    }

    public function ComprarItem($idItem, $idUsuario){
        $sqlBusca = "SELECT qtdPontos FROM usuarios WHERE idUsuario = '{$idUsuario}'";
        $resultado = mysqli_query($this->conexao, $sqlBusca);
        $saldoPontos = mysqli_fetch_row($resultado)[0];

        $sqlBusca = "SELECT preco FROM itensCosmeticos WHERE idItem = '{$idItem}'";
        $resultado = mysqli_query($this->conexao, $sqlBusca);
        $precoItem = mysqli_fetch_row($resultado)[0];

        if($saldoPontos >= $precoItem){
            try{
                $sqlInsert = "INSERT INTO itensInventario (idItem, idInventario)
                        values (
                        '{$idItem}',
                        (SELECT idInventario FROM inventarios where inventarios.idUsuario = '{$idUsuario}'))";
                $resultado = mysqli_query($this->conexao, $sqlInsert);
                
                $sqlUpdate = "UPDATE usuarios SET qtdPontos = qtdPontos - '{$precoItem}' WHERE idUsuario = '{$idUsuario}'";
                $resultado = mysqli_query($this->conexao, $sqlUpdate);

                return "Item adquirido com sucesso! Verifique sua página de perfil.";
            }catch(Exception $e){
                return "Você já possui este item.";
            }
        }else{
            return "Saldo insuficiente.";
        }
    }
    
    public function Delete($item){
        $sqlDelete = "DELETE FROM itensCosmeticos WHERE idItem = '{$item['idItem']}'";
        return mysqli_query($this->conexao, $sqlDelete);
    }
}