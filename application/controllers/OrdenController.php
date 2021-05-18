<?php

class OrdenController extends Zend_Controller_Action{

	private $_session;
	private $_orden;
    private $_season;
    public function init(){

    	$layout = $this->_helper->layout();
        $layout->setLayout('layout-home');
        $this->_orden = new Application_Model_SeasonOrdenModel;
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_season = new Application_Model_SeasonPanelModel;
    }

    public function indexAction(){

        if(empty($this->_session->id)){
             $this->redirect('/home/info');
        }//
        if (!isset($_COOKIE["idorden"])) {
            $id=$this->_session->id;
            $wh="id";
            $table="usuario";
            $this->view->direccion = $this->_orden->getDireccionByUser($id);
        }else{
            return $this-> _redirect('/home/pedidospendientes');
        }
        

    }//index

    //-------------------------------------------REQUEST ADD

    public function requestordenaddAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();

        if($this->getRequest()->getPost()){          
            $id=$this->_session->id;
            $table="orden";
            $result1 = $this->_orden->insertOrden($table,$id,$post);
            $idorden= $result1;
            $table='pedidosdireccion';
            $result = $this->_orden->insertPedidosDire($table,$id,$post,$idorden);
            if ($result) {
                return $this-> _redirect('/home/pedidospendientes');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }//request orden

    //---------------------------------------------Update

    public function refreshUsr($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET iscomplete = ?  WHERE id = ?",array(
                $post['iscomplete'],
                $post["ids"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }
}