<?php
class SolicitudController extends Zend_Controller_Action{
    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_project = new Application_Model_GpsProyectoModel;
        $this->_servicios = new Application_Model_GpsServicioModel;
        $this->_ordencompra = new Application_Model_GpsSolicitudOrdenModel;
        $this->_comprobacion = new Application_Model_GpsComprobacionModel;
        $this->_cajachica = new Application_Model_GpsCajachicaModel;
        $this->_cat = new Application_Model_GpsHerramientaModel;
        $this->_epp = new Application_Model_GpsEppModel;

        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }
    }//END INIT

    public function indexAction(){

    }//index

    public function opcioneslistasolicitudesAction(){

    }

    public function successcomprobacionAction(){
        if($this->_hasParam('residente')){
            $id = $this->_getParam('residente');
            $this->view->id_user=$id;
            $wh="id";
            $table="personal_campo";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
        }
    }

    public function missolicitudesAction(){

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $id = $this->_getParam('id');
        $wh="id_usuario";
        $table="solicitud_ordencompra";
            $solicitud=$this->_season->GetSpecific($table,$wh,$id);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";
            $ver=$this->view->paginator= $this->_ordencompra->getusermissolicitudes($id,$offset,$no_of_records_per_page);
    }

    public function solicitudespagadasAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="servicios";
        $this->view->servicios = $this->_season->GetAll($table);

        $sitio = $this->_getParam('sitio');
        $this->view->nombre_sitio=$sitio;
        $solicitud=$this->_ordencompra->getusernamesolicitudcountaceptandpaysitio($sitio);
        $count=count($solicitud);

        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
        } else {
            $pagina= $this->view->pagina = 1;
        } 

        $no_of_records_per_page = 17;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $table="solicitud_ordencompra";
        $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptandpaysitio($table,$offset,$no_of_records_per_page,$sitio); 
    } 

    public function searchsolicitudespagadasAction(){
        $opcion=$this->_getParam('op');
        $this->view->opcion_search=$opcion;

        $table="servicios";
        $this->view->servicios = $this->_season->GetAll($table);

        if($opcion == 1){
            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;
            $sitio = $this->_getParam('sitio');
            $this->view->nombre_sitio=$sitio;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountaceptandpaysitio($sitio);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptandpaysitio($table,$offset,$no_of_records_per_page,$sitio);
        }

        if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov;

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagoprov($prov);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagoprov($table,$offset,$no_of_records_per_page,$prov);
        }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                $this->view->id_search=$id; 

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagoid($id);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagoid($table,$offset,$no_of_records_per_page,$id);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagouser($user);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagouser($table,$offset,$no_of_records_per_page,$user);

            }

            if($opcion == 5 ){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio;
                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagoservicio($servicio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;
                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagoserviciop($table,$offset,$no_of_records_per_page,$servicio);

            }


    }


    public function ordencompranofacturableAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;
        $wh="id_usuario";
        $table="solicitud_ordencompra";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $wh="id";
        $table="usuario";
        $user = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$user[0]['fkroles'];

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $sql = $this->_ordencompra->getsolicitudnofacturable();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table="proveedor";
        $this->view->prov = $this->_season->GetAll($table);

        $table="servicios";
        $this->view->servicios = $this->_season->GetAll($table);


        if($status == 0) {
            $solicitud=$this->_ordencompra->getsolicitudnofacturable();
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";
            $sql=$this->view->paginator= $this->_ordencompra->getusernamesolicitudnofacturable($table,$offset,$no_of_records_per_page);
        }

        if($status == 1){
            $solicitud=$this->_ordencompra->getusernamesolicitudcountaceptfacturable();
            $count=count($solicitud);

            if(isset($_GET['pagina'])) { $pagina = $_GET['pagina']; }else { $pagina= $this->view->pagina = 1; }

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptnofact($table,$offset,$no_of_records_per_page);
        }

        if($status == 2){
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcancelfacturable();
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";
            $this->view->paginator= $this->_ordencompra->getusernamesolicitudcancelfact($table,$offset,$no_of_records_per_page);
        }

        if($status == 3){
            $solicitud=$this->_ordencompra->getusernamesolicitudcountaceptpagonofact();
            // var_dump($solicitud);exit;
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagonofact($table,$offset,$no_of_records_per_page);
        }        
    }


    public function missolicitudescontabilidadAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $id = $this->_getParam('id');
        $wh="id_usuario";
        $table="solicitud_ordencompra";
            $solicitud=$this->_season->GetSpecific($table,$wh,$id);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 17;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";
            $ver=$this->view->paginator= $this->_ordencompra->getusermissolicitudes($id,$offset,$no_of_records_per_page);
    }

   	public function listaordencompraAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;
        $wh="id_usuario";
        $table="solicitud_ordencompra";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $wh="id";
        $table="usuario";
        $user = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$user[0]['fkroles'];

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

		$sql = $this->_ordencompra->getusernamesolicitudcount();
        $total = count($sql);
		$this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table="proveedor";
        $this->view->prov = $this->_season->GetAll($table);

        $table="servicios";
        $this->view->servicios = $this->_season->GetAll($table);


        if($status == 0) {

            $solicitud=$this->_ordencompra->getusernamesolicitudcount();
            $count=count($solicitud);

	        if (isset($_GET['pagina'])) {
	            $pagina = $_GET['pagina'];
	        } else {
	            $pagina= $this->view->pagina = 1;
	        } 

	        $no_of_records_per_page = 20;
	        $offset = ($pagina-1) * $no_of_records_per_page; 
	        $total_pages= $count;

	        $this->view->totalpage = $total_pages;
	        $this->view->total=ceil($total_pages/$no_of_records_per_page);
	        $table="solicitud_ordencompra";
	        $sql=$this->view->paginator= $this->_ordencompra->getusernamesolicitud($table,$offset,$no_of_records_per_page);
            // var_dump($sql);exit;
        }

        if($status == 1){
	        $solicitud=$this->_ordencompra->getusernamesolicitudcountacept();

	        $count=count($solicitud);

	        if(isset($_GET['pagina'])) { $pagina = $_GET['pagina']; }else { $pagina= $this->view->pagina = 1; }

	        $no_of_records_per_page = 20;
	        $offset = ($pagina-1) * $no_of_records_per_page; 
	        $total_pages= $count;

	        $this->view->totalpage = $total_pages;
	        $this->view->total=ceil($total_pages/$no_of_records_per_page);
	        $table="solicitud_ordencompra";
	        $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudacept($table,$offset,$no_of_records_per_page);
        }

        if($status == 2){
	        $solicitud=$this->_ordencompra->getusernamesolicitudcountcancel();
	        $count=count($solicitud);

	        if (isset($_GET['pagina'])) {
	            $pagina = $_GET['pagina'];
	        } else {
	            $pagina= $this->view->pagina = 1;
	        } 

	        $no_of_records_per_page = 20;
	        $offset = ($pagina-1) * $no_of_records_per_page; 
	        $total_pages= $count;

	        $this->view->totalpage = $total_pages;
	        $this->view->total=ceil($total_pages/$no_of_records_per_page);
	        $table="solicitud_ordencompra";
	        $this->view->paginator= $this->_ordencompra->getusernamesolicitudcancel($table,$offset,$no_of_records_per_page);
        }

        if($status == 3){
            $solicitud=$this->_ordencompra->getusernamesolicitudcountaceptpago();
            // var_dump($solicitud);exit;
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpago($table,$offset,$no_of_records_per_page);
        }
   	}

    public function listaordencomprasitionofacturableAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;

        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$usr[0]['fkroles'];

        $wh="id_usuario";
        $table="solicitud_ordencompra";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $sql = $this->_ordencompra->getusernamesolicitudcount();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table="servicios";
        $this->view->servicios = $this->_season->GetAll($table);

        $opcion = $this->_getParam('op');
        $this->view->opcion_search=$opcion;
        // var_dump($opcion);exit;
        if($status == 0) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;
                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountsearchnofact($sitio);
                // var_dump($solicitud);exit;
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $this->view->paginator= $this->_ordencompra->getusernamesolicitudsearchnofact($table,$offset,$no_of_records_per_page,$sitio);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $prov = $this->_getParam('proveedor');
                // var_dump($prov);exit;
                $this->view->nombre_prov=$prov; 
                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountsearchproveedornofact($prov);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $this->view->paginator= $this->_ordencompra->getusernamesolicitudsearchprovnofact($table,$offset,$no_of_records_per_page,$prov);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                // var_dump($id);exit;
                $this->view->id_search=$id; 
                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountsearchidnofact($id);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $this->view->paginator= $this->_ordencompra->getusernamesolicitudsearchidpagnofact($table,$offset,$no_of_records_per_page,$id);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountsearchusernofact($user);
                 // var_dump($solicitud);exit;
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $this->view->paginator= $this->_ordencompra->getusernamesolicitudsearchprovnofact($table,$offset,$no_of_records_per_page,$user);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 
                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountsearchservicionofact($servicio);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $this->view->paginator= $this->_ordencompra->getusernamesolicitudsearchservicionofact($table,$offset,$no_of_records_per_page,$servicio);     
            }

        }

        if($status == 1){
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearchnofact($sitio);
                // var_dump($solicitud);exit;
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptsitionofact($table,$offset,$no_of_records_per_page,$sitio);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov;

                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearchprovnofact($prov);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptprovnofact($table,$offset,$no_of_records_per_page,$prov);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                $this->view->id_search=$id; 

                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearchidnofact($id);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptidnofacturable($table,$offset,$no_of_records_per_page,$id);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 

                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearchusernofacturable($user);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptusernofact($table,$offset,$no_of_records_per_page,$user);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 
                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearchserviciofact($servicio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptservicionofact($table,$offset,$no_of_records_per_page,$servicio);
            }

        }

        if($status == 2){
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $solicitud=$this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountcancelsitionofact($sitio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcancelsitionofact($table,$offset,$no_of_records_per_page,$sitio);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov;
                $solicitud=$this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountcancelprovnofact($prov);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcancelprovnofact($table,$offset,$no_of_records_per_page,$prov);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                $this->view->id_search=$id; 

                $solicitud=$this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountcancelidnofact($id);
                $count=count($solicitud);
                // var_dump($solicitud);exit;

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcancelidnofact($table,$offset,$no_of_records_per_page,$id);

            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 

                $solicitud=$this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountcancelusernofact($user);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcancelusernofact($table,$offset,$no_of_records_per_page,$user);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 
                $solicitud=$this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountcancelservicionofact($servicio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcancelservicionofact($table,$offset,$no_of_records_per_page,$servicio);
            }

        }

        if($status == 3){
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagositionofact($sitio);
                $count=count($solicitud);
                // var_dump($count);exit;
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagositionofact($table,$offset,$no_of_records_per_page,$sitio);
               
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov;

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagoprovnofact($prov);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagoprovnofact($table,$offset,$no_of_records_per_page,$prov);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                $this->view->id_search=$id; 

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagoidnofact($id);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagoidnofact($table,$offset,$no_of_records_per_page,$id);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagousernofact($user);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagousernofact($table,$offset,$no_of_records_per_page,$user);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagoservicionofact($servicio);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagoserviciopnofact($table,$offset,$no_of_records_per_page,$servicio);
            }


        }
    }


    public function listaordencomprasitioAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;

        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$usr[0]['fkroles'];

        $wh="id_usuario";
        $table="solicitud_ordencompra";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $sql = $this->_ordencompra->getusernamesolicitudcount();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table="servicios";
        $this->view->servicios = $this->_season->GetAll($table);

        $opcion = $this->_getParam('op');
        $this->view->opcion_search=$opcion;
        // var_dump($opcion);exit;
        if($status == 0) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;
                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountsearch($sitio);
                // var_dump($solicitud);exit;
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $this->view->paginator= $this->_ordencompra->getusernamesolicitudsearch($table,$offset,$no_of_records_per_page,$sitio);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $prov = $this->_getParam('proveedor');
                // var_dump($prov);exit;
                $this->view->nombre_prov=$prov; 
                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountsearchproveedor($prov);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $this->view->paginator= $this->_ordencompra->getusernamesolicitudsearchprov($table,$offset,$no_of_records_per_page,$prov);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                // var_dump($id);exit;
                $this->view->id_search=$id; 
                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountsearchid($id);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $this->view->paginator= $this->_ordencompra->getusernamesolicitudsearchidpag($table,$offset,$no_of_records_per_page,$id);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountsearchuser($user);
                 // var_dump($solicitud);exit;
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $this->view->paginator= $this->_ordencompra->getusernamesolicitudsearchprov($table,$offset,$no_of_records_per_page,$user);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 
                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountsearchservicio($servicio);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $this->view->paginator= $this->_ordencompra->getusernamesolicitudsearchservicio($table,$offset,$no_of_records_per_page,$servicio);     
            }

        }

        if($status == 1){
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearch($sitio);
                // var_dump($solicitud);exit;
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptsitio($table,$offset,$no_of_records_per_page,$sitio);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov;

                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearchprov($prov);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptprov($table,$offset,$no_of_records_per_page,$prov);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                $this->view->id_search=$id; 

                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearchid($id);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptid($table,$offset,$no_of_records_per_page,$id);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 

                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearchuser($user);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptuser($table,$offset,$no_of_records_per_page,$user);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 
                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearchservicio($servicio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptservicio($table,$offset,$no_of_records_per_page,$servicio);
            }

        }

        if($status == 2){
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $solicitud=$this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountcancelsitio($sitio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcancelsitio($table,$offset,$no_of_records_per_page,$sitio);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov;
                $solicitud=$this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountcancelprov($prov);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcancelprov($table,$offset,$no_of_records_per_page,$prov);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                $this->view->id_search=$id; 

                $solicitud=$this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountcancelid($id);
                $count=count($solicitud);
                // var_dump($solicitud);exit;

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcancelid($table,$offset,$no_of_records_per_page,$id);

            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 

                $solicitud=$this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountcanceluser($user);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcanceluser($table,$offset,$no_of_records_per_page,$user);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 
                $solicitud=$this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountcancelservicio($servicio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcancelservicio($table,$offset,$no_of_records_per_page,$servicio);
            }

        }

        if($status == 3){
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagositio($sitio);
                $count=count($solicitud);
                // var_dump($count);exit;
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagositio($table,$offset,$no_of_records_per_page,$sitio);
               
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov;

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagoprov($prov);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagoprov($table,$offset,$no_of_records_per_page,$prov);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                $this->view->id_search=$id; 

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagoid($id);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagoid($table,$offset,$no_of_records_per_page,$id);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagouser($user);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagouser($table,$offset,$no_of_records_per_page,$user);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagoservicio($servicio);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagoserviciop($table,$offset,$no_of_records_per_page,$servicio);
            }


        }
    }


    public function listaordencompracoordinadorAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;
        if($status == 0){
            $id=$this->_session->id;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinador($id);
            $this->view->enproceso=count($solicitud);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 17;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";  
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinador($id,$table,$offset,$no_of_records_per_page); 
            // var_dump($sql);exit;
        }
 
    }

    public function listaordencompracoordinadorauditoriaAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;
            $id=$this->_session->id;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinador($id);
            $this->view->enproceso=count($solicitud);
            $count=count($solicitud);

            $table="servicios";
            $this->view->servicios = $this->_season->GetAll($table);

            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;  
        
            $id=$this->_session->id;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadorauditoria($id);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";   
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadorauditoria($id,$table,$offset,$no_of_records_per_page); 
    }

    public function searchlistaordencompracoordinadorauditoriaAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;
            $id=$this->_session->id;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinador($id);
            $this->view->enproceso=count($solicitud);
            $count=count($solicitud);

            $table="servicios";
            $this->view->servicios = $this->_season->GetAll($table);

            $opcion = $this->_getParam('op');
            $this->view->opcion_search=$opcion;

            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;  


            if($opcion == 1){
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $id=$this->_session->id;
                $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadorauditoriacoord($id,$sitio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadorauditoriados($id,$table,$offset,$no_of_records_per_page,$sitio); 
            }

            if($opcion == 2){
                $proveedor = $this->_getParam('proveedor');
                $this->view->nombre_prov=$proveedor;

                $id=$this->_session->id;
                $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadorauditoriacoordprov($id,$proveedor);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadorauditoriadosprov($id,$table,$offset,$no_of_records_per_page,$proveedor); 

            }

            if($opcion == 3){
                $id_sol = $this->_getParam('id');
                $this->view->id_search=$id_sol;

                $id=$this->_session->id;
                $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadorauditoriacoordidsol($id,$id_sol);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadorauditoriadosidsol($id,$table,$offset,$no_of_records_per_page,$id_sol); 

            }

            if($opcion == 5){
                $servicio = $this->_getParam('servicio');
                $this->view->servicio_search=$servicio;

                $id=$this->_session->id;
                $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadorauditoriacoordidserv($id,$servicio);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadorauditoriadosidserv($id,$table,$offset,$no_of_records_per_page,$servicio); 

            }


    }

    public function listaordencompracoordinadoraceptadasAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

            $id=$this->_session->id;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinador($id);
            $this->view->enproceso=count($solicitud);
            $count=count($solicitud);

            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;  
        
            $table="servicios";
            $this->view->servicios = $this->_season->GetAll($table);

            $id=$this->_session->id;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadoraceptadas($id);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";
                    
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadoraceptadas($id,$table,$offset,$no_of_records_per_page); 
    }

    public function searchlistaordencompracoordinadoraceptadasAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

            $table="servicios";
            $this->view->servicios = $this->_season->GetAll($table);

            $opcion = $this->_getParam('op');
            $this->view->opcion_search=$opcion;

            $id=$this->_session->id;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinador($id);
            $this->view->enproceso=count($solicitud);
            $count=count($solicitud);

            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;  
        
            if($opcion == 1){
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;
                $id=$this->_session->id;
                $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadoraceptadascoord($id,$sitio);
                $count=count($solicitud);


                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                        
                $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadoraceptadascoord($id,$table,$offset,$no_of_records_per_page,$sitio);  
            }

            if($opcion == 2){
                $proveedor = $this->_getParam('proveedor');
                $this->view->name_proveedor=$proveedor;  

                $id=$this->_session->id;
                $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadoraceptadascoordprov($id,$proveedor);
                $count=count($solicitud);


                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                        
                $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadoraceptadascoordprov($id,$table,$offset,$no_of_records_per_page,$proveedor);  
            }

            if($opcion == 3){
                $id_sol = $this->_getParam('id');
                $this->view->id_search=$id_sol; 
                $id=$this->_session->id;
                $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadoraceptadascoordidsol($id,$id_sol);
                $count=count($solicitud);


                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                        
                $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadoraceptadascoordidsol($id,$table,$offset,$no_of_records_per_page,$id_sol); 
            }

            if($opcion == 5){
                $servicio = $this->_getParam('servicio');
                $this->view->servicio_search=$servicio;

                $id=$this->_session->id;
                $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadoraceptadascoordidserv($id,$servicio);
                $count=count($solicitud);


                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                        
                $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadoraceptadascoordidserv($id,$table,$offset,$no_of_records_per_page,$servicio); 


            }
    }


    public function listaordencompracoordinadorpagadasAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;
            $id=$this->_session->id;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinador($id);
            $this->view->enproceso=count($solicitud);
            $count=count($solicitud);

            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;  
        
            $table="servicios";
            $this->view->servicios = $this->_season->GetAll($table);

            $id=$this->_session->id;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadorpagadas($id);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";        
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadorpagadas($id,$table,$offset,$no_of_records_per_page); 
    }

    public function searchlistaordencompracoordinadorpagadasAction(){
        $status = $this->_getParam('status');        
        $table="servicios";
        $this->view->servicios = $this->_season->GetAll($table);
        $this->view->status_documento=$status;
            $id=$this->_session->id;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinador($id);
            $this->view->enproceso=count($solicitud);
            $count=count($solicitud);

            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;  

            $opcion=$this->_getParam('op');
            $this->view->opcion_search=$opcion;  
        
        if($opcion == 1){
            $sitio = $this->_getParam('sitio');
            $this->view->nombre_sitio=$sitio;
            $id=$this->_session->id;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadorpagadascoord($id,$sitio);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";        
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadorpagadascoord($id,$table,$offset,$no_of_records_per_page,$sitio);  
        }

        if($opcion == 2){
            $proveedor = $this->_getParam('proveedor');
            $this->view->nombre_prov=$proveedor;
            $id=$this->_session->id;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadorpagadascoordprov($id,$proveedor);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";        
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadorpagadascoordprov($id,$table,$offset,$no_of_records_per_page,$proveedor);  
        }

        if($opcion == 3){
            $id_sol = $this->_getParam('id');
            $this->view->id_search=$id_sol;
            $id=$this->_session->id;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadorpagadascoordidsol($id,$id_sol);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";        
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadorpagadascoordidsol($id,$table,$offset,$no_of_records_per_page,$id_sol);  
        }

        if($opcion == 5){
            $servicio = $this->_getParam('servicio');
            $this->view->servicio_search=$servicio;

            $id=$this->_session->id;
            $solicitud=$this->_ordencompra->getusernamesolicitudcountcoordinadorpagadascoordidserv($id,$servicio);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";        
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudcoordinadorpagadascoordidserv($id,$table,$offset,$no_of_records_per_page,$servicio);    
        }


    }

    public function solicitudescomprasAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;
        
        $table="servicios";
        $this->view->servicios = $this->_season->GetAll($table);

        $id=59;
        $solicitud=$this->_ordencompra->getusernamesolicitudcomprasoption($id);
        $count=count($solicitud);

        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
        } else {
            $pagina= $this->view->pagina = 1;
        } 

        $no_of_records_per_page = 25;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $table="solicitud_ordencompra";        
        $this->view->paginator= $this->_ordencompra->getusernamecompraspaginator($id,$table,$offset,$no_of_records_per_page); 
    }

    public function searchordencompraareaAction(){
        $table="servicios";
        $this->view->servicios = $this->_season->GetAll($table);
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $op = $this->_getParam('op');
        $this->view->op_search=$op;

        if($op == 1){
            $id=59;
            $nombre = $this->_getParam('sitio');
            $this->view->sitio_search=$nombre;
            $solicitud=$this->_ordencompra->getsolicitudsearchcompras($id,$nombre);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";        
            $ver=$this->view->paginator= $this->_ordencompra->getsolicitudsearchcompraspag($id,$offset,$no_of_records_per_page,$nombre);  
        }

        if($op == 2){
            $id=59;
            $nombre = $this->_getParam('proveedor');
            $this->view->proveedor_search=$nombre;
            $solicitud=$this->_ordencompra->getsolicitudsearchcomprasprov($id,$nombre);
            // var_dump($solicitud);exit;
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";        
            $this->view->paginator= $this->_ordencompra->getsolicitudsearchcompraspagprov($id,$offset,$no_of_records_per_page,$nombre);  
        }     

        if($op == 3){
            $id=59;
            $nombre = $this->_getParam('id');
            $this->view->id_search=$nombre;
            $solicitud=$this->_ordencompra->getsolicitudsearchcomprasid($id,$nombre);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";        
            $this->view->paginator= $this->_ordencompra->getsolicitudsearchcompraspagid($id,$offset,$no_of_records_per_page,$nombre); 
        } 

        if($op == 5){
            $id=59;
            $nombre = $this->_getParam('servicio');
            $solicitud=$this->_ordencompra->getsolicitudsearchcompraserv($id,$nombre);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";        
            $this->view->paginator= $this->_ordencompra->getsolicitudsearchcompraspagserv($id,$offset,$no_of_records_per_page,$nombre); 
        } 


    }

	public function papelerasolicitudordencompraAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="solicitud_ordencompra";
        $pagi_count= $this->_ordencompra->Getcountsolicituddelete();
        $count=count($pagi_count);
        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
        } else {
            $pagina= $this->view->pagina = 1;
        } 

        $no_of_records_per_page = 15;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicituddelete($table,$offset,$no_of_records_per_page);
   	}

   	public function solicituddetailAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            $ver=$this->view->solicitud = $this->_ordencompra->getdetailsolicitud($id);
            // var_dump($ver);exit;
            $this->view->validacionuser = $this->_ordencompra->getdetailsolicitudvalidacion($id);
            $this->view->validacionjefe = $this->_ordencompra->getdetailsolicitudvalidacionjefe($id);

            $table = "pagos_solicitud";
            $wh = "id_solicitud";
            $this->view->pagos = $this->_season->GetSpecific($table,$wh,$id);


            $this->view->validacion = $this->_ordencompra->getdetailsolicitudvalidacion($id);
            $table = "cotizacion_solicitudordencompra";
            $wh = "id_solicitud";
            $this->view->cotizacion = $this->_season->GetSpecific($table,$wh,$id);
            $table = "comparativa_solicitudordencompra";
            $wh = "id_solicitud";
            $this->view->comparativa = $this->_season->GetSpecific($table,$wh,$id);

            $table="proveedor";
            $ver= $this->view->proveedor = $this->_season->GetAll($table);
            $table="solicitud_ordencompra";
            $wh="id";
            $this->view->informacion = $this->_season->GetSpecific($table,$wh,$id);

            $table="doc_solicitudordencompra";
            $wh="id_solicitud";
            $this->view->documentos = $this->_season->GetSpecific($table,$wh,$id);

            $id_user=$this->_session->id;
            $this->view->usuario = $id_user;

            $status = $this->_getParam('status');
            $this->view->status_back = $status;

            $wh="id";
            $table="usuario";
            $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);


        }else {
            return $this-> _redirect('/');
        }
   	}

   	public function successsolicitudcontabilidadAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            $solicitud = $this->view->solicitud = $this->_ordencompra->getdetailsolicitud($id);
            $id_solicitud = $solicitud[0]['sitio_id'];
            

            if ($id_solicitud == 0) {
            	$ciudad = "CDMX";
            	$id_cliente = "oficina";
                $proyecto= "--";
            }else{
	            $table = "sitios";
	            $wh = "id";
	            $ver = $this->_season->GetSpecific($table,$wh,$id_solicitud);	
	            $ciudad = $ver[0]['ciudad'];
	            $id_cliente = $ver[0]['id_cliente'];


                $sol = $this->_ordencompra->specificsolicitud($id);

                if($sol[0]['nombre_proyecto'] == NULL){
                    $proyecto = "--";
                }else{
                     $proyecto = $sol[0]['nombre_proyecto'];
                }
            }

            $this->view->ciudad = $ciudad;
            $this->view->cliente = $id_cliente;
            $this->view->proyecto = $proyecto;

         	$proveedor = $solicitud[0]['proveedor_id'];
	        $table = "proveedor";
	        $wh = "id";
	        $this->view->proveedor = $this->_season->GetSpecific($table,$wh,$proveedor);

         	$usuario = $solicitud[0]['id_usuario'];
	        $table = "usuario";
	        $wh = "id";
	        $this->view->usuario = $this->_season->GetSpecific($table,$wh,$usuario);


            $table="cotizacion_solicitudordencompra";
            $wh="id_solicitud";
            $this->view->cotizacion = $this->_season->GetSpecific($table,$wh,$id);
            $table="comparativa_solicitudordencompra";
            $wh="id_solicitud";
            $this->view->comparativa = $this->_season->GetSpecific($table,$wh,$id);
        }else {
            return $this-> _redirect('/');
        }
   	}

   	public function successsolicitudAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            $this->view->validacionuser = $this->_ordencompra->getdetailsolicitudvalidacion($id);
            $this->view->validacionjefe = $this->_ordencompra->getdetailsolicitudvalidacionjefe($id);
            $solicitud = $this->view->solicitud = $this->_ordencompra->getdetailsolicitud($id);
            $id_solicitud = $solicitud[0]['sitio_id'];
            
            if ($id_solicitud == 0) {
            	$ciudad = "CDMX";
            	$id_cliente = "oficina";
                $proyecto= "--";
            }else{
	            $table = "sitios";
	            $wh = "id";
	            $ver = $this->_season->GetSpecific($table,$wh,$id_solicitud);	
	            $ciudad = $ver[0]['ciudad'];
	            $id_cliente = $ver[0]['id_cliente'];
                // var_dump($id);exit;
                $sol = $this->_ordencompra->specificsolicitud($id);

                if($sol[0]['nombre_proyecto'] == NULL){
                    $proyecto = "--";
                }else{
                     $proyecto = $sol[0]['nombre_proyecto'];
                }
            }

            $this->view->ciudad = $ciudad;
            $this->view->cliente = $id_cliente;
            $this->view->proyecto = $proyecto;

         	$proveedor = $solicitud[0]['proveedor_id'];
	        $table = "proveedor";
	        $wh = "id";
	        $this->view->proveedor = $this->_season->GetSpecific($table,$wh,$proveedor);

         	$usuario = $solicitud[0]['id_usuario'];
	        $table = "usuario";
	        $wh = "id";
	        $this->view->usuario = $this->_season->GetSpecific($table,$wh,$usuario);

            $table="cotizacion_solicitudordencompra";
            $wh="id_solicitud";
            $this->view->cotizacion = $this->_season->GetSpecific($table,$wh,$id);
            $table="comparativa_solicitudordencompra";
            $wh="id_solicitud";
            $this->view->comparativa = $this->_season->GetSpecific($table,$wh,$id);
        }else {
            return $this-> _redirect('/');
        }
   	}

   	public function listarolsolicitudesAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $rol = $usr[0]['fkroles'];

        $ct = $this->_ordencompra->getusernamesolicitudroluserprocesocountall($rol);
        $this->view->enproceso=count($ct);

        $table="servicios";
        $this->view->servicios = $this->_season->GetAll($table);

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;
        if($status == 0){
	        $table="solicitud_ordencompra";
	        $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocount($rol);
	        $count=count($solicitud);

	        if (isset($_GET['pagina'])) {
	            $pagina = $_GET['pagina'];
	        } else {
	            $pagina= $this->view->pagina = 1;
	        } 

	        $no_of_records_per_page = 20;
	        $offset = ($pagina-1) * $no_of_records_per_page; 
	        $total_pages= $count;

	        $this->view->totalpage = $total_pages;
	        $this->view->total=ceil($total_pages/$no_of_records_per_page);
	        $table="solicitud_ordencompra";
	        $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserproceso($table,$offset,$no_of_records_per_page,$rol);
        }

        if($status == 1){
            $table="solicitud_ordencompra";
            $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountacept($rol);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesoacpt($table,$offset,$no_of_records_per_page,$rol);
        }

        if($status == 2){
	        $table="solicitud_ordencompra";
	        $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountrech($rol);
	        $count=count($solicitud);

	        if (isset($_GET['pagina'])) {
	            $pagina = $_GET['pagina'];
	        } else {
	            $pagina= $this->view->pagina = 1;
	        } 

	        $no_of_records_per_page = 17;
	        $offset = ($pagina-1) * $no_of_records_per_page; 
	        $total_pages= $count;

	        $this->view->totalpage = $total_pages;
	        $this->view->total=ceil($total_pages/$no_of_records_per_page);
	        $table="solicitud_ordencompra";
	        $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesorech($table,$offset,$no_of_records_per_page,$rol);
        }

        if($status == 3){
            $table="solicitud_ordencompra";
            $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountaceptpago($rol);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesoacptpago($table,$offset,$no_of_records_per_page,$rol);
        }
   	}

    public function listarolsolicitudessitioAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $rol = $usr[0]['fkroles'];

        $table="servicios";
        $this->view->servicios = $this->_season->GetAll($table);

        $ct = $this->_ordencompra->getusernamesolicitudroluserprocesocountall($rol);
        $this->view->enproceso=count($ct);

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;


        $opcion=$this->_getParam('op');
        $this->view->opcion_search=$opcion;

//------------------------
        if($status == 0){
            if($opcion == 1){
                $status = $this->_getParam('status');
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountenc($rol,$sitio);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesoenc($table,$offset,$no_of_records_per_page,$rol,$sitio);
            }

            if($opcion == 2){
                $proveedor = $this->_getParam('proveedor');
                $this->view->nombre_prov=$proveedor;

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesoprove($rol,$proveedor);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesoprov($table,$offset,$no_of_records_per_page,$rol,$proveedor);
            } 

            if($opcion == 3){
                $id = $this->_getParam('id');
                $this->view->id_search=$id;

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesoid($rol,$id);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesoids($table,$offset,$no_of_records_per_page,$rol,$id);
            }


            if($opcion == 5){
                $servicio = $this->_getParam('servicio');
                $this->view->servicio_search=$servicio;

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesorolservicio($rol,$servicio);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocidservicio($table,$offset,$no_of_records_per_page,$rol,$id);
            }

        }

//------------------------
         if($status == 1){
            if($opcion == 1){
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountaceptenc($rol,$sitio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesoacptenc($table,$offset,$no_of_records_per_page,$rol,$sitio);                
            }

            if($opcion == 2){
                $proveedor = $this->_getParam('proveedor');
                $this->view->nombre_prov=$proveedor;

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesoaceptencprov($rol,$proveedor);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesoacptencprov($table,$offset,$no_of_records_per_page,$rol,$proveedor);  
            }

            if($opcion == 3){
                $id = $this->_getParam('id');
                $this->view->id_search=$id;

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesoaceptencidrol($rol,$id);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesoacptencidrol($table,$offset,$no_of_records_per_page,$rol,$id);  
            }

            if($opcion == 5){
                $servicio = $this->_getParam('servicio');
                $this->view->servicio_search=$servicio;

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesoaceptencidserv($rol,$servicio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesoacptencidservi($table,$offset,$no_of_records_per_page,$rol,$servicio); 

            }

        }

//------------------------
        if($status == 2){

            if($opcion == 1){
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountrechenc($rol,$sitio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesorechenc($table,$offset,$no_of_records_per_page,$rol,$sitio);
            }

            if($opcion == 2){
                $proveedor = $this->_getParam('proveedor');
                $this->view->nombre_prov=$proveedor;

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountrechencprov($rol,$proveedor);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesorechencprov($table,$offset,$no_of_records_per_page,$rol,$proveedor);
            }

            if($opcion == 3){
                $id = $this->_getParam('id');
                $this->view->id_search=$id;

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountrecheids($rol,$id);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesorechenid($table,$offset,$no_of_records_per_page,$rol,$id);

            }

            if($opcion == 5){
                $servicio = $this->_getParam('servicio');
                $this->view->servicio_search=$servicio;  

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountrecheidserv($rol,$servicio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesorechenidserv($table,$offset,$no_of_records_per_page,$rol,$servicio);

            }
        }

//------------------------
        if($status == 3){

            if($opcion == 1){
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountaceptpagoenc($rol,$sitio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesoacptpagoenc($table,$offset,$no_of_records_per_page,$rol,$sitio);
            }

            if($opcion == 2){
                $proveedor = $this->_getParam('proveedor');
                $this->view->nombre_prov=$proveedor;   

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountaceptpagoencprov($rol,$proveedor);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesoacptpagoencprov($table,$offset,$no_of_records_per_page,$rol,$proveedor);   
            }

            if($opcion == 3){
                $id = $this->_getParam('id');
                $this->view->id_search=$id;


                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountaceptpagoencid($rol,$id);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesoacptpagoencid($table,$offset,$no_of_records_per_page,$rol,$id);  
            }

            if($opcion == 5){
                $servicio = $this->_getParam('servicio');
                $this->view->servicio_search=$servicio;  

                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountaceptpagoencserv($rol,$servicio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesoacptpagoencserv($table,$offset,$no_of_records_per_page,$rol,$servicio); 

            }

        }  
    }

   	public function listarolsolicitudescontabilidadAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $rol = $usr[0]['fkroles'];
	        $table="solicitud_ordencompra";
            $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocount($rol);
            $this->view->enproceso=count($solicitud);
	        $count=count($solicitud);

            $status = $this->_getParam('status');
            $this->view->status_documento=$status;

            $table="servicios";
            $this->view->servicios = $this->_season->GetAll($table);

            if($status == 0){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocount($rol);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 17;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserproceso($table,$offset,$no_of_records_per_page,$rol);

            }

            if($status == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $solicitud=$this->_ordencompra->getusernamesolicitudcountacept();
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 17;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudacept($table,$offset,$no_of_records_per_page);
                // var_dump($sql);exit;
            }

            if($status == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id=$this->_session->id;
                $wh="id";
                $table="usuario";
                $usr = $this->_season->GetSpecific($table,$wh,$id);
                $rol = $usr[0]['fkroles'];
                
            $table="solicitud_ordencompra";
            $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountrech($rol);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 17;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="solicitud_ordencompra";
            $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesorech($table,$offset,$no_of_records_per_page,$rol);
            }

            if($status == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $solicitud=$this->_ordencompra->getusernamesolicitudcountaceptandpay();
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 17;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptandpay($table,$offset,$no_of_records_per_page);
            }
   	}

    public function listarolsolicitudescontabilidadsitioAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $rol = $usr[0]['fkroles'];
            $table="solicitud_ordencompra";
            $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocount($rol);
            $this->view->enproceso=count($solicitud);
            $count=count($solicitud);

            $status = $this->_getParam('status');
            $this->view->status_documento=$status;

            $opcion = $this->_getParam('op');
            $this->view->opcion_search=$opcion;

        $table="servicios";
        $this->view->servicios = $this->_season->GetAll($table);

            if($status == 0){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $sitio = $this->_getParam('sitio');
                $this->view->actpage=$actualpagina;
                $this->view->nombre_sitio=$sitio;
                $table="solicitud_ordencompra";
                $solicitud=$this->_ordencompra->getusernamesolicitudroluserprocesocountsitio($rol,$sitio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 17;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudroluserprocesositio($table,$offset,$no_of_records_per_page,$rol, $sitio);

            }

        if($status == 1){
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearch($sitio);
                // var_dump($solicitud);exit;
                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptsitio($table,$offset,$no_of_records_per_page,$sitio);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov;

                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearchprov($prov);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptprov($table,$offset,$no_of_records_per_page,$prov);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                $this->view->id_search=$id; 

                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearchid($id);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptid($table,$offset,$no_of_records_per_page,$id);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 

                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearchuser($user);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptuser($table,$offset,$no_of_records_per_page,$user);

            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio;

                $solicitud=$this->view->total_sitio=$this->_ordencompra->getusernamesolicitudcountjefesearchservicio($servicio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptservicio($table,$offset,$no_of_records_per_page,$servicio);
            }

        }

        if($status == 3){
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagositio($sitio);
                $count=count($solicitud);
                // var_dump($count);exit;
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagositio($table,$offset,$no_of_records_per_page,$sitio);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov;

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagoprov($prov);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagoprov($table,$offset,$no_of_records_per_page,$prov);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                $this->view->id_search=$id; 

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagoid($id);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagoid($table,$offset,$no_of_records_per_page,$id);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 

                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagouser($user);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagouser($table,$offset,$no_of_records_per_page,$user);

            }

            if($opcion == 5 ){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio;
                $solicitud= $this->view->total_sitio= $this->_ordencompra->getusernamesolicitudcountaceptpagoservicio($servicio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;
                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="solicitud_ordencompra";
                $sql= $this->view->paginator= $this->_ordencompra->getusernamesolicitudaceptpagoserviciop($table,$offset,$no_of_records_per_page,$servicio);
                // var_dump($sql);exit;

            }
        }
    }


   	public function solicituddetailencargadoAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            $ver= $this->view->solicitud = $this->_ordencompra->getdetailsolicitud($id);
            $this->view->validacionuser = $this->_ordencompra->getdetailsolicitudvalidacion($id);
            $this->view->validacionjefe = $this->_ordencompra->getdetailsolicitudvalidacionjefe($id);
            $table = "pagos_solicitud";
            $wh = "id_solicitud";
            $this->view->pagos = $this->_season->GetSpecific($table,$wh,$id);

            $table = "cotizacion_solicitudordencompra";
            $wh = "id_solicitud";
            $this->view->cotizacion = $this->_season->GetSpecific($table,$wh,$id);
            $table = "comparativa_solicitudordencompra";
            $wh = "id_solicitud";
            $this->view->comparativa = $this->_season->GetSpecific($table,$wh,$id);

            $table="proveedor";
            $this->view->proveedor = $this->_season->GetAll($table);
            $table="solicitud_ordencompra";
            $wh="id";
            $this->view->informacion = $this->_season->GetSpecific($table,$wh,$id);
            $table="doc_solicitudordencompra";
            $wh="id_solicitud";
            $this->view->documentos = $this->_season->GetSpecific($table,$wh,$id);
            $id_user=$this->_session->id;
            $this->view->usuario = $id_user;
            $wh="id";
            $table="usuario";
            $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);

        }else {
            return $this-> _redirect('/');
        }
   	}

    public function detallesolicitudcreadaAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            $ver = $this->view->solicitud = $this->_ordencompra->getdetailsolicitud($id);
            // var_dump($ver);exit;
            $this->view->validacionuser = $this->_ordencompra->getdetailsolicitudvalidacion($id);
            $this->view->validacionjefe = $this->_ordencompra->getdetailsolicitudvalidacionjefe($id);

            $table = "cotizacion_solicitudordencompra";
            $wh = "id_solicitud";
            $this->view->cotizacion = $this->_season->GetSpecific($table,$wh,$id);
            $table = "comparativa_solicitudordencompra";
            $wh = "id_solicitud";
            $this->view->comparativa = $this->_season->GetSpecific($table,$wh,$id);

            $table="proveedor";
            $this->view->proveedor = $this->_season->GetAll($table);
            $table="solicitud_ordencompra";
            $wh="id";
            $ver = $this->view->informacion = $this->_season->GetSpecific($table,$wh,$id);

            $table="pagos_solicitud";
            $wh="id_solicitud";
            $ver = $this->view->pago = $this->_season->GetSpecific($table,$wh,$id);
            // var_dump($ver);exit;
            // var_dump($ver);exit;
            $table="doc_solicitudordencompra";
            $wh="id_solicitud";
            $this->view->documentos = $this->_season->GetSpecific($table,$wh,$id);
            $id_user=$this->_session->id;
            $this->view->usuario = $id_user;
            $wh="id";
            $table="usuario";
            $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);
        }else {
            return $this-> _redirect('/');
        }
    }

    public function solicituddetailcoordinadorAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            $this->view->solicitud = $this->_ordencompra->getdetailsolicitud($id);
            $this->view->validacionuser = $this->_ordencompra->getdetailsolicitudvalidacion($id);
            $this->view->validacionjefe = $this->_ordencompra->getdetailsolicitudvalidacionjefe($id);

            $table = "pagos_solicitud";
            $wh = "id_solicitud";
            $this->view->pagos = $this->_season->GetSpecific($table,$wh,$id);

            $table = "cotizacion_solicitudordencompra";
            $wh = "id_solicitud";
            $this->view->cotizacion = $this->_season->GetSpecific($table,$wh,$id);
            $table = "comparativa_solicitudordencompra";
            $wh = "id_solicitud";
            $this->view->comparativa = $this->_season->GetSpecific($table,$wh,$id);

            $table="proveedor";
            $this->view->proveedor = $this->_season->GetAll($table);
            $table="solicitud_ordencompra";
            $wh="id";
            $this->view->informacion = $this->_season->GetSpecific($table,$wh,$id);
            $table="doc_solicitudordencompra";
            $wh="id_solicitud";
            $this->view->documentos = $this->_season->GetSpecific($table,$wh,$id);
            $id_user=$this->_session->id;
            $this->view->usuario = $id_user;
        }else {
            return $this-> _redirect('/');
        }
    }

    public function combrobacionesAction(){
        $id=30;
        $id_dos=31;
        $wh="puesto";
        $dos=$this->view->residentes = $this->_ordencompra->Getpersonalcomprobaciones();
    }


    public function generarcombrobacionesAction(){
        $id=30;
        $id_dos=31;
        $wh="puesto";
        $dos=$this->view->residentes = $this->_ordencompra->Getpersonalcomprobaciones();
        $this->view->factura = $this->_comprobacion->getallfacturas();

        $table="servicios_comprobaciones";
        $this->view->servicios = $this->_season->GetAll($table);

        $id=0;
        $wh="status_back";
        $table="comprobacion_back";
        $solicitud = $this->_season->GetSpecific($table,$wh,$id);
        $count = count($solicitud);
        $this->view->count_solicitud = $count;
    }

    public function comprobacionesAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $wh = "id";
            $table = "personal_campo";
            $this->view->residente_info = $this->_season->GetSpecific($table,$wh,$id);

            $this->view->residente_id = $id;
            $this->view->residentes = $this->_ordencompra->Getresidentessitio($id);


            $aceptada = 2;
            $pago = 1;
            $solicitud = $this->_comprobacion->getcomprobacionprocesoresidente($aceptada,$pago,$id);
            $count = count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $ver = $this->view->comprobacion= $this->_comprobacion->getpaginatorcomprobacionresidente($aceptada,$pago,$id,$offset,$no_of_records_per_page);

            // $table="comprobaciones";
            // $sitios=$this->_ordencompra->Getcomprobacionproceso($id);
            // $count=count($sitios);
            // $this->view->enproceso = $count;

            // $table="comprobaciones_generadas";
            // $wh="id_residente";
            // $sitios=$this->_season->GetSpecific($table,$wh,$id); 
            // $count=count($sitios);

            // if (isset($_GET['pagina'])) {
            //     $pagina = $_GET['pagina'];
            // } else {
            //     $pagina= $this->view->pagina = 1;
            // } 

            // $no_of_records_per_page = 17;
            // $offset = ($pagina-1) * $no_of_records_per_page; 
            // $total_pages= $count;
            // $this->view->totalpage = $total_pages;
            // $this->view->total=ceil($total_pages/$no_of_records_per_page);
            // $sql= $this->view->comprobacion= $this->_comprobacion->Getpaginationcomprobacionesgeneradasresidente($id,$offset,$no_of_records_per_page); 
        } 

    }

    public function residentedetailAction(){
        if($this->_hasParam('residente')){
            $id = $this->_getParam('residente');
            $wh="id";
            $table="personal_campo";
            $this->view->residente_info = $this->_season->GetSpecific($table,$wh,$id);

            $this->view->residente_id = $id;
            $this->view->residentes = $this->_ordencompra->Getresidentessitio($id);
            $id_comprobacion = $this->_getParam('id');
            $comprobaciones = $this->_comprobacion->Getpaginationcomprobacionesgeneradas($id_comprobacion);
            $count=count($comprobaciones);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 17;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;
            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->comprobacion= $this->_comprobacion->Getpaginationcomprobacionesgeneradaspaginator($id_comprobacion,$offset,$no_of_records_per_page); 
        }
    }

    public function comprobacionesresidenteAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        if($this->_hasParam('id')){
        $table="categoria_herramienta";
        $this->view->cat = $this->_season->GetAll($table);
        $table="sitios";
        $this->view->sitio = $this->_season->GetAll($table);
        $table="personal_campo";
        $this->view->per = $this->_season->GetAll($table);

            $table="epp_tipo";
            $this->view->tipo_epp= $this->_season->GetAll($table);

            $table="epp_catalogo";
            $hola=$this->view->eppn= $this->_epp->Getcatalogo($table);

            $table = "sitios";
            $this->view->sitios = $this->_sitio->Getordernombresitios();

            $id = $this->_getParam('id');
            $this->view->user = $id; 
            $this->view->personal_epp= $this->_epp->GetPersonalEpp($id);
            $wh="id";
            $table="personal_campo";
            $this->view->residente_info = $this->_season->GetSpecific($table,$wh,$id);

            $this->view->residente_id = $id;
            $this->view->residentes = $this->_ordencompra->Getresidentessitio($id);
            $table="comprobaciones";
            $sitios=$this->_ordencompra->Getcomprobacionproceso($id);
            $count=count($sitios);
            $this->view->enproceso = $count;

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 17;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;
            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->comprobacion= $this->_ordencompra->Getpaginationcomprobacionresidente($id,$offset,$no_of_records_per_page); 
            // var_dump($sql);exit;
            $id=$id;
            $wh="id_residente";
            $table="comprobacion_solicitud";
            $resi = $this->_season->GetSpecific($table,$wh,$id);

            $table = "sitios";
            $servicios = $this->view->sitios = $this->_sitio->Getordernombresitios();
            $table="tipo_proyecto";
            $this->view->tipoproyecto = $this->_season->GetAll($table);

            $wh="id_residente";
            $table = "comprobacion_residente";
            $dato = $this->view->residente_comp = $this->_season->GetSpecific($table,$wh,$id);
            // var_dump($dato);exit;
            if(empty($dato)){
                $com_res = 0;
                $this->view->residente_comprobacion = $com_res;
            }else{
                $com_res = 1;
                $this->view->residente_comprobacion = $com_res;

                $table="sitios_tipoproyecto";
                $wh="id_sitio";
                $this->view->proyectos_tipo =$this->_sitio->gettipoproyectosolicitud($dato[0]['id_sitio']);
            }

            $wh="id_residente";
            $table="comprobacion_residente";
            $ver = $this->_season->GetSpecific($table,$wh,$id);

            
            if(empty($ver)){
                $id_residente = 0; $this->view->id_residente = $id_residente;
            }else{
                $id_residente = 1; $this->view->id_residente = $id_residente;
            }


            $wh="id_residente";
            $table="comprobacion_solicitud";
            $solicitud = $this->_comprobacion->getresidentecomprobacion($id);

            if(empty($solicitud)){
                $sol = 0; $this->view->sol = $sol; 
            }else{
                $dos = end ($solicitud);
                $this->view->sol_id = $dos['id']; $this->view->nombre_sitio = $dos['nombre_sitio']; 
                $this->view->nombre_proyecto = $dos['nombre_tipoproyecto']; $this->view->sol_monto = $dos['monto'];
                $this->view->autorizacion = $dos['autorizacion_status']; 
                $this->view->pago = $dos['pago_status']; 
                $this->view->monto_anterior = $dos['monto_anterior'];
                $this->view->end_solicitud = $dos;
                $status_comprobacion= $this->status_comprobacion = $dos['status_comprobacion'];
                $this->view->statusresta = $dos['status_resta'];
                if($status_comprobacion == 0){
                    $sol = 1; $this->view->sol = $sol; 
                }else{
                    $sol = 0; $this->view->sol = $sol; 
                }
            }

        }else {
            return $this-> _redirect('/');
        }
    }

    public function comprobacioneditAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $wh="id";
            $table="comprobaciones";
            $usr = $this->view->comprobacion= $this->_season->GetSpecific($table,$wh,$id);

            $id=30; $id_dos=31;
            $wh="puesto";
            $dos=$this->view->residentes = $this->_ordencompra->Getresidentes($id,$id_dos);

            $table="servicios";
            $this->view->servicio = $this->_season->GetAll($table);

            $user = $this->_getParam('user');
            $this->view->user_id = $user;

            $table="factura_efecticard";
            $this->view->factura = $this->_season->GetAll($table);

        } else {
            return $this-> _redirect('/');
        }
    }

    public function comprobacionresidenteauditadaAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->residente_id = $id;
            $wh="id";
            $table="personal_campo";
            $this->view->residente_info = $this->_season->GetSpecific($table,$wh,$id);

            $sitios=$this->_ordencompra->Getcomprobacionproceso($id);
            $count=count($sitios);
            $this->view->enproceso = $count;

            $sitios= $this->view->comprobacionuno= $this->_ordencompra->Getcomprobacionauditada($id);
            $count=count($sitios);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 17;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;
            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->comprobacion= $this->_ordencompra->Getpaginationcomprobacionresidenteauditada($id,$offset,$no_of_records_per_page); 
            // var_dump($sql);exit;

            $id=$id;
            $wh="id_residente";
            $table="comprobacion_solicitud";
            $resi = $this->_season->GetSpecific($table,$wh,$id);

            $table = "sitios";
            $servicios = $this->view->sitios = $this->_sitio->Getordernombresitios();
            $table="tipo_proyecto";
            $this->view->tipoproyecto = $this->_season->GetAll($table);

            $wh="id_residente";
            $table = "comprobacion_residente";
            $dato = $this->view->residente_comp = $this->_season->GetSpecific($table,$wh,$id);
            if(empty($dato)){
                $com_res = 0;
                $this->view->residente_comprobacion = $com_res;
            }else{
                $com_res = 1;
                $this->view->residente_comprobacion = $com_res;

                $table="sitios_tipoproyecto";
                $wh="id_sitio";
                $this->view->proyectos_tipo =$this->_sitio->gettipoproyectosolicitud($dato[0]['id_sitio']);
            }

            $wh="id_residente";
            $table="comprobacion_residente";
            $ver = $this->_comprobacion->getresidentecomprobacion($id);
            
            if(empty($ver)){
                $id_residente = 0; $this->view->id_residente = $id_residente;
            }else{
                $id_residente = 1; $this->view->id_residente = $id_residente;
            }


            $wh="id_residente";
            $table="comprobacion_solicitud";
            $solicitud = $this->_season->GetSpecific($table,$wh,$id);

            if(empty($solicitud)){
                $sol = 0; $this->view->sol = $sol; 
            }else{
                $dos = end ($solicitud);
                $this->view->sol_id = $dos['id']; $this->view->nombre_sitio = $dos['nombre_sitio']; 
                $this->view->nombre_proyecto = $dos['nombre_tipoproyecto']; $this->view->sol_monto = $dos['monto'];
                $this->view->autorizacion = $dos['autorizacion_status']; 
                $pay = $this->view->pago = $dos['pago_status'];
                $this->view->end_solicitud = $dos;
                $status_comprobacion = $this->view->status_comprobacion = $dos['status_comprobacion'];
                $monto_anterior = $this->view->monto_anterior = $dos['monto_anterior'];
                $this->view->residente_name = $dos['nombre_residente'];

                if($status_comprobacion == 0){
                    $sol = 1; $this->view->sol = $sol; 
                }else{
                    $sol = 0; $this->view->sol = $sol; 
                }

            }

        } else {
            return $this-> _redirect('/');
        } 
    }

    public function comprobaciondetailAction(){
        if($this->_hasParam('id')){
            $table="sitios";
            $this->view->sitios = $this->_sitio->Getordernombresitios();
            $id = $this->_getParam('id');
            $this->view->id_comprobaciones = $id;

            $table="tipo_proyecto";
            $this->view->material = $this->_season->GetAll($table);

            $table="sitios";
            $this->view->sit = $this->_season->GetAll($table);
            $wh="id";
            $table="comprobaciones";
            $com=$this->view->comprobacion = $this->_ordencompra->Getcomprobacionspecificdos($id);
            // var_dump($com);exit;
            $factura = $com[0]['factura'];
            $table="comprobaciones";
            $wh = "factura";
            $usr =$this->view->factura_repetida =$this->_ordencompra->Getcomprobacionsfacturarepetida($factura);
            
            $valor = count($usr);
            $this->view->repetido=$valor;
            $id_sitio = $com[0]['id_sitio'];
            if($id_sitio == 0){
                $tipo_proyecto = 0;
                $this->view->if_proyecto=$tipo_proyecto;
            }else{
                $tipo_proyecto = 1;
                $this->view->if_proyecto=$tipo_proyecto;

                $table="sitios_tipoproyecto";
                $wh="id_sitio";
                $this->view->proyectos =$this->_sitio->gettipoproyectosolicitud($id_sitio);
                
                $table="sitios";
                $wh="id";
                $ver= $this->view->sitio = $this->_season->GetSpecific($table,$wh,$com[0]['id_sitio']); 
            }

            $id = $this->_getParam('id');
            $this->view->id_comprobacion = $id;
            $user = $this->_getParam('user');
            $this->view->user = $user;
            $status = $this->_getParam('status');
            $this->view->status = $status;

            $wh="id_residente";
            $table="comprobacion_solicitud";
            $solicitud = $this->_season->GetSpecific($table,$wh,$user);
            $sol = end($solicitud);
            // var_dump($sol);exit;
            $this->view->id_sol = $sol['id'];  $this->view->solid_sitio = $sol['id_sitio']; 
            $this->view->sol_namesitio = $sol['nombre_sitio'];  $this->view->id_tipoproyecto = $sol['id_tipoproyecto'];
            $this->view->sol_monto = $sol['monto']; $this->view->autorizacion_status = $sol['autorizacion_status'];
            $this->view->pago = $sol['pago_status']; $this->view->nombre_tipoproyecto = $sol['nombre_tipoproyecto'];
            $this->view->monto_anterior = $sol['monto_anterior'];
        }
    }

    public function comprobaciondetailauditadaAction(){
        if($this->_hasParam('id')){
            $table="sitios";
            $this->view->sitios = $this->_sitio->Getordernombresitios();
            $id = $this->_getParam('id');
            $wh="id";
            $table="comprobaciones";
            $this->view->comprobacion = $this->_ordencompra->Getcomprobacionspecific($id);

            $id = $this->_getParam('id');
            $this->view->id_comprobacion = $id;
        }
    }

    public function comprobacionessitioAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->residente_id = $id;
            $this->view->residentes = $this->_ordencompra->Getresidentessitio($id);
        }else {
            return $this-> _redirect('/');
        }  
    }

   	public function pdfsolicitudordencompraAction(){
   		 $this->_helper->Layout->disableLayout();
   	}

    public function requestupdatestatusdeletesolicitudordencompraAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="solicitud_ordencompra";
            $status=1;
            $result = $this->_user->UpdateStatusdeletepersonal($post,$table,$status);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }

    public function requestupdatecomprobacioneditAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $id= $post['ids'];
        $wh="id";
        $table="comprobaciones";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $fac_anterior = $usr[0]["factura"]; 
        $table = "factura_efecticard";
        $this->_comprobacion->updatetatusfacturados($fac_anterior,$table);

        $id= $post['no_factura'];
        $wh="id";
        $table="factura_efecticard";
        $fact = $this->_season->GetSpecific($table,$wh,$id);
        $no_factura = $fact[0]["no_factura"];
        $razon = $fact[0]["nombre_emisor"];
        $table = "factura_efecticard";
        $this->_comprobacion->updatetatusfactura($no_factura,$table);

        // var_dump($no_factura);exit;

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $ap_paterno = $usr[0]['ap'];
            $nombre = $usr[0]['nombre']." ".$ap_paterno;
        if($this->getRequest()->getPost()){
            $table="comprobaciones";
            $result = $this->_ordencompra->updatecomprobacionresidente($post,$table,$hoy,$nombre,$no_factura,$razon);

            if ($result) {
                return $this-> _redirect('/solicitud/comprobacionesresidente/id/'.$post['residente'].' ');  
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }

        }
    }

    public function requestupdatecomprobacioncheckAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        // var_dump($post);exit;
        if($this->getRequest()->getPost()){
            $table="comprobaciones";
            if($post['vo_bo'] == "Parcial"){
                $monto = $post['monto'];
            }else{
                $monto = $post['montos'];
            }

            $result = $this->_ordencompra->updatecomprobacionrcheck($post,$table,$monto);
            if ($result) {
                return $this-> _redirect('/solicitud/comprobaciondetail/id/'.$post['ids'].'/status/'.$post['status'].'/user/'.$post['user'].' ');  
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }

        }
    }


    public function requestupdatecomprobaasignarproyectoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="comprobaciones";
            $result = $this->_ordencompra->updatecomprobacionproyecto($post,$table);
            if ($result) {
                return $this-> _redirect('/solicitud/comprobaciondetail/id/'.$post['comprobacion'].'/status/'.$post['status'].'/user/'.$post['user'].' ');  
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }

        }
    }



    public function requestupdatecomprobacionfileAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="comprobaciones";
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
                    $url1 = 'pdf/comprobaciones/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            $table="comprobaciones";
            $result = $this->_ordencompra->updatecomprobacionrfile($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/solicitud/comprobaciondetail/id/'.$post['id'].' ');  
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }

        }
    }

    public function requestchangerestaurarstautsdeleteAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="solicitud_ordencompra";
            $status=0;
            $result = $this->_user->UpdateStatusdeletepersonal($post,$table,$status);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL


    public function requestdeletesolicitudcompraAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="solicitud_ordencompra";
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
    }//END REQUEST DELETE SOLICITUD ORDEN COMPRA

    public function requestchangerechazadosolicituddAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        // var_dump($post);exit;
        if($this->getRequest()->getPost()){
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");

            $table="solicitud_ordencompra";
            $result=$this->_ordencompra->Updatestatusdocumento($post,$table,$hoy);

            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }   
        }
    }


    public function requestchangeaddstattusdocumentosolicitudAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
                $id=$post['id'];
                $wh="id";
                $table="solicitud_ordencompra";
                $solicitud = $this->_season->GetSpecific($table,$wh,$id);

                $id_provedor = $solicitud[0]['proveedor_id'];
                $wh="id";
                $table="proveedor";
                $proveedor = $this->_season->GetSpecific($table,$wh,$id_provedor);
                $periodo_pago= $proveedor[0]['periodo_pago'];

                date_default_timezone_set('America/Mexico_City');
                $today = date("d-m-Y H:i:s");

                if($periodo_pago = 0){
                    $hoy = $today;
                }else{
                    $hoy =date("d-m-Y H:i:s",strtotime($today."+ ".$proveedor[0]['periodo_pago']." days")); 
                }

                $dato = date("Y-m-d H:i:s");
        if($this->getRequest()->getPost()){

            $table="solicitud_ordencompra";
            $this->_ordencompra->Updatestatusdocumento($post,$table,$hoy,$dato);

        	$user_id= $post['id_user'];
            $table = "usuario";
            $wh = "id";
            $user= $this->_season->GetSpecific($table,$wh,$user_id);
        	$protocol =  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://");
            $host = 'https://prueba.gpsc.com.mx';

            if ($user) { 
                        $cabeceras = 'MIME-Version: 1.0' . "\r\n"; 
                        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        // $cabeceras .= 'To:'.$user[0]['correo'] . "\r\n";
                        $cabeceras .= 'To: ygarcia@gpsc.com.mx,dparra@gpsc.com.mx'."\r\n";
                        $cabeceras .= 'From: Nueva Solicitud de Orden de Compra <gpsc@gpsc.com.mx>' . "\r\n";
                        $contenido = 'GPSconstructivos'." ".$user[0]['nombre'].' '.$user[0]['ap']. "\r\n";
                        

                        $contenido = '  <!DOCTYPE html>
  <html>
  <head>
      <title>CONFIRMACIÓN DE SOLICITUD DE ORDEN DE COMPRA</title>
      
      <meta copyright="Copyright (c) 2020 GPS Constructivos. All Rights Reserved.">
      <style>
           p{     margin:10px 0;     padding:0; } table{     border-collapse:collapse; } h1,h2,h3,h4,h5,h6{     display:block;     margin:0;     padding:0; } img,a img{     border:0;     height:auto;     outline:none;     text-decoration:none; } body,#bodyTable,#bodyCell{     height:100%;     margin:0;     padding:0;     width:100%; } .mcnPreviewText{     display:none !important; } #outlook a{     padding:0; } img{     -ms-interpolation-mode:bicubic; } table{     mso-table-lspace:0pt;     mso-table-rspace:0pt; } .ReadMsgBody{     width:100%; } .ExternalClass{     width:100%; } p,a,li,td,blockquote{     mso-line-height-rule:exactly; } a[href^=tel],a[href^=sms]{     color:inherit;     cursor:default;     text-decoration:none; } p,a,li,td,body,table,blockquote{     -ms-text-size-adjust:100%;     -webkit-text-size-adjust:100%; } .ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{     line-height:100%; } a[x-apple-data-detectors]{     color:inherit !important;     text-decoration:none !important;     font-size:inherit !important;     font-family:inherit !important;     font-weight:inherit !important;     line-height:inherit !important; } #bodyCell{     padding:10px; } .templateContainer{     max-width:600px !important; } a.mcnButton{     display:block; } .mcnImage,.mcnRetinaImage{     vertical-align:bottom; } .mcnTextContent{     word-break:break-word; } .mcnTextContent img{     height:auto !important; } .mcnDividerBlock{     table-layout:fixed !important; } body,#bodyTable{     background-color:#FAFAFA; } #bodyCell{     border-top:0; } .templateContainer{     border:0; } h1{     color:#202020;     font-family:Helvetica;     font-size:26px;     font-style:normal;     font-weight:bold;     line-height:125%;     letter-spacing:normal;     text-align:left; } h2{     color:#202020;     font-family:Helvetica;     font-size:22px;     font-style:normal;     font-weight:bold;     line-height:125%;     letter-spacing:normal;     text-align:left; } h3{     color:#202020;     font-family:Helvetica;     font-size:20px;     font-style:normal;     font-weight:bold;     line-height:125%;     letter-spacing:normal;     text-align:left; } h4{     color:#202020;     font-family:Helvetica;     font-size:18px;     font-style:normal;     font-weight:bold;     line-height:125%;     letter-spacing:normal;     text-align:left; } #templatePreheader{     background-color:#FAFAFA;     background-image:none;     background-repeat:no-repeat;     background-position:center;     background-size:cover;     border-top:0;     border-bottom:0;     padding-top:9px;     padding-bottom:9px; } #templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{     color:#656565;     font-family:Helvetica;     font-size:12px;     line-height:150%;     text-align:left; } #templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{     color:#656565;     font-weight:normal;     text-decoration:underline; } #templateHeader{     background-color:#ffffff;     background-image:none;     background-repeat:no-repeat;     background-position:center;     background-size:cover;     border-top:0;     border-bottom:0;     padding-top:9px;     padding-bottom:0; } #templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{     color:#202020;     font-family:Helvetica;     font-size:16px;     line-height:150%;     text-align:left; } #templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{     color:#007C89;     font-weight:normal;     text-decoration:underline; } #templateBody{     background-color:#FFFFFF;     background-image:none;     background-repeat:no-repeat;     background-position:center;     background-size:cover;     border-top:0;     border-bottom:2px solid #EAEAEA;     padding-top:0;     padding-bottom:9px; } #templateBody .mcnTextContent,#templateBody .mcnTextContent p{     color:#202020;     font-family:Helvetica;     font-size:16px;     line-height:150%;     text-align:left; } #templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{     color:#007C89;     font-weight:normal;     text-decoration:underline; } #templateFooter{     background-color:#FAFAFA;     background-image:none;     background-repeat:no-repeat;     background-position:center;     background-size:cover;     border-top:0;     border-bottom:0;     padding-top:9px;     padding-bottom:9px; } #templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{     color:#656565;     font-family:Helvetica;     font-size:12px;     line-height:150%;     text-align:center; } #templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{     color:#656565;     font-weight:normal;     text-decoration:underline; }
    @media only screen and (min-width:768px){
        .templateContainer{
            width:600px !important;
        }

}
@media only screen and (max-width: 480px){
        body,table,td,p,a,li,blockquote{
            -webkit-text-size-adjust:none !important;
        }
}
@media only screen and (max-width: 480px){ body{ width:100% !important; min-width:100% !important; }}
@media only screen and (max-width: 480px){ #bodyCell{ padding-top:10px !important; }}
@media only screen and (max-width: 480px){ .mcnRetinaImage{ max-width:100% !important; }}
@media only screen and (max-width: 480px){ .mcnImage{ width:100% !important; }}
@media only screen and (max-width: 480px){ .mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{            max-width:100% !important;            width:100% !important;        }}
@media only screen and (max-width: 480px){ .mcnBoxedTextContentContainer{            min-width:100% !important;        }}
@media only screen and (max-width: 480px){ .mcnImageGroupContent{            padding:9px !important;        }}
@media only screen and (max-width: 480px){ .mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{            padding-top:9px !important;        }}
@media only screen and (max-width: 480px){ .mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{            padding-top:18px !important;        }}
@media only screen and (max-width: 480px){ .mcnImageCardBottomImageContent{            padding-bottom:9px !important;        }}
@media only screen and (max-width: 480px){ .mcnImageGroupBlockInner{            padding-top:0 !important;            padding-bottom:0 !important;        }}
@media only screen and (max-width: 480px){ .mcnImageGroupBlockOuter{            padding-top:9px !important;            padding-bottom:9px !important;        }}
@media only screen and (max-width: 480px){        .mcnTextContent,.mcnBoxedTextContentColumn{            padding-right:18px !important;            padding-left:18px !important;        }}   @media only screen and (max-width: 480px){        .mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{            padding-right:18px !important;            padding-bottom:0 !important;            padding-left:18px !important;        }}   @media only screen and (max-width: 480px){        .mcpreview-image-uploader{            display:none !important;            width:100% !important;        }}   @media only screen and (max-width: 480px){        h1{ font-size:22px !important; line-height:125% !important;        }}
@media only screen and (max-width: 480px){        h2{            font-size:20px !important;            line-height:125% !important;        }}   @media only screen and (max-width: 480px){        h3{            font-size:18px !important;            line-height:125% !important;        }}   @media only screen and (max-width: 480px){        h4{            font-size:16px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        .mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{            font-size:14px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        #templatePreheader{            display:block !important;        }}   @media only screen and (max-width: 480px){        #templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{            font-size:14px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        #templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{            font-size:16px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        #templateBody .mcnTextContent,#templateBody .mcnTextContent p{            font-size:16px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        #templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{            font-size:14px !important;            line-height:150% !important;        }}
      </style>
  </head>

<body style="height: 100%;margin: 0;padding: 0;width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FAFAFA;"> 
   
    <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;background-color: #FAFAFA;">
                <tbody><tr>
                    <td align="center" valign="top" id="bodyCell" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 10px;width: 100%;border-top: 0;"><!-- BEGIN TEMPLATE // --><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;"><tr><td align="center" valign="top" width="600" style="width:600px;"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;max-width: 600px !important;">    <tbody><tr>        <td valign="top" id="templatePreheader" style="background:#FAFAFA none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FAFAFA;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 9px;"></td>    </tr>    <tr>        <td valign="top" id="templateHeader" style="background:#FFFFFF none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 0;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><tbody><tr>    <td class="mcnImageContent" valign="top" style="padding-right: 9px;padding-left: 9px;padding-top: 0;padding-bottom: 0;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                    <img align="center" alt="" src="https://prueba.gpsc.com.mx/img/logo-2.png" width="564" style="max-width: 960px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" class="mcnImage">                        </td></tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table></td>    </tr>    <tr>        <td valign="top" id="templateBody" style="background:#FFFFFF none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 2px solid #EAEAEA;padding-top: 0;padding-bottom: 9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                <!--[if mso]>
                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                <tr>
                <![endif]-->
                
                <!--[if mso]>
                <td valign="top" width="600" style="width:600px;">
                <![endif]-->
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr><td valign="top" class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #202020;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: left;">    <h1 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 26px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;">'.$user[0]['nombre'].' '.$user[0]['ap'].', ha creado una solicitud de orden de compra nueva.</h1>

<p style="margin: 10px 0;padding: 0;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #202020;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: left;">Puedes ver los detalles de la solicitud en el sistema <a href="https://prueba.gpsc.com.mx/home/login" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #007C89;font-weight: normal;text-decoration: underline;">Da clic aqui</a>. NO.'.$post['id'].'</p>
</td>
                    </tr>
                </tbody></table>
                <!--[if mso]>
                </td>
                <![endif]-->
                
                <!--[if mso]>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody><tr>
        <td align="center" style="padding-left: 9px;padding-right: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContent">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top: 9px;padding-right: 9px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">    <tbody><tr>        <td align="center" valign="top" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">            <!--[if mso]>            <table align="center" border="0" cellspacing="0" cellpadding="0">            <tr>            <![endif]-->                            <!--[if mso]>                <td align="center" valign="top">                <![endif]-->                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                        <tbody><tr>                            <td valign="top" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                    <tbody><tr>                                        <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                                <tbody><tr>                                                                                                                                                                                                                                                                    </tr>                                            </tbody></table>                                        </td>                                    </tr>                                </tbody></table>                            </td>                        </tr>                    </tbody></table>                                <!--[if mso]>                </td>                <![endif]-->                            <!--[if mso]>                <td align="center" valign="top">                <![endif]-->                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                        <tbody><tr>                            <td valign="top" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                    <tbody><tr>                                        <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                                <tbody><tr>                                                                                                                                                                                                                                                                    </tr>                                            </tbody></table>                                        </td>                                    </tr>                                </tbody></table>                            </td>                        </tr>                    </tbody></table>                                <!--[if mso]>                </td>                <![endif]-->                            <!--[if mso]>                <td align="center" valign="top">                <![endif]-->                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                        <tbody><tr>                            <td valign="top" style="padding-right: 0;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                    <tbody><tr>                                        <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                                <tbody><tr>                                                                                                                                                                                                                                                                    </tr>                                            </tbody></table>                                        </td>                                    </tr>                                </tbody></table>                            </td>                        </tr>                    </tbody></table>                                <!--[if mso]>                </td>                <![endif]-->                        <!--[if mso]>            </tr>            </table>            <![endif]-->        </td>    </tr></tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>    </tr>    <tr>        <td valign="top" id="templateFooter" style="background:#FAFAFA none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FAFAFA;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 9px;"></td>    </tr></tbody></table><!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]--><!-- // END TEMPLATE -->
                    </td>
                </tr>
            </tbody></table>
        </center>
</body>
</html>';
                   
            if(mail($post['mail'],"Solicitud de orden de compra aprobada",$contenido,$cabeceras)){ 
                return $this->_redirect('/solicitud/solicituddetail/id/'.$post['id_solicitud'].'');
            }else{
                return $this->_redirect('/solicitud/solicituddetail/id/'.$post['id_solicitud'].'');
            }
                 
	            }else{
	                print '<script language="JavaScript">'; 
	                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
	                print '</script>'; 
	            }
        }
    }//END REQUEST ADD ROL

    public function requestchangeaddstattusdocumentosolicitudencargadoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i");

            $table="solicitud_ordencompra";
            $this->_ordencompra->Updatestatusdocumentoencargado($post,$table,$hoy);            
            $user_id= $post['id_user'];
            $table = "usuario";
            $wh = "id";
            $user= $this->_season->GetSpecific($table,$wh,$user_id);
            $protocol =  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://");
            $host = 'https://prueba.gpsc.com.mx';

            if ($user) { 
                        $cabeceras = 'MIME-Version: 1.0' . "\r\n"; 
                        $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                        // $cabeceras .= 'To:'.$user[0]['correo'] . "\r\n";
                        $cabeceras .= 'To: proyectos@gpsc.com.mx,cvega@gpsc.com.mx'."\r\n";
                        $cabeceras .= 'From: Nueva Solicitud de Orden de Compra <gpsc@gpsc.com.mx>' . "\r\n";
                        $contenido = 'GPSconstructivos'." ".$user[0]['nombre'].' '.$user[0]['ap']. "\r\n";
                        

                        $contenido = '  <!DOCTYPE html>
  <html>
  <head>
      <title>CONFIRMACIÓN DE SOLICITUD DE ORDEN DE COMPRA</title>
      
      <meta copyright="Copyright (c) 2020 GPS Constructivos. All Rights Reserved.">
      <style>
           p{     margin:10px 0;     padding:0; } table{     border-collapse:collapse; } h1,h2,h3,h4,h5,h6{     display:block;     margin:0;     padding:0; } img,a img{     border:0;     height:auto;     outline:none;     text-decoration:none; } body,#bodyTable,#bodyCell{     height:100%;     margin:0;     padding:0;     width:100%; } .mcnPreviewText{     display:none !important; } #outlook a{     padding:0; } img{     -ms-interpolation-mode:bicubic; } table{     mso-table-lspace:0pt;     mso-table-rspace:0pt; } .ReadMsgBody{     width:100%; } .ExternalClass{     width:100%; } p,a,li,td,blockquote{     mso-line-height-rule:exactly; } a[href^=tel],a[href^=sms]{     color:inherit;     cursor:default;     text-decoration:none; } p,a,li,td,body,table,blockquote{     -ms-text-size-adjust:100%;     -webkit-text-size-adjust:100%; } .ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{     line-height:100%; } a[x-apple-data-detectors]{     color:inherit !important;     text-decoration:none !important;     font-size:inherit !important;     font-family:inherit !important;     font-weight:inherit !important;     line-height:inherit !important; } #bodyCell{     padding:10px; } .templateContainer{     max-width:600px !important; } a.mcnButton{     display:block; } .mcnImage,.mcnRetinaImage{     vertical-align:bottom; } .mcnTextContent{     word-break:break-word; } .mcnTextContent img{     height:auto !important; } .mcnDividerBlock{     table-layout:fixed !important; } body,#bodyTable{     background-color:#FAFAFA; } #bodyCell{     border-top:0; } .templateContainer{     border:0; } h1{     color:#202020;     font-family:Helvetica;     font-size:26px;     font-style:normal;     font-weight:bold;     line-height:125%;     letter-spacing:normal;     text-align:left; } h2{     color:#202020;     font-family:Helvetica;     font-size:22px;     font-style:normal;     font-weight:bold;     line-height:125%;     letter-spacing:normal;     text-align:left; } h3{     color:#202020;     font-family:Helvetica;     font-size:20px;     font-style:normal;     font-weight:bold;     line-height:125%;     letter-spacing:normal;     text-align:left; } h4{     color:#202020;     font-family:Helvetica;     font-size:18px;     font-style:normal;     font-weight:bold;     line-height:125%;     letter-spacing:normal;     text-align:left; } #templatePreheader{     background-color:#FAFAFA;     background-image:none;     background-repeat:no-repeat;     background-position:center;     background-size:cover;     border-top:0;     border-bottom:0;     padding-top:9px;     padding-bottom:9px; } #templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{     color:#656565;     font-family:Helvetica;     font-size:12px;     line-height:150%;     text-align:left; } #templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{     color:#656565;     font-weight:normal;     text-decoration:underline; } #templateHeader{     background-color:#ffffff;     background-image:none;     background-repeat:no-repeat;     background-position:center;     background-size:cover;     border-top:0;     border-bottom:0;     padding-top:9px;     padding-bottom:0; } #templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{     color:#202020;     font-family:Helvetica;     font-size:16px;     line-height:150%;     text-align:left; } #templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{     color:#007C89;     font-weight:normal;     text-decoration:underline; } #templateBody{     background-color:#FFFFFF;     background-image:none;     background-repeat:no-repeat;     background-position:center;     background-size:cover;     border-top:0;     border-bottom:2px solid #EAEAEA;     padding-top:0;     padding-bottom:9px; } #templateBody .mcnTextContent,#templateBody .mcnTextContent p{     color:#202020;     font-family:Helvetica;     font-size:16px;     line-height:150%;     text-align:left; } #templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{     color:#007C89;     font-weight:normal;     text-decoration:underline; } #templateFooter{     background-color:#FAFAFA;     background-image:none;     background-repeat:no-repeat;     background-position:center;     background-size:cover;     border-top:0;     border-bottom:0;     padding-top:9px;     padding-bottom:9px; } #templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{     color:#656565;     font-family:Helvetica;     font-size:12px;     line-height:150%;     text-align:center; } #templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{     color:#656565;     font-weight:normal;     text-decoration:underline; }
    @media only screen and (min-width:768px){
        .templateContainer{
            width:600px !important;
        }

}
@media only screen and (max-width: 480px){
        body,table,td,p,a,li,blockquote{
            -webkit-text-size-adjust:none !important;
        }
}
@media only screen and (max-width: 480px){ body{ width:100% !important; min-width:100% !important; }}
@media only screen and (max-width: 480px){ #bodyCell{ padding-top:10px !important; }}
@media only screen and (max-width: 480px){ .mcnRetinaImage{ max-width:100% !important; }}
@media only screen and (max-width: 480px){ .mcnImage{ width:100% !important; }}
@media only screen and (max-width: 480px){ .mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{            max-width:100% !important;            width:100% !important;        }}
@media only screen and (max-width: 480px){ .mcnBoxedTextContentContainer{            min-width:100% !important;        }}
@media only screen and (max-width: 480px){ .mcnImageGroupContent{            padding:9px !important;        }}
@media only screen and (max-width: 480px){ .mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{            padding-top:9px !important;        }}
@media only screen and (max-width: 480px){ .mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{            padding-top:18px !important;        }}
@media only screen and (max-width: 480px){ .mcnImageCardBottomImageContent{            padding-bottom:9px !important;        }}
@media only screen and (max-width: 480px){ .mcnImageGroupBlockInner{            padding-top:0 !important;            padding-bottom:0 !important;        }}
@media only screen and (max-width: 480px){ .mcnImageGroupBlockOuter{            padding-top:9px !important;            padding-bottom:9px !important;        }}
@media only screen and (max-width: 480px){        .mcnTextContent,.mcnBoxedTextContentColumn{            padding-right:18px !important;            padding-left:18px !important;        }}   @media only screen and (max-width: 480px){        .mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{            padding-right:18px !important;            padding-bottom:0 !important;            padding-left:18px !important;        }}   @media only screen and (max-width: 480px){        .mcpreview-image-uploader{            display:none !important;            width:100% !important;        }}   @media only screen and (max-width: 480px){        h1{ font-size:22px !important; line-height:125% !important;        }}
@media only screen and (max-width: 480px){        h2{            font-size:20px !important;            line-height:125% !important;        }}   @media only screen and (max-width: 480px){        h3{            font-size:18px !important;            line-height:125% !important;        }}   @media only screen and (max-width: 480px){        h4{            font-size:16px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        .mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{            font-size:14px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        #templatePreheader{            display:block !important;        }}   @media only screen and (max-width: 480px){        #templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{            font-size:14px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        #templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{            font-size:16px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        #templateBody .mcnTextContent,#templateBody .mcnTextContent p{            font-size:16px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        #templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{            font-size:14px !important;            line-height:150% !important;        }}
      </style>
  </head>

<body style="height: 100%;margin: 0;padding: 0;width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FAFAFA;"> 
   
    <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;background-color: #FAFAFA;">
                <tbody><tr>
                    <td align="center" valign="top" id="bodyCell" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 10px;width: 100%;border-top: 0;"><!-- BEGIN TEMPLATE // --><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;"><tr><td align="center" valign="top" width="600" style="width:600px;"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;max-width: 600px !important;">    <tbody><tr>        <td valign="top" id="templatePreheader" style="background:#FAFAFA none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FAFAFA;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 9px;"></td>    </tr>    <tr>        <td valign="top" id="templateHeader" style="background:#FFFFFF none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 0;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><tbody><tr>    <td class="mcnImageContent" valign="top" style="padding-right: 9px;padding-left: 9px;padding-top: 0;padding-bottom: 0;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                    <img align="center" alt="" src="https://prueba.gpsc.com.mx/img/logo-2.png" width="564" style="max-width: 960px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" class="mcnImage">                        </td></tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table></td>    </tr>    <tr>        <td valign="top" id="templateBody" style="background:#FFFFFF none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 2px solid #EAEAEA;padding-top: 0;padding-bottom: 9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="padding-top: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                <!--[if mso]>
                <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
                <tr>
                <![endif]-->
                
                <!--[if mso]>
                <td valign="top" width="600" style="width:600px;">
                <![endif]-->
                <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" class="mcnTextContentContainer">
                    <tbody><tr><td valign="top" class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #202020;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: left;">    <h1 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 26px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;">'.$user[0]['nombre'].' '.$user[0]['ap'].', ha creado una solicitud de orden de compra nueva.</h1>

<p style="margin: 10px 0;padding: 0;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #202020;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: left;">Puedes ver los detalles de la solicitud en el sistema <a href="https://prueba.gpsc.com.mx/home/login" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #007C89;font-weight: normal;text-decoration: underline;">Da clic aqui</a>. NO.'.$post['id'].'</p>
</td>
                    </tr>
                </tbody></table>
                <!--[if mso]>
                </td>
                <![endif]-->
                
                <!--[if mso]>
                </tr>
                </table>
                <![endif]-->
            </td>
        </tr>
    </tbody>
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody><tr>
        <td align="center" style="padding-left: 9px;padding-right: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContent">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top: 9px;padding-right: 9px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">    <tbody><tr>        <td align="center" valign="top" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">            <!--[if mso]>            <table align="center" border="0" cellspacing="0" cellpadding="0">            <tr>            <![endif]-->                            <!--[if mso]>                <td align="center" valign="top">                <![endif]-->                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                        <tbody><tr>                            <td valign="top" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                    <tbody><tr>                                        <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                                <tbody><tr>                                                                                                                                                                                                                                                                    </tr>                                            </tbody></table>                                        </td>                                    </tr>                                </tbody></table>                            </td>                        </tr>                    </tbody></table>                                <!--[if mso]>                </td>                <![endif]-->                            <!--[if mso]>                <td align="center" valign="top">                <![endif]-->                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                        <tbody><tr>                            <td valign="top" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                    <tbody><tr>                                        <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                                <tbody><tr>                                                                                                                                                                                                                                                                    </tr>                                            </tbody></table>                                        </td>                                    </tr>                                </tbody></table>                            </td>                        </tr>                    </tbody></table>                                <!--[if mso]>                </td>                <![endif]-->                            <!--[if mso]>                <td align="center" valign="top">                <![endif]-->                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                        <tbody><tr>                            <td valign="top" style="padding-right: 0;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                    <tbody><tr>                                        <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                                <tbody><tr>                                                                                                                                                                                                                                                                    </tr>                                            </tbody></table>                                        </td>                                    </tr>                                </tbody></table>                            </td>                        </tr>                    </tbody></table>                                <!--[if mso]>                </td>                <![endif]-->                        <!--[if mso]>            </tr>            </table>            <![endif]-->        </td>    </tr></tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>    </tr>    <tr>        <td valign="top" id="templateFooter" style="background:#FAFAFA none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FAFAFA;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 9px;"></td>    </tr></tbody></table><!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]--><!-- // END TEMPLATE -->
                    </td>
                </tr>
            </tbody></table>
        </center>
</body>
</html>';
                   
            if(mail($post['mail'],"Solicitud de orden de compra aprobada",$contenido,$cabeceras)){ 
                return $this->_redirect('/solicitud/solicituddetailencargado/id/'.$post['id'].'');
            }else{
                return $this->_redirect('/solicitud/solicituddetailencargado/id/'.$post['id'].'');
            }
                 
                }else{
                    print '<script language="JavaScript">'; 
                    print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                    print '</script>'; 
                }
        }
    }//END REQUEST CHANGE STATUS DOCUMENTO SOLICITUD ORDEN

    public function requestadddocumentacionsolicitudordencompraAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($post['proyecto'] != 0){
            $table = "solicitud_ordencompra";
            $this->_ordencompra->updatetipoproyecto($post,$table);
        }

        if($this->getRequest()->getPost()){
        	$name = $_FILES['file_opuno']['name'];
            if(empty($name)){ 
            	$urldb = "";
            }else{
                $bytes = $_FILES['file_opuno']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                	// PDF supera el tamaño 
                }else{
                    $info1 = new SplFileInfo($_FILES['file_opuno']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/solicitud_ordencompra/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['file_opuno']['tmp_name'],$urldb);
                }
            }

        	$namedos = $_FILES['file_opdos']['name'];
            if(empty($namedos)){ 
            	$urldb_dos="";
            }else{
                $bytes = $_FILES['file_opdos']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                	// PDF supera el tamaño 
                }else{
                    $info1 = new SplFileInfo($_FILES['file_opdos']['name']);
                    $ext1 = $info1->getExtension();
                    $url2 = 'img/solicitud_ordencompra/';
                    $urldb_dos = $url2.$info1;
                    move_uploaded_file($_FILES['file_opdos']['tmp_name'],$urldb_dos);
                }
            }

        	$nametres = $_FILES['file_optres']['name'];
            if(empty($nametres)){ 
            	$urldb_tres = "";
            }else{
                $bytes = $_FILES['file_optres']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                	// PDF supera el tamaño 
                }else{
                    $info1 = new SplFileInfo($_FILES['file_optres']['name']);
                    $ext1 = $info1->getExtension();
                    $url3 = 'img/solicitud_ordencompra/';
                    $urldb_tres = $url3.$info1;
                    move_uploaded_file($_FILES['file_optres']['tmp_name'],$urldb_tres);
                }
            }

            $id=$post['id_solicitud'];
            $wh="id";
            $table="solicitudes_pendientes";
            $sol_pendiente = $this->_season->GetSpecific($table,$wh,$id);
            // var_dump($post);exit;
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $table ="solicitud_ordencompra";
            $id_sol = $this->_season->insertsolicitudordencomprapendiente($sol_pendiente, $hoy,$post);
            $table="solicitudes_pendientes";
            $id=$post['id_solicitud'];
            $wh="id";
            $this->_season-> deleteAll($id,$table,$wh);
            // var_dump($sol_pendiente);exit;
        	
            $table="doc_solicitudordencompra";
            $result=$this->_ordencompra->insertdocumentocontizacionpdf($post,$table,$urldb,$urldb_dos,$urldb_tres,$id_sol );
            if ($result) {
                return $this-> _redirect('/panel/successsolicitudordencompras');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }	
    }

    public function requestaddcomprobantedepagoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
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
                    $url1 = 'pdf/pagos_solicitudes/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $status_pago = 1;

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $nombre= $usr[0]['nombre']." ".$usr[0]['ap'];
            $id_usuario = $usr[0]['id'];
            $table="solicitud_ordencompra";
            $this->_ordencompra->updatepagosolicitud($post,$table,$urldb,$hoy,$status_pago,$nombre);

            $table="pagos_solicitud";
            $result=$this->_ordencompra->insertpagosolicitudorden($post,$table,$urldb,$hoy,$status_pago,$nombre);
            if ($result) {
                return $this-> _redirect('/solicitud/solicituddetailencargado/id/'.$post['id_solicitud'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaddcomprobacionresidenteAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        // var_dump($post);exit;
        $residente  = $post["residentes"];
        $table="personal_campo";
        $ver = $this->_comprobacion->upateuserfactura($residente,$table);
        

        if($post['facturable'] == 2){
            $no_fact = "No Facturable";
            $razon_soc = $post['razon_socialsi'];
            $fecha_fact = $post['fecha'];
            $monto_fct = $post['monto'];
        }else{
            $id = $post['no_factura'];
            $wh="id";
            $table="factura_efecticard";
            $fact =$this->_season->GetSpecific($table,$wh,$id);       

            $no_fact = $fact[0]['id'];
            $razon_soc = $fact[0]['nombre_emisor'];
            $fecha_fact = $fact[0]['fecha_comprobante'];
            $monto_fc = $fact[0]['total_factura'];
            $monto_factura=str_replace(',','',$monto_fc); 
            $monto_fct = $monto_fc;

            $ver = $this->_comprobacion->updatetatusfactura($no_fact,$table);
            $no_fact = $fact[0]['no_factura'];
        }

        // var_dump($post);exit;

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $ap_paterno = $usr[0]['ap'];
            $nombre = $usr[0]['nombre']." ".$ap_paterno;

            $name = $_FILES['factura']['name'];
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            }else{
                $bytes = $_FILES['factura']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['factura']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'pdf/comprobaciones/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['factura']['tmp_name'],$urldb);
                }
            }


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
                    $url1 = 'pdf/comprobaciones/';
                    $urldb2 = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb2);
                }
            }

        if($this->getRequest()->getPost()){
            $table="comprobaciones";
            $result=$this->_ordencompra->insercomprobacionresidente($post,$table,$nombre,$hoy,$urldb,$urldb2,$no_fact,$razon_soc,$monto_fct,$fecha_fact);
            if ($result) {
                return $this-> _redirect('/solicitud/successcomprobacion/residente/'.$post['residentes'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaddgenerarcomprobacionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
            
        $ver=$this->_comprobacion->getiffacturaresidente($post['residente']);
        if(empty($ver)){
            $dato = 0; //actualizar datos 1
            $table="personal_campo";
            $residente =$post['residente'];
            $this->_comprobacion->refreshfacturascontenido($dato,$table,$residente);
        }else{
            $dato = 1; //actualizar datos 1
            $table="personal_campo";
            $residente =$post['residente'];
            $this->_comprobacion->refreshfacturascontenido($dato,$table,$residente);
        }

        $table ="comprobacion_solicitud";
        $this->_comprobacion->refreshssolicitudcomprobada($post, $table);

        $id_residente=$post['residente'];
        $sitios=$this->_ordencompra->Getcomprobacionauditada($id_residente);
        $final = end( $sitios);


        $com_factu = $this->_ordencompra->Getcomprobacionresidentefacturable($id_residente);
        $facturable_residente =0;
        $facturable_proyectos =0;
        foreach ($com_factu as $key ) {
            $facturable_residente = $facturable_residente+$key['monto_solicitud'];
            $facturable_proyectos = $facturable_proyectos+$key['monto_comprobacion'];
        }

        $com_nofactu = $this->_ordencompra->Getcomprobacionresidentenofacturable($id_residente);
        $nofacturable_residente =0;
        $nofacturable_proyectos =0;
        foreach ($com_nofactu as $key ) {
            $nofacturable_residente = $nofacturable_residente+$key['monto_solicitud'];
            $nofacturable_proyectos = $nofacturable_proyectos+$key['monto_comprobacion'];
        }

        date_default_timezone_set('America/Mexico_City');
        $fecha_generacion = date("d-m-Y H:i:s");

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $user_generacion = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];

        $id_solicitud = $post['id_sol'];
        $id_comprobacion = $this->_comprobacion->insertcomprobacionresidente($id_residente,$facturable_residente, $facturable_proyectos, $nofacturable_residente, $nofacturable_proyectos,$fecha_generacion,$user_generacion, $post);

        
        $act=$this->_ordencompra->Getcomprobacionauditada($id_residente);
        // var_dump($act);exit;
        $table ="comprobaciones";
        foreach ($act as $key) {
            $this->_comprobacion->refreshsgenerarcomprobacionesaddsolicitud($table,$post,$id_residente);
        }

         // var_dump($act);exit;
            $dato = $this->_cajachica->insertsolicitudcajachicanew($post);
        $result = 0;
            if ($result == 0) {
                return $this-> _redirect('/comprobacion/nuevosaldocomprobacion/id/'.$id_residente.'/dato/'.$dato.' ');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
    }


    public function requestupdtatenewsolicitudcajachicaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $id_sitio = $post['sitio'];
        $wh="id";
        $table="sitios";
        $usr = $this->_season->GetSpecific($table,$wh,$id_sitio);
        $name_sitio = $usr[0]['nombre'];

        $id = $post['id_solicitud'];
        $wh="id";
        $table="comprobacion_solicitud";
        $sol = $this->_season->GetSpecific($table,$wh,$id);
        $residente = $sol[0]['id_residente'];

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $name_user = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];

        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");

        $table="comprobacion_solicitud";
        $monto_new = $sol[0]['monto_anterior'] - $sol[0]['monto'];
        $result = $this->_cajachica->updatecajachicasolicitud($post,$table,$name_sitio,$name_user,$hoy,$monto_new);


        if ($result) {
            return $this-> _redirect('/solicitud/comprobacionesresidente/id/'.$residente.'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }


    }


    public function requestdeletecomprobacionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
                $id=$post['id'];
                $table="comprobaciones";
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
    }//END REQUEST ADD ROL 

    public function requestbackdireccionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $this->_ordencompra->Updatestatuspagadasadireccion($post);

        $id=$post['solicitud'];
        $table="pagos_solicitud";
        $wh="id_solicitud";
        $this->_season->deleteAll($id,$table,$wh);


        $id=$post['solicitud'];
        $table="doc_solicitudordencompra";
        $wh="id_solicitud";
        $result = $this->_season->deleteAll($id,$table,$wh);

        if($this->getRequest()->getPost()){

            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL 


    public function requestaddherramientasolicitudAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="herramienta_inventario";
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
                    $url1 = 'img/herramienta/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            $name = $_FILES['factura']['name'];
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            }else{
                $bytes = $_FILES['factura']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['factura']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/herramienta/factura/';
                    $urldb1 = $url1.$info1;
                    move_uploaded_file($_FILES['factura']['tmp_name'],$urldb1);
                }
            }

            $responsable=$post['responsable'];
            if ($responsable == 0) {
                $status = 0;
            }else{
                $status=1;
            }

            $result = $this->_cat->insertherramienta($post,$table,$urldb,$urldb1,$status);

            if ($result) {
                return $this-> _redirect('/solicitud/comprobacionesresidente/id/'.$post['responsable'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END add herramienta


    public function requestasignareppsolicitudAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            
            $encampo = $post ['campo'];
            if ($encampo == true) {

                $id=$post['talla']; 
                $table="epp_catalogo";
                $vida=$this->_epp->buscarrep($id,$table);
                
                $vidap=implode($vida[0]);
                $date=$post['fecha'];
                $fechanew=date('Y-m-d', strtotime($date. ' +'.$vidap.' days'));

                $cobro=$post['cobro']; 
                if ($cobro == true) {
                    $statusc = 1;
                }else{
                    $statusc=0;
                }

                $table="epp_asignar";
                $result = $this->_epp->insertasgcompra($post,$table,$fechanew,$statusc);

                if ($result) {
                    return $this-> _redirect('/solicitud/comprobacionesresidente/id/'.$post['idhsol'].''); 
                }else{
                    print '<script language="JavaScript">'; 
                    print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                    print '</script>'; 
                }

            } else {

                $id=$post['talla'];
                $table="epp_catalogo";
                $vida=$this->_epp->buscarrep($id,$table);
                
                $vidap=implode($vida[0]);
                $date=$post['fecha'];
                $fechanew=date('Y-m-d', strtotime($date. ' +'.$vidap.' days'));

                $cobro=$post['cobro']; 
                if ($cobro == true) {
                    $statusc = 1;
                }else{
                    $statusc=0;
                }

                $table="epp_asignar";
                $this->_epp->insertasignacion($post,$table,$fechanew,$statusc);


                $table="epp_catalogo";
                $result = $this->_epp->UpdateStock($post,$table);

                if ($result) {
                    return $this-> _redirect('/solicitud/comprobacionesresidente/id/'.$post['idhsol'].''); 
                }else{
                    print '<script language="JavaScript">'; 
                    print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                    print '</script>'; 
                }
            }
        }        
    }// End Request Asignar -herramienta


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