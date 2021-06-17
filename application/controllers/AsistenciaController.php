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
        if(empty($this->_session->id)){ $this->redirect('/home/login'); }    
    }

    public function cuadrillasAction(){
    	$sitio = $this->_asistencia->getallsitioscuadrilla(); 
    	$this->_asistencia->trancatecuadrilla(); 

    	$uniq_sitio = array();
    	foreach ($sitio as $key) {
    		$uniq_sitio [] = $key['name_sitio'];
    	}

    	$resultado = array_unique($uniq_sitio);
    	$table="sitios_cuadrillas";
    	foreach ($resultado as $key) {
    		$this->_asistencia->insertsitiocuadrilla($key,$table);
    	}
    	
        $table="sitios_cuadrillas";
        $this->view->sitios = $this->_season->GetAll($table); 
    }

    public function asistenciaAction(){
    	$nombre = $this->_getParam('sitio');
    	$this->view->sitio = $nombre;
    	$this->view->personal = $this->_asistencia->getpersonalsitiocuadrilla($nombre);
        $solicitud = $this->view->solicitud = $this->_asistencia->getsolicitudpendientecheckin($nombre);
        if(empty($solicitud)){
            $valor = 0;
            $this->view->op_solicitud = $valor;
        }else{
            $valor = 1;
            $this->view->op_solicitud = $valor;
        }
    }

    public function horaextraAction(){
    	$nombre = $this->_getParam('sitio');
    	$this->view->sitio = $nombre;
    	$this->view->personal = $this->_asistencia->getpersonalsitiocuadrilla($nombre);
        $solicitud = $this->view->solicitud = $this->_asistencia->getsolicitudpendiente($nombre);
        // var_dump($solicitud);exit;
        if(empty($solicitud)){
            $valor = 0;
            $this->view->op_solicitud = $valor;
        }else{
            $valor = 1;
            $this->view->op_solicitud = $valor;
        }
        // var_dump($solicitud);exit;
    }

    public function personalasistenciaAction(){
    	$sitio = $this->_getParam('sitio');
    	$this->view->sitio_name = $sitio;
       	$id=$this->_getParam('id'); $this->view->personal_id=$id;
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
            return $this-> _redirect('/asistencia/horaextra/sitio/'.$post['sitio'].'');
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
        // var_dump($post);exit;
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
            return $this-> _redirect('/asistencia/asistencia/sitio/'.$post['sitio'].'');
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
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y");

        $fecha = date("N");
        $id = $post['ids'];
        $table="personal_campo";
        $pagi_count = $this->_season->GetSpecific($table,$wh,$id);
        $proyecto =$pagi_count[0]['sitio_tipoproyectopersonal'];
        $result=$this->_asistencia->updateinasistencia($id,$table,$post,$fecha,$proyecto,$hoy);
        

        if ($result) {
            return $this-> _redirect('/asistencia/asistencia/sitio/'.$post['sitio'].'');
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

        $name_sitio = $post['sitio'];
        $wh="name_sitio";
        $table="personal_campo";
        $personal = $this->_season->GetSpecific($table,$wh,$name_sitio);

        foreach ($personal as $key) {
            $id_personal =$key['id'];
            // $name_sitio
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
            // $name_sitio
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
            return $this-> _redirect('/asistencia/asistencia/sitio/'.$post['sitio'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 

    }

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