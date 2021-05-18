<?php
class EnviosController extends Zend_Controller_Action{

    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_project = new Application_Model_GpsProyectoModel;
        $this->_servicios = new Application_Model_GpsServicioModel;
        $this->_ordencompra = new Application_Model_GpsSolicitudOrdenModel;
        $this->_envio = new Application_Model_GpsEnvioModel;

        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }
        
    }//END INIT

    public function solicitudespendientesAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

    	$solicitud = $this->_envio->getstepunoenvio();
    	$count=count($solicitud);
        if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

        $no_of_records_per_page = 20;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $id = $this->_session->id;
        $this->view->paginator= $this->_envio->getsteponepaginator($id,$offset,$no_of_records_per_page);
    }

    public function crearenvioAction(){
    	$this->view->sitios = $this->_sitio->Getordernombresitios();
        $table="vehiculos";
        $this->view->vehiculo = $this->_season->GetAll($table);

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $rol = $usr[0]['fkroles'];
        $this->view->rol = $rol;

        $id = 0;
        $wh="status_envio";
        $table="materiales_solicitud";
        $this->view->materiales = $this->_season->GetSpecific($table,$wh,$id);
    }

    public function crearenviodosAction(){
    	$id = $this->_getParam('id');
    	$this->view->id_envio =  $id;
        $table="envios_solicitud";
        $wh="id";
        $prov=$this->view->informacion = $this->_season->GetSpecific($table,$wh,$id);

        $id_sitio = $prov[0]['id_sitio'];
        if($id_sitio == 0 || $id_sitio == 10000000){
            $tipo_proyecto = 0;
            $this->view->if_proyecto=$tipo_proyecto;
        }else{
            $tipo_proyecto = 1;
            $this->view->if_proyecto=$tipo_proyecto;
            $table="sitios_tipoproyecto";
            $wh="id_sitio";
            $this->view->proyectos =$this->_sitio->gettipoproyectosolicitud($id_sitio);
        }

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $rol = $usr[0]['fkroles'];
        $this->view->rol = $rol;

    }

    public function editarpasounoAction(){
        $this->view->sitios = $this->_sitio->Getordernombresitios();
        $id = $this->_getParam('id');
        $this->view->id_envio =  $id;
        $table="envios_solicitud";
        $wh="id";
        $prov=$this->view->informacion = $this->_season->GetSpecific($table,$wh,$id);
        if($prov[0]['solicitud_materiales'] != 0){
            $material = 0;
            $this->view->sol_mat =  $material;
            $table="materiales_solicitud";
            $wh="id";
            $this->view->select_material = $this->_season->GetSpecific($table,$wh,$prov[0]['solicitud_materiales']);

        }else{
            $material = 1;
            $this->view->sol_mat =  $material;
        }
        // var_dump($prov);exit;

        $table="vehiculos";
        $this->view->vehiculo = $this->_season->GetAll($table);

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $rol = $usr[0]['fkroles'];
        $this->view->rol = $rol;

        $id = 0;
        $wh="status_envio";
        $table="materiales_solicitud";
        $this->view->materiales = $this->_season->GetSpecific($table,$wh,$id);
    }

    public function auditoriaenviosAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $step = 1;
        $status = 0;
        $en_proceso = $this->_envio->getsolicitudstepone($step,$status);
        $count_enproceso = count($en_proceso);
        $this->view->en_proceso = $count_enproceso;

        $status=$this->_getParam('status');
        $this->view->opcion_status=$status;

        if($status == 0){
            $step = 1;
            $status = 0;
            $envio = $this->_envio->getsolicitudstepone($step,$status);
            $count=count($envio);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 24;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_envio->getenviosteponepaginator($step,$status,$offset,$no_of_records_per_page);
        }

        if($status == 1){
            $step = 1;
            $status = 1;
            $envio = $this->_envio->getsolicitudstepone($step,$status);
            $count=count($envio);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 24;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_envio->getenviosteponepaginator($step,$status,$offset,$no_of_records_per_page);
        }

        if($status == 2){
            $step = 1;
            $status = 2;
            $envio = $this->_envio->getsolicitudstepone($step,$status);
            $count=count($envio);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 24;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_envio->getenviosteponepaginator($step,$status,$offset,$no_of_records_per_page);
        } 

        if($status == 3){
            $step = 1;
            $status = 3;
            $envio = $this->_envio->getsolicitudstepone($step,$status);
            $count=count($envio);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 24;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_envio->getenviosteponepaginator($step,$status,$offset,$no_of_records_per_page);
        }


    }

    public function buscadorenviosAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $step = 1;
        $status = 0;
        $en_proceso = $this->_envio->getsolicitudstepone($step,$status);
        $count_enproceso = count($en_proceso);
        $this->view->en_proceso = $count_enproceso;

        $status=$this->_getParam('status');
        $this->view->opcion_status=$status;

        $op = $this->_getParam('op'); 
        $this->view->opcion=$op;


        if($op == 1){
            $step = 1;
            $sitio=$this->_getParam('sitio');
            $this->view->sitio_selected=$sitio;
            $envio = $this->_envio->getsitioenviossearch($step,$status,$sitio);
            $count=count($envio);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $ver = $this->view->paginator= $this->_envio->getsitioenviopaginator($step,$status,$sitio,$offset,$no_of_records_per_page);
        }

        if($op == 2){
            $step = 1;
            $user=$this->_getParam('user');
            $this->view->user_selected=$user;
            $envio = $this->_envio->getuserenviossearch($step,$status,$user);
            $count=count($envio);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $ver = $this->view->paginator= $this->_envio->getuserenviopaginator($step,$status,$user,$offset,$no_of_records_per_page);
        }

        if($op == 3){
            $step = 1;
            $dia=$this->_getParam('dia'); $mes=$this->_getParam('mes'); $year=$this->_getParam('year');
            $fecha = $dia."/".$mes."/".$year;
            $this->view->fecha_selected=$fecha;
            $envio = $this->_envio->getfechaenviossearch($step,$status,$fecha);
            $count=count($envio);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $ver = $this->view->paginator= $this->_envio->getfechaenviopaginatoruser($step,$status,$fecha,$offset,$no_of_records_per_page);
        }

        if($op == 4){
            $step = 1;
            $prioridad=$this->_getParam('prioridad');
            $this->view->prioridad_selected=$prioridad;
            $envio = $this->_envio->getprioridadenviossearch($step,$status,$prioridad);
            $count=count($envio);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $ver = $this->view->paginator= $this->_envio->getprioridadenviopaginator($step,$status,$prioridad,$offset,$no_of_records_per_page);
        }

        if($op == 5){
            $step = 1;
            $envio=$this->_getParam('envio');
            $this->view->envio_selected=$envio;
            $dato = $this->_envio->gettipoenvidiadenviossearch($step,$status,$envio);
            
            $count=count($dato);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $ver = $this->view->paginator= $this->_envio->gettipoenvioenviopaginator($step,$status,$envio,$offset,$no_of_records_per_page);
        }

        if($op == 6){
            $step = 1;
            $solicitud=$this->_getParam('solicitud');
            $this->view->id_selected=$solicitud;
            $dato = $this->_envio->gettipsolicitudenviossearch($step,$status,$solicitud);
            
            $count=count($dato);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $ver = $this->view->paginator= $this->_envio->gettiposolicitudenviopaginator($step,$status,$solicitud,$offset,$no_of_records_per_page);
        }

    }

    public function statusenviosAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $step = 1;
        $status = 0;
        $user = $this->_session->id;
        $en_proceso = $this->_envio->getsolicitudsteponeuser($step,$status,$user);
        $count_enproceso = count($en_proceso);
        $this->view->en_proceso = $count_enproceso;

        $status=$this->_getParam('status');
        $this->view->opcion_status=$status;

        if($status == 0){
            $step = 1;
            $status = 0;
            $user = $this->_session->id;
            $envio = $this->_envio->getsolicitudsteponeuser($step,$status,$user);
            $count=count($envio);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 24;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_envio->getenviosteponepaginatoruser($step,$status,$user,$offset,$no_of_records_per_page);
        }

        if($status == 1){
            $step = 1;
            $status = 1;
            $user = $this->_session->id;
            $envio = $this->_envio->getsolicitudsteponeuser($step,$status,$user);
            $count=count($envio);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 24;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_envio->getenviosteponepaginatoruser($step,$status,$user,$offset,$no_of_records_per_page);
        }

        if($status == 2){
            $step = 1;
            $status = 2;
            $user = $this->_session->id;
            $envio = $this->_envio->getsolicitudsteponeuser($step,$status,$user);
            $count=count($envio);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 24;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_envio->getenviosteponepaginatoruser($step,$status,$user,$offset,$no_of_records_per_page);
        }

        if($status == 3){
            $step = 1;
            $status = 3;
            $user = $this->_session->id;
            $envio = $this->_envio->getsolicitudsteponeuser($step,$status,$user);
            $count=count($envio);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 24;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_envio->getenviosteponepaginatoruser($step,$status,$user,$offset,$no_of_records_per_page);
        }

    }


    public function enviodetailAction(){
        $status=$this->_getParam('status');
        $this->view->status = $status;
        $id=$this->_getParam('id');
        $this->view->id_envio = $id;
        $wh="id";
        $table="envios_solicitud";
        $ver = $this->view->envios= $this->_season->GetSpecific($table,$wh,$id);

        if($ver[0]['solicitud_materiales'] == 0){
            $this->view->if_envio = 0;
        }else{
            $this->view->if_envio = 1;
            $wh="id";
            $table="materiales_solicitud";
            $this->view->material_op= $this->_season->GetSpecific($table,$wh,$ver[0]['solicitud_materiales']);

        }

        // var_dump($ver);exit;    
        $id_vehiculo = $ver[0]['vehiculo'];
        $wh="id_vehiculos";
        $table="vehiculos";
        $carro= $this->view->vehiculo= $this->_season->GetSpecific($table,$wh,$id_vehiculo);

        $id_personal = 6;
        $wh="puesto";
        $table="personal_campo";
        $chofer = $this->view->chofer= $this->_season->GetSpecific($table,$wh,$id_personal);
        // var_dump($ver);exit;

        if($ver[0]['operador'] == 0){
            $this->view->op_img = 0;
        }else{
            $this->view->op_img = 1;
            $img_chofer = $ver[0]['operador'];
            $wh="id";
            $table="personal_campo";
            $this->view->imgchofer= $this->_season->GetSpecific($table,$wh,$img_chofer);
        }
        // var_dump($ver_img);exit;

        $table="vehiculos";
        $this->view->vehiculos = $this->_season->GetAll($table);


        if($ver[0]['vehiculo_final'] == 0){
            $this->view->op_vehiculo = 0;
        }else{
            $this->view->op_vehiculo = 1;
            $img_vehiculo = $ver[0]['vehiculo_final'];
            $wh="id_vehiculos";
            $table="vehiculos";
            $this->view->imgvehiculo= $this->_season->GetSpecific($table,$wh,$img_vehiculo);
        }
    }

    public function detalleenvioAction(){
        $status=$this->_getParam('status');
        $this->view->status = $status;
        $id=$this->_getParam('id');
        $this->view->id_envio = $id;
        $wh="id";
        $table="envios_solicitud";
        $ver = $this->view->envios= $this->_season->GetSpecific($table,$wh,$id);
        // var_dump($ver);exit;
        $id_vehiculo = $ver[0]['vehiculo'];
        $wh="id_vehiculos";
        $table="vehiculos";
        $carro= $this->view->vehiculo= $this->_season->GetSpecific($table,$wh,$id_vehiculo);

        $id_personal = 6;
        $wh="puesto";
        $table="personal_campo";
        $chofer = $this->view->chofer= $this->_season->GetSpecific($table,$wh,$id_personal);
        // var_dump($ver);exit;

        if($ver[0]['operador'] == 0){
            $this->view->op_img = 0;
        }else{
            $this->view->op_img = 1;
            $img_chofer = $ver[0]['operador'];
            $wh="id";
            $table="personal_campo";
            $this->view->imgchofer= $this->_season->GetSpecific($table,$wh,$img_chofer);
        }
        // var_dump($ver_img);exit;

        $table="vehiculos";
        $this->view->vehiculos = $this->_season->GetAll($table);


        if($ver[0]['vehiculo_final'] == 0){
            $this->view->op_vehiculo = 0;
        }else{
            $this->view->op_vehiculo = 1;
            $img_vehiculo = $ver[0]['vehiculo_final'];
            $wh="id_vehiculos";
            $table="vehiculos";
            $this->view->imgvehiculo= $this->_season->GetSpecific($table,$wh,$img_vehiculo);
        }
    }

    public function pdfenvioAction(){
        $status=$this->_getParam('status');
        $this->view->status = $status;

        $op_back=$this->_getParam('op');
        $this->view->op_back = $op_back;

        $id=$this->_getParam('id');
        $this->view->id_envio = $id;
        $wh="id";
        $table="envios_solicitud";
        $ver = $this->view->envios= $this->_season->GetSpecific($table,$wh,$id);

        if($ver[0]['vehiculo_final'] == 0){
           $id_vehiculo = $ver[0]['vehiculo']; 
       }else{
            $id_vehiculo = $ver[0]['vehiculo_final'];
       }

        $wh="id_vehiculos";
        $table="vehiculos";
        $this->view->vehiculo= $this->_season->GetSpecific($table,$wh,$id_vehiculo);
    }

    public function pdflogisticaAction(){
        $status=$this->_getParam('status');
        $this->view->status = $status;

        $op_back=$this->_getParam('op');
        $this->view->op_back = $op_back;

        $id=$this->_getParam('id');
        $this->view->id_envio = $id;
        $wh="id";
        $table="envios_solicitud";
        $ver = $this->view->envios= $this->_season->GetSpecific($table,$wh,$id);
        

        if($ver[0]['vehiculo_final'] == 0){
           $id_vehiculo = $ver[0]['vehiculo']; 
       }else{
            $id_vehiculo = $ver[0]['vehiculo_final'];
       }

        $wh="id_vehiculos";
        $table="vehiculos";
        $this->view->vehiculo= $this->_season->GetSpecific($table,$wh,$id_vehiculo);

        // $fecha = $ver[0]['fecha_solicitud'];
        // $wh="fecha_solicitud";
        // $table="envios_solicitud";
        // $this->view->logistica_uno = $this->_envio->getfechalogistica($fecha,$id_vehiculo);

        $user = $ver[0]['operador'];
        $wh="id";
        $table="personal_campo";
        $this->view->user= $this->_season->GetSpecific($table,$wh,$user);
    }

    public function datosfechaAction(){
        try {
            $fecha = $_POST['fecha'];
            $id_vehiculo = $_POST['vehiculo'];
            $table="envios_solicitud";
            $uno = $this->_envio->getfechalogistica($fecha,$id_vehiculo);
            $dos = $this->_envio->getfechalogisticados($fecha,$id_vehiculo);
            $aResponse = array_merge($uno,$dos);

            print json_encode( $dos, JSON_UNESCAPED_UNICODE);
            die();
        } catch (Exception $e) {
            echo "Caught exception: " . get_class($e) . "\n";
            echo "Message: " . $e->getMessage() . "\n";
        }
    }


    public function logisticaenviosAction(){
        $status=$this->_getParam('fecha');
        // var_dump($status);exit;
    }

    public function alertenvioAction(){

    }


    public function requestaddenviossteponeadminAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        // var_dump($post);exit;

        if($post['materiales'] != 0){
            $table ="materiales_solicitud";
            $this->_envio->updatematerial($post,$table);
        }

        if($post['sitio'] == "almacen"){
            $nombre_sitio = "almacen";
            $sitio_cliente = "--";
        }else{
            $sitio = $post['sitio'];
            $wh="id";
            $table="sitios";
            $sit = $this->_season->GetSpecific($table,$wh,$sitio);
            $nombre_sitio = $sit[0]['nombre'];
            $sitio_cliente = $sit[0]['id_cliente'];
        }
        // sitio INFO
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $nombre_usuario = $usr[0]['nombre']. " " .$usr[0]['ap']. " ".$usr[0]['am'];
        // usuario INFO

        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");
        // var_dump($hoy);exit;
        $hora_actual = date('h:i:s A');

        $val1 = $post['fecha_envio'];
        $fecha_actual = date("d-m-Y");

        $envio_diauno = substr($val1, 0,2); 
        $envio_diados = substr($fecha_actual, 0,2); 

        $envio_mesuno = substr($val1, 3,2); 
        $envio_mesdos= substr($fecha_actual, 3,2); 
        $hora_actual = $post['hora_envio'];

        $table="envios_solicitud";
        $result = $this->_envio->insertenviostepone($post,$table,$nombre_sitio,$sitio_cliente,$nombre_usuario,$hoy,$id,$hora_actual);

        if ($result) {
            return $this-> _redirect('/envios/crearenviodos/id/'.$result.'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }     
    }

    public function requestaddenviossteponeAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($post['sitio'] == "oficina"){
            $nombre_sitio = "Oficina";
            $sitio_cliente = "--";
        }else{
            $sitio = $post['sitio'];
            $wh="id";
            $table="sitios";
            $sit = $this->_season->GetSpecific($table,$wh,$sitio);
            $nombre_sitio = $sit[0]['nombre'];
            $sitio_cliente = $sit[0]['id_cliente'];
        }


        // sitio INFO

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $nombre_usuario = $usr[0]['nombre']. " " .$usr[0]['ap']. " ".$usr[0]['am'];
        // usuario INFO

        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");
        $hora_actual = date('h:i:s A');

        $val1 = $post['fecha_envio'];
        $fecha_actual = date("d-m-Y");

        $envio_diauno = substr($val1, 0,2); 
        $envio_diados = substr($fecha_actual, 0,2); 


        $envio_mesuno = substr($val1, 3,2); 
        $envio_mesdos= substr($fecha_actual, 3,2); 


        $suma = $envio_diados + 5 ;
        if($envio_mesdos <= $envio_mesuno){
            if($post['tipo_envio'] == 1){
                if($envio_diauno <= $envio_diados){
                    $menor = 1; // redirect menos
                    return $this-> _redirect('/envios/alertenvio');
                }
                if($envio_diauno == $envio_diados){
                    $menor = 2;
                    $hora_actual = $post['hora_envio'];
                    return $this-> _redirect('/envios/alertenvio');
                }

                if($envio_diauno >= $envio_diados){
                    $menor = 3;
                    $hora_actual = $post['hora_envio'];
                }

            }

            if($post['tipo_envio'] == 2){
                if($envio_diauno <= $suma){
                    $day = 1; // redirect
                    // return $this-> _redirect('/envios/alertenvio');
                }else{
                    $day = 2;
                }   
            }

        }else{
            $menor = 4;
            return $this-> _redirect('/envios/alertenvio');
        }

            // var_dump($suma);exit;

        // 


        $table="envios_solicitud";
        $result = $this->_envio->insertenviostepone($post,$table,$nombre_sitio,$sitio_cliente,$nombre_usuario,$hoy,$id,$hora_actual);

        if ($result) {
            return $this-> _redirect('/envios/crearenviodos/id/'.$result.'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }

    }

    public function requestupdatepasounoenvioadminAction(){
       $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        // var_dump($post);exit;
        if($post['materiales'] == 0){
            $sitio = $post['id_mat'];
            $wh="id";
            $table="materiales_solicitud";
            $sit = $this->_season->GetSpecific($table,$wh,$sitio);
            if(empty($sit)){
                $mat_select = 0;
            }else{
                $mat_select = $sit[0]['id'];
            }
        }else{

            if($post['id_mat'] == 0){
                $mat_select = 0;
            }else{
                $table = "materiales_solicitud";
                $this->_envio->updatematerial($post,$table);

                $table ="materiales_solicitud";
                $this->_envio->updatematerialdos($post,$table);
                $mat_select = $post['materiales'];
            }

        }
        // var_dump($mat_select);exit;

        $sitio = $post['sitios'];
        $wh="id";
        $table="sitios";
        $sit = $this->_season->GetSpecific($table,$wh,$sitio);
        $nombre_sitio = $sit[0]['nombre'];
        $sitio_cliente = $sit[0]['id_cliente'];
        // sitio INFO

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $nombre_usuario = $usr[0]['nombre']. " " .$usr[0]['ap']. " ".$usr[0]['am'];
        // usuario INFO
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");


        $hora_actual = date('h:i:s A');

        $val1 = $post['fecha_envio'];
        $fecha_actual = date("d-m-Y");

        $envio_diauno = substr($val1, 0,2); 
        $envio_diados = substr($fecha_actual, 0,2); 


        $envio_mesuno = substr($val1, 3,2); 
        $envio_mesdos= substr($fecha_actual, 3,2); 



        $hora_actual = $post['hora_envio'];

        $table="envios_solicitud";
        $result = $this->_envio->updateenviopasouno($post,$table,$nombre_sitio,$sitio_cliente,$nombre_usuario,$hoy,$id,$mat_select);

        if ($result) {
            return $this-> _redirect('/envios/crearenviodos/id/'.$post['ids'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }    
    }

    public function requestupdatepasounoenvioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $sitio = $post['sitios'];
        $wh="id";
        $table="sitios";
        $sit = $this->_season->GetSpecific($table,$wh,$sitio);
        $nombre_sitio = $sit[0]['nombre'];
        $sitio_cliente = $sit[0]['id_cliente'];
        // sitio INFO

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $nombre_usuario = $usr[0]['nombre']. " " .$usr[0]['ap']. " ".$usr[0]['am'];
        // usuario INFO
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");


        $hora_actual = date('h:i:s A');

        $val1 = $post['fecha_envio'];
        $fecha_actual = date("d-m-Y");

        $envio_diauno = substr($val1, 0,2); 
        $envio_diados = substr($fecha_actual, 0,2); 


        $envio_mesuno = substr($val1, 3,2); 
        $envio_mesdos= substr($fecha_actual, 3,2); 


        $suma = $envio_diados + 5 ;
        if($envio_mesdos <= $envio_mesuno){
            if($post['tipo_envio'] == 1){
                if($envio_diauno <= $envio_diados){
                    $menor = 1; // redirect menos
                    return $this-> _redirect('/envios/alertenvio');
                }
                if($envio_diauno == $envio_diados){
                    $menor = 2;
                    $hora_actual = $post['hora_envio'];
                    return $this-> _redirect('/envios/alertenvio');
                }

                if($envio_diauno >= $envio_diados){
                    $menor = 3;
                    $hora_actual = $post['hora_envio'];
                }

            }

            if($post['tipo_envio'] == 2){
                if($envio_diauno <= $suma){
                    $day = 1; // redirect
                    return $this-> _redirect('/envios/alertenvio');
                }else{
                    $day = 2;
                }   
            }

        }else{
            $menor = 4;
            return $this-> _redirect('/envios/alertenvio');
        }

        $table="envios_solicitud";
        $result = $this->_envio->updateenviopasouno($post,$table,$nombre_sitio,$sitio_cliente,$nombre_usuario,$hoy,$id);

        if ($result) {
            return $this-> _redirect('/envios/crearenviodos/id/'.$post['ids'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }
    } 

    public function requestaddenviossteptwoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $table="envios_solicitud";
        $result = $this->_envio->updateenviopasodos($post,$table);

        if ($result) {
            return $this-> _redirect('/envios/solicitudespendientes');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }
    }


    public function requestauditoriaenvioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $id= $this->_session->id;
        $table="usuario";
        $wh="id";
        $person= $this->_season->GetSpecific($table,$wh,$id);
        $nombre = $person[0]['nombre']." ".$person[0]['ap']." ".$person[0]['am'];

        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");
        // var_dump($post);exit;

        $table="envios_solicitud";
        $result = $this->_envio->updatauditoriaenvio($post,$table,$nombre,$hoy);

        if ($result) {
            return $this-> _redirect('/envios/enviodetail/id/'.$post['ids'].'/status/'.$post['status'].' ');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }
    }

    public function requestaddvehiculoenvioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        // var_dump($post);exit;

        $table="envios_solicitud";
        $result = $this->_envio->updatevehiculoenvio($post,$table);

        if ($result) {
            return $this-> _redirect('/envios/enviodetail/id/'.$post['ids'].'/status/'.$post['status'].' ');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }
    }

    public function requestaddoperadorenvioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $id= $post['op_select'];
        $table="personal_campo";
        $wh="id";
        $person= $this->_season->GetSpecific($table,$wh,$id);
        $nombre = $person[0]['nombre']." ".$person[0]['apellido_pa']." ".$person[0]['apellido_ma'];
        $table="envios_solicitud";
        $this->_envio->updateoperador($post,$table,$nombre);
        $result = $this->_envio->updatesteplogistica($post, $table);

        if ($result) {
            return $this-> _redirect('/envios/enviodetail/id/'.$post['ids'].'/status/'.$post['status'].' ');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }
    }

    public function requestaddacuseenvioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();


            $name = $_FILES['url']['name'];
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            }else{
                $bytes = $_FILES['url']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['url']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'pdf/acuse_envios/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

        // var_dump($urldb);exit;
        $table="envios_solicitud";
        $result = $this->_envio->updateacuse($post,$table,$urldb);

        if ($result) {
            return $this-> _redirect('/envios/enviodetail/id/'.$post['ids'].'/status/'.$post['status'].' ');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }
    }


    public function requestdeleteenvioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="envios_solicitud";
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
    }//END REQUEST DELETE TODO

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