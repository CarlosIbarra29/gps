<?php
require_once '../vendor/autoload.php';
class ComprobacionController extends Zend_Controller_Action{
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
        $this->_sitio = new Application_Model_GpsSitioModel;

        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }    
    }

    public function listafacturasAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina; 

        $table="factura_efecticard";
        $solicitud = $this->_season->GetAll($table);
        $count = count($solicitud);
    
        if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{ $pagina= $this->view->pagina = 1;} 
        $no_of_records_per_page = 25;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $this->view->paginator= $this->_comprobacion->getAllfacturaslist($offset,$no_of_records_per_page);
    }

    public function editfacturaAction(){
        $id=$this->_getParam('id');
        $this->view->id_sol=$id; 

        $wh="id";
        $table="factura_efecticard";
        $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id); 
    }

    public function busquedafacturaAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina; 

        $op=$this->_getParam('op');
        $this->view->opcion_search =$op; 

        if($op == 1){
            $factura=$this->_getParam('factura');
            $this->view->factura =$factura; 

            $table="factura_efecticard";
            $solicitud = $this->_comprobacion->getfacturacount($factura);
            $count = count($solicitud);
        
            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{ $pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getfacturapaginator($offset,$no_of_records_per_page,$factura);
        }

        if($op == 2){
            $name=$this->_getParam('name');
            $this->view->name =$name; 

            $table="factura_efecticard";
            $solicitud = $this->_comprobacion->getnamecount($name);
            $count = count($solicitud);
        
            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{ $pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getnamepaginator($offset,$no_of_records_per_page,$name);
        }

        if($op == 3){
            $fecha=$this->_getParam('fecha');
            $this->view->fecha_op =$fecha; 

            $table="factura_efecticard";
            $solicitud = $this->_comprobacion->getdatecount($fecha);
            $count = count($solicitud);
        
            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{ $pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getdatepaginator($offset,$no_of_records_per_page,$fecha);
        }

        if($op == 4){
            $id=$this->_getParam('id');
            $this->view->id_op =$id; 

            $table="factura_efecticard";
            $solicitud = $this->_comprobacion->getidcount($id);
            $count = count($solicitud);
        
            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{ $pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getidpaginator($offset,$no_of_records_per_page,$id);
        }

        if($op == 5){
            $status=$this->_getParam('status');
            $this->view->status =$status; 

            $table="factura_efecticard";
            $solicitud = $this->_comprobacion->getstatuscount($status);
            $count = count($solicitud);
        
            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{ $pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getstatuspaginator($offset,$no_of_records_per_page,$status);
        }

    }

    public function nuevosaldocomprobacionAction(){
        $table = "sitios";
        $servicios = $this->view->sitios = $this->_sitio->Getordernombresitios();

        $id = $this->_getParam('dato');
        $this->view->solicitud_id = $id;
        $wh="id";
        $table="comprobacion_solicitud";
        $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);

    }

    public function solicitudescajachicaAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $dato = $usr[0]['nombre']." ". $usr[0]['ap']." ".$usr[0]['am'];
        $this->view->user=$dato;
        $this->view->personal = $this->_comprobacion->getpersonalactivo();

        $proceso = 0;
        $pago = 0;
        $ver = $this->_comprobacion->getcomprobacionproceso($proceso,$pago);
        $count = count($ver);
        $this->view->enproceso=$count;

        if($status == 0){
            $proceso = 0;
            $pago = 0;
            $solicitud= $this->_comprobacion->getcomprobacionproceso($proceso,$pago);
            $count=count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacion($proceso,$pago,$offset,$no_of_records_per_page);
        }
        // SOLICITUDES EN PROCESO

        if($status == 1){
            $aceptada = 2;
            $pago = 0;
            $solicitud= $this->_comprobacion->getcomprobacionproceso($aceptada,$pago);
            $count=count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacion($aceptada,$pago,$offset,$no_of_records_per_page);
        }
        // SOLICITUDES ACEPTADAS

        if($status == 2){

            $rechazada = 1;
            $pago = 3;
            $solicitud= $this->_comprobacion->getcomprobacionproceso($rechazada,$pago);
            $count=count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacion($rechazada,$pago,$offset,$no_of_records_per_page);
        }
        // SOLICITUDES Rechazada

        if($status == 3){
            $aceptada = 2;
            $pago = 1;
            $solicitud= $this->_comprobacion->getcomprobacionproceso($aceptada,$pago);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacion($aceptada,$pago,$offset,$no_of_records_per_page);
        }
        // SOLICITUDES ACEPTADAS
    }

    public function reportecomprobacionesAction(){
        $residente = $this->_getParam('residente');
        $this->view->id_residente = $residente;
        $id = $this->_getParam('id');
        $this->view->id_solicitud = $id;

        $wh = "id";
        $table = "comprobacion_solicitud";
        $this->view->info_solicitud = $this->_season->GetSpecific($table,$wh,$id);

        $wh="id_comprobacion";
        $table="comprobaciones";
        $this->view->solicitudes_anteriores = $this->_comprobacion->getfacturasenproceso($id);  

        $wh="id_comprobacion";
        $table="comprobaciones";
        $facturable = 1;
        $ver =$this->view->facturable_si = $this->_comprobacion->getfacturasenprocesofacturable($id,$facturable);  

        $wh="id_comprobacion";
        $table="comprobaciones";
        $facturable = 2;
        $ver= $this->view->facturable_no = $this->_comprobacion->getfacturasenprocesofacturable($id,$facturable);
    }

    public function cajachicacontabilidadAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $this->view->personal = $this->_comprobacion->getpersonalactivo();

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
            $aceptada = 2;
            $pago = 0;
            $solicitud= $this->_comprobacion->getcomprobacionproceso($aceptada,$pago);
            $count=count($solicitud);
            $this->view->enproceso = $count;

        if($status == 0){
            $aceptada = 2;
            $pago = 0;
            $solicitud= $this->_comprobacion->getcomprobacionproceso($aceptada,$pago);
            $count=count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacion($aceptada,$pago,$offset,$no_of_records_per_page);
        }

        if($status == 1){
            $aceptada = 2;
            $pago = 1;
            $solicitud= $this->_comprobacion->getcomprobacionproceso($aceptada,$pago);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacion($aceptada,$pago,$offset,$no_of_records_per_page);
        }

        if($status == 3){
            $aceptada = 4;
            $pago = 4;
            $solicitud= $this->_comprobacion->getcomprobacionproceso($aceptada,$pago);
            $count=count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacion($aceptada,$pago,$offset,$no_of_records_per_page);
        }

    }

    public function buscadorcajachicacontabilidadAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;
        $this->view->personal = $this->_comprobacion->getpersonalactivo();
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;  

            $aceptada = 2;
            $pago = 0;
            $solicitud= $this->_comprobacion->getcomprobacionproceso($aceptada,$pago);
            $count=count($solicitud);
            $this->view->enproceso = $count;

        $op=$this->_getParam('op');
        $this->view->op_search=$op;  

        if($status == 0){
            if($op == 1){
                $residente = $this->_getParam('residente');
                $proceso = 2;
                $pago = 0;
                $option = "nombre_residente";
                $solicitud= $this->_comprobacion->getcomprobacionprocesolike($proceso,$pago,$option,$residente);
                // var_dump($solicitud);exit;
                $count=count($solicitud);

                if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacionlikeres($proceso,$pago,$option,$residente,$offset,$no_of_records_per_page);
            }else{
                $sitio = $this->_getParam('sitio');
                $proceso = 2;
                $pago = 0;
                $option = "nombre_sitio";
                $solicitud= $this->_comprobacion->getcomprobacionprocesolikesitio($proceso,$pago,$option,$sitio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacionlike($proceso,$pago,$option,$sitio,$offset,$no_of_records_per_page);
            }
        }


        if($status == 1){
            if($op == 1){
                $residente = $this->_getParam('residente');
                $proceso = 2;
                $pago = 1;
                $option = "nombre_residente";
                $solicitud= $this->_comprobacion->getcomprobacionprocesolike($proceso,$pago,$option,$residente);
                // var_dump($solicitud);exit;
                $count=count($solicitud);

                if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacionlikeres($proceso,$pago,$option,$residente,$offset,$no_of_records_per_page);
            }else{
                $sitio = $this->_getParam('sitio');
                $proceso = 2;
                $pago = 1;
                $option = "nombre_sitio";
                $solicitud= $this->_comprobacion->getcomprobacionprocesolikesitio($proceso,$pago,$option,$sitio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacionlike($proceso,$pago,$option,$sitio,$offset,$no_of_records_per_page);
            }
        }

        if($status == 3){
            if($op == 1){
                $residente = $this->_getParam('residente');
                $proceso = 4;
                $pago = 4;
                $option = "nombre_residente";
                $solicitud= $this->_comprobacion->getcomprobacionprocesolike($proceso,$pago,$option,$residente);
                // var_dump($solicitud);exit;
                $count=count($solicitud);

                if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacionlikeres($proceso,$pago,$option,$residente,$offset,$no_of_records_per_page);
            }else{
                $sitio = $this->_getParam('sitio');
                $proceso = 4;
                $pago = 4;
                $option = "nombre_sitio";
                $solicitud= $this->_comprobacion->getcomprobacionprocesolikesitio($proceso,$pago,$option,$sitio);
                $count=count($solicitud);

                if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacionlike($proceso,$pago,$option,$sitio,$offset,$no_of_records_per_page);
            }
        }
    }


    public function detailcontabilidadAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $id = $this->_getParam('id');
        $this->view->id_solicitud=$id;
        $wh="id";
        $table="comprobacion_solicitud";
        $ver =$this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->id_residente=$ver[0]['id_residente'];
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        foreach ($usr as $key) {
           $fk=$key['fkroles'];
        }
        $this->view->fk_rol=$fk;

        if($status == 0){

            $id_residente = $ver[0]['id_residente'];
            $wh="id_residente";
            $table="comprobacion_solicitud";
            $solicitud = $this->_comprobacion->getresidentecomprobaciondos($id_residente);
            if(empty($solicitud)){
                $this->view->monto_anterior = 0;
            }else{
                $dos = end ($solicitud);
                $id_solicitud = $dos["id"];
                $wh="id_comprobacion";
                $table="comprobaciones";
                $ver =$this->view->solicitudes_anteriores = $this->_comprobacion->getfacturasenproceso($id_solicitud); 
                $this->view->monto_anterior = $solicitud[0]["monto"];   

                $wh="id_comprobacion";
                $table="comprobaciones";
                $facturable = 1;
                $ver =$this->view->facturable_si = $this->_comprobacion->getfacturasenprocesofacturable($id_solicitud,$facturable);  
                // var_dump($ver);exit;

                $wh="id_comprobacion";
                $table="comprobaciones";
                $facturable = 2;
                $ver= $this->view->facturable_no = $this->_comprobacion->getfacturasenprocesofacturable($id_solicitud,$facturable);  
            }
            
        }

        if($status == 1){
            $id_solicitud = $this->_getParam('id');
            $ver =$this->view->solicitudes_anteriores = $this->_comprobacion->getfacturasenproceso($id_solicitud);
                $wh="id_comprobacion";
                $table="comprobaciones";
                $facturable = 1;
                $ver =$this->view->facturable_si = $this->_comprobacion->getfacturasenprocesofacturable($id_solicitud,$facturable);  

                $wh="id_comprobacion";
                $table="comprobaciones";
                $facturable = 2;
                $ver= $this->view->facturable_no = $this->_comprobacion->getfacturasenprocesofacturable($id_solicitud,$facturable);
        }

        $id = $this->_getParam('id');
        $wh="id_solicitud";
        $table="comprobacion_pago";
        $this->view->pago_comprobante = $this->_season->GetSpecific($table,$wh,$id);    
    }


    public function detailreembolsoAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $id = $this->_getParam('id');
        $this->view->id_solicitud=$id;   
        $wh="id";
        $table="comprobacion_solicitud";
        $this->view->info_solicitud= $this->_season->GetSpecific($table,$wh,$id);

        $id = $this->_getParam('id');
        $wh="id_solicitud";
        $table="comprobacion_reembolso";
        $this->view->pago_comprobante = $this->_season->GetSpecific($table,$wh,$id);  
    }

    public function pdfreembolsoAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $id = $this->_getParam('id');
        $this->view->id_solicitud=$id;     
        $wh="id";
        $table="comprobacion_solicitud";
        $this->view->info_solicitud= $this->_season->GetSpecific($table,$wh,$id);

        $id = $this->_getParam('id');
        $wh="id_solicitud";
        $table="comprobacion_reembolso";
        $ver = $this->_season->GetSpecific($table,$wh,$id);  
        
        if(empty($ver)){
            $pago  = 1; // vacio
            $this->view->pago_if=$pago; 
        }else{
            $pago  = 2;
            $this->view->pago_if=$pago; 
            $this->view->pago_comprobante = $this->_season->GetSpecific($table,$wh,$id);  

        }
    }

    public function facturasauditadasAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $op=$this->_getParam('op');
        $this->view->op_status=$op;
        
        if($op == 0){
            $table="comprobacion_back";
            $solicitud = $this->_season->GetAll($table);
            $count = count($solicitud);
            
            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{ $pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getAllfacturasback($offset,$no_of_records_per_page);
        }

        if($op == 1){
            $id=1;
            $wh="status_back";
            $table="comprobacion_back";
            $solicitud = $this->_season->GetSpecific($table,$wh,$id);
            $count = count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{ $pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getspecificfacturasback($offset,$no_of_records_per_page,$id);
        }

        if($op == 2){
            $id=0;
            $wh="status_back";
            $table="comprobacion_back";
            $solicitud = $this->_season->GetSpecific($table,$wh,$id);
            $count = count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getspecificfacturasback($offset,$no_of_records_per_page,$id);
        }

    }

    public function cajachicaresidenteAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;
        $residente = $this->_getParam('residente');
        $this->view->nombre_residente=$residente;

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $this->view->personal = $this->_comprobacion->getpersonalactivo();

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $dato = $usr[0]['nombre']." ". $usr[0]['ap']." ".$usr[0]['am'];
        $this->view->user=$dato;

        $proceso = 0;
        $pago = 0;
        $option ="nombre_residente";
        $ver = $this->_comprobacion->getcomprobacionprocesolike($proceso,$pago,$option,$residente);
        $count = count($ver);
        $this->view->enproceso=$count;

        if($status == 0){
            $proceso = 0;
            $pago = 0;
            $option ="nombre_residente";
            $solicitud= $this->_comprobacion->getcomprobacionprocesolike($proceso,$pago,$option,$residente);
            $count=count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacionlike($proceso,$pago,$option,$residente,$offset,$no_of_records_per_page);
        }
        // SOLICITUDES EN PROCESO

        if($status == 1){
            $proceso = 2;
            $pago = 0;
            $option ="nombre_residente";
            $solicitud= $this->_comprobacion->getcomprobacionprocesolike($proceso,$pago,$option,$residente);
            $count=count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacionlike($proceso,$pago,$option,$residente,$offset,$no_of_records_per_page);
        }
        // SOLICITUDES ACEPTADAS

        if($status == 2){
            $proceso = 1;
            $pago = 0;
            $option ="nombre_residente";
            $solicitud= $this->_comprobacion->getcomprobacionprocesolike($proceso,$pago,$option,$residente);
            $count=count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacionlike($proceso,$pago,$option,$residente,$offset,$no_of_records_per_page);
        }
        // SOLICITUDES Rechazada

        if($status == 3){
            $proceso = 2;
            $pago = 1;
            $option ="id_residente";
            $solicitud= $this->_comprobacion->getcomprobacionprocesolike($proceso,$pago,$option,$residente);
            // var_dump($solicitud);exit;
            $count=count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacionlike($proceso,$pago,$option,$residente,$offset,$no_of_records_per_page);
        }
        // SOLICITUDES ACEPTADAS Y PAGADAS

    }


    public function buscarfacturaAction(){
        $factura = $this->_getParam('factura');
        $this->view->op=$factura; 
        $usr =$this->_comprobacion->getsearchfactura($factura); 

        if(empty($usr)){
            $uno = "1";
            $this->view->busqueda=$uno;  
        }else{
            $uno = "2";
            $this->view->busqueda=$uno;
            $this->view->factura =$this->_comprobacion->getsearchfactura($factura); 
        }

    }

    public function cajachicasitioAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;
        $sitio = $this->_getParam('sitio');
        $this->view->nombre_sitio=$sitio;

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $this->view->personal = $this->_comprobacion->getpersonalactivo();

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $dato = $usr[0]['nombre']." ". $usr[0]['ap']." ".$usr[0]['am'];
        $this->view->user=$dato;

        $proceso = 0;
        $pago = 0;
        $option ="nombre_sitio";
        $ver = $this->_comprobacion->getcomprobacionprocesolike($proceso,$pago,$option,$sitio);
        $count = count($ver);
        $this->view->enproceso=$count;

        if($status == 0){
            $proceso = 0;
            $pago = 0;
            $option ="nombre_sitio";
            $solicitud= $this->_comprobacion->getcomprobacionprocesolike($proceso,$pago,$option,$sitio);
            $count=count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina']; }else{$pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacionlike($proceso,$pago,$option,$sitio,$offset,$no_of_records_per_page);
        }
        // SOLICITUDES EN PROCESO

        if($status == 1){
            $proceso = 2;
            $pago = 0;
            $option ="nombre_sitio";
            $solicitud= $this->_comprobacion->getcomprobacionprocesolike($proceso,$pago,$option,$sitio);
            $count=count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{ $pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacionlike($proceso,$pago,$option,$sitio,$offset,$no_of_records_per_page);
        }
        // SOLICITUDES ACEPTADAS

        if($status == 2){
            $proceso = 1;
            $pago = 0;
            $option ="nombre_sitio";
            $solicitud= $this->_comprobacion->getcomprobacionprocesolike($proceso,$pago,$option,$sitio);
            $count=count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{ $pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacionlike($proceso,$pago,$option,$sitio,$offset,$no_of_records_per_page);
        }
        // SOLICITUDES Rechazada

        if($status == 3){
            $proceso = 2;
            $pago = 1;
            $option ="nombre_sitio";
            $solicitud= $this->_comprobacion->getcomprobacionprocesolike($proceso,$pago,$option,$sitio);
            $count=count($solicitud);

            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacionlike($proceso,$pago,$option,$sitio,$offset,$no_of_records_per_page);
        }
        // SOLICITUDES ACEPTADAS Y PAGADAS
    }


    public function cajachicadetailAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $id = $this->_getParam('id');
        $this->view->id_solicitud=$id;
        $wh="id";
        $table="comprobacion_solicitud";
        $ver =$this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);
        if($ver[0]['pago_status'] == 1){
            $wh="id_solicitud";
            $table="comprobacion_pago";
            $pago_dos = $this->view->pago_id = $this->_season->GetSpecific($table,$wh,$id);

            $pay= 1;
            $this->view->if_pago=$pay;
        }else{
            $pay= 0;
            $this->view->if_pago=$pay;
        }
        $this->view->id_residente=$ver[0]['id_residente'];

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        foreach ($usr as $key) {
           $fk=$key['fkroles'];
        }
        $this->view->fk_rol=$fk;
        if($status == 0 || $status == 1){

            $id_residente = $ver[0]['id_residente'];
            $wh="id_residente";
            $table="comprobacion_solicitud";
            $solicitud = $this->_comprobacion->getresidentecomprobaciondos($id_residente);
            if(empty($solicitud)){
                 $this->view->monto_anterior =0;
            }else{
                $dos = end ($solicitud);
                $id_solicitud = $dos["id"];
                $this->view->solicitud_ant = $id_solicitud;
                $wh="id_comprobacion";
                $table="comprobaciones";
                $ver =$this->view->solicitudes_anteriores = $this->_comprobacion->getfacturasenproceso($id_solicitud);  
                 $this->view->monto_anterior = $solicitud[0]["monto"];

                $wh="id_comprobacion";
                $table="comprobaciones";
                $facturable = 1;
                $ver =$this->view->facturable_si = $this->_comprobacion->getfacturasenprocesofacturable($id_solicitud,$facturable);  

                $wh="id_comprobacion";
                $table="comprobaciones";
                $facturable = 2;
                $ver= $this->view->facturable_no = $this->_comprobacion->getfacturasenprocesofacturable($id_solicitud,$facturable);
            }
           
        }

        if($status == 3){
            $id_solicitud = $this->_getParam('id');
            $ver =$this->view->solicitudes_anteriores = $this->_comprobacion->getfacturasenproceso($id_solicitud);

                $wh="id_comprobacion";
                $table="comprobaciones";
                $facturable = 1;
                $ver =$this->view->facturable_si = $this->_comprobacion->getfacturasenprocesofacturable($id_solicitud,$facturable);  

                $wh="id_comprobacion";
                $table="comprobaciones";
                $facturable = 2;
                $ver= $this->view->facturable_no = $this->_comprobacion->getfacturasenprocesofacturable($id_solicitud,$facturable);
        }
    }


    public function consolicitudescajachicaAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento = $status;  

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $proceso = 2;
        $pago = 0;
        $ver = $this->_comprobacion->getcomprobacionproceso($proceso,$pago);
        $count = count($ver);
        $this->view->enproceso=$count;

        if($status == 0){
            $aceptada = 2;
            $pago = 0;
            $solicitud= $this->_comprobacion->getcomprobacionproceso($aceptada,$pago);
            $count=count($solicitud);

            if(isset($_GET['pagina'])){$pagina = $_GET['pagina']; }else{$pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacion($aceptada,$pago,$offset,$no_of_records_per_page);
        } // SOLICITUDES ACEPTADAS

        if($status == 2){
            $aceptada = 2;
            $pago = 1;
            $solicitud= $this->_comprobacion->getcomprobacionproceso($aceptada,$pago);
            $count=count($solicitud);

            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1; } 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_comprobacion->getpaginatorcomprobacion($aceptada,$pago,$offset,$no_of_records_per_page);
        } // SOLICITUDES PAGADAS

    }

    public function requestaddnewsolicitudAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $id= $post['sitio'];
        $wh="id";
        $table="sitios";
        $resi = $this->_season->GetSpecific($table,$wh,$id);
        $name_sitio = $resi[0]['nombre'];

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $ap_paterno = $usr[0]['ap'];
            $nombre = $usr[0]['nombre']." ".$ap_paterno;

        $sitio = $post['proyecto'];
        $name = $this->_comprobacion->Gettiporpoyecto($sitio);
        $tipo_proyecto = $name[0]['nombre_proyecto'];
        $monto = 0;
        if($this->getRequest()->getPost()){
            $table="comprobacion_solicitud";
            $result = $this->_comprobacion->insertfirstcomprobacion($post,$table,$hoy,$nombre,$name_sitio,$tipo_proyecto,$monto);

            if ($result) {
                return $this-> _redirect('/solicitud/comprobacionesresidente/id/'.$post['id_residente'].' ');  
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }

    public function requestaddsolicitudrechazadaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $id= $post['sitio'];
        $wh="id";
        $table="sitios";
        $resi = $this->_season->GetSpecific($table,$wh,$id);
        $name_sitio = $resi[0]['nombre'];

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $ap_paterno = $usr[0]['ap'];
            $nombre = $usr[0]['nombre']." ".$ap_paterno;

        $sitio = $post['proyecto'];
        $name = $this->_comprobacion->Gettiporpoyecto($sitio);
        $tipo_proyecto = $name[0]['nombre_proyecto'];
        $table="comprobacion_solicitud";
        $monto = $post['monto_anterior'];
        $this->_comprobacion->refreshssolicitudcomprobada($post,$table);
        if($this->getRequest()->getPost()){
            $table="comprobacion_solicitud";
            $result = $this->_comprobacion->insertfirstcomprobacion($post,$table,$hoy,$nombre,$name_sitio,$tipo_proyecto,$monto);

            if ($result) {
                return $this-> _redirect('/solicitud/comprobacionesresidente/id/'.$post['id_residente'].' ');  
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }


    public function cargamasivafacturasAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $csv = new \ParseCsv\Csv();
        $csv->auto($_FILES['archivo']['tmp_name']);
        $datos = $csv->data;

        $table="factura_efecticard";
        $facturas= $this->_comprobacion->Getarrayfacturasefecticard();

        $no_factura = array();
        foreach ($datos as $key) {
            $id = $key['no_factura'];
            $wh="no_factura";
            $table="factura_efecticard";
            $usr = $this->_season->GetSpecific($table,$wh,$id);

            if(empty($usr)){
                $table="factura_efecticard";
                $result = $this->_comprobacion->insertfacturaefecticard($key,$table);
            }else{

            }
        }
        $result = 1 ;
        if ($result) {
            return $this-> _redirect('/solicitud/generarcombrobaciones');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }
    }

    public function pdfcomprobacionAction(){
        $id = $this->_getParam('id');
        $this->view->id_comprobacion = $id;  

        $residente = $this->_getParam('residente');
        $this->view->residente_id = $residente;  

        $op = $this->_getParam('op');
        $this->view->option_back = $op;  

        $status = $this->_getParam('status');
        $this->view->status_back = $status;  

        $wh="id";
        $table="personal_campo";
        $ver = $this->view->residente = $this->_season->GetSpecific($table,$wh,$residente);

        $wh = "id";
        $table = "comprobacion_solicitud";
        $in =  $this->view->info_solicitud = $this->_season->GetSpecific($table,$wh,$id);

        $wh="id_comprobacion";
        $table="comprobaciones";
        $this->view->solicitudes_anteriores = $this->_comprobacion->getfacturasenproceso($id);  

        $wh="id_comprobacion";
        $table="comprobaciones";
        $facturable = 1;
        $ver =$this->view->facturable_si = $this->_comprobacion->getfacturasenprocesofacturable($id,$facturable);  

        $wh="id_comprobacion";
        $table="comprobaciones";
        $facturable = 2;
        $ver= $this->view->facturable_no = $this->_comprobacion->getfacturasenprocesofacturable($id,$facturable);
    } 


    public function pdfcontabilidadAction(){
        $id = $this->_getParam('id');
        $this->view->id_comprobacion = $id;  

        $status = $this->_getParam('status');
        $this->view->status_back = $status;  

        $wh="id";
        $table="comprobacion_solicitud";
        $ver = $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id); 

        $id_res =$ver[0]['id_residente'];
        $wh="id";
        $table="personal_campo";
        $ver = $this->view->personal = $this->_season->GetSpecific($table,$wh,$id_res);
    }

    public function datosAction(){
        try {
            $id = $_POST['variable'];
            $aResponse = $this->_comprobacion->getfacturasenprocesopdf($id);  
            print json_encode( $aResponse, JSON_UNESCAPED_UNICODE);
            die();
        } catch (Exception $e) {
            echo "Caught exception: " . get_class($e) . "\n";
            echo "Message: " . $e->getMessage() . "\n";
        }
    }


    public function requestchangeaddstatussolicitudAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="comprobacion_solicitud";
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $result = $this->_comprobacion->Updatechangesolicitud($post,$table,$hoy);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL


    public function requestchangesitioresidenteAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id = $post['residente'];
            $wh="id_residente";
            $table="comprobacion_residente";
            $usr = $this->view->comprobacion= $this->_season->GetSpecific($table,$wh,$id);
            if (empty($usr)){
                $result = $this->_comprobacion->insertresidentecomprobacion($post,$table);
            }else{
                $result = $this->_comprobacion->refreshssitiocomprobacion($post,$table);
            }
   
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL

    public function requestchangesolicitudcajachicaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");

            $id = $this->_session->id;
            $table="usuario";
            $wh="id";
            $personal=$this->_season->GetSpecific($table,$wh,$id);
            $user = $personal[0]['nombre']. " ".$personal[0]['ap']." ".$personal[0]['am'];
            $table ="comprobacion_solicitud";
            $result = $this->_comprobacion->Updatesolicitudcajachica($post,$table, $hoy, $user);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL

    public function requestupdatebackfacturaleidaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");

            $id = $this->_session->id;
            $table="usuario";
            $wh="id";
            $personal=$this->_season->GetSpecific($table,$wh,$id);
            $user = $personal[0]['nombre']. " ".$personal[0]['ap']." ".$personal[0]['am'];
            $table ="comprobacion_back";
            $result = $this->_comprobacion->updateleidofactura($post,$table, $hoy, $user);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }

    public function requestchangefacturabackAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        $factura = $post['factura'];
        $wh="no_factura";
        $table="factura_efecticard";
        $usr = $this->_season->GetSpecific($table,$wh,$factura);
        if($post['factura'] == "No Facturable"){

        }else{
            $id_factura = $usr[0]['id'];
            $this->_comprobacion->refreshsbackfactura($id_factura,$table);            
        }

        if($this->getRequest()->getPost()){
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");

            $id = $this->_session->id;
            $table="usuario";
            $wh="id";
            $personal=$this->_season->GetSpecific($table,$wh,$id);
            $user = $personal[0]['nombre']. " ".$personal[0]['ap']." ".$personal[0]['am'];

            $table ="comprobacion_back";
            $this->_comprobacion->insertfacturaback($post,$table, $hoy, $user);

            $id=$post['id_factura'];
            $table="comprobaciones";
            $wh="id";
            $result = $this->_season->deleteAll($id,$table,$wh);
            if ($result) {
                return $this-> _redirect('/solicitud/comprobacionesresidente/id/'.$post['ids'].'');  
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL

    public function requestupdatefacturasatAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();  
        $table="factura_efecticard";
        $result = $this->_comprobacion->refreshsbackfacturasat($post,$table); 

        if ($result) {
            return $this-> _redirect('/comprobacion/editfactura/id/'.$post['ids'].'');  
        }else{
            print '<script language="JavaScript">';
            print 'alert("Ocurrio un error: Comprueba los datos.");';
            print '</script>';
        }

    }

    public function requestdeletefacturasatAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="factura_efecticard";
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

    public function requestaddcomprobantepagoAction(){
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
                $url1 = 'pdf/pago_comprobaciones/';
                $urldb = $url1.$info1;
                move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
            }
        }

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $user = $usr[0]['nombre']." ".$usr[0]['ap']." ". $usr[0]['am'];

        $table="comprobacion_solicitud";
        $result = $this->_comprobacion->Updatepagosolicitud($post,$table,$urldb,$hoy,$user);
        if ($result) {
            return $this-> _redirect('/comprobacion/cajachicadetail/id/'.$post["id"].'/status/0');
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

        $id = $post['actual_id'];
        $wh="id";
        $table="comprobacion_solicitud";
        $sol = $this->_season->GetSpecific($table,$wh,$id);
        $monto_solicitud = $sol[0]['monto'];
        $monto_anterior = $sol[0]['monto_anterior'];

        $id_com = $post['id_solicitud'];
        $wh="id";
        $table="comprobaciones";
        $comp = $this->_season->GetSpecific($table,$wh,$id_com);
        $monto_comprobacion = $comp[0]['monto_comprobacion'];
        
        $new_solicitud = $monto_solicitud - $monto_comprobacion;
        $new_anterior = $monto_anterior + $monto_comprobacion;

        $name_residente = $sol[0]['nombre_residente'];
        $fact_emaio = $comp[0]['facturable'];
        $monto_comemail = $comp[0]['monto_comprobacion'];
        $fecha_comprobacion = $comp[0]['fecha_user'];

        if($fact_emaio == 1){
            $factura_correo = $comp[0]['factura'];
        }else{
            $factura_correo = "No Factuable";
        }

        $table = "comprobaciones_delete";
        $this->_comprobacion->insertfirstcomprobaciondelete($comp,$post,$table);

        $id= $post['id_solicitud'];
        $table="comprobaciones";
        $wh="id";
        $result = $this->_season->deleteAll($id,$table,$wh);

        $table="comprobacion_solicitud";
        $result = $this->_comprobacion->Updatedeletecomprobacion($post,$table,$new_solicitud,$new_anterior);

        $protocol =  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://");
        $host = 'https://prueba.gpsc.com.mx';

        $email_send = "fherrera@gpsc.com.mx";
        if ($result) {

            $cabeceras = 'MIME-Version: 1.0' . "\r\n"; 
            $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            // $cabeceras .= 'To: ygarcia@gpsc.com.mx, dparra@gpsc.com.mx, cvega@gpsc.com.mx'."\r\n";
            $cabeceras .= 'To: cvega@gpsc.com.mx, ygarcia@gpsc.com.mx, ajuarez@gpsc.com.mx'."\r\n";
            $cabeceras .= 'From: Factura eliminada <gpsc@gpsc.com.mx>' . "\r\n";
            $contenido = 'GPSconstructivos Factura Eliminada'. "\r\n";

            $res=" 
                <tr>
                    <td colspan='3' valign='top' class='mcnTextBlockInner' style='mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><h4>".$name_residente."</h4></td>
                    <td  valign='top' class='mcnTextBlockInner' style='mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><h4>".$factura_correo."</h4></td>
                    <td valign='top' class='mcnTextBlockInner' style='mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><h4>"."$".$monto_comemail."</h4></td>
                    <td valign='top' class='mcnTextBlockInner' style='mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><h4>".$fecha_comprobacion."</h4></td> 
                    <td valign='top' class='mcnTextBlockInner' style='mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;'><h4>".$post['comentario']."</h4></td>
                </tr>";

    $contenido = '<!DOCTYPE html>
  <html>
  <head>
      <title>PEDIDO</title>
      
      <meta copyright="Copyright (c) 2020 Grupo Lion. All Rights Reserved.">
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
                    <td align="center" valign="top" id="bodyCell" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;border-top: 0;">
                        <!-- BEGIN TEMPLATE // -->
                        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                            <tbody><tr>
                                <td align="center" valign="top" id="templatePreheader" style="background:#FAFAFA none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FAFAFA;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 9px;">
                                    <!--[if (gte mso 9)|(IE)]>
                                    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                    <tr>
                                    <td align="center" valign="top" width="600" style="width:600px;">
                                    <![endif]-->
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
                                        <tbody><tr>
                                            <td valign="top" class="preheaderContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
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
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #656565;font-family: Helvetica;font-size: 12px;line-height: 150%;">
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
</table></td>
                                        </tr>
                                    </tbody></table>
                                    <!--[if (gte mso 9)|(IE)]>
                                    </td>
                                    </tr>
                                    </table>
                                    <![endif]-->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" id="templateHeader" style="background:#FFFFFF none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 0;">
                                    <!--[if (gte mso 9)|(IE)]>
                                    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                    <tr>
                                    <td align="center" valign="top" width="600" style="width:600px;">
                                    <![endif]-->
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
                                        <tbody><tr>
                                            <td valign="top" class="headerContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody class="mcnImageBlockOuter">
            <tr>
                <td valign="top" style="padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnImageBlockInner">
                    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                        <tbody><tr>
                            <td class="mcnImageContent" valign="top" style="padding-right: 9px;padding-left: 9px;padding-top: 0;padding-bottom: 0;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                <a href="'.$host.'" title="" class="" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                    <img align="center" alt="" src="https://prueba.gpsc.com.mx/img/logo-2.png" width="564" style="max-width: 960px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" class="mcnImage">
                                </a>
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
    </tbody>
</table></td>
                                        </tr>
                                    </tbody></table>
                                    <!--[if (gte mso 9)|(IE)]>
                                    </td>
                                    </tr>
                                    </table>
                                    <![endif]-->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" id="templateBody" style="background:#FFFFFF none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 9px;">
                                    <!--[if (gte mso 9)|(IE)]>
                                    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                    <tr>
                                    <td align="center" valign="top" width="600" style="width:600px;">
                                    <![endif]-->
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
                                        <tbody><tr>
                                            <td valign="top" class="bodyContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
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
                    <tbody><tr>
                        
                        <td valign="top" class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #202020;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: left;">
                        
                            <h1 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 26px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;">Factura Eliminada!</h1>
                            <br>
                            <h5 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 17px;font-style: normal;font-weight: 200;line-height: 125%;letter-spacing: normal;text-align: left;">Se ha eliminado una factura de la solicitud de caja chica No.
                            '.$post['actual_id'].'
                            </h5>

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
</table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <thead class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                
      </td></tr></tbody><thead line-height="30px" style="border-bottom: 2px solid #dadada;">
          <tr><th colspan="3" style="height: 60px;"><h4 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 18px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;">Residente</h4></th>
          <th><h4 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 18px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;">Factura</h4></th>
          <th><h4 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 18px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;">Monto</h4></th>
          <th><h4 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 18px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;">Fecha</h4></th>
          <th><h4 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 18px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;">Comentario</h4></th>
      </tr>
      </thead>
      <tbody class="mcnTextBlockOuter">
            '.$res.'
        <tr>
        </tr>
    </tbody>
</table>
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnCodeBlock" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody class="mcnTextBlockOuter">
        <tr>
            <td valign="top" class="mcnTextBlockInner" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                </td></tr></tbody><thead>
    <tr><th><h4 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 18px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;"></h4></th>
    <th><h4 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 18px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;"></h4></th>
    <th><h4 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 18px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;"></h4></th>
    <th><h4 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 18px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;"></h4></th>
</tr></thead>
            
        
    
</table></td>
                                        </tr>
                                    </tbody></table>
                                    <!--[if (gte mso 9)|(IE)]>
                                    </td>
                                    </tr>
                                    </table>
                                    <![endif]-->
                                </td>
                            </tr>
                            <tr>
                                <td align="center" valign="top" id="templateFooter" style="background:#FAFAFA none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FAFAFA;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 9px;">
                                    <!--[if (gte mso 9)|(IE)]>
                                    <table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
                                    <tr>
                                    <td align="center" valign="top" width="600" style="width:600px;">
                                    <![endif]-->
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;max-width: 600px !important;">
                                        <tbody><tr>
                                            <td valign="top" class="footerContainer" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody class="mcnFollowBlockOuter">
        <tr>
            <td align="center" valign="top" style="padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowBlockInner">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    <tbody><tr>
        <td align="center" style="padding-left: 9px;padding-right: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContent">
                <tbody><tr>
                    <td align="center" valign="top" style="padding-top: 9px;padding-right: 9px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                        <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                            <tbody><tr>
                                <td align="center" valign="top" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                    <!--[if mso]>
                                    <table align="center" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                    <![endif]-->
                                    
                                        <!--[if mso]>
                                        <td align="center" valign="top">
                                        <![endif]-->
                                        
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                        <tbody><tr>                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        
                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->
                                    
                                        <!--[if mso]>
                                        <td align="center" valign="top">
                                        <![endif]-->
                                        
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                        <tbody><tr>
                                                                                                                                
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
                                                    </td>
                                                </tr>
                                            </tbody></table>
                                        
                                        <!--[if mso]>
                                        </td>
                                        <![endif]-->
                                    
                                        <!--[if mso]>
                                        <td align="center" valign="top">
                                        <![endif]-->
                                        
                                        
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                <tbody><tr>
                                                    <td valign="top" style="padding-right: 0;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                            <tbody><tr>
                                                                <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                                                                        <tbody><tr>
                                                                            
                                                                            
                                                                            
                                                                        </tr>
                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                        </tbody></table>
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
                        </tbody></table>
                    </td>
                </tr>
            </tbody></table>
        </td>
    </tr>
</tbody></table>

            </td>
        </tr>
    </tbody>
</table></td>
                                        </tr>
                                    </tbody></table>
                                    <!--[if (gte mso 9)|(IE)]>
                                    </td>
                                    </tr>
                                    </table>
                                    <![endif]-->
                                </td>
                            </tr>
                        </tbody></table>
                        <!-- // END TEMPLATE -->
                    </td>
                </tr>
            </tbody></table>
        </center>
</body>
</html>';

            if(mail($email_send,"Factura Eliminada",$contenido,$cabeceras)){ 
                return $this-> _redirect('/comprobacion/cajachicadetail/id/'.$post['actual_id'].'/status/'.$post['status'].'');
            }else{
                return $this-> _redirect('/comprobacion/cajachicadetail/id/'.$post['actual_id'].'/status/'.$post['status'].'');
            }


           
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }
    }


    public function requestaddpagocajachicaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $id=$post['actual_id'];
        $wh="id";
        $table="comprobacion_solicitud";
        $sol_monto = $this->_season->GetSpecific($table,$wh,$id);
        $monto = $sol_monto[0]['monto'];

        date_default_timezone_set('America/Mexico_City');
        $fecha_pago = date("d-m-Y H:i:s");

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $user_pago = $usr[0]['nombre']." ".$usr[0]['ap'];

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
                    $url1 = 'pdf/pago_cajachica/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

        $table="comprobacion_pago";
        $this->_comprobacion->insertpagocomprobacion($table,$post,$fecha_pago,$user_pago,$urldb,$monto);

        $table="comprobacion_solicitud";
        $result = $this->_comprobacion->refreshssolicitudpagadacajachica($post,$table);
        if ($result) {
            return $this-> _redirect('/comprobacion/detailcontabilidad/id/'.$post['actual_id'].'/status/'.$post['status'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }

    }


    public function requestaddreembolsoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $id=$post['actual_id'];
        $wh="id";
        $table="comprobacion_solicitud";
        $sol_monto = $this->_season->GetSpecific($table,$wh,$id);
        $monto = $sol_monto[0]['monto'];

        date_default_timezone_set('America/Mexico_City');
        $fecha_pago = date("d-m-Y H:i:s");

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $user_pago = $usr[0]['nombre']." ".$usr[0]['ap'];

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
                    $url1 = 'pdf/pago_reembolso/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

        $table="comprobacion_reembolso";
        $this->_comprobacion->insertpagocomprobacion($table,$post,$fecha_pago,$user_pago,$urldb,$monto);

        $table="comprobacion_solicitud";
        $result = $this->_comprobacion->refreshssolicitudpagadacajachicados($post,$table);
        if ($result) {
            return $this-> _redirect('/comprobacion/detailcontabilidad/id/'.$post['actual_id'].'/status/'.$post['status'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }

    }




    public function requestaddcomprobacionreembolsoAction(){
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

        $id_residente = $post['residente'];
        $table="comprobacion_solicitud";
        $this->_comprobacion->refreshssolicitudcomprobada($post,$table);


        $act=$this->_ordencompra->Getcomprobacionauditada($id_residente);
        $table ="comprobaciones";
        foreach ($act as $key) {
            $this->_comprobacion->refreshsgenerarcomprobacionesaddsolicitud($table,$post,$id_residente);
        }

        $fecha_pago = date("d-m-Y H:i:s");
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $user_pago = $usr[0]['nombre']." ".$usr[0]['ap'];

        $table="comprobacion_solicitud";
        $result = $this->_comprobacion->insertreembolsocomprobacion($table,$post,$fecha_pago,$user_pago);
        if ($result) {
            return $this-> _redirect('/solicitud/comprobaciones/id/'.$id_residente.'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }

    }


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