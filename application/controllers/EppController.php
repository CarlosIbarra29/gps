<?php

class EppController extends Zend_Controller_Action{
	private $_season;
    private $_session;
    private $_user;
    private $_epp;
    private $_her;

    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_project = new Application_Model_GpsProyectoModel;
        $this->_colo = new Application_Model_GpsColocacionModel;
        $this->_epp = new Application_Model_GpsEppModel;
        $this->_her = new Application_Model_GpsHerramientaModel;

        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }
    }

    public function catalogoAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table = "epp_catalogo"; 
        $this->view->alertas=$this->_epp->GetEPPxVen($table);

        $table = "epp_catalogo"; 
        $this->view->alertasvencidas=$this->_epp->GetEPPSinStock($table);

        $table="epp_tipo";
        $this->view->eppt = $this->_season->GetAll($table);

        $table="epp_catalogo";
        $eppinv=$this->_season->GetAll($table);
        $count=count($eppinv);

        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
        } else {
            $pagina= $this->view->pagina = 1;
        } 

        $no_of_records_per_page = 15;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $table="epp_catalogo";
        $sql= $this->view->paginator= $this->_epp->Getpaginationepp($table,$offset,$no_of_records_per_page);  


    }// END EPP

    public function requestaddeppAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="epp_catalogo";
 
            $result = $this->_epp->insertepp($post,$table);

            if ($result) {
                return $this-> _redirect('/epp/catalogo');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END ADD EPP


    public function requestdeleteeppAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="epp_catalogo";
            $wh="idepp";
            $result = $this->_season->deleteAll($id,$table,$wh);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST DELETE EPP

    public function eppeditAction(){
           if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="epp_catalogo";
            $wh="idepp";
            $this->view->epp_inv = $this->_season->GetSpecific($table,$wh,$id);

            $table="epp_tipo";
            $this->view->eppt = $this->_season->GetAll($table);

            $table="categoria_herramienta";
            $this->view->categorias = $this->_season->GetAll($table);

            $table="personal_campo";
            $this->view->per= $this->_season->GetAll($table);

            $table="sitios";
            $this->view->sitio= $this->_season->GetAll($table);
        }else {
            return $this-> _redirect('/');
        }   

    }//END EPPEDIT

    public function requestupdateeppAction(){
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);
    $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            $table="epp_catalogo";
            $result = $this->_epp->updateepp($post,$table);
            if ($result) {
                return $this-> _redirect('/epp/catalogo');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST update EPP

    public function exceleppAction(){
        $status=$this->_getParam('status');
        $this->view->status=$status;
        $this->view->excelepp = $this->_epp->eppexcel();
    }// Excel EPP

     public function excelasignacionAction(){
    
        $this->view->excelepp = $this->_epp->eppasignacion();
    }// Excel EPP


    public function buscareppAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="epp_tipo";
        $this->view->eppt = $this->_season->GetAll($table);

        if($this->_hasParam('nombre')){
            $name = $this->_getParam('nombre');
            $nombre_epp= $this->_epp->nepp($name);
            $option= 1;
            $this->view->name_epp=$name; 
            
            $tal = "vacio";
            $this->view->talla_epp=$tal;

            $this->view->option=$option; 
            $count=count($nombre_epp);
            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            }   
            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->paginator= $this->_epp->eppnamecount($name,$offset,$no_of_records_per_page);
        }

        if($this->_hasParam('tallas')){
            $tallas = $this->_getParam('tallas');
            $talla_e= $this->_epp->tallaepp($tallas);
            $this->view->talla_epp=$tallas;
          
            $name = "vacio";
            $this->view->name_epp=$name; 

            $option= 2;
            $this->view->option=$option;
            $count=count($talla_e);
            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            }else{
                $pagina= $this->view->pagina = 1;
            }   
            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;


            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->paginator= $this->_epp->epptallacount($tallas,$offset,$no_of_records_per_page);
        }

    } //End Buscar Epp

    public function tipoAction(){
        
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="epp_tipo";
        $this->view->tipo_epp = $this->_season->GetAll($table);

        $epp_t=$this->_season->GetAll($table);
        $count=count($epp_t);

        if (isset($_GET['pagina'])) {
            $pagina = $_GET['pagina'];
        } else {
            $pagina= $this->view->pagina = 1;
        } 

        $no_of_records_per_page = 15;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $table="epp_tipo";
        $sql= $this->view->paginator= $this->_epp->Getpaginationtipo($table,$offset,$no_of_records_per_page); 

    }   // Tipo de EPP

    public function requestaddtipoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            $table="epp_tipo";
            $result = $this->_epp->inserttipo($post,$table);
            if ($result) {
                return $this-> _redirect('/epp/tipo');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END add tipo de EPP

    public function buscartipoAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        if($this->_hasParam('nombre')){
            $tipo = $this->_getParam('nombre');
            $nombre = strstr($tipo, '?', true); 
            if($nombre == false){
                $name = $this->_getParam('nombre');
            }else{
                 $name = strstr($tipo, '?', true); 
            }

            $this->view->name_search=$name;
            $usuarios=$this->_epp->tiponombre($name);
            $count=count($usuarios); 
            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 


            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->paginator= $this->_epp->tipocount($name,$offset,$no_of_records_per_page);
        }
    } //Buscar Tipo

    public function tipoeditAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="epp_tipo";
            $wh="id_tipo";
            $this->view->tipo_epp = $this->_season->GetSpecific($table,$wh,$id);
        }else {
            return $this-> _redirect('/');
        }   
    }//End Tipo Edit

    public function requestupdatetipoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            $table="epp_tipo";
            $result = $this->_epp->updatetipo($post,$table);
            if ($result) {
                return $this-> _redirect('/epp/tipo');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST UPDATE TIPO

    public function asignareppAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->personal_epp= $this->_epp->GetPersonalEpp($id);

            $id_user=$this->_session->id;
            $this->view->usuario = $id_user;

            $wh="id";
            $table="usuario";
            $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);

            $table="epp_asignar";
            $wh="id_personal";
            $status=0;
            $this->view->eppasignado = $this->_epp->GetEppAsignado($table,$wh,$id,$status);

            $table="epp_tipo";
            $this->view->tipo_epp= $this->_season->GetAll($table);

            $table="epp_catalogo";
            $hola=$this->view->eppn= $this->_epp->Getcatalogo($table);

            $personal = $this->_getParam('id');
            $this->view->idpersonal=$personal;
        }else {
            return $this-> _redirect('/');
        }       

    } // End Asignar Epp

    public function requesteppdelAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="epp_asignar";
            $wh="id";
            $result = $this->_epp->updatestatus($id,$table,$wh);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST EPP Desasignado

    public function requesteppregresarAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            $id =  $post['id'];
            $table="epp_asignar";
            $wh= "id";
            $datos = $this->_season->GetSpecific($table,$wh,$id);
            $id_epp = $datos[0]['id_epp'];
            $cantidad =$datos[0]['cantidad'];


            $table = "epp_catalogo";
            $catalogo = $this->_epp->GetRegresar($table,$id_epp);
            
            $cantidadAct = $catalogo[0]['stock'];
            
            $nuevostock = $cantidadAct + $cantidad;
            
            $table="epp_catalogo";
            $this->_epp->updateStock2($post,$table,$nuevostock,$id_epp);
            
            // $id =  $post['id'];
            $table="epp_asignar";
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


    public function requestasignareppAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
                
            $encampo = $post ['campo'];
            if ($encampo == true) {

                $id=$post['talla'];
                $table="epp_catalogo";
                $vida=$this->_epp->buscarrep($id,$table);
                
                $vidap=implode($vida[0]);
                $date=$post['fecha'];
                $fechanew=date('Y-m-d', strtotime($date. ' +'.$vidap.' days'));

                $cobro=$post['cobro']; 
                if ($cobro == true) {
                    $statusc = 1;
                }else{
                    $statusc=0;
                }

                $table="epp_asignar";
                $result = $this->_epp->insertasgcompra($post,$table,$fechanew,$statusc);

                if ($result) {
                    return $this-> _redirect('/epp/asignarepp/id/'.$post['idhs'].''); 
                }else{
                    print '<script language="JavaScript">'; 
                    print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                    print '</script>'; 
                }

            } else {

                $id=$post['talla'];
                $table="epp_catalogo";
                $vida=$this->_epp->buscarrep($id,$table);
                
                $vidap=implode($vida[0]);
                $date=$post['fecha'];
                $fechanew=date('Y-m-d', strtotime($date. ' +'.$vidap.' days'));

                $cobro=$post['cobro']; 
                if ($cobro == true) {
                    $statusc = 1;
                }else{
                    $statusc=0;
                }

                $table="epp_asignar";
                $this->_epp->insertasignacion($post,$table,$fechanew,$statusc);


                $table="epp_catalogo";
                $result = $this->_epp->UpdateStock($post,$table);

                if ($result) {
                    return $this-> _redirect('/epp/asignarepp/id/'.$post['idhs'].''); 
                }else{
                    print '<script language="JavaScript">'; 
                    print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                    print '</script>'; 
                }
            }
        }        
    }// End Request Asignar -herramienta



    public function gettallasAction(){

        $this->_helper->layout()->disableLayout();

        $this->_helper->viewRenderer->setNoRender(true);

        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){
        
            $letra = $post['epp'];
        
            $result = $this->_epp->consultaTallas($letra);

            print json_encode($result);

            exit;
            
            // return $html;

            // $html="";

            // // foreach ($result as $key => $value) {
        
            //     $html.="<option value='".$value['idepp']."'>".$value['talla']."</option>";
        
            // }
        
        //     echo $html;

        //     if ($result) {
        
        //         echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
        
        //     }else{
        
        //         print '<script language="JavaScript">';
        //         print 'alert("Ocurrio un error: Comprueba los datos.");';
        //         print '</script>';
        
        //     }
        
         }
    }//END REQUEST get TALLAS


    public function gettallassinAction(){

        $this->_helper->layout()->disableLayout();

        $this->_helper->viewRenderer->setNoRender(true);

        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){
        
            $letra = $post['epp'];
        
            $result = $this->_epp->consultaTallassin($letra);

            print json_encode($result);

            exit;
            
            // return $html;

            // $html="";

            // // foreach ($result as $key => $value) {
        
            //     $html.="<option value='".$value['idepp']."'>".$value['talla']."</option>";
        
            // }
        
        //     echo $html;

        //     if ($result) {
        
        //         echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
        
        //     }else{
        
        //         print '<script language="JavaScript">';
        //         print 'alert("Ocurrio un error: Comprueba los datos.");';
        //         print '</script>';
        
        //     }
        
         }
    }//END REQUEST get TALLAS


    public function asignadetailAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->personal= $this->_epp->Regresar($id);
            
            $table="epp_asignar";
            $this->view->detalles= $this->_epp->DetallesEPP($id);

        }else {
            return $this-> _redirect('/');
        }  
    } // Detalles de EPP Asignado

    public function asignaeditAction(){
        
        if($this->_hasParam('id')){
            
            $id = $this->_getParam('id');
            $this->view->personal= $this->_epp->Regresar($id);
           
            $table="epp_asignar";
            $this->view->asignado= $this->_epp->DetallesEPP($id);


            $table="epp_asignar";;
            $wh = "id";
            $detalle= $this->_season->GetSpecific($table,$wh,$id);

            $talla = $detalle[0]['descripcion'];
            $tallita=$this->view->tallaget= $this->_epp->GetTalla($talla);

            // var_dump($detalle);
            // die();

            $table="epp_tipo";
            $this->view->tipo = $this->_season->GetAll($table);
        
        } else {
        
            return $this-> _redirect('/');
        
        }   
    }


    public function requestupdateasigAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){

            $id=$post['id_epp'];
            $table="epp_catalogo";
            $vida=$this->_epp->buscarrep($id,$table);
         
            $vidap=implode($vida[0]);
            $date=$post['fecha'];
            $fechanew=date('Y-m-d', strtotime($date. ' +'.$vidap.' days'));


            $table="epp_asignar";
            $result = $this->_epp->UpdateEppP($post,$table,$fechanew);
            
            if ($result) {
                return $this-> _redirect('/epp/asignarepp/id/'.$post['ids'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST UPDATE ASINADO


    public function historialAction(){
        
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->personales= $this->_epp->GetPersonalEpp($id);
            
           
            $table="responsivas";
            $this->view->responsiva= $this->_epp->Responsiva($id);

        }else {
            return $this-> _redirect('/');
        }         

    }

    
    public function requestresponsivaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="responsivas";
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
                    $url1 = 'img/epp/responsivas/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");
            $table="responsivas";

            $result = $this->_epp->insertresponsiva($post,$table,$urldb,$hoy);

            if ($result) {
                return $this-> _redirect('/epp/historial/id/'.$post['idper'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END Responsiva

    public function eppmasignarAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->personal_epp= $this->_epp->GetPersonalEpp($id);

            $table="epp_catalogo";
            $hola=$this->view->eppn= $this->_epp->Getcatalogo($table);


            $personal = $this->_getParam('id');
            $this->view->idpersonal=$personal;
        }else {
            return $this-> _redirect('/');
        }       

    } // End Asignar Epp

    public function responsivaAction(){

         if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->personal_epp= $this->_epp->GetPersonalEpp($id);
            

            $table="epp_asignar";
            $wh="id_personal";
            $status=0;
            $this->view->eppasignado = $this->_epp->GetEppAsignado($table,$wh,$id,$status);

            $table="epp_asignar";
            $wh="id_personal";
            $status=0;
            $cobro=1;
            $this->view->eppcobro = $this->_epp->GetEppCobro($table,$wh,$id,$status,$cobro);

            
        }else {
            return $this-> _redirect('/');
        }       

    }

    

    public function eppcostoAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="personal_campo";
        $sql = $this->_epp->GetPersonalCobro($table);
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_cobro=$status;

        if($status == 1){
            $table="personal_campo";
            $eppcobros=$this->_epp->Getcobroeppnomina($status);
            $count=count($eppcobros);

            if (isset($_GET['pagina'])){ $pagina =$_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 
            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="personal_campo";
            $sql= $this->view->paginator= $this->_epp->getnominacobroepppaginator($status,$offset,$no_of_records_per_page);  
        }

        if($status == 2){

            $table="personal_campo";
            $eppcobros=$this->_epp->GetPersonalCobroPag($table);
            $count=count($eppcobros);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="personal_campo";
            $sql= $this->view->paginator= $this->_epp->GetpaginationcobroPag($table,$offset,$no_of_records_per_page); 
        }

    }// END Cobro EPP


    public function eppcostobuscadorAction(){

        $table="personal_campo";
        $sql = $this->_epp->GetPersonalCobro($table);
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_cobro=$status;


        if($status == 1){
             $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;

            $nombre = $this->_getParam('nombre');
            $this->view->nombre_p=$nombre;

            $table="personal_campo";
            $eppcobros=$this->_epp->GetPersonalCobroB($table,$nombre);
            $count=count($eppcobros);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="personal_campo";
            $sql= $this->view->paginator= $this->_epp->GetpaginationcobroB($table,$nombre,$offset,$no_of_records_per_page);  
        }


          if($status == 2){
            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;

            $nombre = $this->_getParam('nombre');
            $this->view->nombre_p=$nombre;

            $table="personal_campo";
            $eppcobros=$this->_epp->GetPersonalCobroPagB($table,$nombre);
            $count=count($eppcobros);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 15;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="personal_campo";
            $sql= $this->view->paginator= $this->_epp->GetpaginationcobroPagB($table,$nombre,$offset,$no_of_records_per_page); 
        }
    }


    public function eppdetailcostoAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            $this->view->personal_epp= $this->_epp->GetPersonalEpp($id);

            $table="epp_asignar";
            $wh="id";
            $status=0;
            $cobro=1;
            $this->view->eppcobro = $this->_epp->GetEppCobronomina($table,$wh,$id,$status,$cobro);

        }else {
            return $this-> _redirect('/');
        }  
    } // Detalles de EPP Asignado

    public function eppdetailcostopAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->personal_epp= $this->_epp->GetPersonalEpp($id);

            $table="epp_asignar";
            $wh="id_personal";
            $status=0;
            $cobro=2;
            $this->view->eppcobros = $this->_epp->GetEppCobro($table,$wh,$id,$status,$cobro);

            $table="epp_cobro";
            $wh="id_personal";
            $this->view->eppcobro = $this->_season->GetSpecific($table,$wh,$id);

        }else {
            return $this-> _redirect('/');
        }  
    } // Detalles de EPP Asignado

//Status 0 = sin cobro Status 1 = Cobro Status 2 = CObrado 

    public function requestcostoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            $table="epp_asignar";
            $wh="id_personal";
            $status=0;
            $cobro=1;
            $id=$post['idpe'];
            $datos=$this->view->eppcobro = $this->_epp->GetEppCobro($table,$wh,$id,$status,$cobro);
           
            foreach ($datos as $key => $value) {
            
            $resultado = null;
           
            $resultado = $this->_epp->UpdateCobro($value['id'],$table);
            
            }

            $table="epp_cobro";
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
                    $url1 = 'img/epp/cobros/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");

            $result = $this->_epp->insertcobro($post,$table,$urldb,$hoy);
            if ($result) {
                return $this-> _redirect('/epp/eppcosto/status/2');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END Add Comprobante Pago


    public function eppdetailAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            
            $wh = "idepp";
            $table="epp_catalogo";
            $this->view->inf= $this->_season->GetSpecific($table,$wh,$id);

        }else {
            return $this-> _redirect('/');
        }  
    } // Detalles de EPP Asignado


    public function personalAction(){

        $table="personal_campo";
        $this->view->personal_campo = $this->_epp->GetAllPsn($table);

    }

    //////////////////////////////// Solicitudes EPP //////////////////////////////////

    public function eppsolAction(){

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        
        $solicitud = $this->_epp->GetSolStepEPP();
        $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_epp->GetStepEpppaginator($offset,$no_of_records_per_page);

    }

    public function addsolicitudeppAction(){

        $table="personal_campo";
        $this->view->personal_campo = $this->_epp->GetAllPsn($table);

    }


    public function requestpasounoeppAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){
           
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id_user = $usr[0]['id'];
            $name_user = $usr[0]['nombre'].' '. $usr[0]['ap'].' '.$usr[0]['am'];
    

            $table="epp_solicitudes";
            $result = $this->_epp->insertsolepp1($post,$table,$id_user,$name_user);

            if ($result) {
                return $this-> _redirect('/epp/addsoleppdos/id/'.$result.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }


    public function updatesoleppAction(){

        $id=$this->_getParam('id');
        $this->view->ids = $id;
        
        $wh="id";
        $table="epp_solicitudes";
        $this->view->solicitudes = $this->_season->GetSpecific($table,$wh,$id);

        $table="personal_campo";
        $this->view->personal_campo = $this->_epp->GetAllPsn($table);

    }


    public function requestupdsoleppAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id_user = $usr[0]['id'];
            $name_user = $usr[0]['nombre'].' '. $usr[0]['ap'].' '.$usr[0]['am'];
            // var_dump($name_user);
            // die();

            $table="epp_solicitudes";
            $result = $this->_epp->UpdateSolPUno($post,$table,$id_user,$name_user);
            
            if ($result) {
                return $this-> _redirect('/epp/addsoleppdos/id/'.$post['ids'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }


    public function requestdeleppsolAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="epp_solicitudes";
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


    public function addsoleppdosAction(){
       
        $id =$this->_getParam('id');
        $this->view->id = $id;
        $wh="id";
        $table="epp_solicitudes";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $id_personal = $usr[0]['id_personal'];
        $this->view->idpersonals = $id_personal;

        $this->view->personalsel = $this->_epp->GetPersonalSel($id_personal);


        $this->view->eppasignado = $this->_epp->GetEppAsgAct($id_personal);

        $table="epp_catalogo";
        $hola=$this->view->eppn= $this->_epp->GetcatalogoSol($table);

        $this->view->eppxasignar = $this->_epp->GetEppXasg($id);
        

    }// SOL Paso 2


    public function requestasgeppsolAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
                
            $id=$post['talla'];
            $wh="idepp";
            $table="epp_catalogo";
            $eppcat = $this->_season->GetSpecific($table,$wh,$id);
            $tipo = $eppcat[0]['tipo_epp'];

            $table="epp_asignarsol";
            $result =  $this->_epp->insertasignacionsol($post,$table,$tipo);

            if ($result) {
                return $this-> _redirect('/epp/addsoleppdos/id/'.$post['solid'].''); 
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }        
    }// End Request Asignar -herramienta

    public function requestdelasgAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="epp_asignarsol";
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


    public function requestaddsolvehdosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");

            $table="epp_solicitudes";
            $result = $this->_epp->UpdateSolPasDos($post,$table,$hoy);
            if ($result) {
                return $this-> _redirect('/epp/eppsol');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }

        }
    }   // Solicitud Terminada Paso 2

    //////////////////////////////////////////// Solicitud EPP ESPecific //////////////////////////////////////////////

    public function eppsolspecificAction(){

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
            
        $user = $this->_season->GetSpecific($table,$wh,$id);
        $id_user = $user[0]['id'];

        $solicitud = $this->_epp->GetSolStepEPPSpecific($id_user);
        $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_epp->GetStepEppSpecificpaginator($id_user,$offset,$no_of_records_per_page);

    }


    public function addsoleppspecificAction(){

        $table="personal_campo";
        $this->view->personal_campo = $this->_epp->GetAllPsn($table);

    }


     public function requestpasounoeppspfAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){
           
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id_user = $usr[0]['id'];
            $name_user = $usr[0]['nombre'].' '. $usr[0]['ap'].' '.$usr[0]['am'];
    

            $table="epp_solicitudes";
            $result = $this->_epp->insertsolepp1($post,$table,$id_user,$name_user);

            if ($result) {
                return $this-> _redirect('/epp/addsoleppdosspf/id/'.$result.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }


    public function addsoleppdosspfAction(){
       
        $id =$this->_getParam('id');
        $this->view->id = $id;
        $wh="id";
        $table="epp_solicitudes";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $id_personal = $usr[0]['id_personal'];
        $this->view->idpersonals = $id_personal;

        $this->view->personalsel = $this->_epp->GetPersonalSel($id_personal);


        $this->view->eppasignado = $this->_epp->GetEppAsgAct($id_personal);

        $table="epp_catalogo";
        $hola=$this->view->eppn= $this->_epp->GetcatalogoSol($table);

        $this->view->eppxasignar = $this->_epp->GetEppXasg($id);

    }// SOL specific Paso 2

    public function requestaddsoldosspfAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");

            $table="epp_solicitudes";
            $result = $this->_epp->UpdateSolPasDos($post,$table,$hoy);
            if ($result) {
                return $this-> _redirect('/epp/eppsolspecific');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }

        }
    }   // Solicitud Specific Terminada Paso 2


    public function updatesoleppspfAction(){

        $id=$this->_getParam('id');
        $this->view->ids = $id;
        
        $wh="id";
        $table="epp_solicitudes";
        $this->view->solicitudes = $this->_season->GetSpecific($table,$wh,$id);

        $table="personal_campo";
        $this->view->personal_campo = $this->_epp->GetAllPsn($table);

    }

    public function requestasgeppsolspfAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
                
            $id=$post['talla'];
            $wh="idepp";
            $table="epp_catalogo";
            $eppcat = $this->_season->GetSpecific($table,$wh,$id);
            $tipo = $eppcat[0]['tipo_epp'];

            $table="epp_asignarsol";
            $result =  $this->_epp->insertasignacionsol($post,$table,$tipo);

            if ($result) {
                return $this-> _redirect('/epp/addsoleppdosspf/id/'.$post['solid'].''); 
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }        
    }// End Request Asignar -herramienta

    public function requestupdsolspfAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id_user = $usr[0]['id'];
            $name_user = $usr[0]['nombre'].' '. $usr[0]['ap'].' '.$usr[0]['am'];
            // var_dump($name_user);
            // die();

            $table="epp_solicitudes";
            $result = $this->_epp->UpdateSolPUno($post,$table,$id_user,$name_user);
            
            if ($result) {
                return $this-> _redirect('/epp/addsoleppdosspf/id/'.$post['ids'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }



    ////////////////// Listas Solicitudes Admin /////////////////////////////////////////


    public function listasolicitudesAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;
        $wh="id_usuario";
        $table="epp_solicitudes";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        // status_documento  enproceso
        
        $wh="id";
        $table="usuario";
        $user = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$user[0]['fkroles'];

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $sql = $this->_epp->GetSolCount();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table="personal_campo";
        $this->view->personal_campo = $this->_epp->GetAllPsn($table);

        if($status == 0) {

            $solicitud=$this->_epp->GetSolCount();
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="epp_solicitudes";
            $sql=$this->view->paginator= $this->_epp->GetSolProcesopaginator($table,$offset,$no_of_records_per_page);
            // var_dump($sql);exit;
        }

        if($status == 1){
            $solicitud=$this->_epp->GetSolEppAceptCount();

            $count=count($solicitud);

            if(isset($_GET['pagina'])) { 
                $pagina = $_GET['pagina']; 
            }else { 
                $pagina= $this->view->pagina = 1; 
            }

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="epp_solicitudes";
            $sql= $this->view->paginator= $this->_epp->GetSolAceptadaspaginator($table,$offset,$no_of_records_per_page);
        }

        if($status == 2){
            $solicitud=$this->_epp->GetSolEppCancelCount();
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="epp_solicitudes";
            $this->view->paginator= $this->_epp->GetSolCanceladaspaginator($table,$offset,$no_of_records_per_page);
        }

        if($status == 3){
            $solicitud=$this->_epp->GetSolEppSurtidoCount();
            // var_dump($solicitud);exit;
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="epp_solicitudes";
            $sql= $this->view->paginator= $this->_epp->GetSolSurtidaspaginator($table,$offset,$no_of_records_per_page);
        }
    }   // Lista solicitudes en proceso


    public function listasolbuscarAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;

        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$usr[0]['fkroles'];

        $wh="id_usuario";
        $table="epp_solicitudes";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $sql = $this->_epp->GetSolCount();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table="personal_campo";
        $this->view->personal_campo = $this->_epp->GetAllPsn($table);

        $opcion = $this->_getParam('op');
        $this->view->opcion_search=$opcion;

        if($status == 0) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalsol=$personal;
                $statusstep = 1;
                $statussol = 0;
                $statussur = 0;
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolEPPBuscar($personal,$statusstep,$statussol,$statussur);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolEPPBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statussur);
            }


            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 0;
                $statussur = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolIdEppBuscar($id,$statusstep,$statussol,$statussur);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolIdEppBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statussur);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 0;
                $statussur = 0;

                $solicitud=$this->view->sol_epp=$this->_epp->GetSolUserEPPBuscar($user,$statusstep,$statussol,$statussur);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolUserEPPBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statussur);
            }

        }


        if($status == 1) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalsol=$personal;
                $statusstep = 1;
                $statussol = 1;
                $statussur = 0;
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolEPPBuscar($personal,$statusstep,$statussol,$statussur);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolEPPBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statussur);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 1;
                $statussur = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolIdEppBuscar($id,$statusstep,$statussol,$statussur);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolIdEppBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statussur);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 1;
                $statussur = 0;

                $solicitud=$this->view->sol_epp=$this->_epp->GetSolUserEPPBuscar($user,$statusstep,$statussol,$statussur);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolUserEPPBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statussur);
            }

        }


        if($status == 2) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalsol=$personal;
                $statusstep = 1;
                $statussol = 2;
                $statussur = 0;
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolEPPBuscar($personal,$statusstep,$statussol,$statussur);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolEPPBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statussur);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 2;
                $statussur = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolIdEppBuscar($id,$statusstep,$statussol,$statussur);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolIdEppBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statussur);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 2;
                $statussur = 0;

                $solicitud=$this->view->sol_epp=$this->_epp->GetSolUserEPPBuscar($user,$statusstep,$statussol,$statussur);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolUserEPPBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statussur);
            }

        }


        if($status == 3) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalsol=$personal;
                $statusstep = 1;
                $statussol = 1;
                $statussur = 1;
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolEPPBuscar($personal,$statusstep,$statussol,$statussur);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolEPPBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statussur);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 1;
                $statussur = 1;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolIdEppBuscar($id,$statusstep,$statussol,$statussur);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolIdEppBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statussur);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 1;
                $statussur = 1;

                $solicitud=$this->view->sol_epp=$this->_epp->GetSolUserEPPBuscar($user,$statusstep,$statussol,$statussur);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolUserEPPBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statussur);
            }

        }
    }   // Buscadores Solicitud
    

    /////////////////////////////////////  Lista Solicitudes Specific   //////////////////////////////////////////////////////
    

    public function listasolspecificAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;
        $wh="id_usuario";
        $table="epp_solicitudes";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        // status_documento  enproceso
        
        $wh="id";
        $table="usuario";
        $user = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$user[0]['fkroles'];

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $sql = $this->_epp->GetSolspfCount($id);
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table="personal_campo";
        $this->view->personal_campo = $this->_epp->GetAllPsn($table);

        if($status == 0) {

            $solicitud=$this->_epp->GetSolspfCount($id);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="epp_solicitudes";
            $sql=$this->view->paginator= $this->_epp->GetSolProcesoSpfpaginator($table,$id,$offset,$no_of_records_per_page);
            // var_dump($sql);exit;
        }

        if($status == 1){
            $solicitud=$this->_epp->GetSolEppAceptSpfCount($id);

            $count=count($solicitud);

            if(isset($_GET['pagina'])) { 
                $pagina = $_GET['pagina']; 
            }else { 
                $pagina= $this->view->pagina = 1; 
            }

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="epp_solicitudes";
            $sql= $this->view->paginator= $this->_epp->GetSolAceptadasSpfpaginator($table,$id,$offset,$no_of_records_per_page);
        }

        if($status == 2){
            $solicitud=$this->_epp->GetSolEppCancelSpfCount($id);
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="epp_solicitudes";
            $this->view->paginator= $this->_epp->GetSolCanceladasSpfpaginator($table,$id,$offset,$no_of_records_per_page);
        }

        if($status == 3){
            $solicitud=$this->_epp->GetSolEppSurtidoSpfCount($id);
            // var_dump($solicitud);exit;
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="epp_solicitudes";
            $sql= $this->view->paginator= $this->_epp->GetSolSurtidasSpfpaginator($table,$id,$offset,$no_of_records_per_page);
        }
    }   // Lista solicitudes Specific

    /////////////////////////////////////// Buscadores Specific ////////////////////////////////////////////
    

    public function listasolbuscarspfAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;

        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$usr[0]['fkroles'];

        $wh="id_usuario";
        $table="epp_solicitudes";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $sql = $this->_epp->GetSolspfCount($id);
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $iduser=$this->_session->id;

        $table="personal_campo";
        $this->view->personal_campo = $this->_epp->GetAllPsn($table);

        $opcion = $this->_getParam('op');
        $this->view->opcion_search=$opcion;

        if($status == 0) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalsol=$personal;
                $statusstep = 1;
                $statussol = 0;
                $statussur = 0;
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolEPPSpfBuscar($personal,$iduser,$statusstep,$statussol,$statussur);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolEPPSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statussur);
            }


            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 0;
                $statussur = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolIdEppSpfBuscar($id,$iduser,$statusstep,$statussol,$statussur);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolIdEppSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statussur);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 0;
                $statussur = 0;

                $solicitud=$this->view->sol_epp=$this->_epp->GetSolUserEPPSpfBuscar($user,$iduser,$statusstep,$statussol,$statussur);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolUserEPPSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statussur);
            }

        }


        if($status == 1) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalsol=$personal;
                $statusstep = 1;
                $statussol = 1;
                $statussur = 0;
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolEPPSpfBuscar($personal,$iduser,$statusstep,$statussol,$statussur);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolEPPSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statussur);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 1;
                $statussur = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolIdEppSpfBuscar($id,$iduser,$statusstep,$statussol,$statussur);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolIdEppSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statussur);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 1;
                $statussur = 0;

                $solicitud=$this->view->sol_epp=$this->_epp->GetSolUserEPPSpfBuscar($user,$iduser,$statusstep,$statussol,$statussur);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolUserEPPSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statussur);
            }

        }


        if($status == 2) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalsol=$personal;
                $statusstep = 1;
                $statussol = 2;
                $statussur = 0;
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolEPPSpfBuscar($persona,$iduser,$statusstep,$statussol,$statussur);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolEPPSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statussur);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 2;
                $statussur = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolIdEppSpfBuscar($id,$iduser,$statusstep,$statussol,$statussur);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolIdEppSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statussur);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 2;
                $statussur = 0;

                $solicitud=$this->view->sol_epp=$this->_epp->GetSolUserEPPSpfBuscar($user,$iduser,$statusstep,$statussol,$statussur);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolUserEPPSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statussur);
            }

        }


        if($status == 3) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalsol=$personal;
                $statusstep = 1;
                $statussol = 1;
                $statussur = 1;
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolEPPSpfBuscar($personal,$iduser,$statusstep,$statussol,$statussur);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolEPPSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statussur);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 1;
                $statussur = 1;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolIdEppSpfBuscar($id,$iduser,$statusstep,$statussol,$statussur);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolIdEppSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statussur);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 1;
                $statussur = 1;

                $solicitud=$this->view->sol_epp=$this->_epp->GetSolUserEPPSpfBuscar($user,$iduser,$statusstep,$statussol,$statussur);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolUserEPPSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statussur);
            }

        }
    }   // Buscadores Solicitud Specific


    public function listasolalmacenAction(){

        $id=$this->_session->id;
        $this->view->user_list=$id;
        $wh="id_usuario";
        $table="epp_solicitudes";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        // status_documento  enproceso
        
        $wh="id";
        $table="usuario";
        $user = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$user[0]['fkroles'];

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $sql = $this->_epp->GetUserSolicitudAlmCount();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table="personal_campo";
        $this->view->personal_campo = $this->_epp->GetAllPsn($table);


        if($status == 0) {

            $solicitud=$this->_epp->GetUserSolicitudAlmCount();
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="epp_solicitudes";
            $sql=$this->view->paginator= $this->_epp->GetPagSolProcesoAlm($table,$offset,$no_of_records_per_page);
            // var_dump($sql);exit;
        }

        if($status == 1){
            $solicitud=$this->_epp->GetSolEppCancelCount();
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="epp_solicitudes";
            $this->view->paginator= $this->_epp->GetSolCanceladaspaginator($table,$offset,$no_of_records_per_page);
        }

        if($status == 2){
            $solicitud=$this->_epp->GetSolEppSurtidoCount();
            // var_dump($solicitud);exit;
            $count=count($solicitud);

            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            } else {
                $pagina= $this->view->pagina = 1;
            } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $table="epp_solicitudes";
            $sql= $this->view->paginator= $this->_epp->GetSolSurtidaspaginator($table,$offset,$no_of_records_per_page);
        }

    }


    public function listasolbuscaralmAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;

        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$usr[0]['fkroles'];

        $wh="id_usuario";
        $table="epp_solicitudes";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $sql = $this->_epp->GetUserSolicitudAlmCount();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table="personal_campo";
        $this->view->personal_campo = $this->_epp->GetAllPsn($table);

        $opcion = $this->_getParam('op');
        $this->view->opcion_search=$opcion;

        if($status == 0) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalsol=$personal;
                $statusstep = 1;
                $statussol = 1;
                $statussur = 0;
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolEPPBuscar($personal,$statusstep,$statussol,$statussur);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolEPPBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statussur);
            }


            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 1;
                $statussur = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolIdEppBuscar($id,$statusstep,$statussol,$statussur);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolIdEppBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statussur);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 1;
                $statussur = 0;

                $solicitud=$this->view->sol_epp=$this->_epp->GetSolUserEPPBuscar($user,$statusstep,$statussol,$statussur);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolUserEPPBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statussur);
            }

        }


        if($status == 1) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalsol=$personal;
                $statusstep = 1;
                $statussol = 2;
                $statussur = 0;
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolEPPBuscar($personal,$statusstep,$statussol,$statussur);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolEPPBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statussur);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 2;
                $statussur = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolIdEppBuscar($id,$statusstep,$statussol,$statussur);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolIdEppBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statussur);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 2;
                $statussur = 0;

                $solicitud=$this->view->sol_epp=$this->_epp->GetSolUserEPPBuscar($user,$statusstep,$statussol,$statussur);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolUserEPPBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statussur);
            }

        }


        if($status == 2) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $personal = $this->_getParam('personal');
                $this->view->personalsol=$personal;
                $statusstep = 1;
                $statussol = 1;
                $statussur = 1;
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolEPPBuscar($personal,$statusstep,$statussol,$statussur);

                $count=count($solicitud);

                if (isset($_GET['pagina'])) {
                    $pagina = $_GET['pagina'];
                } else {
                    $pagina= $this->view->pagina = 1;
                } 

                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolEPPBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statussur);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 1;
                $statussur = 1;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_epp=$this->_epp->GetSolIdEppBuscar($id,$statusstep,$statussol,$statussur);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolIdEppBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statussur);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 1;
                $statussur = 1;

                $solicitud=$this->view->sol_epp=$this->_epp->GetSolUserEPPBuscar($user,$statusstep,$statussol,$statussur);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="epp_solicitudes";
                $this->view->paginator= $this->_epp->GetSolUserEPPBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statussur);
            }

        }

    }   // Buscadores Solicitud
    

    public function solicituddetailAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            
            $table = "epp_solicitudes";
            $wh = "id";
            $usr = $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);

            $table = "epp_solicitudes";
            $this->view->detalle = $this->_epp->GetDetallesEppSol($table,$id); 

            $table = "epp_asignarsol";
            $this->view->epp_requerido = $this->_epp->GetEppXasgSinStatus($id);

            $table = "epp_solicitudes";
            $wh = "id";
            $this->view->solsurtida = $this->_season->GetSpecific($table,$wh,$id);
        
            $id_personal = $usr[0]['id_personal'];
            $this->view->eppasignado = $this->_epp->GetEppAsgAct($id_personal);

            $id_user=$this->_session->id;
            $this->view->usuario = $id_user;

            $status = $this->_getParam('status');
            $this->view->status_back = $status;

            $wh="id";
            $table="usuario";
            $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);


        }else {
            return $this-> _redirect('/');
        }
    }


    public function requestchgaceptsoleppAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            // $dato = date("Y-m-d H:i:s");

            $id = $post['id_user'];
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $name_user = $usr[0]['nombre'].' '. $usr[0]['ap'].' '.$usr[0]['am'];
        

        if($this->getRequest()->getPost()){

            $table="epp_solicitudes";
            $result=$this->_epp->UpdateAceptSolEpp($post,$table,$hoy,$name_user);


            if ($result) {
                return $this->_redirect('/epp/solicituddetail/id/'.$post['id_solicitud'].'/status/1');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   // END REQUEST ACEPTAR SOLICITUD


    public function requestchgcanceleppsolAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $dato = date("Y-m-d H:i:s");

            $id = $post['id_user'];
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $name_user = $usr[0]['nombre'].' '. $usr[0]['ap'].' '.$usr[0]['am'];


        if($this->getRequest()->getPost()){

            $table="epp_solicitudes";
            $result=$this->_epp->UpdateRechazarSolEpp($post,$table,$hoy,$name_user);


            if ($result) {
                return $this->_redirect('/epp/solicituddetail/id/'.$post['id_solicitud'].'/status/2');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   // END REQUEST CANCELAR SOLICITUD


    public function solicitudeppAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            
            $table = "epp_solicitudes";
            $wh = "id";
            $usr = $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);

            $table = "epp_solicitudes";
            $this->view->detalle = $this->_epp->GetDetallesEppSol($table,$id); 

            $table = "epp_asignarsol";
            $this->view->epp_requerido = $this->_epp->GetEppXasgSinStatus($id);

            $table = "epp_asignarsol";
            $this->view->epp_surtido = $this->_epp->GetEppXasgStatus($id);

            $table = "epp_solicitudes";
            $wh = "id";
            $this->view->solsurtida = $this->_season->GetSpecific($table,$wh,$id);
        
            $id_personal = $usr[0]['id_personal'];
            $this->view->eppasignado = $this->_epp->GetEppAsgAct($id_personal);

            $id_user=$this->_session->id;
            $this->view->usuario = $id_user;

            $status = $this->_getParam('status');
            $this->view->status_back = $status;

            $wh="id";
            $table="usuario";
            $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);
        }else {
            return $this-> _redirect('/');
        }
    }   //Para PDF de la solicitud Usuario y MAnager


    public function solicituddetailalmAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            
            $table = "epp_solicitudes";
            $wh = "id";
            $usr = $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);

            $table = "epp_solicitudes";
            $this->view->detalle = $this->_epp->GetDetallesEppSol($table,$id); 

            $table = "epp_asignarsol";
            $this->view->epp_requerido = $this->_epp->GetEppXasgSinStatus($id);

            $table = "epp_solicitudes";
            $wh = "id";
            $this->view->solsurtida = $this->_season->GetSpecific($table,$wh,$id);
        
            $id_personal = $usr[0]['id_personal'];
            $this->view->eppasignado = $this->_epp->GetEppAsgAct($id_personal);

            $id_user=$this->_session->id;
            $this->view->usuario = $id_user;

            $status = $this->_getParam('status');
            $this->view->status_back = $status;

            $wh="id";
            $table="usuario";
            $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);


        }else {
            return $this-> _redirect('/');
        }

    }

    public function solicitudeppalmAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            
            $table = "epp_solicitudes";
            $wh = "id";
            $usr = $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);

            $table = "epp_solicitudes";
            $this->view->detalle = $this->_epp->GetDetallesEppSol($table,$id); 

            $table = "epp_asignarsol";
            $this->view->epp_requerido = $this->_epp->GetEppXasgStatus($id);

            $table = "epp_solicitudes";
            $wh = "id";
            $this->view->solsurtida = $this->_season->GetSpecific($table,$wh,$id);
        
            $id_personal = $usr[0]['id_personal'];
            $this->view->eppasignado = $this->_epp->GetEppAsgAct($id_personal);

            $id_user=$this->_session->id;
            $this->view->usuario = $id_user;

            $status = $this->_getParam('status');
            $this->view->status_back = $status;

            $wh="id";
            $table="usuario";
            $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);
        }else {
            return $this-> _redirect('/');
        }
    }   //Para PDF de la solicitud Usuario y MAnager


    public function requestaddresponsivaeppAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        $idsol = $post['id_solicitud'];
        $wh="id_sol";
        $table="epp_asignarsol";
        $usr = $this->_season->GetSpecific($table,$wh,$idsol);
           
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("Y-m-d");

        $status = 1;
        $this->_epp->UpdateeppSol($post,$table,$idsol,$status,$hoy);  

            $solicitud = $post['id_solicitud'];
            $wh="id_sol";
            $table="epp_asignarsol";
            $eppasg = $this->_epp->GetSpecificInsertar($table,$wh,$solicitud);
          
        foreach ($eppasg as $key) {
          
            $fecha_entrega = $key['fecha_entrega'];
            $cantidad = $key['cantidad'];
            $descripcion = $key['descripcion'];
            $talla = $key['talla'];
            $id_personal = $key['id_personal'];
            $id_epp = $key['id_epp'];
            $cobro = $key['cobro'];
            $tipo_epp = $key['tipo_epp'];

            $id=$talla;
            $table="epp_catalogo";
            $vida=$this->_epp->buscarrep($id,$table);
           

            $vidap=implode($vida[0]);
            $date=$fecha_entrega;
            $fechanew=date('Y-m-d', strtotime($date. ' +'.$vidap.' days'));
           
            $table="epp_asignar";
            $this->_epp->insertasgEppSol($table,$fechanew, $fecha_entrega, $cantidad, $descripcion, $talla, $id_personal, $id_epp,
                $cobro, $tipo_epp);

            $table="epp_catalogo";
            $this->_epp->UpdateStockEppSol($table,$cantidad,$talla);

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
                    $url1 = 'img/epp/responsivas';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");

            $idper = $eppasg[0]['id_personal'];
            $fhoy = date("d-m-Y");
            $table="responsivas";

            $this->_epp->insertrespEppSol($idper,$table,$urldb,$fhoy);

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $name_user = $usr[0]['nombre'].' '. $usr[0]['ap'].' '.$usr[0]['am'];
            $id_usuario = $usr[0]['id'];            
            
            $status_surtido = 1;
            
            $table = "epp_solicitudes";
            $result = $this->_epp->UpdateSurtidaEpp($post,$table,$hoy,$name_user,$status_surtido,$id_usuario,$urldb);

            if ($result) {
                // return $this-> _redirect('/epp/solicituddetailalm/id/'.$post['id_solicitud'].'/status/2');
                return $this-> _redirect('/epp/listasolalmacen/status/0');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }


    public function requestactualizacobroAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $post = $this->getRequest()->getPost();
        $ids = $post['idepp'];
        $table="epp_asignarsol";

        foreach ($ids as $key => $value) {      
            
            $result = null;
           
            $result = $this->_epp->UpdateStatusCobro($value,$table);
            
        }

        if ($result) {

            return $this-> _redirect('/epp/solicituddetail/id/'.$post['sol_id'].'/status/0'); 
            
        }else{
        
            print '<script language="JavaScript">'; 
                
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
               
            print '</script>'; 
        
        }
    }       //End Seleccion a Cobrar


    public function limpiarcobroAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $post = $this->getRequest()->getPost();
        $solicitud = $post['sol'];
        $table="epp_asignarsol";
        
        $result = $this->_epp->UpdateReestablecerCobro($solicitud,$table);

        if ($result) {
 
            return $this-> _redirect('/epp/solicituddetail/id/'.$post['sol'].'/status/0'); 
            
        }else{
        
            print '<script language="JavaScript">'; 
                
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
               
            print '</script>'; 
        
        }
    }       //End Regresar EPP sin cobro



    public function requesteppasignadoAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $post = $this->getRequest()->getPost();
        $ids = $post['ideppasg'];
        $table="epp_asignarsol";

        foreach ($ids as $key => $value) {      
            
            $result = null;
           
            $result = $this->_epp->UpdateStatusAsignado($value,$table);
            
        }

        if ($result) {

            return $this-> _redirect('/epp/solicituddetailalm/id/'.$post['sol_id'].'/status/0'); 
            
        }else{
        
            print '<script language="JavaScript">'; 
                
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
               
            print '</script>'; 
        
        }
    }       //End Seleccion a Cobrar


    

    public function requestreplayentregaAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $post = $this->getRequest()->getPost();
        $solicitud = $post['sol'];
        $table="epp_asignarsol";
        
        $result = $this->_epp->UpdateReestablecerAsignar($solicitud,$table);

        if ($result) {
 
            return $this-> _redirect('/epp/solicituddetailalm/id/'.$post['sol'].'/status/0'); 
            
        }else{
        
            print '<script language="JavaScript">'; 
                
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
               
            print '</script>'; 
        
        }
    }       //End Regresar EPP sin Asignar


    public function eppentregaeditAction(){

        if($this->_hasParam('id')){
            
            $id = $this->_getParam('id');
            $wh="id";
            $table="epp_asignarsol";
            $usr = $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);
           
            $table="epp_asignarsol";
            $this->view->asignado = $this->_epp->DetallesEPPXAsignar($id);


            $table="epp_asignarsol";;
            $wh = "id";
            $detalle= $this->_season->GetSpecific($table,$wh,$id);

            $talla = $detalle[0]['descripcion'];
            $tallita=$this->view->tallaget= $this->_epp->GetTalla($talla);


            $table="epp_tipo";
            $this->view->tipo = $this->_season->GetAll($table);
        
        } else {
        
            return $this-> _redirect('/');
        
        }  

    }

    public function requestudpsoleppAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){

            $table="epp_asignarsol";
            $result = $this->_epp->UpdEppxAsg($post,$table);
            
            if ($result) {
                return $this-> _redirect('/epp/solicituddetailalm/id/'.$post['idsol'].'/status/0');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST UPDATE ASINADO





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


    // date_default_timezone_set('America/Mexico_City');
    // $hoy = date("d-m-Y H:i:s");