<?php

class PersonalController extends Zend_Controller_Action{
	private $_season;
    private $_session;
    private $_user;

    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_personal = new Application_Model_GpsPersonalModel;
        $this->_nomina = new Application_Model_GpsNominaModel;
        if(empty($this->_session->id)){ $this->redirect('/home/login'); }    
    }

    public function listapersonalAction(){
        $this->view->personal_excel = $this->_personal->getallpersonalexcel(); 
        $this->view->puesto = $this->_personal->getallpersonal(); 
        $table="sitios";
        $this->view->sitios = $this->_season->GetAll($table); 
        $this->view->proyectos =$this->_sitio->tiposproyectospersonal();      

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $id=1; $wh="status_campo";
        $table="personal_campo";
        $pagi_count = $this->_season->GetSpecific($table,$wh,$id);
        $count=count($pagi_count);
        if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

        $no_of_records_per_page = 20;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $this->view->paginator= $this->_personal->getpersonalcuadrilla($offset,$no_of_records_per_page,$id); 
    }

    public function buscadorpersonalAction(){
        $this->view->puesto = $this->_personal->getallpersonal(); 

        $table="sitios";
        $this->view->sitios = $this->_season->GetAll($table); 
        $this->view->proyectos =$this->_sitio->tiposproyectospersonal();      

        $actualpagina=$this->_getParam('pagina');
        $this->view->actpage=$actualpagina;

        $op=$this->_getParam('op');
        $this->view->op_select=$op;

        if($op == 1){
            $id = 1; $nombre=$this->_getParam('nombre'); $this->view->nombre_select=$nombre;
            $pagi_count = $this->_personal->getnombrecuadrilla($id,$nombre);
            $count=count($pagi_count);
            $this->view->count=$count;
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_personal->getnombrecuadrillapag($offset,$no_of_records_per_page,$id,$nombre);
        }

        if($op == 2){
            $id = 1; $puesto=$this->_getParam('puesto');
            $pagi_count = $this->_personal->getpuestocuadrilla($id,$puesto);
            $count=count($pagi_count);
            $this->view->count=$count;
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_personal->getpuestocuadrillapag($offset,$no_of_records_per_page,$id,$puesto);
        }

        if($op == 3){
            $id = 1; $sitio=$this->_getParam('sitio'); $this->view->sitio_select=$sitio;
            $pagi_count = $this->_personal->getsitiocuadrilla($id,$sitio);
            $count=count($pagi_count);
            $this->view->count=$count;
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_personal->getsitiocuadrillapag($offset,$no_of_records_per_page,$id,$sitio);
        }

        if($op == 4){
            $id = 1; $status=$this->_getParam('status'); $this->view->status_select=$status;
            $pagi_count = $this->_personal->getstatuscuadrilla($id,$status);
            $count=count($pagi_count);
            $this->view->count=$count;
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 20;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator=$this->_personal->getstatuscuadrillapag($offset,$no_of_records_per_page,$id,$status);
        }
    }

    public function asignarpersonalAction(){
        $table="sitios";
        $this->view->sitios = $this->_season->GetAll($table); 
        $this->view->proyectos =$this->_sitio->tiposproyectospersonal();       
    }

    public function liberarpersonalAction(){
        $table="sitios";
        $this->view->sitios = $this->_season->GetAll($table); 
        $this->view->proyectos =$this->_sitio->tiposproyectospersonal();   
    }


    public function procesoasignarAction(){
        // FECHA INICIAL 
            $dateuno=$this->_getParam('dia_inicial'); 
            $datedos=$this->_getParam('mes_inicial'); 
            $datetres=$this->_getParam('year_inicial');
            $datos_uno = $dateuno."/".$datedos."/".$datetres;
            $this->view->fecha_inicial=$datos_uno;
        // END FECHA INICIAL

        // FECHA FINAL
            $dateone=$this->_getParam('dia_final'); 
            $datetwo=$this->_getParam('mes_final'); 
            $datethree=$this->_getParam('year_final');
            $datos_one = $dateone."/".$datetwo."/".$datethree;
            $this->view->fecha_final=$datos_one;
        // END FECHA FINAL

        $op=$this->_getParam('op'); 
        $this->view->op_select = $op;
        if($op == 1){
            $sitio=$this->_getParam('sitio');  $this->view->sitio_id=$sitio;
            $proyecto=$this->_getParam('proyecto'); $this->view->proyecto=$proyecto;

            $wh="id";
            $table="sitios";
            $this->view->sitio = $this->_season->GetSpecific($table,$wh,$sitio);     
            $this->view->proyectos = $this->_sitio->proyectoasignarpersonal($proyecto);  

            $id=1; $status=0; $wh="status_campo";
            $table="personal_campo";
            $pagi_count = $this->_personal->getpersonalasignarcount($id,$status);
            $count=count($pagi_count);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 140;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_personal->getpersonalasignarpaginator($offset,$no_of_records_per_page,$id,$status); 
        } // END SITIOS

        if($op == 2){
            $id=1; $status=0; $wh="status_campo";
            $table="personal_campo";
            $pagi_count = $this->_personal->getpersonalasignarcount($id,$status);
            $count=count($pagi_count);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 40;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_personal->getpersonalasignarpaginator($offset,$no_of_records_per_page,$id,$status); 
        } // END COMPENSACION

        if($op == 3){
            $id=1; $status=0; $wh="status_campo";
            $table="personal_campo";
            $pagi_count = $this->_personal->getpersonalasignarcount($id,$status);
            $count=count($pagi_count);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 40;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_personal->getpersonalasignarpaginator($offset,$no_of_records_per_page,$id,$status); 
        } // END TALLER

        if($op == 4){
            $id=1; $status=0; $wh="status_campo";
            $table="personal_campo";
            $pagi_count = $this->_personal->getpersonalasignarcount($id,$status);
            $count=count($pagi_count);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 40;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_personal->getpersonalasignarpaginator($offset,$no_of_records_per_page,$id,$status); 
        } // END VACACIONES

        if($op == 5){
            $id=1; $status=0; $wh="status_campo";
            $table="personal_campo";
            $pagi_count = $this->_personal->getpersonalasignarcount($id,$status);
            $count=count($pagi_count);
            if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 

            $no_of_records_per_page = 40;
            $offset = ($pagina-1) * $no_of_records_per_page; 
            $total_pages= $count;

            $this->view->totalpage = $total_pages;
            $this->view->total=ceil($total_pages/$no_of_records_per_page);
            $this->view->paginator= $this->_personal->getpersonalasignarpaginator($offset,$no_of_records_per_page,$id,$status); 
        } // END Taller Foraneos
    }

    public function procesoliberarAction(){
        $op=$this->_getParam('op');  $this->view->op_select=$op;

        $sitio=$this->_getParam('sitio');  $this->view->sitio_id=$sitio;
        $proyecto=$this->_getParam('proyecto'); $this->view->proyecto=$proyecto;

        $wh="id";
        $table="sitios";
        $this->view->sitio = $this->_season->GetSpecific($table,$wh,$sitio);     
        $this->view->proyectos = $this->_sitio->proyectoasignarpersonal($proyecto);  

        $pagi_count = $this->_personal->getpersonalliberarcount($sitio,$proyecto);
        $count=count($pagi_count);
        $this->view->count=$count;

        if (isset($_GET['pagina'])) { $pagina = $_GET['pagina']; } else { $pagina= $this->view->pagina = 1;} 
        $no_of_records_per_page = 40;
        $offset = ($pagina-1) * $no_of_records_per_page; 
        $total_pages= $count;

        $this->view->totalpage = $total_pages;
        $this->view->total=ceil($total_pages/$no_of_records_per_page);
        $this->view->paginator= $this->_personal->getpersonalliberarpaginator($offset,$no_of_records_per_page,$sitio,$proyecto); 

    }

    public function asistenciapersonalAction(){
        $id=$this->_getParam('id'); $this->view->personal_id=$id;
        $table="personal_campo";
        $wh="id";
        $info = $this->view->info_personal = $this->_season->GetSpecific($table,$wh,$id);   
        
        if($info[0]['id_sitiopersonal'] == 0){
            $sit = 0;
            $this->view->if_sitio=$sit;
        }else{
            $sit = 1;
            $this->view->if_sitio=$sit;
            $table="sitios";
            $wh="id";
            $this->view->sitio_info = $this->_season->GetSpecific($table,$wh,$info[0]['id_sitiopersonal']);  

            $table="puestos_personal";
            $wh="id";
            $puesto = $this->_season->GetSpecific($table,$wh,$info[0]['puesto']);  
            $this->view->puesto_info = $puesto[0]['nombre']; 
        }
    }


    public function requestaddpersonalsitioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        
        $year_uno = substr($post['fecha_inicial'], 6); 
        $mes_uno = substr($post['fecha_inicial'], 3,2); 
        $day_uno = substr($post['fecha_inicial'], 0,2); 
        $fecha_inicial = $day_uno."-".$mes_uno."-".$year_uno;

        $year_dos = substr($post['fecha_final'], 6); 
        $mes_dos = substr($post['fecha_final'], 3,2); 
        $day_dos = substr($post['fecha_final'], 0,2); 
        $fecha_fianl = $day_dos."-".$mes_dos."-".$year_dos;

        $fechaInicio=strtotime($fecha_inicial);
        $fechaFin=strtotime($fecha_fianl);

        if($post['op'] == 1){
            $id=$post['sitio'];
            $wh="id";
            $table="sitios";
            $sitio = $this->_season->GetSpecific($table,$wh,$id);
            $name_sitio = $sitio[0]['nombre']; 

            foreach ($post['ids'] as $key){                
                $table="personal_campo";
                $id = $key;
                $result = $this->_sitio->asignacionpersonalasitio($post,$table,$name_sitio,$id);  

                // for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
                //     $dias =  date("d-m-Y", $i);
                //     $table="personal_checkin";
                //     $this->_personal->isertdaystocheckin($post,$table,$name_sitio,$id,$dias);
                // } 
                // FALTA HACER EL PROCESO EN LA SECCION INDIVIDUAL-------------------------------------------
            }
        }

        if($post['op'] == 2){
            $name_sitio = "Compensacion";
            $proyecto=2222222;
            foreach ($post['ids'] as $key) {                
                $table="personal_campo";
                $id = $key;
                $result = $this->_sitio->asignacionpersonalopcomp($post,$table,$name_sitio,$id,$proyecto);  
            }
        }

        if($post['op'] == 3){
            $name_sitio = "Taller";
            $proyecto=3333333;
            foreach ($post['ids'] as $key) {                
                $table="personal_campo";
                $id = $key;
                $result = $this->_sitio->asignacionpersonalop($post,$table,$name_sitio,$id,$proyecto);  
            }
        }

        if($post['op'] == 4){
            $name_sitio = "Vacaciones";
            $proyecto=4444444;
            foreach ($post['ids'] as $key) {                
                $table="personal_campo";
                $id = $key;
                $result = $this->_sitio->asignacionpersonalopvac($post,$table,$name_sitio,$id,$proyecto);  
            }       
        }

        if($post['op'] == 5){
            $name_sitio = "Taller Foraneos";
            $proyecto=5555555;
            foreach ($post['ids'] as $key) {                
                $table="personal_campo";
                $id = $key;
                $result = $this->_sitio->asignacionpersonaloptalfor($post,$table,$name_sitio,$id,$proyecto);  
            }
        }

        if ($result) {
            return $this-> _redirect('/personal/listapersonal');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 
    } 

    public function requestaddpersonalasignarAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost(); 
        $id=$post['id_user'];
        $wh="id";
        $table="personal_campo";
        $personal = $this->_season->GetSpecific($table,$wh,$id);
        if($personal[0]['puesto'] == 30 || $personal[0]['puesto'] == 31){
            $name = $personal[0]['nombre']." ".$personal[0]['apellido_pa']." ".$personal[0]['apellido_ma'];
            $table ="sitios_tipoproyecto";
            $this->_sitio->updatesitioresidente($post,$table,$name);
        }

        $year_uno = substr($post['fecha_inicial'], 0,4); 
        $mes_uno = substr($post['fecha_inicial'], 5,2); 
        $day_uno = substr($post['fecha_inicial'], 8,2); 
        $fecha_inicial = $day_uno."-".$mes_uno."-".$year_uno;

        $year_dos = substr($post['fecha_final'], 0,4); 
        $mes_dos = substr($post['fecha_final'], 5,2); 
        $day_dos = substr($post['fecha_final'], 8,2); 
        $fecha_fianl = $day_dos."-".$mes_dos."-".$year_dos;

        $fechaInicio=strtotime($fecha_inicial);
        $fechaFin=strtotime($fecha_fianl);

        if($post['op'] == 1){
            $id=$post['sitio'];
            $wh="id";
            $table="sitios";
            $sitio = $this->_season->GetSpecific($table,$wh,$id);
            $name_sitio = $sitio[0]['nombre'];
            $table="personal_campo";
            $result=$this->_sitio->asignacionpersonalasitioind($post,$table,$name_sitio,$fecha_inicial,$fecha_fianl);

            // for($i=$fechaInicio; $i<=$fechaFin; $i+=86400){
            //     $dias =  date("d-m-Y", $i);
            //     $table="personal_checkin";
            //     $id = $post['id_user'];
            //     $this->_personal->isertdaystocheckin($post,$table,$name_sitio,$id,$dias);
            // } 
        }

        if($post['op'] == 2){
            $name_sitio = "Compensacion";
            $sitio= 2222222;
            $table="personal_campo";
            $result = $this->_sitio->asignacionpersonalasitioindopcomp($post,$table,$name_sitio,$fecha_inicial,$fecha_fianl,$sitio);
        }

        if($post['op'] == 3){
            $name_sitio = "Taller";
            $sitio= 3333333;
            $table="personal_campo";
            $result = $this->_sitio->asignacionpersonalasitioindop($post,$table,$name_sitio,$fecha_inicial,$fecha_fianl,$sitio);
        }

        if($post['op'] == 4){
            $name_sitio = "Vacaciones";
            $sitio= 4444444;
            $table="personal_campo";
            $result = $this->_sitio->asignacionpersonalasitioindopvac($post,$table,$name_sitio,$fecha_inicial,$fecha_fianl,$sitio);
        }

        if($post['op'] == 5){
            $name_sitio = "Taller Foraneos";
            $sitio= 5555555;
            $table="personal_campo";
            $result = $this->_sitio->asignacionpersonalasitioindoptalfor($post,$table,$name_sitio,$fecha_inicial,$fecha_fianl,$sitio);
        }

        if ($result) {
            return $this-> _redirect('/personal/listapersonal');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 
    }

    public function requestliberarpersonalsitioAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost(); 
             
        foreach ($post['ids'] as $key) {                
            $table="personal_campo";
            $id = $key;
            $result = $this->_sitio->liberacionpersonalasitio($post,$table,$id);  
        }
        
        if ($result) {
            return $this-> _redirect('/personal/listapersonal');
        }else{
            print '<script language="JavaScript">'; 
            print 'alert("Ocurrio un error: Comprueba los datos.");'; 
            print '</script>'; 
        } 
    }


    public function requestasistenciaAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost(); 
        $day_num =  date('N', strtotime($post['day']));


            $name = $_FILES['url_entrada']['name'];
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            }else{
                $bytes = $_FILES['url_entrada']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['url_entrada']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/asistencia_personal/';
                    $urldb_entrada = $url1.$info1;
                    move_uploaded_file($_FILES['url_entrada']['tmp_name'],$urldb_entrada);
                }
            } // END  URLDB_ENTRADA

            $name = $_FILES['url_salida']['name'];
            if(empty($name)){ 
                print '<script language="JavaScript">'; 
                print 'alert("Agrega una imagen");'; 
                print '</script>'; 
            }else{
                $bytes = $_FILES['url_salida']['size'];
                $res = $this->formatSizeUnits($bytes);
                if($res == 0){ 
                    print '<script language="JavaScript">'; 
                    print 'alert("El pdf supera el maximo de tamaño");'; 
                    print '</script>'; 
                }else{
                    $info1 = new SplFileInfo($_FILES['url_salida']['name']);
                    $ext1 = $info1->getExtension();
                    $url1 = 'img/asistencia_personal/';
                    $urldb_salida = $url1.$info1;
                    move_uploaded_file($_FILES['url_salida']['tmp_name'],$urldb_salida);
                }
            } // END  URLDB_ENTRADA


            $year_dos = substr($post['day'], 0,4); 
            $mes_dos = substr($post['day'], 5,2); 
            $day_dos = substr($post['day'], 8,2); 
            $fecha_fianl = $day_dos."-".$mes_dos."-".$year_dos;

            $table="personal_asistencia";
            $result = $this->_nomina->insertnominaextra($table,$post,$day_num,$urldb_entrada,$urldb_salida,$fecha_fianl);

        if ($result) {
            return $this->_redirect('/asistencia/personalasistencia/id/'.$post['user'].'/sitio/'.$post['sitio'].'/proyecto/'.$post['id_proyecto'].'');
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
