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
        $this->_project = new Application_Model_GpsProyectoModel;
        $this->_servicios = new Application_Model_GpsServicioModel;
        $this->_ordencompra = new Application_Model_GpsSolicitudOrdenModel;
        $this->_comprobacion = new Application_Model_GpsComprobacionModel;
        $this->_gasolina = new Application_Model_GpsGasolinaModel;
        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }    
    }

    public function listapersonalAction(){
        
    }

}
