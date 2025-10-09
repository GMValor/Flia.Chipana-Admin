<?php
include_once('conexion.php');

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Guardar la conexión en $conn
$conn = conexion::conexionBD();

// Procesar envío del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre =trim( $_POST['nombre']);
    $password =trim($_POST['password']);

    try {
        // Preparar la consulta
        $stmt = $conn->prepare("SELECT * FROM vw_mostrar_usuarios WHERE nombre = :nombre");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->execute();

        // Obtener el usuario
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        
        //validacion de usuario y contraseña
        if (!$usuario) {
            $errores['nombre'] = "Usuario no encontrado*.";
        } elseif ($password !== $usuario['contraseña']) {
            $errores['password'] = "Contraseña incorrecta*.";
        } else {
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['rol'] = $usuario['rol'];
            header("Location: main.php");
            exit();
        }
    } catch (PDOException $e) {
        $error = "Error al consultar la base de datos: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flia.Chipana</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body id="body-login">
    <!-- Contenedor para escalar todo -->
    <div class="scale-wrapper">
            <div class="container-login">
                <div class="container-login-form">
                    <h1>Login</h1>
                    <p>Ingrese los datos solicitados</p>

                    <form method="POST" action="index.php">
                        <!-- Campo nombre -->
                    <div class="input-wrapper">
                        <input type="text" name="nombre" class="campo" placeholder="Nombre" required>
                        <?php if (!empty($errores['nombre'])): ?>
                        <div class="error-field"><?= htmlspecialchars($errores['nombre']) ?></div>
                        <?php endif; ?>
                    </div>
                        <!-- Campo contraseña -->
                    <div class="input-wrapper password-container">
                        <input type="password" name="password" id="password" class="campo" placeholder="Contraseña" required>
                        <?php if (!empty($errores['password'])): ?>
                        <div class="error-field"><?= htmlspecialchars($errores['password']) ?></div>
                        <?php endif; ?>
                        <!-- mostrar y ocultar contraseña -->
                        <i id="show" class="fa-solid fa-eye toggle-icon"></i>
                        <i id="hide" class="fa-solid fa-eye-slash toggle-icon hide"></i>
                    </div>
                        <br>
                        <button id="btn-aceptar-login" type="submit">Aceptar</button>
                    </form>
                    
                </div>

                <div class="conteiner-login-logo">
                    <img src="resources/login/patron.png" alt="Patron" id="patron-top">
                    <img src="resources/login/logo.png" alt="bichito" id="logo-inca">
                    <img src="resources/login/patron.png" alt="Patron" id="patron-botton">
                </div>
            </div>
    </div>


<!-- esto hace que funcionen los iconos para ocultar y mostrar la Contraseña -->
<script>
    const password = document.getElementById("password");
    const show = document.getElementById("show");
    const hide = document.getElementById("hide");

    show.addEventListener("click", () => {
        password.type = "text";
        show.classList.add("hide");
        hide.classList.remove("hide");
    });

    hide.addEventListener("click", () => {
        password.type = "password";
        hide.classList.add("hide");
        show.classList.remove("hide");
    });
</script>
</body>
</html>



