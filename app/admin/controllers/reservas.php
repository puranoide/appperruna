<?php



function listreservasporconfirmar($conexion)
{
    // Corregido: INNER JOIN va antes del WHERE
    $query = "SELECT reservas.id AS reserva_id, 
                reservas.pet_id, 
                reservas.date, 
                reservas.comment, 
                reservas.estadoreserva,
                mascota.* FROM reservas 
              INNER JOIN mascota ON reservas.pet_id = mascota.id 
              WHERE reservas.estadoreserva = 0 ORDER BY reservas.date ASC";
              
    $stmt = $conexion->prepare($query);
    
    if (!$stmt) {
        // Esto te ayudará a ver el error real de SQL si algo falla
        die("Error en la preparación: " . $conexion->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $reservas = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reservas[] = $row;
        }
        return $reservas;
    } else {
        return false;
    }
}

function listreservashistorial($conexion)
{
    // Corregido: INNER JOIN va antes del WHERE
    $query = "SELECT reservas.id AS reserva_id, 
                reservas.pet_id, 
                reservas.date, 
                reservas.comment, 
                reservas.estadoreserva,
                mascota.* FROM reservas 
              INNER JOIN mascota ON reservas.pet_id = mascota.id 
              WHERE reservas.estadoreserva != 0 ORDER BY reservas.date ASC";
              
    $stmt = $conexion->prepare($query);
    
    if (!$stmt) {
        // Esto te ayudará a ver el error real de SQL si algo falla
        die("Error en la preparación: " . $conexion->error);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $reservas = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $reservas[] = $row;
        }
        return $reservas;
    } else {
        return false;
    }
}

function updatereserva($conexion, $id, $estado)
{
    
    // Build the SQL query dynamically
    $sql = "UPDATE reservas SET estadoreserva = ? WHERE id = ?";

    // Prepare the statement
    $stmt = $conexion->prepare($sql);

    // Bind the parameters
    $stmt->bind_param("ii",$estado, $id);

    // Execute the statement
    $result = $stmt->execute();

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
        case 'getreservasporconfirmar':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }
            $response = listreservasporconfirmar($conexion);
            if ($response) {
                echo json_encode(['success' => true, 'data' => $response]);
            } else {
                echo json_encode(['success' => false,'data'=>[]]);
            }
            break;
        case 'getreservashistorial':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }
            $response = listreservashistorial($conexion);
            if ($response) {
                echo json_encode(['success' => true, 'data' => $response]);
            } else {
                echo json_encode(['success' => false,'data'=>[]]);
            }
            break;
        case 'update':
            if (!$conexion) {
                echo json_encode(['error' => 'No se pudo conectar a la base de datos']);
                exit;
            }
            try {
                $response = updatereserva($conexion, $data['id'], $data['estado']);
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