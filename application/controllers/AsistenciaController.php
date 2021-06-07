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
    }

    public function horaextraAction(){
    	$nombre = $this->_getParam('sitio');
    	$this->view->sitio = $nombre;
    	$this->view->personal = $this->_asistencia->getpersonalsitiocuadrilla($nombre);
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
    }

    public function requestaddhoraextrapersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        // var_dump($post);exit;
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $ap_paterno = $usr[0]['ap'];
        $nombre = $usr[0]['nombre']." ".$ap_paterno;

        $table = "personal_campo";
        if($post['act_todos'] != ""){
	        foreach ($post['personal'] as $key) {
	        	$id = $key;
	        	$value = $post['act_todos'];
	        	$result = $this->_asistencia->updatehoraextra($post,$table,$id,$value,$hoy,$nombre); 
	        }
        }else{
	        $op = 0;
	        foreach ($post['personal'] as $key) {
	        	$id = $key;
	        	$value = $post['hora_extra'][$op];
	        	$result = $this->_asistencia->updatehoraextra($post,$table,$id,$value,$hoy,$nombre);  
	        	$op ++;
	        }
        }

        if ($result) {
            return $this-> _redirect('/asistencia/horaextra/sitio/'.$post['sitio'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 

    }
}