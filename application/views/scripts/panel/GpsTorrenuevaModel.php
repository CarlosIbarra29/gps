<?php

class Application_Model_GpsTorrenuevaModel extends Zend_Db_Table_Abstract{
    protected $_name = 'torre_nuevafile';
    protected $_primary = 'id';
    public function inserttorrenuevafile($post,$table){
        try {
            $row = $this->createRow();
            $row->id_sitio = $post['id_sitio'];
            $row->proyecto = $post['proyecto'];
            $row->sitio = $post['sitio'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO


    public function getexist($id,$proyecto,$sitio){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT  tn.id, tn.id_sitio, tn.proyecto, tn.sitio, tn.torre_file, tn.torre_status, 
                                tn.user_torre, tn.fecha_torre,tn.simentacion_file, tn.simentacion_status, 
                                tn.fecha_simentacion, tn.user_simentacion,tn.calculo_file,tn.calculo_status, 
                                tn.fecha_calculo, tn.user_calculo, tn.staad_status, tn.staad_file, tn.fecha_saad,
                                tn.user_staad,tn.mecanica_status, tn.mecanica_file, tn.fecha_mecanica, tn.user_mecanica
                                FROM torre_nuevafile tn where tn.id_sitio = ? and tn.proyecto =? and tn.sitio = ?",array($id,$proyecto,$sitio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } 

    public function refreshtorre($post,$table,$id_torrenueva,$urldb){
        $torre_status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET torre_file = ?, torre_status = ? WHERE id = ?",array(
                $urldb,
                $torre_status,
                $id_torrenueva));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function refreshsimentacion($post,$table,$id_torrenueva,$urldb){
        $torre_status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET simentacion_file = ?, simentacion_status = ? WHERE id = ?",array(
                $urldb,
                $torre_status,
                $id_torrenueva));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function refreshmemoria($post,$table,$id_torrenueva,$urldb){
        $torre_status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET calculo_file = ?, calculo_status = ? WHERE id = ?",array(
                $urldb,
                $torre_status,
                $id_torrenueva));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function refresstaad($post,$table,$id_torrenueva,$urldb){
        $torre_status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET staad_file = ?, staad_status = ? WHERE id = ?",array(
                $urldb,
                $torre_status,
                $id_torrenueva));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function refresmecanica($post,$table,$id_torrenueva,$urldb){
        $torre_status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET mecanica_file = ?, mecanica_status = ? WHERE id = ?",array(
                $urldb,
                $torre_status,
                $id_torrenueva));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function refreshfiletorrenueva($post,$table,$id_torrenueva,$urldb,$nombre_file,$torre_status, $fecha_user, $user_file, $hoy, $user){
        $status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET $nombre_file=?, $torre_status=?, $fecha_user=?, $user_file=? WHERE id = ?",array(
                $urldb,
                $status,
                $hoy,
                $user,
                $id_torrenueva));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }

}