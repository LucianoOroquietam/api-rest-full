<?php
require_once './libs/Router.php';
require_once './app/controllers/band-apiController.php';

// crea el router
$router = new Router();

// defina la tabla de ruteo
$router->addRoute('bands', 'GET', 'apiController', 'getBands');
$router->addRoute('bands/:ID', 'GET', 'apiController', 'getBand');
$router->addRoute('bands/:ID', 'DELETE', 'apiController', 'deleteBand');
$router->addRoute('bands', 'POST', 'apiController', 'insertBand');
$router->addRoute('bands/:ID', 'PUT', 'apiController', 'updateBand');





// ejecuta la ruta (sea cual sea)
$router->route($_GET["resource"], $_SERVER['REQUEST_METHOD']);
