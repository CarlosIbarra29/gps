<?php

class Application_Model_GpsServicioModel extends Zend_Db_Table_Abstract{
    protected $_name = 'sitios_tipoproyecto';
    protected $_primary = 'id';

    public function insertproyectoSitio($post,$table){
        try {
            $row = $this->createRow();
            $row->id_tipoproyecto = $post['tipo_proyecto'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT U

    public function refreshinsertsitioupdate($post,$table,$name_pro,$name_cli,$coordinador_name, $ingproyecto_name, $residente_name, $coordinador_id, $ingeniero_id, $residente_id,$result){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_sitio = ?, status_proyecto = ?, status_cliente=?, id_operador =?, operador =?, pm_cliente=?, fecha_inicio= ?, residente=?, nombre_residente=?, coordinador_id =?, nombre_coordinador=?, nombre_ingproyecto=?, ingproyecto_id =?, fecha_cliente = ?  WHERE id = ?",array(
                $post['sitio'],
                $name_pro,
                $name_cli,
                $post['id_operador'],
                $post['operador'],
                $post['pm_cliente'],
                $post['fecha_inicio'],
                $residente_id,
                $residente_name,
                $coordinador_id,
                $coordinador_name,
                $ingproyecto_name,
                $ingeniero_id,
                $post['fecha_cliente'],
                $result));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END EDITAR SERVICIOS

    public function insertservicio($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_servicio'=>$post['servicio'],
                'encargado_rol'=>$post['encargado']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT SERVICIO


    public function refreshserviciocatalogo($post, $table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre_servicio = ?, encargado_rol = ?  WHERE id = ?",array(
                $post['servicio'],
                $post['encargado'],
                $post['id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END EDITAR SERVICIOS

    public function Getordernombreservicio(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM servicios ORDER BY nombre_servicio ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // END GET SERVICIOS ORDER BY NOMBRE

      public function Getpaginationservicio($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT s.id, s.nombre_servicio, s.encargado_rol, s.status_Delete, r.id as rol_id, r.nombre
                                FROM servicios s
                                INNER JOIN roles r on s.encargado_rol=r.id LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR

}