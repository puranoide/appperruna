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
        return ['success' => false, 'message' => 'Error de preparación: ' . mysqli_error($con)];
    }

    mysqli_stmt_bind_param($stmt, "sssssssssssdssssssss", 
        $data['contrasenia'], $data['desparasitacion'], $data['direccion'], 
        $data['esterilizado'], $data['fecha_nacimiento'], $data['nombremascota'], 
        $data['parent_dni'], $data['parent_email'], $data['parent_emergencia'], 
        $data['parent_nombre'], $data['parent_tel'], $data['peso'], $data['raza'], 
        $data['sexo'], $data['tipomascota'], $data['vacuna_dia'], $data['vacuna_kc'], 
        $data['veterinaria'], $linkimgurl, $fecharegistro
    );

    if (mysqli_stmt_execute($stmt)) {
        return ['success' => true, 'message' => 'Registro exitoso'];
    } else {
        $errno = mysqli_errno($con);
        $error = mysqli_error($con);
        
        // EVALUACIÓN DE ERRORES ESPECÍFICOS
        if ($errno === 1062) {
            // Buscamos el nombre de la llave UNIQUE que definiste en tu base de datos
            if (strpos($error, 'registro_usuarios_unique_1') !== false) {
                return ['success' => false, 'message' => 'Lo sentimos, este correo electrónico ya está registrado.'];
            } 
            if (strpos($error, 'registro_usuarios_unique') !== false) {
                return ['success' => false, 'message' => 'Atención: El DNI ingresado ya existe en nuestro sistema.'];
            }
            return ['success' => false, 'message' => 'Dato duplicado: El DNI o Correo ya pertenecen a otra cuenta.'];
        }
        
        // Si no es un error de duplicado, recién aquí mandamos el mensaje de SQL
        return ['success' => false, 'message' => 'Error técnico: ' . $error];
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