<?php
 /*
  * Copyright (C) 2011 PoP-ES http://www.pop-es.rnp.br
  * See LICENSE
  */
?>

<html>
<head>
<link type="text/css" href="css/smoothness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/jquery-ui.js"></script> 
<script type="text/javascript" src="js/functions.js"></script>
<link href="css/style.css" rel="stylesheet" media="all" />
<script type="text/javascript">
	$(function() {
		$( "#tabs" ).tabs();
	});
</script>
</head>
<body>

<?php
include "graph.php";

$linstj=listinsts();
$linsts=json_decode($linstj, true);
$i=0;

$ginst = $_GET['ginst'];
$gtype = $_GET['gtype'];
$gintf = $_GET['gintf'];
$showInsts = ( isset($_GET['showinsts']) ? $_GET['showinsts'] : 1 );

if ($showInsts == 1)
{
	echo "<br>Visualize estatísticas e informações históricas dos enlaces das redes conectadas ao PoP-ES/RNP. Selecione a referência abaixo.";
	echo "<br><br>";
	echo "<div id='menu'>";
	echo "<select id='selectedInst' class='menu-client'>
		<option value='null' SELECTED>Selecione...</option>
	";
	do{
		echo "<option value='".$linsts[$i][instcode]."'>".$linsts[$i][instname]."</option>
	";
		$i++;
	}while($linsts[$i][instname]!='');
	echo "</select><br><br></div>";
}
echo "<input type='hidden' id='cliente' name='cliente' value='".$ginst."' />";
?>

<div id="tabs">
	<ul>
		<li class="tab" id="traffic"><a href="#atraffic">Tr&aacute;fego</a></li>
		<li class="tab" id="error"><a href="#aerror">Erro/Descarte</a></li>
		<li class="tab" id="packetsu"><a href="#apacketsu">Pacotes Unicast</a></li>
		<li class="tab" id="packetsm"><a href="#apacketsm">Pacotes Nao Unicast</a></li>
		<li class="tab" id="rtt"><a href="#artt">Lat&ecirc;ncia</a></li>
	</ul>
	<div id="atraffic"></div>
	<div id="aerror"></div>
	<div id="apacketsu"></div>
	<div id="apacketsm"></div>
	<div id="artt"></div>

<div id='menuIntf'>
</div>

<br>

<div id='graphs' class='graphs'> </-- style='display:none'>
<div class='graphx'>Di&aacute;rio: (M&eacute;dia a cada 5 minutos)<br><div id='graph1'></div></div>
<div class='graphx'><br>Semanal: (M&eacute;dia a cada 30 minutos)<br><div id='graph2'></div></div>
<div class='graphx'><br>Mensal: (M&eacute;dia a cada 2 horas)<br><div id='graph3'></div></div>
<div class='graphx'><br>Anual: (M&eacute;dia a cada 1 dia)<br><div id='graph4'></div></div>
</div>

</div>
</body>
</html>
