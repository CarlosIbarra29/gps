<?php

class Application_Model_GpsPeticionesModel extends Zend_Db_Table_Abstract{

    public function insertnewpeticion($post,$table,$urldb,$hoy,$id_user){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'modulo'=>$post['modulo'],
                'descripcion'=>$post['descripcion'],
                'user_peticion'=>$id_user,
                'fecha_peticion'=>$hoy,
                'evidencia'=>$urldb
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT PETICION

    public function getpeticionesadmin($status){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ap.id, ap.modulo, ap.descripcion, ap.fecha_peticion, ap.status_peticion, 
            			u.nombre, u.ap, u.am
						FROM add_peticiones ap
						LEFT JOIN usuario u on u.id = ap.user_peticion 
						where ap.status_peticion = ? 
                		ORDER BY ap.id ASC",array($status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // END CONSULTA PETICIONES 


    public function getpeticiones($status,$user){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ap.id, ap.modulo, ap.descripcion, ap.fecha_peticion, ap.status_peticion, 
            			u.nombre, u.ap, u.am
						FROM add_peticiones ap
						LEFT JOIN usuario u on u.id = ap.user_peticion 
						where ap.status_peticion = ? and ap.user_peticion = ?
                		ORDER BY ap.id ASC",array($status,$user));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // END CONSULTA PETICIONES 

    public function getpeticioneslimit($status,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ap.id, ap.modulo, ap.descripcion, ap.fecha_peticion, ap.status_peticion, 
            			u.nombre, u.ap, u.am
						FROM add_peticiones ap
						LEFT JOIN usuario u on u.id = ap.user_peticion where ap.status_peticion = ?
                		ORDER BY ap.id DESC LIMIT $offset,$no_of_records_per_page",array($status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }// Consulta Buscador Personal Cobro

    public function getpeticioneslimituser($status,$user,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ap.id, ap.modulo, ap.descripcion, ap.fecha_peticion, ap.status_peticion, 
            			u.nombre, u.ap, u.am
						FROM add_peticiones ap
						LEFT JOIN usuario u on u.id = ap.user_peticion 
						where ap.status_peticion = ? AND ap.user_peticion = ?
                		ORDER BY ap.id DESC LIMIT $offset,$no_of_records_per_page",array($status,$user));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }// Consulta Buscador Personal Cobro

}