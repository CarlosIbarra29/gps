<?php

class Application_Model_GpsCajachicaModel extends Zend_Db_Table_Abstract{
    protected $_name = 'comprobacion_solicitud';
    protected $_primary = 'id';


    public function insertsolicitudcajachicanew($post){
        $monto = $post['new_monto'] + $post['saldo_anterior'];
        try {
            $row = $this->createRow();
            $row->id_residente = $post['residente'];
            $row->nombre_residente = $post['residente_name'];
            $row->monto = $post['new_monto'];
            $row->monto_anterior = $monto;
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO

    public function updatecajachicasolicitud($post,$table,$name_sitio,$name_user,$hoy,$monto_new){
        $resta = 0;
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_sitio = ?, nombre_sitio = ?, fecha_solicitud = ?, user_solicitud = ?, monto_anterior = ?, status_resta = ? WHERE id = ?",array(
                $post['sitio'],
                $name_sitio,
                $hoy,
                $name_user,
                $monto_new,
                $resta,
                $post['id_solicitud']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER


}