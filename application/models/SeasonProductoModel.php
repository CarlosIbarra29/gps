<?php 
class Application_Model_SeasonProductoModel extends Zend_Db_Table_Abstract{

		// --------------------------------INSERTS

		public function insertProduct($post,$table,$urldb){

           
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre'=>$post['name'],
                'imagen'=>$urldb,
                'descripcion'=>$post['desc'],
                'stock'=>$post['stock'],
                'precio'=>$post['precio'],
                'ofer'=>$post['ofert'],
                'timeofer'=>$post['tofer'],
                'inicio'=>$post['beig'],
                'precioofer'=>$post['preciooff'],
                'final'=>$post['end']); 

            $res = $db->insert($table, $datasave);
            $id=0;
            if($res)
            $id=$db->lastInsertId();
            $db->closeConnection();               
            return $id;
        } catch (Exception $e) {
            echo $e;
        }
    }//Insert producto

    public function insertProductReco($id,$wh,$table,$post){
        try {
            $res = 0;
            foreach ($post as $key=>$row) {
                
                if($key!='name' && $key!='desc' && $key!='stock' && $key!='precio' && $key!='ofert'
                    && $key!='tofer' && $key!='beig' && $key!='preciooff' && $key!='end'){
                    $db = Zend_Db_Table::getDefaultAdapter();
                    $datasave = array(
                                   'fkpro'=>$id,
                                   'fkrecomendaciones'=>$row);
                    
                    $res = $db->insert($table, $datasave);
                    $db->closeConnection();
                    //var_dump($res);
                    
                }
            }
                    return $res;       
        } catch (Exception $e) {
            echo $e;
        }
    }//Insert producto recomendacion

    // --------------------------------UPDATES

    public function refreshproduct($post,$table,$urldb){

                   
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre = ? , imagen = ? , descripcion = ? , stock = ? , precio = ? , ofer = ?, timeofer = ?, inicio = ?, final = ? , precioofer = ? WHERE id = ?",array(
                $post['name'],
                $urldb,
                $post['desc'],
                $post['stock'],
                $post['precio'],
                $post['ofert'],
                $post['tofer'],
                $post['beig'],
                $post['end'],
                $post['preciooff'],
                $post['id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//refresh producto

    public function refreshstock($table,$result,$id){        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET stock = ?  WHERE id = ?",array(
                $result,
                $id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//refresh producto

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
    }//delete producto

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

    public function GetStock($table,$id){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT stock FROM $table WHERE id= ?",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }
    
}
 ?>