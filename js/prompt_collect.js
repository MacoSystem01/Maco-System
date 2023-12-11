$(document).ready(function (){
    
    $('#formSubmit').submit(function(){
	$(':submit').attr('disabled', 'disabled');
    })
    
    $('.contenidoRecaudo').click(function (){
        $('.contenidoRecaudo').fadeOut('fast');
        $('.detallesRecaudo').fadeOut('fast');
    });
        
    var codeCredit;
    var valor;
    var saldo;
    var id;
    var concepto;
    
    $('.imgEditClass').click(function (){
        $('.contenidoRecaudo').fadeIn('fast');
        $('.detallesRecaudo').fadeIn('fast');
        id = $(this).attr("id");
        
        codeCredit = $('#td1'+id).text();
        valor = $('#td5'+id).text();
        saldo = $('#td6'+id).text();   
        concepto = $('#td7'+id).text(); 
               
        $('#pValor').text("VALOR: "+valor);
        $('#pSaldo').text("SALDO: "+saldo);
        $('#pMensaje').text("");
        
        $('#hiddenSaldo').attr('value', saldo);
        $('#hiddenCodeCredit').attr('value', codeCredit);
        $('#hiddenCodeConcept').attr('value', concepto);
        
        
        
    });
    
    
             
    $('.txbValue').keyup(function (){        
       var valorPagar = $(".txbValue").val().replace(",", "");       
       var saldoActual = $("#hiddenSaldo").val().replace(",", "");
       
       valorPagar = valorPagar.replace(",", "");       
       saldoActual = saldoActual.replace(",", "");  
       
       //alert("VPagar: "+valorPagar+"\nSaldoActual"+saldoActual);
       
       if(valorPagar > 0){
            $('#btnSubmit').removeAttr('disabled');       
            $('#pMensaje').text("");
       }
       else{
           $('#btnSubmit').attr('disabled', 'disabled'); 
           $('#pMensaje').text("EL VALOR DEBE SER MAYOR QUE CERO(0)"); 
       }       
    }); 
    
    
});