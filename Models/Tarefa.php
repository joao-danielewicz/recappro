<?php

class Tarefa{
    public int $idTarefa;
    public string $assunto;
    public string $pergunta;
    public string $resposta;
    public string $midiaPergunta;
    public string $midiaResposta;
    public DateTime $dataAdicao;
    public DateTime $dataProximoEstudo;
    public DateTime $dataUltimoEstudo;
    public int $nivelEstudo;
    public int $idCurso;

    public function __construct(int $idTarefa, string $assunto, string $pergunta, string $resposta, string $midiaPergunta, string $midiaResposta,
                                DateTime $dataAdicao,
                                DateTime $dataProximoEstudo,
                                DateTime $dataUltimoEstudo,
                                int $nivelEstudo, int $idCurso){
        $this->idTarefa=$idTarefa;
        $this->assunto=$assunto;
        $this->pergunta=$pergunta;
        $this->resposta=$resposta;
        $this->midiaPergunta=$midiaPergunta;
        $this->midiaResposta=$midiaResposta;
        $this->dataAdicao=$dataAdicao;
        $this->dataProximoEstudo=$dataProximoEstudo;
        $this->dataUltimoEstudo=$dataUltimoEstudo;
        $this->nivelEstudo=$nivelEstudo;
        $this->idCurso=$idCurso;
    }
}