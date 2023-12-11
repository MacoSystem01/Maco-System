$(document).ready(function(){
         
      var consulta;
             
      //hacemos focus
      $("#txbCode").focus();
                                                 
      //comprobamos si se pulsa una tecla
      $("#txbCode").blur(function(e){  
         
        //obtenemos el texto introducido en el campo
        consulta = $("#txbCode").val();
        
        
        $.ajax({
            type: "POST",
            url: "../../models/CheckClient.php",
            data: "b="+consulta,
            dataType: "html",
            error: function(){
                alert("error petición ajax");
            },
            success: function(data){
                if(data !== "")
                {
                    alertify.error(data);                
                    $("#txbCode").focus();
                    n();
                }
            }
        });
    });    
});