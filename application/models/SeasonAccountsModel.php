<?php

class Application_Model_SeasonAccountsModel extends Zend_Db_Table_Abstract{

	// ---------------------- INSERT
	public function InsertAccounts($table,$id,$card,$post){
		try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombrecuenta'=>$post['nomcuenta'],
            	'ncuenta'=>$card,
            	'vencemm'=>$post['expireMM'],
                'venceyy'=>$post['expireYY'],
            	'fkusuario'=>$id); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
	}

	public function InsertDireccion($table,$id,$dir,$post){
		try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
            	'direccion'=>$dir,
                'cp'=>$post['cp'],
            	'fkusuario'=>$id); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
	}
	// ---------------------- DELETE
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

}