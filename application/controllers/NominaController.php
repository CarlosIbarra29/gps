<?php
class NominaController extends Zend_Controller_Action{
    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_personal = new Application_Model_GpsPersonalModel;
        $this->_asistencia = new Application_Model_GpsAsistenciaModel;
        $this->_nomina = new Application_Model_GpsNominaModel;
        $this->_nomina2 = new Application_Model_GpsNomina2Model;
        if(empty($this->_session->id)){ $this->redirect('/home/login'); }    
    }

    public function solicitudnominaAction(){
        
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->rol_user = $usr[0]['fkroles'];

        $status = $this->_getParam('status');
        $this->view->status_documento = $status;

        $id=1;
        $this->view->select_personal = $this->_nomina->getusernominabuscador($id);

        $st = 0; $pago =0;
        $enproceo =$this->_nomina->getsolicitudnomina($st,$pago);
        $this->view->enproceso = count($enproceo);

        if($status == 0){
            $st = 0; $pago =0;
            $enproceo =$this->_nomina->getsolicitudnomina($st,$pago);    
            $count=count($enproceo);   
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_nomina->getnominasolicitud($offset,$no_of_records_per_page,$st,$pago);
        }

        if($status == 1){
            $st = 1; $pago =0;
            $enproceo =$this->_nomina->getsolicitudnomina2($st,$pago);    
            $count=count($enproceo);   
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_nomina->getnominasolicitud2($offset,$no_of_records_per_page,$st,$pago);  
        }

        if($status == 2){
            $st = 2; $pago =0;
            $enproceo =$this->_nomina->getsolicitudnomina($st,$pago);    
            $count=count($enproceo);   
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_nomina->getnominasolicitud($offset,$no_of_records_per_page,$st,$pago);  
        }

        if($status == 3){
            $st = 1; $pago =1;
            $enproceo =$this->_nomina->getsolicitudnomina($st,$pago);    
            $count=count($enproceo);   
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_nomina->getnominasolicitud($offset,$no_of_records_per_page,$st,$pago);  
        }
    }


    public function searchsolicitudnominaAction(){
        $id=1;
        $this->view->select_personal = $this->_nomina->getusernominabuscador($id);

        $st = 0; $pago =0;
        $enproceo =$this->_nomina->getsolicitudnomina($st,$pago);
        $this->view->enproceso = count($enproceo);  

        $op = $this->_getParam('op');
        $this->view->op_search = $op;
        $status = $this->_getParam('status');
        $this->view->status_documento = $status;

        if($status == 0){
            if($op == 1){
                $st = 0; $pago =0;
                $personal = $this->_getParam('usuario');
                $this->view->user = $personal;
                $enproceo =$this->_nomina->getsolicitudnominausuario($st,$pago,$personal);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscador($offset,$no_of_records_per_page,$st,$pago,$personal);
            }

            if($op == 2){
                $st = 0; $pago =0;
                $sitio = $this->_getParam('sitio');
                $this->view->sitio = $sitio;
                $enproceo =$this->_nomina->getsolicitudnominasitio($st,$pago,$sitio);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscadorsitio($offset,$no_of_records_per_page,$st,$pago,$sitio);
            }

            if($op == 3){
                $st = 0; $pago =0;
                $id = $this->_getParam('id');
                $this->view->id = $id;
                $enproceo =$this->_nomina->getsolicitudnominaid($st,$pago,$id);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscadorid($offset,$no_of_records_per_page,$st,$pago,$id);
            }
        }

        if($status == 1){
            if($op == 1){
                $st = 1; $pago =0;
                $personal = $this->_getParam('usuario');
                $this->view->user = $personal;
                $enproceo =$this->_nomina->getsolicitudnominausuario2($st,$pago,$personal);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscador2($offset,$no_of_records_per_page,$st,$pago,$personal);
            }

            if($op == 2){
                $st = 1; $pago =0;
                $sitio = $this->_getParam('sitio');
                $this->view->sitio = $sitio;
                $enproceo =$this->_nomina->getsolicitudnominasitio2($st,$pago,$sitio);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscadorsitio2($offset,$no_of_records_per_page,$st,$pago,$sitio);
            }

            if($op == 3){
                $st = 1; $pago =0;
                $id = $this->_getParam('id');
                $this->view->id = $id;
                $enproceo =$this->_nomina->getsolicitudnominaid2($st,$pago,$id);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscadorid2($offset,$no_of_records_per_page,$st,$pago,$id);
            }           
        }

        if($status == 2){
            if($op == 1){
                $st = 2; $pago =0;
                $personal = $this->_getParam('usuario');
                $this->view->user = $personal;
                $enproceo =$this->_nomina->getsolicitudnominausuario($st,$pago,$personal);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscador($offset,$no_of_records_per_page,$st,$pago,$personal);
            }

            if($op == 2){
                $st = 2; $pago =0;
                $sitio = $this->_getParam('sitio');
                $this->view->sitio = $sitio;
                $enproceo =$this->_nomina->getsolicitudnominasitio($st,$pago,$sitio);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscadorsitio($offset,$no_of_records_per_page,$st,$pago,$sitio);
            }

            if($op == 3){
                $st = 2; $pago =0;
                $id = $this->_getParam('id');
                $this->view->id = $id;
                $enproceo =$this->_nomina->getsolicitudnominaid($st,$pago,$id);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscadorid($offset,$no_of_records_per_page,$st,$pago,$id);
            }           
        }     

        if($status == 3){
            if($op == 1){
                $st = 1; $pago =1;
                $personal = $this->_getParam('usuario');
                $this->view->user = $personal;
                $enproceo =$this->_nomina->getsolicitudnominausuario($st,$pago,$personal);
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscador($offset,$no_of_records_per_page,$st,$pago,$personal);

            }

            if($op == 2){
                $st = 1; $pago =1;
                $sitio = $this->_getParam('sitio');
                $this->view->sitio = $sitio;
                $enproceo =$this->_nomina->getsolicitudnominasitio($st,$pago,$sitio);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscadorsitio($offset,$no_of_records_per_page,$st,$pago,$sitio);
            }

            if($op == 3){
                $st = 1; $pago =1;
                $id = $this->_getParam('id');
                $this->view->id = $id;
                $enproceo =$this->_nomina->getsolicitudnominaid($st,$pago,$id);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscadorid($offset,$no_of_records_per_page,$st,$pago,$id);
            }            
        }

    }

    public function solicitudnominacontaAction(){
        
    }


    public function nominaspendientesAction(){
        
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->rol_user = $usr[0]['fkroles'];

        $status = $this->_getParam('status');
        $this->view->status_documento = $status;

        $id=1;
        $this->view->select_personal = $this->_nomina->getusernominabuscador($id);

        $st = 1; $pago = 0; $st2 = 0;
        $enproceo =$this->_nomina->getsolicitudnomina3($st,$pago);
        $this->view->enproceso = count($enproceo);

        if($status == 1){
            $st = 1; $pago =0; $st2 = 0;
            $enproceo =$this->_nomina->getsolicitudnomina3($st,$pago);    
            $count=count($enproceo);   
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_nomina->getnominasolicitud3($offset,$no_of_records_per_page,$st,$pago);
        }
    }

    public function searchsolpendientesAction(){
        $id=1;
        $this->view->select_personal = $this->_nomina->getusernominabuscador($id);

        $st = 1; $pago =0;
        $enproceo =$this->_nomina->getsolicitudnomina3($st,$pago);
        $this->view->enproceso = count($enproceo);  

        $op = $this->_getParam('op');
        $this->view->op_search = $op;
        $status = $this->_getParam('status');
        $this->view->status_documento = $status;

        if($status == 1){
            if($op == 1){
                $st = 1; $pago =0;
                $personal = $this->_getParam('usuario');
                $this->view->user = $personal;
                $enproceo =$this->_nomina->getsolicitudnominausuario3($st,$pago,$personal);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscador3($offset,$no_of_records_per_page,$st,$pago,$personal);
            }

            if($op == 2){
                $st = 1; $pago =0;
                $sitio = $this->_getParam('sitio');
                $this->view->sitio = $sitio;
                $enproceo =$this->_nomina->getsolicitudnominasitio3($st,$pago,$sitio);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscadorsitio3($offset,$no_of_records_per_page,$st,$pago,$sitio);
            }

            if($op == 3){
                $st = 1; $pago =0;
                $id = $this->_getParam('id');
                $this->view->id = $id;
                $enproceo =$this->_nomina->getsolicitudnominaid3($st,$pago,$id);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolicitudbuscadorid3($offset,$no_of_records_per_page,$st,$pago,$id);
            }           
        }
    }


    public function detallenominaAction(){
        $user = $this->_getParam('user');
        $this->view->user_solicitud = $user;
        $this->view->personal_nomina = $this->_nomina->getdetailnominauser($user);  

        $solicitud = $this->_getParam('id');
        $this->view->solicitudid_nomina = $solicitud;
        
        $wh="id";
        $table="personal_nomina";
        $this->view->solicitud_nomina = $this->_season->GetSpecific($table,$wh,$solicitud);    

        $wh="solicitud_nomina";
        $table ="personal_asistencia";
        $this->view->detalle_nomina = $this->_nomina->getdetailnomina($solicitud);

        $wh="solicitud_nomina";
        $table ="personal_pagonomina";
        $this->view->pago_nomina = $this->_season->GetSpecific($table,$wh,$solicitud);

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->rol_user = $usr[0]['fkroles'];

    }

    public function pdfnominaAction(){
        $user = $this->_getParam('user');
        $this->view->user_solicitud = $user;
        $this->view->personal_nomina = $this->_nomina->getdetailnominauser($user);  

        $solicitud = $this->_getParam('id');
        $this->view->solicitudid_nomina = $solicitud;
        
        $wh="id";
        $table="personal_nomina";
        $this->view->solicitud_nomina = $this->_season->GetSpecific($table,$wh,$solicitud);    

        $wh="solicitud_nomina";
        $table ="personal_asistencia";
        $this->view->detalle_nomina = $this->_nomina->getdetailnomina($solicitud);        
    }


    public function requestchangecambiostatusnominaAction(){
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

            $table="personal_nomina";
            $result=$this->_nomina->updatenominstatus($post,$table,$hoy,$nombre_usuario);

            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }   
        }
    }

    public function requestchangecambiostatusnominapostAction(){
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

            $table="personal_nomina";
            $result=$this->_nomina->updatenominstatuscomentario($post,$table,$hoy,$nombre_usuario);

            if ($result) {
                return $this->_redirect('/nomina/detallenomina/id/'.$post['id'].'/user/'.$post['user'].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }  
        }
    }


    public function requestaddstatuspagonominaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $nombre_usuario = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];

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
                $url1 = 'img/pago_nomina/';
                $urldb = $url1.$info1;
                move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
            }
        } // END  URLDB_ENTRADA

        $table="personal_pagonomina";
        $this->_nomina->insertpagonomina($post,$table,$hoy,$nombre_usuario,$urldb);

        $table="personal_nomina";
        $result=$this->_nomina->updateevidenciapagonomina($post,$table,$hoy,$nombre_usuario);


        if ($result) {
            return $this->_redirect('/nomina/detallenomina/id/'.$post['id_solicitud'].'/user/'.$post['user'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 
    }


    public function requestdeletepagonominaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $nombre_usuario = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];
        $table="personal_nomina";
        $this->_nomina->updatedeleteevidenciapagonomina($post,$table,$hoy,$nombre_usuario);

        if($this->getRequest()->getPost()){
                $id=$post['id'];
                $table="personal_pagonomina";
                $wh="solicitud_nomina";
                $result = $this->_season->deleteAll($id,$table,$wh);
            if ($result) {
                echo json_encode(array('status' => "1","message"=>"Se ha agregado correctamente", "data"=>$post));   
            }else{
                print '<script language="JavaScript">';
                print 'alert("Ocurrio un error: Comprueba los datos.");';
                print '</script>';
            }
        }        
    }


     public function nominamanagerAction(){

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $table="personal_nomina";
        $this->view->nominas_mng = $this->_nomina->getnominasmanager($table);

        $nominasmanager=$this->_nomina->getnominasmanager($table);
        $count=count($nominasmanager);

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
        $table="personal_nomina";
        $sql= $this->view->paginator= $this->_nomina->GetPaginationNmnMng($table,$offset,$no_of_records_per_page);   

    }   // Status Campamentos


    public function detallenominamgrAction(){
        $sitio = $this->_getParam('sitio');
        $this->view->sitio_name = $sitio;
        $proyecto=$this->_getParam('proyecto'); $this->view->proyecto=$proyecto;
        
        $table="personal_nomina";

        $nominasmgr = $this->_nomina->GetNominaSitioMgr($table,$sitio,$proyecto);

        $id_sol= @$nominasmgr[0]['id'];

        foreach ($nominasmgr as $key => $value) {

            $id= $value['id'];
            
            $periodoNomina= $this->view->periodoNomina = $this->_nomina->GetPeriodoNominas($table,$id);

            $nominasmgr[$key]['periodonomina'] = $periodoNomina;

        }

        $this->view->info_nominas = $nominasmgr;


        if($sitio == "Taller"){
            $this->view->sitio_info_taller = 1; 
        }elseif($sitio == "Compensacion"){
            $this->view->sitio_info_taller = 2;
        }elseif($sitio == "Vacaciones"){
            $this->view->sitio_info_taller = 3; 
        }elseif($sitio == "Taller Foraneos"){
            $this->view->sitio_info_taller = 4; 
        }else{
            $this->view->sitio_info_taller = 0; 
            $table = "sitios";
            $this->view->sitio_info = $this->_nomina->GetSitiosDatos($table,$sitio); 
        }
                    
    }

    public function comentariosnominaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $table="personal_nomina";
        $result=$this->_nomina->updatecomentariosnomina($table,$post);
        
        if ($result) {
            return $this-> _redirect('/nomina/detallenominamgr/sitio/'.$post['sitio'].'/proyecto/'.$post['id_proyecto'].' ');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }   
    }

    public function requestaceptarsolAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");
        $us=$this->_session->id;
        $wh="id";
        $table="usuario";
        $pre = $this->_season->GetSpecific($table,$wh,$us);
        $solicitud_user = $pre[0]['nombre']." ".$pre[0]['ap']." ".$pre[0]['am'];
        $id_user = $pre[0]['id'];

        $montos = 0;
        foreach ($post['ids'] as $key) {
            $id= $key;
            $wh="id";
            $table="personal_nomina";
            $pago_nomina = $this->_season->GetSpecific($table,$wh,$id);
            $num =$pago_nomina[0]['monto_nomina'];

            $multi = 5;

            if (fmod($num, $multi) <> 0) {
                $monto = $num-fmod($num, $multi)+$multi;
            } else {
                $monto = $num;
            }
            $montos = $montos + $monto;
        }

        $status_pack = 1;

        $table = "personal_nominapack";
        $id_solicitud = $this->_nomina2->insertnominasolicitudfin($id_user,$solicitud_user,$status_pack,$post,$table,$hoy,$montos);
        // $ver = $this->view->asistencia =$this->_asistencia->getpersonalasistencianomina($id_user);

        foreach ($post['ids'] as $key) {
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $us=$this->_session->id;
            $wh="id";
            $table="usuario";
            $pre = $this->_season->GetSpecific($table,$wh,$us);
            $solicitud_user = $pre[0]['nombre']." ".$pre[0]['ap']." ".$pre[0]['am'];
            $id_user = $pre[0]['id'];
                
            $status_sol= 1;

            $id= $key;
            $wh="id";
            $table="personal_nomina";
                
            $result=$this->_nomina2->updatesolnominafin($id,$table,$post,$hoy,$solicitud_user,$id_user,$id_solicitud,$status_sol);
        }
       
        if ($result) {
            return $this-> _redirect('/nomina/detallenominamgr/sitio/'.$post['sitio'].'/proyecto/'.$post['id_proyecto'].' ');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }   
    }


    public function requestcancelarnomsolAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");
        $us=$this->_session->id;
        $wh="id";
        $table="usuario";
        $pre = $this->_season->GetSpecific($table,$wh,$us);
        $solicitud_user = $pre[0]['nombre']." ".$pre[0]['ap']." ".$pre[0]['am'];
        $id_user = $pre[0]['id'];

        $montos = 0;
        foreach ($post['ids'] as $key) {
            $id= $key;
            $wh="id";
            $table="personal_nomina";
            $pago_nomina = $this->_season->GetSpecific($table,$wh,$id);
            $num =$pago_nomina[0]['monto_nomina'];

            $multi = 5;

            if (fmod($num, $multi) <> 0) {
                $monto = $num-fmod($num, $multi)+$multi;
            } else {
                $monto = $num;
            }
            $montos = $montos + $monto;
        }

        $status_pack = 2;

        $table = "personal_nominapack";
        $id_solicitud = $this->_nomina2->insertnominasolicitudfin($id_user,$solicitud_user,$status_pack,$post,$table,$hoy,$montos);
        // $ver = $this->view->asistencia =$this->_asistencia->getpersonalasistencianomina($id_user);

        foreach ($post['ids'] as $key) {
            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y H:i:s");
            $us=$this->_session->id;
            $wh="id";
            $table="usuario";
            $pre = $this->_season->GetSpecific($table,$wh,$us);
            $solicitud_user = $pre[0]['nombre']." ".$pre[0]['ap']." ".$pre[0]['am'];
            $id_user = $pre[0]['id'];
                
            $status_sol= 2;

            $id= $key;
            $wh="id";
            $table="personal_nomina";
                
            $result=$this->_nomina2->updatesolnominafincancel($id,$table,$post,$hoy,$solicitud_user,$id_user,$id_solicitud,$status_sol);
        }
       
        if ($result) {
            return $this-> _redirect('/nomina/detallenominamgr/sitio/'.$post['sitio'].'/proyecto/'.$post['id_proyecto'].' ');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }   
    }


    public function listanominamgrAction(){
        
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $this->view->rol_user = $usr[0]['fkroles'];

        $status = $this->_getParam('status');
        $this->view->status_documento = $status;

        $id=1;
        $this->view->select_personal = $this->_nomina->getusernominabuscador($id);

        $st = 1; 
        $enproceo =$this->_nomina->getsolicitudnominamgr($st);
        $this->view->enproceso = count($enproceo);

        if($status == 1){
            $st = 1;
            $enproceo =$this->_nomina->getsolicitudnominamgr($st);    
            $count=count($enproceo);   
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_nomina->getnominasolicitudmgr($offset,$no_of_records_per_page,$st);
        }

        if($status == 2){
            $st = 2;
            $enproceo =$this->_nomina->getsolicitudnominamgr($st);    
            $count=count($enproceo);   
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_nomina->getnominasolicitudmgr($offset,$no_of_records_per_page,$st);  
        }

    }


    public function searchsolnominamgrAction(){
        $id=1;
        $this->view->select_personal = $this->_nomina->getusernominabuscador($id);

        $st = 1; 
        $enproceo =$this->_nomina->getsolicitudnominamgr($st);
        $this->view->enproceso = count($enproceo);  

        $op = $this->_getParam('op');
        $this->view->op_search = $op;
        $status = $this->_getParam('status');
        $this->view->status_documento = $status;

        if($status == 1){
            if($op == 1){
                $st = 1; 
                $sitio = $this->_getParam('sitio');
                $this->view->sitio = $sitio;
                $enproceo =$this->_nomina->getsolnominasitiomgr($st,$sitio);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolbuscadorsitiomgr($offset,$no_of_records_per_page,$st,$sitio);
            }

            if($op == 2){
                $st = 1; 
                $id = $this->_getParam('id');
                $this->view->id = $id;
                $enproceo =$this->_nomina->getsolicitudnominaidmgr($st,$id);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolbuscadoridmgr($offset,$no_of_records_per_page,$st,$id);
            }
        }

        if($status == 2){
            
            if($op == 1){
                $st = 2; 
                $sitio = $this->_getParam('sitio');
                $this->view->sitio = $sitio;
                $enproceo =$this->_nomina->getsolnominasitiomgr($st,$sitio);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolbuscadorsitiomgr($offset,$no_of_records_per_page,$st,$sitio);
            }

            if($op == 2){
                $st = 2;
                $id = $this->_getParam('id');
                $this->view->id = $id;
                $enproceo =$this->_nomina->getsolicitudnominaidmgr($st,$id);    
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_nomina->getnominasolbuscadoridmgr($offset,$no_of_records_per_page,$st,$id);
            }           
        }
    }

    public function detallemgrnomAction(){
        $id = $this->_getParam('id');
        $this->view->id_solicitud = $id;
    
        $wh="id";
        $table="personal_nominapack";
        $pre = $this->_season->GetSpecific($table,$wh,$id);
        $sitio = $pre[0]['sitio'];
        $this->view->sitio_name = $sitio;

        $table="personal_nominapack";
        $nominapack= $this->view->info_nominapack = $this->_season->GetSpecific($table,$wh,$id);

        $table="personal_nomina";
        $nominasmgr= $this->view->info_nominas = $this->_nomina->GetNominaPackMgr($table,$id);

        if($sitio == "Taller"){
            $this->view->sitio_info_taller = 1; 
        }elseif($sitio == "Compensacion"){
            $this->view->sitio_info_taller = 2;
        }elseif($sitio == "Vacaciones"){
            $this->view->sitio_info_taller = 3; 
        }elseif($sitio == "Taller Foraneos"){
            $this->view->sitio_info_taller = 4; 
        }else{
            $this->view->sitio_info_taller = 0; 
            $table = "sitios";
            $this->view->sitio_info = $this->_nomina->GetSitiosDatos($table,$sitio); 
        }
                    
    }

    public function pdfsolnominaAction(){
        $id = $this->_getParam('id');
        $this->view->solicitudid_nomina = $id;
    
        $wh="id";
        $table="personal_nominapack";
        $pre = $this->_season->GetSpecific($table,$wh,$id);
        $sitio = $pre[0]['sitio'];
        $this->view->sitio_name = $sitio;

        $table="personal_nominapack";
        $nominapack= $this->view->info_nominapack = $this->_season->GetSpecific($table,$wh,$id);

        $table="personal_nomina";
        $nominasmgr= $this->view->info_nominas = $this->_nomina->GetNominaPackMgr($table,$id);

        if($sitio == "Taller"){
            $this->view->sitio_info_taller = 1; 
        }elseif($sitio == "Compensacion"){
            $this->view->sitio_info_taller = 2;
        }elseif($sitio == "Vacaciones"){
            $this->view->sitio_info_taller = 3; 
        }elseif($sitio == "Taller Foraneos"){
            $this->view->sitio_info_taller = 4; 
        }else{
            $this->view->sitio_info_taller = 0; 
            $table = "sitios";
            $this->view->sitio_info = $this->_nomina->GetSitiosDatos($table,$sitio); 
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



