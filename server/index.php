<?php
// Slim for API REST
require 'Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// Include functions to be mapping
include 'user.php';
include 'category.php';
include 'seller.php';
include 'offer.php';

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

// Offers
$app->get('/offer', 'getOffer'); //Todas las ofertas
$app->get('/offer/user/:id', 'getOfferByUser'); //Todas las ofertas de un usuario dado
$app->get('/offer/seller/:id', 'getOfferBySeller'); //Todas las ofertas de un negocio
$app->get('/offer/category/:id', 'getOfferByCategory'); //Todas las ofertas de una categoria
$app->get('/offer/recent/category/:id', 'getRecentOfferByCategory'); //Todas las ofertas recientes (Menor a un día)
$app->get('/offer/:id','getOfferById'); //Una oferta
$app->post('/offer', 'addOffer');
$app->delete('/offer/:id', 'deleteOffer');
$app->put('/offer/:id', 'updateOffer');

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
    $dbhost="212.1.210.181";
    $dbuser="groupwe_ofertapp";
    $dbpass="ofertapp";
    $dbname="groupwe_ofertapp";
    $dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}

?>