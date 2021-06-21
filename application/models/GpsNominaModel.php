<?php

class Application_Model_GpsNominaModel extends Zend_Db_Table_Abstract{

    protected $_name = 'personal_nomina';
    protected $_primary = 'id';

    public function insertnominasolicitud($id_user,$name_user,$post,$table){
        try {
            $row = $this->createRow();
            $row->id_personal = $id_user;
            $row->personal = $name_user;
            $row->sitio = $post['sitio'];
            $row->id_proyecto = $post['id_proyecto'];
            $row->monto_nomina = $post['monto'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }
    
    public function updatestatusnominauser($id_solicitud,$id,$table){
        $status= 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_nomina = ?, solicitud_nomina =? WHERE id = ?",array($status,$id_solicitud,$id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

}