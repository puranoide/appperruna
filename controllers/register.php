<?php

function Registermascota($con,$comportamiento,$contrasenia,$edad,$estadosalud,$indicacionesextra,$linkimgurl,$nombremascota,$raza,$tipomascota,$vacunas)
{
    $fechadeaceptacion = date("Y-m-d H:i:s");

    // CAMBIO: "mascota" en lugar de "mascotas"
    $sql = "INSERT INTO mascota (comportamiento, contrasenia, edad, estadosalud, indicacionesextra, linkimgurl, nombremascota, raza, tipomascota, vacunas, fecharegistro) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt === false) {
        // Esto te ayudará a ver el error real de SQL si algo más falla
        die("Error en prepare: " . mysqli_error($con));
    }

    // Agregué $fechadeaceptacion al final para que coincida con los 11 signos de interrogación
    mysqli_stmt_bind_param($stmt, "ssissssssss", $comportamiento, $contrasenia, $edad, $estadosalud, $indicacionesextra, $linkimgurl, $nombremascota, $raza, $tipomascota, $vacunas, $fechadeaceptacion);
    
    $result = mysqli_stmt_execute($stmt);
    return $result;
}


// Verify if receiving POST request with JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Set response header as JSON
    header('Content-Type: application/json');

    // Decode received JSON
    $data = json_decode(file_get_contents("php://input"), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }

    // Validate received data    

    include_once('db.php');
    switch ($data['action']) {
        case 'register':
            if (!$conexion) {
                if (!$result) {
                    echo json_encode(['success' => false, 'error' => mysqli_stmt_error($stmt)]);
                    exit;
                }
            }
            try {
                $response = Registermascota($conexion, $data['comportamiento'],$data['contrasenia'], $data['edad'], $data['estadosalud'], $data['indicacionesextra'], $data['linkimgurl'], $data['nombremascota'], $data['raza'], $data['tipomascota'],$data['vacunas']);

                if ($response) {
                    echo json_encode(['success' => true, 'message' => 'registro exitoso', 'id' => $conexion->insert_id]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'registro fallido']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;
        default:
            echo json_encode(['success' => false]);
            break;
    }
}