$(document).ready(function(){
                         
      var consulta;
             
      //hacemos focus
      $("#txbCode").focus();
                                                 
      //comprobamos si se pulsa una tecla
      $("#txbCode").keyup(function(e){          
        //obtenemos el texto introducido en el campo
        consulta = $("#txbCode").val();
        
        //alert(consulta);
        
        //hace la búsqueda
        //$("#resultado").delay(1000).queue(function(n) {     
            //$("#resultado").html('<img src="../../res/ajax-loader.gif" />');
            $.ajax({
                type: "POST",
                url: "../../models/Check.php",
                data: "b="+consulta,
                dataType: "html",
                error: function(){
                    alert("error petición ajax");
                },
                success: function(data){                         
                    if(data === "")
                    {
                        $('#txbName').val(data);
//                        $('#txbName').attr('value', data);                        
                        $('#txbName').removeAttr('readonly', 'readonly');
                    }
                    else
                    {
                        $('#txbName').val(data);
//                        $('#txbName').attr('value', data);                        
                        $('#txbName').attr('readonly', 'readonly');
                    }
                    
                    n();
                }
            });
    });
    
    //comprobamos si se pulsa una tecla
      $("#txbCode").blur(function(e){          
        //obtenemos el texto introducido en el campo
        consulta = $("#txbCode").val();
        
        //alert(consulta);
        
        //hace la búsqueda
        //$("#resultado").delay(1000).queue(function(n) {     
            //$("#resultado").html('<img src="../../res/ajax-loader.gif" />');
            $.ajax({
                type: "POST",
                url: "../../models/Check.php",
                data: "b="+consulta,
                dataType: "html",
                error: function(){
                    alert("error petición ajax");
                },
                success: function(data){                         
                    if(data === "")
                    {
                        $('#txbName').val(data);
//                        $('#txbName').attr('value', data);                        
                        $('#txbName').removeAttr('readonly', 'readonly');
                    }
                    else
                    {
                        $('#txbName').val(data);
//                        $('#txbName').attr('value', data);                        
                        $('#txbName').attr('readonly', 'readonly');
                    }
                    
                    n();
                }
            });
    });
    
    
    
});