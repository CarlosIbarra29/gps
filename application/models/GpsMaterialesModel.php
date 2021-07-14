<?php

class Application_Model_GpsMaterialesModel extends Zend_Db_Table_Abstract{
    protected $_name = 'materiales_solicitud';
    protected $_primary = 'id';

    public function insertmaterialsolicitud($post,$table,$nombre_sitio,$nombre_usuario,$hoy,$id_user){
        $step = 1;
        try {
            $row = $this->createRow();
            $row->id_sitio = $post['sitio'];
            $row->name_sitio = $nombre_sitio;
            $row->user_solicitud = $nombre_usuario;
            $row->id_user = $id_user;
            $row->fecha_user = $hoy;
            $row->fecha_solicitada = $post['fecha_entrega'];
            $row->comentario = $post['comentario'];
            $row->status_check = $post['status_check'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT SOLICITUD DE MATERIALES

    public function insertcomentarios($post,$table,$hoy,$name_auditor){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_solicitud'=>$post['id'],
                'comentario'=>$post['comentario'],
                'fecha_comentario'=>$hoy,
                'nombre_usuario'=>$name_auditor
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function updatecomentariosol($post,$table,$hoy,$name_audito){
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET  comentario = ?, fecha_comentario = ?, nombre_usuario = ?  WHERE id = ?",array(
                $post['comentario'],
                $hoy,
                $name_audito,
                $post['id']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD DE MATERIALES

    public function updatesoldate($post,$table,$hoy,$name_audito){
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET fecha_solicitada = ?, fecha_cambio = ?, motivo_date =?, fecha_actfecha = ?, user_fechacambio = ?  WHERE id = ?",array(
                $post['date_cambio'],
                $post['date_cambio'],
                $post['motivo_date'],
                $hoy,
                $name_audito,
                $post['id']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD DE MATERIALES


    public function updatemterialesduno($post,$table,$nombre_sitio,$nombre_usuario,$hoy,$id_user){
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_sitio = ?, name_sitio = ?, fecha_solicitada = ?, fecha_user = ? , status_check = ? WHERE id = ?",array(
                $post['sitio'],
                $nombre_sitio,
                $post['fecha_entrega'],
                $hoy,
                $post['status_check'],
                $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD DE MATERIALES

    public function updatemterialesdos($post,$table,$material){
        $paso = 1; 
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_tipoproyecto = ?, file = ?, step_solicitud = ? WHERE id = ?",array(
                $post['proyecto'],
                $material,
                $paso,
                $post['sitio']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD DE MATERIALES

    public function updatcheckselect($post,$table){
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_check = ?WHERE id = ?",array(
                $post['dato'],
                $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE SOLICITUD DE MATERIALES


    public function updateauditoriamaterial($post,$table,$hoy, $name_auditor){
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_solicitud = ?, user_auditoria = ?, fecha_auditoria = ?, auditoria_comentario = ?  WHERE id = ?",array(
                $post['dato'],
                $name_auditor,
                $hoy,
                $post['comentario'],
                $post['id']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE STATUS

    public function solicitudpendiente($id){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT m.id, m.id_sitio, m.name_sitio, m.id_tipoproyecto, m.user_solicitud, m.id_user, 
            	m.fecha_user, m.fecha_solicitada, m.step_solicitud
				FROM materiales_solicitud m where m.step_solicitud =0 and m.id_user = ?",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function solicitudependientespaginator($offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT m.id, m.id_sitio, m.name_sitio, m.id_tipoproyecto, m.user_solicitud, m.id_user, 
            	m.fecha_user, m.fecha_solicitada, m.step_solicitud, m.comentario
				FROM materiales_solicitud m 
				where m.step_solicitud = 0 and m.id_user = ? LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR

    public function getsolicitudesmateriales($step,$status){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT m.id, m.name_sitio, m.id_tipoproyecto, m.user_solicitud, m.fecha_solicitada, 
                tp.nombre_proyecto, m.step_solicitud, m.status_solicitud,
                year(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS years, 
                month(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS mes,
                day(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS dia
                FROM materiales_solicitud m
                LEFT JOIN sitios_tipoproyecto st on st.id=m.id_tipoproyecto
                LEFT JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
                where m.step_solicitud = ? AND m.status_solicitud = ?
                ORDER BY years,mes, dia ASC",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getmaterialesVencidos($step,$status){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ms.id, ms.id_sitio, ms.name_sitio, ms.id_tipoproyecto, ms.fecha_user , ms.fecha_solicitada, 
                    CONCAT(YEAR(DATE(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),
                    '-',
                    SUBSTRING(fecha_solicitada, 4, 2),
                    '-',
                    SUBSTRING(fecha_solicitada, 1, 2)))),'-',
                    MONTH(DATE(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),
                    '-',
                    SUBSTRING(fecha_solicitada, 4, 2),
                    '-',
                    SUBSTRING(fecha_solicitada, 1, 2)))),'-',
                    DAY(DATE(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),
                    '-',
                    SUBSTRING(fecha_solicitada, 4, 2),
                    '-',
                    SUBSTRING(fecha_solicitada, 1, 2))))) as fecha_solicitar,
                    ms.user_solicitud, ms.step_solicitud, ms.status_solicitud, ms.comentario
                    FROM materiales_solicitud ms
                    having fecha_solicitar BETWEEN NOW() - INTERVAL 20 DAY AND NOW() AND ms.step_solicitud = ? and ms.status_solicitud= ?;",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsolicitudesmaterialpag($step,$status,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT m.id, m.id_sitio, m.name_sitio, m.id_tipoproyecto, m.user_solicitud, 
                m.fecha_solicitada, tp.nombre_proyecto, m.step_solicitud, m.status_solicitud, e.solicitud_materiales,
                e.id as envio_id, e.status_solicitud as envios_status, year(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS years, 
                month(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS mes,
                day(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS dia, m.status_check
                FROM materiales_solicitud m
                LEFT JOIN sitios_tipoproyecto st on st.id=m.id_tipoproyecto
                LEFT JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
                LEFT JOIN envios_solicitud e on e.solicitud_materiales = m.id
                where m.step_solicitud = ? AND m.status_solicitud = ?
                ORDER BY years,mes, dia ASC LIMIT $offset,$no_of_records_per_page",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

// SELECT m.id, m.id_sitio, m.name_sitio, m.id_tipoproyecto, m.user_solicitud, 
//                 m.fecha_solicitada, tp.nombre_proyecto, m.step_solicitud, m.status_solicitud,
//                 year(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS years, 
//                 month(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS mes,
//                 day(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS dia, m.status_check
//                 FROM materiales_solicitud m
//                 LEFT JOIN sitios_tipoproyecto st on st.id=m.id_tipoproyecto
//                 LEFT JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
//                 where m.step_solicitud = ? AND m.status_solicitud = ?
//                 ORDER BY years,mes, dia ASC 


    public function getdetailsolicitud($id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT m.id, m.name_sitio, m.id_tipoproyecto, m.user_solicitud, m.fecha_solicitada, 
                tp.nombre_proyecto, m.step_solicitud, m.status_solicitud, m.fecha_user, m.comentario, m.file, 
                m.status_check, m.fecha_cambio, m.motivo_date, m.user_fechacambio, m.fecha_actfecha
                FROM materiales_solicitud m
                LEFT JOIN sitios_tipoproyecto st on st.id=m.id_tipoproyecto
                LEFT JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
                where m.id = ? ",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsolicitudsteponematerial($step,$status){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ms.id, ms.name_sitio, ms.user_solicitud, ms.fecha_solicitada, ms.step_solicitud   FROM materiales_solicitud ms where ms.step_solicitud = ? AND ms.status_solicitud = ?",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsitiobuscador($step,$status,$sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ms.id, ms.name_sitio, ms.user_solicitud, ms.fecha_solicitada,ms.step_solicitud,
            year(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS years, month(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS mes,day(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS dia
                FROM materiales_solicitud ms where ms.step_solicitud = ? AND ms.status_solicitud = ? and name_sitio like '%{$sitio}%'
                    ORDER BY years,mes, dia ASC",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsitiobuscadorpaginator($step,$status,$sitio,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT m.id, m.id_sitio, m.name_sitio, m.id_tipoproyecto, m.user_solicitud, 
                m.fecha_solicitada, tp.nombre_proyecto, m.step_solicitud, m.status_solicitud, e.solicitud_materiales,
                e.id as envio_id, e.status_solicitud as envios_status,
                year(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS years, 
                month(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS mes,
                day(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS dia, m.status_check
                FROM materiales_solicitud m
                LEFT JOIN sitios_tipoproyecto st on st.id=m.id_tipoproyecto
                LEFT JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
                LEFT JOIN envios_solicitud e on e.solicitud_materiales = m.id
                where m.step_solicitud = ? AND m.status_solicitud = ? and m.name_sitio like '%{$sitio}%'
                    ORDER BY years,mes, dia ASC LIMIT $offset,$no_of_records_per_page",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getfechabuscador($step,$status,$fecha){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ms.id, ms.name_sitio, ms.user_solicitud, ms.fecha_solicitada,ms.step_solicitud,
                year(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS years, month(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS mes,day(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS dia
                FROM materiales_solicitud ms where ms.step_solicitud = ? AND ms.status_solicitud = ?  and  fecha_solicitada = ?
                    ORDER BY years,mes, dia ASC",array($step,$status,$fecha));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getfechabuscadorpaginator($step,$status,$fecha,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT m.id, m.id_sitio, m.name_sitio, m.id_tipoproyecto, m.user_solicitud, 
                m.fecha_solicitada, tp.nombre_proyecto, m.step_solicitud, m.status_solicitud, e.solicitud_materiales,
                e.id as envio_id, e.status_solicitud as envios_status,
                year(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS years, 
                month(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS mes,
                day(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS dia,m.status_check
                FROM materiales_solicitud m
                LEFT JOIN sitios_tipoproyecto st on st.id=m.id_tipoproyecto
                LEFT JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
                LEFT JOIN envios_solicitud e on e.solicitud_materiales = m.id
                where m.step_solicitud = ? AND m.status_solicitud = ? and  fecha_solicitada = ?
                    ORDER BY years,mes, dia ASC LIMIT $offset,$no_of_records_per_page",array($step,$status,$fecha));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getnamebuscador($step,$status,$user){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ms.id, ms.name_sitio, ms.user_solicitud, ms.fecha_solicitada,ms.step_solicitud,
            year(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS years, month(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS mes,day(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS dia
                FROM materiales_solicitud ms where ms.step_solicitud = ? AND ms.status_solicitud = ? and user_solicitud like '%{$user}%'
                    ORDER BY years,mes, dia ASC",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getuserbuscadorpaginator($step,$status,$user,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT m.id, m.id_sitio, m.name_sitio, m.id_tipoproyecto, m.user_solicitud, 
                m.fecha_solicitada, tp.nombre_proyecto, m.step_solicitud, m.status_solicitud,e.solicitud_materiales,
                e.id as envio_id, e.status_solicitud as envios_status,
                year(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS years, 
                month(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS mes,
                day(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS dia, m.status_check
                FROM materiales_solicitud m
                LEFT JOIN sitios_tipoproyecto st on st.id=m.id_tipoproyecto
                LEFT JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
                LEFT JOIN envios_solicitud e on e.solicitud_materiales = m.id
                where m.step_solicitud = ? AND m.status_solicitud = ?  and m.user_solicitud like '%{$user}%'
                    ORDER BY years,mes, dia ASC LIMIT $offset,$no_of_records_per_page",array($step,$status));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getidbuscador($step,$status,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ms.id, ms.name_sitio, ms.user_solicitud, ms.fecha_solicitada,ms.step_solicitud,
                year(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS years, month(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS mes,day(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS dia
                FROM materiales_solicitud ms where ms.step_solicitud = ? AND ms.status_solicitud = ?  and  ms.id = ?
                    ORDER BY years,mes, dia ASC ",array($step,$status,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getidbuscadorpaginator($step,$status,$id,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT m.id, m.id_sitio, m.name_sitio, m.id_tipoproyecto, m.user_solicitud, 
                m.fecha_solicitada, tp.nombre_proyecto, m.step_solicitud, m.status_solicitud,e.solicitud_materiales,
                e.id as envio_id, e.status_solicitud as envios_status,
                year(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS years, 
                month(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS mes,
                day(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS dia, m.status_check
                FROM materiales_solicitud m
                LEFT JOIN sitios_tipoproyecto st on st.id=m.id_tipoproyecto
                LEFT JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
                LEFT JOIN envios_solicitud e on e.solicitud_materiales = m.id
                where m.step_solicitud = ? AND m.status_solicitud = ?  and m.id =?
                    ORDER BY years,mes, dia ASC LIMIT $offset,$no_of_records_per_page",array($step,$status,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getcheckbuscador($step,$status,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ms.id, ms.name_sitio, ms.user_solicitud, ms.fecha_solicitada,ms.step_solicitud,
                year(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS years, month(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS mes,day(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '-', SUBSTRING(fecha_solicitada, 4, 2), '-', SUBSTRING(fecha_solicitada, 1, 2)))) AS dia, ms.status_check
                FROM materiales_solicitud ms where ms.step_solicitud = ? AND ms.status_solicitud = ?  and  ms.status_check = ?
                    ORDER BY years,mes, dia ASC ",array($step,$status,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


    public function getcheckbuscadorpaginator($step,$status,$id,$offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT m.id, m.id_sitio, m.name_sitio, m.id_tipoproyecto, m.user_solicitud, 
                m.fecha_solicitada, tp.nombre_proyecto, m.step_solicitud, m.status_solicitud,e.solicitud_materiales,
                e.id as envio_id, e.status_solicitud as envios_status,
                year(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS years, 
                month(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS mes,
                day(date(CONCAT(SUBSTRING(fecha_solicitada, 7, 4),  '/', SUBSTRING(fecha_solicitada, 4, 2), '/', SUBSTRING(fecha_solicitada, 1, 2)))) AS dia, m.status_check
                FROM materiales_solicitud m
                LEFT JOIN sitios_tipoproyecto st on st.id=m.id_tipoproyecto
                LEFT JOIN tipo_proyecto tp on tp.id = st.id_tipoproyecto
                LEFT JOIN envios_solicitud e on e.solicitud_materiales = m.id
                where m.step_solicitud = ? AND m.status_solicitud = ?  and m.status_check =?
                    ORDER BY years,mes, dia ASC LIMIT $offset,$no_of_records_per_page",array($step,$status,$id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getmaterialesreporte(){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT m.id, m.id_sitio, m.name_sitio, m.id_tipoproyecto, m.user_solicitud, 
                m.fecha_user, m.fecha_solicitada, m.comentario, m.fecha_auditoria, m.user_auditoria,
                m.auditoria_comentario, tp.nombre_proyecto, m.status_solicitud
                FROM materiales_solicitud m 
                LEFT JOIN sitios_tipoproyecto st on st.id=m.id_tipoproyecto
                LEFT JOIN tipo_proyecto tp on tp.id= st.id_tipoproyecto
                where m.step_solicitud = 1");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getsitios(){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM sitios ORDER BY nombre ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }
}