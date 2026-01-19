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
        return ['success' => false, 'error_type' => 'sql', 'message' => mysqli_error($con)];
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

    if (mysqli_stmt_execute($stmt)) {
        return ['success' => true];
    } else {
        $errno = mysqli_errno($con);
        $error = mysqli_error($con);
        
        // Error 1062: Duplicate entry
        if ($errno === 1062) {
            if (strpos($error, 'parent_dni') !== false) {
                return ['success' => false, 'error_type' => 'duplicate', 'message' => 'Este DNI ya se encuentra registrado.'];
            } elseif (strpos($error, 'parent_email') !== false) {
                return ['success' => false, 'error_type' => 'duplicate', 'message' => 'Este correo electrónico ya está en uso.'];
            }
            return ['success' => false, 'error_type' => 'duplicate', 'message' => 'El DNI o Correo ya existen.'];
        }
        
        return ['success' => false, 'error_type' => 'other', 'message' => $error];
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