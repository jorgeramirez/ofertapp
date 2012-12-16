<?php
/* 
// Ruteo Ofertas
$app->get('/offer', 'getOffer'); //Todas las ofertas
$app->get('/offer/user/:id', 'getOfferByUser'); //Todas las ofertas de un usuario dado
$app->get('/offer/seller/:id', 'getOfferBySeller'); //Todas las ofertas de un negocio
$app->get('/offer/category/:id', 'getOfferByCategory'); //Todas las ofertas de una categoria
$app->get('/offer/recent/category/:id', 'getRecentOfferByCategory'); //Todas las ofertas recientes (Menor a un día)
$app->get('/offer/:id','getOfferById'); //Una oferta
$app->post('/offer', 'addOffer');
$app->delete('/offer/:id', 'deleteOffer');
$app->put('/offer/:id', 'updateOffer');
*/

// Parameters
$daysFrame = -2;

//Todas las ofertas
function getOffer() {
    $sql = "select * FROM offer ORDER BY date";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $oferta = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Offer": ' . json_encode($oferta) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//Una oferta especifica
function getOfferById($id) {
    $sql = "SELECT * FROM offer WHERE idOffer=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $Offer = $stmt->fetchObject();
        $db = null;
        echo json_encode($Offer);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//Las ofertas de un usuario
function getOfferByUser($id){
    $sql = "SELECT * FROM offer WHERE userId=:id LIMIT 0, 30";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $oferta = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Offer": ' . json_encode($oferta) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//Las ofertas de un negocio
function getOfferBySeller($id){
    $sql = "SELECT * FROM offer WHERE sellerId=:id LIMIT 0, 30";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $oferta = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Offer": ' . json_encode($oferta) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//Las ofertas de una categoria
function getOfferByCategory($id){
    $sql = "SELECT * FROM offer WHERE categoryId=:id LIMIT 0, 30";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $oferta = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Offer": ' . json_encode($oferta) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

//Las ofertas de una categoria
function getRecentOfferByCategory($id){
    $sql = "SELECT offer.*,seller.latitude, seller.longitude, category.smallPhoto FROM offer,seller,category WHERE offer.categoryId=:id and date > timestampadd(day, :daysFrame, now()) and seller.idSeller = offer.sellerId and offer.categoryId = category.idCategory";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("daysFrame", $GLOBALS['daysFrame']);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $oferta = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Offer": ' . json_encode($oferta) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}


// Agregar Oferta
function addOffer() {
    $request = \Slim\Slim::getInstance()->request();
    $Oferta = json_decode($request->getBody());

    $sql = "INSERT INTO offer (offerName, offerDescription, date, photo, price, currency, sellerId, categoryId, userId) VALUES ( :offerName, :offerDescription, NOW(), :photo, :price, :currency, :sellerId, :categoryId, :userId);";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam("offerName", $Oferta->offerName);
        $stmt->bindParam("offerDescription", $Oferta->offerDescription);
        //$stmt->bindParam("date",$Oferta->date);
        //$stmt->bindParam("rating",$Oferta->rating);
        //$stmt->bindParam("ratingsCount",$Oferta->ratingsCount);
        $stmt->bindParam("photo",$Oferta->photo);
        $stmt->bindParam("price",$Oferta->price);
        $stmt->bindParam("currency", $Oferta->currency);
        $stmt->bindParam("sellerId",$Oferta->sellerId);
        $stmt->bindParam("categoryId",$Oferta->categoryId);
        $stmt->bindParam("userId",$Oferta->userId);
        
        $stmt->execute();
        $Oferta->idOffer = $db->lastInsertId();
        $db = null;
        echo json_encode($Oferta);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

// Actualiza Oferta
function updateOffer($id) {
    $request = \Slim\Slim::getInstance()->request();
    $body = $request->getBody();
    $Oferta = json_decode($body);
    $sql = "UPDATE offer SET offerName=:offerName, offerDescription=:offerDescription, date=:date, rating=:rating, ratingsCount=:ratingsCount, photo=:photo, price=:price, currency=:currency, sellerId=:sellerId, categoryId=:categoryId, userId=:userId WHERE idOffer=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        
        $stmt->bindParam("offerName", $Oferta->offerName);
        $stmt->bindParam("offerDescription", $Oferta->offerDescription);
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
function deleteOffer($id) {
    $sql = "DELETE FROM offer WHERE idOffer=:id";
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