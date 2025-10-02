<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flia.Chipana</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body id="body-main">
<div class="scale-wrapper-main">
    <!-- PANEL DE NAVEGACIÓN -->
    <div class="panel-navegacion">            
        <img src="resources/main/patron.png" alt="patron" id="patron-top-main">

        <div class="panel-content"> <!-- contenedor para escalar -->
            <img src="resources/main/logo-FliaChipana.png" alt="logo-FliaChipana" id="logo-FliaChipana">
            <nav>
                <a href="#" onclick="cargarModulo('ventas.php')"><i class="fa fa-shopping-cart"></i> Ventas</a>
                <a href="#" onclick="cargarModulo('productos.php')"><i class="fa fa-shopping-bag"></i> Productos</a>
                <a href="#" onclick="cargarModulo('proveedores.php')"><i class="fa fa-truck"></i> Proveedores</a>
                <a href="#" onclick="cargarModulo('clientes.php')"><i class="fa fa-users"></i> Clientes</a>
                <a href="#" onclick="cargarModulo('formaspago.php')"><i class="fa fa-dollar-sign"></i> Formas Pago</a>   
                <!-- Botón cerrar sesión (este sí puede ser enlace normal) -->
                <a href="cerrarsesion.php" id="btn-cerrar-sesion"><i class="fa fa-sign-out-alt"></i> Cerrar sesión</a>
            </nav>  
        </div>       
        <img src="resources/main/patron.png" alt="patron" id="patron-botton-main">

    </div>

    <!-- PANEL PRINCIPAL -->
    <main id="main-principal">
        <div  id="contenido" class="main-content"> <!-- contenedor dinámico -->
            <h4>Bienvenidos</h4>
            <p>Contenido principal del sitio.</p>
        </div>
    </main>
</div>
<script>
function cargarModulo(modulo) {
    fetch("modulos/" + modulo) // 👈 agregamos ../ para subir un nivel
        .then(res => {
            if (!res.ok) throw new Error("HTTP error " + res.status);
            return res.text();
        })
        .then(data => {
            document.getElementById("contenido").innerHTML = data;
        })
        .catch(err => {
            console.error(err);
            document.getElementById("contenido").innerHTML = "<p>Error al cargar el módulo.</p>";
        });
}

</script>

</body>
</html>
