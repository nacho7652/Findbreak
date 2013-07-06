$(document).ready(function(){
    //mensajes transacciones
    formdata = false;
    formdata = new FormData();
    function limpiar(){
        $('.titunoticia').val('');
        $('.contentnoticia').val('');
         formdata = false;
         formdata = new FormData();
         $('.images').val('');
        $('.coverfile').css('background-image','none');
         $('.titunoticia').focus();
    }
    function msjError(msj){				
        $('#calmsj').html('<div class="iconerror sprites" ></div> '+msj);
        setTimeout('$("#covermsj").fadeOut(500);',4000);
    }
    function loader(msj){
        $("#covermsj").fadeIn(0);	
        $("#covermsj > .innermsj").fadeIn(0);
        $('#calmsj').html(msj);
    }
    function msjSucess(msj){
        $('#calmsj').html('<div class="iconsuccess sprites"></div> '+msj);
        setTimeout('$("#covermsj").fadeOut(500);',4000);
        
        limpiar();
    }
    //fin mensajes transacciones
    mouseOverAll = false; 	
    $('#caloader').live('mouseenter', function(){
        mouseOverAll = true; 
    }).live('mouseleave', function(){ 
        mouseOverAll = false; 
    });
    function revisarTag(nombre){
        error = true;
        $('.tag-elegir').each(function(){
            este = $(this);
            if(este.html() == nombre){
                if(este.hasClass('tag-noselected')){
                    este.removeClass('tag-noselected');
                    este.addClass('tag-selected');
                }
                tags();
                error = false;
            } 
         })
         return error;
    }
    $('body').delegate('.borrarFotoEvento2','click',function(){
        var padre =  $(this).parent();
         padre.attr('style','');
         valorTemporal = padre.find('input').val();
         if(valorTemporal != ''){
             padre.find('input').val('');
         } 
//         padre.find('.borrarFotoEvento2').hide();
         return false;
    });
    $('body').delegate('#modificarclave','click',function(){
        claveactual = $('#clave-actual').val();
        clavenueva1 = $('#clave-nueva1').val();
        clavenueva2 = $('#clave-nueva2').val();
        //verificar su su contraseña es la actual
        $.ajax({
            url : '/findbreak/function/users-response.php',
            type : 'POST',
            data : 'comprobarClave=1&claveactual='+claveactual,
            success : function(res){
                
                if(res == 1){
                   if(trim(clavenueva1) != "" && trim(clavenueva2) != ""){
                       if(trim(clavenueva1) != trim(clavenueva2)){
                        loader('Las contraseñas no coinciden !');
                        return false;
                      }
                   }else{
                       loader('Las contraseñas no pueden estár vacias !');
                       return false;
                   }
                   $.ajax({
                            url : '/findbreak/function/users-response.php',
                            type : 'POST',
                            data : 'cambiarClave=1&clave='+clavenueva2,
                            success : function(res){

                                if(res == 1){
                                   loader('Contraseña modificada con éxito :)');
                                   $('#clave-actual').val('');
                                   $('#clave-nueva1').val('');
                                   $('#clave-nueva2').val('');
                                }else{
                                     loader('Tu contraseña no se pudo editar');
                                }
                            }                
                        });
                }else{
                     loader('Tu contraseña antigua no coincide');
                }
            }                
        });
        //
        
         return false;
    });
    $('.borrarFotoEvento').click(function(){
       var padre =  $(this).parent();
        var url = '../'+$(this).attr('data-url');
        var idEvento = $('#idevent').val();
        var nombre = $(this).attr('data-nombre');
        loader('Eliminando foto...');
        $.ajax({
            url : '/findbreak/function/event-response.php',
            type : 'POST',
            data : 'eliminarFoto=1&idEvento='+idEvento+"&urlBorrar="+url+"&nombreBorrar="+nombre,
            success : function(res){
                
                if(res == 1){
                    padre.attr('style','');
                    padre.find('.borrarFotoEvento').hide();
                    msjSucess('Foto eliminada con éxito');
                }else{
                     msjError('Error, error al eliminar la foto cod: 2');
                }
            }                
        });
        return false;
    })
    //hash-event
    $('#nom-event').keyup(function(){
        nombre = $(this).val();
        if(trim(nombre) == ""){
            $('#hash-event').val('');
            $('.hashtag-corr').hide();
            return false;
        }
        $.post('/findbreak/function/event-response.php', {'comprobarHashTag':1, 'conEspacios':nombre}, 
        function(data){
            if(data.re == 1){
                $('#hash-event').val(data.limpio);
                hashCorrecto();
            }else{
                $('#hash-event').val(data.limpio);
                hashInCorrecto()
            }
        }, "json");
        
    })
    function hashCorrecto(){
         $('.hashtag-incorr').hide();
         $('.error-hashtag').hide();
         $('.hashtag-corr').show();
    }
    function hashInCorrecto(){
        $('.hashtag-corr').hide();
        $('.error-hashtag').html('Este hashtag ya está en uso');
        $('.hashtag-incorr').show();
        $('.error-hashtag').show();
    }
    $('#hash-event').keyup(function(){
        nombre = $(this).val();
        nombreSinEsp = nombre.replace(/ /g,"");
        $('#hash-event').val(nombreSinEsp)
        if(trim(nombreSinEsp) == ""){
            //mostrar mensaje de que no puede estar vacio

            return false;
        }
        $.post('/findbreak/function/event-response.php', {'comprobarHashTag2':1, 'sinEspacios':nombreSinEsp}, 
        function(data){
            if(data.re == 1){
                $('#hash-event').val(data.limpio);
                 hashCorrecto()
            }else{
                $('#hash-event').val(data.limpio);
                 hashInCorrecto()
            }
        }, "json");
       
    })
    //editaruser
    $('#editaruser').click(function(){
         if(!validarCorreo($('#email').val())){
            loader('Correo electrónico inválido');
            return false;
         }
         guardar = true;
         $('.obligatorio').each(function(){
             valor = $(this).val();
             error = $(this).parent().find('.error-obligatorio');
             if(trim(valor) == ""){//si está vacío mostrar msj
                    guardar = false;
                    $(this).focus();
                     $('html, body').animate({
                         'scrollTop': $(this).offset().top - 90 + "px" 
                     },
                     {
                        duration:500,
                        easing:"swing"
                     }
                     );
                     error.fadeIn(200); 
                     return false;
             }else{
                      error.fadeOut(200); 
                 }
             
         })
         if(guardar){
            loader('Guardando cambios...');
            document.formulariousuario.submit();
         }
         
    }); 
    $('#guardarevento-form, #editarevento-form, #editarusuario-form').submit(function(){
        respuesta = true;
        //comprar al menos una foto>ZadaerWDJFG
        $('.obligatorio').each(function(){
             valor = $(this).val();
             error = $(this).parent().find('.error-obligatorio');
             if(trim(valor) == ""){//si está vacío mostrar msj
                    guardar = false;
                    $(this).focus();
                     $('html, body').animate({
                         'scrollTop': $(this).offset().top - 90 + "px" 
                     },
                     {
                        duration:500,
                        easing:"swing"
                     }
                     );
                     error.fadeIn(200); 
                     respuesta = false;
                     return  false;
                     
             }else{
                      error.fadeOut(200); 
                 }
             
         })
         return respuesta;
    });

    $('#guardarevento').click(function(){
         guardar = true;
         $('.obligatorio').each(function(){
             valor = $(this).val();
             error = $(this).parent().find('.error-obligatorio');
             if(trim(valor) == ""){//si está vacío mostrar msj
                    guardar = false;
                    $(this).focus();
                     $('html, body').animate({
                         'scrollTop': $(this).offset().top - 90 + "px" 
                     },
                     {
                        duration:500,
                        easing:"swing"
                     }
                     );
                     error.fadeIn(200); 
                     return false;
             }else{
                      error.fadeOut(200); 
                 }
             
         })
         if(!validarSiEsNumero($('#hour-event').val()) || !validarSiEsNumero($('#minute-event').val())){
             guardar = false;
             error = $('#hour-event').parent().find('.error-obligatorio');
                     $('html, body').animate({
                         'scrollTop': $('#hour-event').offset().top - 90 + "px" 
                     },
                     {
                        duration:500,
                        easing:"swing"
                     }
                     );
                     error.fadeIn(200); 
         }
         if(guardar){
            loader('Guardando Evento...');
            document.formularioevento.submit();
         }
         
    }); 
    $('#modificarevento').click(function(){
         guardar = true;
         $('.obligatorio').each(function(){
             valor = $(this).val();
             error = $(this).parent().find('.error-obligatorio');
             if(trim(valor) == ""){//si está vacío mostrar msj
                    guardar = false;
                    $(this).focus();
                     $('html, body').animate({
                         'scrollTop': $(this).offset().top - 90 + "px" 
                     },
                     {
                        duration:500,
                        easing:"swing"
                     }
                     );
                     error.fadeIn(200); 
                     return false;
             }else{
                      error.fadeOut(200); 
                 }
             
         })
         if(guardar){
            loader('Guardando Evento...');
            document.formularioevento.submit();
         }
         
    }); 
    $('#nuevo-tag-btn').click(function(){
        nuevotag = $('#nuevo-tag').val();
        if(trim(nuevotag) == ''){
            return false;
        }
        if(!revisarTag(nuevotag)){
            alert('La palabra que agregaste ya existe, por ende se agregó automáticamente')
            return false;
        }
        $.ajax({
                      type:"POST",
                      dataType:"html",
                      url:"/findbreak/function/event-response.php",
                      data:"nuevotag=1&nombre="+nuevotag,
                      success:function(data)
                      {
                          if(data == 1){
                            $('.content-tags').prepend('<div class="tag-elegir tag-selected">'+nuevotag+'</div>');
                            tags();
                          }
                      }
                  }); 
    })
    $('.mostrar-agre-tag').click(function(){
        $('.divmostrar-agre-tag').toggle();
        $('#nuevo-tag').focus();
        return false;
    })
    $('body').delegate('.tag-elegir','click',function(){
        este = $(this);
        if(este.hasClass('tag-noselected')){
            este.removeClass('tag-noselected');
            este.addClass('tag-selected');
        }else{
            este.removeClass('tag-selected');
            este.addClass('tag-noselected');
        }
        tags();
    });
     function tags(){
         tagsElegidos = '';
         $('.tag-elegir').each(function(){
            if($(this).hasClass('tag-selected')){
                tagsElegidos+= $(this).html()+',';
            }
         })
         $('#tags-hidden').val(tagsElegidos)
     }
    $('#date-event').datepick({ 
        multiSelect: 999, monthsToShow: 1, dateFormat: 'yyyy-mm-dd'
    });
    
    function mostrarImagenSubida(source, este){
        var    img  = document.createElement('img');
        img.src = source;
       
        este.css('background-image','url('+source+')');
        este.css('background-size','cover');
        este.css('background-position','0px 0px');
    }
    $('body').delegate('#images-galerias','change',function(evt){
            var i = 0, len = this.files.length, img, reader, file;
            var este = $(this).parent();
                 //for( ; i < len; i++){
                    file = this.files[0];
                    //Una pequeña validación para subir imágenes
                    if(!!file.type.match(/image.*/)){
                        //Si el navegador soporta el objeto FileReader
                        if(window.FileReader){
                            reader = new FileReader();
                            //Llamamos a este evento cuando la lectura del archivo es completa
                            //Después agregamos la imagen en una lista
                            reader.onloadend = function(e){

                                mostrarImagenSubida(e.target.result, este);
                            };
                            //Comienza a leer el archivo
                            //Cuando termina el evento onloadend es llamado
                            reader.readAsDataURL(file);
                        }
                    }
         });
    
      
      
  usernameCorrecto = false;
  function comprobarCampos(){
          error = false;
          $('.item-publicar input').each(function(){
              valor = $(this).val();
              if(trim(valor) == ""){
                  error = true;
              }
          })
          return error;
      }
  $('#coverall').delegate('#guardarusuario','click',function()
  {
       if(!validarCorreo($('#correo-usuario').val())){
           $('.todosloscampos .content-mensaje').html('Correo electrónico inválido');
           $('.todosloscampos').show();
           return false;
       }
       if(comprobarCampos()){
           $('.todosloscampos .content-mensaje').html('Debes completar todos los campos');
           $('.todosloscampos').show();
           return false;
       }else{
           $('.todosloscampos').hide();
       }
       if(usernameCorrecto == false){
           return false;
       }
        var nomeuser = $('#nombre-usuario').val();
        var username = $('#user-name').val();
        var correousuario = $('#correo-usuario').val();
        var claveusuario = $('#clave-usuario').val();
//        alert("adads"); return;
                        $.ajax({
                                 dataType:"html",
                                 url : '/findbreak/function/users-response.php',
                                 type : 'POST',
                                 data : "guardaruser=1&nomuser="+nomeuser+"&username="+username+"&correousuario="+correousuario+"&claveusuario="+claveusuario, 
                                 success : function(res){                      
                                     //modificar la foto con el mail
                                    
                                     if(res == 1){
                                          $.ajax({
                                                    type: "POST",
                                                    dataType: "JSON",
                                                    url: "/findbreak/function/login-response.php",
                                                    data: "login=1&mail="+correousuario+"&pass="+claveusuario,
                                                    success : function (data)
                                                    {  
                                                        if(data.exito)
                                                            { 
                                                                
                                                                if(data.usertype == 1){
                                                                  
                                                                  window.location.reload();//es usuario y recargo la página donde esté
                                                                }   
                                                            }
                                                    }
                                                })
                                     }else
                                        if(res == -5){
                                            $('.todosloscampos .content-mensaje').html("Lo sentimos, esta cuenta ya existe. ¿Te gustaría reclamar esta dirección de correo electrónico?");
                                             $('.todosloscampos').show();
                                         }
                                  }//success                
                              });
      
  })
    
      $('body').delegate('#user-name','keyup',function(e){
          username = $(this).val();
          if(username == ""){
              $('.username-incorr').hide();
              $('.username-corr').hide();
              return false;
          }
          $.post("/findbreak/function/users-response.php", {'comprobar-username':1,'username':username}, function(data){
              
               if(data == 1){//se puede
                    $('.username-corr').show();
                    $('.username-incorr').hide();
                    $('.error-username').hide();
                    usernameCorrecto = true;
                }else{
                    usernameCorrecto = false;
                    $('.todosloscampos').hide();
                    $('.username-incorr').show();
                    $('.username-corr').hide();
                    $('.error-username').show();
                    $('.error-username').html('Este nombre de usuario ya existe')
                } 
            }, "html");
      })
      
      
  //Aplicamos la subida de imágenes al evento change del input file
    $('body').delegate('#images-evento-upd','change',function(evt){
        num = $(this).attr('data-num');
        
        $(this).attr('name','images-evento-nueva'+num);
         
//        alert('a'); 
//        return false;
            var i = 0, len = this.files.length, img, reader, file;
            var este = $(this).parent();
                 //for( ; i < len; i++){
                    file = this.files[0];
                    //Una pequeña validación para subir imágenes
                    if(!!file.type.match(/image.*/)){
                        //Si el navegador soporta el objeto FileReader
                        if(window.FileReader){
                            reader = new FileReader();
                            //Llamamos a este evento cuando la lectura del archivo es completa
                            //Después agregamos la imagen en una lista
                            reader.onloadend = function(e){

                                mostrarImagenSubida(e.target.result, este);
                            };
                            //Comienza a leer el archivo
                            //Cuando termina el evento onloadend es llamado
                            reader.readAsDataURL(file);
                        }
                    }
        });
        //fotousuario
        $('body').delegate('#fotousuario','change',function(evt){
        num = $(this).attr('data-num');
        
       
         
//        alert('a'); 
//        return false;
            var i = 0, len = this.files.length, img, reader, file;
            var este = $(this).parent();
                 //for( ; i < len; i++){
                    file = this.files[0];
                    //Una pequeña validación para subir imágenes
                    if(!!file.type.match(/image.*/)){
                        //Si el navegador soporta el objeto FileReader
                        if(window.FileReader){
                            reader = new FileReader();
                            //Llamamos a este evento cuando la lectura del archivo es completa
                            //Después agregamos la imagen en una lista
                            reader.onloadend = function(e){

                                mostrarImagenSubida(e.target.result, este);
                            };
                            //Comienza a leer el archivo
                            //Cuando termina el evento onloadend es llamado
                            reader.readAsDataURL(file);
                        }
                    }
        });
   function trim(cadena){
        // USO: Devuelve un string como el parámetro cadena pero quitando los espacios en blanco de los bordes.
        var retorno=cadena.replace(/^\s+/g,'');
        retorno=retorno.replace(/\s+$/g,'');
        return retorno;
        }
  function validarSiEsNumero(numero){
         var expre = /^([0-9])*$/;
         if(expre.test(numero)){
             return true;
         }else{
             return false;
         }
  }
  function validarCorreo(correo){
         var expre = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
         if(expre.test(correo)){
             return true;
         }else{
             return false;
         }
  }

})

