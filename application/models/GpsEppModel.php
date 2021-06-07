<?php

class Application_Model_GpsEppModel extends Zend_Db_Table_Abstract{

    public function Getpaginationepp($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.idepp, e.nombre, e.talla, e.descripcion, e.stock,
                IF(e.costo_aprobado IS NULL, 'Costo no Asignado', e.costo_aprobado) AS costoa, 
                e.tiempo_vida, e.tipo_epp, et.id_tipo, et.nombre as tiponombre
                FROM epp_catalogo e
                LEFT JOIN epp_tipo et ON et.id_tipo = e.tipo_epp
                ORDER BY e.nombre ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }// CONSULTA EPP


    public function insertepp($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'tipo_epp'=>$post['tipo'],
                'nombre'=>$post['name'],
                'descripcion'=>$post['desc'],
                'talla'=>$post['talla'],
                'stock'=>$post['stock'],
                'tiempo_vida'=>$post['vida'],
                'costo_aprobado'=>$post['costo']
                
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }//  INSERT EPP

    public function updateepp($post,$table){
        // var_dump($post);
        // exit;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre = ?, talla = ?, descripcion = ?, stock = ?, tiempo_vida = ?, costo_aprobado = ?, tipo_epp = ? WHERE idepp = ? ",
                array(
                    $post['name'],
                    $post['talla'],
                    $post['desc'],
                    $post['stock'],
                    $post['vida'],
                    $post['costo'],
                    $post['tipo'],
                    $post['ids']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE EPP

    public function nepp($name){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM epp_catalogo WHERE nombre like '%{$name}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function eppnamecount($name,$offset,$no_of_records_per_page){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.idepp, e.nombre, e.talla, e.descripcion, e.stock,
                IF(e.costo_aprobado IS NULL, 'Costo no Asignado', e.costo_aprobado) AS costoa, 
                e.tiempo_vida, e.tipo_epp, et.id_tipo, et.nombre as tiponombre
                FROM epp_catalogo e
                LEFT JOIN epp_tipo et ON et.id_tipo = e.tipo_epp 
                WHERE e.nombre like '%{$name}%' LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function tallaepp($tallas){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM epp_catalogo WHERE talla like '%{$tallas}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function epptallacount($tallas,$offset,$no_of_records_per_page){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.idepp, e.nombre, e.talla, e.descripcion, e.stock,
                IF(e.costo_aprobado IS NULL, 'Costo no Asignado', e.costo_aprobado) AS costoa, 
                e.tiempo_vida, e.tipo_epp, et.id_tipo, et.nombre as tiponombre
                FROM epp_catalogo e
                LEFT JOIN epp_tipo et ON et.id_tipo = e.tipo_epp 
                WHERE talla like '%{$tallas}%' LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function eppexcel(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.idepp, e.nombre, e.talla, e.descripcion, e.stock,
                IF(e.costo_aprobado IS NULL, 'Costo no Asignado', e.costo_aprobado) AS costoa, 
                e.tiempo_vida, e.tipo_epp, et.id_tipo, et.nombre as tiponombre
                FROM epp_catalogo e
                LEFT JOIN epp_tipo et ON et.id_tipo = e.tipo_epp");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function eppasignacion(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT p.id, p.nombre, p.apellido_pa, p.apellido_ma,
            ae.id_epp, ae.cantidad, ae.descripcion, ec.talla , ae.fecha_entrega, ae.reposicion, ae.comentario, ae.status_epp,
            p.status_personal, p.delete_status, p.id_sitiopersonal,p.name_sitio 
            FROM epp_asignar ae 
            LEFT JOIN personal_campo p ON p.id = ae.id_personal
            LEFT JOIN epp_catalogo ec ON ec.idepp = ae.id_epp
            WHERE p.delete_status = 0
            ORDER by p.id");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function Getpaginationtipo($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT id_tipo, nombre
                FROM $table
                order by id_tipo asc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } 

    public function inserttipo($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre'=>$post['name']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }//  INSERT TIPO

    public function tiponombre($nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM epp_tipo WHERE nombre like '%{$nombre}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //Buscar Tipo

    public function tipocount($nombre,$offset,$no_of_records_per_page){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM epp_tipo WHERE nombre like '%{$nombre}%' LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //Contador Buscar

    public function updatetipo($post,$table){
        // var_dump($post);
        // exit;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre = ? WHERE id_tipo = ? ",
                array(
                    $post['name'],
                    $post['ids']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE TIPO

    public function GetPersonalEpp($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto,
            pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, pc.status_personal, 
            pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal,
            pc.id_sitiopersonal, pc.name_sitio,pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto 
            FROM personal_campo pc 
            LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
            WHERE pc.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Consulta Personal

    public function Getcatalogo($table){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT nombre
                FROM $table");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Consulta Epp Nombre

    public function GetEppAsignado($table,$wh,$id,$status){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ea.id, ea.cantidad, ea.descripcion, ea.cobro, IF(ea.cobro != 2 , IF(ea.cobro = 0, 'Sin Costo Extra', 'Se Aplicara Costo') , 'Descuento Efectuado') AS cobroe, ea.comentario, ea.talla, ea.fecha_entrega, ea.reposicion, ea.id_personal, ea.tipo_epp, ea.status_epp, ea.comprado_campo,
                ea.id_epp, ec.nombre, ec.talla as t_e, ec.descripcion as desc_e, ec.stock, ec.costo_aprobado, ec.tiempo_vida 
                FROM epp_asignar ea 
                LEFT JOIN
                epp_catalogo ec ON ea.id_epp = ec.idepp
                WHERE id_personal = ? AND status_epp= $status ORDER BY fecha_entrega ASC",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    } // Consulta Epp Asignado


    public function updatestatus($id,$table,$wh){
        $status=1;
        $cobro=0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_epp = ? , cobro = ?
             WHERE $wh = ? ",
               array(
                $status,
                $cobro,
                $id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE AsignacionEPP


    public function GetRegresar($table,$id_epp){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table where idepp = $id_epp");
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }



     public function updateStock2($post,$table,$nuevostock,$id_epp){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  stock = ? WHERE idepp = ?",array(
                $nuevostock,
                $id_epp
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  ACTUALIZAR STOCK 

    
    public function buscarrep($id,$table){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT tiempo_vida FROM $table WHERE  idepp = ? ",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    } // Consulta Epp Asignado

    public function insertasignacion($post,$table,$fechanew,$statusc){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'cantidad'=>$post['cantidad'],
                'comentario'=>$post['comentarios'],
                'tipo_epp'=>$post['tipo'],
                'descripcion'=>$post['epp'],
                'talla'=>$post['talla'],
                'id_epp'=>$post['talla'],
                'fecha_entrega'=>$post['fecha'],
                'reposicion'=>$fechanew,
                'cobro'=>$statusc,
                'id_personal'=>$post['idhs']
            );
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END Insert asignar epp a personal


    public function insertasgcompra($post,$table,$fechanew,$statusc){
        $compra = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'cantidad'=>$post['cantidad'],
                'comentario'=>$post['comentarios'],
                'tipo_epp'=>$post['tipo'],
                'descripcion'=>$post['epp'],
                'talla'=>$post['talla'],
                'id_epp'=>$post['talla'],
                'fecha_entrega'=>$post['fecha'],
                'reposicion'=>$fechanew,
                'cobro'=>$statusc,
                'comprado_campo'=>$compra,
                'id_personal'=>$post['idhs']
            );
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END Insert asignar epp a personal COMPRA EN CAMPO


    public function UpdateStock($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET stock = stock - ? WHERE idepp = ?",array(
                $post["cantidad"],
                $post["talla"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  Update Stock de EPP
    

    public function consultaTallas($letra){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT idepp, talla FROM epp_catalogo WHERE nombre like '%{$letra}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }// Obetener tallas


    public function Regresar($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto,
            pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, pc.status_personal, 
            pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, 
            pc.id_sitiopersonal, pc.name_sitio,pc.delete_status , ea.id as idea, ea.fecha_entrega, ea.tipo_epp, 
            ea.id_epp, ea.comentario, ea.reposicion, ea.id_personal
            FROM personal_campo pc 
            INNER JOIN epp_asignar ea on pc.id = ea.id_personal 
            WHERE ea.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Consulta Personal Regresar de Vista


    public function DetallesEPP($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre as nombrep, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, 
                pc.puesto, pc.status_expediente, pc.telefono, pc.email_personal, pc.status_personal, pc.fecha_personal, 
                pc.status_cuadrilla, pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal,
                pc.name_sitio, pc.delete_status, ea.id AS idea, ea.fecha_entrega, ea.tipo_epp, ea.id_epp, ea.cantidad,
                ea.comentario, ea.reposicion, ea.id_personal, ec.idepp, ec.nombre, ec.talla, ec.descripcion,
                ec.costo_aprobado, ec.tipo_epp as tipoe, et.nombre as eppt
                FROM epp_asignar ea
                INNER JOIN personal_campo pc ON ea.id_personal = pc.id
                LEFT JOIN epp_catalogo ec ON ea.id_epp = ec.idepp
                LEFT JOIN epp_tipo et ON ea.tipo_epp = et.id_tipo
                WHERE ea.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Detalles EPP


    public function GetTalla($talla){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT idepp, talla FROM epp_catalogo WHERE nombre like '%{$talla}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }// Obetener tallas


    public function UpdateEppP($post,$table,$fechanew){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE epp_asignar SET talla = ?, id_epp = ?, tipo_epp = ?, fecha_entrega = ?, reposicion = ?, comentario = ? WHERE id = ? ",
                array(
                    $post['tallaget'],
                    $post['tallaget'],
                    $post['tipo'],
                    $post['fecha'],
                    $fechanew,
                    $post['comentarios'],
                    $post['idea']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }

    }   //  Update EppP

    public function Responsiva($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM responsivas WHERE id_personal = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Responsiva

    public function insertresponsiva($post,$table,$urldb,$hoy){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'responsiva'=>$urldb,
                'id_personal'=>$post['idper'],
                'fecha'=>$hoy
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }//  Insert Responsiva


    public function GetEppCobro($table,$wh,$id,$status,$cobro){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ea.id, ea.cantidad, ea.descripcion, ea.cobro , IF(ea.cobro != 2 , IF(ea.cobro = 0, 'Sin Costo Extra', 'Se Aplicara Costo') , 'Descuento Efectuado') AS cobroe, ea.comentario, ea.talla, ea.fecha_entrega, ea.reposicion, ea.id_personal, ea.tipo_epp, ea.status_epp, 
                ea.id_epp, ec.nombre, ec.talla as t_e, ec.descripcion as desc_e, ec.stock, ec.costo_aprobado, ec.tiempo_vida 
                FROM epp_asignar ea 
                LEFT JOIN
                epp_catalogo ec ON ea.id_epp = ec.idepp
                WHERE id_personal = ? AND status_epp= $status AND cobro = $cobro",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    } // Consulta Epp Asignado


    public function GetPersonalCobro($table){
        $cobro = 1;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT
             pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, pc.status_expediente, pc.telefono,
             pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, pc.status_personal, pc.fecha_personal, 
             pc.status_cuadrilla, pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio,
             pc.delete_status, pp.id AS idpuesto, pp.nombre AS name_puesto, ea.cobro
             FROM personal_campo pc
             INNER JOIN
             puestos_personal pp ON pc.puesto = pp.id
             INNER JOIN
             epp_asignar ea ON pc.id = ea.id_personal
             WHERE
             ea.cobro = ? ",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Consulta Personal

    public function GetPersonalCobroPag($table){
        $cobro = 2;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT
             pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, pc.status_expediente, pc.telefono,
             pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, pc.status_personal, pc.fecha_personal, 
             pc.status_cuadrilla, pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio,
             pc.delete_status, pp.id AS idpuesto, pp.nombre AS name_puesto, ea.cobro
             FROM personal_campo pc
             INNER JOIN
             puestos_personal pp ON pc.puesto = pp.id
             INNER JOIN
             epp_asignar ea ON pc.id = ea.id_personal
             WHERE
             ea.cobro = ? ",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Consulta Personal

    public function Getpaginationcobro($table,$offset,$no_of_records_per_page){
        $cobro = 1;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT
             pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, pc.status_expediente, pc.telefono,
             pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, pc.status_personal, pc.fecha_personal, 
             pc.status_cuadrilla, pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio,
             pc.delete_status, pp.id AS idpuesto, pp.nombre AS name_puesto, ea.cobro
             FROM personal_campo pc
             INNER JOIN
             puestos_personal pp ON pc.puesto = pp.id
             INNER JOIN
             epp_asignar ea ON pc.id = ea.id_personal
             WHERE ea.cobro = ? 
                ORDER BY pc.nombre ASC LIMIT $offset,$no_of_records_per_page",array($cobro));;
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }// CONSULTA Cobro

    public function GetpaginationcobroPag($table,$offset,$no_of_records_per_page){
        $cobro = 2;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT
             pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, pc.status_expediente, pc.telefono,
             pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, pc.status_personal, pc.fecha_personal, 
             pc.status_cuadrilla, pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio,
             pc.delete_status, pp.id AS idpuesto, pp.nombre AS name_puesto, ea.cobro
             FROM personal_campo pc
             INNER JOIN
             puestos_personal pp ON pc.puesto = pp.id
             INNER JOIN
             epp_asignar ea ON pc.id = ea.id_personal
             WHERE ea.cobro = ? 
                ORDER BY pc.nombre ASC LIMIT $offset,$no_of_records_per_page",array($cobro));;
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }// CONSULTA Pagado

    public function insertcobro($post,$table,$urldb,$hoy){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'detalle'=>$post['name'],
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

    public function UpdateCobro($post,$table){
        $cobro=2; 
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET cobro = ? WHERE id = ?",array(
                $cobro,
                $post));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  Update Status Cobro

    public function GetPersonalCobroB($table,$nombre){
        $cobro = 1;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT
             pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, pc.status_expediente, pc.telefono,
             pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, pc.status_personal, pc.fecha_personal, 
             pc.status_cuadrilla, pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio,
             pc.delete_status, pp.id AS idpuesto, pp.nombre AS name_puesto, ea.cobro
             FROM personal_campo pc
             INNER JOIN
             puestos_personal pp ON pc.puesto = pp.id
             INNER JOIN
             epp_asignar ea ON pc.id = ea.id_personal
             WHERE
             ea.cobro = ? and pc.nombre like '%{$nombre}%' ",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Consulta Buscador Personal

    public function GetPersonalCobroPagB($table,$nombre){
        $cobro = 2;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT
             pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, pc.status_expediente, pc.telefono,
             pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, pc.status_personal, pc.fecha_personal, 
             pc.status_cuadrilla, pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio,
             pc.delete_status, pp.id AS idpuesto, pp.nombre AS name_puesto, ea.cobro
             FROM personal_campo pc
             INNER JOIN
             puestos_personal pp ON pc.puesto = pp.id
             INNER JOIN
             epp_asignar ea ON pc.id = ea.id_personal
             WHERE
             ea.cobro = ?  and pc.nombre like '%{$nombre}%' ",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Consulta Buscador Personal

    public function GetpaginationcobroB($table,$nombre,$offset,$no_of_records_per_page){
        $cobro = 1;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT
             pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, pc.status_expediente, pc.telefono,
             pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, pc.status_personal, pc.fecha_personal, 
             pc.status_cuadrilla, pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio,
             pc.delete_status, pp.id AS idpuesto, pp.nombre AS name_puesto, ea.cobro
             FROM personal_campo pc
             INNER JOIN
             puestos_personal pp ON pc.puesto = pp.id
             INNER JOIN
             epp_asignar ea ON pc.id = ea.id_personal
             WHERE ea.cobro = ? and pc.nombre like '%{$nombre}%'
                ORDER BY pc.nombre ASC LIMIT $offset,$no_of_records_per_page",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }// Consulta Buscador Personal

    public function GetpaginationcobroPagB($table,$nombre,$offset,$no_of_records_per_page){
        $cobro = 2;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT
             pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, pc.status_expediente, pc.telefono,
             pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, pc.status_personal, pc.fecha_personal, 
             pc.status_cuadrilla, pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio,
             pc.delete_status, pp.id AS idpuesto, pp.nombre AS name_puesto, ea.cobro
             FROM personal_campo pc
             INNER JOIN
             puestos_personal pp ON pc.puesto = pp.id
             INNER JOIN
             epp_asignar ea ON pc.id = ea.id_personal
             WHERE ea.cobro = ? and pc.nombre like '%{$nombre}%'
             ORDER BY pc.nombre ASC LIMIT $offset,$no_of_records_per_page",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }// Consulta Buscador Personal


    public function GetAllPsn($table){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM personal_campo where delete_status = 0 and status_personal = 0
                ORDER BY nombre ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Consulta Personal Con herramienta


} 