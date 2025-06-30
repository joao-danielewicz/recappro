<?php

class Curso{
    public int $idCurso;
    public string $nome;
    public string $areaConhecimento;
    public DateTime $dataAdicao;
    public int $quantidadeNovasTarefas;
    public int $idUsuario;

    public function __construct(int $idCurso, string $nome, string $areaConhecimento, DateTime $dataAdicao,
                                int $quantidadeNovasTarefas, int $idUsuario){
        $this->idCurso=$idCurso;
        $this->nome=$nome;
        $this->areaConhecimento=$areaConhecimento;
        $this->dataAdicao=$dataAdicao;
        $this->quantidadeNovasTarefas=$quantidadeNovasTarefas;
        $this->idUsuario=$idUsuario;
    }
}