<?php

class Application_Model_GpsSolicitudOrdenModel extends Zend_Db_Table_Abstract{
    protected $_name = 'solicitudes_pendientes';
    protected $_primary = 'id';

    public function insertsolicitudordencompra($post,$table,$id_sitio){
        try {
            $row = $this->createRow();
            $row->sitio_id = $id_sitio;
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT SOLICITUD ORDEN COMPRA

    public function insertdocumentocontizacion($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_solicitud'=>$post['id_solicitud'],
                'titulo_cotizacion'=>$post['titulo_cotizacion'],
                'documento_cotizacion'=>$urldb);
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT DOCUMENTO COTIZACION

    public function insertdocumentocontizacionpdf($post,$table,$urldb,$urldb_dos,$urldb_tres,$id_sol ){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_solicitud'=> $id_sol,
                'proveedor_opuno'=> $post['proveedor_opuno'],
                'tiempo_opuno'=> $post['tiempo_uno'],
                'alcance_opuno' => $post['alcance_opuno'],
                'costo_opuno'=> $post['costo_uno'],
                'doc_opuno'=> $urldb,
                'proveedor_opdos'=> $post['proveedor_opdos'],
                'alcance_opdos' => $post['alcance_opdos'],
                'tiempo_opdos' => $post['tiempo_dos'],
                'costo_opdos' => $post['costo_dos'],
                'doc_opdos' => $urldb_dos,
                'proveedor_optres' => $post['proveedor_optres'],
                'alcance_optres' => $post['alcance_optres'],
                'tiempo_optres'=> $post['tiempo_tres'],
                'costo_optres' => $post['costo_tres'],
                'doc_optres' => $urldb_tres
            );
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function insertdocumentocomparativa($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_solicitud'=>$post['id_solicitud'],
                'titulo_comparativa'=>$post['titulo_comparativa'],
                'documento_comparativa'=>$urldb);
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT DOCUMENTO COTIZACION


    public function insercomprobacionresidente($post,$table,$nombre,$hoy,$urldb,$urldb2,$no_fact,$razon_soc,$monto_fct,$fecha_fact){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitio'=>0,
                'id_residente'=>$post['residentes'],
                'razon_social'=>$razon_soc,
                'fecha_del'=>$fecha_fact,
                'monto_solicitud'=>$monto_fct,
                'facturable'=>$post['facturable'],
                'factura'=>$no_fact,
                'servicio'=>$post['servicio'],
                'coment_insert'=>$post['comentario'],
                'fecha_user'=>$hoy,
                'user'=>$nombre,
                'factura_file'=>$urldb,
                'autorizacion'=>$urldb2
            );
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT COMPROBACION RESIDENTE


    public function insertpagosolicitudorden($post,$table,$urldb,$hoy,$status_pago,$nombre){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_solicitud'=>$post['id_solicitud'],
                'fecha_pago'=>$hoy,
                'user_pago'=>$nombre,
                'file_pago'=>$urldb,
                'monto'=>$post['monto']);
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT DOCUMENTO COTIZACION

    public function refreshsolicitudordencompra($table,$result,$post,$id_user,$nombre_sitio,$encargado_rol, $validacion, $hoy,$fact,$name_prov,$name_user){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET proveedor_id = ?, name_proveedor = ?, id_usuario = ?, name_user = ?, fecha_requerida = ?,fecha_creacion = ? ,servicio_id = ?, importe = ?, iva = ?, retencion_isr = ?,  retencion_iva = ?, total = ?, condiciones_compra = ?, referencia = ?, descripcion = ?, nombre_sitio = ?, rol_encargado = ?, status_documentouno = ?, facturable = ? WHERE id = ?",array(
                $post['proveedor'],
                $name_prov,
                $id_user,
                $name_user,
                $post['fecha'],
                $hoy,
                $post['servicio'],
                $post['importe'],
                $post['iva'],
                $post['isr'],
                $post['ret_iva'],
                $post['total'],
                $post['compra'],
                $post['referencia'],
                $post['descripcion'],
                $nombre_sitio,
                $encargado_rol,
                $validacion,
                $fact,
                $result));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD ORDEN COMPRA



    public function refresheditsolicitudordencompra($table,$post,$id_user,$id_sitio, $nombre_sitio, $encargado_rol ){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET sitio_id =?, proveedor_id = ?,id_usuario = ? , fecha_requerida = ?, servicio_id = ?, importe = ?, iva = ?, retencion_isr = ?,  retencion_iva = ?, total = ?, condiciones_compra = ?, referencia = ?, descripcion = ?, nombre_sitio= ?, rol_encargado = ? WHERE id = ?",array(
                $id_sitio,
                $post['proveedor'],
                $id_user,
                $post['fecha'],
                $post['servicio'],
                $post['importe'],
                $post['iva'],
                $post['isr'],
                $post['ret_iva'],
                $post['total'],
                $post['compra'],
                $post['referencia'],
                $post['descripcion'],
                $nombre_sitio,
                $encargado_rol ,
                $post['id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD ORDEN COMPRA

    public function refreshstatussolicitudcompra($table,$option,$result){
        $status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET $option = ? WHERE id = ?",array(
                $status,
                $result));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD ORDEN COMPRA

    public function updatepagosolicitud($post,$table,$urldb,$hoy,$status_pago,$nombre){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_pago=?, fecha_pago=?, encargado_pago=? WHERE id = ?",array(
                $post['status_pago'],
                $hoy,
                $nombre,
                $post['id_solicitud']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD ORDEN COMPRA

    public function updatecomprobacionresidente($post,$table,$hoy,$nombre,$no_factura,$razon){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_residente=?, fecha_del=?, monto_solicitud=?, razon_social=?, facturable=?, factura =?, servicio=?, fecha_user =?, user=? WHERE id = ?",array(
                $post['residente'],
                $post['fecha'],
                $post['monto'],
                $razon,
                $post['facturable'],
                $no_factura,
                $post['servicio'],
                $hoy,
                $nombre,
                $post['ids']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD ORDEN COMPRA


    public function updatecomprobacionrcheck($post,$table,$monto){
        $status=1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET monto_comprobacion = ?, vo_bo=?, comentarios_comprobacion=?, id_sitio=?, status_comprobacion = ? WHERE id = ?",array(
                $monto,
                $post['vo_bo'],
                $post['comentario'],
                $post['sitios'],
                $status,
                $post['ids']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD ORDEN COMPRA


    public function updatecomprobacionproyecto($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_tipoproyecto = ? WHERE id = ?",array(
                $post['proyecto'],
                $post['comprobacion']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD ORDEN COMPRA


    public function updatecomprobacionrfile($post,$table,$urldb){
        $status=1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET factura_file=? WHERE id = ?",array(
                $urldb,
                $post['id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD ORDEN COMPRA


    public function updatetipoproyecto($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET tipo_proyecto=? WHERE id = ?",array(
                $post['proyecto'],
                $post['id_solicitud']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD ORDEN COMPRA


    public function Updatestatusdelete($post,$delete){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE solicitud_ordencompra SET status_delete = ? WHERE id = ?",array($delete,$post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE STATUS DELETE

    public function Updatestatusdocumento($post,$table,$hoy){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_documento = ?, validacion_userdos = ?, fecha_validaciondos = ?, fecha_validacionpago = ?, comentario = ? WHERE id = ?",array(
                $post['dato'],
                $post['id_user'],
                $hoy,
                $post['dato'],
                $post['comentario'],
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function Updatestatusdocumentoencargado($post,$table,$hoy){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_documentouno = ?, validacion_user = ?, fecha_validacion = ?, comentario = ? WHERE id = ?",array(
                $post['dato'],
                $post['id_user'],
                $hoy,
                $post['comentario'],
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL


    public function Updatestatuspagadasadireccion($post){
        $status_pago = 0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE solicitud_ordencompra SET status_pago = ? WHERE id = ?",array($status_pago,$post["solicitud"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE STATUS DELETE


    public function getcotizacionycomparativa($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sc.id_solicitud, sc.titulo_cotizacion, sc.documento_cotizacion, 
                        com.id_solicitud,com.titulo_comparativa, com.documento_comparativa 
                        FROM cotizacion_solicitudordencompra sc 
                        LEFT JOIN  comparativa_solicitudordencompra com on sc.id_solicitud = com.id_solicitud 
                        WHERE sc.id_solicitud = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getpendientesolicitud($user){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id,soc.name_proveedor, 
                        soc.fecha_requerida, soc.id_usuario, soc.name_user,soc.servicio_id, soc.importe, soc.iva,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, u.id, u.nombre, u.ap, s.nombre_servicio 
                        FROM solicitudes_pendientes soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario = ?  order by soc.id DESC",array($user));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitud($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno, 
                        soc.fecha_pago, 
                        soc.fecha_creacion,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.status_documento= 0 and status_documentouno = 1  order by soc.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudnofacturable($table,$offset,$no_of_records_per_page){
        $datos = "No Facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, 
                        soc.proveedor_id, soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, 
                        soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, 
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, 
                        soc.status_pago,soc.status_documentouno,soc.id_usuario,soc.rol_encargado,
                        soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.status_documento= 0 and status_documentouno = 1 
                        and soc.facturable = ?  
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudsearch($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva,  soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra,soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno, 
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.status_documento= 0 and status_documentouno = 1 and nombre_sitio like '%{$nombre}%'  order by soc.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudsearchnofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra,soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto,soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.status_documento= 0 and status_documentouno = 1
                        and soc.facturable = ? 
                        and nombre_sitio like '%{$nombre}%'  order by soc.id DESC LIMIT $offset,$no_of_records_per_page", array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudsearchprov($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida,soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno, soc.fecha_creacion, soc.fecha_pago,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.status_documento= 0 and status_documentouno = 1 and name_proveedor like '%{$nombre}%'  order by soc.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    // public function getusernamesolicitudsearchprov($table,$offset,$no_of_records_per_page,$nombre){
    //     $datos ="No facturable";
    //     try{
    //         $db = Zend_Db_Table::getDefaultAdapter();
    //         $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
    //                     soc.name_proveedor, soc.fecha_requerida,soc.servicio_id, soc.importe, soc.iva, 
    //                     soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
    //                     soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno,
    //                     soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
    //                     st.id_tipoproyecto, t.nombre_proyecto
    //                     FROM solicitud_ordencompra soc
    //                     LEFT JOIN usuario u on soc.id_usuario = u.id 
    //                     LEFT JOIN servicios s on s.id = soc.servicio_id
    //                     LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
    //                     LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
    //                     WHERE soc.status_documento= 0 and status_documentouno = 1 
    //                     AND soc.facturable = ?
    //                     and name_proveedor like '%{$nombre}%'  
    //                     order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($datos));
    //         $row = $qry->fetchAll();
    //         return $row;
    //         $db->closeConnection();
    //     }catch (Exception $e){
    //         echo $e;
    //     }
    // }

    public function getusernamesolicitudsearchprovnofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida,soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.status_documento= 0 and status_documentouno = 1
                        AND soc.facturable = ?
                        and name_proveedor like '%{$nombre}%'  
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudsearchservicio($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno, soc.fecha_creacion, soc.fecha_pago,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.status_documento= 0 and status_documentouno = 1 and soc.servicio_id = ? order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudsearchservicionofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        soc.facturable
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.status_documento= 0 and status_documentouno = 1 
                        and soc.servicio_id = ? 
                        AND soc.facturable =?
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($nombre,$datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudsearchidpag($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida,soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr,soc.total, soc.condiciones_compra,soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno, soc.fecha_creacion, soc.fecha_pago,
                        soc.id_usuario,soc.rol_encargado, soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.status_documento= 0 and status_documentouno = 1 and soc.id = ? order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudsearchidpagnofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida,soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr,soc.total, soc.condiciones_compra,soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado, soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.status_documento= 0 and status_documentouno = 1 
                        and soc.facturable = ?
                        and soc.id = ? order by soc.id 
                        DESC LIMIT $offset,$no_of_records_per_page",array($datos,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudsearchuser($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.name_user ,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento, soc.status_pago, soc.status_documentouno ,soc.id_usuario,
                        soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.status_documento= 0 and status_documentouno = 1 and name_user like '%{$nombre}%'  order by soc.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    // public function getusernamesolicitudsearchproveedor($table,$offset,$no_of_records_per_page,$nombre){
    //     try{
    //         $db = Zend_Db_Table::getDefaultAdapter();
    //         $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, 
    //             soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.status_pago,
    //             soc.status_documentouno ,soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
    //             s.nombre_servicio
    //             FROM solicitud_ordencompra soc
    //             LEFT JOIN usuario u on soc.id_usuario = u.id 
    //             LEFT JOIN servicios s on s.id = soc.servicio_id
    //             where soc.status_documento= 0 and status_documentouno = 1 and nombre_sitio like '%{$nombre}%'  order by soc.id DESC LIMIT $offset,$no_of_records_per_page");
    //         $row = $qry->fetchAll();
    //         return $row;
    //         $db->closeConnection();
    //     }catch (Exception $e){
    //         echo $e;
    //     }
    // }

    public function getusermissolicitudes($id,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.id_usuario, soc.proveedor_id, soc.name_proveedor, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento, soc.status_pago, soc.status_documentouno ,soc.id_usuario,
                        soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getmissolandsitio($iduser,$sitio){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.id_usuario, soc.proveedor_id, soc.name_proveedor,
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento, soc.status_pago, soc.status_documentouno ,soc.id_usuario,
                        soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.nombre_sitio like '%{$sitio}%'  order by soc.id DESC",array($iduser));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getmissolpaginatorsitio($iduser,$sitio,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.id_usuario, soc.proveedor_id, soc.name_proveedor,
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento, soc.status_pago, soc.status_documentouno ,soc.id_usuario,
                        soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.nombre_sitio like '%{$sitio}%'  order by soc.id DESC
                        LIMIT $offset,$no_of_records_per_page",array($iduser));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getmissolandidsol($iduser,$id){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.id_usuario, soc.proveedor_id, soc.name_proveedor,
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento, soc.status_pago, soc.status_documentouno ,soc.id_usuario,
                        soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.id = ? order by soc.id DESC",array($iduser,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getmispaginatoridsol($iduser,$id,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.id_usuario, soc.proveedor_id, soc.name_proveedor,
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento, soc.status_pago, soc.status_documentouno ,soc.id_usuario,
                        soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.id = ? order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($iduser,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


     public function getmissolandproveedor($iduser,$proveedor){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.id_usuario, soc.proveedor_id, soc.name_proveedor,
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento, soc.status_pago, soc.status_documentouno ,soc.id_usuario,
                        soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.name_proveedor like '%{$proveedor}%'  order by soc.id DESC",array($iduser));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getmissolpaginatorproveedor($iduser,$proveedor,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.id_usuario, soc.proveedor_id, soc.name_proveedor,
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento, soc.status_pago, soc.status_documentouno ,soc.id_usuario,
                        soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.name_proveedor like '%{$proveedor}%'  order by soc.id DESC
                        LIMIT $offset,$no_of_records_per_page",array($iduser));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudjefe($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, 
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.rol_encargado,soc.delete_status,u.id, u.nombre,
                        u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.rol_encargado = 8 order by soc.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudroluserprocesocountall($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.rol_encargado, u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 0 
                        order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocount($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.rol_encargado, 
                        u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 0  
                        order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocountenc($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.name_proveedor,soc.servicio_id, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.rol_encargado, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 0 AND nombre_sitio like '%{$nombre}%'  order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoprove($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.rol_encargado, u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 0 AND name_proveedor like '%{$nombre}%'  order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoid($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.rol_encargado, u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 0 AND soc.id = ?  
                        order by soc.id DESC",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesorolservicio($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor,soc.servicio_id, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.rol_encargado, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 0 AND soc.servicio_id = ?  
                        order by soc.id DESC",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocountsitio($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.rol_encargado, u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 0 
                        AND nombre_sitio like '%{$nombre}%'  order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocountacept($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.rol_encargado, 
                        soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id=soc.servicio_id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago =0 
                        order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocountaceptenc($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor,soc.servicio_id, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.rol_encargado, soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id=soc.servicio_id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 
                        AND soc.status_pago !=1 and nombre_sitio like '%{$nombre}%'
                        order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoaceptencprov($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor,soc.servicio_id, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.rol_encargado, soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id=soc.servicio_id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago !=1 
                        AND name_proveedor like '%{$nombre}%'order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoaceptencidrol($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor,soc.servicio_id, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.rol_encargado, soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id=soc.servicio_id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago !=1 
                        AND soc.id = ? order by soc.id DESC",array($id, $nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoaceptencidserv($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor,soc.servicio_id, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.rol_encargado, soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id=soc.servicio_id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago !=1 
                        AND soc.servicio_id = ? order by soc.id DESC",array($id, $nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocountrech($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.rol_encargado, u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 2  
                        order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocountrechenc($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.rol_encargado, u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 2 
                        AND nombre_sitio like '%{$nombre}%'  order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocountrechencprov($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.servicio_id, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.rol_encargado, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 2 
                        AND name_proveedor like '%{$nombre}%'  order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocountrecheids($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.servicio_id, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.rol_encargado, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 2 
                        AND soc.id = ? order by soc.id DESC",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocountrecheidserv($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.servicio_id, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.rol_encargado, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 2 
                        AND soc.id = ? order by soc.servicio_id DESC",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocountrechsitio($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.rol_encargado, u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 2 
                        AND nombre_sitio like '%{$nombre}%'  order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocountaceptpago($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.rol_encargado, 
                        soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id=soc.servicio_id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 
                        AND soc.status_pago =1 order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocountaceptpagoenc($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, 
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno,soc.id_usuario,soc.delete_status,soc.rol_encargado,soc.status_pago,
                        u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id=soc.servicio_id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago =1 
                        AND nombre_sitio like '%{$nombre}%' order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocountaceptpagoencprov($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.servicio_id, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.rol_encargado, soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id=soc.servicio_id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago =1 
                        AND name_proveedor like '%{$nombre}%' order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesocountaceptpagoencserv($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.servicio_id, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.rol_encargado, soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id=soc.servicio_id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago =1 
                        AND soc.servicio_id = ? order by soc.id DESC",array($id, $nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoacptpago($table,$offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago =1  
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoacptpagoenc($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago =1 
                        AND nombre_sitio like '%{$nombre}%'  order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoacptpagoencprov($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago =1 
                        AND name_proveedor like '%{$nombre}%'  order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoacptpagoencid($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago =1 
                        AND soc.id = ?  order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoacptpagoencserv($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago =1 
                        AND soc.servicio_id= ?  order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudroluserproceso($table,$offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 0  order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }
    public function getusernamesolicitudroluserprocesoenc($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 0 and nombre_sitio 
                        like '%{$nombre}%' order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoprov($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 0 and name_proveedor 
                        like '%{$nombre}%' order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoids($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 0 and soc.id = ? 
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id, $nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocidservicio($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 0 and soc.servicio_id = ? 
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id, $nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesositio($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 0 AND nombre_sitio 
                        like '%{$nombre}%'  order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    // public function getusernamesolicitudroluserprocesoacpt($table,$offset,$no_of_records_per_page,$id){
    //     try{
    //         $db = Zend_Db_Table::getDefaultAdapter();
    //         $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida, soc.servicio_id,
    //                                 soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.rol_encargado, soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
    //                             FROM solicitud_ordencompra soc
    //                             LEFT JOIN usuario u on soc.id_usuario = u.id 
    //                             LEFT JOIN servicios s on s.id=soc.servicio_id where soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago =0  order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
    //         $row = $qry->fetchAll();
    //         return $row;
    //         $db->closeConnection();
    //     }catch (Exception $e){
    //         echo $e;
    //     }
    // }

    public function getusernamesolicitudroluserprocesoacpt($table,$offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago !=1  
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoacptenc($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago !=1 
                        AND nombre_sitio like '%{$nombre}%'  order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoacptencprov($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago !=1 
                        AND name_proveedor like '%{$nombre}%'  order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoacptencidrol($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago !=1 
                        AND soc.id = ? order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesoacptencidservi($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 1 AND soc.status_pago !=1 
                        AND soc.servicio_id = ? order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudroluserprocesorech($table,$offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 2 order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesorechenc($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 2 and nombre_sitio 
                        like '%{$nombre}%' order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudroluserprocesorechencprov($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 2 and name_proveedor 
                        like '%{$nombre}%' order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesorechenid($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 2 and soc.id = ? 
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id, $nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesorechenidserv($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 2 and soc.servicio_id = ? 
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id, $nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudroluserprocesorechsitio($table,$offset,$no_of_records_per_page,$id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status,soc.rol_encargado,soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio,soc.status_pago, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.rol_encargado = ? AND soc.status_documentouno = 2 AND nombre_sitio 
                        like '%{$nombre}%' order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }    

    public function getdetailsolicitud($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.fecha_creacion, soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, 
                        soc.retencion_iva, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio,soc.comentario,soc.status_documento,soc.status_documentouno,soc.id_usuario,
                        soc.fecha_validacion,s.nombre_servicio,soc.fecha_validaciondos,soc.created_at,
                        soc.status_pago,u.id, u.nombre, u.ap,p.nombre_prov,p.tarjeta
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN proveedor p on p.id=soc.proveedor_id
                        LEFT JOIN servicios s on s.id=soc.servicio_id 
                        WHERE soc.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        } 
    }


    public function getdetailsolicitudvalidacion($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud,soc.id_usuario, soc.validacion_user, 
                        soc.fecha_validacion,u.id, u.nombre, u.ap 
                        FROM solicitud_ordencompra soc LEFT JOIN usuario u on u.id=soc.validacion_user 
                        where soc.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        } 
    }

    public function getdetailsolicitudvalidacionjefe($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud,soc.id_usuario, soc.validacion_userdos, 
                        soc.fecha_validaciondos,u.id, u.nombre, u.ap 
                        FROM solicitud_ordencompra soc LEFT JOIN usuario u on u.id=soc.validacion_userdos 
                        WHERE soc.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        } 
    }

    public function getdetailsolicitudpagos($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud,soc.id_usuario, soc.validacion_userdos, 
                        soc.fecha_validaciondos,u.id, u.nombre, u.ap 
                        FROM solicitud_ordencompra soc LEFT JOIN usuario u on u.id=soc.validacion_userdos 
                        WHERE soc.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        } 
    }


    public function Getcountsolicituddelete(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion, soc.status_documento, soc.id_usuario,soc.delete_status, 
                        u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.delete_status =1 order by id desc");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicituddelete($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion, soc.status_documento, soc.id_usuario,soc.delete_status, 
                        u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.delete_status = 1  order by soc.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcount(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, 
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_pago, 
                        soc.fecha_creacion,
                        soc.status_documentouno ,soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento= 0 and status_documentouno = 1  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsolicitudnofacturable(){
        $datos = "No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, 
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, soc.facturable,
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento= 0 and status_documentouno = 1 
                        and soc.facturable = ? order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountsearch($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, 
                        soc.fecha_creacion, soc.fecha_pago,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.nombre_sitio,
                        soc.status_documentouno ,soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento= 0 and status_documentouno = 1 AND nombre_sitio 
                        like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountsearchnofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr,soc.total,soc.condiciones_compra, 
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.nombre_sitio,
                        soc.status_documentouno ,soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, 
                        u.nombre, u.ap, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento= 0 and status_documentouno = 1 
                        AND soc.facturable = ?
                        AND nombre_sitio  like '%{$nombre}%'  order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountsearchproveedor($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.name_proveedor, soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, soc.fecha_creacion, soc.fecha_pago, 
                        soc.status_documento, soc.nombre_sitio, soc.status_documentouno ,soc.id_usuario,
                        soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento= 0 and status_documentouno = 1 AND name_proveedor 
                        like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountsearchproveedornofact($nombre){
        $datos="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.name_proveedor, soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento, soc.nombre_sitio, soc.status_documentouno ,soc.id_usuario,
                        soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento= 0 and status_documentouno = 1 
                        AND soc.facturable = ?
                        AND name_proveedor  like '%{$nombre}%'  order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountsearchid($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.name_proveedor, soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documento, soc.nombre_sitio, soc.status_documentouno ,soc.id_usuario,
                        soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento= 0 and status_documentouno = 1 AND soc.id = ? 
                        order by soc.id DESC", array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountsearchidnofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.name_proveedor, soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento, soc.nombre_sitio, soc.status_documentouno ,soc.id_usuario,
                        soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento= 0 and status_documentouno = 1 AND soc.id = ? 
                        and soc.facturable =?
                        order by soc.id DESC", array($nombre,$datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountsearchuser($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.name_proveedor,soc.name_user, soc.importe,soc.iva, soc.retencion_isr,
                        soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documento, soc.nombre_sitio, soc.status_documentouno,soc.id_usuario,
                        soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento= 0 and status_documentouno = 1 AND soc.name_user 
                        like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudsearchusr($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida,soc.servicio_id, soc.name_user,soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno, soc.fecha_creacion, soc.fecha_pago,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.status_documento= 0 and status_documentouno = 1 and name_user like '%{$nombre}%'  order by soc.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountsearchusernofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.name_proveedor,soc.name_user, soc.importe,soc.iva, soc.retencion_isr,
                        soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento, soc.nombre_sitio, soc.status_documentouno,soc.id_usuario,
                        soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento= 0 
                        and status_documentouno = 1 
                        and soc.facturable = ?
                        AND soc.name_user  like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountsearchservicio($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.name_proveedor, soc.name_user, soc.servicio_id ,soc.importe, soc.iva,
                        soc.retencion_isr, soc.total,  soc.condiciones_compra, soc.referencia, soc.descripcion, soc.fecha_creacion, soc.fecha_pago,
                        soc.nombre_sitio, soc.status_documento, soc.nombre_sitio, soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento= 0 and status_documentouno = 1 AND soc.servicio_id =? 
                        order by soc.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountsearchservicionofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.name_proveedor, soc.name_user, soc.servicio_id ,soc.importe, soc.iva,
                        soc.retencion_isr, soc.total,  soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.nombre_sitio, soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento= 0 and status_documentouno = 1
                        and soc.facturable = ?
                        AND soc.servicio_id =? 
                        order by soc.id DESC",array($datos,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountjefe(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.rol_encargado,soc.delete_status,u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.rol_encargado = 8 order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountjefesearch($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, 
                        soc.facturable ,u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND nombre_sitio  like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountjefesearchmgr($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, 
                        soc.facturable ,u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 
                        AND nombre_sitio  like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountjefesearchclavos($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, 
                        soc.facturable ,u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        AND nombre_sitio  like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountjefesearchnofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr,soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, 
                        soc.facturable ,u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos,
                        soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  
                        AND soc.status_pago != 1 
                        AND soc.facturable = ?
                        AND nombre_sitio like '%{$nombre}%' order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountjefesearchprov($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND name_proveedor 
                        like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountjefesearchprovmgr($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 
                        AND name_proveedor 
                        like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountjefesearchprovclavos($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        AND name_proveedor 
                        like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountjefesearchprovnofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr,soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status,soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  
                        AND soc.facturable = ?
                        AND soc.status_pago != 1 AND name_proveedor like '%{$nombre}%' 
                        order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountjefesearchuser($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND name_user  like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountjefesearchusermgr($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 
                        AND name_user  like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountjefesearchuserclavos($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        AND name_user  like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountjefesearchusernofacturable($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status,soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  
                        AND soc.facturable  = ?
                        AND soc.status_pago != 1 AND name_user like '%{$nombre}%' 
                        order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountjefesearchservicio($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.servicio_id,soc.name_proveedor,  soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.status_pago, soc.facturable ,u.id, u.nombre, u.ap, s.nombre_servicio, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 AND soc.servicio_id = ? 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        order by soc.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountjefesearchserviciomgr($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.servicio_id,soc.name_proveedor,  soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.status_pago, soc.facturable ,u.id, u.nombre, u.ap, s.nombre_servicio, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 AND soc.servicio_id = ? 
                        order by soc.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountjefesearchservicioclavos($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.servicio_id,soc.name_proveedor, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_pago, soc.facturable ,u.id, u.nombre, u.ap, s.nombre_servicio, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 AND soc.servicio_id = ? 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        order by soc.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountjefesearchserviciofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr,soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.servicio_id,soc.name_proveedor, soc.fecha_creacion, soc.fecha_pago, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.status_pago, soc.facturable ,u.id, u.nombre, u.ap, s.nombre_servicio, 
                        soc.fecha_validaciondos, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 AND soc.servicio_id = ? 
                        AND soc.facturable = ?
                        order by soc.id DESC",array($nombre,$datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountjefesearchid($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status,soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 AND soc.id = ?
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        order by soc.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


     public function getusernamesolicitudcountjefesearchidmgr($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status,soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 AND soc.id = ?
                        order by soc.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountjefesearchidclavos($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status,soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  AND soc.status_pago != 1 AND soc.id = ?
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        order by soc.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountjefesearchidnofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status,soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento= 1  
                        AND soc.status_pago != 1 
                        AND soc.id = ?
                        AND soc.facturable = ?
                        order by soc.id DESC",array($nombre,$datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountacept(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia,soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_pago, 
                        soc.fecha_creacion, 
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento = 1 AND soc.status_pago !=1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptmgr(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia,soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_pago, 
                        soc.fecha_creacion, 
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento = 1 AND soc.status_pago !=1 
                        order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptclavos(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia,soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento = 1 AND soc.status_pago !=1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountaceptfacturable(){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr,
                        soc.total, soc.condiciones_compra, soc.referencia,soc.descripcion,
                        soc.nombre_sitio, soc.status_documento,soc.status_documentouno ,soc.id_usuario,
                        soc.delete_status, soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.status_documento = 1 AND soc.status_pago !=1 AND soc.facturable = ?order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountaceptsitio($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago !=1 AND nombre_sitio like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptproveedor($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable,
                        u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago !=1 
                        AND soc.name_proveedor like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudacept($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, 
                        soc.proveedor_id,soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, 
                        soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, 
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, 
                        soc.fecha_pago, soc.fecha_creacion,
                        soc.status_pago, soc.status_documentouno,soc.id_usuario,soc.rol_encargado,
                        soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.status_documento = 1 AND soc.status_pago !=1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptmgr($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, 
                        soc.proveedor_id,soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, 
                        soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, 
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, 
                        soc.fecha_pago, soc.fecha_creacion,
                        soc.status_pago, soc.status_documentouno,soc.id_usuario,soc.rol_encargado,
                        soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.status_documento = 1 AND soc.status_pago !=1 
                        ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptclavos($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, 
                        soc.proveedor_id,soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, 
                        soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, soc.fecha_creacion, soc.fecha_pago,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, 
                        soc.status_pago, soc.status_documentouno,soc.id_usuario,soc.rol_encargado,
                        soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.status_documento = 1 AND soc.status_pago !=1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptnofact($table,$offset,$no_of_records_per_page){
        $datos = "No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, 
                        soc.proveedor_id,soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, 
                        soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, 
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, 
                        soc.status_pago, soc.status_documentouno,soc.id_usuario,soc.rol_encargado,
                        soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio, soc.facturable,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.status_documento = 1 AND soc.status_pago !=1 
                        AND soc.facturable = ?
                        ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC 
                        LIMIT $offset,$no_of_records_per_page",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptsitio($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND nombre_sitio like '%{$nombre}%' ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC  
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptsitiomgr($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND nombre_sitio like '%{$nombre}%' ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC  
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptsitioclavos($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75) 
                        AND nombre_sitio like '%{$nombre}%' ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC  
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptsitionofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND soc.facturable = ?
                        AND nombre_sitio like '%{$nombre}%' order by soc.fecha_validaciondos 
                        ASC LIMIT $offset,$no_of_records_per_page",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptprov($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND name_proveedor like '%{$nombre}%' ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptprovmgr($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND name_proveedor like '%{$nombre}%' ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptprovclavos($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75) 
                        AND name_proveedor like '%{$nombre}%' ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptprovnofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  
                        AND soc.status_pago != 1 
                        AND soc.facturable = ?
                        AND name_proveedor like '%{$nombre}%'
                        order by soc.fecha_validaciondos ASC 
                        LIMIT $offset,$no_of_records_per_page",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptuser($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra,soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND name_user like '%{$nombre}%' ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptusermgr($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra,soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND name_user like '%{$nombre}%' ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptuserclavos($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra,soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        AND name_user like '%{$nombre}%' ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptusernofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="no facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra,soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND soc.facturable = ?
                        AND name_user like '%{$nombre}%' order by soc.fecha_validaciondos ASC 
                        LIMIT $offset,$no_of_records_per_page",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptid($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND soc.id =? ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC
                        LIMIT $offset,$no_of_records_per_page",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptidmgr($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND soc.id =? ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC
                        LIMIT $offset,$no_of_records_per_page",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptidclavos($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        AND soc.id =? ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC
                        LIMIT $offset,$no_of_records_per_page",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptidnofacturable($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos,soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND soc.id =? 
                        AND soc.facturable =?
                        order by soc.fecha_validaciondos ASC 
                        LIMIT $offset,$no_of_records_per_page",array($nombre,$datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptservicio($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND soc.servicio_id =? ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC
                        LIMIT $offset,$no_of_records_per_page",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptserviciomgr($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND soc.servicio_id =? ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC
                        LIMIT $offset,$no_of_records_per_page",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptservicioclavos($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        AND soc.servicio_id =? ORDER BY STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC
                        LIMIT $offset,$no_of_records_per_page",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptservicionofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago != 1 
                        AND soc.servicio_id =? 
                        AND soc.facturable = ?
                        order by soc.fecha_validaciondos ASC 
                        LIMIT $offset,$no_of_records_per_page",array($nombre,$datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    // public function getusernamesolicitudaceptsitio($table,$offset,$no_of_records_per_page,$nombre){
    //     try{
    //         $db = Zend_Db_Table::getDefaultAdapter();
    //         $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida, soc.servicio_id,
    //                                 soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable ,u.id, u.nombre, u.ap, s.nombre_servicio, soc.fecha_validaciondos
    //                                     FROM solicitud_ordencompra soc
    //                                     LEFT JOIN usuario u on soc.id_usuario = u.id 
    //                                     LEFT JOIN servicios s on s.id= soc.servicio_id where  soc.status_documento= 1  AND soc.status_pago != 1 AND nombre_sitio like '%{$nombre}%' order by soc.fecha_validaciondos ASC LIMIT $offset,$no_of_records_per_page");
    //         $row = $qry->fetchAll();
    //         return $row;
    //         $db->closeConnection();
    //     }catch (Exception $e){
    //         echo $e;
    //     }
    // }

    public function getusernamesolicitudcountaceptpago(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_pago, 
                        soc.fecha_creacion,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago ,u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1  
                        order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptpagonofact(){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago ,u.id, 
                        u.nombre, u.ap, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1  
                        AND facturable = ?
                        order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptpagositio($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago,
                        u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75 
                        AND nombre_sitio like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptpagositioclavos($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago,
                        u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75) 
                        AND nombre_sitio like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptpagositionofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr,soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago,
                        u.id, u.nombre, u.ap, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1 
                        AND nombre_sitio like '%{$nombre}%' 
                        AND soc.facturable = ? order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountaceptpagoprov($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida, 
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago ,u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND name_proveedor like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptpagoprovclavos($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida, 
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago ,u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        AND name_proveedor like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptpagoprovnofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id,soc.proveedor_id, soc.fecha_requerida, 
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr,soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago ,u.id, 
                        u.nombre, u.ap, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1 
                        AND name_proveedor like '%{$nombre}%'  
                        AND soc.facturable = ? order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountaceptpagoid($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago,
                        u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75 
                        AND soc.id=? order by soc.id DESC", array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptpagoidclavos($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago,
                        u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        AND soc.id=? order by soc.id DESC", array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptpagoidnofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago,
                        u.id, u.nombre, u.ap, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1 
                        AND soc.id=? AND soc.facturable =? order by soc.id DESC", array($nombre,$datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountaceptpagouser($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago ,u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND name_user like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountaceptpagouserclavos($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago ,u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75) 
                        AND name_user like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptpagousernofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe,soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago ,u.id, 
                        u.nombre, u.ap,soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1 
                        AND name_user like '%{$nombre}%' AND soc.facturable =?  
                        order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountaceptpagoservicio($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, soc.fecha_creacion, soc.fecha_pago,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor,soc.servicio_id, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.status_pago ,u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75 
                        AND soc.servicio_id = ?  order by soc.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptpagoservicioclavos($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra, soc.fecha_creacion, soc.fecha_pago,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor,soc.servicio_id, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.status_pago ,u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        AND soc.servicio_id = ?  order by soc.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptpagoservicionofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr,soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor,soc.servicio_id, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, 
                        soc.status_pago ,u.id, u.nombre, u.ap, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1 
                        AND soc.servicio_id = ? AND soc.facturable =?  
                        order by soc.id DESC",array($nombre,$datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptpago($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.fecha_pago, soc.fecha_creacion,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap, 
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        order by STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptpagonofact($table,$offset,$no_of_records_per_page){
        $datos = "No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  
                        AND soc.status_pago = 1 AND soc.facturable = ?
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptpagositio($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno, 
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND nombre_sitio like '%{$nombre}%' order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptpagositioclavos($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno, 
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        AND nombre_sitio like '%{$nombre}%' order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptpagositionofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos = "No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno, 
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1
                        AND soc.facturable =?
                        AND nombre_sitio like '%{$nombre}%' order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }



    public function getusernamesolicitudaceptpagoprov($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND name_proveedor like '%{$nombre}%' order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptpagoprovclavos($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75) 
                        AND name_proveedor like '%{$nombre}%' order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptpagoprovnofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, soc.fecha_validaciondos,
                        soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        AND name_proveedor like '%{$nombre}%' 
                        AND soc.facturable = ? order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }



    public function getusernamesolicitudaceptpagouser($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND name_user like '%{$nombre}%' order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptpagouserclavos($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        AND name_user like '%{$nombre}%' order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptpagousernofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        AND name_user like '%{$nombre}%' 
                        AND soc.facturable =?
                        order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptpagoserviciop($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND soc.servicio_id = ? order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptpagoserviciopclavos($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)   
                        AND soc.servicio_id = ? order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptpagoserviciopnofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, soc.fecha_validaciondos,
                        soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        AND soc.servicio_id = ? 
                        AND soc.facturable =? order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($nombre,$datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptpagoid($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        AND soc.id = ? order by soc.id DESC LIMIT $offset,$no_of_records_per_page", array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptpagoidclavos($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        AND soc.id = ? order by soc.id DESC LIMIT $offset,$no_of_records_per_page", array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudaceptpagoidnofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, 
                        soc.fecha_validaciondos, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        AND soc.id = ? 
                        AND soc.facturable = ?
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page", array($nombre,$datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcancel(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_pago, 
                        soc.fecha_creacion,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento= 2 OR soc.status_documento = 3 order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcancelfacturable(){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,soc.facturable,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento= 2 OR soc.status_documento = 3 
                        order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountcancelsitio($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 AND nombre_sitio 
                        like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcancelsitionofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr,soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, u.id, u.nombre, u.ap,
                        soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 
                        AND nombre_sitio like '%{$nombre}%'  
                        AND soc.facturable = ? order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcancelprov($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 AND name_proveedor 
                        like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcancelprovnofact($nombre){
        $datos = "No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 
                        AND name_proveedor  like '%{$nombre}%'  
                        AND soc.facturable = ?
                        order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcanceluser($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 AND name_user 
                        like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcancelusernofact($nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total,soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, u.id, u.nombre, u.ap,
                        soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 
                        AND name_user like '%{$nombre}%'  
                        AND soc.facturable =? order by soc.id DESC",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcancelservicio($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.servicio_id, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, u.id, 
                        u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 AND soc.servicio_id = ? 
                        order by soc.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcancelservicionofact($nombre){
        $datos = "No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr,soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.servicio_id, 
                        soc.status_documento,soc.status_documentouno ,soc.id_usuario,soc.delete_status, u.id, 
                        u.nombre, u.ap, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 AND soc.servicio_id = ? 
                        AND soc.facturable =?
                        order by soc.id DESC",array($nombre,$datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }



    public function getusernamesolicitudcountcancelid($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.fecha_creacion, soc.fecha_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 AND soc.id = ?  
                        order by soc.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcancelidnofact($nombre){
        $datos = "No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr,soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, u.id, u.nombre, u.ap,
                        soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 AND soc.id = ?  
                        AND soc.facturable =?
                        order by soc.id DESC",array($nombre,$datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcancel($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.fecha_pago, soc.fecha_creacion,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap, 
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE  soc.status_documento= 2 OR soc.status_documento = 3 order by STR_TO_DATE(soc.fecha_validaciondos,'%d-%m-%Y') DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcancelfact($table,$offset,$no_of_records_per_page){
        $datos="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE  soc.status_documento= 2 OR soc.status_documento = 3 and soc.facturable =?
                        order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcancelsitio($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion, soc.fecha_creacion, soc.fecha_pago,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 AND nombre_sitio 
                        like '%{$nombre}%' order by soc.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcancelsitionofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 
                        AND nombre_sitio like '%{$nombre}%' 
                        AND soc.facturable = ?
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcancelprov($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion, soc.fecha_creacion, soc.fecha_pago,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 AND name_proveedor 
                        like '%{$nombre}%' order by soc.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcancelprovnofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos = "No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 
                        AND soc.facturable = ?
                        AND name_proveedor like '%{$nombre}%' 
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcanceluser($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 AND name_user 
                        like '%{$nombre}%' order by soc.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcancelusernofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 
                        AND name_user like '%{$nombre}%' 
                        AND soc.facturable = ?
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcancelservicio($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 AND soc.servicio_id = ? 
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcancelservicionofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos ="No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 AND soc.servicio_id = ? 
                        AND soc.facturable = ?
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($nombre,$datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcancelid($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.fecha_creacion, soc.fecha_pago,
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 AND soc.id = ? 
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcancelidnofact($table,$offset,$no_of_records_per_page,$nombre){
        $datos = "No facturable";
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto, soc.facturable
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.delete_status =0 AND soc.status_documento= 2 AND soc.id = ? 
                        AND soc.facturable = ?
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($nombre,$datos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }



    public function getusernamesolicitudcountcoordinador($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, soc.total,
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento,soc.status_documentouno,soc.delete_status, u.id, u.nombre, u.ap, 
                        s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.status_documento = 0 and status_documentouno=0  
                        order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinador($id,$table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.id_usuario= ? and soc.status_documento = 0 and status_documentouno=0  
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcoordinadorauditoria($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento,soc.status_documentouno,soc.delete_status, u.id, u.nombre, 
                        u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.status_documentouno != 1",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcoordinadorauditoriacoord($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor,
                        soc.servicio_id, soc.status_documento,soc.status_documentouno,soc.delete_status, u.id, 
                        u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.status_documentouno != 1 AND nombre_sitio 
                        like '%{$nombre}%'",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcoordinadorauditoriacoordprov($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia,soc.descripcion,soc.nombre_sitio,soc.name_proveedor,
                        soc.servicio_id, soc.status_documento,soc.status_documentouno,soc.delete_status, u.id, 
                        u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id 
                        WHERE soc.id_usuario= ? and soc.status_documentouno != 1 AND name_proveedor 
                        like '%{$nombre}%'",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcoordinadorauditoriacoordidsol($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, soc.total,
                        soc.condiciones_compra, soc.referencia,soc.descripcion,soc.nombre_sitio,soc.name_proveedor,
                        soc.servicio_id, soc.status_documento,soc.status_documentouno,soc.delete_status, u.id, 
                        u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id 
                        WHERE soc.id_usuario= ? and soc.status_documentouno != 1 
                        AND soc.id = ?",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcoordinadorauditoriacoordidserv($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor,
                        soc.servicio_id, soc.status_documento,soc.status_documentouno,soc.delete_status, u.id, 
                        u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.status_documentouno != 1 
                        AND soc.servicio_id = ?",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinadorauditoria($id,$table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 2 order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinadorauditoriados($id,$table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida,  soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 2 AND nombre_sitio 
                        like '%{$nombre}%' order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinadorauditoriadosprov($id,$table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 2 AND name_proveedor 
                        like '%{$nombre}%' order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinadorauditoriadosidsol($id,$table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 2 AND soc.id = ? 
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinadorauditoriadosidserv($id,$table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 2 AND soc.servicio_id = ? 
                        order by soc.servicio_id DESC LIMIT $offset,$no_of_records_per_page",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcoordinadoraceptadas($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento,soc.status_documentouno,soc.delete_status,soc.status_pago ,u.id, 
                        u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 
                        AND soc.status_pago = 0",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcoordinadoraceptadascoord($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, soc.total,
                        soc.condiciones_compra, soc.referencia,soc.descripcion,soc.nombre_sitio,soc.name_proveedor,
                        soc.servicio_id, soc.status_documento,soc.status_documentouno,soc.delete_status,
                        soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago = 0 
                        AND nombre_sitio like '%{$nombre}%'",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountcoordinadoraceptadascoordprov($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total,
                        soc.condiciones_compra,soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor,
                        soc.servicio_id, soc.status_documento,soc.status_documentouno,soc.delete_status,
                        soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago = 0 
                        AND name_proveedor like '%{$nombre}%'",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcoordinadoraceptadascoordidsol($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia,soc.descripcion,soc.nombre_sitio,soc.name_proveedor,
                        soc.servicio_id, soc.status_documento,soc.status_documentouno,soc.delete_status,
                        soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago = 0 
                        AND soc.id = ? ",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcoordinadoraceptadascoordidserv($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra,soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor,
                        soc.servicio_id, soc.status_documento,soc.status_documentouno,soc.delete_status,
                        soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id 
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago = 0 
                        AND soc.servicio_id = ? ",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinadoraceptadas($id,$table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,
                        s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago !=1 
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinadoraceptadascoord($id,$table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,
                        soc.status_documentouno ,soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, 
                        u.nombre, u.ap,s.nombre_servicio, st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago !=1 
                        AND nombre_sitio like '%{$nombre}%' order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinadoraceptadascoordprov($id,$table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.id_usuario= ? AND soc.status_documentouno = 1 
                        AND soc.status_pago !=1 AND name_proveedor like '%{$nombre}%' order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinadoraceptadascoordidsol($id,$table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago !=1 
                        AND soc.id = ? order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }




    public function getusernamesolicitudcoordinadoraceptadascoordidserv($id,$table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr,soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.id_usuario= ? AND soc.status_documentouno = 1 AND soc.status_pago !=1 
                        AND soc.servicio_id = ? order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcoordinadorpagadas($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento,soc.status_documentouno,soc.delete_status,soc.status_pago ,u.id, 
                        u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id 
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 
                        AND soc.status_pago = 1",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcoordinadorpagadascoord($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia,soc.descripcion,soc.nombre_sitio,soc.name_proveedor,
                        soc.servicio_id, soc.status_documento,soc.status_documentouno,soc.delete_status,
                        soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id 
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago = 1 
                        AND nombre_sitio like '%{$nombre}%'",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcoordinadorpagadascoordprov($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia,soc.descripcion,soc.nombre_sitio,soc.name_proveedor,
                        soc.servicio_id, soc.status_documento,soc.status_documentouno,soc.delete_status,
                        soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id 
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago = 1 
                        AND name_proveedor like '%{$nombre}%'",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcoordinadorpagadascoordidsol($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia,soc.descripcion,soc.nombre_sitio,soc.name_proveedor,
                        soc.servicio_id, soc.status_documento,soc.status_documentouno,soc.delete_status,
                        soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id 
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago = 1 
                        AND soc.id = ? ",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountcoordinadorpagadascoordidserv($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia,soc.descripcion,soc.nombre_sitio,soc.name_proveedor,
                        soc.servicio_id, soc.status_documento,soc.status_documentouno,soc.delete_status,
                        soc.status_pago ,u.id, u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id 
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago = 1 
                        AND soc.servicio_id = ? ",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinadorpagadas($id,$table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 
                        AND soc.status_pago = 1 order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinadorpagadascoord($id,$table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago, soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago = 1 
                        AND nombre_sitio like '%{$nombre}%' order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinadorpagadascoordprov($id,$table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago = 1 
                        AND name_proveedor like '%{$nombre}%' order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinadorpagadascoordidsol($id,$table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago = 1 
                        AND soc.id =? order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcoordinadorpagadascoordidserv($id,$table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto
                        WHERE soc.id_usuario= ? and soc.status_documentouno = 1 AND soc.status_pago = 1 
                        AND soc.servicio_id =? order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptandpay(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,soc.id_usuario,
                        soc.status_documentouno ,soc.delete_status, soc.status_pago ,u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 
                        AND soc.status_pago = 1  
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcountaceptandpayclavos(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,soc.id_usuario,
                        soc.status_documentouno ,soc.delete_status, soc.status_pago ,u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 
                        AND soc.status_pago = 1  
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcountaceptandpaysitio($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,soc.id_usuario,
                        soc.status_documentouno ,soc.delete_status, soc.status_pago ,u.id, u.nombre, u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1 AND soc.status_pago = 1 
                        AND nombre_sitio like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptandpay($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida,soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  
                        AND soc.status_pago = 1 
                        AND soc.proveedor_id != 74 AND soc.proveedor_id != 75
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptandpayclavos($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida,soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre, u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto, soc.facturable, soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  
                        AND soc.status_pago = 1 
                        AND (soc.proveedor_id = 74 OR soc.proveedor_id = 75)
                        order by soc.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudaceptandpaysitio($table,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento, soc.facturable,
                        soc.status_documentouno,soc.name_proveedor, soc.id_usuario,soc.delete_status, 
                        soc.status_pago,u.id, u.nombre, u.ap, s.nombre_servicio , soc.fecha_validaciondos
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        WHERE soc.delete_status =0 AND soc.status_documento= 1  AND soc.status_pago = 1 
                        AND nombre_sitio like '%{$nombre}%' order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsolicitudesaprobadascontabilidad(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia, soc.descripcion,soc.nombre_sitio, soc.status_documento,soc.delete_status,
                        soc.status_documentouno,soc.id_usuario,soc.rol_encargado,u.id,u.nombre,u.ap
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        WHERE soc.status_documento=1 order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }
    public function countsolicitudesaprobadascontabilidad($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id,soc.fecha_requerida,
                        soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, soc.condiciones_compra,
                        soc.referencia,soc.descripcion, soc.nombre_sitio, soc.status_documento,
                        soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.rol_encargado,u.id,u.nombre,
                        u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id 
                        WHERE soc.status_documento=1 order by soc.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getresidentes($id,$id_dos){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM personal_campo where puesto = ? OR puesto = ?",array($id,$id_dos));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // END GET SERVICIOS ORDER BY NOMBRE

    public function Getpersonalcomprobaciones(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM personal_campo where status_comprobacion = 1");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // END GET SERVICIOS ORDER BY NOMBRE


    public function Getresidentessitio($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT stp.id, stp.id_tipoproyecto, stp.id_sitio, stp.residente, 
                        stp.nombre_coordinador, s.id, s.nombre, s.cliente, tp.nombre_proyecto
                        FROM sitios_tipoproyecto stp
                        LEFT JOIN sitios s on stp.id_sitio = s.id 
                        LEFT JOIN tipo_proyecto tp on tp.id=stp.id_tipoproyecto where residente =?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // END GET SERVICIOS ORDER BY NOMBRE

    public function Getcomprobacionproceso($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_residente, c.fecha_del, c.fecha_al, c.monto_solicitud, 
                        c.razon_social, c.facturable, c.factura, c.servicio, c.monto_comprobacion, c.vo_bo, 
                        c.comentarios_comprobacion, c.status_comprobacion, s.nombre
                        FROM comprobaciones c 
                        LEFT JOIN servicios_comprobaciones s on s.id=c.servicio 
                        WHERE c.status_comprobacion = 0 and c.id_residente = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // END GET COMPROBACIONES RESIDENTE EN PROCESO

    public function Getcomprobacionauditada($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_residente, c.fecha_del, c.fecha_al, c.monto_solicitud, 
                        c.razon_social, c.facturable, c.factura, c.servicio, c.monto_comprobacion, c.vo_bo, 
                        c.comentarios_comprobacion, c.status_comprobacion, c.id_comprobacion ,s.nombre
                        FROM comprobaciones c 
                        LEFT JOIN servicios_comprobaciones s on s.id=c.servicio
                        WHERE c.status_comprobacion = 1 and c.id_comprobacion = 0
                        AND c.id_residente = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // END GET COMPROBACIONES RESIDENTE AUDITADAS

    public function Getcomprobacionresidentefacturable($id){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_residente, c.fecha_del, c.fecha_al, c.monto_solicitud, 
                        c.razon_social, c.facturable, c.factura, c.servicio, c.monto_comprobacion, c.vo_bo, 
                        c.comentarios_comprobacion, c.status_comprobacion, c.id_comprobacion ,s.nombre_servicio
                        FROM comprobaciones c 
                        LEFT JOIN servicios s on s.id=c.servicio
                        WHERE c.status_comprobacion = 1 and c.id_comprobacion = 0 and facturable=1 
                        AND c.id_residente = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // END COMPROBACION RESIDENTE FACTURABLE

    public function Getcomprobacionresidentenofacturable($id){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_residente, c.fecha_del, c.fecha_al, c.monto_solicitud, 
                        c.razon_social, c.facturable, c.factura, c.servicio, c.monto_comprobacion, c.vo_bo, 
                        c.comentarios_comprobacion, c.status_comprobacion, c.id_comprobacion ,s.nombre_servicio
                        FROM comprobaciones c 
                        LEFT JOIN servicios s on s.id=c.servicio
                        WHERE c.status_comprobacion = 1 and c.id_comprobacion = 0 and facturable=2
                        AND c.id_residente = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // END COMPROBACION RESIDENTE FACTURABLE


      public function Getpaginationcomprobacionresidente($id,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_residente, c.fecha_del, c.fecha_al, c.monto_solicitud, 
                        c.razon_social, c.facturable, c.factura, c.servicio, c.monto_comprobacion, c.vo_bo, 
                        c.comentarios_comprobacion, c.status_comprobacion, s.nombre
                        from comprobaciones c 
                        LEFT JOIN servicios_comprobaciones s on s.id=c.servicio 
                        WHERE c.status_comprobacion = 0 and c.id_residente = ? order by c.id desc 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR COMPROBACIONES EN PROCESO

      public function Getpaginationcomprobacionresidenteauditada($id,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_residente, c.fecha_del, c.fecha_al, c.monto_solicitud, 
                        c.razon_social, c.facturable, c.factura, c.servicio, c.monto_comprobacion, c.vo_bo, 
                        c.comentarios_comprobacion, c.status_comprobacion, c.id_comprobacion, s.nombre
                        FROM comprobaciones c 
                        LEFT JOIN servicios_comprobaciones s on s.id=c.servicio
                        WHERE c.status_comprobacion = 1 and c.id_comprobacion = 0 and c.id_residente = ? 
                        order by c.id desc LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR COMPROBACIONES EN AUDITADA

    public function Getcomprobacionspecific($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_sitio, c.id_tipoproyecto, c.id_residente, c.fecha_del, c.fecha_al,
                        c.monto_solicitud, c.razon_social, c.facturable, c.factura,c.servicio,c.monto_comprobacion,
                        c.vo_bo, c.comentarios_comprobacion, c.status_comprobacion, c.fecha_user, c.user, 
                        c.factura_file ,s.nombre_servicio
                        FROM comprobaciones c 
                        LEFT JOIN servicios s on s.id=c.servicio 
                        WHERE c.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getcomprobacionspecificdos($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_sitio, c.id_tipoproyecto, c.id_residente, c.fecha_del, c.fecha_al,
                        c.monto_solicitud, c.razon_social, c.facturable, c.factura,c.servicio,c.monto_comprobacion,
                        c.vo_bo, c.comentarios_comprobacion, c.status_comprobacion, c.fecha_user, c.user, 
                        c.factura_file, c.autorizacion,s.nombre, s.comentarios, c.coment_insert
                        FROM comprobaciones c 
                        LEFT JOIN servicios_comprobaciones s on s.id=c.servicio 
                        WHERE c.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function Getcomprobacionsfacturarepetida($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_sitio, c.id_tipoproyecto, c.id_residente, c.fecha_del, c.fecha_al,
                        c.monto_solicitud, c.razon_social, c.facturable, c.factura,c.servicio,c.monto_comprobacion,
                        c.vo_bo, c.comentarios_comprobacion, c.status_comprobacion, c.fecha_user, c.user, 
                        c.factura_file, c.autorizacion ,s.nombre, s.comentarios, p.nombre as name_residente, 
                        p.apellido_pa, p.apellido_ma
                        FROM comprobaciones c 
                        LEFT JOIN servicios_comprobaciones s on s.id=c.servicio 
                        LEFT JOIN personal_campo p on c.id_residente = p.id where c.factura = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getallsolicitudesreporte(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sit.id_cliente, sc.id as idsolicitud,sc.nombre_sitio, sc.name_proveedor,
                        s.nombre_servicio, sc.name_user, sc.fecha_creacion,sc.fecha_validacion as fecha_auditoria, 
                        sc.fecha_validaciondos as fecha_direccion, sc.fecha_pago, sc.importe, sc.iva, 
                        sc.retencion_iva, sc.retencion_isr, sc.total, sc.condiciones_compra, sc.status_documento as
                        direccion, sc.status_documentouno as auditoria,sc.status_pago,sc.descripcion,sc.referencia,
                        tp.nombre_proyecto
                        FROM solicitud_ordencompra sc
                        LEFT JOIN servicios s on sc.servicio_id = s.id
                        LEFT JOIN sitios sit on sit.id = sc.sitio_id
                        LEFT JOIN sitios_tipoproyecto stp on stp.id = sc.tipo_proyecto
                        LEFT JOIN tipo_proyecto tp on tp.id = stp.id_tipoproyecto");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        } 
    }

    public function specificsolicitud($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sit.id_cliente, sc.id as idsolicitud, sc.nombre_sitio,sc.name_proveedor, 
                        s.nombre_servicio, sc.name_user, sc.fecha_creacion,sc.fecha_validacion as fecha_auditoria,
                        sc.fecha_validaciondos as fecha_direccion, sc.fecha_pago, sc.importe, sc.iva, 
                        sc.retencion_iva, sc.retencion_isr, sc.total, sc.condiciones_compra, sc.status_documento as
                        direccion,sc.status_documentouno as auditoria,sc.status_pago, sc.descripcion,sc.referencia,
                        tp.nombre_proyecto
                        FROM solicitud_ordencompra sc
                        LEFT JOIN servicios s on sc.servicio_id = s.id
                        LEFT JOIN sitios sit on sit.id = sc.sitio_id
                        LEFT JOIN sitios_tipoproyecto stp on stp.id = sc.tipo_proyecto
                        LEFT JOIN tipo_proyecto tp on tp.id = stp.id_tipoproyecto
                        WHERE sc.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }      
    }

    public function getallsolicitudesreportecoordinador($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sit.id_cliente, sc.id as idsolicitud, sc.nombre_sitio,p.nombre_prov,
                        sc.id_usuario, s.nombre_servicio, u.nombre, u.ap as apellido , sc.fecha_creacion,
                        sc.fecha_validacion as fecha_auditoria, sc.fecha_validaciondos as fecha_direccion, 
                        sc.fecha_pago, sc.importe, sc.iva, sc.retencion_iva, sc.retencion_isr, sc.total, 
                        sc.condiciones_compra, sc.status_documento as direccion, sc.status_documentouno as
                        auditoria,sc.status_pago, sc.descripcion, sc.referencia
                        FROM solicitud_ordencompra sc
                        LEFT JOIN proveedor p on sc.proveedor_id = p.id
                        LEFT JOIN servicios s on sc.servicio_id = s.id
                        LEFT JOIN sitios sit on sit.id = sc.sitio_id
                        LEFT JOIN usuario u on sc.id_usuario = u.id where sc.id_usuario = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        } 
    }


    public function getallsolicitudesreporteoficina($opcion){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sc.id as idsolicitud, sc.nombre_sitio,p.nombre_prov, s.nombre_servicio, 
                        u.nombre, u.ap as apellido, sc.fecha_creacion,sc.fecha_validacion as fecha_auditoria, 
                        sc.fecha_validaciondos as fecha_direccion, sc.fecha_pago, sc.importe, sc.iva, 
                        sc.retencion_iva, sc.retencion_isr, sc.total, sc.condiciones_compra,sc.status_documento as
                        direccion, sc.status_documentouno as auditoria,sc.status_pago, sc.descripcion
                        FROM solicitud_ordencompra sc
                        LEFT JOIN proveedor p on sc.proveedor_id = p.id
                        LEFT JOIN servicios s on sc.servicio_id = s.id
                        LEFT JOIN usuario u on sc.id_usuario = u.id
                        WHERE nombre_sitio = '$opcion' ");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }    
    }


    public function getsolicitudesSitioAll($sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sit.id_cliente, sc.id as idsolicitud, sc.nombre_sitio,sc.name_proveedor, 
                        s.nombre_servicio, sc.name_user, sc.fecha_creacion,sc.fecha_validacion as fecha_auditoria,
                        sc.fecha_validaciondos as fecha_direccion, sc.fecha_pago, sc.importe, sc.iva, 
                        sc.retencion_iva, sc.retencion_isr, sc.total, sc.condiciones_compra, sc.status_documento as
                        direccion,sc.status_documentouno as auditoria,sc.status_pago, sc.descripcion,sc.referencia,
                        tp.nombre_proyecto
                        FROM solicitud_ordencompra sc
                        LEFT JOIN servicios s on sc.servicio_id = s.id
                        LEFT JOIN sitios sit on sit.id = sc.sitio_id
                        LEFT JOIN sitios_tipoproyecto stp on stp.id = sc.tipo_proyecto
                        LEFT JOIN tipo_proyecto tp on tp.id = stp.id_tipoproyecto
                        WHERE nombre_sitio  like '%{$sitio}%' ");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }    
    }


    public function getsolicitudesPrvAll($proveedor){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sit.id_cliente, sc.id as idsolicitud, sc.nombre_sitio,sc.name_proveedor, 
                        s.nombre_servicio, sc.name_user, sc.fecha_creacion,sc.fecha_validacion as fecha_auditoria,
                        sc.fecha_validaciondos as fecha_direccion, sc.fecha_pago, sc.importe, sc.iva, 
                        sc.retencion_iva, sc.retencion_isr, sc.total, sc.condiciones_compra, sc.status_documento as
                        direccion,sc.status_documentouno as auditoria,sc.status_pago, sc.descripcion,sc.referencia,
                        tp.nombre_proyecto
                        FROM solicitud_ordencompra sc
                        LEFT JOIN servicios s on sc.servicio_id = s.id
                        LEFT JOIN sitios sit on sit.id = sc.sitio_id
                        LEFT JOIN sitios_tipoproyecto stp on stp.id = sc.tipo_proyecto
                        LEFT JOIN tipo_proyecto tp on tp.id = stp.id_tipoproyecto
                        WHERE name_proveedor  like '%{$proveedor}%' ");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }    
    }


    public function getsolicitudesUsrAll($usuario){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sit.id_cliente, sc.id as idsolicitud, sc.nombre_sitio,sc.name_proveedor, 
                        s.nombre_servicio, sc.name_user, sc.fecha_creacion,sc.fecha_validacion as fecha_auditoria,
                        sc.fecha_validaciondos as fecha_direccion, sc.fecha_pago, sc.importe, sc.iva, 
                        sc.retencion_iva, sc.retencion_isr, sc.total, sc.condiciones_compra, sc.status_documento as
                        direccion,sc.status_documentouno as auditoria,sc.status_pago, sc.descripcion,sc.referencia,
                        tp.nombre_proyecto
                        FROM solicitud_ordencompra sc
                        LEFT JOIN servicios s on sc.servicio_id = s.id
                        LEFT JOIN sitios sit on sit.id = sc.sitio_id
                        LEFT JOIN sitios_tipoproyecto stp on stp.id = sc.tipo_proyecto
                        LEFT JOIN tipo_proyecto tp on tp.id = stp.id_tipoproyecto
                        WHERE name_user  like '%{$usuario}%' ");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }    
    }


 // F E C H A S    G R A F I C A S

    public function getdireccionsitiograficas($nombre,$year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id,soc.name_proveedor, 
                        soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr,
                        soc.retencion_iva, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion, 
                        soc.nombre_sitio, soc.status_documento,soc.status_documentouno ,soc.id_usuario,
                        soc.delete_status,  soc.status_pago, soc.facturable,s.nombre_servicio, 
                        soc.fecha_validaciondos, soc.name_user, 
                        year(date(CONCAT(SUBSTRING(fecha_validaciondos, 7, 4),  '-', SUBSTRING(fecha_validaciondos, 4, 2), '-', SUBSTRING(fecha_validaciondos, 1, 2)))) AS years,
                        month(date(CONCAT(SUBSTRING(fecha_validaciondos, 7, 4),  '-', SUBSTRING(fecha_validaciondos, 4, 2), '-', SUBSTRING(fecha_validaciondos, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_validaciondos, 7, 4),  '-', SUBSTRING(fecha_validaciondos, 4, 2), '-', SUBSTRING(fecha_validaciondos, 1, 2)))) AS dia, tp.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN servicios s on s.id= soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto stp on stp.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto tp on tp.id = stp.id_tipoproyecto 
                        having soc.status_documento= 1  AND soc.status_pago != 1 
                        AND mes  = $month
                        AND years = $year
                        AND nombre_sitio  like '%{$nombre}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getdireccionproveedorgraficas($nombre,$year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id,soc.name_proveedor, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr,
                        soc.retencion_iva, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio,soc.name_proveedor ,soc.status_documento,soc.status_documentouno,
                        soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable ,soc.name_user, 
                        s.nombre_servicio, soc.fecha_validaciondos,
                        year(date(CONCAT(SUBSTRING(fecha_validaciondos, 7, 4),  '-', SUBSTRING(fecha_validaciondos, 4, 2), '-', SUBSTRING(fecha_validaciondos, 1, 2)))) AS years ,
                        month(date(CONCAT(SUBSTRING(fecha_validaciondos, 7, 4),  '-', SUBSTRING(fecha_validaciondos, 4, 2), '-', SUBSTRING(fecha_validaciondos, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_validaciondos,7,4),'-',SUBSTRING(fecha_validaciondos,4,2),'-', SUBSTRING(fecha_validaciondos, 1, 2)))) AS dia, tp.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        LEFT JOIN sitios_tipoproyecto stp on stp.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto tp on tp.id = stp.id_tipoproyecto 
                        having soc.status_documento= 1  AND soc.status_pago != 1 
                        AND mes  = $month
                        AND years = $year
                        AND name_proveedor like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getdireccionusergraficas($nombre,$year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id,soc.name_proveedor, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr,
                        soc.retencion_iva, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento,soc.name_user,soc.status_documentouno,soc.id_usuario,
                        soc.delete_status, soc.status_pago, soc.facturable ,soc.name_user, s.nombre_servicio, 
                        soc.fecha_validaciondos, 
                        year(date(CONCAT(SUBSTRING(fecha_validaciondos, 7, 4),  '-', SUBSTRING(fecha_validaciondos, 4, 2), '-', SUBSTRING(fecha_validaciondos, 1, 2)))) AS years,
                        month(date(CONCAT(SUBSTRING(fecha_validaciondos, 7, 4),  '-', SUBSTRING(fecha_validaciondos, 4, 2), '-', SUBSTRING(fecha_validaciondos, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_validaciondos,7,4),'-',SUBSTRING(fecha_validaciondos,4, 2), '-', SUBSTRING(fecha_validaciondos, 1, 2)))) AS dia,tp.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        LEFT JOIN sitios_tipoproyecto stp on stp.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto tp on tp.id = stp.id_tipoproyecto 
                        having soc.status_documento= 1  AND soc.status_pago != 1
                        AND mes  = $month
                        AND years = $year 
                        AND name_user like '%{$nombre}%' order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getdireccionserviciograficas($nombre,$year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id,soc.name_proveedor, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr,
                        soc.retencion_iva, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento,soc.name_user,soc.status_documentouno,
                        soc.servicio_id,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable,
                        soc.name_user s.nombre_servicio, soc.fecha_validaciondos, 
                        year(date(CONCAT(SUBSTRING(fecha_validaciondos, 7, 4),  '-', SUBSTRING(fecha_validaciondos, 4, 2), '-', SUBSTRING(fecha_validaciondos, 1, 2)))) AS years,
                        month(date(CONCAT(SUBSTRING(fecha_validaciondos, 7, 4),  '-', SUBSTRING(fecha_validaciondos, 4, 2), '-', SUBSTRING(fecha_validaciondos, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_validaciondos, 7, 4),  '-', SUBSTRING(fecha_validaciondos, 4, 2), '-', SUBSTRING(fecha_validaciondos, 1, 2)))) AS dia,tp.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN servicios s on s.id= soc.servicio_id 
                        LEFT JOIN sitios_tipoproyecto stp on stp.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto tp on tp.id = stp.id_tipoproyecto 
                        having soc.status_documento= 1  AND soc.status_pago != 1
                        AND mes  = $month
                        AND years = $year 
                        AND soc.servicio_id = ? order by soc.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

// END GRAFICAS DIRECCION

    public function getpagadagraficasitio($nombre,$year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id,soc.name_proveedor, soc.fecha_requerida, soc.servicio_id,
                                    soc.importe, soc.iva, soc.retencion_isr,soc.retencion_iva, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.status_documento,soc.name_user,soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable ,soc.name_user, s.nombre_servicio, soc.fecha_validaciondos, soc.fecha_pago, year(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS years ,month(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS mes ,day(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS dia, tp.nombre_proyecto
                                FROM solicitud_ordencompra soc
                                LEFT JOIN servicios s on s.id= soc.servicio_id 
                                LEFT JOIN sitios_tipoproyecto stp on stp.id = soc.tipo_proyecto
                                LEFT JOIN tipo_proyecto tp on tp.id = stp.id_tipoproyecto 
                                having soc.status_documento= 1 AND soc.status_pago = 1 
                                AND mes  = $month
                                AND years = $year 
                                AND nombre_sitio like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getpagadagraficaproveedor($nombre,$year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.name_proveedor,soc.fecha_requerida, soc.servicio_id,
                                    soc.importe, soc.iva, soc.retencion_isr,soc.retencion_iva, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.status_documento,soc.name_user,soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable ,soc.name_user, s.nombre_servicio, soc.fecha_validaciondos, soc.fecha_pago, year(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS years ,month(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS mes ,day(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS dia, tp.nombre_proyecto
                                FROM solicitud_ordencompra soc
                                LEFT JOIN servicios s on s.id= soc.servicio_id
                                LEFT JOIN sitios_tipoproyecto stp on stp.id = soc.tipo_proyecto
                                LEFT JOIN tipo_proyecto tp on tp.id = stp.id_tipoproyecto  
                                having  soc.status_documento= 1 
                                AND soc.status_pago = 1 
                                AND mes  = $month
                                AND years = $year 
                                AND name_proveedor like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getpagadagraficausuario($nombre,$year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id,soc.name_proveedor, soc.fecha_requerida, soc.servicio_id,
                                    soc.importe, soc.iva, soc.retencion_isr,soc.retencion_iva, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.name_user, soc.status_documento,soc.name_user,soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.status_pago, soc.facturable ,soc.name_user, s.nombre_servicio, soc.fecha_validaciondos, soc.fecha_pago, year(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS years ,month(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS mes ,day(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS dia, tp.nombre_proyecto
                                FROM solicitud_ordencompra soc
                                LEFT JOIN servicios s on s.id= soc.servicio_id 
                                LEFT JOIN sitios_tipoproyecto stp on stp.id = soc.tipo_proyecto
                                LEFT JOIN tipo_proyecto tp on tp.id = stp.id_tipoproyecto  
                                having soc.status_documento= 1 AND soc.status_pago = 1 
                                AND mes  = $month
                                AND years = $year 
                                AND name_user like '%{$nombre}%'  order by soc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getpagadagraficaservicio($nombre,$year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id,soc.name_proveedor, soc.fecha_requerida, soc.servicio_id,
                                    soc.importe, soc.iva, soc.retencion_isr,soc.retencion_iva, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio,soc.name_proveedor, soc.name_user, soc.status_documento,soc.name_user,soc.status_documentouno ,soc.id_usuario,soc.delete_status, soc.servicio_id, soc.status_pago, soc.facturable ,soc.name_user, s.nombre_servicio, soc.fecha_validaciondos, soc.fecha_pago, year(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS years ,month(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS mes ,day(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS dia, tp.nombre_proyecto
                                FROM solicitud_ordencompra soc
                                LEFT JOIN servicios s on s.id= soc.servicio_id 
                                LEFT JOIN sitios_tipoproyecto stp on stp.id = soc.tipo_proyecto
                                LEFT JOIN tipo_proyecto tp on tp.id = stp.id_tipoproyecto  
                                having soc.status_documento= 1 AND soc.status_pago = 1 
                                AND mes  = $month
                                AND years = $year 
                                AND servicio_id = ? order by soc.id DESC",array($nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getinfosolicitudesindex($year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sit.id_cliente, sc.id as idsolicitud, sc.nombre_sitio,p.nombre_prov, s.nombre_servicio, u.nombre, u.ap as apellido , sc.fecha_creacion,sc.fecha_validacion as fecha_auditoria, sc.fecha_validaciondos as fecha_direccion, sc.fecha_pago, sc.importe, sc.iva, sc.retencion_iva, sc.retencion_isr, sc.total, sc.condiciones_compra, sc.status_documento as direccion, sc.status_documentouno as auditoria,sc.status_pago, sc.descripcion, sc.referencia, year(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS years ,month(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS mes ,day(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS dia
                        FROM solicitud_ordencompra sc
                        LEFT JOIN proveedor p on sc.proveedor_id = p.id
                        LEFT JOIN servicios s on sc.servicio_id = s.id
                        LEFT JOIN sitios sit on sit.id = sc.sitio_id
                        LEFT JOIN usuario u on sc.id_usuario = u.id
                                having sc.status_pago= 1
                                AND mes  = $month
                                AND years = $year  order by sc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getinfosolicitudessitio($year,$month, $sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT sit.id_cliente, sc.id as idsolicitud, sc.tipo_proyecto, sc.nombre_sitio,
                        p.nombre_prov, s.nombre_servicio, u.nombre, u.ap as apellido , sc.fecha_creacion,
                        sc.fecha_validacion as fecha_auditoria, sc.fecha_validaciondos as fecha_direccion, 
                        sc.fecha_pago, sc.importe, sc.iva, sc.retencion_iva, sc.retencion_isr, sc.total, 
                        sc.condiciones_compra, sc.status_documento as direccion, sc.status_documentouno as 
                        auditoria,sc.status_pago, sc.descripcion, sc.referencia, year(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS years ,month(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS mes ,day(date(CONCAT(SUBSTRING(fecha_pago, 7, 4),  '-', SUBSTRING(fecha_pago, 4, 2), '-', SUBSTRING(fecha_pago, 1, 2)))) AS dia
                        FROM solicitud_ordencompra sc
                        INNER JOIN proveedor p on sc.proveedor_id = p.id
                        INNER JOIN servicios s on sc.servicio_id = s.id
                        INNER JOIN sitios sit on sit.id = sc.sitio_id
                        INNER JOIN usuario u on sc.id_usuario = u.id
                                having sc.status_pago= 1
                                AND mes  = $month
                                AND years = $year  
                                AND sc.tipo_proyecto = $sitio
                                order by sc.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getusernamesolicitudcompras($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, soc.retencion_isr, soc.total,
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento,soc.status_documentouno,soc.delete_status, u.id, u.nombre, u.ap, 
                        s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario= ? and soc.status_documento = 0 and status_documentouno = 0  
                        order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamesolicitudcomprasoption($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.proveedor_id, soc.id_usuario, 
                        soc.fecha_requerida, soc.servicio_id,soc.importe, soc.iva, soc.retencion_isr, soc.total, 
                        soc.condiciones_compra, soc.referencia, soc.descripcion,soc.nombre_sitio, 
                        soc.status_documento,soc.status_documentouno,soc.delete_status,soc.status_pago ,u.id, 
                        u.nombre, u.ap, s.nombre_servicio
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        WHERE soc.id_usuario = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getusernamecompraspaginator($id,$table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto  
                        WHERE soc.id_usuario = ?
                        order by soc.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }
// '%{$nombre}%'
    public function getsolicitudsearchcompras($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto  
                        WHERE soc.id_usuario = ? and soc.nombre_sitio like '%{$nombre}%' order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsolicitudsearchcompraspag($id,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto  
                        WHERE soc.id_usuario = ? and soc.nombre_sitio like '%{$nombre}%'  order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsolicitudsearchcomprasprov($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto  
                        WHERE soc.id_usuario = ? and soc.name_proveedor like '%{$nombre}%' order by soc.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsolicitudsearchcompraspagprov($id,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto  
                        WHERE soc.id_usuario = ? and soc.name_proveedor like '%{$nombre}%'  order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsolicitudsearchcomprasid($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto  
                        WHERE soc.id_usuario = ? and soc.id= ? order by soc.id DESC",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsolicitudsearchcompraspagid($id,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto  
                        WHERE soc.id_usuario = ? and soc.id = ? order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getsolicitudsearchcompraserv($id,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto  
                        WHERE soc.id_usuario = ? and soc.servicio_id= ? order by soc.id DESC",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsolicitudsearchcompraspagserv($id,$offset,$no_of_records_per_page,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT soc.id as id_solicitud, soc.sitio_id, soc.tipo_proyecto, soc.proveedor_id,
                        soc.name_proveedor, soc.fecha_requerida, soc.servicio_id, soc.importe, soc.iva, 
                        soc.retencion_isr, soc.total, soc.condiciones_compra, soc.referencia, soc.descripcion,
                        soc.nombre_sitio, soc.status_documento, soc.status_pago,soc.status_documentouno ,
                        soc.id_usuario,soc.rol_encargado,soc.delete_status, u.id, u.nombre,u.ap,s.nombre_servicio,
                        st.id_tipoproyecto, t.nombre_proyecto
                        FROM solicitud_ordencompra soc
                        LEFT JOIN usuario u on soc.id_usuario = u.id 
                        LEFT JOIN servicios s on s.id = soc.servicio_id
                        LEFT JOIN sitios_tipoproyecto st on st.id = soc.tipo_proyecto
                        LEFT JOIN tipo_proyecto t on t.id = st.id_tipoproyecto  
                        WHERE soc.id_usuario = ? and soc.servicio_id = ? order by soc.id DESC LIMIT $offset,$no_of_records_per_page",array($id,$nombre));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

}