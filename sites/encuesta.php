<!--<div class="encabezadoencuesta">
    
</div>
<div class="pregunta">
    <div class="nombre">
        1. ¿A usted le interesaría utilizar una aplicación en la cual pueda publicar sus eventos?
    </div>
    <div class="alternativas">
        <div class="alt">
            <div class="si">Si</div>
            <input type="radio" name="alt1"/>
        </div>
        <div class="alt">
            <div class="no">No</div>
            <input type="radio" name="alt1"/>
        </div>
    </div>
</div>
<div class="pregunta">
     <div class="nombre">
      2. Cuando quiere publicar un evento, ¿De qué manera lo hace?
    </div>
    <div class="alternativasabiertas">
        <div class="altabierta">
            <textarea maxlength="180" class="respuesta" placeholder="Escriba aquí"></textarea>
            <div class="quedan">Caracteres restantes <span class="restante">180</span></div>
        </div>
        
    </div>
</div>
<div class="pregunta">
    <div class="nombre">
        3. ¿Realiza búsqueda de productos o servicios para la producción de sus eventos? <span class="ej"> Ej: arriendo de implementos musicales, guardias, etc.</span>
    </div>
    <div class="alternativas">
        <div class="alt">
            <div class="si">Si</div>
            <input type="radio" name="alt3"/>
        </div>
        <div class="alt">
            <div class="no">No</div>
            <input type="radio" name="alt3"/>
        </div>
    </div>
</div>
<div class="pregunta">
   
     <div class="nombre">
      4. Si busca productos o servicios para la producción de sus eventos, ¿De qué manera lo hace?
    </div>
    <div class="alternativasabiertas">
        <div class="altabierta">
            <textarea maxlength="180" class="respuesta2" placeholder="Escriba aquí"></textarea>
            <div class="quedan">Caracteres restantes <span class="restante2">180</span></div>
        </div>
        
    </div>

</div>
<div class="pregunta">
    <div class="nombre">
        5. ¿Usted utilizaría la versión gratuita por un periodo de 6 meses?
    </div>
    <div class="alternativas">
        <div class="alt">
            <div class="si">Si</div>
            <input type="radio" name="alt5"/>
        </div>
        <div class="alt">
            <div class="no">No</div>
            <input type="radio" name="alt5"/>
        </div>
    </div>
</div>
<div class="pregunta">
    <div class="nombre">
        6. Después de los 6 meses y si la aplicación le es de su agrado, ¿pagaría $ 1000 pesos por la publicación de cada evento?
    </div>
    <div class="alternativas">
        <div class="alt">
            <div class="si">Si</div>
            <input type="radio" name="alt6"/>
        </div>
        <div class="alt">
            <div class="no">No</div>
            <input type="radio" name="alt6"/>
        </div>
    </div>
</div>
<div class="lastdiv">
    <a href="" class="boton botonright">Responder</a>
</div>-->


<!--<div contenteditable="true" class="editable divtrans">
    <a href="" id="sally" class="boton botonright au">Responder</a>
    <a href="" class="boton botonright ua">Responder3</a>
    <a href="" class="boton botonright pa">Responder4</a>
</div>

<input id="btn" type="button" value="Insert node">

<div style="width: 400px; height: 300px;" contenteditable="true" id="test">Here is some editable text</div>

<div id="citasHidden">
   
</div>
<script>
  c = 1;
 $('#btn').click(function(){
//     insertNodeAtCaretI(document.createTextNode('[INSERTED]'))
    insertNodeAtCaret(document.getElementById('cita'))
    $('#test').focus();
 })
 $('#test').keypress(function(e){
        if( e.keyCode == 13){
//            alert(c)
            $('#test').html('jajajaa');
            $('#test').focus();
            $('#citasHidden').html('<b id=cita-'+c+'>cita numero '+c+'</b>');
            insertNodeAtCaret(document.getElementById('cita-'+c))
          c++;
          alert($('#citasHidden').html())
    $('#test').focus();
         return false;   
        }
 })
function insertNodeAtCaret(node) {
    if (typeof window.getSelection != "undefined") {
        
        var sel = window.getSelection();
        if (sel.rangeCount) {
            var range = sel.getRangeAt(0);
            range.collapse(false);
            range.insertNode(node);
            range = range.cloneRange();
            range.selectNodeContents(node);
            range.collapse(false);
            sel.removeAllRanges();
            sel.addRange(range);
        }
    } else if (typeof document.selection != "undefined" && document.selection.type != "Control") {
        var html = (node.nodeType == 1) ? node.outerHTML : node.data;
        var id = "marker_" + ("" + Math.random()).slice(2);
        html += '<span id="' + id + '"></span>';
        var textRange = document.selection.createRange();
        textRange.collapse(false);
        textRange.pasteHTML(html);
        var markerSpan = document.getElementById(id);
        textRange.moveToElementText(markerSpan);
        textRange.select();
        markerSpan.parentNode.removeChild(markerSpan);
    }
}
</script>-->


<!--CASI CASI !
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&#237;tulo</title>
<script>
    function sacarArroa2(){
            textoArea = $('#pepito').html();
            textoAreaDividido = textoArea.split(" ");
            numeroPalabras = textoAreaDividido.length;
//            alert(numeroPalabras)
            
            for (var i=0; i<numeroPalabras; i++)
            {
//                alert(textoAreaDividido[i])
                  if(textoAreaDividido[i].indexOf('@')!= -1){
//                      alert(textoAreaDividido[i])
//                      alert('tiene arroa')
                        palabraEncontrada = textoAreaDividido[i];
                        nuevaPalabra = '<span class="sacar">'+palabraEncontrada+'</span>&nbsp;&nbsp;';
                        break;
                  }
                
            }
//            alert(palabraEncontrada)
//            alert($('#pepito').html())
            $('#pepito').html(textoArea.replace(palabraEncontrada, ' '));
            //$('#pepito').focus();
       }
function inHTML(editor,u){ 
    var u,u2; 
        try{ 
            document.execCommand("inserthtml",false,u); 
        }catch(e){ 
            try{ 
                editor.focus(); 
                u2=document.selection.createRange(); 
                u2.pasteHTML(u); 
            }catch(E){ 
                alert('nop'); 
            } 
        }
        return false;
} 
document.onkeydown=function(e){
    var evt=e || event;
    var t=evt.wich || evt.keyCode;
    if(t==13){
        //$('#pepito').html('ctmaaaaaaaaaaaaaaaaaaaaa')
       
       inHTML(document.getElementById('pepito'),'&nbsp;&nbsp;<span><a style="color:red" href="#">Luis</a></span>&nbsp;&nbsp;');
     //  sacarArroa2();
       return false;
    }
}
</script>
</head>

<body>
<div id="pepito" contenteditable="true">esto es contenido editable</div>
</body>
</html> -->



<!--<body>
<div id="pepito" contenteditable="true">esto es contenido editable</div>
</body>
</html> 
<script>
       function sacarArroa2(){
            textoArea = $('#pepito').html();
            textoAreaDividido = textoArea.split(" ");
            numeroPalabras = textoAreaDividido.length;
//            alert(numeroPalabras)
            
            for (var i=0; i<numeroPalabras; i++)
            {
//                alert(textoAreaDividido[i])
                  if(textoAreaDividido[i].indexOf('@')!= -1){
//                      alert(textoAreaDividido[i])
//                      alert('tiene arroa')
                        palabraEncontrada = textoAreaDividido[i];
                        nuevaPalabra = '<span class="sacar">'+palabraEncontrada+'</span>&nbsp;&nbsp;';
                        break;
                  }
                
            }
//            alert(palabraEncontrada)
//            alert($('#pepito').html())
            $('#pepito').html(textoArea.replace(palabraEncontrada, ''));
       }
       
    var savedRange; 
var savedRange; 
function saveSelection() { 
    if(window.getSelection)//navegadores no IE
    {
    savedRange = window.getSelection().getRangeAt(0);
    }
}
    document.onkeydown=function(e){
    var evt=e || event;
    var t=evt.wich || evt.keyCode;
    if(t==13){
//        saveSelection();
//        //$('#pepito').html('ctmaaaaaaaaaaaaaaaaaaaaa')
       
//       inHTML(document.getElementById('pepito'),'<span><a style="color:red" href="#">Luis</a></span> ');
         insertText('pepito', 'Luis');
         sacarArroa2();
         return false;
    }
}
    function insertText(divEditable, strTexto) {
            if (strTexto == "untexto"){
            return 0; 
            }
            
            //FF
            if (window.getSelection) {
            document.getElementById(divEditable).focus();
            var sel, range, html; 
            //alert("FF, " + strTexto);
            sel = window.getSelection();
            range = sel.getRangeAt(0);
            range.deleteContents();
            range.insertNode(document.createTextNode(strTexto) );
            }else if (window.getSelection) {
            var s = window.getSelection();
            if (s.rangeCount > 0) s.removeAllRanges(); 
            s.addRange(savedRange); 
            window.getSelection().addRange(savedRange); 
            document.execCommand("insertHTML", false, strTexto);
            saveSelection();
            return false;
}
            
}
</script>-->

<!--TERCER INTENTO

<div contenteditable="true" id="editor">Put the caret somewhere and press Enter</div>

<script>
    function sacarArroa2(){
            textoArea = $('#editor').html();
            textoAreaDividido = textoArea.split(" ");
            numeroPalabras = textoAreaDividido.length;
//            alert(numeroPalabras)
            
            for (var i=0; i<numeroPalabras; i++)
            {
//                alert(textoAreaDividido[i])
                  if(textoAreaDividido[i].indexOf('@')!= -1){
//                      alert(textoAreaDividido[i])
//                      alert('tiene arroa')
                        palabraEncontrada = textoAreaDividido[i];
                        nuevaPalabra = '<span class="sacar">diego</span>&nbsp;&nbsp;';
                        break;
                  }
                
            }
//            alert(palabraEncontrada)
//            alert($('#pepito').html())
            $('#editor').html(textoArea.replace(palabraEncontrada, nuevaPalabra));
       }
function pasteTextAtCaret(text) {
    var sel, range;
    if (window.getSelection) {
        // IE9 and non-IE
        sel = window.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            range.deleteContents();

            var textNode = document.createTextNode(text);
            range.insertNode(textNode);

            // Preserve the selection
            range = range.cloneRange();
            range.setStartAfter(textNode);
            range.collapse(true);
            sel.removeAllRanges();
            sel.addRange(range);
        }
    } else if (document.selection && document.selection.type != "Control") {
        // IE < 9
        document.selection.createRange().text = text;
    }
}

document.getElementById("editor").onkeydown = function(evt) {
    evt = evt || window.event;
    if (evt.keyCode == 13) {
       
        pasteTextAtCaret("<ENTER>");
      sacarArroa2();
        $('.sacar').remove();
         pasteTextAtCaret("AHORA");
        return false;
    }
};
        </script>-->

CUARTO INTENTO
  <textarea id="tester"></textarea>
  <div id="replica"></div>
  
  <script type='text/javascript'> 

     largoUsuario = 0;
     focusFinal = 0;
      function reemplazar(){
          texto = $('#tester').val();
          partes = texto.split(" ");
          usuario = -1;
          yapaso = 0;
          // buscar cada palabra que contenga esto !#skumblue
          // a estas palabras se transformaran en <b>!#skumblue</b>
          for(i=0; i<partes.length; i++){
              if(partes[i].indexOf('!#')!= -1){
                  
                  usuario = partes[i];
                  nueva = '<b>'+usuario+'</b> ';
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
          texto = $('#tester').val();
          for(i=0; i<texto.length; i++){
              if(texto[i] == '@'){
                  break;
              }
          }
          return i;
      }
      function conocerElFocusFinal(){
                        
          //conocer el largo del usuario si aprete arroa
          if(focusArroa != false){
              //tomo el nombre de usuario y tomo el largo
                nuevoTexto = $('#tester').val();
                usuarioAcitar = '!#skumblue1';
                largoUsuario = usuarioAcitar.length;
                 largoUsuarioRetur = largoUsuario;
                 largoUsuario = 0;
//                 alert('largo user: '+largoUsuarioRetur)
//                 alert('focus arroa: '+focusArroa)
                 focusFinal = largoUsuarioRetur+focusArroa;
          }  
      }
       
       
      function HayArroa(){
          hayArroa = false;
          partes = $('#tester').val();
          for(i=0; i<partes.length; i++){
              if(partes[i].indexOf('@')!= -1){
                  hayArroa = true;
                  break;
              }
          }
          return hayArroa;
      }
      c=1;
      function citar(){
          //tengo que sacar el nickname del usuario seleccionado
          //luego saco su largo y era
          texto = $('#tester').val();
          partes = texto.split(" ");
          usuario = -1;
          yapaso = 0;
          cursor = $('#tester').val().length;
          // buscar cada palabra que contenga esto !#skumblue
          // a estas palabras se transformaran en <b>!#skumblue</b>
          for(i=0; i<partes.length; i++){
              if(partes[i].indexOf('@')!= -1){
                  arroa = partes[i];
                  usuario = '!#skumblue'+c; //el que se encuentra en la base de datos
                  c++;
                  nueva = '<b>'+usuario+'</b> ';
                  nuevaplano = usuario;
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
                  $('#tester').val(textoPlano);
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
              textoPlano = $('#replica').html();
              $.post('/findbreak/function/users-response.php', {'reemplazarBr':1,'textoPlano':textoPlano},
                    function(data){   
                        $('#replica').html(data)       
                    }, "html");
      }
      focusArroa = false;
      $('#tester').keyup(function(e){
          if(e.keyCode == 81){
           focusArroa = conocerElFocus();
          }
         
          
          if(e.keyCode == 13){
             //si no hay arroa no haga nada
             if(HayArroa()){
                citar();
                reemplazar();
                conocerElFocusFinal();
                setCaretToPos(document.getElementById('tester'), parseInt(focusFinal))
                focusFinal = 0;
                focusArroa = false;
             }
             reemplazar();
             
          }
          else{
              reemplazar();
          }
             tobr();
      })
  </script> 
  
