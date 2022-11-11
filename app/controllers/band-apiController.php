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
            $columns =["id_banda","id_genero_fk","nombre_banda","cantidad_discos","origen_banda"];

                if(!empty($_GET['sort']) && !empty($_GET['order']) && empty($_GET['offset']) && empty($_GET['limit'])){
                    

                    if(((strtoupper($_GET['order']) == 'ASC') || (strtoupper($_GET['order'])== 'DESC')) && in_array($_GET['sort'],$columns)){
                        var_dump(in_array($_GET['sort'],$columns));
                        $bands = $this->model->getAll($_GET['sort'],$_GET['order'],null,null);
                        $this->view->response($bands);
                        $this->view->response("consulta exitosa ",200);  
                    }
                    else{
                        $this->view->response("revise el nombre de columna o que haya ordenado correctamente",400); 
                    }
                    
                
                }
                else{
                    if(isset($_GET['offset']) && isset($_GET['limit']) && !isset($_GET['sort']) && !isset($_GET['order']) ) {
                        if(is_numeric($_GET['offset']) && is_numeric($_GET['limit'])){
                            $bands = $this->model->getAll(null,null,$_GET['offset'],$_GET['limit']);
                            $this->view->response($bands);
                            $this->view->response("consulta exitosa ",200);  
                        }
                        else{
                            $this->view->response("revise el valor ingresado. para ver su consulta, debe ingresar ambos valores numericos",400);
                        }   
                    }
                }

                if(isset($_GET['linkTo']) && isset($_GET['equalTo'])){
                        if(in_array($_GET['linkTo'],$columns)){
                            var_dump(in_array($_GET['linkTo'],$columns));
                            $bands = $this->model->getAll(null,null,null,null,$_GET['linkTo'],$_GET['equalTo']);
                            $this->view->response($bands);
                            $this->view->response("La consulta de filtro fue exitosa ",200);   
                        }
                        else{
                            $this->view->response("La consulta de filtro no fue exitosa ",400);
                        }
                        
                }
               
        
                if(!empty($_GET['sort']) && !empty($_GET['order']) && !empty($_GET['offset']) && !empty($_GET['limit'])){
                        $bands = $this->model->getAll($_GET['sort'],$_GET['order'],$_GET['offset'],$_GET['limit']);
                        $this->view->response($bands);
                        $this->view->response("La consulta del order con filtro fue Exitosa! ",200); 
                    }               
                else if(empty($_GET['sort']) && empty($_GET['order']) && empty($_GET['offset']) && empty($_GET['limit']) && empty($_GET['linkTo']) && empty($_GET['equalTo'])){
                    
                        $bands = $this->model->getAll();
                        $this->view->response($bands);
                        $this->view->response("La consulta de entidades fue Exitosa! ",200); 
                    }
            } catch (Exception $e){
                echo $e->getMessage();
                die();
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
    
    
       function updateBand($params = null){
    
            $id = $params[':ID'];
            
            $band = $this->getData(); //Agarra lo q mando en postman y lo pasa a json
    
            if($band){
                $this->model->updateBand($id,$band);
                $this->view->response($band);
                $this->view->response("La banda con el id=$id Fue creada con exito", 201);
            }
    
            else{
                $this->view->response("La banda con el id=$id No existe", 404);
            }
        }
    
    
        
           
        
    }
       

   
    
    
