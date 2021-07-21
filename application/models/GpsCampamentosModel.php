<?php

class Application_Model_GpsCampamentosModel extends Zend_Db_Table_Abstract{

    public function Getpaginationcam($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id_campamento, c.id_sitio, c.id_proyecto, c.fecha_solicitud, c.inicio_renta, c.fin_renta,
                        c.monto_renta, c.nombre_arrendador, c.tel_arrendador, c.pago_deposito, c.deposito, c.status_anticipo,
                        IF(c.deposito = 0, 'Sin Previo Deposito', c.deposito) AS depositos, c.status_campamento, c.condiciones_dev, 
                        c.pago_servicios, c.comentarios, c.contrato, c.id_responsable, s.Idgps, s.id_cliente, s.nombre, tp.id, 
                        tp.nombre_proyecto, st.id_tipoproyecto, st.id_sitio AS idsi, st.residente, 
                        IF(p.nombre IS NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma, pu.nombre AS puesto,
                        sc.nombre AS nstatus
                        FROM campamentos c
                        LEFT JOIN sitios s ON s.id = c.id_sitio
                        LEFT JOIN tipo_proyecto tp ON tp.id = c.id_proyecto
                        LEFT JOIN sitios_tipoproyecto st ON st.id_sitio = c.id_sitio AND st.id_tipoproyecto = c.id_proyecto
                        LEFT JOIN personal_campo p ON p.id = c.id_responsable
                        LEFT JOIN puestos_personal pu ON pu.id = p.puesto
                        LEFT JOIN campamentos_status sc ON sc.id_status = c.status_anticipo
                        ORDER BY c.status_campamento ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA CAMPAMENTOS

    public function sitio($name){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id_campamento, c.id_sitio, c.id_proyecto, c.fecha_solicitud, c.inicio_renta, c.fin_renta,
                        c.monto_renta, c.nombre_arrendador, c.tel_arrendador, c.pago_deposito, c.deposito, c.status_anticipo,
                        IF(c.deposito = 0, 'Sin Previo Deposito', c.deposito) AS depositos,c.status_campamento, c.condiciones_dev, 
                        c.pago_servicios, c.comentarios, c.contrato, c.id_responsable, s.Idgps, s.id_cliente, s.nombre, tp.id, 
                        tp.nombre_proyecto, st.id_tipoproyecto, st.id_sitio AS idsi, st.residente, 
                        IF(p.nombre IS NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma, pu.nombre AS puesto,
                        sc.nombre AS nstatus
                        FROM campamentos c
                        LEFT JOIN sitios s ON s.id = c.id_sitio
                        LEFT JOIN tipo_proyecto tp ON tp.id = c.id_proyecto
                        LEFT JOIN sitios_tipoproyecto st ON st.id_sitio = c.id_sitio AND st.id_tipoproyecto = c.id_proyecto
                        LEFT JOIN personal_campo p ON p.id = c.id_responsable
                        LEFT JOIN puestos_personal pu ON pu.id = p.puesto
                        LEFT JOIN campamentos_status sc ON sc.id_status = c.status_anticipo
                        WHERE s.nombre like '%{$name}%'");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // BUSCAR POR SITIO 

    public function sitioccount($name,$offset,$no_of_records_per_page){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id_campamento, c.id_sitio, c.id_proyecto, c.fecha_solicitud, c.inicio_renta, c.fin_renta,
                        c.monto_renta, c.nombre_arrendador, c.tel_arrendador, c.pago_deposito, c.deposito, c.status_anticipo,
                        IF(c.deposito = 0, 'Sin Previo Deposito', c.deposito) AS depositos,c.status_campamento, c.condiciones_dev, 
                        c.pago_servicios, c.comentarios, c.contrato, c.id_responsable, s.Idgps, s.id_cliente, s.nombre, tp.id, 
                        tp.nombre_proyecto, st.id_tipoproyecto, st.id_sitio AS idsi, st.residente, 
                        IF(p.nombre IS NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma, pu.nombre AS puesto,
                        sc.nombre AS nstatus
                        FROM campamentos c
                        LEFT JOIN sitios s ON s.id = c.id_sitio
                        LEFT JOIN tipo_proyecto tp ON tp.id = c.id_proyecto
                        LEFT JOIN sitios_tipoproyecto st ON st.id_sitio = c.id_sitio AND st.id_tipoproyecto = c.id_proyecto
                        LEFT JOIN personal_campo p ON p.id = c.id_responsable
                        LEFT JOIN puestos_personal pu ON pu.id = p.puesto
                        LEFT JOIN campamentos_status sc ON sc.id_status = c.status_anticipo
                        WHERE s.nombre like '%{$name}%' 
                        LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // BUSCAR POR SITIO COUNT


     public function statusc($status){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id_campamento, c.id_sitio, c.id_proyecto, c.fecha_solicitud, c.inicio_renta, c.fin_renta,
                        c.monto_renta, c.nombre_arrendador, c.tel_arrendador, c.pago_deposito, c.deposito, c.status_anticipo,
                        IF(c.deposito = 0, 'Sin Previo Deposito', c.deposito) AS depositos, c.status_campamento, c.condiciones_dev, 
                        c.pago_servicios, c.comentarios, c.contrato, c.id_responsable , s.Idgps, s.id_cliente, s.nombre, tp.id, 
                        tp.nombre_proyecto, st.id_tipoproyecto, st.id_sitio AS idsi, st.residente, 
                        IF(p.nombre IS NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma, pu.nombre AS puesto,
                        sc.nombre AS nstatus
                        FROM campamentos c
                        LEFT JOIN sitios s ON s.id = c.id_sitio
                        LEFT JOIN tipo_proyecto tp ON tp.id = c.id_proyecto
                        LEFT JOIN sitios_tipoproyecto st ON st.id_sitio = c.id_sitio AND st.id_tipoproyecto = c.id_proyecto
                        LEFT JOIN personal_campo p ON p.id = c.id_responsable
                        LEFT JOIN puestos_personal pu ON pu.id = p.puesto
                        LEFT JOIN campamentos_status sc ON sc.id_status = c.status_anticipo
                        WHERE c.status_campamento = ?",array($status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // BUSCAR POR STATUS

    public function statusccount($status,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id_campamento, c.id_sitio, c.id_proyecto, c.fecha_solicitud, c.inicio_renta, c.fin_renta,
                        c.monto_renta, c.nombre_arrendador, c.tel_arrendador, c.pago_deposito, c.deposito, c.status_anticipo,
                        IF(c.deposito = 0, 'Sin Previo Deposito', c.deposito) AS depositos,c.status_campamento, c.condiciones_dev, 
                        c.pago_servicios, c.comentarios, c.contrato, c.id_responsable, s.Idgps, s.id_cliente, s.nombre, tp.id, 
                        tp.nombre_proyecto, st.id_tipoproyecto, st.id_sitio AS idsi, st.residente, 
                        IF(p.nombre IS NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma, pu.nombre AS puesto,
                        sc.nombre AS nstatus
                        FROM campamentos c
                        LEFT JOIN sitios s ON s.id = c.id_sitio
                        LEFT JOIN tipo_proyecto tp ON tp.id = c.id_proyecto
                        LEFT JOIN sitios_tipoproyecto st ON st.id_sitio = c.id_sitio AND st.id_tipoproyecto = c.id_proyecto
                        LEFT JOIN personal_campo p ON p.id = c.id_responsable
                        LEFT JOIN puestos_personal pu ON pu.id = p.puesto
                        LEFT JOIN campamentos_status sc ON sc.id_status = c.status_anticipo
                        WHERE c.status_campamento = ? LIMIT $offset,$no_of_records_per_page",array($status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // BUSCAR POR STATUS COUNT


    public function insertcamp($post,$table,$urldb,$statusd,$statusa){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitio'=>$post['sitio'],
                'id_proyecto'=>$post['proyecto'],
                'fecha_solicitud'=>$post['fechasol'],
                'inicio_renta'=>$post['fechair'],
                'fin_renta'=>$post['fechafr'],
                'monto_renta'=>$post['monto'],
                'pago_deposito'=>$statusd,
                'pago_servicios'=>$post['pagos'],
                'deposito'=>$post['deposito'],
                'status_campamento'=>$post['statusc'],
                'condiciones_dev'=>$post['condiciones'],
                'nombre_arrendador'=>$post['nombrear'],
                'tel_arrendador'=>$post['tel'],
                'contrato'=>$urldb,
                'id_responsable'=>$post['responsable'],
                'status_anticipo'=>$statusa,
                'comentarios'=>$post['comen']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }//  INSERT CAMPAMENTO

    public function updatecamp($post,$table,$urldb,$statusd,$statusa){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_sitio = ?, id_proyecto = ?, fecha_solicitud = ?, inicio_renta = ?, fin_renta = ?, monto_renta = ?, pago_deposito = ?, pago_servicios = ?, deposito = ?, status_campamento = ?, condiciones_dev = ?, nombre_arrendador = ?, tel_arrendador = ?, contrato = ?, comentarios = ?, id_responsable = ?, status_anticipo = ? WHERE id_campamento = ? ",
                array(
                    $post['sitio'],
                    $post['proyecto'],
                    $post['fechasol'],
                    $post['fechair'],
                    $post['fechafr'],
                    $post['monto'],
                    $statusd,
                    $post['pagos'],
                    $post['deposito'],
                    $post['statusc'],
                    $post['condiciones'],
                    $post['nombrear'],
                    $post['tel'],
                    $urldb,
                    $post['comen'],
                    $post['responsable'],
                    $statusa,
                    $post['ids']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE CAMPAMENTOS

    public function updatecampamento($post,$table,$urldb){
        $statuscmp = 2;

        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET contrato = ?, comentarios = ?, status_campamento = ? WHERE id_campamento = ? ",
                array(
                    $urldb,
                    $post['comentarios'],
                    $statuscmp,
                    $post['idc']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE STATUS CAMPAMENTO (2 RENTADO)



    public function updatecampamentoCerrar($post,$table,$urldb,$hoy){
        $statuscmp = 3;
        $statusatc = 3;

        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET fecha_cierre = ?, devolucion_img = ?, montodev = ?, fecha_rem = ?, comentarioscerrar = ?, status_campamento = ?, status_anticipo = ? WHERE id_campamento = ? ",
                array(
                    $hoy,
                    $urldb,
                    $post['monto'],
                    $post['fecha'],
                    $post['comentarios'],
                    $statuscmp,
                    $statusatc,
                    $post['idc']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE STATUS CAMPAMENTO (3 Cerrado)


    public function updateCampSrem($post,$table,$hoy){
        $statuscmp = 3;

        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET fecha_cierre = ?, comentarioscerrar = ?, status_campamento = ? WHERE id_campamento = ? ",
                array(
                    $hoy,
                    $post['comentario'],
                    $statuscmp,
                    $post['idc']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE STATUS CAMPAMENTO (3 Cerrado sin reembolso)

    public function GetCampamentosAll($table,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id_campamento, c.id_sitio, c.id_proyecto, c.fecha_solicitud, c.inicio_renta, c.fin_renta,
                        c.monto_renta, c.nombre_arrendador, c.tel_arrendador, c.pago_deposito, c.status_anticipo, c.created_at, 
                        c.devolucion_img, c.comentarioscerrar, c.montodev, c.fecha_rem, c.fecha_cierre,
                        IF(c.pago_deposito != 0,  IF(c.pago_deposito = 1, 'Aplica', 'No Aplica'),'No Aplica') AS pdeposito,
                        c.deposito, c.status_campamento, c.condiciones_dev, c.pago_servicios,
                        IF(c.status_campamento != 3, IF(c.status_campamento != 2, IF(c.status_campamento = 1, 'Por Rentar', 'Sin Status'), 'En Renta'),'Cerrado') AS statusc,
                        IF(c.pago_servicios != 1,  IF(c.pago_servicios = 0, 'Incluidos en Renta', 'Fuera de Renta'),'Fuera de Renta') AS pservicios,
                        c.comentarios, c.contrato, c.id_responsable, s.Idgps, s.id_cliente,s.nombre, tp.id, tp.nombre_proyecto, 
                        st.id_tipoproyecto, st.id_sitio AS idsi, st.residente, 
                        IF(p.nombre IS NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma, pu.nombre AS puesto,
                        sc.nombre AS nstatus
                        FROM campamentos c
                        LEFT JOIN sitios s ON s.id = c.id_sitio
                        LEFT JOIN tipo_proyecto tp ON tp.id = c.id_proyecto
                        LEFT JOIN sitios_tipoproyecto st ON st.id_sitio = c.id_sitio AND st.id_tipoproyecto = c.id_proyecto
                        LEFT JOIN personal_campo p ON p.id = c.id_responsable
                        LEFT JOIN puestos_personal pu ON pu.id = p.puesto
                        LEFT JOIN campamentos_status sc ON sc.id_status = c.status_anticipo
                        WHERE c.id_campamento = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // CONSULTA CAMPAMENTOS



    public function excelc($table){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id_campamento, c.id_sitio, c.id_proyecto, c.fecha_solicitud, c.inicio_renta, c.fin_renta,
                        c.monto_renta, c.nombre_arrendador, c.tel_arrendador, c.pago_deposito, c.status_anticipo, c.created_at, 
                        c.devolucion_img, c.comentarioscerrar, c.montodev, c.fecha_rem,
                        IF(c.pago_deposito != 0,  IF(c.pago_deposito = 1, 'Aplica', 'No Aplica'),'No Aplica') AS pdeposito,
                        c.deposito, c.status_campamento, c.condiciones_dev, c.pago_servicios,
                        IF(c.status_campamento != 3, IF(c.status_campamento != 2, IF(c.status_campamento = 1, 'Por Rentar', 'Sin Status'), 'En Renta'),'Cerrado') AS statusc,
                        IF(c.pago_servicios != 1,  IF(c.pago_servicios = 0, 'Incluidos en Renta', 'Fuera de Renta'),'Fuera de Renta') AS pservicios,
                        c.comentarios, c.contrato, c.id_responsable, s.Idgps, s.id_cliente,
                        s.nombre, tp.id, tp.nombre_proyecto, st.id_tipoproyecto, st.id_sitio AS idsi, st.residente, 
                        IF(p.nombre IS NULL, 'Sin Asignar', p.nombre) AS nombrea, p.apellido_pa, p.apellido_ma, pu.nombre AS puesto,
                        sc.nombre AS nstatus
                        FROM campamentos c
                        LEFT JOIN sitios s ON s.id = c.id_sitio
                        LEFT JOIN tipo_proyecto tp ON tp.id = c.id_proyecto
                        LEFT JOIN sitios_tipoproyecto st ON st.id_sitio = c.id_sitio AND st.id_tipoproyecto = c.id_proyecto
                        LEFT JOIN personal_campo p ON p.id = c.id_responsable
                        LEFT JOIN puestos_personal pu ON pu.id = p.puesto
                        LEFT JOIN campamentos_status sc ON sc.id_status = c.status_anticipo
                        ORDER BY c.id_campamento ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // EXCEL CAMPAMENTOS

    public function Getpaginationst($table,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT id_status, nombre
                FROM $table
                order by id_status asc LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }  // CONSULTA STATUS CAMPAMENTOS

      public function insertstatus($post,$table){
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
    }//  INSERT STATUS

    public function updatestatusc($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET nombre = ? WHERE id_status = ? ",
                array(
                    $post['name'],
                    $post['ids']));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }   // END  REQUEST UPDATE STATUS

    public function GetordernombresitiosC(){  
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

    public function GetPersonalC(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM personal_campo ORDER BY nombre ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } // CONSULTA PERSONAL ORDEN



    public function consultaproyecto($letra){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT st.id, st.id_tipoproyecto, t.nombre_proyecto,st.id_sitio, s.Idgps, s.id_cliente, s.nombre, 
                        st.status_proyecto, st.status_cliente, st.operador, st.id_operador, st.residente, st.pm_cliente, 
                        st.coordinador_id, st.nombre_coordinador, st.ingproyecto_id,st.nombre_ingproyecto, st.fecha_inicio, st.issue
                        FROM sitios_tipoproyecto st
                        LEFT JOIN sitios s ON s.id = st.id_sitio 
                        LEFT JOIN tipo_proyecto t ON t.id = st.id_tipoproyecto 
                        where st.id_sitio = $letra");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }// Obetener Sitios


    public function GetCampamentosxVen($table){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id_campamento, c.id_sitio ,c.id_proyecto, c.fecha_solicitud, c.inicio_renta, c.fin_renta,
                        c.monto_renta, c.condiciones_dev, c.pago_deposito, c.deposito, c.status_campamento, c.comentarios, s.id, 
                        s.id_cliente,s.Idgps, s.nombre, s.cliente
                        FROM campamentos c
                        LEFT JOIN sitios s ON s.id = c.id_sitio
                        WHERE c.fin_renta between curdate() and date_add(curdate(), interval 10 day) AND c.status_campamento = 2");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Campamentos por vencer para alertas.


    public function GetCampamentosVen($table){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT c.id_campamento, c.id_sitio ,c.id_proyecto, c.fecha_solicitud, c.inicio_renta, c.fin_renta,
                        c.monto_renta, c.condiciones_dev, c.pago_deposito, c.deposito, c.status_campamento, c.comentarios, s.id, 
                        s.id_cliente,s.Idgps, s.nombre, s.cliente
                        FROM campamentos c
                        LEFT JOIN sitios s ON s.id = c.id_sitio
                        WHERE c.fin_renta BETWEEN NOW() - INTERVAL 10 DAY AND NOW() - INTERVAL 1 DAY AND c.status_campamento = 2");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }   // Alertas Campamentos Vencidos.

  



} 