<?php
require '../functions/zend_functions.php';
class ShoppingController extends Zend_Controller_Action{ 

	private $_shopping;

	public function init(){
		$this->_shopping = zend_functions::Instance();
	}

	public function itemaddAction(){
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		
		if($this->getRequest()->getPost()){
			$post = $this->getRequest()->getPost();		
			$this->_shopping->setCookieProduct($post);
		}
	}

	public function itemsgetAction(){
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$array =  json_decode($this->_shopping->readCookieProduct());
		echo json_encode($array);
	}

	public function itemdeleteAction(){
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		if($this->getRequest()->getPost()){
			$post = $this->getRequest()->getPost();		
			$this->_shopping->deleteCookie($post["id"]);
		}
	}

	public function itemdeleteallAction(){
		$this->_helper->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);
		$this->_shopping->clearCookies();
		$this->redirect('/home/pedidostmp');
	}
}