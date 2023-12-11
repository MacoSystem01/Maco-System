$(document).ready(function () {
    // cada vez que se cambia el valor del combo
    $("#selectDepartment").change(function () {
        // obtenemos el valor seleccionado
        var department = $(this).val();

        // si es 0, no es un departamento
        if (department > 0)
        {
            //creamos un objeto JSON
            var data = {
                idDepartment: $(this).val()
            };

            // utilizamos la función post, para hacer una llamada AJAX
            $.post("../controllers/ctrlLocality.php", data, function (locations) {

                // obtenemos el combo de ciudades
                var $selectLocality = $("#selectDepartment");

                // lo vaciamos
                $selectLocality.empty();

                // iteramos a través del arreglo de ciudades
                $.each(locations, function (index, objLocality) {

                    // agregamos opciones al combo
                    $selectLocality.append("<option>" + objLocality.getName() + "</option>");
                });
            }, 'json');
        }
        else
        {
            // limpiamos el combo e indicamos que se seleccione un país
            var $selectLocality = $("#selectDepartment");
            $selectLocality.empty();
            $selectLocality.append("<option>Seleccione un Department</option>");
        }
    });
});