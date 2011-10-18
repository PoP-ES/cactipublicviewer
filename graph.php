<?php
 /*
  * Copyright (C) 2011 PoP-ES http://www.pop-es.rnp.br
  * See LICENSE
  */
?>

<?php

$action = $_GET['action'];
$instcode = $_GET['icod'];


$a = array();
$i=0;
if ($action=='listInsts'){
	listinsts();
}elseif ($action=='getIDs'){
	getids($instcode);
}elseif ($action=='getCactiURL'){
	getCactiURL();
}

function getCactiURL(){
	$docxml = new DOMDocument();
	$docxml->load(dirname( __FILE__ ) . '/graphcode.xml');
	$cactiurl = $docxml->getElementsByTagName('cactiurl')->item(0)->nodeValue;
	echo json_encode($cactiurl);
}
	

function listinsts(){
	$docxml = new DOMDocument();
	$docxml->load(dirname( __FILE__ ) . '/graphcode.xml');
	$insts = $docxml->getElementsByTagName('instituicao');
	$i=0;

	foreach ($insts as $inst){
		$aId[$i]['instname']=$inst->getElementsByTagName('instDesc')->item(0)->nodeValue;
		$aId[$i]['instcode']=$inst->getAttribute('cod');
		$aId[$i]['instpai']=$inst->getAttribute('pai');
		$intfs = $inst->getElementsByTagName('interface');
		$j=0;
		
		foreach ($intfs as $intf){
			$aId[$i][$j]=$intf->getAttribute('desc');
			$j++;		
		}
		$i++;	
	}
	return json_encode($aId);	
}

function getids($instcode){
	$docxml = new DOMDocument();
	$docxml->load('graphcode.xml');
	$aId = array();
	$insts = $docxml->getElementsByTagName('instituicao');
	foreach ($insts as $inst){
		if($inst->getAttribute('cod')==$instcode){
			$aId['instname'][0]=$inst->getElementsByTagName('instDesc')->item(0)->nodeValue;
			$intfs = $inst->getElementsByTagName('interface');
			$i=0;
			foreach ($intfs as $intf){
				$aId['intfDesc'][$i]= $intf->getElementsByTagName('interfDesc')->item(0)->nodeValue;
				$aId['type']['traffic'][$i]= $intf->getElementsByTagName('traffic')->item(0)->nodeValue;
				$aId['type']['error'][$i]= $intf->getElementsByTagName('error')->item(0)->nodeValue;
				$aId['type']['packetsu'][$i]= $intf->getElementsByTagName('packetsUni')->item(0)->nodeValue;
				$aId['type']['packetsm'][$i]= $intf->getElementsByTagName('packetsMul')->item(0)->nodeValue;
				$aId['type']['rtt'][$i]= $intf->getElementsByTagName('rtt')->item(0)->nodeValue;
				
				$i++;
				
			}
			echo json_encode($aId);
		}
	}
}


?> 
