<?php
class NominaController extends Zend_Controller_Action{
    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_personal = new Application_Model_GpsPersonalModel;
        $this->_asistencia = new Application_Model_GpsAsistenciaModel;
        $this->_nomina = new Application_Model_GpsNominaModel;
        if(empty($this->_session->id)){ $this->redirect('/home/login'); }    
    }

    public function solicitudnominaAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento = $status;

        $st = 0; $pago =0;
        $enproceo =$this->_nomina->getsolicitudnomina($st,$pago);
        $this->view->enproceso = count($enproceo);

        if($status == 0){
            $st = 0; $pago =0;
            $enproceo =$this->_nomina->getsolicitudnomina($st,$pago);    
            $count=count($enproceo);   
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_nomina->getnominasolicitud($offset,$no_of_records_per_page,$st,$pago);     
        }

    }

}