

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

/* NAHUEL
// Ruteo Usuarios
$app->get('/user', 'getUser'); //Todos los usuarios
$app->get('/user/:id' 'getUserById'); //Un usuario 
$app->post('/user', 'addUser');
$app->delete('/user/:id', 'deleteUser');
$app->put('/user/:id', 'updateUser');
*/


// Ruteo Negocio
$app->get('/seller', 'getSeller'); //Todos los negocios
$app->get('/seller/:id', 'getSellerById'); //Un negocio
$app->get('/seller/close/:lat/:lon', 'getSellerByLatLon'); //Negocios cerca
$app->post('/seller', 'addSeller');
$app->delete('/seller/:id', 'deleteSeller');
$app->put('/seller/:id', 'updateSeller');


/* NAHUEL
// Ruteo Categoria
$app->get('/category', 'getCategory'); //Todas las categorias
$app->get('/category/:id', 'getCategoryId'); //Una categoria
$app->post('/category', 'addCategory');
$app->delete('/category/:id', 'deleteCategory');
$app->put('/category/:id', 'updateCategory');
*/





 
$app->run();
 
/*
    Se encarga de la conexion a la BD
*/
function getConnection() {
    $dbhost="127.0.0.1";
    $dbuser="root";
    $dbpass="pepe";
    $dbname="offertappdatabase";
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

    // Agregar Oferta
    function addOffert() {
        $request = \Slim\Slim::getInstance()->request();
        $Oferta = json_decode($request->getBody());

        $sql = "INSERT INTO offert (offertName, offertDescription, date, rating, ratingsCount, photo, price, currency, sellerId, categoryId, userId) VALUES ( :offertName, :offertDescription, :date, :rating, :ratingsCount, :photo, :price, :currency, :sellerId, :categoryId, :userId);";

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

    // >>>>>>>> FIN OFERTA <<<<<<<<<

/*
*   Grupo de funciones para el manejo
*   de :        NEGOCIO
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