$(document).ready(function(){
    
    //Informacion publicar evento hecho por el mejor programador de la tierra daniel millar
    
    $('#info-publicar').hover(function(){
        
        $('#info-mostrar').show();
        
    })
    $('#info-mostrar').mouseleave(function(){
        
        $('#info-mostrar').hide();
        
    })
    
    //fin info-publicar
    
    
  padre = 0;
        $('#login-fb').mouseover(function(){
           $(this).css('background','url(/mooff/images/login-face-sprite.png) -82px -24px no-repeat');
           $('#loginbtn-fb').css('background','url(/mooff/images/loginbtn-face-sprite.png) -0px -24px no-repeat')
       })
       $('#login-fb').mouseleave(function(){
           $(this).css('background','url(/mooff/images/login-face-sprite.png) top right no-repeat');
           $('#loginbtn-fb').css('background','url(/mooff/images/loginbtn-face-sprite.png) top right no-repeat')
       })
        //inicio
        $('.redir-cerca').hover(function(){
          //  alert('sadsda')
            $('.pincerca').css('background-position','56px -612px');
        })
        $('.redir-cerca').mouseleave(function(){
            $('.pincerca').css('background-position','54px -533px');
        })
       //cerca
          $('body').delegate('.botonitemcerca','click',function(){
              var item = $(this).parent().parent().parent();
             
               $('body, html').animate({
                         'scrollTop': item.offset().top - 200 + "px" 
                     },
                     {
                        duration:500,
                        easing:"swing"
                     }
                     );
                  
                 $('.coment-cerca').fadeOut(100);
                 $('.coment-cerca .list .boxscroll').html('');
                 idevento = item.attr('data-id');
                 hashevent = item.attr('data-hash');
                 $.ajax({           
                            type:"POST",
                            dataType:"html",
                            url: "/findbreak/function/event-response.php",
                            data: "mostrar-coment-cerca=1&idevento="+idevento+'&hashevent='+hashevent,
                            success: function (data)
                            {   
                                item.find('.coment-cerca .list.boxscroll').html(data)
                                item.find('.coment-cerca').fadeIn(100)
                                item.find('#coment').focus()
                            }
                        })
            
               
             //$(".boxscroll").niceScroll({cursorborder:"rgb(185, 185, 185)",cursorcolor:"rgb(185, 185, 185)",boxzoom:false, cursorwidth:9}).cursor.css({"right":"3px"}); // MAC like scrollbar; // First scrollable DIV

          })
       
       //fin cerca
        
        /*CERRAR CON CLICK*/
        var cerrarNoti = true;
        $('.noti-friend').hover(function(){
            cerrarNoti = false;
        }, 
        function(){
            cerrarNoti = true;
        });
        $('body, html').click(function(){
            if(cerrarNoti){
                $('#show-solicitud').hide();
            }
        })
        
        
        var cerrarCit = true;
        $('body').delegate('.divcitar','hover',function(){
             cerrarCit = false;
        })
        $('body').delegate('.divcitar','mouseleave',function(){
            cerrarCit = true;
        })
//        $('.divcitar').hover(function(){
//            cerrarCit = false;
//        }, 
//        function(){
//            cerrarCit = true;
//        });
        $('body, html').click(function(){
            if(cerrarCit){
                $('.amigosCitar').hide();
            }
        })
        /*CERRAR CON CLICK FIN*/
        
        /* COVERALL   ***************************************************** */
	mouseOverAll = false; 	
	$('#caloader').live('mouseenter', function(){
	    mouseOverAll = true; 
	}).live('mouseleave', function(){ 
	    mouseOverAll = false; 
	});
        function popup(data){
          $("html").css("overflow","hidden");
          $("#top").css("right","8px");
          $(".eventprofile").css("right","8px");
          $('#allbackground').show();
          $('#coverall').show();
          $("#coverall > .innercal").fadeIn(0);
          $('#caloader').html(data);
      }
	function coverallclose(){	
		$("#coverall").fadeOut(0, 
			function(){
				$("#coverall > .innercal").css("display", "none");
                                $('#allbackground').hide();
				$("html").css("overflow-y", "scroll");
                                $("#top").css("right","0px");
                                $(".eventprofile").css("right","0px");
				$("#caloader").html("");								
			}
		);
	}
	$("#coverall").click(
		function(){
			if (!mouseOverAll){
				coverallclose();
                                
			}			
        });
        
        //popupmensajes
        mouseOverAllmsj = false; 	
	$('.innermsj').live('mouseenter', function(){
	    mouseOverAllmsj = true; 
	}).live('mouseleave', function(){ 
	    mouseOverAllmsj = false; 
	});
        $("#covermsj").click(function(){
			if (!mouseOverAllmsj){
				covermsjclose();    
			}			
        });
        function covermsjclose(){	
		$("#covermsj").fadeOut(0, 
			function(){
				$("#covermsj > .innermsj").css("display", "none");
                                $("#top").css("right","0px");
                                $("#body").css("right","0px");
                                $('#covermsj').hide();
				$("html").css("overflow-y", "scroll");
				$("#calmsj").html("");								
			});
	}
    function preguntar(pregunta, cuerpo, pie){
            $("#covermsj").fadeIn(0);
            $(".innermsj").fadeIn(0);
            $('#calmsj').html(pregunta+cuerpo+pie);
    }    
    $('body').delegate('#cancelar','click',function(){
           covermsjclose();
    })    
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

        }
//        $('.menutop').hover(function(){
//            $(this).animate({
//                         'height': '70px',
//                         'margin-bottom': '30px' 
//                     },
//                     {
//                        duration:200,
//                        easing:"swing"
//                     }
//                     );
//        }, function(){
//            $(this).animate({
//                         'height': '50px',
//                         'margin-bottom': '0px'
//                     },
//                     {
//                        duration:200,
//                        easing:"swing"
//                     }
//                     );
//        });
        //PERFIL EVENTO
        $('.readmore').click(function(){
            if($('.descripcion-event').css('max-height') == '115px'){
                $('.descripcion-event').css('max-height','none')
                $(this).html('Leer menos...');
            }else{
                $('.descripcion-event').css('max-height','115px');
                $(this).html('Leer más...');
            }
            return false;
        })
        $('body').delegate('.leermas-coment','click',function(){
            var id = $('#idevent').val();
            var ultimoComentario = $('.list .itemcoment:last').attr('data-num');
            var totalComent = $('#totalComent').val();
            var hashevent = $('#hashevent').val();
            ultimoComentario++;
//            alert(ultimoComentario);
//            alert(totalComent)
            $.ajax({           
                type:"POST",
                dataType:"html",
                url: "/findbreak/function/comentario-response.php",
                data: "vermascomentarios=1&ultimo="+ultimoComentario+'&eventid='+id+'&hashevent='+hashevent+'&totalComent='+totalComent,
                success: function (data)
                {   
                    $('.list').html(data);
                    $('.list').attr('style','outline: none; tabindex="5000; overflow-y:none"');
//                    $('.list').animate({
//                         'scrollTop': $('.leermas-coment').offset().top + "px" 
//                     },
//                     {
//                        duration:500,
//                        easing:"swing"
//                     }
//                     );
                }
            })  
            return false;
        })
        function descontarNotificacion(){
            var count = parseInt($('#cant-solicitud').html());
            count--;
            $('#cant-solicitud').html(count);
        }
        $('body').delegate('.not1','click',function(){
            var id = $(this).attr('id');
            if($(this).hasClass('norevi')){
                $(this).removeClass('norevi');
                descontarNotificacion();
            }
            $.ajax({           
                type:"POST",
                dataType:"html",
                url: "/findbreak/function/comentario-response.php",
                data: "vercomentario=1&id="+id,
                success: function (data)
                { 
                    
                    popup(data);
                }
            })   
        })
        var overcoment = false;
        $('.coments').hover(function(){
            
            overcoment = true;
        })
        $('.coments').mouseleave(function(){
           
            overcoment = false;
        })
        $('body').delegate('#coment','focus',function(){
            $('.showfocuscom').show();
        })  
        $('body').delegate('.itemcoment','hover',function(){
            $(this).find('.aparececom').show();
        })
        $('body').delegate('.itemcoment','mouseleave',function(){
            $(this).find('.aparececom').hide();
        })
        $('body').delegate('#coment','focus',function(){
            $('.list').attr('style','outline: none; tabindex="5000; overflow-y:none"');
        })
       
        $('body').delegate('#btn-comentar','click',function(){
         padre = $(this).parent().parent().parent().parent().parent();
         var coment = padre.find('#coment').val();
         var eventid = padre.find('#idevent').val();
         var nombreevent = padre.find('.title-event').html();
         var hashevent = padre.find('#hashevent').val();
         var totalComent = padre.find('#totalComent').val();
         var ultimoComentario = padre.find('.list .itemcoment:last').attr('data-num');
         ultimoComentario = parseInt(ultimoComentario) +2;
         totalComent++;
         
         $.ajax({           
             type:"POST",
             dataType:"html",
             url: "/findbreak/function/comentario-response.php",
             data: "comentevent=1&comentario="+coment+"&eventId="+eventid+"&hashevent="+hashevent+"&nombreevent="+nombreevent+'&totalComent='+totalComent+"&ultimo="+ultimoComentario,
             success: function (data)
             {
                 padre.find('.showfocuscom').hide();
                 padre.find('#coment').css('height','16px');
                 padre.find('#coment').val('');
                 padre.find('.list').html(data);
                 padre.find('#replica').html('');
                 padre.find('.list').attr('style','outline: none; tabindex="5000; overflow-y:none"');
                 //sumar evento
                
                 cantidadComentarios = (parseInt(padre.find('#totalComent').val())  + 1)
                 padre.find('#totalComent').val(cantidadComentarios)
                 if(cantidadComentarios == 0){
                                            textoComentario = 'Se el primero en comentar!';
                                        }else
                                            if(cantidadComentarios == 1){
                                            textoComentario = 'Un comentario';
                                        }else{
                                            textoComentario = '<span class="bold">'+cantidadComentarios+'</span> Comentarios';
                                        }
                 padre.find('#comentaevent-prof').html(textoComentario);
                
                 padre.find('.list').animate({
                     'scrollTop': "0px" 
                 },
                 {
                    duration:500,
                    easing:"swing"
                 }
                 );
             }
           })
        })
        //preguntar(pregunta, cuerpo, pie)
          var itemComentario;
          $('body').delegate('#delcoment','click',function(){
               padre = $(this).parent().parent().parent().parent().parent().parent();
              itemComentario = $(this).parent().parent();
              var dataid = $(this).attr('data-id');
              var pregunta = '<div class="bloq1msj">¿Realmente deseas borrar este comentario?</div>';
              var nombre = $(this).parent().parent().find('.nomusercom').html();
              var foto = $(this).parent().parent().find('.bloq1').css('background');
              var tiempo = $(this).parent().parent().find('.hacecuant').html();
              var comentario = $(this).parent().parent().find('.comentuser').html();
              
              var cuerpo = '<div class="bloq2msj"><div class="itemcomentmsj">';
                  cuerpo+=   '<div style="background: url('+foto+')" class="bloq1"></div>';
                  cuerpo+=   '<div class="bloq2msjinner">';
                  cuerpo+=       '<div class="nomusercom tit-gray">'+nombre+'</div>';
                  cuerpo+=       '<div class="comentuser">'+comentario+'</div>';
                  cuerpo+=   '</div>';
                  cuerpo+= '<div class="bloq3msjinner">';
                  cuerpo+=    '<div class="hacecuant">'+tiempo+'</div>';
                  cuerpo+= '</div></div></div>';
             
             var pie = '<div class="bloq3msj"><div data-id="'+dataid+'" id="aceptarcoment" class="botonblue">Aceptar</div>';
                 pie+= '<div id="cancelar" class="botoncancel">Cancelar</div></div>';
                 
                
              preguntar(pregunta, cuerpo, pie)
          });
        //delcoment
        $('#covermsj').delegate('#aceptarcoment','click',function(){
           
           var dataid = $(this).attr('data-id');
         
            $.ajax({           
               type:"POST",
               dataType:"html",
               url: "/findbreak/function/comentario-response.php",
               data: "delcoment=1&dataid="+dataid,
               success: function (data)
               {
                 //sumar evento
                    cantidadComentarios = (parseInt(padre.find('#totalComent').val())  - 1)
                    $('#totalComent').val(cantidadComentarios)
                    if(cantidadComentarios == 0){
                                               textoComentario = 'Se el primero en comentar!';
                                           }else
                                               if(cantidadComentarios == 1){
                                               textoComentario = 'Un comentario';
                                           }else{
                                               textoComentario = '<span class="bold">'+cantidadComentarios+'</span> Comentarios';
                                           }
                    $('#comentaevent-prof').html(textoComentario);
                 ///
                   if(data == 1){
                    covermsjclose();
                    itemComentario.remove();
                   }
                   
               }
           })
        })
       
        //FIN PERFIL EVENTO
        
        $('#user-login .option').hover(function(){
            $(this).find('.content-option').css('color','rgba(255, 255, 255, 0.86)');
        })
        $('#user-login .option').mouseleave(function(){
            $(this).find('.content-option').css('color','rgb(219, 219, 219)');
        })
        var colorfocus = 'rgb(104, 104, 104)';
        var colorfocusout = 'rgb(145, 145, 145)';
        $('#search').focus(function(){
            if($(this).val() == 'Fiestas, deportes, arte, etc.'){
                $(this).css('color',colorfocus);
                $(this).val('');
            }
        })
        $('#search').focusout(function(){
            if($(this).val() == ''){
                $(this).css('color',colorfocusout);
                $(this).val('Fiestas, deportes, arte, etc.');
            }
        })
        
        $('#search-near').focus(function(){
            if($(this).val() == 'BUSCA LO QUE QUIERAS...'){
                $(this).css('color',colorfocus);
                $(this).val('');
            }
        })
        $('#search-near').focusout(function(){
            if($(this).val() == ''){
                $(this).css('color',colorfocusout);
                $(this).val('BUSCA LO QUE QUIERAS...');
            }
        })
         $('#search-location').focus(function(){
            if($(this).val() == 'UBICACIÓN ACTUAL'){
                $(this).css('color',colorfocus);
                $(this).val('');
                desactivarLocacion();
            }
        })
        $('#search-location').focusout(function(){
            if($(this).val() == ''){
                $(this).css('color',colorfocusout);
                $(this).val('UBICACIÓN ACTUAL');
                 //activarLocacion();
            }
        })
        //reset location
        $('#boton-location').click(function(){
            if($(this).hasClass('loc-desactivado')){
                activarLocacion();
            }else{
                desactivarLocacion();
                $('#search-location').val('UBICACIÓN ACTUAL');
            }
        });
        
        function activarLocacion(){
                $('#boton-location').removeClass('loc-desactivado');
                $('#boton-location').addClass('loc-activado');
        }
        function desactivarLocacion(){
                $('#boton-location').removeClass('loc-activado');
                $('#boton-location').addClass('loc-desactivado');
        }
        
        var outMenuCont = false;
        $(".menu,.groupoption").mouseover(function(){
            outMenuCont = true;
        });
        $(".menu, .groupoption").mouseout(function(){
            outMenuCont = false;
        });
        $('body, html').click(function(){
            
            if(!outMenuCont){
                 $(".groupoption").hide();
            }
        })
       $('.menu').click(function(){
            $('.groupoption').toggle();
        });
        
        /* HOME */
        $('#coverall').delegate('.noaccept','click',function(){
            coverallclose();
        });

         $('#coverall').delegate('.accept','click',function(){
            coverallclose();
        });
        function sumarchar(num){
            $('.restante'+num).html( 180 - parseInt($('.respuesta'+num).val().length));
        }
        $('.respuesta2').keyup(function(){
            sumarchar("2"); 
        })
        $('.respuesta4').keyup(function(){
            sumarchar("4"); 
        })
        $('.respuesta7').keyup(function(){
            sumarchar("7"); 
        })
//        $('.respuesta').focusout(function(){
//            if($(this).val())
//            $(this).css('height','19px');
//        })
        $('.responder').click(function(){
                //2 4 7 abiertas
                var alt1 = "No";
                var alt2 = "No";
                var alt3 = "No";
                var alt4 = "No";
                var alt5 = "No";
                var alt6 = "No";
                var alt7 = "No";
                
                if($('.alt1').find('.respuestasi').is(":checked")){
                    alt1 = "Si";
                }
                alt2 = $('.respuesta2').val();
                 if(trim(alt2) == ""){
                     $('html, body').animate({
                         'scrollTop': $('.respuesta2').offset().top - 25 + "px" 
                     },
                     {
                        duration:500,
                        easing:"swing"
                     }
                     );
                     $('.error2').fadeIn(200); 
                     return false;
                 }else{
                      $('.error2').fadeOut(200); 
                 }
                 
                if($('.alt3').find('.respuestasi').is(":checked")){
                    alt3 = "Si";
                }
                
                 alt4 = $('.respuesta4').val();
//                 if(trim(alt4) == ""){
//                      $('html, body').animate({
//                         'scrollTop': $('.respuesta4').offset().top - 25 + "px" 
//                     },
//                     {
//                        duration:200,
//                        easing:"swing"
//                     }
//                     );
//                     $('.error4').fadeIn(200); 
//                     return false;
//                 }else{
//                      $('.error4').fadeOut(200); 
//                 }
                 
                 if($('.alt5').find('.respuestasi').is(":checked")){
                    alt5 = "Si";
                }
                
                if($('.alt6').find('.respuestasi').is(":checked")){
                    alt6 = "Si";
                }
                 
                alt7 = $('.respuesta7').val();
                 if(trim(alt7) == ""){
                      $('html, body').animate({
                         'scrollTop': $('.respuesta7').offset().top - 25 + "px" 
                     },
                     {
                        duration:500,
                        easing:"swing"
                     }
                     );
                     $('.error7').fadeIn(200); 
                     return false;
                 }else{
                      $('.error7').fadeOut(200); 
                 }
                 var mail = $('.mailproductora').val();
             //  alert(alt1);alert(alt2);alert(alt3);alert(alt4);alert(alt5);alert(alt6);alert(alt7);return false;
            $.post('../json/zoom.php', {'responder':1,'mail':mail,'alt1':alt1,'alt2':alt2,'alt3':alt3,'alt4':alt4,'alt5':alt5,'alt6':alt6,'alt7':alt7},
                    function(data){
                                $("html").css("overflow", "hidden");
				$("#coverall").fadeIn(0);	
				$("#coverall > .innercal").fadeIn(0);					
                                $('#caloader').html(data.re);
                    }, "json");
            return false;
           });        
           
      /**********/
      /* LANDING*/
      $('.button-usuario').hover(function(){
          $.post('../json/zoom.php', {'info-rol':1,'user':1},
                    function(data){
                                $("html").css("overflow", "hidden");
				$("#coverall").fadeIn(0);	
				$("#coverall > .innercal").fadeIn(0);					
                                $('#caloader').html(data.re);
                    }, "json");
         $('#fondouser').css("background","url('images/botones/fondo-roles-sprite.png') no-repeat 0px -50px");
      },function(){
          $('#fondouser').css("background","url('images/botones/fondo-roles-sprite.png') no-repeat 0px 0px");
      });
      
      $('.button-productora').hover(function(){
         $('#fondoproductora').css("background","url('images/botones/fondo-roles-sprite.png') no-repeat -47px -49px");
      },function(){
          $('#fondoproductora').css("background","url('images/botones/fondo-roles-sprite.png') no-repeat  -45px 1px");
      });
      
      $('.button-proveedor').hover(function(){
         $('#fondoproveedor').css("background","url('images/botones/fondo-roles-sprite.png') no-repeat -100px -49px");
      },function(){
          $('#fondoproveedor').css("background","url('images/botones/fondo-roles-sprite.png') no-repeat  -97px 0px");
      });
      
      $('.button-establecimiento').hover(function(){
         $('#fondoestablecimiento').css("background","url('images/botones/fondo-roles-sprite.png') no-repeat -154px -53px");
      },function(){
          $('#fondoestablecimiento').css("background","url('images/botones/fondo-roles-sprite.png') no-repeat  -152px -1px");
      });
      //Busqueda de amigos
      var outLoginCont = false;
       $("#hover-response").mouseover(function(){
           outLoginCont = true;
       });
       $("#hover-response").mouseout(function(){
           outLoginCont = false;
       });
       $('body, html').click(function(){
           if(!outLoginCont){
                $("#response-friend").hide();
           }
       })
       
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
        $('body').delegate('.item-search','hover',function(){
            $('.item-search').removeClass('itemCitarSelected');
            $(this).addClass('itemCitarSelected');
        });
      $('#search-ini').keyup(function(e){
           focusFinalBus = $('#search-ini').val().length;
          if(e.keyCode == 32 && trim($('#search-ini').val()) == false ){//si apreto espacio muestro los más populares
              
              $('#search-ini').val('')
              $.ajax({
              
                    type: "POST",
                    dataType: "json",
                    url: "/findbreak/function/event-response.php",// url: "../function/users-response.php",
                    data: "search-space=1", 
                    success : function(data) // data = cuadro
                    {  
                       if(data.hay){

                            $('#eventresponse').show();
                            $('#eventresponse').html(data.re);
                       }else{
                           $('#eventresponse').show();
                           $('#eventresponse').html("<div class='nohaycoinci'>No hay coincidencias</div>");
                       }

                    }

                })
              setCaretToPos(document.getElementById('search-ini'), 0);
              return;
          }
      
         
          if(e.keyCode == 13){//enter
              var redirec = $('.item-search.itemCitarSelected').attr('href');
              location.href = redirec;
          }
          if(e.keyCode == 40){//abajo
                       //$('.item-search').removeClass('itemCitarSelected');
                       setCaretToPos(document.getElementById('search-ini'), parseInt(focusFinalBus))
                       if( $('#eventresponse .item-search:last-child').hasClass('itemCitarSelected')){
                             selected = $('.item-search.itemCitarSelected');
                             nuevo = $('.item-search:first');
                             selected.removeClass('itemCitarSelected');
                             nuevo.addClass('itemCitarSelected');
                             return false;
                        }
                        selected = $('.item-search.itemCitarSelected');
                        nuevo = selected.next('.item-search');
                        selected.removeClass('itemCitarSelected');
                        nuevo.addClass('itemCitarSelected');
                        
                       return false;
                  }
                  if(e.keyCode == 38){
                    //  $('.item-search').removeClass('itemCitarSelected');
                       //si estoy en el primero no haga nada 
                      setCaretToPos(document.getElementById('search-ini'), parseInt(focusFinalBus))
                      if( $('#eventresponse .item-search:first-child').hasClass('itemCitarSelected')){
                             selected = $('.item-search.itemCitarSelected');
                             nuevo = $('.item-search:last');
                             selected.removeClass('itemCitarSelected');
                             nuevo.addClass('itemCitarSelected');
                             return false;
                      }
                      selected = $('.item-search.itemCitarSelected');
                      nuevo = selected.prev('.item-search');
                      selected.removeClass('itemCitarSelected');
                      nuevo.addClass('itemCitarSelected');
                       
                       return false;
                  }
                  
          var textoAmigo = $('#search-ini').val();
          if(textoAmigo == ""){
              $('#eventresponse').html("");
              $('#eventresponse').hide();
              return;
          }
          $.ajax({
              
              type: "POST",
              dataType: "json",
              url: "/findbreak/function/event-response.php",// url: "../function/users-response.php",
              data: "search-ini=1&busqueda="+textoAmigo, 
              success : function(data) // data = cuadro
              {     
                 if(data.hay){
                     
                      $('#eventresponse').show();
                      $('#eventresponse').html(data.re);
                 }else{
                     $('#eventresponse').show();
                     $('#eventresponse').html("<div class='nohaycoinci'>No hay coincidencias</div>");
                 }
              
              }
              
          })
          
          
      })
      
      $('#search').keyup(function(e){
           focusFinalBus = $('#search').val().length;
          if(trim($('#search').val()) == false ){//si apreto espacio muestro los más populares
             
              $('#search').val('')
              $('#response-friend').hide();
              setCaretToPos(document.getElementById('search'), 0);
              return;
          }
      
         
          if(e.keyCode == 13){//enter
              var redirec = $('.item-search.itemCitarSelected').attr('href');
              location.href = redirec;
          }
          if(e.keyCode == 40){//abajo
                       //$('.item-search').removeClass('itemCitarSelected');
                       setCaretToPos(document.getElementById('search'), parseInt(focusFinalBus))
                       if( $('#response-friend .item-search:last-child').hasClass('itemCitarSelected')){
                           
                             selected = $('.item-search.itemCitarSelected');
                             nuevo = $('.item-search:first');
                             selected.removeClass('itemCitarSelected');
                             nuevo.addClass('itemCitarSelected');
                             return false;
                        }
                        selected = $('.item-search.itemCitarSelected');

                        if(selected.next('.item-search').html() == null){//si es el titulo
                            nuevo = $('.title-search-item2').next('.item-search');
                            selected.removeClass('itemCitarSelected');
                            nuevo.addClass('itemCitarSelected');
                        }else{
                            
                            nuevo = selected.next('.item-search');
                            selected.removeClass('itemCitarSelected');
                            nuevo.addClass('itemCitarSelected');
                       }
                       return false;
                  }
                  if(e.keyCode == 38){
                    //  $('.item-search').removeClass('itemCitarSelected');
                       //si estoy en el primero no haga nada 
                      setCaretToPos(document.getElementById('search'), parseInt(focusFinalBus))
                      if( $('#response-friend .item-search:first-child').hasClass('itemCitarSelected')){
                             selected = $('.item-search.itemCitarSelected');
                             nuevo = $('#response-friend .item-search:last');
                             selected.removeClass('itemCitarSelected');
                             nuevo.addClass('itemCitarSelected');
                             return false;
                      }
                      selected = $('.item-search.itemCitarSelected');

                        if(selected.prev('.item-search').html() == null){//si es el titulo
                            nuevo = $('.title-search-item2').prev('.item-search');
                            selected.removeClass('itemCitarSelected');
                            nuevo.addClass('itemCitarSelected');
                        }else{
                            
                            nuevo = selected.prev('.item-search');
                            selected.removeClass('itemCitarSelected');
                            nuevo.addClass('itemCitarSelected');
                       
                       }
                       
                       return false;
                  }
          
          ///
          var textoAmigo = $('#search').val();
          if(textoAmigo == ""){
              $('#search').html("");
              $('#response-friend').hide();
              return;
          }
          $.ajax({
              
              type: "POST",
              dataType: "html",
              url: "/findbreak/function/users-response.php",// url: "../function/users-response.php",
              data: "search-friend=1&textoAmigo="+textoAmigo, 
              success : function(data) // data = cuadro
              {     
                 if(data == "no"){
                     $('#response-friend').show();
                     $('#response-friend').html("<div class='nohaycoinci'>No hay coincidencias</div>");
                 }else{
                  $('#response-friend').show();
                  $('#response-friend').html(data);
                 }
              
              }
              
          })
          
          
      })
      
      // fin busquedad de amigos
      
      //MOSTRAR SOLICITUD
      
      $('.noti-friend').click(function(){
          
          $('#show-solicitud').toggle();
         
          
      });
      
      //aceptar solicitud
      //
      
      $('.boton-aceptar').click(function()
  {
     var idsolicitud = $(this).parent().attr("id");
     var divpadre = $(this).parent();
     //alert(idsolicitud); return;
     $.ajax({
         
              type: "POST",
              dataType: "html",
              url: "/findbreak/function/users-response.php",// url: "../function/users-response.php",
              data: "solicitudaceptada=1&idsolicitud="+idsolicitud,
              success : function(data)
              {
                   var cantsolicitud = parseInt($('#cant-solicitud').html());
                   var nuevacantidad = cantsolicitud - 1;
                   $('#cant-solicitud').html(nuevacantidad);
                   divpadre.remove();
              }
              
         
     })
     
  });
  $('.boton-rechazar').click(function()
  {
     var idsolicitud = $(this).parent().attr("id");
     var divpadre = $(this).parent();
     //alert(idsolicitud); return;
     $.ajax({
         
              type: "POST",
              dataType: "html",
              url: "/findbreak/function/users-response.php",// url: "../function/users-response.php",
              data: "solicitud-rechazada=1&id-solicitud="+idsolicitud,
              success : function(data)
              {
                   var cantsolicitud = parseInt($('#cant-solicitud').html());
                   var nuevacantidad = cantsolicitud - 1;
                   $('#cant-solicitud').html(nuevacantidad);
                    divpadre.remove();
              }
              
         
     })
     
  });
      //fin aceptar/cancelar solicitud
      
      
      
      
      //FIN SOLICITUD
      
      //LOGIN
      $('.registrate').click(function(){
          $.post("/findbreak/json/zoom.php", {'popup-registrousuario':1}, function(data){
                popup(data);
            }, "html");
      });
      
      var outLoginCont = false;
       $(".login-cont").mouseover(function(){
//           alert("entrar")
           outLoginCont = true;
       });
       $(".login-cont").mouseout(function(){
//           alert("salio")
           outLoginCont = false;
       });
       $('body, html').click(function(){
           if(!outLoginCont){
                $(".login-cont").hide();
           }
       })
      $(".login-hover").click(function(){
          $(".login-cont").toggle();
          return false; 
      })
      
      $("#boton-login").click(function(){
          alert('qwerty')
          //var textoAmigo = $('#amigo').val();
          var mail = $('#mail').val();
          var pass = $('#pass').val();
          
          if(mail=="" || pass=="")
              {
                  alert('Email o contraseña no son validos');
              }
              else
                  {
                      
                      $.ajax({
                          
                          type: "POST",
                          dataType: "JSON",
                          url: "/findbreak/function/login-response.php",
                          data: "login=1&mail="+mail+"&pass="+pass,
                          success : function (data)
                          {  
                              if(data.exito)
                                  { 
                                      if(data.usertype == 1){
                                        window.location.reload();//es usuario y recargo la página donde esté
                                      }
                                      if(data.usertype == 2){  
                                        var id = data.userid;
                                        
                                        window.location.href="../productora/"+id+"";//es usuario y recargo la página donde esté
                                      }
                                     // alert(data.divuserlogin)
                                     // $('.top-right').html(data.divuserlogin);
                                      //$("#login").html("Bienvenido");
//                                      $('#login').hide(1000);
//                                      $("#user-register").show(1111);
//                                      $("#user-photo").html(data.foto);
//                                      $("#user-name").html(data.username);
                                      //user-id 
                                      
                                      
                                  }
                          }
                          
                          
                      })
                  }
              
          
          
      })
      $("#boton-login2").click(function(){
          
          //var textoAmigo = $('#amigo').val();
          var mail = $('#mail2').val();
          var pass = $('#pass2').val();
          
          if(mail=="" || pass=="")
              {
                  alert('Email o contraseña no son validos');
              }
              else
                  {
                      
                      $.ajax({
                          
                          type: "POST",
                          dataType: "JSON",
                          url: "/findbreak/function/login-response.php",
                          data: "login=1&mail="+mail+"&pass="+pass,
                          success : function (data)
                          {  
                              if(data.exito)
                                  { 
                                      if(data.usertype == 1){
                                        window.location.reload();//es usuario y recargo la página donde esté
                                      }
                                      if(data.usertype == 2){  
                                        var id = data.userid;
                                        
                                        window.location.href="../productora/"+id+"";//es usuario y recargo la página donde esté
                                      }
                                     // alert(data.divuserlogin)
                                     // $('.top-right').html(data.divuserlogin);
                                      //$("#login").html("Bienvenido");
//                                      $('#login').hide(1000);
//                                      $("#user-register").show(1111);
//                                      $("#user-photo").html(data.foto);
//                                      $("#user-name").html(data.username);
                                      //user-id 
                                      
                                      
                                  }
                          }
                          
                          
                      })
                  }
              
          
          
      })
      
       $("#boton-logout").click(function(){
          $.ajax({
                          type: "POST",
                          dataType: "json",
                          url: "/findbreak/function/login-response.php",
                          data: "logout=1",
                          success : function (data)
                          {
                                window.location.href="/findbreak/inicio/";
                          }
             
             
         })
       });
      //FIN LOGIN
      
      //Solicitud Amigos
      var idSolicitado;
     $('body').delegate('.item-search-friend','click',function(){
         idSolicitado = $(this).find('.id-item-search').html();
         if($(this).hasClass('norevi')){
             $(this).removeClass('norevi');
              descontarNotificacion();
              $.post('/findbreak/function/users-response.php', {'revisarnot2':1,'id':$(this).attr('id')});
         }
         $.ajax({
                          type: "POST",
                          dataType: "json",
                          url: "/findbreak/json/zoom.php",
                          data: "popup-user=1&idSolicitado="+idSolicitado,
                          success : function (data)
                          {
                                 popup(data.divProfileUser);
                                
                          }
             
             
         })
       return false;  
     })
     //seguiramigo
     $('#coverall').delegate('#desseguiramigo','hover',function(){
         $(this).html('Dejar de seguir')
     });
     $('#coverall').delegate('#desseguiramigo','mouseleave',function(){
         $(this).html('Siguiendo')
     });
        $('#coverall').delegate('#seguiramigo','click',function(){
         var boton = $(this);
         $.ajax({
                          type: "POST",
                          dataType: "json",
                          url: "/findbreak/function/users-response.php",
                          data: "seguirpersona=1&idSolicitado="+idSolicitado,
                          success : function (data)
                          {    
                               if(data.re==1)
                                   {
                                        //id="seguiramigo" class="botoncancel"
                                        boton.removeClass('botoncancel');
                                        boton.addClass('botongreen');
                                        boton.attr('id','desseguiramigo');
                                        boton.html("Siguiendo");
                                        $('.friends-user').append(data.item);
                                   }else
                                       {
                                   
                                           $('.button-friend').html("No se puede");
                                       }
                                
                          }
         })
         
     })
     
      $('#coverall').delegate('#desseguiramigo','click',function(){
         var boton = $(this);
         $.ajax({
                          type: "POST",
                          dataType: "json",
                          url: "/findbreak/function/users-response.php",
                          data: "dejardeseguirpersona=1&idSolicitado="+idSolicitado,
                          success : function (data)
                          {    
                               if(data.re==1)
                                   {
                                        boton.removeClass('botongreen');
                                        boton.addClass('botoncancel');
                                        boton.attr('id','seguiramigo');
                                        boton.html("Seguir");
                                        eliminarSeguidor(data.idUser);
                                   }else
                                       {
                                   
                                           $('.button-friend').html("No se puede");
                                       }
                                
                          }
         })
         
     })
     function eliminarSeguidor(id){
         
         $('.item-friends-user').each(function(){
             var idUser = $(this).attr('data-id');
            
             if(idUser == id){
                 $(this).remove();
                 return;
             }
         })
     }
      //Fin  solicitud amigos
      
      
      //PUBLICAR EVENTOS
      $('.publicar-event').click(function(){
            $.post("../json/zoom.php", {'popup-publicarevent':1}, function(data){
                popup(data);
            }, "html");
         })
      
      //FIN PUBLICAR EVENTOS
      
      
      //PUBLICAR ESTABLECIMIENTOS
      
      $('.publicar-est').click(function()
  {
      
      $.ajax({
          
                        type: "POST",
                        dataType: "html",
                        url: "../json/zoom.php",
                        data: "popup-publicarest="+1,
                        success : function (data)
                        {
                            
                            popup(data);
                            
                            
                            
                        }
                        
          
          
      })
      
  })
      
      //FIN PUblic EStablecimiento
      
       $('.productora-registro').click(function()
  {     
      $.ajax({  
                        type: "POST",
                        dataType: "html",
                        url: "../json/zoom.php",
                        data: "popup-registroproductora="+1,
                        success : function (data)
                        {                           
                            popup(data);                          
                        }         
      })
      
  })
  
     
      
      /*functions*/
      
      
      function trim(cadena){
        // USO: Devuelve un string como el parámetro cadena pero quitando los espacios en blanco de los bordes.
        var retorno=cadena.replace(/^\s+/g,'');
        retorno=retorno.replace(/\s+$/g,'');
        return retorno;
        }
});
