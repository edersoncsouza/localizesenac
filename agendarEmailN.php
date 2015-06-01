<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <script src="dist/components/jquery/dist/jquery.min.js"></script>
<script>

$(document).ready(function() {
	// executa o post para receber o retorno dos lembretes salvos na agenda do aluno
	var url = "zenvia/buscarLembretes.php";

	for (i = 60; i > 0; i--){ // laco para fornecer os minutos de antecedencia
		
		setTimeout(function(){ // aguarda 1 minuto e executa a funcao abaixo
		
			// recebe como retorno um json com os lembretes (lembretesJson)
			$.post(url,{ tipoLembrete: "pemail", turno: "N", antecedenciaEmail: i}, function(lembretesJson) {

				if (lembretesJson == 0){// caso o retorno de buscarDisciplinasDia.php seja = 0
					console.log("Não existiam lembretes do tipo pemail no banco de dados no turno da noite!");
				}
				else{ // se retornou com disciplinas
					console.log("Foram retornados lembretes:");
					console.log(lembretesJson);
				}
				
			});	
		
		},60000);
		
	}
	
});

</script>
</head>
</html>