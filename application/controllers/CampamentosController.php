<?php

class CampamentosController extends Zend_Controller_Action{
	private $_season;
    private $_session;
    private $_user; 
    private $_veh;
    private $_cam;

    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_project = new Application_Model_GpsProyectoModel;
        $this->_colo = new Application_Model_GpsColocacionModel;
        $this->_veh = new Application_Model_GpsVehiculosModel;
        $this->_cam = new Application_Model_GpsCampamentosModel;

        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }
    }

    public function addcampamentoAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="sitios";
        $this->view->sitios = $this->_cam->GetordernombresitiosC($table);

        $table="personal_campo";
        $this->view->per = $this->_cam->GetPersonalC($table);

        $table="tipo_proyecto";
        $this->view->proyectos = $this->_season->GetAll($table);

        $table="campamentos_status";
        $this->view->campamentos_s = $this->_season->GetAll($table); 

        $table="campamentos";
        $campinv=$this->_season->GetAll($table);
        $count=count($campinv);

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
        $table="campamentos";
        $sql= $this->view->paginator= $this->_cam->Getpaginationcam($table,$offset,$no_of_records_per_page);  


    }// END Campamentos Inventario

 public function buscarcampAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="sitios";
        $this->view->sitios = $this->_cam->GetordernombresitiosC($table);

        $table="personal_campo";
        $this->view->per = $this->_cam->GetPersonalC($table);

        $table="tipo_proyecto";
        $this->view->proyectos = $this->_season->GetAll($table);

        $table="campamentos_status";
        $this->view->campamentos_s = $this->_season->GetAll($table); 

        if($this->_hasParam('sitio')){
            $name = $this->_getParam('sitio');
            $sitio_n= $this->_cam->sitio($name);
            
            $option= 1;
            $this->view->name_sitio=$name; 
            
            $this->view->status_c= 0;

            $this->view->option=$option; 
            $count=count($sitio_n);
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
            $sql= $this->view->paginator= $this->_cam->sitioccount($name,$offset,$no_of_records_per_page);
        }

        if($this->_hasParam('status')){
            $status = $this->_getParam('status');
            $status_cam= $this->_cam->statusc($status);
            $this->view->status_c=$status;
         
            $name="vacio";
            $this->view->name_sitio=$name;

            $option= 2;
            $this->view->option=$option;
            $count=count($status_cam);
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
            $sql= $this->view->paginator= $this->_cam->statusccount($status,$offset,$no_of_records_per_page);
        } 

    } //End Buscar Campamento


    public function requestdeletecampAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="campamentos";
            $wh="id_campamento";
            $result = $this->_season->deleteAll($id,$table,$wh);

            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST DELETE Campamento


    public function requestaddcampAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        
        $resp = $post['statusa'];
        if ($resp == "") {
            $statusa = 0;  
        } else {
            $statusa = $post['statusa'];
        }

        $pagod=$post['pagod'];
         if ($pagod == true) {
            $statusd = 1;
        }else{
            $statusd=0;
        }

        if($this->getRequest()->getPost()){
            $table="campamentos";
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
                    $url1 = 'img/campamentos/contratos/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            $table="campamentos";
            $result = $this->_cam->insertcamp($post,$table,$urldb,$statusd,$statusa);

            if ($result) {
                return $this-> _redirect('/campamentos/addcampamento');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    } //END ADD CAMPAMENTO

    public function campeditAction(){
           if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $table="campamentos";
            $wh="id_campamento";
            $this->view->campamento_act = $this->_season->GetSpecific($table,$wh,$id);

            $table="sitios";
            $this->view->sitios = $this->_cam->GetordernombresitiosC($table);

            $table="tipo_proyecto";
            $this->view->proyectos = $this->_season->GetAll($table);   

            $table="personal_campo";
            $this->view->per = $this->_cam->GetPersonalC($table); 

            $table="campamentos_status";
            $this->view->campamentos_s = $this->_season->GetAll($table);  


        }else {
            return $this-> _redirect('/');
        }   

    }// END EDIT CAMPAMENTOS

    public function requestupdatecamAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $resp = $post['statusa'];
        if ($resp == "") {
            $statusa = 0;  
        } else {
            $statusa = $post['statusa'];
        }

        $pagod=$post['pagod'];
         if ($pagod == true) {
            $statusd = 1;
        }else{
            $statusd=0;
        }

        if($this->getRequest()->getPost()){

            $table="campamentos";
            $name = $_FILES['url']['name'];
            $urldb = $post["imahidden"];
            if(!empty($_FILES["url"]["name"])) {
                $bytes = $_FILES['url']['size'];
                $res = $this->formatSizeUnits($bytes);
                if ($res == 0) {
                    print '<script language="JavaScript">'; 
                    print 'alert("La imagen supera el maximo de tamaño");'; 
                    print '</script>';
                } else {
                    unlink($post['imahidden']);
                    $info1 = new SplFileInfo($_FILES['url']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/campamentos/contratos/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="campamentos";
            $result = $this->_cam->updatecamp($post,$table,$urldb,$statusd,$statusa);

            if ($result) {
                return $this-> _redirect('/campamentos/addcampamento');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    } //END UPDATE CAMPAMENTOS


    public function campdetailAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="vehiculos";
            $this->view->campamentosc = $this->_cam->GetCampamentosAll($table,$id);


            $camp = $this->_getParam('id');
            $this->view->idca=$camp;
        }else {
            return $this-> _redirect('/');
        }       

    } // END CAMPAMENTOS DETAIL


    public function requestrentarAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();


        if($this->getRequest()->getPost()){
            $table="campamentos";
            $name = $_FILES['url']['name'];
            $urldb = $post["imahidden"];
            if(!empty($_FILES["url"]["name"])) {
                $bytes = $_FILES['url']['size'];
                $res = $this->formatSizeUnits($bytes);
                if ($res == 0) {
                    print '<script language="JavaScript">'; 
                    print 'alert("La imagen supera el maximo de tamaño");'; 
                    print '</script>';
                } else {
                    unlink($post['imahidden']);
                    $info1 = new SplFileInfo($_FILES['url']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/campamentos/contratos/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="campamentos";
            $result = $this->_cam->updatecampamento($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/campamentos/campdetail/id/'.$post['idc'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    } // Rentar Campamento

    public function requestcerrarcAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
            
        if($this->getRequest()->getPost()){
            $table="campamentos";
            $name = $_FILES['url']['name'];
            $urldb = $post["imahidden"];
            if(!empty($_FILES["url"]["name"])) {
                $bytes = $_FILES['url']['size'];
                $res = $this->formatSizeUnits($bytes);
                if ($res == 0) {
                    print '<script language="JavaScript">'; 
                    print 'alert("La imagen supera el maximo de tamaño");'; 
                    print '</script>';
                } else {
                    unlink($post['imahidden']);
                    $info1 = new SplFileInfo($_FILES['url']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/campamentos/devoluciones/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");

            $table="campamentos";
            $result = $this->_cam->updatecampamentoCerrar($post,$table,$urldb,$hoy);
            if ($result) {
                
                return $this-> _redirect('/campamentos/campdetail/id/'.$post['idc'].''); 
            }else{
            
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }       //End Cerrar Campamento

    public function requestcerrarcampAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
            
        if($this->getRequest()->getPost()){
            
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");

            $table="campamentos";
            $result = $this->_cam->updateCampSrem($post,$table,$hoy);
            
            if ($result) {
                
                return $this-> _redirect('/campamentos/campdetail/id/'.$post['idc'].''); 
            
            }else{
            
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }       //End Cerrar Campamento

    public function excelcamAction(){
        $status=$this->_getParam('status');
        $this->view->status=$status;

        $table="campamentos";
        $this->view->excelc = $this->_cam->excelc($table);

    }   // EXCEL Campamentos


    public function statuscAction(){

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="campamentos_status";
        $this->view->status_camp = $this->_season->GetAll($table);

        $stcamp=$this->_season->GetAll($table);
        $count=count($stcamp);

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
        $table="campamentos_status";
        $sql= $this->view->paginator= $this->_cam->Getpaginationst($table,$offset,$no_of_records_per_page);   

    }   // Status Campamentos

    public function requestaddstatusAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){

            $table="campamentos_status";
            $result = $this->_cam->insertstatus($post,$table);
            if ($result) {
                return $this-> _redirect('/campamentos/statusc');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   //END ADD STATUS

    public function statuseditAction(){
        
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $table="campamentos_status";
            $wh="id_status";
            $this->view->status_camp = $this->_season->GetSpecific($table,$wh,$id);

        }else {
            return $this-> _redirect('/');
        }   
    }  // END EDIT STATUS

    public function requestupdatestatusAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            $table="campamentos_status";
            $result = $this->_cam->updatestatusc($post,$table);
            if ($result) {
                return $this-> _redirect('/campamentos/statusc');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST UPDATE STATUS  
    
    public function requestdeletestatusAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="campamentos_status";
            $wh="id_status";
            $result = $this->_season->deleteAll($id,$table,$wh);

            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST DELETE STATUS CAMPAMENTO


        public function getproyectosAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){

            $letra = $post['sitio'];
            $result = $this->_cam->consultaproyecto($letra);

            print json_encode($result);

            exit;
            
            // return $html;

            // $html="";

            // // foreach ($result as $key => $value) {
        
            //     $html.="<option value='".$value['idepp']."'>".$value['talla']."</option>";
        
            // }
        
        //     echo $html;

        //     if ($result) {
        
        //         echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
        
        //     }else{
        
        //         print '<script language="JavaScript">';
        //         print 'alert("Ocurrio un error: Comprueba los datos.");';
        //         print '</script>';
        
        //     }
        
         }
    }//END REQUEST GET PROYECTOS



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


    



