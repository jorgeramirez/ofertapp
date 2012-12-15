

<?php
// Prueba de slim para api rest
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();


// ==================== PRUEBA ==================
$app->get('/oferta', 'getOfertas');
$app->get('/oferta/:id', 'getOferta');
$app->get('/oferta/search/:query','findByName');
$app->post('/oferta','addOferta');
$app->put('/oferta/:id','updateOferta');
$app->delete('/oferta/:id',   'deleteOferta');
$app->get('/hola', function () {
    echo 'Hola poronga';
});

// ==============================================

/* 
        >>>>>>>> RUTEO <<<<<<<<<<<<<
*/

// Ruteo Ofertas
$app->get('/offert', 'getOffert'); //Todas las ofertas
$app->get('/offert/user/:id', 'getOffertByUser'); //Todas las ofertas de un usuario dado
$app->get('/offert/seller/:id', 'getOffertBySeller'); //Todas las ofertas de un negocio
$app->get('/offert/category/:id', 'getOffertByCategory'); //Todas las ofertas de una categoria
$app->get('/offert/:id','getOffertById'); //Una oferta
$app->post('/offert', 'addOffert');
$app->delete('/offert/:id', 'deleteOffert');
$app->put('/offert/:id', 'updateOffert');

// Ruteo Usuarios
$app->get('/user', 'getUser'); //Todos los usuarios
$app->get('/user/:id' 'getUserById'); //Un usuario 
$app->post('/user', 'addUser');
$app->delete('/user/:id', 'deleteUser');
$app->put('/user/:id', 'updateUser');

// Ruteo Negocio
$app->get('/seller', 'getSeller'); //Todos los negocios
$app->get('/seller/:id', 'getSellerById'); //Un negocio
$app->get('/seller/:lat/:lon', 'getSellerByLatLon'); //Negocios cerca
$app->post('/seller', 'addSeller');
$app->delete('/seller/:id', 'deleteSeller');
$app->put('/seller/:id', 'updateSeller');

// Ruteo Categoria
$app->get('/category', 'getCategory'); //Todas las categorias
$app->get('/category/:id', 'getCategoryId'); //Una categoria
$app->post('/category', 'addCategory');
$app->delete('/category/:id', 'deleteCategory');
$app->put('/category/:id', 'updateCategory');






 
$app->run();
 
/*
    Se encarga de la conexion a la BD
*/
function getConnection() {
    $dbhost="127.0.0.1";
    $dbuser="root";
    $dbpass="pepe";
    $dbname="testdb";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
} 


function getOfertas() {
    $sql = "select * FROM Oferta ORDER BY nombre";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $oferta = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Oferta": ' . json_encode($oferta) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function getOferta($id) {
    $sql = "SELECT * FROM Oferta WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $Oferta = $stmt->fetchObject();
        $db = null;
        echo json_encode($Oferta);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function addOferta() {
    $request = \Slim\Slim::getInstance()->request();
    $Oferta = json_decode($request->getBody());
    $sql = "INSERT INTO Oferta (nombre, descripcion) VALUES (:nombre, :descripcion)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("nombre", $Oferta->nombre);
        $stmt->bindParam("descripcion", $Oferta->descripcion);
        $stmt->execute();
        $Oferta->id = $db->lastInsertId();
        $db = null;
        echo json_encode($Oferta);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function updateOferta($id) {
    $request = \Slim\Slim::getInstance()->request();
    $body = $request->getBody();
    $Oferta = json_decode($body);
    $sql = "UPDATE Oferta SET nombre=:nombre, descripcion=:descripcion WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("nombre", $Oferta->nombre);
        $stmt->bindParam("descripcion", $Oferta->descripcion);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
        echo json_encode($Oferta);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function deleteOferta($id) {
    $sql = "DELETE FROM Oferta WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function findByName($query) {
    $sql = "SELECT * FROM Oferta WHERE UPPER(nombre) LIKE :query ORDER BY nombre";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = "%".$query."%";
        $stmt->bindParam("query", $query);
        $stmt->execute();
        $oferta = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Oferta": ' . json_encode($oferta) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 

/*
*   Grupo de funciones para el manejo
*   de :        OFERTAS
*/

//Todas las ofertas
function getOffert() {
    $sql = "select * FROM offert ORDER BY date";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $oferta = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Oferta": ' . json_encode($oferta) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//Una oferta especifica
function getOferta($id) {
    $sql = "SELECT * FROM offert WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $Oferta = $stmt->fetchObject();
        $db = null;
        echo json_encode($Oferta);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//Las ofertas de un usuario
function getOffertByUser($id){
    
}

function addOffert() {
    $request = \Slim\Slim::getInstance()->request();
    $Oferta = json_decode($request->getBody());
    $sql = "INSERT INTO offert () VALUES ()";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam("offertName", $Oferta->offertName);
        $stmt->bindParam("offertDescription", $Oferta->offertDescription);
        
        $stmt->execute();
        $Oferta->id = $db->lastInsertId();
        $db = null;
        echo json_encode($Oferta);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function updateOffert($id) {
    $request = \Slim\Slim::getInstance()->request();
    $body = $request->getBody();
    $Oferta = json_decode($body);
    $sql = "UPDATE offert SET offertName=:offertName, offertDescription=:offertDescription WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam("offertName", $Oferta->offertName);
        $stmt->bindParam("offertDescription", $Oferta->offertDescription);
        $stmt->bindParam("id", $id);
        
        $stmt->execute();
        $db = null;
        echo json_encode($Oferta);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function deleteOffert($id) {
    $sql = "DELETE FROM offert WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

// >>>>>>>> FIN OFERTA <<<<<<<<<



?>