<?php

require_once 'app/model/bandsModel.php';
require_once 'app/view/Api.View.php';
class apiController{
    private $view;
    private $model;
    private $data;
    
    function __construct(){

        $this->view = new apiView();
        $this->model = new bandsModel();
        $this->data = file_get_contents("php://input");
        //permite leer la entrada enviada en formato raw    
    }

    private function getData() {
        return json_decode($this->data);
        //devuelve un objeto json
    }

    function getBands($params=null){

        try{ 
                $linkTo = $_GET["linkTo"] ?? null;
                $equalTo = $_GET["equalTo"] ?? null;
                $sort = $_GET["sort"] ?? null;
                $order = $_GET["order"] ?? null;
                $limit = $_GET["limit"] ?? null;
                $offset =  $_GET["offset"] ?? null;

                $this->verifyParams($linkTo, $equalTo, $sort, $order, $limit, $offset);

                $bands=null;

                if(isset($sort) && isset($order) && isset($offset) && isset($limit) && isset($linkTo) && isset($equalTo) ){
                    $bands = $this->model->getAll($sort, $order, $offset, $limit, $linkTo, $equalTo);
                }
                else if(isset($sort) && isset($order) && isset($linkTo) && isset($equalTo) ){
                    $bands = $this->model->getAll($sort, $order, null, null, $linkTo, $equalTo); 
                }
                else if(isset($offset) && isset($limit) && isset($linkTo) && isset($equalTo) ){
                    $bands = $this->model->getAll(null, null, $offset, $limit, $linkTo, $equalTo); 
                }
                else if(isset($sort) && isset($order) && isset($offset) && isset($limit)){
                    $bands = $this->model->getAll($sort, $order, $offset, $limit,null,null);
                }
                else if(isset($linkTo) && isset($equalTo)){
                    $bands = $this->model->getAll(null, null, null, null, $linkTo, $equalTo);
                }
                else if(isset($sort)&&isset($order)){
                    $bands = $this->model->getAll($sort,$order,null,null,null,null); 
                }
                else if(isset($offset) && isset($limit)){
                    $bands = $this->model->getAll(null,null,$offset,$limit,null,null);  
                }
                else{
                    $bands = $this->model->getAll(null,null,null,null,null,null);  
                }
                if ($bands!=null){
                    $this->view->response($bands, 200);
                }else{
                    $this->view->response("Bandas No encontradas", 404);
                }

           }catch(Exception $e){
                $this->view->response("Internal Server Error", 500);
            }

        }
        function verifyParams($linkTo, $equalTo, $sort, $order, $limit, $offset) {
            $columns = [
                "id_banda", 
                "id_genero_fk", 
                "nombre_banda", 
                "cantidad_discos", 
                "origen_banda", 
                "imagen_banda",
                "genero_banda"
            ];

            
            if ($equalTo!=null && !in_array(strtolower($linkTo), $columns)) {
                $this->view->response("parametro de consulta incorrecto linkTo: $linkTo en la solicitud GET", 400);
                die;
            }
            if ($linkTo != null && $equalTo == null) {
                $this->view->response("Enlace de parámetro incorrecto= $linkTo o faltante en la solicitud GET", 400);
                die;
            }
    
            if ($order != null && !in_array(strtolower($sort), $columns)) {
                $this->view->response("columna erronea: $sort o orden mal escrito $order in GET request", 400);
                die;
            }
    
            if (($order != null) && ($order != "asc" && $order != "desc" && $order !="ASC" && $order !="DESC")) {
                $this->view->response("Orden de parámetro de consulta incorrecto en la solicitud GET", 400);
                die;
            }
    
            if ($offset != null && (!is_numeric($offset) || $offset < 0)) {
                $this->view->response("Página de parámetro de consulta incorrecta en la solicitud GET", 400);
                die;
            }
    
            if ($limit != null && (!is_numeric($limit) || $limit < 0)) {
                $this->view->response("Límite de parámetro de consulta incorrecto en la solicitud GET", 400);
                die;
            }
            
        }  
            
        function getBand($params= null){
            $id = $params[':ID'];
            $band = $this->model->getOne($id);

            if($band){
                $this->view->response($band);
            }
            else{
                $this->view->response("La banda con el id = $id no existe", 404);
            }
        }
    
    
        function deleteBand($params = null){
    
            $id = $params[':ID'];
    
            $band = $this->model->getOne($id);
    
            if($band){
                $this->model->deleteOne($id);
                $this->view->response("La banda: $band->nombre_banda con el id = $id fue eliminada con exito",200);
            }
    
            else{
                $this->view->response("La banda con el id = $id no existe", 404);
            }
    
        }
    
        function insertBand($params = null){
    
            $bands = $this->getData();
            //esto seria el body de mi objeto json 
    
            if (empty($bands->nombre_banda) || empty($bands->cantidad_discos) || empty($bands->origen_banda) || empty($bands->id_genero_fk) ) {
                $this->view->response("DATOS INCOMPLETOS!! ,Complete los datos para continuar con la consulta", 400);
            } else {
                $id = $this->model->insertBand($bands->nombre_banda, $bands->cantidad_discos, $bands->origen_banda, $bands->id_genero_fk);
                $band = $this->model->getOne($id);
                $this->view->response("La banda: $bands->nombre_banda con el id = $id fue creada con exito", 201);
              
                $this->view->response($band, 201);
            }
        }   
    }
       

   
    
    
