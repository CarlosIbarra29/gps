<?php
class SeguimientoController extends Zend_Controller_Action{
    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_project = new Application_Model_GpsProyectoModel;
        $this->_servicios = new Application_Model_GpsServicioModel;
        $this->_ordencompra = new Application_Model_GpsSolicitudOrdenModel;
        $this->_archivo = new Application_Model_GpsArchivosModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_torrenueva = new Application_Model_GpsTorrenuevaModel;
        $this->_gasolina = new Application_Model_GpsGasolinaModel;
        $this->_comprobacion = new Application_Model_GpsComprobacionModel;
        $this->_envio = new Application_Model_GpsEnvioModel;
        $this->_material = new Application_Model_GpsMaterialesModel;
        $this->_seguimiento = new Application_Model_GpsSeguimientoModel;

        if(empty($this->_session->id)){ $this->redirect('/home/login'); }

    }//END INIT

    public function seguimientoproyectosAction(){
        $table="status_proyecto";
        $this->view->status_proyecto = $this->_season->GetAll($table);
        $table="status_cliente";
        $this->view->status_cliente = $this->_season->GetAll($table);

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $solicitud = $this->_seguimiento->getproyectosseguimiento(); 
        $count=count($solicitud);
        if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

        $no_of_records_per_page = 25;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $this->view->paginator= $this->_seguimiento->paginatorseguimiento($offset,$no_of_records_per_page);
    }

    public function buscadorseguimientoAction(){
        $table="status_proyecto";
        $this->view->status_proyecto = $this->_season->GetAll($table);
        $table="status_cliente";
        $this->view->status_cliente = $this->_season->GetAll($table);
        
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $op=$this->_getParam('op');
        $this->view->op_option=$op;

        if($op == 1){
            $option = "id_cliente";
            $id = $this->_getParam('cliente');
            $this->view->cliente=$id;
            $solicitud = $this->_seguimiento->getproyectosseguimientosearch($option, $id); 
            $count=count($solicitud);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_seguimiento->paginatorseguimientosearch($offset,$no_of_records_per_page,$option,$id);
        }

        if($op == 2){
            $nombre = $this->_getParam('sitio');
            $this->view->sitio=$nombre;
            $solicitud = $this->_seguimiento->getproyectosseguimientosearchsitio($nombre); 

            $count=count($solicitud);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_seguimiento->paginatorseguimientosearchsitio($offset,$no_of_records_per_page,$nombre);
        }

        if($op == 3){
            $option = "sp.nombre_status";
            $id = $this->_getParam('gps');
            $this->view->gps=$id;
            $wh="id";
            $table="status_proyecto";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id = $usr[0]['nombre_status'];
            $solicitud = $this->_seguimiento->getproyectosseguimientosearch($option, $id); 
            $count=count($solicitud);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_seguimiento->paginatorseguimientosearch($offset,$no_of_records_per_page,$option,$id);
        }

        if($op == 4){
            $option = "sc.nombre_status";
            $id = $this->_getParam('status');
            $this->view->status=$id;
            $wh="id";
            $table="status_cliente";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id = $usr[0]['nombre_status'];
            $solicitud = $this->_seguimiento->getproyectosseguimientosearch($option, $id); 
            $count=count($solicitud);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_seguimiento->paginatorseguimientosearch($offset,$no_of_records_per_page,$option,$id);
        }

    }
}