<!DOCTYPE html>
<html>
    <head>
        <title>LocalizeSenac - Listagem de Alunos</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	
    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- DataTables CSS -->
    <link href="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../bower_components/datatables-responsive/css/dataTables.responsive.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
	
		<style type="text/css" media="screen">

			#example_wrapper .fg-toolbar { font-size: 0.8em }
			#theme_links span { float: left; padding: 2px 10px; }
		</style>
	
	<!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../bower_components/DataTables/media/js/jquery.dataTables.min.js"></script>
    <script src="../bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.min.js"></script>
	
	 <!-- DataTables Editable JavaScript -->
	<script src="../bower_components/datatables-editable/js/jquery.jeditable.js" type="text/javascript"></script>
	<script src="../bower_components/datatables-editable/js/jquery.dataTables.editable.js"></script>
	
	<script src="../bower_components/jquery-validate/js/jquery.validate.js"></script>

		<script>
			$(document).ready(function() {
				$('#tabelaAlunos').dataTable( {
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "fonteAluno.php" // script PHP que lista a tabela aluno
				} ).makeEditable({
							sUpdateURL: "atualiza_aluno.php", // script php que recebe o registro atualizado
							sAddURL: "AddData.php",
                            sAddHttpMethod: "GET",
                            sDeleteHttpMethod: "GET",
							sDeleteURL: "DeleteData.php",
							 'aoColumns': [
									{
										tooltip: 'Matrícula',
										oValidationOptions : { rules:{ value: {minlength: 9 }  },
										messages: { value: {minlength: 'Tamanho mínimo - 9'} } }
									},
									{
										tooltip: 'Senha',
										oValidationOptions : { rules:{ value: {minlength: 5 }  },
										messages: { value: {minlength: 'Tamanho mínimo - 5'} } },

									},
									{
										tooltip: 'Nome',
										oValidationOptions : { rules:{ value: {minlength: 5 }  },
										messages: { value: {minlength: 'Min length - 5'} } }
									},
									{
										tooltip: 'Celular',
										oValidationOptions :{ rules:{ value: {required : true, number : true, minlength: 8} },
										messages: { value: {minlength: 'Tamanho mínimo - 8', number: 'Por favor digite apenas números', required: 'Este campo é obrigatório'} } }
									},
									{
										tooltip: 'E-mail',
										cssclass:"email",
									},
									{
										tooltip: 'Ativo',
										type: 'select',
										data: "{'Ativo':'S','Desativado':'N'}",
										submit: 'Ok',
									}
								],
									oAddNewRowButtonOptions: {	label: "Add...",
													icons: {primary:'ui-icon-plus'} 
									},
									oDeleteRowButtonOptions: {	label: "Remove", 
													icons: {primary:'ui-icon-trash'}
									},

									oAddNewRowFormOptions: { 	
                                                    title: 'Add a new browser',
													show: "blind",
													hide: "explode",
                                                    modal: true
									}	,
									sAddDeleteToolbarSelector: ".dataTables_length"								
							});
			} );
		</script>
	
</head>

<body>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong> Listagem de Alunos </strong>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <div class="dataTable_wrapper">

	<table cellpadding="0" cellspacing="0" border="0" id="tabelaAlunos" class="table table-striped table-bordered table-hover dataTable no-footer display" >

		<thead>
			<tr>
				<th width="15%">Matricula</th>
				<th width="25%">Senha</th>
				<th width="25%">Nome</th>
				<th width="15%">Celular</th>
				<th width="15%">E-mail</th>
				<th width="10%">Ativo</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td colspan="5" class="dataTables_empty">Loading data from server</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th width="15%">Matricula</th>
				<th width="25%">Senha</th>
				<th width="25%">Nome</th>
				<th width="15%">Celular</th>
				<th width="15%">E-mail</th>
				<th width="10%">Ativo</th>
			</tr>
		</tfoot>
	</table>
	
	</div>
                            <!-- /.table-responsive -->

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
</div> <!-- <div id="page-wrapper"> -->
	
</body>

</html>