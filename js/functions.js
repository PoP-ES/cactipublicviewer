/* --------------------------
AUTHOR : PoP-ES/RNP
URL : http://www.pop-es.rnp.br
Copyrights by PoP-ES/RNP
See LICENSE
----------------------------*/

function colectID(gintf){
	var hol=jQuery('#cliente').val();
	if (!hol){
		var hol=$('.menu-client option[rel="ativo"]').attr('value');
	}
	
	if (hol == 'null'){
		$('#tabs').hide();
		$('#tabs').tabs('select',0);
		$('#menuIntf').hide();
		$('#graphs').hide();
		return;
	}
	
	// Pega URL do graph
	var hostname = window.location.hostname;
	var pathArray = window.location.pathname.split( '/' );
	var path = "";
	var i = 0;
	for ( i = 0; i < pathArray.length - 1; i++ ) {
		if (pathArray[i] == "index.php")
			break;
		path += pathArray[i];
		path += "/";
	}
	var url;

	url = "http://"+hostname+path.replace('index.php/','')+"graph.php?action=getIDs&icod="+hol;
	$.getJSON(url, function(json){
		var interfaces = '<ul>';
		var interf;
		if (gintf != null){
			interf = gintf;
		}else{
			interf = $(".interface[rel='ativo']").attr('val');
		}
		
		if (interf == null){ interf = 0; }

		var i=0;
		var $tabs = $('#tabs').tabs();
		var tp = $("li.tab.ui-tabs-selected").attr("id");
		for (type in json['type']){
			if (json.type[type][interf] == null){
				if (tp == type){
					$tabs.tabs('select',0);
				}
				$tabs.tabs( "disable" , i );
			}else{
				$tabs.tabs( "enable" , i );
			}
			i++;
		}
		i=0;

		while(json.intfDesc[i]!=null){
			if (json.type[tp][i] != null)
				interfaces = interfaces+"<li><a href='#' class='interface' val='"+i+"' >"+json.intfDesc[i]+"</a></li>";
			i++;
		}
		interfaces = interfaces+"</lu>";
		$('#menuIntf').html(interfaces);
		$(".interface[val='"+interf+"']").attr('rel', 'ativo');
		
		var gr;
		
		// Pega URL do Cacti
		url = "http://"+hostname+path.replace('index.php/','')+"graph.php?action=getCactiURL";
		$.getJSON(url, function(cactiurl){		
			for(var i=1; i<=4; i++){
				gr = '#graph'+i;
				$(gr).html ("<img src=\""+cactiurl+"/graph_image.php?local_graph_id="+json.type[tp][interf]+"&rra_id="+i+"&graph_height=120&graph_width=500\">");
			}	
			$('#tabs').show();
			$('#menuIntf').show();
			$('#graphs').show();
		});
	});
}

function getUrlVars(){
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

$(document).ready(function() { //Finish loading the entire page before processing any javascript

	//$('#selectedInst').hide();
	var ginst = getUrlVars()["ginst"];
	var gtype = getUrlVars()["gtype"];
	var gintf = getUrlVars()["gintf"];

	var $tabs = $('#tabs').tabs();
	$tabs.tabs('select', 0);

	$('#tabs').hide();	
	$('#menuIntf').hide();
	$('#graphs').hide();
	
	if (ginst!=null && gtype!=null && gintf!=null){
		/*setar os options dos menus para os das variaveis passda */
		$(".menu-client").attr('rel','');
		$(".menu-client option[value='"+ginst+"']").attr('rel','ativo');
		$(".menu-client option[value='"+ginst+"']").attr('selected','selected');

		colectID(gintf);
	}

	$('.menu-client').live('change',function(){
		$(".interface[rel='ativo']").attr('rel', '');
		$(".menu-client option[rel='ativo']").attr('rel','');
		$(".menu-client option[value='"+$(this).attr('value')+"']").attr('rel','ativo');
		
		colectID();
	});
	$tabs.tabs({
		show: function(event, ui){
			colectID();
		}
	});

	$('.interface').live('click',function(){
		// Limpa todas as interfaces
		$(".interface[rel='ativo']").attr('rel', '');
		// Marca aquele link clicado como ativo
		$(this).attr('rel', 'ativo');

		colectID();
	});
	

});
