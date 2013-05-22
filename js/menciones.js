$(document).ready(function(){
        
     largoUsuario = 0;
     focusFinal = 0;
      function reemplazar(){
          texto = $('#coment').val();
          partes = texto.split(" ");
          usuario = -1;
          yapaso = 0;
          // buscar cada palabra que contenga esto !#skumblue
          // a estas palabras se transformaran en <b>!#skumblue</b>
          for(i=0; i<partes.length; i++){
              if(partes[i].indexOf('#')!= -1){
                  
                  usuario = partes[i];
                  nueva = '<b>'+usuario+'</b>';
                  if(yapaso == 1){
                     textoHtml = textoHtml.replace(usuario, nueva);
                  }else{
                     textoHtml = texto.replace(usuario, nueva);  
                  }
                  yapaso = 1;
                  $('#replica').html(textoHtml);
              }
          }
          if(usuario == -1)// no hay citas
              {
                  $('#replica').html(texto);
              }
      }
      function conocerElFocus(){
          texto = $('#coment').val();
          for(i=0; i<texto.length; i++){
              if(texto[i] == '@'){
                  break;
              }
          }
          
          return i;
      }
      function conocerElFocusFinal(){
                        
          //conocer el largo del usuario si aprete arroa
          if(focusArroa != false || focusArroa == 0){
              //tomo el nombre de usuario y tomo el largo
                var id = $('.itemCitar.itemCitarSelected').attr('data-id');
                var nombre = $('.itemCitar.itemCitarSelected').find('.item-friends-username').html();
                nuevoTexto = $('#coment').val();
//                usuarioAcitar = '!#skumblue1';
                usuarioAcitar = nombre;
                largoUsuario = usuarioAcitar.length + 3;//mas dos por el !#
                 largoUsuarioRetur = largoUsuario;
                 largoUsuario = 0;
//                 alert('largo user: '+largoUsuarioRetur)
//                 alert('focus arroa: '+focusArroa)
                 focusFinal = largoUsuarioRetur+focusArroa;
                
          }
      }
      function conocerElFocusFinalClick(nombre){
                        
          //conocer el largo del usuario si aprete arroa
//          if(focusArroa != false || focusArroa == 0){
              //tomo el nombre de usuario y tomo el largo
//                var id = $('.itemCitar.itemCitarSelected').attr('data-id');
//                var nombre = $('.itemCitar.itemCitarSelected').find('.item-friends-username').html();
                nuevoTexto = $('#coment').val();
//                usuarioAcitar = '!#skumblue1';
                usuarioAcitar = nombre;
                largoUsuario = usuarioAcitar.length + 3;//mas dos por el !#
                 largoUsuarioRetur = largoUsuario;
                 largoUsuario = 0;
//                 alert('largo user: '+largoUsuarioRetur)
//                 alert('focus arroa: '+focusArroa)
                 focusFinal = largoUsuarioRetur+focusArroa;
                
//          }
      } 
       
      function HayArroa(){
          hayArroa = false;
          partes = $('#coment').val();
          for(i=0; i<partes.length; i++){
              if(partes[i].indexOf('@')!= -1){
                  hayArroa = true;
                  break;
              }
          }
          return hayArroa;
      }
      c=1;
      function citar(nombre){
          //tengo que sacar el nickname del usuario seleccionado
          //luego saco su largo y era
          texto = $('#coment').val();
          partes = texto.split(" ");
          usuario = -1;
          yapaso = 0;
          cursor = $('#coment').val().length;
          // buscar cada palabra que contenga esto !#skumblue
          // a estas palabras se transformaran en <b>!#skumblue</b>
          for(i=0; i<partes.length; i++){
              if(partes[i].indexOf('@')!= -1){
                  arroa = partes[i];
                  //buscar el 
                  usuario = '#'+nombre; //el que se encuentra en la base de datos
                  c++;
                  nueva = '<b>'+usuario+'</b> ';
                  nuevaplano = usuario+' '
                  if(yapaso == 1){
                     textoHtml = textoHtml.replace(arroa, nueva);
                     textoPlano = textoHtml.replace(arroa, nuevaplano);
                  }
                  else{
                     textoHtml = texto.replace(arroa, nueva);
                     textoPlano = texto.replace(arroa, nuevaplano);
                  }
                  yapaso = 1;
                  $('#replica').html(textoHtml);
                  $('#coment').val(textoPlano);
              }
          }
      }
      
      function setSelectionRange(input, selectionStart, selectionEnd) {
        if (input.setSelectionRange) {
          input.focus();
          input.setSelectionRange(selectionStart, selectionEnd);
        }
        else if (input.createTextRange) {
          var range = input.createTextRange();
          range.collapse(true);
          range.moveEnd('character', selectionEnd);
          range.moveStart('character', selectionStart);
          range.select();
        }
      }

        function setCaretToPos (input, pos) {
          setSelectionRange(input, pos, pos);
        }

     function tobr(){
         textoPlano1 = $('#replica').html().replace(/ /g,'&nbsp;');
         textoPlano = textoPlano1.replace(/\n/g,'<br>');
         $('#replica').html(textoPlano)
//         alert($('#replica').html());
//         alert($('#coment').val());
//              textoPlano = $('#replica').html().replace(/ /g,'&nbsp;');
//              $('#replica').html(textoPlano) 
//              $.post('/findbreak/function/users-response.php', {'reemplazarBr':1,'textoPlano':textoPlano},
//                    function(data){   
//                        $('#replica').html(data)       
//                    }, "html");
      }
      
        
        $('body').delegate('#coment','keyup',function(e){ 
           // alert('dsaads')
//           alert(e.keyCode)
//           alert('key up')
         
           if($('.amigosCitar').is(':visible')){
                   conocerElFocusFinal();
                   if(e.keyCode == 40){//abajo
                      
                        //si estoy en el ultimo no haga nada
                        setCaretToPos(document.getElementById('coment'), parseInt(focusFinal))
                       if( $('.amigosCitar .itemCitar:last-child').hasClass('itemCitarSelected')){
                             selected = $('.itemCitar.itemCitarSelected');
                             nuevo = $('.itemCitar:first');
                             selected.removeClass('itemCitarSelected');
                             nuevo.addClass('itemCitarSelected');
                             return false;
                        }
                        selected = $('.itemCitar.itemCitarSelected');
                        nuevo = selected.next('.itemCitar');
                        selected.removeClass('itemCitarSelected');
                        nuevo.addClass('itemCitarSelected');
                        
                       return false;
                  }
                  if(e.keyCode == 38){
                       //si estoy en el primero no haga nada
//                      conocerElFocusFinal();
                      setCaretToPos(document.getElementById('coment'), parseInt(focusFinal))
                      if( $('.amigosCitar .itemCitar:first-child').hasClass('itemCitarSelected')){
                             selected = $('.itemCitar.itemCitarSelected');
                             nuevo = $('.itemCitar:last');
                             selected.removeClass('itemCitarSelected');
                             nuevo.addClass('itemCitarSelected');
                             return false;
                      }
                      selected = $('.itemCitar.itemCitarSelected');
                      nuevo = selected.prev('.itemCitar');
                      selected.removeClass('itemCitarSelected');
                      nuevo.addClass('itemCitarSelected');
                       
                       return false;
                  }
          }
          
                textoAmigo = $(this).val();
                //alert(textoAmigo)
                $.post('/findbreak/function/users-response.php', {'search-friend-cit-arroa':1,'textoAmigo':textoAmigo},
                    function(data){   
                                //alert(data)
                                if(data == ''){
                                    $('.amigosCitar').hide();
                                    $('.amigosCitar').html(data);
                                    $('.itemCitar:first').addClass('itemCitarSelected');
                                }else{
                                    $('.amigosCitar').show();
                                    $('.amigosCitar').html(data);
                                    $('.itemCitar:first').addClass('itemCitarSelected');
                                }
                    }, "html");
        })
      
      focusArroa = false;
      apretoFuera = false;
      $('body').delegate('#coment','keyup',function(e){
          if(e.keyCode == 81){
           focusArroa = conocerElFocus();
          }
         
          
          if(e.keyCode == 13){
             //si no hay arroa no haga nada
             if(HayArroa() || apretoFuera){
                
                var id = $('.itemCitar.itemCitarSelected').attr('data-id');
                var nombre = $('.itemCitar.itemCitarSelected').find('.item-friends-username').html(); 
                citar(nombre);
                reemplazar();
                conocerElFocusFinal();
                setCaretToPos(document.getElementById('coment'), parseInt(focusFinal))
                focusFinal = 0;
                focusArroa = false;
                apretoFuera = false;
             }
             reemplazar();
             
          }
          else{
              reemplazar();
          }
             tobr();
      })
     
    
       
        
        amigosCitVisible = false;
        function mostrarAmigosCitar(){
            $('.amigosCitar').toggle();
            if($('.amigosCitar').is(':visible')){
                amigosCitVisible = true;
            }else{
                amigosCitVisible = false;
            }
            
            $.post('/findbreak/function/users-response.php', {'search-friend-cit':1,'textoAmigo':''},
                    function(data){   
//                        alert(data)
                                $('.amigosCitar').html(data)
                    }, "html");
        }
        $('body').delegate('.divcitar','click',function(){
            mostrarAmigosCitar();
        })
        //itemCitar
        $('body').delegate('.itemCitar','click',function(){
            var id = $(this).attr('data-id');
            var nombre = $(this).find('.item-friends-username').html();
            $('#coment').val($('#coment').val()+ ' #'+nombre)
//            citar(nombre)
//            alert(nombre)
            reemplazar();
//            conocerElFocusFinalClick(nombre);
//            setCaretToPos(document.getElementById('coment'), parseInt(focusFinal))
//            focusFinal = 0;
//            focusArroa = false;
            tobr();
        })
       
      //autoresize
        //<![CDATA[
        $('body').delegate('.textoajustable','keyup',
                $('.textoajustable').autoResize({
                        // Al redimensionar
                        onResize : function() {

                          $(this).css({opacity:0.8});
                        },
                        // Llamar efecto despues de redimensionar:
                        animateCallback : function() {
                            $(this).css({opacity:1});
        //                    $(this).css({'background-color':'#A39565'});
                        },
                        // Diración de la animación:
                        animateDuration : 300,
                        // Limite en pixeles hasta los que se va a expandir
                        // pasado el límite genera el scroll tradicional, valor por defecto 1000px
                        limit : 300,
                        // Espacio Extra al final del texto:
                        extraSpace : 30
                  })
           );     

        
      //  ]]>

});        