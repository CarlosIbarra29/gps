<?php
class MaterialesController extends Zend_Controller_Action{
    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_project = new Application_Model_GpsProyectoModel;
        $this->_material = new Application_Model_GpsMaterialesModel;

        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }

    }//END INIT

    public function materialesAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $id=$this->_session->id;
        $solicitud = $this->_material->solicitudpendiente($id);
        $count=count($solicitud);
        if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
        $no_of_records_per_page = 20;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $this->view->paginator=$this->_material->solicitudependientespaginator($offset,$no_of_records_per_page,$id);
    }

    public function crearsolicitudmaterialesAction(){
        $table="sitios";
        $this->view->sitios = $this->_season->GetAll($table);
    }

    public function solicitudmaterialdosAction(){
        $id_sitio = $this->_getParam('id');
        $this->view->sitio=$id_sitio;
        $wh="id";
        $table="materiales_solicitud";
        $usr = $this->_season->GetSpecific($table,$wh,$id_sitio);

            if($usr[0]['id_sitio'] == 0){
                $this->view->opp = 0;
            }else{
                $this->view->opp = 1;
                $id_sit = $usr[0]['id_sitio'];
                $table="sitios_tipoproyecto";
                $wh="id_sitio";
                $ver = $this->view->proyectos =$this->_sitio->gettipoproyectosolicitud($id_sit);      
            }

    }

    public function editpasounomaterialesAction(){
        $id_sitio = $this->_getParam('id');
        $this->view->sitio=$id_sitio;
        $wh="id";
        $table="materiales_solicitud";
        $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id_sitio);

        $table="sitios";
        $this->view->sitios = $this->_season->GetAll($table);
    }

    public function auditoriamaterialesAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $status = $this->_getParam('status');
        $this->view->opcion_status = $status;
        
        $step = 1; $dato = 0;
        $en_proceso = $this->_material->getsolicitudesmateriales($step,$dato);
        $count_enproceso = count($en_proceso);
        $this->view->en_proceso = $count_enproceso;

        $this->view->alertas=$this->_material->getmaterialesVencidos($step,$status);
        
        $step = 1;
        $solicitud = $this->_material->getsolicitudesmateriales($step,$status);
        $count=count($solicitud);
        if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_material->getsolicitudesmaterialpag($step,$status,$offset,$no_of_records_per_page);
    }

    public function buscadormaterialesAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $step = 1;
        $status = 0;
        $en_proceso = $this->_material->getsolicitudsteponematerial($step,$status);
        $count_enproceso = count($en_proceso);
        $this->view->en_proceso = $count_enproceso;

        $status=$this->_getParam('status');
        $this->view->opcion_status=$status;

        $op = $this->_getParam('op'); 
        $this->view->opcion=$op;

        if($op == 1){
            $step = 1;
            $sitio=$this->_getParam('sitio');
            $this->view->sitio_selected=$sitio;
            $envio = $this->_material->getsitiobuscador($step,$status,$sitio);
            $count=count($envio);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1; } 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_material->getsitiobuscadorpaginator($step,$status,$sitio,$offset,$no_of_records_per_page);
        }

        if($op == 2){
            $step = 1;
            $dia=$this->_getParam('dia'); $mes=$this->_getParam('mes'); $year=$this->_getParam('year');
            $fecha = $dia."/".$mes."/".$year;
            $this->view->fecha_selected=$fecha;
            $envio = $this->_material->getfechabuscador($step,$status,$fecha);
            $count=count($envio);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_material->getfechabuscadorpaginator($step,$status,$fecha,$offset,$no_of_records_per_page);
        }

        if($op == 3){
            $step = 1;
            $user=$this->_getParam('user');
            $this->view->user_selected=$user;
            $envio = $this->_material->getnamebuscador($step,$status,$user);
            $count=count($envio);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{ $pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $ver = $this->view->paginator= $this->_material->getuserbuscadorpaginator($step,$status,$user,$offset,$no_of_records_per_page);
        }

        if($op == 4){
            $step = 1;
            $solicitud=$this->_getParam('solicitud');
            $this->view->id_selected=$solicitud;
            $dato = $this->_material->getidbuscador($step,$status,$solicitud);
            
            $count=count($dato);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $ver = $this->view->paginator= $this->_material->getidbuscadorpaginator($step,$status,$solicitud,$offset,$no_of_records_per_page);
        }

        if($op == 5){
            $step = 1;
            $solicitud=$this->_getParam('check');
            $this->view->id_selected=$solicitud;
            $dato = $this->_material->getcheckbuscador($step,$status,$solicitud);
            
            $count=count($dato);
            if(isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $ver = $this->view->paginator= $this->_material->getcheckbuscadorpaginator($step,$status,$solicitud,$offset,$no_of_records_per_page);
        }

    }

    public function materialdetailAction(){
        $status = $this->_getParam('status');
        $this->view->opcion_status = $status;

        $id = $this->_getParam('id');
        $this->view->id_material = $id;
        $this->view->info=$this->_material->getdetailsolicitud($id);

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->rol_user=$usr[0]['fkroles'];

        $id=$this->_getParam('id');
        $wh="id_solicitud";
        $table="comentario_material";
        $this->view->comentario= $this->_season->GetSpecific($table,$wh,$id);
    }

    public function pdfmaterialesAction(){
        $status = $this->_getParam('status');
        $this->view->opcion_status = $status;

        $id = $this->_getParam('id');
        $this->view->id_material = $id;
        $this->view->info=$this->_material->getdetailsolicitud($id);       
    }

    public function requestaddsolicitudmaterialAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        // var_dump($post);exit;

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $nombre_usuario = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];
        $id_user = $usr[0]['id'];

        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");

        if($post['sitio']  == 0){
            $nombre_sitio = "Stock Almacen";
        }else{
            $sit =$post['sitio'];
            $wh="id";
            $table="sitios";
            $sitio = $this->_season->GetSpecific($table,$wh,$sit);
            $nombre_sitio = $sitio[0]['nombre'];
        }

        $table="materiales_solicitud";  
        $result = $this->_material->insertmaterialsolicitud($post,$table,$nombre_sitio,$nombre_usuario,$hoy,$id_user);

        if ($result) {
            return $this-> _redirect('/materiales/solicitudmaterialdos/id/'.$result.'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }   
    }

    public function requestupdatesolicitudunoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();   
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $nombre_usuario = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];
        $id_user = $usr[0]['id'];

        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");

        if($post['sitio']  == 0){
            $nombre_sitio = "Stock Almacen";
        }else{
            $sit =$post['sitio'];
            $wh="id";
            $table="sitios";
            $sitio = $this->_season->GetSpecific($table,$wh,$sit);
            $nombre_sitio = $sitio[0]['nombre'];
        }

        $table="materiales_solicitud";  
        $result = $this->_material->updatemterialesduno($post,$table,$nombre_sitio,$nombre_usuario,$hoy,$id_user);

        if ($result) {
            return $this-> _redirect('/materiales/solicitudmaterialdos/id/'.$post['ids'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }   
    }

    public function requestaddsolicitudmaterialdosAction(){
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
                $url1 = 'pdf/materiales/';
                $material = $url1.$info1;
                move_uploaded_file($_FILES['url']['tmp_name'],$material);
            }
        } 
        $table="materiales_solicitud";  
        $result = $this->_material->updatemterialesdos($post,$table,$material);

        if ($result) {
            return $this-> _redirect('/materiales/materiales');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 
    }

    public function requestupdatechangestatusAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->getRequest()->getPost()){

            $post = $this->getRequest()->getPost();
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y h:i:sa");
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $name_auditor = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];

            $table="materiales_solicitud";
            $result = $this->_material->updateauditoriamaterial($post,$table,$hoy,$name_auditor);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                    
            }
        }
    }

    public function addcomentariosolicitudAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->getRequest()->getPost()){

            $post = $this->getRequest()->getPost();
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y h:i:sa");
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $name_auditor = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];

            $table="comentario_material";
            $result = $this->_material->insertcomentarios($post,$table,$hoy,$name_auditor);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                    
            }
        }
    }

    public function requestupdatecomentariosolicitudAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->getRequest()->getPost()){

            $post = $this->getRequest()->getPost();
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y h:i:sa");
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $name_auditor = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];

            $table="comentario_material";
            $result = $this->_material->updatecomentariosol($post,$table,$hoy,$name_auditor);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                    
            }
        }
    }

    public function requestupdatefechaolicitudAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->getRequest()->getPost()){

            $post = $this->getRequest()->getPost();
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y h:i:sa");
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $name_auditor = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];

            $table="materiales_solicitud";
            $result = $this->_material->updatesoldate($post,$table,$hoy,$name_auditor);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                    
            }
        }
    }


    public function requestdeletesolicitumaterialesAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="materiales_solicitud";
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


    public function requestupdatestatuscheckAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $table="materiales_solicitud";  
        $result = $this->_material->updatcheckselect($post,$table);

        if ($result) {
            return $this-> _redirect('/materiales/materialdetail/id/'.$post['ids'].'/status/'.$post['status'].'');
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