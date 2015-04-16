$(function() {

var entidade = 'Salas';
var labelform = 'Incluir uma nova Sala';

  var oMemTable = $('#tabela'+ entidade).dataTable({
	  "sPaginationType": "full_numbers",
	  "bProcessing": true,
	  "bServerSide": true,
	  "sAjaxSource": "service.php?action=getMembersAjx&entidade=" + entidade, 
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
		sUpdateURL: "service.php?action=updateMemberAjx&entidade=" + entidade,
		sAddURL: "service.php?action=addMemberAjx&entidade=" + entidade,
		sDeleteURL: "service.php?action=deleteMember&entidade=" + entidade,
		sDeleteRowButtonId: "btnDeleteMemRow",
		
		'aoColumns': [
									{
										tooltip: 'Unidade',
										type: 'select',
										data: "{'1':'Unidade 1','2':'Unidade 2'}",
										submit: 'Ok',
									},
									{
										tooltip: 'Andar',
										oValidationOptions : { rules:{ value: {minlength: 1 }  },
										messages: { value: {minlength: 'Tamanho mínimo - 1'} } },

									},
									{
										tooltip: 'Número',
										oValidationOptions : { rules:{ value: {minlength: 3 }  },
										messages: { value: {minlength: 'Tamanho mínimo - 3'} } }
									},
									{
										tooltip: 'Categoria',
										type: 'select',
										data: "{'1':'Serviços Administrativos','2':'Salas de Aula','3':'Alimentação','4':'Serviços','5':'Apoio'}",
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
