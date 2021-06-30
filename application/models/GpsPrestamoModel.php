<?php

class Application_Model_GpsPrestamoModel extends Zend_Db_Table_Abstract{

    public function insertnewprestamo($post,$table,$hoy,$nombre_personal,$nombre_usuario,$fecha_prestamo,$urldb){
    	$status = 0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_personal'=>$post['usuario'],
                'nombre_personal'=>$nombre_personal,
                'fecha_prestamo'=>$fecha_prestamo,
                'monto'=>$post['monto'],
                'cantidad_pagos'=>$post['cantidad'],
                'motivo'=>$post['motivo'],
                'evidencia'=>$urldb,
                'status_prestamo'=>$status,
                'user_prestamo'=>$nombre_usuario,
                'user_fecha'=>$hoy
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertnewprestamonomina($post,$table,$id,$descuento,$hoy){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_personal'=>$post['user'],
                'nombre'=>$post['sitio'],
                'dia'=>$hoy,
                'id_proyecto'=>$post['id_proyecto'],
                'id_proyecto_salida'=>$post['id_proyecto'],
                'monto_pago'=>$descuento,
                'solicitud_prestamo'=>$id

            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER


    public function updatesolicituprestamouno($id,$table,$num_pago){
        $status= 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET cantidad_saldada = ?, status_prestamo = ? WHERE id = ?",array($num_pago,$status,$id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function updatesolicituprestamodos($id,$table,$num_pago){
    	// var_dump($num_pago);exit;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET cantidad_saldada =? WHERE id = ?",array($num_pago,$id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL



    public function getprestamos($op_status){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pp.id, pp.id_personal, pp.nombre_personal, pp.fecha_prestamo, pp.monto, 
            			pp.cantidad_pagos, pp.motivo, pp.evidencia,pp.status_prestamo, pp.cantidad_saldada, 
            			pp.fecha_liquidacion
						FROM personal_prestamos pp where pp.status_prestamo = ?",array($op_status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PRESTAMO

    public function getprestamosolicitud($offset,$no_of_records_per_page,$op_status){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pp.id, pp.id_personal, pp.nombre_personal, pp.fecha_prestamo, pp.monto, 
            			pp.cantidad_pagos, pp.motivo, pp.evidencia,pp.status_prestamo, pp.cantidad_saldada, 
            			pp.fecha_liquidacion
						FROM personal_prestamos pp 
						WHERE pp.status_prestamo = ?
                        ORDER BY pp.id ASC
                        LIMIT $offset,$no_of_records_per_page",array($op_status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PRESTAMO

    public function getpersonalprestamo($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, 
                        pc.puesto,pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc,pc.dia_pago, 
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, 
                        pc.name_sitio,pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto,  
                        pc.status_operativo , pc.status_campo, tp.nombre_proyecto, pc.fechainicio_asignacion,
                        pc.fechafinal_asignacion
                        FROM personal_campo pc 
                        LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        LEFT JOIN tipo_proyecto tp on tp.id = pc.tipo_proyectopersonal 
                        WHERE pc.status_campo = ? ORDER BY pc.nombre ASC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL

}