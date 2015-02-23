$(document).ready(function(){
//selects dependientes - Fuero(rama) y juzgado
$("#marlene_actasbundle_actas_juzgado").find('option').remove();
	$('#marlene_actasbundle_actas_rama').on('change', function() {
	
		url="../juzgado/indexJson";
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
	
//checkboxes alternantes entre nuevo cliente/abogado o uno existente

	$("#clienteLbl").css('display','none');
	$("#marlene_actasbundle_actas_cliente").css('display','none');

	$('#nuevoCli').click(function(){
		//checkbox --> checked
		if($('#nuevoCli').is(':checked')) {  

            $("#clienteLbl").css('display','none');
			$("#marlene_actasbundle_actas_cliente").css('display','none');
			$("#clienteForm").css('display','block');
			//restablece el atributo required para que no se envie los datos vacios;
			$("#marlene_actasbundle_cliente input").attr("required","required");
        } else { //checkbox-->not checked
            $("#clienteLbl").css('display','block');
		    $("#marlene_actasbundle_actas_cliente").css('display','block');
			$("#clienteForm").css('display','none');	
			//quita el atributo required para poder enviar los datos vacios;
        	$("#marlene_actasbundle_cliente input").removeAttr("required");	    
        }

    
	});

	$("#abogadoCpLbl").css('display','none');
	$("#marlene_actasbundle_actas_abogadoContraparte").css('display','none');

	$('#nuevoAbogadoCp').click(function(){
		
		if($('#nuevoAbogadoCp').is(':checked')) {  

            $("#abogadoCpLbl").css('display','none');
			$("#marlene_actasbundle_actas_cliente").css('display','none');
			$("#abogadoContraparteForm").css('display','block');
			//restablece el atributo required para que no se envie los datos vacios;
			$("#marlene_actasbundle_abogado input").attr("required","required");
        } else { 
 
            $("#abogadoCpLbl").css('display','block');
		    $("#marlene_actasbundle_actas_abogadoContraparte").css('display','block');
			$("#abogadoContraparteForm").css('display','none');		
			//quita el atributo required para poder enviar los datos vacios;
			$("#marlene_actasbundle_abogado input").removeAttr("required");    
        }
    });
});