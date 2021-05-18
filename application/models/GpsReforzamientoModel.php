<?php

class Application_Model_GpsReforzamientoModel extends Zend_Db_Table_Abstract{


    public function inserdocreforzamiento($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitiotipo'=>$post['id_sitiotipo']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END DOC REFORZAMIENTO

    public function refresdocunoreforzamiento($id,$table,$option,$fecha,$user,$status,$post,$urldb,$hoy,$name_user){
    	$step =1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET $option = ?, $fecha = ?, $user = ?, $status= ? WHERE id = ?",array(
                $urldb,
                $hoy,
                $name_user,
                $step,
                $id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE DOC REFORZAMIENTO

}