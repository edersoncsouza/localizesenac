<!DOCTYPE HTML>
<html lang="pt-br">
<head>
    <script src="dist/components/jquery/dist/jquery.min.js"></script>
<script>

$(document).ready(function() {
	
	var timerId = setInterval(timerMethod, 60000);    //60,000 milisegundos, ou seja, um minuto
	
	var contador = 60;

// funcao que chama o buscar lembretes fornecendo o tipo como "pemail", o turno como "N" e os minutos de antecedencia como contador
function timerMethod() {
    
    if(contador < 0) clearInterval(timerId); // se contador valer menos que zero limpa o temporizador de execucao timerId
		
		// define a pagina a ser chamada por post
		var url = "zenvia/buscarLembretes.php";
		
		// recebe como retorno um json com os lembretes (lembretesJson)
		$.post(url,{ tipoLembrete: "pemail", turno: "M", antecedenciaEmail: contador}, function(lembretesJson) {

			if (lembretesJson == 0){// caso o retorno de buscarLembretes.php seja = 0
				console.log("Não existiam lembretes do tipo pemail no banco de dados no turno da noite com intervalo de " + contador + " minutos!");
			}
			else{ // se retornou com disciplinas
				console.log("Retornado um lembrete do tipo pemail no turno da noite com intervalo de " + contador + " minutos!");
				console.log(lembretesJson);
			}
			
		});	
		
	contador--;
	
}
	
});

</script>
</head>
</html>