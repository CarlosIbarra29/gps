<?php
require '../functions/zend_functions.php';
class HomeController extends Zend_Controller_Action{

	private $_session;
    private $_season;
    private $_usr;
    private $_reco;
    // private $_pro;

    public function init(){
        $layout = $this->_helper->layout();
        $layout->setLayout('layout-home');
        $this->_session = new Zend_Session_Namespace("current_session");
        $this->_season = new Application_Model_SeasonTokensModel;
        $this->_usr = new Application_Model_SeasonPanelModel;
        // $this->_reco = new Application_Model_SeasonRecomendacionModel;
        // $this->_pro = new Application_Model_SeasonProductoModel;
    }//init

    public function indexAction(){
        $table="recomendacion";
        // $this->view->recomendation = $this->_reco->GetAll($table);

    }//indexAction


    // public function productsAction(){
    // 	$table="producto";
    //     $this->view->product = $this->_reco->GetAll($table);
    //     $table="recomendacion";
    //     $this->view->recomendation = $this->_reco->GetAll($table);
    // }//productsAction

    // public function detalleproductoAction(){
    //     $table1="recomendacion";
    //     $this->view->recomendation = $this->_reco->GetAll($table1);
    //     if($this->_hasParam('id')){
    //         $id = $this->_getParam('id');
    //         $table="producto";
    //         $wh="id";
    //         $this->view->productos = $this->_reco->GetSpecific($table,$wh,$id);
    //     }else {
    //         return $this-> _redirect('/');
    //     }
        
    // }//detalle producto


    public function recuperarcontrasenaAction(){
        
    }

    public function infoAction(){
        
    }

    public function comprarAction(){
        
    }

    public function contactoAction(){
        
    }

    public function successpassAction(){
        
    }

    public function cambiocontrasenaAction(){
        if(empty($this->_session->id)){
            $this->redirect('/home');
        }
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $this->view->usuario = $this->_usr->GetSpecific($table,$wh,$id);
    }

     public function nuevacontrasenaAction(){
         if($this->_hasParam('token')){
            $tokn =  $this->_getParam('token');
            $table="tokenusr";
            $tokens = $this->_season->Tokenvalidar($tokn);
            $this->view->correo = $tokens;
            if (!$tokens) {
                header("Location: /");
            }
        }else{
            echo "No disponible";
        }
    }

    public function perfilusuarioAction(){
        if(empty($this->_session->id)){
            $this->redirect('/home');
        }
        
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $this->view->usuario = $this->_usr->GetSpecific($table,$wh,$id);
    }//perfilusuarioAction

    public function editarperfilAction(){
    	if(empty($this->_session->id)){
            $this->redirect('/home');
        }
        $id=$this->_session->id;
        $wh="id";
        $table="usuario";
        $this->view->usuario = $this->_usr->GetSpecific($table,$wh,$id);
    }//editarperfilAction



    public function registroAction(){
    	
    }//registroAction

    public function loginAction(){
    	
    }//loginAction

    public function loginerrorAction(){
        
    }//loginAction

    public function successAction(){
        
    }//SUCCESS ACTION

    // -------------------------------REQUEST ADD


    // -------------------------------REQUEST UDATE

    public function requestupdateuserAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="usuario";
            $result = $this->_usr->refreshUsr($post,$table);
            if ($result) {
                return $this-> _redirect('/panel/usuarios');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestupdateusersessionAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $id=$this->_session->id;
            $wh='id';
            $table='usuario';
            $result = $this->_usr->UpdateUsrSession($post,$table,$wh,$id);
            if ($result) {
                return $this-> _redirect('/home/perfilusuario');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Comprueba los datos.");'; 
                print '</script>'; 
            }
        }
    }

    public function requestrefreshpassAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $wh='id';
            $table='usuario';
            $result = $this->_usr->UpdateUsrPassw($post,$table,$wh);
            if ($result) {
                return $this-> _redirect('/home/perfilusuario');
            }else{
                print '<script language="JavaScript">'; 
                print 'alert("Ocurrio un error: Sin acceso.");'; 
                print '</script>'; 
            }
        }
    }//Joel


    public function requestupdateuserpassAction(){
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $post = $this->getRequest()->getPost();
        if($this->getRequest()->getPost()){
            $table="usuario";
            $result = $this->_season->refreshPass($post,$table);
            //var_dump($post);exit;
            if ($result) {
                return $this-> _redirect('/home/login');
            }else{
               print '<script language="JavaScript">'; 
               print 'alert("Ocurrio un error: Comprueba los datos.");'; 
               print '</script>'; 
           }
       }
    }//Jos




    // -------------------------------REQUEST DELETE

    public function requestdeleteuserAction(){
    	$this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->_hasParam('id')){
            $id =  $this->_getParam('id');
            $table="usuario";
            $wh="id";
            $result = $this->_season->deleteAll($id,$table,$wh);
            if ($result) {
                return $this-> _redirect('/panel/usuarios');
            }
        } else {
            return $this-> _redirect('/panel');
        }
    }

}

