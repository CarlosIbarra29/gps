<?php
class PrestamoController extends Zend_Controller_Action{
    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_personal = new Application_Model_GpsPersonalModel;
        $this->_asistencia = new Application_Model_GpsAsistenciaModel;
        $this->_nomina = new Application_Model_GpsNominaModel;
        $this->_prestamo = new Application_Model_GpsPrestamoModel;
        if(empty($this->_session->id)){ $this->redirect('/home/login'); }    
    }


    public function solicitudprestamoAction(){
        $status = $this->_getParam('status');
        $this->view->status_documento = $status;

        $op = 1;
        $this->view->prestamo_user = $this->_prestamo->getpersonalprestamo($op);

        $op_status = 0;
        $sol =$this->_prestamo->getprestamos($op_status);
        $this->view->enproceso = count($sol);

        if($status == 0){
            $op_status = 0; 
            $enproceo =$this->_prestamo->getprestamos($op_status);   
            $count=count($enproceo);   
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_prestamo->getprestamosolicitud($offset,$no_of_records_per_page,$op_status);
        }

        if($status == 1){
            $op_status = 1; 
            $enproceo =$this->_prestamo->getprestamos($op_status);     
            $count=count($enproceo);   
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

            $no_of_records_per_page = 25;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_prestamo->getprestamosolicitud($offset,$no_of_records_per_page,$op_status);  
        }

    }


    public function searchsolicitudprestamoAction(){
        $op = 1;
        $this->view->prestamo_user = $this->_prestamo->getpersonalprestamo($op);

        $status = $this->_getParam('status');
        $this->view->status_documento = $status;

        $op_status = 0;
        $sol =$this->_prestamo->getprestamos($op_status);
        $this->view->enproceso = count($sol);

        $op = $this->_getParam('op');
        $this->view->op_search = $op;

        if($status == 0){
            if($op == 1){
                $user = $this->_getParam('usuario');
                $this->view->user = $user;
                $op_status = 0; 
                $enproceo =$this->_prestamo->getprestamosusuario($op_status,$user);   
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_prestamo->getprestamosolicituduser($offset,$no_of_records_per_page,$op_status,$user);
            }

            if($op == 2){
                $dia = $this->_getParam('dia');
                $this->view->dia = $dia;
                $mes = $this->_getParam('mes');
                $this->view->mes = $mes;
                $year = $this->_getParam('year');
                $this->view->year = $year;
                $op_status = 0; 
                $fecha =$dia."-".$mes."-".$year;
                $enproceo =$this->_prestamo->getprestamosyear($op_status,$fecha);   
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_prestamo->getprestamosolicituddia($offset,$no_of_records_per_page,$op_status,$fecha);
            }
        }


        if($status == 1){
            if($op == 1){
                $user = $this->_getParam('usuario');
                $this->view->user = $user;
                $op_status = 1; 
                $enproceo =$this->_prestamo->getprestamosusuario($op_status,$user);   

                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_prestamo->getprestamosolicituduser($offset,$no_of_records_per_page,$op_status,$user);
            }

            if($op == 2){
                $dia = $this->_getParam('dia');
                $mes = $this->_getParam('mes');
                $year = $this->_getParam('year');
                $op_status = 1; 
                $fecha =$dia."-".$mes."-".$year;
                $this->view->fecha_user = $fecha;
                $enproceo =$this->_prestamo->getprestamosyear($op_status,$fecha);   
                $count=count($enproceo);   
                if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;}

                $no_of_records_per_page = 25;
                $offset = ($pagina-1) * $no_of_records_per_page; 
                $total_pages= $count;

                $this->view->totalpage = $total_pages;
                $this->view->total=ceil($total_pages/$no_of_records_per_page);
                $this->view->paginator=$this->_prestamo->getprestamosolicituddia($offset,$no_of_records_per_page,$op_status,$fecha);
            }
        }

    }


    public function detalleprestamoAction(){
        $id_solicitud = $this->_getParam('id');
        $this->view->id_solicitud = $id_solicitud;

        $wh="id";
        $table="personal_prestamos";
        $sol = $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id_solicitud);
        $user =$sol[0]['id_personal'];
        $wh="id";
        $table="personal_campo";
        $inf_user =$this->view->personal = $this->_season->GetSpecific($table,$wh,$user);

        $puesto = $inf_user[0]['puesto'];
        $wh="id";
        $table="puestos_personal";
        $this->view->puestos = $this->_season->GetSpecific($table,$wh,$puesto);


        $wh="solicitud_prestamo";
        $table="personal_asistencia";
        $this->view->pagos_realizados = $this->_season->GetSpecific($table,$wh,$id_solicitud);

    }

    public function pdfprestamoAction(){
        $id_solicitud = $this->_getParam('id');
        $this->view->id_solicitud = $id_solicitud;

        $wh="id";
        $table="personal_prestamos";
        $sol = $this->view->solicitud = $this->_season->GetSpecific($table,$wh,$id_solicitud);
        $user =$sol[0]['id_personal'];
        $wh="id";
        $table="personal_campo";
        $inf_user =$this->view->personal = $this->_season->GetSpecific($table,$wh,$user);

        $puesto = $inf_user[0]['puesto'];
        $wh="id";
        $table="puestos_personal";
        $this->view->puestos = $this->_season->GetSpecific($table,$wh,$puesto);       
    }

    public function requestaddprestamoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost(); 

            $name = $_FILES['url']['name'];
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
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
                    $url1 = 'img/evidencia_prestamos/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            } // END  URLDB_ENTRADA

        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y");

        $id=$post['usuario'];
        $wh="id";
        $table="personal_Campo";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $nombre_personal = $usr[0]['nombre']." ".$usr[0]['apellido_pa']." ".$usr[0]['apellido_ma'];
    
        $id_us=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id_us);
        $nombre_usuario = $usr[0]['nombre']." ".$usr[0]['ap']." ".$usr[0]['am'];

        $year_uno = substr($post['fecha'], 0,4); 
        $mes_uno = substr($post['fecha'], 5,2); 
        $day_uno = substr($post['fecha'], 8); 
        $fecha_prestamo = $day_uno."-".$mes_uno."-".$year_uno;

        $table = "personal_prestamos";
        $result = $this->_prestamo->insertnewprestamo($post,$table,$hoy,$nombre_personal,$nombre_usuario,$fecha_prestamo,$urldb);
        if ($result) {
            return $this->_redirect('/prestamo/solicitudprestamo/status/0');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 

    }


    public function requestaplicarprestamoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost(); 

        foreach ($post['validar'] as $key) {
            $id = $key;
            $wh="id";
            $table="personal_prestamos";
            $usr = $this->_season->GetSpecific($table,$wh,$id);
            $descuento ="-".$usr[0]['monto'] / $usr[0]['cantidad_pagos'];
            $num_pago =$usr[0]['cantidad_saldada'];
            $new_num_pago = $num_pago + 1;
            if($new_num_pago == $usr[0]['cantidad_pagos']){
                $this->_prestamo->updatesolicituprestamouno($id,$table,$new_num_pago);
            }else{
                $this->_prestamo->updatesolicituprestamodos($id,$table,$new_num_pago); 
            }

            date_default_timezone_set('America/Mexico_City');
            $hoy = date("d-m-Y");

            $table = "personal_asistencia";
            $result = $this->_prestamo->insertnewprestamonomina($post,$table,$id,$descuento,$hoy); 
        }

        if ($result) {
            return $this->_redirect('/asistencia/personalasistencia/id/'.$post['user'].'/sitio/'.$post['sitio'].'/proyecto/'.$post['id_proyecto'].'');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        }       
    }


    public function requestdeleteprestamonuevoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        $id=$post['id'];
        $table="personal_prestamos";
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