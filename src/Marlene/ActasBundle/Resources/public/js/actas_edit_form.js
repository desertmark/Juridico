$(document).ready(function(){
//selects dependientes - Fuero(rama) y juzgado
$("#marlene_actasbundle_actas_juzgado").find('option').remove();
	$('#marlene_actasbundle_actas_rama').on('change', function() {
	
		url="../../juzgado/indexJson";
		data = {'rama' : this.value};

		$("#marlene_actasbundle_actas_juzgado").find('option').remove();
		$("#marlene_actasbundle_actas_juzgado").append(new Option('cargando..',''));
		$.post(url,data,function(result)
		{
			console.log(result);
			juzgados = JSON.parse(result);
			console.log(juzgados);
			$("#marlene_actasbundle_actas_juzgado").find('option').remove();
			for (var i = 0; i < juzgados.length; i++) {
				$("#marlene_actasbundle_actas_juzgado").append(new Option('Juzgado Nro: '+juzgados[i].numero +' rama: '+juzgados[i].rama, juzgados[i].id));
			};
		});
	});
	
});