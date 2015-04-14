<?php
    include("seguranca.php"); // Inclui o arquivo com o sistema de segurança
	//$link = mysql_connect('localhost', 'root', 'usbw') or die;
	//mysql_select_db('localizesenac', $link) or die;	
	
function defineDiaSemana(){

    $diaPorExtenso = array("Domingo","segunda","Terça","Quarta","Quinta","Sexta","Sábado");
    date_default_timezone_set('America/Sao_Paulo');
    $diaAtual= date("w");
    $diaDaSemana = $diaPorExtenso[$diaAtual];
    
    echo $diaDaSemana;

}

function defineDisciplinas(){

							$sql3 = "SELECT
								aluno_disciplina.dia_semana AS DIA, aluno_disciplina.fk_numero_sala AS SALA, disciplina.nome AS DISC
							FROM
								aluno_disciplina, disciplina, aluno
							WHERE
								aluno.id = aluno_disciplina.fk_id_aluno
							AND
								disciplina.id = aluno_disciplina.fk_id_disciplina
							AND
								aluno_disciplina.fk_id_aluno=" . $_SESSION['usuarioID'] . " ORDER BY aluno_disciplina.id";
							
							$result3 = mysql_query($sql3, $_SG['link']);
							
							$contDiscp = mysql_num_rows($result3);
							$_SESSION['contDiscp'] = $contDiscp; // passa a varivel para a sessão
							
                            $discSeg = "Não tem aulas no dia de hoje";
                            $discTer = "Não tem aulas no dia de hoje";
                            $discQua = "Não tem aulas no dia de hoje";
                            $discQui = "Não tem aulas no dia de hoje";
                            $discSex = "Não tem aulas no dia de hoje";
							$discSab = "Não tem aulas no dia de hoje";
							$discDom = "Não tem aulas no dia de hoje";

                            /*  incio do while para preencher os conteudos das pills */
                            
							while ($row = mysql_fetch_assoc($result3)) {
                                if ($row['DIA'] == "SEG") {
                                    $discSeg = $row['SALA'] . " - " . $row['DISC'];
                                }
                                if ($row['DIA'] == "TER") {
                                    $discTer = $row['SALA'] . " - " . $row['DISC'];
                                }
                                if ($row['DIA'] == "QUA") {
                                    $discQua = $row['SALA'] . " - " . $row['DISC'];
                                }
                                if ($row['DIA'] == "QUI") {
                                    $discQui = $row['SALA'] . " - " . $row['DISC'];
                                }
                                if ($row['DIA'] == "SEX") {
                                    $discSex = $row['SALA'] . " - " . $row['DISC'];
                                }
								if ($row['DIA'] == "SAB") {
                                    $discSab = $row['SALA'] . " - " . $row['DISC'];
                                }
								if ($row['DIA'] == "DOM") {
                                    $discDom = $row['SALA'] . " - " . $row['DISC'];
                                }
								
                            }
}

?>

