$(function() {

var entidade = 'EventosAcademicos';
var labelform = 'Incluir um novo Evento';

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
									{//^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$ // fonte: http://stackoverflow.com/questions/15491894/regex-to-validate-date-format-dd-mm-yyyy
										tooltip: 'Data de início do evento',
										oValidationOptions : { rules:{ value: {required : true, date : true }  }, 
										messages: { value: {date: 'A data deve ser informada no formato dd/mm/aaaa',required: 'Este campo é obrigatório'} } }
									},
									{
										tooltip: 'Hora de início do evento',
										oValidationOptions : { rules:{ value: {required : true/*value: {minlength: 5*/ }  },
										messages: { value: {/*minlength: 'Tamanho mínimo - 5'*/required: 'Este campo é obrigatório'} } },

									},
									{
										tooltip: 'Data final do evento',
										oValidationOptions : { rules:{ value: {required : true/*value: {minlength: 5*/ }  },
										messages: { value: {/*minlength: 'Tamanho mínimo - 5'*/required: 'Este campo é obrigatório'} } },
									},
									{
										tooltip: 'Hora final do evento',
										oValidationOptions :{ rules:{ value: {required : true/*, number : true, minlength: 8*/} },
										messages: { value: {/*minlength: 'Tamanho mínimo - 5'*/required: 'Este campo é obrigatório'} } },
									},
									{
										tooltip: 'Descrição do evento',
										oValidationOptions :{ rules:{ value: {required : true/*, number : true, minlength: 8*/} },
										messages: { value: {/*minlength: 'Tamanho mínimo - 5'*/required: 'Este campo é obrigatório'} } },
									},
									{
										tooltip: 'Local do evento',
										oValidationOptions :{ rules:{ value: {required : true/*, number : true, minlength: 8*/} },
										messages: { value: {/*minlength: 'Tamanho mínimo - 5'*/required: 'Este campo é obrigatório'} } },
									}
								],
	

			oAddNewRowButtonOptions: { label: "Incluir...",
				icons: {primary: "btn btn-default btn-md fa fa-plus-square-o"} //glyphicon glyphicon-floppy-save
				//icons: {primary: "btn-default glyphicon glyphicon-floppy-save btn-md"} //glyphicon-plus btn-md"}
			},
			oDeleteRowButtonOptions: { label: "Remover",
				icons: {primary: "btn btn-default btn-md fa fa-minus-square-o"} //glyphicon glyphicon-remove-circle
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
