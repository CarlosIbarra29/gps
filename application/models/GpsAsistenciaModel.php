<?php

class Application_Model_GpsAsistenciaModel extends Zend_Db_Table_Abstract{

    protected $_name = 'personal_solicitudhoras';
    protected $_primary = 'id';

    public function isertsolicitudhoras($post,$table,$user,$fecha){
        try {
            $row = $this->createRow();
            $row->nombre_sitio = $post['sitio'];
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

    public function insertsitiocuadrilla($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_sitio'=>$post,
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
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp,pc.puesto,
                        pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, 
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, 
                        pc.name_sitio,pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto,  
                        pc.status_operativo , pc.status_campo, tp.nombre_proyecto, pc.hora_extra
                        FROM personal_campo pc 
                        LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        LEFT JOIN tipo_proyecto tp on tp.id = pc.tipo_proyectopersonal 
                        WHERE name_sitio = ? ORDER BY pc.nombre ASC",array($nombre));
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
                        ps.asistencia_status, ps.motivo
                        FROM personal_solicitudhoras ps
                        WHERE ps.status = ?
                        ORDER BY ps.id ASC
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
                        pc.motivo, pc.asistencia_status
                        FROM personal_solicitudhoras pc 
                        where pc.nombre_sitio =? and pc.status= 0;",array($nombre));
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

}