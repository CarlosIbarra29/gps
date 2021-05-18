<?php

class ReforzamientoController extends Zend_Controller_Action{
	private $_season;
    private $_session;
    private $_user;

    public function init(){
        $this->_season = new Application_Model_SeasonPanelModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_user = new Application_Model_GpsUserModel;
        $this->_panel = new Application_Model_GpsPanelModel;
        $this->_sitio = new Application_Model_GpsSitioModel;
        $this->_project = new Application_Model_GpsProyectoModel;
        $this->_colo = new Application_Model_GpsColocacionModel;
        $this->_refo = new Application_Model_GpsReforzamientoModel;

        if(empty($this->_session->id)){
            $this->redirect('/home/login');
        } 
    }


    public function requestaddfiledocumentounoAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        date_default_timezone_set('America/Mexico_City');
        $hoy = date("d-m-Y H:i:s");

        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $usr = $this->_season->GetSpecific($table,$wh,$id);
        $id_user = $usr[0]['id'];
        $name_user = $usr[0]['nombre'] ." ". $usr[0]['ap'];

        // var_dump($post);exit;
        $name_sitio = $post['name_sitio'];
        $wh="id_sitiotipo";
        $id=$post['id_sitiotipo'];
        $table="doc_refozamiento";
        $detail_table= $this->_season->GetSpecific($table,$wh,$id);


        if (empty($detail_table)) {
            mkdir("pdf/sitios/reforzamiento/".$name_sitio.""); 
// var_dump($detail_table);exit;
            $table="doc_refozamiento";

            $this->_refo->inserdocreforzamiento($post,$table);
            $detail_table= $this->_season->GetSpecific($table,$wh,$id);
            $detalle_bts_insert = 0;

        }else{
            $detalle_bts_insert = 1;
        }


        if($this->getRequest()->getPost()){
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
                    $url1 = 'pdf/sitios/reforzamiento/'.$name_sitio.'/';
                    $urldb = $url1.$info1;
                    move_uploaded_file($_FILES['url']['tmp_name'],$urldb);
                }
            }



	        $id=$post['id_sitiotipo'];
	        $table="doc_refozamiento";
	        $detail_table = $this->_season->GetSpecific($table,$wh,$id);

	        if($post['opcion_file'] == 1){
	            $option ="levantamiento_file"; $fecha ="levantamiento_fecha"; $user ="levantamiento_user";
	            $status ="levantamiento_status";
	            $table="doc_refozamiento";
	        }

	        if($post['opcion_file'] == 2){
	            $option ="ingenieria_file"; $fecha ="ingenieria_fecha"; $user ="ingenieria_user";
	            $status ="ingenieria_status";
	            $table="doc_refozamiento";
	        }

	        if($post['opcion_file'] == 3){
	            $option ="catalogo_file"; $fecha ="catalogo_fecha"; $user ="catalogo_user"; 
	            $status ="catalogo_status";
	            $table="doc_refozamiento";
	        }
	        $id=$detail_table[0]['id'];
	        $result= $this->_refo->refresdocunoreforzamiento($id,$table,$option,$fecha,$user,$status,$post,$urldb,$hoy,$name_user);

            if ($result) {
                return $this-> _redirect('/panel/detallesreforzamiento/id/'.$post["id"].'/proyecto/'.$post["proyecto"].'/sitio/'.$post["id_sitiotipo"].'');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
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