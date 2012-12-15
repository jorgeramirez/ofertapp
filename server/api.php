

<?php
// Prueba de slim para api rest
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

$app->get('/oferta', 'getOfertas');
$app->get('/oferta/:id', 'getOferta');
$app->get('/oferta/search/:query','findByName');
$app->post('/oferta','addOferta');
$app->put('/oferta/:id','updateOferta');
$app->delete('/oferta/:id',   'deleteOferta');
$app->get('/hola', function () {
	echo 'Hola poronga';
});
 
$app->run();
 
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
 
function getConnection() {
    $dbhost="127.0.0.1";
    $dbuser="root";
    $dbpass="pepe";
    $dbname="testdb";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
} 


?>