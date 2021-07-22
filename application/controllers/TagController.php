<?php
require_once '../vendor/autoload.php';
class TagController extends Zend_Controller_Action{
	private $_season;
    private $_session;
    private $_user;
    private $_epp;
    private $_tag;

    public function init(){
        
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_project = new Application_Model_GpsProyectoModel;
        $this->_colo = new Application_Model_GpsColocacionModel;
        $this->_epp = new Application_Model_GpsEppModel;
        $this->_tag = new Application_Model_GpsTagModel;

        if(empty($this->_session->id)){
        
            $this->redirect('/home/login');
        
        }
    }


    public function addconsumoAction(){

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $id_user=$this->_session->id;
        $this->view->user_list=$id_user;

        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id_user);
        $this->view->user_rol=$usr[0]['fkroles'];
        
        $solicitud = $this->_tag->GetTags();
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
            $this->view->paginator= $this->_tag->GetTagspaginator($offset,$no_of_records_per_page);

    }

    public function cargamasivafacturasAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $csv = new \ParseCsv\Csv();
        $csv->auto($_FILES['archivo']['tmp_name']);
        $datos = $csv->data;

        $table="tag";
        $consumos = $this->_tag->GetArrayConsumosTag();

        $fecha = array();
        
        foreach ($datos as $key) {
            $id = $key['fecha'];
            $wh="fecha";
            $table="tag";
            $usr = $this->_season->GetSpecific($table,$wh,$id);

            if(empty($usr)){
                $table="tag";
                $result = $this->_tag->insertTagConsumos($key,$table);
            }else{

            }
        }
        
        $result = 1 ;
        
        if ($result) {
        
            return $this-> _redirect('/tag/addconsumo');
        
        }else{
        
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        
        }
    }

    public function requestdeltagAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){
        
            $id =  $post['id'];
            $table="tag";
            $wh="tag";
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


     public function requestdeltagconsumoAction(){
        
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        if($this->getRequest()->getPost()){
        
            $id =  $post['id'];
            $table="tag";
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
    }//END REQUEST DELETE REGISTRO
    

    
    public function detailconsumoAction(){

        if($this->_hasParam('id')){
        
            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;
            
            $table="sitios";
            $this->view->sitio = $this->_season->GetAll($table);

            $this->view->proyectos =$this->_tag->proyectosActuales(); 

            $table="meses";
            $this->view->meses = $this->_season->GetAll($table);

            $table="years";
            $this->view->years = $this->_season->GetAll($table);

            $id = $this->_getParam('id');
            $table="tag";
            $wh="tag";
            $tagcount = $this->view->tag_cont = $this->_tag->GetSpecificTag($table,$wh,$id);

            $count=count($tagcount);

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
            $table="tag";
            $sql= $this->view->paginator= $this->_tag->GetpaginationTagSpf($table,$id,$offset,$no_of_records_per_page);

            $notag = $this->_getParam('id');
            $this->view->tagnumber=$notag;

            $id_user=$this->_session->id;
            $this->view->user_list=$id_user;

            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id_user);
            $this->view->user_rol=$usr[0]['fkroles'];
        
        }   else {

            return $this-> _redirect('/');
        
        } 

    }



    public function consumobuscarAction(){

        $notag = $this->_getParam('id');
        $this->view->tagnumber=$notag;

        $id_user=$this->_session->id;
        $this->view->user_list=$id_user;

        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id_user);
        $this->view->user_rol=$usr[0]['fkroles'];

        $table="sitios";
        $this->view->sitio = $this->_season->GetAll($table);

        $this->view->proyectos =$this->_tag->proyectosActuales(); 

        $table="meses";
        $this->view->meses = $this->_season->GetAll($table);

        $table="years";
        $this->view->years = $this->_season->GetAll($table);

        $tid = $this->_getParam('id');
        $table="tag";
        $wh="tag";
        $sql = $this->view->tag_contar = $this->_tag->GetSpecificTag($table,$wh,$tid);

        $total = count($sql);
        $this->view->enproceso=$total;

        $opcion = $this->_getParam('op');
        $this->view->opcion_search=$opcion;

        if($opcion == 1){
            
            $actualpagina=$this->_getParam('pagina');
            $this->view->actpage=$actualpagina;    
            
            $id = $this->_getParam('id');

            $sitio = $this->_getParam('sitio');
            $this->view->sitioid=$sitio;
            

            $tag_contador=$this->view->tagcount=$this->_tag->GetTagSitio($id,$sitio);
            $count=count($tag_contador);

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
                $table="tag";
                $this->view->paginator= $this->_tag->GetTagSitioPaginator($table,$offset,$no_of_records_per_page,$id,$sitio);
            }


            if($opcion == 2){
        
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;        
                $id = $this->_getParam('id');

                $proyecto = $this->_getParam('proyecto');
                $this->view->proyectoid=$proyecto;

                $tag_contador=$this->view->tagcount=$this->_tag->GetTagProyecto($id,$proyecto);
                $count=count($tag_contador);
                
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
                $table="tag";
                $this->view->paginator= $this->_tag->GetTagProyectoPaginator($table,$offset,$no_of_records_per_page,$id,$proyecto);
            }

            if($opcion == 3){
                
                $actualpagina=$this->_getParam('pagina');
                $this->view->actpage=$actualpagina;

                $id = $this->_getParam('id');

                $year = $this->_getParam('year');
                $this->view->yearsel=$year;
                
                $mes = $this->_getParam('mes'); 
                $this->view->messel=$mes; 
                // var_dump($id);
                // var_dump($mes);
                // var_dump($año);

                $tag_contador=$this->view->tagcount=$this->_tag->GetTagMes($id,$mes,$year);
                $count=count($tag_contador);

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
                $table="tag";
                $this->view->paginator= $this->_tag->GetTagMesPaginator($table,$offset,$no_of_records_per_page,$id,$mes,$year);
            }

    }   


    public function excelsitiosproyectoAction(){

        $table="sitios";
        $this->view->sitios = $this->_tag->sitiosproyectoexcel();       
    
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


    // date_default_timezone_set('America/Mexico_City');
    // $hoy = date("d-m-Y H:i:s");