$(document).ready(function(){
            

            
        });

        
        i=0;
        function comentar(usuario){
                
            if(i==0){
                row ='<tr id="'+i+'"><td>';  
                row +='<input id="creador'+i+'" value="'+usuario+'"type="text" style="display: none" disabled/>';
                row +='<textarea style="width:94%" id="texto'+i+'"></textarea>';
                row +='<div class="btnEliminarComentario" ><button onclick="borrarFila('+i+')" class="btn btn-danger sup">x</button></div>';
                row +='</td></tr>'
                $('#divComentarios tbody').append(row);
                saveBtn = '<button id="saveCom" onclick="guardarComentario('+i+')" class="btn">Guardar comentario</button><br><br>';
                $('#btnComentar').before(saveBtn);
                i++;
            }
            else
            {
                $('#texto0').focus();
            }
        }    
        function borrarFila(id)
        {
            if(confirm("Esta seguro que desea borrar el comentario?"))
            {
                id = "#" + id;
                $(id).remove();
                $("#saveCom").remove();
                i=0;
            }
        }
        function guardarComentario(id)
        {
            creador = $('#creador'+id).val();
            texto = $('#texto'+id).val();
            actaId = $('#actaId').text();
            console.log(creador + texto);


            url="comentarios/";
            data = {'creador' : creador, 'texto' : texto, 'actaId' : actaId };
            
            $.post(url,data,function(result)
            {
                    console.log('success: '+result);
                    location.reload();
                
            });
        }