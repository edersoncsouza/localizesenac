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
	
	<!-- CSS para clockpicker -->
	<link rel="stylesheet" type="text/css" href="dist/components/clockpicker/css/bootstrap-clockpicker.min.css">
	
	<!-- CSS para datepicker -->
	<link rel="stylesheet" type="text/css" href="dist/components/datepicker/css/bootstrap-datepicker.min.css">
	
	<!-- Bootstrap Core CSS -->
    <link href="dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	<!-- Custom Fonts -->
    <link href="dist/components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<!-- jQuery -->
    <script src="dist/components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="dist/components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- funcoes personalizadas -->
	<script type="text/javascript" src="dist/js/funcoes.js"></script>	


</head>

<body>

	<div class="container">
	
		<div class="row clearfix">
			<div class="col-xs-12 col-sm-8 col-md-8 col-sm-offset-2 col-md-offset-3">

				<form id="formCriaEvento" role="form" action="dist/php/atualizaEventoAcademico.php" method="POST">
					<h2>Cadastro de Evento</h2>
					<hr class="colorgraph">
					
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<div class="col-xs-12 col-sm-12 col-md-12 input-group">
									<input name="dataInicio" id="inputDataInicio" class="datepicker form-control" placeholder="Data de inicio" required />
									<span class="input-group-addon">
										<span id="iconeDataInicio" class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
					</div>
						
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<div class="col-xs-12 col-sm-12 col-md-12 input-group clockpicker">
									<input type="text" name="horaInicio" id="inputHoraInicio" class="form-control" placeholder="Hora de inicio" required />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<div class="col-xs-12 col-sm-12 col-md-12 input-group">
									<input name="dataFinal" id="inputDataFinal" class="datepicker form-control" placeholder="Data final" required />
									<span class="input-group-addon">
										<span id="iconeDataFinal" class="fa fa-calendar"></span>
									</span>
								</div>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<div class="col-xs-12 col-sm-12 col-md-12 input-group clockpicker">
									<input type="text" name="horaFinal" id="inputHoraFinal" class="form-control" placeholder="Hora final" required />
									<span class="input-group-addon">
										<span class="glyphicon glyphicon-time"></span>
									</span>
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<div class="col-xs-12 col-sm-12 col-md-12 input-group">
									<input class="form-control" name="descricaoEvento" id="inputDescricao" placeholder="Descrição do evento" style="border-radius: 0.25em;" required />
									
									<span class="input-group-addon">
										<span id="iconeDescricao" class="fa fa-pencil-square-o"></span>
									</span>
									
								</div>
							</div>
						</div>
					</div>
					
					<!--
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<div class="col-xs-12 col-sm-12 col-md-12 input-group" data-toggle="tooltip" title="Unidade">
									
									<select name="unidade" id="selectUnidade" class="form-control" >
											<option value="1">Unidade 1</option>
											<option value="2">Unidade 2</option>
									</select>
									<input  class="form-control" id="inputUnidade" placeholder="Unidade" style="border-radius: 0.25em;"/> 
									
									<span class="input-group-addon">
										<span id="iconeUnidade" class="fa fa-building-o"></span>
									</span>
									
								</div>
							</div>
						</div>
					</div> 
					-->
					
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
							<div class="form-group">
								<div class="col-xs-12 col-sm-12 col-md-12 input-group">
									<input class="form-control" name="local" id="inputLocal" placeholder="Local" style="border-radius: 0.25em;" required />
									
									<span class="input-group-addon">
										<span id="iconeLocal" class="fa fa-map-marker"></span>
									</span>
									
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12">
						
							<div class="form-group">
							
								<div class="col-xs-6 col-sm-6 col-md-6">
									<button type="submit" id="incluiEvento" class="btn btn-success btn-block btn-lg" style="white-space: normal; padding-right:3px; padding-left:3px;"><i class="fa fa-plus-square-o"></i> Adicionar Evento</button>
								</div>
								
								<div class="col-xs-6 col-sm-6 col-md-6">
									<button type="button" id="sairEvento" class="btn btn-primary btn-block btn-lg" style="white-space: normal; padding-right:3px; padding-left:3px;" ><i class="fa fa-home"></i> Voltar</button>
								</div>
								
							</div>

						</div>
					</div>
					
				</form>
					
				
			</div>
		</div>
	</div>

		<!-- Clockpicker -->
		<script type="text/javascript" src="dist/components/clockpicker/js/bootstrap-clockpicker.min.js"></script>
		
		<script type="text/javascript" src="dist/components/datepicker/js/bootstrap-datepicker.min.js"></script>
		<script type="text/javascript" src="dist/components/datepicker/js/bootstrap-datepicker.pt-BR.min.js"></script>
		
<script type="text/javascript">
$('.clockpicker').clockpicker({
	placement: 'bottom',
	align: 'left',
	autoclose: true,
}).find('input').change(function(){
		console.log(this.value);
	});
	
// funcao para simular primeiro click em um select, fonte: http://stackoverflow.com/questions/2895608/click-trigger-on-select-box-doesnt-work-in-jquery
function open(elem) {
    if (document.createEvent) {
        var e = document.createEvent("MouseEvents");
        e.initMouseEvent("mousedown", true, true, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);
        elem[0].dispatchEvent(e);
    } else if (element.fireEvent) {
        elem[0].fireEvent("onmousedown");
    }
}
	
 $(document).ready(function () {
	 
	$('.datepicker').datepicker({
		format: 'dd/mm/yyyy',                
		language: 'pt-BR',
		autoclose: true
	});
	

	// dispara o evento de foco no campo de data se o icone for clicado
	$('#iconeDataInicio').click( function() {
		$("#inputDataInicio").trigger('focus');

	});
	
	// dispara o evento de foco no campo de data se o icone for clicado
	$('#iconeDataFinal').click( function() {
		$("#inputDataFinal").trigger('focus');

	});

	// executa a funcao open para simular o evento de abertura do select de unidade se o icone for clicado
	$('#iconeUnidade').click( function() {
		open($('#selectUnidade'));

	});

	// dispara o evento de foco no inputbox de descricao do evento se o icone for clicado
	$('#iconeDescricao').click( function() {
		$("#inputDescricao").trigger('focus');

	});
	
	// dispara o evento de foco no inputbox de descricao do evento se o icone for clicado
	$('#iconeLocal').click( function() {
		$("#inputLocal").trigger('focus');

	});
	
			
});

</script>
	
</body>

</html>