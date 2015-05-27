<html>
<head>
	<!-- jQuery -->
    <script src="dist/components/jquery/dist/jquery.min.js"></script>
<script>
//

$(document).ready(function() {

var json = '[{"diaDaSemana":"QUA","minutos":"5"},{"diaDaSemana":"QUI","minutos":"5"},{"diaDaSemana":"SEG","minutos":"5"},{"diaDaSemana":"SEX","minutos":"5"},{"diaDaSemana":"TER","minutos":"5"}]';
/*
var json = [
	{"id":"1","tagName":"apple"},
	{"id":"2","tagName":"orange"},
	{"id":"3","tagName":"banana"},
	{"id":"4","tagName":"watermelon"},
	{"id":"5","tagName":"pineapple"}
];
*/
$.each(JSON.parse(json), function(idx, obj) {
	alert(obj.diaDaSemana);
});
	
});

</script>

</head>

<body></body>

</html>