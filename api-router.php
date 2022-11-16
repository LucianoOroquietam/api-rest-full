<?php
require_once './libs/Router.php';
require_once './app/controllers/band-apiController.php';


$router = new Router();


$router->addRoute('bands', 'GET', 'apiController', 'getBands');
$router->addRoute('bands/:ID', 'GET', 'apiController', 'getBand');
$router->addRoute('bands/:ID', 'DELETE', 'apiController', 'deleteBand');
$router->addRoute('bands', 'POST', 'apiController', 'insertBand');



$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);

