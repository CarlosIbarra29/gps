<?php

class Application_Model_GpsNomina2Model extends Zend_Db_Table_Abstract{

    protected $_name = 'personal_nominapack';
    protected $_primary = 'id';
    public function insertnominasolicitudfin($id_user,$solicitud_user,$status_pack,$post,$table,$hoy,$montos){
        try {
            $row = $this->createRow();
            $row->fecha_creacion = $hoy;
            $row->sitio = $post['sitio'];
            $row->id_proyecto = $post['id_proyecto'];
            $row->status = $status_pack;
            $row->id_auditoria = $id_user;
            $row->monto = $montos;
            $row->fecha_auditoria = $hoy;
            $row->user_auditoria = $solicitud_user;
            $row->comentarios_auditoria = $post['comentarios'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }


    public function updatesolnominafin($id,$table,$post,$hoy,$solicitud_user,$id_user,$id_solicitud,$status_sol){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_auditoria2 = ?, iduser_auditoria2 = ?, user_auditoria2 = ?, fecha_auditoria2 = ?, id_packnomina = ? WHERE id = ?",
                array($status_sol,$id_user,$solicitud_user,$hoy,$id_solicitud,$id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE nominal status

    public function updatesolnominafincancel($id,$table,$post,$hoy,$solicitud_user,$id_user,$id_solicitud,$status_sol){
        $statusunosol = 2;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_auditoria2 = ?, iduser_auditoria2 = ?, user_auditoria2 = ?, fecha_auditoria2 = ?, id_packnomina = ?, comentario_auditoria2 = ?, status_auditoria = ? WHERE id = ?",
                array($status_sol,$id_user,$solicitud_user,$hoy,$id_solicitud,$post['comentarios'],$statusunosol,$id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE nominal status

}



 