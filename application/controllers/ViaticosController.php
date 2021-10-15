<?php

class ViaticosController extends Zend_Controller_Action{
    private $_season;
    private $_session;
    private $_user;
    private $_epp;
    private $_veh;
    private $_via;

    public function init(){

        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_project = new Application_Model_GpsProyectoModel;
        $this->_colo = new Application_Model_GpsColocacionModel;
        $this->_epp = new Application_Model_GpsEppModel;
        $this->_veh = new Application_Model_GpsVehiculosModel;
        $this->_via = new Application_Model_GpsViaticosModel;

        if(empty($this->_session->id)){
        
            $this->redirect('/home/login');
        
        }
        
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        
        foreach ($usr as $key) {
        
           $fk=$key['fkroles'];
        
        }
    }

    public function solviaticosAction(){

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

            $id_user=$this->_session->id;
            $wh="id";
            $table="usuario";
            $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);

        $solicitud = $this->_via->GetSolStepUnoV();
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
            $this->view->paginator= $this->_via->GetStepCeroViapaginator($offset,$no_of_records_per_page);
    }


     public function requestdeletesolvAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="viaticos_sol";
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


    public function addsolviaticosAction(){

        $table = "sitios";
        $sitios = $this->view->sitios = $this->_via->GetordersitiosV();

        $table = "personal_campo";
        $this->view->personal = $this->_via->GetPersonalViaticos();

    }


    public function requestaddsolicitudviaticosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){
           
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id_user = $usr[0]['id'];
            $nombre= $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];

            $id= $post['personal'];
            $table="personal_campo";
            $pusr = $this->_season->GetSpecific($table,$wh,$id);
            $nombre_per = $pusr[0]['nombre']." ".$pusr[0]['apellido_pa']." ".$pusr[0]['apellido_ma'];

            $id= $post['sitio'];
            $table="sitios";
            $sto = $this->_season->GetSpecific($table,$wh,$id);
            $nombre_sitio = $sto[0]['nombre'];


            $table="viaticos_sol";
            $result = $this->_via->insertsolviaticos($post,$table,$id_user,$nombre,$nombre_per,$nombre_sitio);

            if ($result) {
       
                return $this-> _redirect('/viaticos/addsolviaticos2/id/'.$result.'');
       
            }else{
       
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
       
            }
        }
    }


    public function addsolviaticos2Action(){
       
        $id =$this->_getParam('id');
        $this->view->id = $id;
        $wh="id";
        $table="viaticos_sol";
        $usr =  $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);
        
        $sitio = $usr[0]['id_sitio'];
        $table="sitios_tipoproyecto";
        $this->view->proyecto = $this->_via->getproyectosviaticos($sitio);

    } // Vista Addsolviaticos2


    public function requestadddosviaticosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){

            $id=$post['idsol'];
            $wh="id";
            $table="viaticos_sol";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $personal = $usr[0]['id_personal'];

            $wh="id";
            $table="personal_campo";
            $dtusr = $this->_season->GetSpecific($table,$wh,$personal);

            $montovtc = $dtusr[0]['viaticos'] * $post['dia'];

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");

            $table="viaticos_sol";
            $result = $this->_via->UpdateSolViaDos($post,$table,$montovtc,$hoy);
            if ($result) {
                return $this-> _redirect('/viaticos/solviaticos');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }

        }
    } 


     public function updatesolviaticosAction(){

        $id=$this->_getParam('id');
        $this->view->ids = $id;
        
        $wh="id";
        $table="viaticos_sol";
        $this->view->solicitudes = $this->_season->GetSpecific($table,$wh,$id);

        $table = "sitios";
        $sitios = $this->view->sitios = $this->_via->GetordersitiosV();

        $table = "personal_campo";
        $this->view->personal = $this->_via->GetPersonalViaticos();        
    
    }


    public function requestupdatesolviaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id_user = $usr[0]['id'];
            $nombre= $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];

            $id= $post['personal'];
            $table="personal_campo";
            $pusr = $this->_season->GetSpecific($table,$wh,$id);
            $nombre_per = $pusr[0]['nombre']." ".$pusr[0]['apellido_pa']." ".$pusr[0]['apellido_ma'];

            $id= $post['sitio'];
            $table="sitios";
            $sto = $this->_season->GetSpecific($table,$wh,$id);
            $nombre_sitio = $sto[0]['nombre'];


            $table="viaticos_sol";
            $result = $this->_via->UpdateSolviaticosStepUno($post,$table,$id_user,$nombre,$nombre_per,$nombre_sitio);
            
            if ($result) {
        
                return $this-> _redirect('/viaticos/addsolviaticos2/id/'.$post['ids'].'');
        
            }else{
        
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
        
            }
        }
    } // Udapte udatesolviaticos


    public function listasolicitudvtcAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;
        $wh="user_creacion";
        $table="viaticos_sol";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        // status_documento  enproceso
        
        $wh="id";
        $table="usuario";
        $user = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$user[0]['fkroles'];

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $sql = $this->_via->GetSolicitudesViaCount();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table = "sitios";
        $sitios = $this->view->sitios = $this->_via->GetordersitiosV();

        $table = "personal_campo";
        $this->view->personal = $this->_via->GetPersonalViaticos();   


        if($status == 0) {

            $solicitud=$this->_via->GetSolicitudesViaCount();
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
            $table="viaticos_sol";
            $sql=$this->view->paginator= $this->_via->GetPagSolProcesoViatico($table,$offset,$no_of_records_per_page);
            // var_dump($sql);exit;
        }

        if($status == 1){

            $solicitud=$this->_via->GetSolAceptaViaticosCount();
            $count=count($solicitud);

            if(isset($_GET['pagina'])) { 
            
                $pagina = $_GET['pagina']; 
            
            }else { 
            
                $pagina= $this->view->pagina = 1; 
            
            }

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="viaticos_sol";
            $sql= $this->view->paginator= $this->_via->GetPagSolAptViatico($table,$offset,$no_of_records_per_page);
        }

        if($status == 2){
            
            $solicitud=$this->_via->GetSolCancelViaticoCount();
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
            $table="viaticos_sol";
            $this->view->paginator= $this->_via->GetPagSolCancelViatico($table,$offset,$no_of_records_per_page);
        }

        if($status == 3){
            
            $solicitud=$this->_via->GetSolPagadaViaticoCount();
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
            $table="viaticos_sol";
            $sql= $this->view->paginator= $this->_via->GetPagSolPagViatico($table,$offset,$no_of_records_per_page);
        }   
    }   // Lista solicitudes viaticos general


    public function listasolvbuscarAction(){
    
        $id=$this->_session->id;
        $this->view->user_list=$id;

        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$usr[0]['fkroles'];

        $wh="id_usuario";
        $table="viaticos_sol";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $sql = $this->_via->GetSolicitudesViaCount();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table = "sitios";
        $sitios = $this->view->sitios = $this->_via->GetordersitiosV();

        $table = "personal_campo";
        $this->view->personal = $this->_via->GetPersonalViaticos();   


        $opcion = $this->_getParam('op');
        $this->view->opcion_search=$opcion;

        if($status == 0) {
    
            if($opcion == 1){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalid=$personal;
                
                $statusstep = 1;
                $statussol = 0;
                $statuscom = 0;
                $solicitud=$this->view->sol_viatico=$this->_via->GetSolPersonalVBuscar($personal,$statusstep,$statussol,$statuscom);

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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolPersonalVBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 2){

                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 0;
                $statuscom = 0;

                $this->view->id_search=$id;

                $solicitud=$this->view->sol_viatico=$this->_via->GetSolIdVBuscar($id,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolIdVBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 3){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $sitio = $this->_getParam('sitio'); 
                $this->view->sitio_search=$sitio; 
                
                $statusstep = 1;
                $statussol = 0;
                $statuscom = 0;

                $solicitud=$this->view->sol_viatico=$this->_via->GetSolSitioVBuscar($sitio,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolSitioVBuscarPag($table,$offset,$no_of_records_per_page,$sitio,$statusstep,$statussol,$statuscom);    
            }

        }


        if($status == 1) {
            
            if($opcion == 1){
            
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalid=$personal;
               
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;
               
                $solicitud=$this->view->sol_viatico=$this->_via->GetSolPersonalVBuscar($personal,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolPersonalVBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 2){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_viatico=$this->_via->GetSolIdVBuscar($id,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolIdVBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 3){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $sitio = $this->_getParam('sitio'); 
                $this->view->sitio_search=$sitio; 
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;

                $solicitud=$this->view->sol_viatico=$this->_via->GetSolSitioVBuscar($sitio,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolSitioVBuscarPag($table,$offset,$no_of_records_per_page,$sitio,$statusstep,$statussol,$statuscom);    
            }

        }


        if($status == 2) {
            
            if($opcion == 1){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalid=$personal;
                
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;
                
                $solicitud=$this->view->sol_viatico=$this->_via->GetSolPersonalVBuscar($personal,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolPersonalVBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 2){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_viatico=$this->_via->GetSolIdVBuscar($id,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolIdVBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 3){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $sitio = $this->_getParam('sitio'); 
                $this->view->sitio_search=$sitio; 
                
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;

                $solicitud=$this->view->sol_viatico=$this->_via->GetSolSitioVBuscar($sitio,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolSitioVBuscarPag($table,$offset,$no_of_records_per_page,$sitio,$statusstep,$statussol,$statuscom);    
            }

        }


        if($status == 3) {
            
            if($opcion == 1){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalid=$personal;
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;
                
                $solicitud=$this->view->sol_viatico=$this->_via->GetSolPersonalVBuscar($personal,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolPersonalVBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statuscom);
            
            }

            if($opcion == 2){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_viatico=$this->_via->GetSolIdVBuscar($id,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolIdVBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom);
            }


            if($opcion == 3){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $sitio = $this->_getParam('sitio'); 
                $this->view->sitio_search=$sitio; 
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;

                $solicitud=$this->view->sol_viatico=$this->_via->GetSolSitioVBuscar($sitio,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolSitioVBuscarPag($table,$offset,$no_of_records_per_page,$sitio,$statusstep,$statussol,$statuscom);    
            }

        }
    }   // Buscadores Solicitud viaticos general


    public function listaviaticoscontaAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;
        $wh="user_creacion";
        $table="viaticos_sol";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        
        $wh="id";
        $table="usuario";
        $user = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$user[0]['fkroles'];

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $sql = $this->_via->GetSolicitudViaContCount();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table = "sitios";
        $sitios = $this->view->sitios = $this->_via->GetordersitiosV();

        $table = "personal_campo";
        $this->view->personal = $this->_via->GetPersonalViaticos(); 

        if($status == 0) {

            $solicitud=$this->_via->GetSolicitudViaContCount();
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
            $table="viaticos_sol";
            $sql=$this->view->paginator= $this->_via->GetPagSolProcesoViaCont($table,$offset,$no_of_records_per_page);
            // var_dump($sql);exit;
        }

        if($status == 1){
            
            $solicitud=$this->_via->GetSolCancelViaCount();
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
            $table="viaticos_sol";
            $this->view->paginator= $this->_via->GetPagSolCancelVia($table,$offset,$no_of_records_per_page);
        }

        if($status == 2){
            $solicitud=$this->_via->GetSolFinViaCount();
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
            $table="viaticos_sol";
            $sql= $this->view->paginator= $this->_via->GetPagSolFinViaticos($table,$offset,$no_of_records_per_page);
        }
    } // Lista solicitudes viaticos contabilidad


    public function listasolvbuscarctbAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;

        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$usr[0]['fkroles'];

        $wh="id_usuario";
        $table="viaticos_sol";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $sql = $this->_via->GetSolicitudViaContCount();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table = "sitios";
        $sitios = $this->view->sitios = $this->_via->GetordersitiosV();

        $table = "personal_campo";
        $this->view->personal = $this->_via->GetPersonalViaticos();   

        $opcion = $this->_getParam('op');
        $this->view->opcion_search=$opcion;

        if($status == 0) {
            
            if($opcion == 1){
            
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalid=$personal;
               
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;
               
                $solicitud=$this->view->sol_viatico=$this->_via->GetSolPersonalVBuscar($personal,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolPersonalVBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 2){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_viatico=$this->_via->GetSolIdVBuscar($id,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolIdVBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 3){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $sitio = $this->_getParam('sitio'); 
                $this->view->sitio_search=$sitio; 
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;

                $solicitud=$this->view->sol_viatico=$this->_via->GetSolSitioVBuscar($sitio,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolSitioVBuscarPag($table,$offset,$no_of_records_per_page,$sitio,$statusstep,$statussol,$statuscom);    
            }

        }


        if($status == 1) {
            
            if($opcion == 1){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalid=$personal;
                
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;
                
                $solicitud=$this->view->sol_viatico=$this->_via->GetSolPersonalVBuscar($personal,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolPersonalVBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 2){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_viatico=$this->_via->GetSolIdVBuscar($id,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolIdVBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 3){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $sitio = $this->_getParam('sitio'); 
                $this->view->sitio_search=$sitio; 
                
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;

                $solicitud=$this->view->sol_viatico=$this->_via->GetSolSitioVBuscar($sitio,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolSitioVBuscarPag($table,$offset,$no_of_records_per_page,$sitio,$statusstep,$statussol,$statuscom);    
            }

        }


        if($status == 2) {
            
            if($opcion == 1){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalid=$personal;
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;
                
                $solicitud=$this->view->sol_viatico=$this->_via->GetSolPersonalVBuscar($personal,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolPersonalVBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statuscom);
            
            }

            if($opcion == 2){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_viatico=$this->_via->GetSolIdVBuscar($id,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolIdVBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom);
            }


            if($opcion == 3){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $sitio = $this->_getParam('sitio'); 
                $this->view->sitio_search=$sitio; 
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;

                $solicitud=$this->view->sol_viatico=$this->_via->GetSolSitioVBuscar($sitio,$statusstep,$statussol,$statuscom);
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
                $table="viaticos_sol";
                $this->view->paginator= $this->_via->GetSolSitioVBuscarPag($table,$offset,$no_of_records_per_page,$sitio,$statusstep,$statussol,$statuscom);    
            }

        }
    } // Buscar solicitudes viaticos contabilidad


    public function soldetailviaticosAction(){
        
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            
            $table = "viaticos_sol";
            $wh = "id";
            $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);

            $table = "viaticos_sol";
            $this->view->detalle = $this->_via->GetDetallesViaticos($table,$id); 

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


    public function requestchangeviaticossolAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
            
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id_user = $usr[0]['id'];
            $nombre= $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $dato = date("Y-m-d H:i:s");


        if($this->getRequest()->getPost()){

            $table="viaticos_sol";
            $result=$this->_via->UpdateAceptViaticos($post,$table,$hoy,$nombre);

            if ($result) {

                return $this->_redirect('/viaticos/soldetailviaticos/id/'.$post['id_solicitud'].'/status/1');
            
            }else{
            
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            
            }
        }
    }   // END REQUEST ACEPTAR SOLICITUD


    public function requestchangecancelviaticoAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id_user = $usr[0]['id'];
            $nombre= $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];
        
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $dato = date("Y-m-d H:i:s");

        if($this->getRequest()->getPost()){

            $table="viaticos_sol";
            $result=$this->_via->UpdateRechazarViaticos($post,$table,$hoy,$nombre);

            if ($result) {

                return $this->_redirect('/viaticos/soldetailviaticos/id/'.$post['id_solicitud'].'/status/2');

            }else{

                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 

            }
        }
    }   // END REQUEST CANCELAR SOLICITUD


    public function soldetailviaticoscbtAction(){    

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            
            $table = "viaticos_sol";
            $wh = "id";
            $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);

            $table = "viaticos_sol";
            $this->view->detalle = $this->_via->GetDetallesViaticos($table,$id); 

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

    public function requestchangecancelviaticoscontaAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id_user = $usr[0]['id'];
            $nombre= $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];
        
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $dato = date("Y-m-d H:i:s");

        if($this->getRequest()->getPost()){

            $table="viaticos_sol";
            $result=$this->_via->UpdateRechazarViaticos($post,$table,$hoy,$nombre);


            if ($result) {

                return $this->_redirect('/viaticos/soldetailviaticoscbt/id/'.$post['id_solicitud'].'/status/2');
            
            }else{
            
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            
            }
        }
    }   // END REQUEST CANCELAR SOLICITUD


    public function requestaddcmptpagoviaticosAction(){
        
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
                    $url1 = 'img/viaticos/';
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
            $id_user = $usr[0]['id'];
            $nombre= $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];
                
            $table="viaticos_sol";
            $result=$this->_via->UpdatePagoSolViaticos($post,$table,$hoy,$status_pago,$id_user,$nombre,$urldb);

        
            if ($result) {
                    // return $this-> _redirect('/vehiculos/solicituddetailctb/id/'.$post['id_solicitud'].'/status/2');
                return $this-> _redirect('/viaticos/listaviaticosconta/status/0');
        
            }else{
        
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
        
            }
        
        }
    }

    
    public function solicitudviaticosAction(){
        
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            
            $table = "viaticos_sol";
            $wh = "id";
            $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);

            $table = "viaticos_sol";
            $this->view->detalle = $this->_via->GetDetallesViaticos($table,$id); 

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


    public function solicitudviaticosctbAction(){
        
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            
            $table = "viaticos_sol";
            $wh = "id";
            $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);

            $table = "viaticos_sol";
            $this->view->detalle = $this->_via->GetDetallesViaticos($table,$id); 

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

     public function excelpagadosAction(){
    
        $table="viaticos_sol";
        $this->view->excelvpagados = $this->_via->GetExcel($table);

    }   // EXCEL VEHICULOS


    public function formatSizeUnits($bytes){ 

        if ($bytes >= 1073741824) {
            
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        
        elseif ($bytes >= 1048576) {
            
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        
        elseif ($bytes >= 1024) {
            
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        
        elseif ($bytes > 1) {
            
            $bytes = $bytes . ' bytes';
        }
        
        elseif ($bytes == 1) {
            
            $bytes = $bytes . ' byte';
        }
        
        else {
            
            $bytes = '0 bytes';
        }

        return $bytes;
    }   //END FUNCION DE TAMAÑO DE IMAGEN

}


    



