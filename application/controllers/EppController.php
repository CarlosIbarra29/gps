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
            $eppcobros=$this->_epp->GetPersonalCobro($table);
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
            $sql= $this->view->paginator= $this->_epp->Getpaginationcobro($table,$offset,$no_of_records_per_page);  
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
            $this->view->personal_epp= $this->_epp->GetPersonalEpp($id);

            $table="epp_asignar";
            $wh="id_personal";
            $status=0;
            $cobro=1;
            $this->view->eppcobro = $this->_epp->GetEppCobro($table,$wh,$id,$status,$cobro);

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