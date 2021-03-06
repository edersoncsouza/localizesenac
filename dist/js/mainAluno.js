$(function() {

var entidade = 'Alunos';
var labelform = 'Incluir um novo Aluno';

  var oMemTable = $('#tabela'+ entidade).dataTable({
	  "sPaginationType": "full_numbers",
	  "bProcessing": true,
	  "bServerSide": true,
	  "sAjaxSource": "dist/php/service.php?action=getMembersAjx&entidade=" + entidade, 
	  "sDom": 'T<"clear">lfrtip',
	  "oTableTools": {
			//"sSwfPath": "http://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf"
			"aButtons": [
                                {  
                                    "sExtends": "xls",
                                    "sButtonText": "XLS"
                                },
								{  
                                    "sExtends": "csv",
                                    "sButtonText": "CSV"
                                },
								{  
                                    "sExtends": "pdf",
                                    "sButtonText": "PDF"
                                },
                                {
                                    "sExtends": "copy",
                                    "sButtonText": "Copiar"
                                },
                                {
                                    "sExtends": "print",
                                    "sButtonText": "Imprimir"
                                }                              
                            ],
			"sSwfPath": "dist/components/datatables-tabletools/swf/copy_csv_xls_pdf.swf" //exibe a lista de opções de exportacao
			}
	  
    }).makeEditable({
		sUpdateURL: "dist/php/service.php?action=updateMemberAjx&entidade=" + entidade,
		sAddURL: "dist/php/service.php?action=addMemberAjx&entidade=" + entidade,
		sDeleteURL: "dist/php/service.php?action=deleteMember&entidade=" + entidade,
		sDeleteRowButtonId: "btnDeleteMemRow",
		
		'aoColumns': [
									null,// este null faz com que a coluna matricula nao possa ser editada
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
										messages: { value: {minlength: 'Tamanho mínimo - 5'} } }
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
										data: "{'S':'Ativo','N':'Desativado'}",
										submit: 'Ok',
									}
								],
	

			oAddNewRowButtonOptions: { label: "Incluir...",
				icons: {primary: "btn btn-default glyphicon glyphicon-floppy-save btn-md"}
				//icons: {primary: "btn-default glyphicon glyphicon-floppy-save btn-md"} //glyphicon-plus btn-md"}
			},
			oDeleteRowButtonOptions: { label: "Remover",
				icons: {primary: "btn btn-default glyphicon glyphicon-remove-circle btn-md"}
				//icons: {primary: "btn-default glyphicon glyphicon-remove-circle btn-md"} //glyphicon-remove btn-md"}
			},
			oAddNewRowFormOptions: {
				title: labelform,
				show: "blind",
				hide: "explode",
				modal: true
			},
			sAddDeleteToolbarSelector: ".dataTables_length"			

  });

});
