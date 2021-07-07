<?php

class Application_Model_GpsNominaModel extends Zend_Db_Table_Abstract{

    protected $_name = 'personal_nomina';
    protected $_primary = 'id';

    public function insertnominasolicitud($id_user,$name_user,$post,$table){
        try {
            $row = $this->createRow();
            $row->id_personal = $id_user;
            $row->personal = $name_user;
            $row->sitio = $post['sitio'];
            $row->id_proyecto = $post['id_proyecto'];
            $row->monto_nomina = $post['monto'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function insertnominaextra($table,$post,$day_num,$urldb_entrada,$url_salida,$fecha_fianl){
    	$status=1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_personal'=>$post['user'],
                'nombre'=>$post['sitio'],
                'hora_entrada'=>$post['hora_entrada'],
                'hora_salida'=>$post['hora_salida'],
                'dia'=>$fecha_fianl,
                'day_num'=>$day_num,
                'id_proyecto'=>$post['proyecto_entrada'],
                'id_proyecto_salida'=>$post['proyecto_salida'],
                'ev_entrada'=>$urldb_entrada,
                'ev_salida'=>$url_salida,
                'status_extra'=>$status
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER


    public function updatestatusnominauser($id_solicitud,$id,$table,$monto){
        $status= 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET monto_pago =?, status_nomina = ?, solicitud_nomina =? WHERE id = ?",array($monto,$status,$id_solicitud,$id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function getsolicitudnomina($status,$pago){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
             			pn.solicitud_fecha,pn.solicitud_user,pn.status_auditoria,pn.user_auditoria, 
             			pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago
						FROM personal_nomina pn 
						where pn.status_auditoria = ? and status_pago = ?",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA

    public function getnominasolicitud($offset,$no_of_records_per_page,$status,$pago){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
             			pn.solicitud_fecha,pn.solicitud_user, pn.status_auditoria, pn.user_auditoria, 
             			pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago
						FROM personal_nomina pn
						 where pn.status_auditoria = ? and status_pago = ?
                        ORDER BY pn.sitio ASC
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL

    public function getdetailnomina($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pa.id, pa.id_personal, pa.nombre, pa.hora_entrada, pa.hora_salida, pa.dia, 
            			pa.day_num, pa.hora_extra, pa.id_solicitudhora, pa.id_proyecto, pa.id_proyecto_salida, 
            			pa.ev_entrada,pa.ev_salida, pa.status_asistencia, pa.motivo_inasistencia,pa.status_nomina, 
						pa.solicitud_nomina, pc.hora_pago, pc.dia_pago, pa.status_extra, pa.monto_pago, 
                        pa.solicitud_prestamo, pa.status_tipos
						FROM personal_asistencia pa
						INNER JOIN personal_campo pc on pc.id=pa.id_personal 
						where pa.solicitud_nomina = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA REGISTRO

    public function getdetailnominauser($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, 
            		pp.nombre as puesto, pc.curp, pc.nss,pc.rfc
					FROM personal_campo pc
					INNER JOIN puestos_personal pp on pp.id = pc.puesto 
					where pc.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA REGISTRO


    public function getusernominabuscador($id){
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
    } //END GET ASISTENCIA REGISTRO


}