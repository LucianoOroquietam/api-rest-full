<?php

class bandsModel{

    private $db;

    public function __construct() {
        $this->db = new PDO('mysql:host=localhost;'.'dbname=db_bandas;charset=utf8', 'root', '');
    }

    function getAll($sort,$order,$offset,$limit,$linkTo, $equalTo){

        if(($sort && $order) && ($offset==null && $limit==null && $linkTo==null && $equalTo==null)){
            /*Ordenar datos sin limites */
            $query = $this->db->prepare("SELECT id_banda,nombre_banda,cantidad_discos,origen_banda,genero_banda FROM bandas JOIN genero ON bandas.id_genero_fk = genero.id_genero ORDER BY $sort $order");
            $query->execute();
        }else{
            if(($offset!=null && $limit!=null) && ($sort==null && $order==null)){    
                /*Limitar datos sin ordenar */
                $query= $this->db->prepare("SELECT id_banda,nombre_banda,cantidad_discos,origen_banda,genero_banda FROM bandas JOIN genero ON bandas.id_genero_fk = genero.id_genero LIMIT $limit OFFSET $offset");
                $query->execute();      
            } 
        }

       if(($sort!=null && $order!=null && $limit!=null && $offset!=null && $linkTo==null && $equalTo==null)){
            /*Limitar datos con orden */
            $query= $this->db->prepare("SELECT id_banda,nombre_banda,cantidad_discos,origen_banda,genero_banda FROM bandas JOIN genero ON bandas.id_genero_fk = genero.id_genero ORDER BY $sort $order LIMIT $limit OFFSET $offset");
            $query->execute(); 
       }else{
            if($sort==null && $order==null && $limit==null && $offset==null && $linkTo==null && $equalTo==null){
               /*obtener la coleccion completa sin filtrar ni ordenar */
                    $query = $this->db->prepare("SELECT id_banda,nombre_banda,cantidad_discos,origen_banda,genero_banda FROM bandas JOIN genero ON bandas.id_genero_fk = genero.id_genero");
                    $query->execute();
            }
       }

       if($sort==null && $order==null && $limit==null && $offset==null && $linkTo!=null && $equalTo!=null){
        /*filtrado por valor de columna */
        $query= $this->db->prepare("SELECT id_banda,nombre_banda,cantidad_discos,origen_banda,genero_banda FROM bandas JOIN genero ON bandas.id_genero_fk = genero.id_genero WHERE $linkTo = :$linkTo");
        $query->bindParam(":".$linkTo, $equalTo, PDO::PARAM_STR); 
        $query->execute();

       }
       else if($sort!=null && $order!=null && $linkTo!=null && $equalTo!=null && $limit==null && $offset==null){
        /*filtrado con order by*/ 
        $query= $this->db->prepare("SELECT id_banda,nombre_banda,cantidad_discos,origen_banda,genero_banda FROM bandas JOIN genero ON bandas.id_genero_fk = genero.id_genero WHERE $linkTo = :$linkTo ORDER BY $sort $order");
        $query->bindParam(":".$linkTo, $equalTo, PDO::PARAM_STR); 
        $query->execute();
       }

       else if($limit!=null && $offset!=null && $linkTo!=null && $equalTo!=null && $order==null && $sort==null){
        /*filtrado con limit*/ 
        $query= $this->db->prepare("SELECT id_banda,nombre_banda,cantidad_discos,origen_banda,genero_banda FROM bandas JOIN genero ON bandas.id_genero_fk = genero.id_genero WHERE $linkTo = :$linkTo LIMIT $limit OFFSET $offset");
        $query->bindParam(":".$linkTo, $equalTo, PDO::PARAM_STR); 
        $query->execute();
       }

       else if($sort!=null && $order!=null && $limit!=null && $offset!=null && $linkTo!=null && $equalTo!=null){
        /*Filtrado con order y limit */
        $query= $this->db->prepare("SELECT id_banda,nombre_banda,cantidad_discos,origen_banda,genero_banda FROM bandas JOIN genero ON bandas.id_genero_fk = genero.id_genero WHERE $linkTo = :$linkTo ORDER BY $sort $order LIMIT $limit OFFSET $offset");
        $query->bindParam(":".$linkTo, $equalTo, PDO::PARAM_STR); 
        $query->execute();
       }

       $bands= $query->fetchAll(PDO::FETCH_OBJ);
       return $bands;
    }
    function getOne($id){
        $query = $this->db->prepare("SELECT id_banda,nombre_banda,cantidad_discos,origen_banda,genero_banda FROM bandas JOIN genero ON bandas.id_genero_fk = genero.id_genero WHERE id_banda=?");
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
}