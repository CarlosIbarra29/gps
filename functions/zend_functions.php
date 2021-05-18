<?php

class zend_functions{

	public static function Instance(){
		try {
			static $inst = null;
			if ($inst === null ) {
				$inst = new zend_functions();
			}
			return $inst;
		} catch (Exception $e) {
			
		}
	}

	public function setCookieID($id,$name){
		setcookie("idPanel",json_encode([$id,$name]),strtotime( '+30 days' ), "/"); //expirar la cookie ? 
	}

	public function setCookieProduct($data_array, $is_unset = false){
		$tmp_array = null;
		$current = ($this->readCookieProduct() != null ) ? $this->readCookieProduct() :  null ;
		if($current != null){
			# 2 - When the values exist
			$parsed_array = json_decode($current); // parsed the array [array(0)]
			$result = $this->validateCookie($parsed_array,$data_array); //When the user add the same product if not success the the array is the same
			
			if($result[1]){
				$parsed_array = array();//clean the array 
				$parsed_array = $result[0]; //add the values again NOT pushing
			} else {
				$parsed_array[] = $data_array; // push the array [array(0),array(1)]	
			}

			$tmp_array = $parsed_array; //Set in the var
			/* echo "\nResult from parsed_array ----------------------- \n"; var_dump($parsed_array); echo "\nResult from validate cookie ----------------------- \n"; var_dump($result[0]); */
		}else {
			# 1- The first time is nothing to add
			$tmp_array[] = $data_array;
		}
		if (!$is_unset) {
			setcookie("idProducts",json_encode($tmp_array),strtotime( '+30 days' ),"/"); //expirar la cookie ? 			
		}else{
			setcookie("idProducts",json_encode($data_array),strtotime( '+30 days' ),"/");  		
		}

		# return $tmp_array; //just debug
	}

	public function readCookieProduct(){
		$cookie = (isset($_COOKIE["idProducts"])) ? $_COOKIE["idProducts"] : null;
		return $cookie;
	}

	public function readCookieID(){
		$cookie = (isset($_COOKIE["idPanel"])) ? $_COOKIE["idPanel"] : null;
		return $cookie;
	}

    public function validateCookie($cookie, $cur_array){
        //This will call from on the click button
        //var_dump($cookie);
        $is_duplicate = false;
        foreach ($cookie as $key => $value) {
            if($value->id == $cur_array["id"]){ //Se convierte en objeto por el parsed ?
                $cookie[$key]->quantity = ($value->quantity + $cur_array["quantity"]);
                $is_duplicate = true;
            }
        }
        return [$cookie,$is_duplicate];
    }

    public function deleteCookie($index){
    	$current = ($this->readCookieProduct() != null ) ? $this->readCookieProduct() :  null ;
    	$parsed_array = json_decode($current);
        array_splice($parsed_array,$index,1); //re array the cookie 
		$this->setCookieProduct($parsed_array,true);
        //return $parsed_array;
    }

	public function clearCookies(){
		//unset($_COOKIE["idPanel"]);
		//unset($_COOKIE["idProducts"]);

		if (isset($_SERVER['HTTP_COOKIE'])) {
    		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    		foreach($cookies as $cookie) {
        		$parts = explode('=', $cookie);
        		$name = trim($parts[0]);
        		setcookie($name, '', time()-1000);
        		setcookie($name, '', time()-1000, '/');
    		}
		}		
		return true;
	}
}