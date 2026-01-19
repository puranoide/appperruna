<?php

function Registermascota($con, $data, $linkimgurl) {
    $fecharegistro = date("Y-m-d H:i:s");
    
    $sql = "INSERT INTO registro_usuarios (
        contrasenia, desparacitacion, direccion, esterilizado, fecha_nacimiento, 
        nombremascota, parent_dni, parent_email, parent_emergencia, parent_nombre, 
        parent_tel, peso, raza, sexo, tipomascota, 
        vacuna_dia, vacuna_kc, veterinaria, linkfoto, fecharegistro
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt === false) {
        // Esto solo falla si hay un error de sintaxis en el SQL
        return ['success' => false, 'message' => 'Error de preparación SQL: ' . mysqli_error($con)];
    }

    mysqli_stmt_bind_param($stmt, "sssssssssssdssssssss", 
        $data['contrasenia'], 
        $data['desparasitacion'], 
        $data['direccion'], 
        $data['esterilizado'], 
        $data['fecha_nacimiento'], 
        $data['nombremascota'], 
        $data['parent_dni'], 
        $data['parent_email'], 
        $data['parent_emergencia'], 
        $data['parent_nombre'], 
        $data['parent_tel'], 
        $data['peso'], 
        $data['raza'], 
        $data['sexo'], 
        $data['tipomascota'], 
        $data['vacuna_dia'], 
        $data['vacuna_kc'], 
        $data['veterinaria'],
        $linkimgurl,
        $fecharegistro
    );

    // Intentar ejecutar la inserción
    if (mysqli_stmt_execute($stmt)) {
        return ['success' => true];
    } else {
        // SI LA EJECUCIÓN FALLA, revisamos si es por duplicados
        $errno = mysqli_errno($con);
        $error = mysqli_error($con);
        
        // Código 1062 = Entrada duplicada
        if ($errno === 1062) {
            // Evaluamos el mensaje de error de MySQL para saber qué campo falló
            if (strpos($error, 'parent_dni') !== false || strpos($error, 'registro_usuarios_unique') !== false) {
                return ['success' => false, 'message' => 'Este DNI ya se encuentra registrado.'];
            } 
            if (strpos($error, 'parent_email') !== false || strpos($error, 'registro_usuarios_unique_1') !== false) {
                return ['success' => false, 'message' => 'Este correo electrónico ya está en uso.'];
            }
            return ['success' => false, 'message' => 'El DNI o el Correo electrónico ya existen en nuestra base de datos.'];
        }
        
        // Si es cualquier otro error de SQL
        return ['success' => false, 'message' => 'Error de base de datos: ' . $error];
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');

    $data = json_decode(file_get_contents("php://input"), true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'Invalid JSON']);
        exit;
    }

    include_once('db.php');

    switch ($data['action']) {
        case 'register':
            if (!$conexion) {
                echo json_encode(['success' => false, 'error' => 'Error de conexión']);
                exit;
            }
        try {
            $result = Registermascota($conexion, $data, $data['linkimgurl']);
            // El resultado ya viene con el formato success/message
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error inesperado: ' . $e->getMessage()]);
        }
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            break;
    }
}