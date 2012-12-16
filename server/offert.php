<?php
/* 
// Ruteo Ofertas
$app->get('/offert', 'getOffert'); //Todas las ofertas
$app->get('/offert/user/:id', 'getOffertByUser'); //Todas las ofertas de un usuario dado
$app->get('/offert/seller/:id', 'getOffertBySeller'); //Todas las ofertas de un negocio
$app->get('/offert/category/:id', 'getOffertByCategory'); //Todas las ofertas de una categoria
$app->get('/offert/recent/category/:id', 'getRecentOffertByCategory'); //Todas las ofertas recientes (Menor a un día)
$app->get('/offert/:id','getOffertById'); //Una oferta
$app->post('/offert', 'addOffert');
$app->delete('/offert/:id', 'deleteOffert');
$app->put('/offert/:id', 'updateOffert');
*/

// Parameters
$daysFrame = -2;

//Todas las ofertas
function getOffert() {
    $sql = "select * FROM offert ORDER BY date";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $oferta = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Offert": ' . json_encode($oferta) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//Una oferta especifica
function getOffertById($id) {
    $sql = "SELECT * FROM offert WHERE idOffert=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $Offert = $stmt->fetchObject();
        $db = null;
        echo json_encode($Offert);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//Las ofertas de un usuario
function getOffertByUser($id){
    $sql = "SELECT * FROM offert WHERE userId=:id LIMIT 0, 30";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $oferta = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Offert": ' . json_encode($oferta) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//Las ofertas de un negocio
function getOffertBySeller($id){
    $sql = "SELECT * FROM offert WHERE sellerId=:id LIMIT 0, 30";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $oferta = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Offert": ' . json_encode($oferta) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//Las ofertas de una categoria
function getOffertByCategory($id){
    $sql = "SELECT * FROM offert WHERE categoryId=:id LIMIT 0, 30";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $oferta = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Offert": ' . json_encode($oferta) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//Las ofertas de una categoria
function getRecentOffertByCategory($id){
    $sql = "SELECT * FROM offert WHERE categoryId=:id and date > timestampadd(day, :daysFrame, now())";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("daysFrame", $GLOBALS['daysFrame']);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $oferta = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Offert": ' . json_encode($oferta) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


// Agregar Oferta
function addOffert() {
    $request = \Slim\Slim::getInstance()->request();
    $Oferta = json_decode($request->getBody());

    $sql = "INSERT INTO offert (offertName, offertDescription, date, photo, price, currency, sellerId, categoryId, userId) VALUES ( :offertName, :offertDescription, NOW(), :photo, :price, :currency, :sellerId, :categoryId, :userId);";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam("offertName", $Oferta->offertName);
        $stmt->bindParam("offertDescription", $Oferta->offertDescription);
        //$stmt->bindParam("date",$Oferta->date);
        //$stmt->bindParam("rating",$Oferta->rating);
        //$stmt->bindParam("ratingsCount",$Oferta->ratingsCount);
        $stmt->bindParam("photo",$Oferta->photo);
        $stmt->bindParam("price",$Oferta->price);
        $stmt->bindParam("currency",$Oferta->currency);
        $stmt->bindParam("sellerId",$Oferta->sellerId);
        $stmt->bindParam("categoryId",$Oferta->categoryId);
        $stmt->bindParam("userId",$Oferta->userId);
        
        $stmt->execute();
        $Oferta->id = $db->lastInsertId();
        $db = null;
        echo json_encode($Oferta);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

// Actualiza Oferta
function updateOffert($id) {
    $request = \Slim\Slim::getInstance()->request();
    $body = $request->getBody();
    $Oferta = json_decode($body);
    $sql = "UPDATE offert SET offertName=:offertName, offertDescription=:offertDescription, date=:date, rating=:rating, ratingsCount=:ratingsCount, photo=:photo, price=:price, currency=:currency, sellerId=:sellerId, categoryId=:categoryId, userId=:userId WHERE idOffert=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam("offertName", $Oferta->offertName);
        $stmt->bindParam("offertDescription", $Oferta->offertDescription);
        $stmt->bindParam("date",$Oferta->date);
        $stmt->bindParam("rating",$Oferta->rating);
        $stmt->bindParam("ratingsCount",$Oferta->ratingsCount);
        $stmt->bindParam("photo",$Oferta->photo);
        $stmt->bindParam("price",$Oferta->price);
        $stmt->bindParam("currency",$Oferta->currency);
        $stmt->bindParam("sellerId",$Oferta->sellerId);
        $stmt->bindParam("categoryId",$Oferta->categoryId);
        $stmt->bindParam("userId",$Oferta->userId);
        $stmt->bindParam("id", $id);
        
        $stmt->execute();
        $db = null;
        echo json_encode($Oferta);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

// Borrar Oferta
function deleteOffert($id) {
    $sql = "DELETE FROM offert WHERE idOffert=:id";
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

?>