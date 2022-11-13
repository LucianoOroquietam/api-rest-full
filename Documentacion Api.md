DOCUMENTACION API PARA RECURSO BANDAS

Una API FULL-REST sencilla para manejar un CRUD de bandas.

IMPORTAR LA BASE DE DATOS

importar desde PHPMyAdmin (o cualquiera) database/db_bandas.sql


PRUEBA CON POSTMAN

El endpoint de la API es: http://localhost/tucarpetalocal/api/bands


El nombre del recurso se asigna a un endpoint, aqui las consultas:

Method	Url	        Code	
GET	    /bands	        200	 -> coleccion de entidades.
GET	    /bands/:id	    200	 -> obtenemos un banda en especifica(:id).
POST	  /bands	        201	 -> creamos una banda.
DELETE	/bands/:id      200	 -> eliminamos una banda especifica(:id).


PAGINATION

agregar query params (?) para obtener la solicitud
    api/bands?limit=5&offset=1

SORTING

agregar query params (?) para obtener la solicitud
  order = ASC OR DESC.
  sort = Columna de la tabla correspondiente a la db.
ejemplo:
  api/bands?sort="columna"&order="desc"

Filtering

agregar query params (?) para obtener la solicitud
  linkTo = Nombre de la columna. 
  equalTo = Valor de la columna.
ejemplo:
  api/bands?linkTo="cantidad_discos"&equalTo="10"





CONTACTO
 oroquietaluciano@gmail.com

