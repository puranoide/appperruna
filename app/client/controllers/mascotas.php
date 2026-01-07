<?php



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

function updatemascota($conexion, $data, $id)
{
    
    // Build the SQL query dynamically
    $sql = "UPDATE mascota SET edad = ?, comportamiento = ?, estadosalud = ?, indicacionesextra = ?, nombremascota = ?, raza = ?, tipomascota = ? WHERE id = ?";

    // Prepare the statement
    $stmt = $conexion->prepare($sql);

    // Bind the parameters
    $stmt->bind_param("issssssi", $data['edad'], $data['comportamiento'], $data['estadosalud'], $data['indicacionesextra'], $data['nombre'], $data['raza'], $data['especie'], $id);

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
                $response = updatemascota($conexion, $data, $data['idmascota']);
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