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

    public function getsolicitudnomina($status,$pago){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
             			pn.solicitud_fecha,pn.solicitud_user,pn.status_auditoria,pn.user_auditoria, 
             			pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago
						FROM personal_nomina pn 
						where pn.status_auditoria = ? and status_pago = ?",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA

    public function getnominasolicitud($offset,$no_of_records_per_page,$status,$pago){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
             			pn.solicitud_fecha,pn.solicitud_user, pn.status_auditoria, pn.user_auditoria, 
             			pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago
						FROM personal_nomina pn
						 where pn.status_auditoria = ? and status_pago = ?
                        ORDER BY pn.sitio ASC
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL

}