<?php

class VehiculosController extends Zend_Controller_Action{
	private $_season;
    private $_session;
    private $_user;
    private $_epp;
    private $_veh;

    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_project = new Application_Model_GpsProyectoModel;
        $this->_colo = new Application_Model_GpsColocacionModel;
        $this->_epp = new Application_Model_GpsEppModel;
        $this->_veh = new Application_Model_GpsVehiculosModel;

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
    }

    public function inventariovAction(){
        
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $id_user=$this->_session->id;
        $this->view->usuario = $id_user;

        $status = $this->_getParam('status');
        $this->view->status_back = $status;

        $wh="id";
        $table="usuario";
        $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);

        $table = "vehiculos_documentacion"; 
        $this->view->alertas=$this->_veh->GetVigenciasAll($table);

        $table = "vehiculos_documentacion"; 
        $this->view->alertasvencidas=$this->_veh->GetVigenciasven($table);
        

        $table="vehiculos_grupo";
        $this->view->grupov = $this->_season->GetAll($table);

        $table="vehiculos";
        $vehinv=$this->_season->GetAll($table);
        $count=count($vehinv);

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
        $table="vehiculos";
        $sql= $this->view->paginator= $this->_veh->Getpaginationveh($table,$offset,$no_of_records_per_page);  

    }// END Vehiculos Inventario

 public function buscarvehiculoAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $id_user=$this->_session->id;
        $this->view->usuario = $id_user;

        $status = $this->_getParam('status');
        $this->view->status_back = $status;

        $wh="id";
        $table="usuario";
        $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);

        $table="vehiculos_grupo";
        $this->view->grupov = $this->_season->GetAll($table);

        if($this->_hasParam('marca')){
            $name = $this->_getParam('marca');
            $marca_veh= $this->_veh->marca($name);
            
            $option= 1;
            $this->view->name_marca=$name; 
            
            $pla = "vacio";
            $this->view->placas_v=$pla;
            
            $this->view->status_v= 0;

            $this->view->option=$option; 
            $count=count($marca_veh);
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
            $sql= $this->view->paginator= $this->_veh->marcavcount($name,$offset,$no_of_records_per_page);
        }

        if($this->_hasParam('placas')){
            $placas = $this->_getParam('placas');
            $placas_count= $this->_veh->placas($placas);
            $this->view->placas_v=$placas;
            
            $name="vacio";
            $this->view->name_marca=$name; 
            
            $option= 2;
            $this->view->option=$option;
            $count=count($placas_count);
            if (isset($_GET['pagina'])) {
                $pagina = $_GET['pagina'];
            }else{
                $pagina= $this->view->pagina = 1;
            }   
            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;


            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $sql= $this->view->paginator= $this->_veh->placasvcount($placas,$offset,$no_of_records_per_page);
        }

        if($this->_hasParam('status')){
            $status = $this->_getParam('status');
            $status_her= $this->_veh->status($status);
            $this->view->status_v=$status;
            $placas="vacio";
            $this->view->placas_v=$placas;
            $name="vacio";
            $this->view->name_marca=$name;

            $option= 3;
            $this->view->option=$option;
            $count=count($status_her);
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
            $sql= $this->view->paginator= $this->_veh->statusvcount($status,$offset,$no_of_records_per_page);
        } 

    } //End Buscar Vehículo


    public function requestdeletevehAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="vehiculos";
            $wh="id_vehiculos";
            $result = $this->_season->deleteAll($id,$table,$wh);

            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }//END REQUEST DELETE VEHICULO


    public function requestaddvehAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
       
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){
            $table="vehiculos";
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
                    $url1 = 'img/vehiculos/autos/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }

            $name = $_FILES['url2']['name'];
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            }else{
                $bytes = $_FILES['url2']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['url2']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/vehiculos/tarjetas_circulacion/';
                    $urldb2 = $url1.$info1;
                    move_uploaded_file($_FILES['url2']['tmp_name'],$urldb2);
                }
            }
           
            $table="vehiculos";
            $result = $this->_veh->insertveh($post,$table,$urldb,$urldb2);

            if ($result) {
                return $this-> _redirect('/vehiculos/inventariov');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    } //END ADD VEHICULO

    public function vehiculoeditAction(){
           if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $table="vehiculos";
            $wh="id_vehiculos";
            $this->view->vehiculos_act = $this->_season->GetSpecific($table,$wh,$id);


            $table="vehiculos_grupo";
            $this->view->grupov = $this->_season->GetAll($table);

            $op = $this->_getParam('op'); 
            $this->view->op_sel=$op; 

            $marca = $this->_getParam('marca'); 
            $this->view->marca=$marca;

            $placas = $this->_getParam('placas'); 
            $this->view->placas=$placas;

            $status = $this->_getParam('status'); 
            $this->view->status=$status;

        }else {
            return $this-> _redirect('/');
        }   

    }// END EDIT VEHICULO

    public function requestupdatevhAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
       
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){

            $table="vehiculos";
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
                    $url1 = 'img/vehiculos/autos/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $name = $_FILES['url2']['name'];
            $urldb2 = $post["imatarjeta"];
            if(!empty($_FILES["url2"]["name"])) {
                $bytes = $_FILES['url2']['size'];
                $res = $this->formatSizeUnits($bytes);
                if ($res == 0) {
                    print '<script language="JavaScript">'; 
                    print 'alert("La imagen supera el maximo de tamaño");'; 
                    print '</script>';
                } else {
                    unlink($post['imatarjeta']);
                    $info1 = new SplFileInfo($_FILES['url2']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/vehiculos/tarjetas_circulacion/';
                    $urldb2 = $url1.$info1;
                    move_uploaded_file($_FILES['url2']['tmp_name'],$urldb2);
                }
            }//end de if

            $table="vehiculos";
            $result = $this->_veh->updateveh($post,$table,$urldb,$urldb2);

            if ($result) {
                return $this-> _redirect('/vehiculos/inventariov');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    } //END UPDATE VEHICULO


    public function vehdetailAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="vehiculos";
            $wh="id_vehiculos";
            $this->view->vehiculosc = $this->_veh->GetVehiculos($table,$id);

            $this->view->per = $this->_veh->GetPersonalV();

            $this->view->pers = $this->_veh->GetdatosV($wh,$id);

            $table = "vehiculos_documentacion"; 
            $this->view->alertas=$this->_veh->GetVigenciasSpecific($table,$id);

            $table = "vehiculos_documentacion"; 
            $this->view->alertasvencidas=$this->_veh->GetVigenciasvenSpecific($table,$id);

            $op = $this->_getParam('op'); 
            $this->view->op_sel=$op; 

            $marca = $this->_getParam('marca'); 
            $this->view->marca=$marca;

            $placas = $this->_getParam('placas'); 
            $this->view->placas=$placas;

            $status = $this->_getParam('status'); 
            $this->view->status=$status;

            $veh = $this->_getParam('id');
            $this->view->idvh=$veh;
        }else {
            return $this-> _redirect('/');
        }       

    } // END VEHICULO DETAIL

    public function updatetarjetaAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){

            $table="vehiculos";
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
                    $url1 = 'img/vehiculos/tarjetas_circulacion/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="vehiculos";
            $result = $this->_veh->updateTarjeta($post,$table,$urldb);

            if ($result) {
                return $this-> _redirect('/vehiculos/vehdetail/id/'.$post['idhs'].''); 
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   // Añadir Tarjeta

    public function updatemodtarjetaAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){

            $table="vehiculos";
            $name = $_FILES['url2']['name'];
            $urldb = $post["imahidden"];
            if(!empty($_FILES["url2"]["name"])) {
                $bytes = $_FILES['url2']['size'];
                $res = $this->formatSizeUnits($bytes);
                if ($res == 0) {
                    print '<script language="JavaScript">'; 
                    print 'alert("La imagen supera el maximo de tamaño");'; 
                    print '</script>';
                } else {
                    unlink($post['imahidden']);
                    $info1 = new SplFileInfo($_FILES['url2']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/vehiculos/tarjetas_circulacion/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url2']['tmp_name'],$urldb);
                }
            }   //end de if
            
            $table="vehiculos";
            $result = $this->_veh->updateTarjeta($post,$table,$urldb);

            if ($result) {
                return $this-> _redirect('/vehiculos/vehdetail/id/'.$post['idhs'].''); 
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   // Modificar Tarjeta

    public function requestasignarvehAction(){
       
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");
            
            $id = $post['responsable'];
            $table = "tarjeta_efecticard";
            $wh="id_responsable";
            $tarjetas = $this->view->tefecticard = $this->_season->GetSpecific($table,$wh,$id);

            if ($tarjetas == null) {
               $efecticard = null;
            } else{
                $efecticard = $tarjetas[0]['no_tarjeta'];
            }

            $table="vehiculos_operadores";
                $name = $_FILES['archivo']['name'];
                if(empty($name)){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("Agrega una imagen");'; 
                    print '</script>'; 
                }else{
                    $bytes = $_FILES['archivo']['size'];
                    $res = $this->formatSizeUnits($bytes);

                    if($res == 0){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("El pdf supera el maximo de tamaño");'; 
                        print '</script>'; 
                    }else{
                        $info1 = new SplFileInfo($_FILES['archivo']['name']);
                        $ext1 = $info1->getExtension();
                        $url1 = 'img/vehiculos/operadores/';
                        $urldb = $url1.$info1;
                        move_uploaded_file($_FILES['archivo']['tmp_name'],$urldb);
                    }
                }//end de if

            $table="vehiculos_operadores";
            $this->_veh->InsertVehOp($post,$table,$hoy,$efecticard,$urldb);

            $table="vehiculos";
            $result = $this->_veh->UpdateStatusVeh($post,$table,$hoy);

            if ($result) {

                // echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post)); 
                return $this-> _redirect('/vehiculos/vehdetail/id/'.$post['idveh'].'');   
            
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }   // END ASIGNAR VEHICULO

    public function requestregresarvAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");

            $table="vehiculos_operadores";
                $name = $_FILES['archivo2']['name'];
                if(empty($name)){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("Agrega una imagen");'; 
                    print '</script>'; 
                }else{
                    $bytes = $_FILES['archivo2']['size'];
                    $res = $this->formatSizeUnits($bytes);

                    if($res == 0){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("El pdf supera el maximo de tamaño");'; 
                        print '</script>'; 
                    }else{
                        $info1 = new SplFileInfo($_FILES['archivo2']['name']);
                        $ext1 = $info1->getExtension();
                        $url1 = 'img/vehiculos/operadores/';
                        $urldb = $url1.$info1;
                        move_uploaded_file($_FILES['archivo2']['tmp_name'],$urldb);
                    }
                }//end de if
            
            $table="vehiculos_operadores";
            $this->_veh->UpdateVehOp($post,$table,$hoy,$urldb);

            $table="vehiculos";
            $result = $this->_veh->UpdateStatusReturn($post,$table);

            if ($result) {

                // echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
                return $this-> _redirect('/vehiculos/vehdetail/id/'.$post['idveh'].'');   
            
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }   // END REGRESAR VEHICULO


    public function requestbajavAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){
            $table="vehiculos";
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
                    $url1 = 'img/vehiculos/baja/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");

            $table="vehiculos";
            $result = $this->_veh->UpdateStatusVB($post,$table,$urldb,$hoy);
            
            if ($result) {
                return $this-> _redirect('/vehiculos/vehdetail/id/'.$post['idh'].''); 
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   // END BAJA VEHICULO

        
    
    public function requestvehrAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){
            $tiporep = $post['accion'];

            if ($tiporep == 1) {

                $table="vehiculos_manto";
                $name = $_FILES['imagenm']['name'];
                if(empty($name)){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("Agrega una imagen");'; 
                    print '</script>'; 
                }else{
                    $bytes = $_FILES['imagenm']['size'];
                    $res = $this->formatSizeUnits($bytes);

                    if($res == 0){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("El pdf supera el maximo de tamaño");'; 
                        print '</script>'; 
                    }else{
                        $info1 = new SplFileInfo($_FILES['imagenm']['name']);
                        $ext1 = $info1->getExtension();
                        $url1 = 'img/vehiculos/manto/';
                        $urldb = $url1.$info1;
                        move_uploaded_file($_FILES['imagenm']['tmp_name'],$urldb);
                    }
                }//end de if

                $table="vehiculos_manto";
                $this->_veh->insertrepmanto($post,$table,$urldb);

                $table="vehiculos";
                $result = $this->_veh->UpdateStatusVRM($post,$table);
                if ($result) {
                    return $this-> _redirect('/vehiculos/vehdetail/id/'.$post['idhs'].''); 
                }else{
                    print '<script language="JavaScript">'; 
                    print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                    print '</script>'; 
                }
            }

            if ($tiporep == 2) {

                $table="vehiculos_incidentes";
                $name = $_FILES['imagenv']['name'];
                if(empty($name)){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("Agrega una imagen");'; 
                    print '</script>'; 
                }else{
                    $bytes = $_FILES['imagenv']['size'];
                    $res = $this->formatSizeUnits($bytes);

                    if($res == 0){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("El pdf supera el maximo de tamaño");'; 
                        print '</script>'; 
                    }else{
                        $info1 = new SplFileInfo($_FILES['imagenv']['name']);
                        $ext1 = $info1->getExtension();
                        $url1 = 'img/vehiculos/incidentes/';
                        $urldb1 = $url1.$info1;
                        move_uploaded_file($_FILES['imagenv']['tmp_name'],$urldb1);
                    }
                }//end de if

                $name = $_FILES['imageni']['name'];
                if(empty($name)){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("Agrega una imagen");'; 
                    print '</script>'; 
                }else{
                    $bytes = $_FILES['imageni']['size'];
                    $res = $this->formatSizeUnits($bytes);

                    if($res == 0){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("El pdf supera el maximo de tamaño");'; 
                        print '</script>'; 
                    }else{
                        $info1 = new SplFileInfo($_FILES['imageni']['name']);
                        $ext1 = $info1->getExtension();
                        $url1 = 'img/vehiculos/incidentes/';
                        $urldb2 = $url1.$info1;
                        move_uploaded_file($_FILES['imageni']['tmp_name'],$urldb2);
                    }
                }//end de if

                $table="vehiculos_incidentes";
                $this->_veh->insertrepinc($post,$table,$urldb1,$urldb2);

                $table="vehiculos";
                $result = $this->_veh->UpdateStatusVRI($post,$table);
                if ($result) {
                    return $this-> _redirect('/vehiculos/vehdetail/id/'.$post['idhs'].''); 
                }else{
                    print '<script language="JavaScript">'; 
                    print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                    print '</script>'; 
                }
            } 
        }
    }   //END REPARAR VEHICULO

    public function requestvehreparadoAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");
            
            $table="vehiculos_manto";
            $this->_veh->UpdateManto($post,$table,$hoy);

            $table="vehiculos_incidentes";
            $this->_veh->UpdateInc($post,$table,$hoy);

            $table="vehiculos";
            $result = $this->_veh->UpdateStatusRep($post,$table);
            
            if ($result) {
                
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }
    }   // END Vehiculo Reparado

    public function catalogosAction(){
        
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="vehiculos_grupo";
        $this->view->vehiculo_g = $this->_season->GetAll($table);

        $vhg=$this->_season->GetAll($table);
        $count=count($vhg);

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
        $table="vehiculos_grupo";
        $sql= $this->view->paginator= $this->_veh->Getpaginationgrupo($table,$offset,$no_of_records_per_page);   

    }   // CATALOGO GRUPO

    public function requestaddgrupoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){

            $table="vehiculos_grupo";
            $result = $this->_veh->insertgrupo($post,$table);
            if ($result) {
                return $this-> _redirect('/vehiculos/catalogos');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END ADD GRUPO

    public function grupoeditAction(){
        
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $table="vehiculos_grupo";
            $wh="id_grupo";
            $this->view->vehiculog = $this->_season->GetSpecific($table,$wh,$id);

        }else {
            return $this-> _redirect('/');
        }   
    }  // END EDIT GRUPO  

    public function requestupdategrupoAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            $table="vehiculos_grupo";
            $result = $this->_veh->updategrupo($post,$table);
            if ($result) {
                return $this-> _redirect('/vehiculos/catalogos');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//END REQUEST UPDATE GRUPO

    public function excelvAction(){
        $status=$this->_getParam('status');
        $this->view->status=$status;

        $table="vehiculos";
        $this->view->excelv = $this->_veh->excelvh($table);

    }   // EXCEL VEHICULOS

    public function serviciosvAction(){

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $table="vehiculo_servicios";
        $serv = $this->_season->GetAll($table); 
        $count=count($serv);

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
        $table="vehiculo_servicios";
        $sql= $this->view->servicio= $this->_veh->GetpaginationservicioV($table,$offset,$no_of_records_per_page);    

    }


    public function requesataddservicioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){

            if ($post['statusuno'] == 0) {
                $statusu = 0;
            } else{
                $statusu = 1;
            }

            if ($post['statusdos'] == 0) {
                $statusd = 0;
            } else{
                $statusd = 1;
            }

            if ($post['statustres'] == 0) {
                $statust = 0;
            } else{
                $statust = 1;
            }

            if ($post['statuscuatro'] == 0) {
                $statuscu = 0;
            } else{
                $statuscu = 1;
            }

            if ($post['statuscinco'] == 0) {
                $statusci = 0;
            } else{
                $statusci = 1;
            }

            if ($post['statusseis'] == 0) {
                $statusse = 0;
            } else{
                $statusse = 1;
            }

            if ($post['statussiete'] == 0) {
                $statussi = 0;
            } else{
                $statussi = 1;
            }

            $table="vehiculo_servicios";
            $result = $this->_veh->insertservicio($post,$table,$statusu,$statusd,
                $statust,$statuscu,$statusci,$statusse,$statussi);
            
            if ($result) {
                return $this-> _redirect('/vehiculos/serviciosv');
            
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   //END ADD SERVICIO

    public function serveditAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $table="vehiculo_servicios";
            $wh="id";
            $hola=$this->view->serviciosV = $this->_season->GetSpecific($table,$wh,$id);
            // var_dump($hola);
            // die();
        }else {
            return $this-> _redirect('/');
        }   
    }

    public function requestupdateservicioAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){

            if ($post['statusuno'] == 0) {
                $statusu = 0;
            } else{
                $statusu = 1;
            }

            if ($post['statusdos'] == 0) {
                $statusd = 0;
            } else{
                $statusd = 1;
            }

            if ($post['statustres'] == 0) {
                $statust = 0;
            } else{
                $statust = 1;
            }

            if ($post['statuscuatro'] == 0) {
                $statuscu = 0;
            } else{
                $statuscu = 1;
            }

            if ($post['statuscinco'] == 0) {
                $statusci = 0;
            } else{
                $statusci = 1;
            }

            if ($post['statusseis'] == 0) {
                $statusse = 0;
            } else{
                $statusse = 1;
            }

            if ($post['statussiete'] == 0) {
                $statussi = 0;
            } else{
                $statussi = 1;
            }

            $table="vehiculo_servicios";
            $result = $this->_veh->updateServicioV($post,$table,$statusu,$statusd,
                $statust,$statuscu,$statusci,$statusse,$statussi);
            
            if ($result) {
                return $this-> _redirect('/vehiculos/serviciosv');
            
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }  
    }

    public function requestdeleteserviciovAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="vehiculo_servicios";
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
    }   //END REQUEST DELETE SERVICIO

    public function operadoresAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="vehiculos";
            $wh="id_vehiculos";
            $this->view->vehiculosc = $this->_veh->GetVehiculos($table,$id);

            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;

            $table="vehiculos_operadores";
            $vehop = $this->view->vehasignado = $this->_veh->GetVehiculosAsignado($table,$id);
            $count=count($vehop);

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
            $table="vehiculos_operadores";
            $sql= $this->view->paginator= $this->_veh->GetpaginationOperador($table,$offset,$no_of_records_per_page,$id);

            $veh = $this->_getParam('id');
            $this->view->idvh=$veh;
        }else {

            return $this-> _redirect('/');
        
        } 

    }

    public function updatearchivoAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){

            $table="vehiculos_operadores";
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
                    $url1 = 'img/vehiculos/operadores/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="vehiculos_operadores";
            $result = $this->_veh->updateArcOp($post,$table,$urldb);

            if ($result) {
                return $this-> _redirect('/vehiculos/operadores/id/'.$post['idhs'].''); 
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    } // Añadir Archivo

    public function updatemodarchivoAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){

            $table="vehiculos_operadores";
            $name = $_FILES['url2']['name'];
            $urldb = $post["imahidden"];
            if(!empty($_FILES["url2"]["name"])) {
                $bytes = $_FILES['url2']['size'];
                $res = $this->formatSizeUnits($bytes);
                if ($res == 0) {
                    print '<script language="JavaScript">'; 
                    print 'alert("La imagen supera el maximo de tamaño");'; 
                    print '</script>';
                } else {
                    unlink($post['imahidden']);
                    $info1 = new SplFileInfo($_FILES['url2']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/vehiculos/operadores/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url2']['tmp_name'],$urldb);
                }
            }   //end de if
            
            $table="vehiculos_operadores";
            $result = $this->_veh->updateArcOp($post,$table,$urldb);

            if ($result) {
                return $this-> _redirect('/vehiculos/operadores/id/'.$post['idhs'].''); 
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   // Modificar Archivo


    public function updatearchivo2Action(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){

            $table="vehiculos_operadores";
            $name = $_FILES['url3']['name'];
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            }else{
                $bytes = $_FILES['url3']['size'];
                $res = $this->formatSizeUnits($bytes);

                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['url3']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/vehiculos/operadores/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url3']['tmp_name'],$urldb);
                }
            }//end de if

            $table="vehiculos_operadores";
            $result = $this->_veh->updateArc2Op($post,$table,$urldb);

            if ($result) {
                return $this-> _redirect('/vehiculos/operadores/id/'.$post['idhs'].''); 
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    } // Añadir Archivo 2

    public function updatemodarchivo2Action(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){

            $table="vehiculos_operadores";
            $name = $_FILES['url4']['name'];
            $urldb = $post["imahidden2"];
            if(!empty($_FILES["url4"]["name"])) {
                $bytes = $_FILES['url4']['size'];
                $res = $this->formatSizeUnits($bytes);
                if ($res == 0) {
                    print '<script language="JavaScript">'; 
                    print 'alert("La imagen supera el maximo de tamaño");'; 
                    print '</script>';
                } else {
                    unlink($post['imahidden2']);
                    $info1 = new SplFileInfo($_FILES['url4']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/vehiculos/operadores/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url4']['tmp_name'],$urldb);
                }
            }   //end de if
            
            $table="vehiculos_operadores";
            $result = $this->_veh->updateArc2Op($post,$table,$urldb);

            if ($result) {
                return $this-> _redirect('/vehiculos/operadores/id/'.$post['idhs'].''); 
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   // Modificar Archivo2

    public function incidentesAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="vehiculos";
            $wh="id_vehiculos";
            $this->view->vehiculosc = $this->_veh->GetVehiculos($table,$id);

            // $table="vehiculos_incidentes";
            // $this->view->vehincidente = $this->_veh->GetVehiculosIncidente($table,$id);

            $table="vehiculos_solicitudes";
            $this->view->solicitud = $this->_veh->GetSolicitudes($table,$id);

            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;

            $table="vehiculos_incidentes";
            $vehinc = $this->view->vehincidente = $this->_veh->GetVehiculosIncidente($table,$id);
            $count=count($vehinc);

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
            $table="vehiculos_incidentes";
            $sql= $this->view->paginator= $this->_veh->GetpaginationInc($table,$offset,$no_of_records_per_page,$id);

            $veh = $this->_getParam('id');
            $this->view->idvh=$veh;
        }else {

            return $this-> _redirect('/');
        
        } 

    }

    public function updatesolincAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){

            $table="vehiculos_incidentes";
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
                    $url1 = 'img/vehiculos/incidentes/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="vehiculos_incidentes";
            $this->_veh->updateAsgSol($post,$table,$urldb);

            $table="vehiculos_solicitudes";
            $result = $this->_veh->updatesol($post,$table);

            if ($result) {
                return $this-> _redirect('/vehiculos/incidentes/id/'.$post['idhs'].''); 
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function excelincAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $table="vehiculos_incidentes";
            $this->view->vehincidente = $this->_veh->GetVehiculosIncidente($table,$id);
        
        }else {

            return $this-> _redirect('/');
        
        } 

    }   // EXCEL VEHICULOS INCIDENCIAS

    public function mantenimientoAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="vehiculos";
            $wh="id_vehiculos";
            $this->view->vehiculosc = $this->_veh->GetVehiculos($table,$id);

            // $table="vehiculos_manto";
            // $this->view->vehmantenimiento = $this->_veh->GetVehiculosManto($table,$id);

            $table="vehiculos_solicitudes";
            $this->view->solicitud = $this->_veh->GetSolicitudes($table,$id);

            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;

            $table="vehiculos_manto";
            $vehmto =$this->view->vehmantenimiento = $this->_veh->GetVehiculosManto($table,$id);
            $count=count($vehmto);

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
            $table="vehiculos_manto";
            $sql= $this->view->paginator= $this->_veh->GetpaginationMto($table,$offset,$no_of_records_per_page,$id);

            $veh = $this->_getParam('id');
            $this->view->idvh=$veh;
        }else {

            return $this-> _redirect('/');
        
        } 

    }

    public function updatesolmantoAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){

            $table="vehiculos_manto";
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
                    $url1 = 'img/vehiculos/manto/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="vehiculos_manto";
            $this->_veh->updateMtnSol($post,$table,$urldb);

            $table="vehiculos_solicitudes";
            $result = $this->_veh->updatesol($post,$table);

            if ($result) {
                return $this-> _redirect('/vehiculos/mantenimiento/id/'.$post['idhs'].''); 
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function excelmtoAction(){

          if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $table="vehiculos_manto";
            $this->view->vehmantenimiento = $this->_veh->GetVehiculosManto($table,$id);
        
        }else {

            return $this-> _redirect('/');
        
        } 

    }   // EXCEL VEHICULOS MANTENIMIENTO


    public function documentacionAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="vehiculos";
            $wh="id_vehiculos";
            $this->view->vehiculosc = $this->_veh->GetVehiculos($table,$id);

            $table="vehiculos_tpodoc";
            $this->view->tpodoc = $this->_season->GetAll($table);

            $table="vehiculos_tpodoc";
            $this->view->tpod = $this->_veh->GetAdoc($table,$id);


            $id_user=$this->_session->id;
            $this->view->usuario = $id_user;

            $wh="id";
            $table="usuario";
            $this->view->user = $this->_season->GetSpecific($table,$wh,$id_user);

            $table="vehiculos_solicitudes";
            $this->view->solicitud = $this->_veh->GetSolicitudes($table,$id);

            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;

            $table="vehiculos_documentacion";
            $vehdct = $this->view->vehdoc = $this->_veh->GetVehiculosDoc($table,$id);
            $count=count($vehdct);

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
            $table="vehiculos_documentacion";
            // $sql= $this->view->paginator= $this->_veh->GetpaginationDoc($table,$offset,$no_of_records_per_page,$id);

            $paginator = $this->_veh->GetpaginationDoc($table,$offset,$no_of_records_per_page,$id);
            
            foreach ($paginator as $key => $value) {

                $aResponse = false ;

                $fechaActual = date('Y-m-d'); 

                $datetime1 = date_create($value['vigencia']);

                $datetime2 = date_create($fechaActual);

                $contador = date_diff($datetime1, $datetime2);

                $differenceFormat = '%a';

                $dias =  $contador->format($differenceFormat);

                if ( 30 > $dias) {
                      
                    $aResponse =  true ;
                    
                }

                $paginator[$key]['diasvigencia'] = $aResponse;
            }

            $this->view->paginator = $paginator;
            
            $veh = $this->_getParam('id');
            
            $this->view->idvh=$veh;
        
        }   else {

            return $this-> _redirect('/');
        
        } 

    }

    public function requestadddocAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $id = $post['nombred'];
        $table = "vehiculos_tpodoc";
        $wh = "id";
        $doc = $this->_season->GetSpecific($table,$wh,$id);
        
        $nombredoc = $doc[0]['nombredoc'];

        $idv = $post['idhs'];
        $table = "vehiculos";
            $porveh = $this->_veh->GetProcentaje($table,$idv);
            $actual = $porveh[0]['porcentaje_doc'];


        $table = "vehiculos_tpodoc";
            $ndoc = $this->_veh->GetNumeroDocumentos($table);
            $numerodoc = $ndoc[0]['numero'];
            $porcentaje = 100/$numerodoc;
            
        $nuevoporcentaje = $actual + $porcentaje;
            

        if($this->getRequest()->getPost()){

            $aplicable = $post['accion'];

            if ($aplicable == 1) {

                $table="vehiculos_documentacion";
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
                        $url1 = 'pdf/vehiculosdoc/';
                        $urldb = $url1.$info1;
                        move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                    }
                }//end de if

                date_default_timezone_set('America/Mexico_City');
                $hoy = date("d-m-Y");

                $table="vehiculos_documentacion";
                $this->_veh->insertdoc($post,$table,$urldb,$nombredoc,$hoy);

                $table="vehiculos";
                $this->_veh->updateporcentaje($post,$table,$nuevoporcentaje);

                $table="vehiculos_solicitudes";
                $result = $this->_veh->updatesol($post,$table);

                if ($result) {
                    return $this-> _redirect('/vehiculos/documentacion/id/'.$post['idhs'].''); 
                }else{
                    print '<script language="JavaScript">'; 
                    print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                    print '</script>'; 
                }

            } 

            if ($aplicable == 2) {

                $table="vehiculos";
                $this->_veh->updateporcentaje($post,$table,$nuevoporcentaje);

                date_default_timezone_set('America/Mexico_City');
                $hoy = date("d-m-Y");

                $table="vehiculos_documentacion";
                $result = $this->_veh->insertdoc2($post,$table,$nombredoc,$hoy);

                if ($result) {
                    return $this-> _redirect('/vehiculos/documentacion/id/'.$post['idhs'].''); 
                }else{
                    print '<script language="JavaScript">'; 
                    print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                    print '</script>'; 
                }

            }
        }
    }

    public function requestdeldocAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            $id =  $post['id'];
            $table="vehiculos_documentacion";
            $wh= "id";
            $detalles = $this->_season->GetSpecific($table,$wh,$id);
            $idv = $detalles[0]['id_vehiculo'];

            $table = "vehiculos";
            $porveh = $this->_veh->GetProcentaje($table,$idv);
            $actual = $porveh[0]['porcentaje_doc'];


            $table = "vehiculos_tpodoc";
            $ndoc = $this->_veh->GetNumeroDocumentos($table);
            $numerodoc = $ndoc[0]['numero'];
            $porcentaje = 100/$numerodoc;
            
            $nuevoporcentaje = $actual - $porcentaje;
            
            $table="vehiculos";
            $this->_veh->updateporcentaje2($post,$table,$nuevoporcentaje,$idv);
            
            // $id =  $post['id'];
            $table="vehiculos_documentacion";
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

    public function excelopAction(){

          if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="vehiculos_operadores";
            $this->view->vehasignado = $this->_veh->GetVehiculosAsignado($table,$id);

        }else {

            return $this-> _redirect('/');
        
        } 

    }   // EXCEL VEHICULOS Asignados


    public function historialvdAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="vehiculos";
            $wh="id_vehiculos";
            $this->view->vehiculosc = $this->_veh->GetVehiculos($table,$id);

            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;
            
            $año = $this->_getParam('year');
            $this->view->year=$año;
            
            $table="vehiculos_documentacion";
            $vehdct = $this->view->vehdoc = $this->_veh->GetVehiculosDocH($table,$id,$año);
            $count=count($vehdct);
            

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
            $table="vehiculos_documentacion";
            $sql= $this->view->paginator= $this->_veh->GetpaginationDocH($table,$offset,$no_of_records_per_page,$id,$año);
            
            $veh = $this->_getParam('id');
            $this->view->idvh=$veh;
        
        }   else {

            return $this-> _redirect('/');
        
        } 

    }


    public function exceldocAction(){

          if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $año = $this->_getParam('year');
            $this->view->year=$año;

            $table="vehiculos_documentacion";
            $this->view->vehmdocumentacion = $this->_veh->GetVehiculosDocE($table,$id);
        
        }else {

            return $this-> _redirect('/');
        
        } 

    }   // EXCEL VEHICULOS MANTENIMIENTO



    //////////////////////////////////////////// SOLICITUDES VEHICULOS ////////////////////////////////////////////////

    public function solservicioAction(){

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;
        $solicitud = $this->_veh->GetSolStepUno();
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
            $this->view->paginator= $this->_veh->GetStepVpaginator($offset,$no_of_records_per_page);

    }

    public function requestdeletesolAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id =  $post['id'];
            $table="vehiculos_solicitudes";
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



    public function addsolicitudvAction(){

        $table="vehiculos";
        $this->view->vehiculos = $this->_season->GetAll($table);

        $table = "sitios";
        $servicios = $this->view->sitios = $this->_veh->GetordernombresitiosV();

        $table="vehiculo_servicios";
        $this->view->servicios = $this->_season->GetAll($table);

        $table="proveedor";
        $this->view->proveedores = $this->_veh->GetProvedores($table);

        $this->view->personal = $this->_veh->GetPersonalV();

    }

    public function listasolicitudesAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;
        $wh="id_usuario";
        $table="vehiculos_solicitudes";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        // status_documento  enproceso
        
        $wh="id";
        $table="usuario";
        $user = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$user[0]['fkroles'];

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $sql = $this->_veh->GetUserSolicitudCount();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table="proveedor";
        $this->view->prov = $this->_season->GetAll($table);

        $table="vehiculos";
        $this->view->vehiculos = $this->_season->GetAll($table);

        $table="vehiculo_servicios";
        $this->view->servicios = $this->_season->GetAll($table);


        if($status == 0) {

            $solicitud=$this->_veh->GetUserSolicitudCount();
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
            $table="vehiculos_solicitudes";
            $sql=$this->view->paginator= $this->_veh->GetPagSolProceso($table,$offset,$no_of_records_per_page);
            // var_dump($sql);exit;
        }

        if($status == 1){
            $solicitud=$this->_veh->GetSolAceptCount();

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
            $table="vehiculos_solicitudes";
            $sql= $this->view->paginator= $this->_veh->GetPagSolAcept($table,$offset,$no_of_records_per_page);
        }

        if($status == 2){
            $solicitud=$this->_veh->GetSolCancelCount();
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
            $table="vehiculos_solicitudes";
            $this->view->paginator= $this->_veh->GetPagSolCancel($table,$offset,$no_of_records_per_page);
        }

        if($status == 3){
            $solicitud=$this->_veh->GetSolFinCount();
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
            $table="vehiculos_solicitudes";
            $sql= $this->view->paginator= $this->_veh->GetPagSolFin($table,$offset,$no_of_records_per_page);
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
        $table="vehiculos_solicitudes";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $sql = $this->_veh->GetUserSolicitudCount();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table="vehiculo_servicios";
        $this->view->servicios = $this->_season->GetAll($table);

        $table="proveedor";
        $this->view->prov = $this->_season->GetAll($table);

        $table="vehiculos";
        $this->view->vehiculos = $this->_season->GetAll($table);

        $opcion = $this->_getParam('op');
        $this->view->opcion_search=$opcion;

        if($status == 0) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $vehiculo = $this->_getParam('vehiculo');
                $this->view->vehiculosol=$vehiculo;
                $statusstep = 1;
                $statussol = 0;
                $statuscom = 0;
                $solicitud=$this->view->sol_auto=$this->_veh->GetSolVehiculoBuscar($vehiculo,$statusstep,$statussol,$statuscom);

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
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolVehiculoBuscarPag($table,$offset,$no_of_records_per_page,$vehiculo,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov; 
                
                $statusstep = 1;
                $statussol = 0;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolProvBuscar($prov,$statusstep,$statussol,$statuscom);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolProvBuscarPag($table,$offset,$no_of_records_per_page,$prov,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 0;
                $statuscom = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_auto=$this->_veh->GetSolIdBuscar($id,$statusstep,$statussol,$statuscom);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolIdBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 0;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolUserBuscar($user,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolUserBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 
                $statusstep = 1;
                $statussol = 0;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolServicioBuscar($servicio,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolServicioBuscarPag($table,$offset,$no_of_records_per_page,$servicio,$statusstep,$statussol,$statuscom);    
            }

            if($opcion == 6){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $placas = $this->_getParam('placas'); 
                $this->view->placas_search=$placas; 
                $statusstep = 1;
                $statussol = 0;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolPlacasBuscar($placas,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolPlacasBuscarPag($table,$offset,$no_of_records_per_page,$placas,$statusstep,$statussol,$statuscom);
            }
        }


        if($status == 1) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $vehiculo = $this->_getParam('vehiculo');
                $this->view->vehiculosol=$vehiculo;
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;
                $solicitud=$this->view->sol_auto=$this->_veh->GetSolVehiculoBuscar($vehiculo,$statusstep,$statussol,$statuscom);

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
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolVehiculoBuscarPag($table,$offset,$no_of_records_per_page,$vehiculo,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov; 
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolProvBuscar($prov,$statusstep,$statussol,$statuscom);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolProvBuscarPag($table,$offset,$no_of_records_per_page,$prov,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_auto=$this->_veh->GetSolIdBuscar($id,$statusstep,$statussol,$statuscom);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolIdBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolUserBuscar($user,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolUserBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolServicioBuscar($servicio,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolServicioBuscarPag($table,$offset,$no_of_records_per_page,$servicio,$statusstep,$statussol,$statuscom);    
            }

             if($opcion == 6){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $placas = $this->_getParam('placas'); 
                $this->view->placas_search=$placas; 
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolPlacasBuscar($placas,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolPlacasBuscarPag($table,$offset,$no_of_records_per_page,$placas,$statusstep,$statussol,$statuscom);
            }
        }


        if($status == 2) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $vehiculo = $this->_getParam('vehiculo');
                $this->view->vehiculosol=$vehiculo;
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;
                $solicitud=$this->view->sol_auto=$this->_veh->GetSolVehiculoBuscar($vehiculo,$statusstep,$statussol,$statuscom);

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
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolVehiculoBuscarPag($table,$offset,$no_of_records_per_page,$vehiculo,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov; 
                
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolProvBuscar($prov,$statusstep,$statussol,$statuscom);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolProvBuscarPag($table,$offset,$no_of_records_per_page,$prov,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_auto=$this->_veh->GetSolIdBuscar($id,$statusstep,$statussol,$statuscom);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolIdBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolUserBuscar($user,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolUserBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolServicioBuscar($servicio,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolServicioBuscarPag($table,$offset,$no_of_records_per_page,$servicio,$statusstep,$statussol,$statuscom);    
            }

             if($opcion == 6){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $placas = $this->_getParam('placas'); 
                $this->view->placas_search=$placas; 
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolPlacasBuscar($placas,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolPlacasBuscarPag($table,$offset,$no_of_records_per_page,$placas,$statusstep,$statussol,$statuscom);
            }
        }


        if($status == 3) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $vehiculo = $this->_getParam('vehiculo');
                $this->view->vehiculosol=$vehiculo;
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;
                $solicitud=$this->view->sol_auto=$this->_veh->GetSolVehiculoBuscar($vehiculo,$statusstep,$statussol,$statuscom);

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
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolVehiculoBuscarPag($table,$offset,$no_of_records_per_page,$vehiculo,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov; 
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolProvBuscar($prov,$statusstep,$statussol,$statuscom);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolProvBuscarPag($table,$offset,$no_of_records_per_page,$prov,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_auto=$this->_veh->GetSolIdBuscar($id,$statusstep,$statussol,$statuscom);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolIdBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolUserBuscar($user,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolUserBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolServicioBuscar($servicio,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolServicioBuscarPag($table,$offset,$no_of_records_per_page,$servicio,$statusstep,$statussol,$statuscom);    
            }
            if($opcion == 6){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $placas = $this->_getParam('placas'); 
                $this->view->placas_search=$placas; 
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolPlacasBuscar($placas,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolPlacasBuscarPag($table,$offset,$no_of_records_per_page,$placas,$statusstep,$statussol,$statuscom);
            }
        }
    }   // Buscadores Solicitud


    public function updatesolvehAction(){

        $id=$this->_getParam('id');
        $this->view->ids = $id;
        
        $wh="id";
        $table="vehiculos_solicitudes";
        $this->view->solicitudes = $this->_season->GetSpecific($table,$wh,$id);

        $table = "sitios";
        $servicios = $this->view->sitios = $this->_veh->GetordernombresitiosV();

        $table="vehiculo_servicios";
        $this->view->servicios = $this->_season->GetAll($table);

        $table="vehiculos";
        $this->view->vehiculos = $this->_season->GetAll($table);

        $table="proveedor";
        $this->view->proveedores = $this->_veh->GetProvedores($table);
        
        $this->view->personal = $this->_veh->GetPersonalV();
    
    }

    public function requestaddsolicitudservicioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $resp = $post['responsable'];
            if ($resp == "") {
                $responsable = 0;  
            } else {
                $responsable = $post['responsable'];
            }

        if($this->getRequest()->getPost()){
           
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id_user = $usr[0]['id'];

            $table="vehiculos_solicitudes";
            $result = $this->_veh->insertsolveh($post,$table,$id_user,$responsable);

            if ($result) {
                return $this-> _redirect('/vehiculos/addsolicitudvdos/id/'.$result.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestupdatesolvehAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $resp = $post['responsable'];
        if ($resp == "") {
            $responsable = 0;  
        } else {
            $responsable = $post['responsable'];
        }

        if($this->getRequest()->getPost()){

            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id_user = $usr[0]['id'];

            $table="vehiculos_solicitudes";
            $result = $this->_veh->UpdateSolPasUno($post,$table,$id_user,$responsable);
            
            if ($result) {
                return $this-> _redirect('/vehiculos/addsolicitudvdos/id/'.$post['ids'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

        // Si status de campo es 1
        //     Si tipo de dato es 1,2,3
        // Si estatus de campo es 0
        //     Nada

    public function addsolicitudvdosAction(){
       
        $id =$this->_getParam('id');
        $this->view->id = $id;
        $wh="id";
        $table="vehiculos_solicitudes";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $id_servicios = $usr[0]['id_servicios'];
        $this->view->idserv = $id_servicios;


        $table="vehiculo_servicios";
        $wh="id_sitio";
        $a=$this->view->servicios =$this->_veh->GetServicios($id_servicios);


    }

    public function requestaddsolvehdosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            $id=$post['idsol'];
            $wh="id";
            $table="vehiculos_solicitudes";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $id_servicios = $usr[0]['id_servicios'];

            $id=$post['idserv'];
            $wh="id";
            $table="vehiculo_servicios";
            $usrs = $this->_season->GetSpecific($table,$wh,$id);
            $id_servicios = $usrs[0]['id'];
            
            if($usrs[0]['status_uno'] == 1){
                
                if ($usrs[0]['tipo_uno'] == 1) {

                    $name = $_FILES['datouno']['name'];
                    if(empty($name)){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("Agrega una imagen");'; 
                        print '</script>'; 
                    }else{
                        $bytes = $_FILES['datouno']['size'];
                        $res = $this->formatSizeUnits($bytes);
                        if($res == 0){ 
                            print '<script language="JavaScript">'; 
                            print 'alert("La imagen supera el maximo de tamaño");'; 
                            print '</script>'; 
                        }else{
                            $info1 = new SplFileInfo($_FILES['datouno']['name']);
                            $ext1 = $info1->getExtension();
                            $url1 = 'img/vehiculos/sevidencias/';
                            $datouno = $url1.$info1;
                            move_uploaded_file($_FILES['datouno']['tmp_name'],$datouno);
                        }
                    }

                }

                if ($usrs[0]['tipo_uno'] == 2) {
                   
                   $datouno = $post['datouno']; 
                   
                }

                if ($usrs[0]['tipo_uno'] == 3) {
                    
                    $name = $_FILES['datouno']['name'];
                    if(empty($name)){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("Agrega un archivo");'; 
                        print '</script>'; 
                    }else{
                        $bytes = $_FILES['datouno']['size'];
                        $res = $this->formatSizeUnits($bytes);
                        if($res == 0){ 
                            print '<script language="JavaScript">'; 
                            print 'alert("El archivo supera el maximo de tamaño");'; 
                            print '</script>'; 
                        }else{
                            $info1 = new SplFileInfo($_FILES['datouno']['name']);
                            $ext1 = $info1->getExtension();
                            $url1 = 'img/vehiculos/sevidencias/';
                            $datouno = $url1.$info1;
                            move_uploaded_file($_FILES['datouno']['tmp_name'],$datouno);
                        }
                    }
                    
                }
            } else {
              
              $datouno = $post['datouno'];   
            
            }
            

            if($usrs[0]['status_dos'] == 1){
                
                if ($usrs[0]['tipo_dos'] == 1) {

                    $name = $_FILES['datodos']['name'];
                    if(empty($name)){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("Agrega una imagen");'; 
                        print '</script>'; 
                    }else{
                        $bytes = $_FILES['datodos']['size'];
                        $res = $this->formatSizeUnits($bytes);
                        if($res == 0){ 
                            print '<script language="JavaScript">'; 
                            print 'alert("La imagen supera el maximo de tamaño");'; 
                            print '</script>'; 
                        }else{
                            $info1 = new SplFileInfo($_FILES['datodos']['name']);
                            $ext1 = $info1->getExtension();
                            $url1 = 'img/vehiculos/sevidencias/';
                            $datodos = $url1.$info1;
                            move_uploaded_file($_FILES['datodos']['tmp_name'],$datodos);
                        }
                    }
                    
                }

                if ($usrs[0]['tipo_dos'] == 2) {
                   
                   $datodos = $post['datodos']; 
                   
                }

                if ($usrs[0]['tipo_dos'] == 3) {
                    
                    $name = $_FILES['datodos']['name'];
                    if(empty($name)){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("Agrega un archivo");'; 
                        print '</script>'; 
                    }else{
                        $bytes = $_FILES['datodos']['size'];
                        $res = $this->formatSizeUnits($bytes);
                        if($res == 0){ 
                            print '<script language="JavaScript">'; 
                            print 'alert("El archivo supera el maximo de tamaño");'; 
                            print '</script>'; 
                        }else{
                            $info1 = new SplFileInfo($_FILES['datodos']['name']);
                            $ext1 = $info1->getExtension();
                            $url1 = 'img/vehiculos/sevidencias/';
                            $datodos = $url1.$info1;
                            move_uploaded_file($_FILES['datodos']['tmp_name'],$datodos);
                        }
                    }
                    
                }
            } else {
              
              $datodos = $post['datodos'];    
            
            }


            if($usrs[0]['status_tres'] == 1){
                
                if ($usrs[0]['tipo_tres'] == 1) {

                    $name = $_FILES['datotres']['name'];
                    if(empty($name)){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("Agrega una imagen");'; 
                        print '</script>'; 
                    }else{
                        $bytes = $_FILES['datotres']['size'];
                        $res = $this->formatSizeUnits($bytes);
                        if($res == 0){ 
                            print '<script language="JavaScript">'; 
                            print 'alert("La imagen supera el maximo de tamaño");'; 
                            print '</script>'; 
                        }else{
                            $info1 = new SplFileInfo($_FILES['datotres']['name']);
                            $ext1 = $info1->getExtension();
                            $url1 = 'img/vehiculos/sevidencias/';
                            $datotres = $url1.$info1;
                            move_uploaded_file($_FILES['datotres']['tmp_name'],$datotres);
                        }
                    }
                   
                }

                if ($usrs[0]['tipo_tres'] == 2) {
                   
                   $datotres = $post['datotres']; 
                   
                }

                if ($usrs[0]['tipo_tres'] == 3) {
                    
                    $name = $_FILES['datotres']['name'];
                    if(empty($name)){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("Agrega un archivo");'; 
                        print '</script>'; 
                    }else{
                        $bytes = $_FILES['datotres']['size'];
                        $res = $this->formatSizeUnits($bytes);
                        if($res == 0){ 
                            print '<script language="JavaScript">'; 
                            print 'alert("El archivo supera el maximo de tamaño");'; 
                            print '</script>'; 
                        }else{
                            $info1 = new SplFileInfo($_FILES['datotres']['name']);
                            $ext1 = $info1->getExtension();
                            $url1 = 'img/vehiculos/sevidencias/';
                            $datotres = $url1.$info1;
                            move_uploaded_file($_FILES['datotres']['tmp_name'],$datotres);
                        }
                    }
                    
                }
            } else {
              
            $datotres = $post['datotres'];    
            
            }


            if($usrs[0]['status_cuatro'] == 1){
                
                if ($usrs[0]['tipo_cuatro'] == 1) {

                    $name = $_FILES['datocuatro']['name'];
                    if(empty($name)){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("Agrega una imagen");'; 
                        print '</script>'; 
                    }else{
                        $bytes = $_FILES['datocuatro']['size'];
                        $res = $this->formatSizeUnits($bytes);
                        if($res == 0){ 
                            print '<script language="JavaScript">'; 
                            print 'alert("La imagen supera el maximo de tamaño");'; 
                            print '</script>'; 
                        }else{
                            $info1 = new SplFileInfo($_FILES['datocuatro']['name']);
                            $ext1 = $info1->getExtension();
                            $url1 = 'img/vehiculos/sevidencias/';
                            $datocuatro = $url1.$info1;
                            move_uploaded_file($_FILES['datocuatro']['tmp_name'],$datocuatro);
                        }
                    }
                   
                }

                if ($usrs[0]['tipo_cuatro'] == 2) {
                   
                   $datocuatro = $post['datocuatro']; 
                   
                }

                if ($usrs[0]['tipo_cuatro'] == 3) {
                    
                    $name = $_FILES['datocuatro']['name'];
                    if(empty($name)){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("Agrega un archivo");'; 
                        print '</script>'; 
                    }else{
                        $bytes = $_FILES['datocuatro']['size'];
                        $res = $this->formatSizeUnits($bytes);
                        if($res == 0){ 
                            print '<script language="JavaScript">'; 
                            print 'alert("El archivo supera el maximo de tamaño");'; 
                            print '</script>'; 
                        }else{
                            $info1 = new SplFileInfo($_FILES['datocuatro']['name']);
                            $ext1 = $info1->getExtension();
                            $url1 = 'img/vehiculos/sevidencias/';
                            $datocuatro = $url1.$info1;
                            move_uploaded_file($_FILES['datocuatro']['tmp_name'],$datocuatro);
                        }
                    }
                   
                }
            } else {
              
              $datocuatro = $post['datocuatro'];    
            
            }


            if($usrs[0]['status_cinco'] == 1){
                
                if ($usrs[0]['tipo_cinco'] == 1) {

                    $name = $_FILES['datocinco']['name'];
                    if(empty($name)){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("Agrega una imagen");'; 
                        print '</script>'; 
                    }else{
                        $bytes = $_FILES['datocinco']['size'];
                        $res = $this->formatSizeUnits($bytes);
                        if($res == 0){ 
                            print '<script language="JavaScript">'; 
                            print 'alert("La imagen supera el maximo de tamaño");'; 
                            print '</script>'; 
                        }else{
                            $info1 = new SplFileInfo($_FILES['datocinco']['name']);
                            $ext1 = $info1->getExtension();
                            $url1 = 'img/vehiculos/sevidencias/';
                            $datocinco = $url1.$info1;
                            move_uploaded_file($_FILES['datocinco']['tmp_name'],$datocinco);
                        }
                    }
                   
                }

                if ($usrs[0]['tipo_cinco'] == 2) {
                   
                   $datocinco = $post['datocinco']; 
                    
                }

                if ($usrs[0]['tipo_cinco'] == 3) {
                    
                    $name = $_FILES['datocinco']['name'];
                    if(empty($name)){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("Agrega un archivo");'; 
                        print '</script>'; 
                    }else{
                        $bytes = $_FILES['datocinco']['size'];
                        $res = $this->formatSizeUnits($bytes);
                        if($res == 0){ 
                            print '<script language="JavaScript">'; 
                            print 'alert("El archivo supera el maximo de tamaño");'; 
                            print '</script>'; 
                        }else{
                            $info1 = new SplFileInfo($_FILES['datocinco']['name']);
                            $ext1 = $info1->getExtension();
                            $url1 = 'img/vehiculos/sevidencias/';
                            $datocinco = $url1.$info1;
                            move_uploaded_file($_FILES['datocinco']['tmp_name'],$datocinco);
                        }
                    }
                    
                }
            } else {
              
              $datocinco = $post['datocinco'];  
            
            }


            if($usrs[0]['status_seis'] == 1){
                
                if ($usrs[0]['tipo_seis'] == 1) {

                    $name = $_FILES['datoseis']['name'];
                    if(empty($name)){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("Agrega una imagen");'; 
                        print '</script>'; 
                    }else{
                        $bytes = $_FILES['datoseis']['size'];
                        $res = $this->formatSizeUnits($bytes);
                        if($res == 0){ 
                            print '<script language="JavaScript">'; 
                            print 'alert("La imagen supera el maximo de tamaño");'; 
                            print '</script>'; 
                        }else{
                            $info1 = new SplFileInfo($_FILES['datoseis']['name']);
                            $ext1 = $info1->getExtension();
                            $url1 = 'img/vehiculos/sevidencias/';
                            $datoseis = $url1.$info1;
                            move_uploaded_file($_FILES['datoseis']['tmp_name'],$datoseis);
                        }
                    }
                   
                }

                if ($usrs[0]['tipo_seis'] == 2) {

                   $datoseis = $post['datoseis']; 

                }

                if ($usrs[0]['tipo_seis'] == 3) {
                    
                    $name = $_FILES['datoseis']['name'];
                    if(empty($name)){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("Agrega un archivo");'; 
                        print '</script>'; 
                    }else{
                        $bytes = $_FILES['datoseis']['size'];
                        $res = $this->formatSizeUnits($bytes);
                        if($res == 0){ 
                            print '<script language="JavaScript">'; 
                            print 'alert("El archivo supera el maximo de tamaño");'; 
                            print '</script>'; 
                        }else{
                            $info1 = new SplFileInfo($_FILES['datoseis']['name']);
                            $ext1 = $info1->getExtension();
                            $url1 = 'img/vehiculos/sevidencias/';
                            $datoseis = $url1.$info1;
                            move_uploaded_file($_FILES['datoseis']['tmp_name'],$datoseis);
                        }
                    }
                  
                }
            } else {
              
              $datoseis = $post['datoseis'];  
            
            }


            if($usrs[0]['status_siete'] == 1){
                
                if ($usrs[0]['tipo_siete'] == 1) {

                    $name = $_FILES['datosiete']['name'];
                    if(empty($name)){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("Agrega una imagen");'; 
                        print '</script>'; 
                    }else{
                        $bytes = $_FILES['datosiete']['size'];
                        $res = $this->formatSizeUnits($bytes);
                        if($res == 0){ 
                            print '<script language="JavaScript">'; 
                            print 'alert("La imagen supera el maximo de tamaño");'; 
                            print '</script>'; 
                        }else{
                            $info1 = new SplFileInfo($_FILES['datosiete']['name']);
                            $ext1 = $info1->getExtension();
                            $url1 = 'img/vehiculos/sevidencias/';
                            $datosiete = $url1.$info1;
                            move_uploaded_file($_FILES['datosiete']['tmp_name'],$datosiete);
                        }
                    }
                    
                }

                if ($usrs[0]['tipo_siete'] == 2) {
                  
                   $datosiete = $post['datosiete']; 
                  
                }

                if ($usrs[0]['tipo_siete'] == 3) {
                    
                    $name = $_FILES['datosiete']['name'];
                    if(empty($name)){ 
                        print '<script language="JavaScript">'; 
                        print 'alert("Agrega un archivo");'; 
                        print '</script>'; 
                    }else{
                        $bytes = $_FILES['datosiete']['size'];
                        $res = $this->formatSizeUnits($bytes);
                        if($res == 0){ 
                            print '<script language="JavaScript">'; 
                            print 'alert("El archivo supera el maximo de tamaño");'; 
                            print '</script>'; 
                        }else{
                            $info1 = new SplFileInfo($_FILES['datosiete']['name']);
                            $ext1 = $info1->getExtension();
                            $url1 = 'img/vehiculos/sevidencias/';
                            $datosiete = $url1.$info1;
                            move_uploaded_file($_FILES['datosiete']['tmp_name'],$datosiete);
                        }
                    }
                   
                }
            } else {
              
              $datosiete = $post['datosiete'];
            
            }

            date_default_timezone_set('America/Mexico_City');
             $hoy = date("d-m-Y H:i:s");

            $table="vehiculos_solicitudes";
            $result = $this->_veh->UpdateSolPasDos($post,$table,$datouno,$datodos,$datotres,$datocuatro,$datocinco,$datoseis,$datosiete,$hoy);
            if ($result) {
                return $this-> _redirect('/vehiculos/solservicio');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }

        }
    }   // Solicitud Terminada Paso 2


    public function solicituddetailAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            
            $table = "vehiculos_solicitudes";
            $wh = "id";
            $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);

            $table = "vehiculos_solicitudes";
            $this->view->detalle = $this->_veh->GetDetalles($table,$id); 

            $table = "vehiculos_pagos";
            $wh = "id_solicitud";
            $this->view->pagos = $this->_season->GetSpecific($table,$wh,$id);

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


    // public function requestchangeaddstattusdocumentosolicitudAction(){
    //     $this->_helper->layout()->disableLayout();
    //     $this->_helper->viewRenderer->setNoRender(true);
    //     $post = $this->getRequest()->getPost();
        
    //             $id=$post['id'];
    //             $wh="id";
    //             $table="solicitud_ordencompra";
    //             $solicitud = $this->_season->GetSpecific($table,$wh,$id);

    //             $id_provedor = $solicitud[0]['proveedor_id'];
    //             $wh="id";
    //             $table="proveedor";
    //             $proveedor = $this->_season->GetSpecific($table,$wh,$id_provedor);
    //             $periodo_pago= $proveedor[0]['periodo_pago'];

    //             date_default_timezone_set('America/Mexico_City');
    //             $today = date("d-m-Y");

    //             if($periodo_pago = 0){
    //                 $hoy = $today;
    //             }else{
    //                 $hoy =date("d-m-Y",strtotime($today."+ ".$proveedor[0]['periodo_pago']." days")); 
    //             }

    //             $dato = date("Y-m-d H:i:s");
    //     if($this->getRequest()->getPost()){

    //         $table="solicitud_ordencompra";
    //         $this->_ordencompra->Updatestatusdocumento($post,$table,$hoy,$dato);

    //         $user_id= $post['id_user'];
    //         $table = "usuario";
    //         $wh = "id";
    //         $user= $this->_season->GetSpecific($table,$wh,$user_id);
    //         $protocol =  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://");
    //         $host = 'https://prueba.gpsc.com.mx';

    //         if ($user) { 
    //                     $cabeceras = 'MIME-Version: 1.0' . "\r\n"; 
    //                     $cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    //                     // $cabeceras .= 'To:'.$user[0]['correo'] . "\r\n";
    //                     $cabeceras .= 'To: ygarcia@gpsc.com.mx,dparra@gpsc.com.mx'."\r\n";
    //                     $cabeceras .= 'From: Nueva Solicitud de Orden de Compra <gpsc@gpsc.com.mx>' . "\r\n";
    //                     $contenido = 'GPSconstructivos'." ".$user[0]['nombre'].' '.$user[0]['ap']. "\r\n";
                        

    //                     $contenido = '  <!DOCTYPE html>
    //                   <html>
    //                   <head>
    //                       <title>CONFIRMACIÓN DE SOLICITUD DE ORDEN DE COMPRA</title>
                          
    //                       <meta copyright="Copyright (c) 2020 GPS Constructivos. All Rights Reserved.">
    //                       <style>
    //                            p{     margin:10px 0;     padding:0; } table{     border-collapse:collapse; } h1,h2,h3,h4,h5,h6{     display:block;     margin:0;     padding:0; } img,a img{     border:0;     height:auto;     outline:none;     text-decoration:none; } body,#bodyTable,#bodyCell{     height:100%;     margin:0;     padding:0;     width:100%; } .mcnPreviewText{     display:none !important; } #outlook a{     padding:0; } img{     -ms-interpolation-mode:bicubic; } table{     mso-table-lspace:0pt;     mso-table-rspace:0pt; } .ReadMsgBody{     width:100%; } .ExternalClass{     width:100%; } p,a,li,td,blockquote{     mso-line-height-rule:exactly; } a[href^=tel],a[href^=sms]{     color:inherit;     cursor:default;     text-decoration:none; } p,a,li,td,body,table,blockquote{     -ms-text-size-adjust:100%;     -webkit-text-size-adjust:100%; } .ExternalClass,.ExternalClass p,.ExternalClass td,.ExternalClass div,.ExternalClass span,.ExternalClass font{     line-height:100%; } a[x-apple-data-detectors]{     color:inherit !important;     text-decoration:none !important;     font-size:inherit !important;     font-family:inherit !important;     font-weight:inherit !important;     line-height:inherit !important; } #bodyCell{     padding:10px; } .templateContainer{     max-width:600px !important; } a.mcnButton{     display:block; } .mcnImage,.mcnRetinaImage{     vertical-align:bottom; } .mcnTextContent{     word-break:break-word; } .mcnTextContent img{     height:auto !important; } .mcnDividerBlock{     table-layout:fixed !important; } body,#bodyTable{     background-color:#FAFAFA; } #bodyCell{     border-top:0; } .templateContainer{     border:0; } h1{     color:#202020;     font-family:Helvetica;     font-size:26px;     font-style:normal;     font-weight:bold;     line-height:125%;     letter-spacing:normal;     text-align:left; } h2{     color:#202020;     font-family:Helvetica;     font-size:22px;     font-style:normal;     font-weight:bold;     line-height:125%;     letter-spacing:normal;     text-align:left; } h3{     color:#202020;     font-family:Helvetica;     font-size:20px;     font-style:normal;     font-weight:bold;     line-height:125%;     letter-spacing:normal;     text-align:left; } h4{     color:#202020;     font-family:Helvetica;     font-size:18px;     font-style:normal;     font-weight:bold;     line-height:125%;     letter-spacing:normal;     text-align:left; } #templatePreheader{     background-color:#FAFAFA;     background-image:none;     background-repeat:no-repeat;     background-position:center;     background-size:cover;     border-top:0;     border-bottom:0;     padding-top:9px;     padding-bottom:9px; } #templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{     color:#656565;     font-family:Helvetica;     font-size:12px;     line-height:150%;     text-align:left; } #templatePreheader .mcnTextContent a,#templatePreheader .mcnTextContent p a{     color:#656565;     font-weight:normal;     text-decoration:underline; } #templateHeader{     background-color:#ffffff;     background-image:none;     background-repeat:no-repeat;     background-position:center;     background-size:cover;     border-top:0;     border-bottom:0;     padding-top:9px;     padding-bottom:0; } #templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{     color:#202020;     font-family:Helvetica;     font-size:16px;     line-height:150%;     text-align:left; } #templateHeader .mcnTextContent a,#templateHeader .mcnTextContent p a{     color:#007C89;     font-weight:normal;     text-decoration:underline; } #templateBody{     background-color:#FFFFFF;     background-image:none;     background-repeat:no-repeat;     background-position:center;     background-size:cover;     border-top:0;     border-bottom:2px solid #EAEAEA;     padding-top:0;     padding-bottom:9px; } #templateBody .mcnTextContent,#templateBody .mcnTextContent p{     color:#202020;     font-family:Helvetica;     font-size:16px;     line-height:150%;     text-align:left; } #templateBody .mcnTextContent a,#templateBody .mcnTextContent p a{     color:#007C89;     font-weight:normal;     text-decoration:underline; } #templateFooter{     background-color:#FAFAFA;     background-image:none;     background-repeat:no-repeat;     background-position:center;     background-size:cover;     border-top:0;     border-bottom:0;     padding-top:9px;     padding-bottom:9px; } #templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{     color:#656565;     font-family:Helvetica;     font-size:12px;     line-height:150%;     text-align:center; } #templateFooter .mcnTextContent a,#templateFooter .mcnTextContent p a{     color:#656565;     font-weight:normal;     text-decoration:underline; }
    //                     @media only screen and (min-width:768px){
    //                         .templateContainer{
    //                             width:600px !important;
    //                         }

    //                 }
    //                 @media only screen and (max-width: 480px){
    //                         body,table,td,p,a,li,blockquote{
    //                             -webkit-text-size-adjust:none !important;
    //                         }
    //                 }
    //                 @media only screen and (max-width: 480px){ body{ width:100% !important; min-width:100% !important; }}
    //                 @media only screen and (max-width: 480px){ #bodyCell{ padding-top:10px !important; }}
    //                 @media only screen and (max-width: 480px){ .mcnRetinaImage{ max-width:100% !important; }}
    //                 @media only screen and (max-width: 480px){ .mcnImage{ width:100% !important; }}
    //                 @media only screen and (max-width: 480px){ .mcnCartContainer,.mcnCaptionTopContent,.mcnRecContentContainer,.mcnCaptionBottomContent,.mcnTextContentContainer,.mcnBoxedTextContentContainer,.mcnImageGroupContentContainer,.mcnCaptionLeftTextContentContainer,.mcnCaptionRightTextContentContainer,.mcnCaptionLeftImageContentContainer,.mcnCaptionRightImageContentContainer,.mcnImageCardLeftTextContentContainer,.mcnImageCardRightTextContentContainer,.mcnImageCardLeftImageContentContainer,.mcnImageCardRightImageContentContainer{            max-width:100% !important;            width:100% !important;        }}
    //                 @media only screen and (max-width: 480px){ .mcnBoxedTextContentContainer{            min-width:100% !important;        }}
    //                 @media only screen and (max-width: 480px){ .mcnImageGroupContent{            padding:9px !important;        }}
    //                 @media only screen and (max-width: 480px){ .mcnCaptionLeftContentOuter .mcnTextContent,.mcnCaptionRightContentOuter .mcnTextContent{            padding-top:9px !important;        }}
    //                 @media only screen and (max-width: 480px){ .mcnImageCardTopImageContent,.mcnCaptionBottomContent:last-child .mcnCaptionBottomImageContent,.mcnCaptionBlockInner .mcnCaptionTopContent:last-child .mcnTextContent{            padding-top:18px !important;        }}
    //                 @media only screen and (max-width: 480px){ .mcnImageCardBottomImageContent{            padding-bottom:9px !important;        }}
    //                 @media only screen and (max-width: 480px){ .mcnImageGroupBlockInner{            padding-top:0 !important;            padding-bottom:0 !important;        }}
    //                 @media only screen and (max-width: 480px){ .mcnImageGroupBlockOuter{            padding-top:9px !important;            padding-bottom:9px !important;        }}
    //                 @media only screen and (max-width: 480px){        .mcnTextContent,.mcnBoxedTextContentColumn{            padding-right:18px !important;            padding-left:18px !important;        }}   @media only screen and (max-width: 480px){        .mcnImageCardLeftImageContent,.mcnImageCardRightImageContent{            padding-right:18px !important;            padding-bottom:0 !important;            padding-left:18px !important;        }}   @media only screen and (max-width: 480px){        .mcpreview-image-uploader{            display:none !important;            width:100% !important;        }}   @media only screen and (max-width: 480px){        h1{ font-size:22px !important; line-height:125% !important;        }}
    //                 @media only screen and (max-width: 480px){        h2{            font-size:20px !important;            line-height:125% !important;        }}   @media only screen and (max-width: 480px){        h3{            font-size:18px !important;            line-height:125% !important;        }}   @media only screen and (max-width: 480px){        h4{            font-size:16px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        .mcnBoxedTextContentContainer .mcnTextContent,.mcnBoxedTextContentContainer .mcnTextContent p{            font-size:14px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        #templatePreheader{            display:block !important;        }}   @media only screen and (max-width: 480px){        #templatePreheader .mcnTextContent,#templatePreheader .mcnTextContent p{            font-size:14px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        #templateHeader .mcnTextContent,#templateHeader .mcnTextContent p{            font-size:16px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        #templateBody .mcnTextContent,#templateBody .mcnTextContent p{            font-size:16px !important;            line-height:150% !important;        }}   @media only screen and (max-width: 480px){        #templateFooter .mcnTextContent,#templateFooter .mcnTextContent p{            font-size:14px !important;            line-height:150% !important;        }}
    //                       </style>
    //                   </head>

    //                 <body style="height: 100%;margin: 0;padding: 0;width: 100%;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FAFAFA;"> 
                       
    //                     <center>
    //                             <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 0;width: 100%;background-color: #FAFAFA;">
    //                                 <tbody><tr>
    //                                     <td align="center" valign="top" id="bodyCell" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;height: 100%;margin: 0;padding: 10px;width: 100%;border-top: 0;"><!-- BEGIN TEMPLATE // --><!--[if (gte mso 9)|(IE)]><table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;"><tr><td align="center" valign="top" width="600" style="width:600px;"><![endif]--><table border="0" cellpadding="0" cellspacing="0" width="100%" class="templateContainer" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;border: 0;max-width: 600px !important;">    <tbody><tr>        <td valign="top" id="templatePreheader" style="background:#FAFAFA none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FAFAFA;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 9px;"></td>    </tr>    <tr>        <td valign="top" id="templateHeader" style="background:#FFFFFF none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 0;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnImageBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    //                     <tbody class="mcnImageBlockOuter">
    //                             <tr>
    //                                 <td valign="top" style="padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnImageBlockInner">
    //                                     <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><tbody><tr>    <td class="mcnImageContent" valign="top" style="padding-right: 9px;padding-left: 9px;padding-top: 0;padding-bottom: 0;text-align: center;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                    <img align="center" alt="" src="https://prueba.gpsc.com.mx/img/logo-2.png" width="564" style="max-width: 960px;padding-bottom: 0;display: inline !important;vertical-align: bottom;border: 0;height: auto;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;" class="mcnImage">                        </td></tr>
    //                                     </tbody></table>
    //                                 </td>
    //                             </tr>
    //                     </tbody>
    //                 </table></td>    </tr>    <tr>        <td valign="top" id="templateBody" style="background:#FFFFFF none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 2px solid #EAEAEA;padding-top: 0;padding-bottom: 9px;"><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnTextBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    //                     <tbody class="mcnTextBlockOuter">
    //                         <tr>
    //                             <td valign="top" class="mcnTextBlockInner" style="padding-top: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    //                                 <!--[if mso]>
    //                                 <table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
    //                                 <tr>
    //                                 <![endif]-->
                                    
    //                                 <!--[if mso]>
    //                                 <td valign="top" width="600" style="width:600px;">
    //                                 <![endif]-->
    //                                 <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width: 100%;min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" width="100%" class="mcnTextContentContainer">
    //                                     <tbody><tr><td valign="top" class="mcnTextContent" style="padding-top: 0;padding-right: 18px;padding-bottom: 9px;padding-left: 18px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;word-break: break-word;color: #202020;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: left;">    <h1 style="display: block;margin: 0;padding: 0;color: #202020;font-family: Helvetica;font-size: 26px;font-style: normal;font-weight: bold;line-height: 125%;letter-spacing: normal;text-align: left;">'.$user[0]['nombre'].' '.$user[0]['ap'].', ha creado una solicitud de orden de compra nueva.</h1>

    //                 <p style="margin: 10px 0;padding: 0;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #202020;font-family: Helvetica;font-size: 16px;line-height: 150%;text-align: left;">Puedes ver los detalles de la solicitud en el sistema <a href="https://prueba.gpsc.com.mx/home/login" target="_blank" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #007C89;font-weight: normal;text-decoration: underline;">Da clic aqui</a>. NO.'.$post['id'].'</p>
    //                 </td>
    //                                     </tr>
    //                                 </tbody></table>
    //                                 <!--[if mso]>
    //                                 </td>
    //                                 <![endif]-->
                                    
    //                                 <!--[if mso]>
    //                                 </tr>
    //                                 </table>
    //                                 <![endif]-->
    //                             </td>
    //                         </tr>
    //                     </tbody>
    //                 </table><table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowBlock" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    //                     <tbody class="mcnFollowBlockOuter">
    //                         <tr>
    //                             <td align="center" valign="top" style="padding: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowBlockInner">
    //                                 <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentContainer" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    //                     <tbody><tr>
    //                         <td align="center" style="padding-left: 9px;padding-right: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
    //                             <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width: 100%;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContent">
    //                                 <tbody><tr>
    //                                     <td align="center" valign="top" style="padding-top: 9px;padding-right: 9px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;"><table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">    <tbody><tr>        <td align="center" valign="top" style="mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">            <!--[if mso]>            <table align="center" border="0" cellspacing="0" cellpadding="0">            <tr>            <![endif]-->                            <!--[if mso]>                <td align="center" valign="top">                <![endif]-->                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                        <tbody><tr>                            <td valign="top" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                    <tbody><tr>                                        <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                                <tbody><tr>                                                                                                                                                                                                                                                                    </tr>                                            </tbody></table>                                        </td>                                    </tr>                                </tbody></table>                            </td>                        </tr>                    </tbody></table>                                <!--[if mso]>                </td>                <![endif]-->                            <!--[if mso]>                <td align="center" valign="top">                <![endif]-->                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                        <tbody><tr>                            <td valign="top" style="padding-right: 10px;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                    <tbody><tr>                                        <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                                <tbody><tr>                                                                                                                                                                                                                                                                    </tr>                                            </tbody></table>                                        </td>                                    </tr>                                </tbody></table>                            </td>                        </tr>                    </tbody></table>                                <!--[if mso]>                </td>                <![endif]-->                            <!--[if mso]>                <td align="center" valign="top">                <![endif]-->                                                    <table align="left" border="0" cellpadding="0" cellspacing="0" style="display: inline;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                        <tbody><tr>                            <td valign="top" style="padding-right: 0;padding-bottom: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnFollowContentItemContainer">                                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnFollowContentItem" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                    <tbody><tr>                                        <td align="left" valign="middle" style="padding-top: 5px;padding-right: 10px;padding-bottom: 5px;padding-left: 9px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                            <table align="left" border="0" cellpadding="0" cellspacing="0" width="" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">                                                <tbody><tr>                                                                                                                                                                                                                                                                    </tr>                                            </tbody></table>                                        </td>                                    </tr>                                </tbody></table>                            </td>                        </tr>                    </tbody></table>                                <!--[if mso]>                </td>                <![endif]-->                        <!--[if mso]>            </tr>            </table>            <![endif]-->        </td>    </tr></tbody></table>
    //                                     </td>
    //                                 </tr>
    //                             </tbody></table>
    //                         </td>
    //                     </tr>
    //                 </tbody></table>

    //                             </td>
    //                         </tr>
    //                     </tbody>
    //                 </table></td>    </tr>    <tr>        <td valign="top" id="templateFooter" style="background:#FAFAFA none no-repeat center/cover;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FAFAFA;background-image: none;background-repeat: no-repeat;background-position: center;background-size: cover;border-top: 0;border-bottom: 0;padding-top: 9px;padding-bottom: 9px;"></td>    </tr></tbody></table><!--[if (gte mso 9)|(IE)]></td></tr></table><![endif]--><!-- // END TEMPLATE -->
    //                                     </td>
    //                                 </tr>
    //                             </tbody></table>
    //                         </center>
    //                 </body>
    //                 </html>';
                                       
    //         if(mail($post['mail'],"Solicitud de orden de compra aprobada",$contenido,$cabeceras)){ 
    //             return $this->_redirect('/solicitud/solicituddetail/id/'.$post['id_solicitud'].'');
    //         }else{
    //             return $this->_redirect('/solicitud/solicituddetail/id/'.$post['id_solicitud'].'');
    //         }
                 
    //             }else{
    //                 print '<script language="JavaScript">'; 
    //                 print 'alert("Ocurrio un error: Comprueba los datos.");'; 
    //                 print '</script>'; 
    //             }
    //     }
    // }//END REQUEST ADD ROL

    public function requestchangeaceptsolAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $dato = date("Y-m-d H:i:s");

            // var_dump($post);
            // die();

        if($this->getRequest()->getPost()){

            $table="vehiculos_solicitudes";
            $result=$this->_veh->UpdateAceptSol($post,$table,$hoy);


            if ($result) {
                return $this->_redirect('/vehiculos/solicituddetail/id/'.$post['id_solicitud'].'/status/1');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   // END REQUEST ACEPTAR SOLICITUD


    public function requestchangerechazarsolAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $dato = date("Y-m-d H:i:s");

            // var_dump($post);
            // die();

        if($this->getRequest()->getPost()){

            $table="vehiculos_solicitudes";
            $result=$this->_veh->UpdateRechazarSol($post,$table,$hoy);


            if ($result) {
                return $this->_redirect('/vehiculos/solicituddetail/id/'.$post['id_solicitud'].'/status/2');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   // END REQUEST RECHAZAR SOLICITUD


    public function requestchangecancelarsolAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $dato = date("Y-m-d H:i:s");

            // var_dump($post);
            // die();

        if($this->getRequest()->getPost()){

            $table="vehiculos_solicitudes";
            $result=$this->_veh->UpdateRechazarSol($post,$table,$hoy);


            if ($result) {
                return $this->_redirect('/vehiculos/solicituddetail/id/'.$post['id_solicitud'].'/status/2');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   // END REQUEST CANCELAR SOLICITUD


    public function solicitudvehiculoAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            
            $table = "vehiculos_solicitudes";
            $wh = "id";
            $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);

            $table = "vehiculos_solicitudes";
            $this->view->detalle = $this->_veh->GetDetallesConta($table,$id); 

            $table = "vehiculos_pagos";
            $wh = "id_solicitud";
            $this->view->pagos = $this->_season->GetSpecific($table,$wh,$id);

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


    public function solicituddetailctbAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            
            $table = "vehiculos_solicitudes";
            $wh = "id";
            $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);

            $table = "vehiculos_solicitudes";
            $this->view->detalle = $this->_veh->GetDetallesConta($table,$id); 

            $table = "vehiculos_pagos";
            $wh = "id_solicitud";
            $this->view->pagos = $this->_season->GetSpecific($table,$wh,$id);

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


    public function solicitudvehctbAction(){
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $this->view->id_solicitud = $id;
            
            $table = "vehiculos_solicitudes";
            $wh = "id";
            $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id);

            $table = "vehiculos_solicitudes";
            $this->view->detalle = $this->_veh->GetDetallesConta($table,$id); 

            $table = "vehiculos_pagos";
            $wh = "id_solicitud";
            $this->view->pagos = $this->_season->GetSpecific($table,$wh,$id);

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
    }   //Para PDF de la solicitud Contabilidad


    public function requestaddcomprobantedepagovAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){

            $status_conta = $post['pago_conta'];

            if ($status_conta == 1) {
      
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
                        $url1 = 'pdf/sol_vehiculos/';
                        $urldb = $url1.$info1;
                        move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                    }
                }
                date_default_timezone_set('America/Mexico_City');
                $hoy = date("d-m-Y H:i:s");
                $status_pago = 1;

                $id=$this->_session->id;
                $wh="id";
                $table="usuario";
                $usr = $this->_season->GetSpecific($table,$wh,$id);
                $nombre= $usr[0]['nombre']." ".$usr[0]['ap'];
                $id_usuario = $usr[0]['id'];
                
                $table="vehiculos_solicitudes";
                $this->_veh->UpdatePagoSolV($post,$table,$hoy,$status_pago,$id_usuario);

                $table="vehiculos_pagos";
                $result=$this->_veh->InsertPagoSerVeh($post,$table,$urldb,$hoy,$nombre);
                if ($result) {
                    // return $this-> _redirect('/vehiculos/solicituddetailctb/id/'.$post['id_solicitud'].'/status/2');
                    return $this-> _redirect('/vehiculos/listasolcontabilidad/status/0');
                }else{
                    print '<script language="JavaScript">'; 
                    print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                    print '</script>'; 
                }
            } else {


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
                        $url1 = 'pdf/sol_vehiculos/';
                        $urldb = $url1.$info1;
                        move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                    }
                }
                date_default_timezone_set('America/Mexico_City');
                $hoy = date("d-m-Y H:i:s");
                $status_pago = 0;

                $id=$this->_session->id;
                $wh="id";
                $table="usuario";
                $usr = $this->_season->GetSpecific($table,$wh,$id);
                $nombre= $usr[0]['nombre']." ".$usr[0]['ap'];
                $id_usuario = $usr[0]['id'];
                
                $table="vehiculos_solicitudes";
                $this->_veh->UpdatePagoSolV($post,$table,$hoy,$status_pago,$id_usuario);

                $table="vehiculos_pagos";
                $result=$this->_veh->InsertPagoSerVeh($post,$table,$urldb,$hoy,$nombre);
                if ($result) {
                    // return $this-> _redirect('/vehiculos/solicituddetailctb/id/'.$post['id_solicitud'].'/status/0');
                    return $this-> _redirect('/vehiculos/listasolcontabilidad/status/0');
                }else{
                    print '<script language="JavaScript">'; 
                    print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                    print '</script>'; 
                }


            }
        }
    }


    public function listasolcontabilidadAction(){

         $id=$this->_session->id;
        $this->view->user_list=$id;
        $wh="id_usuario";
        $table="vehiculos_solicitudes";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        // status_documento  enproceso
        
        $wh="id";
        $table="usuario";
        $user = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$user[0]['fkroles'];

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $sql = $this->_veh->GetUserSolicitudContCount();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table="proveedor";
        $this->view->prov = $this->_season->GetAll($table);

        $table="vehiculos";
        $this->view->vehiculos = $this->_season->GetAll($table);

        $table="vehiculo_servicios";
        $this->view->servicios = $this->_season->GetAll($table);


        if($status == 0) {

            $solicitud=$this->_veh->GetUserSolicitudContCount();
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
            $table="vehiculos_solicitudes";
            $sql=$this->view->paginator= $this->_veh->GetPagSolProcesoCont($table,$offset,$no_of_records_per_page);
            // var_dump($sql);exit;
        }

        if($status == 1){
            $solicitud=$this->_veh->GetSolCancelCount();
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
            $table="vehiculos_solicitudes";
            $this->view->paginator= $this->_veh->GetPagSolCancel($table,$offset,$no_of_records_per_page);
        }

        if($status == 2){
            $solicitud=$this->_veh->GetSolFinCount();
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
            $table="vehiculos_solicitudes";
            $sql= $this->view->paginator= $this->_veh->GetPagSolFin($table,$offset,$no_of_records_per_page);
        }

    }


    public function listasolbuscarcontAction(){
        $id=$this->_session->id;
        $this->view->user_list=$id;

        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->user_rol=$usr[0]['fkroles'];

        $wh="id_usuario";
        $table="vehiculos_solicitudes";
        $usr = $this->_season->GetSpecific($table,$wh,$id);

        $sql = $this->_veh->GetUserSolicitudContCount();
        $total = count($sql);
        $this->view->enproceso=$total;

        $status = $this->_getParam('status');
        $this->view->status_documento=$status;

        $table="vehiculo_servicios";
        $this->view->servicios = $this->_season->GetAll($table);

        $table="proveedor";
        $this->view->prov = $this->_season->GetAll($table);

        $table="vehiculos";
        $this->view->vehiculos = $this->_season->GetAll($table);

        $opcion = $this->_getParam('op');
        $this->view->opcion_search=$opcion;

        if($status == 0) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $vehiculo = $this->_getParam('vehiculo');
                $this->view->vehiculosol=$vehiculo;
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;
                $solicitud=$this->view->sol_auto=$this->_veh->GetSolVehiculoBuscar($vehiculo,$statusstep,$statussol,$statuscom);

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
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolVehiculoBuscarPag($table,$offset,$no_of_records_per_page,$vehiculo,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov; 
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolProvBuscar($prov,$statusstep,$statussol,$statuscom);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolProvBuscarPag($table,$offset,$no_of_records_per_page,$prov,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_auto=$this->_veh->GetSolIdBuscar($id,$statusstep,$statussol,$statuscom);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolIdBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolUserBuscar($user,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolUserBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolServicioBuscar($servicio,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolServicioBuscarPag($table,$offset,$no_of_records_per_page,$servicio,$statusstep,$statussol,$statuscom);    
            }

            if($opcion == 6){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $placas = $this->_getParam('placas'); 
                $this->view->placas_search=$placas; 
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolPlacasBuscar($placas,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolPlacasBuscarPag($table,$offset,$no_of_records_per_page,$placas,$statusstep,$statussol,$statuscom);
            }
        }


        if($status == 1) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $vehiculo = $this->_getParam('vehiculo');
                $this->view->vehiculosol=$vehiculo;
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;
                $solicitud=$this->view->sol_auto=$this->_veh->GetSolVehiculoBuscar($vehiculo,$statusstep,$statussol,$statuscom);

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
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolVehiculoBuscarPag($table,$offset,$no_of_records_per_page,$vehiculo,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov; 
                
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolProvBuscar($prov,$statusstep,$statussol,$statuscom);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolProvBuscarPag($table,$offset,$no_of_records_per_page,$prov,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_auto=$this->_veh->GetSolIdBuscar($id,$statusstep,$statussol,$statuscom);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolIdBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolUserBuscar($user,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolUserBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolServicioBuscar($servicio,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolServicioBuscarPag($table,$offset,$no_of_records_per_page,$servicio,$statusstep,$statussol,$statuscom);    
            }

            if($opcion == 6){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $placas = $this->_getParam('placas'); 
                $this->view->placas_search=$placas; 
                $statusstep = 1;
                $statussol = 2;
                $statuscom = 0;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolPlacasBuscar($placas,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolPlacasBuscarPag($table,$offset,$no_of_records_per_page,$placas,$statusstep,$statussol,$statuscom);
            }
        }


        if($status == 2) {
            if($opcion == 1){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $vehiculo = $this->_getParam('vehiculo');
                $this->view->vehiculosol=$vehiculo;
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;
                $solicitud=$this->view->sol_auto=$this->_veh->GetSolVehiculoBuscar($vehiculo,$statusstep,$statussol,$statuscom);

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
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolVehiculoBuscarPag($table,$offset,$no_of_records_per_page,$vehiculo,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 2){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $prov = $this->_getParam('proveedor');
                $this->view->nombre_prov=$prov; 
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolProvBuscar($prov,$statusstep,$statussol,$statuscom);
                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolProvBuscarPag($table,$offset,$no_of_records_per_page,$prov,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 3){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $id = $this->_getParam('id');
                
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;

                $this->view->id_search=$id; 
                $solicitud=$this->view->sol_auto=$this->_veh->GetSolIdBuscar($id,$statusstep,$statussol,$statuscom);
                $count=count($solicitud);
                
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolIdBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 4){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $user = $this->_getParam('usuario'); 
                $this->view->user_search=$user; 
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolUserBuscar($user,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolUserBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statuscom);
            }

            if($opcion == 5){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $servicio = $this->_getParam('servicio'); 
                $this->view->servicio_search=$servicio; 
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolServicioBuscar($servicio,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolServicioBuscarPag($table,$offset,$no_of_records_per_page,$servicio,$statusstep,$statussol,$statuscom);    
            }

            if($opcion == 6){
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;
                $placas = $this->_getParam('placas'); 
                $this->view->placas_search=$placas; 
                $statusstep = 1;
                $statussol = 1;
                $statuscom = 1;

                $solicitud=$this->view->sol_auto=$this->_veh->GetSolPlacasBuscar($placas,$statusstep,$statussol,$statuscom);

                $count=count($solicitud);
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1; } 
                
                $no_of_records_per_page = 20;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $table="vehiculos_solicitudes";
                $this->view->paginator= $this->_veh->GetSolPlacasBuscarPag($table,$offset,$no_of_records_per_page,$placas,$statusstep,$statussol,$statuscom);
            }
        }
    }

    public function notificacionesAction() {

        $table = "vehiculos_documentacion"; 
        $this->view->alertas=$this->_veh->GetVigencias($table);

    }


    public function tpodocumentoAction() {

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="vehiculos_tpodoc";
        $tipodoc=$this->view->tpodoc = $this->_season->GetAll($table);

        $count=count($tipodoc);

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
        $table="vehiculos_tpodoc";
        $sql= $this->view->paginator= $this->_veh->Getpaginationtipodoc($table,$offset,$no_of_records_per_page);   
    }   // Catalogo Tipo de Documento

    public function requesttipodAction() {
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){
            
            $table="vehiculos_tpodoc";
            $result = $this->_veh->inserttipodoc($post,$table);
            
            if ($result) {
            
                return $this-> _redirect('/vehiculos/tpodocumento');
            
            }else{
            
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            
            }
        }
    }   //END ADD TIPO DE DOCUMENTO

    public function requestdeletetipodocAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){
            $id=$post['id'];
            $table="vehiculos_tpodoc";
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
    }   //END REQUEST DELETE TIPO DOCUMENTO

    public function tpodoceditAction(){
        
        if($this->_hasParam('id')){
            
            $id = $this->_getParam('id');
            $table="vehiculos_tpodoc";
            $wh="id";
            $this->view->tpo_doc = $this->_season->GetSpecific($table,$wh,$id);
        
        } else {
        
            return $this-> _redirect('/');
        
        }   
    }   //End Editar Tipo Documento

    
    public function requestupdtpodoctAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){

            $table="vehiculos_tpodoc";
            $result = $this->_veh->updatetipodoc($post,$table);
            
            if ($result) {
            
                return $this-> _redirect('/vehiculos/tpodocumento');
            
            }else{
             
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            
            }
        }
    }//END REQUEST UPDATE DOCUMENTO


    public function requestudpdocAction(){

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $id = $post['nombred'];
        $table = "vehiculos_tpodoc";
        $wh = "id";
        $doc = $this->_season->GetSpecific($table,$wh,$id);
        
        $nombredoc = $doc[0]['nombredoc'];

        if($this->getRequest()->getPost()){

            $table="vehiculos_documentacion";
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
                    $url1 = 'pdf/vehiculosdoc/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");

            $table="vehiculos_documentacion";
            $this->_veh->insertdoc($post,$table,$urldb,$nombredoc,$hoy);

            $table="vehiculos_documentacion";
            $this->_veh->updatedocvig($post,$table);

            $table="vehiculos_solicitudes";
            $result = $this->_veh->updatesol($post,$table);

            if ($result) {
                return $this-> _redirect('/vehiculos/documentacion/id/'.$post['idhs'].''); 
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }


    public function documentoeditAction(){
        
        if($this->_hasParam('id')){
            $id = $this->_getParam('id');

            $table="vehiculos_documentacion";
            $wh="id";
            $this->view->documentoedit = $this->_season->GetSpecific($table,$wh,$id);

        }else {
            return $this-> _redirect('/');
        }   
    }  // END EDIT DOCUMENTO

    public function requestupdatedocumentosAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true); 
        $post = $this->getRequest()->getPost();

        $vehiculo = $post['vehiculo'];

        if($this->getRequest()->getPost()){
            $table="vehiculos_documentacion";
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
                    $url1 = 'pdf/vehiculosdoc/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }//end de if

            $table="vehiculos_documentacion";
            $result = $this->_veh->updatedocedit($post,$table,$urldb);
            if ($result) {
                return $this-> _redirect('/vehiculos/documentacion/id/'.$vehiculo.'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }   //END REQUEST UPDATE DOCUMENTO

    public function formatSizeUnits($bytes){ 

        if ($bytes >= 1073741824) {
            
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        
        elseif ($bytes >= 1048576) {
            
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        
        elseif ($bytes >= 1024) {
            
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        
        elseif ($bytes > 1) {
            
            $bytes = $bytes . ' bytes';
        }
        
        elseif ($bytes == 1) {
            
            $bytes = $bytes . ' byte';
        }
        
        else {
            
            $bytes = '0 bytes';
        }

        return $bytes;
    }   //END FUNCION DE TAMAÑO DE IMAGEN

}


    



