$(document).ready(function() {
    var consulta;
    
    consulta = $("#selectDepartment").val();
    
    //hace la búsqueda
    $.ajax({

        type: "POST",            
        url: "../../models/Select.php",
        data: "b=" + consulta,
        dataType: "html",
        beforeSend: function() {               
        },
        error: function() {
            alert("error petición ajax");
        },
        success: function(data) {
            $("#selectLocality").empty();
            $("#selectLocality").html(data);
        }
    });
    
    
       
    
    
    

    //comprobamos si se pulsa una tecla
    $("#selectDepartment").change(function() {
        
    //obtenemos el texto introducido en el campo de búsqueda
    consulta = $("#selectDepartment").val();
    
    //hace la búsqueda
    $.ajax({

        type: "POST",            
        url: "../../models/Select.php",
        data: "b=" + consulta,
        dataType: "html",
        beforeSend: function() {               
        },
        error: function() {
            alert("error petición ajax");
        },
        success: function(data) {
            $("#selectLocality").empty();
            $("#selectLocality").html(data);
        }
    });
    
    
    
    });
});






























