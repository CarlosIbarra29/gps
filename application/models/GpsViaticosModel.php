<?php

class Application_Model_GpsViaticosModel extends Zend_Db_Table_Abstract{
    protected $_name = 'viaticos_sol';
    protected $_primary = 'id';


    public function GetSolStepUnoV(){ 
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM viaticos_sol vs where vs.status_step = 0");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }
 
    public function GetStepCeroViapaginator($offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, 
                vs.id_sitio, vs.name_sitio, vs.status_step, vs.status_solicitud, vs.id_proyecto, pc.puesto, pp.nombre as namepuesto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                where vs.status_step = 0 LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET INFO TO PAGINATOR Para SolViaticos.phtml

    public function GetordersitiosV(){  
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM sitios ORDER BY nombre ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } // CONSULTA SITIOS ORDEN para addsolviaticos.phtml


    public function GetPersonalViaticos(){  
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM personal_campo where status_personal = 0 and delete_status = 0 ORDER BY nombre ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } // CONSULTA PERSONAL ORDEN // CONSULTA Personal para addsolviaticos.phtml


    public function insertsolviaticos($post,$table,$id_user,$nombre,$nombre_per,$nombre_sitio){
        
        try {
            $row = $this->createRow();
            $row->fecha_inicio = $post['fecha_inicial'];
            $row->fecha_fin = $post['fecha_final'];
            $row->id_personal = $post['personal'];
            $row->name_personal = $nombre_per;
            $row->id_sitio = $post['sitio'];
            $row->name_sitio = $nombre_sitio;
            $row->motivo_viaticos = $post['motivo'];
            $row->user_creacion = $id_user;
            $row->name_user = $nombre;
            $res = $row->save();              
            return $res;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   // END INSERT PASO 1 SOLICITUD Viaticos en addsolviaticos.phtml


    public function getproyectosviaticos($sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT tis.id, tis.id_sitio, tis.id_tipoproyecto, tp.id as idp, 
                        tp.nombre_proyecto, s.nombre
                        FROM sitios_tipoproyecto tis
                        LEFT JOIN tipo_proyecto tp on tis.id_tipoproyecto = tp.id 
                        LEFT JOIN sitios s on s.id = tis.id_sitio 
                        where tis.id_sitio = ? ",array($sitio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Tipo de proyecto para addsolviaticos2.phtml


     public function UpdateSolViaDos($post,$table,$montovtc,$hoy){
        $pasodos = 1; 
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_step = ?, id_proyecto = ?, dias = ?, monto_total = ?,  fecha_creacion = ? WHERE id = ?",
                array(
                    $pasodos,
                    $post['proyecto'],
                    $post['dia'],
                    $montovtc,
                    $hoy,
                    $post['idsol']
                ));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            
            echo $e;
        
        }
    }   // END UPDATE PASO 2 SOLICITUD Viaticos de addsolviaticos2.phtml


    public function UpdateSolviaticosStepUno($post,$table,$id_user,$nombre,$nombre_per,$nombre_sitio){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET fecha_inicio = ?, fecha_fin = ?, id_personal = ?, name_personal = ?, id_sitio = ?, name_sitio= ?, motivo_viaticos = ?, user_creacion = ?, name_user =? WHERE id = ?",array(
                $post['fecha_inicial'],
                $post['fecha_final'],
                $post['personal'],
                $nombre_per,
                $post['sitio'],
                $nombre_sitio,
                $post['motivo'],
                $id_user,
                $nombre,                
                $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   // END UPDATE PASO 1 SOLICITUD Viaticos de updatesolviaticos.phtml


    public function GetSolicitudesViaCount(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 0 and vs.status_pago = 0 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // Consulta Solicitudes en Proceso

    public function GetPagSolProcesoViatico($table,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 0 and vs.status_pago = 0 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Paginacion Solicitudes en Proceso

               
    public function GetSolAceptaViaticosCount(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 1 and vs.status_pago = 0 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // Solicitudes Aceptadas


    public function GetPagSolAptViatico($table,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 1 and vs.status_pago = 0 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Paginacion Solicitudes en Aceptadas  

    public function GetSolCancelViaticoCount(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 2 and vs.status_pago = 0 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // Solicitudes Canceladas


    public function GetPagSolCancelViatico($table,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 2 and vs.status_pago = 0 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Paginacion Solicitudes en Canceladas 


    public function GetSolPagadaViaticoCount(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 1 and vs.status_pago = 1 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // Solicitudes Pagada


    public function GetPagSolPagViatico($table,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 1 and vs.status_pago = 1 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Paginacion Solicitudes Pagadas


    public function GetSolPersonalVBuscar($personal,$statusstep,$statussol,$statuscom){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step = $statusstep and vs.status_solicitud = $statussol and vs.status_pago = $statuscom AND vs.id_personal = ? order by vs.id DESC",array($personal));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por personal

    public function GetSolPersonalVBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statuscom){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step = $statusstep and vs.status_solicitud = $statussol and vs.status_pago = $statuscom AND vs.id_personal = ? order by vs.id DESC LIMIT $offset,$no_of_records_per_page",array($personal));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por personal 


     public function GetSolIdVBuscar($id,$statusstep,$statussol,$statuscom){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step = $statusstep and vs.status_solicitud = $statussol and vs.status_pago = $statuscom AND vs.id = ? order by vs.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por ID

    public function GetSolIdVBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step = $statusstep and vs.status_solicitud = $statussol and vs.status_pago = $statuscom AND vs.id = ? order by vs.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por ID


    public function GetSolSitioVBuscar($sitio,$statusstep,$statussol,$statuscom){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step = $statusstep and vs.status_solicitud = $statussol and vs.status_pago = $statuscom AND vs.id_sitio = ? order by vs.id DESC",array($sitio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por sitio

    public function GetSolSitioVBuscarPag($table,$offset,$no_of_records_per_page,$sitio,$statusstep,$statussol,$statuscom){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step = $statusstep and vs.status_solicitud = $statussol and vs.status_pago = $statuscom AND vs.id_sitio = ? order by vs.id DESC LIMIT $offset,$no_of_records_per_page",array($sitio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por sitio 

    public function GetSolicitudViaContCount(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, vs.name_sitio, 
                vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, vs.comprobante_viatico, 
                vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, vs.user_autorizacion, 
                vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 1 and vs.status_pago = 0 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // Consulta Solicitudes en Proceso Contabilidad 

    public function GetPagSolProcesoViaCont($table,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, 
                vs.name_sitio, vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, 
                vs.comprobante_viatico, vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, 
                vs.user_autorizacion, vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, 
                pp.nombre as namepuesto, st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 1 and vs.status_pago = 0 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Paginacion Solicitudes en Proceso Contabilidad

    public function GetSolCancelViaCount(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, 
                vs.name_sitio, vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, 
                vs.comprobante_viatico, vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, 
                vs.user_autorizacion, vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, 
                pp.nombre as namepuesto, st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 2 and vs.status_pago = 0 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // Solicitudes Canceladas


    public function GetPagSolCancelVia($table,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, 
                vs.name_sitio, vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, 
                vs.comprobante_viatico, vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, 
                vs.user_autorizacion, vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, 
                pp.nombre as namepuesto, st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 2 and vs.status_pago = 0 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Paginacion Solicitudes en Canceladas 

    public function GetSolFinViaCount(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, 
                vs.name_sitio, vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, 
                vs.comprobante_viatico, vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, 
                vs.user_autorizacion, vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, 
                pp.nombre as namepuesto, st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 1 and vs.status_pago = 1 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // Solicitudes Terminada


    public function GetPagSolFinViaticos($table,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, 
                vs.name_sitio, vs.id_proyecto, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, 
                vs.comprobante_viatico, vs.monto_total,  vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion, 
                vs.user_autorizacion, vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago, pc.puesto, 
                pp.nombre as namepuesto, st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 1 and vs.status_pago = 1 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Paginacion Solicitudes en Terminada 

 
    public function GetDetallesViaticos($table,$id){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, 
                vs.name_sitio, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, 
                vs.comentario_cancel, vs.motivo_viaticos, vs.monto_pagado,
                vs.comprobante_viatico, vs.monto_total, vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion,
                vs.user_autorizacion, vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago,   
                pc.puesto, pc.viaticos, pc.imagen, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                WHERE vs.id = ? order by vs.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){

            echo $e;
        
        }
    }   // Detalles de solicitud

    public function UpdateAceptViaticos($post,$table,$hoy,$nombre){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_solicitud = ?, user_autorizacion = ?, fecha_autorizacion = ?, name_userautorizacion = ?  WHERE id = ?",array(
                $post['dato'],
                $post['id_user'],
                $hoy,
                $nombre,
                $post["id"]));
            $db->closeConnection();               


            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }//  UPDATE Status Solicitud a Aceptada

    public function UpdateRechazarViaticos($post,$table,$hoy,$nombre){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_solicitud = ?, user_autorizacion = ?, fecha_autorizacion = ?, name_userautorizacion = ?, comentario_cancel = ?  WHERE id = ?",array(
                $post['dato'],
                $post['id_user'],
                $hoy,
                $nombre,
                $post['comentario'],
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }//  UPDATE Status Solicitud a Rechazada


    public function UpdatePagoSolViaticos($post,$table,$hoy,$status_pago,$id_user,$nombre,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_pago = ?, fecha_pago = ?, user_pago = ?, name_userpago = ?, comprobante_viatico = ?, monto_pagado = ? WHERE id = ?",array(
                $status_pago,
                $hoy,
                $id_user,
                $nombre,
                $urldb,
                $post['monto'],
                $post['id_solicitud']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }// END UPDATE Solicitud Viaticos Pagada



    public function GetExcel(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.fecha_inicio, vs.fecha_fin, vs.id_personal, vs.name_personal, vs.id_sitio, 
                vs.name_sitio, vs.status_step, vs.status_solicitud, vs.id_proyecto, vs.dias, vs.status_pago, 
                vs.comentario_cancel, vs.motivo_viaticos, vs.monto_pagado,
                vs.comprobante_viatico, vs.monto_total, vs.fecha_creacion, vs.user_creacion, vs.name_user, vs.fecha_autorizacion,
                vs.user_autorizacion, vs.name_userautorizacion , vs.fecha_pago, vs.user_pago, vs.name_userpago,   
                pc.puesto, pc.viaticos, pc.imagen, pp.nombre as namepuesto, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM viaticos_sol vs 
                LEFT JOIN personal_campo pc ON pc.id = vs.id_personal
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios_tipoproyecto st ON st.id = vs.id_proyecto
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                where vs.status_step= 1 and vs.status_solicitud = 1 and vs.status_pago = 1 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // Solicitudes Terminada


} 