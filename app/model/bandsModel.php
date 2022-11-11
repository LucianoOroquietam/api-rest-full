<?php

class bandsModel{

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_bandas;charset=utf8', 'root', '');
    }


    function getAll($sort=null,$order=null,$offset=null,$limit=null,$linkTo=null,$equalTo=null){

       
        
        if(($sort && $order) && ($offset==null && $limit==null)){
            echo "entro al order";
            /*Ordenar datos sin limites */
            $query= $this->db->prepare("SELECT id_banda,nombre_banda,cantidad_discos,origen_banda FROM bandas ORDER BY $sort $order");
            $query->execute();
        }
        else{
            if(($offset && $limit) && ($sort==null && $order==null) ){
                echo "entro en ofset limit";
                    /*Limitar datos sin ordenar */
                    $query= $this->db->prepare("SELECT id_banda,nombre_banda,cantidad_discos,origen_banda FROM bandas LIMIT $limit OFFSET $offset");
                    $query->execute(); 
            }
        }

       if($sort!=null && $order!=null && $limit!=null && $offset!=null) {

        echo "entro al order con limit";
        /*Limitar datos con orden */
        $query= $this->db->prepare("SELECT id_banda,nombre_banda,cantidad_discos,origen_banda FROM bandas ORDER BY $sort $order LIMIT $limit OFFSET $offset");
        $query->execute(); 
           
       }else{
            if($sort==null && $order==null && $limit==null && $offset==null && $linkTo==null && $equalTo==null){
                echo "entro al get all";
                    /*traigo la coleccion completa sin filtrar ni ordenar */
                    $query = $this->db->prepare("SELECT id_banda,nombre_banda,cantidad_discos,origen_banda FROM bandas");
                    $query->execute();
            }
       }

       if($sort==null && $order==null && $limit==null && $offset==null && $linkTo!=null && $equalTo!=null){

        echo "entro al filter";
        /*filtrado por valor de columna */
        $query= $this->db->prepare("SELECT id_banda,nombre_banda,cantidad_discos,origen_banda FROM bandas WHERE $linkTo = :$linkTo");
        $query->bindParam(":".$linkTo, $equalTo, PDO::PARAM_STR);
        $query->execute();

       }
      
      

       

       $bands= $query->fetchAll(PDO::FETCH_OBJ);
       return $bands;
    }

    function getOne($id){
        $query = $this->db->prepare('SELECT id_banda,nombre_banda,cantidad_discos,origen_banda FROM bandas WHERE id_banda=?');
        $query->execute([$id]);

        $band = $query->fetch(PDO::FETCH_OBJ);

        return $band;

    }

    function deleteOne($id){
        $query = $this->db->prepare('DELETE FROM bandas WHERE id_banda= ?');
        $query->execute([$id]);
    }

    function insertBand($nombre_banda, $cantidad_discos, $origen_banda,$id_genero_fk){
        $query = $this->db->prepare('INSERT INTO bandas (nombre_banda, cantidad_discos, origen_banda,id_genero_fk) VALUES (?, ?, ?, ?)');
        $query->execute([$nombre_banda, $cantidad_discos, $origen_banda,$id_genero_fk]);

        return $this->db->lastInsertId(); 
        //devuelvo el ultimo id ,en este caso devuelvo la ultima banda que agregue
    }

    function updateBand($id,$band){
        $query = $this->db->prepare('UPDATE bandas SET nombre_banda=?,cantidad_discos=?,origen_banda=? WHERE id_banda=?');
        $query->execute(array($band->nombre_banda,$band->cantidad_discos,$band->origen_banda,$id));
    }

    

}