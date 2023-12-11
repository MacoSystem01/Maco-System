$(document).ready(function() {
    
    var consulta;

    //comprobamos si se pulsa una tecla
    $("#txbSearchClient").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchClient").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchClient.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchStock").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchStock").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchStock.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });
    
    $("#txbSearchStockBill").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchStockBill").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchStockBill.php",
            data: "b=" + consulta+"&id=" + $("#txbCode").val(),
            
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listadoStockBill").empty();
                $(".listadoStockBill").append(data);
            }
        });
    });
    
    $("#txbSearchBill").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchBill").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchBill.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listado").empty();
                $(".listado").append(data);
            }
        });
    });

});