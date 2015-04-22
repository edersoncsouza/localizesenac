<?php

//include("configBanco.php"); // Inclui o arquivo com a configuração do banco
	
function defineDiaSemana(){
	
    $diaPorExtenso = array("Domingo","segunda","Terça","Quarta","Quinta","Sexta","Sábado");
    date_default_timezone_set('America/Sao_Paulo');
    $diaAtual= date("w");
    $diaDaSemana = $diaPorExtenso[$diaAtual];
    
    echo $diaDaSemana;
}

function defineDisciplinas(){

	$sql3 = "SELECT
				fk_sala_fk_id_unidade AS UNIDADE, turno AS TURNO, aluno_disciplina.dia_semana AS DIA, aluno_disciplina.fk_numero_sala AS SALA, disciplina.nome AS DISC
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

	$semAulas = "Não tem aulas no dia de hoje"; // armazena o texto padrao para dias sem aula
	
	
	
	$discSeg = array();
	$discTer = array();
	$discQua = array();
	$discQui = array();
	$discSex = array();
	$discSab = array();
	$discDom = array();
	
	// inicializa as variaveis de aulas por semana
    $discSeg[] = $semAulas;
    $discTer[] = $semAulas;
    $discQua[] = $semAulas;
    $discQui[] = $semAulas;
    $discSex[] = $semAulas;
	$discSab[] = $semAulas;
	$discDom[] = $semAulas;
	
/*  incio do while para preencher os conteudos das pills */
	while ($row = mysql_fetch_assoc($result3)) {
		
		// monta a string com o local, turno, sala e disciplina do dia
		$discDia = "Unidade " . $row['UNIDADE'] . " - " ."Turno " . $row['TURNO'] . " - " ."Sala: ".$row['SALA'] . " - " . $row['DISC'];
		
		// se houver aulas cadastradas para o dia
        if ($row['DIA'] == "SEG") {		
			// se houver o texto padrao de "sem aulas" dentro do array reinstancia para zerar
			if (in_array($semAulas, $discSeg))
				$discSeg = array();
			// armazena a disciplina no array (necessario pois o aluno pode ter mais de uma disciplina no dia, em turnos diferentes)
			$discSeg[] = $discDia;
		}
        if ($row['DIA'] == "TER") {
			if (in_array($semAulas, $discTer))
				$discTer = array();

			$discTer[] = $discDia;
		}
        if ($row['DIA'] == "QUA") {
			if (in_array($semAulas, $discQua))
				$discQua = array();

			$discQua[] = $discDia;
		}
        if ($row['DIA'] == "QUI") {
			if (in_array($semAulas, $discQui))
				$discQui = array();
			
			$discQui[] = $discDia;
		}
        if ($row['DIA'] == "SEX") {
			if (in_array($semAulas, $discSex))
				$discSex = array();
			
			$discSex[] = $discDia;
		}
		if ($row['DIA'] == "SAB") {
			if (in_array($semAulas, $discSab))
				$discSab = array();
			
			$discSab[] = $discDia;
		}
		if ($row['DIA'] == "DOM") {
			if (in_array($semAulas, $discDom))
				$discDom = array();
			
			$discDom[] = $discDia;
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

	if (isset($_GET['andar'])) {$andar = $_GET['andar'];}
  
	$sql = "SELECT
				id, nome, parametro_imagem 
			FROM 
				categoria";
				
	$result = mysql_query($sql, $_SESSION['conexao']);

	//$i = 1; // o valor dos collapses parte de 1 para nao sobrescrever a area de pesquisas que e collapse 0

    while ($consulta = mysql_fetch_array($result)) {
	
        echo "<li id=\"menuCategoria\">"; // cria a estrutura do menu de categoria
			echo "<a href=\"#\"><i class=\" {$consulta['parametro_imagem']} \"></i> $consulta[nome] <span class=\"fa arrow\"></span></a>";

			/* Escrever itens secundarios do menu */

			$sql2 = "SELECT
						sala.id, numero, descricao, andar
					FROM
						sala, info_locais
					WHERE
						sala.numero = info_locais.fk_numero_sala
					AND
						fk_id_categoria = $consulta[id]
					ORDER BY
						andar";

			$result2 = mysql_query($sql2, $_SESSION['conexao']);
										
			echo "<ul class=\"nav nav-second-level collapse\">"; // cria a estrutura dos itens de menu
			
				while ($consulta2 = mysql_fetch_array($result2)) {
					
					echo "<li>"; // cria o item de categoria
						//echo "<a href=\"#\" onclick=\"location.href='mapa.php?sala=$consulta2[numero]&andar=$consulta2[andar]'; \"> $consulta2[descricao]</a>\n";
						//echo "<a href=\"#\" onclick=\"atualizaMapa($consulta2[andar],$consulta2[numero])\"> $consulta2[descricao]</a>\n";
						echo "<a href=\"#\" onclick=\" insereMarker($consulta2[andar],$consulta2[numero]); \"> $consulta2[descricao]	</a>\n";
					echo "</li>";

					// acrescenta cada descricao, andar e sala ao vetor associativo $nomeAndarNumero para uso do typeahead
					$nomeAndarNumero[] = array('descricao' => $consulta2['descricao'], 'andar' =>$consulta2['andar'], 'numero' =>$consulta2['numero']);

					// codifica o vetor em formato JSON
					//$JsonNomeAndarNumero = json_encode($nomeAndarNumero,JSON_FORCE_OBJECT); // modo forcado
					$JsonNomeAndarNumero = json_encode($nomeAndarNumero);
					
					// armazena o vetor em uma variavel de sessao
					$_SESSION['JsonNomeAndarNumero'] = $JsonNomeAndarNumero;
					
				}
				
			echo "</ul>";
	
        echo "</li>";

        //$i++;
    }
}
	
?>

