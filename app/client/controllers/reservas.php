<?php

function registerreserva($con,$pet_id,$date,$comment)
{

    // CAMBIO: "mascota" en lugar de "mascotas"
    $sql = "INSERT INTO reservas (pet_id, date, comment) VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);

    if ($stmt === false) {
        // Esto te ayudará a ver el error real de SQL si algo más falla
        die("Error en prepare: " . mysqli_error($con));
    }

    // Agregué $fechadeaceptacion al final para que coincida con los 11 signos de interrogación
    mysqli_stmt_bind_param($stmt, "iss", $pet_id, $date, $comment);
    
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
        case 'registerreserva':
            if (!$conexion) {
                if (!$result) {
                    echo json_encode(['success' => false, 'error' => mysqli_stmt_error($stmt)]);
                    exit;
                }
            }
            try {
                $response = registerreserva($conexion, $data['pet_id'], $data['date'], $data['comment']);

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