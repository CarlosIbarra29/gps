<?php

class Application_Model_GpsArchivosModel extends Zend_Db_Table_Abstract{

    public function getbtsstatus($step,$status){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT s.id,s.id_cliente, s.nombre , s.cliente, s.ciudad, s.estado, s.region, 
                        ttp.nombre_proyecto as proyecto, sc.nombre_status as status_cliente, sp.nombre_status as
                        status_proyecto, st.issue, st.porcentaje_proyecto, st.id as id_proyectos
        				FROM sitios s 
        				INNER JOIN sitios_tipoproyecto st on s.id = st.id_sitio
        				INNER JOIN status_cliente sc on sc.id = st.status_cliente
        				INNER JOIN status_proyecto sp on sp.id = st.status_proyecto
        				INNER JOIN tipo_proyecto ttp on ttp.id = st.id_tipoproyecto 
        				WHERE ttp.id = ? and st.status_proyecto = ?",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getcomentarios(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id_sitio, s.nombre, s.id_cliente, c.comentarios  
                        FROM comentarios_sitios c
						INNER JOIN sitios s on s.id = c.id_sitio");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getissue($tipo){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT s.id,s.id_cliente, s.nombre , s.cliente, s.ciudad, s.estado, s.region, 
                        ttp.nombre_proyecto as proyecto, sc.nombre_status as status_cliente, sp.nombre_status as 
                        status_proyecto, st.issue
                        FROM sitios s 
                        INNER JOIN sitios_tipoproyecto st on s.id = st.id_sitio
                        INNER JOIN status_cliente sc on sc.id = st.status_cliente
                        INNER JOIN status_proyecto sp on sp.id = st.status_proyecto
                        INNER JOIN tipo_proyecto ttp on ttp.id = st.id_tipoproyecto 
                        where st.issue = 'ATC' AND ttp.id = ?",array($tipo));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }  

    public function getvehculossolicitudes($year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                        vs.status_solicitud, vs.id_proveedor, vs.referencia, vs.fecha_sol, vs.fecha_pagada, 
                        vs.step_veh, vs.motivos, vs.monto, vs.status_comprobante, vs.status_asignada, 
                        vs.fecha_validacion, p.nombre as nombrer, p.apellido_pa as apr, p.apellido_ma as amr, 
                        sv.nombre_servicio, pr.nombre_prov,vp.fecha_pago, vp.comprobante_pago,vp.monto, vi.marca, 
                        vi.submarca, vi.modelo, vi.placas, u.nombre as name_user, u.ap, u.am,
                        year(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS years,
                        month(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS mes ,
                        day(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS dia
                        FROM vehiculos_solicitudes vs
                        LEFT JOIN personal_campo p ON p.id = vs.id_responsable
                        LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                        LEFT JOIN proveedor pr ON pr.id = vs.id_proveedor
                        LEFT JOIN vehiculos_pagos vp ON vp.id_solicitud = vs.id_vehiculo
                        LEFT JOIN vehiculos vi on vi.id_vehiculos = vs.id_vehiculo
                        LEFT JOIN usuario u on u.id = vs.id_usuario 
                        having mes = ? AND years = ?  order by vs.id ASC",array($month,$year));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }  


}