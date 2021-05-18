<?php 
class Application_Model_SeasonRecomendacionModel extends Zend_Db_Table_Abstract{

	// --------------------------------INSERTS

	public function insertRecomendacion($post,$table,$urldb){
		try{
			$db = Zend_Db_Table::getDefaultAdapter();
			$datasave = array(
						'nombre'=>$post['name'],
						'descripcion'=>$post['desc'],
						'imagen'=>$urldb);
					$res = $db->insert($table,$datasave);
					$db->closeConnection();
					//var_dump($res);exit;
                    return $res;
		}catch (Exception $e){
			echo $e;
		}
	}//Insert recomendacion

	// --------------------------------UPDATES

    public function refreshRecomen($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre = ? , descripcion = ? , imagen = ? 
                WHERE id = ?",array(
                $post['name'],
                $post['desc'],
                $urldb,
                $post['id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//Update recomendacion

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
    }//delete recomendacion

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
	}// Get all

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
    }//Get Especific

    public function getRelationByInnerJoin($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * 
                                FROM productorecomendacion r
                                    INNER JOIN producto pp on r.fkpro = pp.id 
                                WHERE r.fkrecomendaciones = ?",$id);
            $row = $qry->fetchAll();
            //print_r($row);
            return $row;
            //$db->closeConnection();
            
        }catch (Exception $e){
            echo $e;
        }//end try-catch

    }//end get relacion
}
?>
