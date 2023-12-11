<!DOCTYPE html>
<html lang="esp">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>MACO | Login</title>
        <link rel="icon" href="res/logo/frase.ico" type="image/x-icon">
        <link rel="shortcut icon" href="res/logo/frase.ico" type="image/x-icon">

        <link href="css/style.css" rel="stylesheet">
        <script src="js/jquery/jquery.js"></script>
        <script src="js/alertify/alertify.js"></script>
        <link href="css/alertify/alertify.css" rel="stylesheet">
        <link href="css/alertify/themes/default.css" rel="stylesheet">
    </head>

    <body>
        <section class="contenedor">
            <header>
                <div class="logoEmpresa">
                    <a href="index.php"><img src="res/logo/logo-1.png" class="logo-ini"></a>
                </div>
                <div class="sesion">
                </div>
                <div class="contenedorRutaApp">
                    <div class="nombreAplicacion">
                        MACO System "Sistema de Registro Contable"
                    </div>
                    <div class="arrowImgRight">
                        <img src="res/arrow-25-16.png">
                    </div>
                    <div class="opcionSeleccionada">
                        INICIO SESIÓN
                    </div>
                </div>
            </header>
            <nav id="menu">
                <ul>
                    <li></li>
                </ul>
            </nav>
            <section class="contenido" id="contenidoGeneral">
                <h1>Iniciar Sesión</h1>
                <?php
                    if(isset($_GET['error']))
                        {
                            echo '<script>alertify.error("Datos de sesión incorrectos");</script>';
                        }
                ?>
                <form method="post" action="controllers/ctrlLogin.php">
                    <input type="text" name="txbUser" placeholder="Usuario" id="imputUpNone" required>
                    <input type="password" placeholder="Contraseña" name="txbPassword" id="imputUpNone" required>
                    <input type="submit" value="Ingresar">
                </form>
            </section>
            <footer>                
                <div class="franjaAzul"></div>   
                <p class="m-0 text-center">&copy; <a href="http://127.0.0.1:5500/login.html">MACO System Accountant</a>.
                    Reservados todos los derechos. Diseñado Por <a href="https://github.com/MacoSystem01" target="_blank">MACO
                        System</a><br>
                </p>
            </footer>
        </section>

    </body>
</html>