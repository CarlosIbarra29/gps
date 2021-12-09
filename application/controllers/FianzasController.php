<?php
require_once '../vendor/autoload.php';
class FianzasController extends Zend_Controller_Action{
	private $_season;
    private $_session;
    private $_user;
    private $_fnz;

    public function init(){
        
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_fnz = new Application_Model_GpsFianzasModel;

        if(empty($this->_session->id)){
        
            $this->redirect('/home/login');
        
        }
    }


    public function fianzasAction(){

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $id_user=$this->_session->id;
        $this->view->user_list=$id_user;

        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id_user);
        $this->view->user_rol=$usr[0]['fkroles'];
        
        $table="sitios";
        $this->view->sitio = $this->_season->GetAll($table);

        $solicitud = $this->_fnz->GetFianzasAll();
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
            $this->view->paginator= $this->_fnz->GetFianzasAllpaginator($offset,$no_of_records_per_page);

    }

    public function requestdelfianzaAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){
        
            $id =  $post['id'];
            $table="fianzas";
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


    public function requestaddfianzaAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $nombre_usuario = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];
            $id_user = $usr[0]['id'];

            $id = $post['sitio'];
            $wh="id";
            $table="sitios";
            $sto = $this->_season->GetSpecific($table,$wh,$id);
            $name_sitio = $sto[0]['nombre'];

            $table="fianzas";
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
                    $url1 = 'img/fianzas/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                
                }
            }

            $result = $this->_fnz->inserfianzaall($post,$table,$urldb,$nombre_usuario,$id_user,$hoy,$name_sitio);

            if ($result) {
            
                return $this-> _redirect('/fianzas/fianzas');
            
            }else{
            
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            
            }
        }
    }//END add FIANZA


    public function buscarfianzasAction(){

        $id_user=$this->_session->id;
        $this->view->user_list=$id_user;

        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id_user);
        $this->view->user_rol=$usr[0]['fkroles'];

        $table="sitios";
        $this->view->sitio = $this->_season->GetAll($table);

        $sql = $this->view->fianzacontar =$this->_fnz->GetFianzasAll();

        $total = count($sql);
        $this->view->enproceso=$total;

        $opcion = $this->_getParam('op');
        $this->view->opcion_search=$opcion;

        if($opcion == 1){
            
            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;    

            $sitio = $this->_getParam('sitio');
            $this->view->sitioid=$sitio;
            

            $fianza_contador=$this->view->fianza_count=$this->_fnz->GetFianzaSitio($sitio);
            $count=count($fianza_contador);

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
                $table="fianzas";
                $this->view->paginator= $this->_fnz->GetFianzaSitioPaginator($table,$offset,$no_of_records_per_page,$sitio);
            }

    }   


    public function fianzaeditAction(){

        if($this->_hasParam('id')){
            $id = $this->_getParam('id');
            $table="fianzas";
            $wh="id";
            $consulta=$this->view->fianzasid = $this->_season->GetSpecific($table,$wh,$id);

            $table="sitios";
            $this->view->sitio= $this->_season->GetAll($table);

        }else {

            return $this-> _redirect('/');

        }   

    }//End Fianza Edit


    public function requestupdatefianzaAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $nombre_usuario = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];
            $id_user = $usr[0]['id'];

            $id = $post['sitio'];
            $wh="id";
            $table="sitios";
            $sto = $this->_season->GetSpecific($table,$wh,$id);
            $name_sitio = $sto[0]['nombre'];

            $table="fianzas";
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
                    $url1 = 'img/fianzas/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
        
                }
            }//end de if
                

            $table="fianzas";
            $result = $this->_fnz->updatefianzas($post,$table,$urldb,$nombre_usuario,$id_user,$name_sitio);
        
            if ($result) {
        
                return $this-> _redirect('/fianzas/fianzas');
        
            }else{
        
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
        
            }
        }
    }//END REQUEST update FIANZAS
 

     public function excelhistoricoAction(){
        
        $this->view->excelfianzas = $this->_fnz->GetFianzaalls();
    
    }// Excel Historico Fianzas


    public function excelfechasAction(){
        $inicio = $this->_getParam('inicio'); $this->view->inicio=$inicio;
        $final = $this->_getParam('final'); $this->view->final=$final;

        $inicioa=date("Y-m-d", strtotime($inicio));
        $finala=date("Y-m-d", strtotime($final));


        $a=$this->view->excelfianzas = $this->_fnz->getFianzasFechas($inicioa,$finala);             
        // var_dump($a);
        // die();
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
