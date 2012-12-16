<?php
/*
// Ruteo Usuarios
$app->get('/user', 'getUser'); //Todos los usuarios
$app->get('/user/:id', 'getUserById'); //Un usuario 
$app->get('/user/oauth/:id', 'getUserByOauth'); //Un usuario por Oauth
$app->post('/user', 'addUser');
$app->delete('/user/:id', 'deleteUser');
$app->put('/user/:id', 'updateUser');
*/

function getUser() {
    $sql = "select * FROM user";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $users = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"User": ' . json_encode($users) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function getUserById($id) {
    $sql = "SELECT * FROM user WHERE idUser=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $user = $stmt->fetchObject();
        $db = null;
        echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function getUserByOauth($id) {
    $sql = "SELECT * FROM user WHERE userIDFb=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $user = $stmt->fetchObject();
        $db = null;
        echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}

function addUser() {
    $request = \Slim\Slim::getInstance()->request();
    $user = json_decode($request->getBody());
    $sql = "INSERT INTO user (userIDFb, mail, creationDate) VALUES(:userID, :mail, NOW())";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("userID", $user->userIDFb);
        $stmt->bindParam("mail", $user->mail);
        $stmt->execute();
        $user->idUser = $db->lastInsertId();
        $db = null;
        echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function updateUser($id) {
    $request = \Slim\Slim::getInstance()->request();
    $body = $request->getBody();
    $user = json_decode($body);
    $sql = "UPDATE user SET userIDFb=:userID, mail=:mail, offersCount=:offersCount, rating=:rating, ratingsCount=:ratingCount, creationDate=:creationDate WHERE idUser=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("userID", $user->userID);
        $stmt->bindParam("mail", $user->mail);
        $stmt->bindParam("offersCount", $user->offersCount);
        $stmt->bindParam("rating", $user->rating);
        $stmt->bindParam("ratingsCount", $user->ratingsCount);
        $stmt->bindParam("creationDate", $user->creationDate);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
        echo json_encode($user);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function deleteUser($id) {
    $sql = "DELETE FROM user WHERE idUser=:id";
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