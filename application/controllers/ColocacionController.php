<?php

class ColocacionController extends Zend_Controller_Action{
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
        $this->_colo = new Application_Model_GpsColocacionModel;

        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }
        
    }

	public function requestadddetailsitioajaxcolocacionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="detalle_colocacion";
            $id=$post['sitio'];
            $wh="id_sitiotipo";
            $datos = $this->_season->GetSpecific($table,$wh,$id);
            if (empty($datos)){
                $table="detalle_colocacion";
                $this->_project->insertdetallecolocacion($post,$table);
            }else{

            }

            // var_dump($datos);exit;

            $table = "detalle_colocacion";
            if($post['levantamiento_baseline'] != null || $post['levantamiento_baseline'] == ""){
                $date_bts = "levantamiento_baseline"; $dato_update =$post['levantamiento_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['levantamiento_forecast'] != null || $post['levantamiento_forecast'] == null){
                $date_bts = "levantamiento_forecast"; $dato_update =$post['levantamiento_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['levantamiento_actual'] != null || $post['levantamiento_actual'] == null){
                $date_bts = "levantamiento_actual"; $dato_update =$post['levantamiento_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['propuesta_baseline'] != null || $post['propuesta_baseline'] == null){
                $date_bts = "propuesta_baseline"; $dato_update =$post['propuesta_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['propuesta_forecast'] != null || $post['propuesta_forecast'] == null){
                $date_bts = "propuesta_forecast"; $dato_update =$post['propuesta_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['propuesta_actual'] != null || $post['propuesta_actual'] == null){
                $date_bts = "propuesta_actual"; $dato_update =$post['propuesta_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['preliminar_baseline'] != null || $post['preliminar_baseline'] == null) {
                $date_bts = "preliminar_baseline"; $dato_update =$post['preliminar_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['preliminar_forecast'] != null || $post['preliminar_forecast'] == null){
                $date_bts = "preliminar_forecast"; $dato_update =$post['preliminar_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['preliminar_actual'] != null || $post['preliminar_actual'] == null){
                $date_bts = "preliminar_actual"; $dato_update =$post['preliminar_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['redlines'] != null || $post['redlines'] == null){
                $date_bts = "redlines"; $dato_update =$post['redlines'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['final_baseline'] != null || $post['final_baseline'] == null){
                $date_bts = "final_baseline"; $dato_update =$post['final_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['final_forecast'] != null || $post['final_forecast'] == null){
                $date_bts = "final_forecast"; $dato_update =$post['final_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['final_actual'] != null || $post['final_actual'] == null){
                $date_bts = "final_actual"; $dato_update =$post['final_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['inicio_baseline'] != null || $post['inicio_baseline'] == null){
                $date_bts = "inicio_baseline"; $dato_update =$post['inicio_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['inicio_forecast'] != null || $post['inicio_forecast'] == null){
                $date_bts = "inicio_forecast"; $dato_update =$post['inicio_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['inicio_actual'] != null || $post['inicio_actual'] == null){
                $date_bts = "inicio_actual"; $dato_update =$post['inicio_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['termino_baseline'] != null || $post['termino_baseline'] == null){
                $date_bts = "termino_baseline"; $dato_update =$post['termino_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['termino_forecast'] != null || $post['termino_forecast'] == null){
                $date_bts = "termino_forecast"; $dato_update =$post['termino_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['termino_actual'] != null || $post['termino_actual'] == null){
                $date_bts = "termino_actual"; $dato_update =$post['termino_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }       

            var_dump($result);exit;
          if ($result) {

            echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
           
        }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
	}


    public function requestaddfilecolocacionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
            $id=$this->_session->id;
            $table="usuario";
            $wh="id";
            $usuario= $this->_season->GetSpecific($table,$wh,$id);
            $user = $usuario[0]['nombre']." ".$usuario[0]['ap'];

        if($post['condicion'] == 1){ $set ="colocacion"; $fecha = "fecha_colocacion"; $carga_user = "user_colocacion";}
        if($post['condicion'] == 2){ $set ="proyecto_preliminar"; $fecha = "fecha_preliminar"; $carga_user ="user_preliminar";}
        if($post['condicion'] == 3){ $set ="proyecto_final"; $fecha = "fecha_final"; $carga_user ="user_final";}

        $name_sitio = $post['nombre_sitio'];
        $table="detalle_colocacionpdf";
        $wh="id_sitiotipo";
        $id=$post['sitio_tipoproyecto'];
        $detail_table= $this->_season->GetSpecific($table,$wh,$id);

        if (empty($detail_table)) {
            mkdir("pdf/sitios/colocacion/".$name_sitio.""); 
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
                    $url1 = 'pdf/sitios/colocacion/'.$name_sitio.'/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            $id=$detail_table[0]['id'];
            // var_dump($id);exit;
            $table="detalle_colocacionpdf";
            $hoy = date("Y-m-d H:i:s");
            $result = $this->_sitio->insertpdfdetallebts($post,$table,$id,$urldb,$set,$fecha,$hoy,$user,$carga_user);

            if ($result) {
                return $this-> _redirect('/panel/detallescolocacion/id/'.$post["id_sitio"].'/proyecto/'.$post["id_tipoproyecto"].'/sitio/'.$post["sitio_tipoproyecto"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestaddevidenciaproyectocolocacionAction(){
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
                    $url1 = 'img/sitios/colocaciones/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            } 

            $table="semanauno_colocacion";
            $id=$post['sitio'];
            $wh="idsitio_tipo";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            if(empty($usr)){
                $table="semanauno_colocacion";
                $result1 = $this->_colo->insertfotopreliminarcolocacion($post,$table);
                // var_dump($result1);exit;
                if ($post['actividad'] == 1){
                    $status = "status_excavacion";
                    $imagen ="excavacion_trayectoria";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 2){
                    $status = "status_basemedicion";
                    $imagen ="base_medicion";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 3){
                    $status = "status_basecuchillas";
                    $imagen ="base_cuchillas";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 4){
                    $status = "status_registrosfo";
                    $imagen ="registro_fo";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 5){
                    $status = "status_registroselectricos";
                    $imagen ="registros_electricos";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 6){
                    $status = "status_tuberiafo";
                    $imagen ="tuberia_fo";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 7){
                    $status = "status_tuberiaelectrica";
                    $imagen ="tuberia_electrica";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 8){
                    $status = "status_trayectoriaaerea";
                    $imagen ="trayectoria_aerea";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 9){
                    $status = "status_planchaequipos";
                    $imagen ="plancha_equipos";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 10){
                    $status = "status_telescopio";
                    $imagen ="telescopio";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 11){
                    $status = "status_sistematierras";
                    $imagen ="sistema_tierras";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 12){
                    $status = "status_interruptores";
                    $imagen ="interruptores";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 13){
                    $status = "status_nichocarga";
                    $imagen ="nicho_carga";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 14){
                    $status = "status_fuerzasoporte";
                    $imagen ="fuerza_soporte";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 15){
                    $status = "status_instalacioncable";
                    $imagen ="instalacion_cable";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 16){
                    $status = "status_interconexiones";
                    $imagen ="interconexiones";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 17){
                    $status = "status_orientacionrf";
                    $imagen ="orientacion_rf";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 18){
                    $status = "status_instalacioncgo";
                    $imagen ="instalacion_cgo";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 19){
                    $status = "status_instalacionbarras";
                    $imagen ="instalacion_barras";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 20){
                    $status = "status_aterrizajebarras";
                    $imagen ="aterrizaje_barras";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 21){
                    $status = "status_portacablera";
                    $imagen ="porta_cablera";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 22){
                    $status = "status_sistemaelectrico";
                    $imagen ="sistema_electrico";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 23){
                    $status = "status_fibraoptica";
                    $imagen ="fibra_optica";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 24){
                    $status = "status_sistematierra";
                    $imagen ="sistema_tierra";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 25){
                    $status = "status_limpieza";
                    $imagen ="limpieza_detalles";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

            }else{

                $result1=$usr[0]['id'];
                if ($post['actividad'] == 1){
                    $status = "status_excavacion";
                    $imagen ="excavacion_trayectoria";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 2){
                    $status = "status_basemedicion";
                    $imagen ="base_medicion";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 3){
                    $status = "status_basecuchillas";
                    $imagen ="base_cuchillas";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 4){
                    $status = "status_registrosfo";
                    $imagen ="registro_fo";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 5){
                    $status = "status_registroselectricos";
                    $imagen ="registros_electricos";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 6){
                    $status = "status_tuberiafo";
                    $imagen ="tuberia_fo";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 7){
                    $status = "status_tuberiaelectrica";
                    $imagen ="tuberia_electrica";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 8){
                    $status = "status_trayectoriaaerea";
                    $imagen ="trayectoria_aerea";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 9){
                    $status = "status_planchaequipos";
                    $imagen ="plancha_equipos";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 10){
                    $status = "status_telescopio";
                    $imagen ="telescopio";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 11){
                    $status = "status_sistematierras";
                    $imagen ="sistema_tierras";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 12){
                    $status = "status_interruptores";
                    $imagen ="interruptores";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 13){
                    $status = "status_nichocarga";
                    $imagen ="nicho_carga";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 14){
                    $status = "status_fuerzasoporte";
                    $imagen ="fuerza_soporte";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 15){
                    $status = "status_instalacioncable";
                    $imagen ="instalacion_cable";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 16){
                    $status = "status_interconexiones";
                    $imagen ="interconexiones";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 17){
                    $status = "status_orientacionrf";
                    $imagen ="orientacion_rf";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 18){
                    $status = "status_instalacioncgo";
                    $imagen ="instalacion_cgo";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 19){
                    $status = "status_instalacionbarras";
                    $imagen ="instalacion_barras";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 20){
                    $status = "status_aterrizajebarras";
                    $imagen ="aterrizaje_barras";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 21){
                    $status = "status_portacablera";
                    $imagen ="porta_cablera";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 22){
                    $status = "status_sistemaelectrico";
                    $imagen ="sistema_electrico";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 23){
                    $status = "status_fibraoptica";
                    $imagen ="fibra_optica";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 24){
                    $status = "status_sistematierra";
                    $imagen ="sistema_tierra";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 25){
                    $status = "status_limpieza";
                    $imagen ="limpieza_detalles";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
            }

            if ($result) {
                return $this-> _redirect('/panel/detallescolocacion/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST ADD CERTIFICADO MEDICO PERSONAL DE CAMPO



    public function requestupdatevidenciassemanaunocolocacionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        if($this->getRequest()->getPost()){
            $post = $this->getRequest()->getPost();
            $table="semanauno_colocacion";
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
                    $url1 = 'img/sitios/colocaciones/'; 
                    $urldb = $url1.$ran.$ext1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="semanauno_colocacion";
            $id=$post['sitio'];
            $wh="idsitio_tipo";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $result1=$usr[0]['id'];

                if ($post['actividad'] == 1){
                    $status = "status_excavacion";
                    $imagen ="excavacion_trayectoria";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 2){
                    $status = "status_basemedicion";
                    $imagen ="base_medicion";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 3){
                    $status = "status_basecuchillas";
                    $imagen ="base_cuchillas";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 4){
                    $status = "status_registrosfo";
                    $imagen ="registro_fo";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 5){
                    $status = "status_registroselectricos";
                    $imagen ="registros_electricos";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 6){
                    $status = "status_tuberiafo";
                    $imagen ="tuberia_fo";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 7){
                    $status = "status_tuberiaelectrica";
                    $imagen ="tuberia_electrica";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 8){
                    $status = "status_trayectoriaaerea";
                    $imagen ="trayectoria_aerea";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 9){
                    $status = "status_planchaequipos";
                    $imagen ="plancha_equipos";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 10){
                    $status = "status_telescopio";
                    $imagen ="telescopio";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 11){
                    $status = "status_sistematierras";
                    $imagen ="sistema_tierras";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 12){
                    $status = "status_interruptores";
                    $imagen ="interruptores";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 13){
                    $status = "status_nichocarga";
                    $imagen ="nicho_carga";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 14){
                    $status = "status_fuerzasoporte";
                    $imagen ="fuerza_soporte";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 15){
                    $status = "status_instalacioncable";
                    $imagen ="instalacion_cable";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 16){
                    $status = "status_interconexiones";
                    $imagen ="interconexiones";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 17){
                    $status = "status_orientacionrf";
                    $imagen ="orientacion_rf";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 18){
                    $status = "status_instalacioncgo";
                    $imagen ="instalacion_cgo";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 19){
                    $status = "status_instalacionbarras";
                    $imagen ="instalacion_barras";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 20){
                    $status = "status_aterrizajebarras";
                    $imagen ="aterrizaje_barras";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 21){
                    $status = "status_portacablera";
                    $imagen ="porta_cablera";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 22){
                    $status = "status_sistemaelectrico";
                    $imagen ="sistema_electrico";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 23){
                    $status = "status_fibraoptica";
                    $imagen ="fibra_optica";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }

                if ($post['actividad'] == 24){
                    $status = "status_sistematierra";
                    $imagen ="sistema_tierra";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }
                if ($post['actividad'] == 25){
                    $status = "status_limpieza";
                    $imagen ="limpieza_detalles";
                    $result = $this->_project->refresactividadsemanauno($post, $table, $result1, $urldb, $status, $imagen);
                }



            if ($result) {
                return $this-> _redirect('/panel/editevidenciascolocacion/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
            return $this-> _redirect('/panel/editevidenciascolocacion/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["sitio"].'');
        }
    }//END REQUEST EDIT WK 1 BTS

    public function requestadddetailtwositioajaxcolocacionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="detalle_colocaciondos";
            $id=$post['sitio'];
            $wh="id_sitiotipo";
            $datos = $this->_season->GetSpecific($table,$wh,$id);
            if (empty($datos)){
                $this->_project->insertdetallecolocacion($post,$table);
            }


            // var_dump($post);exit;


            $table = "detalle_colocaciondos";
            if($post['reportesitio_baseline'] != null || $post['reportesitio_baseline'] == null){
                $date_bts = "sitioterminado_baseline"; $dato_update =$post['reportesitio_baseline'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['reportesitio_forecast'] != null || $post['reportesitio_forecast'] == null){
                $date_bts = "sitioterminado_forecast"; $dato_update =$post['reportesitio_forecast'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['reportesitio_actual'] != null || $post['reportesitio_actual'] == null){
                $date_bts = "sitioterminado_actual"; $dato_update =$post['reportesitio_actual'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['entrega_sitio'] != null || $post['entrega_sitio'] == null){
                $date_bts = "entrega_cliente"; $dato_update =$post['entrega_sitio'];
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

            if($post['baseline_correcciondetalles'] != null || $post['baseline_correcciondetalles'] == null){
                $date_bts = "correccion_baseline"; $dato_update =$post['baseline_correcciondetalles'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['forecast_correcciondetalles'] != null || $post['forecast_correcciondetalles'] == null){
                $date_bts = "correccion_forecast"; $dato_update =$post['forecast_correcciondetalles'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['actual_correcciondetalles'] != null || $post['actual_correcciondetalles'] == null){
                $date_bts = "correccion_actual"; $dato_update =$post['actual_correcciondetalles'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['protocolo_limpio'] != null || $post['protocolo_limpio'] == null){
                $date_bts = "protocolo_operador"; $dato_update =$post['protocolo_limpio'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }


            if($post['baseline_asbuilt'] != null || $post['baseline_asbuilt'] == null){
                $date_bts = "asbuilt_baseline"; $dato_update =$post['baseline_asbuilt'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['forecast_asbuilt'] != null || $post['forecast_asbuilt'] == null){
                $date_bts = "asbuilt_forecast"; $dato_update =$post['forecast_asbuilt'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['actual_asbuilt'] != null || $post['actual_asbuilt'] == null){
                $date_bts = "asbuilt_actual"; $dato_update =$post['actual_asbuilt'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['baseline_liberacion'] != null || $post['baseline_liberacion'] == null){
                $date_bts = "liberacion_baseline"; $dato_update =$post['baseline_liberacion'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }

            if($post['forecast_asbuilt'] != null || $post['forecast_asbuilt'] == null){
                $date_bts = "liberacion_forecast"; $dato_update =$post['forecast_asbuilt'];
                $result = $this->_project->updatedetallebts($date_bts,$dato_update,$table,$post);
            }


            if($post['actual_liberacion'] != null || $post['actual_liberacion'] == null){
                $date_bts = "liberacion_actual"; $dato_update =$post['actual_liberacion'];
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


    public function requestaddfilebtstwocolocacionAction(){
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
        if($post['condicion'] == 5){ $set ="pdf_asbuilt"; $fecha = "fecha_asbuilt"; $carga_user = "user_asbuilt";}
        if($post['condicion'] == 6){ $set ="pdf_cartaliberacion"; $fecha="fecha_cartaliberacion"; $carga_user="user_cartaliberacion";}

        $name_sitio = $post['nombre_sitio'];
        $table="detalle_colocacionpdfdos";
        $wh="id_sitiotipo";
        $id=$post['sitio_tipoproyecto'];
        $detail_table= $this->_season->GetSpecific($table,$wh,$id);

        if (empty($detail_table)) {
            mkdir("pdf/sitios/colocacion/".$name_sitio.""); 
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
                    $url1 = 'pdf/sitios/colocacion/'.$name_sitio.'/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            $id=$detail_table[0]['id'];
            $table="detalle_colocacionpdfdos";
            $hoy = date("Y-m-d H:i:s");
            // var_dump($set);exit;
            $result = $this->_sitio->insertpdfdetallebts($post,$table,$id,$urldb,$set,$fecha,$hoy,$user,$carga_user);

            if ($result) {
                return $this-> _redirect('/panel/detallescolocacion/id/'.$post["id_sitio"].'/proyecto/'.$post["id_tipoproyecto"].'/sitio/'.$post["sitio_tipoproyecto"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }


    public function requestupdatecomentariositiocolocacionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost(); 
        if($this->getRequest()->getPost()){
            $table="detalle_comentarios";
            $result = $this->_user->refreshcomentariositio($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/detallescolocacion/id/'.$post['id'].'/proyecto/'.$post['proyecto'].'/sitio/'.$post['sitio'].' ');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }

    }



        public function randomnamebts(){

            $ran =  rand();
            return 'bts-wk1-'.$ran;

        }//fin de random WK 1

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