<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
//Autenticacion toker
use Tuupola\Middleware\JwtAuthentication;
use Firebase\JWT\JWT;
use App\Conexion;
use App\ClientesRepository;
use App\FormasPagoRepository;
use App\middleware\RoleMiddleware;


//---------------------
//RUTAS
//---------------------
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/conexion.php';
require __DIR__ . '/../src/clientesRepository.php';
require __DIR__ . '/../src/UsuariosRepository.php';
require __DIR__ . '/../src/FormasPagoRepository.php';
require __DIR__ . '/../src/middleware/roleMiddleware.php';


$app = AppFactory::create();
$app->addBodyParsingMiddleware();
 

//-------------------------------------------------------
// RUTA DE LOGIN PARA GENERAR TOKEN (PARA USER O ADMIN)
//-------------------------------------------------------

$app->post('/login', function (Request $request, Response $response) {
$header = $request->getHeaderLine('Authorization');


    //validar qu el ancabezado empiece con Basic, sino entra al if y tira error 
    if (strpos($header, 'Basic ') !== 0) {
        $response->getBody()->write(json_encode(["error" => "Falta encabezado Authorization"]));
        return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
    }

    // Decodificar credenciales  (quitar Basic) y comvertir a texto
    $solocredenciales = substr($header, 6);     //6: para empezar en la posicion 6 (Basic)
    $textocredenciales = base64_decode($solocredenciales);

    // Separar usuario y contraseña
    $partes = explode(':', $textocredenciales, 2);
    $username = $partes[0];
    $password = $partes[1];

    $repo = new \App\UsuariosRepository();
    $user = $repo->obtenerUsuarioPorUsername($username);

     if (!$user || $password !== $user['contraseña']) {
        $response->getBody()->write(json_encode(["error" => "Credenciales incorrectas."]));
        return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
     }
    $role = $user['rol'];


    $key = "Yasminarevalo2005";      
    $payload = [
        "iss" => "example.com",
        "aud" => "example.com",
        "iat" => time(),
        "nbf" => time(),
        "exp" => time() + 86400,
        "data" => [
            "username" => $username,
            "role" => $role
        ]
    ];

    $token = JWT::encode($payload, $key, 'HS256');
    $response->getBody()->write(json_encode(["token" => $token]));
    return $response->withHeader('Content-Type', 'application/json');
});
// Middleware para permitir CORS
$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type, Accept, Origin')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});
// Permitir preflight OPTIONS para todas las rutas
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'Authorization, Content-Type, Accept, Origin')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});
//-------------------------------------------------------
// MIDDLEWARE JWT
//-------------------------------------------------------
$app->add(new JwtAuthentication([
    "secret" => "Yasminarevalo2005",
    "attribute" => "token",
    "path" => ["/"],
    "ignore" => ["/api-chipana/public/login"],
    "algorithm" => ["HS256"],
    "secure" => false
    
]));




//-------------------------------------------------------
// CRUD CLIENTES USANDO CLASE
//-------------------------------------------------------

//mostrar todos los clietes
$app->get('/clientes', function (Request $request, Response $response) {
    $repo = new ClientesRepository();
    $data = $repo->obtenerTodosLosClientes(); //metodo de la clase Clientes
    $response->getBody()->write(json_encode($data));   
    return $response->withHeader('Content-Type', 'application/json');
});


$app->post('/clientes', function (Request $request, Response $response) {
    $data = json_decode($request->getBody(), true);   //obtiene lo que envio en el body
    $repo = new ClientesRepository();

     if($repo->crearCliente($data)) { //metodo de la clase Cliente
        $response->getBody()->write(json_encode(["message" => "Cliente creado"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    } else {
        $response->getBody()->write(json_encode(["message" => "Error al crear cliente"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
});


$app->put('/clientes/{id_cliente}', function (Request $request, Response $response, $args) {
    $id_cliente = $args["id_cliente"];    //obtiene el id que esta el URL
    $data = json_decode($request->getBody(), true);  //obtiene los datos enviado en el body
    $repo = new ClientesRepository();

    if($repo->actualizarCliente($id_cliente, $data)) { 
        $response->getBody()->write(json_encode(["message" => "Cliente actualizado"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        $response->getBody()->write(json_encode(["message" => "Error al actualizar cliente"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
});

$app->delete('/clientes/{id_cliente}', function (Request $request, Response $response, $args) {
    $id_cliente = $args["id_cliente"];   //obtiene el id por la URL
    $repo = new ClientesRepository();

   if($repo->eliminarCliente($id_cliente)) {
        $response->getBody()->write(json_encode(["message" => "Cliente eliminado"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        $response->getBody()->write(json_encode(["message" => "Error al eliminar cliente"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
})->add(new RoleMiddleware(['admin']));







//-------------------------------------------------------
// CRUD FORMAS DE PAGO USANDO CLASE
//-------------------------------------------------------

//mostrar todos los clietes
$app->get('/formaspago', function (Request $request, Response $response) {
    $repo = new FormasPagoRepository();
    $data = $repo->obtenerTodasLasFormasDePago(); //metodo de la clase Clientes
    $response->getBody()->write(json_encode($data));   
    return $response->withHeader('Content-Type', 'application/json');
});


$app->post('/formaspago', function (Request $request, Response $response) {
    $data = json_decode($request->getBody(), true);   //obtiene lo que envio en el body
    $repo = new FormasPagoRepository();

     if($repo->crearFormaPago($data)) { //metodo de la clase Cliente
        $response->getBody()->write(json_encode(["message" => "Forma de Pago creada"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
    } else {
        $response->getBody()->write(json_encode(["message" => "Error al crear la forma de pago"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
});


$app->put('/formaspago/{id_forma_pago}', function (Request $request, Response $response, $args) {
    $id_forma_pago = $args["id_forma_pago"];    //obtiene el id que esta el URL
    $data = json_decode($request->getBody(), true);  //obtiene los datos enviado en el body
    $repo = new FormasPagoRepository();

    if($repo->actualizarFormaPago($id_forma_pago, $data)) { 
        $response->getBody()->write(json_encode(["message" => "Forma de Pago actualizada"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        $response->getBody()->write(json_encode(["message" => "Error al actualizar la forma de pago"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
});

$app->delete('/formaspago/{id_forma_pago}', function (Request $request, Response $response, $args) {
    $id_forma_pago = $args["id_forma_pago"];   //obtiene el id por la URL
    $repo = new FormasPagoRepository();

   if($repo->eliminarFormaPago($id_forma_pago)) {
        $response->getBody()->write(json_encode(["message" => "Forma de Pago eliminada"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        $response->getBody()->write(json_encode(["message" => "Error al eliminar la forma de pago"]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
    }
})->add(new RoleMiddleware(['admin']));



$app->addErrorMiddleware (true,true,true);
$app->setBasePath('/api-chipana/public');


$app->run();
?>