<?php

class Application_Model_GpsColocacionModel extends Zend_Db_Table_Abstract{
    protected $_name = 'semanauno_colocacion';
    protected $_primary = 'id';
    public function insertfotopreliminarcolocacion($post,$table){
        try {
            $row = $this->createRow();
            $row->idsitio_tipo = $post['sitio'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO

}