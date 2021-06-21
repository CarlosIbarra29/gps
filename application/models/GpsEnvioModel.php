<?php

class Application_Model_GpsEnvioModel extends Zend_Db_Table_Abstract{
    protected $_name = 'envios_solicitud';
    protected $_primary = 'id';

    public function insertenviostepone($post,$table,$nombre_sitio,$sitio_cliente,$nombre_usuario,$hoy,$id,$hora_actual){
    	$op = 0;
        try {
            $row = $this->createRow();
            $row->id_sitio = $post['sitio'];
            $row->name_sitio = $nombre_sitio;
            $row->id_cliente = $sitio_cliente;
            $row->fecha_solicitud = $post['fecha_envio'];
            $row->fecha_envio = $hoy;
            $row->user_solicitud = $nombre_usuario;
            $row->prioridad= $post['prioridad'];
            $row->tipo_envio = $post['tipo_envio'];
            $row->vehiculo = $post['vehiculo'];
            $row->step_envio = $op;
            $row->hora_entrega = $hora_actual;
            $row->id_user = $id;
            $row->solicitud_materiales = $post['materiales'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT ENVIO

    public function updateenviopasodos($post,$table){
    	$step = 1;
        try {
        $db = Zend_Db_Table::getDefaultAdapter();
        $qry = $db->query("UPDATE $table SET step_envio = ?, id_tipoproyecto = ?, direccion = ?, contacto =?, peso_aproximado	 =?, dimensiones = ?, descripcion =?, comentarios = ? WHERE id = ?",array(
            $step,
            $post['proyecto'],
            $post['direccion'],
            $post['contacto'],
            $post['peso'],
            $post['dimension'],
            $post['descripcion'],
            $post['comentario'],
            $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE ENVIO

    public function updatauditoriaenvio($post,$table,$nombre,$hoy){
        try {
        $db = Zend_Db_Table::getDefaultAdapter();
        $qry = $db->query("UPDATE $table SET status_solicitud = ?, user_auditoria = ?, fecha_auditoria = ?, comentario_auditoria = ? WHERE id = ?",array(
            $post['op_auditoria'],
            $nombre,
            $hoy,
            $post['motivo'],
            $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE ENVIO


    public function updatevehiculoenvio($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET vehiculo_final = ? WHERE id = ?",array(
                $post['op_car'],
                $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE ENVIO

    public function updatematerial($post,$table){
        $change = 1;
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_envio = ? WHERE id = ?",array(
                $change,
                $post['materiales']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE ENVIO

    public function updatematerialdos($post,$table){
        $change = 0;
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_envio = ? WHERE id = ?",array(
                $change,
                $post['id_mat']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE ENVIO


    public function updateoperador($post,$table,$nombre){
        $step = 1;
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET operador = ?, nombre_operador = ? WHERE id = ?",array(
                $post['op_select'],
                $nombre,
                $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE ENVIO


    public function updatesteplogistica($post,$table){
        $step = 3;
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_solicitud = ? WHERE id = ?",array(
                $step,
                $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE ENVIO

    public function updateacuse($post,$table,$urldb){
        $status = 1;
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET acuse = ?, status_solicitud = ? WHERE id = ?",array(
                $urldb,
                $status,
                $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE ENVIO



    public function updateenviopasouno($post,$table,$nombre_sitio,$sitio_cliente,$nombre_usuario,$hoy,$id,$mat_select){
        $step = 1;
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_sitio = ?, name_sitio = ?, id_cliente  = ?, fecha_solicitud =?, fecha_envio = ?, user_solicitud = ?, id_user =?, prioridad = ?, tipo_envio = ?, vehiculo = ?, solicitud_materiales = ?
                WHERE id = ?",array(
                $post['sitios'],
                $nombre_sitio,
                $sitio_cliente,
                $post['fecha_envio'],
                $hoy,
                $nombre_usuario,
                $id,
                $post['prioridad'],
                $post['tipo_envio'],
                $post['vehiculo'],
                $mat_select,
                $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE ENVIO



    public function getstepunoenvio(){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
				        e.user_solicitud, e.id_user, e.prioridad, e.tipo_envio, e.vehiculo 
                        FROM envios_solicitud e 
                        WHERE e.step_envio = 0;");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getenviosVencidos($step,$status){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT es.id, es.id_sitio, es.name_sitio, es.id_cliente, es.fecha_solicitud, es.fecha_envio, 
                    CONCAT(YEAR(DATE(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),
                    '-',
                    SUBSTRING(fecha_solicitud, 4, 2),
                    '-',
                    SUBSTRING(fecha_solicitud, 1, 2)))),'-',
                    MONTH(DATE(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),
                    '-',
                    SUBSTRING(fecha_solicitud, 4, 2),
                    '-',
                    SUBSTRING(fecha_solicitud, 1, 2)))),'-',
                    DAY(DATE(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),
                    '-',
                    SUBSTRING(fecha_solicitud, 4, 2),
                    '-',
                    SUBSTRING(fecha_solicitud, 1, 2))))) as fecha_enviar,
                    es.user_solicitud, es.step_envio, es.status_solicitud, es.descripcion
                    FROM envios_solicitud es
                    having fecha_enviar BETWEEN NOW() - INTERVAL 10 DAY AND NOW() AND es.step_envio = ? and es.status_solicitud= ?;",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsteponepaginator($id,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
				        e.user_solicitud, e.id_user, e.prioridad, e.tipo_envio, e.vehiculo 
                        FROM envios_solicitud e 
                        WHERE e.step_envio = 0 AND e.id_user = ? order by e.id DESC 
                        LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsolicitudstepone($step,$status){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion, e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios, 
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse, e.id_tipoproyecto
                        FROM envios_solicitud e 
                        WHERE step_envio = ? and status_solicitud = ?;",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsolicitudsteponeuser($step,$status,$user){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud, e.id_user, e.prioridad, e.tipo_envio, e.vehiculo,e.direccion,e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios, 
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse, e.id_tipoproyecto
                        FROM envios_solicitud e 
                        WHERE step_envio = ? and status_solicitud = ? and id_user = ?",array($step,$status,$user));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getenviosteponepaginator($step,$status,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion, e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios, 
                        e.status_solicitud, e.vehiculo_final,e.operador, e.acuse,e.descripcion, e.id_tipoproyecto, 
                        year(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', 
                        SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS years, 
                        month(date(CONCAT(SUBSTRING(fecha_solicitud,7,4),  '-', SUBSTRING(fecha_solicitud,4,2), '-', 
                        SUBSTRING(fecha_solicitud,1,2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_solicitud,7,4), '-', 
                        SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS dia,
                        e.solicitud_materiales, m.file as archivo
                        FROM envios_solicitud e 
                        LEFT JOIN materiales_solicitud m on m.id = e.solicitud_materiales
                        having step_envio = ? AND status_solicitud = ?
                        ORDER BY years,mes, dia ASC LIMIT $offset,$no_of_records_per_page",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getenviosteponepaginatoruser($step,$status,$user,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud,e.id_user, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion,e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios,
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse, e.id_tipoproyecto, 
                        year(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS years, 
                        month(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS dia
                        FROM envios_solicitud e 
                        WHERE step_envio = ? AND status_solicitud = ? AND id_user = ? 
                        ORDER BY years, mes, dia ASC 
                        LIMIT $offset,$no_of_records_per_page",array($step,$status,$user));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsitioenviossearch($step,$status,$sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion, e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios, 
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse,e.descripcion, e.id_tipoproyecto,
                        year(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS years, 
                        month(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS dia
                        FROM envios_solicitud e 
                        WHERE step_envio = ? and status_solicitud = ? and name_sitio like '%{$sitio}%'
                        ORDER BY years,mes, dia ASC",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getuserenviossearch($step,$status,$user){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion, e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios, 
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse,e.descripcion, e.id_tipoproyecto,
                        year(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS years, 
                        month(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS dia
                        FROM envios_solicitud e 
                        WHERE step_envio = ? and status_solicitud = ? and user_solicitud  like '%{$user}%'
                        ORDER BY years,mes, dia ASC",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getprioridadenviossearch($step,$status,$prioridad){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion, e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios, 
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse,e.descripcion, e.id_tipoproyecto,
                        year(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS years, 
                        month(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS dia
                        FROM envios_solicitud e 
                        WHERE step_envio = ? AND status_solicitud = ? AND e.prioridad =?
                        ORDER BY years,mes, dia ASC",array($step,$status,$prioridad));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function gettipoenvidiadenviossearch($step,$status,$envio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion, e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios, 
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse,e.descripcion, e.id_tipoproyecto,
                        year(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS years, 
                        month(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS dia
                        FROM envios_solicitud e 
                        WHERE step_envio = ? AND status_solicitud = ? AND tipo_envio =?
                        ORDER BY years,mes, dia ASC",array($step,$status,$envio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function gettipsolicitudenviossearch($step,$status,$solicitud){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion, e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios, 
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse,e.descripcion, e.id_tipoproyecto,
                        year(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS years, 
                        month(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS dia
                        FROM envios_solicitud e 
                        WHERE step_envio = ? AND status_solicitud = ? AND e.id =?
                    ORDER BY years,mes, dia ASC",array($step,$status,$solicitud));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }



    public function getfechaenviossearch($step,$status,$fecha){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion, e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios, 
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse,e.descripcion, e.id_tipoproyecto,
                        year(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS years, 
                        month(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS dia
                        FROM envios_solicitud e 
                        WHERE step_envio = ? AND status_solicitud = ? AND fecha_solicitud= ? 
                        ORDER BY years,mes, dia ASC",array($step,$status,$fecha));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getfechaenviopaginatoruser($step,$status,$fecha,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud,e.id_user, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion,e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios,
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse, e.id_tipoproyecto, 
                        year(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS years, 
                        month(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS dia,e.solicitud_materiales, m.file as archivo
                        FROM envios_solicitud e 
                        LEFT JOIN materiales_solicitud m on m.id = e.solicitud_materiales
                        WHERE step_envio = ? AND e.status_solicitud = ? AND e.fecha_solicitud = ? 
                        ORDER BY years, mes, dia ASC 
                        LIMIT $offset,$no_of_records_per_page",array($step,$status,$fecha));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getsitioenviopaginator($step,$status,$sitio,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion, e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios, 
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse,e.descripcion, e.id_tipoproyecto,
                        year(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS years, 
                        month(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS dia,e.solicitud_materiales, m.file as archivo
                        FROM envios_solicitud e 
                        LEFT JOIN materiales_solicitud m on m.id = e.solicitud_materiales
                        WHERE step_envio = ? AND e.status_solicitud = ? AND e.name_sitio like '%{$sitio}%'
                        ORDER BY years,mes, dia ASC LIMIT $offset,$no_of_records_per_page",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getuserenviopaginator($step,$status,$user,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion, e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios, 
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse,e.descripcion, e.id_tipoproyecto,
                        year(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS years, 
                        month(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS dia,e.solicitud_materiales, m.file as archivo
                        FROM envios_solicitud e 
                        LEFT JOIN materiales_solicitud m on m.id = e.solicitud_materiales
                        WHERE step_envio = ? AND e.status_solicitud = ? AND e.user_solicitud like '%{$user}%'
                        ORDER BY years,mes, dia ASC LIMIT $offset,$no_of_records_per_page",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getprioridadenviopaginator($step,$status,$prioridad,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion, e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios, 
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse,e.descripcion, e.id_tipoproyecto,
                        year(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS years, 
                        month(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS dia,e.solicitud_materiales, m.file as archivo
                        FROM envios_solicitud e 
                        LEFT JOIN materiales_solicitud m on m.id = e.solicitud_materiales
                        WHERE step_envio = ? and e.status_solicitud = ? and e.prioridad = ?
                        ORDER BY years,mes, dia ASC 
                        LIMIT $offset,$no_of_records_per_page",array($step,$status,$prioridad));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function gettipoenvioenviopaginator($step,$status,$envio,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion, e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones,e.comentarios, 
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse,e.descripcion, e.id_tipoproyecto,
                        year(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS years, 
                        month(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS dia,e.solicitud_materiales, m.file as archivo
                        FROM envios_solicitud e 
                        LEFT JOIN materiales_solicitud m on m.id = e.solicitud_materiales
                        WHERE step_envio = ? and e.status_solicitud = ? and tipo_envio = ?
                        ORDER BY years,mes, dia ASC 
                        LIMIT $offset,$no_of_records_per_page",array($step,$status,$envio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function gettiposolicitudenviopaginator($step,$status,$solicitud,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id, e.id_sitio, e.name_sitio, e.id_cliente, e.fecha_solicitud,e.fecha_envio, 
                        e.user_solicitud, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion, e.step_envio, 
                        e.hora_entrega, e.descripcion, e.contacto, e.peso_aproximado, e.dimensiones, e.comentarios, 
                        e.status_solicitud, e.vehiculo_final, e.operador, e.acuse,e.descripcion, e.id_tipoproyecto,
                        year(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS years, 
                        month(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS mes,
                        day(date(CONCAT(SUBSTRING(fecha_solicitud, 7, 4),  '-', SUBSTRING(fecha_solicitud, 4, 2), '-', SUBSTRING(fecha_solicitud, 1, 2)))) AS dia,e.solicitud_materiales, m.file as archivo
                        FROM envios_solicitud e 
                        LEFT JOIN materiales_solicitud m on m.id = e.solicitud_materiales
                        WHERE step_envio = ? and e.status_solicitud = ? and e.id = ?
                        ORDER BY years,mes, dia ASC 
                        LIMIT $offset,$no_of_records_per_page",array($step,$status,$solicitud));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getfechalogistica($fecha,$vehiculo){
        $logistica = 3;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id as No_envio,e.name_sitio as Sitio, e.direccion as Direccion, 
                        e.descripcion as Descripcion, e.peso_aproximado as Peso,e.dimensiones as Dimensiones, 
                        e.comentarios as Comentario 
                        FROM envios_solicitud e  
                        WHERE e.fecha_solicitud= ? AND e.vehiculo = ? AND e.status_solicitud= ?"
                ,array($fecha,$vehiculo,$logistica));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getfechalogisticados($fecha,$vehiculo){
        $logistica = 3;
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id as No_envio, e.name_sitio as Sitio, e.direccion as Direccion, 
                        e.descripcion as Descripcion, e.peso_aproximado as Peso,e.dimensiones as Dimensiones, 
                        e.comentarios as Comentario  
                        FROM envios_solicitud e 
                        WHERE e.fecha_solicitud= ? AND e.vehiculo_final = ? 
                        AND e.status_solicitud= ?",array($fecha,$vehiculo,$logistica));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getinfoenvio(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT e.id,e.id_sitio,e.name_sitio, e.id_cliente, e.fecha_solicitud, e.fecha_envio, 
                        e.user_solicitud, e.prioridad, e.tipo_envio, e.vehiculo, e.direccion, e.hora_entrega, 
                        e.descripcion,e.contacto, e.peso_aproximado, e.dimensiones,e.comentarios,e.status_solicitud,
                        e.user_auditoria, e.fecha_auditoria, e.comentario_auditoria, e.nombre_operador, 
                        e.id_tipoproyecto, tp.nombre_proyecto,e.vehiculo_final
                        FROM envios_solicitud e 
                        LEFT JOIN sitios_tipoproyecto st on st.id = e.id_tipoproyecto 
                        LEFT JOIN tipo_proyecto tp on tp.id =st.id_tipoproyecto 
                        WHERE e.step_envio = 1");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

}