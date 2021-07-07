<?php

class GasolinaController extends Zend_Controller_Action{
	private $_season;
    private $_session;
    private $_user;

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
        $this->_gasolina = new Application_Model_GpsGasolinaModel;
        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }
        
    }

    public function efecticardAction(){

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $table="personal_campo";
        $this->view->personal = $this->_user->personalactivo($table);

        $table="tarjeta_efecticard";
        $solicitud =  $this->_season->GetAll($table);
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
            $this->view->paginator= $this->_gasolina->getefecticardpaginator($offset,$no_of_records_per_page);
    }   

    public function efecticarddetailAction(){
        $id=$this->_getParam('id');
        $wh="id";
        $table="tarjeta_efecticard";
        $this->view->tarjeta = $this->_season->GetSpecific($table,$wh,$id);

        $table="personal_campo";
        $this->view->personal = $this->_user->personalactivodos($table);
    }

    public function controlgasolinaAction(){

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $solicitud = $this->_gasolina->getstepuno();
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
            $this->view->paginator= $this->_gasolina->getstepunopaginator($offset,$no_of_records_per_page);

    }

    public function addcontrolgasolinaAction(){
        $table = "sitios";
        $this->view->sitios = $this->_sitio->Getordernombresitios();

        $table="personal_campo";
        $this->view->usuarios = $this->_user->Getcountpersonalgasolina();

        $table="vehiculos";
        $this->view->vehiculos = $this->_season->GetAll($table);

        $table="tarjeta_efecticard";
        $this->view->tarjetas = $this->_season->GetAll($table);
    }

    public function addcontrolgasolinadosAction(){
        $sitio =$this->_getParam('id');
        $this->view->id = $sitio;
        $wh="id";
        $table="add_gasolina";
        $usr = $this->_season->GetSpecific($table,$wh,$sitio);
        
        $id_sitio = $usr[0]['id_sitios'];
        $this->view->id_sitio = $id_sitio;
        $this->view->forma_pago = $usr[0]['forma_pago'];
        $vehi = $usr[0]['id_vehiculo'];
        
        $id = $usr[0]['id_responsable'];
        $wh="id_vehiculos";
        $table="vehiculos";
        $tarjetas = $this->_season->GetSpecific($table,$wh,$vehi);
        // var_dump($tarjetas);exit;

        if($tarjetas[0]['efecticard'] == NULL || $tarjetas[0]['tag'] == NULL){
            $valor = 0; //vacio
            $this->view->if_datos = $valor;
        }else{
            $valor = 1; //datos
            $this->view->if_datos = $valor;
            $id = $usr[0]['id_responsable'];
            $wh="id_responsable";
            $table="tarjeta_efecticard";
            $this->view->tarjetas = $this->_season->GetSpecific($table,$wh,$id);
        }

        // var_dump($tarjetas);exit;

        $table="sitios_tipoproyecto";
        $wh="id_sitio";
        $this->view->proyectos =$this->_sitio->gettipoproyectosolicitud($id_sitio);
    }

    public function updatecontrolgasolinaAction(){
        $id=$this->_getParam('id');
        $this->view->ids = $id;
        $wh="id";
        $table="add_gasolina";
        $this->view->control = $this->_season->GetSpecific($table,$wh,$id);

        $table = "sitios";
        $this->view->sitios = $this->_sitio->Getordernombresitios();

        $table="personal_campo";
        $this->view->usuarios = $this->_user->Getcountpersonalgasolina();

        $table="vehiculos";
        $this->view->vehiculos = $this->_season->GetAll($table);
    }

    public function auditoriagasolinaAction(){
        $table="tarjeta_efecticard";
        $this->view->tarjetas = $this->_season->GetAll($table);

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $estado = 0;
        $sql = $this->_gasolina->getprocesogasolina($estado);
        $total = count($sql);
        $this->view->enproceso=$total;

        if($status == 0){
            $estado = 0;
            $solicitud = $this->_gasolina->getprocesogasolina($estado);
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
            $this->view->paginator= $this->_gasolina->getprocesopaginator($offset,$no_of_records_per_page,$estado);
        } // EN PROCESO


        if($status == 1){
            $estado = 2;
            $solicitud = $this->_gasolina->getprocesogasolina($estado);
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
            $this->view->paginator= $this->_gasolina->getprocesopaginator($offset,$no_of_records_per_page,$estado);
        } // RECHAZADAS


        if($status == 2){
            $estado = 1;
            $solicitud = $this->_gasolina->getprocesogasolina($estado);
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
            $this->view->paginator= $this->_gasolina->getprocesopaginator($offset,$no_of_records_per_page,$estado);
        } // Aceptadas

    }

    public function busquedacontrolgasolinaAction(){
        $table="tarjeta_efecticard";
        $this->view->tarjetas = $this->_season->GetAll($table);

        $id=$this->_session->id;
        $this->view->user_list=$id;

        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$usr[0]['fkroles'];

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $estado = 0;
        $sql = $this->_gasolina->getprocesogasolina($estado);
        $total = count($sql);
        $this->view->enproceso=$total;


        if($status == 0){
            $op = $this->_getParam('op');
            $this->view->op=$op;
            if($op == 1){
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $estado = 0;
                $solicitud =$this->view->total_sitio= $this->_gasolina->getprocesogasolinasitio($estado,$sitio);
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
                $this->view->paginator= $this->_gasolina->getprocesopaginatorsitio($offset,$no_of_records_per_page,$estado,$sitio);
            }

            if($op == 2){
                $responsable = $this->_getParam('responsable');
                $this->view->nombre_responsable=$responsable;

                $estado = 0;
                $solicitud =$this->view->total_sitio= $this->_gasolina->getprocesogasolinaresponsable($estado,$responsable);
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
                $this->view->paginator= $this->_gasolina->getprocesopaginatorresponsable($offset,$no_of_records_per_page,$estado,$responsable);            
            }

            if($op == 3){
                $placas = $this->_getParam('placas');
                $this->view->nombre_placas=$placas;

                $estado = 0;
                $solicitud =$this->view->total_sitio= $this->_gasolina->getprocesogasolinaplacas($estado,$placas);
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
                $this->view->paginator= $this->_gasolina->getprocesopaginatorplacas($offset,$no_of_records_per_page,$estado,$placas);  
            }

            if($op == 4){
                $tarjeta = $this->_getParam('tarjeta');
                $this->view->id_tarjeta=$tarjeta;

                $estado = 0;
                $solicitud =$this->view->total_sitio= $this->_gasolina->getprocesogasolinatarjeta($estado,$tarjeta);
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
                $this->view->paginator= $this->_gasolina->getprocesopaginatortarjeta($offset,$no_of_records_per_page,$estado,$tarjeta); 
            }

        } // EN PROCESO

        if($status == 1){
            $op = $this->_getParam('op');
            $this->view->op=$op;
            if($op == 1){
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $estado = 2;
                $solicitud =$this->view->total_sitio= $this->_gasolina->getprocesogasolinasitio($estado,$sitio);
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
                $this->view->paginator= $this->_gasolina->getprocesopaginatorsitio($offset,$no_of_records_per_page,$estado,$sitio);
            }

            if($op == 2){
                $responsable = $this->_getParam('responsable');
                $this->view->nombre_responsable=$responsable;

                $estado = 2;
                $solicitud = $this->view->total_sitio=$this->_gasolina->getprocesogasolinaresponsable($estado,$responsable);
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
                $this->view->paginator= $this->_gasolina->getprocesopaginatorresponsable($offset,$no_of_records_per_page,$estado,$responsable);            
            }

            if($op == 3){
                $placas = $this->_getParam('placas');
                $this->view->nombre_placas=$placas;

                $estado = 2;
                $solicitud =$this->view->total_sitio= $this->_gasolina->getprocesogasolinaplacas($estado,$placas);
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
                $this->view->paginator= $this->_gasolina->getprocesopaginatorplacas($offset,$no_of_records_per_page,$estado,$placas);  
            }

            if($op == 4){
                $tarjeta = $this->_getParam('tarjeta');
                $this->view->id_tarjeta=$tarjeta;

                $estado = 2;
                $solicitud =$this->view->total_sitio= $this->_gasolina->getprocesogasolinatarjeta($estado,$tarjeta);
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
                $this->view->paginator= $this->_gasolina->getprocesopaginatortarjeta($offset,$no_of_records_per_page,$estado,$tarjeta); 
            }

        } // EN Rechazadas

        if($status == 2){
            $op = $this->_getParam('op');
            $this->view->op=$op;
            if($op == 1){
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;

                $estado = 1;
                $solicitud = $this->view->total_sitio=$this->_gasolina->getprocesogasolinasitio($estado,$sitio);
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
                $this->view->paginator= $this->_gasolina->getprocesopaginatorsitio($offset,$no_of_records_per_page,$estado,$sitio);
            }

            if($op == 2){
                $responsable = $this->_getParam('responsable');
                $this->view->nombre_responsable=$responsable;

                $estado = 1;
                $solicitud =$this->view->total_sitio= $this->_gasolina->getprocesogasolinaresponsable($estado,$responsable);
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
                $this->view->paginator= $this->_gasolina->getprocesopaginatorresponsable($offset,$no_of_records_per_page,$estado,$responsable);            
            }

            if($op == 3){
                $placas = $this->_getParam('placas');
                $this->view->nombre_placas=$placas;

                $estado = 1;
                $solicitud = $this->view->total_sitio=$this->_gasolina->getprocesogasolinaplacas($estado,$placas);
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
                $this->view->paginator= $this->_gasolina->getprocesopaginatorplacas($offset,$no_of_records_per_page,$estado,$placas);  
            }

            if($op == 4){
                $tarjeta = $this->_getParam('tarjeta');
                $this->view->id_tarjeta=$tarjeta;

                $estado = 1;
                $solicitud =$this->view->total_sitio= $this->_gasolina->getprocesogasolinatarjeta($estado,$tarjeta);
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
                $this->view->paginator= $this->_gasolina->getprocesopaginatortarjeta($offset,$no_of_records_per_page,$estado,$tarjeta); 
            }

        } // EN Aceptadas



    }

    public function auditoriagasolinadetailAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $status = $this->_getParam('status');
            $this->view->status=$status;

            $wh="id";
            $table="add_gasolina";
            $gasolina =$this->view->add_gasolina = $this->_season->GetSpecific($table,$wh,$id);

            $forma_pago = $gasolina[0]['forma_pago'];
            $this->view->forma_pago=$forma_pago;

            if($forma_pago == 1){
                $tar = $gasolina[0]['id_tarjeta'];
                $wh="id";
                $table="tarjeta_efecticard";
                $tarjetas= $this->_season->GetSpecific($table,$wh,$id);
                $this->view->tarjeta = $tarjetas[0]['no_tarjeta'];
            }else{
                $tarjetas= 0;
                $this->view->tarjeta = $tarjetas;
            }

            $vehiculo = $gasolina[0]['id_vehiculo'];
            $table="vehiculos";
            $wh="id_vehiculos";
            $this->view->vehiculo = $this->_season->GetSpecific($table,$wh,$vehiculo);
            

        }else {
            return $this-> _redirect('/');
        }
    }

    public function informacionauditoriagasolinaAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $status = $this->_getParam('status');
            $this->view->status=$status;

            $wh="id";
            $table="add_gasolina";
            $gasolina =$this->view->add_gasolina = $this->_season->GetSpecific($table,$wh,$id);

            $forma_pago = $gasolina[0]['forma_pago'];
            $this->view->forma_pago=$forma_pago;

            if($forma_pago == 1){
                $tar = $gasolina[0]['id_tarjeta'];
                $wh="id";
                $table="tarjeta_efecticard";
                $tarjetas= $this->_season->GetSpecific($table,$wh,$id);
                $this->view->tarjeta = $tarjetas[0]['no_tarjeta'];
            }else{
                $tarjetas= 0;
                $this->view->tarjeta = $tarjetas;
            }

            $vehiculo = $gasolina[0]['id_vehiculo'];
            $table="vehiculos";
            $wh="id_vehiculos";
            $this->view->vehiculo = $this->_season->GetSpecific($table,$wh,$vehiculo);
            
        }
    }

    public function requestaddtarjetaefecticardAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();   
        if($this->getRequest()->getPost()){
            
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");

            $id= $post["personal"];
            $wh="id";
            $table="personal_campo";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $personal = $usr[0]['nombre']." ".$usr[0]['apellido_pa']." ".$usr[0]['apellido_ma'];
            // var_dump($post);exit;
            // $table="personal_campo";
            // $this->_gasolina->updatepersonalefecticard($table,$post);

            $table ="tarjeta_efecticard";
            $result = $this->_gasolina->inserttarjetaefecticard($post,$table,$hoy,$personal);
            if ($result) {
                return $this-> _redirect('/gasolina/efecticard/');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }

        }   
    }

    public function requestupdatepersonalefecticardAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();   
        if($this->getRequest()->getPost()){
            

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");
            $id= $post["responsable"];
            $wh="id";
            $table="personal_campo";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $personal = $usr[0]['nombre']." ".$usr[0]['apellido_pa']." ".$usr[0]['apellido_ma'];
            // var_dump($post);exit;

            $table ="tarjeta_efecticard";
            $result = $this->_gasolina->updatepersonalefecticard($post,$table,$hoy,$personal);
            if ($result) {
                return $this-> _redirect('/gasolina/efecticard/');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }

        }   
    }


    public function requestaddcontrolgasolinaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        

            $id=$post['vehiculo'];
            $wh="id_vehiculos";
            $table="vehiculos";
            $sit = $this->_season->GetSpecific($table,$wh,$id);
            $placas = $sit[0]['placas'];

        if($this->getRequest()->getPost()){
            if($post['sitio'] == 0){
                $name_sitio = "Oficina";
            }else{
                $id=$post['sitio'];
                $wh="id";
                $table="sitios";
                $sit = $this->_season->GetSpecific($table,$wh,$id);
                $name_sitio= $sit[0]['nombre'];
                // NOmbre del Sitio    END
            }

            $id=$post['responsable'];
            $wh="id";
            $table="personal_campo";
            $per = $this->_season->GetSpecific($table,$wh,$id);
            
            $name_per = $per[0]['nombre']." ".$per[0]['apellido_pa']." ".$per[0]['apellido_ma'];
            $id_responsable = $per[0]['id']; 
            // Responsable        END

            $table="add_gasolina";
            $result = $this->_gasolina->insertcontrolgasolina($post,$table,$name_sitio,$name_per,$id_responsable,$placas);
            // var_dump($result);exit;
            if ($result) {
                return $this-> _redirect('/gasolina/addcontrolgasolinados/id/'.$result.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaddcontrolgasolinadosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            $id=$post['ids'];
            $wh="id";
            $table="add_gasolina";
            $usr = $this->_season->GetSpecific($table,$wh,$id);


            $ve=$usr[0]['id_vehiculo'];
            $wh="id_vehiculos";
            $table="vehiculos";
            $vehiculo = $this->_season->GetSpecific($table,$wh,$ve);

            $nombre_tarjeta = $vehiculo[0]['efecticard'];
            $tag = $vehiculo[0]['tag'];

            $id_tarjeta = 0;

            $name = $_FILES['odometro']['name'];
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            }else{
                $bytes = $_FILES['odometro']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['odometro']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'pdf/gasolina/';
                    $odometro = $url1.$info1;
                    move_uploaded_file($_FILES['odometro']['tmp_name'],$odometro);
                }
            } 

            $name = $_FILES['bomba']['name'];
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            }else{
                $bytes = $_FILES['bomba']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['bomba']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'pdf/gasolina/';
                    $bomba = $url1.$info1;
                    move_uploaded_file($_FILES['bomba']['tmp_name'],$bomba);
                }
            } 

            $name = $_FILES['ticket']['name'];
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            }else{
                $bytes = $_FILES['ticket']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['ticket']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'pdf/gasolina/';
                    $ticket = $url1.$info1;
                    move_uploaded_file($_FILES['ticket']['tmp_name'],$ticket);
                }
            } 

            $table="add_gasolina";
            $result = $this->_gasolina->updategasolinacontroldos($post,$table,$odometro,$bomba,$ticket,$id_tarjeta,$nombre_tarjeta,$tag);
            if ($result) {
                return $this-> _redirect('/gasolina/controlgasolina');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }

        }
    }

    public function requestupdatecontrolgasolinaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

            $id=$post['vehiculo'];
            $wh="id_vehiculos";
            $table="vehiculos";
            $sit = $this->_season->GetSpecific($table,$wh,$id);
            $placas = $sit[0]['placas'];


        if($this->getRequest()->getPost()){
            
            if($post['sitio'] == 0){
                $name_sitio = "Oficina";
            }else{
                $id=$post['sitio'];
                $wh="id";
                $table="sitios";
                $sit = $this->_season->GetSpecific($table,$wh,$id);
                $name_sitio= $sit[0]['nombre'];
                // NOmbre del Sitio    END
            }

            $id=$post['responsable'];
            $wh="id";
            $table="personal_campo";
            $per = $this->_season->GetSpecific($table,$wh,$id);
            $name_per = $per[0]['nombre']." ".$per[0]['apellido_pa']." ".$per[0]['apellido_ma'];
            // Responsable        END

            $table="add_gasolina";
            $result = $this->_gasolina->updategasolinacontrol($post,$table,$name_sitio,$name_per,$placas);
            if ($result) {
                return $this-> _redirect('/gasolina/addcontrolgasolinados/id/'.$post['ids'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }

    }

    public function requestupdateauditoriagasolinaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->getRequest()->getPost()){

            $post = $this->getRequest()->getPost();
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y h:i:sa");
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $name_auditor = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];

            $table="add_gasolina";
            $result = $this->_gasolina->updateauditoria($post,$table,$hoy,$name_auditor);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                    
            }

        }
    }


    public function requestdeletecontrolgasolinaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="add_gasolina";
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
    
        public function randomnamebts(){

            $ran =  rand();
            return 'bts-wk1-'.$ran;

        }//fin de random WK 1

        public function randomnamebtswkdos(){

            $ran =  rand();
            return 'bts-wk2-'.$ran;

        }//fin de random WK 2

        public function randomnamebtswktres(){

            $ran =  rand();
            return 'bts-wk3-'.$ran;

        }//fin de random WK 3

        public function randomnamebtswkcuatro(){

            $ran =  rand();
            return 'bts-wk4-'.$ran;

        }//fin de random WK 4
}
