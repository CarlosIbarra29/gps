<?php

class Application_Model_GpsNominaModel extends Zend_Db_Table_Abstract{

    protected $_name = 'personal_nomina';
    protected $_primary = 'id';
    public function insertnominasolicitud($id_user,$name_user,$post,$table,$hoy,$solicitud_user){
        try {
            $row = $this->createRow();
            $row->id_personal = $id_user;
            $row->personal = $name_user;
            $row->sitio = $post['sitio'];
            $row->id_proyecto = $post['id_proyecto'];
            $row->monto_nomina = $post['monto'];
            $row->solicitud_fecha = $hoy;
            $row->solicitud_user = $solicitud_user;
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
                'status_extra'=>$status,
                'tipo_nomina'=>$post['tipo_nomina']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertpagonomina($post,$table,$hoy,$nombre_usuario,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'pago_nomina'=>$post['monto'],
                'evidencia_pago'=>$urldb,
                'user_pago'=>$nombre_usuario,
                'fecha_pago'=>$hoy,
                'usuario_nomina'=>$post['user'],
                'solicitud_nomina'=>$post['id_solicitud']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER


    public function updatenominstatus($post,$table,$hoy,$nombre_usuario){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_auditoria = ?, user_auditoria=?, fecha_auditoria = ? WHERE id = ?",array($post['status'],$nombre_usuario,$hoy,$post['id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function updatenominstatuscomentario($post,$table,$hoy,$nombre_usuario){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_auditoria = ?, user_auditoria=?, fecha_auditoria = ?, comentario_auditoria = ? WHERE id = ?",array($post['status'],$nombre_usuario,$hoy,$post['comentario'],$post['id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function updateevidenciapagonomina($post,$table,$hoy,$nombre_usuario){
        $status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_pago = ?, fecha_pago = ?, user_pago = ? WHERE id = ?",array($status,$hoy,$nombre_usuario,$post['id_solicitud']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL


    public function updatedeleteevidenciapagonomina($post,$table,$hoy,$nombre_usuario){
        $status = 0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_pago = ?, fecha_pago = ?, user_pago = ? WHERE id = ?",array($status,$hoy,$nombre_usuario,$post['id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL


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

    public function updateasistendiadaynomina($table,$post,$monto,$day_num,$urldb,$urldb_s){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET hora_entrada =?, hora_salida = ?, id_proyecto =?, id_proyecto_salida = ?, ev_entrada = ?, ev_salida = ? WHERE id = ?",
                array($post['hora_entrada'],$post['hora_salida'],$post['sitio_entrada'],$post['sitio_salida'],$urldb,$urldb_s,$post['id_solicitud']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL


    public function fechapagonomina($id_solicitud,$table,$fecha,$daynum){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET dia =?, day_num = ? WHERE id = ?",array($fecha,$daynum,$id_solicitud));
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

    public function getsolicitudnomina2($status,$pago){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user,pn.status_auditoria,pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn 
                        where pn.status_auditoria = ? and status_pago = ? and pn.status_auditoria2 = 1",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA


    public function getsolicitudnomina3($status,$pago){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user,pn.status_auditoria,pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn 
                        where pn.status_auditoria = ? and status_pago = ? and pn.status_auditoria2 = 0",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA
    


    public function getsolicitudnominausuario($status,$pago,$personal){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user,pn.status_auditoria,pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago
                        FROM personal_nomina pn 
                        where pn.status_auditoria = ? AND status_pago = ? AND pn.id_personal = ?",array($status,$pago,$personal));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA

    public function getsolicitudnominausuario2($status,$pago,$personal){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user,pn.status_auditoria,pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn 
                        where pn.status_auditoria = ? AND status_pago = ? AND pn.id_personal = ? and pn.status_auditoria2 = 1",array($status,$pago,$personal));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA

    public function getsolicitudnominausuario3($status,$pago,$personal){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user,pn.status_auditoria,pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn 
                        where pn.status_auditoria = ? AND status_pago = ? AND pn.id_personal = ? and pn.status_auditoria2 = 0",array($status,$pago,$personal));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA

    public function getsolicitudnominasitio($status,$pago,$sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user,pn.status_auditoria,pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago
                        FROM personal_nomina pn 
                        where pn.status_auditoria = ? AND status_pago = ? AND pn.sitio LIKE '%{$sitio}%'",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA sitio 

    public function getsolicitudnominasitio2($status,$pago,$sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user,pn.status_auditoria,pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn 
                        where pn.status_auditoria = ? AND status_pago = ? AND pn.sitio LIKE '%{$sitio}%' and pn.status_auditoria2 = 1",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA sitio 


    public function getsolicitudnominasitio3($status,$pago,$sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user,pn.status_auditoria,pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn 
                        where pn.status_auditoria = ? AND status_pago = ? AND pn.sitio LIKE '%{$sitio}%' and pn.status_auditoria2 = 0",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA sitio 

    public function getsolicitudnominaid($status,$pago,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user,pn.status_auditoria,pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago
                        FROM personal_nomina pn 
                        where pn.status_auditoria = ? AND status_pago = ? AND pn.id = ?",array($status,$pago,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA

    public function getsolicitudnominaid2($status,$pago,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user,pn.status_auditoria,pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn 
                        where pn.status_auditoria = ? AND status_pago = ? AND pn.id = ? AND pn.status_auditoria2 = 1",array($status,$pago,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ASISTENCIA


    public function getsolicitudnominaid3($status,$pago,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user,pn.status_auditoria,pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn 
                        where pn.status_auditoria = ? AND status_pago = ? AND pn.id = ? AND pn.status_auditoria2 = 0",array($status,$pago,$id));
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

    public function getnominasolicitud2($offset,$no_of_records_per_page,$status,$pago){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user, pn.status_auditoria, pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn
                        where pn.status_auditoria = ? and status_pago = ? and pn.status_auditoria2 = 1
                        ORDER BY pn.sitio ASC
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL

    public function getnominasolicitud3($offset,$no_of_records_per_page,$status,$pago){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user, pn.status_auditoria, pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn
                        where pn.status_auditoria = ? and status_pago = ? and pn.status_auditoria2 = 0
                        ORDER BY pn.sitio ASC
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL

    public function getnominasolicitudbuscador($offset,$no_of_records_per_page,$status,$pago,$personal){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user, pn.status_auditoria, pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago
                        FROM personal_nomina pn
                        where pn.status_auditoria = ? and status_pago = ? AND pn.id_personal = ?
                        ORDER BY pn.id DESC
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago,$personal));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL


     public function getnominasolicitudbuscador2($offset,$no_of_records_per_page,$status,$pago,$personal){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user, pn.status_auditoria, pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn
                        where pn.status_auditoria = ? and status_pago = ? AND pn.id_personal = ? and  pn.status_auditoria2 = 1
                        ORDER BY pn.id DESC
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago,$personal));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL


    public function getnominasolicitudbuscador3($offset,$no_of_records_per_page,$status,$pago,$personal){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user, pn.status_auditoria, pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn
                        where pn.status_auditoria = ? and status_pago = ? AND pn.id_personal = ? and  pn.status_auditoria2 = 0
                        ORDER BY pn.id DESC
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago,$personal));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL

    public function getnominasolicitudbuscadorsitio($offset,$no_of_records_per_page,$status,$pago,$sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user, pn.status_auditoria, pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago
                        FROM personal_nomina pn
                        where pn.status_auditoria = ? and status_pago = ? AND pn.sitio LIKE '%{$sitio}%'
                        ORDER BY pn.id DESC
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL

    public function getnominasolicitudbuscadorsitio2($offset,$no_of_records_per_page,$status,$pago,$sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user, pn.status_auditoria, pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn
                        where pn.status_auditoria = ? and status_pago = ? AND pn.sitio LIKE '%{$sitio}%' and pn.status_auditoria2 = 1
                        ORDER BY pn.id DESC
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL

    public function getnominasolicitudbuscadorsitio3($offset,$no_of_records_per_page,$status,$pago,$sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user, pn.status_auditoria, pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn
                        where pn.status_auditoria = ? and status_pago = ? AND pn.sitio LIKE '%{$sitio}%' and pn.status_auditoria2 = 0
                        ORDER BY pn.id DESC
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL



    public function getnominasolicitudbuscadorid($offset,$no_of_records_per_page,$status,$pago,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user, pn.status_auditoria, pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago
                        FROM personal_nomina pn
                        where pn.status_auditoria = ? and status_pago = ? AND pn.id = ?
                        ORDER BY pn.id DESC
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL

    public function getnominasolicitudbuscadorid2($offset,$no_of_records_per_page,$status,$pago,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user, pn.status_auditoria, pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn
                        where pn.status_auditoria = ? and status_pago = ? AND pn.id = ? and pn.status_auditoria2 = 1
                        ORDER BY pn.id DESC
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL


    public function getnominasolicitudbuscadorid3($offset,$no_of_records_per_page,$status,$pago,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.id_personal, pn.personal, pn.sitio, pn.id_proyecto,pn.monto_nomina,
                        pn.solicitud_fecha,pn.solicitud_user, pn.status_auditoria, pn.user_auditoria, 
                        pn.fecha_auditoria, pn.status_pago, pn.fecha_pago, pn.user_pago, pn.status_auditoria2
                        FROM personal_nomina pn
                        where pn.status_auditoria = ? and status_pago = ? AND pn.id = ? and pn.status_auditoria2 = 0
                        ORDER BY pn.id DESC
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago,$id));
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
                        pa.solicitud_prestamo, pa.status_tipos, pa.tipo_nomina
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
            $qry = $db->query("SELECT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.hora_pago, pc.dia_pago,
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
                        pc.puesto,pc.status_expediente, pc.telefono, pc.email_personal,pc.nss, pc.rfc,pc.dia_pago, 
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

    public function getnominapagadaexcel(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.id, pn.pago_nomina, pn.fecha_pago, pn.usuario_nomina, pn.solicitud_nomina,
                sn.id as idnomina, sn.id_personal, sn.personal, sn.sitio, pc.id, pp.nombre as puesto
                FROM personal_pagonomina pn
                LEFT JOIN personal_nomina sn ON sn.id = pn.solicitud_nomina
                LEFT JOIN personal_campo pc ON pc.id = pn.usuario_nomina
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                ORDER BY pn.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL


    public function getnominasmanager(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sitio, id_proyecto ,SUM(monto_nomina) as monto_nmn
                FROM personal_nomina
                WHERE status_auditoria = 1 and status_pago = 0 and status_auditoria2 = 0
                GROUP BY sitio");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET NOMINAS MANAGER


    public function GetPaginationNmnMng($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sitio, id_proyecto ,SUM(monto_nomina) as monto_nmn
                FROM personal_nomina
                WHERE status_auditoria = 1 and status_pago = 0 and status_auditoria2 = 0
                GROUP BY sitio
                ORDER BY sitio ASC
                LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL



    public function GetNominaSitioMgr($table,$sitio,$proyecto){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.*, p.puesto, pp.nombre FROM personal_nomina pn
                INNER JOIN personal_campo p ON p.id = pn.id_personal
                INNER JOIN puestos_personal pp ON pp.id = p.puesto
                WHERE status_auditoria = 1 and status_pago = 0 and status_auditoria2 = 0 and
                sitio LIKE '%{$sitio}%' and id_proyecto = ? ORDER BY p.puesto DESC",array($proyecto));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    } // Nominas por sitio



    public function GetPeriodoNominas($table,$id){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT concat('De ', min(dia), '<br> Al ', max(dia) ) as periodo from personal_asistencia where solicitud_nomina = ?",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    } // Nominas por sitio


    public function GetSitiosDatos($table,$sitio){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM sitios
                WHERE nombre LIKE '%{$sitio}%'");
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    } // Nominas por sitio


    public function updatecomentariosnomina($table,$post){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET comentario_auditoria2 = ? WHERE id = ?",
                array($post['comentarios'],$post['idi']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL


    public function getsolicitudnominamgr($status){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pnp.id, pnp.fecha_creacion, pnp.sitio, pnp.id_proyecto, pnp.status,  
                    pnp.monto, pnp.id_auditoria, pnp.user_auditoria, pnp.fecha_auditoria, pnp.comentarios_auditoria
                    FROM personal_nominapack pnp 
                        where pnp.status = ? ",array($status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET Solicitudes MANAGER

    public function getnominasolicitudmgr($offset,$no_of_records_per_page,$status){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pnp.id, pnp.fecha_creacion, pnp.sitio, pnp.id_proyecto, pnp.status,  
                    pnp.monto, pnp.id_auditoria, pnp.user_auditoria, pnp.fecha_auditoria, pnp.comentarios_auditoria
                    FROM personal_nominapack pnp 
                    where pnp.status = ? 
                    ORDER BY pnp.id DESC
                    LIMIT $offset,$no_of_records_per_page",array($status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET SOLICITUDES manager paginacion


    public function getsolnominasitiomgr($status,$sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pnp.id, pnp.fecha_creacion, pnp.sitio, pnp.id_proyecto, pnp.status,  
                    pnp.monto, pnp.id_auditoria, pnp.user_auditoria, pnp.fecha_auditoria, pnp.comentarios_auditoria
                    FROM personal_nominapack pnp 
                    WHERE pnp.status = ? AND pnp.sitio LIKE '%{$sitio}%'",array($status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET SITIO


    public function getnominasolbuscadorsitiomgr($offset,$no_of_records_per_page,$status,$sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pnp.id, pnp.fecha_creacion, pnp.sitio, pnp.id_proyecto, pnp.status,  
                    pnp.monto, pnp.id_auditoria, pnp.user_auditoria, pnp.fecha_auditoria, pnp.comentarios_auditoria
                    FROM personal_nominapack pnp
                        where pnp.status = ? AND pnp.sitio LIKE '%{$sitio}%'
                        ORDER BY pnp.id DESC
                        LIMIT $offset,$no_of_records_per_page",array($status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR SITIO


    public function getsolicitudnominaidmgr($status,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pnp.id, pnp.fecha_creacion, pnp.sitio, pnp.id_proyecto, pnp.status,  
                    pnp.monto, pnp.id_auditoria, pnp.user_auditoria, pnp.fecha_auditoria, pnp.comentarios_auditoria
                    FROM personal_nominapack pnp 
                    WHERE pnp.status = ? AND pnp.id = ?",array($status,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET ID

    public function getnominasolbuscadoridmgr($offset,$no_of_records_per_page,$status,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pnp.id, pnp.fecha_creacion, pnp.sitio, pnp.id_proyecto, pnp.status,  
                    pnp.monto, pnp.id_auditoria, pnp.user_auditoria, pnp.fecha_auditoria, pnp.comentarios_auditoria
                    FROM personal_nominapack pnp 
                    WHERE pnp.status = ? AND pnp.id = ?
                    ORDER BY pnp.id DESC
                    LIMIT $offset,$no_of_records_per_page",array($status,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR ID


    public function GetNominaPackMgr($table,$id){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pn.*, p.puesto, pp.nombre, ppn.evidencia_pago FROM personal_nomina pn
                INNER JOIN personal_campo p ON p.id = pn.id_personal
                INNER JOIN puestos_personal pp ON pp.id = p.puesto
                LEFT JOIN personal_pagonomina ppn ON pn.id = ppn.solicitud_nomina
                WHERE id_packnomina = ? ORDER BY p.puesto DESC",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    } // Nominas por sitio

    // public function GetCountSolMgr($table){
    //     try{
    //         $db = Zend_Db_Table::getDefaultAdapter();
    //         $qry = $db->query("SELECT COUNT(DISTINCT (sitio)) as notis FROM personal_nomina
    //             WHERE status_auditoria = 1 and status_pago = 0;");
    //         $row = $qry->fetchAll();
    //         return $row;
    //         $db->closeConnection();
    //     }catch (Exception $e){
    //         echo $e;
    //     }
    // } //Total de sol MANAGER
}