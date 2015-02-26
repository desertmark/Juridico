$(document).ready(function(){
            i=0;
            $('#btnComentar').click(function(){
                
                if(i==0){
                    today = new Date();
                    row ='<tr id="'+i+'">';  
                    row +='<td><input id="creador'+i+'" type="text"/></td>';
                    row +='<td><input id="fechaHora'+i+'" type="text" value="'+today.getDate()+'/'+(today.getMonth()+1) +'/'+today.getFullYear()+' '+today.getHours()+':'+today.getMinutes()+':'+today.getSeconds() +'" disabled></td>';
                    row +='<td><textarea id="texto'+i+'"></textarea></td>';
                    row +='<td><button onclick="borrarFila('+i+')" class="btn btn-danger sup">x</button></td>';
                    row +='</tr>'
                    $('#divComentarios tbody').append(row);
                    saveBtn = '<button id="saveCom" onclick="guardarComentario('+i+')" class="btn">Guardar comentario</button><br><br>';
                    $('#btnComentar').before(saveBtn);
                    i++;
                }
                else
                {
                    $('#texto0').focus();
                }
            });

            
        });

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