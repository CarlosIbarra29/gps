<?php

class PeticionesController extends Zend_Controller_Action{
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
        $this->_peticion = new Application_Model_GpsPeticionesModel;

        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        }
    }


    public function desarrolladoresAction(){
        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $status=$this->_getParam('status');
        $this->view->status=$status;

        $us=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$us);

        if($usr[0]['fkroles'] == 1){
            $dos = 0;
            $sql = $this->_peticion->getpeticionesadmin($dos);
            $total = count($sql);
            $this->view->enproceso=$total;

            $herracobros=$this->_peticion->getpeticionesadmin($status);
            $count=count($herracobros);
            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_peticion->getpeticioneslimit($status,$offset,$no_of_records_per_page);
        }else{
            $dos = 0;
            $user = $this->_session->id;
            $sql = $this->_peticion->getpeticiones($dos,$user);
            $total = count($sql);
            $this->view->enproceso=$total;

            $herracobros=$this->_peticion->getpeticiones($status,$user);
            $count=count($herracobros);
            if (isset($_GET['pagina'])){$pagina = $_GET['pagina'];}else{$pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_peticion->getpeticioneslimituser($status,$user,$offset,$no_of_records_per_page);           
        } 
    }

    public function detallepeticionAction(){
        $id=$this->_getParam('id');
        $this->view->id_solicitud=$id; 
        
        $wh="id";
        $table="add_peticiones";
        $peticion =$this->view->peticion = $this->_season->GetSpecific($table,$wh,$id);

        $user = $peticion[0]['user_peticion'];
        $wh="id";
        $table="usuario";
        $usr = $this->view->usuario = $this->_season->GetSpecific($table,$wh,$user);

        $rol = $usr[0]['fkroles'];
        $wh="id";
        $table="roles";
        $this->view->rol = $this->_season->GetSpecific($table,$wh,$rol);

        $id = $this->_session->id;
        $wh="id";
        $table="usuario";
        $ver=$this->_season->GetSpecific($table,$wh,$id);
        $this->view->us_fk = $ver[0]['fkroles'];
    }

    public function requestaddpeticionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
            $name = $_FILES['url']['name'];
            if(empty($name)){ 
                $urldb = NULL;
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
                    $url1 = 'img/peticiones/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");
        $id_user = $this->_session->id;

        $table="add_peticiones";
        $result = $this->_peticion->insertnewpeticion($post,$table,$urldb,$hoy,$id_user);
        if ($result) {
            return $this-> _redirect('/peticiones/desarrolladores/status/0');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }
    }

    public function requestupdaterechazarsolicitudAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");
        $id_user = $this->_session->id;
        $wh="id";
        $table="usuario";
        $user= $this->view->rol = $this->_season->GetSpecific($table,$wh,$id_user);
        $name_user = $user[0]['nombre']." ".$user[0]['ap']." ".$user[0]['am'];
        $motivo = $post['motivo'];
        $status = 1;
        $table="add_peticiones";
        $result = $this->_peticion->updatesolicitudpeticiones($post,$table,$hoy,$name_user,$status,$motivo);
        if ($result) {
            return $this-> _redirect('peticiones/detallepeticion/id/'.$post['id_solicitud'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }
    }

    public function requestupdaterechazarsolicitudautorizarAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");
        $id_user = $this->_session->id;
        $wh="id";
        $table="usuario";
        $user= $this->view->rol = $this->_season->GetSpecific($table,$wh,$id_user);
        $name_user = $user[0]['nombre']." ".$user[0]['ap']." ".$user[0]['am'];
        $status = 2;
        $motivo = NULL;
        $table="add_peticiones";
        $result = $this->_peticion->updatesolicitudpeticiones($post,$table,$hoy,$name_user,$status,$motivo);
        if ($result) {
            return $this-> _redirect('peticiones/detallepeticion/id/'.$post['id_solicitud'].'');
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