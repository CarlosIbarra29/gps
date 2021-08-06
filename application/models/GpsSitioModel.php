<?php
class Application_Model_GpsSitioModel extends Zend_Db_Table_Abstract{
    protected $_name = 'semanados_bts';
    protected $_primary = 'id';

    public function insertfotopreliminarsemanados($post,$table){
        try {
            $row = $this->createRow();
            $row->idsitio_tipo = $post['sitio'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO

    protected $_namedos = 'semanatres_bts';
    protected $_primarydos = 'id';

    public function refreshEstructura($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre_estructura = ? WHERE id = ?",array(
                $post['name'],
                $post["ids"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function updatesitioresidente($post,$table,$personal){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET residente = ?, nombre_residente = ? WHERE id = ?",array(
                $post['id_user'],
                $personal,
                $post["proyecto"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER


    public function refresharchivoption($id,$table,$option,$fecha,$user, $post){
        $uno =null; $dos =null; $tres =null;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET $option = ?, $fecha = ?, $user = ? WHERE id = ?",array(
                $uno,
                $dos,
                $tres,
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function insertproyectoSitio($post,$table,$name_pro,$name_cli,$coordinador_name, $ingproyecto_name, $residente_name,$coordinador_id, $ingeniero_id, $residente_id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_tipoproyecto'=>$post['tipo_proyecto'],
                'id_sitio'=>$post['sitio'],
                'status_proyecto'=> $name_pro,
                'status_cliente'=>$name_cli,
                'id_operador'=>$post['id_operador'],
                'operador'=>$post['operador'],
                'pm_cliente'=>$post['pm_cliente'],
                'fecha_inicio'=>$post['fecha_inicio'],
                'residente'=>$residente_id,
                'nombre_residente'=>$residente_name,
                'coordinador_id'=>$coordinador_id,
                'nombre_coordinador'=>$coordinador_name,
                'nombre_ingproyecto'=>$ingproyecto_name,
                'ingproyecto_id'=>$ingeniero_id); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT U

    public function insertEstructurasitio($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_estructura'=>$post['name']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function inserComentariositio($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitio'=>$post['sitio'],
                'comentarios'=>$post['comentario']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertdetallebtsdosid($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitiotipo'=>$post['sitio']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertdetallepdfbts($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitiotipo'=>$post['sitio_tipoproyecto']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertcomentariopersonal($post,$table,$nombre){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitiotipo'=>$post['sitio'],
                'id_usuario'=>$post['usuario'],
                'comentario'=>$post['comentario']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insercotizacionsitio($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'sitio_id'=>$post['sitio'],
                'proyecto_id'=>$post['id'],
                'titulo'=>$post['titulo'],
                'fecha_cotizacion'=>$post['fecha_realizada'],
                'fecha'=>$post['fecha'],
                'usuario'=>$post['name_user'],
                'documento'=>$urldb,
                'total'=>$post['total'],
                'comentario'=>$post['comentario']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT COTIZACION DEL SITIO

    public function insercotizacionsitiopo($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitiopo'=>$post['id_sitio'],
                'titulo_po'=>$post['titulo'],
                'numero_po'=>$post['numero'],
                'fecha_subir'=>$post['fecha_realizada'],
                'fecha_creo'=>$post['fecha'],
                'name_user'=>$post['name_user'],
                'monto'=>$post['monto'],
                'tipo_moneda'=>$post['moneda'],
                'documento_po'=>$urldb,
                'id_cotizacion'=>$post['id_cotizacion'],
                'descripcion'=>$post['descripcion']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT P.O DE LA COTIZACION DEL SITIO

    public function insertpdfdetallebts($post,$table,$id,$urldb,$set,$fecha,$hoy,$user, $carga_user){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET $set = ?, $fecha=?, $carga_user =? WHERE id = ?",array(
                $urldb,
                $hoy,
                $user,
                $id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO

    public function changeporcentajesitio($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET porcentaje_proyecto = ? WHERE id = ?",array(
                $post['porcentaje'],
                $post['sitio']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO


    // public function insertfilealtansitio($post,$table,$id,$urldb,$hoy,$user){
    //     try {
    //         $db = Zend_Db_Table::getDefaultAdapter();
    //         $qry = $db->query("UPDATE $table SET file_altan = ?, date_file=?, user_file =? WHERE id = ?",array(
    //             $urldb,
    //             $hoy,
    //             $user,
    //             $id));
    //         $db->closeConnection();               
    //         return $qry;
    //     } 
    //     catch (Exception $e) {
    //         echo $e;
    //     }
    // }// END INSERT CERTIFICADO MEDICO PERSONAL DE CAMPO

    public function insertfilealtansitio($post,$table,$id,$urldb,$hoy,$user){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitiotipo'=>$post['sitio_tipoproyecto'],
                'file_altan'=>$urldb,
                'user_file'=>$user,
                'date_file'=>$hoy,
                'name_file'=>$post['name_file']
            );
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function getnombreautocomplete($nombre){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM sitios WHERE nombre like '%{$nombre}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getEstructurasitio($nombre){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM estructura_sitio WHERE nombre_estructura like '%{$nombre}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getestructurapaginator($nombre,$offset,$no_of_records_per_page){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM estructura_sitio WHERE nombre_estructura like '%{$nombre}%' LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function GetspecificSitio($id){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT stp.id_tipoproyecto,stp.id_sitio,  tp.id, tp.nombre_proyecto
                        FROM sitios_tipoproyecto stp
                        LEFT JOIN tipo_proyecto tp on stp.id=tp.id where id_sitio = ?",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function Getproridadstatus($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM status_proyecto WHERE tipo_proyecto = ? AND prioridad = 1",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getproridadcliente($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM status_cliente WHERE tipo_proyecto = ? AND prioridad = 1",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function GettipoproyectoDetalles($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM sitios_tipoproyecto WHERE id = ? ",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getordernombresitios(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM sitios ORDER BY nombre ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getcomentariossitio($tipo){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT dc.id as commitid, dc.id_sitiotipo, dc.id_usuario, dc.comentario, 
                        u.id, u.nombre, u.ap
                        From detalle_comentarios dc 
                        LEFT JOIN usuario u on u.id=dc.id_usuario 
                        WHERE dc.id_sitiotipo = ? ",array($tipo));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getproyectsitios($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT tp.id, tp.nombre_proyecto,  stp.id as idtipo, stp.id_tipoproyecto,
                        stp.nombre_coordinador,stp.nombre_ingproyecto, stp.id_sitio, stp.status_cliente, 
                        stp.status_proyecto,stp.fecha_inicio,stp.porcentaje_proyecto ,sc.id, sc.nombre_status 
                        as statuscliente, sp.id, sp.nombre_status as statusproyecto
                        FROM tipo_proyecto tp
                        LEFT JOIN sitios_tipoproyecto stp on tp.id = stp.id_tipoproyecto
                        LEFT JOIN status_cliente sc on sc.id = stp.status_cliente
                        LEFT JOIN status_proyecto sp on sp.id = stp.status_proyecto 
                        WHERE stp.id_sitio= ? ;",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function refreshStatuscliente($post,$table,$id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre_status = ?, tipo_proyecto = ?, prioridad = ? WHERE id = ?",array(
                $post['nombre'],
                $post['tipo_proyecto'],
                $post["prioridad"],
                $id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER
    
    public function refreshcotizacionsitio($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE cotizaciones_sitios SET titulo = ?, fecha_cotizacion = ?, fecha = ?, usuario = ?, documento = ?, total = ?, comentario = ? WHERE id = ?",array(
                $post['titulo'],
                $post['fecha_realizada'],
                $post['fecha'],
                $post['name_user'],
                $urldb,
                $post['total'],
                $post["comentario"],
                $post['id_cotizacion']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function UpdateStatusgps($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_proyecto = ? WHERE id = ?",array(
                $post['gps'],
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function UpdateStatuscliente($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_cliente = ? WHERE id = ?",array(
                $post['cli'],
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function UpdateIsuecliente($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET issue = ? WHERE id = ?",array(
                $post['issue'],
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function UpdateCotizacionsitio($post){
        $variable = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE cotizaciones_sitios SET status_documento = ? WHERE id = ?",array(
                $variable,
                $post["id_cotizacion"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function UpdateAsignacionpersonalasitio($post,$table){
        $status_cuadrilla = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_cuadrilla = ?, tipo_proyectopersonal = ?, sitio_tipoproyectopersonal = ?, id_sitiopersonal = ?, name_sitio = ? WHERE id = ?",array(
                $status_cuadrilla,
                $post['id_tipoproyecto'],
                $post['sitio_tipoproyecto'],
                $post['id_sitio'],
                $post['name_sitio'],
                $post["personal"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function asignacionpersonalasitio($post,$table,$name_sitio,$id){
        $status_cuadrilla = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_cuadrilla = ?, sitio_tipoproyectopersonal = ?, id_sitiopersonal = ?, name_sitio = ?, fechainicio_asignacion = ?, fechafinal_asignacion = ? WHERE id = ?",array(
                $status_cuadrilla,
                $post['proyecto'],
                $post['sitio'],
                $name_sitio,
                $post['fecha_inicial'],
                $post['fecha_final'],
                $id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function asignacionpersonalop($post,$table,$name_sitio,$id,$proyecto){
        $status_cuadrilla = 1;
        $proyec = 0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_cuadrilla = ?, sitio_tipoproyectopersonal = ?, id_sitiopersonal = ?, name_sitio = ?, fechainicio_asignacion = ?, fechafinal_asignacion = ? WHERE id = ?",array(
                $status_cuadrilla,
                $proyec,
                $proyecto,
                $name_sitio,
                $post['fecha_inicial'],
                $post['fecha_final'],
                $id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL


    public function liberacionpersonalasitio($post,$table,$id){
        $status_cuadrilla = 0;
        $value = 0;
        $sitio = NULL;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_cuadrilla = ?, sitio_tipoproyectopersonal = ?, id_sitiopersonal = ?, name_sitio = ?, fechainicio_asignacion = ?, fechafinal_asignacion = ? WHERE id = ?",array(
                $status_cuadrilla,
                $value,
                $value,
                $sitio,
                $sitio,
                $sitio,
                $id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function asignacionpersonalcuadrillaadd($post,$table,$id_sitio,$fecha_inicio,$fecha_final){
        $status_cuadrilla = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_cuadrilla = ?, sitio_tipoproyectopersonal = ?, id_sitiopersonal = ?, name_sitio = ?, fechainicio_asignacion = ?, fechafinal_asignacion = ? WHERE id = ?",array(
                $status_cuadrilla,
                $post['proyecto'],
                $id_sitio,
                $post['sitio'],
                $fecha_inicio,
                $fecha_final,
                $post['person_more']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL


    public function asignacionpersonalasitioind($post,$table,$name_sitio,$fecha_inicial,$fecha_final){
        $status_cuadrilla = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_cuadrilla = ?, sitio_tipoproyectopersonal = ?, id_sitiopersonal = ?, name_sitio = ?, fechainicio_asignacion = ?, fechafinal_asignacion = ? WHERE id = ?",array(
                $status_cuadrilla,
                $post['proyecto'],
                $post['sitio'],
                $name_sitio,
                $fecha_inicial,
                $fecha_final,
                $post['id_user']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function asignacionpersonalasitioindop($post,$table,$name_sitio,$fecha_inicial,$fecha_final,$sitio){
        $status_cuadrilla = 1;
        $proyect = 0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_cuadrilla = ?, sitio_tipoproyectopersonal = ?, id_sitiopersonal = ?, name_sitio = ?, fechainicio_asignacion = ?, fechafinal_asignacion = ? WHERE id = ?",array(
                $status_cuadrilla,
                $proyect,
                $sitio,
                $name_sitio,
                $fecha_inicial,
                $fecha_final,
                $post['id_user']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function Updatechangepersonal($post,$table,$hoy){
        $status_personal = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_personal = ?, fecha_personal= ?, status_operativo = ? WHERE id = ?",array(
                $post['dato'],
                $hoy,
                $post["operativo"],
                $post["user"],

            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function Updatechangepersonaldos($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_operativo = ? WHERE id = ?",array(
                $post['dato'],
                $post["user"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function Updatechangepersonalperfil($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET perfil = ? WHERE id = ?",array(
                $post['perfil_text'],
                $post["user"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function Updateliberacionpersonalasitio($post){
        $name_sitio = NULL;
        $inicial = NULL;
        $final = NULL;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE personal_campo SET status_cuadrilla = 0, tipo_proyectopersonal = 0, sitio_tipoproyectopersonal = 0, id_sitiopersonal = 0, name_sitio = ?, fechainicio_asignacion = ?, fechafinal_asignacion = ? 
                WHERE id = ?",array($name_sitio,$inicial,$final,$post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE ROL

    public function Updatecomentario($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET comentarios = ? WHERE id = ?",array(
                $post['comentario'],
                $post["ids"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function Gettlatitudemaps(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM sitios  where latitude != '' AND longitude != '' ");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getcomentariossitioid($id){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.id_sitio, c.comentarios, c.created_at 
                        FROM comentarios_sitios c 
                        WHERE c.id_sitio = ? ORDER BY id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getpaginationcotizacionservicio($id,$table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table WHERE sitio_id = ? 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR

    public function Getpaginationcotizacionpo($sitio,$id,$table,$offset,$no_of_records_per_page){
        // var_dump($id);exit;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table WHERE id_sitiopo = ? AND id_cotizacion = ?
                        LIMIT $offset,$no_of_records_per_page",array($sitio,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR

    public function gettipoproyectosolicitud($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT tis.id, tis.id_sitio, tis.id_tipoproyecto, tp.id as idp, 
                        tp.nombre_proyecto
                        FROM sitios_tipoproyecto tis
                        LEFT JOIN tipo_proyecto tp on tis.id_tipoproyecto= tp.id where tis.id_sitio =?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function tiposproyectospersonal(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT tis.id, tis.id_sitio, tis.id_tipoproyecto, tp.id as idp, 
                        tp.nombre_proyecto, s.nombre, s.id_cliente
                        FROM sitios_tipoproyecto tis
                        LEFT JOIN tipo_proyecto tp on tis.id_tipoproyecto= tp.id 
                        LEFT JOIN sitios s on s.id = tis.id_sitio ORDER BY s.nombre ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }  
    }


    public function proyectoasignarpersonal($proyecto){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT tis.id, tis.id_sitio, tis.id_tipoproyecto, tp.id as idp, 
                        tp.nombre_proyecto, s.nombre, s.id_cliente
                        FROM sitios_tipoproyecto tis
                        LEFT JOIN tipo_proyecto tp on tis.id_tipoproyecto= tp.id 
                        LEFT JOIN sitios s on s.id = tis.id_sitio where tis.id = ?",array($proyecto));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getinfoingproyecto($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT s.id, s.idgps,s.id_cliente,s.nombre, s.cliente,s.direccion,s.ciudad,
                        s.estado, s.region, s.estructura, s.altura, s.edificio, s.tipo_sitio, s.latitude, 
                        s.longitude, st.id_sitio, st.ingproyecto_id
                        From sitios s 
                        LEFT JOIN sitios_tipoproyecto st on s.id= st.id_sitio 
                        WHERE st.ingproyecto_id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getpaginationingproyecto($id,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT s.id, s.idgps, s.id_cliente, s.nombre, s.cliente,s.direccion,s.ciudad, 
                        s.estado, s.region, s.estructura, s.altura, s.edificio, s.tipo_sitio,s.latitude,s.longitude,
                        st.id_sitio, st.ingproyecto_id
                        FROM sitios s 
                        LEFT JOIN sitios_tipoproyecto st on s.id= st.id_sitio 
                        WHERE st.ingproyecto_id = ? LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR

    public function GetAllSitio($table){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table ORDER BY nombre ASC");
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function Getreportesitiocero(){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT p.id, p.nombre,p.apellido_pa, p.apellido_ma, p.telefono, 
                        p.email_personal, p.status_personal, p.name_sitio, p.status_operativo,
                        p.id_sitiopersonal,p.curp,p.nss,p.rfc, pp.nombre as puesto
                        FROM personal_campo p
                        LEFT JOIN puestos_personal pp on p.puesto = pp.id;");
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function Getreportesitiodiferentecero($id){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT p.id, p.nombre, p.apellido_pa, p.apellido_ma, p.telefono,
                        p.email_personal, p.status_personal, p.name_sitio, p.status_operativo, p.id_sitiopersonal, 
                        p.rfc, p.curp, p.nss, pp.nombre as puesto
                        FROM personal_campo p
                        LEFT JOIN puestos_personal pp on p.puesto = pp.id where p.id_sitiopersonal = ?",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function avancebtsfechas($proyecto){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT db.id,db.id_sitiotipo,s.id_cliente,s.nombre, db.ttv_baseline, 
                        db.ttv_forecast, db.ttv_actual, db.muestreo_baseline, db.muestreo_forecast, 
                        db.muestreo_actual, db.proyectopreliminar_baseline, db.proyectopreliminar_forecast, 
                        db.proyectopreliminar_actual, db.redlines, db.mspreliminar_baseline,db.mspreliminar_forecast,
                        db.mspreliminar_actual,db.msfinal_baseline, db.msfinal_forecast, db.msfinal_actual,
                        db.proyectofinal_baseline, db.proyectofinal_forecast,db.proyectofinal_actual, 
                        db.inicioobra_baseline, db.inicioobra_forecast,db.inicioobra_actual,db.terminoobra_baseline,
                        db.terminoobra_forecast, db.terminoobra_actual, 
                        st.id_sitio, sp.nombre_status
                        FROM detalle_bts db
                        INNER JOIN sitios_tipoproyecto st on db.id_sitiotipo = st.id
                        INNER JOIN sitios s on s.id = st.id_sitio
                        INNER JOIN status_proyecto sp on sp.id =st.status_proyecto
                        WHERE sp.id != 77 AND st.id_tipoproyecto = ?", array($proyecto));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }
}