<?php
class AsistenciaController extends Zend_Controller_Action{
    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_personal = new Application_Model_GpsPersonalModel;
        $this->_asistencia = new Application_Model_GpsAsistenciaModel;
        $this->_nomina = new Application_Model_GpsNominaModel;
        $this->_epp = new Application_Model_GpsEppModel;
        $this->_prestamo = new Application_Model_GpsPrestamoModel;
        if(empty($this->_session->id)){ $this->redirect('/home/login'); }    
    }

    public function demoAction(){
        
    }

    public function cuadrillasAction(){
    	$sitio = $this->_asistencia->getallsitioscuadrilla(); 
    	$this->_asistencia->trancatecuadrilla(); 

    	$uniq_sitio = array();
    	foreach ($sitio as $key) {
    		$uniq_sitio [] = $key['sitio_tipoproyectopersonal'];
    	}
    	$resultado = array_unique($uniq_sitio);
        
    	foreach ($resultado as $key) {
            $id=$key;
            $wh="id";
            $table="sitios_tipoproyecto";
            $usr = $this->_season->GetSpecific($table,$wh,$id);

            $id_sitio = $usr[0]['id_sitio'];
            $proyecto = $usr[0]['id_tipoproyecto'];

            $table="sitios";
            $sit = $this->_season->GetSpecific($table,$wh,$id_sitio);

            $nombre = $sit[0]['nombre'];
            $cliente = $sit[0]['id_cliente'];

            $table="tipo_proyecto";
            $pro = $this->_season->GetSpecific($table,$wh,$proyecto);

            $tipo_proyecto =$pro[0]['nombre_proyecto'];
            $table="sitios_cuadrillas";
    		$this->_asistencia->insertsitiocuadrilla($nombre,$cliente,$tipo_proyecto,$key,$table);
    	}
    	
        $table="sitios_cuadrillas";
        $this->view->sitios = $this->_asistencia->getsitioscuadrillasordername(); 
    }

    public function asistenciaAction(){
    	$nombre = $this->_getParam('sitio');
    	$this->view->sitio = $nombre;

        $proyecto= $this->_getParam('proyecto');
        $this->view->proyecto = $proyecto;

    	$this->view->personal = $this->_asistencia->getpersonalsitiocuadrilla($proyecto);
        $solicitud = $this->view->solicitud = $this->_asistencia->getsolicitudpendiente($proyecto);
        // var_dump($solicitud);exit;
        if(empty($solicitud)){
            $valor = 0;
            $this->view->op_solicitud = $valor;
            $this->view->as_status = $valor;
        }else{
            $valor = 1;
            $this->view->op_solicitud = $valor;
            $this->view->as_status = $valor;
        }
    }

    public function horaextraAction(){
    	$nombre = $this->_getParam('sitio');
    	$this->view->sitio = $nombre;

        $proyecto= $this->_getParam('proyecto');
        $this->view->proyecto = $proyecto;

    	$this->view->personal = $this->_asistencia->getpersonalsitiocuadrilla($proyecto);
        $solicitud = $this->view->solicitud = $this->_asistencia->getsolicitudpendiente($proyecto);
        // var_dump($solicitud);exit;
        if(empty($solicitud)){
            $valor = 0;
            $this->view->op_solicitud = $valor;
            $this->view->as_status = $valor;
        }else{
            $valor = 1;
            $this->view->op_solicitud = $valor;
            $this->view->as_status = $valor;
        }
    }

    public function historialnominaAction(){

    }

    public function personalasistenciaAction(){
    	$sitio = $this->_getParam('sitio');
    	$this->view->sitio_name = $sitio;
       	$id=$this->_getParam('id'); $this->view->personal_id=$id;
        $proyecto=$this->_getParam('proyecto'); $this->view->proyecto=$proyecto;
        $table="personal_campo";
        $wh="id";
        $info = $this->view->info_personal = $this->_season->GetSpecific($table,$wh,$id);   
        
        if($info[0]['id_sitiopersonal'] == 0){
            $sit = 0;
            $this->view->if_sitio=$sit;
        }else{
            $sit = 1;
            $this->view->if_sitio=$sit;
            $table="sitios";
            $wh="id";
            $this->view->sitio_info = $this->_season->GetSpecific($table,$wh,$info[0]['id_sitiopersonal']);  

            $table="puestos_personal";
            $wh="id";
            $puesto = $this->_season->GetSpecific($table,$wh,$info[0]['puesto']);  
            $this->view->puesto_info = $puesto[0]['nombre']; 
        }
        $id=$this->_getParam('id');
        $this->view->asistencia =$this->_asistencia->getpersonalasistencianomina($id);
        $this->view->proyectos =$this->_sitio->tiposproyectospersonal(); 

        $wh="id_personal";
        $table="personal_prestamos";
        $sol = $this->view->solicitud_prestamo = $this->_prestamo->getprestamossolicitudnomina($id);

        if(empty($sol)){
            $op = 0; $this->view->op_solicitud = $op;   // $op = "Sin datos";
        }else{          
            $op = 1; $this->view->op_solicitud = $op;  // $op = "con datos";
        }

        $rest = $this->view->herramienta_cobro = $this->_asistencia->getcobroherramientapendienteuser($id);
        if(empty($rest)){
            $op = 0; $this->view->herramienta_op = $op;   // $op = "Sin datos";
        }else{          
            $op = 1; $this->view->herramienta_op = $op;  // $op = "con datos";
        }

        $epp = $this->view->nomina_epp = $this->_epp->geteppasignarcobronomina($id);
        if(empty($epp)){
            $op = 0; $this->view->epp_op = $op;   // $op = "Sin datos";
        }else{          
            $op = 1; $this->view->epp_op = $op;  // $op = "con datos";
        }


    }

    public function editregistroasistenciaAction(){
        $user=$this->_getParam('user'); $this->view->personal_id=$user;
        $sitio = $this->_getParam('sitio');  $this->view->sitio_name = $sitio;
        $proyecto = $this->_getParam('proyecto');  $this->view->proyecto = $proyecto;
        $id_sol = $this->_getParam('id');  $this->view->id_solicitud = $id_sol;
        $this->view->proyectos =$this->_sitio->tiposproyectospersonal();  

        $id=$this->_getParam('id');
        $this->view->asistencia =$this->_asistencia->getpersonalasistencianominaregistro($id);
    } 

    public function solicitudhorasextraAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento = $status;

        $op_status = 0;
        $sol =$this->_asistencia->getprocesosolicitudhoras($op_status);
        $this->view->enproceso = count($sol);

        if($status == 0){
            $op_status = 0;
            $pagi_count = $this->_asistencia->getprocesosolicitudhoras($op_status);
            $count=count($pagi_count);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_asistencia->getcountsolhoras($offset,$no_of_records_per_page,$op_status);
        }

        if($status == 1){
            $op_status = 1;
            $pagi_count = $this->_asistencia->getprocesosolicitudhoras($op_status);
            $count=count($pagi_count);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_asistencia->getcountsolhoras($offset,$no_of_records_per_page,$op_status);
        }

        if($status == 2){
            $op_status = 2;
            $pagi_count = $this->_asistencia->getprocesosolicitudhoras($op_status);
            $count=count($pagi_count);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_asistencia->getcountsolhoras($offset,$no_of_records_per_page,$op_status);
        }
    }

    public function detallesolicitudhorasAction(){
        $id = $this->_getParam('id');
        $this->view->id_solicitud = $id;

        $wh="id";
        $table="personal_solicitudhoras";
        $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->personal= $this->_asistencia->getpersonalsolicituddetalle($id);
        $user = $this->_session->id;
        $this->view->id_user = $user;
    }

    public function pdfasistenciasolicitudAction(){
        $id = $this->_getParam('id');
        $this->view->id_solicitud = $id; 
        $wh="id";
        $table="personal_solicitudhoras";
        $this->view->solicitud= $this->_season->GetSpecific($table,$wh,$id);
        $this->view->personal= $this->_asistencia->getpersonalsolicituddetalle($id);
    }

    public function requestaddhoraextrapersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $ap_paterno = $usr[0]['ap'];
        $nombre = $usr[0]['nombre']." ".$ap_paterno;
        // Solicitud caja chica
            $table="personal_solicitudhoras";
            $id_solicitud = $this->_asistencia->isertsolicitudhoras($post,$table,$nombre,$hoy);
            $op = 0;
            $table="personal_userhoras";
            foreach ($post['personal'] as $key) {
                $id = $key;
                $value = $post['hora_extra'][$op];
                $result = $this->_asistencia->insertpersonalsolictud($post,$table,$id,$value,$hoy,$nombre,$id_solicitud);  
                $op ++;
            }
        //END solicitud caja chica

        $table = "personal_campo";
        // if($post['act_todos'] != ""){
	       //  foreach ($post['personal'] as $key) {
	       //  	$id = $key;
	       //  	$value = $post['act_todos'];
	       //  	$result = $this->_asistencia->updatehoraextra($post,$table,$id,$value,$hoy,$nombre); 
	       //  }
        // }else{
	       //  $op = 0;
	       //  foreach ($post['personal'] as $key) {
	       //  	$id = $key;
	       //  	$value = $post['hora_extra'][$op];
	       //  	$result = $this->_asistencia->updatehoraextra($post,$table,$id,$value,$hoy,$nombre);  
	       //  	$op ++;
	       //  }
        // }

        if ($result) {
            return $this-> _redirect('/asistencia/horaextra/sitio/'.$post['sitio'].'/proyecto/'.$post['proyecto'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 
    }

    public function requestchangehoraextrapersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
            $op = 0;
            $table="personal_userhoras";
            foreach ($post['personal'] as $key) {
                $id = $key;
                $value = $post['hora_extra'][$op];
                $result = $this->_asistencia->updatehoraextrasolicitud($table,$id,$value);  
                $op ++;
            }

        if ($result) {
            return $this-> _redirect('/asistencia/detallesolicitudhoras/id/'.$post['id_solicitud'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 
    }

    public function requestaddasistenciapersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($post['op_asistencia'] == 0){
            $name = $_FILES['url_entrada']['name'];
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            }else{
                $bytes = $_FILES['url_entrada']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['url_entrada']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/asistencia_personal/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url_entrada']['tmp_name'],$urldb);
                }
            }

            foreach ($post['ids'] as $key) {
                $fecha = date("N");
                date_default_timezone_set('America/Mexico_City');
                $hoy = date("d-m-Y");
                $id= $key;
                $wh="id";
                $table="personal_campo";
                $pagi_count = $this->_season->GetSpecific($table,$wh,$id);
                $proyecto =$pagi_count[0]['sitio_tipoproyectopersonal'];
                $table="personal_campo";
                $result=$this->_asistencia->updatehoraentrada($id,$table,$post,$fecha,$proyecto,$hoy,$urldb);
            }
        }else{

            $name = $_FILES['url_salida']['name'];
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            }else{
                $bytes = $_FILES['url_salida']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['url_salida']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/asistencia_personal/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url_salida']['tmp_name'],$urldb);
                }
            }

            foreach ($post['ids'] as $key) {
                $id= $key;
                $wh="id";
                $table="personal_campo";
                $pagi_count = $this->_season->GetSpecific($table,$wh,$id);
                // $hora_inicio = $pagi_count[0]['hora_inicio'];
                // $datetime1 = new DateTime($hora_inicio);
                // $datetime2 = new DateTime($post['h_salida']);
                // $interval = $datetime1->diff($datetime2);
                // $diferencia = $interval->format("%H:%I");
                $proyecto =$pagi_count[0]['sitio_tipoproyectopersonal'];
                $table="personal_campo";
                $result=$this->_asistencia->updatehorasalida($id,$table,$post,$proyecto,$urldb);
            }
        }
        
        if ($result) {
            return $this-> _redirect('/asistencia/asistencia/sitio/'.$post['sitio'].'/proyecto/'.$post['proyecto'].' ');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }   
    }

    public function requestaddinasistenciapersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost(); 
        // var_dump($post);exit;
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y");

        $fecha = date("N");
        $id = $post['ids'];
        $wh ="id";
        $table="personal_campo";
        $pagi_count = $this->_season->GetSpecific($table,$wh,$id);
        $proyecto =$pagi_count[0]['sitio_tipoproyectopersonal'];
        $result=$this->_asistencia->updateinasistencia($id,$table,$post,$fecha,$proyecto,$hoy);
        
        if ($result) {
            return $this-> _redirect('/asistencia/asistencia/sitio/'.$post['sitio'].'/proyecto/'.$post['proyecto'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 

    }

    public function requestupdatesolicitudhorasextraAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        date_default_timezone_set('America/Mexico_City');
        $today = date("d-m-Y H:i:s");
        $id=$post['id_user'];
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $nombre_usuario = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];
         $table="personal_solicitudhoras";
        $table="personal_solicitudhoras";
        $this->_asistencia->updatesolicitudhoraextra($post,$table,$today,$nombre_usuario);

        if ($result) {
            echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
        }else{
            print '<script language="JavaScript">';
            print 'alert("Ocurrio un error: Comprueba los datos.");';
            print '</script>';
        }
    }


    public function requestvaldiarusuariosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        $wh="id";
        $table="personal_solicitudhoras";
        $soli = $this->_season->GetSpecific($table,$wh,$post['solicitud']);
        $name_sitio = $soli[0]['nombre_sitio'];

        $wh="name_sitio";
        $table="personal_campo";
        $personal = $this->_season->GetSpecific($table,$wh,$name_sitio);

        foreach ($personal as $key) {
            $id_user = $key['id'];
            $table="personal_campo";
            $horaextra = 0;
            $this->_asistencia->updaterolregistrohorapersonal($id_user,$table,$horaextra);
        }

        if($post['op_status'] == 0){
            $solicitud = $post['solicitud'];
            $table="personal_userhoras";
            $this->_asistencia->updaterolregistrohorapersonaldos($solicitud,$table);
            // $this->_asistencia->updaterolregistrohorapersonal($id_user,$table,$horaextra);
        }

        foreach ($post['validar'] as $key) {
            $solicitud = $key;
            $table="personal_userhoras";
            $this->_asistencia->updaterolregistrohora($solicitud,$table);
            $wh="id";
            $table="personal_userhoras";
            $usr = $this->_season->GetSpecific($table,$wh,$solicitud);

            $horaextra = $usr[0]['hora_extra'];
            $id_user = $usr[0]['id_user'];
            $table="personal_campo";
            $this->_asistencia->updaterolregistrohorapersonal($id_user,$table,$horaextra);

            $table="personal_solicitudhoras";
            $solicitud = $post['solicitud'];
            $result =$this->_asistencia->updaterolregistrohorasolicitud($solicitud,$table);
        }

        if ($result) {
            return $this-> _redirect('/asistencia/detallesolicitudhoras/id/'.$post['solicitud'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 
    }

    public function requestaddfinalziarprocesoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        // var_dump($post);exit;
        $name_sitio = $post['proyecto'];
        $wh="sitio_tipoproyectopersonal";
        $table="personal_campo";
        $personal = $this->_season->GetSpecific($table,$wh,$name_sitio);

        foreach ($personal as $key) {
            $id_personal =$key['id'];
            $name_sitio = $key['name_sitio'];
            $hora_entrada = $key['hora_inicio'];
            $hora_salida = $key['hora_final'];
            $dia = $key['day_asistencia'];
            $dia_num = $key['day_number'];
            $hora_extra = $key['hora_extra'];
            $id_solicitudhora = $post['id_solicitudextra'];
            $proyecto_entrada = $key['proyecto_fechainicio'];
            $proyecto_salida = $key['proyecto_fechafinal'];
            $ev_entrada = $key["evidencia_entrada"];
            $ev_salida = $key["evidencia_salida"];
            $table="personal_asistencia";
            $status_asistencia = $key['status_asistencia'];
            $motivo = $key['motivo_inasistencia'];
            $result=$this->_asistencia->insertfinalizarproceso($id_personal,$name_sitio,$hora_entrada,$hora_salida,$dia,$dia_num,$hora_extra,$id_solicitudhora,$proyecto_entrada,$proyecto_salida,$ev_entrada,$ev_salida,$table,$status_asistencia,$motivo);
        } 
        // END INSERT PERSONAL (personal_asistencia)

        foreach ($personal as $key) {
            $id_personal =$key['id'];
            $name_sitio = $key['name_sitio'];
            $hora_entrada = NULL;
            $hora_salida = NULL;
            $dia = NULL;
            $dia_num = 0;
            $hora_extra = 0;
            $id_solicitudhora = 0;
            $proyecto_entrada = 0;
            $proyecto_salida = 0;
            $ev_entrada = NULL;
            $ev_salida = NULL;
            $motivo = NULL;
            $table="personal_campo";
            $status_asistencia = $key['status_asistencia'];
            $result=$this->_asistencia->updatefinalizarproceso($id_personal,$name_sitio,$hora_entrada,$hora_salida,$dia,$dia_num,$hora_extra,$id_solicitudhora,$proyecto_entrada,$proyecto_salida,$ev_entrada,$ev_salida,$table,$status_asistencia,$motivo);
        } 
        // END UPDATE PERSONAL (personal_Campo)

        $table="personal_solicitudhoras";
        $result = $this->_asistencia->updatesolicitudhoraextras($table,$post);

        if ($result) {
            return $this-> _redirect('/asistencia/asistencia/sitio/'.$post['sitio'].'/proyecto/'.$post['proyecto'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 

    }

    public function requestaddsolicitudnominaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $us=$this->_session->id;
            $wh="id";
            $table="usuario";
            $pre = $this->_season->GetSpecific($table,$wh,$us);
            $solicitud_user = $pre[0]['nombre']." ".$pre[0]['ap']." ".$pre[0]['am'];


        $id_user = $post['user'];
        $wh = "id";
        $table = "personal_campo";
        $usr = $this->_season->GetSpecific($table,$wh,$id_user);
        $name_user = $usr[0]['nombre']." ".$usr[0]['apellido_pa']." ".$usr[0]['apellido_ma'];
        $table = "personal_nomina";
        $id_solicitud = $this->_nomina->insertnominasolicitud($id_user,$name_user,$post,$table,$hoy,$name_user);
        $ver = $this->view->asistencia =$this->_asistencia->getpersonalasistencianomina($id_user);
        
        foreach ($ver as $key) {
            if($key['status_asistencia'] == 0){
                if($key['solicitud_prestamo'] == 0){ 

                    $datetime1 = new DateTime($key['hora_entrada']);
                    $datetime2 = new DateTime($key['hora_salida']);
                    $interval = $datetime1->diff($datetime2);
                    $diferencia = $interval->format("%H:%I");
                    
                    if($key['status_extra'] == 0){ 
                   
                        if($key['dia_pago'] == "" || $key['dia_pago'] == NULL){
                            $dia_pago = 0;
                        }else{
                            $dia_pago = $key['dia_pago'];
                        } 
                                    

                        if($key['hora_pago'] == "" || $key['hora_pago'] == NULL){
                            $hora_pago = 0;
                        }else{
                            $hora_pago = $key['hora_pago'];
                        } 
                                    
                 
                        if($key['day_num'] == 6 || $key['day_num'] == 7){
                            $rest = substr($diferencia, 0, -3);

                            if($rest == 5){
                                $monto = $dia_pago;
                            }

                            if($rest <= 9){
                                $total = $rest - 5;
                                $suma = $total * $hora_pago;
                                $monto = $dia_pago + $suma;
                                // echo "menor";
                            }

                            if($rest == 10){
                                $monto = $dia_pago * 2;
                            }

                            if($rest > 10){
                                $total = $rest - 10;
                                $suma = $total * $hora_pago;
                                $dia = $dia_pago*2;

                                $monto = $dia + $suma;
                                // echo "menor";
                            }

                        }else{
                            $rest = substr($diferencia, 0, -3);
                            if($rest < 10){
                                $total = $rest - 2;
                                $monto = $total * $hora_pago;
                                // echo "menor";
                            }

                            if($rest > 10){
                                $total = $rest - 10;
                                $multi = $total * $hora_pago;
                                $monto = $dia_pago + $multi;
                                // echo "mayor";
                            }

                            if($rest == 10){
                                $monto = $dia_pago;
                                // echo "igual";
                            }

                        }
                                        
                    }else{ 
                    // <!-- D I A  E X T R A -->
                        $dia_pago = $usr['dia_pago'];
                        $hora_pago = $usr['hora_pago'];
                        if($key['day_num'] == 6 || $key['day_num'] == 7){
                            $rest = substr($diferencia, 0, -3);

                            if($rest == 5){
                                $monto = 0;
                            }

                            if($rest <= 9){
                                $total = $rest - 5;
                                $monto = $total * $hora_pago;
                                // echo "menor";
                            }

                            if($rest == 10){
                                $monto = 0;
                            }

                            if($rest > 10){
                                $total = $rest - 10;
                                $suma = $total * $hora_pago;
                                $dia = $dia_pago*2;

                                $monto = $suma;
                                // echo "menor";
                            }

                        }else{
                            $rest = substr($diferencia, 0, -3);
                            if($rest < 10){
                                $total = $rest - 2;
                                $monto = $total * $hora_pago;
                                // echo "menor";
                            }

                            if($rest > 10){
                                $total = $rest - 10;
                                $multi = $total * $hora_pago;
                                $monto = $multi;
                                // echo "mayor";
                            }

                            if($rest == 10){
                                $monto = 0;
                                // echo "igual";
                            }

                        }

                    } 
                }else{
                    $monto = $key['monto_pago']; 
                } 

            }else{
                $monto = 0;
            }
            $id = $key['id_pa'];
            $monto_pago = $monto;
            $table="personal_asistencia";
            $result= $this->_nomina->updatestatusnominauser($id_solicitud,$id,$table,$monto);  
        }

        if ($result) {
            return $this->_redirect('/asistencia/personalasistencia/id/'.$post['user'].'/sitio/'.$post['sitio'].'/proyecto/'.$post['id_proyecto'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 
             
    }


    public function requestaupdatesolicitudnominaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();


        if($post['day'] == NULL || $post['day'] == ""){

        }else{
            $fecha = date($post['day']);
            $day_num =  date('N', strtotime($fecha));

            $year_uno = substr($post['day'], 0,4); 
            $mes_uno = substr($post['day'], 5,2); 
            $day_uno = substr($post['day'], 8,2); 
            $fecha_new = $day_uno."-".$mes_uno."-".$year_uno;
            $table="personal_asistencia";
            $id_solicitud = $post['id_solicitud'];
            $this->_nomina->fechapagonomina($id_solicitud,$table,$fecha_new,$day_num); 
        }


        $id_user = $post['user'];
        $wh = "id";
        $table = "personal_campo";
        $usr = $this->_season->GetSpecific($table,$wh,$id_user);
        $name_user = $usr[0]['nombre']." ".$usr[0]['apellido_pa']." ".$usr[0]['apellido_ma'];
        $table = "personal_nomina";
        $key = $this->view->asistencia =$this->_asistencia->getpersonalasistencianomina($id_user);

            $datetime1 = new DateTime($post['hora_entrada']);
            $datetime2 = new DateTime($post['hora_salida']);
            $interval = $datetime1->diff($datetime2);
            $diferencia = $interval->format("%H:%I");

            if($key[0]['solicitud_prestamo'] == 0){ 
                if($key[0]['status_extra'] == 0){ 
               
                    if($key[0]['dia_pago'] == "" || $key[0]['dia_pago'] == NULL){
                        $dia_pago = 0;
                    }else{
                        $dia_pago = $key[0]['dia_pago'];
                    } 
                                

                    if($key[0]['hora_pago'] == "" || $key[0]['hora_pago'] == NULL){
                        $hora_pago = 0;
                    }else{
                        $hora_pago = $key[0]['hora_pago'];
                    } 
                                
             
                    if($key[0]['day_num'] == 6 || $key[0]['day_num'] == 7){
                        $rest = substr($diferencia, 0, -3);

                        if($rest == 5){
                            $monto = $dia_pago;
                        }

                        if($rest <= 9){
                            $total = $rest - 5;
                            $suma = $total * $hora_pago;
                            $monto = $dia_pago + $suma;
                            // echo "menor";
                        }

                        if($rest == 10){
                            $monto = $dia_pago * 2;
                        }

                        if($rest > 10){
                            $total = $rest - 10;
                            $suma = $total * $hora_pago;
                            $dia = $dia_pago*2;

                            $monto = $dia + $suma;
                            // echo "menor";
                        }

                    }else{
                        $rest = substr($diferencia, 0, -3);
                        if($rest < 10){
                            $total = $rest - 2;
                            $monto = $total * $hora_pago;
                            // echo "menor";
                        }

                        if($rest > 10){
                            $total = $rest - 10;
                            $multi = $total * $hora_pago;
                            $monto = $dia_pago + $multi;
                            // echo "mayor";
                        }

                        if($rest == 10){
                            $monto = $dia_pago;
                            // echo "igual";
                        }

                    }
                                    
                }else{ 
                // <!-- D I A  E X T R A -->     
                    if($key[0]['day_num'] == 6 || $key[0]['day_num'] == 7){
                        $rest = substr($diferencia, 0, -3);

                        if($rest == 5){
                            $monto = 0;
                        }

                        if($rest <= 9){
                            $total = $rest - 5;
                            $monto = $total * $hora_pago;
                            // echo "menor";
                        }

                        if($rest == 10){
                            $monto = 0;
                        }

                        if($rest > 10){
                            $total = $rest - 10;
                            $suma = $total * $hora_pago;
                            $dia = $dia_pago*2;

                            $monto = $suma;
                            // echo "menor";
                        }

                    }else{
                        $rest = substr($diferencia, 0, -3);
                        if($rest < 10){
                            $total = $rest - 2;
                            $monto = $total * $hora_pago;
                            // echo "menor";
                        }

                        if($rest > 10){
                            $total = $rest - 10;
                            $multi = $total * $hora_pago;
                            $monto = $multi;
                            // echo "mayor";
                        }

                        if($rest == 10){
                            $monto = 0;
                            // echo "igual";
                        }

                    }

                } 
            }else{
                $monto = $key[0]['monto_pago']; 
            }

            if($post['day'] == NULL){ $dia = $post['dia_registro']; }else{ $dia = $post['day']; }
            $day_num =  date('N', strtotime($dia));
            

            $name = $_FILES['evi_entrada']['name'];
            if(empty($name)){ 
                $urldb = $post['validate_entrada']; 
            }else{
                $bytes = $_FILES['evi_entrada']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['evi_entrada']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/asistencia_personal/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['evi_entrada']['tmp_name'],$urldb);
                }
            }


            $name = $_FILES['evi_salida']['name'];
            if(empty($name)){ 
                $urldb_s = $post['validate_salida']; 
            }else{
                $bytes = $_FILES['evi_salida']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['evi_salida']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/asistencia_personal/';
                    $urldb_s = $url1.$info1;
                    move_uploaded_file($_FILES['evi_salida']['tmp_name'],$urldb_s);
                }
            }

            $table="personal_asistencia";
            $result= $this->_nomina->updateasistendiadaynomina($table,$post,$monto,$day_num,$urldb,$urldb_s);  

        if ($result) {
            return $this->_redirect('/asistencia/editregistroasistencia/user/'.$post['user'].'/sitio/'.$post['sitio'].'/id/'.$post['id_solicitud'].'/proyecto/'.$post['proyecto'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 

    }

    public function requestdeleteregistronominanormalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $id=$post['id'];
        $table="personal_asistencia";
        $wh="id";
        $result = $this->_season->deleteAll($id,$table,$wh);

        if ($result) {
            echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
        }else{
            print '<script language="JavaScript">';
            print 'alert("Ocurrio un error: Comprueba los datos.");';
            print '</script>';
        }
    }


    public function requestdeleteregistroasistencianominaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $wh="id";
            $table="personal_asistencia";
            $pre = $this->_season->GetSpecific($table,$wh,$id);

            if($post['op'] == 1){
                $id_prestamo = $pre[0]['solicitud_prestamo'];
                $wh="id";
                $table="personal_prestamos";
                $usr = $this->_season->GetSpecific($table,$wh,$id_prestamo);
                $cantidad  = $usr[0]['cantidad_saldada'];
                $cantidadsaldada = $cantidad - 1;
                $this->_asistencia->updatedeleteprestamoasistencia($table,$cantidadsaldada,$id_prestamo);    
            }

            if($post['op'] == 2){
                $id_herramienta = $pre[0]['solicitud_prestamo'];
                $wh="id_cobro";
                $table="cobro_herramientas";
                $usr = $this->_season->GetSpecific($table,$wh,$id_herramienta);
                $cantidad  = $usr[0]['cantidad_pago'];
                $cantidadsaldada = $cantidad - 1;
                $this->_asistencia->updatedeleteherramientaasistencia($table,$cantidadsaldada,$id_herramienta);
            }

            if($post['op'] == 3){
                $id_epp = $pre[0]['solicitud_prestamo'];
                $wh="id";
                $table="epp_asignar";
                $usr = $this->_season->GetSpecific($table,$wh,$id_epp);
                $cantidad  = $usr[0]['cantidad_pago'];
                $cantidadsaldada = $cantidad - 1;
                $this->_asistencia->updatedeleteeppasistencia($table,$cantidadsaldada,$id_epp);
            }

            $table="personal_asistencia";
            $wh="id";
            $result = $this->_season->deleteAll($id,$table,$wh);

            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST DELETE PERSONAL


    public function formatSizeUnits($bytes){
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }
        return $bytes;
    }//END FUNCION DE TAMAÑO DE IMAGEN


}