<?php

class Application_Model_GpsServicioOrdenModel extends Zend_Db_Table_Abstract{
    protected $_name = 'solicitud_ordencompra';
    protected $_primary = 'id';

    public function insertsolicitudordencompra($post,$table){
        try {
            $row = $this->createRow();
            $row->sitio_id = $post['sitio'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT SOLICITUD ORDEN COMPRA

    public function insertdocumentocontizacion($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_solicitud'=>$post['id_solicitud'],
                'titulo_cotizacion'=>$post['titulo_cotizacion'],
                'documento_cotizacion'=>$urldb);
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT DOCUMENTO COTIZACION

    public function insertdocumentocomparativa($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_solicitud'=>$post['id_solicitud'],
                'titulo_comparativa'=>$post['titulo_comparativa'],
                'documento_comparativa'=>$urldb);
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT DOCUMENTO COTIZACION


    public function refreshsolicitudordencompra($table,$result,$post,$id_user){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET proveedor_id = ?,id_usuario = ? , fecha_requerida = ?, servicio_id = ?, importe = ?, iva = ?, retencion_isr = ?,  retencion_iva = ?, total = ?, condiciones_compra = ?, referencia = ?, descripcion = ? WHERE id = ?",array(
                $post['proveedor'],
                $id_user,
                $post['fecha'],
                $post['servicio'],
                $post['importe'],
                $post['iva'],
                $post['isr'],
                $post['ret_iva'],
                $post['total'],
                $post['compra'],
                $post['referencia'],
                $post['descripcion'],
                $result));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD ORDEN COMPRA


    public function getcotizacionycomparativa($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sc.id_solicitud, sc.titulo_cotizacion, sc.documento_cotizacion,com.id_solicitud,
                                com.titulo_comparativa, com.documento_comparativa 
                                FROM cotizacion_solicitudordencompra sc 
                                INNER JOIN  comparativa_solicitudordencompra com on sc.id_solicitud = com.id_solicitud where sc.id_solicitud = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


}