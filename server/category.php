<?php
/* Mappings Functions to Category
*
$app->get('/category', 'getCategory'); //Todas las categorias
$app->get('/category/:id', 'getCategoryId'); //Una categoria
$app->post('/category', 'addCategory');
$app->delete('/category/:id', 'deleteCategory');
$app->put('/category/:id', 'updateCategory');

*/

function getCategory() {
    $sql = "select * FROM category";
    try {
        $db = getConnection();
        $stmt = $db->query($sql);
        $categorys = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo '{"Category": ' . json_encode($categorys) . '}';
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function getCategoryById($id) {
    $sql = "SELECT * FROM category WHERE idCategory=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $category = $stmt->fetchObject();
        $db = null;
        echo json_encode($category);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function addCategory() {
    $request = \Slim\Slim::getInstance()->request();
    $category = json_decode($request->getBody());
    $sql = "INSERT INTO `category` (categoryName) VALUES(:categoryName)";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("categoryName", $category->categoryName);
        $stmt->execute();
        $category->id = $db->lastInsertId();
        $db = null;
        echo json_encode($category);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function updateCategory($id) {
    $request = \Slim\Slim::getInstance()->request();
    $body = $request->getBody();
    $category = json_decode($body);
    $sql = "UPDATE category SET categoryName=:categoryName, smallPhoto=:smallPhoto, photo=:photo WHERE idCategory=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("categoryName", $category->categoryName);
        $stmt->bindParam("smallPhoto", $category->smallPhoto);
        $stmt->bindParam("photo", $category->photo);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $db = null;
        echo json_encode($category);
    } catch(PDOException $e) {
        echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
}
 
function deleteCategory($id) {
    $sql = "DELETE FROM category WHERE idCategory=:id";
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