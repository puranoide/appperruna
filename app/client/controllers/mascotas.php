<?php

function createRegister($conexion, $data) {
    $fechadeaceptacion = date('Y-m-d');
    
    $query = "INSERT INTO mascota (
        foto, Especie, raza, peso, nacimiento, 
        sexo, estadosexual, domicilio, veterinariaconfianza, 
        vacunacionaldia, vacunakc, desparacitacion, fechaaceptaciondeclaracion, 
        id_dueño, nombre, comportamiento, indicacionesextras
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($query);

    // Agrega esto para ver el error exacto si vuelve a fallar
    if (!$stmt) {
        die(json_encode(['error' => 'Prepare failed: ' . $conexion->error]));
    }

    $stmt->bind_param(
        "sssisssssiiisisss", 
        $data['linkimgurl'],
        $data['tipomascota'],
        $data['raza'],
        $data['peso'],                // i (int)
        $data['fecha_nacimiento'],
        $data['sexo'],
        $data['estadosexual'],
        $data['domiciliomascota'],
        $data['veterinariaconfianza'],
        $data['vacunas'],             // i
        $data['vacuna_kc'],           // i
        $data['desparasitacion'],     // i
        $fechadeaceptacion,
        $data['idusuario'],           // i
        $data['nombremascota'],
        $data['comportamiento'],
        $data['indicacionesextra']
    );

    return $stmt->execute();
}

function listTodasMascotasPorUsuario($conexion, $idusuario) {
    // Ajusta 'id_dueño' al nombre real de la columna en tu tabla mascota
    $query = "SELECT * FROM mascota WHERE id_dueño = ?"; 
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $idusuario);
    $stmt->execute();
    $result = $stmt->get_result();

    $mascotas = [];
    while ($row = $result->fetch_assoc()) {
        $mascotas[] = $row;
    }
    return $mascotas;
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
                $response = createRegister($conexion, $data);
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
        case 'get_all_by_user': // Nuevo caso para el frontend
                if (!$conexion) {
                    echo json_encode(['error' => 'No se pudo conectar']);
                    exit;
                }
                $response = listTodasMascotasPorUsuario($conexion, $data['idusuario']);
             // Devolvemos el array completo
                echo json_encode(['success' => true, 'data' => $response]);
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