$(document).ready(function (){
    
    $('.contenidoCantidadPrecio').click(function (){
        $('.contenidoCantidadPrecio').fadeOut('fast');
        $('.detallesCantidadPrecio').fadeOut('fast');
    });
    
    
    var code;
    var name;
    var quantityAvailable;
    var priceBuy;
    var origen;
    
    $('.imgEditClass').click(function (){
        $('.contenidoCantidadPrecio').fadeIn('fast');
        $('.detallesCantidadPrecio').fadeIn('fast');
        
//        $('#txbObservations').val("");
//        $('.txbValue').val("");
//        $('#pMensaje').text("");
        
        var id = $(this).attr("id");
        
        code = $('#td1'+id).text();
        name = $('#td2'+id).text();
        quantityAvailable = $('#td3'+id).text();
        priceBuy = $('#td4'+id).text();
        origen = $('#td5'+id).text();
        
     
       $('#pDisponibles').text("\DISPONIBLES: "+quantityAvailable);
       //$('#pPrecioCompra').text("\PRECIO COMPRA: $ "+priceBuy);
       $('.detallesCantidadPrecio h1').text(name);
       
        $('#hiddenCodeArticle').attr('value', code);
        $('#hiddenName').attr('value', name); 
        $('#hiddenPriceBuy').attr('value', priceBuy);
        $('#hiddenAuxAvailable').attr('value', quantityAvailable);
        $('#hiddenOrigen').attr('value', origen);         
        
    });
            
    $('#txbQuantityBuy').keyup(function (){
       var cantidadComprar = $('#txbQuantityBuy').val().replace(",", "");
       
       var auxCant = parseInt($('#hiddenAuxAvailable').val().replace(",", "")); 
        
       if(cantidadComprar<=auxCant && cantidadComprar!=0)
       {
           //alert("Si Disponibles: "+auxCant+"\nSolicitadas: "+cantidadComprar);
           $('#btnSubmit').removeAttr('disabled');       
           $('#pMensaje').text("");
       }
       else
       {
           //alert("No Disponibles: "+auxCant+"\nSolicitadas: "+cantidadComprar);
           $('#btnSubmit').attr('disabled', 'disabled'); 
           $('#pMensaje').text("CANTIDAD NO DISPONIBLE");           
       }
    }); 
       
    $('#formSubmit').submit(function(){
	$(':submit').attr('disabled', 'disabled');
    })
});