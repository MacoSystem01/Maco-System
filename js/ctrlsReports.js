$(document).ready(function(){
    
    $('#txbArticulo').keypress(function (){
        $('#txbReferencia').val("");        
    });
    
    $('#txbReferencia').keypress(function (){
        $('#txbArticulo').val("");
    });
    
    
    
    $('#txbClienteRC').keypress(function (){
        $('#txbCreditoRC').val("");
        $('#txbRemisionRC').val("");
    });
    
    $('#txbCreditoRC').keypress(function (){
        $('#txbClienteRC').val("");
        $('#txbRemisionRC').val("");
    });
    
    $('#txbRemisionRC').keypress(function (){
        $('#txbCreditoRC').val("");
        $('#txbClienteRC').val("");
    });
    
    
    
    $('#txbReciboRG').keypress(function (){
        $('#txbClienteRG').val("");
        $('#txbConceptoRG').val("");
    });
    
    $('#txbClienteRG').keypress(function (){
        $('#txbReciboRG').val("");
    });
    
    $('#txbConceptoRG').keypress(function (){
        $('#txbReciboRG').val("");
    });
    
});