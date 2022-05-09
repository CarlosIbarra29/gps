<?php
class ArchivosController extends Zend_Controller_Action{
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
        $this->_nomina = new Application_Model_GpsNominaModel;
 
        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }

    }//END INIT

    public function indexAction(){

    }//index

    public function excelproveedoresAction(){
        $table="proveedor";
        $this->view->proveedor = $this->_season->GetAll($table); 
    }

    public function excelgasolinaAction(){
        $estado = 1;
        $ver = $this->view->gasolina = $this->_gasolina->getprocesogasolina($estado);
        // var_dump($ver);exit;
    }

    public function excelpersonalAction(){
        $sitio = $this->_getParam('sitio'); $this->view->sitio=$sitio;
        $nombre = $this->_getParam('nombre'); $this->view->nombre=$nombre;
        $ap = $this->_getParam('ap'); $this->view->ap=$ap;
        $am = $this->_getParam('am'); $this->view->am=$am;
        $curp = $this->_getParam('curp'); $this->view->curp=$curp;
        $rfc = $this->_getParam('rfc'); $this->view->rfc=$rfc;
        $nss = $this->_getParam('nss'); $this->view->nss=$nss;
        $telefono = $this->_getParam('telefono'); $this->view->telefono=$telefono;
        $email = $this->_getParam('email'); $this->view->email=$email;
        $personal = $this->_getParam('personal'); $this->view->personales=$personal;
        $namesitio = $this->_getParam('namesitio'); $this->view->namesitio=$namesitio;
        $operativo = $this->_getParam('operativo'); $this->view->operativo=$operativo;
        $puesto = $this->_getParam('puesto'); $this->view->puesto=$puesto;

        if($sitio == 0){
            $this->view->personal = $this->_sitio->Getreportesitiocero();             
        }else{
            $this->view->personal = $this->_sitio->Getreportesitiodiferentecero($sitio);
            // var_dump($ver);exit;
        }

        // $table="personal_Campo";
        // $this->view->personal = $this->_user->nombrepersonalreporte(); 

    }

    public function excelpersonaldocAction(){
        $table="certificadomedico_personal";
        $this->view->certificado_medico = $this->_season->GetAll($table);
        $this->view->dctres = $this->_user->getpersonaldctres();
        $this->view->info_antidoping = $this->_user->getpersonalantidoping();
        

    }

    public function excelsitiosAction(){
        $table="sitios";
        $this->view->sitios = $this->_user->nombresitiosexcel();       
    }

    public function excelcomprobacionesAction(){
        $this->view->comprobaciones = $this->_comprobacion->getfacturasreporte();
    }

    public function excelavanceproyectosAction(){
        $tipo = $this->_getParam('tipo');
        $this->view->op_proyecto = $tipo;

        if($tipo == 1){
            $table="detalle_bts";
            $this->view->detalle_bts = $this->_sitio->avancebtsfechas($tipo); 
        } // BTS

        if($tipo == 5){
            $table="detalle_bts";
            $this->view->doc_torrenueva = $this->_torrenueva->getdocumentaciontorre(); 
            $this->view->factores = $this->_torrenueva->getfactoresdiseno();
            $this->view->bitacora = $this->_torrenueva->getbitacoracambios();
        }// TORRE NUEVA


    }

    public function excelstatusproyectosAction(){
        $tipo_ulr = $this->_getParam('tipo');
        $this->view->op_proyecto = $tipo_url;

        $tipo = 1; $status = 9; $this->view->bts_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 10; $this->view->bts_dos = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 11; $this->view->bts_tres = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 12; $this->view->bts_cuatro= $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 13; $this->view->bts_cinco = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 14; $this->view->bts_seis = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 15; $this->view->bts_siete = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 16; $this->view->bts_ocho = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 17; $this->view->bts_nuevo = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 18; $this->view->bts_diez = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 19; $this->view->bts_once = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 20; $this->view->bts_doce = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 21; $this->view->bts_trece = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 22; $this->view->bts_catorece = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 23; $this->view->bts_quince = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 1; $status = 24; $this->view->bts_diesiseis = $this->_archivo->getbtsstatus($tipo,$status);
        // B T S

        $tipo = 2; $status = 31; $this->view->colo_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 2; $status = 32; $this->view->colo_dos = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 2; $status = 33; $this->view->colo_tres = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 2; $status = 34; $this->view->colo_cuatro= $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 2; $status = 35; $this->view->colo_cinco = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 2; $status = 36; $this->view->colo_seis = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 2; $status = 37; $this->view->colo_siete = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 2; $status = 38; $this->view->colo_ocho = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 2; $status = 39; $this->view->colo_nuevo = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 2; $status = 40; $this->view->colo_diez = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 2; $status = 41; $this->view->colo_once = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 2; $status = 42; $this->view->colo_doce = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 2; $status = 43; $this->view->colo_trece = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 2; $status = 44; $this->view->colo_catorece = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 2; $status = 45; $this->view->colo_quince = $this->_archivo->getbtsstatus($tipo,$status);
        // C O L O C A C I O N


        $tipo = 3; $status = 1; $this->view->refo_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 64; $this->view->refo_dos = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 2; $this->view->refo_tres = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 3; $this->view->refo_cuatro= $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 4; $this->view->refo_cinco = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 6; $this->view->refo_seis = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 7; $this->view->refo_siete = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 57; $this->view->refo_ocho = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 8; $this->view->refo_nuevo = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 48; $this->view->refo_diez = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 65; $this->view->refo_once = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 66; $this->view->refo_doce = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 5; $this->view->refo_trece = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 71; $this->view->refo_catorece = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 68; $this->view->refo_quince = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 3; $status = 69; $this->view->refo_diesiseis = $this->_archivo->getbtsstatus($tipo,$status);
        // R E F O R Z A M I E N T O

        $tipo = 4; $status = 58; $this->view->cambio_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 4; $status = 26; $this->view->cambio_dos = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 4; $status = 27; $this->view->cambio_tres = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 4; $status = 28; $this->view->cambio_cuatro= $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 4; $status = 29; $this->view->cambio_cinco = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 4; $status = 78; $this->view->cambio_seis = $this->_archivo->getbtsstatus($tipo,$status);
        // C A M B I O  D E  T O R R E

        $tipo = 5; $status = 76; $this->view->nueva_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 5; $status = 50; $this->view->nueva_dos = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 5; $status = 56; $this->view->nueva_tres = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 5; $status = 51; $this->view->nueva_cuatro= $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 5; $status = 59; $this->view->nueva_cinco = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 5; $status = 52; $this->view->nueva_seis = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 5; $status = 72; $this->view->nueva_siete = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 5; $status = 53; $this->view->nueva_ocho = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 5; $status = 54; $this->view->nueva_nuevo = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 5; $status = 55; $this->view->nueva_diez = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 5; $status = 73; $this->view->nueva_once = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 5; $status = 74; $this->view->nueva_doce = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 5; $status = 75; $this->view->nueva_trece = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 5; $status = 49; $this->view->nueva_catorece = $this->_archivo->getbtsstatus($tipo,$status);
        // T O R R E   N U E V A

        $tipo = 6; $status = 60; $this->view->mapeo_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 6; $status = 61; $this->view->mapeo_dos = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 6; $status = 62; $this->view->mapeo_tres = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 6; $status = 63; $this->view->mapeo_cuatro= $this->_archivo->getbtsstatus($tipo,$status);
        //  M A P E O  D E  T O R R E

        $tipo = 8; $status = 81; $this->view->torque_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 8; $status = 82; $this->view->torque_dos = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 8; $status = 83; $this->view->torque_tres = $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 8; $status = 84; $this->view->torque_cuatro= $this->_archivo->getbtsstatus($tipo,$status);
        $tipo = 8; $status = 85; $this->view->torque_cinco = $this->_archivo->getbtsstatus($tipo,$status);
        // T O R Q U E  Y  V E R T I C A L I D A D 

        $this->view->comentarios =$this->_archivo->getcomentarios();

        $this->view->issue= $this->_archivo->getissue($tipo_ulr);

    }

    public function reportesAction(){
        $table="sitios";
        $this->view->sitios = $this->_sitio->GetAllSitio($table);

        $table="proveedor";
        $this->view->proveedor = $this->_season->GetAll($table); 

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->rol_user=$usr[0]['fkroles'];

        $table ="tipo_proyecto";
        $this->view->tipo_proyecto = $this->_season->GetAll($table);
    }

    public function excelsolicitudescompraAction(){
        $this->view->reporte = $this->_ordencompra->getallsolicitudesreporte();
        $opcion = "Oficina";
        $this->view->oficina = $this->_ordencompra->getallsolicitudesreporteoficina($opcion);
        $opcion = "Stock Almacen";
        $this->view->almacen = $this->_ordencompra->getallsolicitudesreporteoficina($opcion);
    }

    public function excelsolicitudescompracoordAction(){
        $id=$this->_session->id;
        $this->view->reporte = $this->_ordencompra->getallsolicitudesreportecoordinador($id);
        $opcion = "Oficina";
        $this->view->oficina = $this->_ordencompra->getallsolicitudesreporteoficina($opcion);
        $opcion = "Stock Almacen";
        $this->view->almacen = $this->_ordencompra->getallsolicitudesreporteoficina($opcion);
    }

    public function excelcomprobacionAction(){
        
    }

    public function excelenviosAction(){
        $this->view->envios = $this->_envio->getinfoenvio();
    }

    public function excelmaterialesAction(){
        $this->view->material = $this->_material->getmaterialesreporte();
    }

    public function facturasxmlAction(){
        $this->view->facturas = $this->_comprobacion->getfacturasasignada();
        $id=0; $wh="status_factura"; $table="factura_efecticard";
        $this->view->facturas_dos = $this->_season->GetSpecific($table,$wh,$id);


        $this->view->oficina = $this->_comprobacion->getfacturasasignadaoficina();
        $this->view->oficina_dos = $this->_comprobacion->getfacturasasignadaoficinados();
    }

    public function excelordencompraespAction(){

        $op=$this->_getParam('op');
        $this->view->op_select=$op;

        if($op == 1){
            
            $sitio = $this->_getParam('sitio');
            $this->view->sitio = $sitio;
            
            $this->view->sitioexc = $this->_ordencompra->getsolicitudesSitioAll($sitio);

        }

        if($op == 2){
            
            $proveedor = $this->_getParam('proveedor');
            $this->view->proveedor = $proveedor;$sitio;
            
            $this->view->proveedorexc = $this->_ordencompra->getsolicitudesPrvAll($proveedor);

        }

        if($op == 3){
            
            $usuario = $this->_getParam('usuario');
            $this->view->usuario = $usuario;
            
            $this->view->usuarioexc = $this->_ordencompra->getsolicitudesUsrAll($usuario);

        }

    }

    public function excelnominasAction(){

        $this->view->nominas_pagadas = $this->_nomina->getnominapagadaexcel1(); 

    }

}