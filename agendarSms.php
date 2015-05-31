<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <script src="dist/components/jquery/dist/jquery.min.js"></script>
<script>

$(document).ready(function() {
	// executa o post para receber o retorno dos lembretes salvos na agenda do aluno
	var url = "buscarLembretes.php";

	// recebe como retorno um json com os lembretes (lembretesJson)
	$.post(url,{ tipoLembrete: "zsms", turno: "M"}, function(lembretesJson) {

		if (lembretesJson == 0){// caso o retorno de buscarDisciplinasDia.php seja = 0

			//console.log("Não existiam lembretes do tipo sms no banco de dados no turno da manhã!");
		
		}
		else{ // se retornou com disciplinas
			
			//console.log("Foram retornados lembretes");
			
		}
});

</script>
</head>
</html>