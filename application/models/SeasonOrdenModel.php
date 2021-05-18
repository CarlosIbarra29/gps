<?php

class Application_Model_SeasonOrdenModel extends Zend_Db_Table_Abstract{

	// --------------------------------INSERTS

    protected $_name = 'orden';
    protected $_primary = 'id';

	public function insertOrden($table,$id,$post){
        try {

            $row = $this->createRow();
            $row->idusuario = $id;
            $row->iddireccion =$post["iddireccion"];
            $row->nombre =$post["name"];
            $row->iscomplete =$post["complete"];
            $row->isrejected =$post["rejected"];
            $row->isactive =$post["active"];
            $res = $row->save();

            setcookie("idorden",$res,strtotime( '+30 days' ), "/");               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }//Insert
	
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

	// --------------------------------CONSULTA

	public function getPedidosByInnerJoin($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM producto_orden po
                                    INNER JOIN orden o on po.fkorden = o.id 
                                    INNER JOIN producto pp on po.fkpro = pp.id
                                WHERE po.fkorden = ?",$id);
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }//end try-catch

    }//end get relacion

    public function getDireccionByUser($id){
    	try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM direcciones WHERE fkusuario = ?",$id);
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }//end try-catch
    }// end get direccion by id user

    public function GetSpecificOrderByInner($id){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM orden o INNER JOIN direcciones d WHERE o.idusuario=d.fkusuario AND o.idusuario=? ORDER BY o.create DESC LIMIT 1",$id);
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    //---------------------------------INSERT

    public function insertPedidosDire($table,$id,$post,$idorden){

           
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'fkdireccion'=>$post['iddireccion'],
                'fkusuario'=>$id,
                'fechadeentrega'=>$post['fecha'],
                'horadeentrega'=>$post['hora'],
                'nombrerecibe'=>$post['recibe'],
                'fkorden'=>$idorden); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }//Insert producto

    public function GetAllIsCompletecompras($id){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT o.id as idorden, o.nombre, o.idusuario, o.iddireccion, u.id as idusuario, u.nombre as name, d.id, d.direccion from orden o 
                inner join usuario u on o.idusuario=u.id
                inner join direcciones d on o.iddireccion=d.id WHERE iscomplete=1 and idusuario=?", array($id));


            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

     public function GetAllIncompletenet($idorden){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT o.id as idorden, o.iscomplete, o.nombre, o.idusuario, o.iddireccion, u.id as idusuario, u.nombre as name, d.id, d.direccion from orden o 
                                             inner join usuario u on o.idusuario=u.id
                                        inner join direcciones d on o.iddireccion=d.id WHERE iscomplete=0",array($idorden));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

     public function GetAllIsComplete($idorden){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT o.id as idorden, o.nombre, o.idusuario, o.iddireccion, u.id as idusuario, u.nombre as name, d.id, d.direccion from orden o 
                inner join usuario u on o.idusuario=u.id
                inner join direcciones d on o.iddireccion=d.id WHERE iscomplete=1", array($idorden));


            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }
    public function datospedidosnet($idus){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT o.id as idorden, o.iscomplete, o.nombre, o.idusuario, o.iddireccion, u.id as idusuario, u.nombre as name, d.id, d.direccion from orden o 
                                                            inner join usuario u on o.idusuario=u.id
                                                            inner join direcciones d on o.iddireccion=d.id and o.idusuario= ?",array($idus));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }
}