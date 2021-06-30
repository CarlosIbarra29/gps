<?php

class HerramientaController extends Zend_Controller_Action{
	private $_season;
    private $_session;
    private $_user;
    private $_cat; 
    private $_her; 

    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_project = new Application_Model_GpsProyectoModel;
        $this->_colo = new Application_Model_GpsColocacionModel;
        $this->_cat = new Application_Model_GpsHerramientaModel;
        $this->_her = new Application_Model_GpsHerramientaModel;

        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }
    }


    public function inventarioAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="categoria_herramienta";
        $this->view->cat = $this->_season->GetAll($table);
        $table="sitios";
        $this->view->sitio = $this->_season->GetAll($table);
        $table="personal_campo";
        $this->view->per = $this->_season->GetAll($table);

        $table="herramienta_inventario";
        $inventario=$this->_season->GetAll($table);
        $count=count($inventario);


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
        $table="herramienta_inventario";
        $sql= $this->view->paginator= $this->_cat->Getpaginationinventario($table,$offset,$no_of_records_per_page);  


    }// end inventario 

    public function buscarherramientaAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="categoria_herramienta";
        $this->view->cat = $this->_season->GetAll($table);
        $table="sitios";
        $this->view->sitio = $this->_season->GetAll($table);
        $table="personal_campo";
        $this->view->per = $this->_season->GetAll($table);

        if($this->_hasParam('nombre')){
            $name = $this->_getParam('nombre');
            $nombre_herra= $this->_her->npersonal($name);
            $option= 1;
            $this->view->name_herramienta=$name; 
            $cod = "vacio";
            $this->view->codigo_h=$cod;
            $this->view->status_h= 0;

            $this->view->option=$option; 
            $count=count($nombre_herra);
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
            $sql= $this->view->paginator= $this->_her->nombrehercount($name,$offset,$no_of_records_per_page);
        }

        if($this->_hasParam('codigo')){
            $codigo = $this->_getParam('codigo');
            $codigo_herra= $this->_her->hercodigo($codigo);
            $this->view->codigo_h=$codigo;
            $name="vacio";
            $this->view->name_herramienta=$name; 
            $option= 2;
            $this->view->option=$option;
            $count=count($codigo_herra);
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
            $sql= $this->view->paginator= $this->_her->hercodcount($codigo,$offset,$no_of_records_per_page);
        }

        if($this->_hasParam('status')){
            $status = $this->_getParam('status');
            $status_her= $this->_her->statusher($status);
            $this->view->status_h=$status;
            $codigo="vacio";
            $this->view->codigo_h=$codigo;
            $name="vacio";
            $this->view->name_herramienta=$name;

            $option= 3;
            $this->view->option=$option;
            $count=count($status_her);
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
            $sql= $this->view->paginator= $this->_her->statushercount($status,$offset,$no_of_records_per_page);
        } 

        if($this->_hasParam('nombreh')){ 
            $nherr = $this->_getParam('nombreh');
            $n_herra= $this->_her->hernherr($nherr);
            $this->view->name_h=$nherr;
            
            $name="vacio";
            $this->view->name_herramienta=$name; 
            $codigo="vacio";
            $this->view->codigo_h=$codigo;
           
            $option= 4;
            $this->view->option=$option;
            $count=count($n_herra);
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
            $sql= $this->view->paginator= $this->_her->herncount($nherr,$offset,$no_of_records_per_page);
        }

        if($this->_hasParam('hid')){ 
            $htaid = $this->_getParam('hid');
            
            $idhta= $this->_her->idherramienta($htaid);
            
            $this->view->id_h=$htaid;
            
            $name="vacio";
            $this->view->name_herramienta=$name; 
            $codigo="vacio";
            $this->view->codigo_h=$codigo;

            $nherr="vacio";
            $this->view->name_herramienta=$nherr; 

            $option= 5;
            $this->view->option=$option;
            $count=count($idhta);
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
            $sql= $this->view->paginator= $this->_her->idhercount($htaid,$offset,$no_of_records_per_page);
        }

         if($this->_hasParam('cate')){
            $categoria = $this->_getParam('cate');
            $cat_her= $this->_her->catsher($categoria);
            $this->view->cate_h=$categoria;
            
            $status="";
            $this->view->status_h=$status;
            $codigo="vacio";
            $this->view->codigo_h=$codigo;
            $name="vacio";
            $this->view->name_herramienta=$name;

            $option= 6;
            $this->view->option=$option;
            $count=count($cat_her);
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
            $sql= $this->view->paginator= $this->_her->cathercount($categoria,$offset,$no_of_records_per_page);
        } 

    } //End Buscar Herramienta

    public function requestaddherramientaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="herramienta_inventario";
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
                    $url1 = 'img/herramienta/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            $name = $_FILES['factura']['name'];
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            }else{
                $bytes = $_FILES['factura']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['factura']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/herramienta/factura/';
                    $urldb1 = $url1.$info1;
                    move_uploaded_file($_FILES['factura']['tmp_name'],$urldb1);
                }
            }

            $responsable=$post['responsable'];
            if ($responsable == 0) {
                $status = 0;
            }else{
                $status=1;
            }

            $result = $this->_cat->insertherramienta($post,$table,$urldb,$urldb1,$status);

            if ($result) {
                return $this-> _redirect('/herramienta/herramientadetail/id/'.$result.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END add herramienta

    public function requestdeleteherramientaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="herramienta_inventario";
            $wh="id_herramienta";
            $result = $this->_season->deleteAll($id,$table,$wh);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST DELETE Herramienta


    public function herramientaeditAction(){
           if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="herramienta_inventario";
            $wh="id_herramienta";
            $consulta=$this->view->herramientas_inv = $this->_season->GetSpecific($table,$wh,$id);

            // var_dump($consulta);
            // die();

            $table="categoria_herramienta";
            $this->view->categorias = $this->_season->GetAll($table);

            $table="personal_campo";
            $this->view->per= $this->_season->GetAll($table);

            $table="sitios";
            $this->view->sitio= $this->_season->GetAll($table);

            $op = $this->_getParam('op'); 
            $this->view->op_sel=$op; 

            $nombre = $this->_getParam('nombre'); 
            $this->view->nombre=$nombre;

            $codigo = $this->_getParam('codigo'); 
            $this->view->codigo=$codigo;

            $status = $this->_getParam('status'); 
            $this->view->status=$status;

            $nombreh = $this->_getParam('nombreh'); 
            $this->view->nombreh=$nombreh;

            $hid = $this->_getParam('hid'); 
            $this->view->hid=$hid;

            $cate = $this->_getParam('cate'); 
            $this->view->cate_h=$cate;

        }else {
            return $this-> _redirect('/');
        }   

    }//End herramientaedit

    public function requestupdateherramientaAction(){
    $this->_helper->layout()->disableLayout();
    $this->_helper->viewRenderer->setNoRender(true);
    $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="herramienta_inventario";
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
                    $url1 = 'img/herramienta/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if
                
            $urldb1 = $post["imafactura"];
            if(!empty($_FILES["factura"]["name"])) {
                $bytes = $_FILES['factura']['size'];
                $res = $this->formatSizeUnits($bytes);
                if ($res == 0) {
                    print '<script language="JavaScript">'; 
                    print 'alert("La imagen supera el maximo de tamaño");'; 
                    print '</script>';
                } else {
                    unlink($post['imafactura']);
                    $info1 = new SplFileInfo($_FILES['factura']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/herramienta/factura/';
                    $urldb1 = $url1.$info1;
                    move_uploaded_file($_FILES['factura']['tmp_name'],$urldb1);
                }
            }//end de if

            $table="herramienta_inventario";
            $result = $this->_cat->updateherramienta($post,$table,$urldb,$urldb1);
            if ($result) {
                return $this-> _redirect('/herramienta/inventario');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST update herramienta
 

    public function herramientadetailAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="herramienta_inventario";
            $wh="id_herramienta";
            $this->view->herramienta = $this->_season->GetSpecific($table,$wh,$id);

            $table="personal_campo";
            $this->view->per= $this->_her->GetAllEmpleados($table);
            $this->view->pers = $this->_her->Getdatos($wh,$id);
            $this->view->fecha = $this->_her->Getfecha($wh,$id);

            $table="reportes_reparacion";
            $this->view->reparacion= $this->_her->Getreparacion($id);
            $this->view->nreparacion= $this->_her->Getnrep($id);

            $table="solicitud_ordencompra";
            $this->view->solicitud = $this->_her->GetSolicitudesReparacion($table);


            $op = $this->_getParam('op'); 
            $this->view->op_sel=$op; 

            $nombre = $this->_getParam('nombre'); 
            $this->view->nombre=$nombre;

            $codigo = $this->_getParam('codigo'); 
            $this->view->codigo=$codigo;

            $status = $this->_getParam('status'); 
            $this->view->status=$status;

            $nombreh = $this->_getParam('nombreh'); 
            $this->view->nombreh=$nombreh;

            $hid = $this->_getParam('hid'); 
            $this->view->hid=$hid;

            $cate = $this->_getParam('cate'); 
            $this->view->cate_h=$cate;

            $her = $this->_getParam('id');
            $this->view->idher=$her;
        }else {
            return $this-> _redirect('/');
        }       

    } // End Herramienta Detail


    public function requestasignarherramientaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $table="herramienta_inventario";
            $result = $this->_her->UpdateStatusHer($post,$table,$hoy);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }// End Request Asignar herramienta

    public function requestrherramientaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $personal = $post['idrs'];
        
        if($this->getRequest()->getPost()){
            $table="reportes_reparacion";
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
                    $url1 = 'img/herramienta/reparacion/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="reportes_reparacion";
            $this->_her->insertreporterep($post,$table,$urldb);
            
            $table="herramienta_inventario";
            $result = $this->_her->UpdateStatusHerRep($post,$table,$personal);
            if ($result) {
                return $this-> _redirect('/herramienta/herramientadetail/id/'.$post['idhs'].''); 
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
            
    }// End Request Reparar herramienta

    public function requestregresarherramientaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="herramienta_inventario";
            $result = $this->_her->UpdateStatusHer1($post,$table);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }// End Request Regresar herramienta

    public function requeststatushAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="herramienta_inventario";
            $result = $this->_her->UpdateStatusHer1($post,$table);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }// End Request Regresar herramienta


    public function requestactualizatodoAction(){
        $this->_helper->layout()->disableLayout();
        
        $this->_helper->viewRenderer->setNoRender(true);

        $post = $this->getRequest()->getPost();

        $id=$post['idp'];
       
        $table="herramienta_inventario";
        
        $datoherramienta= $this->_her->Getherramientasa($id);

        foreach ($datoherramienta as $key => $value) {
            
            $result = null;
           
            $result = $this->_her->UpdateStatusHer3($value['id_herramienta'],$table);
        }
        
            if ($result) {
                
                return $this-> _redirect('/herramienta/bresponsable?responsable='.$post['idp'].''); 
            
            }else{
        
                print '<script language="JavaScript">'; 
                
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
               
                print '</script>'; 
        
            }
    }       //End Regresar todas las herramientas


    public function requestactualizaseleccionAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $post = $this->getRequest()->getPost();
        $ids = $post['idh'];
        $table="herramienta_inventario";

        foreach ($ids as $key => $value) {
    
           $result = null;
           
            $result = $this->_her->UpdateStatusHer2($value,$table);
            
        }

        if ($result) {

            return $this-> _redirect('/herramienta/bresponsable?responsable='.$post['idp'].''); 
            
        }else{
        
            print '<script language="JavaScript">'; 
                
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
               
            print '</script>'; 
        
        }
    }       //End Regresar SELECCION herramientas


    public function requestcobrarAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $post = $this->getRequest()->getPost();
        
        $idhr = $post['idh'];
        $personal = $post['idp'];
        $table="cobro_herramientas";
        
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");

        foreach ($idhr as $key => $value) {
            
            $a = null;
            $a= $this->_her->InsertCobro($value,$table,$hoy,$personal);
            
        }

        $ids = $post['idh'];
        $table="herramienta_inventario";

        foreach ($ids as $key => $value) {
            
            $result = null;
            $result = $this->_her->UpdateStatusHerB2($value,$table);
            
        }

        if ($result) {

            return $this-> _redirect('/herramienta/bresponsable?responsable='.$post['idp'].''); 
            
        }else{
        
            print '<script language="JavaScript">'; 
                
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
               
            print '</script>'; 
        
        }
    }       //End Regresar SELECCION herramientas

    // public function requestherramientareparadaAction(){
    //     $this->_helper->layout()->disableLayout();
    //     $this->_helper->viewRenderer->setNoRender(true);
    //     $post = $this->getRequest()->getPost();
    //     if($this->getRequest()->getPost()){

    //         date_default_timezone_set('America/Mexico_City');
    //         $hoy = date("d-m-Y");
    //         $table="reportes_reparacion";
    //         $this->_her->Updatefecha($post,$table,$hoy);


    //         $table="herramienta_inventario";
    //         $result = $this->_her->UpdateStatusHerR($post,$table);
    //         if ($result) {
    //             echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            
    //         }else{
    //             print '<script language="JavaScript">';
    //             print 'alert("Ocurrio un error: Comprueba los datos.");';
    //             print '</script>';
    //         }
    //     }
    // }// End Request Reparada herramienta

    public function requestherramientareparadaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");
            $table="reportes_reparacion";
            $this->_her->Updatefecha($post,$table,$hoy);

            $table="solicitud_ordencompra";
            $this->_her->Updatesolicitudasg($post,$table);
            
            $table="herramienta_inventario";
            $result = $this->_her->UpdateStatusHerR($post,$table);
            if ($result) {
                return $this-> _redirect('/herramienta/herramientadetail/id/'.$post['idhss'].''); 
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
            
    }// End Request Herramienta Reparada

    public function requestbajaherramientaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $cobro=$post['cobro'];
        
        if ($cobro == true) {
                $idhr = $post['idh'];
                $personal = $post['idr'];
                $table="cobro_herramientas";
                date_default_timezone_set('America/Mexico_City');
                 $hoy = date("d-m-Y H:i:s");
                $a= $this->_her->InsertCobrohd($post,$table,$hoy,$personal);


                if($this->getRequest()->getPost()){
                $table="herramienta_inventario";
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
                        $url1 = 'img/herramienta/baja/';
                        $urldb = $url1.$info1;
                        move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                    }
                }//end de if


                $table="herramienta_inventario";
                $result = $this->_her->UpdateStatusHerB($post,$table,$urldb,$personal);
                if ($result) {
                    return $this-> _redirect('/herramienta/herramientadetail/id/'.$post['idh'].''); 
                }else{
                    print '<script language="JavaScript">'; 
                    print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                    print '</script>'; 
                }
            }

        } else {
            
            $personal = $post['idr'];

            if($this->getRequest()->getPost()){
                $table="herramienta_inventario";
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
                        $url1 = 'img/herramienta/baja/';
                        $urldb = $url1.$info1;
                        move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                    }
                }//end de if


                $table="herramienta_inventario";
                $result = $this->_her->UpdateStatusHerB($post,$table,$urldb,$personal);
                if ($result) {
                    return $this-> _redirect('/herramienta/herramientadetail/id/'.$post['idh'].''); 
                }else{
                    print '<script language="JavaScript">'; 
                    print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                    print '</script>'; 
                }
            }
        }
    }       //End Baja herramienta


    public function categoriaAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="categoria_herramienta";
        $this->view->categoria_herramienta = $this->_season->GetAll($table);

        $categoria=$this->_season->GetAll($table);
        $count=count($categoria);

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
        $table="categoria_herramienta";
        $sql= $this->view->paginator= $this->_cat->Getpaginationcat($table,$offset,$no_of_records_per_page);        
    }   // END categoria

 
    public function requestaddcatAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="categoria_herramienta";

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
                    $url1 = 'img/cat_herramientas/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            $result = $this->_cat->insertcat($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/herramienta/categoria');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END add cat


    public function cateditAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="categoria_herramienta";
            $wh="id_cat";
            $this->view->cat_herramientas = $this->_season->GetSpecific($table,$wh,$id);
        }else {
            return $this-> _redirect('/');
        }   
    }//End catedit

    public function requestupdatecatAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="categoria_herramienta";
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
                    $url1 = 'img/cat_herramientas/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="categoria_herramienta";
            $result = $this->_cat->updatecategoria($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/herramienta/categoria');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST UPDATE CATEGORIA


    public function requestdeletecatAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="categoria_herramienta";
            $wh="id_cat";
            $result = $this->_season->deleteAll($id,$table,$wh);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST DELETE Categoria

    public function buscarcatAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        if($this->_hasParam('nombre')){
            $cat = $this->_getParam('nombre');
            $nombre = strstr($cat, '?', true); 
            if($nombre == false){
                $name = $this->_getParam('nombre');
            }else{
                 $name = strstr($cat, '?', true); 
            }

            $this->view->name_search=$name;
            $usuarios=$this->_cat->catnombre($name);
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
            $sql= $this->view->paginator= $this->_cat->catcount($name,$offset,$no_of_records_per_page);
        }
    } //Buscar Categoria

     public function excelherramientaAction(){
        $status=$this->_getParam('status');
        $this->view->status=$status;
        
        $this->view->excelher = $this->_her->herramientasexcel();
    }// Excel Herramientas

     public function reportereparaAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
          
            $this->view->reporte = $this->_her->reparacionexcel($id);

            $table="reportes_reparacion";
            $this->view->reparacion= $this->_her->Getreparacion($id);
            $this->view->nreparacion= $this->_her->Getnrep($id);

        }else {
            return $this-> _redirect('/');
        }       
        
    } // Excel Reportes

    public function reportesAction(){          
        
        $this->view->reporte = $this->_her->reparaexcel();    
        
    } // Excel ReportesEspecificos

    public function regresarhAction(){
      
        $table="personal_campo";
        $this->view->personal_campo = $this->_her->GetAllPersonal($table);

    }

    public function reporteeditAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="reportes_reparacion";
            $wh="id_reporte";
            $this->view->reporte = $this->_season->GetSpecific($table,$wh,$id);

        }else {
            return $this-> _redirect('/');
        }   
    }//End Reporte Edit

    
    public function requestupdaterepAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="reportes_reparacion";
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
                    $url1 = 'img/herramienta/reparacion/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="reportes_reparacion";
            $result = $this->_her->updatereporte($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/herramienta/herramientadetail/id/'.$post['idsr'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST UPDATE Reporte Reparacion

    public function bresponsableAction(){

        if($this->_hasParam('responsable')){
            $id = $this->_getParam('responsable');
            $table="personal_campo";
            $wh="id";
            $this->view->Personal = $this->_season->GetSpecific($table,$wh,$id);

            $table="personal_campo";
            $this->view->per= $this->_her->Getdatos_p($table,$id);

            $table="herramienta_inventario";
            $this->view->contador= $this->_her->Getcontadorh($id);

            $table="herramienta_inventario";
            $this->view->herramienta= $this->_her->Getherramientasa($id);

            $table="cobro_herramientas";
            $this->view->cobros= $this->_her->Getcobro($id);

        }else {
            
            return $this-> _redirect('/');
        
        } 

    }

    public function responsivahAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            
            $table="herramienta_inventario";
            $this->view->contador= $this->_her->Getcontadorh($id);

            $table="herramienta_inventario";
            $this->view->herramienta= $this->_her->Getherramientasres($id);
            
        }else {        
            return $this-> _redirect('/');        
        }  

    }

    public function historialhAction(){
        
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->personales= $this->_her->GetPersonal($id);
            
           
            $table="responsivah";
            $this->view->responsiva= $this->_her->Responsivah($id);

        }else {
            return $this-> _redirect('/');
        }         

    }


    public function requestresponsivahAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="responsivah";
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
                    $url1 = 'img/herramienta/responsivas/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            date_default_timezone_set('America/Mexico_City');
             $hoy = date("d-m-Y H:i:s");
            $table="responsivah";

            $result = $this->_her->insertresponsivah($post,$table,$urldb,$hoy);

            if ($result) {
                return $this-> _redirect('/herramienta/historialh/id/'.$post['idper'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   //END Responsiva

    public function cobrohAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            
            $table="cobro_herramientas";
            $this->view->contador= $this->_her->Getcontadorcobro($id);


            $table="cobro_herramientas";
            $this->view->cobros= $this->_her->Getcobro($id);
            
        }else {        
            return $this-> _redirect('/');        
        }  
    }


     public function herramientacostoAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="personal_campo";
        $sql = $this->_her->GetPersonalCobroH($table);
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_cobro=$status;

        if($status == 1){

            $table="personal_campo";
            $herracobros=$this->_her->GetPersonalCobroH($table);
            $count=count($herracobros);

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
            $sql= $this->view->paginator= $this->_her->GetpaginationcobroH($table,$offset,$no_of_records_per_page);  
        }

        if($status == 2){

            $table="personal_campo";
            $herracobros=$this->_her->GetPersonalPagoH($table);
            $count=count($herracobros);

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
            $sql= $this->view->paginator= $this->_her->GetpaginationPagoH($table,$offset,$no_of_records_per_page); 
        }

    }// END Cobro EPP

    public function costobuscarAction(){

        $table="personal_campo";
        $sql = $this->_her->GetPersonalCobroH($table);
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
            $herracobros=$this->_her->GetPersonalCobroBH($table,$nombre);
            $count=count($herracobros);

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
            $sql= $this->view->paginator= $this->_her->GetpaginationcobroBH($table,$nombre,$offset,$no_of_records_per_page);  
        }


          if($status == 2){
            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;

            $nombre = $this->_getParam('nombre');
            $this->view->nombre_p=$nombre;

            $table="personal_campo";
            $herracobros=$this->_her->GetPersonalCobroPH($table,$nombre);
            $count=count($herracobros);

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
            $sql= $this->view->paginator= $this->_her->GetpaginationcobroPH($table,$nombre,$offset,$no_of_records_per_page); 
        }
    }


    public function costodetailAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->personal= $this->_her->GetPersonal($id);

            $table="cobro_herramientas";
            $wh="id_personal";
            $cobro=1;
            $this->view->hercobro = $this->_her->GetHerCobro($table,$wh,$id,$cobro);

        }else {
            return $this-> _redirect('/');
        }  
    } // Detalles de Herramienta a Cobrar

    public function costodetailpAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->personal= $this->_her->GetPersonal($id);

            // $table="epp_asignar";
            // $wh="id_personal";
            // $status=0;
            // $cobro=2;
            // $this->view->eppcobro = $this->_epp->GetEppCobro($table,$wh,$id,$status,$cobro);

            $table="cobro_herrac";
            $wh="id_personal";
            $this->view->hercobro = $this->_season->GetSpecific($table,$wh,$id);

        }else {
            return $this-> _redirect('/');
        }  
    } // Detalles de EPP Asignado


     public function requestcostohAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            $table="cobro_herramientas";
            $wh="id_personal";
            $cobro=1;
            $id=$post['idpe'];
            $datos=$this->view->hercobro = $this->_her->GetHerCobro($table,$wh,$id,$cobro);
          
            foreach ($datos as $key => $value) {
            
            $resultado = null;
           
            $resultado = $this->_her->UpdateCobroH($value['id_herramienta'],$table);
            
            }

            $table="cobro_herrac";
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
                    $url1 = 'img/herramienta/cobros/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");

            $result = $this->_her->insertcobroH($post,$table,$urldb,$hoy);
            if ($result) {
                return $this-> _redirect('/herramienta/herramientacosto/status/1');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END Add Comprobante Pago Herramienta


    public function prueba2Action(){
         if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            
            $table="herramienta_inventario";
            $this->view->contador= $this->_her->Getcontadorh($id);

            $table="herramienta_inventario";
            $this->view->herramienta= $this->_her->Getherramientasres($id);
            
        }else {        
            return $this-> _redirect('/');        
        }  
    }

    public function datosAction(){
        
        try {
              
            $id = $_POST['variable'];

            $aResponse = $this->_her->Getherramientasresp($id);

            print json_encode( $aResponse, JSON_UNESCAPED_UNICODE);


            die();

        } catch (Exception $e) {

            echo "Caught exception: " . get_class($e) . "\n";
            
            echo "Message: " . $e->getMessage() . "\n";
        }
    }

     public function prueba3Action(){
         if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            
            $table="herramienta_inventario";
            $this->view->contador= $this->_her->Getcontadorh($id);

            $table="herramienta_inventario";
            $this->view->herramienta= $this->_her->Getherramientasres($id);
            
        }else {        
            return $this-> _redirect('/');        
        }  
    }

    public function escaneaqrAction(){

    }

    public function herramientaqrAction(){

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