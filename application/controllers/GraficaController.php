<?php
class GraficaController extends Zend_Controller_Action{
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
        $this->_archivo = new Application_Model_GpsArchivosModel;

        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }
        
    }

    public function btsprojectAction(){

        $cot_id=$this->_getParam('sitio');
        $table="cotizaciones_sitios";
        $wh="sitio_id";
        $cotizacion = $this->_season->GetSpecific($table,$wh,$cot_id);
        $suma = 0;
        foreach ($cotizacion as $key) {
            $suma = $suma + $key['total'];
        }
        $this->view->suma_cotizacion = $suma;


        $po_id=$this->_getParam('sitio');
        $table="cotizaciones_sitiospo";
        $wh="id_sitiopo";
        $po = $this->_season->GetSpecific($table,$wh,$po_id);
        $suma = 0;
        if($po){
            foreach ($po as $key) {
                $suma = $suma + $key['monto'];
            }
        }else{
            $suma = 0;
        }
        $this->view->suma_po = $suma;

        $id=$this->_getParam('id');
        $this->view->id=$id;
        $table="sitios";
        $wh="id";
        $sitio_name= $this->view->sitio = $this->_season->GetSpecific($table,$wh,$id);


        $table="sitios";
        $wh="id";
        $ver=$this->_season->GetSpecific($table,$wh,$id);
        $estructura = $ver[0]['estructura'];
        $table="estructura_sitio";
        $wh="id";
        $dos=$this->view->estructura = $this->_season->GetSpecific($table,$wh,$estructura);

        $sitio=$this->_getParam('id');
        $proyecto=$this->_getParam('proyecto');
        $this->view->tipo_sitio = $this->_sitio->GettipoproyectoDetalles($id);


        $table="tipo_proyecto";
        $wh="id";
        $this->view->nombreproyecto = $this->_season->GetSpecific($table,$wh,$proyecto);

        $table="status_cliente";
        $wh="tipo_proyecto";
        $this->view->statuscliente = $this->_season->GetSpecific($table,$wh,$proyecto);

        $table="status_proyecto";
        $wh="tipo_proyecto";
        $this->view->status = $this->_season->GetSpecific($table,$wh,$proyecto);


        $user=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$user);
        foreach ($usr as $key) {
            $fk=$key['fkroles'];
        }
        $this->view->rol_user=$fk;


        // DOCUMENTACIÓN 1 
            $sitio=$this->_getParam('sitio');
            $wh="id_sitiotipo";
            $table="detalle_bts";
            $sit = $this->_season->GetSpecific($table,$wh,$sitio);

            if(empty($sit)){
                $condicion_bts = 0; // Vacion
                $this->view->condicion_bts = $condicion_bts;
            }else{
                $condicion_bts = 1; // Con datos
                $this->view->condicion_bts = $condicion_bts;
                $this->view->docu_uno = $this->_season->GetSpecific($table,$wh,$sitio);
            }

            $sitio=$this->_getParam('sitio');
            $wh="id_sitiotipo";
            $table="detalle_btspdf";
            $file = $this->_season->GetSpecific($table,$wh,$sitio);

            if(empty($file)){
                $bts_archivo = 0; // Vacion
                $this->view->bts_archivo = $bts_archivo;
            }else{
                $bts_archivo = 1; // Con datos
                $this->view->bts_archivo = $bts_archivo;
                $this->view->docu_unofile = $this->_season->GetSpecific($table,$wh,$sitio);
            }
        // END DOCUMENTACIÓN 1

        // SEMANA UNO BTS
            $wh="idsitio_tipo";
            $table="semanauno_bts";
            $wk1 = $this->_season->GetSpecific($table,$wh,$sitio);
            if(empty($wk1)){
                $semana_uno = 0; // Vacion
                $this->view->semana_uno = $semana_uno;
            }else{
                $semana_uno = 1; // Con datos
                $this->view->semana_uno = $semana_uno;
                $wk11= $this->view->semana_btsuno = $this->_season->GetSpecific($table,$wh,$sitio);
            }

            $tipo = $this->_getParam('sitio');
            $this->view->ev_wkuno = $this->_season->GetSpecific($table,$wh,$tipo);
        // END SEMANA UNO 

        // SEMANA DOS BTS
            $wh="idsitio_tipo";
            $table="semanados_bts";
            $wk2 = $this->_season->GetSpecific($table,$wh,$sitio);
            if(empty($wk2)){
                $semana_dos = 0; // Vacion
                $this->view->semana_dos = $semana_dos;
            }else{
                $semana_dos = 1; // Con datos
                $this->view->semana_dos = $semana_dos;
                $wk11= $this->view->semana_btsdos = $this->_season->GetSpecific($table,$wh,$sitio);
            }   
            $table="semanados_bts";
            $this->view->ev_wkdos = $this->_season->GetSpecific($table,$wh,$tipo);

        // END SEMANA DOS 

        // SEMANA TRES BTS
            $wh="idsitio_tipo";
            $table="semanatres_bts";
            $wk3 = $this->_season->GetSpecific($table,$wh,$sitio);
            if(empty($wk3)){
                $semana_tres = 0; // Vacion
                $this->view->semana_tres = $semana_tres;
            }else{
                $semana_tres = 1; // Con datos
                $this->view->semana_tres = $semana_tres;
                $wk11= $this->view->semana_btstres = $this->_season->GetSpecific($table,$wh,$sitio);
            }   

            $table="semanatres_bts";
            $this->view->ev_wktres = $this->_season->GetSpecific($table,$wh,$tipo);
        // END SEMANA TRES 

        // SEMANA CUATRO BTS
            $wh="idsitio_tipo";
            $table="semanacuatro_bts";
            $wk4 = $this->_season->GetSpecific($table,$wh,$sitio);
            if(empty($wk4)){
                $semana_cuatro = 0; // Vacion
                $this->view->semana_cuatro = $semana_cuatro;
            }else{
                $semana_cuatro = 1; // Con datos
                $this->view->semana_cuatro = $semana_cuatro;
                $wk11= $this->view->semana_btscuatro = $this->_season->GetSpecific($table,$wh,$sitio);
            }   

            $table="semanacuatro_bts";
            $this->view->ev_wkcuatro = $this->_season->GetSpecific($table,$wh,$tipo);
        // END SEMANA CUATRO 

            $sitio=$this->_getParam('sitio');
            $this->view->id_sitio=$sitio;
            $wh="id_sitiotipo";
            $table="detalle_btsdos";
            $sitdos = $this->_season->GetSpecific($table,$wh,$sitio);

            if(empty($sitdos)){
                $condiciondos_bts = 0; // Vacion
                $this->view->condiciondos_bts = $condiciondos_bts;
            }else{
                $condiciondos_bts = 1; // Con datos
                $this->view->condiciondos_bts = $condiciondos_bts;
                $this->view->docu_dos = $this->_season->GetSpecific($table,$wh,$sitio);
            }


            $wh="id_sitiotipo";
            $table="detalle_btspdfdos";
            $file_dos = $this->_season->GetSpecific($table,$wh,$sitio);

            if(empty($file_dos)){
                $bts_archivodos = 0; // Vacion
                $this->view->bts_archivodos = $bts_archivodos;
            }else{
                $bts_archivodos = 1; // Con datos
                $this->view->bts_archivodos = $bts_archivodos;
                $ver = $this->view->docu_dosfile = $this->_season->GetSpecific($table,$wh,$sitio);
                // var_dump($ver);exit;
            }

        // END DOCUMENTACIÓN 2
        $sitio=$this->_getParam('sitio');
        $year=2021;
        $this->view->year_op = $year;
        $month = "1";
        $enero = $this->view->enero=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_enero=count($enero);

        $month = "2";
        $febrero = $this->view->febrero=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);        
        $this->view->count_febreo=count($febrero);

        $month = "3";
        $marzo = $this->view->marzo=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_marzo=count($marzo);

        $month = "4";
        $abril = $this->view->abril=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_abril=count($abril);   

        $month = "5";
        $mayo = $this->view->mayo=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio); 
        $this->view->count_mayo=count($mayo);  

        $month = "6";
        $junio = $this->view->junio=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);   
        $this->view->count_junio=count($junio);

        $month = "7";
        $julio = $this->view->julio=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio); 
        $this->view->count_julio=count($julio);  

        $month = "8";
        $agosto = $this->view->agosto=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_agosto=count($agosto);   

        $month = "9";
        $septiembre = $this->view->septiembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_septiembre=count($septiembre);   

        $month = "10";
        $octubre = $this->view->octubre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);  
        $this->view->count_octubre=count($octubre); 

        $month = "11";
        $noviembre = $this->view->noviembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_noviembre=count($noviembre);   

        $month = "12";
        $diciembre = $this->view->diciembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);  
        $this->view->count_diciembre=count($diciembre);

        //  G A S O L I N A
        $month= 1;
        $gas_enero = $this->view->gas_enero=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasenero = count($gas_enero);
        $month= 2;
        $gas_febrero = $this->view->gas_febrero=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasfebrero = count($gas_febrero);
        $month= 3;
        $gas_marzo = $this->view->gas_marzo=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasmarzo = count($gas_marzo);
        $month= 4;
        $gas_abril = $this->view->gas_abril=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasabril = count($gas_abril);
        $month= 5;
        $gas_mayo = $this->view->gas_mayo=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasmayo = count($gas_mayo);
        $month= 6;
        $gas_junio = $this->view->gas_junio=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasjunio = count($gas_junio);
        $month= 7;
        $gas_julio = $this->view->gas_julio=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasjulio = count($gas_julio);
        $month= 8;
        $gas_agosto = $this->view->gas_agosto=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasagosto = count($gas_agosto);
        $month= 9;
        $gas_septiembre = $this->view->gas_septiembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasseptiembre = count($gas_septiembre);
        $month= 10;
        $gas_octubre = $this->view->gas_octubre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasoctubre = count($gas_octubre);
        $month= 11;
        $gas_noviembre = $this->view->gas_noviembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasnoviembre = count($gas_noviembre);
        $month= 12;
        $gas_diciembre = $this->view->gas_diciembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasdiciembre = count($gas_diciembre);

        // C A J A   C H I C A
        $month= 1;
        $cajachica_enero = $this->view->cajachica_enero=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaenero = count($cajachica_enero);
        $month= 2;
        $cajachica_febrero = $this->view->cajachica_febrero=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicafebrero = count($cajachica_febrero);
        $month= 3;
        $cajachica_marzo = $this->view->cajachica_marzo=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicamarzo = count($cajachica_marzo);
        $month= 4;
        $cajachica_abril = $this->view->cajachica_abril=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaabril = count($cajachica_abril);
        $month= 5;
        $cajachica_mayo = $this->view->cajachica_mayo=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicamayo = count($cajachica_mayo);
        $month= 6;
        $cajachica_junio = $this->view->cajachica_junio=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicajunio = count($cajachica_junio);
        $month= 7;
        $cajachica_julio = $this->view->cajachica_julio=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicajulio = count($cajachica_julio);
        $month= 8;
        $cajachica_agosto = $this->view->cajachica_agosto=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaagosto = count($cajachica_agosto);
        $month= 9;
        $cajachica_septiembre = $this->view->cajachica_septiembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaseptiembre = count($cajachica_septiembre);
        $month= 10;
        $cajachica_octubre = $this->view->cajachica_octubre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaoctubre = count($cajachica_octubre);
        $month= 11;
        $cajachica_noviembre = $this->view->cajachica_noviembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachica_noviembre = count($cajachica_noviembre);
        $month= 12;
        $cajachica_diciembre = $this->view->cajachicadiciembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicadiciembre = count($cajachica_diciembre);


        $month= 1;
        $nomina_enero=$this->view->nomina_enero=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaenero = count($nomina_enero);

        $month= 2;
        $nomina_febrero=$this->view->nomina_febrero=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominafebrero = count($nomina_febrero);

        $month= 3;
        $nomina_marzo=$this->view->nomina_marzo=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominamarzo = count($nomina_marzo);

        $month= 4;
        $nomina_abril=$this->view->nomina_abril=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaabril = count($nomina_abril);

        $month= 5;
        $nomina_mayo=$this->view->nomina_mayo=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominamayo = count($nomina_mayo);

        $month= 6;
        $nomina_junio=$this->view->nomina_junio=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominajunio = count($nomina_junio);

        $month= 7;
        $nomina_julio=$this->view->nomina_julio=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominajulio = count($nomina_julio);

        $month= 8;
        $nomina_agosto=$this->view->nomina_agosto=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaagosto = count($nomina_agosto);

        $month= 9;
        $nomina_septiembre=$this->view->nomina_septiembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaseptiembre = count($nomina_septiembre);

        $month= 10;
        $nomina_octubre=$this->view->nomina_octubre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaoctubre = count($nomina_octubre);

        $month= 11;
        $nomina_noviembre=$this->view->nomina_noviembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominanoviembre = count($nomina_noviembre);

        $month= 12;
        $nomina_diciembre=$this->view->nomina_diciembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominadiciembre = count($nomina_diciembre);

                  // T A G  C O N S U M O S
        $month= 1;
        $tag_enero = $this->view->tag_enero = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagenero = count($tag_enero);

        $month= 2;
        $tag_febrero = $this->view->tag_febrero = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagfebrero = count($tag_febrero);

        $month= 3;
        $tag_marzo = $this->view->tag_marzo = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagmarzo = count($tag_marzo);

        $month= 4;
        $tag_abril = $this->view->tag_abril = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagabril = count($tag_abril);

        $month= 5;
        $tag_mayo = $this->view->tag_mayo = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagmayo = count($tag_mayo);

        $month= 6;
        $tag_junio = $this->view->tag_junio = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagjunio = count($tag_junio);

        $month= 7;
        $tag_julio = $this->view->tag_julio = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagjulio = count($tag_julio);

        $month= 8;
        $tag_agosto = $this->view->tag_agosto = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagagosto = count($tag_agosto);

        $month= 9;
        $tag_septiembre = $this->view->tag_septiembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagseptiembre = count($tag_septiembre);

        $month= 10;
        $tag_octubre = $this->view->tag_octubre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagoctubre = count($tag_octubre);

        $month= 11;
        $tag_noviembre = $this->view->tag_noviembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagnoviembre = count($tag_noviembre);

        $month= 12;
        $tag_diciembre = $this->view->tag_diciembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagdiciembre = count($tag_diciembre);

        // E N D  T A G  C O N S U M O S

                // V I A T I C O S   G A S T O S 
        
        $month= 1;
        $viaticos_enero = $this->view->viaticos_enero = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosenero = count($viaticos_enero);

        $month= 2;
        $viaticos_febrero = $this->view->viaticos_febrero = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosfebrero = count($viaticos_febrero);

        $month= 3;
        $viaticos_marzo = $this->view->viaticos_marzo = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosmarzo = count($viaticos_marzo);

        $month= 4;
        $viaticos_abril = $this->view->viaticos_abril = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosabril = count($viaticos_abril);

        $month= 5;
        $viaticos_mayo = $this->view->viaticos_mayo = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosmayo = count($viaticos_mayo);

        $month= 6;
        $viaticos_junio = $this->view->viaticos_junio = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosjunio = count($viaticos_junio);

        $month= 7;
        $viaticos_julio = $this->view->viaticos_julio = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosjulio = count($viaticos_julio);

        $month= 8;
        $viaticos_agosto = $this->view->viaticos_agosto = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosagosto = count($viaticos_agosto);

        $month= 9;
        $viaticos_septiembre = $this->view->viaticos_septiembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosseptiembre = count($viaticos_septiembre);

        $month= 10;
        $viaticos_octubre = $this->view->viaticos_octubre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosoctubre = count($viaticos_octubre);

        $month= 11;
        $viaticos_noviembre = $this->view->viaticos_noviembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosnoviembre = count($viaticos_noviembre);

        $month= 12;
        $viaticos_diciembre = $this->view->viaticos_diciembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosdiciembre = count($viaticos_diciembre);
        
        // E N D  V I A T I C O S   G A S T O S 

        // F A C T U R A S
        $this->view->cajachica_factura = $this->_comprobacion->getmesfacturapanelsitio($sitio);

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->rol_user = $usr[0]['fkroles']; 
    }

    public function reforzamientoprojectAction(){
        $cot_id=$this->_getParam('sitio');
        $table="cotizaciones_sitios";
        $wh="sitio_id";
        $cotizacion = $this->_season->GetSpecific($table,$wh,$cot_id);
        $suma = 0;
        foreach ($cotizacion as $key) {
            $suma = $suma + $key['total'];
        }
        $this->view->suma_cotizacion = $suma;


        $po_id=$this->_getParam('sitio');
        $table="cotizaciones_sitiospo";
        $wh="id_sitiopo";
        $po = $this->_season->GetSpecific($table,$wh,$po_id);
        $suma = 0;
        if($po){
            foreach ($po as $key) {
                $suma = $suma + $key['monto'];
            }
        }else{
            $suma = 0;
        }
        $this->view->suma_po = $suma;


        $sitio=$this->_getParam('sitio');
        $year=2021;
        $this->view->year_op = $year;
        $month = "1";
        $enero = $this->view->enero=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_enero=count($enero);

        $month = "2";
        $febrero = $this->view->febrero=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);        
        $this->view->count_febreo=count($febrero);

        $month = "3";
        $marzo = $this->view->marzo=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_marzo=count($marzo);

        $month = "4";
        $abril = $this->view->abril=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_abril=count($abril);   

        $month = "5";
        $mayo = $this->view->mayo=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio); 
        $this->view->count_mayo=count($mayo);  

        $month = "6";
        $junio = $this->view->junio=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);   
        $this->view->count_junio=count($junio);

        $month = "7";
        $julio = $this->view->julio=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio); 
        $this->view->count_julio=count($julio);  

        $month = "8";
        $agosto = $this->view->agosto=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_agosto=count($agosto);   

        $month = "9";
        $septiembre = $this->view->septiembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_septiembre=count($septiembre);   

        $month = "10";
        $octubre = $this->view->octubre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);  
        $this->view->count_octubre=count($octubre); 

        $month = "11";
        $noviembre = $this->view->noviembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_noviembre=count($noviembre);   

        $month = "12";
        $diciembre = $this->view->diciembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);  
        $this->view->count_diciembre=count($diciembre);


        //  G A S O L I N A
        $month= 1;
        $gas_enero = $this->view->gas_enero=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasenero = count($gas_enero);
        $month= 2;
        $gas_febrero = $this->view->gas_febrero=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasfebrero = count($gas_febrero);
        $month= 3;
        $gas_marzo = $this->view->gas_marzo=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasmarzo = count($gas_marzo);
        $month= 4;
        $gas_abril = $this->view->gas_abril=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasabril = count($gas_abril);
        $month= 5;
        $gas_mayo = $this->view->gas_mayo=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasmayo = count($gas_mayo);
        $month= 6;
        $gas_junio = $this->view->gas_junio=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasjunio = count($gas_junio);
        $month= 7;
        $gas_julio = $this->view->gas_julio=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasjulio = count($gas_julio);
        $month= 8;
        $gas_agosto = $this->view->gas_agosto=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasagosto = count($gas_agosto);
        $month= 9;
        $gas_septiembre = $this->view->gas_septiembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasseptiembre = count($gas_septiembre);
        $month= 10;
        $gas_octubre = $this->view->gas_octubre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasoctubre = count($gas_octubre);
        $month= 11;
        $gas_noviembre = $this->view->gas_noviembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasnoviembre = count($gas_noviembre);
        $month= 12;
        $gas_diciembre = $this->view->gas_diciembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasdiciembre = count($gas_diciembre);

        // C A J A   C H I C A
        $month= 1;
        $cajachica_enero = $this->view->cajachica_enero=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaenero = count($cajachica_enero);
        $month= 2;
        $cajachica_febrero = $this->view->cajachica_febrero=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicafebrero = count($cajachica_febrero);
        $month= 3;
        $cajachica_marzo = $this->view->cajachica_marzo=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicamarzo = count($cajachica_marzo);
        $month= 4;
        $cajachica_abril = $this->view->cajachica_abril=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaabril = count($cajachica_abril);
        $month= 5;
        $cajachica_mayo = $this->view->cajachica_mayo=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicamayo = count($cajachica_mayo);
        $month= 6;
        $cajachica_junio = $this->view->cajachica_junio=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicajunio = count($cajachica_junio);
        $month= 7;
        $cajachica_julio = $this->view->cajachica_julio=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicajulio = count($cajachica_julio);
        $month= 8;
        $cajachica_agosto = $this->view->cajachica_agosto=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaagosto = count($cajachica_agosto);
        $month= 9;
        $cajachica_septiembre = $this->view->cajachica_septiembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaseptiembre = count($cajachica_septiembre);
        $month= 10;
        $cajachica_octubre = $this->view->cajachica_octubre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaoctubre = count($cajachica_octubre);
        $month= 11;
        $cajachica_noviembre = $this->view->cajachica_noviembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachica_noviembre = count($cajachica_noviembre);
        $month= 12;
        $cajachica_diciembre = $this->view->cajachicadiciembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicadiciembre = count($cajachica_diciembre);


        $month= 1;
        $nomina_enero=$this->view->nomina_enero=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaenero = count($nomina_enero);

        $month= 2;
        $nomina_febrero=$this->view->nomina_febrero=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominafebrero = count($nomina_febrero);

        $month= 3;
        $nomina_marzo=$this->view->nomina_marzo=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominamarzo = count($nomina_marzo);

        $month= 4;
        $nomina_abril=$this->view->nomina_abril=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaabril = count($nomina_abril);

        $month= 5;
        $nomina_mayo=$this->view->nomina_mayo=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominamayo = count($nomina_mayo);

        $month= 6;
        $nomina_junio=$this->view->nomina_junio=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominajunio = count($nomina_junio);

        $month= 7;
        $nomina_julio=$this->view->nomina_julio=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominajulio = count($nomina_julio);

        $month= 8;
        $nomina_agosto=$this->view->nomina_agosto=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaagosto = count($nomina_agosto);

        $month= 9;
        $nomina_septiembre=$this->view->nomina_septiembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaseptiembre = count($nomina_septiembre);

        $month= 10;
        $nomina_octubre=$this->view->nomina_octubre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaoctubre = count($nomina_octubre);

        $month= 11;
        $nomina_noviembre=$this->view->nomina_noviembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominanoviembre = count($nomina_noviembre);

        $month= 12;
        $nomina_diciembre=$this->view->nomina_diciembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominadiciembre = count($nomina_diciembre);


          // T A G  C O N S U M O S
        $month= 1;
        $tag_enero = $this->view->tag_enero = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagenero = count($tag_enero);

        $month= 2;
        $tag_febrero = $this->view->tag_febrero = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagfebrero = count($tag_febrero);

        $month= 3;
        $tag_marzo = $this->view->tag_marzo = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagmarzo = count($tag_marzo);

        $month= 4;
        $tag_abril = $this->view->tag_abril = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagabril = count($tag_abril);

        $month= 5;
        $tag_mayo = $this->view->tag_mayo = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagmayo = count($tag_mayo);

        $month= 6;
        $tag_junio = $this->view->tag_junio = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagjunio = count($tag_junio);

        $month= 7;
        $tag_julio = $this->view->tag_julio = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagjulio = count($tag_julio);

        $month= 8;
        $tag_agosto = $this->view->tag_agosto = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagagosto = count($tag_agosto);

        $month= 9;
        $tag_septiembre = $this->view->tag_septiembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagseptiembre = count($tag_septiembre);

        $month= 10;
        $tag_octubre = $this->view->tag_octubre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagoctubre = count($tag_octubre);

        $month= 11;
        $tag_noviembre = $this->view->tag_noviembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagnoviembre = count($tag_noviembre);

        $month= 12;
        $tag_diciembre = $this->view->tag_diciembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagdiciembre = count($tag_diciembre);

        // E N D  T A G  C O N S U M O S

        // V I A T I C O S   G A S T O S 
        
        $month= 1;
        $viaticos_enero = $this->view->viaticos_enero = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosenero = count($viaticos_enero);

        $month= 2;
        $viaticos_febrero = $this->view->viaticos_febrero = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosfebrero = count($viaticos_febrero);

        $month= 3;
        $viaticos_marzo = $this->view->viaticos_marzo = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosmarzo = count($viaticos_marzo);

        $month= 4;
        $viaticos_abril = $this->view->viaticos_abril = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosabril = count($viaticos_abril);

        $month= 5;
        $viaticos_mayo = $this->view->viaticos_mayo = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosmayo = count($viaticos_mayo);

        $month= 6;
        $viaticos_junio = $this->view->viaticos_junio = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosjunio = count($viaticos_junio);

        $month= 7;
        $viaticos_julio = $this->view->viaticos_julio = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosjulio = count($viaticos_julio);

        $month= 8;
        $viaticos_agosto = $this->view->viaticos_agosto = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosagosto = count($viaticos_agosto);

        $month= 9;
        $viaticos_septiembre = $this->view->viaticos_septiembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosseptiembre = count($viaticos_septiembre);

        $month= 10;
        $viaticos_octubre = $this->view->viaticos_octubre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosoctubre = count($viaticos_octubre);

        $month= 11;
        $viaticos_noviembre = $this->view->viaticos_noviembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosnoviembre = count($viaticos_noviembre);

        $month= 12;
        $viaticos_diciembre = $this->view->viaticos_diciembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosdiciembre = count($viaticos_diciembre);
        
        // E N D  V I A T I C O S   G A S T O S 

        // F A C T U R A S
        $this->view->cajachica_factura = $this->_comprobacion->getmesfacturapanelsitio($sitio);

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->rol_user = $usr[0]['fkroles'];           
    }


    public function colocacionprojectAction(){
        $cot_id=$this->_getParam('sitio');
        $table="cotizaciones_sitios";
        $wh="sitio_id";
        $cotizacion = $this->_season->GetSpecific($table,$wh,$cot_id);
        $suma = 0;
        foreach ($cotizacion as $key) {
            $suma = $suma + $key['total'];
        }
        $this->view->suma_cotizacion = $suma;


        $po_id=$this->_getParam('sitio');
        $table="cotizaciones_sitiospo";
        $wh="id_sitiopo";
        $po = $this->_season->GetSpecific($table,$wh,$po_id);
        $suma = 0;
        if($po){
            foreach ($po as $key) {
                $suma = $suma + $key['monto'];
            }
        }else{
            $suma = 0;
        }
        $this->view->suma_po = $suma;

        $sitio=$this->_getParam('sitio');
        $year=2021;
        $this->view->year_op = $year;
        $month = "1";
        $enero = $this->view->enero=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_enero=count($enero);

        $month = "2";
        $febrero = $this->view->febrero=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);        
        $this->view->count_febreo=count($febrero);

        $month = "3";
        $marzo = $this->view->marzo=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_marzo=count($marzo);

        $month = "4";
        $abril = $this->view->abril=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_abril=count($abril);   

        $month = "5";
        $mayo = $this->view->mayo=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio); 
        $this->view->count_mayo=count($mayo);  

        $month = "6";
        $junio = $this->view->junio=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);   
        $this->view->count_junio=count($junio);

        $month = "7";
        $julio = $this->view->julio=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio); 
        $this->view->count_julio=count($julio);  

        $month = "8";
        $agosto = $this->view->agosto=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_agosto=count($agosto);   

        $month = "9";
        $septiembre = $this->view->septiembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_septiembre=count($septiembre);   

        $month = "10";
        $octubre = $this->view->octubre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);  
        $this->view->count_octubre=count($octubre); 

        $month = "11";
        $noviembre = $this->view->noviembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_noviembre=count($noviembre);   

        $month = "12";
        $diciembre = $this->view->diciembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);  
        $this->view->count_diciembre=count($diciembre);


        //  G A S O L I N A
        $month= 1;
        $gas_enero = $this->view->gas_enero=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasenero = count($gas_enero);
        $month= 2;
        $gas_febrero = $this->view->gas_febrero=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasfebrero = count($gas_febrero);
        $month= 3;
        $gas_marzo = $this->view->gas_marzo=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasmarzo = count($gas_marzo);
        $month= 4;
        $gas_abril = $this->view->gas_abril=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasabril = count($gas_abril);
        $month= 5;
        $gas_mayo = $this->view->gas_mayo=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasmayo = count($gas_mayo);
        $month= 6;
        $gas_junio = $this->view->gas_junio=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasjunio = count($gas_junio);
        $month= 7;
        $gas_julio = $this->view->gas_julio=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasjulio = count($gas_julio);
        $month= 8;
        $gas_agosto = $this->view->gas_agosto=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasagosto = count($gas_agosto);
        $month= 9;
        $gas_septiembre = $this->view->gas_septiembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasseptiembre = count($gas_septiembre);
        $month= 10;
        $gas_octubre = $this->view->gas_octubre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasoctubre = count($gas_octubre);
        $month= 11;
        $gas_noviembre = $this->view->gas_noviembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasnoviembre = count($gas_noviembre);
        $month= 12;
        $gas_diciembre = $this->view->gas_diciembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasdiciembre = count($gas_diciembre);

        // C A J A   C H I C A
        $month= 1;
        $cajachica_enero = $this->view->cajachica_enero=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaenero = count($cajachica_enero);
        $month= 2;
        $cajachica_febrero = $this->view->cajachica_febrero=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicafebrero = count($cajachica_febrero);
        $month= 3;
        $cajachica_marzo = $this->view->cajachica_marzo=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicamarzo = count($cajachica_marzo);
        $month= 4;
        $cajachica_abril = $this->view->cajachica_abril=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaabril = count($cajachica_abril);
        $month= 5;
        $cajachica_mayo = $this->view->cajachica_mayo=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicamayo = count($cajachica_mayo);
        $month= 6;
        $cajachica_junio = $this->view->cajachica_junio=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicajunio = count($cajachica_junio);
        $month= 7;
        $cajachica_julio = $this->view->cajachica_julio=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicajulio = count($cajachica_julio);
        $month= 8;
        $cajachica_agosto = $this->view->cajachica_agosto=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaagosto = count($cajachica_agosto);
        $month= 9;
        $cajachica_septiembre = $this->view->cajachica_septiembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaseptiembre = count($cajachica_septiembre);
        $month= 10;
        $cajachica_octubre = $this->view->cajachica_octubre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaoctubre = count($cajachica_octubre);
        $month= 11;
        $cajachica_noviembre = $this->view->cajachica_noviembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachica_noviembre = count($cajachica_noviembre);
        $month= 12;
        $cajachica_diciembre = $this->view->cajachicadiciembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicadiciembre = count($cajachica_diciembre);


        $month= 1;
        $nomina_enero=$this->view->nomina_enero=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaenero = count($nomina_enero);

        $month= 2;
        $nomina_febrero=$this->view->nomina_febrero=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominafebrero = count($nomina_febrero);

        $month= 3;
        $nomina_marzo=$this->view->nomina_marzo=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominamarzo = count($nomina_marzo);

        $month= 4;
        $nomina_abril=$this->view->nomina_abril=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaabril = count($nomina_abril);

        $month= 5;
        $nomina_mayo=$this->view->nomina_mayo=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominamayo = count($nomina_mayo);

        $month= 6;
        $nomina_junio=$this->view->nomina_junio=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominajunio = count($nomina_junio);

        $month= 7;
        $nomina_julio=$this->view->nomina_julio=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominajulio = count($nomina_julio);

        $month= 8;
        $nomina_agosto=$this->view->nomina_agosto=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaagosto = count($nomina_agosto);

        $month= 9;
        $nomina_septiembre=$this->view->nomina_septiembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaseptiembre = count($nomina_septiembre);

        $month= 10;
        $nomina_octubre=$this->view->nomina_octubre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaoctubre = count($nomina_octubre);

        $month= 11;
        $nomina_noviembre=$this->view->nomina_noviembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominanoviembre = count($nomina_noviembre);

        $month= 12;
        $nomina_diciembre=$this->view->nomina_diciembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominadiciembre = count($nomina_diciembre);


          // T A G  C O N S U M O S
        $month= 1;
        $tag_enero = $this->view->tag_enero = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagenero = count($tag_enero);

        $month= 2;
        $tag_febrero = $this->view->tag_febrero = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagfebrero = count($tag_febrero);

        $month= 3;
        $tag_marzo = $this->view->tag_marzo = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagmarzo = count($tag_marzo);

        $month= 4;
        $tag_abril = $this->view->tag_abril = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagabril = count($tag_abril);

        $month= 5;
        $tag_mayo = $this->view->tag_mayo = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagmayo = count($tag_mayo);

        $month= 6;
        $tag_junio = $this->view->tag_junio = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagjunio = count($tag_junio);

        $month= 7;
        $tag_julio = $this->view->tag_julio = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagjulio = count($tag_julio);

        $month= 8;
        $tag_agosto = $this->view->tag_agosto = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagagosto = count($tag_agosto);

        $month= 9;
        $tag_septiembre = $this->view->tag_septiembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagseptiembre = count($tag_septiembre);

        $month= 10;
        $tag_octubre = $this->view->tag_octubre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagoctubre = count($tag_octubre);

        $month= 11;
        $tag_noviembre = $this->view->tag_noviembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagnoviembre = count($tag_noviembre);

        $month= 12;
        $tag_diciembre = $this->view->tag_diciembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagdiciembre = count($tag_diciembre);

        // E N D  T A G  C O N S U M O S

                // V I A T I C O S   G A S T O S 
        
        $month= 1;
        $viaticos_enero = $this->view->viaticos_enero = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosenero = count($viaticos_enero);

        $month= 2;
        $viaticos_febrero = $this->view->viaticos_febrero = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosfebrero = count($viaticos_febrero);

        $month= 3;
        $viaticos_marzo = $this->view->viaticos_marzo = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosmarzo = count($viaticos_marzo);

        $month= 4;
        $viaticos_abril = $this->view->viaticos_abril = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosabril = count($viaticos_abril);

        $month= 5;
        $viaticos_mayo = $this->view->viaticos_mayo = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosmayo = count($viaticos_mayo);

        $month= 6;
        $viaticos_junio = $this->view->viaticos_junio = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosjunio = count($viaticos_junio);

        $month= 7;
        $viaticos_julio = $this->view->viaticos_julio = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosjulio = count($viaticos_julio);

        $month= 8;
        $viaticos_agosto = $this->view->viaticos_agosto = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosagosto = count($viaticos_agosto);

        $month= 9;
        $viaticos_septiembre = $this->view->viaticos_septiembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosseptiembre = count($viaticos_septiembre);

        $month= 10;
        $viaticos_octubre = $this->view->viaticos_octubre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosoctubre = count($viaticos_octubre);

        $month= 11;
        $viaticos_noviembre = $this->view->viaticos_noviembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosnoviembre = count($viaticos_noviembre);

        $month= 12;
        $viaticos_diciembre = $this->view->viaticos_diciembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosdiciembre = count($viaticos_diciembre);
        
        // E N D  V I A T I C O S   G A S T O S 

        // F A C T U R A S
        $this->view->cajachica_factura = $this->_comprobacion->getmesfacturapanelsitio($sitio);

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->rol_user = $usr[0]['fkroles']; 

    }

    public function cambiotorreprojectAction(){
        $cot_id=$this->_getParam('sitio');
        $table="cotizaciones_sitios";
        $wh="sitio_id";
        $cotizacion = $this->_season->GetSpecific($table,$wh,$cot_id);
        $suma = 0;
        foreach ($cotizacion as $key) {
            $suma = $suma + $key['total'];
        }
        $this->view->suma_cotizacion = $suma;


        $po_id=$this->_getParam('sitio');
        $table="cotizaciones_sitiospo";
        $wh="id_sitiopo";
        $po = $this->_season->GetSpecific($table,$wh,$po_id);
        $suma = 0;
        if($po){
            foreach ($po as $key) {
                $suma = $suma + $key['monto'];
            }
        }else{
            $suma = 0;
        }
        $this->view->suma_po = $suma;

        $sitio=$this->_getParam('sitio');
        $year=2021;
        $this->view->year_op = $year;
        $month = "1";
        $enero = $this->view->enero=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_enero=count($enero);

        $month = "2";
        $febrero = $this->view->febrero=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);        
        $this->view->count_febreo=count($febrero);

        $month = "3";
        $marzo = $this->view->marzo=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_marzo=count($marzo);

        $month = "4";
        $abril = $this->view->abril=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_abril=count($abril);   

        $month = "5";
        $mayo = $this->view->mayo=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio); 
        $this->view->count_mayo=count($mayo);  

        $month = "6";
        $junio = $this->view->junio=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);   
        $this->view->count_junio=count($junio);

        $month = "7";
        $julio = $this->view->julio=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio); 
        $this->view->count_julio=count($julio);  

        $month = "8";
        $agosto = $this->view->agosto=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_agosto=count($agosto);   

        $month = "9";
        $septiembre = $this->view->septiembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_septiembre=count($septiembre);   

        $month = "10";
        $octubre = $this->view->octubre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);  
        $this->view->count_octubre=count($octubre); 

        $month = "11";
        $noviembre = $this->view->noviembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_noviembre=count($noviembre);   

        $month = "12";
        $diciembre = $this->view->diciembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);  
        $this->view->count_diciembre=count($diciembre);


        //  G A S O L I N A
        $month= 1;
        $gas_enero = $this->view->gas_enero=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasenero = count($gas_enero);
        $month= 2;
        $gas_febrero = $this->view->gas_febrero=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasfebrero = count($gas_febrero);
        $month= 3;
        $gas_marzo = $this->view->gas_marzo=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasmarzo = count($gas_marzo);
        $month= 4;
        $gas_abril = $this->view->gas_abril=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasabril = count($gas_abril);
        $month= 5;
        $gas_mayo = $this->view->gas_mayo=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasmayo = count($gas_mayo);
        $month= 6;
        $gas_junio = $this->view->gas_junio=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasjunio = count($gas_junio);
        $month= 7;
        $gas_julio = $this->view->gas_julio=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasjulio = count($gas_julio);
        $month= 8;
        $gas_agosto = $this->view->gas_agosto=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasagosto = count($gas_agosto);
        $month= 9;
        $gas_septiembre = $this->view->gas_septiembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasseptiembre = count($gas_septiembre);
        $month= 10;
        $gas_octubre = $this->view->gas_octubre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasoctubre = count($gas_octubre);
        $month= 11;
        $gas_noviembre = $this->view->gas_noviembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasnoviembre = count($gas_noviembre);
        $month= 12;
        $gas_diciembre = $this->view->gas_diciembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasdiciembre = count($gas_diciembre);

        // C A J A   C H I C A
        $month= 1;
        $cajachica_enero = $this->view->cajachica_enero=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaenero = count($cajachica_enero);
        $month= 2;
        $cajachica_febrero = $this->view->cajachica_febrero=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicafebrero = count($cajachica_febrero);
        $month= 3;
        $cajachica_marzo = $this->view->cajachica_marzo=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicamarzo = count($cajachica_marzo);
        $month= 4;
        $cajachica_abril = $this->view->cajachica_abril=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaabril = count($cajachica_abril);
        $month= 5;
        $cajachica_mayo = $this->view->cajachica_mayo=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicamayo = count($cajachica_mayo);
        $month= 6;
        $cajachica_junio = $this->view->cajachica_junio=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicajunio = count($cajachica_junio);
        $month= 7;
        $cajachica_julio = $this->view->cajachica_julio=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicajulio = count($cajachica_julio);
        $month= 8;
        $cajachica_agosto = $this->view->cajachica_agosto=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaagosto = count($cajachica_agosto);
        $month= 9;
        $cajachica_septiembre = $this->view->cajachica_septiembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaseptiembre = count($cajachica_septiembre);
        $month= 10;
        $cajachica_octubre = $this->view->cajachica_octubre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaoctubre = count($cajachica_octubre);
        $month= 11;
        $cajachica_noviembre = $this->view->cajachica_noviembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachica_noviembre = count($cajachica_noviembre);
        $month= 12;
        $cajachica_diciembre = $this->view->cajachicadiciembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicadiciembre = count($cajachica_diciembre);


        $month= 1;
        $nomina_enero=$this->view->nomina_enero=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaenero = count($nomina_enero);

        $month= 2;
        $nomina_febrero=$this->view->nomina_febrero=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominafebrero = count($nomina_febrero);

        $month= 3;
        $nomina_marzo=$this->view->nomina_marzo=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominamarzo = count($nomina_marzo);

        $month= 4;
        $nomina_abril=$this->view->nomina_abril=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaabril = count($nomina_abril);

        $month= 5;
        $nomina_mayo=$this->view->nomina_mayo=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominamayo = count($nomina_mayo);

        $month= 6;
        $nomina_junio=$this->view->nomina_junio=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominajunio = count($nomina_junio);

        $month= 7;
        $nomina_julio=$this->view->nomina_julio=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominajulio = count($nomina_julio);

        $month= 8;
        $nomina_agosto=$this->view->nomina_agosto=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaagosto = count($nomina_agosto);

        $month= 9;
        $nomina_septiembre=$this->view->nomina_septiembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaseptiembre = count($nomina_septiembre);

        $month= 10;
        $nomina_octubre=$this->view->nomina_octubre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaoctubre = count($nomina_octubre);

        $month= 11;
        $nomina_noviembre=$this->view->nomina_noviembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominanoviembre = count($nomina_noviembre);

        $month= 12;
        $nomina_diciembre=$this->view->nomina_diciembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominadiciembre = count($nomina_diciembre);

          // T A G  C O N S U M O S
        $month= 1;
        $tag_enero = $this->view->tag_enero = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagenero = count($tag_enero);

        $month= 2;
        $tag_febrero = $this->view->tag_febrero = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagfebrero = count($tag_febrero);

        $month= 3;
        $tag_marzo = $this->view->tag_marzo = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagmarzo = count($tag_marzo);

        $month= 4;
        $tag_abril = $this->view->tag_abril = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagabril = count($tag_abril);

        $month= 5;
        $tag_mayo = $this->view->tag_mayo = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagmayo = count($tag_mayo);

        $month= 6;
        $tag_junio = $this->view->tag_junio = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagjunio = count($tag_junio);

        $month= 7;
        $tag_julio = $this->view->tag_julio = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagjulio = count($tag_julio);

        $month= 8;
        $tag_agosto = $this->view->tag_agosto = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagagosto = count($tag_agosto);

        $month= 9;
        $tag_septiembre = $this->view->tag_septiembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagseptiembre = count($tag_septiembre);

        $month= 10;
        $tag_octubre = $this->view->tag_octubre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagoctubre = count($tag_octubre);

        $month= 11;
        $tag_noviembre = $this->view->tag_noviembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagnoviembre = count($tag_noviembre);

        $month= 12;
        $tag_diciembre = $this->view->tag_diciembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagdiciembre = count($tag_diciembre);

        // E N D  T A G  C O N S U M O S

                // V I A T I C O S   G A S T O S 
        
        $month= 1;
        $viaticos_enero = $this->view->viaticos_enero = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosenero = count($viaticos_enero);

        $month= 2;
        $viaticos_febrero = $this->view->viaticos_febrero = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosfebrero = count($viaticos_febrero);

        $month= 3;
        $viaticos_marzo = $this->view->viaticos_marzo = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosmarzo = count($viaticos_marzo);

        $month= 4;
        $viaticos_abril = $this->view->viaticos_abril = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosabril = count($viaticos_abril);

        $month= 5;
        $viaticos_mayo = $this->view->viaticos_mayo = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosmayo = count($viaticos_mayo);

        $month= 6;
        $viaticos_junio = $this->view->viaticos_junio = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosjunio = count($viaticos_junio);

        $month= 7;
        $viaticos_julio = $this->view->viaticos_julio = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosjulio = count($viaticos_julio);

        $month= 8;
        $viaticos_agosto = $this->view->viaticos_agosto = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosagosto = count($viaticos_agosto);

        $month= 9;
        $viaticos_septiembre = $this->view->viaticos_septiembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosseptiembre = count($viaticos_septiembre);

        $month= 10;
        $viaticos_octubre = $this->view->viaticos_octubre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosoctubre = count($viaticos_octubre);

        $month= 11;
        $viaticos_noviembre = $this->view->viaticos_noviembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosnoviembre = count($viaticos_noviembre);

        $month= 12;
        $viaticos_diciembre = $this->view->viaticos_diciembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosdiciembre = count($viaticos_diciembre);
        
        // E N D  V I A T I C O S   G A S T O S 

        // F A C T U R A S
        $this->view->cajachica_factura = $this->_comprobacion->getmesfacturapanelsitio($sitio);

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->rol_user = $usr[0]['fkroles']; 

    }

    public function torrenuevaprojectAction(){
        $cot_id=$this->_getParam('sitio');
        $table="cotizaciones_sitios";
        $wh="sitio_id";
        $cotizacion = $this->_season->GetSpecific($table,$wh,$cot_id);
        $suma = 0;
        foreach ($cotizacion as $key) {
            $suma = $suma + $key['total'];
        }
        $this->view->suma_cotizacion = $suma;


        $po_id=$this->_getParam('sitio');
        $table="cotizaciones_sitiospo";
        $wh="id_sitiopo";
        $po = $this->_season->GetSpecific($table,$wh,$po_id);
        $suma = 0;
        if($po){
            foreach ($po as $key) {
                $suma = $suma + $key['monto'];
            }
        }else{
            $suma = 0;
        }
        $this->view->suma_po = $suma;


        $sitio=$this->_getParam('sitio');
        $year=2021;
        $this->view->year_op = $year;
        $month = "1";
        $enero = $this->view->enero=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_enero=count($enero);

        $month = "2";
        $febrero = $this->view->febrero=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);        
        $this->view->count_febreo=count($febrero);

        $month = "3";
        $marzo = $this->view->marzo=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_marzo=count($marzo);

        $month = "4";
        $abril = $this->view->abril=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_abril=count($abril);   

        $month = "5";
        $mayo = $this->view->mayo=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio); 
        $this->view->count_mayo=count($mayo);  

        $month = "6";
        $junio = $this->view->junio=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);   
        $this->view->count_junio=count($junio);

        $month = "7";
        $julio = $this->view->julio=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio); 
        $this->view->count_julio=count($julio);  

        $month = "8";
        $agosto = $this->view->agosto=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_agosto=count($agosto);   

        $month = "9";
        $septiembre = $this->view->septiembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_septiembre=count($septiembre);   

        $month = "10";
        $octubre = $this->view->octubre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);  
        $this->view->count_octubre=count($octubre); 

        $month = "11";
        $noviembre = $this->view->noviembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_noviembre=count($noviembre);   

        $month = "12";
        $diciembre = $this->view->diciembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);  
        $this->view->count_diciembre=count($diciembre);

        //  G A S O L I N A
        $month= 1;
        $gas_enero = $this->view->gas_enero=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasenero = count($gas_enero);
        $month= 2;
        $gas_febrero = $this->view->gas_febrero=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasfebrero = count($gas_febrero);
        $month= 3;
        $gas_marzo = $this->view->gas_marzo=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasmarzo = count($gas_marzo);
        $month= 4;
        $gas_abril = $this->view->gas_abril=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasabril = count($gas_abril);
        $month= 5;
        $gas_mayo = $this->view->gas_mayo=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasmayo = count($gas_mayo);
        $month= 6;
        $gas_junio = $this->view->gas_junio=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasjunio = count($gas_junio);
        $month= 7;
        $gas_julio = $this->view->gas_julio=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasjulio = count($gas_julio);
        $month= 8;
        $gas_agosto = $this->view->gas_agosto=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasagosto = count($gas_agosto);
        $month= 9;
        $gas_septiembre = $this->view->gas_septiembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasseptiembre = count($gas_septiembre);
        $month= 10;
        $gas_octubre = $this->view->gas_octubre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasoctubre = count($gas_octubre);
        $month= 11;
        $gas_noviembre = $this->view->gas_noviembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasnoviembre = count($gas_noviembre);
        $month= 12;
        $gas_diciembre = $this->view->gas_diciembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasdiciembre = count($gas_diciembre);

        // C A J A   C H I C A
        $month= 1;
        $cajachica_enero = $this->view->cajachica_enero=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaenero = count($cajachica_enero);
        $month= 2;
        $cajachica_febrero = $this->view->cajachica_febrero=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicafebrero = count($cajachica_febrero);
        $month= 3;
        $cajachica_marzo = $this->view->cajachica_marzo=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicamarzo = count($cajachica_marzo);
        $month= 4;
        $cajachica_abril = $this->view->cajachica_abril=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaabril = count($cajachica_abril);
        $month= 5;
        $cajachica_mayo = $this->view->cajachica_mayo=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicamayo = count($cajachica_mayo);
        $month= 6;
        $cajachica_junio = $this->view->cajachica_junio=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicajunio = count($cajachica_junio);
        $month= 7;
        $cajachica_julio = $this->view->cajachica_julio=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicajulio = count($cajachica_julio);
        $month= 8;
        $cajachica_agosto = $this->view->cajachica_agosto=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaagosto = count($cajachica_agosto);
        $month= 9;
        $cajachica_septiembre = $this->view->cajachica_septiembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaseptiembre = count($cajachica_septiembre);
        $month= 10;
        $cajachica_octubre = $this->view->cajachica_octubre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaoctubre = count($cajachica_octubre);
        $month= 11;
        $cajachica_noviembre = $this->view->cajachica_noviembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachica_noviembre = count($cajachica_noviembre);
        $month= 12;
        $cajachica_diciembre = $this->view->cajachicadiciembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicadiciembre = count($cajachica_diciembre);

        // var_dump($sitio);exit;

        $month= 1;
        $nomina_enero=$this->view->nomina_enero=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaenero = count($nomina_enero);

        $month= 2;
        $nomina_febrero=$this->view->nomina_febrero=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominafebrero = count($nomina_febrero);

        $month= 3;
        $nomina_marzo=$this->view->nomina_marzo=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominamarzo = count($nomina_marzo);

        $month= 4;
        $nomina_abril=$this->view->nomina_abril=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaabril = count($nomina_abril);

        $month= 5;
        $nomina_mayo=$this->view->nomina_mayo=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominamayo = count($nomina_mayo);

        $month= 6;
        $nomina_junio=$this->view->nomina_junio=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominajunio = count($nomina_junio);

        $month= 7;
        $nomina_julio=$this->view->nomina_julio=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominajulio = count($nomina_julio);

        $month= 8;
        $nomina_agosto=$this->view->nomina_agosto=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaagosto = count($nomina_agosto);

        $month= 9;
        $nomina_septiembre=$this->view->nomina_septiembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaseptiembre = count($nomina_septiembre);

        $month= 10;
        $nomina_octubre=$this->view->nomina_octubre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaoctubre = count($nomina_octubre);

        $month= 11;
        $nomina_noviembre=$this->view->nomina_noviembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominanoviembre = count($nomina_noviembre);

        $month= 12;
        $nomina_diciembre=$this->view->nomina_diciembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominadiciembre = count($nomina_diciembre);


        // T A G  C O N S U M O S
        $month= 1;
        $tag_enero = $this->view->tag_enero = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagenero = count($tag_enero);

        $month= 2;
        $tag_febrero = $this->view->tag_febrero = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagfebrero = count($tag_febrero);

        $month= 3;
        $tag_marzo = $this->view->tag_marzo = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagmarzo = count($tag_marzo);

        $month= 4;
        $tag_abril = $this->view->tag_abril = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagabril = count($tag_abril);

        $month= 5;
        $tag_mayo = $this->view->tag_mayo = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagmayo = count($tag_mayo);

        $month= 6;
        $tag_junio = $this->view->tag_junio = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagjunio = count($tag_junio);

        $month= 7;
        $tag_julio = $this->view->tag_julio = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagjulio = count($tag_julio);

        $month= 8;
        $tag_agosto = $this->view->tag_agosto = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagagosto = count($tag_agosto);

        $month= 9;
        $tag_septiembre = $this->view->tag_septiembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagseptiembre = count($tag_septiembre);

        $month= 10;
        $tag_octubre = $this->view->tag_octubre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagoctubre = count($tag_octubre);

        $month= 11;
        $tag_noviembre = $this->view->tag_noviembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagnoviembre = count($tag_noviembre);

        $month= 12;
        $tag_diciembre = $this->view->tag_diciembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagdiciembre = count($tag_diciembre);

        // E N D  T A G  C O N S U M O S

                // V I A T I C O S   G A S T O S 
        
        $month= 1;
        $viaticos_enero = $this->view->viaticos_enero = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosenero = count($viaticos_enero);

        $month= 2;
        $viaticos_febrero = $this->view->viaticos_febrero = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosfebrero = count($viaticos_febrero);

        $month= 3;
        $viaticos_marzo = $this->view->viaticos_marzo = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosmarzo = count($viaticos_marzo);

        $month= 4;
        $viaticos_abril = $this->view->viaticos_abril = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosabril = count($viaticos_abril);

        $month= 5;
        $viaticos_mayo = $this->view->viaticos_mayo = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosmayo = count($viaticos_mayo);

        $month= 6;
        $viaticos_junio = $this->view->viaticos_junio = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosjunio = count($viaticos_junio);

        $month= 7;
        $viaticos_julio = $this->view->viaticos_julio = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosjulio = count($viaticos_julio);

        $month= 8;
        $viaticos_agosto = $this->view->viaticos_agosto = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosagosto = count($viaticos_agosto);

        $month= 9;
        $viaticos_septiembre = $this->view->viaticos_septiembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosseptiembre = count($viaticos_septiembre);

        $month= 10;
        $viaticos_octubre = $this->view->viaticos_octubre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosoctubre = count($viaticos_octubre);

        $month= 11;
        $viaticos_noviembre = $this->view->viaticos_noviembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosnoviembre = count($viaticos_noviembre);

        $month= 12;
        $viaticos_diciembre = $this->view->viaticos_diciembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosdiciembre = count($viaticos_diciembre);
        
        // E N D  V I A T I C O S   G A S T O S 

        // F A C T U R A S
        $this->view->cajachica_factura = $this->_comprobacion->getmesfacturapanelsitio($sitio);

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->rol_user = $usr[0]['fkroles'];     
    }

    public function mapeotorreprojectAction(){
        $cot_id=$this->_getParam('sitio');
        $table="cotizaciones_sitios";
        $wh="sitio_id";
        $cotizacion = $this->_season->GetSpecific($table,$wh,$cot_id);
        $suma = 0;
        foreach ($cotizacion as $key) {
            $suma = $suma + $key['total'];
        }
        $this->view->suma_cotizacion = $suma;


        $po_id=$this->_getParam('sitio');
        $table="cotizaciones_sitiospo";
        $wh="id_sitiopo";
        $po = $this->_season->GetSpecific($table,$wh,$po_id);
        $suma = 0;
        if($po){
            foreach ($po as $key) {
                $suma = $suma + $key['monto'];
            }
        }else{
            $suma = 0;
        }
        $this->view->suma_po = $suma;

        $sitio=$this->_getParam('sitio');
        $year=2021;
        $this->view->year_op = $year;
        $month = "1";
        $enero = $this->view->enero=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_enero=count($enero);

        $month = "2";
        $febrero = $this->view->febrero=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);        
        $this->view->count_febreo=count($febrero);

        $month = "3";
        $marzo = $this->view->marzo=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_marzo=count($marzo);

        $month = "4";
        $abril = $this->view->abril=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_abril=count($abril);   

        $month = "5";
        $mayo = $this->view->mayo=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio); 
        $this->view->count_mayo=count($mayo);  

        $month = "6";
        $junio = $this->view->junio=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);   
        $this->view->count_junio=count($junio);

        $month = "7";
        $julio = $this->view->julio=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio); 
        $this->view->count_julio=count($julio);  

        $month = "8";
        $agosto = $this->view->agosto=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_agosto=count($agosto);   

        $month = "9";
        $septiembre = $this->view->septiembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_septiembre=count($septiembre);   

        $month = "10";
        $octubre = $this->view->octubre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);  
        $this->view->count_octubre=count($octubre); 

        $month = "11";
        $noviembre = $this->view->noviembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);
        $this->view->count_noviembre=count($noviembre);   

        $month = "12";
        $diciembre = $this->view->diciembre=$this->_ordencompra->getinfosolicitudessitio($year,$month,$sitio);  
        $this->view->count_diciembre=count($diciembre);


        //  G A S O L I N A
        $month= 1;
        $gas_enero = $this->view->gas_enero=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasenero = count($gas_enero);
        $month= 2;
        $gas_febrero = $this->view->gas_febrero=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasfebrero = count($gas_febrero);
        $month= 3;
        $gas_marzo = $this->view->gas_marzo=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasmarzo = count($gas_marzo);
        $month= 4;
        $gas_abril = $this->view->gas_abril=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasabril = count($gas_abril);
        $month= 5;
        $gas_mayo = $this->view->gas_mayo=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasmayo = count($gas_mayo);
        $month= 6;
        $gas_junio = $this->view->gas_junio=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasjunio = count($gas_junio);
        $month= 7;
        $gas_julio = $this->view->gas_julio=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasjulio = count($gas_julio);
        $month= 8;
        $gas_agosto = $this->view->gas_agosto=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasagosto = count($gas_agosto);
        $month= 9;
        $gas_septiembre = $this->view->gas_septiembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasseptiembre = count($gas_septiembre);
        $month= 10;
        $gas_octubre = $this->view->gas_octubre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasoctubre = count($gas_octubre);
        $month= 11;
        $gas_noviembre = $this->view->gas_noviembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasnoviembre = count($gas_noviembre);
        $month= 12;
        $gas_diciembre = $this->view->gas_diciembre=$this->_gasolina->getinfoindexsitio($year,$month,$sitio);
        $this->view->count_gasdiciembre = count($gas_diciembre);

        // C A J A   C H I C A
        $month= 1;
        $cajachica_enero = $this->view->cajachica_enero=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaenero = count($cajachica_enero);
        $month= 2;
        $cajachica_febrero = $this->view->cajachica_febrero=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicafebrero = count($cajachica_febrero);
        $month= 3;
        $cajachica_marzo = $this->view->cajachica_marzo=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicamarzo = count($cajachica_marzo);
        $month= 4;
        $cajachica_abril = $this->view->cajachica_abril=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaabril = count($cajachica_abril);
        $month= 5;
        $cajachica_mayo = $this->view->cajachica_mayo=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicamayo = count($cajachica_mayo);
        $month= 6;
        $cajachica_junio = $this->view->cajachica_junio=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicajunio = count($cajachica_junio);
        $month= 7;
        $cajachica_julio = $this->view->cajachica_julio=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicajulio = count($cajachica_julio);
        $month= 8;
        $cajachica_agosto = $this->view->cajachica_agosto=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaagosto = count($cajachica_agosto);
        $month= 9;
        $cajachica_septiembre = $this->view->cajachica_septiembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaseptiembre = count($cajachica_septiembre);
        $month= 10;
        $cajachica_octubre = $this->view->cajachica_octubre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicaoctubre = count($cajachica_octubre);
        $month= 11;
        $cajachica_noviembre = $this->view->cajachica_noviembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachica_noviembre = count($cajachica_noviembre);
        $month= 12;
        $cajachica_diciembre = $this->view->cajachicadiciembre=$this->_comprobacion->getmessitio($year,$month,$sitio);
        $this->view->count_cajachicadiciembre = count($cajachica_diciembre);


        $month= 1;
        $nomina_enero=$this->view->nomina_enero=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaenero = count($nomina_enero);

        $month= 2;
        $nomina_febrero=$this->view->nomina_febrero=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominafebrero = count($nomina_febrero);

        $month= 3;
        $nomina_marzo=$this->view->nomina_marzo=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominamarzo = count($nomina_marzo);

        $month= 4;
        $nomina_abril=$this->view->nomina_abril=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaabril = count($nomina_abril);

        $month= 5;
        $nomina_mayo=$this->view->nomina_mayo=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominamayo = count($nomina_mayo);

        $month= 6;
        $nomina_junio=$this->view->nomina_junio=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominajunio = count($nomina_junio);

        $month= 7;
        $nomina_julio=$this->view->nomina_julio=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominajulio = count($nomina_julio);

        $month= 8;
        $nomina_agosto=$this->view->nomina_agosto=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaagosto = count($nomina_agosto);

        $month= 9;
        $nomina_septiembre=$this->view->nomina_septiembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaseptiembre = count($nomina_septiembre);

        $month= 10;
        $nomina_octubre=$this->view->nomina_octubre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominaoctubre = count($nomina_octubre);

        $month= 11;
        $nomina_noviembre=$this->view->nomina_noviembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominanoviembre = count($nomina_noviembre);

        $month= 12;
        $nomina_diciembre=$this->view->nomina_diciembre=$this->_archivo->getnomiasolicitudesproyecto($year,$month,$sitio);
        $this->view->count_nominadiciembre = count($nomina_diciembre);

          // T A G  C O N S U M O S
        $month= 1;
        $tag_enero = $this->view->tag_enero = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagenero = count($tag_enero);

        $month= 2;
        $tag_febrero = $this->view->tag_febrero = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagfebrero = count($tag_febrero);

        $month= 3;
        $tag_marzo = $this->view->tag_marzo = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagmarzo = count($tag_marzo);

        $month= 4;
        $tag_abril = $this->view->tag_abril = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagabril = count($tag_abril);

        $month= 5;
        $tag_mayo = $this->view->tag_mayo = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagmayo = count($tag_mayo);

        $month= 6;
        $tag_junio = $this->view->tag_junio = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagjunio = count($tag_junio);

        $month= 7;
        $tag_julio = $this->view->tag_julio = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagjulio = count($tag_julio);

        $month= 8;
        $tag_agosto = $this->view->tag_agosto = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagagosto = count($tag_agosto);

        $month= 9;
        $tag_septiembre = $this->view->tag_septiembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagseptiembre = count($tag_septiembre);

        $month= 10;
        $tag_octubre = $this->view->tag_octubre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagoctubre = count($tag_octubre);

        $month= 11;
        $tag_noviembre = $this->view->tag_noviembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagnoviembre = count($tag_noviembre);

        $month= 12;
        $tag_diciembre = $this->view->tag_diciembre = $this->_archivo->gettagconsumosproyecto($year,$month,$sitio);
        $this->view->count_tagdiciembre = count($tag_diciembre);

        // E N D  T A G  C O N S U M O S

                // V I A T I C O S   G A S T O S 
        
        $month= 1;
        $viaticos_enero = $this->view->viaticos_enero = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosenero = count($viaticos_enero);

        $month= 2;
        $viaticos_febrero = $this->view->viaticos_febrero = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosfebrero = count($viaticos_febrero);

        $month= 3;
        $viaticos_marzo = $this->view->viaticos_marzo = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosmarzo = count($viaticos_marzo);

        $month= 4;
        $viaticos_abril = $this->view->viaticos_abril = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosabril = count($viaticos_abril);

        $month= 5;
        $viaticos_mayo = $this->view->viaticos_mayo = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosmayo = count($viaticos_mayo);

        $month= 6;
        $viaticos_junio = $this->view->viaticos_junio = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosjunio = count($viaticos_junio);

        $month= 7;
        $viaticos_julio = $this->view->viaticos_julio = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosjulio = count($viaticos_julio);

        $month= 8;
        $viaticos_agosto = $this->view->viaticos_agosto = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosagosto = count($viaticos_agosto);

        $month= 9;
        $viaticos_septiembre = $this->view->viaticos_septiembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosseptiembre = count($viaticos_septiembre);

        $month= 10;
        $viaticos_octubre = $this->view->viaticos_octubre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosoctubre = count($viaticos_octubre);

        $month= 11;
        $viaticos_noviembre = $this->view->viaticos_noviembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosnoviembre = count($viaticos_noviembre);

        $month= 12;
        $viaticos_diciembre = $this->view->viaticos_diciembre = $this->_archivo->getviaticosproyecto($year,$month,$sitio);
        $this->view->count_viaticosdiciembre = count($viaticos_diciembre);
        
        // E N D  V I A T I C O S   G A S T O S 

        // F A C T U R A S
        $this->view->cajachica_factura = $this->_comprobacion->getmesfacturapanelsitio($sitio);


        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->rol_user = $usr[0]['fkroles']; 
    }


    public function solicitudesdecompraAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $opcion = $this->_getParam('op');
        $this->view->opcion_search=$opcion;
        $year=date("Y");

        $modulo = $this->_getParam('modulo');
        $this->view->modulo=$modulo;

        if($status == 1){
            if($opcion == 1){
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;
                $month = "1";
                $enero = $this->view->enero=$this->_ordencompra->getdireccionsitiograficas($sitio,$year,$month);
                $this->view->count_enero=count($enero);
                $month = "2";
                $febrero= $this->view->febrero=$this->_ordencompra->getdireccionsitiograficas($sitio,$year,$month);
                // var_dump($febrero);exit;
                $this->view->count_febrero=count($febrero);
                $month = "3";
                $marzo = $this->view->marzo=$this->_ordencompra->getdireccionsitiograficas($sitio,$year,$month);
                $this->view->count_marzo=count($marzo);
                $month = "4";
                $abril=$this->view->abril=$this->_ordencompra->getdireccionsitiograficas($sitio,$year,$month);
                $this->view->count_abril=count($abril);
                $month = "5";
                $mayo= $this->view->mayo=$this->_ordencompra->getdireccionsitiograficas($sitio,$year,$month);
                $this->view->count_mayo=count($mayo);
                $month = "6";
                $junio = $this->view->junio=$this->_ordencompra->getdireccionsitiograficas($sitio,$year,$month);
                $this->view->count_junio=count($junio);
                $month = "7";
                $julio = $this->view->julio=$this->_ordencompra->getdireccionsitiograficas($sitio,$year,$month);
                $this->view->count_julio=count($julio);
                $month = "8";
                $agosto = $this->view->agosto=$this->_ordencompra->getdireccionsitiograficas($sitio,$year,$month);
                $this->view->count_agosto=count($agosto);
                $month = "9";
                $septiembre = $this->view->septiembre=$this->_ordencompra->getdireccionsitiograficas($sitio,$year,$month);
                $this->view->count_septiembre=count($septiembre);
                $month = "10";
                $octubre = $this->view->octubre=$this->_ordencompra->getdireccionsitiograficas($sitio,$year,$month);
                $this->view->count_octubre=count($octubre);
                $month = "11";
                $noviembre = $this->view->noviembre=$this->_ordencompra->getdireccionsitiograficas($sitio,$year,$month);
                $this->view->count_noviembre=count($noviembre);
                $month = "12";
                $diciembre = $this->view->diciembre=$this->_ordencompra->getdireccionsitiograficas($sitio,$year,$month);
                $this->view->count_diciembre=count($diciembre);
            }

            if($opcion == 2){
                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov; 
                $month = "1";
                $enero = $this->view->enero=$this->_ordencompra->getdireccionproveedorgraficas($prov,$year,$month);
                $this->view->count_enero=count($enero);
                $month = "2";
                $febrero= $this->view->febrero=$this->_ordencompra->getdireccionproveedorgraficas($prov,$year,$month);
                $this->view->count_febrero=count($febrero);
                $month = "3";
                $marzo = $this->view->marzo=$this->_ordencompra->getdireccionproveedorgraficas($prov,$year,$month);
                $this->view->count_marzo=count($marzo);
                $month = "4";
                $abril=$this->view->abril=$this->_ordencompra->getdireccionproveedorgraficas($prov,$year,$month);
                $this->view->count_abril=count($abril);
                $month = "5";
                $mayo= $this->view->mayo=$this->_ordencompra->getdireccionproveedorgraficas($prov,$year,$month);
                $this->view->count_mayo=count($mayo);
                $month = "6";
                $junio = $this->view->junio=$this->_ordencompra->getdireccionproveedorgraficas($prov,$year,$month);
                $this->view->count_junio=count($junio);
                $month = "7";
                $julio = $this->view->julio=$this->_ordencompra->getdireccionproveedorgraficas($prov,$year,$month);
                $this->view->count_julio=count($julio);
                $month = "8";
                $agosto = $this->view->agosto=$this->_ordencompra->getdireccionproveedorgraficas($prov,$year,$month);
                $this->view->count_agosto=count($agosto);
                $month = "9";
                $septiembre=$this->view->septiembre=$this->_ordencompra->getdireccionproveedorgraficas($prov,$year,$month);
                $this->view->count_septiembre=count($septiembre);
                $month = "10";
                $octubre = $this->view->octubre=$this->_ordencompra->getdireccionproveedorgraficas($prov,$year,$month);
                $this->view->count_octubre=count($octubre);
                $month = "11";
                $noviembre = $this->view->noviembre=$this->_ordencompra->getdireccionproveedorgraficas($prov,$year,$month);
                $this->view->count_noviembre=count($noviembre);
                $month = "12";
                $diciembre = $this->view->diciembre=$this->_ordencompra->getdireccionproveedorgraficas($prov,$year,$month);
                $this->view->count_diciembre=count($diciembre);
            }

            if($opcion == 4){
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $month = "1";
                $enero = $this->view->enero=$this->_ordencompra->getdireccionusergraficas($user,$year,$month);
                $this->view->count_enero=count($enero);
                $month = "2";
                $febrero= $this->view->febrero=$this->_ordencompra->getdireccionusergraficas($user,$year,$month);
                $this->view->count_febrero=count($febrero);
                $month = "3";
                $marzo = $this->view->marzo=$this->_ordencompra->getdireccionusergraficas($user,$year,$month);
                $this->view->count_marzo=count($marzo);
                $month = "4";
                $abril=$this->view->abril=$this->_ordencompra->getdireccionusergraficas($user,$year,$month);
                $this->view->count_abril=count($abril);
                $month = "5";
                $mayo= $this->view->mayo=$this->_ordencompra->getdireccionusergraficas($user,$year,$month);
                $this->view->count_mayo=count($mayo);
                $month = "6";
                $junio = $this->view->junio=$this->_ordencompra->getdireccionusergraficas($user,$year,$month);
                $this->view->count_junio=count($junio);
                $month = "7";
                $julio = $this->view->julio=$this->_ordencompra->getdireccionusergraficas($user,$year,$month);
                $this->view->count_julio=count($julio);
                $month = "8";
                $agosto = $this->view->agosto=$this->_ordencompra->getdireccionusergraficas($user,$year,$month);
                $this->view->count_agosto=count($agosto);
                $month = "9";
                $septiembre=$this->view->septiembre=$this->_ordencompra->getdireccionusergraficas($user,$year,$month);
                $this->view->count_septiembre=count($septiembre);
                $month = "10";
                $octubre = $this->view->octubre=$this->_ordencompra->getdireccionusergraficas($user,$year,$month);
                $this->view->count_octubre=count($octubre);
                $month = "11";
                $noviembre = $this->view->noviembre=$this->_ordencompra->getdireccionusergraficas($user,$year,$month);
                $this->view->count_noviembre=count($noviembre);
                $month = "12";
                $diciembre = $this->view->diciembre=$this->_ordencompra->getdireccionusergraficas($user,$year,$month);
                $this->view->count_diciembre=count($diciembre);
            }

            if($opcion == 5){
                $servicio = $this->_getParam('servicio'); 
                $wh="id";
                $table="servicios";
                $this->view->info = $this->_season->GetSpecific($table,$wh,$servicio);

                $this->view->servicio_search=$servicio; 
                $month = "1";
                $enero = $this->view->enero=$this->_ordencompra->getdireccionserviciograficas($servicio,$year,$month);
                $this->view->count_enero=count($enero);
                $month = "2";
                $febrero= $this->view->febrero=$this->_ordencompra->getdireccionserviciograficas($servicio,$year,$month);
                $this->view->count_febrero=count($febrero);
                $month = "3";
                $marzo = $this->view->marzo=$this->_ordencompra->getdireccionserviciograficas($servicio,$year,$month);
                $this->view->count_marzo=count($marzo);
                $month = "4";
                $abril=$this->view->abril=$this->_ordencompra->getdireccionserviciograficas($servicio,$year,$month);
                $this->view->count_abril=count($abril);
                $month = "5";
                $mayo= $this->view->mayo=$this->_ordencompra->getdireccionserviciograficas($servicio,$year,$month);
                $this->view->count_mayo=count($mayo);
                $month = "6";
                $junio = $this->view->junio=$this->_ordencompra->getdireccionserviciograficas($servicio,$year,$month);
                $this->view->count_junio=count($junio);
                $month = "7";
                $julio = $this->view->julio=$this->_ordencompra->getdireccionserviciograficas($servicio,$year,$month);
                $this->view->count_julio=count($julio);
                $month = "8";
                $agosto = $this->view->agosto=$this->_ordencompra->getdireccionserviciograficas($servicio,$year,$month);
                $this->view->count_agosto=count($agosto);
                $month = "9";
                $septiembre=$this->view->septiembre=$this->_ordencompra->getdireccionserviciograficas($servicio,$year,$month);
                $this->view->count_septiembre=count($septiembre);
                $month = "10";
                $octubre = $this->view->octubre=$this->_ordencompra->getdireccionserviciograficas($servicio,$year,$month);
                $this->view->count_octubre=count($octubre);
                $month = "11";
                $noviembre = $this->view->noviembre=$this->_ordencompra->getdireccionserviciograficas($servicio,$year,$month);
                $this->view->count_noviembre=count($noviembre);
                $month = "12";
                $diciembre = $this->view->diciembre=$this->_ordencompra->getdireccionserviciograficas($servicio,$year,$month);
                $this->view->count_diciembre=count($diciembre);
            }


        }

        if($status == 3){
            if($opcion == 1){
                $sitio = $this->_getParam('sitio');
                $this->view->nombre_sitio=$sitio;
                $month = "1";
                $enero = $this->view->enero=$this->_ordencompra->getpagadagraficasitio($sitio,$year,$month);
                $this->view->count_enero=count($enero);
                $month = "2";
                $febrero= $this->view->febrero=$this->_ordencompra->getpagadagraficasitio($sitio,$year,$month);
                $this->view->count_febrero=count($febrero);
                $month = "3";
                $marzo = $this->view->marzo=$this->_ordencompra->getpagadagraficasitio($sitio,$year,$month);
                $this->view->count_marzo=count($marzo);
                $month = "4";
                $abril=$this->view->abril=$this->_ordencompra->getpagadagraficasitio($sitio,$year,$month);
                $this->view->count_abril=count($abril);
                $month = "5";
                $mayo= $this->view->mayo=$this->_ordencompra->getpagadagraficasitio($sitio,$year,$month);
                $this->view->count_mayo=count($mayo);
                $month = "6";
                $junio = $this->view->junio=$this->_ordencompra->getpagadagraficasitio($sitio,$year,$month);
                $this->view->count_junio=count($junio);
                $month = "7";
                $julio = $this->view->julio=$this->_ordencompra->getpagadagraficasitio($sitio,$year,$month);
                $this->view->count_julio=count($julio);
                $month = "8";
                $agosto = $this->view->agosto=$this->_ordencompra->getpagadagraficasitio($sitio,$year,$month);
                $this->view->count_agosto=count($agosto);
                $month = "9";
                $septiembre = $this->view->septiembre=$this->_ordencompra->getpagadagraficasitio($sitio,$year,$month);
                $this->view->count_septiembre=count($septiembre);
                $month = "10";
                $octubre = $this->view->octubre=$this->_ordencompra->getpagadagraficasitio($sitio,$year,$month);
                $this->view->count_octubre=count($octubre);
                $month = "11";
                $noviembre = $this->view->noviembre=$this->_ordencompra->getpagadagraficasitio($sitio,$year,$month);
                $this->view->count_noviembre=count($noviembre);
                $month = "12";
                $diciembre = $this->view->diciembre=$this->_ordencompra->getpagadagraficasitio($sitio,$year,$month);
                $this->view->count_diciembre=count($diciembre);
            }

            if($opcion == 2){
                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov; 
                $month = "1";
                $enero = $this->view->enero=$this->_ordencompra->getpagadagraficaproveedor($prov,$year,$month);
                $this->view->count_enero=count($enero);
                $month = "2";
                $febrero= $this->view->febrero=$this->_ordencompra->getpagadagraficaproveedor($prov,$year,$month);
                $this->view->count_febrero=count($febrero);
                $month = "3";
                $marzo = $this->view->marzo=$this->_ordencompra->getpagadagraficaproveedor($prov,$year,$month);
                $this->view->count_marzo=count($marzo);
                $month = "4";
                $abril=$this->view->abril=$this->_ordencompra->getpagadagraficaproveedor($prov,$year,$month);
                $this->view->count_abril=count($abril);
                $month = "5";
                $mayo= $this->view->mayo=$this->_ordencompra->getpagadagraficaproveedor($prov,$year,$month);
                $this->view->count_mayo=count($mayo);
                $month = "6";
                $junio = $this->view->junio=$this->_ordencompra->getpagadagraficaproveedor($prov,$year,$month);
                $this->view->count_junio=count($junio);
                $month = "7";
                $julio = $this->view->julio=$this->_ordencompra->getpagadagraficaproveedor($prov,$year,$month);
                $this->view->count_julio=count($julio);
                $month = "8";
                $agosto = $this->view->agosto=$this->_ordencompra->getpagadagraficaproveedor($prov,$year,$month);
                $this->view->count_agosto=count($agosto);
                $month = "9";
                $septiembre=$this->view->septiembre=$this->_ordencompra->getpagadagraficaproveedor($prov,$year,$month);
                $this->view->count_septiembre=count($septiembre);
                $month = "10";
                $octubre = $this->view->octubre=$this->_ordencompra->getpagadagraficaproveedor($prov,$year,$month);
                $this->view->count_octubre=count($octubre);
                $month = "11";
                $noviembre = $this->view->noviembre=$this->_ordencompra->getpagadagraficaproveedor($prov,$year,$month);
                $this->view->count_noviembre=count($noviembre);
                $month = "12";
                $diciembre = $this->view->diciembre=$this->_ordencompra->getpagadagraficaproveedor($prov,$year,$month);
                $this->view->count_diciembre=count($diciembre);
            }

            if($opcion == 4){
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $month = "1";
                $enero = $this->view->enero=$this->_ordencompra->getpagadagraficausuario($user,$year,$month);
                $this->view->count_enero=count($enero);
                $month = "2";
                $febrero= $this->view->febrero=$this->_ordencompra->getpagadagraficausuario($user,$year,$month);
                $this->view->count_febrero=count($febrero);
                $month = "3";
                $marzo = $this->view->marzo=$this->_ordencompra->getpagadagraficausuario($user,$year,$month);
                $this->view->count_marzo=count($marzo);
                $month = "4";
                $abril=$this->view->abril=$this->_ordencompra->getpagadagraficausuario($user,$year,$month);
                $this->view->count_abril=count($abril);
                $month = "5";
                $mayo= $this->view->mayo=$this->_ordencompra->getpagadagraficausuario($user,$year,$month);
                $this->view->count_mayo=count($mayo);
                $month = "6";
                $junio = $this->view->junio=$this->_ordencompra->getpagadagraficausuario($user,$year,$month);
                $this->view->count_junio=count($junio);
                $month = "7";
                $julio = $this->view->julio=$this->_ordencompra->getpagadagraficausuario($user,$year,$month);
                $this->view->count_julio=count($julio);
                $month = "8";
                $agosto = $this->view->agosto=$this->_ordencompra->getpagadagraficausuario($user,$year,$month);
                $this->view->count_agosto=count($agosto);
                $month = "9";
                $septiembre=$this->view->septiembre=$this->_ordencompra->getpagadagraficausuario($user,$year,$month);
                $this->view->count_septiembre=count($septiembre);
                $month = "10";
                $octubre = $this->view->octubre=$this->_ordencompra->getpagadagraficausuario($user,$year,$month);
                $this->view->count_octubre=count($octubre);
                $month = "11";
                $noviembre = $this->view->noviembre=$this->_ordencompra->getpagadagraficausuario($user,$year,$month);
                $this->view->count_noviembre=count($noviembre);
                $month = "12";
                $diciembre = $this->view->diciembre=$this->_ordencompra->getpagadagraficausuario($user,$year,$month);
                $this->view->count_diciembre=count($diciembre);
            }


            if($opcion == 5){
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 
                $wh="id";
                $table="servicios";
                $this->view->info = $this->_season->GetSpecific($table,$wh,$servicio);
                
                $month = "1";
                $enero = $this->view->enero=$this->_ordencompra->getpagadagraficaservicio($servicio,$year,$month);
                $this->view->count_enero=count($enero);
                $month = "2";
                $febrero= $this->view->febrero=$this->_ordencompra->getpagadagraficaservicio($servicio,$year,$month);
                $this->view->count_febrero=count($febrero);
                $month = "3";
                $marzo = $this->view->marzo=$this->_ordencompra->getpagadagraficaservicio($servicio,$year,$month);
                $this->view->count_marzo=count($marzo);
                $month = "4";
                $abril=$this->view->abril=$this->_ordencompra->getpagadagraficaservicio($servicio,$year,$month);
                $this->view->count_abril=count($abril);
                $month = "5";
                $mayo= $this->view->mayo=$this->_ordencompra->getpagadagraficaservicio($servicio,$year,$month);
                $this->view->count_mayo=count($mayo);
                $month = "6";
                $junio = $this->view->junio=$this->_ordencompra->getpagadagraficaservicio($servicio,$year,$month);
                $this->view->count_junio=count($junio);
                $month = "7";
                $julio = $this->view->julio=$this->_ordencompra->getpagadagraficaservicio($servicio,$year,$month);
                $this->view->count_julio=count($julio);
                $month = "8";
                $agosto = $this->view->agosto=$this->_ordencompra->getpagadagraficaservicio($servicio,$year,$month);
                $this->view->count_agosto=count($agosto);
                $month = "9";
                $septiembre=$this->view->septiembre=$this->_ordencompra->getpagadagraficaservicio($servicio,$year,$month);
                $this->view->count_septiembre=count($septiembre);
                $month = "10";
                $octubre = $this->view->octubre=$this->_ordencompra->getpagadagraficaservicio($servicio,$year,$month);
                $this->view->count_octubre=count($octubre);
                $month = "11";
                $noviembre = $this->view->noviembre=$this->_ordencompra->getpagadagraficaservicio($servicio,$year,$month);
                $this->view->count_noviembre=count($noviembre);
                $month = "12";
                $diciembre = $this->view->diciembre=$this->_ordencompra->getpagadagraficaservicio($servicio,$year,$month);
                $this->view->count_diciembre=count($diciembre);
            }


        }


    }


    public function informacionmensualAction(){
        $year=$this->_getParam('year');
        $this->view->year_op = $year;
        $month = $this->_getParam('mes');
        $this->view->month = $month;

        $this->view->solicitudes = $this->_ordencompra->getinfosolicitudesindex($year,$month);
        $this->view->gasolina = $this->_gasolina->getinfoindex($year,$month);
        $this->view->cajachica = $this->_comprobacion->getmesfacturapanel($year,$month);
        $this->view->sol_cajachica = $this->_comprobacion->getmessolicitudpanel($year,$month);
        $this->view->vehiculos = $this->_archivo->getvehculossolicitudes($year,$month);
        $this->view->nomina = $this->_archivo->getnomiasolicitudes($year,$month);
        $this->view->tag = $this->_archivo->gettagconsumosm($year,$month);
        $this->view->viaticos = $this->_archivo->getviaticosm($year,$month);

    }


    public function requestchangeporcentajeAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
            $table="sitios_tipoproyecto";
            $result=$this->_sitio->changeporcentajesitio($post,$table);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }   

    }


}