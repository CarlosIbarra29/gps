<?php

class Application_Model_GpsHerramientaModel extends Zend_Db_Table_Abstract{
    protected $_name = 'herramienta_inventario';
    protected $_primary = 'id_herramienta';

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

    public function insertherramienta($post,$table,$urldb,$urldb1,$status){
        try {
            $row = $this->createRow();
            $row->imagen = $urldb;
            $row->id_cat_herramienta = $post['cat'];
            $row->codigo = $post['cod'];
            $row->nombre = $post['name'];
            $row->marca = $post['marca'];
            $row->modelo = $post['modelo'];
            $row->no_serie = $post['serie'];
            $row->unidad = $post['uni'];
            $row->descripcion = $post['desc'];
            $row->fecha_compra = $post['fcompra'];
            $row->tiempo_vida = $post['vida'];
            $row->factura_imagen = $urldb1;
            $row->factura_numero = $post['factura_no'];
            $row->vencimiento_gar = $post['vencimiento'];
            $row->fecha_salida = $post['fecha_salida'];
            $row->fecha_entrega = $post['fecha_entrega'];
            $row->id_responsable = $post['responsable'];
            $row->id_sitio = $post['sitio'];
            $row->status_disponible = $status;
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }   //  INSERT Herramienta

    public function updateherramienta($post,$table,$urldb,$urldb1){
        // var_dump($post);
        // exit;
    	try {
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("UPDATE $table SET imagen = ?, id_cat_herramienta = ?, codigo = ?, nombre = ?, marca = ?, modelo = ?, no_serie = ?, unidad = ?, descripcion = ?, fecha_compra = ?, tiempo_vida = ?, factura_imagen = ?, factura_numero = ?, vencimiento_gar = ?, fecha_salida = ?, fecha_entrega = ?, id_responsable = ?, id_sitio = ? WHERE id_herramienta = ? ",
    			array(
    				$urldb,
    				$post['cat'],
    				$post['cod'],
    				$post['name'],
    				$post['marca'],
    				$post['modelo'],
    				$post['serie'],
    				$post['uni'],
    				$post['desc'],
    				$post['fcompra'],
    				$post['vida'],
    				$urldb1,
    				$post['factura_no'],
    				$post['vencimiento'],
    				$post['fecha_salida'],
    				$post['fecha_entrega'],
    				$post['responsable'],
    				$post['sitio'],
    				$post['ids']));
    		$db->closeConnection();               
    		return $qry;
    	} 
    	catch (Exception $e) {
    		echo $e;
    	}
    }// END UPDATE herramienta

    public function hercodigo($codigo){
    	try{
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("SELECT * FROM herramienta_inventario WHERE codigo like '%{$codigo}%'");
    		$row = $qry->fetchAll();
    		return $row;
    		$db->closeConnection();
    	}catch (Exception $e){
    		echo $e;
    	}
    }

    public function hercodcount($codigo,$offset,$no_of_records_per_page){ 
    	try{
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("SELECT h.id_herramienta, h.codigo, h.nombre, h.unidad, h.descripcion, h.imagen, h.status_disponible, h.fecha_salida, h.fecha_entrega, h.id_responsable, h.id_cat_herramienta, h.id_sitio, h.tiempo_vida, h.factura_imagen, h.fecha_compra, h.vencimiento_gar, h.marca, h.modelo, h.no_serie, h.factura_numero, p.id, IF(p.nombre is null, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma 
    			FROM herramienta_inventario h 
    			LEFT JOIN personal_campo p on p.id= h.id_responsable  
    			WHERE codigo like '%{$codigo}%' LIMIT $offset,$no_of_records_per_page");
    		$row = $qry->fetchAll();
    		return $row;
    		$db->closeConnection();
    	}catch (Exception $e){
    		echo $e;
    	}
    }

    public function npersonal($nombre){
    	try{
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("SELECT p.nombre, h.id_responsable FROM personal_campo p
                                LEFT JOIN herramienta_inventario h on h.id_responsable = p.id 
                                WHERE p.nombre like '%{$nombre}%'");
    		$row = $qry->fetchAll();
    		return $row;
    		$db->closeConnection();
    	}catch (Exception $e){
    		echo $e;
    	}
    }



    public function nombrehercount($nombre,$offset,$no_of_records_per_page){  
    	try{
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("SELECT h.id_herramienta, h.codigo, h.nombre, h.unidad, h.descripcion, h.imagen, h.status_disponible, h.fecha_salida, h.fecha_entrega, h.id_responsable, h.id_cat_herramienta, h.id_sitio, h.tiempo_vida, h.factura_imagen, h.fecha_compra, h.vencimiento_gar, h.marca, h.modelo, h.no_serie, h.factura_numero, p.id, IF(p.nombre is null, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma 
    			FROM herramienta_inventario h 
    			LEFT JOIN personal_campo p on p.id= h.id_responsable 
    			WHERE p.nombre like '%{$nombre}%' 
    			LIMIT $offset,$no_of_records_per_page");
    		$row = $qry->fetchAll();
    		return $row;
    		$db->closeConnection();
    	}catch (Exception $e){
    		echo $e;
    	}
    } 

    public function statusher($status){
    	try{
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("SELECT * FROM herramienta_inventario WHERE status_disponible = ?",array($status));
    		$row = $qry->fetchAll();
    		return $row;
    		$db->closeConnection();
    	}catch (Exception $e){
    		echo $e;
    	}
    }


     public function catsher($categoria){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM herramienta_inventario WHERE id_cat_herramienta = ?",array($categoria));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function statushercount($status,$offset,$no_of_records_per_page){
    	try{
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("SELECT h.id_herramienta, h.codigo, h.nombre, h.unidad, h.descripcion, h.imagen, h.status_disponible, h.fecha_salida, h.fecha_entrega, h.id_responsable, h.id_cat_herramienta, h.id_sitio, h.tiempo_vida, h.factura_imagen, h.fecha_compra, h.vencimiento_gar, h.marca, h.modelo, h.no_serie, h.factura_numero, p.id, IF(p.nombre is null, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma 
    			FROM herramienta_inventario h 
    			LEFT JOIN personal_campo p on p.id= h.id_responsable 
    			WHERE h.status_disponible = ? LIMIT $offset,$no_of_records_per_page",array($status));
    		$row = $qry->fetchAll();
    		return $row;
    		$db->closeConnection();
    	}catch (Exception $e){
    		echo $e;
    	}
    }


    public function cathercount($categoria,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT h.id_herramienta, h.codigo, h.nombre, h.unidad, h.descripcion, h.imagen, h.status_disponible, h.fecha_salida, h.fecha_entrega, h.id_responsable, h.id_cat_herramienta, h.id_sitio, h.tiempo_vida, h.factura_imagen, h.fecha_compra, h.vencimiento_gar, h.marca, h.modelo, h.no_serie, h.factura_numero, p.id, IF(p.nombre is null, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma 
                FROM herramienta_inventario h 
                LEFT JOIN personal_campo p on p.id= h.id_responsable 
                WHERE h.id_cat_herramienta = ? LIMIT $offset,$no_of_records_per_page",array($categoria));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function hernherr($nherr){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM herramienta_inventario WHERE nombre like '%{$nherr}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function herncount($nherr,$offset,$no_of_records_per_page){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT h.id_herramienta, h.codigo, h.nombre, h.unidad, h.descripcion, h.imagen, h.status_disponible, h.fecha_salida, h.fecha_entrega, h.id_responsable, h.id_cat_herramienta, h.id_sitio, h.tiempo_vida, h.factura_imagen, h.fecha_compra, h.vencimiento_gar, h.marca, h.modelo, h.no_serie, h.factura_numero, p.id, IF(p.nombre is null, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma 
                FROM herramienta_inventario h 
                LEFT JOIN personal_campo p on p.id= h.id_responsable  
                WHERE h.nombre like '%{$nherr}%' LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function idherramienta($htaid){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM herramienta_inventario WHERE id_herramienta = ?",array($htaid));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function idhercount($htaid,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT h.id_herramienta, h.codigo, h.nombre, h.unidad, h.descripcion, h.imagen, h.status_disponible, h.fecha_salida, h.fecha_entrega, h.id_responsable, h.id_cat_herramienta, h.id_sitio, h.tiempo_vida, h.factura_imagen, h.fecha_compra, h.vencimiento_gar, h.marca, h.modelo, h.no_serie, h.factura_numero, p.id, IF(p.nombre is null, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma 
                FROM herramienta_inventario h 
                LEFT JOIN personal_campo p on p.id= h.id_responsable 
                WHERE h.id_herramienta = ? LIMIT $offset,$no_of_records_per_page",array($htaid));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function insertcat($post,$table,$urldb){
    	try {
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$datasave = array(
    			'nombre'=>$post['name'],
    			'imagen'=>$urldb); 
    		$res = $db->insert($table, $datasave);
    		$db->closeConnection();               
    		return $res;
    	} catch (Exception $e) {
    		echo $e;
    	}
    }//  INSERT cat


    public function updatecategoria($post,$table,$urldb){
        // var_dump($post);
        // exit;
    	try {
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("UPDATE $table SET nombre = ?, imagen = ? WHERE id_cat = ? ",
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
    }// END UPDATE CAT

    public function Getpaginationcat($table,$offset,$no_of_records_per_page){
    	try{
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("SELECT c.id_cat, c.nombre, c.imagen
    			FROM categoria_herramienta c
    			order by id_cat asc LIMIT $offset,$no_of_records_per_page");
    		$row = $qry->fetchAll();
    		return $row;
    		$db->closeConnection();
    	}catch (Exception $e){
    		echo $e;
    	}
    }

    public function Getpaginationinventario($table,$offset,$no_of_records_per_page){
    	try{
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("SELECT h.id_herramienta, h.codigo, h.nombre, h.unidad, h.descripcion, h.imagen, h.status_disponible, h.fecha_salida, h.fecha_entrega, h.id_responsable, h.id_cat_herramienta, h.id_sitio, h.tiempo_vida, h.factura_imagen, h.fecha_compra, h.vencimiento_gar, h.marca, h.modelo, h.no_serie, h.factura_numero, h.comentario_b, h.evidencia_b, p.id, IF(p.nombre is null, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma
    			from herramienta_inventario h
    			LEFT JOIN personal_campo p on p.id= h.id_responsable ORDER BY h.nombre ASC
    			LIMIT $offset,$no_of_records_per_page");
    		$row = $qry->fetchAll();
    		return $row;
    		$db->closeConnection();
    	}catch (Exception $e){
    		echo $e;
    	}
    }


// SELECT h.id_herramienta, h.codigo, h.nombre, h.unidad, h.descripcion, h.imagen,
//                 h.status_disponible, h.fecha_salida, h.fecha_entrega, h.id_responsable, 
//                 h.id_cat_herramienta, h.id_sitio, h.tiempo_vida, h.factura_imagen, h.fecha_compra,
//                 h.vencimiento_gar, h.marca, h.modelo, h.no_serie, h.factura_numero,h.comentario_b, h.evidencia_b,
//                 ch.nombre AS categoria,
//                 st.residente, st.id_sitio,
//                 IF(s.nombre is NULL, 'Sin Sitio', s.nombre) AS sition,
//                 IF(p.nombre is null, 'Sin Asignar', p.nombre) AS nombrea,
//                 p.apellido_pa, p.apellido_ma
//                 FROM herramienta_inventario h
//                 LEFT JOIN categoria_herramienta ch ON h.id_cat_herramienta = ch.id_cat
//                 LEFT JOIN personal_campo p ON h.id_responsable = p.id 
//                 LEFT JOIN sitios_tipoproyecto st ON st.residente = p.id  and st.residente = h.id_responsable 
//                 LEFT JOIN sitios s ON s.id = st.id_sitio


    public function Getdatos($wh,$id){
    	try {
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("SELECT h.id_herramienta, h.codigo, h.nombre, h.unidad, h.descripcion, h.imagen,
    			h.status_disponible, h.fecha_salida, h.fecha_entrega, h.id_responsable, 
    			h.id_cat_herramienta, h.id_sitio, h.tiempo_vida, h.factura_imagen, h.fecha_compra,
    			h.vencimiento_gar, h.marca, h.modelo, h.no_serie, h.factura_numero,h.comentario_b, 
                h.evidencia_b, h.ultimo_r, ch.nombre AS categoria,  
    			IF(s.nombre is NULL, 'Sin Sitio', s.nombre) AS sitio_h,
    			IF(sit.nombre is NULL, 'Sin Sitio', sit.nombre) AS sitio,
                IF(p.nombre is null, 'Sin Asignar', p.nombre) AS nombrea,
    			p.apellido_pa, p.apellido_ma, p.id_sitiopersonal,

                IF(pu.nombre is null, 'Sin Asignar', pu.nombre) AS nombreu,
                pu.apellido_pa as apa, pu.apellido_ma as ama

    			FROM herramienta_inventario h
    			LEFT JOIN categoria_herramienta ch ON h.id_cat_herramienta = ch.id_cat
    			LEFT JOIN sitios s ON h.id_sitio = s.id 
    			LEFT JOIN personal_campo p ON h.id_responsable = p.id
                LEFT JOIN personal_campo pu ON h.ultimo_r = pu.id
                LEFT JOIN sitios sit ON p.id_sitiopersonal = sit.id 
    			WHERE $wh = ?",array($id));
    		$row = $qry->fetchAll();
    		$db->closeConnection();
    		return $row;
    	} catch (Exception $e) {
    		echo $e;
    	}
    }

    public function Getdatos_p($table,$id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT p.id, p.nombre, p.apellido_pa, p.apellido_ma, p.imagen, 
                p.puesto, p.id_sitiopersonal, pp.id as id_puesto, pp.nombre as puestop,
                s.id, IF(s.nombre is NULL, 'Sin Sitio', s.nombre) AS sitio
                FROM personal_campo p
                LEFT JOIN puestos_personal pp ON p.puesto = pp.id
                LEFT JOIN sitios s ON p.id_sitiopersonal = s.id
                WHERE p.id = ?",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }


    public function Getcontadorh($id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT count(id_responsable) as Asignadas
                from herramienta_inventario
                WHERE id_responsable = ?",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function Getherramientasa($id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT h.id_herramienta, h.codigo, h.nombre, h.unidad, h.descripcion, h.imagen,
                h.status_disponible, h.fecha_salida, h.fecha_entrega, h.id_responsable, 
                h.id_cat_herramienta, h.id_sitio, h.tiempo_vida, h.factura_imagen, h.fecha_compra,
                h.vencimiento_gar, h.marca, h.modelo, h.no_serie, h.factura_numero,h.comentario_b, h.evidencia_b,
                IF(p.nombre is null, 'Sin Asignar', p.nombre) AS nombrea,
                p.apellido_pa, p.apellido_ma, p.id
                FROM herramienta_inventario h
                LEFT JOIN personal_campo p ON h.id_responsable = p.id 
                WHERE h.id_responsable = ? and h.status_disponible = 1",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }   


    public function Getcobro($id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id_herramienta, c.id_personal, c.status_cobro, c.fecha, h.id_herramienta,
                h.codigo, h.nombre, h.unidad, h.descripcion, h.imagen, h.status_disponible, h.fecha_salida, h.fecha_entrega, 
                h.id_responsable, h.marca, h.modelo, IF(p.nombre IS NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, 
                p.apellido_ma, p.id, p.telefono, p.email_personal, pu.nombre as puesto
                FROM cobro_herramientas c
                LEFT JOIN herramienta_inventario h ON c.id_herramienta = h.id_herramienta
                LEFT JOIN personal_campo p ON c.id_personal = p.id 
                LEFT JOIN puestos_personal pu ON p.puesto = pu.id
                WHERE c.id_personal = ? and c.status_cobro = 1",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }  

    public function Getcontadorcobro($id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT count(id_personal) as Cobradas
                from cobro_herramientas
                WHERE id_personal = ? and status_cobro = 1",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function Getherramientasres($id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT h.id_herramienta, h.codigo, h.nombre, h.unidad, h.descripcion, h.imagen,
                h.status_disponible, h.fecha_salida, h.fecha_entrega, h.id_responsable, 
                h.id_cat_herramienta, h.id_sitio, h.tiempo_vida, h.factura_imagen, h.fecha_compra,
                h.vencimiento_gar, h.marca, h.modelo, h.no_serie, h.factura_numero,h.comentario_b, h.evidencia_b,
                IF(p.nombre is null, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma, 
                p.id, p.name_sitio, p.telefono, p.email_personal,  pu.nombre as pueston
                FROM herramienta_inventario h
                LEFT JOIN personal_campo p ON h.id_responsable = p.id 
                LEFT JOIN puestos_personal pu ON  p.puesto = pu.id
                WHERE h.id_responsable = ?",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    } // Get Datos Responsiva

    public function Getherramientasresp($id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT h.id_herramienta as ID, h.codigo as Código, h.nombre as Herramienta
                FROM herramienta_inventario h
                LEFT JOIN personal_campo p ON h.id_responsable = p.id 
                WHERE h.id_responsable = ? ORDER BY h.codigo desc " ,array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    } // Get Datos Responsiva

    public function Getfecha($wh,$id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT date(created_at) as fecha
                FROM herramienta_inventario 
                WHERE $wh = ?",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

     public function GetSolicitudesReparacion($table){
        $statusas = 0;
        $servicio= 29;

        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT so.id, so.total, so.condiciones_compra, so.referencia, so.descripcion, so.name_user, so.servicio_id,
                so.comentario, so.name_proveedor, so.status_asignada, so.status_pago
                FROM solicitud_ordencompra so
                WHERE  so.servicio_id = $servicio and so.status_asignada = $statusas and so.status_pago = 1;");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA DOCUMENTACION VEHICULOS

    public function Getreparacion($id){
    	try {
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("SELECT r.id_reporte,r.motivo,r.orden_compra,r.fecha_inicio, r.costo,
                IF(r.fecha_regreso IS NULL,'Aún no se repara',r.fecha_regreso) AS fechaa,
                r.id_herramienta, r.id_solicitud, h.id_herramienta as id_h, h.codigo, so.id, so.total, ps.id as idpago,
                ps.fecha_pago, ps.file_pago, ps.monto
                FROM reportes_reparacion r
                LEFT JOIN herramienta_inventario h ON r.id_herramienta = h.id_herramienta
                LEFT JOIN solicitud_ordencompra so ON r.id_solicitud = so.id
                LEFT JOIN pagos_solicitud ps ON so.id = ps.id_solicitud
    			WHERE r.id_herramienta = ?",array($id));
    		$row = $qry->fetchAll();
    		$db->closeConnection();
    		return $row;
    	} catch (Exception $e) {
    		echo $e;
    	}
    }

    public function Getnrep($id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT count(id_herramienta) as Reparaciones
                from reportes_reparacion
                WHERE id_herramienta = ?",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function updatereporte($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET motivo = ?, orden_compra = ?, fecha_inicio = ?, costo = ? WHERE id_reporte = ? ",
                array(
                    $post['name'],
                    $urldb,
                    $post['fecha'],
                    $post['costo'],
                    $post['ids']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE Reporte

    public function reparacionexcel($id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT r.id_reporte,r.motivo,r.orden_compra,r.fecha_inicio, r.costo,
                IF(r.fecha_regreso IS NULL,'Aún no se repara',r.fecha_regreso) AS fechaa, h.nombre,
                r.id_herramienta, r.id_solicitud, h.id_herramienta as id_h, h.codigo, so.id, so.total, ps.id as idpago,
                ps.fecha_pago, ps.file_pago, ps.monto
                FROM reportes_reparacion r
                LEFT JOIN herramienta_inventario h ON r.id_herramienta = h.id_herramienta
                LEFT JOIN solicitud_ordencompra so ON r.id_solicitud = so.id
                LEFT JOIN pagos_solicitud ps ON so.id = ps.id_solicitud
                WHERE r.id_herramienta = ?",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }


    public function reparaexcel(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT r.id_reporte,r.motivo,r.orden_compra,r.fecha_inicio, r.costo,
                IF(r.fecha_regreso IS NULL,'Aun no se regresa',r.fecha_regreso) AS fechaa,
                r.id_herramienta, h.id_herramienta as id_h, h.codigo, h.id_cat_herramienta, h.nombre, ct.nombre as nombrecategoria
                FROM reportes_reparacion r
                LEFT JOIN herramienta_inventario h ON r.id_herramienta = h.id_herramienta
                LEFT JOIN categoria_herramienta ct ON h.id_cat_herramienta = ct.id_cat ");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function catnombre($nombre){
    	try{
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("SELECT * FROM categoria_herramienta WHERE nombre like '%{$nombre}%'");
    		$row = $qry->fetchAll();
    		return $row;
    		$db->closeConnection();
    	}catch (Exception $e){
    		echo $e;
    	}
    }

    public function catcount($nombre,$offset,$no_of_records_per_page){ 
    	try{
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("SELECT * FROM categoria_herramienta WHERE nombre like '%{$nombre}%' LIMIT $offset,$no_of_records_per_page");
    		$row = $qry->fetchAll();
    		return $row;
    		$db->closeConnection();
    	}catch (Exception $e){
    		echo $e;
    	}
    }

    public function herramientasexcel(){  
    	try{
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("SELECT h.id_herramienta, h.codigo, h.nombre, h.unidad, h.descripcion, 
    			h.imagen, IF(h.status_disponible != 2, IF(h.status_disponible != 1, 
                IF(h.status_disponible = 0, 'Disponible', 'Baja'), 'Ocupado'),'Reparacion') AS nstatus,
                h.status_disponible, h.fecha_salida, h.fecha_entrega, h.id_responsable,
    			h.id_cat_herramienta, h.id_sitio, h.tiempo_vida, h.factura_imagen, h.fecha_compra, 
    			h.vencimiento_gar, h.marca, h.modelo, h.no_serie, h.factura_numero, h.comentario_b, h.evidencia_b, p.id, 
    			IF(p.nombre is NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma, p.id_sitiopersonal,
    			IF(s.nombre is NULL, 'Sin Sitio', s.nombre) AS sitio_h,
                IF(sit.nombre is NULL, 'Sin Sitio', sit.nombre) AS sitio
    			
                FROM herramienta_inventario h
    			LEFT JOIN personal_campo p ON p.id= h.id_responsable
    			LEFT JOIN sitios s ON h.id_sitio = s.id
                LEFT JOIN sitios sit ON p.id_sitiopersonal = sit.id");
    		$row = $qry->fetchAll();
    		return $row;
    		$db->closeConnection();
    	}catch (Exception $e){
    		echo $e;
    	}
    } 

    public function UpdateStatusHer($post,$table,$hoy){
    	$status=1;
    	try {
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("UPDATE $table SET id_responsable = ? , status_disponible = ?, fecha_salida = ? WHERE id_herramienta = ?",array(
    			$post['responsable'],
    			$status,
                $hoy,
    			$post["id"]));
    		$db->closeConnection();               
    		return $qry;
    	} 
    	catch (Exception $e) {
    		echo $e;
    	}
    }	//  Update Status Regresar Herramienta


    public function UpdateStatusHer1($post,$table){
    	$status=0;
    	$responsable=0;
        $sitio=0;
    	try {
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("UPDATE $table SET id_responsable = ? , status_disponible = ?, id_sitio = ? WHERE id_herramienta = ?",array(
    			$responsable,
    			$status,
                $sitio,
    			$post["id"]));
    		$db->closeConnection();               
    		return $qry;
    	} 
    	catch (Exception $e) {
    		echo $e;
    	}
    }	//  Update Status Regresar Herramienta  

    public function UpdateStatusHer2($post,$table){
        $status=0;
        $responsable=0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_responsable = ? , status_disponible = ? WHERE id_herramienta = ?",array(
                $responsable,
                $status,
                $post));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  Update Status Regresar Herramienta  

    public function UpdateStatusHer3($post,$table){
        $status=0;
        $responsable=0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_responsable = ? , status_disponible = ? WHERE id_herramienta = ?",array(
                $responsable,
                $status,
                $post));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  Update Status Regresar Herramienta 

    public function insertreporterep($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'motivo'=>$post['motivo'],
                'costo'=>$post['costo'],
                'orden_compra'=>$urldb,
                'fecha_inicio'=>$post['fecha'],
                'id_herramienta'=>$post['idhs']
            );
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT reporte de reparacion

    public function Updatefecha($post,$table,$hoy){
        $status=1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  fecha_regreso = ?, id_solicitud = ?, status_rep = ? WHERE id_herramienta = ? and status_rep = 0",array(
                $hoy,
                $post["solicitud"],
                $status,
                $post["idhss"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  actualizar fecha

    public function Updatesolicitudasg($post,$table){
        $status=1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  status_asignada = ? WHERE id = ? ",array(
                $status,
                $post["solicitud"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  actualizar fecha


    public function UpdateStatusHerRep($post,$table,$personal){
    	$status=2;
        $asigna=0;
    	try {
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("UPDATE $table SET id_responsable = ?, ultimo_r = ?, status_disponible = ? WHERE id_herramienta = ?",array(
    			$asigna,
                $personal,
                $status,
    			$post["idhs"]));
    		$db->closeConnection();               
    		return $qry;
    	} 
    	catch (Exception $e) {
    		echo $e;
    	}
    }	//  Update Status Reparar Herramienta

    public function UpdateStatusHerR($post,$table){
    	$status=0;
    	$responsable=0;
    	$comentario="";
    	$evidencia="";
        $sitio=0;
    	try {
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("UPDATE $table SET id_sitio = ?, id_responsable = ? , status_disponible = ? , comentario_b = ? , evidencia_b = ? WHERE id_herramienta = ?",array(
                $sitio,
    			$responsable,
    			$status,
    			$comentario,
    			$evidencia,
    			$post["idhss"]));
    		$db->closeConnection();               
    		return $qry;
    	} 
    	catch (Exception $e) {
    		echo $e;
    	}
    }	//  Update Status Regresar Herramienta  


    public function UpdateStatusHerB($post,$table,$urldb,$personal){
    	$sitio=0;
        $status=3;
        $asignarp = 0;
    	try {
    		$db = Zend_Db_Table::getDefaultAdapter();
    		$qry = $db->query("UPDATE $table SET id_sitio = ?, id_responsable = ?, ultimo_r = ?,  status_disponible = ? , comentario_b = ? , evidencia_b = ? WHERE id_herramienta = ?",array(
    			$sitio,
                $asignarp,
                $personal,
                $status,
    			$post["motivos"],
    			$urldb,
    			$post["idh"]));
    		$db->closeConnection();               
    		return $qry;
    	} 
    	catch (Exception $e) {
    		echo $e;
    	}
    }	//  Update Status Baja Herramienta

    public function UpdateStatusHerB2($post,$table){
        $responsable=0;
        $status=3;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_responsable = ?, status_disponible = ? WHERE id_herramienta = ?",array(
                $responsable,
                $status,
                $post));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  Update Status Baja Cobro Herramienta  

    public function InsertCobro($post,$table,$hoy,$personal){
        $statuscobro = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_herramienta'=>$post,
                'id_personal'=>$personal,
                'status_cobro'=>$statuscobro,
                'fecha'=>$hoy
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }   //  Insert Cobro Herramientas

    public function InsertCobrohd($post,$table,$hoy,$personal){
        $statuscobro = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_herramienta'=>$post['idh'],
                'id_personal'=>$personal,
                'status_cobro'=>$statuscobro,
                'fecha'=>$hoy
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }   //  Insert Cobro Herramientas DESDE hERRAMIENTA DETAIL

    public function GetPersonal($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto,
            pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, pc.status_personal, 
            pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal,
            pc.id_sitiopersonal, pc.name_sitio,pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto 
            FROM personal_campo pc 
            INNER JOIN puestos_personal pp on pc.puesto = pp.id 
            WHERE pc.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Consulta Personal


    public function Responsivah($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM responsivah WHERE id_personal = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Consulta Responsiva Herramientas


    public function insertresponsivah($post,$table,$urldb,$hoy){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'responsivah'=>$urldb,
                'id_personal'=>$post['idper'],
                'fecha'=>$hoy
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }   //  Insert Responsiva Herramientas


    public function GetPersonalCobroH($table){
        $cobro = 1;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp,
                pc.puesto, pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio, pc.delete_status, pp.id AS idpuesto, 
                pp.nombre AS name_puesto, ch.status_cobro
                FROM personal_campo pc
                INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                INNER JOIN cobro_herramientas ch ON pc.id = ch.id_personal
                WHERE ch.status_cobro = ? ",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Consulta Personal deudas Herramientas 

    public function GetPersonalPagoH($table){
        $cobro = 2;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp,
                pc.puesto, pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio, pc.delete_status, pp.id AS idpuesto, 
                pp.nombre AS name_puesto, ch.status_cobro
                FROM personal_campo pc
                INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                INNER JOIN cobro_herramientas ch ON pc.id = ch.id_personal
                WHERE ch.status_cobro = ? ",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Consulta Personal Pagadas Herramientas

    public function GetpaginationcobroH($table,$offset,$no_of_records_per_page){
        $cobro = 1;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp,
                pc.puesto, pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio, pc.delete_status, pp.id AS idpuesto, 
                pp.nombre AS name_puesto, ch.status_cobro
                FROM personal_campo pc
                INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                INNER JOIN cobro_herramientas ch ON pc.id = ch.id_personal
                WHERE ch.status_cobro = ?
             ORDER BY pc.nombre ASC LIMIT $offset,$no_of_records_per_page",array($cobro));;
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA Cobro PErsonal

    public function GetpaginationPagoH($table,$offset,$no_of_records_per_page){
        $cobro = 2;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp,
                pc.puesto, pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio, pc.delete_status, pp.id AS idpuesto, 
                pp.nombre AS name_puesto, ch.status_cobro
                FROM personal_campo pc
                INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                INNER JOIN cobro_herramientas ch ON pc.id = ch.id_personal
                WHERE ch.status_cobro = ?
             ORDER BY pc.nombre ASC LIMIT $offset,$no_of_records_per_page",array($cobro));;
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA PAgo herramienta pagination PErsonal


    public function GetPersonalCobroBH($table,$nombre){
        $cobro = 1;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp,
                pc.puesto, pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio, pc.delete_status, pp.id AS idpuesto, 
                pp.nombre AS name_puesto, ch.status_cobro
                FROM personal_campo pc
                INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                INNER JOIN cobro_herramientas ch ON pc.id = ch.id_personal
                WHERE ch.status_cobro = ? and pc.nombre like '%{$nombre}%' ",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Consulta Buscador Personal Cobro

    public function GetpaginationcobroBH($table,$nombre,$offset,$no_of_records_per_page){
        $cobro = 1;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp,
                pc.puesto, pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio, pc.delete_status, pp.id AS idpuesto, 
                pp.nombre AS name_puesto, ch.status_cobro
                FROM personal_campo pc
                INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                INNER JOIN cobro_herramientas ch ON pc.id = ch.id_personal
                WHERE ch.status_cobro = ? and pc.nombre like '%{$nombre}%'
             ORDER BY pc.nombre ASC LIMIT $offset,$no_of_records_per_page",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }// Consulta Buscador Personal Cobro

     public function GetPersonalCobroPH($table,$nombre){
        $cobro = 2;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp,
                pc.puesto, pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio, pc.delete_status, pp.id AS idpuesto, 
                pp.nombre AS name_puesto, ch.status_cobro
                FROM personal_campo pc
                INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                INNER JOIN cobro_herramientas ch ON pc.id = ch.id_personal
                WHERE ch.status_cobro = ? and pc.nombre like '%{$nombre}%' ",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Consulta Buscador Personal Pagadp

    public function GetpaginationcobroPH($table,$nombre,$offset,$no_of_records_per_page){
        $cobro = 2;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp,
                pc.puesto, pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio, pc.delete_status, pp.id AS idpuesto, 
                pp.nombre AS name_puesto, ch.status_cobro
                FROM personal_campo pc
                INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                INNER JOIN cobro_herramientas ch ON pc.id = ch.id_personal
                WHERE ch.status_cobro = ? and pc.nombre like '%{$nombre}%'
             ORDER BY pc.nombre ASC LIMIT $offset,$no_of_records_per_page",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }// Consulta Buscador Personal Pagado


    public function GetHerCobro($table,$wh,$id,$cobro){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT  c.id_herramienta, c.id_personal, c.status_cobro, c.fecha, h.id_herramienta, h.codigo, 
                h.nombre, h.unidad, h.descripcion, h.imagen, h.status_disponible, h.fecha_salida, h.fecha_entrega, 
                h.id_responsable, h.marca, h.modelo
                FROM cobro_herramientas c
                LEFT JOIN herramienta_inventario h ON c.id_herramienta = h.id_herramienta
                WHERE c.id_personal = ? and c.status_cobro = $cobro",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    } // Consulta herramienta 

     public function UpdateCobroH($post,$table){
        $cobro=2; 
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_cobro = ? WHERE id_herramienta = ?",array(
                $cobro,
                $post));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  Update Status Cobro


    public function insertcobroH($post,$table,$urldb,$hoy){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nota'=>$post['name'],
                'id_personal'=>$post['idpe'],
                'fecha'=>$hoy,
                'comprobante'=>$urldb); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }//  INSERT COBRO


    public function GetAllPersonal($table){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT distinct h.id_responsable, p.id, p.nombre, p.apellido_pa, p.apellido_ma
                FROM herramienta_inventario h
                INNER JOIN personal_campo p on p.id = h.id_responsable
                ORDER BY p.nombre ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Consulta Personal Con herramienta






} 