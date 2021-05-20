<?php

class PersonalController extends Zend_Controller_Action{
	private $_season;
    private $_session;
    private $_user;

    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_personal = new Application_Model_GpsPersonalModel;

        if(empty($this->_session->id)){ $this->redirect('/home/login'); }    
    }

    public function listapersonalAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $id=1; $wh="status_campo";
        $table="personal_campo";
        $pagi_count = $this->_season->GetSpecific($table,$wh,$id);
        $count=count($pagi_count);
        if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

        $no_of_records_per_page = 20;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $this->view->paginator= $this->_personal->getpersonalcuadrilla($offset,$no_of_records_per_page,$id); 
    }

    public function asignarpersonalAction(){
        $table="sitios";
        $this->view->sitios = $this->_season->GetAll($table); 
        $this->view->proyectos =$this->_sitio->tiposproyectospersonal();       
    }

    public function procesoasignarAction(){
        $sitio=$this->_getParam('sitio');  $this->view->sitio_id=$sitio;
        $proyecto=$this->_getParam('proyecto'); $this->view->proyecto=$proyecto;

        // FECHA INICIAL 
            $dateuno=$this->_getParam('dia_inicial'); 
            $datedos=$this->_getParam('mes_inicial'); 
            $datetres=$this->_getParam('year_inicial');
            $datos_uno = $dateuno."/".$datedos."/".$datetres;
            $this->view->fecha_inicial=$datos_uno;
        // END FECHA INICIAL

        // FECHA FINAL
            $dateone=$this->_getParam('dia_final'); 
            $datetwo=$this->_getParam('mes_final'); 
            $datethree=$this->_getParam('year_final');
            $datos_one = $dateone."/".$datetwo."/".$datethree;
            $this->view->fecha_final=$datos_one;
        // END FECHA FINAL

        $wh="id";
        $table="sitios";
        $this->view->sitio = $this->_season->GetSpecific($table,$wh,$sitio);     
        $this->view->proyectos = $this->_sitio->proyectoasignarpersonal($proyecto);  

        $id=1; $status=0; $wh="status_campo";
        $table="personal_campo";
        $pagi_count = $this->_personal->getpersonalasignarcount($id,$status);
        $count=count($pagi_count);
        if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

        $no_of_records_per_page = 20;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $this->view->paginator= $this->_personal->getpersonalasignarpaginator($offset,$no_of_records_per_page,$id,$status); 
    }


    public function requestaddpersonalsitioAction(){
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
        $nombre_user = $usr[0]['nombre']." ".$ap_paterno;

        $id=$post['sitio'];
        $wh="id";
        $table="sitios";
        $sitio = $this->_season->GetSpecific($table,$wh,$id);
        $name_sitio = $sitio[0]['nombre'];

        foreach ($post['ids'] as $key) {                
            $table="personal_campo";
            $id = $key;
            $result = $this->_sitio->asignacionpersonalasitio($post,$table,$name_sitio,$id);  
        }

            if ($result) {
                return $this-> _redirect('/personal/listapersonal');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }        var_dump($post);exit;
    } 

}
