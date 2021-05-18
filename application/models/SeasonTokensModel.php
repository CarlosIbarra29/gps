<?php

class Application_Model_SeasonTokensModel extends Zend_Db_Table_Abstract{

	// --------------------------------INSERTS

	public function insertToken($mail,$table,$tok){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'correo'=>$mail,
            	'token'=>$tok); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }//Insert

    //--------------------------------UPDATE
	
		public function refreshPass($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $encri = openssl_digest($post["pass"],"sha512");
            $qry = $db->query("UPDATE $table SET passw = ? WHERE correo = ?",
                array(
                    $encri,
                    $post['correo']));
            $db->closeConnection();               
            return $qry;
            
        } 
        catch (Exception $e) {
            echo $e;
        }
    }

	// --------------------------------GET

	public function GetAll($table){
		 try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table");
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
	}

    public function GetSpecific($table,$wh,$id){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table WHERE $wh = ?",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    // --------------------------------Login

    public function Validarcorreo($post){

        try {
            //var_dump($post);exit;
            $db = Zend_Db_Table::getDefaultAdapter();
            $valiu = $db->query("SELECT * FROM usuario WHERE correo = ?",
        array(
            $post["correo"]));       
        $row = $valiu->fetchAll();             
                    $db->closeConnection();               
                    return $row;
                    //var_dump($valiu);exit;
        } catch (Exception $e) {
            echo $e;
        }//end try and catch
    }//fin de validar

    public function Tokenvalidar($tok){

        try {
            
            $db = Zend_Db_Table::getDefaultAdapter();
            $valiu = $db->query("SELECT * FROM tokenusr WHERE token = ? ",
        	array(
        		$tok));       
        $row = $valiu->fetchAll();             
                    $db->closeConnection();               
                    return $row;
                    //var_dump($row);exit;
                    //var_dump($valiu);exit;
        } catch (Exception $e) {
            echo $e;
        }//end try and catch
    }//fin de validar

    // public function CarreoByToken($mail){

    //     try {
            
    //         $db = Zend_Db_Table::getDefaultAdapter();
    //         $valiu = $db->query("SELECT correo FROM tokenusr WHERE token = ? ",
    //         array(
    //             $mail));       
    //     $row = $valiu->fetchAll();             
    //                 $db->closeConnection();               
    //                 return $row;
    //                 //var_dump($row);exit;
    //                 //var_dump($valiu);exit;
    //     } catch (Exception $e) {
    //         echo $e;
    //     }//end try and catch
    // }//fin de validar

}