$(document).ready(function(){
    eventosCitVisible = false;
    $('body').delegate('#hasheventos','keyup',function(e){
       // alert(e.keyCode);
          if(e.keyCode == 51){//#
             mostrarEventosCitar();
          }
//      topComent = $('.perfiluser .overcoment').offset().top;
//      alert(topComent)
//      $('.perfiluser #replica').css('top',topComent+'px' )
    });
    textoCitaEvento = '';
    function addCitaEvent(id,hash){
        textoCitaEvento+=' '+hash;
        $('#hasheventos').val(textoCitaEvento);
        $('.eventosCitar').toggle();
    }
    $('body').delegate('.item-event-citar','click',function(e){
            var id = $(this).attr('data-id');
            var hash = $(this).find('.item-evento-name').html();
            addCitaEvent(id,hash);
          //  $('#hasheventos').val().replace('#', '');
           // alert(id); alert(hash)
           // $('#hasheventos').val($('#hasheventos').val()+ ''+hash)
    });
    $('#btn-comentar-puser').click(function(){
        if($('#coment').val() == ""){
            return false;
        }
        comentario = $('#hasheventos').val()+' '+$('#coment').val();
        padre = $(this).parent().parent().parent().parent().parent();
         var coment = comentario;
         var eventid = padre.find('#idevent').val();
         //alert(eventid)
         var nombreevent = padre.find('.title-event').html();
         var hashevent = $('#hasheventos').val();
         var totalComent = padre.find('#totalComent').html();
         var ultimoComentario = padre.find('.list .itemcoment:last').attr('data-num');
         ultimoComentario = parseInt(ultimoComentario) +2;
         totalComent++;

         $.ajax({           
             type:"POST",
             dataType:"html",
             url: "/findbreak/function/comentario-response.php",
             data: "comenteventUser=1&comentario="+coment+"&eventId="+eventid+"&hashevent="+hashevent+"&nombreevent="+nombreevent+'&totalComent='+totalComent+"&ultimo="+ultimoComentario,
             success: function (data)
             {   
                 padre.find('.showfocuscom').hide();
                 padre.find('#coment').css('height','16px');
                 padre.find('#coment').val('');
                 padre.find('.list').html(data);
                 padre.find('#replica').html('');
                 padre.find('.list').attr('style','outline: none; tabindex="5000; overflow-y:none"');
                 //sumar evento
                
//                 cantidadComentarios = (parseInt(padre.find('#totalComent').val())  + 1)
//                 padre.find('#totalComent').val(cantidadComentarios)
//                 if(cantidadComentarios == 0){
//                                            textoComentario = '0';
//                                        }else
//                                            if(cantidadComentarios == 1){
//                                            textoComentario = 'Un comentario';
//                                        }else{
//                                            textoComentario = '<span class="bold">'+cantidadComentarios+'</span> Comentarios';
//                                        }
                 $('#totalComent').html(totalComent);
                
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
    function mostrarEventosCitar(){
            $('.eventosCitar').toggle();
            if($('.eventosCitar').is(':visible')){
                eventosCitVisible = true;
            }else{
                eventosCitVisible = false;
            }
            
            $.post('/findbreak/function/event-response.php', {'search-event-cit':1,'textoEvento':''},
                    function(data){   
                                $('.eventosCitar').html(data)
                    }, "html");
        }
});