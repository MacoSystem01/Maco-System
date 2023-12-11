$(document).ready(function (){
    
    $('.fondoNegro').click(function (){
        $('.fondoNegro').fadeOut('fast');
        $('.promtInventario').fadeOut('fast');
        $('.promtRemision').fadeOut('fast');
        $('.promtUtilidad').fadeOut('fast');
    });
    
    
    var code;
    var name;
    var quantityAvailable;
    var priceBuy;
    
    $('#0').click(function (){
        $('.fondoNegro').fadeIn('fast');
        $('.promtInventario').fadeIn('fast');        
    });
    
    $('#1').click(function (){
        $('.fondoNegro').fadeIn('fast');
        $('.promtRemision').fadeIn('fast');        
    });
    
    $('#2').click(function (){
        $('.fondoNegro').fadeIn('fast');
        $('.promtUtilidad').fadeIn('fast');        
    });    
    
});