# DOCUMENTACION API PARA RECURSO BANDAS

Una API FULL-REST sencilla para manejar un CRUD de bandas.

# IMPORTAR LA BASE DE DATOS

importar desde PHPMyAdmin (o cualquiera) database/db_bandas.sql


# PRUEBA CON POSTMAN

El endpoint de la API es: http://localhost/tucarpetalocal/api/bands


El nombre del recurso se asigna a un endpoint, aqui las consultas:

# Method	Url	        Code	
GET	    /bands	        200	 -> coleccion de entidades.

GET	    /bands/:id	    200	 -> obtenemos un banda en especifica(:id).

POST	  /bands	        201	 -> creamos una banda.

DELETE	/bands/:id      200	 -> eliminamos una banda especifica(:id).

## Method: GET, URL : carpetaProyecto/api/bands/:ID -
Al endpoint agregandole un ID especifico logramos que nos traiga el detalle de una banda en especifica. 

## Method: DELETE, URL: carpetaProyecto/api/bands/:ID -
Con el metodo DELETE lo que logramos es poder eliminar una banda con un ID en especifico.

## Method: POST, URL: carpetaProyecto/api/bands -
Para insertar una banda necesitamos el body en formato JSON, para poder completar los campos de dicha banda.
por ejemplo:

{
"id_genero_fk": 1,
"nombre_banda": "Ratones paranoicos",
"cantidad_discos": 20,
"origen_banda": " Argentina, Buenos Aires(1994)"
}

# PAGINACION

agregar query params (?) para obtener la solicitud
    api/bands?limit=5&offset=1

# ORDENAMIENTO

agregar query params (?) para obtener la solicitud
  order = ASC OR DESC.
  sort = Columna de la tabla correspondiente a la db.
ejemplo:
  api/bands?sort="columna"&order="desc"

# FILTRADO

agregar query params (?) para obtener la solicitud
  linkTo = Nombre de la columna. 
  equalTo = Valor de la columna.
ejemplo:
  api/bands?linkTo="cantidad_discos"&equalTo="10"





# CONTACTO
 oroquietaluciano@gmail.com

