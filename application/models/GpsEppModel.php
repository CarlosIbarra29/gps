<?php

class Application_Model_GpsEppModel extends Zend_Db_Table_Abstract{
    protected $_name = 'epp_solicitudes';
    protected $_primary = 'id';

    public function Getpaginationepp($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.idepp, e.nombre, e.talla, e.descripcion, e.stock, e.imagen, e.presentacion,
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
 

    public function insertepp($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'tipo_epp'=>$post['tipo'],
                'nombre'=>$post['name'],
                'descripcion'=>$post['desc'],
                'presentacion'=>$post['presentacion'],
                'imagen'=>$urldb,
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

    public function updateepp($post,$table,$urldb){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre = ?, talla = ?, descripcion = ?, imagen = ?, presentacion = ?, stock = ?, tiempo_vida = ?, costo_aprobado = ?, tipo_epp = ? 
                WHERE idepp = ? ",
                array(
                    $post['name'],
                    $post['talla'],
                    $post['desc'],
                    $urldb,
                    $post['presentacion'],
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
        }
        catch (Exception $e){
        
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
            $qry = $db->query("SELECT e.idepp, e.nombre, e.talla, e.descripcion, e.stock, e.presentacion,
                        IF(e.costo_aprobado IS NULL, 'Costo no Asignado', e.costo_aprobado) AS costoa, 
                        e.tiempo_vida, e.tipo_epp, et.id_tipo, et.nombre as tiponombre
                        FROM epp_catalogo e
                        LEFT JOIN epp_tipo et ON et.id_tipo = e.tipo_epp");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }


    public function eppasignacion(){  
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT p.id, p.nombre, p.apellido_pa, p.apellido_ma,ae.id_epp, ae.cantidad, ae.descripcion, 
                        ec.talla , ae.fecha_entrega, ae.reposicion, ae.comentario, ae.status_epp, p.status_personal,p.delete_status, 
                        p.id_sitiopersonal,p.name_sitio 
                        FROM epp_asignar ae 
                        LEFT JOIN personal_campo p ON p.id = ae.id_personal
                        LEFT JOIN epp_catalogo ec ON ec.idepp = ae.id_epp
                        WHERE p.delete_status = 0
                        ORDER by p.id");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        
        }
        catch (Exception $e){
        
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
        }
        catch (Exception $e){
        
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
        } 
        catch (Exception $e) {
        
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
        }
        catch (Exception $e){
        
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
        }
        catch (Exception $e){
         
            echo $e;
        
        }
    } //Contador Buscar

    public function updatetipo($post,$table){
        
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
                        pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                        pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                        pc.sitio_tipoproyectopersonal,pc.id_sitiopersonal, pc.name_sitio,pc.delete_status ,pp.id as idpuesto, 
                        pp.nombre as name_puesto 
                        FROM personal_campo pc 
                        LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                        WHERE pc.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
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
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } // Consulta Epp Nombre


    public function GetcatalogoSol($table){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT nombre
                FROM $table
                where stock >= 1");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } // Consulta Epp Nombre


    public function GetEPPxVen($table){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM epp_catalogo
            WHERE stock <= 2 and stock >=1");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // EPP con poco stock.

    public function GetEPPSinStock($table){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM epp_catalogo
            WHERE stock <= 0");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
        
            echo $e;
        
        }
    }   // EPP con poco stock.

    public function GetEppAsignado($table,$wh,$id,$status){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ea.id, ea.cantidad, ea.descripcion, ea.cobro, 
                        IF(ea.cobro != 2 , IF(ea.cobro = 0, 'Sin Costo Extra', 'Se Aplicara Costo') , 'Descuento Efectuado') AS cobroe, ea.comentario, ea.talla, ea.fecha_entrega, ea.reposicion, ea.id_personal, ea.tipo_epp, 
                        ea.status_epp, ea.comprado_campo,ea.id_epp, ec.nombre, ec.talla as t_e, ec.descripcion as desc_e, ec.stock, ec.presentacion,
                        ec.costo_aprobado, ec.tiempo_vida 
                        FROM epp_asignar ea 
                        LEFT JOIN
                        epp_catalogo ec ON ea.id_epp = ec.idepp
                        WHERE id_personal = ? AND status_epp= $status ORDER BY fecha_entrega ASC",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } 
        catch (Exception $e) {
        
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
        }
        catch (Exception $e) {
        
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
        }
        catch (Exception $e) {
        
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
        }
        catch (Exception $e) {
        
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
        }
        catch (Exception $e) {
        
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
    
// 
    public function consultaTallas($letra){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT idepp, talla FROM epp_catalogo WHERE nombre like '%{$letra}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }// Obetener tallas


    public function consultaTallassin($letra){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT idepp, talla FROM epp_catalogo WHERE nombre like '%{$letra}%' and stock >=1");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }// Obetener tallas


    public function Regresar($id){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto,
                        pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                        pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                        pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio,pc.delete_status , ea.id as idea, 
                        ea.fecha_entrega, ea.tipo_epp, ea.id_epp, ea.comentario, ea.reposicion, ea.id_personal
                        FROM personal_campo pc 
                        INNER JOIN epp_asignar ea on pc.id = ea.id_personal 
                        WHERE ea.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
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
        }
        catch (Exception $e){
        
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
        }
        catch (Exception $e){
        
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
        }
        catch (Exception $e){
        
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
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    }//  Insert Responsiva


    public function GetEppCobro($table,$wh,$id,$status,$cobro){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ea.id, ea.cantidad, ea.descripcion, ea.cobro , 
                        IF(ea.cobro != 2 , IF(ea.cobro = 0, 'Sin Costo Extra', 'Se Aplicara Costo') , 'Descuento Efectuado') AS cobroe, ea.comentario, ea.talla, ea.fecha_entrega, ea.reposicion, ea.id_personal, ea.tipo_epp, 
                        ea.status_epp, ea.id_epp, ec.nombre, ec.talla as t_e, ec.descripcion as desc_e, ec.stock, ec.costo_aprobado,
                        ec.tiempo_vida 
                        FROM epp_asignar ea 
                        LEFT JOIN
                        epp_catalogo ec ON ea.id_epp = ec.idepp
                        WHERE id_personal = ? AND status_epp= $status AND cobro = $cobro",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    } // Consulta Epp Asignado

    public function GetEppCobronomina($table,$wh,$id){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ea.id, ea.cantidad, ea.descripcion, ea.cobro, ea.comentario, ea.talla, 
                        ea.fecha_entrega, ea.reposicion, ea.id_personal, ea.tipo_epp, ea.status_epp, 
                        ea.id_epp, ec.nombre, ec.talla as t_e, ec.descripcion as desc_e, ec.stock, 
                        ec.costo_aprobado, ec.tiempo_vida, ea.cobro, ea.comentario_rechazo, ea.user_monto,
                        ea.fecha_monto
                        FROM epp_asignar ea 
                        LEFT JOIN
                        epp_catalogo ec ON ea.id_epp = ec.idepp
                        WHERE id = ? ",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    } // Consulta Epp Asignado



    public function GetPersonalCobro($table){
        $cobro = 1;
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, 
                        pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                        pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                        pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio, pc.delete_status, pp.id AS idpuesto, 
                        pp.nombre AS name_puesto, ea.cobro
                        FROM personal_campo pc
                        INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                        INNER JOIN epp_asignar ea ON pc.id = ea.id_personal
                        WHERE ea.cobro = ? ",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } // Consulta Personal

    public function Getcobroeppnomina($cobro){
        $cobro = 1;
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ea.id, ea.cantidad, ea.descripcion, ea.talla, ea.reposicion,ea.id_personal, 
                        ea.id_personal, ea.tipo_epp,pc.nombre, pc.apellido_pa,pc.apellido_ma
                        FROM epp_asignar ea 
                        LEFT JOIN personal_campo pc on pc.id = ea.id_personal
                        where ea.cobro = ?",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } // Consulta Personal


    public function GetPersonalCobroPag($table){
        $cobro = 2;
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, 
                        pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                        pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                        pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio,
                        pc.delete_status, pp.id AS idpuesto, pp.nombre AS name_puesto, ea.cobro
                        FROM personal_campo pc
                        INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                        INNER JOIN epp_asignar ea ON pc.id = ea.id_personal
                        WHERE ea.cobro = ? ",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } // Consulta Personal

    public function Getpaginationcobro($table,$offset,$no_of_records_per_page){
        $cobro = 1;
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, 
                        pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                        pc.status_personal,pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                        pc.sitio_tipoproyectopersonal,pc.id_sitiopersonal,pc.name_sitio, pc.delete_status, pp.id AS idpuesto, 
                        pp.nombre AS name_puesto, ea.cobro
                        FROM personal_campo pc
                        INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                        INNER JOIN epp_asignar ea ON pc.id = ea.id_personal
                        WHERE ea.cobro = ? 
                        ORDER BY pc.nombre ASC LIMIT $offset,$no_of_records_per_page",array($cobro));;
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }// CONSULTA Cobro

    public function getnominacobroepppaginator($cobro,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ea.id, ea.cantidad, ea.descripcion, ea.talla, ea.reposicion,ea.id_personal,
                        ea.id_personal, ea.tipo_epp, pc.nombre, pc.apellido_pa,pc.apellido_ma
                        FROM epp_asignar ea 
                        LEFT JOIN personal_campo pc on pc.id = ea.id_personal
                        where ea.cobro = ?
                        ORDER BY pc.nombre ASC LIMIT $offset,$no_of_records_per_page",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }// CONSULTA Cobro


    public function GetpaginationcobroPag($table,$offset,$no_of_records_per_page){
        $cobro = 2;
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, 
                        pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                        pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                        pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio, pc.delete_status, pp.id AS idpuesto, 
                        pp.nombre AS name_puesto, ea.cobro
                        FROM personal_campo pc
                        INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                        INNER JOIN epp_asignar ea ON pc.id = ea.id_personal
                        WHERE ea.cobro = ? 
                        ORDER BY pc.nombre ASC LIMIT $offset,$no_of_records_per_page",array($cobro));;
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
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
        }
        catch (Exception $e) {
        
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

    public function UpdateCobronomina($post,$table,$nombre_usuario,$hoy){
        $cobro=4; 
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET cobro = ?, comentario_rechazo = ?, fecha_monto = ?, user_monto =? WHERE id = ?",array(
                $cobro,
                $post['motivo_rechazo'],
                $hoy,
                $nombre_usuario,
                $post['id_solicitud']));
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
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, 
                        pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                        pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                        pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio, pc.delete_status, pp.id AS idpuesto, 
                        pp.nombre AS name_puesto, ea.cobro
                        FROM personal_campo pc
                        INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                        INNER JOIN epp_asignar ea ON pc.id = ea.id_personal
                        WHERE ea.cobro = ? and pc.nombre like '%{$nombre}%' ",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } // Consulta Buscador Personal

    public function GetPersonalCobroPagB($table,$nombre){
        $cobro = 2;
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, 
                        pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                        pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                        pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio, pc.delete_status, pp.id AS idpuesto, 
                        pp.nombre AS name_puesto, ea.cobro
                        FROM personal_campo pc
                        INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                        INNER JOIN epp_asignar ea ON pc.id = ea.id_personal
                        WHERE ea.cobro = ?  and pc.nombre like '%{$nombre}%' ",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } // Consulta Buscador Personal

    public function GetpaginationcobroB($table,$nombre,$offset,$no_of_records_per_page){
        $cobro = 1;
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, 
                        pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                        pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                        pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio, pc.delete_status, pp.id AS idpuesto, 
                        pp.nombre AS name_puesto, ea.cobro
                        FROM personal_campo pc
                        INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                        INNER JOIN epp_asignar ea ON pc.id = ea.id_personal
                        WHERE ea.cobro = ? and pc.nombre like '%{$nombre}%'
                        ORDER BY pc.nombre ASC LIMIT $offset,$no_of_records_per_page",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }// Consulta Buscador Personal

    public function GetpaginationcobroPagB($table,$nombre,$offset,$no_of_records_per_page){
        $cobro = 2;
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT DISTINCT pc.id, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto, 
                        pc.status_expediente, pc.telefono,pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, pc.hora_pago, 
                        pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, pc.tipo_proyectopersonal, 
                        pc.sitio_tipoproyectopersonal, pc.id_sitiopersonal, pc.name_sitio,
                        pc.delete_status, pp.id AS idpuesto, pp.nombre AS name_puesto, ea.cobro
                        FROM personal_campo pc
                        INNER JOIN puestos_personal pp ON pc.puesto = pp.id
                        INNER JOIN epp_asignar ea ON pc.id = ea.id_personal
                        WHERE ea.cobro = ? and pc.nombre like '%{$nombre}%'
                        ORDER BY pc.nombre ASC LIMIT $offset,$no_of_records_per_page",array($cobro));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
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
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // Consulta Personal EPP


    public function GetAllProveedor($table){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM proveedor
                ORDER BY nombre_prov ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // Consulta Personal EPP


     public function GetSolStepEPP(){ 
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT *
                FROM epp_solicitudes where step_uno = 0");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }


    public function GetStockStep(){ 
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT *
                FROM epp_stock where step_uno = 0");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }


    public function GetSolStepEPPSpecific($id_user){ 
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT *
                FROM epp_solicitudes where step_uno = 0 and id_usuario = $id_user");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }


    public function GetStepEpppaginator($offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida,
                        e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.puesto, 
                        pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 0 LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET INFO TO PAGINATOR


    public function GetStepStockpaginator($offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id,e.id_usuario, e.name_usuario, e.status_stock, e.fecha_recibido,
                        e.step_uno, e.comprobante_doc, e.comentarios, e.id_proveedor, e.name_proveedor
                        FROM epp_stock e 
                        where e.step_uno = 0 LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET INFO TO PAGINATOR



    public function GetStepEppSpecificpaginator($id_user,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida,
                        e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, pc.puesto, 
                        pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 0 and e.id_usuario = $id_user LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET INFO TO PAGINATOR SPECIFIC


    public function insertsolepp1($post,$table,$id_user,$name_user){
        
        try {
            $row = $this->createRow();
            $row->id_usuario = $id_user;
            $row->name_usuario = $name_user;
            $row->id_personal = $post['personal'];
            $row->comentarios = $post['comentarios'];
            $row->fecha_requerida = $post['fecha_requerida'];
            $res = $row->save();              
            return $res;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   // END INSERT PASO 1 SOLICITUD EPP

    public function UpdateSolPUno($post,$table,$id_user,$name_user){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET fecha_requerida = ?, id_usuario = ?, name_usuario = ?, id_personal = ?, comentarios = ? WHERE id = ?",
                array(
                $post['fecha_requerida'],
                $id_user,
                $name_user,
                $post['personal'],
                $post['comentarios'],
                $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   // END UPDATE PASO 1 SOLICITUD EPP

    public function GetPersonalSel($id_personal){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM personal_campo WHERE id = $id_personal");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }


    public function GetEppAsgAct($id_personal){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ea.id, ea.cantidad, ea.descripcion, ea.cobro, 
                        IF(ea.cobro != 2 , IF(ea.cobro = 0, 'Sin Costo Extra', 'Se Aplicara Costo') , 'Descuento Efectuado') AS cobroe, ea.comentario, ea.talla, ea.fecha_entrega, ea.reposicion, ea.id_personal, ea.tipo_epp, 
                        ea.status_epp, ea.comprado_campo,ea.id_epp, ec.nombre, ec.talla as t_e, ec.descripcion as desc_e, ec.stock,
                        ec.costo_aprobado, ec.tiempo_vida 
                        FROM epp_asignar ea 
                        LEFT JOIN
                        epp_catalogo ec ON ea.id_epp = ec.idepp
                        WHERE id_personal = ? AND status_epp = 0 ORDER BY fecha_entrega ASC",array($id_personal));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    } // Consulta Epp Asignado Actualmente

    public function insertasignacionsol($post,$table,$tipo){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'cantidad'=>$post['cantidad'],
                'descripcion'=>$post['epp'],
                'talla'=>$post['talla'],
                'id_personal'=>$post['idhs'],
                'tipo_epp'=>$tipo,
                'id_epp'=>$post['talla'],
                'id_sol'=>$post['solid']
            );
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    }// END Insert EPP por asignar


    public function GetEppXasg($id){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ea.id, ea.cantidad, ea.descripcion, ea.cobro, 
                        IF(ea.cobro != 2 , IF(ea.cobro = 0, 'Sin Costo Extra', 'Se Aplicara Costo') , 'Descuento Efectuado') AS cobroe, ea.talla, ea.id_personal, ea.tipo_epp, ea.status_epp, ea.comprado_campo,ea.id_epp, ea.id_sol, 
                        ec.nombre, ec.talla as t_e, ec.descripcion as desc_e, ec.stock, ec.costo_aprobado, ec.tiempo_vida, 
                        et.nombre as nombretipo
                        FROM epp_asignarsol ea 
                        LEFT JOIN epp_catalogo ec ON ea.id_epp = ec.idepp
                        LEFT JOIN epp_tipo et ON et.id_tipo = ea.tipo_epp
                        WHERE ea.id_sol = ? and ea.status_epp = 0 ORDER BY ea.id ASC",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    } // Consulta Epp Por Asignar


    public function GetEppXasgSinStatus($id){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ea.id, ea.cantidad, ea.descripcion, ea.cobro, 
                        IF(ea.cobro != 2 , IF(ea.cobro = 0, 'Sin Costo Extra', 'Se Aplicara Costo') , 'Descuento Efectuado') AS cobroe, ea.talla, ea.id_personal, ea.tipo_epp, ea.epp_asignado, ea.fecha_entrega, ea.status_epp, 
                        ea.comprado_campo, ea.id_epp, ea.id_sol, ec.nombre,ec.talla as t_e, ec.descripcion as desc_e, ec.stock, 
                        ec.costo_aprobado, ec.tiempo_vida, et.nombre as nombretipo
                        FROM epp_asignarsol ea 
                        LEFT JOIN epp_catalogo ec ON ea.id_epp = ec.idepp
                        LEFT JOIN epp_tipo et ON et.id_tipo = ea.tipo_epp
                        WHERE ea.id_sol = ? ORDER BY ea.id ASC",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    } // Consulta Epp Por Asignar Sin status


    public function GetEppXasgStatus($id){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ea.id, ea.cantidad, ea.descripcion, ea.cobro, 
                        IF(ea.cobro != 2 , IF(ea.cobro = 0, 'Sin Costo Extra', 'Se Aplicara Costo') , 'Descuento Efectuado') AS cobroe, ea.talla, ea.id_personal, ea.tipo_epp, ea.epp_asignado, ea.fecha_entrega, ea.status_epp, 
                        ea.comprado_campo, ea.id_epp, ea.id_sol, ec.nombre,ec.talla as t_e, ec.descripcion as desc_e, ec.stock, ec.presentacion,
                        ec.costo_aprobado, ec.tiempo_vida, et.nombre as nombretipo
                        FROM epp_asignarsol ea 
                        LEFT JOIN epp_catalogo ec ON ea.id_epp = ec.idepp
                        LEFT JOIN epp_tipo et ON et.id_tipo = ea.tipo_epp
                        WHERE ea.id_sol = ? and ea.epp_asignado = 1 ORDER BY ea.id ASC",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    } // Consulta Epp Por Asignar Sin status

    public function UpdateSolPasDos($post,$table,$hoy){
        $pasodos = 1; 
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET step_uno = ?, fecha_solicitud = ? WHERE id = ?",array(
                $pasodos,
                $hoy,
                $post['idsol']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   // END UPDATE PASO 2 SOLICITUD EPP 


    ///////////////////////////////// Lista epp_solicitudes Almacen ////////////////////////////////////////////////////////////


    public function GetUserSolicitudAlmCount(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 1 and e.status_surtido = 0 order by e.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // Consulta Solicitudes en Proceso Almacen  


    public function GetPagSolProcesoAlm($table,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 1 and e.status_surtido = 0 
                        order by e.id ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Paginacion Solicitudes en Proceso Almacen 


    ///////////////////////////////// Lista epp_solicitudes Admin ////////////////////////////////////////////////////////////

    public function GetSolCount(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 0 and e.status_surtido = 0 order by e.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET SOLICITUDES  COUNT

    public function GetSolProcesopaginator($table,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 0 and e.status_surtido = 0 
                        order by e.id ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //Paginacion Solicitudes en Proceso

    public function GetSolEppAceptCount(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 1 and e.status_surtido = 0 order by e.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET SOLICITUDES  COUNT Acerptadas



    public function GetSolAceptadaspaginator($table,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 1 and e.status_surtido = 0 
                        order by e.id ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //Paginacion Solicitudes Aceptadas


    public function GetSolEppCancelCount(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 2 and e.status_surtido = 0 order by e.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET SOLICITUDES  COUNT Canceladas/Rechazadas



    public function GetSolCanceladaspaginator($table,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 2 and e.status_surtido = 0 
                        order by e.id ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //Paginacion Solicitudes Canceladas/Rechazadas


    public function GetSolEppSurtidoCount(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 1 and e.status_surtido = 1 order by e.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET SOLICITUDES COUNT Surtidas



    public function GetSolSurtidaspaginator($table,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 1 and e.status_surtido = 1 
                        order by e.id ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //Paginacion Solicitudes Surtidas

    /////////////////////////////////////////////// Buscadores Admin  /////////////////////////////////////////////////////////

     public function GetSolEPPBuscar($personal,$statusstep,$statussol,$statussur){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = $statusstep and e.status_solicitud = $statussol and e.status_surtido = $statussur 
                        AND e.id_personal = ? Order By e.id ASC",array($personal));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por Personal

    public function GetSolEPPBuscarPag($table,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statussur){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = $statusstep and e.status_solicitud = $statussol and e.status_surtido = $statussur 
                        AND e.id_personal = ? Order By e.id ASC LIMIT $offset,$no_of_records_per_page",array($personal));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por Personal


     public function GetSolIdEppBuscar($id,$statusstep,$statussol,$statussur){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = $statusstep and e.status_solicitud = $statussol and e.status_surtido = $statussur 
                        AND e.id = ? order by e.id ASC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por ID

    public function GetSolIdEppBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statussur){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = $statusstep and e.status_solicitud = $statussol and e.status_surtido = $statussur 
                        AND e.id = ? order by e.id ASC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por ID


    public function GetSolUserEPPBuscar($user,$statusstep,$statussol,$statussur){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = $statusstep and e.status_solicitud = $statussol and e.status_surtido = $statussur 
                        AND e.name_usuario like '%{$user}%' order by e.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por Usuario


     public function GetSolUserEPPBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statussur){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = $statusstep and e.status_solicitud = $statussol and e.status_surtido = $statussur 
                        AND e.name_usuario like '%{$user}%' order by e.id ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por Usuario


    //////////////////////////////////////// Lista solicitudes Specific ////////////////////////////////////////////////

    public function GetSolspfCount($id){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 0 and e.status_surtido = 0 and e.id_usuario = $id 
                        order by e.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET SOLICITUDES  COUNT



    public function GetSolProcesoSpfpaginator($table,$id,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 0 and e.status_surtido = 0  and e.id_usuario = $id 
                        order by e.id ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //Paginacion Solicitudes en Proceso

    public function GetSolEppAceptSpfCount($id){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 1 and e.status_surtido = 0 and e.id_usuario = $id 
                        order by e.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET SOLICITUDES  COUNT Acerptadas



    public function GetSolAceptadasSpfpaginator($table,$id,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 1 and e.status_surtido = 0 and e.id_usuario = $id 
                        order by e.id ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //Paginacion Solicitudes Aceptadas


    public function GetSolEppCancelSpfCount($id){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 2 and e.status_surtido = 0 and e.id_usuario = $id 
                        order by e.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET SOLICITUDES  COUNT Canceladas/Rechazadas



    public function GetSolCanceladasSpfpaginator($table,$id,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 2 and e.status_surtido = 0 and e.id_usuario = $id 
                        order by e.id ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //Paginacion Solicitudes Canceladas/Rechazadas


    public function GetSolEppSurtidoSpfCount($id){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 1 and e.status_surtido = 1 and e.id_usuario = $id 
                        order by e.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET SOLICITUDES COUNT Surtidas



    public function GetSolSurtidasSpfpaginator($table,$id,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = 1 and e.status_solicitud = 1 and e.status_surtido = 1 and e.id_usuario = $id 
                        order by e.id ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //Paginacion Solicitudes Surtidas
    

    /////////////////////////////////////////////// Buscadores Specific  /////////////////////////////////////////////////////////

     public function GetSolEPPSpfBuscar($personal,$iduser,$statusstep,$statussol,$statussur){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = $statusstep and e.status_solicitud = $statussol and e.status_surtido = $statussur 
                        AND e.id_usuario = $iduser AND e.id_personal = ? Order By e.id ASC",array($personal));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por Personal

    public function GetSolEPPSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$personal,$statusstep,$statussol,$statussur){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = $statusstep and e.status_solicitud = $statussol and e.status_surtido = $statussur 
                        AND e.id_usuario = $iduser AND e.id_personal = ? Order By e.id ASC 
                        LIMIT $offset,$no_of_records_per_page",array($personal));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por Personal


     public function GetSolIdEppSpfBuscar($id,$iduser,$statusstep,$statussol,$statussur){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = $statusstep and e.status_solicitud = $statussol and e.status_surtido = $statussur 
                        AND e.id_usuario = $iduser AND e.id = ? order by e.id ASC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por ID

    public function GetSolIdEppSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statussur){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = $statusstep and e.status_solicitud = $statussol and e.status_surtido = $statussur 
                        AND e.id_usuario = $iduser AND e.id = ? order by e.id ASC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por ID


    public function GetSolUserEPPSpfBuscar($user,$iduser,$statusstep,$statussol,$statussur){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = $statusstep and e.status_solicitud = $statussol and e.status_surtido = $statussur 
                        AND e.id_usuario = $iduser AND e.name_usuario like '%{$user}%' order by e.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por Usuario


     public function GetSolUserEPPSpfBuscarPag($table,$iduser,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statussur){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_personal, e.id_usuario, e.name_usuario, e.fecha_solicitud, e.fecha_requerida, 
                        e.status_surtido, e.status_solicitud, e.step_uno, e.comentarios, pc.nombre, pc.apellido_pa, pc.apellido_ma, 
                        pc.puesto, pp.nombre as pname 
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        where e.step_uno = $statusstep and e.status_solicitud = $statussol and e.status_surtido = $statussur 
                        AND e.id_usuario = $iduser AND e.name_usuario like '%{$user}%' 
                        order by e.id ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por Usuario


    /////////////////////////////////////////////////////// detalles de solicitud /////////////////////////////////////


    public function GetDetallesEppSol($table,$id){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_usuario, e.name_usuario, e.id_personal, e.fecha_solicitud, e.fecha_requerida,
                        e.status_solicitud, e.step_uno, e.status_surtido, e.comentarios, e.url_responsiva, e.fecha_aprobada, 
                        e.user_aprobado, e.name_useraprobado, e.fecha_rechazado, e.user_rechazado, e.name_userrechazado, 
                        e.comentarios_rechazo, e.fecha_surtido, e.user_surtido, e.name_usersurtido, pc.imagen,
                        pc.nombre as nombreres, pc.apellido_pa as ares, pc.apellido_ma as amres, pc.puesto, pp.nombre as pname
                        FROM epp_solicitudes e 
                        LEFT JOIN personal_campo pc ON pc.id = e.id_personal
                        LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                        WHERE e.id = ? order by e.id ASC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // Detalles de solicitud


    public function UpdateAceptSolEpp($post,$table,$hoy,$name_user){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_solicitud = ?, user_aprobado = ?, fecha_aprobada = ?, name_useraprobado = ? WHERE id = ?",array(
                $post['dato'],
                $post['id_user'],
                $hoy,
                $name_user,
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }//  UPDATE Status Solicitud a Aceptada


    public function UpdateRechazarSolEpp($post,$table,$hoy,$name_user){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_solicitud = ?, user_rechazado = ?, fecha_rechazado = ?, comentarios_rechazo = ?, name_userrechazado = ?  WHERE id = ?",array(
                $post['dato'],
                $post['id_user'],
                $hoy,
                $post['comentario'],
                $name_user,
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }//  UPDATE Status Solicitud a Rechazada


    public function UpdateSurtidaEpp($post,$table,$hoy,$name_user,$status_surtido,$id_usuario,$urldb){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_surtido=?, url_responsiva = ?, fecha_surtido = ?, user_surtido = ?, name_usersurtido = ? WHERE id = ?",array(
                $status_surtido,
                $urldb,
                $hoy,
                $id_usuario,
                $name_user,
                $post['id_solicitud']));
            $db->closeConnection();               
            return $qry;
        } 
        
        catch (Exception $e) {
        
            echo $e;
        
        }
    }// END UPDATE SOLICITUD Surtida EPP

    public function UpdateeppSol($post,$table,$idsol,$status,$hoy){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_epp = ?, fecha_entrega = ? WHERE id_sol = ?",array($status,$hoy,$idsol));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   // UPDATE STATUS 


    public function insertasgEppSol($table,$fechanew, $fecha_entrega, $cantidad, $descripcion, $talla, $id_personal, $id_epp,
                $cobro, $tipo_epp){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'cantidad'=>$cantidad,
                'tipo_epp'=>$tipo_epp,
                'descripcion'=>$descripcion,
                'talla'=>$talla,
                'id_epp'=>$id_epp,
                'fecha_entrega'=>$fecha_entrega,
                'reposicion'=>$fechanew,
                'cobro'=>$cobro,
                'id_personal'=>$id_personal
            );
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    }// END Insert asignar epp a personal desde solicitudes

    public function UpdateStockEppSol($table,$cantidad,$talla){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET stock = stock - ? WHERE idepp = ?",array(
                $cantidad,
                $talla));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   //  Update Stock de EPP desde Solicitudes

    public function insertrespEppSol($idper,$table,$urldb,$fhoy){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'responsiva'=>$urldb,
                'id_personal'=>$idper,
                'fecha'=>$fhoy
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    }//  Insert Responsiva En historial desde solicitudes


     public function UpdateStatusCobro($post,$table){
        
        $statuscobro=1;
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET cobro = ? WHERE id = ?",array(
                $statuscobro,
                $post));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   //  Update Status Cobro solicitud


     public function UpdateReestablecerCobro($solicitud,$table){
        
        $statuscobro=0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET cobro = ? WHERE id_sol = ?",array(
                $statuscobro,
                $solicitud));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   //  Update Reestablecer Cobro


     public function UpdateStatusAsignado($post,$table){
        $status=1;
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET epp_asignado = ? WHERE id = ?",array(
                $status,
                $post));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   //  Update Status Cobro solicitud


    public function UpdateReestablecerAsignar($solicitud,$table){
        $status=0;
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET epp_asignado = ? WHERE id_sol = ?",array(
                $status,
                $solicitud));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   //  Update Reestablecer Cobro

    public function GetSpecificInsertar($table,$wh,$id){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table WHERE $wh = ? and epp_asignado = 1",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    }


    public function DetallesEPPXAsignar($id){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre as nombrep, pc.apellido_pa, pc.apellido_ma, ea.id AS idea, ea.fecha_entrega,
                        ea.tipo_epp, ea.id_epp, ea.cantidad, ea.id_sol, ea.id_personal, ec.idepp, ec.nombre,ec.talla,ec.descripcion, 
                        ec.costo_aprobado, ec.tipo_epp as tipoe, et.nombre as eppt
                        FROM epp_asignarsol ea
                        INNER JOIN personal_campo pc ON ea.id_personal = pc.id
                        LEFT JOIN epp_catalogo ec ON ea.id_epp = ec.idepp
                        LEFT JOIN epp_tipo et ON ea.tipo_epp = et.id_tipo
                        WHERE ea.id = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } // Consulta EPP en solicitudes


    public function UpdEppxAsg($post,$table){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE epp_asignarsol SET talla = ?, id_epp = ? WHERE id = ? ",
                array(
                    $post['tallaget'],
                    $post['tallaget'],
                    $post['idea']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }

    }   //  Update UpdEppxAsg


     public function Updateagregarmontoeppnomina($post,$table,$urldb,$hoy,$nombre_usuario){
        $cobro=3; 
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET monto_pago =?, parcialidad =? ,cobro = ?, fecha_monto = ?, user_monto =? ,evidencia =? WHERE id = ?",array(
                $post['monto'],
                $post['cantidad'],
                $cobro,
                $hoy,
                $nombre_usuario,
                $urldb,
                $post['id_solicitud']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   //  Update Status Cobro


    public function updatesolicitudcobroounoepp($id,$table,$num_pago){
        $status= 2;
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET cantidad_pago = ?, cobro = ? WHERE id = ?",array($num_pago,$status,$id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }//  UPDATE ROL

    public function updatesolicitudcobroodosepp($id,$table,$num_pago){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET cantidad_pago =? WHERE cobro = ?",array($num_pago,$id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }//  UPDATE ROL

    public function insertneweppnomina($post,$table,$id,$descuento,$hoy){
        $tipo = 3;
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_personal'=>$post['user'],
                'nombre'=>$post['sitio'],
                'dia'=>$hoy,
                'id_proyecto'=>$post['id_proyecto'],
                'id_proyecto_salida'=>$post['id_proyecto'],
                'monto_pago'=>$descuento,
                'status_tipos' => $tipo,
                'solicitud_prestamo'=>$id
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    }// END INSERT USER


    public function geteppasignarcobronomina($user){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ea.id, ea.cantidad, ea.descripcion, ea.talla, ea.reposicion,ea.id_personal,
                        ea.comentario, ea.monto_pago, ea.parcialidad, ea.cantidad_pago
                        FROM epp_asignar ea 
                        where cobro = 3 AND id_personal = ? order by ea.id ASC",array($user));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // Detalles de solicitud

    /////////////////////////////////////// Pedidos EPP ////////////////////////////////////////////////////////////


    public function UpdatePedidoUno($post,$table,$id_user,$name_user,$name_proveedor,$urldb){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET fecha_recibido = ?, id_usuario = ?, name_usuario = ?, id_proveedor = ?, name_proveedor = ?, comentarios = ?, comprobante_doc = ? WHERE id = ?",
                array(
                $post['fecharecibido'],
                $id_user,
                $name_user,
                $post['proveedor'],
                $name_proveedor,
                $post['comentarios'],
                $urldb,
                $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   // END UPDATE PASO 1 PEDIDIDO EPP



    public function insertaddstock1($post,$table,$tipo){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'cantidad'=>$post['cantidad'],
                'descripcion'=>$post['epp'],
                'talla'=>$post['talla'],
                'tipo_epp'=>$tipo,
                'id_epp'=>$post['talla'],
                'id_stock'=>$post['pedid']
            );
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    }// END Insert EPP que llego



    public function GetEppxPedido($id){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT es.id, es.cantidad, es.descripcion, es.talla, es.id_epp, es.tipo_epp, es.id_stock, es.epp_add, 
                        ec.nombre, ec.talla as t_e, et.nombre as nombretipo
                        FROM epp_stockadd es 
                        LEFT JOIN epp_catalogo ec ON es.id_epp = ec.idepp
                        LEFT JOIN epp_tipo et ON et.id_tipo = es.tipo_epp
                        WHERE es.id_stock = ? and es.epp_add = 0 ORDER BY es.id ASC",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    } // Consulta Epp del pedido


    public function GetEppxPedidoEntrega($id){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT es.id, es.cantidad, es.descripcion, es.talla, es.id_epp, es.tipo_epp, es.id_stock, es.epp_add, 
                        ec.nombre, ec.talla as t_e, et.nombre as nombretipo
                        FROM epp_stockadd es 
                        LEFT JOIN epp_catalogo ec ON es.id_epp = ec.idepp
                        LEFT JOIN epp_tipo et ON et.id_tipo = es.tipo_epp
                        WHERE es.id_stock = ? and es.epp_add = 1 ORDER BY es.id ASC",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    } // Consulta Epp del pedido


    public function UpdateEppPedidoEntregado($post,$table,$idpedido,$status){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET epp_add = ? WHERE id_stock = ?",array($status,$idpedido));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   // UPDATE STATUS 


    public function GetSpecificStockAdd($table,$wh,$pedido){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table WHERE $wh = ? and epp_add = 1",array($pedido));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    }


    public function UpdateSumarStock($table,$cantidad,$talla){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET stock = stock + ? WHERE idepp = ?",array(
                $cantidad,
                $talla));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   //  Update Stock de EPP PEdidos


    public function UpdatePedidoPasoDos($post,$table,$hoy,$pedidocomplete){
        $pasodos = 1; 
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET step_uno = ?, fecha_creacion = ?, status_stock = ? WHERE id = ?",array(
                $pasodos,
                $hoy,
                $pedidocomplete,
                $post['idpedido']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
        
            echo $e;
        
        }
    }   // END UPDATE PASO 2 PEDIDO EPP 


    public function GetPedidosCount(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_usuario, e.name_usuario, e.comprobante_doc, e.fecha_recibido, 
                        e.status_stock, e.id_proveedor, e.step_uno, e.comentarios, e.name_proveedor, e.fecha_creacion
                        FROM epp_stock e 
                        where e.step_uno = 1 order by e.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET PEDIDOS  COUNT


    public function GetPedidospaginator($table,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_usuario, e.name_usuario, e.comprobante_doc, e.fecha_recibido, 
                        e.status_stock, e.id_proveedor, e.step_uno, e.comentarios, e.name_proveedor, e.fecha_creacion
                        FROM epp_stock e 
                        where e.step_uno = 1 
                        order by e.id ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //Paginacion Solicitudes en Proceso


    public function GetPedidosEPPBuscar($statusped,$statusstep){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_usuario, e.name_usuario, e.comprobante_doc, e.fecha_recibido, 
                        e.status_stock, e.id_proveedor, e.step_uno, e.comentarios, e.name_proveedor, e.fecha_creacion
                        FROM epp_stock e 
                        where e.step_uno = $statusstep AND e.status_stock = ? Order By e.id ASC",array($statusped));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por Status

    public function GetPedEPPBuscarPag($table,$offset,$no_of_records_per_page,$statusped,$statusstep){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_usuario, e.name_usuario, e.comprobante_doc, e.fecha_recibido, 
                        e.status_stock, e.id_proveedor, e.step_uno, e.comentarios, e.name_proveedor, e.fecha_creacion
                        FROM epp_stock e 
                        where e.step_uno = $statusstep AND e.status_stock = ? Order By e.id ASC LIMIT $offset,$no_of_records_per_page",array($statusped));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por Status


    public function GetPedidosEPPBuscarId($id,$statusstep){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_usuario, e.name_usuario, e.comprobante_doc, e.fecha_recibido, 
                        e.status_stock, e.id_proveedor, e.step_uno, e.comentarios, e.name_proveedor, e.fecha_creacion
                        FROM epp_stock e 
                        where e.step_uno = $statusstep AND e.id = ? Order By e.id ASC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por ID

    public function GetPedEPPBuscarPagId($table,$offset,$no_of_records_per_page,$id,$statusstep){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_usuario, e.name_usuario, e.comprobante_doc, e.fecha_recibido, 
                        e.status_stock, e.id_proveedor, e.step_uno, e.comentarios, e.name_proveedor, e.fecha_creacion
                        FROM epp_stock e 
                        where e.step_uno = $statusstep AND e.id = ? Order By e.id ASC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por ID

    public function GetPedidosEPPBuscarPrv($proveedor,$statusstep){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_usuario, e.name_usuario, e.comprobante_doc, e.fecha_recibido, 
                        e.status_stock, e.id_proveedor, e.step_uno, e.comentarios, e.name_proveedor, e.fecha_creacion
                        FROM epp_stock e 
                        where e.step_uno = $statusstep AND e.name_proveedor like '%{$proveedor}%' order by e.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por Proveedor


     public function GetPedEPPBuscarPagPrv($table,$offset,$no_of_records_per_page,$proveedor,$statusstep){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_usuario, e.name_usuario, e.comprobante_doc, e.fecha_recibido, 
                        e.status_stock, e.id_proveedor, e.step_uno, e.comentarios, e.name_proveedor, e.fecha_creacion
                        FROM epp_stock e 
                        where e.step_uno = $statusstep AND e.name_proveedor like '%{$proveedor}%' order by e.id ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por Proveedor


    public function GetDetallesEppPedido($table,$id){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_usuario, e.name_usuario, e.comprobante_doc, e.fecha_recibido, 
                        e.status_stock, e.id_proveedor, e.step_uno, e.comentarios, e.name_proveedor, e.fecha_creacion,
                        p.nombre_prov, p.telefono, p.rfc, p.datos_banco, p.cuenta, p.tarjeta, p.titular, p.email
                        FROM epp_stock e 
                        LEFT JOIN proveedor p ON p.id = e.id_proveedor
                        WHERE e.id = ? order by e.id ASC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   // Detalles de Pedido

} 