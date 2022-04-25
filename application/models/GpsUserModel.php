<?php

class Application_Model_GpsUserModel extends Zend_Db_Table_Abstract{
    protected $_name = 'semanacuatro_bts';
    protected $_primary = 'id';

    public function insertfotopreliminarsemanacuatro($post,$table){
        try {
            $row = $this->createRow();
            $row->idsitio_tipo = $post['sitio'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO
	public function insertUsr($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $encri = openssl_digest($post["pword"],"sha512");
            $datasave = array(
                'fkroles'=>$post['rol'],
            	'nombre'=>$post['name'],
            	'ap'=>$post['apa'],
            	'am'=>$post['ama'],
            	'telefono'=>$post['phone'],
            	'correo'=>$post['mail'],
            	'passw'=>$encri); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

	public function refreshUsr($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $encri = openssl_digest($post["pword"],"sha512");
            $qry = $db->query("UPDATE $table SET nombre = ? , ap = ? , am = ? , direccion = ? , telefono = ? , correo = ? , passw = ?, fkroles = ? WHERE id = ?",array(
               	$post['name'],
            	$post['apa'],
            	$post['ama'],
            	$post['dir'],
            	$post['phone'],
            	$post['mail'],
            	$encri,
                $post['rol'],
                $post["ids"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER


    public function refresnamerol($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $encri = openssl_digest($post["pword"],"sha512");
            $qry = $db->query("UPDATE $table SET nombre = ? WHERE id = ?",array(
                $post['name'],
                $post["ids"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER


    public function refreshcomprobacionstatus($post,$table,$id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_comprobacion = ? WHERE id = ?",array(
                $post['dato'],
                $id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER


// END MODULO DE ROLES 

	public function inserrol($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre'=>$post['name']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }//  INSERT ROL

    public function UpdateRol($post,$table,$wh){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre = ? WHERE $wh = ?",array($post['name']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

// END MODULO DE ROLES 
	public function insertpersonal($post,$table,$fechafinal){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
            	'nombre'=>$post['name'],
            	'apellido_pa'=>$post['apa'],
            	'apellido_ma'=>$post['ama'],
            	'curp'=>$post['curp'],
            	'puesto'=> $post['puesto'],
            	'status_expediente'=>$post['status'],
            	'rfc'=>$post['rfc'],
            	'telefono'=>$post['phone'],
                'tel_emergencia'=>$post['emergencia'],
            	'email_personal'=>$post['mail'],
                'nss'=>$post['nss'],
                'fecha_ingreso'=>$fechafinal,
                'dia_pago'=>$post['dia_pago'],
                'hora_pago'=>$post['hora_pago'],
                'tarjeta'=>$post['tarjeta'],
                'disponibilidad'=>$post['disponibilidad'],
                'status_campo'=>$post['cuadrilla'],
                'viaticos'=>$post['viaticos']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT PERSONAL CAMPO


	public function insertcertificadopersonal($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
            	'nombre'=>$post['name'],
            	'id_personal'=>$post['user_id'],
            	'comentario'=>$post['comentario'],
            	'lugar_capacitacion'=>$post['lugar_capacitacion'],
            	'fecha'=> $post['fecha'],
            	'medico'=>$post['medico'],
            	'cedula'=>$post['cedula'],
            	'folio_documento'=>$post['folio'],
            	'pdf'=>$urldb); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO

    public function insertinfoantidoping($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_personal'=>$post['user_id'],
                'fecha'=> $post['fecha'],
                'folio'=>$post['folio'],
                'resultado'=>$post['resultado'],
                'laboratorio'=>$post['laboratorio'],
                'file'=>$urldb); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO

    public function insertpuestopersonal($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre'=>$post['name']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT PUESTO PERSONAL 


    public function updateinfoantidoping($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  file = ?, laboratorio = ?, fecha = ?, resultado =?, folio =? WHERE id_personal = ? ",
                array(
                $urldb,
                $post['laboratorio'],
                $post['fecha'],
                $post['resultado'],
                $post['folio'],
                $post['user_id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO

    public function updateinfocertificadomedico($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  nombre = ?, status = ?, comentario = ?, lugar_capacitacion =?, fecha =?, pdf= ?, medico =?, cedula =?, folio_documento=? WHERE id_personal = ? ",
                array(
                $post['name'],
                $post['status'],
                $post['comentario'],
                $post['lugar_capacitacion'],
                $post['fecha'],
                $urldb,
                $post['medico'],
                $post['cedula'],
                $post['folio'],
                $post['user_id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO


    public function insertimagenpersonal($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  imagen = ? WHERE id = ? ",
                array(
                $urldb,
                $post['id_personal']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }

    public function insertdocumentosfotopersonal($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_personal'=>$post['user_id'],); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function updatedocumentofotopersonal($post,$table,$urldb,$documento,$fecha,$status,$hoy){
        $st = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  $documento = ?, $fecha = ?, $status = ? WHERE id_personal = ? ",
                array(
                $urldb,
                $hoy,
                $st,
                $post['user_id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }

    public function refreshPersonalimagen($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET imagen = ? WHERE id = ? ",
                array(
                $urldb,
                $post['id_personal']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }

    public function insertantidopingpersonalid($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_personal'=>$post['user_id']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO


	public function insertantidopingpersonal($post,$table,$urldb_alturas,$edit,$status){
        // var_dump($urldb_alturas);exit;   
        $status_edit= 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET $edit = ?, $status = ? WHERE id_personal = ?",array(
                $urldb_alturas,
                $status_edit,
                $post["user_id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }

    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO

	public function refreshPersonal($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre = ?, apellido_pa = ?, apellido_ma = ?, fecha_ingreso = ?, curp = ?, puesto = ?, status_expediente=?, nss = ?, rfc = ?, telefono = ?, tel_emergencia = ?, email_personal = ?, dia_pago = ?, hora_pago =?, disponibilidad = ?, tarjeta = ?, viaticos = ?, status_campo = ? WHERE id = ?",array(
               	$post['name'],
            	$post['apellido_pa'],
            	$post['ampellido_ma'],
                $post['fingreso'],
            	$post['curp'],
                $post['puesto'],
                $post['status'],
            	$post['nss'],
            	$post['rfc'],
            	$post['phone'],
                $post['emergencia'],
            	$post['mail'],
                $post['dia_pago'],
                $post['hora_pago'],
                $post['disponibilidad'],
                $post['tarjeta'],
                $post['viaticos'],
                $post['cuadrilla'],
                $post["ids"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER


    public function refreshPersonalcont($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre = ?, apellido_pa = ?, apellido_ma = ?, fecha_ingreso = ?, curp = ?, puesto = ?, status_expediente=?, nss = ?, rfc = ?, telefono = ?, tel_emergencia = ?, email_personal = ?, disponibilidad = ?, status_campo = ? WHERE id = ?",array(
                $post['name'],
                $post['apellido_pa'],
                $post['ampellido_ma'],
                $post['fingreso'],
                $post['curp'],
                $post['puesto'],
                $post['status'],
                $post['nss'],
                $post['rfc'],
                $post['phone'],
                $post['emergencia'],
                $post['mail'],
                $post['disponibilidad'],
                $post['cuadrilla'],
                $post["ids"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function refreshcomentariositio($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET comentario = ? WHERE id = ?",array(
                $post['comentario'],
                $post["comentario_id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER}

    public function UpdateStatusdeletepersonal($post,$table, $status){ 
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET delete_status = ? WHERE id = ?",array(
                $status,
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL


    public function Getpagination($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table order by nombre asc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getpaginationestructura($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table order by nombre_estructura asc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getpaginationtipoproyecto($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table order by nombre_proyecto asc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function Getpaginationuser($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT u.id, u.nombre, u.ap, u.am, u.direccion,  u.telefono, u.correo, u.fkroles, 
                u.imagen, r.id as idrol, r.nombre as namerol
                FROM usuario u 
                LEFT JOIN roles r on u.fkroles = r.id order by nombre asc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }



    public function Getpaginationproveedor($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table order by nombre_prov asc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function Informaciongeneral($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, 
                        pc.puesto, pc.status_expediente, pc.telefono, pc.tel_emergencia, pc.email_personal, pc.nss, pc.rfc,
                        pc.dia_pago, pc.fecha_ingreso,
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal,pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, pc.name_sitio,
                        pc.status_comprobacion,pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto 
                        FROM personal_campo pc LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        WHERE pc.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getcountpersonalcero(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, 
                        pc.puesto,pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago,
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, pc.name_sitio,
                        pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto 
                        FROM personal_campo pc LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        WHERE pc.delete_status =0  order by id desc");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getcountpersonalceropaguno(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, 
                        pc.puesto,pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago,
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, pc.name_sitio,
                        pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto 
                        FROM personal_campo pc LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        WHERE pc.delete_status =0 AND pc.status_personal = 0  order by id desc");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function Getcountpersonalgasolina(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, 
                        pc.puesto,pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago,
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, pc.name_sitio,
                        pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto 
                        FROM personal_campo pc LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        WHERE pc.delete_status =0 AND pc.status_personal = 0 order by pc.nombre ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function Getcountpersonal($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, 
                        pc.puesto, pc.status_expediente, pc.telefono, pc.email_personal, pc.nss,pc.rfc, pc.dia_pago, 
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, pc.name_sitio,
                        pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto,  pc.status_operativo 
                        FROM personal_campo pc LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        WHERE pc.delete_status =0 order by id desc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getcountpersonaldirectorio($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, 
                        pc.puesto,pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago,
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, pc.name_sitio,
                        pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto 
                        FROM personal_campo pc LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        WHERE pc.delete_status =0 and status_personal = 0 order by pc.apellido_pa asc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getcountpersonaldeletecount(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, 
                        pc.puesto,pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago,
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, pc.name_sitio,
                        pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto 
                        FROM personal_campo pc LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        WHERE pc.delete_status =1 order by id desc");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getcountpersonaldelete($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, 
                        pc.puesto,pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago,
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, pc.name_sitio,
                        pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto 
                        FROM personal_campo pc LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        WHERE pc.delete_status =1 order by id desc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function nombrepersonal($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM personal_campo Where delete_status= 0 AND nombre like '%{$nombre}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function nombrepersonalcount($nombre,$offset,$no_of_records_per_page){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, 
                        pc.puesto,pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago,
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, pc.name_sitio,
                        pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto, pc.status_operativo 
                        FROM personal_campo pc LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        WHERE pc.delete_status= 0 AND pc.nombre like '%{$nombre}%'  LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } 

    public function nombrepersonalexcel(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT p.nombre, p.apellido_pa, p.apellido_ma, p.telefono, p.curp, p.telefono, 
                        p.email_personal, p.nss, p.rfc, p.puesto, pp.nombre as name 
                        FROM personal_campo p LEFT JOIN puestos_personal pp on p.puesto= pp.id;");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }
    public function nombrepersonalreporte(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT p.nombre, p.apellido_pa, p.apellido_ma, p.telefono, p.curp, p.telefono, 
                        p.email_personal, p.nss, p.rfc, p.name_sitio,p.status_personal, p.puesto, pp.nombre as name 
                        FROM personal_campo p LEFT JOIN puestos_personal pp on p.puesto= pp.id;");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } 

    public function nombresitiosexcel(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT s.id, s.id_cliente,s.Idgps, s.nombre, s.cliente, s.cliente, s.direccion, 
                        s.ciudad, s.estado, s.region, s.estructura, s.altura, s.edificio, s.tipo_sitio, s.latitude, 
                        s.longitude, e.nombre_estructura
                        FROM sitios s
                        LEFT JOIN estructura_sitio e on e.id = s.estructura");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } 

    public function puestopersonal($puesto){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, 
                        pc.puesto,pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago,
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, pc.name_sitio,
                        pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto 
                        FROM personal_campo pc LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        WHERE pp.nombre  like '%{$puesto}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function puestopersonalcount($puesto,$offset,$no_of_records_per_page){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, 
                        pc.puesto,pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago,
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, pc.name_sitio,
                        pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto, pc.status_operativo 
                        FROM personal_campo pc LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        WHERE pp.nombre  like '%{$puesto}%' LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } 

    public function statuspersonal($status){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
             $qry = $db->query("SELECT * FROM personal_campo WHERE status_expediente = ?",array($status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function statuspersonalcount($status,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
             $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, 
                        pc.puesto,pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago,
                        pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                        pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, pc.name_sitio,
                        pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto, pc.status_operativo 
                        FROM personal_campo pc LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        WHERE pc.status_expediente = ? LIMIT $offset,$no_of_records_per_page",array($status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function usernombre($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
             $qry = $db->query("SELECT * FROM usuario WHERE nombre like '%{$nombre}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function correoerror($email){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
             $qry = $db->query("SELECT * FROM usuario WHERE correo = ?",array($email));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function correoerrorpersonal($email){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
             $qry = $db->query("SELECT * FROM personal_campo WHERE email_personal = ?",array($email));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function usuariocount($nombre,$offset,$no_of_records_per_page){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM usuario WHERE nombre like '%{$nombre}%' LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function correoerrorcount($email,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
             $qry = $db->query("SELECT * FROM usuario WHERE correo = ? LIMIT $offset,$no_of_records_per_page",array($email));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function correoerrorcountpersonal($email,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
             $qry = $db->query("SELECT * FROM personal_campo WHERE email_personal = ? LIMIT $offset,$no_of_records_per_page",array($email));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function Getpersonalcuadrilla($id,$proyecto,$sitio, $nombre){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT p.id as id_personal, p.nombre, p.apellido_pa, p.apellido_ma, p.imagen, 
                        p.curp, p.puesto, p.status_expediente, p.telefono, p.email_personal, p.nss,p.rfc,p.dia_pago,
                        p.hora_pago, p.status_personal, p.fecha_personal, p.status_cuadrilla, p.id_sitiopersonal, 
                        p.name_sitio, p.delete_status, pt.id, pt.nombre as name_puesto
                        FROM personal_campo p 
                        LEFT JOIN puestos_personal pt on pt.id = p.puesto 
                        WHERE tipo_proyectopersonal = ? AND sitio_tipoproyectopersonal = ? AND id_sitiopersonal = ? AND name_sitio = ?",array($proyecto,$id,$sitio,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function Getinfodetailpersonal($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT p.id, p.nombre, p.apellido_pa, p.apellido_ma, p.imagen, p.curp, p.puesto, 
                        p.status_expediente, p.telefono, p.email_personal, p.nss, p.rfc, p.dia_pago, p.hora_pago, 
                        p.status_personal, p.fecha_personal, p.status_cuadrilla, p.tipo_proyectopersonal, p.fecha_ingreso, 
                        pu.id as idp,pu.nombre as name_puesto 
                        FROM personal_campo p
                        LEFT join puestos_personal pu on pu.id = p.puesto where p.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function personalactivo(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
             $qry = $db->query("SELECT * FROM personal_campo WHERE status_personal = 0 AND status_efecticard = 0 order by nombre");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function personalactivodos(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
             $qry = $db->query("SELECT * FROM personal_campo WHERE status_personal = 0  order by nombre");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getpersonaldctres(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ap.id, ap.id_personal, ap.status_altura, ap.status_electrico,  
                        ap.status_auxilio, pc.nombre, pc.apellido_pa, pc.apellido_ma
                        FROM antidoping_personal ap
                        LEFT JOIN personal_campo pc on pc.id = ap.id_personal");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getpersonalantidoping(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT a.id, a.id_personal, a.file as documento, a.laboratorio, a.fecha, 
                        a.resultado, a.folio, p.nombre, p.apellido_pa, p.apellido_ma
                        FROM info_antidoping a
                        LEFT JOIN personal_campo p on p.id=a.id_personal");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


}