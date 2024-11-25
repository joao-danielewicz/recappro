<?php

// Lê os bytes do arquivo da imagem passado através de um POST, retornando-os como uma string.
function pegarImagem(Array $files):string{
    $nome_img = $files['name'];
    $tipo_img = $files['type'];
    $tam_img = $files['size'];
    $midia = $files['tmp_name'];

    $fp = fopen($midia, "rb");
    $midia = fread($fp, $tam_img);
    $midia = addslashes($midia);
    fclose($fp);

    return $midia;
}