<?php

function createRegister($conexion, $data)
{

    // Agregar una fecha por defecto (por ejemplo, el primer día del mes actual)
    $year = date('Y');
    $month = $data['meses'];
    $day = '01';
    $data['fechaCreada'] = "$year-$month-$day";
    // Construir la consulta de forma dinámica
    $columns = implode(", ", array_keys($data));
    $placeholders = implode(", ", array_fill(0, count($data), "?"));
    $sql = "INSERT INTO registros ($columns) VALUES ($placeholders)";

    // Preparar la consulta
    $stmt = $conexion->prepare($sql);

    // Asignar los valores a los parámetros
    $values = array_values($data);
    $stmt->bind_param(str_repeat("s", count($values)), ...$values);

    // Ejecutar la consulta
    return $stmt->execute();
}



function listmascota($conexion,$id)
{
    $query = "SELECT * FROM mascota where id=?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $mascota = $result->fetch_assoc();
        return $mascota;
    }else{
        return false;
    }

}

function updateRegister($conexion, $data, $id)
{
    // Update 'fechaCreada' column with format 'YYYY-MM-01' using 'meses' parameter
    $year = date('Y');
    $month = $data['meses'];
    $day = '01';
    $data['fechaCreada'] = "$year-$month-$day";
    
    // Build the SQL query dynamically
    $sql = "UPDATE registros SET ";
    foreach ($data as $column => $value) {
        $sql .= "$column = ?, ";
    }
    $sql = rtrim($sql, ", ");
    $sql .= " WHERE id = ?";

    // Prepare the statement
    $stmt = $conexion->prepare($sql);

    // Assign the values to the parameters
    $values = array_values($data);
    $values[] = $id;
    $stmt->bind_param(str_repeat("s", count($values)), ...$values);

    // Execute the query
    return $stmt->execute();
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
        case 'insert':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }

            // Resto del código...
            try {
                $response = createRegister($conexion, $data['data']);
                if ($response) {
                    echo json_encode(['success' => true, 'message' => 'insert exitoso']);
                } else {
                    echo json_encode(['error' => 'insert fallido']);
                }
            } catch (Exception $e) {
                echo json_encode(['error' => $e->getMessage()]);
            }
            break;
        case 'get':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }
            $response = listmascota($conexion, $data['idmascota']);
            if ($response) {
                echo json_encode(['success' => true, 'data' => $response]);
            } else {
                echo json_encode(['error' => 'list fallido']);
            }
            break;
        case 'update':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }
            try {
                $response = updateRegister($conexion, $data['datos'], $data['id']);
                if ($response) {
                    echo json_encode(['success' => true, 'message' => 'update exitoso']);
                } else {
                    echo json_encode(['error' => 'update fallido']);
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