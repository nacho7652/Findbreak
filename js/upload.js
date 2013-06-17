$(document).ready(function(){
    //mensajes transacciones
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
        $('#calmsj').html('<img class="iconerror" src="images/error.png"/> '+msj);
        setTimeout('$("#covermsj").fadeOut(500);',4000);
    }
    function loader(msj){
        $("#covermsj").fadeIn(0);	
        $("#covermsj > .innermsj").fadeIn(0);
        $('#calmsj').html(msj);
    }
    function msjSucess(msj){
        $('#calmsj').html('<img class="iconsuccess" src="images/s_success.png"/> '+msj);
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
         if(guardar){
            loader('Guardando galería...');
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
                tagsElegidos+= $(this).html()+' ';
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
                                 dataType:"JSON",
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
      
      
  
   function trim(cadena){
        // USO: Devuelve un string como el parámetro cadena pero quitando los espacios en blanco de los bordes.
        var retorno=cadena.replace(/^\s+/g,'');
        retorno=retorno.replace(/\s+$/g,'');
        return retorno;
        }
  
})

