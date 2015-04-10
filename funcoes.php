<?php

function defineDiaSemana(){

    $diaPorExtenso = array("Domindo","segunda","Terça","Quarta","Quinta","Sexta","Sábado");
    date_default_timezone_set('America/Sao_Paulo');
    $diaAtual= date("w");
    $diaDaSemana = $diaPorExtenso[$diaAtual];
    
    echo $diaDaSemana;

}

?>

