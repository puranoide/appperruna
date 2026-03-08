<?php
function enviarCorreoInteresado($data)
{
    $parent_dni = $data['parent_dni'];
    $contrasenia = $data['apellidos'];
    $mensaje = "Hola hemos recidido tus datos y generamos tu perfil: usuario:" . $parent_dni. " Contraseña: ". $contrasenia;
    // Validación básica
    if (empty($nombres) || empty($email) || empty($mensaje)) {
        return false;
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
        exit;
    }

    // Sanitizar el correo electrónico
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Datos del correo
    $para = $data['parent_email'];
    $asunto = "Perfil de dueño";
    $cabecera = "From: no-reply@slategrey-coyote-524330.hostingersite.com";
    $mail = mail($para, $asunto, $mensaje, $cabecera);

    // Enviar el correo
    if ($mail) {
        return true;
    } else {
        return false;
    }
}


function registerusuario($con, $data) {
    $fecharegistro = date("Y-m-d H:i:s");
    
    $sql = "INSERT INTO registro_usuarios (
        contrasenia, parent_dni, parent_email, parent_emergencia, parent_nombre, 
        parent_tel, fecharegistro
    ) VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($con, $sql);

    if ($stmt === false) {
        return ['error' => 'Error de preparación: ' . mysqli_error($con)];
    }

    mysqli_stmt_bind_param($stmt, "sssssss",
        $data['contrasenia'],
        $data['parent_dni'], $data['parent_email'], $data['parent_emergencia'], 
        $data['parent_nombre'], $data['parent_tel'], $fecharegistro
    );

    try { // ← ENVUELVE EL EXECUTE EN TRY/CATCH
        mysqli_stmt_execute($stmt);
        return ['success' => true, 'message' => 'Registro exitoso', 'id' => mysqli_insert_id($con)];

    } catch (mysqli_sql_exception $e) {
        $errno = $e->getCode();
        $error = $e->getMessage();

        if ($errno === 1062) {
            if (strpos($error, 'registro_usuarios_unique_1') !== false) {
                return ['error' => 'Lo sentimos, este correo electrónico ya está registrado.'];
            }
            if (strpos($error, 'registro_usuarios_unique') !== false) {
                return ['error' => 'Atención: El DNI ingresado ya existe en nuestro sistema.'];
            }
            return ['error' => 'Dato duplicado: El DNI o Correo ya pertenecen a otra cuenta.'];
        }

        return ['error' => 'Error técnico: ' . $error];
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
            $result = Registermascota($conexion, $data);
            // El resultado ya viene con el formato success/message
            echo json_encode($result);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Error el DNI o correo ya existe']);
        }
            break;
        case 'registeruser':
            $response = registerusuario($conexion, $data);
                if (isset($response['error'])) {
                echo json_encode(['error' => $response['error']]); // ← verás el error exacto
            } else {
                echo json_encode(['success' => true, 'id' => $response['id']]);
            }
            break;
        case 'mandarcorreo':
            $response = enviarCorreoInteresado($data);
            if (isset($response['error'])) {
                echo json_encode(['error' => $response['error']]); // ← verás el error exacto
            } else {
                echo json_encode(['success' => true]);
            }
            break;
            
        default:
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
            break;
    }
}