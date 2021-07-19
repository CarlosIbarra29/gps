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
            $qry = $db->query("SELECT si.id_cliente,si.nombre,c.comentarios,c.id_sitio as id_proyecto, s.id_sitio
                        FROM comentarios_sitios c
                        INNER JOIN sitios_tipoproyecto s on s.id = c.id_sitio
                        INNER JOIN sitios si on si.id = s.id_sitio");
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
                        LEFT JOIN vehiculos_pagos vp ON vp.id_solicitud = vs.id
                        LEFT JOIN vehiculos vi on vi.id_vehiculos = vs.id_vehiculo
                        LEFT JOIN usuario u on u.id = vs.id_usuario 
                        having mes = ? AND years = ? and status_comprobante = 1 order by vs.id ASC",array($month,$year));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }  

    public function getnomiasolicitudes($year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pa.id, pa.id_personal, pa.nombre, pa.hora_entrada, pa.hora_salida, pa.dia, 
                        pa.day_num, pa.hora_extra, pa.id_solicitudhora, pa.id_proyecto, pa.id_proyecto_salida, 
                        pa.ev_entrada,pa.ev_salida, pa.status_asistencia, pa.motivo_inasistencia,pa.status_nomina, 
                        pa.solicitud_nomina, pc.hora_pago, pc.dia_pago, pa.status_extra, pa.monto_pago, pn.personal,
                        pa.solicitud_prestamo, pa.status_tipos, pa.id_proyecto, pn.status_pago, pn.fecha_pago,
                        year(date(CONCAT(SUBSTRING(pn.fecha_pago, 7, 4),  '-', SUBSTRING(pn.fecha_pago, 4, 2), '-', SUBSTRING(pn.fecha_pago, 1, 2)))) AS years,
                        month(date(CONCAT(SUBSTRING(pa.dia, 7, 4),  '-', SUBSTRING(pa.dia, 4, 2), '-', SUBSTRING(pa.dia, 1, 2)))) AS mes ,
                        day(date(CONCAT(SUBSTRING(pa.dia, 7, 4),  '-', SUBSTRING(pa.dia, 4, 2), '-', SUBSTRING(pa.dia, 1, 2)))) AS dia_count
                        FROM personal_asistencia pa
                        LEFT JOIN personal_campo pc on pc.id=pa.id_personal 
                        LEFT JOIN personal_nomina pn on pn.id = pa.solicitud_nomina
                        having mes = ? AND years = ? 
                        AND pa.solicitud_nomina = 9 AND pn.status_pago = 1",array($month,$year));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } 


    public function getnomiasolicitudesproyecto($year,$month,$sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pa.id, pa.id_personal, pa.nombre, pa.hora_entrada, pa.hora_salida, pa.dia, 
                        pa.day_num, pa.hora_extra, pa.id_solicitudhora, pa.id_proyecto, pa.id_proyecto_salida, 
                        pa.ev_entrada,pa.ev_salida, pa.status_asistencia, pa.motivo_inasistencia,pa.status_nomina, 
                        pa.solicitud_nomina, pc.hora_pago, pc.dia_pago, pa.status_extra, pa.monto_pago, pn.personal,
                        pa.solicitud_prestamo, pa.status_tipos, pa.id_proyecto, pn.status_pago, pn.fecha_pago,
                        year(date(CONCAT(SUBSTRING(pn.fecha_pago, 7, 4),  '-', SUBSTRING(pn.fecha_pago, 4, 2), '-', SUBSTRING(pn.fecha_pago, 1, 2)))) AS years,
                        month(date(CONCAT(SUBSTRING(pa.dia, 7, 4),  '-', SUBSTRING(pa.dia, 4, 2), '-', SUBSTRING(pa.dia, 1, 2)))) AS mes ,
                        day(date(CONCAT(SUBSTRING(pa.dia, 7, 4),  '-', SUBSTRING(pa.dia, 4, 2), '-', SUBSTRING(pa.dia, 1, 2)))) AS dia_count
                        FROM personal_asistencia pa
                        LEFT JOIN personal_campo pc on pc.id=pa.id_personal 
                        LEFT JOIN personal_nomina pn on pn.id = pa.solicitud_nomina
                        having mes = ? AND years = ? 
                        AND pa.solicitud_nomina = 9 AND pn.status_pago = 1 
                        AND pa.id_proyecto = ? AND pa.status_tipos = 0",array($month,$year,$sitio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function gettagconsumosm($year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT t.id, t.concesionaria, t.fecha, t.tag, t.entrada, t.salida, t.importe,
                t.id_sitio, t.id_proyecto, s.id_cliente, s.nombre, s.cliente,
                st.id_tipoproyecto, st.status_proyecto, st.status_cliente, st.operador, tp.nombre_proyecto,
                YEAR(DATE(CONCAT(SUBSTRING(t.fecha, 7, 4),
                    '-',
                    SUBSTRING(t.fecha, 4, 2),
                    '-',
                    SUBSTRING(t.fecha, 1, 2)))) AS AÑO,
                MONTH(DATE(CONCAT(SUBSTRING(t.fecha, 7, 4),
                    '-',
                    SUBSTRING(t.fecha, 4, 2),
                    '-',
                    SUBSTRING(t.fecha, 1, 2)))) AS MES,
                DAY(DATE(CONCAT(SUBSTRING(t.fecha, 7, 4),
                    '-',
                    SUBSTRING(t.fecha, 4, 2),
                    '-',
                    SUBSTRING(t.fecha, 1, 2)))) AS DIA
                FROM tag t
                LEFT JOIN sitios s ON s.id = t.id_sitio
                LEFT JOIN sitios_tipoproyecto st ON st.id = t.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                HAVING MES = ? And AÑO = ? ORDER BY t.fecha",array($month,$year));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } 


    public function gettagconsumosproyecto($year,$month,$sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT t.id, t.concesionaria, t.fecha, t.tag, t.entrada, t.salida, t.importe,
                t.id_sitio, t.id_proyecto, s.id_cliente, s.nombre, s.cliente,
                st.id_tipoproyecto, st.status_proyecto, st.status_cliente, st.operador, tp.nombre_proyecto,
                YEAR(DATE(CONCAT(SUBSTRING(t.fecha, 7, 4),
                    '-',
                    SUBSTRING(t.fecha, 4, 2),
                    '-',
                    SUBSTRING(t.fecha, 1, 2)))) AS AÑO,
                MONTH(DATE(CONCAT(SUBSTRING(t.fecha, 7, 4),
                    '-',
                    SUBSTRING(t.fecha, 4, 2),
                    '-',
                    SUBSTRING(t.fecha, 1, 2)))) AS MES,
                DAY(DATE(CONCAT(SUBSTRING(t.fecha, 7, 4),
                    '-',
                    SUBSTRING(t.fecha, 4, 2),
                    '-',
                    SUBSTRING(t.fecha, 1, 2)))) AS DIA
                FROM tag t
                LEFT JOIN sitios s ON s.id = t.id_sitio
                LEFT JOIN sitios_tipoproyecto st ON st.id = t.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                HAVING MES = ? And AÑO = ? AND t.id_proyecto = ? ORDER BY t.fecha",array($month,$year,$sitio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } 

}