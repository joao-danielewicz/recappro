<?php

class Cosmetic{
    public int $idItem;
    public string $descricao;
    public string $tipo;
    public int $preco;
    public string $midia;

    public function __construct(int $idItem, string $descricao, string $tipo, int $preco, string $midia){
        $this->idItem = $idItem;
        $this->descricao = $descricao;
        $this->tipo = $tipo;
        $this->preco = $preco;
        $this->midia = $midia;
    }
}