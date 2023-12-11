$(document).ready(function () {
    $("#btnConsultarInventario").click(function () {
        $('#formReporteInventario').attr('action', "stock.php");        
        $('#formReporteInventario').removeAttr('target');
    });
    $("#btnGenerarInventario").click(function () {
        $('#formReporteInventario').attr('action', "../../controllers/ctrlPrintInventario.php");
        $('#formReporteInventario').attr('target', "_blank");
    });
    
    
    $("#btnConsultarStockArticulo").click(function () {
        $('#formReporteStockArticle').attr('action', "article.php");        
        $('#formReporteStockArticle').removeAttr('target');
    });
    $("#btnGenerarStockArticulo").click(function () {
        $('#formReporteStockArticle').attr('action', "../../controllers/ctrlPrintStockArticle.php");
        $('#formReporteStockArticle').attr('target', "_blank");
    });
    
    
    $("#btnConsultarArticuloVendido").click(function () {
        $('#formReporteArticleVendido').attr('action', "cantvend.php");        
        $('#formReporteArticleVendido').removeAttr('target');
    });
    $("#btnGenerarArticuloVendido").click(function () {
        $('#formReporteArticleVendido').attr('action', "../../controllers/ctrlPrintArticleVendidos.php");
        $('#formReporteArticleVendido').attr('target', "_blank");
    });
    
    
    $("#btnConsultarRemision").click(function () {
        $('#formReporteRemision').attr('action', "bill.php");        
        $('#formReporteRemision').removeAttr('target');
    });
    $("#btnGenerarRemision").click(function () {
        $('#formReporteRemision').attr('action', "../../controllers/ctrlPrintRemision.php");
        $('#formReporteRemision').attr('target', "_blank");
    });
    
    
    $("#btnConsultarUtilidad").click(function () {
        $('#formReporteUtilidad').attr('action', "utility.php");        
        $('#formReporteUtilidad').removeAttr('target');
    });    
    $("#btnGenerarUtilidad").click(function () {
        $('#formReporteUtilidad').attr('action', "../../controllers/ctrlPrintUtilidad.php");
        $('#formReporteUtilidad').attr('target', "_blank");
    });
    
    
    $("#btnConsultarEstadoCuenta").click(function () {
        $('#formReporteEstadoCuenta').attr('action', "state_account.php");        
        $('#formReporteEstadoCuenta').removeAttr('target');
    });    
    $("#btnGenerarEstadoCuenta").click(function () {
        $('#formReporteEstadoCuenta').attr('action', "../../controllers/ctrlPrintStateAccount.php");
        $('#formReporteEstadoCuenta').attr('target', "_blank");
    });
    
    
    $("#btnConsultarGastos").click(function () {
        $('#formReporteGastos').attr('action', "spend.php");        
        $('#formReporteGastos').removeAttr('target');
    });    
    $("#btnGenerarGastos").click(function () {
        $('#formReporteGastos').attr('action', "../../controllers/ctrlPrintSpend.php");
        $('#formReporteGastos').attr('target', "_blank");
    });

	
    $("#btnConsultarEstadoCuentaProveedor").click(function () {
        $('#formReporteEstadoCuentaProveedor').attr('action', "state_account_proveedor.php");        
        $('#formReporteEstadoCuentaProveedor').removeAttr('target');
    });    
    $("#btnGenerarEstadoCuentaProveedor").click(function () {
        $('#formReporteEstadoCuentaProveedor').attr('action', "../../controllers/ctrlPrintStateAccountProveedor.php");
        $('#formReporteEstadoCuentaProveedor').attr('target', "_blank");
    });

    
    $("#btnConsultarEstadoCuentaGeneral").click(function () {
        $('#formReporteEstadoCuentaGeneral').attr('action', "state_account_general.php");        
        $('#formReporteEstadoCuentaGeneral').removeAttr('target');
    });    
    $("#btnGenerarEstadoCuentaGeneral").click(function () {
        $('#formReporteEstadoCuentaGeneral').attr('action', "../../controllers/ctrlPrintStateAccountGeneral.php");
        $('#formReporteEstadoCuentaGeneral').attr('target', "_blank");
    });
});