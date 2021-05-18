<?php

class Application_Model_GpsPanelModel extends Zend_Db_Table_Abstract{
    protected $_name = 'semanatres_bts';
    protected $_primary = 'id';

    public function insertfotopreliminarsemanatres($post,$table){
        try {
            $row = $this->createRow();
            $row->idsitio_tipo = $post['sitio'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO

    public function getproyecto($nombre){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM tipo_proyecto WHERE nombre_proyecto like '%{$nombre}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } 


    public function gettipoproyectoorder($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM status_proyecto WHERE tipo_proyecto =? order by prioridad asc",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function gettipoclienteorder($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM status_cliente WHERE tipo_proyecto =? order by prioridad asc",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } 

    public function getpersonalasc(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM personal_campo  where status_personal = 0 order by nombre asc");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getproyectopaginator($nombre,$offset,$no_of_records_per_page){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM tipo_proyecto WHERE nombre_proyecto like '%{$nombre}%' LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getproveedor($nombre){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM proveedor WHERE nombre_prov like '%{$nombre}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getprovedorpaginator($nombre,$offset,$no_of_records_per_page){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM proveedor WHERE nombre_prov like '%{$nombre}%' LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getordernombreproveedor(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM proveedor ORDER BY nombre_prov ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsitiospaginator($wh,$option,$offset,$no_of_records_per_page){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM sitios WHERE $wh like '%{$option}%' order by nombre asc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsitio($wh,$nombre){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM sitios WHERE $wh like '%{$nombre}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }
}