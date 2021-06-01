<?php

class ClientesController extends Zend_Controller_Action{
	private $_season;
    private $_session;
    private $_user;
    private $_cliente; 
    private $_her; 

    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_project = new Application_Model_GpsProyectoModel;
        $this->_colo = new Application_Model_GpsColocacionModel;
        $this->_cliente = new Application_Model_GpsClientesModel;
        $this->_her = new Application_Model_GpsHerramientaModel;

        if(empty($this->_session->id)){


            $this->redirect('/home/login');
        
        }
    }


    public function clientesAction(){

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $id_user=$this->_session->id;
        $this->view->usuario = $id_user;

        $wh="id";
        $table="usuario";
        $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);

        $table="clientes";
        $this->view->clt = $this->_season->GetAll($table);

        $clientes=$this->_season->GetAll($table);
        $count=count($clientes);

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
        $table="clientes";
        $sql= $this->view->paginator= $this->_cliente->Getpaginationclientes($table,$offset,$no_of_records_per_page); 

    } // Vista de Clientes


    // public function requestaddclienteAction(){

    //     $this->_helper->layout()->disableLayout();
    //     $this->_helper->viewRenderer->setNoRender(true);
    //     $post = $this->getRequest()->getPost();

    //     if($this->getRequest()->getPost()){
    //         $table="clientes";
    //         $name = $_FILES['url']['name'];
            
    //         if(empty($name)){ 
    //             print '<script language="JavaScript">'; 
    //             print 'alert("Agrega una imagen");'; 
    //             print '</script>'; 
    //         } else {

    //             $bytes = $_FILES['url']['size'];
    //             $res = $this->formatSizeUnits($bytes);
                
    //             if($res == 0){       
    //                 print '<script language="JavaScript">'; 
    //                 print 'alert("El pdf supera el maximo de tamaño");'; 
    //                 print '</script>'; 
    //             } else {
    //                 $info1 = new SplFileInfo($_FILES['url']['name']);
    //                 $ext1 = $info1->getExtension();
    //                 $url1 = 'img/clientes/logos/';
    //                 $urldb = $url1.$info1;
    //                 move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
    //             }
    //         }

    //         $result = $this->_cliente->insertcliente($post,$table,$urldb);
    //         if ($result) {
                
    //             return $this-> _redirect('/clientes/clientes');
            
    //         } else {
    //             print '<script language="JavaScript">'; 
    //             print 'alert("Ocurrio un error: Comprueba los datos.");'; 
    //             print '</script>'; 
    //         }
    //     }
    // }   // Agregar Cliente

    public function requestaddclienteAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){
            $table="clientes";
            $name = $_FILES['url']['name'];
            
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            } else {

                $bytes = $_FILES['url']['size'];
                $res = $this->formatSizeUnits($bytes);
                
                if($res == 0){       
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                } else {
                    $info1 = new SplFileInfo($_FILES['url']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/clientes/logos/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            $result = $this->_cliente->insertcliente($post,$table,$urldb);
            if ($result) {
                
                return $this-> _redirect('/clientes/especificaciones');
            
            } else {
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   // Agregar Cliente


    public function requestdeleteclienteAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="clientes";
            $wh="id";
            $result = $this->_season->deleteAll($id,$table,$wh);
            
            if ($result) {
                
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            
            } else {
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }   //REQUEST DELETE CLIENTE


    public function clienteeditAction(){
        
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="clientes";
            $wh="id";
            $this->view->cliente_edit = $this->_season->GetSpecific($table,$wh,$id);
        } else {
            return $this-> _redirect('/');
        }   
    
    }   //End Clientes Edit


    public function requestupdatecltAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){
            
            $table="clientes";
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
                    $url1 = 'img/clientes/logos/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="clientes";
            $result = $this->_cliente->updatecliente($post,$table,$urldb);
            
            if ($result) {
            
                return $this-> _redirect('/clientes/especificaciones');
            
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   //REQUEST UPDATE CLIENTE


    public function busquedacltAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        
        if($this->_hasParam('nombre')){
            
            $id_user=$this->_session->id;
            $this->view->usuario = $id_user;

            $wh="id";
            $table="usuario";
            $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);

            $cliente = $this->_getParam('nombre');
            $nombre = strstr($cliente, '?', true); 
            
            if($nombre == false){
                $name = $this->_getParam('nombre');
            }else{
                 $name = strstr($cliente, '?', true); 
            }

            $this->view->name_search=$name;
            $cltname=$this->_cliente->cltnombre($name);
            $count=count($cltname); 
            
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
            $sql= $this->view->paginator= $this->_cliente->clientescount($name,$offset,$no_of_records_per_page);
        }
    }   //Buscar Cliente


    public function especificacionesAction(){

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $id_user=$this->_session->id;
        $this->view->usuario = $id_user;

        $wh="id";
        $table="usuario";
        $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);

        $table="clientes";
        $this->view->clt = $this->_season->GetAll($table);

        $clientes=$this->_season->GetAll($table);
        $count=count($clientes);

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
        $table="clientes";
        $sql= $this->view->paginator= $this->_cliente->Getpaginationclientes($table,$offset,$no_of_records_per_page); 

    } // Vista de Clientes

    public function carpetasAction(){
            
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="clientes_carpeta";
            $wh="id_cliente";
            $this->view->carpetas = $this->_cliente->GetCarpetasC($table,$id);

            $id_user=$this->_session->id;
            $this->view->usuario = $id_user;

            $wh="id";
            $table="usuario";
            $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);

            $table="clientes";
            $wh="id";
            $this->view->cliente_dato = $this->_season->GetSpecific($table,$wh,$id);

            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;

            $table="clientes_archivos";
            $this->view->clt = $this->_season->GetAll($table);

            $clientes=$this->_cliente->GetArchivosCarpeta1($table,$id);
            $count=count($clientes);

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
            $table="clientes_archivos";
            $sql= $this->view->paginator= $this->_cliente->Getpaginationarchivosclientes($table,$offset,$no_of_records_per_page,$id); 

            $idclt = $this->_getParam('id');
            $this->view->id_cliente=$idclt;
        }else {

            return $this-> _redirect('/');
        
        } 

    }   //Carpetas Clientas
   

    
    public function requestaddcarpetaAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $cliente= $post['id_cliente'];
        
        $table="clientes_carpeta";
        $result = $this->_cliente->insertcarpeta($post,$table);
        
        if ($result) {
                
            return $this-> _redirect('/clientes/carpetas/id/'.$cliente.'');
            
        } else {
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
        }
    }   // Agregar Cliente


    public function requestdeletecarpetaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="clientes_carpeta";
            $wh="id";
            $result = $this->_season->deleteAll($id,$table,$wh);
            
            if ($result) {
                
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            
            } else {
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }   //REQUEST DELETE CARPETA


    public function requestadddcAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $cliente= $post['id_clientes'];

        if($this->getRequest()->getPost()){
            $table="clientes_archivos";
            $name = $_FILES['urla']['name'];
            
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            } else {

                $bytes = $_FILES['urla']['size'];
                $res = $this->formatSizeUnits($bytes);
                
                if($res == 0){       
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                } else {
                    $info1 = new SplFileInfo($_FILES['urla']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/clientes/archivos/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['urla']['tmp_name'],$urldb);
                }
            }

            $result = $this->_cliente->insertarchivo($post,$table,$urldb);
            if ($result) {
                
                return $this-> _redirect('/clientes/carpetas/id/'.$cliente.'');
            
            } else {
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   // Agregar Archivo

    public function requestdeletearchivoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="clientes_archivos";
            $wh="id";
            $result = $this->_season->deleteAll($id,$table,$wh);
            
            if ($result) {
                
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            
            } else {
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }   //REQUEST DELETE CARPETA


    public function carpetaeditAction(){
        
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $table="clientes_carpeta";
            $wh="id";
            $this->view->carpetaedit = $this->_season->GetSpecific($table,$wh,$id);

        }else {
            return $this-> _redirect('/');
        }   
    }  // END EDIT CARPETA 

    
    public function requestupdatecarpetaAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $cliente=$post['id_cliente'];
        
        if($this->getRequest()->getPost()){

            $table="clientes_carpeta";
            $result = $this->_cliente->updatecarpeta($post,$table);
            
            if ($result) {
                return $this-> _redirect('/clientes/carpetas/id/'.$cliente.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST UPDATE CARPETA

    public function archivoeditAction(){
        
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $table="clientes_archivos";
            $wh="id";
            $this->view->archivoedit = $this->_season->GetSpecific($table,$wh,$id);

        }else {
            return $this-> _redirect('/');
        }   
    }  // END EDIT ARCHIVO


    public function requestupdatearchivoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true); 
        $post = $this->getRequest()->getPost();

        $cliente = $post['id_cliente'];

        if($this->getRequest()->getPost()){
            $table="clientes_archivos";
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
                    $url1 = 'img/clientes/archivos/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="clientes_archivos";
            $result = $this->_cliente->updatearchivo($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/clientes/carpetas/id/'.$cliente.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   //END REQUEST UPDATE ARCHIVO


    public function subcarpetaAction(){
            
        if($this->_hasParam('id')){
            $clienteid = $this->_getParam('cliente');
            $id = $this->_getParam('id');
            
            $table="clientes_carpeta";
            $wh="id_cliente";
            $this->view->carpetas = $this->_cliente->GetSCarpetas($table,$id,$clienteid);

            $table="clientes_carpeta";
            $this->view->nombrecarpeta = $this->_cliente->GetSuCarpetas($table,$id);

            $id_user=$this->_session->id;
            $this->view->usuario = $id_user;

            $wh="id";
            $table="usuario";
            $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);

            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;

            $table="clientes_archivos";
            $this->view->clt = $this->_season->GetAll($table);

            $clientes=$this->_cliente->GetAllsubcarpeta($table,$id,$clienteid);
            $count=count($clientes);

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
            $table="clientes_archivos";
            $sql= $this->view->paginator= $this->_cliente->Getpaginationarchivocarpeta($table,$offset,$no_of_records_per_page,$id,$clienteid); 

            $idcarpeta = $this->_getParam('id');
            $this->view->idcarpeta=$idcarpeta;

            $id_cliente = $this->_getParam('cliente');
            $this->view->id_cliente=$id_cliente;
        }else {

            return $this-> _redirect('/');
        
        } 

    }   //Carpetas 2


    public function requestaddsubcarpetaAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        $cliente= $post['id_cliente'];
        $carpeta= $post['idcarpeta'];

        $table="clientes_carpeta";
        $result = $this->_cliente->insertsubcarpeta($post,$table);
        if ($result) {
                
            return $this-> _redirect('/clientes/subcarpeta/id/'.$carpeta.'/cliente/'.$cliente.'');
            
        } else {
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
        }
    }   // Agregar Cliente


    public function requestadddocsAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $cliente= $post['id_clientes'];
        $carpeta= $post['idcarpetas'];

        if($this->getRequest()->getPost()){
            $table="clientes_archivos";
            $name = $_FILES['urla']['name'];
            
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            } else {

                $bytes = $_FILES['urla']['size'];
                $res = $this->formatSizeUnits($bytes);
                
                if($res == 0){       
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                } else {
                    $info1 = new SplFileInfo($_FILES['urla']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/clientes/archivos/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['urla']['tmp_name'],$urldb);
                }
            }

            $result = $this->_cliente->insertarchivosub($post,$table,$urldb);
            if ($result) {
                
                return $this-> _redirect('/clientes/subcarpeta/id/'.$carpeta.'/cliente/'.$cliente.'');
            
            } else {
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   // Agregar Documento Subcarpeta


    public function carpetaedit2Action(){
        
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $table="clientes_carpeta";
            $wh="id";
            $this->view->carpetaedit2 = $this->_season->GetSpecific($table,$wh,$id);

        }else {
            return $this-> _redirect('/');
        }   
    }  // END EDIT SUBCARPETA 

    
    public function requestupdatesubcarpetaAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $cliente=$post['id_cliente'];
        $carpeta= $post['idcta'];

        
        if($this->getRequest()->getPost()){

            $table="clientes_carpeta";
            $result = $this->_cliente->updatecarpeta($post,$table);
            
            if ($result) {
                return $this-> _redirect('/clientes/subcarpeta/id/'.$carpeta.'/cliente/'.$cliente.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST UPDATE SUBCARPETA


    public function archivoedit2Action(){
        
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $table="clientes_archivos";
            $wh="id";
            $this->view->archivoedit2 = $this->_season->GetSpecific($table,$wh,$id);

        }else {
            return $this-> _redirect('/');
        }   
    }  // END EDIT ARCHIVO


    public function requestupdatearchivosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true); 
        $post = $this->getRequest()->getPost();

        $cliente = $post['id_cliente'];
        $carpeta= $post['idcta'];

        if($this->getRequest()->getPost()){
            $table="clientes_archivos";
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
                    $url1 = 'img/clientes/archivos/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="clientes_archivos";
            $result = $this->_cliente->updatearchivo($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/clientes/subcarpeta/id/'.$carpeta.'/cliente/'.$cliente.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   //END REQUEST UPDATE ARCHIVO


    public function subcarpeta2Action(){
            
        if($this->_hasParam('id')){
            $clienteid = $this->_getParam('cliente');
            $id = $this->_getParam('id');
            
            $table="clientes_carpeta";
            $wh="id_cliente";
            $this->view->carpetas = $this->_cliente->GetSCarpetas($table,$id,$clienteid);

            $id_user=$this->_session->id;
            $this->view->usuario = $id_user;

            $wh="id";
            $table="usuario";
            $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);

            $table="clientes_carpeta";
            $this->view->nombrecarpeta = $this->_cliente->GetSuCarpetas($table,$id);

            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;

            $table="clientes_archivos";
            $this->view->clt = $this->_season->GetAll($table);

            $clientes=$this->_cliente->GetAllsubcarpeta($table,$id,$clienteid);
            $count=count($clientes);

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
            $table="clientes_archivos";
            $sql= $this->view->paginator= $this->_cliente->Getpaginationarchivocarpeta($table,$offset,$no_of_records_per_page,$id,$clienteid); 

            $idcarpeta = $this->_getParam('id');
            $this->view->idcarpeta=$idcarpeta;

            $id_cliente = $this->_getParam('cliente');
            $this->view->id_cliente=$id_cliente;

            $subcarpeta = $this->_getParam('carpeta');
            $this->view->subcarpeta=$subcarpeta;
        }else {

            return $this-> _redirect('/');
        
        } 

    }   //Carpetas 2


    public function requestadddocs2Action(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $cliente= $post['id_clientes'];
        $subcarpeta= $post['idsubcarpetas'];
        $carpeta= $post['idcarpetas'];

        if($this->getRequest()->getPost()){
            $table="clientes_archivos";
            $name = $_FILES['urla']['name'];
            
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            } else {

                $bytes = $_FILES['urla']['size'];
                $res = $this->formatSizeUnits($bytes);
                
                if($res == 0){       
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                } else {
                    $info1 = new SplFileInfo($_FILES['urla']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/clientes/archivos/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['urla']['tmp_name'],$urldb);
                }
            }

            $result = $this->_cliente->insertarchivosub2($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/clientes/subcarpeta2/id/'.$subcarpeta.'/cliente/'.$cliente.'/carpeta/'.$carpeta.'');
            
            } else {
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   // Agregar Documento Subcarpeta2


    public function archivoedit3Action(){
        
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $table="clientes_archivos";
            $wh="id";
            $this->view->archivoedit3 = $this->_season->GetSpecific($table,$wh,$id);

            $subcarpeta = $this->_getParam('carpeta');
            $this->view->subcarpeta=$subcarpeta;
        }   else {
            return $this-> _redirect('/');
        }   
    }  // END EDIT ARCHIVO2
    
    public function requestupdatearchivos2Action(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true); 
        $post = $this->getRequest()->getPost();

        $cliente = $post['id_cliente'];
        $subcarpeta= $post['idcta'];
        $carpeta= $post['carpeta'];

        if($this->getRequest()->getPost()){
            $table="clientes_archivos";
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
                    $url1 = 'img/clientes/archivos/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="clientes_archivos";
            $result = $this->_cliente->updatearchivo($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/clientes/subcarpeta2/id/'.$subcarpeta.'/cliente/'.$cliente.'/carpeta/'.$carpeta.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   //END REQUEST UPDATE ARCHIVO2
    
        




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