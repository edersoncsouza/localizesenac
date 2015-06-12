<?php

function httpPost($url,$params){
  $postData = '';

  // cria o arquivo de log de erros
  $fp = fopen(dirname(__FILE__).'/../../logs/errorlog.txt', 'w');

  //create name value pairs separated by &
   foreach($params as $k => $v) 
   { 
      $postData .= $k . '='.$v.'&'; 
   }
   rtrim($postData, '&');
 
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_HEADER, false); 
    curl_setopt($ch, CURLOPT_POST, count($postData));
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
 
	// define verbosidade para verificar erros no curl
	curl_setopt($ch, CURLOPT_VERBOSE, true);
	// define a saida de erros
	curl_setopt($ch, CURLOPT_STDERR, $fp);
 
    $output=curl_exec($ch);
 
    curl_close($ch);
    return $output;
 
}

function enviaEmail($corpo, $destinatario, $nome){

	require_once("../phpmailer/class.phpmailer.php");
	include_once("../phpmailer/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

	$mail             = new PHPMailer();

	/*
	$body             = file_get_contents('contents.html');
	$body             = eregi_replace("[\]",'',$body);
	*/
	$body = $corpo;
	
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host       = "mx1.hostinger.com.br"; // SMTP server
	$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
											   // 0 = no messages
											   // 1 = errors and messages
											   // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
	$mail->Username   = "localizesenac@gmail.com";  // GMAIL username
	$mail->Password   = "N1kolatesla";            // GMAIL password

	$mail->SetFrom('localizesenac@gmail.com', 'LocalizeSenac');

	$mail->AddReplyTo('localizesenac@gmail.com',"LocalizeSenac");

	$mail->Subject    = retiraAcentos($corpo);

	$mail->AltBody    = $body; // optional, comment out and test

	$mail->MsgHTML($body);

	$address = $destinatario;
	$mail->AddAddress($address, $nome);

	if(!$mail->Send()) {
	  echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	  echo "Message sent!";
	}
	
}

function enviaEmailSilencioso($corpo, $destinatario, $nome){

	require_once("../phpmailer/class.phpmailer.php");
	include_once("../phpmailer/class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

	$mail             = new PHPMailer();

	/*
	$body             = file_get_contents('contents.html');
	$body             = eregi_replace("[\]",'',$body);
	*/
	$body = $corpo;
	
	$mail->IsSMTP(); // telling the class to use SMTP
	$mail->Host       = "mx1.hostinger.com.br"; // SMTP server
	$mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
											   // 0 = no messages
											   // 1 = errors and messages
											   // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
	$mail->Username   = "localizesenac@gmail.com";  // GMAIL username
	$mail->Password   = "N1kolatesla";            // GMAIL password

	$mail->SetFrom('localizesenac@gmail.com', 'LocalizeSenac');

	$mail->AddReplyTo('localizesenac@gmail.com',"LocalizeSenac");

	$mail->Subject    = retiraAcentos($corpo);

	$mail->AltBody    = $body; // optional, comment out and test

	$mail->MsgHTML($body);

	$address = $destinatario;
	$mail->AddAddress($address, $nome);

	if(!$mail->Send()) {
	  echo "Mailer Error: " . $mail->ErrorInfo;
	} else {
	  echo "Message sent!";
	}
	
}

function imprimeSessao(){
    //session_start();
    echo "<h3> PHP List All Session Variables</h3>";
	echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
	
}

function retiraAcentos($texto){
	$retorno="";
	
	$retorno = preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $texto ) );
	
	return $retorno;
}

function defineDiaSemana(){
	
    $diaPorExtenso = array("Domingo","segunda","Terça","Quarta","Quinta","Sexta","Sábado");
    date_default_timezone_set('America/Sao_Paulo');
    $diaAtual= date("w");
    $diaDaSemana = $diaPorExtenso[$diaAtual];
    
    echo $diaDaSemana;
}

// retorna o dia da semana semi-estendido a partir do nome abreviado
// ex.: retorna domingo para DOM
function getNomeDiaSemana($data) {
	$apelidoDiaSemana = ["DOM","SEG","TER","QUA","QUI","SEX","SAB"];
	$nomeDiaSemana = ["domingo","segunda","terça","quarta","quinta","sexta","sábado"];
	
	$indice = array_search($data, $apelidoDiaSemana);
	$retornoNomeDiaSemana = $nomeDiaSemana[$indice];
	
	return $retornoNomeDiaSemana;
	
}

// fornece o dia da semana abreviado a partir de uma data no formato AAAA-MM-DD
function getDiaSemana($data) {
    list($ano, $mes, $dia) = explode('-', $data);
 
    $diasemana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));
 
    switch ($diasemana) {
        case 0: $diasemana = "DOM";
            break;
        case 1: $diasemana = "SEG";
            break;
        case 2: $diasemana = "TER";
            break;
        case 3: $diasemana = "QUA";
            break;
        case 4: $diasemana = "QUI";
            break;
        case 5: $diasemana = "SEX";
            break;
        case 6: $diasemana = "SAB";
            break;
    }
 
    return $diasemana;
}

function getDataDiaDaSemana($diaDaSemana){
	
	$diaAtual = date('Y-m-d'); // instancia e define a mascara da data do dia atual
	
	$diaSemanaAtual = getDiaSemana($diaAtual); // busca e armazena o dia da semana atual
	
	// laco de 0 a 6 para percorrer todos os dias da semana e definir a data do atual ou proximo dia da semana
	for ($i = 0; $i < 7; $i++) { 
		
		$diaAtual = date('Y-m-d', strtotime("+".$i." days")); // incrementa o dia atual com a variavel $i
		$diaSemanaAtual = getNomeDiaSemana(getDiaSemana($diaAtual)); // atualizar a variavel diaSemanaAtual (pega o dia abrevidado pela data, pega o dia estendido pelo dia abreviado)
		
		if($diaSemanaAtual == $diaDaSemana){ // verifica se o dia da semana atual e igual ao dia recebido como parametro
			$dataDoEvento = $diaAtual; // varivel de data do evento recebe a data do proximo dia da semana correspondente
			$i = 7; // forca a saida do FOR
		}
	}
	
	return $dataDoEvento;
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
	
	$arrayDiasComDisciplinas = [];
	
/*  incio do while para preencher os conteudos das pills */
	while ($row = mysql_fetch_assoc($result3)) {
		
		// monta a string com o local, turno, sala e disciplina do dia
		$discDia = "Unidade " . $row['UNIDADE'] . " - " ."Turno " . $row['TURNO'] . " - " ."Sala: ".$row['SALA'] . " - " . $row['DISC'] .";";
		
		// se houver aulas cadastradas para o dia
        if ($row['DIA'] == "SEG") {		
			// se houver o texto padrao de "sem aulas" dentro do array reinstancia para zerar
			if (in_array($semAulas, $discSeg))
				$discSeg = array();
			// armazena a disciplina no array (necessario pois o aluno pode ter mais de uma disciplina no dia, em turnos diferentes)
			$discSeg[] = $discDia;
			$arrayDiasComDisciplinas[] = $row['DIA']; // se existe disciplina no dia, armazena no array
		}
        if ($row['DIA'] == "TER") {
			if (in_array($semAulas, $discTer))
				$discTer = array();

			$discTer[] = $discDia;
			$arrayDiasComDisciplinas[] = $row['DIA']; // se existe disciplina no dia, armazena no array
		}
        if ($row['DIA'] == "QUA") {
			if (in_array($semAulas, $discQua))
				$discQua = array();

			$discQua[] = $discDia;
			$arrayDiasComDisciplinas[] = $row['DIA']; // se existe disciplina no dia, armazena no array
		}
        if ($row['DIA'] == "QUI") {
			if (in_array($semAulas, $discQui))
				$discQui = array();
			
			$discQui[] = $discDia;
			$arrayDiasComDisciplinas[] = $row['DIA']; // se existe disciplina no dia, armazena no array
		}
        if ($row['DIA'] == "SEX") {
			if (in_array($semAulas, $discSex))
				$discSex = array();
			
			$discSex[] = $discDia;
			$arrayDiasComDisciplinas[] = $row['DIA']; // se existe disciplina no dia, armazena no array
		}
		if ($row['DIA'] == "SAB") {
			if (in_array($semAulas, $discSab))
				$discSab = array();
			
			$discSab[] = $discDia;
			$arrayDiasComDisciplinas[] = $row['DIA']; // se existe disciplina no dia, armazena no array
		}
		if ($row['DIA'] == "DOM") {
			if (in_array($semAulas, $discDom))
				$discDom = array();
			
			$discDom[] = $discDia;
			$arrayDiasComDisciplinas[] = $row['DIA']; // se existe disciplina no dia, armazena no array
		}
	}

	$_SESSION['discSeg'] = $discSeg;
	$_SESSION['discTer'] = $discTer;
	$_SESSION['discQua'] = $discQua;
	$_SESSION['discQui'] = $discQui;
	$_SESSION['discSex'] = $discSex;
	$_SESSION['discSab'] = $discSab;
	$_SESSION['discDom'] = $discDom;
	
	$_SESSION['arrayDiasComDisciplinas'] = $arrayDiasComDisciplinas;
	
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
	
        echo "<li id=\"menuCategoria\" class=\"\">"; // cria a estrutura do menu de categoria
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
						echo "<a href=\"#\" onclick=\" mudaAndarMapa($consulta2[andar]); insereMarker($consulta2[andar],$consulta2[numero]); \"> $consulta2[descricao]	</a>\n";
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


function existeLembrete($tipoLembrete){

	// monta a query de pesquisa de lembretes do tipo fornecido
	$sql = "SELECT
				aluno_lembrete.id
			FROM
				aluno_lembrete, aluno
			WHERE
				matricula = \"{$_SESSION['usuarioLogin']}\"
			AND
				tipo = \"{$tipoLembrete}\"";
				
	// executa a query para verificar se o aluno possui lembretes do tipo fornecido
	$result = mysql_query($sql) or die("Erro na operação:\n Erro número:".mysql_errno()."\n Mensagem: ".mysql_error());
	
	if(mysql_num_rows($result) > 0) // se houverem lembretes do tipo fornecido
		return true;
	else
		return false;
}
	
?>

