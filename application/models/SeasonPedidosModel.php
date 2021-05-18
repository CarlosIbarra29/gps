<?php

class Application_Model_SeasonPedidosModel extends Zend_Db_Table_Abstract{

    //---------------------------------INSERT

    public function insertPedidosOrden($key,$table){

           
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'fkorden'=>$key['idorden'],
                'fkpro'=>$key['id'],
                'cantidad'=>$key['cantidad']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }//Insert producto

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

    public function getPedidos($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM pedidosdireccion pd
                                        INNER JOIN orden o on pd.fkorden = o.id 
                                        INNER JOIN direcciones d on pd.fkdireccion = d.id
                                        WHERE pd.fkorden = ?",$id);
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }//end try-catch
    }
    public function getUsuario($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM pedidosdireccion pd
                                        INNER JOIN orden o on pd.fkorden = o.id 
                                        INNER JOIN usuario d on pd.fkusuario = d.id
                                        WHERE pd.fkorden = ?",$id);
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }//end try-catch
    }

    public function refreshOrden($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET iscomplete = ?  WHERE id = ?",array(
                $post['iscomplete'],
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }
    public function getPedidosmasterpanelNet($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT p.id, p.fechadeentrega, p.horadeentrega, p.fkorden,p.fkdireccion, p.nombrerecibe, 
                                                p.fkusuario, d.id , d.direccion from pedidosdireccion p 
                                                INNER JOIN direcciones d on p.fkdireccion=d.id where fkorden= ?",$id);
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }//end try-catch
    }
    public function detallespedidosnet($idus,$idorden){
          try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT p.id as idproducto, p.nombre, p.precio, pro.fkpro, pro.cantidad, p.precio*pro.cantidad as subtotal, pro.fkorden,o.id as ordenid ,    o.idusuario from producto p
                                                        INNER JOIN producto_orden pro on p.id=pro.fkpro
                                                        INNER JOIN orden o on o.id=pro.fkorden 
                                                        where idusuario=? and fkorden= ?",array($idus,$idorden));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }
}