<?php

class Application_Model_GpsAsistenciaModel extends Zend_Db_Table_Abstract{

    protected $_name = 'personal_solicitudhoras';
    protected $_primary = 'id';

    public function isertsolicitudhoras($post,$table,$user,$fecha){
        try {
            $row = $this->createRow();
            $row->nombre_sitio = $post['sitio'];
            $row->id_proyecto = $post['proyecto'];
            $row->user_solicitud = $user;
            $row->user_fecha = $fecha;
            $row->motivo = $post['motivo'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT SOLICITUD HORAS EXTRA

    public function insertpersonalsolictud($post,$table,$id,$hora,$hoy,$nombre,$id_solicitud){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_user'=>$id,
                'hora_extra'=>$hora,
                'id_solicitud'=>$id_solicitud
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertfinalizarproceso($id_personal,$name_sitio,$hora_entrada,$hora_salida,$dia,$dia_num,$hora_extra,$id_solicitudhora,$proyecto_entrada,$proyecto_salida,$ev_entrada,$ev_salida,$table,$status_asistencia,$motivo){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_personal'=>$id_personal,
                'nombre'=>$name_sitio,
                'hora_entrada'=>$hora_entrada,
                'hora_salida'=>$hora_salida,
                'dia'=>$dia,
                'day_num'=>$dia_num,
                'hora_extra'=>$hora_extra,
                'id_solicitudhora'=>$id_solicitudhora,
                'id_proyecto'=>$proyecto_entrada,
                'id_proyecto_salida'=>$proyecto_salida,
                'ev_entrada'=>$ev_entrada,
                'ev_salida'=>$ev_salida,
                'status_asistencia'=>$status_asistencia,
                'motivo_inasistencia'=>$motivo
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function insertsitiocuadrilla($nombre,$cliente,$tipo_proyecto,$key,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_sitio'=>$nombre,
                'cliente'=>$cliente,
                'proyecto'=>$tipo_proyecto,
                'id_proyecto'=>$key
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function updatehoraextra($post,$table,$id,$hora,$hoy,$nombre){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET hora_extra = ?,date_horaextra =?, user_horaextra =?  WHERE id = ?",array($hora,$hoy,$nombre,$id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function updatehoraextrasolicitud($table,$id,$value){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET hora_extra = ? WHERE id = ?",array($value,$id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL


    public function updaterolregistrohora($post,$table){
        $value= 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_user = $value WHERE id = ?",array($post));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function updaterolregistrohorapersonaldos($solicitud,$table){
        $value= 0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_user = ? WHERE id_solicitud = ?",array($value,$solicitud));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL


    public function updaterolregistrohorapersonal($post,$table,$horaextra){
        $value= 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET hora_extra = ? WHERE id = ?",array($horaextra,$post));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function updaterolregistrohorasolicitud($solicitud,$table){
        $value= 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status = $value WHERE id = ?",array($solicitud));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function updatehoraentrada($id,$table,$post,$fecha,$proyecto,$hoy,$urldb){
        $status = 0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_asistencia= ?, hora_inicio=?, proyecto_fechainicio=?, day_number=?, day_asistencia = ?, evidencia_entrada = ? WHERE id = ?",
                array($status,$post['h_entrada'],$proyecto,$fecha,$hoy,$urldb,$id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function updatehorasalida($id,$table,$post,$proyecto,$urldb){
        $status = 0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_asistencia= ?, hora_final=?, proyecto_fechafinal=?, evidencia_salida= ? WHERE id = ?",
                array($status,$post['h_salida'],$proyecto,$urldb,$id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function updateinasistencia($id,$table,$post,$fecha,$proyecto,$hoy){
        $status = 1; $hora_trabajo =0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_asistencia= ?, hora_inicio=?, proyecto_fechainicio=?, day_number=?, day_asistencia = ? WHERE id = ?",
                array($status,$hora_trabajo,$proyecto,$fecha,$hoy,$id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function updatefinalizarproceso($id_personal,$name_sitio,$hora_entrada,$hora_salida,$dia,$dia_num,$hora_extra,$id_solicitudhora,$proyecto_entrada,$proyecto_salida,$ev_entrada,$ev_salida,$table,$status_asistencia,$motivo){
        $status = 0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_asistencia= ?, hora_inicio=?, proyecto_fechainicio=?, hora_final=?, proyecto_fechafinal = ?, day_number= ?, hora_extra= ?,motivo_inasistencia =?, day_asistencia = ?, evidencia_entrada= ?, evidencia_salida = ? WHERE id = ?",
                array($status,$hora_entrada,$proyecto_entrada,$hora_salida,$proyecto_salida,$dia_num,$hora_extra,$motivo,$dia,$ev_entrada, $ev_salida,$id_personal));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function updatesolicitudhoraextras($table,$post){
        $status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET asistencia_status= ? WHERE id = ?",
                array($status,$post['id_solicitudextra']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL




    public function trancatecuadrilla(){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("TRUNCATE TABLE sitios_cuadrillas");
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END TRUNCATE


    public function updatesolicitudhoraextra($post,$table,$today,$nombre_usuario){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status = ?, validacion_user = ?, fecha_validacion = ?, comentario = ? WHERE id = ?",array(
                $post['dato'],
                $nombre_usuario,
                $today,
                $post['comentario'],
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL


    public function getallsitioscuadrilla(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp,pc.puesto,
                        pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, 
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, 
                        pc.name_sitio,pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto,  
                        pc.status_operativo , pc.status_campo, tp.nombre_proyecto
                        FROM personal_campo pc 
                        LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        LEFT JOIN tipo_proyecto tp on tp.id = pc.tipo_proyectopersonal 
                        WHERE pc.status_campo = 1 AND pc.status_cuadrilla = 1");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA

    public function getpersonalsitiocuadrilla($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp,
                        pc.puesto,pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc,pc.dia_pago, 
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, 
                        pc.name_sitio,pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto,  
                        pc.status_operativo , pc.status_campo, tp.nombre_proyecto, pc.hora_extra,
                        pc.fechainicio_asignacion, pc.fechafinal_asignacion, pc.day_number, pc.hora_inicio, 
                        pc.hora_final, pc.status_asistencia, pc.horas_trabajadas
                        FROM personal_campo pc 
                        LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        LEFT JOIN tipo_proyecto tp on tp.id = pc.tipo_proyectopersonal 
                        WHERE sitio_tipoproyectopersonal = ? ORDER BY pc.nombre ASC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA

    public function getprocesosolicitudhoras($op_status){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ps.id,ps.nombre_sitio,ps.user_solicitud, ps.user_fecha, ps.status, 
                        ps.asistencia_status 
                        FROM personal_solicitudhoras ps
                        WHERE ps.status = ?",array($op_status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA


    public function getcountsolhoras($offset,$no_of_records_per_page,$op_status){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ps.id,ps.nombre_sitio,ps.user_solicitud, ps.user_fecha, ps.status, 
                        ps.asistencia_status, ps.motivo, ps.id_proyecto, st.id_tipoproyecto, st.id_sitio, s.nombre,
                        s.id_cliente, tp.nombre_proyecto
                        FROM personal_solicitudhoras ps
                        LEFT JOIN sitios_tipoproyecto st on st.id = ps.id_proyecto
                        LEFT JOIN sitios s on s.id = st.id_sitio
                        LEFT JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
                        WHERE ps.status = ?
                        ORDER BY ps.id DESC
                        LIMIT $offset,$no_of_records_per_page",array($op_status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL

    public function getpersonalsolicituddetalle($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pu.id as id_sol,pu.id_user, pu.hora_extra, pc.nombre, pc.apellido_pa, 
                        pc.apellido_ma, pc.imagen,  pp.nombre as puesto, pu.id_solicitud, pu.status_user
                        FROM personal_userhoras pu
                        INNER JOIN personal_campo pc on pc.id = pu.id_user
                        INNER JOIN puestos_personal pp on pp.id = pc.puesto
                        Where pu.id_solicitud = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET DETALLE PERSONAL SOLICITUD HORAS EXTRA



    public function getsolicitudpendiente($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre_sitio, pc.user_solicitud, pc.user_solicitud,pc.status, 
                        pc.motivo, pc.asistencia_status, pc.id_proyecto
                        FROM personal_solicitudhoras pc 
                        where id_proyecto = ? and pc.status= 0;",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA

    public function getsolicitudpendientecheckin($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre_sitio, pc.user_solicitud, pc.user_solicitud,pc.status, 
                        pc.motivo, pc.asistencia_status
                        FROM personal_solicitudhoras pc 
                        where pc.nombre_sitio =? and pc.status= 1 AND pc.asistencia_status = 0",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA PENDIENTE

    public function getpersonalasistencianomina($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pa.id as id_pa, pa.id_personal, pa.nombre, pa.hora_entrada, pa.hora_salida, 
                        pa.dia,pa.day_num, pa.hora_extra,pa.id_solicitudhora,pa.id_proyecto,pa.id_proyecto_salida, 
                        pa.ev_entrada, pa.ev_salida, pa.status_asistencia, pa.motivo_inasistencia,pa.status_nomina, 
                        pc.dia_pago, pc.hora_pago,pc.nombre as name_personal, pc.apellido_pa, pc.apellido_ma, 
                        pa.status_extra, pa.solicitud_prestamo, pa.monto_pago
                        FROM personal_asistencia pa 
                        LEFT JOIN personal_campo pc on pc.id = pa.id_personal
                        where pa.id_personal = ? and status_nomina = 0",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA PENDIENTE


    public function getpersonalasistencianominaregistro($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pa.id as id_pa, pa.id_personal, pa.nombre, pa.hora_entrada, pa.hora_salida, 
                        pa.dia,pa.day_num, pa.hora_extra,pa.id_solicitudhora,pa.id_proyecto,pa.id_proyecto_salida, 
                        pa.ev_entrada, pa.ev_salida, pa.status_asistencia, pa.motivo_inasistencia,pa.status_nomina, 
                        pc.dia_pago, pc.hora_pago,pc.nombre as name_personal, pc.apellido_pa, pc.apellido_ma
                        FROM personal_asistencia pa 
                        LEFT JOIN personal_campo pc on pc.id = pa.id_personal
                        where pa.id = ? and status_nomina = 0",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA REGISTRO

    public function getsitioscuadrillasordername(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sc.id,sc.nombre_sitio, sc.cliente, sc.proyecto, sc.id_proyecto, sc.status_asistencia FROM sitios_cuadrillas sc order by sc.nombre_sitio ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA REGISTRO

}