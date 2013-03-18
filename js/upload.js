$(document).ready(function(){
    mouseOverAll = false; 	
    $('#caloader').live('mouseenter', function(){
        mouseOverAll = true; 
    }).live('mouseleave', function(){ 
        mouseOverAll = false; 
    });
    
    $("#coverall").click(
		function(){
			if (!mouseOverAll){
				formdata = false;
                                cantfotos = 0;
                                
			}			
    });
        
 //   var input = document.getElementById('images');
    var formdata = false;
    var cantfotos = 0;
    function mostrarImagenSubida(source){
        
//        var list = document.getElementById('lista-imagenes'),
//            li   = document.createElement('li'),
        var    img  = document.createElement('img');
        
        img.src = source;
        //alert(source)
//        li.appendChild(img);
//        list.appendChild(li);
          //li.html(img);
          var item = '<div style=" background:url('+source+') ; background-size: cover " class="images-item"></div>';
          $('.foto-publicarevent').append(item);
          //$('.foto-publicarevent').html("");
         // $('.foto-publicarevent').css('background', 'url("'+source+'")');
          //$('.foto-publicarevent').css('background-size', 'cover');
          
    }
    
    //Revisamos si el navegador soporta el objeto FormData
    if(window.FormData){
        formdata = new FormData();
        //document.getElementById('btnSubmit').style.display = 'none';
    }
    
    //Aplicamos la subida de imágenes al evento change del input file
    $('body').delegate('#images','change',function(evt){
            cantfotos++;
            if(cantfotos > 3){
                alert("Solo 3 fotos!"); 
                return;
            }
            var i = 0, len = this.files.length, img, reader, file;
            
            //document.getElementById('response').innerHTML = 'Subiendo...';
            //$('.foto-publicarevent').html("Cargando...");
            
            //Si hay varias imágenes, las obtenemos una a una
            for( ; i < len; i++){
                file = this.files[i];
                
                //Una pequeña validación para subir imágenes
                if(!!file.type.match(/image.*/)){
                    //Si el navegador soporta el objeto FileReader
                    if(window.FileReader){
                        reader = new FileReader();
                        //Llamamos a este evento cuando la lectura del archivo es completa
                        //Después agregamos la imagen en una lista
                        reader.onloadend = function(e){
                            mostrarImagenSubida(e.target.result);
                        };
                        //Comienza a leer el archivo
                        //Cuando termina el evento onloadend es llamado
                        reader.readAsDataURL(file);
                    }
                    
                    //Si existe una instancia de FormData
                    if(formdata)
                        //Usamos el método append, cuyos parámetros son:
                            //name : El nombre del campo
                            //value: El valor del campo (puede ser de tipo Blob, File e incluso string)
                        formdata.append('images[]', file);
                }
            }
            
            //Por último hacemos uso del método proporcionado por jQuery para hacer la petición ajax
            //Como datos a enviar, el objeto FormData que contiene la información de las imágenes
            
        });
    
    
    $('#coverall').delegate('#guardarevento','click',function(){
        //alert("daasddas");
        
        var nomevent = $('#nom-event').val();
        var addresEvent = $('#addresEvent').val();
        var lat = $('.Lat').val();
        var lng = $('.Lng').val();
        var dateevent = $('#date-event').val();
      // alert(dateevent); return;
        var hourevent = $('#hour-event').val();
        var tagsevent = $('#tags-event').val();
        var descripcionevent = $('#descripcion-event').val();
        var urlfacebook = $('#urlfacebook').val();
        var urltwitter = $('#urltwitter').val();
       
        if(formdata){
                    $.ajax({
                                           url : '../function/upload.php',
                                           type : 'POST',
                                           data : formdata,
                                           processData : false, 
                                           contentType : false,
                                           dataType: "JSON",
                                           success : function(res){
//                                               alert(res.exito);
//                                               alert(res.nombrefoto);
                                                 
                                               if(res.exito){
                                               //   alert(res.nombresfoto);return;
                                                $.ajax({
                                                         url : '../function/event-response.php',
                                                         type : 'POST',
                                                         data : "guardarevent=1&nomevent="+nomevent+"&nombresfoto="+res.nombresfoto+"&addresEvent="+addresEvent+"&lat="+lat+"&lng="+lng+"&dateevent="+dateevent+"&hourevent="+hourevent+"&tagsevent="+tagsevent+"&descripcionevent="+descripcionevent+"&urlface="+urlfacebook+"&urltwitter="+urltwitter, 
                                                         success : function(res){                      
                                                             if(res == 1){
                                                                   window.location.reload();
                                                             }else{
                                                                 alert("Vuelva a intentarlo")
                                                             }
                                                         }                
                                                      });
                                               }//if
                                           }                
                            });
                            
                     }//if
      })
      
      $('#coverall').delegate('#guardarest','click',function()
  {
        var nomevent = $('#nom-event').val();
        var addresEvent = $('#addresEvent').val();
        var lat = $('.Lat').val();
        var lng = $('.Lng').val();
        var tagsevent = $('#tags-event').val();
        var descripcionevent = $('#descripcion-event').val();
        var telefono = $('#telefono-est').val();
        var urltwitter = $('#url-twitter').val();
        var urlfacebook = $('#url-face').val();
     //  alert("aaaaaa"); return;
        if(formdata){
                    $.ajax({
                                           url : '../function/uploadest.php',
                                           type : 'POST',
                                           data : formdata,
                                           processData : false, 
                                           contentType : false,
                                           dataType: "JSON",
                                           beforeSend:function(){
                                               $('#guardarest').html('Loading...');
                                           },
                                           success : function(res){
//                                               alert(res.exito);
//                                               alert(res.nombrefoto);
                                             
                                               if(res.exito){
                                                $.ajax({
                                                    
                                                         url : '../function/establecimiento-response.php',
                                                         type : 'POST',
                                                         data : "guardarest=&nomevent="+nomevent+"&nombresfoto="+res.nombresfoto+"&addresEvent="+addresEvent+"&lat="+lat+"&lng="+lng+"&tagsevent="+tagsevent+"&descripcionevent="+descripcionevent+"&telefono="+telefono+"&urlface="+urlfacebook+"&urltwitter="+urltwitter, 
                                                         success : function(res){                      
                                                         
                                                             formdata = false;
                                                            if(res == 1){
                                                                 $('#guardarest').html('Guardar');
                                                                 alert("Agregado");
                                                                 
                                                            }else{
                                                                alert("Vuelva a intentarlo");
                                                            }
                                                         }                
                                                      });
                                               }//if
                                           }                
                            });
                            
                     }
      
  })

     $('#coverall').delegate('#guardarusuario','click',function()
  {
      
        var nomeuser = $('#nombre-usuario').val();
        var apellido = $('#apellido-usuario').val();
        var correousuario = $('#correo-usuario').val();
        var claveusuario = $('#clave-usuario').val();
        //alert("adads"); return;
                        $.ajax({
                                 dataType:"JSON",
                                 url : '../function/users-response.php',
                                 type : 'POST',
                                 data : "guardaruser=1&nomuser="+nomeuser+"&apellido="+apellido+"&correousuario="+correousuario+"&claveusuario="+claveusuario, 
                                 success : function(res){                      
                                     //modificar la foto con el mail
                                     if(res == 1)
                                     alert("Agregado")
                                    else
                                     alert("Vuelva a intentarlo")
                                  }//success                
                              });
      
  })

    $('#coverall').delegate('#guardarproductora','click',function()
  {
      
        var nomeuser = $('#nombre-usuario').val();
        var correousuario = $('#correo-usuario').val();
        var claveusuario = $('#clave-usuario').val();
//        alert("adads"); return;
                        $.ajax({
                                 dataType:"JSON",
                                 url : '../function/productora-response.php',
                                 type : 'POST',
                                 data : "guardarproductora=1&nomuser="+nomeuser+"&correousuario="+correousuario+"&claveusuario="+claveusuario, 
                                 success : function(res){                      
                                     //modificar la foto con el mail
                                     if(res == 1)
                                     alert("Agregado")
                                    else
                                     alert("Vuelva a intentarlo")
                                  }//success                
                              });
      
  })
  
})

