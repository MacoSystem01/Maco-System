$(document).ready(function (){
    
    $('.contenidoCantidadPrecioDetail').click(function (){
        $('.contenidoCantidadPrecioDetail').fadeOut('fast');
        $('.detallesCantidadPrecioDetail').fadeOut('fast');
    });
    
    
    var code;
    var quantity;
    var priceVenta;
    
    $('.imgEditClassDetail').click(function (){
        $('.contenidoCantidadPrecioDetail').fadeIn('fast');
        $('.detallesCantidadPrecioDetail').fadeIn('fast');
        var id = $(this).attr("id");;
        
       
        
        code = $('#tdd1'+id).text();
        quantity = $('#tdd2'+id).text();
        priceVenta = $('#tdd3'+id).text();
        
        $('#txbQuantityBuyDetail').val(quantity);
        $('#example22').val(priceVenta);
        $('#pMensaje').text("");
        
        //$('#txbQuantityBuyDetail').attr('value', quantity);
        //$('#example22').attr('value', priceVenta);               
        
        $('#pCantidadDetail').text("\CANTIDAD: "+quantity);
        $('#pPrecioCompraDetail').text("\PRECIO COMPRA: $ "+priceVenta);
        $('.detallesCantidadPrecioDetail h1').text(code);
       
        $('#hiddenCodeArticleDetail').attr('value', code);
        $('#hiddenQuantityDetail').attr('value', quantity); 
        $('#hiddenPriceBuyDetail').attr('value', priceVenta);
        
        
        
//        $('.contenidoCantidadPrecioDetail').fadeIn('fast');
//        $('.detallesCantidadPrecioDetail').fadeIn('fast');
//        
//        $('#txbQuantityBuy').val("");
//        $('#example2').val("");
//        $('#pMensaje').text("");
//        
//        var id = $(this).attr("id");
//        
//        code = $('#tdd1'+id).text();
//        name = $('#tdd2'+id).text();
//        quantityAvailable = $('#tdd3'+id).text();
//        priceBuy = $('#tdd4'+id).text();
//     
//       $('#pDisponibles').text("\DISPONIBLES: "+quantityAvailable);
//       $('#pPrecioCompra').text("\PRECIO COMPRA: $ "+priceBuy);
//       $('.detallesCantidadPrecio h1').text(name);
//       
//        $('#hiddenCodeArticle').attr('value', code);
//        $('#hiddenName').attr('value', name); 
//        $('#hiddenPriceBuy').attr('value', priceBuy);
//        $('#hiddenAuxAvailable').attr('value', quantityAvailable);
         
        
    });
            
    $('#txbQuantityBuyDetail').keyup(function (){
       var cantidadComprar = $('#txbQuantityBuyDetail').val().replace(",", "");                    
        
       if(cantidadComprar>0)
       {
           //alert("Si Disponibles: "+auxCant+"\nSolicitadas: "+cantidadComprar);
           $('#btnSubmitDetail').removeAttr('disabled');       
           $('#pMensajeDetail').text("");
       }
       else
       {
           $('#btnSubmitDetail').attr('disabled', 'disabled'); 
           $('#pMensajeDetail').text("LA CANTIDAD DEBE SER MAYOR DE CERO");           
       }
    }); 
    
    
    $('#example22').keyup(function (){        
       var cantidadComprar = $('#txbQuantityBuyDetail').val().replace(",", "");                    
        
       if(cantidadComprar>0)
       {
           //alert("Si Disponibles: "+auxCant+"\nSolicitadas: "+cantidadComprar);
           $('#btnSubmitDetail').removeAttr('disabled');       
           $('#pMensajeDetail').text("");
       }
       else
       {
           $('#btnSubmitDetail').attr('disabled', 'disabled'); 
           $('#pMensajeDetail').text("LA CANTIDAD DEBE SER MAYOR DE CERO");           
       }
    }); 
});