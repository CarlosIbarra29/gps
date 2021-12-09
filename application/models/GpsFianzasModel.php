<?php

class Application_Model_GpsFianzasModel extends Zend_Db_Table_Abstract{
    protected $_name = 'fianzas';
    protected $_primary = 'id';


    public function GetFianzasAll(){ 
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM fianzas");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }


    public function GetFianzasAllpaginator($offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.*, s.id_cliente 
                FROM fianzas f
                INNER JOIN sitios s ON s.id = f.id_sitio
                ORDER by id LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET INFO TO PAGINATOR


    public function inserfianzaall($post,$table,$urldb,$nombre_usuario,$id_user,$hoy,$name_sitio){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'archivo_fianza'=>$urldb,
                'fecha_vigencia'=>$post['vigencia'], 
                'comentario'=>$post['comentario'],
                'fecha_insersion'=>$hoy,
                'id_user'=>$id_user,
                'user_modificacion'=>$nombre_usuario,
                'id_sitio'=>$post['sitio'],
                'name_sitio'=>$name_sitio
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }
    //  INSERT FIANZA

    public function GetFianzaSitio($sitio){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.*, s.id_cliente 
                        FROM fianzas f
                        INNER JOIN sitios s ON s.id = f.id_sitio
                        WHERE f.id_sitio = ? ORDER BY f.id",array($sitio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por Sitio


    public function GetFianzaSitioPaginator($table,$offset,$no_of_records_per_page,$sitio){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.*, s.id_cliente 
                        FROM fianzas f
                        INNER JOIN sitios s ON s.id = f.id_sitio
                        WHERE f.id_sitio = ?  
                        ORDER BY f.id LIMIT $offset,$no_of_records_per_page",array($sitio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por Sitio



    public function updatefianzas($post,$table,$urldb,$nombre_usuario,$id_user,$name_sitio){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET archivo_fianza = ?, user_modificacion = ?, id_user = ?, fecha_vigencia = ?, comentario = ?, name_sitio = ?, id_sitio = ? WHERE id = ? ",
                array(
                    $urldb,
                    $nombre_usuario,
                    $id_user,
                    $post['vigencia'],
                    $post['comentario'],
                    $name_sitio,
                    $post['sitio'],
                    $post['ids']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }// END UPDATE FIANZAS


    public function GetFianzaalls(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.*, s.id_cliente 
                        FROM fianzas f
                        INNER JOIN sitios s ON s.id = f.id_sitio");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por Sitio

    public function getFianzasFechas($inicioa,$finala){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.*, s.id_cliente 
                        FROM fianzas f
                        LEFT JOIN sitios s ON s.id = f.id_sitio
                        WHERE f.fecha_vigencia between '$inicioa' and '$finala'
                        ORDER BY f.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }

} 