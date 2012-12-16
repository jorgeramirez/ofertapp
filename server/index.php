<?php
// Slim for API REST
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// Include functions to be mapping
include 'user.php';
include 'category.php';
include 'seller.php';
include 'offert.php';

/*
 *
 * Mappings
 *
 */

// Users
$app->get('/user', 'getUser'); //Todos los usuarios
$app->get('/user/:id', 'getUserById'); //Un usuario 
$app->get('/user/oauth/:id', 'getUserByOauth'); //Un usuario por Oauth
$app->post('/user', 'addUser');
$app->delete('/user/:id', 'deleteUser');
$app->put('/user/:id', 'updateUser');

// Categories
$app->get('/category', 'getCategory'); //Todas las categorias
$app->get('/category/:id', 'getCategoryById'); //Una categoria
$app->post('/category', 'addCategory');
$app->delete('/category/:id', 'deleteCategory');
$app->put('/category/:id', 'updateCategory');

// Offerts
$app->get('/offert', 'getOffert'); //Todas las ofertas
$app->get('/offert/user/:id', 'getOffertByUser'); //Todas las ofertas de un usuario dado
$app->get('/offert/seller/:id', 'getOffertBySeller'); //Todas las ofertas de un negocio
$app->get('/offert/category/:id', 'getOffertByCategory'); //Todas las ofertas de una categoria
$app->get('/offert/:id','getOffertById'); //Una oferta
$app->post('/offert', 'addOffert');
$app->delete('/offert/:id', 'deleteOffert');
$app->put('/offert/:id', 'updateOffert');

// Sellers (Negocios)
$app->get('/seller', 'getSeller'); //Todos los negocios
$app->get('/seller/:id', 'getSellerById'); //Un negocio
$app->get('/seller/close/:lat/:lon', 'getSellerByLatLon'); //Negocios cerca
$app->post('/seller', 'addSeller');
$app->delete('/seller/:id', 'deleteSeller');
$app->put('/seller/:id', 'updateSeller');


$app->run();

 
/*
    Function to manage the connection to de DB
*/

function getConnection() {
    $dbhost="127.0.0.1";
    $dbuser="root";
    $dbpass="";
    $dbname="ofertappdatabase";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

?>