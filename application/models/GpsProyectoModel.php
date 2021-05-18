<?php

class Application_Model_GpsProyectoModel extends Zend_Db_Table_Abstract{
    protected $_name = 'semanauno_bts';
    protected $_primary = 'id';

    public function insertfotopreliminar($post,$table){
        try {
            $row = $this->createRow();
            $row->idsitio_tipo = $post['sitio'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO

    public function insertstatusproyecto($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_status'=>$post['name'],
                'tipo_proyecto'=>$post['id_proyecto'],
                'prioridad'=>$post['prioridad']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertstatuscliente($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_status'=>$post['name'],
                'tipo_proyecto'=>$post['id_proyecto'],
                'prioridad'=>$post['prioridad']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertdetallebts($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitiotipo'=>$post
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// Add insert detalles uno


    public function insertdetallecolocacion($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitiotipo'=>$post['sitio']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// Add insert detalles uno


    public function updatedetallebts($date_bts,$dato_update,$table,$post){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET $date_bts = ? WHERE id_sitiotipo = ?",array(
                $dato_update,
                $post['sitio']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER


    public function updatestatusproyecto($table,$post){
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre_status = ?, prioridad = ? WHERE id = ?",array(
                $post['status'],
                $post['prioridad'],
                $post['id_proyecto']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function insertdetalledosbts($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitiotipo'=>$post['id'],
                'reportesitio_baseline'=>$post['reportesitio_baseline'],
                'reportesitio_forecast'=>$post['reportesitio_forecast'],
                'reportesitio_actual'=>$post['reportesitio_actual'],
                'entrega_sitio'=>$post['entrega_sitio'],
                'odk_operador'=>$post['odk_operador'],
                'punchlist_operador'=>$post['punchlist_operador'],
                'corecciondetalles_baseline'=>$post['corecciondetalles_baseline'],
                'correcciondetalles_forecast'=>$post['correcciondetalles_forecast'],
                'correcciondetalles_actual'=>$post['correcciondetalles_actual'],
                'protocolo_operador'=>$post['protocolo_operador'],
                'pruebacompactacion_baseline'=>$post['pruebacompactacion_baseline'],
                'pruebacompactacion_forecast'=>$post['pruebacompactacion_forecast'],
                'pruebacompactacion_actual'=>$post['pruebacompactacion_actual'],
                'pruebasiete_baseline'=>$post['pruebasiete_baseline'],
                'pruebasiete_forecast'=>$post['pruebasiete_forecast'],
                'pruebasiete_actual'=>$post['pruebasiete_actual'],
                'pruebacatorce_baseline'=>$post['pruebacatorce_baseline'],
                'pruebacatorce_forecast'=>$post['pruebacatorce_forecast'],
                'pruebacatorce_actual'=>$post['pruebacatorce_actual'],
                'pruebaventiuno_baseline'=>$post['pruebaventiuno_baseline'],
                'pruebaventiuno_forecast'=>$post['pruebaventiuno_forecast'],
                'pruebaventiuno_actual'=>$post['pruebaventiuno_actual'],
                'pruebaventiocho_baseline'=>$post['pruebaventiocho_baseline'],
                'pruebaventiocho_forecast'=>$post['pruebaventiocho_forecast'],
                'pruebaventiocho_actual'=>$post['pruebaventiocho_actual'],
                'resistividad_baseline'=>$post['resistividad_baseline'],
                'resistividad_forecast'=>$post['resistividad_forecast'],
                'resistividad_actual'=>$post['resistividad_actual'],
                'voltaje_baseline'=>$post['voltaje_baseline'],
                'voltaje_forecast'=>$post['voltaje_forecast'],
                'voltaje_actual'=>$post['voltaje_actual'],
                'adeudo_baseline'=>$post['carta_adeudo'],
                'asbuilt_baseline'=>$post['asbuilt_baseline'],
                'asbuilt_forecast'=>$post['asbuilt_forecast'],
                'asbuilt_actual'=>$post['asbuilt_actual'],
                'carta_liberacion'=>$post['carta_liberacion'],
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// ADD insert detalles dos


    public function refreshsitioproyecto($post,$table, $coordinador_name, $ingproyecto_name, $residente_name, $coordinador_id, $ingeniero_id, $residente_id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET operador = ?, id_operador= ?,  residente = ?, nombre_residente = ?, pm_cliente = ?, coordinador_id = ?, nombre_coordinador = ? , ingproyecto_id = ?, nombre_ingproyecto = ?, fecha_inicio = ?, fecha_cliente = ? WHERE id = ?",array(
                $post['operador'],
                $post['id_operador'],
                $residente_id,
                $residente_name,
                $post['pm_cliente'],
                $coordinador_id,
                $coordinador_name,
                $ingeniero_id,
                $ingproyecto_name,
                $post['fecha'],
                $post['fecha_cliente'],
                $post["sitio"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen){
        $preliminares= 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET $status = ?, $imagen = ?  WHERE id = ?",array(
                $preliminares,
                $urldb,
                $result1));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END AGREGAR FOTOS SEMANA UNO BTS


    public function refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen){
        $preliminares= 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET $status = ?, $imagen = ?  WHERE id = ?",array(
                $preliminares,
                $urldb,
                $result1));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END AGREGAR FOTOS SEMANA DOS BTS


    public function refreshpruebasdeconcreto($sitio, $table, $siete_dias, $catorce_dias, $ventiun_dias, $ventiocho_dias){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET pruebasiete_baseline = ?, pruebacatorce_baseline = ?, pruebaventiuno_baseline = ?, pruebaventiocho_baseline = ?  WHERE id_sitiotipo = ?",array(
                $siete_dias,
                $catorce_dias,
                $ventiun_dias,
                $ventiocho_dias,
                $sitio));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END AGREGAR FECHAS A LAS PRUEBAS DE CONCRETO


    public function refreshpruebasdecompactacion($sitio, $table, $pruebacompactacion){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET pruebacompactacion_baseline = ?  WHERE id_sitiotipo = ?",array(
                $pruebacompactacion,
                $sitio));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END AGREGAR FECHAS A LAS PRUEBAS DE CONCRETO

    public function refreshreportesitio($sitio, $table, $pruebacompactacion){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET reportesitio_baseline = ?  WHERE id_sitiotipo = ?",array(
                $pruebacompactacion,
                $sitio));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END AGREGAR FECHAS A LAS PRUEBAS DE CONCRETO

}