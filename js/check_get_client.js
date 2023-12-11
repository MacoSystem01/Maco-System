$(document).ready(function(){
         
      var consulta;
             
      //hacemos focus
      $("#txbCodeClient").focus();
                                                 
      //comprobamos si se pulsa una tecla
      $("#txbCodeClient").keyup(function(e){  
        //obtenemos el texto introducido en el campo
        consulta = $("#txbCodeClient").val();
        
        
        $.ajax({
            type: "POST",
            url: "../../models/CheckGetClient.php",
            data: "b="+consulta,
            dataType: "html",
            error: function(){
                alert("error petición ajax");
            },
            success: function(data){
                if(data !== "")
                {
                    $("#txbNameClient").val(data);                
                    //$("#txbCode").focus();
                    n();
                }
                else
                {
                    $("#txbNameClient").val(data);                
                    n();
                }
                    
            }
        });
    });    
});