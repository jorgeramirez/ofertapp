<?php
/*
// Ruteo Sellers
$app->get('/seller', 'getSeller'); //Todos los negocios
$app->get('/seller/:id', 'getSellerById'); //Un negocio
$app->get('/seller/close/:lat/:lon', 'getSellerByLatLon'); //Negocios cerca
$app->post('/seller', 'addSeller');
$app->delete('/seller/:id', 'deleteSeller');
$app->put('/seller/:id', 'updateSeller');
*/


function getSeller() {
    $sql = "select * FROM seller ORDER BY sellerName";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $seller = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Seller": ' . json_encode($seller) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function getSellerById($id) {
    $sql = "SELECT * FROM seller WHERE idSeller=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $Seller = $stmt->fetchObject();
        $db = null;
        echo json_encode($Seller);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function addSeller() {
    $request = \Slim\Slim::getInstance()->request();
    $Seller = json_decode($request->getBody());
    $sql = "INSERT INTO seller (sellerName, address, latitude, longitude, photo) VALUES (:sellerName, :address, :latitude, :longitude, :photo)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("sellerName", $Seller->sellerName);
        $stmt->bindParam("address", $Seller->address);
        $stmt->bindParam("latitude", $Seller->latitude);
        $stmt->bindParam("longitude", $Seller->longitude);
        $stmt->bindParam("photo", $Seller->photo);
        $stmt->execute();
        $Seller->id = $db->lastInsertId();
        $db = null;
        echo json_encode($Seller);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function updateSeller($id) {
    $request = \Slim\Slim::getInstance()->request();
    $body = $request->getBody();
    $Seller = json_decode($body);
    $sql = "UPDATE seller SET sellerName, address, latitude, longitude, photo WHERE idSeller=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("sellerName", $Seller->sellerName);
        $stmt->bindParam("address", $Seller->address);
        $stmt->bindParam("latitude", $Seller->latitude);
        $stmt->bindParam("longitude",$Seller->longitude);
        $stmt->bindParam("photo",$Seller->photo);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
        echo json_encode($Seller);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function deleteSeller($id) {
    $sql = "DELETE FROM seller WHERE idSeller=:id";
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

function getSellerByLatLon($lat,$lon){
    $sql = "select *, ( 6371 * acos( cos( radians( :latitude ) ) * cos( radians( latitude ) ) * cos( radians( longitude )- radians( :longitude ) ) + sin( radians( :latitude ) ) * sin( radians( latitude ) ) ) ) AS distance FROM seller HAVING distance <= 1 ORDER BY distance ASC";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("latitude", $lat);
        $stmt->bindParam("longitude", $lon);
        $stmt->execute();
        $seller = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Seller": ' . json_encode($seller) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

?>