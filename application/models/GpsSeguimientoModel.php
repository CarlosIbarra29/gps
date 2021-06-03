<?php

class Application_Model_GpsSeguimientoModel extends Zend_Db_Table_Abstract{

    public function getproyectosseguimiento(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT st.id, st.id_tipoproyecto, tp.nombre_proyecto, st.id_sitio,s.nombre, 
            			s.id_cliente, sp.nombre_status as status_gps, sc.nombre_status as status_cliente, 
						st.operador, st.nombre_residente, st.pm_cliente, st.nombre_coordinador,st.nombre_ingproyecto,
						st.fecha_inicio, st.issue, st.porcentaje_proyecto, st.fecha_cliente
						FROM sitios_tipoproyecto st
						INNER JOIN sitios s on s.id = st.id
						INNER JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
						INNER JOIN status_proyecto sp on sp.id = st.status_proyecto
						INNER JOIN status_cliente sc on sc.id = st.status_cliente");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function paginatorseguimiento($offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT st.id, st.id_tipoproyecto, tp.nombre_proyecto, st.id_sitio, s.nombre as
            		 	name_sitio, s.id_cliente, sp.nombre_status as status_gps, sc.nombre_status as status_cliente, 
						st.operador, st.nombre_residente, st.pm_cliente, st.nombre_coordinador,st.nombre_ingproyecto,
						st.fecha_inicio, st.issue, st.porcentaje_proyecto, st.fecha_cliente
						FROM sitios_tipoproyecto st
						INNER JOIN sitios s on s.id = st.id
						INNER JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
						INNER JOIN status_proyecto sp on sp.id = st.status_proyecto
						INNER JOIN status_cliente sc on sc.id = st.status_cliente order by s.nombre ASC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getproyectosseguimientosearch($option, $id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT st.id, st.id_tipoproyecto, tp.nombre_proyecto, st.id_sitio,s.nombre, 
            			s.id_cliente, sp.nombre_status as status_gps, sc.nombre_status as status_cliente, 
						st.operador, st.nombre_residente, st.pm_cliente, st.nombre_coordinador,st.nombre_ingproyecto,
						st.fecha_inicio, st.issue, st.porcentaje_proyecto, st.fecha_cliente,st.status_cliente, 
						st.status_proyecto as id_proyecto
						FROM sitios_tipoproyecto st
						INNER JOIN sitios s on s.id = st.id
						INNER JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
						INNER JOIN status_proyecto sp on sp.id = st.status_proyecto
						INNER JOIN status_cliente sc on sc.id = st.status_cliente
						WHERE $option = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function paginatorseguimientosearch($offset,$no_of_records_per_page,$option,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT st.id, st.id_tipoproyecto, tp.nombre_proyecto, st.id_sitio, s.nombre as
            		 	name_sitio, s.id_cliente, sp.nombre_status as status_gps, sc.nombre_status as status_cliente, 
						st.operador, st.nombre_residente, st.pm_cliente, st.nombre_coordinador,st.nombre_ingproyecto,
						st.fecha_inicio, st.issue, st.porcentaje_proyecto, st.fecha_cliente
						FROM sitios_tipoproyecto st
						INNER JOIN sitios s on s.id = st.id
						INNER JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
						INNER JOIN status_proyecto sp on sp.id = st.status_proyecto
						INNER JOIN status_cliente sc on sc.id = st.status_cliente 
						WHERE $option = ? order by s.nombre ASC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getproyectosseguimientosearchsitio($sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT st.id, st.id_tipoproyecto, tp.nombre_proyecto, st.id_sitio,s.nombre, 
            			s.id_cliente, sp.nombre_status as status_gps, sc.nombre_status as status_cliente, 
						st.operador, st.nombre_residente, st.pm_cliente, st.nombre_coordinador,st.nombre_ingproyecto,
						st.fecha_inicio, st.issue, st.porcentaje_proyecto, st.fecha_cliente
						FROM sitios_tipoproyecto st
						INNER JOIN sitios s on s.id = st.id
						INNER JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
						INNER JOIN status_proyecto sp on sp.id = st.status_proyecto
						INNER JOIN status_cliente sc on sc.id = st.status_cliente
						WHERE s.nombre like '%{$sitio}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function paginatorseguimientosearchsitio($offset,$no_of_records_per_page,$sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT st.id, st.id_tipoproyecto, tp.nombre_proyecto, st.id_sitio, s.nombre as
            		 	name_sitio, s.id_cliente, sp.nombre_status as status_gps, sc.nombre_status as status_cliente, 
						st.operador, st.nombre_residente, st.pm_cliente, st.nombre_coordinador,st.nombre_ingproyecto,
						st.fecha_inicio, st.issue, st.porcentaje_proyecto, st.fecha_cliente
						FROM sitios_tipoproyecto st
						INNER JOIN sitios s on s.id = st.id
						INNER JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
						INNER JOIN status_proyecto sp on sp.id = st.status_proyecto
						INNER JOIN status_cliente sc on sc.id = st.status_cliente 
						WHERE s.nombre like '%{$sitio}%' order by s.nombre ASC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


}