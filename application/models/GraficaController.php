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

        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }
        
    }

    public function btsprojectAction(){
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
        $ver = $this->view->cajachica = $this->_comprobacion->getmesfacturapanel($year,$month);
        $this->view->sol_cajachica = $this->_comprobacion->getmessolicitudpanel($year,$month);
        // var_dump($ver);exit;
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