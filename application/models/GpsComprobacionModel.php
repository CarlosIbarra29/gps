<?php

class Application_Model_GpsComprobacionModel extends Zend_Db_Table_Abstract{
    protected $_name = 'comprobaciones_generadas';
    protected $_primary = 'id';

    public function insertcomprobacionresidente($id_residente,$facturable_residente, $facturable_proyectos, $nofacturable_residente, $nofacturable_proyectos,$fecha_generacion,$user_generacion,$post){
        try {
            $row = $this->createRow();
            $row->id_residente = $id_residente;
            $row->id_solicitud = $post['id_sol'];
            $row->facturable_residente = $facturable_residente;
            $row->facturable_proyectos = $facturable_proyectos;
            $row->nofacturable_residente = $nofacturable_residente;
            $row->nofacturable_proyectos = $nofacturable_proyectos;
            $row->fecha_generacion = $fecha_generacion;
            $row->user_generacion = $user_generacion;
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT COMPROBACIONES

    public function insertfirstcomprobacion($post,$table,$hoy,$nombre,$name_sitio,$nombre_proyecto,$monto){
        // $monto = 0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_residente'=>$post['id_residente'],
                'nombre_residente'=>$post['nombre_residente'],
                'id_sitio'=>$post['sitio'],
                'nombre_sitio'=>$name_sitio,
                'id_tipoproyecto'=>$post['proyecto'],
                'nombre_tipoproyecto'=>$nombre_proyecto,
                'monto'=>$post['monto'],
                'comentario'=> $post['comentario'],
                'fecha_solicitud'=>$hoy,
                'user_solicitud'=>$nombre,
                'monto_anterior'=>$monto
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertfirstcomprobaciondelete($comp,$post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitio'=>$comp[0]['id_sitio'],
                'id_tipoproyecto'=>$comp[0]['id_tipoproyecto'],
                'id_residente'=>$comp[0]['id_residente'],
                'fecha_del'=>$comp[0]['fecha_del'],
                'monto_solicitud'=>$comp[0]['monto_solicitud'],
                'razon_social'=>$comp[0]['razon_social'],
                'facturable'=>$comp[0]['facturable'],
                'factura'=>$comp[0]['factura'],
                'servicio'=>$comp[0]['servicio'],
                'monto_comprobacion'=>$comp[0]['monto_comprobacion'],
                'vo_bo'=>$comp[0]['vo_bo'],
                'comentarios_comprobacion'=>$comp[0]['comentarios_comprobacion'],
                'status_comprobacion'=>$comp[0]['comentarios_comprobacion'],
                'status_repetido'=>$comp[0]['status_repetido'],
                'fecha_user'=>$comp[0]['fecha_user'],
                'user'=>$comp[0]['user'],
                'factura_file'=>$comp[0]['factura_file'],
                'autorizacion'=>$comp[0]['autorizacion'],
                'id_comprobacion'=>$comp[0]['id_comprobacion'],
                'comentario_aud'=>$post['comentario']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertfacturaefecticard($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'no_factura'=> utf8_encode($post['no_factura'] ),
                'rfc_emisor'=> utf8_encode($post['rfc_emisor'] ),
                'nombre_emisor'=> utf8_encode($post['nombre_emisor'] ),
                'fecha_comprobante'=> utf8_encode($post['fecha_comprobante'] ),
                'total_factura'=> utf8_encode($post['total_factura']),
                'forma_pago'=>utf8_encode($post['forma_pago']),
                'lugar_expedicion'=> utf8_encode($post['lugar_expedicion'])
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertfacturaback($post,$table, $hoy, $user){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'factura'=> utf8_encode($post['factura'] ),
                'servicio'=> utf8_encode($post['servicio'] ),
                'monto'=> utf8_encode($post['monto'] ),
                'razon_social'=> $post['razon_social'],
                'residente'=> utf8_encode($post['residente']),
                'motivo_inp'=>utf8_encode($post['motivo_inp']),
                'fecha_regreso'=> $hoy,
                'user_regreso'=>$user
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertserviciocomprobacion($post,$table,$autorizacion,$name_auto){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre'=>$post['name'],
                'status_monto'=>$post['status_politica'],
                'monto'=>$post['monto_limite'],
                'status_excepcion'=>$post['status_excepcion'],
                'autorizacion'=>$autorizacion,
                'nombre_rol'=>$name_auto,
                'comentarios'=>$post['comentario']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertpagocomprobacion($table,$post,$fecha_pago,$user_pago,$urldb,$monto){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_solicitud'=>$post['actual_id'],
                'fecha_pago'=>$fecha_pago,
                'user_pago'=>$user_pago,
                'monto'=>$monto,
                'file_pago'=>$urldb
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertreembolsocomprobacion($table,$post,$fecha,$user){
        $sitio = 00;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_residente'=>$post['residente'],
                'nombre_residente'=>$post['residente_name'],
                'id_sitio'=>$sitio,
                'nombre_sitio' => "Reembolso",
                'monto' => $post['monto'],
                'autorizacion_status'=>4,
                'user_autorizacion'=>"--",
                'fecha_autorizacion'=>$fecha,
                'pago_status'=>4,
                'fecha_solicitud'=>$fecha,
                'user_solicitud'=>$user,
                'status_comprobacion'=>1
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertresidentecomprobacion($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_residente'=>$post['residente'],
                'id_sitio'=>$post['sitio']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function refreshsgenerarcomprobaciones($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_comprobacion = ?",array(
                $post['sitio']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE COMPROBACIONES

    public function refreshfacturascontenido($dato,$table,$residente){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET facturas_pendientes = ? where id = ?",array(
                $dato,
                $residente
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE COMPROBACIONES

    public function refreshssitiocomprobacion($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_sitio = ? where id_residente = ?",array(
                $post['sitio'], $post['residente']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE COMPROBACIONES

    public function refreshsbackfactura($id_factura,$table){
        $status = 0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_factura = ? where id =?",array(
                $status,
                $id_factura));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE COMPROBACIONES

    public function refreshsbackfacturasat($post,$table){
        $status = 0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET no_factura = ?, rfc_emisor = ?, nombre_emisor = ?, fecha_comprobante= ?, total_factura = ?, forma_pago = ?, lugar_expedicion = ? where id =?",array(
                $post['factura'],
                $post['rfc'],
                $post['emisor'],
                $post['fecha'],
                $post['total'],
                $post['forma_pago'],
                $post['lugar'],
                $post['ids']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE FACTURA SAT



    public function refreshssolicitudcomprobada($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_comprobacion = 1 where id = ? ",array(
                $post['id_sol']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE COMPROBACIONES

    public function refreshssolicitudpagadacajachica($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET pago_status = 1 where id = ?",array(
                $post['actual_id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE COMPROBACIONES

    public function refreshssolicitudpagadacajachicados($post,$table){
        // var_dump($post);exit;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_caja = 1 where id = ?",array(
                $post['actual_id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE COMPROBACIONES

    public function refreshsgenerarcomprobacionesaddsolicitud($table,$post, $id_residente){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_comprobacion = ?  WHERE status_comprobacion = 1 AND id_comprobacion = 0 AND id_residente = $id_residente",array(
                $post['id_sol']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE COMPROBACIONES

    public function refreshsresidentecomprobacion($key, $table, $id_residente, $id_comprobacion){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_comprobacion = ?  WHERE id = ?",array(
                $id_comprobacion,
                $key['id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE COMPROBACIONES

    public function refreshserviciocomprobacion($post,$table,$monto_limite,$autorizacion,$name_auto){
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre = ?, status_monto = ?, monto = ?, status_excepcion = ?, autorizacion =?, nombre_rol = ?, comentarios = ? WHERE id = ?",array(
                $post['name'],
                $post['status_politica'],
                $monto_limite,
                $post['status_excepcion'],
                $autorizacion,
                $name_auto,
                $post['comentario'],
                $post['id']
            ));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function Updatesolicitudcajachica($post,$table,$hoy,$user){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET autorizacion_status = ?, user_autorizacion= ?, fecha_autorizacion = ?, comentario = ?, pago_status = ? WHERE id = ?",array(
                $post['dato'],
                $user,
                $hoy,
                $post['comentario'],
                $post['pago'],
                $post['id']
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function updateleidofactura($post,$table,$hoy,$user){
        $status_back = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_back = ?, user_leido= ?, fecha_leido = ? WHERE id = ?",array(
                $status_back,
                $user,
                $hoy,
                $post['id']
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function upateuserfactura($residente,$table){
        $status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET facturas_pendientes = ? WHERE id = ? ",
                array(
                $status,
                $residente));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE STATUS FACTURA

    public function updatetatusfactura($no_fact,$table){
        $status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_factura = ? WHERE id = ? ",
                array(
                $status,
                $no_fact));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE STATUS FACTURA

    public function updatetatusfacturados($no_fact,$table){
        $status = 0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_factura = ? WHERE id = ? ",
                array(
                $status,
                $no_fact));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE STATUS FACTURA

    public function Updatechangesolicitud($post,$table,$hoy){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET autorizacion_status = ?, fecha_personal= ? WHERE id = ?",array(
                $post['dato'],
                $hoy,
                $post["user"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function Updatepagosolicitud($post,$table,$urldb,$hoy,$user){
        $pago = 1; 
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET pago_status = ?,pago_file = ?, pago_user = ?, pago_fecha = ? WHERE id = ?",array(
                $pago,
                $urldb,
                $user,
                $hoy,
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function Updatedeletecomprobacion($post,$table,$new_solicitud,$new_anterior){
        $pago = 1; 
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET monto = ?, monto_anterior = ? WHERE id = ?",array(
                $new_solicitud,
                $new_anterior,
                $post["actual_id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function Getcomprobaciongenerada($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_residente, c.fecha_del, c.fecha_al, c.monto_solicitud, 
                        c.razon_social, c.facturable, c.factura, c.servicio, c.monto_comprobacion, c.vo_bo, 
                        c.comentarios_comprobacion, c.status_comprobacion, s.nombre_servicio
                        FROM comprobaciones c 
                        LEFT JOIN servicios s on s.id=c.servicio 
                        WHERE c.status_comprobacion = 0 and c.id_residente = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // END GET COMPROBACIONES RESIDENTE EN PROCESO

    public function Getpaginationcomprobacionesgeneradasresidente($id,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM comprobaciones_generadas 
                        WHERE id_residente = ? LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR COMPROBACIONES EN PROCESO

    public function Getarrayfacturasefecticard(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT no_factura,rfc_emisor,nombre_emisor,fecha_comprobante,total_factura, 
                        forma_pago,lugar_expedicion  
                        FROM factura_efecticard");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR COMPROBACIONES EN PROCESO

    public function Getpaginationcomprobacionesgeneradas($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM comprobaciones where id_comprobacion = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR COMPROBACIONES EN PROCESO

    public function Gettiporpoyecto($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT stp.id, stp.id_tipoproyecto, stp.residente, tp.nombre_proyecto
                        FROM sitios_tipoproyecto stp 
                        LEFT JOIN tipo_proyecto tp on tp.id = stp.id_tipoproyecto where stp.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR COMPROBACIONES EN PROCESO

    public function Getpaginationcomprobacionesgeneradaspaginator($id,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_residente, c.fecha_del, c.fecha_al, c.monto_solicitud, 
                        c.razon_social, c.facturable, c.factura, c.servicio, c.monto_comprobacion, c.vo_bo, 
                        c.comentarios_comprobacion, c.status_comprobacion, s.nombre_servicio
                        FROM comprobaciones c 
                        LEFT JOIN servicios s on s.id=c.servicio where id_comprobacion = ? 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR COMPROBACIONES EN PROCESO

    public function Getproyectocomprobaciones($id){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT s.id, s.id_tipoproyecto, s.id_sitio, tp.nombre_proyecto 
                        FROM sitios_tipoproyecto s 
                        LEFT JOIN tipo_proyecto tp on s.id_tipoproyecto=tp.id where s.id_sitio=?",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function getservicioscomprobaciones(){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sc.id, sc.nombre, sc.status_monto, sc.monto, sc.status_excepcion, 
                        sc.autorizacion, sc.nombre_rol, sc.comentarios 
                        FROM servicios_comprobaciones sc");
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function getservicioscomprobacionespaginator($offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sc.id, sc.nombre, sc.status_monto, sc.monto, sc.status_excepcion, 
                        sc.autorizacion, sc.nombre_rol, sc.comentarios 
                        FROM servicios_comprobaciones sc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR COMPROBACIONES EN PROCESO

    public function getcomprobacionproceso($status,$pago){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT cs.id,cs.id_residente,cs.nombre_residente,cs.id_sitio,cs.nombre_sitio, 
                        cs.id_tipoproyecto, cs.nombre_tipoproyecto,cs.monto, cs.autorizacion_status,cs.pago_status, 
                        cs.pago_file, cs.status_caja, cs.comentario, cs.fecha_solicitud, cs.user_solicitud 
                        FROM comprobacion_solicitud cs 
                        where cs.autorizacion_status = ? 
                        AND cs.pago_status = ?",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getcomprobacionprocesoresidente($status,$pago,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT cs.id, cs.id_residente, cs.nombre_residente, cs.id_sitio, cs.nombre_sitio, 
                        cs.id_tipoproyecto, cs.nombre_tipoproyecto, cs.monto,cs.autorizacion_status,cs.pago_status, 
                        cs.pago_file, cs.status_caja, cs.comentario, cs.fecha_solicitud, cs.user_solicitud 
                        FROM comprobacion_solicitud cs 
                        WHERE cs.autorizacion_status = ? AND cs.pago_status = ? 
                        AND cs.id_residente = ?",array($status,$pago,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getpaginatorcomprobacion($status,$pago,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT cs.id, cs.id_residente, cs.nombre_residente, cs.id_sitio, cs.nombre_sitio, 
                        cs.id_tipoproyecto, cs.nombre_tipoproyecto,cs.monto, cs.autorizacion_status,cs.pago_status,
                        cs.pago_file,cs.status_caja, cs.comentario, cs.fecha_solicitud, cs.user_solicitud, 
                        cs.status_caja
                        FROM comprobacion_solicitud cs 
                        WHERE cs.autorizacion_status = ? AND cs.pago_status = ? ORDER BY cs.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getpaginatorcomprobacionresidente($status,$pago,$id,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT cs.id, cs.id_residente, cs.nombre_residente, cs.id_sitio, 
                        cs.nombre_sitio, cs.id_tipoproyecto, cs.nombre_tipoproyecto,cs.monto,cs.autorizacion_status,
                        cs.pago_status, cs.pago_file, cs.status_caja, cs.comentario, cs.fecha_solicitud, 
                        cs.user_solicitud, cs.monto_anterior 
                        FROM comprobacion_solicitud cs 
                        WHERE cs.autorizacion_status = ? AND cs.pago_status = ? 
                        AND cs.id_residente = ? ORDER BY cs.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   

    public function getcomprobacionprocesolike($status,$pago,$opcion,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT cs.id,cs.id_residente,cs.nombre_residente,cs.id_sitio,cs.nombre_sitio, 
                        cs.id_tipoproyecto, cs.nombre_tipoproyecto, cs.monto,cs.autorizacion_status,cs.pago_status, 
                        cs.pago_file, cs.status_caja, cs.comentario, cs.fecha_solicitud, cs.user_solicitud 
                        FROM comprobacion_solicitud cs 
                        WHERE cs.autorizacion_status = ? 
                        AND cs.pago_status = ? 
                        AND cs.id_residente = ?",
                array($status,$pago,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }  
    }


    public function getcomprobacionprocesolikesitio($status,$pago,$opcion,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT cs.id,cs.id_residente,cs.nombre_residente,cs.id_sitio,cs.nombre_sitio, 
                        cs.id_tipoproyecto, cs.nombre_tipoproyecto, cs.monto,cs.autorizacion_status,cs.pago_status, 
                        cs.pago_file, cs.status_caja, cs.comentario, cs.fecha_solicitud, cs.user_solicitud 
                        FROM comprobacion_solicitud cs 
                        WHERE cs.autorizacion_status = ? 
                        AND cs.pago_status = ? 
                        AND $opcion like '%{$nombre}%'",
                array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }  
    }

    public function getpaginatorcomprobacionlike($status,$pago,$opcion,$nombre,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT cs.id, cs.id_residente, cs.nombre_residente, cs.id_sitio, 
                        cs.nombre_sitio, cs.id_tipoproyecto, cs.nombre_tipoproyecto,cs.monto,cs.autorizacion_status,
                        cs.pago_status, cs.pago_file, cs.status_caja, cs.comentario, cs.fecha_solicitud, 
                        cs.user_solicitud 
                        FROM comprobacion_solicitud cs 
                        WHERE cs.autorizacion_status = ? 
                        AND cs.pago_status = ? 
                        AND $opcion like '%{$nombre}%' LIMIT $offset,$no_of_records_per_page",array($status,$pago));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getpaginatorcomprobacionlikeres($status,$pago,$opcion,$nombre,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT cs.id, cs.id_residente, cs.nombre_residente, cs.id_sitio, cs.nombre_sitio, 
                        cs.id_tipoproyecto, cs.nombre_tipoproyecto,cs.monto,cs.autorizacion_status,cs.pago_status, 
                        cs.pago_file, cs.status_caja, cs.comentario, cs.fecha_solicitud, cs.user_solicitud 
                        FROM comprobacion_solicitud cs 
                        WHERE cs.autorizacion_status = ? 
                        AND cs.pago_status = ? 
                        AND cs.id_residente = ? 
                        LIMIT $offset,$no_of_records_per_page",array($status,$pago,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getallfacturas(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT id,no_factura,rfc_emisor,nombre_emisor,fecha_comprobante, total_factura, 
                        forma_pago, lugar_expedicion, status_factura 
                        FROM factura_efecticard 
                        WHERE status_factura = 0;");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getresidentecomprobacion($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT id, id_residente, nombre_residente, id_sitio, nombre_sitio, id_tipoproyecto,
                        monto, autorizacion_status, user_autorizacion,fecha_autorizacion, pago_status, pago_file,
                        pago_user, pago_fecha, status_caja, comentario, fecha_solicitud,user_solicitud,
                        status_comprobacion, monto_comprobado, monto_anterior, nombre_tipoproyecto, status_resta
                        FROM comprobacion_solicitud 
                        WHERE status_comprobacion = 0 AND id_residente = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getresidentecomprobaciondos($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT id, id_residente, nombre_residente, id_sitio, nombre_sitio, id_tipoproyecto, 
                        monto, autorizacion_status, user_autorizacion,fecha_autorizacion, pago_status, pago_file,
                        pago_user, pago_fecha, status_caja, comentario, fecha_solicitud,user_solicitud,
                        status_comprobacion, monto_comprobado, monto_anterior, nombre_tipoproyecto 
                        FROM comprobacion_solicitud 
                        WHERE status_comprobacion = 1 AND id_residente = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getfacturasenproceso($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_sitio, c.id_tipoproyecto, c.id_residente, c.fecha_del, 
                        c.monto_solicitud,c.razon_social,c.facturable, c.factura, c.servicio, c.monto_comprobacion, 
                        c.vo_bo, c.comentarios_comprobacion, c.status_comprobacion,c.fecha_user, c.user, 
                        c.factura_file, c.autorizacion, c.id_comprobacion, s.nombre,s.id_cliente,st.id_tipoproyecto,
                        t.nombre_proyecto, f.no_factura, f.nombre_emisor, f.rfc_emisor, f.forma_pago, 
                        f.lugar_expedicion, sc.nombre as nameservicio, c.comentarios_comprobacion
                        FROM comprobaciones c
                        LEFT JOIN sitios s on c.id_sitio = s.id
                        LEFT JOIN sitios_tipoproyecto st on c.id_tipoproyecto = st.id 
                        LEFT JOIN tipo_proyecto t on t.id= st.id_tipoproyecto 
                        LEFT JOIN factura_efecticard f on f.no_factura = c.factura
                        LEFT JOIN servicios_comprobaciones sc on sc.id = c.servicio 
                        WHERE id_comprobacion = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getfacturasenprocesopdf($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id as Id,  IF(c.id_sitio = 0, 'Oficina', s.nombre) AS Sitio,  
                        t.nombre_proyecto as Proyecto, c.fecha_del as Fecha, c.monto_solicitud as Monto,
                        c.monto_comprobacion as Comprobado, sc.nombre as Servicio, c.fecha_user as Auditada
                        FROM comprobaciones c
                        LEFT JOIN sitios s on c.id_sitio = s.id
                        LEFT JOIN sitios_tipoproyecto st on c.id_tipoproyecto = st.id 
                        LEFT JOIN tipo_proyecto t on t.id= st.id_tipoproyecto 
                        LEFT JOIN factura_efecticard f on f.no_factura = c.factura
                        LEFT JOIN servicios_comprobaciones sc on sc.id = c.servicio 
                        WHERE id_comprobacion = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getfacturasenprocesofacturable($id,$factura){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_sitio, c.id_tipoproyecto, c.id_residente, c.fecha_del, 
                        c.monto_solicitud,c.razon_social,c.facturable, c.factura, c.servicio, c.monto_comprobacion, 
                        c.vo_bo,c.comentarios_comprobacion,c.status_comprobacion,c.fecha_user,c.factura_file,
                        c.user, c.autorizacion,c.id_comprobacion,s.nombre,s.id_cliente,st.id_tipoproyecto,
                        t.nombre_proyecto, f.no_factura, f.nombre_emisor, f.rfc_emisor, f.forma_pago, 
                        f.lugar_expedicion, sc.nombre as nameservicio
                        FROM comprobaciones c
                        LEFT JOIN sitios s on c.id_sitio = s.id
                        LEFT JOIN sitios_tipoproyecto st on c.id_tipoproyecto = st.id 
                        LEFT JOIN tipo_proyecto t on t.id= st.id_tipoproyecto 
                        LEFT JOIN factura_efecticard f on f.no_factura = c.factura
                        LEFT JOIN servicios_comprobaciones sc on sc.id = c.servicio 
                        WHERE id_comprobacion = ? AND c.facturable = ?",array($id,$factura));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getmesfacturapanel($year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ad.id,ad.id_comprobacion, s.nombre as sitio,s.id_cliente, 
                        st.id_tipoproyecto, tp.nombre_proyecto,p.nombre, p.apellido_pa, p.apellido_ma, ad.fecha_del,
                        ad.monto_solicitud, ad.facturable, ad.razon_social,ad.fecha_user,ad.factura, 
                        ad.monto_comprobacion, 
                        YEAR(DATE(CONCAT(SUBSTRING(ad.fecha_user, 7, 4),'-',SUBSTRING(ad.fecha_user, 4, 2),'-',SUBSTRING(ad.fecha_user, 1, 2)))) AS years, 
                        MONTH(DATE(CONCAT(SUBSTRING(ad.fecha_user, 7, 4), '-', SUBSTRING(ad.fecha_user, 4, 2),'-',SUBSTRING(ad.fecha_user, 1, 2)))) AS mes, 
                        DAY(DATE(CONCAT(SUBSTRING(ad.fecha_user, 7, 4),'-',SUBSTRING(ad.fecha_user, 4, 2),'-',SUBSTRING(ad.fecha_user, 1, 2)))) AS dia
                        FROM comprobaciones ad 
                        LEFT JOIN personal_campo p on ad.id_residente = p .id
                        LEFT JOIN sitios s on ad.id_sitio = s.id
                        LEFT JOIN sitios_tipoproyecto st on st.id = ad.id_tipoproyecto
                        LEFT JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
                        WHERE ad.status_comprobacion = 1 having mes = ? and years = ?",array($month,$year));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getmesfacturapanelsitio($sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ad.id,ad.id_comprobacion, s.nombre as sitio,s.id_cliente, 
                        st.id_tipoproyecto, tp.nombre_proyecto,p.nombre, p.apellido_pa, p.apellido_ma, ad.fecha_del,
                        ad.monto_solicitud, ad.facturable, ad.razon_social,ad.fecha_user,ad.factura, 
                        ad.monto_comprobacion, 
                        YEAR(DATE(CONCAT(SUBSTRING(ad.fecha_user, 7, 4),'-',SUBSTRING(ad.fecha_user, 4, 2),'-',SUBSTRING(ad.fecha_user, 1, 2)))) AS years, 
                        MONTH(DATE(CONCAT(SUBSTRING(ad.fecha_user, 7, 4), '-', SUBSTRING(ad.fecha_user, 4, 2),'-',SUBSTRING(ad.fecha_user, 1, 2)))) AS mes, 
                        DAY(DATE(CONCAT(SUBSTRING(ad.fecha_user, 7, 4),'-',SUBSTRING(ad.fecha_user, 4, 2),'-',SUBSTRING(ad.fecha_user, 1, 2)))) AS dia
                        FROM comprobaciones ad 
                        LEFT JOIN personal_campo p on ad.id_residente = p .id
                        LEFT JOIN sitios s on ad.id_sitio = s.id
                        LEFT JOIN sitios_tipoproyecto st on st.id = ad.id_tipoproyecto
                        LEFT JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
                        WHERE ad.status_comprobacion = 1 and ad.id_tipoproyecto =?",array($sitio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getmessolicitudpanel($year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.fecha_solicitud, c.user_solicitud, c.nombre_residente, 
                        c.nombre_sitio,c.user_autorizacion,c.fecha_autorizacion,p.user_pago,p.fecha_pago,p.monto, 
                        YEAR(DATE(CONCAT(SUBSTRING(p.fecha_pago, 7, 4), '-',SUBSTRING(p.fecha_pago, 4, 2),'-',
                        SUBSTRING(p.fecha_pago, 1, 2)))) AS years, MONTH(DATE(CONCAT(SUBSTRING(p.fecha_pago, 7, 4), '-', SUBSTRING(p.fecha_pago, 4, 2),'-',SUBSTRING(p.fecha_pago, 1, 2)))) AS mes, 
                        DAY(DATE(CONCAT(SUBSTRING(p.fecha_pago, 7, 4),'-',SUBSTRING(p.fecha_pago, 4, 2),'-',
                        SUBSTRING(p.fecha_pago, 1, 2)))) AS dia
                        FROM comprobacion_solicitud c 
                        INNER JOIN comprobacion_pago p on c.id=p.id_solicitud 
                        WHERE c.pago_status = 1 having mes = ? AND years = ? ",array($month,$year));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getmessitio($year,$month,$sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_sitio, c.id_tipoproyecto, c.id_residente, c.fecha_del, 
                        c.monto_solicitud, c.razon_social, c.facturable, c.factura, c.monto_comprobacion, c.vo_bo, 
                        c.comentarios_comprobacion, c.status_comprobacion, c.fecha_user, c.user as usuario, 
                        c.id_comprobacion,
                        year(date(CONCAT(SUBSTRING(fecha_del, 7, 4),  '-', SUBSTRING(fecha_del, 4, 2), '-', SUBSTRING(fecha_del, 1, 2)))) AS years ,
                        month(date(CONCAT(SUBSTRING(fecha_del, 7, 4),  '-', SUBSTRING(fecha_del, 4, 2), '-', SUBSTRING(fecha_del, 1, 2)))) AS mes 
                        FROM comprobaciones c 
                        WHERE status_comprobacion = 1 AND c.id_tipoproyecto = ? 
                        having mes = ? AND years = ?",array($sitio,$month,$year));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }    
    }

    public function getsearchfactura($factura){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_sitio, c.id_tipoproyecto, c.id_residente, c.fecha_del, 
                        c.monto_solicitud, c.razon_social, c.facturable, c.factura,c.servicio,c.monto_comprobacion, 
                        c.vo_bo, c.status_comprobacion, c.id_comprobacion,p.nombre, p.apellido_pa, p.apellido_ma
                        FROM comprobaciones c
                        LEFT JOIN personal_campo p on p.id = c.id_residente where  c.factura like '%{$factura}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }    
    }


    public function getfacturasreporte(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id,s.nombre,t.nombre_proyecto,sc.nombre as nameservicio,c.fecha_del, 
                        c.monto_solicitud,c.razon_social,c.facturable, c.factura, c.monto_comprobacion, c.vo_bo, 
                        c.comentarios_comprobacion, c.status_comprobacion,c.fecha_user as fecha_auditoria, c.user,
                        c.id_comprobacion, CONCAT(p.nombre, ' ', p.apellido_pa, ' ', p.apellido_ma) as residente
                        FROM comprobaciones c
                        LEFT JOIN sitios s on c.id_sitio = s.id
                        LEFT JOIN sitios_tipoproyecto st on c.id_tipoproyecto = st.id 
                        LEFT JOIN tipo_proyecto t on t.id= st.id_tipoproyecto 
                        LEFT JOIN factura_efecticard f on f.no_factura = c.factura
                        LEFT JOIN servicios_comprobaciones sc on sc.id = c.servicio
                        LEFT JOIN personal_campo p on p.id=c.id_residente ");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }    
    }

    public function getiffacturaresidente($residente){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_residente, c.status_comprobacion
                        FROM comprobaciones c 
                        WHERE c.id_residente = ? AND c.status_comprobacion = 0",array($residente));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getfacturasasignada(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.id, f.no_factura,f.rfc_emisor, f.nombre_emisor, f.fecha_comprobante,
                        f.total_factura, f.forma_pago, f.lugar_expedicion, f.status_factura, p.nombre,p.apellido_pa,
                        p.apellido_ma, s.id_cliente, s.nombre as sitio
                        FROM factura_efecticard f
                        INNER JOIN comprobaciones c on c.factura = f.no_factura
                        INNER JOIN personal_campo p on p.id = c.id_residente
                        INNER JOIN sitios s on s.id = c.id_sitio 
                        WHERE f.status_factura = 1");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }    
    }

    public function getfacturasasignadaoficina(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.id, f.no_factura,f.rfc_emisor, f.nombre_emisor, f.fecha_comprobante,
                        f.total_factura, f.forma_pago, f.lugar_expedicion, f.status_factura, p.nombre,p.apellido_pa,
                        p.apellido_ma
                        FROM factura_efecticard f
                        INNER JOIN comprobaciones c on c.factura = f.no_factura
                        INNER JOIN personal_campo p on p.id = c.id_residente 
                        WHERE f.status_factura = 1 AND c.id_sitio = 0");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }    
    }

    public function getfacturasasignadaoficinados(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.id, f.no_factura,f.rfc_emisor, f.nombre_emisor, f.fecha_comprobante,
                        f.total_factura, f.forma_pago, f.lugar_expedicion, f.status_factura, p.nombre,p.apellido_pa,
                        p.apellido_ma
                        FROM factura_efecticard f
                        INNER JOIN comprobaciones c on c.factura = f.no_factura
                        INNER JOIN personal_campo p on p.id = c.id_residente 
                        WHERE f.status_factura = 0 AND c.id_sitio = 0");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }    
    }

    public function getAllfacturasback($offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM comprobacion_back ORDER BY id DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } 

    public function getAllfacturaslist($offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM factura_efecticard ORDER BY id DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } 

    public function getspecificfacturasback($offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM comprobacion_back 
                        WHERE status_back = ? ORDER BY id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getfacturacount($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.id, f.no_factura, f.rfc_emisor, f.nombre_emisor, f.fecha_comprobante, 
                        f.total_factura, f.forma_pago, f.lugar_expedicion, f.status_factura 
                        FROM factura_efecticard f 
                        WHERE no_factura like '%{$nombre}%' order by f.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getfacturapaginator($offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.id, f.no_factura, f.rfc_emisor, f.nombre_emisor, f.fecha_comprobante, 
                        f.total_factura, f.forma_pago, f.lugar_expedicion, f.status_factura 
                        FROM factura_efecticard f 
                        WHERE no_factura like '%{$id}%' order by f.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getnamecount($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.id, f.no_factura, f.rfc_emisor, f.nombre_emisor, f.fecha_comprobante, 
                        f.total_factura, f.forma_pago, f.lugar_expedicion, f.status_factura 
                        FROM factura_efecticard f 
                        WHERE nombre_emisor like '%{$nombre}%'  order by f.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getnamepaginator($offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.id, f.no_factura, f.rfc_emisor, f.nombre_emisor, f.fecha_comprobante, 
                        f.total_factura, f.forma_pago, f.lugar_expedicion, f.status_factura 
                        FROM factura_efecticard f 
                        WHERE nombre_emisor like '%{$id}%' order by f.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getdatecount($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.id, f.no_factura, f.rfc_emisor, f.nombre_emisor, f.fecha_comprobante, 
                        f.total_factura, f.forma_pago, f.lugar_expedicion, f.status_factura 
                        FROM factura_efecticard f 
                        WHERE fecha_comprobante = ? order by f.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getdatepaginator($offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.id, f.no_factura, f.rfc_emisor, f.nombre_emisor, f.fecha_comprobante, 
                        f.total_factura, f.forma_pago, f.lugar_expedicion, f.status_factura 
                        FROM factura_efecticard f 
                        WHERE fecha_comprobante = ? order by f.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getidcount($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.id, f.no_factura, f.rfc_emisor, f.nombre_emisor, f.fecha_comprobante, 
                        f.total_factura, f.forma_pago, f.lugar_expedicion, f.status_factura 
                        FROM factura_efecticard f 
                        WHERE id = ? order by f.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getidpaginator($offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.id, f.no_factura, f.rfc_emisor, f.nombre_emisor, f.fecha_comprobante, 
                        f.total_factura, f.forma_pago, f.lugar_expedicion, f.status_factura 
                        FROM factura_efecticard f 
                        WHERE id = ? order by f.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getstatuscount($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.id, f.no_factura, f.rfc_emisor, f.nombre_emisor, f.fecha_comprobante, 
                        f.total_factura, f.forma_pago, f.lugar_expedicion, f.status_factura 
                        FROM factura_efecticard f 
                        WHERE status_factura = ? order by f.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getstatuspaginator($offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT f.id, f.no_factura, f.rfc_emisor, f.nombre_emisor, f.fecha_comprobante, 
                        f.total_factura, f.forma_pago, f.lugar_expedicion, f.status_factura 
                        FROM factura_efecticard f 
                        WHERE status_factura = ? order by f.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getpersonalactivo(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM personal_campo where status_personal = 0 OR status_personal = 1 
                        ORDER BY nombre ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

}