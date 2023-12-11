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
    
    $("#txbSearchTypeClient").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchTypeClient").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchTypeClient.php",
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
    
    $("#txbSearchConcept").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchConcept").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchConcept.php",
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
    

    $("#txbSearchBanks").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchBanks").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchBanco.php",
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


    $("#txbSearchSpend").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchSpend").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchSpend.php",
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
    
    $("#txbSearchCollect").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchCollect").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchCollect.php",
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
    
    $("#txbSearchCreditCollect").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchCreditCollect").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchCreditCollect.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listadoCreditBill").empty();
                $(".listadoCreditBill").append(data);
            }
        });
    });
    
    $("#txbSearchCreditCollectNoVentas").keyup(function(e) {

        //obtenemos el texto introducido en el campo de búsqueda
        consulta = $("#txbSearchCreditCollectNoVentas").val();

        //hace la búsqueda
        $.ajax({
            
            type: "POST",            
            url: "../../models/SearchCreditCollectNoVentas.php",
            data: "b=" + consulta,
            dataType: "html",
            beforeSend: function() {               
            },
            error: function() {
                alert("error petición ajax");
            },
            success: function(data) {
                $(".listadoCreditBill").empty();
                $(".listadoCreditBill").append(data);
            }
        });
    });

});