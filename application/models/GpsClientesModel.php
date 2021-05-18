<?php

class Application_Model_GpsClientesModel extends Zend_Db_Table_Abstract{
    protected $_name = 'herramienta_inventario';
    protected $_primary = 'id_herramienta';


    public function Getpaginationclientes($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id, c.nombre_cliente, c.logo
                FROM clientes c
                order by id asc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function insertcliente($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_cliente'=>$post['name'],
                'logo'=>$urldb); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }   //  INSERT CLIENTES


    public function updatecliente($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre_cliente = ?, logo = ? WHERE id = ? ",
                array(
                    $post['name'],
                    $urldb,
                    $post['ids']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   // END UPDATE CLIENTE


    public function cltnombre($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM clientes WHERE nombre_cliente like '%{$nombre}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function clientescount($nombre,$offset,$no_of_records_per_page){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM clientes WHERE nombre_cliente like '%{$nombre}%' LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function GetCarpetasC($table,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT cc.id, cc.nombre_carpeta, cc.id_cliente, cc.idc
                FROM clientes_carpeta cc 
                WHERE cc.idc = 0 AND cc.id_cliente = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA Carpeta Principal


    public function Getpaginationarchivosclientes($table,$offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ca.id, ca.nombre_archivo, ca.archivo, ca.id_cliente, ca.id_carpeta, ca.fecha
                FROM clientes_archivos ca
                WHERE ca.id_carpeta = 0 AND ca.id_cliente = $id
                order by ca.id asc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function insertcarpeta($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_carpeta'=>$post['carpeta'],
                'id_cliente'=>$post['id_cliente']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }   //  INSERT CARPETA


    public function insertarchivo($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_archivo'=>$post['namedoc'],
                'id_cliente'=>$post['id_clientes'],
                'fecha'=>$post['fecha'],
                'archivo'=>$urldb); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }   //  INSERT ARCHIVO


    public function updatecarpeta($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre_carpeta = ? WHERE id = ? ",
                array(
                    $post['name'],
                    $post['idcarpeta']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   // END  REQUEST UPDATE CARPETA


    public function updatearchivo($post,$table,$urldb){
        // var_dump($post);
        // exit;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre_archivo = ?, archivo = ?, fecha = ? WHERE id = ? ",
                array(
                    $post['name'],
                    $urldb,
                    $post['fecha'],
                    $post['idarchivo']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   // END UPDATE ARCHIVO


    public function GetSCarpetas($table,$id,$clienteid){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT cc.id, cc.nombre_carpeta, cc.id_cliente, cc.idc
                FROM clientes_carpeta cc 
                WHERE cc.idc = ? AND cc.id_cliente = $clienteid",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA SubCarpetaEspecifiva

    public function GetSuCarpetas($table,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT cc.id, cc.nombre_carpeta
                FROM clientes_carpeta cc 
                WHERE cc.id = ? ",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA SubCarpetaEspecifiva


    public function Getpaginationarchivocarpeta($table,$offset,$no_of_records_per_page,$id,$clienteid){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ca.id, ca.nombre_archivo, ca.archivo, ca.id_cliente, ca.id_carpeta, ca.fecha
                FROM clientes_archivos ca
                WHERE ca.id_carpeta = $id AND ca.id_cliente = $clienteid
                order by ca.id asc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Arvhicos Especificos


    public function insertsubcarpeta($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_carpeta'=>$post['carpeta'],
                'idc'=>$post['idcarpeta'],
                'id_cliente'=>$post['id_cliente']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }   //  INSERT SUBCARPETA


    public function insertarchivosub($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_archivo'=>$post['namedoc'],
                'id_cliente'=>$post['id_clientes'],
                'id_carpeta'=>$post['idcarpetas'],
                'fecha'=>$post['fecha'],
                'archivo'=>$urldb); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }   //  INSERT ARCHIVO SUBCARPETA


    public function insertarchivosub2($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_archivo'=>$post['namedoc'],
                'id_cliente'=>$post['id_clientes'],
                'id_carpeta'=>$post['idsubcarpetas'],
                'fecha'=>$post['fecha'],
                'archivo'=>$urldb); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }   //  INSERT ARCHIVO SUBCARPETA
















	// public function insertherramienta($post,$table,$urldb,$urldb1,$status){
	// 	try {
	// 		$db = Zend_Db_Table::getDefaultAdapter();
	// 		$datasave = array(
	// 			'imagen'=>$urldb,
	// 			'id_cat_herramienta'=>$post['cat'],
	// 			'codigo'=>$post['cod'],
	// 			'nombre'=>$post['name'],
	// 			'marca'=>$post['marca'],
	// 			'modelo'=>$post['modelo'],
	// 			'no_serie'=>$post['serie'],
	// 			'unidad'=>$post['uni'],
	// 			'descripcion'=>$post['desc'],
	// 			'fecha_compra'=>$post['fcompra'],
	// 			'tiempo_vida'=>$post['vida'],
	// 			'factura_imagen'=>$urldb1,
	// 			'factura_numero'=>$post['factura_no'],
	// 			'vencimiento_gar'=>$post['vencimiento'],
	// 			'fecha_salida'=>$post['fecha_salida'],
	// 			'fecha_entrega'=>$post['fecha_entrega'],
	// 			'id_responsable'=>$post['responsable'],
	// 			'id_sitio'=>$post['sitio'],
	// 			'status_disponible'=>$status
	// 		); 
	// 		$res = $db->insert($table, $datasave);
	// 		$db->closeConnection();               
	// 		return $res;
	// 	} catch (Exception $e) {
	// 		echo $e;
	// 	}
    //    }


    //  INSERT Herramienta

    // public function insertherramienta($post,$table,$urldb,$urldb1,$status){
    //     try {
    //         $row = $this->createRow();
    //         $row->imagen = $urldb;
    //         $row->id_cat_herramienta = $post['cat'];
    //         $row->codigo = $post['cod'];
    //         $row->nombre = $post['name'];
    //         $row->marca = $post['marca'];
    //         $row->modelo = $post['modelo'];
    //         $row->no_serie = $post['serie'];
    //         $row->unidad = $post['uni'];
    //         $row->descripcion = $post['desc'];
    //         $row->fecha_compra = $post['fcompra'];
    //         $row->tiempo_vida = $post['vida'];
    //         $row->factura_imagen = $urldb1;
    //         $row->factura_numero = $post['factura_no'];
    //         $row->vencimiento_gar = $post['vencimiento'];
    //         $row->fecha_salida = $post['fecha_salida'];
    //         $row->fecha_entrega = $post['fecha_entrega'];
    //         $row->id_responsable = $post['responsable'];
    //         $row->id_sitio = $post['sitio'];
    //         $row->status_disponible = $status;
    //         $res = $row->save();              
    //         return $res;
    //     } catch (Exception $e) {
    //         echo $e;
    //     }


    // }   //  INSERT Herramienta 2


} 