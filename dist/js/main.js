$(function() {

  var oMemTable = $('#tabelaAlunos').dataTable({
	  "sPaginationType": "full_numbers",
	  "bProcessing": true,
	  "bServerSide": true,
	  "sAjaxSource": "service.php?action=getMembersAjx", 
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
		sUpdateURL: "service.php?action=updateMemberAjx",
		sAddURL: "service.php?action=addMemberAjx",
		sDeleteURL: "service.php?action=deleteMember",
		sDeleteRowButtonId: "btnDeleteMemRow",
		
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
				title: "Incluir um novo Aluno",
				show: "blind",
				hide: "explode",
				modal: true
			},
			sAddDeleteToolbarSelector: ".dataTables_length"			

  });

});
