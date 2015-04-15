<?php

    include_once("../dist/php/configBanco.php"); // Inclui o arquivo com a configuração do banco
	
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
							
							$result3 = mysql_query($sql3, $_SESSION['conexao']);
							
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
							
							$_SESSION['discSeg'] = $discSeg;
							$_SESSION['discTer'] = $discTer;
							$_SESSION['discQua'] = $discQua;
							$_SESSION['discQui'] = $discQui;
							$_SESSION['discSex'] = $discSex;
							$_SESSION['discSab'] = $discSab;
							$_SESSION['discDom'] = $discDom;
							
}

function defineAcordion(){

                                if (isset($_GET['andar'])) {
                                    $andar = $_GET['andar'];
                                }
                                $sql = "SELECT id, nome, parametro_imagem FROM categoria";

                                //$result = mysql_query($sql, $_SG['link']);
								$result = mysql_query($sql, $_SESSION['conexao']);
								
                                $i = 1; // o valor dos collapses parte de 1 para nao sobrescrever a area de pesquisas que e collapse 0
								
                                while ($consulta = mysql_fetch_array($result)) {
									
                                    echo "<li id=\"menuCategoria\">"; // cria a estrutura do menu de categoria
									echo "<a href=\"#\"><i class=\" {$consulta['parametro_imagem']} \"></i> $consulta[nome] <span class=\"fa arrow\"></span></a>";
											
                                    /* Escrever itens secundários do menu */

                                    //$sql2 = "SELECT  id, nome, andar FROM andar_locais WHERE fk_id_categoria = $consulta[id] ORDER BY andar";
									$sql2 = "SELECT
										sala.id, numero, descricao, andar
									FROM
										sala, info_locais
									WHERE
										sala.numero = info_locais.fk_numero_sala
									AND
										fk_id_categoria = $consulta[id]
									ORDER BY andar";

                                    //$result2 = mysql_query($sql2, $_SG['link']);
									$result2 = mysql_query($sql2, $_SESSION['conexao']);
									
                                    echo "<ul class=\"nav nav-second-level collapse\">"; // cria a estrutura dos itens de menu
										while ($consulta2 = mysql_fetch_array($result2)) {
											echo "<li>"; // cria o item de categoria
											//echo "<a href=\"#\" onclick=\"location.href='mapa.php?sala=$consulta2[numero]&andar=$consulta2[andar]'; \"> $consulta2[descricao]</a>\n";
											//echo "<a href=\"#\" onclick=\"atualizaMapa($consulta2[andar],$consulta2[numero])\"> $consulta2[descricao]</a>\n";

											echo "<a href=\"#\" onclick=\" insereMarker($consulta2[andar],$consulta2[numero]); \"> $consulta2[descricao]</a>\n";
											
											echo "</li>";
											
											// acrescenta cada descricao, andar e sala ao vetor associativo $nomeAndarNumero para uso do typeahead
											$nomeAndarNumero[] = array('descricao' => $consulta2['descricao'], 'andar' =>$consulta2['andar'], 'numero' =>$consulta2['numero']);
											
											// codifica o vetor em formato JSON
											//$JsonNomeAndarNumero = json_encode($nomeAndarNumero,JSON_FORCE_OBJECT);
											$JsonNomeAndarNumero = json_encode($nomeAndarNumero);
										}	
                                    echo "</ul>";
									
                                    echo "</li>";

                                    $i++;
                                }


}
						
?>

