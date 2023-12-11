<?php

// si se está enviando por POST el id del país
// significa que intentamos acceder desde jQuery
if (isset($_POST['idDepartment'])) {
    $locations = array();
    
    require '../models/LocalityImpl.php';
    $locations = $objLocalityImpl = new LocalityImpl();
    
    // devolvemos el arreglo de ciudades, en formato JSON
    echo json_encode($locations);
}

?>