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

		<!-- Bootstrap Core CSS -->
        <link href="dist/components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		
		<!-- Custom Fonts -->
        <link href="dist/components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">	
		
		<!-- Custom CSS -->
		<link href="dist/css/sb-admin-2.css" rel="stylesheet">
		
		<!-- CSS para clockpicker -->
		<link rel="stylesheet" type="text/css" href="dist/components/clockpicker/css/bootstrap-clockpicker.min.css">
		
		<!-- CSS para datepicker -->
		<link rel="stylesheet" type="text/css" href="dist/components/datepicker/css/bootstrap-datepicker.min.css">
		
	    <!-- jQuery -->
        <script src="dist/components/jquery/dist/jquery.min.js"></script>
		
		<!-- RobinHerbots/jquery.inputmask: https://github.com/RobinHerbots/jquery.inputmask -->
		<script type="text/javascript" src="dist/components/jquery.inputmask/jquery.inputmask.js"></script>
		
		<!-- Bootstrap Core JavaScript -->
		<script src="dist/components/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
		
		<!-- Bootbox -->
		<script src="dist/components/bootbox/dist/js/bootbox.min.js" type="text/javascript"></script>




</head>

<body>

	<div class="container">
		<div class="row clearfix">
			<div class="col-md-12 column">
			
				
					<form class="form-horizontal" role="form">
					
						<div class="form-group">
							 <label for="inputDataInicio" class="col-sm-2 control-label">Data de inicio</label>
							<div class="col-sm-10 input-group">
								<input id="inputDataInicio" class="datepicker form-control" />
								<span class="input-group-addon">
									<span id="iconeDataInicio" class="fa fa-calendar"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label for="inputHoraInicio" class="col-sm-2 control-label">Hora de inicio</label>
							<div class="col-sm-10 input-group clockpicker">
								<input type="text" id="inputHoraInicio" class="form-control" >
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							 <label for="inputDataFinal" class="col-sm-2 control-label">Data final</label>
							<div class="col-sm-10 input-group">
								<input id="inputDataFinal" class="datepicker form-control"  />
								<span class="input-group-addon">
									<span id="iconeDataFinal" class="fa fa-calendar"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label for="inputHoraFinal" class="col-sm-2 control-label">Hora final</label>
							<div class="input-group clockpicker">
								<input id="inputHoraFinal" type="text" class="form-control " >
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-time"></span>
								</span>
							</div>
						</div>
						<div class="form-group">
							 <label for="inputDescricao" class="col-sm-2 control-label">Descrição do evento</label>
							<div class="col-sm-10 input-group">
								<input class="form-control" id="inputDescricao" />
							</div>
						</div>
						<div class="form-group">
							 <label for="inputUnidade" class="col-sm-2 control-label">Unidade</label>
							<div class="col-sm-10 input-group">
								<input type="email" class="form-control" id="inputUnidade" />
							</div>
						</div>
						<div class="form-group">
							 <label for="inputLocal" class="col-sm-2 control-label">Local</label>
							<div class="col-sm-10 input-group">
								<input type="email" class="form-control" id="inputLocal" />
							</div>
						</div>
						<div class="form-group">
							<div class="col-xs-6 col-sm-6 col-md-6">
								<button type="button" id="incluiDisciplina" class="btn btn-success btn-block btn-lg" style="white-space: normal; padding-right:3px; padding-left:3px;"><i class="fa fa-plus-square-o"></i> Adicionar Evento</button>
							</div>
							
							<div class="col-xs-6 col-sm-6 col-md-6">
								<button type="button" id="sairDisciplina" class="btn btn-primary btn-block btn-lg" style="white-space: normal; padding-right:3px; padding-left:3px;" ><i class="fa fa-home"></i> Voltar</button>
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

	
			
});

</script>
	
</body>

</html>