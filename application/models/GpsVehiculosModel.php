<?php

class Application_Model_GpsVehiculosModel extends Zend_Db_Table_Abstract{
    protected $_name = 'vehiculos_solicitudes';
    protected $_primary = 'id';
    
    public function Getpaginationveh($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT v.id_vehiculos, v.marca, v.submarca, v.modelo, v.placas, v.color, v.id_responsable, 
                v.id_status, v.id_grupo, v.imagen, v.comentarios, v.fecha, v.fechar, v.comentarior, v.porcentaje_doc,
                v.fechab, v.comentariob, v.evidenciab, IF(vg.nombre is null, 'Sin Asignar', vg.nombre) as grupo,
                IF(p.nombre IS NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma 
                FROM vehiculos v 
                LEFT JOIN vehiculos_grupo vg ON vg.id_grupo = v.id_grupo
                LEFT JOIN personal_campo p ON v.id_responsable = p.id
                ORDER BY v.marca  ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e; 
        }
    }   // CONSULTA VEHICULOS

    public function marca($name){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT v.id_vehiculos, v.marca, v.submarca, v.modelo, v.placas, v.color, v.id_responsable,
                v.id_status, v.id_grupo, v.imagen, v.comentarios, v.fecha, v.fechar, v.comentarior,
                v.fechab, v.comentariob, v.evidenciab, IF(vg.nombre is null, 'Sin Asignar', vg.nombre) as grupo
                FROM vehiculos v 
                LEFT JOIN vehiculos_grupo vg ON vg.id_grupo = v.id_grupo 
                WHERE v.marca like '%{$name}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // BUSCAR POR MARCA 

    public function marcavcount($name,$offset,$no_of_records_per_page){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT v.id_vehiculos, v.marca, v.submarca, v.modelo, v.placas, v.color, v.id_responsable,
                v.id_status, v.id_grupo, v.imagen, v.comentarios, v.fecha, v.fechar, v.comentarior, v.porcentaje_doc,
                v.fechab, v.comentariob, v.evidenciab, IF(vg.nombre is null, 'Sin Asignar', vg.nombre) as grupo,
                IF(p.nombre IS NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma 
                FROM vehiculos v 
                LEFT JOIN vehiculos_grupo vg ON vg.id_grupo = v.id_grupo 
                LEFT JOIN personal_campo p ON v.id_responsable = p.id
                WHERE v.marca like '%{$name}%' 
                LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // BUSCAR POR MARCA COUNT

    public function placas($placas){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT v.id_vehiculos, v.marca, v.submarca, v.modelo, v.placas, v.color, v.id_responsable,
                v.id_status, v.id_grupo, v.imagen, v.comentarios, v.fecha, v.fechar, v.comentarior,
                v.fechab, v.comentariob, v.evidenciab, IF(vg.nombre is null, 'Sin Asignar', vg.nombre) as grupo
                FROM vehiculos v 
                LEFT JOIN vehiculos_grupo vg ON vg.id_grupo = v.id_grupo 
                WHERE v.placas like '%{$placas}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // BUSCAR POR PLACAS 

    public function placasvcount($placas,$offset,$no_of_records_per_page){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT v.id_vehiculos, v.marca, v.submarca, v.modelo, v.placas, v.color, v.id_responsable,
                v.id_status, v.id_grupo, v.imagen, v.comentarios, v.fecha, v.fechar, v.comentarior, v.porcentaje_doc,
                v.fechab, v.comentariob, v.evidenciab, IF(vg.nombre is null, 'Sin Asignar', vg.nombre) as grupo,
                IF(p.nombre IS NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma 
                FROM vehiculos v 
                LEFT JOIN vehiculos_grupo vg ON vg.id_grupo = v.id_grupo 
                LEFT JOIN personal_campo p ON v.id_responsable = p.id
                WHERE v.placas like '%{$placas}%' 
                LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // BUSCAR POR PLACAS COUNT

     public function status($status){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT v.id_vehiculos, v.marca, v.submarca, v.modelo, v.placas, v.color, v.id_responsable,
                v.id_status, v.id_grupo, v.imagen, v.comentarios, v.fecha, v.fechar, v.comentarior,
                v.fechab, v.comentariob, v.evidenciab, IF(vg.nombre is null, 'Sin Asignar', vg.nombre) as grupo
                FROM vehiculos v 
                LEFT JOIN vehiculos_grupo vg ON vg.id_grupo = v.id_grupo
                WHERE v.id_status = ?",array($status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // BUSCAR POR STATUS

    public function statusvcount($status,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT v.id_vehiculos, v.marca, v.submarca, v.modelo, v.placas, v.color, v.id_responsable,
                v.id_status, v.id_grupo, v.imagen, v.comentarios, v.fecha, v.fechar, v.comentarior, v.porcentaje_doc,
                v.fechab, v.comentariob, v.evidenciab, IF(vg.nombre is null, 'Sin Asignar', vg.nombre) as grupo,
                IF(p.nombre IS NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma 
                FROM vehiculos v 
                LEFT JOIN vehiculos_grupo vg ON vg.id_grupo = v.id_grupo
                LEFT JOIN personal_campo p ON v.id_responsable = p.id
                WHERE v.id_status = ? LIMIT $offset,$no_of_records_per_page",array($status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // BUSCAR POR STATUS COUNT


    public function insertveh($post,$table,$urldb,$urldb2){
        $status = 0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'imagen'=>$urldb,
                'tarjeta_circulacion'=>$urldb2,
                'marca'=>$post['marca'],
                'submarca'=>$post['submarca'],
                'modelo'=>$post['modelo'],
                'placas'=>$post['placas'],
                'no_serie'=>$post['serie'],
                'color'=>$post['color'],
                'tag'=>$post['tag'],
                'efecticard'=>$post['efecticard'],
                'comentarios'=>$post['com'],
                'id_status'=>$status,
                'id_grupo'=>$post['grupo']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }//  INSERT VEHICULO

    public function updateveh($post,$table,$urldb,$urldb2){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET imagen = ?, tarjeta_circulacion = ?, marca = ?, submarca = ?, modelo = ?, placas = ?, no_serie = ?, color = ?, tag = ?, efecticard = ?, comentarios = ?, id_grupo = ? WHERE id_vehiculos = ? ",
                array(
                    $urldb,
                    $urldb2,
                    $post['marca'],
                    $post['submarca'],
                    $post['modelo'],
                    $post['placas'],
                    $post['serie'],
                    $post['color'],
                    $post['tag'],
                    $post['efecticard'],
                    $post['com'],
                    $post['grupo'],
                    $post['ids']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE VEHICULO


    public function GetAdoc($table,$id){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT *
from vehiculos_tpodoc vt 
where id not in ( 
    SELECT vt.id
    from vehiculos_tpodoc vt
    left JOIN vehiculos_documentacion vd ON vd.tipo_doc = vt.id
    where id_vehiculo = $id and vd.status = 0 OR id_vehiculo = $id and vd.status = 2
) ");
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function GetNumeroDocumentos($table){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT count(*) as numero FROM $table");
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function GettpDocumentos($table,$id){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM vehiculos_tpodoc vt
                LEFT JOIN vehiculos_documentacion vd ON vd.tipo_doc = vt.id
                WHERE id_vehiculo = $id ");
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    public function GetProcentaje($table,$idv){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT porcentaje_doc FROM $table where id_vehiculos = $idv");
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    

    public function GetVehiculos($table,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT v.id_vehiculos, v.marca, v.submarca, v.modelo, v.placas, v.color, v.created_at, v.id_responsable, v.id_status, v.id_grupo, v.imagen, v.comentarios, v.fecha, v.fechar, v.comentarior, v.tarjeta_circulacion, v.porcentaje_doc, v.tag, v.efecticard, v.no_serie,
                v.fechab, v.comentariob, v.evidenciab, IF(vg.nombre is null, 'Sin Asignar', vg.nombre) as grupo
                FROM vehiculos v 
                LEFT JOIN vehiculos_grupo vg ON vg.id_grupo = v.id_grupo
                WHERE v.id_vehiculos = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA VEHICULOS

     public function GetPersonalV(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM personal_campo where status_personal = 0 ORDER BY nombre ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // CONSULTA PERSONAL ORDEN


    public function GetdatosV($wh,$id){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT v.id_vehiculos, v.marca, v.submarca, v.modelo, v.placas, v.color, v.id_status, v.id_grupo, 
                v.imagen, v.comentarios, v.id_responsable, v.fecha, v.fecha, v.fechar, v.comentarior,
                v.fechab, v.comentariob, v.evidenciab, vg.nombre AS grupo, IF(p.nombre IS NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma 
                FROM vehiculos v
                LEFT JOIN vehiculos_grupo vg ON vg.id_grupo = v.id_grupo
                LEFT JOIN personal_campo p ON v.id_responsable = p.id
                WHERE $wh = ?",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }   //DATOS PERSONAL ASIGNADO

    public function UpdateStatusVeh($post,$table,$hoy){
        $status=1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_responsable = ? , id_status = ?, fecha = ? WHERE id_vehiculos = ?",array(
                $post['responsable'],
                $status,
                $hoy,
                $post["idveh"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  UPDATE ASIGNAR VEHICULO


     public function updateTarjeta($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  tarjeta_circulacion = ? WHERE id_vehiculos = ?",array(
                $urldb,
                $post['idhs']
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  ACTUALIZAR Mantienimiento

    public function InsertVehOp($post,$table,$hoy,$efecticard,$urldb){
        $status=1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_responsable'=>$post['responsable'],
                'status_veh'=>$status,
                'fecha_asignacion'=>$hoy,
                'archivo'=>$urldb,
                'tarjeta_efecticard'=>$efecticard,
                'id_vehiculo'=>$post['idveh'],
                'comentarios'=>$post['comentarios']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }   //  INSERT VEHICULOS-OPERADORES

    public function UpdateStatusReturn($post,$table){
        $status=0;
        $responsable=0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_responsable = ? , id_status = ? WHERE id_vehiculos = ?",array(
                $responsable,
                $status,
                $post["idveh"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  UPDATE REGRESAR VEHICULO 

    public function UpdateVehOp($post,$table,$hoy,$urldb){
        $statusv=1;
        $status=2;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET fecha_entrega = ? , status_veh = ?, archivo2 = ? WHERE id_vehiculo = ? AND status_veh = ?",array(
                $hoy,
                $status,
                $urldb,
                $post["idveh"],
                $statusv
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  UPDATE ASIGNAR VEHICULO


    public function UpdateStatusVB($post,$table,$urldb,$hoy){
        $status=3;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_status = ? , comentariob = ? , evidenciab = ?, fechab = ? WHERE id_vehiculos = ?",array(
                $status,
                $post["motivos"],
                $urldb,
                $hoy,
                $post["idh"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  BAJA VEHICULO

    public function insertrepmanto($post,$table,$urldb){
        $statusv =1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'status_veh'=>$statusv,
                'id_vehiculo'=>$post['idhs'],
                'tipo_manto'=>$post['tipom'],
                'fecha_manto'=>$post['fecham'],
                'kilometraje'=>$post['kilometrajem'],
                'servicio_realizado'=>$post['serviciom'],
                'costo'=>$post['costom'],
                'imagen_servicio'=>$urldb
            );
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT REPARACION MANTENIMIENTO

    public function insertrepinc($post,$table,$urldb1,$urldb2){
        $statusv =1;
        $statusi =1;

        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'status_veh'=>$statusv,
                'nombre_incidente'=>$post['nombrei'],
                'id_vehiculo'=>$post['idhs'],
                'id_personal'=>$post['personali'],
                'status_incidente'=>$statusi,
                'imagen_veh'=>$urldb1,
                'imagen_incidente'=>$urldb2,
                'accion'=>$post['accioni'],
                'costo'=>$post['costoi'],
                'fecha_incidente'=>$post['fechai'],
                'comentarios'=>$post['comentarioi']
            );
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT REPARACION INCIDENTE

    public function UpdateManto($post,$table,$hoy){
        $statusv = 0;
        $statusa = 1;

        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  fecha_rep = ?, status_veh = ? WHERE id_vehiculo = ? AND status_veh = ?",array(
                $hoy,
                $statusv,
                $post["id"],
                $statusa
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  ACTUALIZAR FECHA DE REPARACION MANTENIMIENTO


    public function insertdoc($post,$table,$urldb,$nombredoc,$hoy){
        $statusv =0;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'status'=>$statusv,
                'id_vehiculo'=>$post['idhs'],
                'fecha'=>$hoy,
                'tipo_doc'=>$post['nombred'],
                'nombre_doc'=>$nombredoc,
                'vigencia'=>$post['vigencia'],
                'id_sol'=>$post['solicitud'],
                'comentarios'=>$post['comentarios'],
                'documento'=>$urldb
            );
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT Documentacion


    public function insertdoc2($post,$table,$nombredoc,$hoy){
        $statusv =2;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'status'=>$statusv,
                'id_vehiculo'=>$post['idhs'],
                'fecha'=>$hoy,
                'tipo_doc'=>$post['nombred'],
                'nombre_doc'=>$nombredoc,
                'vigencia'=>$post['vigencia'],
                'id_sol'=>$post['solicitud'],
                'comentarios'=>$post['comentarios']
            );
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT Documentacion

    public function updateporcentaje($post,$table,$nuevoporcentaje){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  porcentaje_doc = ? WHERE id_vehiculos = ?",array(
                $nuevoporcentaje,
                $post["idhs"]
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  ACTUALIZAR Porcentaje +

     public function updateporcentaje2($post,$table,$nuevoporcentaje,$idv){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  porcentaje_doc = ? WHERE id_vehiculos = ?",array(
                $nuevoporcentaje,
                $idv
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  ACTUALIZAR Porcentaje -


    public function updateAsgSol($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  veh_rep = ?, id_sol = ? WHERE id_incidente = ?",array(
                $urldb,
                $post['solicitud'],
                $post['idi']
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  ACTUALIZAR Incidente

    public function updateMtnSol($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  veh_rep = ?, id_sol = ? WHERE id_manto = ?",array(
                $urldb,
                $post['solicitud'],
                $post['idi']
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  ACTUALIZAR Mantienimiento

    public function updatesol($post,$table){
        $statusa = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  status_asignada = ? WHERE id = ?",array(
                $statusa,
                $post["solicitud"]
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  ACTUALIZAR FECHA DE REPARACION MANTENIMIENTO


    public function updateArcOp($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  archivo = ? WHERE id = ?",array(
                $urldb,
                $post['idi']
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  ACTUALIZAR Archivo1 Operadores

    public function updateArc2Op($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  archivo2 = ? WHERE id = ?",array(
                $urldb,
                $post['idi']
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  ACTUALIZAR Archivo2 Operadores

    public function UpdateInc($post,$table,$hoy){
        $statusv = 0;
        $statusi = 2;
        $statusa = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  fecha_reparado = ?, status_veh = ?, status_incidente = ? WHERE id_vehiculo = ? AND status_veh = ?",array(
                $hoy,
                $statusv,
                $statusi,
                $post["id"],
                $statusa
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  ACTUALIZAR FECHA DE REPARACION INCIDENTE

    public function UpdateStatusVRM($post,$table){
        $status=2;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_status = ?, comentarior = ?, fechar = ? WHERE id_vehiculos = ?",array(
                $status,
                $post["serviciom"],
                $post["fecham"],
                $post["idhs"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  UPDATE VEHICULO A REPARAR MANTENIMIENTO

    public function UpdateStatusVRI($post,$table){
        $status=2;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_status = ?, comentarior = ?, fechar = ? WHERE id_vehiculos = ?",array(
                $status,
                $post["accioni"],
                $post["fechai"],
                $post["idhs"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  UPDATE VEHICULO A REPARAR INCIDENTE

    public function UpdateStatusRep($post,$table){
        $status=0;
        $responsable=0;
        $comentario="";
        $fechar="";
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_responsable = ? , id_status = ? , comentarior = ? , fechar = ? WHERE id_vehiculos = ?",array(
                $responsable,
                $status,
                $comentario,
                $fechar,
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   // UPDATE VEHICULO REPARADO   


    public function Getpaginationgrupo($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT id_grupo, nombre
                FROM $table
                order by id_grupo asc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }  // CONSULTA GRUPOS

    public function insertgrupo($post,$table){
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
    }//  INSERT GRUPO

    public function updategrupo($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre = ? WHERE id_grupo = ? ",
                array(
                    $post['name'],
                    $post['ids']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   // END  REQUEST UPDATE GRUPO


    public function excelvh($table){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT  v.id_vehiculos, v.marca, v.submarca, v.modelo, v.placas, v.color, v.id_responsable, 
                v.id_status, IF(v.id_status != 2, IF(v.id_status != 1, IF(v.id_status = 0, 'Disponible', 'Baja'), 'Ocupado'),'En Taller') AS nstatus, v.id_grupo, v.imagen, v.comentarios, v.fecha, v.fechar, v.comentarior, v.no_serie,
                v.fechab, v.comentariob, v.evidenciab, 
                IF(vg.nombre IS NULL, 'Sin Asignar', vg.nombre) AS grupo,
                IF(p.nombre IS NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma 
                FROM vehiculos v
                LEFT JOIN vehiculos_grupo vg ON vg.id_grupo = v.id_grupo
                LEFT JOIN personal_campo p ON v.id_responsable = p.id
                ORDER BY v.id_vehiculos ASC
                ");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // EXCEL VEHICULOS

    public function GetordernombresitiosV(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM sitios ORDER BY nombre ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // CONSULTA SITIOS ORDEN

    public function insertservicio($post,$table,$statusu,$statusd,
                $statust,$statuscu,$statusci,$statusse,$statussi){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombre_servicio'=>$post['names'],
                'evidencia_uno'=>$post['namecuno'], 
                'status_uno'=>$statusu, 
                'tipo_uno'=>$post['statusuno'],  
                'evidencia_dos'=>$post['namecdos'], 
                'status_dos'=>$statusd, 
                'tipo_dos'=>$post['statusdos'], 
                'evidencia_tres'=>$post['namectres'], 
                'status_tres'=>$statust, 
                'tipo_tres'=>$post['statustres'], 
                'evidencia_cuatro'=>$post['nameccuatro'],  
                'status_cuatro'=>$statuscu, 
                'tipo_cuatro'=>$post['statuscuatro'], 
                'evidencia_cinco'=>$post['nameccinco'],  
                'status_cinco'=>$statusci, 
                'tipo_cinco'=>$post['statuscinco'], 
                'evidencia_seis'=>$post['namecseis'], 
                'status_seis'=>$statusse, 
                'tipo_seis'=>$post['statusseis'], 
                'evidencia_siete'=>$post['namecsiete'], 
                'status_siete'=>$statussi,
                'tipo_siete'=>$post['statussiete'], 

            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }//  INSERT SERVICIOS

    public function updateServicioV($post,$table,$statusu,$statusd,
                $statust,$statuscu,$statusci,$statusse,$statussi){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  nombre_servicio = ?, evidencia_uno = ?, status_uno = ?, tipo_uno = ?, 
                evidencia_dos = ?, status_dos = ?, tipo_dos = ?, evidencia_tres = ?, status_tres = ?, tipo_tres = ?, 
                evidencia_cuatro = ?, status_cuatro = ?, tipo_cuatro = ?, evidencia_cinco = ?, status_cinco = ?,
                tipo_cinco = ?, evidencia_seis = ?, status_seis = ?, tipo_seis = ?, evidencia_siete = ?, status_siete = ?,
                tipo_siete = ? WHERE id = ?",array(
                $post['names'],
                $post['namecuno'],
                $statusu,
                $post['statusuno'],
                $post['namecdos'], 
                $statusd, 
                $post['statusdos'],
                $post['namectres'],
                $statust,
                $post['statustres'],
                $post['nameccuatro'],
                $statuscu,
                $post['statuscuatro'],
                $post['nameccinco'],
                $statusci, 
                $post['statuscinco'],
                $post['namecseis'],
                $statusse, 
                $post['statusseis'],
                $post['namecsiete'],
                $statussi,
                $post['statussiete'], 
                $post['ids']
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   //  ACTUALIZAR Incidente

    public function GetVehiculosAsignado($table,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vo.id, vo.id_responsable, vo.status_veh, 
                IF(vo.status_veh = 1, 'Vigente', 'Entregado') as statusv, 
                vo.fecha_asignacion, vo.fecha_entrega, 
                IF(vo.fecha_entrega is null, 'Vehículo con el usuario', vo.fecha_entrega) as fentrega , vo.id_vehiculo,
                vo.tarjeta_efecticard, IF(vo.tarjeta_efecticard is null, 'Sin Efecticard Asignada', vo.tarjeta_efecticard) as efecticard,
                vo.archivo, vo.archivo2, pc.nombre, pc.apellido_pa, pc.apellido_ma,  v.marca, v.submarca, v.modelo, v.color, v.placas
                FROM vehiculos_operadores vo
                LEFT JOIN personal_campo pc ON pc.id = vo.id_responsable
                LEFT JOIN vehiculos v ON v.id_vehiculos = vo.id_vehiculo
                WHERE vo.id_vehiculo = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA ASIGNACION VEHICULOS

    public function GetpaginationOperador($table,$offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vo.id, vo.id_responsable, vo.status_veh, 
                IF(vo.status_veh = 1, 'Vigente', 'Entregado') as statusv, 
                vo.fecha_asignacion, vo.fecha_entrega, vo.archivo, vo.archivo2,
                IF(vo.fecha_entrega is null, 'Vehículo con el usuario', vo.fecha_entrega) as fentrega , vo.id_vehiculo,
                vo.tarjeta_efecticard, IF(vo.tarjeta_efecticard is null, 'Sin Efecticard Asignada', vo.tarjeta_efecticard) as efecticard,
                pc.nombre, pc.apellido_pa, pc.apellido_ma, v.marca, v.submarca, v.modelo, v.color, v.placas
                FROM vehiculos_operadores vo
                LEFT JOIN personal_campo pc ON pc.id = vo.id_responsable
                LEFT JOIN vehiculos v ON v.id_vehiculos = vo.id_vehiculo
                WHERE vo.id_vehiculo = $id LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e; 
        }
    }   // CONSULTA ASIGNACION VEHICULOS PAGINACION

 
    public function GetVehiculosDoc($table,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vd.id, vd.tipo_doc, vd.id_vehiculo, vd.nombre_doc, vd.fecha, vd.vigencia,
            vd.status, IF(vd.status = 0, 'Vigente', 'Vencido') as statusd, vd.comentarios, vd.documento, vd.id_sol,
            vp.comprobante_pago, v.marca, v.submarca, v.modelo, v.color, v.placas 
            FROM vehiculos_documentacion vd
            LEFT JOIN vehiculos v ON v.id_vehiculos = vd.id_vehiculo
            LEFT JOIN vehiculos_pagos vp ON vp.id_solicitud = vd.id_sol
            WHERE vd.id_vehiculo = ? AND vd.status = 0 OR vd.id_vehiculo = $id AND vd.status = 2",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA DOCUMENTACION VEHICULOS

    public function GetpaginationDoc($table,$offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vd.id, vd.tipo_doc, vd.id_vehiculo, vd.nombre_doc, vd.fecha, vd.vigencia,
            vd.status, IF(vd.status = 0, 'Vigente', 'Vencido') as statusd, vd.comentarios, vd.documento, vd.id_sol,
            vp.comprobante_pago, v.marca, v.submarca, v.modelo, v.color, v.placas 
            FROM vehiculos_documentacion vd
            LEFT JOIN vehiculos v ON v.id_vehiculos = vd.id_vehiculo
            LEFT JOIN vehiculos_pagos vp ON vp.id_solicitud = vd.id_sol
            WHERE vd.id_vehiculo = $id AND vd.status = 0 OR vd.id_vehiculo = $id AND vd.status = 2 LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e; 
        }
    }   // CONSULTA ASIGNACION VEHICULOS PAGINACION

    public function GetVehiculosDocH($table,$id,$año){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vd.id, vd.tipo_doc, vd.id_vehiculo, vd.nombre_doc, vd.fecha, vd.vigencia,
            YEAR(DATE(vigencia)) AS Año,
            vd.status, IF(vd.status = 0, 'Vigente', 'Vencido') as statusd, vd.comentarios, vd.documento, vd.id_sol,
            vp.comprobante_pago, v.marca, v.submarca, v.modelo, v.color, v.placas 
            FROM vehiculos_documentacion vd
            LEFT JOIN vehiculos v ON v.id_vehiculos = vd.id_vehiculo
            LEFT JOIN vehiculos_pagos vp ON vp.id_solicitud = vd.id_sol
            having vd.id_vehiculo = ? and vd.status = 0 and Año = $año OR vd.id_vehiculo = $id and vd.status = 1 and Año = $año ORDER BY vd.status ASC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA DOCUMENTACION VEHICULOS

    public function GetpaginationDocH($table,$offset,$no_of_records_per_page,$id,$año){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vd.id, vd.tipo_doc, vd.id_vehiculo, vd.nombre_doc, vd.fecha, vd.vigencia,
            YEAR(DATE(vigencia)) AS Año,
            vd.status, IF(vd.status = 0, 'Vigente', 'Vencido') as statusd, vd.comentarios, vd.documento, vd.id_sol,
            vp.comprobante_pago, v.marca, v.submarca, v.modelo, v.color, v.placas 
            FROM vehiculos_documentacion vd
            LEFT JOIN vehiculos v ON v.id_vehiculos = vd.id_vehiculo
            LEFT JOIN vehiculos_pagos vp ON vp.id_solicitud = vd.id_sol
            having vd.id_vehiculo = $id and vd.status = 0 and Año = $año OR vd.id_vehiculo = $id and vd.status = 1 and Año = $año ORDER BY vd.status ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e; 
        }
    }   // CONSULTA ASIGNACION VEHICULOS PAGINACION

    public function GetSolicitudes($table,$id){
        $statusas = 0;

        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.total, 
                vs.status_solicitud, vs.id_proveedor, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.status_comprobante, vs.status_asignada, vs.fecha_validacion, p.nombre as nombrer, 
                p.apellido_pa as apr, p.apellido_ma as amr, sv.nombre_servicio, pr.nombre_prov, vp.fecha_pago, vp.comprobante_pago,
                vp.monto as MontoPagado
                FROM vehiculos_solicitudes vs
                LEFT JOIN personal_campo p ON p.id = vs.id_responsable
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor pr ON pr.id = vs.id_proveedor
                LEFT JOIN vehiculos_pagos vp ON vp.id_solicitud = vs.id
                WHERE vs.step_veh = 1 and vs.status_solicitud = 1 and vs.status_asignada = $statusas and vs.id_vehiculo = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA DOCUMENTACION VEHICULOS

    public function GetVehiculosManto($table,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vm.id_manto, vm.status_veh, vm.id_vehiculo, vm.tipo_manto,
                IF(vm.tipo_manto =1 ,'Mantenimiento Preventivo','Mantenimiento Correctivo') AS tmanto, vm.fecha_manto,
                vm.fecha_rep, IF(vm.fecha_rep IS NULL,'Vehículo en mantenimiento', vm.fecha_rep) AS frep, vm.kilometraje,
                vm.servicio_realizado, vm.costo, vm.comprobante_servicio, vm.imagen_servicio, v.marca, v.submarca, v.modelo, 
                v.color, v.placas, vm.veh_rep, vm.id_sol, vp.comprobante_pago,  vp.monto as MontoPagado
                FROM vehiculos_manto vm 
                LEFT JOIN vehiculos v ON v.id_vehiculos = vm.id_vehiculo
                LEFT JOIN vehiculos_pagos vp ON vp.id_solicitud = vm.id_sol
                WHERE vm.id_vehiculo = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA MANTENIMIENTO VEHICULOS


    public function GetVehiculosDocE($table,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vd.id, vd.tipo_doc, vd.id_vehiculo, vd.nombre_doc, vd.fecha, vd.vigencia,
            YEAR(DATE(vigencia)) AS Año,
            vd.status, IF(vd.status = 0, 'Vigente', 'Vencido') as statusd, vd.comentarios, vd.documento, vd.id_sol,
            vp.comprobante_pago, v.marca, v.submarca, v.modelo, v.color, v.placas 
            FROM vehiculos_documentacion vd
            LEFT JOIN vehiculos v ON v.id_vehiculos = vd.id_vehiculo
            LEFT JOIN vehiculos_pagos vp ON vp.id_solicitud = vd.id_sol
            WHERE vd.id_vehiculo = ? and vd.status = 0 OR vd.id_vehiculo = $id and vd.status = 1 ORDER BY vd.vigencia ASC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA DOCUMENTACION VEHICULOS GENERal

    public function GetpaginationMto($table,$offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vm.id_manto, vm.status_veh, vm.id_vehiculo, vm.tipo_manto, 
                IF(vm.tipo_manto =1 ,'Mantenimiento Preventivo','Mantenimiento Correctivo') AS tmanto, vm.fecha_manto,
                vm.fecha_rep, IF(vm.fecha_rep IS NULL,'Vehículo en mantenimiento', vm.fecha_rep) AS frep, vm.kilometraje,
                vm.servicio_realizado, vm.costo, vm.comprobante_servicio, vm.imagen_servicio, v.marca, v.submarca, v.modelo, 
                v.color, v.placas, vm.veh_rep, vm.id_sol, vp.comprobante_pago,  vp.monto as MontoPagado
                FROM vehiculos_manto vm 
                LEFT JOIN vehiculos v ON v.id_vehiculos = vm.id_vehiculo
                LEFT JOIN vehiculos_pagos vp ON vp.id_solicitud = vm.id_sol
                WHERE vm.id_vehiculo = $id LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e; 
        }
    }   // CONSULTA MANTENIMIENTO VEHICULOS PAGINACION

    public function GetVehiculosIncidente($table,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vi.id_incidente, vi.status_veh, vi.nombre_incidente, vi.id_vehiculo,
                vi.id_personal, vi.status_incidente, IF(vi.status_incidente = 1,'En Proceso','Atendido') AS incidentest,
                vi.imagen_veh, vi.imagen_incidente, vi.accion, vi.costo, vi.fecha_incidente, vi.id_sol, vi.fecha_reparado, 
                vi.comentarios, vi.veh_rep, IF(vi.fecha_reparado IS NULL,'Vehículo en reparacion', vi.fecha_reparado) AS frep, 
                pc.nombre, pc.apellido_pa, pc.apellido_ma, v.marca, v.submarca, v.modelo, v.color, v.placas, vp.comprobante_pago,
                 vp.monto as MontoPagado
                FROM vehiculos_incidentes vi
                LEFT JOIN personal_campo pc ON pc.id = vi.id_personal
                LEFT JOIN vehiculos v ON v.id_vehiculos = vi.id_vehiculo
                LEFT JOIN vehiculos_pagos vp ON vp.id_solicitud = vi.id_sol
                WHERE vi.id_vehiculo = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA INCIDENTE VEHICULOS


    public function GetpaginationInc($table,$offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vi.id_incidente, vi.status_veh, vi.nombre_incidente, vi.id_vehiculo,
                vi.id_personal, vi.status_incidente, IF(vi.status_incidente = 1,'En Proceso','Atendido') AS incidentest,
                vi.imagen_veh, vi.imagen_incidente, vi.accion, vi.costo, vi.fecha_incidente, vi.id_sol, vi.fecha_reparado, 
                vi.comentarios, vi.veh_rep, IF(vi.fecha_reparado IS NULL,'Vehículo en reparacion', vi.fecha_reparado) AS frep, 
                pc.nombre, pc.apellido_pa, pc.apellido_ma, v.marca, v.submarca, v.modelo, v.color, v.placas, vp.comprobante_pago,
                 vp.monto as MontoPagado
                FROM vehiculos_incidentes vi
                LEFT JOIN personal_campo pc ON pc.id = vi.id_personal
                LEFT JOIN vehiculos v ON v.id_vehiculos = vi.id_vehiculo
                LEFT JOIN vehiculos_pagos vp ON vp.id_solicitud = vi.id_sol
                WHERE vi.id_vehiculo = $id LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e; 
        }
    }   // CONSULTA INCIDENTE VEHICULOS PAGINACION

    public function GetpaginationservicioV($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT id, nombre_servicio FROM $table
                                LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //END GET INFO TO PAGINATOR


    public function GetProvedores($table){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table where tipo_proveedor = 1");
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    }

    //////////////////////////////////////////// SOLICITUDES VEHICULOS ////////////////////////////////////////////////
    
    public function GetUserSolicitudCount(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.id_proveedor, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, vs.monto, vs.iva, vs.total, p.nombre_prov, vs.status_comprobante, vs.iva, vs.total,
                u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, v.placas, sv.nombre_servicio
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 0 and vs.status_comprobante = 0 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Consulta Solicitudes en Proceso


    public function GetPagSolProceso($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov, vs.status_comprobante, vs.iva, vs.total
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 0 and vs.status_comprobante = 0 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Paginacion Solicitudes en Proceso

    public function GetSolAceptCount(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov, vs.status_comprobante
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 1 and vs.status_comprobante = 0 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Solicitudes Aceptadas


    public function GetPagSolAcept($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov, vs.status_comprobante
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 1 and vs.status_comprobante = 0 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Paginacion Solicitudes en Aceptadas  


    public function GetSolCancelCount(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov, vs.status_comprobante
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 2 and vs.status_comprobante = 0 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Solicitudes Canceladas


    public function GetPagSolCancel($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov, vs.status_comprobante
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 2 and vs.status_comprobante = 0 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Paginacion Solicitudes en Canceladas 


    public function GetSolCancelCountFact(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov, vs.status_comprobante
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 2 and vs.status_comprobante = 0 and vs.facturable = 2 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Solicitudes Canceladas Facturable.


    public function GetPagSolCancelFact($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov, vs.status_comprobante
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 2 and vs.status_comprobante = 0 and vs.facturable = 2 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Paginacion Solicitudes en Canceladas Facturable.


    public function GetSolFinCount(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.status_comprobante, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh,
                vs.motivos, vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, 
                v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 1 and vs.status_comprobante = 1 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Solicitudes Terminada


    public function GetPagSolFin($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.status_comprobante,vs.fecha_sol, vs.fecha_pagada, vs.step_veh, 
                vs.motivos, vs.iva, vs.total, vs.monto, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, 
                v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 1 and vs.status_comprobante = 1 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Paginacion Solicitudes en Terminada 


    public function GetSolFinCountFact(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.status_comprobante, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh,
                vs.motivos, vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, 
                v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 1 and vs.status_comprobante = 1 and vs.facturable = 2 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Solicitudes Terminada Facturacion


    public function GetPagSolFinFact($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.status_comprobante,vs.fecha_sol, vs.fecha_pagada, vs.step_veh, 
                vs.motivos, vs.iva, vs.total, vs.monto, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, 
                v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 1 and vs.status_comprobante = 1 and vs.facturable = 2 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Paginacion Solicitudes en Terminada  Facturacion

    ////////////////////////////////////////////BUSCADOR/////////////////////////////////////////////////

    public function GetSolVehiculoBuscar($vehiculo,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom AND vs.id_vehiculo = ? order by vs.id DESC",array($vehiculo));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor por vehiculo

    public function GetSolVehiculoBuscarPag($table,$offset,$no_of_records_per_page,$vehiculo,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom AND  vs.id_vehiculo = ? order by vs.id DESC LIMIT $offset,$no_of_records_per_page",array($vehiculo));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor en Paginacion por vehiculo 



    public function GetSolVehiculoBuscarFact($vehiculo,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom and vs.facturable = 2 AND vs.id_vehiculo = ? order by vs.id DESC",array($vehiculo));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor por vehiculo facturable

    public function GetSolVehiculoBuscarFactPag($table,$offset,$no_of_records_per_page,$vehiculo,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom and vs.facturable = 2 AND  vs.id_vehiculo = ? order by vs.id DESC LIMIT $offset,$no_of_records_per_page",array($vehiculo));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor en Paginacion por vehiculo  facturable



    public function GetSolProvBuscar($prov,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom AND p.nombre_prov like '%{$prov}%' order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor por PROVEEDOR 


     public function GetSolProvBuscarPag($table,$offset,$no_of_records_per_page,$prov,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom AND p.nombre_prov like '%{$prov}%' order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor en Paginacion por proveedor


    public function GetSolProvBuscarFact($prov,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom and vs.facturable = 2 AND p.nombre_prov like '%{$prov}%' order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor por PROVEEDOR 


     public function GetSolProvBuscarPagFact($table,$offset,$no_of_records_per_page,$prov,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom and vs.facturable = 2 AND p.nombre_prov like '%{$prov}%' order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor en Paginacion por proveedor


    public function GetSolIdBuscar($id,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom AND vs.id = ? order by vs.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor por ID

    public function GetSolIdBuscarPag($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom AND  vs.id = ? order by vs.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor en Paginacion por ID

    public function GetSolIdBuscarFact($id,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom and vs.facturable = 2 AND vs.id = ? order by vs.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor por ID Facturacion 

    public function GetSolIdBuscarPagFact($table,$offset,$no_of_records_per_page,$id,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom and vs.facturable = 2 AND  vs.id = ? order by vs.id DESC LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor en Paginacion por ID Facturacion 


    public function GetSolUserBuscar($user,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom AND u.nombre like '%{$user}%' order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor por Usuario


     public function GetSolUserBuscarPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom AND u.nombre like '%{$user}%' order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor en Paginacion por Usuario

    public function GetSolUserBuscarFact($user,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom and vs.facturable = 2 AND u.nombre like '%{$user}%' order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor por Usuario Fact


     public function GetSolUserBuscarFactPag($table,$offset,$no_of_records_per_page,$user,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom and vs.facturable = 2 AND u.nombre like '%{$user}%' order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor en Paginacion por Usuario Fact



    public function GetSolServicioBuscar($servicio,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom AND vs.id_servicios = ? order by vs.id DESC",array($servicio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor por servicios

    public function GetSolServicioBuscarPag($table,$offset,$no_of_records_per_page,$servicio,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom AND  vs.id_servicios = ? order by vs.id DESC LIMIT $offset,$no_of_records_per_page",array($servicio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor en Paginacion por servicios 


    public function GetSolServicioBuscarFact($servicio,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom and vs.facturable = 2 AND vs.id_servicios = ? order by vs.id DESC",array($servicio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor por servicios Facturable

    public function GetSolServicioBuscarFactPag($table,$offset,$no_of_records_per_page,$servicio,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom and vs.facturable = 2 AND  vs.id_servicios = ? order by vs.id DESC LIMIT $offset,$no_of_records_per_page",array($servicio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor en Paginacion por servicios  Facturable


    public function GetSolPlacasBuscar($placas,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom AND v.placas like '%{$placas}%' order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor por Placas


     public function GetSolPlacasBuscarPag($table,$offset,$no_of_records_per_page,$placas,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom AND v.placas like '%{$placas}%' order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor en Paginacion por Placas

    public function GetSolPlacasBuscarfact($placas,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom and vs.facturable = 2 AND v.placas like '%{$placas}%' order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor por Placas Facturacion


     public function GetSolPlacasBuscarfactPag($table,$offset,$no_of_records_per_page,$placas,$statusstep,$statussol,$statuscom){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh = $statusstep and vs.status_solicitud = $statussol and vs.status_comprobante = $statuscom and vs.facturable = 2 AND v.placas like '%{$placas}%' order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Buscardor en Paginacion por Placas Facturacion

    ////////////////////////////////////// End Buscadores ////////////////////////////////////////////////////////

    public function GetSolStepUno(){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.fecha_sol, vs.step_veh, vs.motivos
                FROM vehiculos_solicitudes vs where vs.step_veh = 0");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function GetStepVpaginator($offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.fecha_sol, vs.step_veh, vs.motivos, u.nombre, u.ap, u.am, v.marca, v.submarca, 
                v.modelo, v.color, v.placas, sv.nombre_servicio
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                where vs.step_veh = 0 LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR

    public function insertsolveh($post,$table,$id_user,$responsable){
        try {
            $row = $this->createRow();
            $row->id_vehiculo = $post['vehiculo'];
            $row->id_servicios = $post['servicio'];
            $row->id_proveedor = $post['proveedor'];
            $row->referencia = $post['referencia'];
            $row->id_responsable = $responsable;
            $row->fecha_sol = $post['fecha_requerida'];
            $row->motivos = $post['motivo'];
            $row->facturable = $post['facturable'];
            $row->monto = $post['monto'];
            $row->iva = $post['iva'];
            $row->total = $post['total'];
            $row->id_usuario = $id_user;
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }   // END INSERT PASO 1 SOLICITUD VEHICULO

    public function UpdateSolPasUno($post,$table,$id_user,$responsable){
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET fecha_sol = ?, id_servicios = ?, id_vehiculo = ?, id_proveedor = ?, monto = ?, iva= ?, total = ?, id_responsable = ?, referencia =?, motivos = ? WHERE id = ?",array(
                $post['fecha_requerida'],
                $post['servicio'],
                $post['vehiculo'],
                $post['proveedor'],
                $post['monto'],
                $post['iva'],
                $post['total'],
                $responsable,
                $post['referencia'],                
                $post['motivo'],
                $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   // END UPDATE PASO 1 SOLICITUD VEHICULO

    public function UpdateSolPasDos($post,$table,$datouno,$datodos,$datotres,$datocuatro,$datocinco,$datoseis,$datosiete,$hoy){
        $pasodos = 1; 
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET step_veh = ?, datouno = ?, statusuno = ?, tipouno = ?, datodos = ?, statusdos = ?, tipodos = ?, datotres = ?, statustres = ?, tipotres = ?, datocuatro = ?, statuscuatro = ?, tipocuatro = ?, datocinco = ?, statuscinco = ?, tipocinco = ?, datoseis = ?, statusseis = ?, tiposeis = ?, datosiete = ?, statussiete = ?, tiposiete = ?, fecha_creacion = ? WHERE id = ?",array(
                $pasodos,
                $datouno,
                $post['statusuno'],
                $post['tipouno'],
                $datodos,
                $post['statusdos'],
                $post['tipodos'],
                $datotres,
                $post['statustres'],
                $post['tipotres'],
                $datocuatro,
                $post['statuscuatro'],
                $post['tipocuatro'],
                $datocinco,
                $post['statuscinco'],
                $post['tipocinco'],
                $datoseis,
                $post['statusseis'],
                $post['tiposeis'],
                $datosiete,
                $post['statussiete'],
                $post['tiposiete'],
                $hoy,
                
                $post['idsol']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   // END UPDATE PASO 2 SOLICITUD VEHICULO


    public function GetServicios($id_servicios){
         try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM vehiculo_servicios vs WHERE id = $id_servicios");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function GetDetalles($table,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.id_sitio, 
                vs.referencia, vs.id_proveedor, vs.status_solicitud, vs.step_veh, vs.fecha_sol, vs.fecha_pagada, 
                vs.monto, vs.iva, vs.total, vs.motivos, vs.datouno, vs.statusuno, vs.tipouno, vs.datodos, 
                vs.statusdos, vs.tipodos, 
                vs.datotres, vs.statustres, vs.tipotres, vs.datocuatro, vs.statuscuatro, vs.tipocuatro, vs.datocinco, 
                vs.statuscinco, vs.tipocinco, vs.datoseis, vs.statusseis, vs.tiposeis, vs.datosiete, vs.statussiete, 
                vs.tiposiete, vs.status_comprobante, vs.user_val, vs.fecha_validacion, vs.fecha_cancelacion, 
                vs.motivo_rechazo, vs.fecha_creacion, vs.user_pago,

                u.nombre, u.ap, u.am, 
                us.nombre as nombreap, us.ap as apap, us.am as amap, 
                uss.nombre as nombrep, uss.ap as app, uss.am as amp, 

                r.nombre as nombreres, r.apellido_pa as ares, r.apellido_ma as amres,

                v.marca, v.submarca, v.modelo, v.color, v.placas,v.imagen, 

                sv.nombre_servicio, sv.evidencia_uno, sv.evidencia_dos, sv.evidencia_tres, sv.evidencia_cuatro,
                sv.evidencia_cinco, sv.evidencia_seis, sv.evidencia_siete,

                p.nombre_prov, p.telefono, p.rfc, p.datos_banco, p.cuenta, p.titular, p.email
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN usuario us ON us.id = vs.user_val
                LEFT JOIN usuario uss ON us.id = vs.user_pago
                LEFT JOIN personal_campo r ON r.id = vs.id_responsable
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                WHERE vs.id = ? order by vs.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Detalles de solicitud



    public function GetDetallesConta($table,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.id_sitio, 
                vs.referencia, vs.id_proveedor, vs.status_solicitud, vs.step_veh, vs.fecha_sol, vs.fecha_pagada, 
                vs.monto, vs.iva, vs.total, vs.motivos, vs.datouno, vs.statusuno, vs.tipouno, vs.datodos,
                 vs.statusdos, vs.tipodos, 
                vs.datotres, vs.statustres, vs.tipotres, vs.datocuatro, vs.statuscuatro, vs.tipocuatro, vs.datocinco, 
                vs.statuscinco, vs.tipocinco, vs.datoseis, vs.statusseis, vs.tiposeis, vs.datosiete, vs.statussiete, 
                vs.tiposiete, vs.status_comprobante, vs.user_val, vs.fecha_validacion, vs.fecha_cancelacion, 
                vs.motivo_rechazo, vs.fecha_creacion, vs.user_pago,

                u.nombre, u.ap, u.am, 
                us.nombre as nombreap, us.ap as apap, us.am as amap, 
                uss.nombre as nombrep, uss.ap as app, uss.am as amp, 

                r.nombre as nombreres, r.apellido_pa as ares, r.apellido_ma as amres,

                v.marca, v.submarca, v.modelo, v.color, v.placas,v.imagen, 

                sv.nombre_servicio, sv.evidencia_uno, sv.evidencia_dos, sv.evidencia_tres, sv.evidencia_cuatro,
                sv.evidencia_cinco, sv.evidencia_seis, sv.evidencia_siete,

                p.nombre_prov, p.telefono, p.rfc, p.datos_banco, p.cuenta, p.titular, p.email
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN usuario us ON us.id = vs.user_val
                LEFT JOIN usuario uss ON us.id = vs.user_pago
                LEFT JOIN personal_campo r ON r.id = vs.id_responsable
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                WHERE vs.id = ? order by vs.id DESC",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Detalles de solicitud


    public function UpdateAceptSol($post,$table,$hoy){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_solicitud = ?, user_val = ?, fecha_validacion = ?  WHERE id = ?",array(
                $post['dato'],
                $post['id_user'],
                $hoy,
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE Status Solicitud a Aceptada

    public function UpdateRechazarSol($post,$table,$hoy){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_solicitud = ?, user_val = ?, fecha_cancelacion = ?, motivo_rechazo = ?  WHERE id = ?",array(
                $post['dato'],
                $post['id_user'],
                $hoy,
                $post['comentario'],
                $post["id"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE Status Solicitud a Rechazada

    public function UpdatePagoSolV($post,$table,$hoy,$status_pago,$id_usuario){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_comprobante=?, fecha_pagada=?, user_pago=? WHERE id = ?",array(
                $status_pago,
                $hoy,
                $id_usuario,
                $post['id_solicitud']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD SERVICIOS VEHICULO


    public function InsertPagoSerVeh($post,$table,$urldb,$hoy,$nombre){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_solicitud'=>$post['id_solicitud'],
                'fecha_pago'=>$hoy,
                'user_pago'=>$nombre,
                'comprobante_pago'=>$urldb,
                'monto'=>$post['monto']);
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT DOCUMENTO COTIZACION

    ////////////////////////////////// Solicitudes Contabilidad //////////////////////////////////////////////////////////////

    public function GetUserSolicitudContCount(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.id_proveedor, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, vs.monto, vs.iva, vs.total, p.nombre_prov, vs.status_comprobante,
                u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, v.placas, sv.nombre_servicio
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 1 and vs.status_comprobante = 0 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Consulta Solicitudes en Proceso Contabilidad 


    public function GetPagSolProcesoCont($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, 
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov, vs.status_comprobante
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 1 and vs.status_comprobante = 0 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Paginacion Solicitudes en Proceso Contabilidad


     public function GetUserSolicitudContFact(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.id_proveedor, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, p.nombre_prov, vs.status_comprobante,
                u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, v.placas, sv.nombre_servicio
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 1 and vs.status_comprobante = 0 and vs.facturable = 2 order by vs.id DESC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Consulta Solicitudes en Proceso Contabilidad  Sin Facturacion


    public function GetPagSolProcesoContFact($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vs.id, vs.id_responsable, vs.id_usuario, vs.id_vehiculo, vs.id_servicios, vs.facturable,
                vs.status_solicitud, vs.referencia, vs.fecha_sol, vs.fecha_pagada, vs.step_veh, vs.motivos, 
                vs.monto, vs.iva, vs.total, vs.id_proveedor, u.nombre, u.ap, u.am, v.marca, v.submarca, v.modelo, v.color, 
                v.placas, sv.nombre_servicio, p.nombre_prov, vs.status_comprobante
                FROM vehiculos_solicitudes vs 
                LEFT JOIN usuario u ON u.id = vs.id_usuario
                LEFT JOIN vehiculos v ON v.id_vehiculos = vs.id_vehiculo
                LEFT JOIN vehiculo_servicios sv ON sv.id = vs.id_servicios
                LEFT JOIN proveedor p ON p.id = vs.id_proveedor
                where vs.step_veh= 1 and vs.status_solicitud = 1 and vs.status_comprobante = 0 and vs.facturable = 2 order by vs.id DESC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   //Paginacion Solicitudes en Proceso Contabilidad Sin Facturacion


    public function GetVigencias($table){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * from $table where vigencia between curdate() and date_add(curdate(), interval 30 day) AND status = 0");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Vigencia para alertas.

     public function GetVigenciasAll($table){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vd.id, vd.tipo_doc, vd.id_vehiculo, vd.nombre_doc, vd.fecha, vd.vigencia,
            vd.status, IF(vd.status = 0, 'Vigente', 'Vencido') as statusd, vd.comentarios, vd.documento, vd.id_sol,
            v.marca, v.submarca, v.modelo, v.color, v.placas 
            FROM vehiculos_documentacion vd
            LEFT JOIN vehiculos v ON v.id_vehiculos = vd.id_vehiculo
            WHERE vd.vigencia between curdate() and date_add(curdate(), interval 30 day) AND vd.status = 0");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Vigencia para alertas.


    public function GetVigenciasven($table){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vd.id, vd.tipo_doc, vd.id_vehiculo, vd.nombre_doc, vd.fecha, vd.vigencia, 
            vd.status, IF(vd.status = 0, 'Vigente', 'Vencido') as statusd, vd.comentarios, vd.documento, vd.id_sol,
            v.marca, v.submarca, v.modelo, v.color, v.placas 
            FROM vehiculos_documentacion vd
            LEFT JOIN vehiculos v ON v.id_vehiculos = vd.id_vehiculo
            WHERE vd.vigencia BETWEEN NOW() - INTERVAL 30 DAY AND NOW() - INTERVAL 1 DAY AND vd.status = 0");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Vigencia para alertas Vencidas.


    public function GetVigenciasSpecific($table,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vd.id, vd.tipo_doc, vd.id_vehiculo, vd.nombre_doc, vd.fecha, vd.vigencia,
            vd.status, IF(vd.status = 0, 'Vigente', 'Vencido') as statusd, vd.comentarios, vd.documento, vd.id_sol,
            v.marca, v.submarca, v.modelo, v.color, v.placas 
            FROM vehiculos_documentacion vd
            LEFT JOIN vehiculos v ON v.id_vehiculos = vd.id_vehiculo
            WHERE vd.vigencia between curdate() and date_add(curdate(), interval 30 day) AND vd.status = 0 AND vd.id_vehiculo = $id");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Vigencia para alertas.
    
    public function GetVigenciasvenSpecific($table,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vd.id, vd.tipo_doc, vd.id_vehiculo, vd.nombre_doc, vd.fecha, vd.vigencia, 
            vd.status, IF(vd.status = 0, 'Vigente', 'Vencido') as statusd, vd.comentarios, vd.documento, vd.id_sol,
            v.marca, v.submarca, v.modelo, v.color, v.placas 
            FROM vehiculos_documentacion vd
            LEFT JOIN vehiculos v ON v.id_vehiculos = vd.id_vehiculo
            WHERE vd.vigencia BETWEEN NOW() - INTERVAL 30 DAY AND NOW() - INTERVAL 1 DAY AND vd.status = 0 AND vd.id_vehiculo = $id");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Vigencia para alertas Vencidas.

    public function Getpaginationtipodoc($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table order by id asc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // Get Tipo de Documentos

      public function inserttipodoc($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'nombredoc'=>$post['name']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }   //  INSERT Tipo de Documento


    public function updatetipodoc($post,$table){

        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombredoc = ? WHERE id = ? ",
                array(
                    $post['name'],
                    $post['ids']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   // END Tipo de Documento

    public function updatedocvig($post,$table){
        $status = 1; 
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status = ? WHERE id = ?",array(
                $status,
                $post["idi"]));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }//  UPDATE Status Solicitud a Aceptada


    public function updatedocedit($post,$table,$urldb){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET vigencia = ?, documento = ?, comentarios = ? WHERE id = ? ",
                array(
                    $post['vigencia'],
                    $urldb,
                    $post['comentarios'],
                    $post['iddocumento']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   // END UPDATE DOCUMENTO


    public function GetVehAsigOperador($table,$id,$status){
         try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT vo.id, vo.id_responsable , vo.status_veh , vo.fecha_asignacion , vo.fecha_entrega , vo.id_vehiculo , vo.tarjeta_efecticard,
                vo.comentarios, v.id_vehiculos , v.marca , v.submarca , v.modelo , v.placas , v.tag, v.efecticard, v.color , v.imagen, 
                pc.id as id_personal , pc.nombre , pc.apellido_pa , pc.apellido_ma , pc.imagen as imagenper , pc.telefono , pc.puesto , pc.email_personal, 
                pc.id_sitiopersonal, pc.name_sitio, pc.sitio_tipoproyectopersonal, pp.nombre as nombre_puesto, s.id_cliente, s.nombre as nombresitio, 
                st.id_tipoproyecto, tp.nombre_proyecto
                FROM vehiculos_operadores vo 
                LEFT JOIN vehiculos v ON v.id_vehiculos = vo.id_vehiculo
                LEFT JOIN personal_campo pc ON pc.id = vo.id_responsable
                LEFT JOIN puestos_personal pp ON pp.id = pc.puesto
                LEFT JOIN sitios s ON s.id = pc.id_sitiopersonal
                LEFT JOIN sitios_tipoproyecto st ON st.id = pc.sitio_tipoproyectopersonal
                LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                WHERE vo.id_vehiculo = ? AND vo.status_veh = $status ORDER BY vo.fecha_asignacion ASC",array($id));
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        } catch (Exception $e) {
            echo $e;
        }
    } // Consulta Epp Asignado
} 