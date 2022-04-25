<?php
class PanelController extends Zend_Controller_Action{
 
	private $_season;
    private $_session;
    private $_user;
    private $_epp;
    
    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_project = new Application_Model_GpsProyectoModel;
        $this->_servicios = new Application_Model_GpsServicioModel;
        $this->_ordencompra = new Application_Model_GpsSolicitudOrdenModel;
        $this->_torrenueva = new Application_Model_GpsTorrenuevaModel;
        $this->_comprobacion = new Application_Model_GpsComprobacionModel;
        $this->_epp = new Application_Model_GpsEppModel;
        $this->_gasolina = new Application_Model_GpsGasolinaModel;
        $this->_archivo = new Application_Model_GpsArchivosModel;
        $this->_envio = new Application_Model_GpsEnvioModel;

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
        // if($fk!=1){
        //     $this->redirect('/home/perfilusuario');
        // }
    }//END INIT

    // ----------------------   INDEX  --------------------------//

     public function indexAction(){
        $op=$this->_getParam('op');
        $this->view->op_modulo = $op;


        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }
        
        $table = "sitios";
        $ver = $this->view->coordenadas = $this->_sitio->Gettlatitudemaps(); 

        $id=$this->_session->id; $wh="id"; $table="usuario";
        $usr= $this->view->info = $this->_season->GetSpecific($table,$wh,$id);
        foreach ($usr as $key) {
           $fk=$key['fkroles'];
        }

        $table = "sitios";
        $servicios = $this->view->sitios = $this->_sitio->Getordernombresitios();

        $year=$this->_getParam('year');
        $this->view->year_op = $year;
        $month = "1";
        $enero = $this->view->enero=$this->_ordencompra->getinfosolicitudesindex($year,$month);
        $this->view->count_enero=count($enero);
        $month = "2";
        $febrero= $this->view->febrero=$this->_ordencompra->getinfosolicitudesindex($year,$month);
        $this->view->count_febrero=count($febrero);
        $month = "3";
        $marzo = $this->view->marzo=$this->_ordencompra->getinfosolicitudesindex($year,$month);
        $this->view->count_marzo=count($marzo);
        $month = "4";
        $abril=$this->view->abril=$this->_ordencompra->getinfosolicitudesindex($year,$month);
        $this->view->count_abril=count($abril);
        $month = "5";
        $mayo= $this->view->mayo=$this->_ordencompra->getinfosolicitudesindex($year,$month);
        $this->view->count_mayo=count($mayo);
        $month = "6";
        $junio = $this->view->junio=$this->_ordencompra->getinfosolicitudesindex($year,$month);
        $this->view->count_junio=count($junio);
        $month = "7";
        $julio = $this->view->julio=$this->_ordencompra->getinfosolicitudesindex($year,$month);
        $this->view->count_julio=count($julio);
        $month = "8";
        $agosto = $this->view->agosto=$this->_ordencompra->getinfosolicitudesindex($year,$month);
        $this->view->count_agosto=count($agosto);
        $month = "9";
        $septiembre = $this->view->septiembre=$this->_ordencompra->getinfosolicitudesindex($year,$month);
        $this->view->count_septiembre=count($septiembre);
        $month = "10";
        $octubre = $this->view->octubre=$this->_ordencompra->getinfosolicitudesindex($year,$month);
        $this->view->count_octubre=count($octubre);
        $month = "11";
        $noviembre = $this->view->noviembre=$this->_ordencompra->getinfosolicitudesindex($year,$month);
        $this->view->count_noviembre=count($noviembre);
        $month = "12";
        $diciembre = $this->view->diciembre=$this->_ordencompra->getinfosolicitudesindex($year,$month);
        $this->view->count_diciembre=count($diciembre);

        // G A S O L I N A 
        $month= 1;
        $gas_enero = $this->view->gas_enero=$this->_gasolina->getinfoindex($year,$month);
        $this->view->count_gasenero = count($gas_enero);
        $month= 2;
        $gas_febrero = $this->view->gas_febrero=$this->_gasolina->getinfoindex($year,$month);
        $this->view->count_gasfebrero = count($gas_febrero);
        $month= 3;
        $gas_marzo = $this->view->gas_marzo=$this->_gasolina->getinfoindex($year,$month);
        $this->view->count_gasmarzo = count($gas_marzo);
        $month= 4;
        $gas_abril = $this->view->gas_abril=$this->_gasolina->getinfoindex($year,$month);
        $this->view->count_gasabril = count($gas_abril);
        $month= 5;
        $gas_mayo = $this->view->gas_mayo=$this->_gasolina->getinfoindex($year,$month);
        $this->view->count_gasmayo = count($gas_mayo);
        $month= 6;
        $gas_junio = $this->view->gas_junio=$this->_gasolina->getinfoindex($year,$month);
        $this->view->count_gasjunio = count($gas_junio);
        $month= 7;
        $gas_julio = $this->view->gas_julio=$this->_gasolina->getinfoindex($year,$month);
        $this->view->count_gasjulio = count($gas_julio);
        $month= 8;
        $gas_agosto = $this->view->gas_agosto=$this->_gasolina->getinfoindex($year,$month);
        $this->view->count_gasagosto = count($gas_agosto);
        $month= 9;
        $gas_septiembre = $this->view->gas_septiembre=$this->_gasolina->getinfoindex($year,$month);
        $this->view->count_gasseptiembre = count($gas_septiembre);
        $month= 10;
        $gas_octubre = $this->view->gas_octubre=$this->_gasolina->getinfoindex($year,$month);
        $this->view->count_gasoctubre = count($gas_octubre);
        $month= 11;
        $gas_noviembre = $this->view->gas_noviembre=$this->_gasolina->getinfoindex($year,$month);
        $this->view->count_gasnoviembre = count($gas_noviembre);
        $month= 12;
        $gas_diciembre = $this->view->gas_diciembre=$this->_gasolina->getinfoindex($year,$month);
        $this->view->count_gasdiciembre = count($gas_diciembre);

        // C O M P R O B A C I O N E S     C A J A  C H I C A
        $month= 1;
        $cajachica_enero = $this->view->cajachica_enero=$this->_comprobacion->getmessolicitudpanel($year,$month);
        $this->view->count_cajachicaenero = count($cajachica_enero);
        $month= 2;
        $cajachica_febrero = $this->view->cajachica_febrero=$this->_comprobacion->getmessolicitudpanel($year,$month);
        $this->view->count_cajachicafebrero = count($cajachica_febrero);
        $month= 3;
        $cajachica_marzo = $this->view->cajachica_marzo=$this->_comprobacion->getmessolicitudpanel($year,$month);
        $this->view->count_cajachicamarzo = count($cajachica_marzo);
        $month= 4;
        $cajachica_abril = $this->view->cajachica_abril=$this->_comprobacion->getmessolicitudpanel($year,$month);
        $this->view->count_cajachicaabril = count($cajachica_abril);
        $month= 5;
        $cajachica_mayo = $this->view->cajachica_mayo=$this->_comprobacion->getmessolicitudpanel($year,$month);
        $this->view->count_cajachicamayo = count($cajachica_mayo);
        $month= 6;
        $cajachica_junio = $this->view->cajachica_junio=$this->_comprobacion->getmessolicitudpanel($year,$month);
        $this->view->count_cajachicajunio = count($cajachica_junio);
        $month= 7;
        $cajachica_julio = $this->view->cajachica_julio=$this->_comprobacion->getmessolicitudpanel($year,$month);
        $this->view->count_cajachicajulio = count($cajachica_julio);
        $month= 8;
        $cajachica_agosto = $this->view->cajachica_agosto=$this->_comprobacion->getmessolicitudpanel($year,$month);
        $this->view->count_cajachicaagosto = count($cajachica_agosto);
        $month= 9;
        $cajachica_septiembre = $this->view->cajachica_septiembre=$this->_comprobacion->getmessolicitudpanel($year,$month);
        $this->view->count_cajachicaseptiembre = count($cajachica_septiembre);
        $month= 10;
        $cajachica_octubre = $this->view->cajachica_octubre=$this->_comprobacion->getmessolicitudpanel($year,$month);
        $this->view->count_cajachicaoctubre = count($cajachica_octubre);
        $month= 11;
        $cajachica_noviembre = $this->view->cajachica_noviembre=$this->_comprobacion->getmessolicitudpanel($year,$month);
        $this->view->count_cajachica_noviembre = count($cajachica_noviembre);
        $month= 12;
        $cajachica_diciembre = $this->view->cajachicadiciembre=$this->_comprobacion->getmessolicitudpanel($year,$month);
        $this->view->count_cajachicadiciembre = count($cajachica_diciembre);

        // V E H I C U L O S  S  O L I C I T U D E S
        $month= 1;
        $vehiculo_enero = $this->view->vehiculo_enero = $this->_archivo->getvehculossolicitudes($year,$month);
        $this->view->count_vehiculoenero = count($vehiculo_enero);

        $month= 2;
        $vehiculo_febrero = $this->view->vehiculo_febrero = $this->_archivo->getvehculossolicitudes($year,$month);
        $this->view->count_vehiculofebrero = count($vehiculo_febrero);

        $month= 3;
        $vehiculo_marzo = $this->view->vehiculo_marzo = $this->_archivo->getvehculossolicitudes($year,$month);
        $this->view->count_vehiculomarzo = count($vehiculo_marzo);

        $month= 4;
        $vehiculo_abril = $this->view->vehiculo_abril = $this->_archivo->getvehculossolicitudes($year,$month);
        $this->view->count_vehiculoabril = count($vehiculo_abril);

        $month= 5;
        $vehiculo_mayo = $this->view->vehiculo_mayo = $this->_archivo->getvehculossolicitudes($year,$month);
        $this->view->count_vehiculomayo = count($vehiculo_mayo);

        $month= 6;
        $vehiculo_junio = $this->view->vehiculo_junio = $this->_archivo->getvehculossolicitudes($year,$month);
        $this->view->count_vehiculojunio = count($vehiculo_junio);

        $month= 7;
        $vehiculo_julio = $this->view->vehiculo_julio = $this->_archivo->getvehculossolicitudes($year,$month);
        $this->view->count_vehiculojulio = count($vehiculo_julio);

        $month= 8;
        $vehiculo_agosto = $this->view->vehiculo_agosto = $this->_archivo->getvehculossolicitudes($year,$month);
        $this->view->count_vehiculoagosto = count($vehiculo_agosto);

        $month= 9;
        $vehiculo_septiembre = $this->view->vehiculo_septiembre = $this->_archivo->getvehculossolicitudes($year,$month);
        $this->view->count_vehiculoseptiembre = count($vehiculo_septiembre);

        $month= 10;
        $vehiculo_octubre = $this->view->vehiculo_octubre = $this->_archivo->getvehculossolicitudes($year,$month);
        $this->view->count_vehiculooctubre = count($vehiculo_octubre);

        $month= 11;
        $vehiculo_noviembre = $this->view->vehiculo_noviembre = $this->_archivo->getvehculossolicitudes($year,$month);
        $this->view->count_vehiculonoviembre = count($vehiculo_noviembre);

        $month= 12;
        $vehiculo_diciembre = $this->view->vehiculo_diciembre = $this->_archivo->getvehculossolicitudes($year,$month);
        $this->view->count_vehiculodiciembre = count($vehiculo_diciembre);

        // N O M I N A   P A G O
        $month= 1;
        $nomina_enero = $this->view->nomina_enero = $this->_archivo->getnomiasolicitudes($year,$month);
        $this->view->count_nominaenero = count($nomina_enero);

        $month= 2;
        $nomina_febrero = $this->view->nomina_febrero = $this->_archivo->getnomiasolicitudes($year,$month);
        $this->view->count_nominafebrero = count($nomina_febrero);

        $month= 3;
        $nomina_marzo = $this->view->nomina_marzo = $this->_archivo->getnomiasolicitudes($year,$month);
        $this->view->count_nominamarzo = count($nomina_marzo);

        $month= 4;
        $nomina_abril = $this->view->nomina_abril = $this->_archivo->getnomiasolicitudes($year,$month);
        $this->view->count_nominaabril = count($nomina_abril);

        $month= 5;
        $nomina_mayo = $this->view->nomina_mayo = $this->_archivo->getnomiasolicitudes($year,$month);
        $this->view->count_nominamayo = count($nomina_mayo);

        $month= 6;
        $nomina_junio = $this->view->nomina_junio = $this->_archivo->getnomiasolicitudes($year,$month);
        $this->view->count_nominajunio = count($nomina_junio);

        $month= 7;
        $nomina_julio = $this->view->nomina_julio = $this->_archivo->getnomiasolicitudes($year,$month);
        $this->view->count_nominajulio = count($nomina_julio);

        $month= 8;
        $nomina_agosto = $this->view->nomina_agosto = $this->_archivo->getnomiasolicitudes($year,$month);
        $this->view->count_nominaagosto = count($nomina_agosto);

        $month= 9;
        $nomina_septiembre = $this->view->nomina_septiembre = $this->_archivo->getnomiasolicitudes($year,$month);
        $this->view->count_nominaseptiembre = count($nomina_septiembre);

        $month= 10;
        $nomina_octubre = $this->view->nomina_octubre = $this->_archivo->getnomiasolicitudes($year,$month);
        $this->view->count_nominaoctubre = count($nomina_octubre);

        $month= 11;
        $nomina_noviembre = $this->view->nomina_noviembre = $this->_archivo->getnomiasolicitudes($year,$month);
        $this->view->count_nominanoviembre = count($nomina_noviembre);

        $month= 12;
        $nomina_diciembre = $this->view->nomina_diciembre = $this->_archivo->getnomiasolicitudes($year,$month);
        $this->view->count_nominadiciembre = count($nomina_diciembre);


        // T A G  C O N S U M O S

        $month= 1;
        $tag_enero = $this->view->tag_enero = $this->_archivo->gettagconsumosm($year,$month);
        $this->view->count_tagenero = count($tag_enero);

        $month= 2;
        $tag_febrero = $this->view->tag_febrero = $this->_archivo->gettagconsumosm($year,$month);
        $this->view->count_tagfebrero = count($tag_febrero);

        $month= 3;
        $tag_marzo = $this->view->tag_marzo = $this->_archivo->gettagconsumosm($year,$month);
        $this->view->count_tagmarzo = count($tag_marzo);

        $month= 4;
        $tag_abril = $this->view->tag_abril = $this->_archivo->gettagconsumosm($year,$month);
        $this->view->count_tagabril = count($tag_abril);

        $month= 5;
        $tag_mayo = $this->view->tag_mayo = $this->_archivo->gettagconsumosm($year,$month);
        $this->view->count_tagmayo = count($tag_mayo);

        $month= 6;
        $tag_junio = $this->view->tag_junio = $this->_archivo->gettagconsumosm($year,$month);
        $this->view->count_tagjunio = count($tag_junio);

        $month= 7;
        $tag_julio = $this->view->tag_julio = $this->_archivo->gettagconsumosm($year,$month);
        $this->view->count_tagjulio = count($tag_julio);

        $month= 8;
        $tag_agosto = $this->view->tag_agosto = $this->_archivo->gettagconsumosm($year,$month);
        $this->view->count_tagagosto = count($tag_agosto);

        $month= 9;
        $tag_septiembre = $this->view->tag_septiembre = $this->_archivo->gettagconsumosm($year,$month);
        $this->view->count_tagseptiembre = count($tag_septiembre);

        $month= 10;
        $tag_octubre = $this->view->tag_octubre = $this->_archivo->gettagconsumosm($year,$month);
        $this->view->count_tagoctubre = count($tag_octubre);

        $month= 11;
        $tag_noviembre = $this->view->tag_noviembre = $this->_archivo->gettagconsumosm($year,$month);
        $this->view->count_tagnoviembre = count($tag_noviembre);

        $month= 12;
        $tag_diciembre = $this->view->tag_diciembre = $this->_archivo->gettagconsumosm($year,$month);
        $this->view->count_tagdiciembre = count($tag_diciembre);

        // E N D  T A G  C O N S U M O S


        // V I A T I C O S   G A S T O S 
        
        $month= 1;
        $viaticos_enero = $this->view->viaticos_enero = $this->_archivo->getviaticosm($year,$month);
        $this->view->count_viaticosenero = count($viaticos_enero);

        $month= 2;
        $viaticos_febrero = $this->view->viaticos_febrero = $this->_archivo->getviaticosm($year,$month);
        $this->view->count_viaticosfebrero = count($viaticos_febrero);

        $month= 3;
        $viaticos_marzo = $this->view->viaticos_marzo = $this->_archivo->getviaticosm($year,$month);
        $this->view->count_viaticosmarzo = count($viaticos_marzo);

        $month= 4;
        $viaticos_abril = $this->view->viaticos_abril = $this->_archivo->getviaticosm($year,$month);
        $this->view->count_viaticosabril = count($viaticos_abril);

        $month= 5;
        $viaticos_mayo = $this->view->viaticos_mayo = $this->_archivo->getviaticosm($year,$month);
        $this->view->count_viaticosmayo = count($viaticos_mayo);

        $month= 6;
        $viaticos_junio = $this->view->viaticos_junio = $this->_archivo->getviaticosm($year,$month);
        $this->view->count_viaticosjunio = count($viaticos_junio);

        $month= 7;
        $viaticos_julio = $this->view->viaticos_julio = $this->_archivo->getviaticosm($year,$month);
        $this->view->count_viaticosjulio = count($viaticos_julio);

        $month= 8;
        $viaticos_agosto = $this->view->viaticos_agosto = $this->_archivo->getviaticosm($year,$month);
        $this->view->count_viaticosagosto = count($viaticos_agosto);

        $month= 9;
        $viaticos_septiembre = $this->view->viaticos_septiembre = $this->_archivo->getviaticosm($year,$month);
        $this->view->count_viaticosseptiembre = count($viaticos_septiembre);

        $month= 10;
        $viaticos_octubre = $this->view->viaticos_octubre = $this->_archivo->getviaticosm($year,$month);
        $this->view->count_viaticosoctubre = count($viaticos_octubre);

        $month= 11;
        $viaticos_noviembre = $this->view->viaticos_noviembre = $this->_archivo->getviaticosm($year,$month);
        $this->view->count_viaticosnoviembre = count($viaticos_noviembre);

        $month= 12;
        $viaticos_diciembre = $this->view->viaticos_diciembre = $this->_archivo->getviaticosm($year,$month);
        $this->view->count_viaticosdiciembre = count($viaticos_diciembre);
        
        // E N D  V I A T I C O S   G A S T O S 


        $envios = $this->view->fabricacion = $this->_envio->getfabricacionindex();
        // STATUS PROYECTOS
        $tipo = 1;$status = 9; $bts_uno=$this->view->bts_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_unocount = count($bts_uno);
        $tipo = 1; $status = 10; $bts_dos=$this->view->bts_dos = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_doscount = count($bts_dos);
        $tipo = 1; $status = 11; $bts_tres=$this->view->bts_tres = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_trescount = count($bts_tres);
        $tipo = 1; $status = 12; $bts_cuatro=$this->view->bts_cuatro= $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_cuatrocount = count($bts_cuatro);
        $tipo = 1; $status = 13; $bts_cinco=$this->view->bts_cinco = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_cincocount = count($bts_cinco);
        $tipo = 1; $status = 14; $bts_seis=$this->view->bts_seis = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_seiscount = count($bts_seis);
        $tipo = 1; $status = 15; $bts_siete=$this->view->bts_siete = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_sietecount = count($bts_siete);
        $tipo = 1; $status = 16; $bts_ocho=$this->view->bts_ocho = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_ochocount = count($bts_ocho);
        $tipo = 1; $status = 17; $bts_nueve=$this->view->bts_nueve = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_nuevecount = count($bts_nueve);
        $tipo = 1; $status = 18; $bts_diez=$this->view->bts_diez = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_diezcount= count($bts_diez);
        $tipo = 1; $status = 19; $bts_once=$this->view->bts_once = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_oncecount= count($bts_once);
        $tipo = 1; $status = 20; $bts_doce=$this->view->bts_doce = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_docecount= count($bts_doce);
        $tipo = 1; $status = 21; $bts_trece=$this->view->bts_trece = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_trececount= count($bts_trece);
        $tipo=1; $status = 22; $bts_catorece=$this->view->bts_catorece = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_catorcecount= count($bts_catorece);
        $tipo = 1; $status = 23; $bts_quince=$this->view->bts_quince = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_quincecount= count($bts_quince);
        $tipo = 1;$status=24; $bts_diesiseis=$this->view->bts_diesiseis = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_diesiseiscount= count($bts_diesiseis);
        $tipo=1;$status=25;$bts_diesisiete=$this->view->bts_diesisiete = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_diesisietecount= count($bts_diesisiete);
        $tipo = 1;$status=77;$bts_diesiocho=$this->view->bts_diesiocho = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->bts_diesiochocount= count($bts_diesiocho);

        // C O L O C A C I O N
        $tipo = 2; $status = 31; $colo_uno=$this->view->colo_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_unocount= count($colo_uno);
        $tipo = 2; $status = 32; $colo_dos=$this->view->colo_dos = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_doscount= count($colo_dos);
        $tipo = 2; $status = 33; $colo_tres=$this->view->colo_tres = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_trescount= count($colo_tres);
        $tipo = 2; $status = 34; $colo_cuatro=$this->view->colo_cuatro= $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_cuatrocount= count($colo_cuatro);
        $tipo = 2; $status = 35; $colo_cinco=$this->view->colo_cinco = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_cincocount= count($colo_cinco);
        $tipo = 2; $status = 36; $colo_seis=$this->view->colo_seis = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_seiscount= count($colo_seis);
        $tipo = 2; $status = 37; $colo_siete=$this->view->colo_siete = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_sietecount= count($colo_siete);
        $tipo = 2; $status = 38; $colo_ocho=$this->view->colo_ocho = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_ochocount= count($colo_ocho);
        $tipo = 2; $status = 39; $colo_nueve=$this->view->colo_nueve = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_nuevecount= count($colo_nueve);
        $tipo = 2; $status = 40; $colo_diez=$this->view->colo_diez = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_diezcount= count($colo_diez);
        $tipo = 2; $status = 41; $colo_once=$this->view->colo_once = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_oncecount= count($colo_once);
        $tipo = 2; $status = 42; $colo_doce=$this->view->colo_doce = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_docecount= count($colo_doce);
        $tipo = 2; $status = 43; $colo_trece=$this->view->colo_trece = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_trececount= count($colo_trece);
        $tipo = 2; $status = 44; $colo_catorce=$this->view->colo_catorece = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_catorcecount= count($colo_catorce);
        $tipo = 2; $status = 45; $colo_quince=$this->view->colo_quince = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_quincecount= count($colo_quince);
        $tipo = 2;$status = 47; $colo_diesiseis=$this->view->colo_diesiseis = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_diesiseiscount= count($colo_diesiseis);
        $tipo =2;$status=88; $colo_diesisiete=$this->view->colo_diesisiete = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->colo_diesisietecount= count($colo_diesisiete);
        // C O L O C A C I O N

        // R E F O R Z A M I E N T O
        $tipo = 3; $status = 1; $refo_uno=$this->view->refo_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_unocount= count($refo_uno);
        $tipo = 3; $status = 64; $refo_dos=$this->view->refo_dos = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_doscount= count($refo_dos);
        $tipo = 3; $status = 2; $refo_tres=$this->view->refo_tres = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_trescount= count($refo_tres);
        $tipo = 3; $status = 3; $refo_cuatro=$this->view->refo_cuatro= $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_cuatrocount= count($refo_cuatro);
        $tipo = 3; $status = 4; $refo_cinco=$this->view->refo_cinco = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_cincocount= count($refo_cinco);
        $tipo = 3; $status = 6; $refo_seis=$this->view->refo_seis = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_seiscount= count($refo_seis);
        $tipo = 3; $status = 7; $refo_siete=$this->view->refo_siete = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_sietecount= count($refo_siete);
        $tipo = 3; $status = 57; $refo_ocho=$this->view->refo_ocho = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_ochocount= count($refo_ocho);
        $tipo = 3; $status = 8; $refo_nueve=$this->view->refo_nueve = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_nuevecount= count($refo_nueve);
        $tipo = 3; $status = 48; $refo_diez=$this->view->refo_diez = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_diezcount= count($refo_diez);
        $tipo = 3; $status = 65; $refo_once=$this->view->refo_once = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_oncecount= count($refo_once);
        $tipo = 3; $status = 66; $refo_doce=$this->view->refo_doce = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_docecount= count($refo_doce);
        $tipo = 3; $status = 5; $refo_trece=$this->view->refo_trece = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_trececount= count($refo_trece);
        $tipo = 3; $status = 71; $refo_catorece=$this->view->refo_catorece = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_catorececount= count($refo_catorece);
        $tipo = 3; $status = 68; $refo_quince=$this->view->refo_quince = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_quincecount= count($refo_quince);
        $tipo =3; $status =69; $refo_diesiseis=$this->view->refo_diesiseis = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_diesiseiscount= count($refo_diesiseis);
        $tipo=3; $status=70; $refo_diesisiete=$this->view->refo_diesisiete = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_diesisietecount= count($refo_diesisiete);
        $tipo=3; $status=71; $refo_diesisiocho=$this->view->refo_diesisiocho=$this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_diesisiochocount= count($refo_diesisiocho);
        $tipo=3; $status=80; $refo_diesinueve=$this->view->refo_diesinueve=$this->_archivo->getbtsstatus($tipo,$status);
        $this->view->refo_diesinuevecount= count($refo_diesinueve);
        // R E F O R Z A M I E N T O

        // C A M B I O  D E  T O R R E
        $tipo = 4; $status = 26; $cambio_uno=$this->view->cambio_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->cambio_unocount= count($cambio_uno);
        $tipo = 4; $status = 27; $cambio_dos=$this->view->cambio_dos = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->cambio_doscount= count($cambio_dos);
        $tipo = 4; $status = 28; $cambio_tres=$this->view->cambio_tres= $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->cambio_trescount= count($cambio_tres);
        $tipo = 4; $status = 29; $cambio_cuatro=$this->view->cambio_cuatro = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->cambio_cuatrocount= count($cambio_cuatro);
        $tipo = 4; $status = 30; $cambio_cinco=$this->view->cambio_cinco = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->cambio_cincocount= count($cambio_cinco);
        $tipo = 4; $status = 58; $cambio_seis=$this->view->cambio_seis = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->cambio_seiscount= count($cambio_seis);
        $tipo = 4; $status = 78; $cambio_siete=$this->view->cambio_siete = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->cambio_sietecount= count($cambio_siete);
        $tipo = 4; $status = 79; $cambio_ocho=$this->view->cambio_ocho = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->cambio_ochocount= count($cambio_ocho);
        // C A M B I O  D E  T O R R E


        // T O R R E   N U E V A
        $tipo = 5; $status = 76; $torre_uno=$this->view->torre_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_unocount= count($torre_uno);
        $tipo = 5; $status = 50; $torre_dos=$this->view->torre_dos = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_doscount= count($torre_dos);
        $tipo = 5; $status = 56; $torre_tres=$this->view->torre_tres= $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_trescount= count($torre_tres);
        $tipo = 5; $status = 51; $torre_cuatro=$this->view->torre_cuatro = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_cuatrocount= count($torre_cuatro);
        $tipo = 5; $status = 59; $torre_cinco=$this->view->torre_cinco = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_cincocount= count($torre_cinco);
        $tipo = 5; $status = 52; $torre_seis=$this->view->torre_seis = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_seiscount= count($torre_seis);
        $tipo = 5; $status = 72; $torre_siete=$this->view->torre_siete = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_sietecount= count($torre_siete);
        $tipo = 5; $status = 53; $torre_ocho=$this->view->torre_ocho = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_ochocount= count($torre_ocho);
        $tipo = 5; $status = 54; $torre_nueve=$this->view->torre_nueve = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_nuevecount= count($torre_nueve);
        $tipo = 5; $status = 55; $torre_diez=$this->view->torre_diez = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_diezcount= count($torre_diez);
        $tipo = 5; $status = 73; $torre_once=$this->view->torre_once = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_oncecount= count($torre_once);
        $tipo = 5; $status = 74; $torre_doce=$this->view->torre_doce = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_docecount= count($torre_doce);
        $tipo = 5; $status = 75; $torre_trece=$this->view->torre_trece = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_trececount= count($torre_trece);
        $tipo = 5; $status = 49; $torre_catorce=$this->view->torre_catorce = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_catorcecount= count($torre_catorce);
        $tipo = 5; $status = 89; $torre_quince=$this->view->torre_quince = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torre_quincecount= count($torre_quince);
        // T O R R E   N U E V A

        // M A P E O  D E  T O R R E
        $tipo = 6; $status = 60; $mapeo_uno=$this->view->mapeo_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->mapeo_unocount= count($mapeo_uno);
        $tipo = 6; $status = 61; $mapeo_dos=$this->view->mapeo_dos = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->mapeo_doscount= count($mapeo_dos);
        $tipo = 6; $status = 62; $mapeo_tres=$this->view->mapeo_tres= $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->mapeo_trescount= count($mapeo_tres);
        $tipo = 6; $status = 63; $mapeo_cuatro=$this->view->mapeo_cuatro = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->mapeo_cuatrocount= count($mapeo_cuatro);
        // M A P E O  D E  T O R R E

        // G A B I N E T E
        $tipo = 7; $status = 67; $gabinete_uno=$this->view->gabinete_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->gabinete_unocount= count($gabinete_uno);
        // G A B I N E T E


        // T O R Q U E  Y  V E R T I C A L I D A D
        $tipo = 8; $status = 81; $torque_uno=$this->view->torque_uno = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torque_unocount= count($torque_uno);
        $tipo = 8; $status = 82; $torque_dos=$this->view->torque_dos = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torque_doscount= count($torque_dos);
        $tipo = 8; $status = 83; $torque_tres=$this->view->torque_tres= $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torque_trescount= count($torque_tres);
        $tipo = 8; $status = 84; $torque_cuatro=$this->view->torque_cuatro = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torque_cuatrocount= count($torque_cuatro);
        $tipo = 8; $status = 85; $torque_cinco=$this->view->torque_cinco = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torque_cincocount= count($torque_cuatro);
        $tipo = 8; $status = 86; $torque_seis=$this->view->torque_seis = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torque_seiscount= count($torque_seis);
        $tipo = 8; $status = 87; $torque_siete=$this->view->torque_siete = $this->_archivo->getbtsstatus($tipo,$status);
        $this->view->torque_sietecount= count($torque_siete);
        // T O R Q U E  Y  V E R T I C A L I D A D


        // END STATUS PROYECTOS 

     }//END INDEX

    public function calendarioAction(){
        
    }


    public function asignaractividadAction(){

    }

    public function pruebaqrdosAction(){

    }

    public function directorioAction(){
        $table="puestos_personal";
        $this->view->puestos = $this->_season->GetAll($table);

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="personal_campo";
        $pagi_count=$this->view->usuarios = $this->_user->Getcountpersonalceropaguno();
        $count=count($pagi_count);
        if (isset($_GET['pagina'])){$pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 

        $no_of_records_per_page = 20;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $sql= $this->view->paginator= $this->_user->Getcountpersonaldirectorio($table,$offset,$no_of_records_per_page);   
    }

    public function loginAction(){
        $table="usuario";
        $this->view->admin = $this->_season->GetAll($table);
    }// END LOGIN

    // ----------------------   USUARIOS  --------------------------//
    public function usuariosAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="roles";
        $this->view->rol = $this->_season->GetAll($table);
        $table="usuario";
        $usuarios=$this->_season->GetAll($table);
        $count=count($usuarios);
        if (isset($_GET['pagina'])) {$pagina = $_GET['pagina'];} else {$pagina= $this->view->pagina = 1;} 

        $no_of_records_per_page = 15;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $table="usuario";
        $sql= $this->view->paginator= $this->_user->Getpaginationuser($table,$offset,$no_of_records_per_page);
    }//usuariosAction

    public function usuarioseditAction(){
    	if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="usuario";
            $wh="id";
            $this->view->usuarios = $this->_season->GetSpecific($table,$wh,$id);

            $table="roles";
            $this->view->rol = $this->_season->GetAll($table);
        }else {
            return $this-> _redirect('/');
        }
    }//END USUARIOS

    public function usuariodetailAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="usuario";
            $wh="id";
            $this->view->usuarios = $this->_season->GetSpecific($table,$wh,$id);
            $this->view->id_personal=$id;
        }else {
            return $this-> _redirect('/');
        }
    }//END USUARIOS

    public function userrolAction(){
        $table="roles";
        $this->view->roles = $this->_season->GetAll($table);      
    }

    public function roleseditAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="roles";
            $wh="id";
            $this->view->roles = $this->_season->GetSpecific($table,$wh,$id);
        }else {
            return $this-> _redirect('/');
        }   
    }

    public function errorusuarioAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        if($this->_hasParam('correo')){
            $user = $this->_getParam('correo');
            $nombre = strstr($user, '?', true); 
            if($nombre == false){
                $name = $this->_getParam('correo');
            }else{
                 $name = strstr($user, '?', true); 
            }

            $this->view->name_search=$name;
            $usuarios=$this->_user->correoerror($name);
            $count=count($usuarios); 
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->paginator= $this->_user->correoerrorcount($name,$offset,$no_of_records_per_page);
        }
    }

    public function errorpersonalAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        if($this->_hasParam('correo')){
            $user = $this->_getParam('correo');
            $nombre = strstr($user, '?', true); 
            if($nombre == false){
                $name = $this->_getParam('correo');
            }else{
                 $name = strstr($user, '?', true); 
            }

            $this->view->name_search=$name;
            $usuarios=$this->_user->correoerrorpersonal($name);
            $count=count($usuarios); 
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->paginator= $this->_user->correoerrorcountpersonal($name,$offset,$no_of_records_per_page);
        }
    }


    public function personalAction(){ 
        $table="puestos_personal";
        $this->view->puestos = $this->_season->GetAll($table);

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="personal_campo";
        $pagi_count=$this->view->usuarios = $this->_user->Getcountpersonalcero();
        $count=count($pagi_count);
        if(isset($_GET['pagina'])) {$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

        $no_of_records_per_page = 15;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $sql= $this->view->paginator=$this->_user->Getcountpersonal($table,$offset,$no_of_records_per_page);
    }

    public function listapersonalAction(){
        $table="personal_campo";
        $this->view->puestos = $this->_season->GetAll($table);
    }

    public function papelerapersonalAction(){
        $table="puestos_personal";
        $this->view->puestos = $this->_season->GetAll($table);

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="personal_campo";
        $pagi_count=$this->view->usuarios = $this->_user->Getcountpersonaldeletecount();
        $count=count($pagi_count);
        if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

        $no_of_records_per_page = 15;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $sql= $this->view->paginator= $this->_user->Getcountpersonaldelete($table,$offset,$no_of_records_per_page);
    }

    public function personaleditAction(){ 
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="personal_campo";
            $wh="id";
            $this->view->usuarios = $this->_season->GetSpecific($table,$wh,$id);
            $table="puestos_personal";
            $this->view->puestos = $this->_season->GetAll($table);

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $rol = $usr[0]['fkroles'];
            $this->view->rol_user = $rol;
        }else {
            return $this-> _redirect('/');
        }        
    }

    public function personaldetailAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="personal_campo";
            $wh="id";
            $this->view->personal = $this->_season->GetSpecific($table,$wh,$id);
            $this->view->personaldetail = $this->_user->Getinfodetailpersonal($id);
            $this->view->id_personal=$id;

            $table="epp_asignar";
            $wh="id_personal";
            $status=0;
            $this->view->eppasignado = $this->_epp->GetEppAsignado($table,$wh,$id,$status);

            $table="certificadomedico_personal";
            $wh="id_personal";
            $med=$this->view->medico = $this->_season->GetSpecific($table,$wh,$id);
            if(empty($med)){
                $option_med= "vacio";
                $this->view->validation_med=$option_med;
            }else{
                $option_med= "no vacio";
                $this->view->validation_med=$option_med;
            } 

            $table="antidoping_personal";
            $wh="id_personal";
            $ant=$this->view->antidoping = $this->_season->GetSpecific($table,$wh,$id);
            if(empty($ant)){
                $option= "vacio";
                $this->view->validation=$option;
            }else{
                $option= "no vacio";
                $this->view->validation=$option;
            } 

            $id = $this->_getParam('id');
            $table="info_antidoping";
            $wh="id_personal";
            $ver=$this->view->info_antidoping = $this->_season->GetSpecific($table,$wh,$id);

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            foreach ($usr as $key) {
               $fk=$key['fkroles'];
            }
            $this->view->rol_user=$fk;
        }else {
            return $this-> _redirect('/');
        }       
    }

    public function editardctresAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $table="antidoping_personal";
            $wh="id";
            $this->view->antidoping = $this->_season->GetSpecific($table,$wh,$id);

            $id = $this->_getParam('user');
            $table="personal_campo";
            $wh="id";
            $this->view->personal = $this->_season->GetSpecific($table,$wh,$id);
        }else {
            return $this-> _redirect('/');
        }  
    }

    public function editarantidopingAction(){ 
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="info_antidoping";
            $wh="id";
            $this->view->antidoping = $this->_season->GetSpecific($table,$wh,$id);

            $id = $this->_getParam('user');
            $table="personal_campo";
            $wh="id";
            $this->view->personal = $this->_season->GetSpecific($table,$wh,$id);
        }else {
            return $this-> _redirect('/');
        }  
    }

    public function editarcertificadomedicoAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="certificadomedico_personal";
            $wh="id";
            $this->view->certificado = $this->_season->GetSpecific($table,$wh,$id);

            $id = $this->_getParam('user');
            $table="personal_campo";
            $wh="id";
            $this->view->personal = $this->_season->GetSpecific($table,$wh,$id);
        }else {
            return $this-> _redirect('/');
        }  
    }

    public function informaciongeneralAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="personal_campo";
            $wh="id";
            $this->view->personal = $this->_user->Informaciongeneral($id);

            $table="documentos_personal";
            $wh="id_personal";
            $this->view->doc = $this->_season->GetSpecific($table,$wh,$id);

        }else {
            return $this-> _redirect('/');
        }  
    }


    public function searchpersonalAction(){
        $table="puestos_personal";
        $this->view->puestos = $this->_season->GetAll($table);

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        if($this->_hasParam('nombre')){
            $name = $this->_getParam('nombre');
            $nombre_pers= $this->_user->nombrepersonal($name);
            $option= 1;
            $this->view->name_per=$name; 
            $per = "vacio";
            $this->view->puesto=$per;
            $this->view->status_per= 0;

            $this->view->option=$option; 
            $count=count($nombre_pers);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;}   
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;
            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $ver = $this->view->paginator= $this->_user->nombrepersonalcount($name,$offset,$no_of_records_per_page);
            $option = 1;
            $this->view->condicion=$option;
        }

        if($this->_hasParam('puesto')){
            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;
            $puesto = $this->_getParam('puesto');
            $puesto_pers= $this->_user->puestopersonal($puesto);
            $this->view->puesto=$puesto;
            $name="vacio";
            $this->view->name_per=$name; 
            $option= 2;
            $this->view->option=$option;
            $count=count($puesto_pers);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;}

            $no_of_records_per_page = 19;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_user->puestopersonalcount($puesto,$offset,$no_of_records_per_page);
            $option = 2;
            $this->view->condicion=$option;
        }

        if($this->_hasParam('status')){
            $status = $this->_getParam('status');
            $status_pers= $this->_user->statuspersonal($status);
            $this->view->status_per=$status;
            $puesto="vacio";
            $this->view->puesto=$puesto;
            $name="vacio";
            $this->view->name_per=$name;

            $option= 3;
            $this->view->option=$option;
            $count=count($status_pers);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 19;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_user->statuspersonalcount($status,$offset,$no_of_records_per_page);
            $option = 3;
            $this->view->condicion=$option;
        }   
    }


   public function searchdirectorioAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        if($this->_hasParam('nombre')){
            $name = $this->_getParam('nombre');
            $nombre_pers= $this->_user->nombrepersonal($name);
            $option= 1;
            $this->view->name_per=$name; 
            $per = "vacio";
            $this->view->puesto=$per;
            $this->view->status_per= 0;

            $this->view->option=$option; 
            $count=count($nombre_pers);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;}   
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->paginator= $this->_user->nombrepersonalcount($name,$offset,$no_of_records_per_page);
            
            $condicion = 1;
            $this->view->condicion=$condicion;
        }

        if($this->_hasParam('puesto')){
            $puesto = $this->_getParam('puesto');
            $puesto_pers= $this->_user->puestopersonal($puesto);
            $this->view->puesto=$puesto;
            $name="vacio";
            $this->view->name_per=$name; 
            $option= 2;
            $this->view->option=$option;
            $count=count($puesto_pers);
            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;}   
            $no_of_records_per_page = 5;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->paginator= $this->_user->puestopersonalcount($puesto,$offset,$no_of_records_per_page);
            $condicion = 2;
            $this->view->condicion=$condicion;
        }

        if($this->_hasParam('status')){
            $status = $this->_getParam('status');
            $status_pers= $this->_user->statuspersonal($status);
            $this->view->status_per=$status;
            $puesto="vacio";
            $this->view->puesto=$puesto;
            $name="vacio";
            $this->view->name_per=$name;

            $option= 3;
            $this->view->option=$option;
            $count=count($status_pers);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->paginator= $this->_user->statuspersonalcount($status,$offset,$no_of_records_per_page);
        }   
    }

    public function searchusuariosAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        if($this->_hasParam('nombre')){
            $user = $this->_getParam('nombre');
            $nombre = strstr($user, '?', true); 
            if($nombre == false){
                $name = $this->_getParam('nombre');
            }else{
                 $name = strstr($user, '?', true); 
            }

            $this->view->name_search=$name;
            $usuarios=$this->_user->usernombre($name);
            $count=count($usuarios); 
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->paginator= $this->_user->usuariocount($name,$offset,$no_of_records_per_page);
        }
    }

    public function searchtipoproyectoAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        if($this->_hasParam('nombre')){
            $tipo_proy = $this->_getParam('nombre');
            $this->view->tipoproyecto_seach=$tipo_proy;
            $proyecto=$this->_panel->getproyecto($tipo_proy);
            $count=count($proyecto);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->paginator= $this->_panel->getproyectopaginator($tipo_proy,$offset,$no_of_records_per_page);
        }
    }


    public function searchproveedorAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina; 
        if($this->_hasParam('nombre')){
            $tipo_proy = $this->_getParam('nombre');
            $this->view->proveedor_seach=$tipo_proy;
            $proyecto=$this->_panel->getproveedor($tipo_proy);
            $count=count($proyecto);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->paginator= $this->_panel->getprovedorpaginator($tipo_proy,$offset,$no_of_records_per_page);
        }
    }

    public function searchestructuraAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina; 

        if($this->_hasParam('nombre')){
            $estructura_sitios = $this->_getParam('nombre');
            $this->view->estructura_seach=$estructura_sitios;
            $estructura=$this->_sitio->getEstructurasitio($estructura_sitios);
            $count=count($estructura);
            if (isset($_GET['pagina'])) {$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->paginator= $this->_sitio->getestructurapaginator($estructura_sitios,$offset,$no_of_records_per_page);
        }
    }

    public function searchsitiosAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina; 
        if($this->_hasParam('nombre')){
            $nombre = $this->_getParam('nombre');
            $this->view->nombre_seach=$nombre;
            $option=1;
            $this->view->option_sit=$option;
            $wh= "nombre";
            $sitios=$this->_panel->getsitio($wh,$nombre);
            $count=count($sitios);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $wh = "nombre";
            $sql= $this->view->paginator= $this->_panel->getsitiospaginator($wh,$nombre,$offset,$no_of_records_per_page);

            $table="estructura_sitio";
            $this->view->estructura = $this->_season->GetAll($table);

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            foreach ($usr as $key) {
               $fk=$key['fkroles'];
            }
            $this->view->rol_user=$fk;
        }


        if($this->_hasParam('cliente')){
            $cliente = $this->_getParam('cliente');
            $this->view->cliente_seach=$cliente;
            $option=2;
            $this->view->option_sit=$option;
            $wh= "id_cliente";
            $sitios=$this->_panel->getsitio($wh,$cliente);
            $count=count($sitios);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $wh = "id_cliente";
            $sql= $this->view->paginator= $this->_panel->getsitiospaginator($wh,$cliente,$offset,$no_of_records_per_page);
        }

        if($this->_hasParam('region')){
            $region = $this->_getParam('region');
            $this->view->region_seach=$region;
            $option=3;
            $this->view->option_sit=$option;
            $wh= "region";
            $sitios=$this->_panel->getsitio($wh,$region);
            $count=count($sitios);
            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $wh = "region";
            $sql= $this->view->paginator= $this->_panel->getsitiospaginator($wh,$region,$offset,$no_of_records_per_page);
        }

        if($this->_hasParam('ciudad')){
            $ciudad = $this->_getParam('ciudad');
            $this->view->ciudad_seach=$ciudad;
            $option=4;
            $this->view->option_sit=$option;
            $wh= "ciudad";
            $sitios=$this->_panel->getsitio($wh,$ciudad);
            $count=count($sitios);
            if(isset($_GET['pagina'])) {$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $wh = "ciudad";
            $sql= $this->view->paginator= $this->_panel->getsitiospaginator($wh,$ciudad,$offset,$no_of_records_per_page);
        }
    }

    public function certificadomedicoeditAction(){ 
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="certificadomedico_personal";
            $wh="id_personal";
            $ant=$this->view->certificado = $this->_season->GetSpecific($table,$wh,$id);
        }else {
            return $this-> _redirect('/');
        }  
    }

    public function sitiosingenieroAction(){
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        foreach ($usr as $key) {
           $fk=$key['fkroles'];
        }
        $this->view->rol_user=$fk;
        $table="tipo_proyecto";
        $this->view->proyecto = $this->_season->GetAll($table);
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        // $table="sitios";
        // $id=$this->_session->id;
        // $sitios = $this->_sitio->getinfoingproyecto($id); 

        $table="sitios";
        $sitios = $this->_season->GetAll($table); 
        $count=count($sitios);

        if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

        $no_of_records_per_page = 17;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;
        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $table="sitios";
        // $sql= $this->view->paginator= $this->_sitio->Getpaginationingproyecto($table,$offset,$no_of_records_per_page);
        $sql= $this->view->paginator= $this->_user->Getpagination($table,$offset,$no_of_records_per_page);
        $table="estructura_sitio";
        $this->view->estructura = $this->_season->GetAll($table);

        $table="tipo_proyecto";
        $this->view->material = $this->_season->GetAll($table);
    }

    public function proveedoresAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $table= "proveedor";
        $prov = $this->_season->GetAll($table);

        $count=count($prov);
        if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

        $no_of_records_per_page = 15;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $table="proveedor";
        $sql= $this->view->paginator= $this->_user->Getpaginationproveedor($table,$offset,$no_of_records_per_page);

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->rol=$usr[0]['fkroles'];
    }

    public function proveedoreditAction(){ 
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="proveedor";
            $wh="id";
            $this->view->proveedor = $this->_season->GetSpecific($table,$wh,$id);
        }else {
            return $this-> _redirect('/');
        }   
    }

    public function tipoproyectoAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="tipo_proyecto";
        $proyecto=$this->_season->GetAll($table); 
        $count=count($proyecto);
        if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

        $no_of_records_per_page = 15;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $table="tipo_proyecto";
        $sql= $this->view->paginator= $this->_user->Getpaginationtipoproyecto($table,$offset,$no_of_records_per_page);
    }

    public function tipoproyectoeditAction(){ 
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="tipo_proyecto";
            $wh="id";
            $this->view->proyecto = $this->_season->GetSpecific($table,$wh,$id);
        }else {
            return $this-> _redirect('/');
        } 
    }

    public function statusproyectoAction(){
        $table="tipo_proyecto";
        $this->view->tipo =$this->_season->GetAll($table); 
        $table="status_proyecto";
        $this->view->proyecto =$this->_season->GetAll($table); 
    }


    public function statustipoAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_proyecto = $id;
            $table="status_proyecto";
            $wh="tipo_proyecto";
            $this->view->proyecto = $this->_panel->gettipoproyectoorder($id);
        }else {
            return $this-> _redirect('/');
        } 
    }

    public function statustipoeditAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_proyecto = $id;
            $table="status_proyecto";
            $wh="id";
            $this->view->proyecto = $this->_season->GetSpecific($table,$wh,$id);

            $tipo = $this->_getParam('tipo');
            $this->view->tipo = $tipo;
        }else {
            return $this-> _redirect('/');
        }  
    }

    public function statustipoclienteAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_proyecto=$id;
            $table="status_cliente";
            $wh="tipo_proyecto";
            $this->view->proyecto = $this->_panel->gettipoclienteorder($id);
        }else {
            return $this-> _redirect('/');
        } 
    }

    public function statusproyectoeditAction(){
    }

    public function statusclienteAction(){
        $table="tipo_proyecto";
        $this->view->tipo =$this->_season->GetAll($table); 

        $table="status_cliente";
        $this->view->cliente =$this->_season->GetAll($table); 
    }

    public function puestosAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $table="puestos_personal";
        $sitios = $this->_season->GetAll($table); 
        $count=count($sitios);
        if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

        $no_of_records_per_page = 15;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;
        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $table="puestos_personal";
        $sql= $this->view->puesto= $this->_user->Getpagination($table,$offset,$no_of_records_per_page);
    }

    public function serviciosAction(){

    }

    public function serviciossolicitudesAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $table="servicios";
        $sitios = $this->_season->GetAll($table); 
        $count=count($sitios);
        if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

        $no_of_records_per_page = 17;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;
        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $table="servicios";
        $sql= $this->view->servicio= $this->_servicios->Getpaginationservicio($table,$offset,$no_of_records_per_page);   
        $table="roles";
        $this->view->user= $this->_season->GetAll($table); 
    }

    public function servicioscomprobacionesAction(){
        $table="roles";
        $this->view->roles = $this->_season->GetAll($table);
        $table="usuario";
        $ver= $this->view->usuario = $this->_season->GetAll($table);
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="servicios_comprobaciones";
        $solicitud = $this->_comprobacion->getservicioscomprobaciones();
        $count = count($solicitud);
        if(isset($_GET['pagina'])) {$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

        $no_of_records_per_page = 20;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $this->view->servicios= $this->_comprobacion->getservicioscomprobacionespaginator($offset,$no_of_records_per_page);
    }


    public function servicioeditAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="servicios";
            $wh="id";
            $this->view->servicios = $this->_season->GetSpecific($table,$wh,$id);
            $table="roles";
            $this->view->rol = $this->_season->GetAll($table);
        }else {
            return $this-> _redirect('/');
        }
    }

    public function servicioeditcomprobacionAction(){
        $id = $this->_getParam('id');
        $table="servicios_comprobaciones";
        $wh="id";
        $this->view->servicios = $this->_season->GetSpecific($table,$wh,$id);
        $table="roles";
        $this->view->rol = $this->_season->GetAll($table);
    }


    public function sitiosAction(){ 
        $table="tipo_proyecto";
        $this->view->proyecto = $this->_season->GetAll($table);
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $table="sitios";
        $sitios = $this->_season->GetAll($table); 
        $count=count($sitios);
        if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

        $no_of_records_per_page = 15;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;
        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $table="sitios";
        $sql= $this->view->paginator= $this->_user->Getpagination($table,$offset,$no_of_records_per_page);

        $table="estructura_sitio";
        $this->view->estructura = $this->_season->GetAll($table);

        $table="tipo_proyecto";
        $this->view->material = $this->_season->GetAll($table);

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        foreach ($usr as $key) {
           $fk=$key['fkroles'];
        }
        $this->view->rol_user=$fk;
    }


    public function pruebaAction(){
    }

    public function mapasitioAction(){
        $table = "sitios";
        $this->view->coordenadas = $this->_sitio->Gettlatitudemaps(); 
    }

    public function sitiosdetailAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_sitio=$id;
            $table="sitios";
            $wh="id";
            $ver=$this->view->sitiodetail = $this->_season->GetSpecific($table,$wh,$id);

            $latitude = $ver[0]['latitude'];
            $this->view->latitude = $latitude;
            $longitude= $ver[0]['longitude'];
            $this->view->longitude = $longitude;

            $estructura= $ver[0]['estructura'];
            $table="estructura_sitio";
            $wh="id";
            $dos=$this->view->estructura = $this->_season->GetSpecific($table,$wh,$estructura);
            $table= "estructura_sitio";
            $dos =$this->view->estructura_sitio = $this->_season->GetAll($table);

            $table= "tipo_proyecto";
            $dos =$this->view->tipo = $this->_season->GetAll($table);

            $table="sitios_tipoproyecto";
            $wh="id_sitio";
            $this->view->tipos = $this->_sitio->getproyectsitios($id);

            $table = "usuario";
            $wh ="fkroles";
            $estructura =  7;
            $this->view->coordinador = $this->_season->GetSpecific($table,$wh,$estructura);

            $table = "usuario";
            $wh ="fkroles";
            $estructura =  2;
            $this->view->ing = $this->_season->GetSpecific($table,$wh,$estructura);

            $id=30;
            $id_dos=31;
            $wh="puesto";
            $dos=$this->view->residentes = $this->_ordencompra->Getresidentes($id,$id_dos);

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            foreach ($usr as $key) {
               $fk=$key['fkroles'];
            }
            $ver =$this->view->rol_user=$fk;
            // var_dump($fk);exit;
        }else {
            return $this-> _redirect('/');
        } 
    }

    public function sitiosdetaileditAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->idurl = $id;

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto = $proyecto;

            $sitio = $this->_getParam('sitio');
            $this->view->sitio = $sitio;
            $table= "sitios_tipoproyecto";
            $wh = "id";
            $dos =$this->view->tipo = $this->_season->GetSpecific($table,$wh,$sitio);

            $table = "usuario";
            $wh ="fkroles";
            $estructura =  7;
            $this->view->coordinador = $this->_season->GetSpecific($table,$wh,$estructura);

            $table = "usuario";
            $wh ="fkroles";
            $estructura =  2;
            $this->view->ing = $this->_season->GetSpecific($table,$wh,$estructura);

            $id=30;
            $id_dos=31;
            $wh="puesto";
            $dos=$this->view->residentes = $this->_ordencompra->Getresidentes($id,$id_dos);
        }else {
            return $this-> _redirect('/');
        } 
    }

    public function asignardetallesviewAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_sitio=$id;

            $table="sitios";
            $wh="id";
            $ver=$this->_season->GetSpecific($table,$wh,$id);
            $estructura = $ver[0]['estructura'];
            $table="estructura_sitio";
            $wh="id";
            $dos=$this->view->estructura = $this->_season->GetSpecific($table,$wh,$estructura);

            $table="comentarios_sitios";
            $wh="id_sitio";
            $id=$this->_getParam('sitio');
            $this->view->comentarios = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_proyecto";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->status = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_cliente";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->statuscliente = $this->_season->GetSpecific($table,$wh,$id);

            $table="sitios";
            $wh="id";
            $id=$this->_getParam('id');
            $sitio_name= $this->view->sitio = $this->_season->GetSpecific($table,$wh,$id);
            
            $sitio=$this->_getParam('id');
            $proyecto=$this->_getParam('proyecto');
            $id=$this->_getParam('sitio');
            $im=$this->view->tipo_sitio = $this->_sitio->GettipoproyectoDetalles($id);

            $tipo = $this->_getParam('sitio');
            $this->view->idtipo=$tipo;
            $this->view->commit = $this->_sitio->getcomentariossitio($tipo);

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto_id = $proyecto;

            $table="personal_campo";
            $this->view->personal = $this->_panel->getpersonalasc();
            
            $nombre= $sitio_name[0]["nombre"];
            $this->view->nombre_sitio = $nombre;
            $this->view->personal_proyecto = $this->_user->Getpersonalcuadrilla($id,$proyecto,$sitio,$nombre);
            
            $table="detalle_btsdos";
            $wh="id_sitiotipo";
            $this->view->detallesdos_bts = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="detalle_bts";
            $wh="id_sitiotipo";
            $ver=$this->view->detalles_bts = $this->_season->GetSpecific($table,$wh,$tipo);
            if(empty($ver)){
                $dos="1";
                $this->view->id_detalle = $dos;
            }else{
                $dos="2";
                $this->view->id_detalle = $ver[0]['id'];
            }

            $table="semanauno_bts";
            $wh="idsitio_tipo";
            $tipo =$this->_getParam('sitio');
            $this->view->wkuno = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="semanados_bts";
            $this->view->wkdos = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="semanatres_bts";
            $this->view->wktres = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="semanacuatro_bts";
            $this->view->wkcuatro = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="detalle_btspdf";
            $wh="id_sitiotipo";
            $this->view->pdfdetail = $this->_season->GetSpecific($table,$wh,$tipo);
            
            $table="detalle_btspdfdos";
            $wh="id_sitiotipo";
            $this->view->pdfdetaildos = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="altan_file";
            $wh="id_sitiotipo";
            $this->view->altanfile = $this->_season->GetSpecific($table,$wh,$tipo);

            $id=$this->_getParam('proyecto');
            $table="tipo_proyecto";
            $wh="id";
            $this->view->nombreproyecto = $this->_season->GetSpecific($table,$wh,$id);

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            foreach ($usr as $key) {
               $fk=$key['fkroles'];
            }
            $this->view->rol_user=$fk;
        }else {
            return $this-> _redirect('/');
        } 
    }


    public function asignardetallesAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_sitio=$id;

            $table="sitios";
            $wh="id";
            $ver=$this->_season->GetSpecific($table,$wh,$id);
            $estructura = $ver[0]['estructura'];
            $table="estructura_sitio";
            $wh="id";
            $dos=$this->view->estructura = $this->_season->GetSpecific($table,$wh,$estructura);

            $table="comentarios_sitios";
            $wh="id_sitio";
            $id=$this->_getParam('sitio');
            $this->view->comentarios = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_proyecto";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->status = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_cliente";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->statuscliente = $this->_season->GetSpecific($table,$wh,$id);

            $table="sitios";
            $wh="id";
            $id=$this->_getParam('id');
            $sitio_name= $this->view->sitio = $this->_season->GetSpecific($table,$wh,$id);
            
            $sitio=$this->_getParam('id');
            $proyecto=$this->_getParam('proyecto');
            $id=$this->_getParam('sitio');
            $im=$this->view->tipo_sitio = $this->_sitio->GettipoproyectoDetalles($id);

            $tipo = $this->_getParam('sitio');
            $this->view->idtipo=$tipo;
            $this->view->commit = $this->_sitio->getcomentariossitio($tipo);

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto_id = $proyecto;

            $table="personal_campo";
            $this->view->personal = $this->_panel->getpersonalasc();
            
            $nombre= $sitio_name[0]["nombre"];
            $this->view->nombre_sitio = $nombre;
            $this->view->personal_proyecto = $this->_user->Getpersonalcuadrilla($id,$proyecto,$sitio,$nombre);
            
            $table="detalle_btsdos";
            $wh="id_sitiotipo";
            $this->view->detallesdos_bts = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="detalle_bts";
            $wh="id_sitiotipo";
            $ver=$this->view->detalles_bts = $this->_season->GetSpecific($table,$wh,$tipo);
            if(empty($ver)){
                $dos="1";
                $this->view->id_detalle = $dos;
            }else{
                $dos="2";
                $this->view->id_detalle = $ver[0]['id'];
            }

            $table="semanauno_bts";
            $wh="idsitio_tipo";
            $tipo =$this->_getParam('sitio');
            $this->view->wkuno = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="semanados_bts";
            $this->view->wkdos = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="semanatres_bts";
            $this->view->wktres = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="semanacuatro_bts";
            $this->view->wkcuatro = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="detalle_btspdf";
            $wh="id_sitiotipo";
            $this->view->pdfdetail = $this->_season->GetSpecific($table,$wh,$tipo);
            
            $table="detalle_btspdfdos";
            $wh="id_sitiotipo";
            $this->view->pdfdetaildos = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="altan_file";
            $wh="id_sitiotipo";
            $this->view->altanfile = $this->_season->GetSpecific($table,$wh,$tipo);

            $id=$this->_getParam('proyecto');
            $table="tipo_proyecto";
            $wh="id";
            $this->view->nombreproyecto = $this->_season->GetSpecific($table,$wh,$id);

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            foreach ($usr as $key) {
               $fk=$key['fkroles'];
            }
            $this->view->rol_user=$fk;
        }else {
            return $this-> _redirect('/');
        } 
    }

    public function detallescolocacionAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_sitio=$id;
            $table="comentarios_sitios";
            $wh="id_sitio";
            $id=$this->_getParam('sitio');
            $this->view->comentarios = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_proyecto";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->status = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_cliente";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $ver=$this->view->statuscliente = $this->_season->GetSpecific($table,$wh,$id);

            $table="sitios";
            $wh="id";
            $id=$this->_getParam('id');
            $sitio_name= $this->view->sitio = $this->_season->GetSpecific($table,$wh,$id);
            
            $sitio=$this->_getParam('id');
            $proyecto=$this->_getParam('proyecto');
            $id=$this->_getParam('sitio');
            $im=$this->view->tipo_sitio = $this->_sitio->GettipoproyectoDetalles($id);
            
            $tipo = $this->_getParam('sitio');
            $this->view->idtipo=$tipo;
            $this->view->commit = $this->_sitio->getcomentariossitio($tipo);

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto_id = $proyecto;

            $table="personal_campo";
            $this->view->personal = $this->_season->GetAll($table);

            $nombre= $sitio_name[0]["nombre"];
            $this->view->nombre_sitio = $nombre;
            $this->view->personal_proyecto = $this->_user->Getpersonalcuadrilla($id,$proyecto,$sitio,$nombre);

            $table="detalle_colocaciondos";
            $wh="id_sitiotipo";
            $this->view->detallesdos_bts = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="detalle_colocacion";
            $wh="id_sitiotipo";
            $ver=$this->view->detalles_colocacion = $this->_season->GetSpecific($table,$wh,$tipo);
            if(empty($ver)){
                $dos="1";
                $this->view->id_detalle = $dos;
            }else{
                $dos="2";
                $this->view->id_detalle = $ver[0]['id'];
            }

            $table="detalle_colocacionpdf";
            $wh="id_sitiotipo";
            $this->view->pdfdetail = $this->_season->GetSpecific($table,$wh,$tipo);


            $table="detalle_colocacionpdfdos";
            $wh="id_sitiotipo";
            $this->view->pdfdetaildos = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="semanauno_colocacion";
            $wh="idsitio_tipo";
            $tipo =$this->_getParam('sitio');
            $this->view->wkuno = $this->_season->GetSpecific($table,$wh,$tipo);

        }
    }

    public function detallesreforzamientoAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_sitio=$id;

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto=$proyecto;

            $sitio = $this->_getParam('sitio');
            $this->view->sitio_id=$sitio;   
            $torre = $this->view->torre = $this->_torrenueva->getexist($id,$proyecto,$sitio);
            
            $table="status_proyecto";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->status = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_cliente";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->statuscliente = $this->_season->GetSpecific($table,$wh,$id);
        
            $table="sitios";
            $wh="id";
            $id=$this->_getParam('id');
            $sitio_name= $this->view->sitio = $this->_season->GetSpecific($table,$wh,$id);
            
            $sitio=$this->_getParam('id');
            $proyecto=$this->_getParam('proyecto');
            $id=$this->_getParam('sitio');
            $im=$this->view->tipo_sitio = $this->_sitio->GettipoproyectoDetalles($id);
            $tipo = $this->_getParam('sitio');
            $this->view->idtipo=$tipo;
            $this->view->commit = $this->_sitio->getcomentariossitio($tipo);

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto_id = $proyecto;

            $table="personal_campo";
            $this->view->personal = $this->_panel->getpersonalasc();
            
            $nombre= $sitio_name[0]["nombre"];
            $this->view->nombre_sitio = $nombre;
            $this->view->personal_proyecto = $this->_user->Getpersonalcuadrilla($id,$proyecto,$sitio,$nombre);

            $id=$this->_getParam('proyecto');
            $table="tipo_proyecto";
            $wh="id";
            $this->view->nombreproyecto = $this->_season->GetSpecific($table,$wh,$id);

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            foreach ($usr as $key) {
               $fk=$key['fkroles'];
            }
            $this->view->rol_user=$fk;


            $id=$this->_getParam('sitio');
            $wh="id_sitiotipo";
            $table="doc_refozamiento";
            $this->view->docunoref = $this->_season->GetSpecific($table,$wh,$id);
        } 
    }

    public function detallescambiotorreAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_sitio=$id;

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto=$proyecto;

            $sitio = $this->_getParam('sitio');
            $this->view->sitio=$sitio;   
            $torre = $this->view->torre = $this->_torrenueva->getexist($id,$proyecto,$sitio);
            
            $table="status_proyecto";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->status = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_cliente";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->statuscliente = $this->_season->GetSpecific($table,$wh,$id);
        
            $table="sitios";
            $wh="id";
            $id=$this->_getParam('id');
            $sitio_name= $this->view->sitio = $this->_season->GetSpecific($table,$wh,$id);
            
            $sitio=$this->_getParam('id');
            $proyecto=$this->_getParam('proyecto');
            $id=$this->_getParam('sitio');
            $im=$this->view->tipo_sitio = $this->_sitio->GettipoproyectoDetalles($id);
            $tipo = $this->_getParam('sitio');
            $this->view->idtipo=$tipo;
            $this->view->commit = $this->_sitio->getcomentariossitio($tipo);

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto_id = $proyecto;

            $table="personal_campo";
            $this->view->personal = $this->_panel->getpersonalasc();
            
            $nombre= $sitio_name[0]["nombre"];
            $this->view->nombre_sitio = $nombre;
            $this->view->personal_proyecto = $this->_user->Getpersonalcuadrilla($id,$proyecto,$sitio,$nombre);

            $id=$this->_getParam('proyecto');
            $table="tipo_proyecto";
            $wh="id";
            $this->view->nombreproyecto = $this->_season->GetSpecific($table,$wh,$id);

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            foreach ($usr as $key) {
               $fk=$key['fkroles'];
            }
            $this->view->rol_user=$fk;

        } 
    }

    public function detallestorrenuevaAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_sitio=$id;

            $table="sitios";
            $wh="id";
            $ver=$this->_season->GetSpecific($table,$wh,$id);
            $estructura = $ver[0]['estructura'];
            $table="estructura_sitio";
            $wh="id";
            $dos=$this->view->estructura = $this->_season->GetSpecific($table,$wh,$estructura);
            
            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto=$proyecto;

            $sitio = $this->_getParam('sitio');
            $this->view->sitio_id=$sitio;   
            $ver = $this->view->torre = $this->_torrenueva->getexist($id,$proyecto,$sitio);
            $torre = $this->view->torre_doc = $this->_torrenueva->getexistinfodos($id,$proyecto,$sitio);

            $table="status_proyecto";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->status = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_cliente";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->statuscliente = $this->_season->GetSpecific($table,$wh,$id);

            $table="sitios";
            $wh="id";
            $id=$this->_getParam('id');
            $sitio_name= $this->view->sitio = $this->_season->GetSpecific($table,$wh,$id);
            
            $sitio=$this->_getParam('id');
            $proyecto=$this->_getParam('proyecto');
            $id=$this->_getParam('sitio');
            $im=$this->view->tipo_sitio = $this->_sitio->GettipoproyectoDetalles($id);
            $tipo = $this->_getParam('sitio');
            $this->view->idtipo=$tipo;
            $this->view->commit = $this->_sitio->getcomentariossitio($tipo);
            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto_id = $proyecto;

            $table="personal_campo";
            $ver=$this->view->personal = $this->_panel->getpersonalasc();
            $nombre= $sitio_name[0]["nombre"];
            $this->view->nombre_sitio = $nombre;
            $this->view->personal_proyecto = $this->_user->Getpersonalcuadrilla($id,$proyecto,$sitio,$nombre);

            $id=$this->_getParam('proyecto');
            $table="tipo_proyecto";
            $wh="id";
            $this->view->nombreproyecto = $this->_season->GetSpecific($table,$wh,$id);

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            foreach ($usr as $key) {
               $fk=$key['fkroles'];
            }
            $this->view->rol_user=$fk;
            $id = $this->_getParam('id');
            $proyecto=$this->_getParam('proyecto');
            $sitio=$this->_getParam('sitio');

            $table="torre_nuevacambios";
            $ver= $this->view->torrecambios = $this->_torrenueva->gettorre_nuevacambios($id,$proyecto,$sitio);


            $id= $this->_getParam('sitio');
            $wh="id_sitiotipo";
            $table="torrenueva_avances";
            $this->view->avances_torre = $this->_season->GetSpecific($table,$wh,$id);
            $id= $this->_getParam('sitio');
            $wh="id_sitiotipo";
            $table="torrenueva_comentarioavance";
            $this->view->comentario_avance = $this->_season->GetSpecific($table,$wh,$id);

        }   
    }

    public function ordencompraspendienteAction(){
        $id=$this->_session->id;
        $wh="id_usuario";
        $table="solicitudes_pendientes";
        $this->view->sitios = $this->_ordencompra->getpendientesolicitud($id);
    }

    public function ordencomprasAction(){
        $table = "sitios";
        $servicios = $this->view->sitios = $this->_sitio->Getordernombresitios();
        $nombre = array();
        foreach ($servicios as $key => $value) {
            $nombre[] = $value['nombre'];   
        }
        $separado_por_comas = implode(",", $nombre);
        $this->view->nombre_servicios = $nombre;
        $table = "proveedor";
        $this->view->proveedor = $this->_panel->Getordernombreproveedor();
        $table = "servicios";
        $this->view->servicio = $this->_servicios->Getordernombreservicio();
    }

    public function ordencompraspasodosAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->orden_id=$id;
            $table="cotizacion_solicitudordencompra";
            $wh="id_solicitud";
            $this->view->cotizacion = $this->_season->GetSpecific($table,$wh,$id);
            $table="comparativa_solicitudordencompra";
            $wh="id_solicitud";
            $this->view->comparativa = $this->_season->GetSpecific($table,$wh,$id);

            $table="solicitudes_pendientes";
            $wh="id";
            $prov=$this->view->informacion = $this->_season->GetSpecific($table,$wh,$id);

            $id_sitio = $prov[0]['sitio_id'];
            if($id_sitio == 0 || $id_sitio == 10000000){
                $tipo_proyecto = 0;
                $this->view->if_proyecto=$tipo_proyecto;
            }else{

                $tipo_proyecto = 1;
                $this->view->if_proyecto=$tipo_proyecto;

                $table="sitios_tipoproyecto";
                $wh="id_sitio";
                $this->view->proyectos =$this->_sitio->gettipoproyectosolicitud($id_sitio);
            }

            $id_proveedor = $prov[0]['proveedor_id'];
            $table="proveedor";
            $wh="id";
            $name= $this->view->name_prov = $this->_season->GetSpecific($table,$wh,$id_proveedor);


            $table = "sitios";
            $servicios = $this->view->sitios = $this->_sitio->Getordernombresitios();

            $table="proveedor";
            $this->view->proveedor = $this->_season->GetAll($table);
            $table="servicios";
            $this->view->servicio = $this->_season->GetAll($table);
        }        
    }

    public function successsolicitudordencomprasAction(){
    }

    public function comentariositioAction(){ 
        if($this->_hasParam('comentario')){
            $id = $this->_getParam('comentario');
            $table="detalle_comentarios";
            $wh="id";
            $this->view->comentario = $this->_season->GetSpecific($table,$wh,$id);

            $id = $this->_getParam('id');
            $this->view->id=$id;
            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto=$proyecto;
            $sitio = $this->_getParam('sitio');
            $this->view->sitio=$sitio;
        }
    }

    public function comentariocolocacionAction(){
        if($this->_hasParam('comentario')){
            $id = $this->_getParam('comentario');
            $table="detalle_comentarios";
            $wh="id";
            $this->view->comentario = $this->_season->GetSpecific($table,$wh,$id);

            $id = $this->_getParam('id');
            $this->view->id=$id;
            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto=$proyecto;
            $sitio = $this->_getParam('sitio');
            $this->view->sitio=$sitio;
        } 
    }

    public function semanaunoeditAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_sitio=$id;

            $table="status_proyecto";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->status = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_cliente";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->statuscliente = $this->_season->GetSpecific($table,$wh,$id);

            $table="sitios";
            $wh="id";
            $id=$this->_getParam('id');
            $sitio_name= $this->view->sitio = $this->_season->GetSpecific($table,$wh,$id);
            
            $sitio=$this->_getParam('id');
            $proyecto=$this->_getParam('proyecto');
            $id=$this->_getParam('sitio');
            $this->view->tipo_sitio = $this->_sitio->GettipoproyectoDetalles($id);

            $tipo = $this->_getParam('sitio');
            $this->view->idtipo=$tipo;

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto_id = $proyecto;

            $table="detalle_bts";
            $wh="id_sitiotipo";
            $this->view->detalles_bts = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="semanauno_bts";
            $wh="idsitio_tipo";
            $tipo =$this->_getParam('sitio');
            $this->view->wkuno = $this->_season->GetSpecific($table,$wh,$tipo);
            
        }else {
            return $this-> _redirect('/');
        } 
    }

    public function semanadoseditAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_sitio=$id;

            $table="status_proyecto";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->status = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_cliente";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->statuscliente = $this->_season->GetSpecific($table,$wh,$id);

            $table="sitios";
            $wh="id";
            $id=$this->_getParam('id');
            $sitio_name= $this->view->sitio = $this->_season->GetSpecific($table,$wh,$id);
            
            $sitio=$this->_getParam('id');
            $proyecto=$this->_getParam('proyecto');
            $id=$this->_getParam('sitio');
            $this->view->tipo_sitio = $this->_sitio->GettipoproyectoDetalles($id);

            $tipo = $this->_getParam('sitio');
            $this->view->idtipo=$tipo;

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto_id = $proyecto;

            $table="detalle_bts";
            $wh="id_sitiotipo";
            $this->view->detalles_bts = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="semanados_bts";
            $wh="idsitio_tipo";
            $tipo =$this->_getParam('sitio');
            $this->view->wkdos = $this->_season->GetSpecific($table,$wh,$tipo);
            
        }else {
            return $this-> _redirect('/');
        } 
    }

    public function semanatreseditAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_sitio=$id;

            $table="status_proyecto";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->status = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_cliente";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->statuscliente = $this->_season->GetSpecific($table,$wh,$id);

            $table="sitios";
            $wh="id";
            $id=$this->_getParam('id');
            $sitio_name= $this->view->sitio = $this->_season->GetSpecific($table,$wh,$id);
            
            $sitio=$this->_getParam('id');
            $proyecto=$this->_getParam('proyecto');
            $id=$this->_getParam('sitio');
            $this->view->tipo_sitio = $this->_sitio->GettipoproyectoDetalles($id);

            $tipo = $this->_getParam('sitio');
            $this->view->idtipo=$tipo;

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto_id = $proyecto;

            $table="detalle_bts";
            $wh="id_sitiotipo";
            $this->view->detalles_bts = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="semanatres_bts";
            $wh="idsitio_tipo";
            $tipo =$this->_getParam('sitio');
            $this->view->wktres = $this->_season->GetSpecific($table,$wh,$tipo);
            
        }else {
            return $this-> _redirect('/');
        } 
    }


    public function semanacuatroeditAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_sitio=$id;

            $table="status_proyecto";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->status = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_cliente";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->statuscliente = $this->_season->GetSpecific($table,$wh,$id);

            $table="sitios";
            $wh="id";
            $id=$this->_getParam('id');
            $sitio_name= $this->view->sitio = $this->_season->GetSpecific($table,$wh,$id);
            
            $sitio=$this->_getParam('id');
            $proyecto=$this->_getParam('proyecto');
            $id=$this->_getParam('sitio');
            $this->view->tipo_sitio = $this->_sitio->GettipoproyectoDetalles($id);

            $tipo = $this->_getParam('sitio');
            $this->view->idtipo=$tipo;

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto_id = $proyecto;

            $table="detalle_bts";
            $wh="id_sitiotipo";
            $this->view->detalles_bts = $this->_season->GetSpecific($table,$wh,$tipo);

            $table="semanacuatro_bts";
            $wh="idsitio_tipo";
            $tipo =$this->_getParam('sitio');
            $this->view->wkcuatro = $this->_season->GetSpecific($table,$wh,$tipo);
            
        }else {
            return $this-> _redirect('/');
        } 
    }

    public function editevidenciascolocacionAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_sitio=$id;

            $table="status_proyecto";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->status = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_cliente";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->statuscliente = $this->_season->GetSpecific($table,$wh,$id);

            $table="sitios";
            $wh="id";
            $id=$this->_getParam('id');
            $sitio_name= $this->view->sitio = $this->_season->GetSpecific($table,$wh,$id);
            
            $sitio=$this->_getParam('id');
            $proyecto=$this->_getParam('proyecto');
            $id=$this->_getParam('sitio');
            $this->view->tipo_sitio = $this->_sitio->GettipoproyectoDetalles($id);

            $tipo = $this->_getParam('sitio');
            $this->view->idtipo=$tipo;

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto_id = $proyecto;

            $table="semanauno_colocacion";
            $wh="idsitio_tipo";
            $tipo =$this->_getParam('sitio');
            $this->view->wkuno = $this->_season->GetSpecific($table,$wh,$tipo);
            
        }else {
            return $this-> _redirect('/');
        } 
    }


    public function sitioseditAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="sitios";
            $wh="id";
            $this->view->sitiosedit = $this->_season->GetSpecific($table,$wh,$id);

            $table="estructura_sitio";
            $this->view->estructura = $this->_season->GetAll($table);
        }else {
            return $this-> _redirect('/');
        } 
    }


    public function estructurasitiosAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $table="estructura_sitio";
        $sitios = $this->_season->GetAll($table); 
        $count=count($sitios);
        if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

        $no_of_records_per_page = 15;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;
        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $table="estructura_sitio";
        $sql= $this->view->paginator= $this->_user->Getpaginationestructura($table,$offset,$no_of_records_per_page);

        $table="estructura_sitio";
        $this->view->estructura = $this->_season->GetAll($table);
    }


    public function estructurasitioseditAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="estructura_sitio";
            $wh="id";
            $this->view->estructura = $this->_season->GetSpecific($table,$wh,$id);
        }else {
            return $this-> _redirect('/');
        } 
    }

    public function statussitioAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $dos=$this->view->estructura = $this->_sitio->GetspecificSitio($id);

            $table="status_proyecto";
            $this->view->status = $this->_season->GetAll($table);
            $tipo = array();
            foreach ($dos as $key => $value) {
                $tipo[] = $value['id_tipoproyecto'];
            }
            $this->view->tipo = $tipo;
        }else {
            return $this-> _redirect('/');
        } 
    }


    public function statuseditAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $tipo = $this->_getParam('tipo');
            $this->view->tipo=$tipo;
            $table="status_cliente";
            $wh="id";
            $this->view->estructura = $this->_season->GetSpecific($table,$wh,$id);

            $table="tipo_proyecto";
            $this->view->status = $this->_season->GetAll($table);

            $tipo = $this->_getParam('tipo');
            $this->view->tipo = $tipo;

        }else {
            return $this-> _redirect('/');
        } 
    }

    public function detallesproyectoAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_sitio=$id;  //imprimir id del sitio
            $table="comentarios_sitios";
            $wh="id_sitio";
            $id=$this->_getParam('sitio');
            $com=$this->view->comentarios = $this->_sitio->Getcomentariossitioid($id);

            $table="status_proyecto";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->status = $this->_season->GetSpecific($table,$wh,$id);

            $table="status_cliente";
            $wh="tipo_proyecto";
            $id=$this->_getParam('proyecto');
            $this->view->statuscliente = $this->_season->GetSpecific($table,$wh,$id);

            $table="sitios";
            $wh="id";
            $id=$this->_getParam('id');
            $this->view->sitio = $this->_season->GetSpecific($table,$wh,$id);
            
            $sitio=$this->_getParam('id');
            $proyecto=$this->_getParam('proyecto');
            $id=$this->_getParam('sitio');
            $this->view->tipo_sitio = $this->_sitio->GettipoproyectoDetalles($id);

            $tipo = $this->_getParam('sitio');
            $this->view->idtipo=$tipo; // imprimir el sitio del proyecto

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto_id = $proyecto; // imprimir el proyecto del sitio

            $id=$this->_getParam('proyecto');
            $table="tipo_proyecto";
            $wh="id";
            $this->view->nombreproyecto = $this->_season->GetSpecific($table,$wh,$id);
        }else {
            return $this-> _redirect('/');
        } 
    }    

    public function cotizacionesAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        if($this->_hasParam('id')){
            $id= $this->_getParam('id');
            $this->view->id = $id;
            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto = $proyecto;
            $sitio = $this->_getParam('sitio');
            $this->view->sitio = $sitio;
            
            $id=$this->_session->id;
            $this->view->id_user = $id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $nombre = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];
            $this->view->nombre_user = $nombre;

            $table="cotizaciones_sitios";
            $wh="sitio_id";
            $sitios = $this->_season->GetSpecific($table,$wh,$sitio); 
            $count=count($sitios);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;
            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="cotizaciones_sitios";
            $sql= $this->view->cotizaciones= $this->_sitio->Getpaginationcotizacionservicio($sitio,$table,$offset,$no_of_records_per_page); 
        }
    }

    public function documentocotizacionAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        if($this->_hasParam('id')){
            $id= $this->_getParam('id');
            $this->view->id = $id;
            $wh="id";
            $table="cotizaciones_sitios";
            $cotizacion=$this->view->cotizacion=$this->_season->GetSpecific($table,$wh,$id);

            $id=$this->_session->id;
            $this->view->id_user = $id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $nombre = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];
            $this->view->nombre_user = $nombre;

            $sitio= $this->_getParam('sitio');
            $this->view->sitio_id = $sitio;

            $table="cotizaciones_sitiospo";
            $wh="id_sitiopo";
            $sitios = $this->_season->GetSpecific($table,$wh,$sitio); 
            $count=count($sitios);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;
            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="cotizaciones_sitiospo";
            $id= $this->_getParam('id');
            $sql= $this->view->cotizaciones= $this->_sitio->Getpaginationcotizacionpo($sitio,$id,$table,$offset,$no_of_records_per_page); 
        }       
    }


    public function comentarioseditAction(){
        if($this->_hasParam('comentario')){
            $id = $this->_getParam('comentario');
            $table="comentarios_sitios";
            $wh="id";
            $this->view->comentarios = $this->_season->GetSpecific($table,$wh,$id);

            $proyecto = $this->_getParam('proyecto');
            $this->view->proyecto_id = $proyecto;
            $sitio = $this->_getParam('sitio');
            $this->view->sitio=$sitio;
            $id = $this->_getParam('id');
            $this->view->id=$id;
        }else {
            return $this-> _redirect('/');
        }    
    }
    // ----------------------   REQUEST	--------------------------//
    // --------------   REQUEST ADD USER--------------------//

    public function requestadduserAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
            $id=$post["mail"];
            $table="usuario";
            $wh="correo";
            $usuario= $this->_season->GetSpecific($table,$wh,$id);

            if($usuario != null){
                return $this-> _redirect('/panel/errorusuario/correo/'.$post["mail"].' ');
            }
        if($this->getRequest()->getPost()){
            $table="usuario";
            $result = $this->_user->insertUsr($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/usuarios');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD USER

    public function requestaddrolAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="roles";
            $result = $this->_user->inserrol($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/userrol');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD ROL

    public function requestaddpersonalcampoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
            $id=$post["mail"];
            $table="personal_campo";
            $wh="email_personal";
        if($this->getRequest()->getPost()){

            $fechainicial = $post["fingreso"];
            $timestamp = strtotime($fechainicial); 
            $fechafinal = date("d/m/Y", $timestamp );

            $table="personal_campo";
            $result = $this->_user->insertpersonal($post,$table,$fechafinal);
            if ($result) {
                return $this-> _redirect('/panel/personal');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD PERSONAL DE CAMPO

    public function requestaddpuestopersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="puestos_personal";
            $result = $this->_user->insertpuestopersonal($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/puestos');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD PERSONAL DE CAMPO

    public function requestaddfotopersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="personal_campo";
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
                    $url1 = 'img/foto_personal/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            $table="personal_campo";
            $result = $this->_user->insertimagenpersonal($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/personaldetail/id/'.$post["id_personal"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestadddocumentostorrenuevaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $id=$post["id_sitio"];
        $proyecto=$post["proyecto"];
        $sitio=$post["sitio"];
        $exist = $this->_torrenueva->getexist($id,$proyecto,$sitio);

        if(empty($exist)){
            $table = "torre_nuevafile";
            $id_torrenueva = $this->_torrenueva->inserttorrenuevafile($post,$table);
        }else{
            $id_torrenueva = $exist[0]['id'];
        }

            $table="torre_nuevafile";
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
                    $url1 = 'pdf/torrenueva/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            $table="torre_nuevafile";
            $result = $this->_torrenueva->refreshtorre($post,$table,$id_torrenueva,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/detallestorrenueva/id/'.$id.'/proyecto/'.$proyecto.'/sitio/'.$sitio.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
    }

    public function requestadddocumentosmemoriaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $id=$post["id_sitio"];
        $proyecto=$post["proyecto"];
        $sitio=$post["sitio"];
        $exist = $this->_torrenueva->getexist($id,$proyecto,$sitio);

        if(empty($exist)){
            $table = "torre_nuevafile";
            $id_torrenueva = $this->_torrenueva->inserttorrenuevafile($post,$table);
        }else{
            $id_torrenueva = $exist[0]['id'];
        }

            $table="torre_nuevafile";
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
                    $url1 = 'pdf/torrenueva/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }
            $table="torre_nuevafile";
            $result = $this->_torrenueva->refreshmemoria($post,$table,$id_torrenueva,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/detallestorrenueva/id/'.$id.'/proyecto/'.$proyecto.'/sitio/'.$sitio.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
    }

    public function requestadddocumentosstaadAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $id=$post["id_sitio"];
        $proyecto=$post["proyecto"];
        $sitio=$post["sitio"];
        $exist = $this->_torrenueva->getexist($id,$proyecto,$sitio);

        if(empty($exist)){
            $table = "torre_nuevafile";
            $id_torrenueva = $this->_torrenueva->inserttorrenuevafile($post,$table);
        }else{
            $id_torrenueva = $exist[0]['id'];
        }

            $table="torre_nuevafile";
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
                    $url1 = 'pdf/torrenueva/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            $table="torre_nuevafile";
            $result = $this->_torrenueva->refresstaad($post,$table,$id_torrenueva,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/detallestorrenueva/id/'.$id.'/proyecto/'.$proyecto.'/sitio/'.$sitio.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
    }


    public function requestaddcomentarioavancecAction(){
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


            $table="torrenueva_comentarioavance";
            $result = $this->_torrenueva->insertcomentarioavance($post,$table,$nombre_user,$hoy);
            if ($result) {
                return $this-> _redirect('/panel/detallestorrenueva/id/'.$post['id'].'/proyecto/'.$post['proyecto'].'/sitio/'.$post['sitio'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }        
    }

    public function requestaddporcentajetorrenuevaAction(){
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

            $id = $post['sitio'];
            $wh="id_sitiotipo";
            $table="torrenueva_avances";
            $usr = $this->_season->GetSpecific($table,$wh,$id);

            if(empty($usr)){
                $table="torrenueva_avances";
                $this->_torrenueva->insertavancetorrenueva($post,$table);
            }

            $id = $post['sitio'];
            $wh="id_sitiotipo";
            $table="torrenueva_avances";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id_sol = $usr[0]['id'];

            if($post['suministro'] == ""){
                $total_suministro = 0; $user_suministro = NULL; $fecha_suministro = NULL; $status_suministro=0;
            }else{
                $total_suministro = $post['suministro']; $user_suministro = $nombre_user;
                $fecha_suministro = $hoy;  $status_suministro = 1;
            }

            if($post['corte'] == ""){
                $total_corte = 0; $user_corte = NULL; $fecha_corte = NULL; $status_corte = 0;
            }else{
                $total_corte = $post['corte']; $user_corte = $nombre_user;
                $fecha_corte = $hoy;  $status_corte = 1;
            }

            if($post['soldadura'] == ""){
                $total_soldadura = 0; $user_soldadura = NULL; $fecha_soldadura = NULL; $status_soldadura = 0;
            }else{
                $total_soldadura = $post['soldadura']; $user_soldadura = $nombre_user; 
                $fecha_soldadura = $hoy; $status_soldadura = 1;
            }

            if($post['galvanizado'] == ""){
                $total_galvanizado =0; $user_galvanizado = NULL; $fecha_galvanizado =NULL; $status_galvanizado = 0;
            }else{
                $total_galvanizado =$post['galvanizado']; $user_galvanizado = $nombre_user; 
                $fecha_galvanizado =$fecha_soldadura;  $status_galvanizado = 1;
            }

            // var_dump($post);exit;

            $table="torrenueva_avances";
            $result = $this->_torrenueva->udpateavancetorre($post,$table,$total_suministro,$user_suministro,$fecha_suministro,$status_suministro,$total_corte,$user_corte,$fecha_corte,$status_corte,$total_soldadura,$user_soldadura,$fecha_soldadura,$status_soldadura,$total_galvanizado,$user_galvanizado,$fecha_galvanizado,$status_galvanizado,$hoy,$nombre_user,$id_sol);
            if ($result) {
                return $this-> _redirect('/panel/detallestorrenueva/id/'.$post['id'].'/proyecto/'.$post['proyecto'].'/sitio/'.$post['sitio'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
    }


    public function requestaddinfotorrenuevaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $id=$post["id_sitio"];
        $proyecto=$post["proyecto"];
        $sitio=$post["sitio"];
        $exist = $this->_torrenueva->getexistinfodos($id,$proyecto,$sitio);
        
        if(empty($exist)){
            $table = "detalle_torrenueva";
            $this->_torrenueva->insertdocdostorrenueva($post,$table);
        }else{
        }

        $doc = $this->_torrenueva->getexistinfodos($id,$proyecto,$sitio);
        $id= $doc[0]['id'];

            $table="detalle_torrenueva";
            $result=$this->_torrenueva->refreshtorrenuevados($post,$table,$id);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }   
    }


    public function requestadddescripcioncambiosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y");

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $dato = $usr[0]['nombre']." ". $usr[0]['ap']." ".$usr[0]['am'];

            $table = "torre_nuevacambios";
            $result = $this->_torrenueva->insertdescripcioncambios($post,$table,$hoy, $dato);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }   
    }

    public function requestaddfiletorrenuevaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $id=$post["id_sitio"];
        $proyecto=$post["proyecto"];
        $sitio=$post["sitio"];
        $exist = $this->_torrenueva->getexist($id,$proyecto,$sitio);

        if(empty($exist)){
            $table = "torre_nuevafile";
            $id_torrenueva = $this->_torrenueva->inserttorrenuevafile($post,$table);
        }else{
            $id_torrenueva = $exist[0]['id'];
        }

            $table="torre_nuevafile";
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
                    $url1 = 'pdf/torrenueva/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $user = $usr[0]['nombre']." ".$usr[0]['ap']." ". $usr[0]['am'];

            if($post['archivo'] == 1){
                $nombre_file = "torre_file"; $torre_status = "torre_status";
                $fecha_user = "fecha_torre";  $user_file = "user_torre";
            }

            if($post['archivo'] == 2){
                $nombre_file = "simentacion_file"; $torre_status = "simentacion_status";
                $fecha_user = "fecha_simentacion";  $user_file = "user_simentacion";
            }

            if($post['archivo'] == 3){
                $nombre_file = "calculo_file"; $torre_status = "calculo_status";
                $fecha_user = "fecha_calculo";  $user_file = "user_calculo";
            }

            if($post['archivo'] == 4){
                $nombre_file = "staad_file"; $torre_status = "staad_status";
                $fecha_user = "fecha_saad";  $user_file = "user_staad";
            }

            if($post['archivo'] == 5){
                $nombre_file = "mecanica_file"; $torre_status = "mecanica_status";
                $fecha_user = "fecha_mecanica";  $user_file = "user_mecanica";
            }

            if($post['archivo'] == 6){
                $nombre_file = "acero_file"; $torre_status = "acero_status";
                $fecha_user = "fecha_acero";  $user_file = "user_acero";

            }

            if($post['archivo'] == 7){
                $nombre_file = "tornilleria_file"; $torre_status = "tornilleria_status";
                $fecha_user = "fecha_tornilleria";  $user_file = "user_tornilleria";
            }        

            if($post['archivo'] == 8){
                $nombre_file = "galvanizado_file"; $torre_status = "galvanizado_status";
                $fecha_user = "fecha_galvanizado";  $user_file = "user_galvanizado";
            }   

            if($post['archivo'] == 9){
                $nombre_file = "verticalidad_file"; $torre_status = "verticalidad_status";
                $fecha_user = "fecha_verticalidad";  $user_file = "user_verticalidad";
            } 

            if($post['archivo'] == 10){
                $nombre_file = "tension_file"; $torre_status = "tension_status";
                $fecha_user = "fecha_tension";  $user_file = "user_tension";
            } 

            if($post['archivo'] == 11){
                $nombre_file = "foto_file"; $torre_status = "foto_status";
                $fecha_user = "fecha_foto";  $user_file = "user_foto";
            } 

            if($post['archivo'] == 12){
                $nombre_file = "tor_file"; $torre_status = "tor_status";
                $fecha_user = "fecha_tor";  $user_file = "user_tor";
            }            

            if($post['archivo'] == 13){
                $nombre_file = "pesoacero_file"; $torre_status = "pesoacero_status";
                $fecha_user = "fecha_pesoacero";  $user_file = "user_pesoacero";
            }

            if($post['archivo'] == 14){
                $nombre_file = "torrepdf_file"; $torre_status = "torrepdf_status";
                $fecha_user = "fecha_torrepdf";  $user_file = "user_torrepdf";
            }

            if($post['archivo'] == 15){
                $nombre_file = "torredwg_file"; $torre_status = "torredwg_status";
                $fecha_user = "fecha_torredwg";  $user_file = "user_dwg";
            }

            if($post['archivo'] == 16){
                $nombre_file = "modelotorre_file"; $torre_status = "modelotorre_status";
                $fecha_user = "fecha_torrenueva";  $user_file = "user_torrenueva";
            }

            if($post['archivo'] == 17){
                $nombre_file = "colloapp"; $torre_status = "colloapp_status";
                $fecha_user = "fecha_colloapp";  $user_file = "user_colloapp";
            }

            // var_dump($nombre_file); var_dump($torre_status); var_dump($fecha_user); exit;   

            $table="torre_nuevafile";
            $result = $this->_torrenueva->refreshfiletorrenueva($post,$table,$id_torrenueva,$urldb,$nombre_file,$torre_status, $fecha_user, $user_file, $hoy, $user);
            if ($result) {
                return $this-> _redirect('/panel/detallestorrenueva/id/'.$post['id_sitio'].'/proyecto/'.$post['proyecto'].'/sitio/'.$post['sitio'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
    }

    public function requestadddocumentosmecanicaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $id=$post["id_sitio"];
        $proyecto=$post["proyecto"];
        $sitio=$post["sitio"];
        $exist = $this->_torrenueva->getexist($id,$proyecto,$sitio);

        if(empty($exist)){
            $table = "torre_nuevafile";
            $id_torrenueva = $this->_torrenueva->inserttorrenuevafile($post,$table);
        }else{
            $id_torrenueva = $exist[0]['id'];
        }

            $table="torre_nuevafile";
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
                    $url1 = 'pdf/torrenueva/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }
            $table="torre_nuevafile";
            $result = $this->_torrenueva->refresmecanica($post,$table,$id_torrenueva,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/detallestorrenueva/id/'.$id.'/proyecto/'.$proyecto.'/sitio/'.$sitio.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
    }

    public function requestadddocumentosimentacionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $id=$post["id_sitio"];
        $proyecto=$post["proyecto"];
        $sitio=$post["sitio"];
        $exist = $this->_torrenueva->getexist($id,$proyecto,$sitio);

        if(empty($exist)){
            $table = "torre_nuevafile";
            $id_torrenueva = $this->_torrenueva->inserttorrenuevafile($post,$table);
        }else{
            $id_torrenueva = $exist[0]['id'];
        }
            $table="torre_nuevafile";
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
                    $url1 = 'pdf/torrenueva/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }
            $table="torre_nuevafile";
            $result = $this->_torrenueva->refreshsimentacion($post,$table,$id_torrenueva,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/detallestorrenueva/id/'.$id.'/proyecto/'.$proyecto.'/sitio/'.$sitio.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
    }

    public function requestaddfotodocumentopersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $id=$post['user_id'];
        $wh="id_personal";
        $table="documentos_personal";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        if(empty($usr)){
            $result = $this->_user->insertdocumentosfotopersonal($post,$table);
        }
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y");
        if($this->getRequest()->getPost()){
            $table="documentos_personal";
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
                    $url1 = 'img/fotosdocumentos_personal/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            if($post['documento'] == 1){
                $documento ="ine_documento"; $fecha = "ine_fecha"; $status ="ine_status";
            }

            if($post['documento'] == 2){
                $documento ="nss_documento"; $fecha = "nss_fecha"; $status ="nss_status";   
            }

            if($post['documento'] == 3){
                $documento ="curp_documento"; $fecha = "curp_fecha"; $status ="curp_status";   
            }

            if($post['documento'] == 4){
                $documento ="rfc_documento"; $fecha = "rfc_fecha"; $status ="rfc_status";   
            }

            if($post['documento'] == 5){
                $documento ="domicilio_documento"; $fecha = "domicilio_fecha"; $status ="domicilio_status";   
            }

            if($post['documento'] == 6){
                $documento ="acta_documento"; $fecha = "acta_fecha"; $status ="acta_status"; 
            }

            $table="documentos_personal";
            $result = $this->_user->updatedocumentofotopersonal($post,$table,$urldb,$documento,$fecha,$status,$hoy);
            if ($result) {
                return $this-> _redirect('/panel/informaciongeneral/id/'.$post["user_id"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaddfotousuarioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="usuario";
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
                    $url1 = 'img/foto_usuario/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }
            $table="usuario";
            $result = $this->_user->insertimagenpersonal($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/usuariodetail/id/'.$post["id_personal"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }


    public function requestupdatefotopersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $urldb = $post['urlhidden'];
            if (!empty($_FILES['cover']['name'])){
                $bytes = $_FILES['cover']['size'];
                $res = $this->formatSizeUnits($bytes);
                if ($res==0) {
                    print '<script language="JavaScript">'; 
                    print 'alert("La imagen (PORTADA) supera el maximo de tamaño");'; 
                    print '</script>'; 
                } else {
                    unlink($post['urlhidden']);
                    $info1 = new SplFileInfo($_FILES['cover']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/foto_personal/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['cover']['tmp_name'],$urldb);
                    }
                } 

            $table="personal_campo";
            $result = $this->_user->refreshPersonalimagen($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/personaldetail/id/'.$post["id_personal"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestupdatefotousuarioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $urldb = $post['urlhidden'];
            if (!empty($_FILES['cover']['name'])){
                $bytes = $_FILES['cover']['size'];
                $res = $this->formatSizeUnits($bytes);
                if ($res==0) {
                    print '<script language="JavaScript">'; 
                    print 'alert("La imagen (PORTADA) supera el maximo de tamaño");'; 
                    print '</script>'; 
                } else {
                    unlink($post['urlhidden']);
                    $info1 = new SplFileInfo($_FILES['cover']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/foto_usuario/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['cover']['tmp_name'],$urldb);
                    }
                } 

            $table="usuario";
            $result = $this->_user->refreshPersonalimagen($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/usuariodetail/id/'.$post["id_personal"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }


    public function requestaddcertificadomedicopersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="personal_campo";
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
                    $url1 = 'img/certificado_medico_personal/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            } 

            $table="certificadomedico_personal";
            $result = $this->_user->insertcertificadopersonal($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/personaldetail/id/'.$post["user_id"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD CERTIFICADO MEDICO PERSONAL DE CAMPO


    public function requestaddinfoantidopingpersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="info_antidoping";
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
                    $url1 = 'img/info_antidoping/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            } 

            $table="info_antidoping";
            $result = $this->_user->insertinfoantidoping($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/personaldetail/id/'.$post["user_id"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD CERTIFICADO MEDICO PERSONAL DE CAMPO

    public function requestupdateinfoantidopingpersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){
            $table="info_antidoping";
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
                    $url1 = 'img/info_antidoping/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="info_antidoping";
            $result = $this->_user->updateinfoantidoping($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/personaldetail/id/'.$post["user_id"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD CERTIFICADO MEDICO PERSONAL DE CAMPO

    public function requestupdateinfocertificadomedicoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="certificadomedico_personal";
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
                    $url1 = 'img/certificado_medico_personal/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if
            $table="certificadomedico_personal";
            $result = $this->_user->updateinfocertificadomedico($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/personaldetail/id/'.$post["user_id"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD CERTIFICADO MEDICO PERSONAL DE CAMPO

    public function requestaddantidopingpersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $id=$post['user_id'];
        $wh="id_personal";
        $table="antidoping_personal";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        if(empty($usr)){
            $alt= "";
            $aux="";
            $ele="";
            $table="antidoping_personal";
             $this->_user->insertantidopingpersonalid($post,$table);
        }else{
            $alt= $usr[0]['tr_alturas'];
            $ele= $usr[0]['tr_electrico'];
            $aux= $usr[0]['tr_auxilio'];
        }

        if($this->getRequest()->getPost()){
            $table="personal_campo";
                $name = $_FILES['url']['name'];
                $bytes = $_FILES['url']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf NOM-009-STPS-2011 Trabajos en Alturas supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['url']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/antidoping_personal/';
                    $urldb_alturas = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb_alturas);
                }
        

            if($post['actividad'] == 1){
                $edit = "tr_alturas"; $status = "status_altura";
            }

            if($post['actividad'] == 2){
                $edit = "tr_electrico"; $status = "status_electrico";
            }

            if($post['actividad'] == 3){ $edit = "tr_auxilio"; $status = "status_auxilio";
            }

            $table="antidoping_personal";
            $result = $this->_user->insertantidopingpersonal($post,$table,$urldb_alturas,$edit,$status);
            if ($result) {
                return $this-> _redirect('/panel/personaldetail/id/'.$post["user_id"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD ANTIDOPING PERSONAL DE CAMPO


    public function requestaddcotizacionordendecompraAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="cotizacion_solicitudordencompra";
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
                    $url1 = 'pdf/solicitud_compra/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            } 

            $table="cotizacion_solicitudordencompra";
            $this->_ordencompra->insertdocumentocontizacion($post,$table,$urldb);

            $table="solicitud_ordencompra";
            $option="status_cotizacion"; 
            $id=$post["id_solicitud"];
            $result =$this->_ordencompra->refreshstatussolicitudcompra($table,$option,$id);
            if ($result) {
                return $this-> _redirect('/panel/ordencompraspasodos/id/'.$post["id_solicitud"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD COTIZACION SOLICITUD ORDEN DE COMPRA

    public function requestaddcomparativaordendecompraAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="comparativa_solicitudordencompra";
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
                    $url1 = 'pdf/solicitud_compra/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            } 

            $table="comparativa_solicitudordencompra";
            $this->_ordencompra->insertdocumentocomparativa($post,$table,$urldb);
            $table="solicitud_ordencompra";
            $option="status_comparativa"; 
            $id=$post["id_solicitud"];
            $result =$this->_ordencompra->refreshstatussolicitudcompra($table,$option,$id);
            if ($result) {
                return $this-> _redirect('/panel/ordencompraspasodos/id/'.$post["id_solicitud"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD COTIZACION SOLICITUD ORDEN DE COMPRA

    public function requestaddproveedorAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="proveedor";
            $result = $this->_season->insertProveedor($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/proveedores');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD PROVEEDOR

    public function requestaddcotizacionsitioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost(); 
        $id= $post['id'];
        $wh="id";
        $table="sitios";
        $sitio = $this->_season->GetSpecific($table,$wh,$id);
        $nombre = $sitio[0]['nombre'];
        mkdir("pdf/sitios/".$nombre."");
        mkdir("pdf/sitios/".$nombre."/cotizacion");
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
                    $url1 = 'pdf/sitios/'.$nombre.'/cotizacion/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            } 
            $table="cotizaciones_sitios";
            $result = $this->_sitio->insercotizacionsitio($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/cotizaciones/id/'.$post['id'].'/proyecto/'.$post['proyecto'].'/sitio/'.$post['sitio'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaddcotizacionsitiopoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $id= $post['id_sitio'];
        $wh="id";
        $table="sitios";
        $sitio = $this->_season->GetSpecific($table,$wh,$id);
        $nombre = $sitio[0]['nombre'];

        $cambio_status = $this->_sitio->UpdateCotizacionsitio($post); 
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
                    $url1 = 'pdf/sitios/'.$nombre.'/cotizacion/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            } 
        }
        // var_dump($post);exit;
        $table="cotizaciones_sitiospo";
        $result = $this->_sitio->insercotizacionsitiopo($post,$table,$urldb);
        if ($result) {
            return $this-> _redirect('/panel/documentocotizacion/id/'.$post['id_cotizacion'].'/sitio/'.$post['id_sitio'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }
    }

    public function requestaddtipoproyectoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="tipo_proyecto";
            $result = $this->_season->insertProyecto($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/tipoproyecto');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD TIPO DE PROYECTO

    public function requestaddestructurasitioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="estructura_sitio";
            $result = $this->_sitio->insertEstructurasitio($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/estructurasitios');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaddsitioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($post['latitude'] == "" ){
            $grados = $post['grados_lat'];
            $minutos = $post['min_lat'];
            $segundos = $post['seg_lat'];

            $dos_min = $minutos /60;
            $dos_seg = $segundos/3600;
            $latitude = $grados + $dos_min + $dos_seg;
            $conversion_lat = 1;
        }else{
            $latitude = $post['latitude'];
            $conversion_lat = 0;
        }

        if($post['longitude'] == ""){
            $grados = $post['grados_lon'];
            $minutos = $post['min_lon'];
            $segundos = $post['seg_lon'];

            $dos_min = $minutos /60;
            $dos_seg = $segundos/3600;
            $longitude = $grados + $dos_min + $dos_seg;
            $conversion_lon = 1;
        }else{
            $longitude = $post['longitude'];
            $conversion_lon = 0;
        }   

        if($this->getRequest()->getPost()){
            $table="sitios";
            $result = $this->_season->insertsitio($post,$latitude,$longitude,$conversion_lat,$conversion_lon,$table);
            // $id=$idproducto;
            // $wh="id";
            // $table="sitios_tipoproyecto";
            // $result=$this->_season->insertsitio_tipoproyecto($id,$wh,$table,$post); 

            // Modificar la vista de sitios para solo agregar info basica y despues asignarle un tipo de proyecto en la vista de detail.
            if ($result) {
                return $this-> _redirect('/panel/sitios');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD ROL

    public function requestaddproyectositioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost(); 
        $id= $post['tipo_proyecto'];
        $status_pro = $this->_sitio->Getproridadstatus($id);
        $name_pro = $status_pro[0]['id'];

        $status_cli = $this->_sitio->Getproridadcliente($id);
        $name_cli = $status_cli[0]['id'];

            $datos=$post["coordinador"];
            if($datos== null){
                $coordinador_id = 0;
                $coordinador_name = "";
            }else{
                $id=$post["coordinador"];
                $table="usuario";
                $wh="id";
                $coordinador = $this->_season->GetSpecific($table,$wh,$id);
                $coordinador_id = $coordinador[0]['id'];
                $coordinador_name =$coordinador[0]['nombre'];
            }

            $datos=$post["ingproyecto"];
            if($datos == null){
                $ingeniero_id = 0;
                $ingproyecto_name ="";
            }else{
                $id=$post["ingproyecto"];
                $table="usuario";
                $wh="id";
                $ingproyecto = $this->_season->GetSpecific($table,$wh,$id);
                $ingeniero_id = $ingproyecto[0]['id'];
                $ingproyecto_name =$ingproyecto[0]['nombre'];
            }

            $datos=$post["residente"];
            if($datos == null){
                $residente_id = 0;
                $residente_name ="";
            }else{
                $id=$post["residente"];
                $table="personal_campo";
                $wh="id";
                $residente = $this->_season->GetSpecific($table,$wh,$id);
                $residente_id = $residente[0]['id'];
                $residente_name =$residente[0]['nombre'];
            }

        if($this->getRequest()->getPost()){
            $table="sitios_tipoproyecto";
            $result=$this->_servicios->insertproyectoSitio($post,$table);
            $this->_servicios->refreshinsertsitioupdate($post,$table,$name_pro,$name_cli,$coordinador_name, $ingproyecto_name, $residente_name, $coordinador_id, $ingeniero_id, $residente_id,$result);
            
                $table="detalle_bts";
                $id=$post['sitio'];
                $wh="id_sitiotipo";
                $datos = $this->_season->GetSpecific($table,$wh,$id);
                if (empty($datos)){
                    $table="detalle_bts";
                    $result1= $this->_project->insertdetallebts($result,$table);
                }else{
                }

            if ($result) {
                return $this-> _redirect('/panel/sitiosdetail/id/'.$post['sitio'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaddserviciocomprobacionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($post['autorizacion'] == 0){
            $name_auto = "Sin autorizacion";
        }else{
            $id= $post['autorizacion'];
            $wh="id";
            $table="roles";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $name_auto = $usr[0]['nombre'];
        }

        if($post['status_excepcion'] == 1){ 
            $autorizacion = 0;
        } else{
            $autorizacion = $post['autorizacion'];
        }

        if($this->getRequest()->getPost()){
            $table="servicios_comprobaciones";
            $result = $this->_comprobacion->insertserviciocomprobacion($post,$table,$autorizacion,$name_auto);
            if ($result) {
                return $this-> _redirect('/panel/servicioscomprobaciones');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestchangestatusgpsAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="sitios_tipoproyecto";
            $result = $this->_sitio->UpdateStatusgps($post,$table);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL

    public function requestchangestatuspersonaldeleteAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="personal_campo";
            $status=1;
            $result = $this->_user->UpdateStatusdeletepersonal($post,$table,$status);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL  

    public function requestchangestatuspersonalrestaurarAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="personal_campo";
            $status = 0;
            $result = $this->_user->UpdateStatusdeletepersonal($post,$table,$status);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL   

    public function requestchangestatusclienteAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="sitios_tipoproyecto";
            $result = $this->_sitio->UpdateStatuscliente($post,$table);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD STATUS CLIENTE

    public function requestchangeisuesitioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="sitios_tipoproyecto";
            $this->_sitio->UpdateStatusgps($post,$table);
            $this->_sitio->UpdateStatuscliente($post,$table);
            $result = $this->_sitio->UpdateIsuecliente($post,$table);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ISSUE

    public function requestchangeaddcuadrillaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $status_cuadrilla=1;
            $table="personal_campo";
            $result = $this->_sitio->UpdateAsignacionpersonalasitio($post,$table);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL

    public function requestchangeaddstatuspersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="personal_campo";
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");
            $result = $this->_sitio->Updatechangepersonal($post,$table, $hoy);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL

    public function requestchangeaddstatuspersonaldosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="personal_campo";
            $result = $this->_sitio->Updatechangepersonaldos($post,$table);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL

    public function requestchangeaddperfilpersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="personal_campo";
            $result = $this->_sitio->Updatechangepersonalperfil($post,$table);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL

    public function requestaddcomentariositiopersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            $table="detalle_comentarios";
            $result = $this->_sitio->insertcomentariopersonal($post,$table,$nombre);
            
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL

    public function requestliberarpersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $result = $this->_sitio->Updateliberacionpersonalasitio($post); 
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST ADD ROL

    public function requestdeletefilebtsAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($post['option'] == 1){
            $option = "proyecto_preliminarap"; $fecha = "fecha_preliminar"; $user = "user_preliminar"; unlink($post['file']); 
            $table="detalle_btspdf";
        }

        if($post['option'] == 2){
            $option = "msde_preliminar"; $fecha = "fecha_mspreliminar"; $user = "user_mspreliminar"; unlink($post['file']); 
            $table="detalle_btspdf";
        }

        if($post['option'] == 3){
            $option = "msde_final"; $fecha = "fecha_msfinal"; $user = "user_msfinal"; unlink($post['file']); 
            $table="detalle_btspdf";
        }

        if($post['option'] == 4){
            $option = "proyecto_final"; $fecha= "fecha_proyectofinal"; $user = "user_proyectofinal"; unlink($post['file']); 
            $table="detalle_btspdf";
        }

        if($post['option'] == 5){
            $option = "ttv_colocacion"; $fecha = "fecha_colocacion"; $user = "user_colocacion"; unlink($post['file']); 
            $table="detalle_btspdf";
        }

        if($post['option'] == 6){
            $option = "ttv_anexoa"; $fecha = "fecha_anexoa"; $user = "user_anexoa"; unlink($post['file']); 
            $table="detalle_btspdf";
        }

        if($post['option'] == 7){
            $option = "ttv_candidato"; $fecha = "fecha_candidato"; $user = "user_candidato"; unlink($post['file']); 
            $table="detalle_btspdf";
        }

        if($post['option'] == 8){
            $option = "termino_obra"; $fecha = "fecha_terminoobra"; $user = "user_terminoobra"; unlink($post['file']); 
            $table="detalle_btspdf";
        }

        if($post['option'] == 9){
            $option = "pdf_reportesitio"; $fecha = "fecha_reportesitio"; $user = "user_reportesitio"; unlink($post['file']); 
            $table="detalle_btspdfdos";
        }

        if($post['option'] == 10){
            $option = "pdf_punchlist"; $fecha ="fecha_punchlist"; $user = "user_punchlist"; unlink($post['file']); 
            $table="detalle_btspdfdos";
        }

        if($post['option'] == 11){
            $option = "pdf_correcciondetalles"; $fecha ="fecha_correcciondetalles"; $user = "user_correcciondetalles";
            unlink($post['file']); $table="detalle_btspdfdos";
        }

        if($post['option'] == 12){
            $option = "pdf_protocolooperador"; $fecha ="fecha_protocolooperador"; $user="user_protocolooperador";
            unlink($post['file']); $table="detalle_btspdfdos";
        }

        if($post['option'] == 13){
            $option ="pdf_compactacion"; $fecha = "fecha_compactacion"; $user="user_compactacion"; unlink($post['file']); 
            $table="detalle_btspdfdos";
        }

        if($post['option'] == 14){
            $option = "pdf_sietedias"; $fecha="fecha_sietedias"; $user="user_sietedias"; unlink($post['file']); 
            $table="detalle_btspdfdos";
        }

        if($post['option'] == 15){
            $option ="pdf_catorcedias"; $fecha="fecha_catorcedias"; $user ="user_catorcedias"; unlink($post['file']); 
            $table="detalle_btspdfdos";
        }

        if($post['option'] == 16){
            $option ="pdf_ventiundias"; $fecha ="fecha_ventiundias"; $user ="user_ventiundias"; unlink($post['file']); 
            $table="detalle_btspdfdos";
        }

        if($post['option'] == 17){
            $option ="pdf_ventiochodias"; $fecha="fecha_ventiochodias"; $user="user_ventiochodias"; unlink($post['file']); 
            $table="detalle_btspdfdos";
        }

        if($post['option'] == 18){
            $option ="pdf_resistividad"; $fecha="fecha_resistividad"; $user ="user_resistividad"; unlink($post['file']); 
            $table="detalle_btspdfdos";
        }

        if($post['option'] == 19){
            $option ="pdf_voltaje"; $fecha="fecha_voltaje"; $user ="user_voltaje"; unlink($post['file']); 
            $table="detalle_btspdfdos";
        }

        if($post['option'] == 20){
            $option ="pdf_adeudo"; $fecha="fecha_adeudo"; $user ="user_adeudo"; unlink($post['file']); 
            $table="detalle_btspdfdos";
        }

        if($post['option'] == 21){
            $option ="pdf_asbuilt"; $fecha ="fecha_asbuilt"; $user ="user_asbuilt"; unlink($post['file']); 
            $table="detalle_btspdfdos";
        }

        if($post['option'] == 22){
            $option ="pdf_cartaliberacion"; $fecha ="fecha_cartaliberacion"; $user ="user_cartaliberacion";
            unlink($post['file']); $table="detalle_btspdfdos";
        }

        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $result = $this->_sitio->refresharchivoption($id,$table,$option,$fecha,$user,$post);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST DELETE PERSONAL

    public function requestdeletepuestopersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="puestos_personal";
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
    }//END REQUEST DELETE PERSONAL

    public function requestdeletefilecotizacionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="cotizacion_solicitudordencompra";
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
    }//END REQUEST DELTE COTIZACION SOLICITUD ORDEN COMPRA

    public function requestdeletefilecomparativaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="comparativa_solicitudordencompra";
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
    }//END REQUEST DELTE COMPARATIVA SOLICITUD ORDEN COMPRA

    public function requestdeleteservicioscatalogoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="servicios";
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
    }//END REQUEST DELETE PERSONAL

    public function requestdeleteserviciocatalogoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="servicios_comprobaciones";
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
    }

    public function requestdeleteajaxsitiosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="sitios";
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
    }//END REQUEST DELETE PERSONAL

    public function requestdeletepersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="personal_campo";
            $wh="id";
            $imagen=$this->_season->GetSpecific($table,$wh,$id);
            foreach ($imagen as $img => $val) {
                $url=$val['imagen'];
                if (file_exists($url)) {
                    unlink($url);
                    if (!empty($imagen)&&!empty($id)) {
                        $this->_season->deleteAll($id,$table,$wh);
                    }   
                }else{
                    $this->_season->deleteAll($id,$table,$wh); 
                }               
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

    public function requestadddetailsitioajaxAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        // var_dump($post);exit;
            $table="detalle_bts";
            $id=$post['sitio'];
            $wh="id_sitiotipo";
            $datos = $this->_season->GetSpecific($table,$wh,$id);
            if (empty($datos)){
                $table="detalle_bts";
                $this->_project->insertdetallebts($post['sitio'],$table);
            }else{

            }

            if($post['baseline_cof'] != ""){
                $table="detalle_btsdos";
                $id=$post['sitio'];
                $wh="id_sitiotipo";
                $usr = $this->_season->GetSpecific($table,$wh,$id);
                $fecha_actual = $post['baseline_cof'];
                $pruebacompactacion = date("d-m-Y",strtotime($fecha_actual."+ 1 days"));
                $table="detalle_btsdos";
                $id=$post['sitio'];
                $wh="id_sitiotipo";
                $usr = $this->_season->GetSpecific($table,$wh,$id);
                    if (empty($usr)) {
                        $table="detalle_btsdos";
                        $this->_sitio->insertdetallebtsdosid($post,$table);
                    }
                $sitio = $post["sitio"];
                $this->_project->refreshreportesitio($sitio, $table, $pruebacompactacion);
            }

        if($this->getRequest()->getPost()){
            $table = "detalle_bts";

            if($post['ttv_baseline'] != "" || $post['ttv_baseline'] == ""){
                $date_bts = "ttv_baseline"; $dato_update =$post['ttv_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['ttv_forecast'] != "" || $post['ttv_forecast'] == ""){
                $date_bts = "ttv_forecast"; $dato_update =$post['ttv_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['ttv_actual'] != "" || $post['ttv_actual'] == ""){
                $date_bts = "ttv_actual"; $dato_update =$post['ttv_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['muestreo_baseline'] != "" || $post['muestreo_baseline'] == ""){
                $date_bts = "muestreo_baseline"; $dato_update =$post['muestreo_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['muestreo_forecast'] != "" || $post['muestreo_forecast'] == ""){
                $date_bts = "muestreo_forecast"; $dato_update =$post['muestreo_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['muestreo_actual'] != "" || $post['muestreo_actual'] == ""){
                $date_bts = "muestreo_actual"; $dato_update =$post['muestreo_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['baseline_ap'] != "" || $post['baseline_ap'] == ""){
                $date_bts = "proyectopreliminar_baseline"; $dato_update =$post['baseline_ap'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['forecast_ap'] != "" || $post['forecast_ap'] == ""){
                $date_bts = "proyectopreliminar_forecast"; $dato_update =$post['forecast_ap'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['actual_ap'] != "" || $post['actual_ap'] == ""){
                $date_bts = "proyectopreliminar_actual"; $dato_update =$post['actual_ap'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['baseline_red'] != "" || $post['baseline_red'] == ""){
                $date_bts = "redlines"; $dato_update =$post['baseline_red'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['baseline_preliminar'] != "" || $post['baseline_preliminar'] == ""){
                $date_bts = "mspreliminar_baseline"; $dato_update =$post['baseline_preliminar'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['forecast_preliminar'] != "" || $post['forecast_preliminar'] == ""){
                $date_bts = "mspreliminar_forecast"; $dato_update =$post['forecast_preliminar'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['actual_preliminar'] != "" || $post['actual_preliminar'] == ""){
                $date_bts = "mspreliminar_actual"; $dato_update =$post['actual_preliminar'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['baseline_msdefinal'] != "" || $post['baseline_msdefinal'] == ""){
                $date_bts = "msfinal_baseline"; $dato_update =$post['baseline_msdefinal'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['forecast_msdefinal'] != "" || $post['forecast_msdefinal'] == ""){
                $date_bts = "msfinal_forecast"; $dato_update =$post['forecast_msdefinal'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['actual_msdefinal'] != "" || $post['actual_msdefinal'] == ""){
                $date_bts = "msfinal_actual"; $dato_update =$post['actual_msdefinal'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['baseline_msfinal'] != "" || $post['baseline_msfinal'] == "" ){
                $date_bts = "proyectofinal_baseline"; $dato_update =$post['baseline_msfinal'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['forecast_msfinal'] != "" || $post['forecast_msfinal'] == ""){
                $date_bts = "proyectofinal_forecast"; $dato_update =$post['forecast_msfinal'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['actual_msfinal'] != "" || $post['actual_msfinal'] == "" ){
                $date_bts = "proyectofinal_actual"; $dato_update =$post['actual_msfinal'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['baseline_cos'] != "" || $post['baseline_cos'] == ""){
                $date_bts = "inicioobra_baseline"; $dato_update =$post['baseline_cos'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);

                // $table2="sitios_tipoproyecto";
                // $this->_project->updatesitiocronograma($table2,$post);
            }

            if($post['forecast_cos'] != "" || $post['forecast_cos'] == ""){
                $date_bts = "inicioobra_forecast"; $dato_update =$post['forecast_cos'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['actual_cos'] != "" || $post['actual_cos'] == ""){
                $date_bts = "inicioobra_actual"; $dato_update =$post['actual_cos'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['baseline_cof'] != "" || $post['baseline_cof'] == ""){
                $date_bts = "terminoobra_baseline"; $dato_update =$post['baseline_cof'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['forecast_cof'] != "" || $post['forecast_cof'] == ""){
                $date_bts = "terminoobra_forecast"; $dato_update =$post['forecast_cof'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['actual_cof'] != "" || $post['actual_cof'] == ""){
                $date_bts = "terminoobra_actual"; $dato_update =$post['actual_cof'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }
                    
            if ($result) {
                return $this-> _redirect('/panel/asignardetalles/id/'.$post['id'].'/proyecto/'.$post['proyecto'].'/sitio/'.$post['sitio'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD ROL

    public function requestadddetailtwositioajaxAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="detalle_btsdos";
            $id=$post['sitio'];
            $wh="id_sitiotipo";
            $datos = $this->_season->GetSpecific($table,$wh,$id);
            if (empty($datos)){
                $this->_project->insertdetallebts($post['sitio'],$table);
            }

            $table = "detalle_btsdos";
            if($post['reportesitio_baseline'] != null || $post['reportesitio_baseline'] == null){
                $date_bts = "reportesitio_baseline"; $dato_update =$post['reportesitio_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['reportesitio_forecast'] != null || $post['reportesitio_forecast'] == nul){
                $date_bts = "reportesitio_forecast"; $dato_update =$post['reportesitio_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['reportesitio_actual'] != null || $post['reportesitio_actual'] == null){
                $date_bts = "reportesitio_actual"; $dato_update =$post['reportesitio_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['entrega_sitio'] != null || $post['entrega_sitio'] == null){
                $date_bts = "entrega_sitio"; $dato_update =$post['entrega_sitio'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['odk_operador'] != null || $post['odk_operador'] == null){
                $date_bts = "odk_operador"; $dato_update =$post['odk_operador'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['punchlist_operador'] != null || $post['punchlist_operador'] == null){
                $date_bts = "punchlist_operador"; $dato_update =$post['punchlist_operador'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['correcciondetalles_baseline'] != null || $post['correcciondetalles_baseline'] == null){
                $date_bts = "corecciondetalles_baseline"; $dato_update =$post['correcciondetalles_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['correcciondetalles_forecast'] != null || $post['correcciondetalles_forecast'] == null){
                $date_bts = "correcciondetalles_forecast"; $dato_update =$post['correcciondetalles_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['correcciondetalles_actual'] != null || $post['correcciondetalles_actual'] == null){
                $date_bts = "correcciondetalles_actual"; $dato_update =$post['correcciondetalles_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['protocolo_limpio'] != null || $post['protocolo_limpio'] == null){
                $date_bts = "protocolo_operador"; $dato_update =$post['protocolo_limpio'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['pruebascompactacion_baseline'] != null || $post['pruebascompactacion_baseline'] == null){
                $date_bts = "pruebacompactacion_baseline"; $dato_update =$post['pruebascompactacion_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['pruebascompactacion_forecast'] != null || $post['pruebascompactacion_forecast'] == null){
                $date_bts = "pruebacompactacion_forecast"; $dato_update =$post['pruebascompactacion_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['pruebascompactacion_actual'] != null || $post['pruebascompactacion_actual'] == null){
                $date_bts = "pruebacompactacion_actual"; $dato_update =$post['pruebascompactacion_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['sietedias_baseline'] != null || $post['sietedias_baseline'] == null){
                $date_bts = "pruebasiete_baseline"; $dato_update =$post['sietedias_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['sietedias_forecast'] != null || $post['sietedias_forecast'] == null){
                $date_bts = "pruebasiete_forecast"; $dato_update =$post['sietedias_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['sietedias_actual'] != null || $post['sietedias_actual'] == null){
                $date_bts = "pruebasiete_actual"; $dato_update =$post['sietedias_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['catorcedias_baseline'] != null || $post['catorcedias_baseline'] != null){
                $date_bts = "pruebacatorce_baseline"; $dato_update =$post['catorcedias_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['catorcedias_forecast'] != null || $post['catorcedias_forecast'] == null){
                $date_bts = "pruebacatorce_forecast"; $dato_update =$post['catorcedias_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['catorcedias_actual'] != null || $post['catorcedias_actual'] == null){
                $date_bts = "pruebacatorce_actual"; $dato_update =$post['catorcedias_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['ventiunodias_baseline'] != null || $post['ventiunodias_baseline'] == null){
                $date_bts = "pruebaventiuno_baseline"; $dato_update =$post['ventiunodias_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['ventiunodias_forecast'] != null || $post['ventiunodias_forecast'] == null){
                $date_bts = "pruebaventiuno_forecast"; $dato_update =$post['ventiunodias_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['ventiunodias_actual'] != null || $post['ventiunodias_actual'] == null){
                $date_bts = "pruebaventiuno_actual"; $dato_update =$post['ventiunodias_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['ventiochodias_baseline'] != null || $post['ventiochodias_baseline'] == null){
                $date_bts = "pruebaventiocho_baseline"; $dato_update =$post['ventiochodias_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['ventiochodias_forecast'] != null || $post['ventiochodias_forecast'] == null){
                $date_bts = "pruebaventiocho_forecast"; $dato_update =$post['ventiochodias_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['ventiochodias_actual'] != null || $post['ventiochodias_actual'] == null){
                $date_bts = "pruebaventiocho_actual"; $dato_update =$post['ventiochodias_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['resistividad_baseline'] != null || $post['resistividad_baseline'] == null){
                $date_bts = "resistividad_baseline"; $dato_update =$post['resistividad_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['resistividad_forecast'] != null || $post['resistividad_forecast'] == null){
                $date_bts = "resistividad_forecast"; $dato_update =$post['resistividad_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['resistividad_actual'] != null || $post['resistividad_actual'] == null){
                $date_bts = "resistividad_actual"; $dato_update =$post['resistividad_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['voltaje_baseline'] != null || $post['voltaje_baseline'] == null){
                $date_bts = "voltaje_baseline"; $dato_update =$post['voltaje_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['voltaje_forecast'] != null || $post['voltaje_forecast'] == null){
                $date_bts = "voltaje_forecast"; $dato_update =$post['voltaje_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['voltaje_actual'] != null || $post['voltaje_actual'] == null){
                $date_bts = "voltaje_actual"; $dato_update =$post['voltaje_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['carta_adeudo'] != null || $post['carta_adeudo'] == null){
                $date_bts = "adeudo_baseline"; $dato_update =$post['carta_adeudo'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['asbuilt_baseline'] != null || $post['asbuilt_baseline'] == null){
                $date_bts = "asbuilt_baseline"; $dato_update =$post['asbuilt_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['asbuilt_forecast'] != null || $post['asbuilt_forecast'] == null){
                $date_bts = "asbuilt_forecast"; $dato_update =$post['asbuilt_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['asbuilt_actual'] != null || $post['asbuilt_actual'] == null){
                $date_bts = "asbuilt_actual"; $dato_update =$post['asbuilt_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['carta_liberacion'] != null || $post['carta_liberacion'] == null){
                $date_bts = "carta_liberacion"; $dato_update =$post['carta_liberacion'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
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

    public function requestaddserviciocatalogoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="servicios";
            $result = $this->_servicios->insertservicio($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/servicios');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaddsolicitudordencompraAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $prov=$post['proveedor'];
        $wh="id";
        $table="proveedor";
        $provs = $this->_season->GetSpecific($table,$wh,$prov);
        $name_prov = $provs[0]['nombre_prov'];

            if($post['sitio'] == "oficina"){
                $id_sitio= 0;
                $nombre_sitio = "oficina";
            }

            if($post['sitio'] == "almacen"){
                $id_sitio= 10000000;
                $nombre_sitio = "Stock Almacen";
            }

            if($post['sitio'] != "oficina" && $post['sitio'] != "almacen"){
                $id=$post['sitio'];
                $wh="id";
                $table="sitios";
                $sitios_id = $this->_season->GetSpecific($table,$wh,$id);
                $id_sitio= $sitios_id[0]['id'];
                $nombre_sitio= $sitios_id[0]['nombre'];
            }

        $servicio_id=$post['servicio'];
        $wh="id";
        $table="servicios";
        $ser = $this->_season->GetSpecific($table,$wh,$servicio_id);
        $encargado_rol = $ser[0]['encargado_rol'];

        if($ser[0]['encargado_rol'] == 8){
            $validacion = 1;
        }else{
            $validacion = 0;
        }

        if($post['facturable'] == 1){
            $fact = "Facturable";
        }else{
            $fact = "No facturable";
        }

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $id_user = $usr[0]['id'];
        $name_user = $usr[0]['nombre'] ." ". $usr[0]['ap'];
        
        if($this->getRequest()->getPost()){
            $table="solicitudes_pendientes";
            $result = $this->_ordencompra->insertsolicitudordencompra($post,$table,$id_sitio);

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i");
            $resultado= $this->_ordencompra->refreshsolicitudordencompra($table,$result,$post,$id_user,$nombre_sitio,$encargado_rol, $validacion,$hoy,$fact, $name_prov,$name_user);

            if ($resultado) {
                return $this-> _redirect('/panel/ordencompraspasodos/id/'.$result.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaupdatesolicitudordencompraAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

            if($post['sitio'] == "oficina"){
                $id_sitio= 0;
                $nombre_sitio = "oficina";
            }

            if($post['sitio'] == "almacen"){
                $id_sitio= 10000000;
                $nombre_sitio = "Stock Almacen";
            }

            if($post['sitio'] != "oficina" && $post['sitio'] != "almacen"){
                $id=$post['sitio'];
                $wh="id";
                $table="sitios";
                $sitios_id = $this->_season->GetSpecific($table,$wh,$id);
                $id_sitio= $sitios_id[0]['id'];
            }

        $servicio_id=$post['servicio'];
        $wh="id";
        $table="servicios";
        $ser = $this->_season->GetSpecific($table,$wh,$servicio_id);
        $encargado_rol = $ser[0]['encargado_rol'];

        if($this->getRequest()->getPost()){
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id_user = $usr[0]['id'];

            $table="solicitudes_pendientes";
            $resultado= $this->_ordencompra->refresheditsolicitudordencompra($table,$post,$id_user,$id_sitio,$nombre_sitio,$encargado_rol );
            if ($resultado) {
                return $this-> _redirect('/panel/ordencompraspasodos/id/'.$post['id'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestupdateserviciocatalogoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="servicios";
            $result = $this->_servicios->refreshserviciocatalogo($post,$table);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }

    public function requestaddstatusproyectoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="status_proyecto";
            $result = $this->_project->insertstatusproyecto($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/statustipo/id/'.$post['id_proyecto'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestupdatestatusproyectoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="status_proyecto";
            $result = $this->_project->updatestatusproyecto($table,$post);
            if ($result) {
                return $this-> _redirect('/panel/statustipo/id/'.$post['status_proyecto'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaddstatusclienteAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();  
        if($this->getRequest()->getPost()){
            $table="status_cliente";
            $result = $this->_project->insertstatuscliente($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/statustipocliente/id/'.$post['id_proyecto'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaddcomentarioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="comentarios_sitios";
            $result = $this->_sitio->inserComentariositio($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/detallesproyecto/id/'.$post['id'].'/proyecto/'.$post['proyecto'].'/sitio/'.$post['sitio'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaddevidenciaproyectoAction(){
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
                    $url1 = 'img/sitios/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            } 

            $table="semanauno_bts";
            $id=$post['sitio'];
            $wh="idsitio_tipo";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            if(empty($usr)){
                $table="semanauno_bts";
                $result1 = $this->_project->insertfotopreliminar($post,$table);

                if ($post['actividad'] == 1){
                    $status = "status_preliminares";
                    $imagen ="preliminares";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 2){
                    $status = "status_trazo";
                    $imagen ="trazo_limpieza";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 3){
                    $status = "status_excavacion";
                    $imagen ="excavacion";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 4){
                    $status = "status_plantilla";
                    $imagen ="plantilla";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 5){
                    $status = "status_translado";
                    $imagen ="translado";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 6){
                    $status = "status_armado";
                    $imagen ="armado";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 7){
                    $status = "status_muro";
                    $imagen ="excavacion_muro";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if($post['actividad'] == 8){
                    $status = "status_arena";
                    $imagen = "arena";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if($post['actividad'] == 9){
                    $status = "status_cemento";
                    $imagen = "cemento";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if($post['actividad'] == 10){
                    $status = "status_block";
                    $imagen = "block";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if($post['actividad'] == 11){
                    $status = "status_varilla";
                    $imagen = "varilla";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if($post['actividad'] == 12){
                    $status = "status_madera";
                    $imagen = "madera";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

            }else{
                $result1=$usr[0]['id'];
                if ($post['actividad'] == 1){
                    $status = "status_preliminares";
                    $imagen ="preliminares";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 2){
                    $status = "status_trazo";
                    $imagen ="trazo_limpieza";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 3){
                    $status = "status_excavacion";
                    $imagen ="excavacion";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 4){
                    $status = "status_plantilla";
                    $imagen ="plantilla";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 5){
                    $status = "status_translado";
                    $imagen ="translado";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 6){
                    $status = "status_armado";
                    $imagen ="armado";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 7){
                    $status = "status_muro";
                    $imagen ="excavacion_muro";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if($post['actividad'] == 8){
                    $status = "status_arena";
                    $imagen = "arena";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if($post['actividad'] == 9){
                    $status = "status_cemento";
                    $imagen = "cemento";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if($post['actividad'] == 10){
                    $status = "status_block";
                    $imagen = "block";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if($post['actividad'] == 11){
                    $status = "status_varilla";
                    $imagen = "varilla";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if($post['actividad'] == 12){
                    $status = "status_madera";
                    $imagen = "madera";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
            }

            if ($result) {
                return $this-> _redirect('/panel/asignardetalles/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD CERTIFICADO MEDICO PERSONAL DE CAMPO

    public function requestupdatevidenciassemanaunoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        if($this->getRequest()->getPost()){
            $post = $this->getRequest()->getPost();
            $table="semanauno_bts";
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
                    $ext1 = '.'.$info1->getExtension();
                    $ran =  $this->randomnamebts();    
                    $url1 = 'img/sitios/'; 
                    $urldb = $url1.$ran.$ext1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if
            $table="semanauno_bts";
            $id=$post['sitio'];
            $wh="idsitio_tipo";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $result1=$usr[0]['id'];

                if ($post['actividad'] == 1){
                    $status = "status_preliminares";
                    $imagen ="preliminares";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 2){
                    $status = "status_trazo";
                    $imagen ="trazo_limpieza";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 3){
                    $status = "status_excavacion";
                    $imagen ="excavacion";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 4){
                    $status = "status_plantilla";
                    $imagen ="plantilla";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 5){
                    $status = "status_translado";
                    $imagen ="translado";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 6){
                    $status = "status_armado";
                    $imagen ="armado";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 7){
                    $status = "status_muro";
                    $imagen ="excavacion_muro";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }


                if($post['actividad'] == 8){
                    $status = "status_arena";
                    $imagen = "arena";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if($post['actividad'] == 9){
                    $status = "status_cemento";
                    $imagen = "cemento";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if($post['actividad'] == 10){
                    $status = "status_blok";
                    $imagen = "block";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if($post['actividad'] == 11){
                    $status = "status_varilla";
                    $imagen = "varilla";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if($post['actividad'] == 12){
                    $status = "status_madera";
                    $imagen = "madera";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

            if ($result) {
                return $this-> _redirect('/panel/semanaunoedit/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
            return $this-> _redirect('/panel/semanaunoedit/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
        }
    }//END REQUEST EDIT WK 1 BTS


    public function requestaddevidenciasemanadosAction(){
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
                    $url1 = 'img/sitios/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            } 
            $table="semanados_bts";
            $id=$post['sitio'];
            $wh="idsitio_tipo";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            if(empty($usr)){
                $table="semanados_bts";
                $result1 = $this->_sitio->insertfotopreliminarsemanados($post,$table);

                if ($post['actividad'] == 1){
                    $status = "status_colocacion";
                    $imagen ="colocacion";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 2){
                    $fecha_actual = date("d-m-Y");
                    $siete_dias = date("d-m-Y",strtotime($fecha_actual."+ 8 days"));
                    $catorce_dias = date("d-m-Y",strtotime($fecha_actual."+ 15 days"));
                    $ventiun_dias = date("d-m-Y",strtotime($fecha_actual."+ 22 days"));
                    $ventiocho_dias = date("d-m-Y",strtotime($fecha_actual."+ 29 days"));
                    $table="detalle_btsdos";
                    $id=$post['sitio'];
                    $wh="id_sitiotipo";
                    $usr = $this->_season->GetSpecific($table,$wh,$id);

                        if (empty($usr)) {
                            $table="detalle_btsdos";
                            $result1 = $this->_sitio->insertdetallebtsdosid($post,$table);
                        }
                    $sitio = $post["sitio"];
                    $this->_project->refreshpruebasdeconcreto($sitio, $table, $siete_dias, $catorce_dias, $ventiun_dias, $ventiocho_dias);
                    $status = "status_vaciado";
                    $imagen ="vaciado";
                    $table="semanados_bts";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 3){

                    $fecha_actual = date("d-m-Y");
                    $pruebacompactacion = date("d-m-Y",strtotime($fecha_actual."+ 8 days"));
                    $table="detalle_btsdos";
                    $id=$post['sitio'];
                    $wh="id_sitiotipo";
                    $usr = $this->_season->GetSpecific($table,$wh,$id);

                        if (empty($usr)) {
                            $table="detalle_btsdos";
                            $result1 = $this->_sitio->insertdetallebtsdosid($post,$table);
                        }
                    $sitio = $post["sitio"];
                    $this->_project->refreshpruebasdecompactacion($sitio, $table, $pruebacompactacion);

                    $status = "status_relleno";
                    $imagen ="relleno";
                    $table="semanados_bts";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 4){
                    $status = "status_nicho";
                    $imagen ="nicho";
                    $table="semanados_bts";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 5){
                    $status = "status_muro";
                    $imagen ="muro";
                    $table="semanados_bts";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 6){
                    $status = "status_tuberiapvc";
                    $imagen ="tuberiapvc";
                    $table="semanados_bts";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 7){
                    $status = "status_laboratorio";
                    $imagen ="laboratorio";
                    $table="semanados_bts";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
            }else{

                $result1=$usr[0]['id'];
                if ($post['actividad'] == 1){
                    $status = "status_colocacion";
                    $imagen ="colocacion";
                    $table="semanados_bts";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 2){
                    $fecha_actual = date("d-m-Y");
                    $siete_dias = date("d-m-Y",strtotime($fecha_actual."+ 8 days"));
                    $catorce_dias = date("d-m-Y",strtotime($fecha_actual."+ 15 days"));
                    $ventiun_dias = date("d-m-Y",strtotime($fecha_actual."+ 22 days"));
                    $ventiocho_dias = date("d-m-Y",strtotime($fecha_actual."+ 29 days"));
                    $table="detalle_btsdos";
                    $id=$post['sitio'];
                    $wh="id_sitiotipo";
                    $usr = $this->_season->GetSpecific($table,$wh,$id);

                        if (empty($usr)) {
                            $table="detalle_btsdos";
                            $result1 = $this->_sitio->insertdetallebtsdosid($post,$table);
                        }                        
                    $sitio = $post["sitio"];
                    $this->_project->refreshpruebasdeconcreto($sitio, $table, $siete_dias, $catorce_dias, $ventiun_dias, $ventiocho_dias);

                    $status ="status_vaciado";
                    $imagen ="vaciado";
                    $table="semanados_bts";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 3){
                    $fecha_actual = date("d-m-Y");
                    $pruebacompactacion = date("d-m-Y",strtotime($fecha_actual."+ 8 days"));
                    $table="detalle_btsdos";
                    $id=$post['sitio'];
                    $wh="id_sitiotipo";
                    $usr = $this->_season->GetSpecific($table,$wh,$id);

                        if (empty($usr)) {
                            $table="detalle_btsdos";
                            $result1 = $this->_sitio->insertdetallebtsdosid($post,$table);
                        }
                    $sitio = $post["sitio"];
                    $this->_project->refreshpruebasdecompactacion($sitio, $table, $pruebacompactacion);


                    $status = "status_relleno";
                    $imagen ="relleno";
                    $table="semanados_bts";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 4){
                    $status = "status_nicho";
                    $imagen ="nicho";
                    $table="semanados_bts";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 5){
                    $status = "status_muro";
                    $table="semanados_bts";
                    $imagen ="muro";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 6){
                    $status = "status_tuberiapvc";
                    $imagen ="tuberiapvc";
                    $table="semanados_bts";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 7){
                    $status = "status_laboratorio";
                    $imagen ="laboratorio";
                    $table="semanados_bts";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
            }
            if ($result) {
                return $this-> _redirect('/panel/asignardetalles/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD EVIDENCIAS WK 2 BTA

    public function requestupdatevidenciassemanadosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        if($this->getRequest()->getPost()){
            $post = $this->getRequest()->getPost();
            $table="semanados_bts";
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
                    $ext1 = '.'.$info1->getExtension();
                    $ran =  $this->randomnamebtswkdos();    
                    $url1 = 'img/sitios/'; 
                    $urldb = $url1.$ran.$ext1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="semanados_bts";
            $id=$post['sitio'];
            $wh="idsitio_tipo";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $result1=$usr[0]['id'];

                if ($post['actividad'] == 1){
                    $status = "status_colocacion";
                    $imagen ="colocacion";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 2){
                    $status = "status_vaciado";
                    $imagen ="vaciado";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 3){
                    $status = "status_relleno";
                    $imagen ="relleno";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 4){
                    $status = "status_nicho";
                    $imagen ="nicho";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 5){
                    $status = "status_muro";
                    $imagen ="muro";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 6){
                    $status = "status_tuberiapvc";
                    $imagen ="tuberiapvc";
                    $table="semanados_bts";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 7){
                    $status = "status_laboratorio";
                    $imagen ="laboratorio";
                    $table="semanados_bts";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

            if ($result) {
                return $this-> _redirect('/panel/semanadosedit/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
            return $this-> _redirect('/panel/semanadosedit/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
        }
    }//END REQUEST EDIT WK 2 BTS

    public function requestaddevidenciasemanatresAction(){
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
                    $url1 = 'img/sitios/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            } 

            $table="semanatres_bts";
            $id=$post['sitio'];
            $wh="idsitio_tipo";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            if(empty($usr)){
                $table="semanatres_bts";
                $result1 = $this->_panel->insertfotopreliminarsemanatres($post,$table);

                if ($post['actividad'] == 1){
                    $status = "status_excavaciontrayectoria";
                    $imagen ="excavacion_trayectoria";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 2){
                    $status = "status_basemedicion";
                    $imagen ="base_medicion";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 3){
                    $status = "status_baseinterruptor";
                    $imagen ="base_interruptor";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 4){
                    $status = "status_registrosfo";
                    $imagen ="registros_fo";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 5){
                    $status = "status_registroelectrico";
                    $imagen ="registro_electrico";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 6){
                    $status = "status_tuberiafo";
                    $imagen ="tuberia_fo";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 7){
                    $status = "status_tuberiaelectrica";
                    $imagen ="tuberia_electrica";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 8){
                    $status = "status_trayectoriaaerea";
                    $imagen ="trayectoria_aerea";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 9){
                    $status = "status_planchaequipo";
                    $imagen ="plancha_equipo";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 10){
                    $status = "status_soportetelescopio";
                    $imagen ="soporte_telescopio";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 11){
                    $status = "status_sistematierras";
                    $imagen ="sistema_tierras";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 12){
                    $status = "status_interruptorgabinetes";
                    $imagen ="interruptor_gabinetes";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 13){
                    $status = "status_nichocentro";
                    $imagen ="nicho_centro";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 14){
                    $status = "status_gabinetefuerzas";
                    $imagen ="gabinete_fuerzas";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 15){
                    $status = "status_instalacioncable";
                    $imagen ="instalacion_cable";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 16){
                    $status = "status_basesequipos";
                    $imagen ="bases_equipos";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 17){
                    $status = "status_orientacionsoportes";
                    $imagen ="orientacion_soportes";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 18){
                    $status = "status_instalacioncgo";
                    $imagen ="instalacion_cgo";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 19){
                    $status = "status_instalacionbarrastierras";
                    $imagen ="instalacion_barrastierras";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 20){
                    $status = "status_aterrizajebarras";
                    $imagen ="aterrizaje_barras";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 21){
                    $status = "status_portacables";
                    $imagen ="porta_cables";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 22){
                    $status = "status_sistemaelectrico";
                    $imagen ="sistema_electrico";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 23){
                    $status = "status_fibraoptica";
                    $imagen ="fibra_optica";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 24){
                    $status = "status_sistemadetierra";
                    $imagen ="sistemadetierra";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 25){
                    $status = "status_materialelectrico";
                    $imagen ="materialelectrico";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
            }else{
                $result1=$usr[0]['id'];
                if ($post['actividad'] == 1){
                    $status = "status_excavaciontrayectoria";
                    $imagen ="excavacion_trayectoria";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 2){
                    $status = "status_basemedicion";
                    $imagen ="base_medicion";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 3){
                    $status = "status_baseinterruptor";
                    $imagen ="base_interruptor";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 4){
                    $status = "status_registrosfo";
                    $imagen ="registros_fo";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 5){
                    $status = "status_registroelectrico";
                    $imagen ="registro_electrico";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 6){
                    $status = "status_tuberiafo";
                    $imagen ="tuberia_fo";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 7){
                    $status = "status_tuberiaelectrica";
                    $imagen ="tuberia_electrica";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 8){
                    $status = "status_trayectoriaaerea";
                    $imagen ="trayectoria_aerea";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 9){
                    $status = "status_planchaequipo";
                    $imagen ="plancha_equipo";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 10){
                    $status = "status_soportetelescopio";
                    $imagen ="soporte_telescopio";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 11){
                    $status = "status_sistematierras";
                    $imagen ="sistema_tierras";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 12){
                    $status = "status_interruptorgabinetes";
                    $imagen ="interruptor_gabinetes";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 13){
                    $status = "status_nichocentro";
                    $imagen ="nicho_centro";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 14){
                    $status = "status_gabinetefuerzas";
                    $imagen ="gabinete_fuerzas";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 15){
                    $status = "status_instalacioncable";
                    $imagen ="instalacion_cable";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 16){
                    $status = "status_basesequipos";
                    $imagen ="bases_equipos";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 17){
                    $status = "status_orientacionsoportes";
                    $imagen ="orientacion_soportes";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 18){
                    $status = "status_instalacioncgo";
                    $imagen ="instalacion_cgo";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 19){
                    $status = "status_instalacionbarrastierras";
                    $imagen ="instalacion_barrastierras";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 20){
                    $status = "status_aterrizajebarras";
                    $imagen ="aterrizaje_barras";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 21){
                    $status = "status_portacables";
                    $imagen ="porta_cables";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 22){
                    $status = "status_sistemaelectrico";
                    $imagen ="sistema_electrico";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 23){
                    $status = "status_fibraoptica";
                    $imagen ="fibra_optica";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 24){
                    $status = "status_sistemadetierra";
                    $imagen ="sistemadetierra";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 25){
                    $status = "status_materialelectrico";
                    $imagen ="materialelectrico";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

            }
            if ($result) {
                return $this-> _redirect('/panel/asignardetalles/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD EVIDENCIAS FOTOGRAFICAS 3 BTS

    public function requestupdatevidenciassemanatresAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        if($this->getRequest()->getPost()){
            $post = $this->getRequest()->getPost();
            $table="semanatres_bts";
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
                    $ext1 = '.'.$info1->getExtension();
                    $ran =  $this->randomnamebtswktres();    
                    $url1 = 'img/sitios/'; 
                    $urldb = $url1.$ran.$ext1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if
            $table="semanatres_bts";
            $id=$post['sitio'];
            $wh="idsitio_tipo";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $result1=$usr[0]['id'];

                if ($post['actividad'] == 1){
                    $status = "status_excavaciontrayectoria";
                    $imagen ="excavacion_trayectoria";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 2){
                    $status = "status_basemedicion";
                    $imagen ="base_medicion";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 3){
                    $status = "status_baseinterruptor";
                    $imagen ="base_interruptor";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 4){
                    $status = "status_registrosfo";
                    $imagen ="registros_fo";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 5){
                    $status = "status_registroelectrico";
                    $imagen ="registro_electrico";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 6){
                    $status = "status_tuberiafo";
                    $imagen ="tuberia_fo";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 7){
                    $status = "status_tuberiaelectrica";
                    $imagen ="tuberia_electrica";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 8){
                    $status = "status_trayectoriaaerea";
                    $imagen ="trayectoria_aerea";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 9){
                    $status = "status_planchaequipo";
                    $imagen ="plancha_equipo";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 10){
                    $status = "status_soportetelescopio";
                    $imagen ="soporte_telescopio";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 11){
                    $status = "status_sistematierras";
                    $imagen ="sistema_tierras";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 12){
                    $status = "status_interruptorgabinetes";
                    $imagen ="interruptor_gabinetes";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 13){
                    $status = "status_nichocentro";
                    $imagen ="nicho_centro";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 14){
                    $status = "status_gabinetefuerzas";
                    $imagen ="gabinete_fuerzas";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 15){
                    $status = "status_instalacioncable";
                    $imagen ="instalacion_cable";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 16){
                    $status = "status_basesequipos";
                    $imagen ="bases_equipos";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 17){
                    $status = "status_orientacionsoportes";
                    $imagen ="orientacion_soportes";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 18){
                    $status = "status_instalacioncgo";
                    $imagen ="instalacion_cgo";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 19){
                    $status = "status_instalacionbarrastierras";
                    $imagen ="instalacion_barrastierras";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 20){
                    $status = "status_aterrizajebarras";
                    $imagen ="aterrizaje_barras";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 21){
                    $status = "status_portacables";
                    $imagen ="porta_cables";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 22){
                    $status = "status_sistemaelectrico";
                    $imagen ="sistema_electrico";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 23){
                    $status = "status_fibraoptica";
                    $imagen ="fibra_optica";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
                
                if ($post['actividad'] == 24){
                    $status = "status_sistemadetierra";
                    $imagen ="sistemadetierra";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 25){
                    $status = "status_materialelectrico";
                    $imagen ="materialelectrico";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
            if ($result) {
                return $this-> _redirect('/panel/semanatresedit/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
            return $this-> _redirect('/panel/semanatresedit/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
        }
    }//END REQUEST EDIT WK 4 BTS

    public function requestaddevidenciasemanacuatroAction(){
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
                    $url1 = 'img/sitios/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            } 

            $table="semanacuatro_bts";
            $id=$post['sitio'];
            $wh="idsitio_tipo";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            if(empty($usr)){
                $table="semanacuatro_bts";
                $result1 = $this->_user->insertfotopreliminarsemanacuatro($post,$table);

                if ($post['actividad'] == 1){
                    $status = "status_montajetorre";
                    $imagen ="montaje_torre";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 2){
                    $status = "status_camagrava";
                    $imagen ="cama_grava";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 3){
                    $status = "status_limpiezadetalles";
                    $imagen ="limpieza_detalles";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
            }else{
                $result1=$usr[0]['id'];
                if ($post['actividad'] == 1){
                    $status = "status_montajetorre";
                    $imagen ="montaje_torre";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 2){
                    $status = "status_camagrava";
                    $imagen ="cama_grava";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 3){
                    $status = "status_limpiezadetalles";
                    $imagen ="limpieza_detalles";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }
            }

            if ($result) {
                return $this-> _redirect('/panel/asignardetalles/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD EVIDENCIAS FOTOGRAFICAS WK 4


    public function requestupdatevidenciassemanacuatroAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        if($this->getRequest()->getPost()){
            $post = $this->getRequest()->getPost();
            $table="semanacuatro_bts";
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
                    $ext1 = '.'.$info1->getExtension();
                    $ran =  $this->randomnamebtswkcuatro();    
                    $url1 = 'img/sitios/'; 
                    $urldb = $url1.$ran.$ext1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="semanacuatro_bts";
            $id=$post['sitio'];
            $wh="idsitio_tipo";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $result1=$usr[0]['id'];
                if ($post['actividad'] == 1){
                    $status = "status_montajetorre";
                    $imagen ="montaje_torre";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 2){
                    $status = "status_camagrava";
                    $imagen ="cama_grava";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 3){
                    $status = "status_limpiezadetalles";
                    $imagen ="limpieza_detalles";
                    $result = $this->_project->refresactividadsemanados($post, $table, $result1, $urldb, $status, $imagen);
                }

            if ($result) {
                return $this-> _redirect('/panel/semanacuatroedit/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
            return $this-> _redirect('/panel/semanacuatroedit/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
        }
    }//END REQUEST EDIT WK 4 BTS

    public function requestaddfilebtsAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
            $id=$this->_session->id;
            $table="usuario";
            $wh="id";
            $usuario= $this->_season->GetSpecific($table,$wh,$id);
            $user = $usuario[0]['nombre']." ".$usuario[0]['ap'];

        if($post['condicion'] == 1){ $set = "proyecto_preliminarap"; $fecha = "fecha_preliminar"; $carga_user = "user_preliminar";}
        if($post['condicion'] == 2){ $set = "msde_preliminar"; $fecha = "fecha_mspreliminar"; $carga_user ="user_mspreliminar";}
        if($post['condicion'] == 3){ $set = "msde_final"; $fecha = "fecha_msfinal"; $carga_user ="user_msfinal";}
        if($post['condicion'] == 4){ $set = "proyecto_final"; $fecha = "fecha_proyectofinal"; $carga_user ="user_proyectofinal";}
        if($post['condicion'] == 51){ $set = "termino_obra"; $fecha = "fecha_terminoobra"; $carga_user ="user_terminoobra";}

        if($post['condicion'] == 10){
            if($post['formato'] == 1){ $set = "ttv_colocacion"; $fecha = "fecha_colocacion"; $carga_user = "user_colocacion";}
            if($post['formato'] == 2){ $set = "ttv_anexoa"; $fecha = "fecha_anexoa"; $carga_user = "user_anexoa";}
            if($post['formato'] == 3){ $set = "ttv_candidato"; $fecha = "fecha_candidato"; $carga_user = "user_candidato";}
        }

        $name_sitio = $post['nombre_sitio'];
        $table="detalle_btspdf";
        $wh="id_sitiotipo";
        $id=$post['sitio_tipoproyecto'];
        $detail_table= $this->_season->GetSpecific($table,$wh,$id);

        if (empty($detail_table)) {
            mkdir("pdf/sitios/bts/".$name_sitio.""); 
            $insert = $this->_sitio->insertdetallepdfbts($post,$table);
            $detail_table= $this->_season->GetSpecific($table,$wh,$id);
            $detalle_bts_insert = 0;

        }else{
            $detalle_bts_insert = 1;
        }

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
                    $url1 = 'pdf/sitios/bts/'.$name_sitio.'/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }
            $id=$detail_table[0]['id'];
            $table="detalle_btspdf";
            $hoy = date("Y-m-d H:i:s");
            $result = $this->_sitio->insertpdfdetallebts($post,$table,$id,$urldb,$set,$fecha,$hoy,$user,$carga_user);

            if ($result) {
                return $this-> _redirect('/panel/asignardetalles/id/'.$post["id_sitio"].'/proyecto/'.$post["id_tipoproyecto"].'/sitio/'.$post["sitio_tipoproyecto"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaddfilebtstwoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

            $id=$this->_session->id;
            $table="usuario";
            $wh="id";
            $usuario= $this->_season->GetSpecific($table,$wh,$id);
            $user = $usuario[0]['nombre']." ".$usuario[0]['ap'];

        if($post['condicion'] == 1){ $set ="pdf_reportesitio"; $fecha = "fecha_reportesitio"; $carga_user = "user_reportesitio";}
        if($post['condicion'] == 2){ $set ="pdf_punchlist"; $fecha = "fecha_punchlist"; $carga_user = "user_punchlist";}
        if($post['condicion'] == 3){ $set ="pdf_correcciondetalles"; $fecha = "fecha_correcciondetalles"; $carga_user = "user_correcciondetalles";}
        if($post['condicion'] == 4){ $set ="pdf_protocolooperador"; $fecha = "fecha_protocolooperador"; $carga_user = "user_protocolooperador";}
        if($post['condicion'] == 5){ $set ="pdf_compactacion"; $fecha = "fecha_compactacion"; $carga_user = "user_compactacion";}
        if($post['condicion'] == 6){ $set ="pdf_sietedias"; $fecha = "fecha_sietedias"; $carga_user = "user_sietedias";}
        if($post['condicion'] == 7){ $set ="pdf_catorcedias"; $fecha = "fecha_catorcedias"; $carga_user = "user_catorcedias";}
        if($post['condicion'] == 8){ $set ="pdf_ventiundias"; $fecha = "fecha_ventiundias"; $carga_user = "user_ventiundias";}
        if($post['condicion'] == 9){ $set ="pdf_ventiochodias"; $fecha = "fecha_ventiochodias"; $carga_user = "user_ventiochodias";}
        if($post['condicion'] == 10){ $set ="pdf_resistividad"; $fecha = "fecha_resistividad"; $carga_user = "user_resistividad";}
        if($post['condicion'] == 11){ $set ="pdf_voltaje"; $fecha = "fecha_voltaje"; $carga_user = "user_voltaje";}
        if($post['condicion'] == 12){ $set ="pdf_adeudo"; $fecha = "fecha_adeudo"; $carga_user = "user_adeudo";}
        if($post['condicion'] == 13){ $set ="pdf_asbuilt"; $fecha = "fecha_asbuilt"; $carga_user = "user_asbuilt";}
        if($post['condicion'] == 14){ $set ="pdf_cartaliberacion"; $fecha="fecha_cartaliberacion"; $carga_user="user_cartaliberacion";}

        $name_sitio = $post['nombre_sitio'];
        $table="detalle_btspdfdos";
        $wh="id_sitiotipo";
        $id=$post['sitio_tipoproyecto'];
        $detail_table= $this->_season->GetSpecific($table,$wh,$id);

        if (empty($detail_table)) {
            mkdir("pdf/sitios/bts/".$name_sitio.""); 
            $insert = $this->_sitio->insertdetallepdfbts($post,$table);
            $detail_table= $this->_season->GetSpecific($table,$wh,$id);
            $detalle_bts_insert = 0;

        }else{
            $detalle_bts_insert = 1;
        }

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
                    $url1 = 'pdf/sitios/bts/'.$name_sitio.'/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            $id=$detail_table[0]['id'];
            $table="detalle_btspdfdos";
            $hoy = date("Y-m-d H:i:s");
            $result = $this->_sitio->insertpdfdetallebts($post,$table,$id,$urldb,$set,$fecha,$hoy,$user,$carga_user);

            if ($result) {
                return $this-> _redirect('/panel/asignardetalles/id/'.$post["id_sitio"].'/proyecto/'.$post["id_tipoproyecto"].'/sitio/'.$post["sitio_tipoproyecto"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaddfilealtanAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

            $id=$this->_session->id;
            $table="usuario";
            $wh="id";
            $usuario= $this->_season->GetSpecific($table,$wh,$id);
            $user = $usuario[0]['nombre']." ".$usuario[0]['ap'];

        $name_sitio = $post['nombre_sitio'];
        $table="altan_file";
        $wh="id_sitiotipo";
        $id=$post['sitio_tipoproyecto'];
        $detail_table= $this->_season->GetSpecific($table,$wh,$id);

        if (empty($detail_table)) {
            mkdir("altan/".$name_sitio.""); 
            $detalle_bts_insert = 0;

        }else{
            $detalle_bts_insert = 1;
        }

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
                    $url1 = 'altan/'.$name_sitio.'/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            $table="altan_file";
            $hoy = date("Y-m-d H:i:s");
            $result = $this->_sitio->insertfilealtansitio($post,$table,$id,$urldb,$hoy,$user);

            if ($result) {
                return $this-> _redirect('/panel/asignardetalles/id/'.$post["id_sitio"].'/proyecto/'.$post["id_tipoproyecto"].'/sitio/'.$post["sitio_tipoproyecto"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }
    // -------------------   REQUEST EDIT USER----------------------------//

    public function requestupdateuserAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $id=$post["mail"];
        $table="usuario";
        $wh="correo";
        $usuario= $this->_season->GetSpecific($table,$wh,$id);

        if($this->getRequest()->getPost()){
            $table="usuario";
            $result = $this->_user->refreshUsr($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/usuarios');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//REUQUEST EDIT USER

    public function requestupdatenamerolAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="roles";
            $result = $this->_user->refresnamerol($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/userrol');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//REUQUEST EDIT USER

    public function requestuodatepersonalAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();  
        $id=$post["mail"];
        $table="personal_campo";
        $wh="email_personal";
        $usuario= $this->_season->GetSpecific($table,$wh,$id);

        if($this->getRequest()->getPost()){
            $table="personal_campo";
            $result = $this->_user->refreshPersonal($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/personaledit/id/'.$post['ids'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }

    }

    public function requestupdateprsAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();  
        $id=$post["mail"];
        $table="personal_campo";
        $wh="email_personal";
        $usuario= $this->_season->GetSpecific($table,$wh,$id);

        if($this->getRequest()->getPost()){
            $table="personal_campo";
            $result = $this->_user->refreshPersonalcont($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/personaledit/id/'.$post['ids'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }

    }

    public function requestupdatecomentariositioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();  
        if($this->getRequest()->getPost()){
            $table="detalle_comentarios";
            $result = $this->_user->refreshcomentariositio($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/asignardetalles/id/'.$post['id'].'/proyecto/'.$post['proyecto'].'/sitio/'.$post['sitio'].' ');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestupdateserviciocomprobacionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost(); 
    
        if($post['status_politica'] == 0){ $monto_limite = ""; }
        if($post['status_politica'] == 1){ $monto_limite = $post['monto_limite']; }
        if($post['status_politica'] == 2){ $monto_limite = ""; }

        if($post['status_excepcion'] == 0){
            $autorizacion = $post['autorizacion'];
            $id = $post['autorizacion'];
            $wh="id";
            $table="roles";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $name_auto = $usr[0]['nombre'];
        }

        if($post['status_excepcion'] == 1){
            $autorizacion = 0;
            $name_auto = "Sin Autorizacion";
        }
        if($this->getRequest()->getPost()){
            $table="servicios_comprobaciones";
            $result = $this->_comprobacion->refreshserviciocomprobacion($post,$table,$monto_limite,$autorizacion,$name_auto);
            if ($result) {
                return $this-> _redirect('/panel/servicioeditcomprobacion/id/'.$post['id'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestupdateproveedorAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="proveedor";
            $result = $this->_season->refreshProveedor($post,$table);
            // var_dump($result);exit;
            if ($result) {
                return $this-> _redirect('/panel/proveedores');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//REUQUEST EDIT USER

    public function requestupdatesitioproyectoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

            $datos=$post["coordinador"];
            if($datos== null){
                $coordinador_id = 0;
                $coordinador_name = "";
            }else{
                $id=$post["coordinador"];
                $table="usuario";
                $wh="id";
                $coordinador = $this->_season->GetSpecific($table,$wh,$id);
                $coordinador_id = $coordinador[0]['id'];
                $coordinador_name =$coordinador[0]['nombre'];
            }

            $datos=$post["ingeniero"];
            if($datos == null){
                $ingeniero_id = 0;
                $ingproyecto_name ="";
            }else{
                $id=$post["ingeniero"];
                $table="usuario";
                $wh="id";
                $ingproyecto = $this->_season->GetSpecific($table,$wh,$id);
                $ingeniero_id = $ingproyecto[0]['id'];
                $ingproyecto_name =$ingproyecto[0]['nombre'];
            }

            $datos=$post["residente"];
            if($datos == null){
                $residente_id = 0;
                $residente_name ="";
            }else{
                $id=$post["residente"];
                $table="personal_campo";
                $wh="id";
                $residente = $this->_season->GetSpecific($table,$wh,$id);
                $residente_id = $residente[0]['id'];
                $residente_name =$residente[0]['nombre'];
            }

        if($this->getRequest()->getPost()){
            $table="sitios_tipoproyecto";
            $result = $this->_project->refreshsitioproyecto($post,$table, $coordinador_name, $ingproyecto_name, $residente_name, $coordinador_id, $ingeniero_id, $residente_id);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }

    public function requestupdatesitiosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($post['latitude'] == "" ){
            $grados = $post['grados_lat'];
            $minutos = $post['min_lat'];
            $segundos = $post['seg_lat'];

            $dos_min = $minutos /60;
            $dos_seg = $segundos/3600;
            if($post['coordenada1'] == "s"){
                $latitud = $grados + $dos_min + $dos_seg;
                $latitude = "-".$latitud;
            }else{
                $latitude = $grados + $dos_min + $dos_seg;
            }

            $conversion_lat = 1;
                 
        }else{
            $latitude = $post['latitude'];
            $conversion_log = 0;
        }

        if($post['longitude'] == ""){
            $grados = $post['grados_lon'];
            $minutos = $post['min_lon'];
            $segundos = $post['seg_lon'];

            $dos_min = $minutos /60;
            $dos_seg = $segundos/3600;
                if($post['coordenada2'] == "o"){
                    $long = $grados + $dos_min + $dos_seg;
                    $longitude = "-".$long;
                }else{
                    $longitude = $grados + $dos_min + $dos_seg;
                }
            $conversion_lon = 1;
        }else{
            $longitude = $post['longitude'];
            $conversion_lon = 0;
        }   

        if($this->getRequest()->getPost()){
            $table="sitios";
            $result = $this->_season->refreshSitio($post,$longitude,$latitude,$table);
            if ($result) {
                return $this-> _redirect('/panel/sitios');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestupdatesitiosinfoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($post['latitude'] == "" ){
            $grados = $post['grados_lat'];
            $minutos = $post['min_lat'];
            $segundos = $post['seg_lat'];

            $dos_min = $minutos /60;
            $dos_seg = $segundos/3600;
            if($post['coordenada1'] == "s"){
                $latitud = $grados + $dos_min + $dos_seg;
                $latitude = "-".$latitud;
            }else{
                $latitude = $grados + $dos_min + $dos_seg;
            }

            $conversion_lat = 1;
                 
        }else{
            $latitude = $post['latitude'];
            $conversion_log = 0;
        }

        if($post['longitude'] == ""){
            $grados = $post['grados_lon'];
            $minutos = $post['min_lon'];
            $segundos = $post['seg_lon'];

            $dos_min = $minutos /60;
            $dos_seg = $segundos/3600;
                if($post['coordenada2'] == "o"){
                    $long = $grados + $dos_min + $dos_seg;
                    $longitude = "-".$long;
                }else{
                    $longitude = $grados + $dos_min + $dos_seg;
                }
            
            $conversion_lon = 1;
        }else{
            $longitude = $post['longitude'];
            $conversion_lon = 0;
        }   

        if($this->getRequest()->getPost()){
            $table="sitios";
            $result=$this->_season->refreshSitio($post,$longitude,$latitude,$table);

            if ($result) {
                return $this-> _redirect('/panel/sitiosdetail/id/'.$post['ids'].' ');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestupdateestructurasAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="estructura_sitio";
            $result = $this->_sitio->refreshEstructura($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/estructurasitios');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestupdatecomentariosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="comentarios_sitios";
            $result = $this->_sitio->Updatecomentario($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/detallesproyecto/id/'.$post['id'].'/proyecto/'.$post['proyecto'].'/sitio/'.$post['sitio'].' ');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestupdateproyectoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="tipo_proyecto";
            $result = $this->_season->refreshProyecto($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/tipoproyecto');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//REUQUEST EDIT USER

    public function requestupdatestatuseditAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="status_cliente";
            $id = $post['ids'];
            $result = $this->_sitio->refreshStatuscliente($post,$table,$id);
            if ($result) {
                return $this-> _redirect('/panel/statustipocliente/id/'.$post['tipo'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestupdatestatuscomprobacionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            $table="personal_campo";
            $id = $post['ids'];
            $result = $this->_user->refreshcomprobacionstatus($post,$table,$id);
            if ($result) {
                return $this-> _redirect('/panel/informaciongeneral/id/'.$post['ids'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    // -------------------   REQUEST EDIT RECOMENDACIONES----------------------------//
    public function requestupdaterecomendacionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);        
        if($this->getRequest()->getPost()){
            $post = $this->getRequest()->getPost();
            $table="recomendacion";
            $urldb = $post["imahidden"];
            if(!empty($_FILES["url"]["name"])) {
                $bytes = $_FILES['url']['size'];
                $res = $this->formatSizeUnits($bytes);
                if ($res == 0) {
                    print '<script language="JavaScript">'; 
                    print 'alert("La imagen supera el maximo de tamaño");'; 
                    print '</script>';
                } else {
                    $info = new SplFileInfo($_FILES['url']['name']);
                    $url = 'img/img_reco/';
                    $urldb = $url.$info;
                    unlink($post['imahidden']);
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }
            $result = $this->_reco->refreshRecomen($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/recomendaciones');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
            return $this-> _redirect('/panel/recomendaciones');
        }
    }

    public function requestupdatecotizacionsitioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);        
        if($this->getRequest()->getPost()){
        $post = $this->getRequest()->getPost();
        $id= $post['id'];
        $wh="id";
        $table="sitios";    
        $sitio = $this->_season->GetSpecific($table,$wh,$id);
        $nombre = $sitio[0]['nombre'];
        $table="cotizaciones_sitios";
        $urldb = $post["imahidden"];
            if(!empty($_FILES["url"]["name"])) {
                $bytes = $_FILES['url']['size'];
                $res = $this->formatSizeUnits($bytes);
                if ($res == 0) {
                    print '<script language="JavaScript">'; 
                    print 'alert("La imagen supera el maximo de tamaño");'; 
                    print '</script>';
                } else {
                    $info = new SplFileInfo($_FILES['url']['name']);
                    $url1 = 'pdf/sitios/'.$nombre.'/cotizacion/';   
                    $urldb = $url1.$info;
                    
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }
            $result = $this->_sitio->refreshcotizacionsitio($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/panel/cotizaciones/id/'.$post['id'].'/proyecto/'.$post['proyecto'].'/sitio/'.$post['sitio'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestdeleteallAction(){
    	$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->_hasParam('id')){
            $id =  $this->_getParam('id');
            $table="usuario";
            $wh="id";
            $result = $this->_season->deleteAll($id,$table,$wh);
            if ($result) {
                return $this-> _redirect('/panel/usuarios');
            }
        } else {
            return $this-> _redirect('/panel');
        }    
    }//END REQUEST DELETE TODO

    public function requestdeletealluserAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->_hasParam('id')){
            $id =  $this->_getParam('id');
            $table="usuario";
            $wh="id";
            $imagen=$this->_season->GetSpecific($table,$wh,$id);
            foreach ($imagen as $img => $val) {
                $url=$val['imagen'];
                
                if (file_exists($url)) {
                    unlink($url);
                    if (!empty($imagen)&&!empty($id)) {
                        $this->_season->deleteAll($id,$table,$wh);
                        return $this-> _redirect('/panel/usuarios');
                    }else {
                        return $this-> _redirect('/panel');
                    }   
                }else{
                    $this->_season->deleteAll($id,$table,$wh); 
                    return $this-> _redirect('/panel/error404');
                }               
            }   
        }
    }

    public function requestdeleteproveedorAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->_hasParam('id')){
            $id =  $this->_getParam('id');
            $table="proveedor";
            $wh="id";
            $result = $this->_season->deleteAll($id,$table,$wh);
            if ($result) {
                return $this-> _redirect('/panel/proveedores');
            }
        } else {
            return $this-> _redirect('/panel');
        }    
    }//END REQUEST DELETE TODO

    public function requestdeletecomentariositioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="detalle_comentarios";
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

    public function requestdeletecomentariotorrenuevaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="torrenueva_comentarioavance";
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


    public function requestdeletecotizacionsitioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="cotizaciones_sitios";
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

    public function requestdeletefilealtanAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $url= $post['file'];
            unlink($url);
            $id =  $post['id'];
            $table="altan_file";
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

    public function requestdeleteestructuraAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->_hasParam('id')){
            $id =  $this->_getParam('id');
            $table="estructura_sitio";
            $wh="id";
            $result = $this->_season->deleteAll($id,$table,$wh);
            if ($result) {
                return $this-> _redirect('/panel/estructurasitios');
            }
        } else {
            return $this-> _redirect('/panel');
        }      
    }

    public function requestdeleteallsitiosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->_hasParam('id')){
            $id =  $this->_getParam('id');
            $table="sitios";
            $wh="id";
            $result = $this->_season->deleteAll($id,$table,$wh);
            if ($result) {
                return $this-> _redirect('/panel/sitios');
            }
        } else {
            return $this-> _redirect('/panel');
        }    
    }//END REQUEST DELETE TODO

    public function requestdeletecomentarioproyectoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->_hasParam('comentario')){
            $comentario =  $this->_getParam('comentario');
            $id= $this->_getParam('id');
            $proyecto= $this->_getParam('proyecto');
            $sitio= $this->_getParam('sitio');
            $table="comentarios_sitios";
            $wh="id";
            $result = $this->_season->deleteAll($comentario,$table,$wh);
            if ($result) {
                return $this-> _redirect('/panel/detallesproyecto/id/'.$id.'/proyecto/'.$proyecto.'/sitio/'.$sitio.'');
            }
        } else {
            return $this-> _redirect('/panel');
        }    
    }//END REQUEST DELETE TODO


    public function requestdeleteproyectoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->_hasParam('id')){
            $id =  $this->_getParam('id');
            $table="tipo_proyecto";
            $wh="id";
            $result = $this->_season->deleteAll($id,$table,$wh);
            if ($result) {
                return $this-> _redirect('/panel/tipoproyecto');
            }
        } else {
            return $this-> _redirect('/panel');
        }    
    }//END REQUEST DELETE TODO


    public function requestdeletestatusclienteAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="status_cliente";
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

    public function requestdeletestatusproyectoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="status_proyecto";
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

    public function requestdeletependienteAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="solicitudes_pendientes";
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

    // public function requestsearchnombreAction(){
    //     $this->_helper->layout()->disableLayout();
    //     $this->_helper->viewRenderer->setNoRender(true);  
    //     $post = $this->getRequest()->getPost();
    //     var_dump($post);exit;
    //     if($this->getRequest()->getPost()){
    //         $table="tipo_proyecto";
    //         $result = $this->_season->refreshProyecto($post,$table);

    //     }
    // }


     // ----------------------------   REQUEST DELETE TARJETAS------------------------------//

    // public function requestdeleteproductAction(){
    //     $this->_helper->layout()->disableLayout();
    //     $this->_helper->viewRenderer->setNoRender(true);
    //     if($this->_hasParam('id')){
    //         $id =  $this->_getParam('id');
    //         $table="producto";
    //         $wh="id";
    //         $imagen=$this->_pro->GetSpecific($table,$wh,$id);
    //         foreach ($imagen as $img => $val) {
    //             $url=$val['imagen'];
                
    //             if (file_exists($url)) {
    //                 unlink($url);
    //                 if (!empty($imagen)&&!empty($id)) {
    //                     $this->_pro->deleteAll($id,$table,$wh);
    //                     return $this-> _redirect('/panel/productos');
    //                 }else {
    //                     return $this-> _redirect('/panel');
    //                 }   
    //             }else{
    //                 $this->_pro->deleteAll($id,$table,$wh);
    //                 print '<script language="JavaScript">'; 
    //                 print 'alert("La imagen en el servidor no existe");'; 
    //                 print '</script>';
    //                 print '<a href="/panel/productos">Regresar a productos</a>"'; 
    //             }               
    //         }
    //     }   
    // }

     // ----------------------------   REQUEST DELETE SLIDER------------------------------//



    // --------------------   REQUEST ADD FLORES TEMPORADA	-----------------------//


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

}//FINAL DEL PANEL