<?php

class Application_Model_GpsPedidosEppModel extends Zend_Db_Table_Abstract{
    protected $_name = 'epp_stock';
    protected $_primary = 'id';

    public function insertpedidoepp1($post,$table,$id_user,$name_user,$name_proveedor,$urldb){
        
        try {
            $row = $this->createRow();
            $row->id_usuario = $id_user;
            $row->name_usuario = $name_user;
            $row->id_proveedor = $post['proveedor'];
            $row->name_proveedor = $name_proveedor;
            $row->comentarios = $post['comentarios'];
            $row->fecha_recibido = $post['fecharecibido'];
            $row->comprobante_doc = $urldb;
            $res = $row->save();              
            return $res;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   // END INSERT PASO 1 SOLICITUD EPP
} 


