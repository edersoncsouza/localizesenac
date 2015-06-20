<!--								

PENDENCIAS LOCAIS:

-->

<!DOCTYPE HTML>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="LocalizeSenac - Sistema de Indoor Mapping para a Faculdade Senac Porto Alegre">
	<meta name="keywords" content="Indoor Mapping,mapeamento interno,Faculdade Senac Porto Alegre">
    <meta name="author" content="Ederson Souza">

    <title>LocalizeSenac 2.0 - Indoor Mapping da Faculdade Senac Porto Alegre</title>
<?php
/*
		<!-- formValidation -->
        <link rel="stylesheet" 		   href="dist/components/formValidation/dist/css/formValidation.css"/>
        <script type="text/javascript" src="dist/components/formValidation/dist/js/formValidation.js"/>
        <script type="text/javascript" src="dist/components/formValidation/dist/js/framework/bootstrap.js"/>

        <!-- Configuracao para validação dos formularios -->
        <script type="text/javascript" src="dist/js/configFormValidation.js" />
*/

	include("dist/php/seguranca.php"); // Inclui o arquivo com o sistema de segurança
	include("dist/php/funcoes.php");
	protegePagina(); // Chama a função que protege a página
    mysql_set_charset('UTF8', $_SG['link']);
	//imprimeSessao();
	
	echo "<script> var idP = {$_SESSION['usuarioID']}; </script>";
	
	$sql = "SELECT nome, email, celular FROM aluno WHERE id=".$_SESSION['usuarioID'];
	
	$result = mysql_query($sql, $_SESSION['conexao']);
	
	while ($row = mysql_fetch_assoc($result)) {
		$nome = $row['nome'];
		$email = $row['email'];
		$celular = $row['celular'];
	}
?>			

		<!-- Bootstrap Core CSS -->
        <link href="dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Custom Fonts -->
        <link href="dist/components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">	
		
		<!-- Custom CSS -->
		<link href="dist/css/sb-admin-2.css" rel="stylesheet">
		
		<!-- CSS para animacoes Ajax -->
		<link href="dist/css/ajax.css" rel="stylesheet">
		
	    <!-- jQuery -->
        <script src="dist/components/jquery/dist/jquery.min.js"></script>
		
		<!-- RobinHerbots/jquery.inputmask: https://github.com/RobinHerbots/jquery.inputmask -->
		<script type="text/javascript" src="dist/components/jquery.inputmask/jquery.inputmask.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="dist/components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
		
		<!-- Bootbox -->
		<script src="dist/components/bootbox/dist/js/bootbox.min.js" type="text/javascript"></script>
		
		<!-- funcoes personalizadas -->
		<script type="text/javascript" src="dist/js/funcoes.js"></script>
		
<script>
	$(document).ready(function(){
	
	//$("#testeIcloud").load("icloud_calendar/addons/icloud-master/PHP/testeIcloud.php");
	
		// exibe a animacao de carregando cada vez que uma requisicao Ajax ocorrer
		$body = $("body");
		$(document).on({
			ajaxStart: function() { $body.addClass("carregando");    },
			 ajaxStop: function() { $body.removeClass("carregando"); }    
		});
	
		// seleciona a guia academico
		$('.academico').click();
	
		// ao clicar nos botoes de sair encaminha de volta ao principal.php
		$('#sairSenha, #sairInfo, #sairDisciplina').click( function() {
			var url = "principal.php";
			$("body").load(url);
		});
		
		// carrega o calendario da semana
		carregaCalendarioSemana();

// CONFIGURACOES PARA A GUIA PERFIL
		
		// mascara para o celular
		$('#celular').inputmask('(99) 9999-9999[9]');

		// captura o evento submit do formMudaInfo e chama a funcao atualizaInfo
		$("#formMudaInfo").submit(function (event) {
			
			event.preventDefault(); // impede o submit

			//var idP = <?php $_SESSION['usuarioID'];?>; // esta informação esta sendo trazida no start do PHP
			var nomeP = $("#nome").val(); // recebe o valor do input de nome
			var emailP = $("#email").val(); // recebe o valor de input de email
			var celularP = $("#celular").val(); // recebe o valor de input de celular
			var emailConfirmacao = $("#confirmaEmail").val();
			
			// verifica se a confirmacao de email esta OK
			if(emailP!==emailConfirmacao){
				bootbox.alert('Os emails não conferem!');
			}
			else{			
				atualizaInfo(nomeP, emailP, celularP); // chama a funcao para atualizar as informacoes
			}
			
			console.log("(#formMudaInfo).submit: saindo do submit do form");
			
		});

		//ocultaAreaSeguranca(); // chama a funcao que oculta a guia de segurança para os usuários do google e facebook
		
// CONFIGURACOES PARA A GUIA SEGURANCA

		// captura o evento submit do formMudaSenha e chama a funcao atualizaSenha
		$("#formMudaSenha").submit(function (event) {
			
			event.preventDefault(); // impede o submit

			//var idP = <?php $_SESSION['usuarioID'];?>; // esta informação esta sendo trazida no start do PHP
			var senhaAtualP = $("#passwordAtual").val(); // recebe o valor do input de senha atual
			var senhaP = $("#password").val(); // recebe o valor de input de nova senha
			var senhaConfirmacao = $("#password2").val();
			
			// verifica se a confirmacao de senha esta OK
			if(senhaP!==senhaConfirmacao){
				bootbox.alert('As novas senhas não conferem!');
			}
			else			
				atualizaSenha(senhaAtualP, senhaP); // chama a funcao para atualizar a senha
		});
		
// CONFIGURACOES GUIA ACADEMICO - QUADRO DE DIALOGO DE INSERIR DISCIPLINAS
		
		// captura o evento onChange do select box CURSO
		$('#curso').on('change', function() {
		  
		  var cursoP = this.value; // armazena o id do curso
		  
		  montarGrade(cursoP); // chama a funcao para montar a grade
		  
		});
		
		// captura a alteracao no value do input de ANDAR
		$("input#inputAndarDisciplina").bind("input", function() {
		  
		  $('#sala').empty(); // zera os itens previos do select sala
		  
		  var andarP = this.value; // armazena o andar
		  var unidadeP = $("#unidade").val(); // armazena a unidade

		  montarAndar(andarP, unidadeP); // chama a funcao para montar a grade
		  
		});
	
		// captura o evento onChange do select box UNIDADE
		$('#unidade').on('change', function() {
			
			$('#sala').empty(); // zera os itens previos do select sala
			
			var andarP = $("input#inputAndarDisciplina").val(); // substituida a linha abaixo na madrugada
			var unidadeP = this.value;
			
			montarAndar(andarP, unidadeP);				
			
		});
		
		// captura o evento submit do formMudaDisciplina e chama a funcao atualizaDisciplina
		$("#formMudaDisciplina").submit(function (event) {
			
			event.preventDefault(); // impede o submit

			//var idP = <?php $_SESSION['usuarioID'];?>; // esta informação esta sendo trazida no start do PHP
			var disciplinaP = $("#disciplina").val(); // recebe o valor do input de disciplina
			var unidadeP = $("#unidade").val(); // recebe o valor de input de unidade
			var turnoP = $("#turno").val(); //recebe o valor do select de turno
			var andarP = $("input#inputAndarDisciplina").val(); // recebe o valor de input de andar
			var salaP = $("#sala").val(); // recebe o valor do select de sala
			
			var palavras = $(".modal-title").text().split(" "); // armazena as palavras do titulo do modal em um array
			
			// pega a terceira palavra, apenas os tres primeiros caract e tira acentuacoes da letra A maiuscula e armazena
			var diaP = palavras[2].substring(0, 3).replace(/[ÀÁÂÃÄÅ]/g,"A");
			
			// chama a funcao para atualizar ou inserir a disciplina no dia
			atualizaDisciplina(disciplinaP, unidadeP, turnoP, andarP, salaP, diaP);

		});

// CONFIGURACOES GUIA ACADEMICO - QUADRO DE DIALOGO ICLOUD
		
			// envia os campos para testar a conexao com o iCloud
			$("#botaoTestarIcloud").click(function () {
				
				var url = 'icloud_calendar/addons/icloud-master/PHP/testeIcloud.php';
				
				var usuarioIcloudP = $('#usuarioIcloud').val(); // recebe o usuario do inputbox
				var senhaIcloudP = $('#senhaIcloud').val(); // recebe a senha do inputbox
				
				bootbox.alert("usuario do icloud: " + usuarioIcloudP);
				
				// executa o post dos campos em testeIcloud recebe como retorno ...
				$.post(url,{ appleID: usuarioIcloudP, pw: senhaIcloudP }, function(retorno) {
					if (retorno == 0){// caso o retorno de testeIcloud.php seja = 0
						//bootbox.alert('Erro no envio de parâmetros!');
						console.log("Erro na verificação das informações no iCloud!\n"+retorno); // envia para o console o aviso de problemas
						bootbox.alert("Problemas na autenticação, revise o usuário e senha!"); // avisa o usuario de que ocorreu um problema
					}
					else{
						//console.log("Informações OK!\n"+retorno); // envia para o console o aviso de OK
						bootbox.alert("Autenticado no iCloud com sucesso!"); // avisa o usuario que a autenticacao foi confirmada
						$('#usuarioIcloud').prop('disabled', true); // desabilita a inputbox de usuario
						$('#senhaIcloud').prop('disabled', true); // desabilita a inputbox de senha
						var objJsonIcloud = JSON.parse(retorno); // transforma a string recebida em objeto
						//bootbox.alert(objJsonIcloud.usuario); 
						//bootbox.alert(objJsonIcloud.senha); 
						var idIcloudP = objJsonIcloud.id; // armazena o id do usuario iCloud
					}
				});
			});
			
		
			
	}); //documentReady

			// funcao que busca as disciplinas do aluno no dia da semana fornecido (diaP) e enxerta a string no modal de dialogo
			function buscarDisciplinasDia(diaP){
				var url = "dist/php/buscarDisciplinasDia.php";
				
				// executa o post enviando o parametro dia
				// recebe como retorno um json com as disciplinas (diaJson)
				$.post(url,{ dia: diaP }, function(diaJson) {
					
					if (diaJson == 0){// caso o retorno de buscarDisciplinasDia.php seja = 0
						bootbox.alert('Erro no envio de parâmetros!');
					}
					else{
							var objJson = JSON.parse(diaJson); // transforma a string recebida em objeto
							var listaItens=""; // cria uma lista de itens para inserir uma única vez
							
							var i=1;
							$.each(objJson, function(index, value) { // para cada objeto da lista armazena na string
								
								// monta a string com as checkbox para cada disciplina
								listaItens+='<div class="checkbox">'+
												'<label for="disciplina' + i + '">'+
													'<input type="checkbox" name="disciplina" id="disciplina' + i + '" value="disciplina' + i + '"> ' + value+
												'</label>'+
											'</div>';
								i++;
							});
						

						// exibe o formulario de exclusao em um modal bootbox
						bootbox.dialog({
								title: "Selecione a(s) disciplina(s) a excluir",
								message: '<div class="row">  ' +
											'<div class="col-md-12"> ' +
												'<form class="form-horizontal"> ' +
													'<div class="form-group"> ' +
														'<div id="bootboxDialogDisciplinas" class="col-md-12">' +
															// o conteudo das disciplinas vem aqui
														'</div> ' +
													'</div>'+
												'</form>'+
											'</div>'+
										'</div>',
								buttons: {
									success: {
										label: "Excluir",
										className: "btn-danger",
										callback: function () { // caso clique no botao excluir executa a funcao
											// pega os labels dos inputs marcados na div bootboxDialogDisciplinas e para cada...
											$('#bootboxDialogDisciplinas input:checked').each(function() {

												// armazena o texto do LABEL que contem Unidade, Turno, Sala e Disciplina
												var unidadeTurnoSalaDisciplina = $("label[for='"+$(this).val()+"']").text(); 
												
												// separar Unidade, Turno, Sala e Disciplina pelo caracter "-"
												var palavras = unidadeTurnoSalaDisciplina.split("-"); // armazena as palavras em um array
				
												// pega a segunda palavra, apenas o caract a duas posicoes do fim, pois o fim é um espaço branco
												var turnoP = palavras[1].charAt(palavras[1].length-2);
												
												// chama a funcao javascript que acionara a funcao php que excluira a disciplina
												excluirDisciplinaGrade(diaP, turnoP);

											});
											
											// atualiza a grade de aulas
											//window.location.reload();
										}
									},
									main: {
									  label: "Sair",
									  className: "btn-primary",
									  callback: function() { // caso clique no botao sair executa a funcao
										//var url = "principal.php";
										//$("body").load(url);
										bootbox.alert("Ufa...");
									  }
									}
								}
								
						});
							// enxerta o conteudo das checkboxs no modal de dialogo, na area de conteudo, dentro do corpo
							//$('.modal-dialog>modal-content>modal-body').append(listaItens); 
							
							// enxerta o conteudo das checkboxs na area bootboxDialogDisciplinas do modal de diálogo,
							//if(!retornoP) // se nao pede retorno - apenas processo de excluir disciplina por enquanto
							
							$('#bootboxDialogDisciplinas').append(listaItens);
							
							//else // se pedir retorno
							return objJson; // retorna o json de objetos disciplina em uma unica string
					}
					
				});
			}

			// funcao que busca as disciplinas do aluno no dia da semana fornecido (diaP) e retorna em formato Json
			function buscarDisciplinasDiaJson(diaP){
				var url = "dist/php/buscarDisciplinasDiaJson.php";
				var retorno;
				
				// executa o post enviando o parametro dia
				// recebe como retorno um json com as disciplinas (diaJson)
				$.post(url,{ dia: diaP }, function(diaJson) {
					
					if (diaJson == 0){// caso o retorno de buscarDisciplinasDia.php seja = 0
						bootbox.alert('Erro no envio de parâmetros!');
					}
					else{
						console.log("Estou no buscarDisciplinasDiaJson, aqui diaJson e: "+diaJson);
					}
					
					retorno = diaJson;
					
				});
				return retorno; // retorna o json de objetos disciplina
			}

			
			// funcao que executa o post dia e do turno para excluir a disciplina da grade por jQuery
			function excluirDisciplinaGrade(diaP, turnoP){
					
				var url = "dist/php/excluirDisciplinaGrade.php";
					
				// executa o post enviando os parametros Id de usuario, dia da semana e turno da disciplina
				$.post(url,{ id: idP, dia: diaP, turno: turnoP }, function(json) {
					
					if (json == 0){// caso o retorno de excluirDisciplinaGrade.php seja = 0
						bootbox.alert('Erro no envio de parâmetros!');
					}
					else{
							bootbox.alert('Disciplina removida da grade com sucesso!',
												function() {// apos OK executa a funcao
														
														$('#configAluno').load( "configAluno.php" );
														
												});
					}
				});

			}
		
			// funcao que executa o post do curso para montar o select de disciplinas por jQuery
			function montarGrade(cursoP){

				var url = "dist/php/montarGrade.php";
				
				$('#disciplina').empty(); // zera os itens previos de select
				
				// executa o post enviando o parametro curso
				$.post(url,{ curso: cursoP }, function(json) {
					
					if (json == 0){ // caso o retorno de montarGrade.php seja = 0
						bootbox.alert('Erro no envio de parâmetros!');
					}
					else{
						var objJson = JSON.parse(json); // transforma a string recebida em objeto

						var listaItens; // cria uma lista de itens para inserir uma unica vez
						var nomeDisciplina;
						var idDisciplina;
							
						$.each(objJson, function() { // para cada registro no Json {objJson[0].id ou objJson[0].nome
						  $.each(this, function(name, value) { // utiliza o nome da chave e o valor ex: [nome]: [algoritmos]
							
							if(name == 'nome') // caso seja a propriedade nome, armazena na variavel de nome
								nomeDisciplina=value;
							else // senao armazena na variavel de id
								idDisciplina=value;
						  });
						  // monta o option de cada disciplina com os valores de nome e id
						  listaItens += '<option value=\"'+idDisciplina+'\">' + nomeDisciplina + '</option>';
						});

						$('#disciplina').append(listaItens); // enxerta o conteudo da select disciplina
					}
				});
			}
		
			// funcao que executa o post do andar para montar o select de salas por jQuery
			function montarAndar(andarP, unidadeP){

				var url = "dist/php/montarAndar.php";
				
				// executa o post enviando os parametros id, passwordAtual, password
				$.post(url,{ andar: andarP, unidade: unidadeP}, function(json) {
					
					if (json == 0){// caso o retorno de montarGrade.php seja = 0
						//bootbox.alert('Não existem salas neste andar!');
					}
					else{
							var objJson = JSON.parse(json); // transforma a string recebida em objeto
							var listaItens; // cria uma lista de itens para inserir uma única vez
							
							$.each(objJson, function(index, value) { // para cada objeto da lista armazena na string
								listaItens += '<option>' + value + '</option>';
							});
							
							$('#sala').append(listaItens); // faz enxerta o conteudo da select disciplina
					}
				});
			}
		
			// funcao que executa o post da id, da senha atual e da nova senha para modificar por jQuery
			function atualizaSenha(senhaAtualP, senhaP){

				var url = "dist/php/mudarSenha.php";
				
				// executa o post enviando os parametros id, passwordAtual, password
				$.post(url,{ id: idP, passwordAtual: senhaAtualP,  password: senhaP}, function(result) {

					if (result == 1){// caso o retorno de mudarSenha.php seja = 1, o processo foi OK
						bootbox.alert('Senha alterada com sucesso!');
						
						$("#passwordAtual").val(''); // zera os valores dos inputs de senha
						$("#password").val('');
						$("#password2").val('');
					}
					else{
						bootbox.alert('A senha não pode ser alterada!');
					}
					
				});
				
			}
			
			// funcao que executa o post da id, da senha atual e da nova senha para modificar por jQuery
			function atualizaInfo(nomeP, emailP, celularP){

				var url = "dist/php/mudarInfo.php";
				
				// executa o post enviando os parametros id, passwordAtual, password
				$.post(url,{ id: idP, nome: nomeP, email: emailP,  celular: celularP}, function(result) {

					if (result == 1){ // caso o retorno de mudarInfo.php seja = 1, o processo foi OK

						bootbox.alert('Informações atualizadas com sucesso!', 
										function() { // apos OK executa a funcao
										  //$('#configuracoes').trigger( "click" );
											$('#configAluno').load( "configAluno.php" );
										}
						);
					
												  
						console.log("Função atualizaInfo: Vou verificar ('celular').val(): ");
						console.log($('#celular').val());
						
						if($('#celular').val() != ""){ // caso o usuario tenha cadastrado celular
							$('.lembrarZenvia').prop("disabled", false); // habilita os checkboxes para receber sms
							//$('.checkboxesZenvia').tooltip("disabled"); // remove as dicas ao posicionar o mouse
						}
						
						console.log("Função atualizaInfo: Passei pelo I F");
						
					}
					else{
						bootbox.alert('A informações não foram alteradas!');
					}
					
					console.log("Função atualizaInfo: Estou saindo do POST para mudarInfo.php");
					
				});
				
				console.log("Função atualizaInfo: Estou saindo da função atualizaInfo");
			}
			
			// funcao que executa o post dos parametros para inserir ou editar a disciplina por jQuery
			function atualizaDisciplina(disciplinaP, unidadeP, turnoP, andarP, salaP, diaP){

				var url = "dist/php/atualizaDisciplina.php";
				//var tabDiaSemana;
				
				// executa o post enviando os parametros id, dia, sala, andar, turno, unidade e disciplina
				$.post(url,{ id: idP, dia: diaP, sala: salaP, andar: andarP, turno: turnoP, unidade: unidadeP, disciplina: disciplinaP }, function(result) {
					
					if (result == 1){// caso o retorno de atualizaDisciplina.php seja = 1
						bootbox.alert('Disciplina atualizada com sucesso!',
												function() {// apos OK executa a funcao
														
														$('#configAluno').load( "configAluno.php" );
														
												});
					}
					else{
						// separar a mensagem de erro pelo caracter espaço em branco
						erros = result.split(" "); // armazena as palavras em um array
						
						if(erros[5] == "'PRIMARY'") // compara a ultima palavra do array
							bootbox.alert("Disciplina de "+diaP+" - Já existe disciplina neste turno!");
						else
							if(erros[5] == "'uq_aluno_disciplina'")
								bootbox.alert("Esta disciplina já está cadastrada!");
							else
								bootbox.alert("Ocorreu um erro com sua requisição!");
					}
				});
			}

			
</script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
		
    </head>

    <body>
	
		<div class="modal"></div>
		
        <div class="panel-group">

            <div class="panel panel-primary" >

                <!-- Minhas Aulas -->

                <div class="panel-heading">

                    <!-- Disciplinas -->
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-cogs fa-5x">
                            </i>
                        </div>
                        <div class="col-xs-9 text-right">

                            <div>
                                <h3> CONFIGURAÇÕES DO USUÁRIO </h3>
								<br>
									<?php 
										
										//echo $nome; 
										if ($_SESSION["tipoUsuario"] == "facebook")
											echo "<img src=\"https://graph.facebook.com/" . $_SESSION['usuarioSenha'] . "/picture\">";
										if ($_SESSION["tipoUsuario"] == "google")
											echo "<img src=\"https://www.googleapis.com/admin/directory/v1/users/" . $_SESSION['usuarioSenha'] . "/photos/thumbnail/?key=WrIiWLHNXYJBwCwc1tUrL85A\">";
									?> 
                            </div><!-- <i class="fa fa-user fa-fw"></i> -->
                        </div>
                    </div>
                </div>

                <div class="panel-footer" id="pills">
                    <ul class="nav nav-pills nav-justified">
                        <li class="active">
                            <a href="#perfil" data-toggle="pill">
                                <i class="fa fa-user fa-2x">
                                </i>
                                PERFIL
                            </a>
                        </li>
                        <li id="liSeguranca">
                            <a href="#seguranca" data-toggle="pill">
                                <i class="fa fa-lock fa-2x">
                                </i>
                                SEGURANÇA
                            </a>
                        </li>
                        <li >
                            <a href="#academico" class="academico" data-toggle="pill">
                                <i class="fa fa-calendar fa-2x">
                                </i>
                                ACADÊMICO
                            </a>
                        </li>
						<!--
						<li >
                            <a href="#icloud" class="icloud" data-toggle="pill">
                                <i class="fa fa-mobile fa-2x">
                                </i>
                                ICLOUD
                            </a>
                        </li>
						-->
                    </ul>
                </div>
            </div> 
        </div>
        <!-- panel-footer Pills>
        -->

        <div class="tab-content">
            <div class="tab-pane active" id="perfil">
                <p class="TabContent" >
                    <form id="formMudaInfo" action="#" title="Modificar as informações pessoais" method='POST' > 
					
						<div class="col-xs-12 col-sm-12 col-md-12">
							<h4>
								MODIFICAR AS INFORMAÇÕES PESSOAIS 
							</h4>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12" >
							<div class="form-group">
								<input
									type="text"
									name="nome"
									id="nome"
									title="Nome completo"
									placeholder="Nome completo"
									class="form-control input-lg"
									tabindex="1"
									value='<?php echo $nome; ?>'
									required
								>
							</div>
						</div>
					
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<input
									type="email"
									name="email"
									id="email"
									title="E-mail"
									placeholder="E-mail"
									class="form-control input-lg"
									tabindex="2"
									value='<?php echo $email; ?>'
									required
								>
							</div>
						</div>
					

					
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<input
									type="email"
									name="confirmaEmail"
									id="confirmaEmail"
									title="Confirme o E-mail"
									placeholder="Confirme o E-mail"
									class="form-control input-lg"
									tabindex="3"
									value='<?php echo $email; ?>'
									required
								>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<input
									type="text"
									name="celular"
									id="celular"
									title="Celular"
									placeholder="Celular"
									class="form-control input-lg" 
									tabindex="4"
									value='<?php echo $celular; ?>'
									required="required" maxlength="15"
									data-inputmask="'alias':'celular'"
								/>

							</div>
						</div>
					
						<div class="col-xs-12 col-sm-12 col-md-12">
							<br>
							<div class="col-xs-6 col-sm-6 col-md-6">
								<input id="salvaInfo" type="submit" value="Salvar" class="btn btn-success btn-block btn-lg" >
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6">
								<!-- <input id="sairInfo" type="button" value="Sair" class="btn btn-danger btn-block btn-lg" data-dismiss="modal" data-target="#configModal"> -->
								<button type="button" id="sairInfo" value="Sair" class="btn btn-primary btn-block btn-lg" data-dismiss="modal" data-target="#configModal" style="white-space: normal; padding-right:2px; padding-left:2px;"> <i class="fa fa-home"></i> Voltar</button>
							</div>
						</div> 
					
					</form>

                </p>
            </div>

            <div class="tab-pane" id="seguranca">
                <p class="TabContent">

					<form id="formMudaSenha" action="#" title="Modificar a Senha" method='POST'> 

						<div class="col-xs-12 col-sm-12 col-md-12">
							<h4>
								MODIFICAR A SENHA 
							</h4>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<input 
									type="password"
									name="passwordAtual"
									id="passwordAtual"							
									title="Senha atual: de 6 a 10 caracteres"
									placeholder="Senha atual"
									class="form-control input-lg" 
									tabindex="1"
									required
									/>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<input 
									type="password"
									name="password"
									id="password"							
									title="Nova senha: de 6 a 10 caracteres"
									placeholder="Nova senha"
									class="form-control input-lg" 
									tabindex="2"
									required
									/>
							</div>
						</div>


						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<input     
									type="password"
									name="password2"
									id="password2"
									title="Confirmação de senha"
									placeholder="Confirme a nova senha"
									class="form-control input-lg"
									tabindex="3"
									required
									/>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-12">
							<br>
							<div class="col-xs-6 col-sm-6 col-md-6">
								<input id="salvaSenha" type="submit" value="Salvar" class="btn btn-success btn-block btn-lg" >
							</div>

							<div class="col-xs-6 col-sm-6 col-md-6">
								<!-- <input id="sairSenha" type="button" value="Sair" class="btn btn-danger btn-block btn-lg"> -->
								<button type="button" id="sairSenha" value="Sair" class="btn btn-primary btn-block btn-lg" style="white-space: normal; padding-right:2px; padding-left:2px;"> <i class="fa fa-home"></i> Voltar</button>
							</div>
						</div> 
					</form>
                </p>
            </div>


            <div class="tab-pane" id="academico">
                <p class="TabContent">
				
						<div class="col-xs-12 col-sm-12 col-md-12">
							<h4>
								MONTAR A GRADE DE AULAS DO SEMESTRE 
							</h4>
						</div>
				
					<form id="formMudaDisciplina" role="form">
						
						<div id="minhaGrade">
						<!-- AREA DE EXIBICAO DAS SALAS POR DIA DA SEMANA -->
						</div>
						
						<!-- MODAL DA AREA DE MONTAGEM DE GRADE -->
						<div class="modal fade" id="gradeModal" tabindex="-1" role="dialog" aria-labelledby="gradeModalLabel" aria-hidden="true" >
							<div class="modal-dialog">
								<div class="modal-content">
								
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">
												DISCIPLINA DE 
											</h4>
									</div>
								
									<div class="col-xs-12 col-sm-12 col-md-12">
										<div class="form-group">
											<label for="curso">Nome do curso:</label>
												<select class="form-control" id="curso" >
													<?php
														$sql2="SELECT id, descricao FROM curso order by descricao";
														
														$result2 = mysql_query($sql2, $_SESSION['conexao']);
														
														echo "<option value=0></option>"; 
														
														while ($row = mysql_fetch_assoc($result2)) {
															
															echo "<option value=$row[id]>$row[descricao]</option>"; 
														
														}
													?>
												</select>
										</div>
									</div>
						
									<div class="col-xs-12 col-sm-12 col-md-12">
										<div class="form-group">
											<label for="disciplina">Disciplina:</label>
												<select class="form-control" id="disciplina" required></select>
										</div>
									</div>
						
									<div class="col-xs-12 col-sm-12 col-md-12">
										<div class="form-group">
											<label for="unidade">Unidade Senac:</label>
												<select class="form-control" id="unidade">
													<?php
														$sql3="SELECT id, nome, endereco FROM unidade order by nome";
														
														$result3 = mysql_query($sql3, $_SESSION['conexao']);
														
														while ($row = mysql_fetch_assoc($result3)) {
															
															echo "<option value=$row[id]>$row[nome] -  $row[endereco]</option>"; 
														
														}
													?>
												</select>
										</div>
									</div>
						
									<div class="col-xs-4 col-sm-4 col-md-4">
										<div class="form-group">
											<label for="turno">Turno:</label>
												<select class="form-control" id="turno" required>
													<option value="M">Manhã</option>
													<option value="N">Noite</option>
												</select>
										</div>
									</div>
						
									<div class="col-xs-4 col-sm-4 col-md-4">
										<div class="form-group">
											<label for="andar">Andar:</label>
											<input class="form-control" id="inputAndarDisciplina" name="andar" value="-1" type="number" min="0" max="10">
										</div>
									</div>
									
									<div class="col-xs-4 col-sm-4 col-md-4">
										<div class="form-group">
											<label for="sala">Sala:</label>
												<select class="form-control" id="sala" required></select>
										</div>
									</div>
									
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
										<button type="submit" id="salvarDisciplina" class="btn btn-primary">Salvar alterações</button>
									</div>
								
								</div> <!-- class="modal-content" -->

							</div> <!-- class="modal-dialog" -->

						</div> <!-- <div class="modal fade"  -->
						
					</form>
				
                </p>
				
            </div>
			<!--
			<div class="tab-pane" id="icloud">
                <p class="TabContent">

					<form id="formConfiguraIcloud" action="#" title="Configurar o iCloud" method='POST'> 
						
						
						<div class="col-xs-12 col-sm-12 col-md-12">
							<h4> INTEGRAÇÃO COM ICLOUD </h4>
							
							
							<input type="checkbox" name="integrarIcloud" value="integrarIcloud" />Configurar integração com iCloud <br /> 
							
							<input type="text" name="usuarioIcloud" id="usuarioIcloud" title="Usuário iCloud" placeholder="Usuário iCloud" class="form-control input-lg" tabindex="1" value="" required="">
							<input type="password" name="senhaIcloud" id="senhaIcloud" title="Senha iCloud" placeholder="Senha iCloud" class="form-control input-lg" tabindex="2" value="" required="">
							
							<button id="botaoTestarIcloud" type="button" class="btn btn-success">Testar</button>
						
						</div>
						
						
						<div id="testeIcloud">
							
						</div>
						
					</form>
				</p>
			</div>
				-->

        </div>
		
    </body>

</html>