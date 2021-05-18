<?php

class Application_Model_SeasonPanelModel extends Zend_Db_Table_Abstract{
    protected $_name = 'solicitud_ordencompra';
    protected $_primary = 'id';

    public function insertsolicitudordencomprapendiente($sol_pendiente,$hoy,$post){
        // var_dump($sol_pendiente);exit;
        try {
            $row = $this->createRow();
            $row->sitio_id = $sol_pendiente[0]['sitio_id'];
            $row->tipo_proyecto = $post['proyecto'];
            $row->nombre_sitio = $sol_pendiente[0]['nombre_sitio'];
            $row->proveedor_id = $sol_pendiente[0]['proveedor_id'];
            $row->name_proveedor = $sol_pendiente[0]['name_proveedor'];
            $row->id_usuario = $sol_pendiente[0]['id_usuario'];
            $row->name_user = $sol_pendiente[0]['name_user'];
            $row->fecha_requerida = $sol_pendiente[0]['fecha_requerida'];
            $row->fecha_creacion = $hoy;
            $row->servicio_id = $sol_pendiente[0]['servicio_id'];
            $row->importe = $sol_pendiente[0]['importe'];
            $row->iva = $sol_pendiente[0]['iva'];
            $row->retencion_isr = $sol_pendiente[0]['retencion_isr'];
            $row->retencion_iva = $sol_pendiente[0]['retencion_iva'];
            $row->total = $sol_pendiente[0]['total'];
            $row->condiciones_compra = $sol_pendiente[0]['condiciones_compra'];
            $row->referencia = $sol_pendiente[0]['referencia']; 
            $row->descripcion = $sol_pendiente[0]['descripcion'];
            $row->rol_encargado = $sol_pendiente[0]['rol_encargado'];
            $row->status_documentouno = $sol_pendiente[0]['status_documentouno'];
            $row->facturable = $sol_pendiente[0]['facturable'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT SOLICITUD ORDEN COMPRA

    public function insertpendientesol($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_prov'=>$post['name'],
                'telefono'=>$post['phone'],
                'rfc'=>$post['rfc'],
                'datos_banco'=>$post['banco'],
                'cuenta'=>$post['cuenta'],
                'tarjeta'=>$post['tarjeta'],
                'titular'=>$post['titular'],
                'email'=>$post['email'],
                'periodo_pago'=>$post['periodo_pago'],
                'tipo_proveedor'=>$post['clasificacion']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertProveedor($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_prov'=>$post['name'],
                'telefono'=>$post['phone'],
                'rfc'=>$post['rfc'],
                'datos_banco'=>$post['banco'],
                'cuenta'=>$post['cuenta'],
                'tarjeta'=>$post['tarjeta'],
                'titular'=>$post['titular'],
                'email'=>$post['email'],
                'periodo_pago'=>$post['periodo_pago'],
                'tipo_proveedor'=>$post['clasificacion']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertProyecto($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_proyecto'=>$post['name'],
                'descripcion'=>$post['desc']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function insertsitio($post,$latitude,$longitude,$conversion_lat,$conversion_lon,$table){
            if($post['coordenada1'] == "s"){
                $lat= "-".$latitude;
            }else{
                $lat = $latitude;
            }

            if($post['coordenada2'] == "o"){
                $long = "-".$longitude;
            }else{
                $long = $longitude;
            }

        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_cliente'=>$post['id_cliente'],
                'nombre'=>$post['name'],
                'cliente'=>$post['cliente'],
                'direccion'=>$post['direccion'],
                'ciudad'=>$post['ciudad'],
                'estado'=>$post['estado'],
                'region'=>$post['region'],
                'estructura'=>$post['estructura'],
                'edificio'=>$post['edificio'],
                'tipo_sitio'=>$post['tipo_sitio'],
                'altura'=>$post['altura'],
                'latitude'=>$lat,
                'coor_lat'=>$post['coordenada1'],
                'conv_lat'=>$conversion_lat,
                'conv_lon'=>$conversion_lon,
                'coor_lon'=>$post['coordenada2'],
                'longitude'=>$long); 
            $res = $db->insert($table, $datasave);
            $id=0;
            if($res)
            $id=$db->lastInsertId();
            $db->closeConnection();               
            return $id;
        } catch (Exception $e) {
            echo $e;
        }       
    }



    public function insertsitio_tipoproyecto($id,$wh,$table,$post){
        try {
            $res = 0;
            foreach ($post as $key=>$row) {
                
                if($key!='id_cliente' && $key!='name' && $key!='cliente' && $key!='ciudad' && $key!='estado'
                    && $key!='region' && $key!='estructura' && $key!='altura' && $key!='latitude' && $key!='longitude'){
                    $db = Zend_Db_Table::getDefaultAdapter();
                    $datasave = array(
                                   'id_sitio'=>$id,
                                   'id_tipoproyecto'=>$row);
                    $res = $db->insert($table, $datasave);
                    $db->closeConnection();                    
                }
            }
                    return $res;       
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT SITIO



    public function refreshProveedor($post,$table){
        // var_dump($post);exit;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre_prov = ?, telefono = ?,rfc = ?,datos_banco = ?,cuenta = ?, tarjeta =?, titular =?, email = ?, periodo_pago=?, tipo_proveedor = ? WHERE id = ?",array(
                $post['name'],
                $post['phone'],
                $post['rfc'],
                $post['datos_banco'],
                $post['cuenta'],
                $post['tarjeta'],
                $post['titular'],
                $post['email'],
                $post['periodo_pago'],
                $post['clasificacion'],
                $post["ids"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function refreshSitio($post,$longitude,$latitude,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_cliente = ?, nombre = ? , direccion = ?, cliente =?, ciudad = ? , estado = ?, region = ?, estructura = ?, edificio = ?, tipo_sitio = ? ,altura = ?, latitude = ?, longitude = ? WHERE id = ?",array(
                $post['id_cliente'],
                $post['nombre'],
                $post['direccion'],
                $post['cliente'],
                $post['ciudad'],
                $post['estado'],
                $post['region'],
                $post['estructura'],
                $post['edificio'],
                $post['tipo_sitio'],
                $post['altura'],
                $latitude,
                $longitude,
                $post["ids"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER


    public function refreshProyecto($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre_proyecto = ?, descripcion = ? WHERE id = ?",array(
                $post['name'],
                $post['desc'],
                $post["ids"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER


    public function UpdateUsrSession($post,$table,$wh,$id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre = ? , ap = ? , am = ? , direccion = ? , telefono = ? , correo = ? WHERE $wh = ?",array(
                $post['name'],
                $post['apa'],
                $post['ama'],
                $post['dir'],
                $post['phone'],
                $post['mail'],
                $id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }

    public function UpdateUsrPassw($post,$table,$wh){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $cripted = openssl_digest($post['pword'],"sha512");
            $qry = $db->query("UPDATE $table SET passw = ? WHERE $wh = ?",array($cripted,$post['id']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }
	
	// --------------------------------DELETS

	public function deleteAll($id,$table,$wh){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $var =  $db->query ("DELETE from $table where $wh = ? ",array($id));
            $db->closeConnection();
            return $var;
        } catch (Exception $e) {
            echo $e;
        }
    }//deleteUsr

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

    public function Validar($post){

        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $p = openssl_digest($post["passw"],"sha512");
            $valiu = $db->query("SELECT * FROM usuario WHERE correo = ? and passw = ?",
        array(
            $post["mail"],
            $p));       
        $row = $valiu->fetchAll();             
                    $db->closeConnection();               
                    return $row;
        } catch (Exception $e) {
            echo $e;
        }//end try and catch
    }//fin de validar

    public function Correonet($table){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT nombre,ap,correo FROM $table order by ID DESC limit 1");
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    } 
}