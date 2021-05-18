<?php

class Application_Model_SeasonSliderModel extends Zend_Db_Table_Abstract{
	public function insertSlider($table,$id,$urldb,$post){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre'=>$post['name'],
                'imagen'=>$urldb,
            	'fkpro'=>$id); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }//Insert

    // --------------------------------UPDATE

    public function refreshSlider($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre = ? , imagen = ? , fkpro = ? WHERE id = ? ",
                array(
                $post['name'],
                $urldb,
                $post['prod'],
                $post['id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }

    // --------------------------------DELETS

	public function deleteAll($id,$table,$wh){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $var =  $db->query ("DELETE from $table where $wh = ? ",array($id));
            $db->closeConnection();
            return $var;
        } catch (Exception $e) {
            echo $e;
        }
    }//deleteUsr

    // --------------------------------GET

	public function GetAll($table){
		 try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table");
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
	}

    public function GetSpecific($table,$wh,$id){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table WHERE $wh = ?",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

}