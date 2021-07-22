<?php

class Application_Model_GpsTagModel extends Zend_Db_Table_Abstract{
    protected $_name = 'tag';
    protected $_primary = 'id';


    public function GetTags(){ 
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT distinct tag
                FROM tag");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }


    public function GetTagspaginator($offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT distinct tag 
                FROM tag  LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET INFO TO PAGINATOR

    public function GetArrayConsumosTag(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT id, concesionaria, fecha, tag, entrada, salida, importe, 
                id_sitio, id_proyecto  
                FROM tag");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } //END GET Consumos ya cargados

    public function insertTagConsumos($post,$table){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'concesionaria'=> utf8_encode($post['concesionaria'] ),
                'fecha'=> utf8_encode($post['fecha'] ),
                'tag'=> utf8_encode($post['tag'] ),
                'entrada'=> utf8_encode($post['entrada'] ),
                'salida'=> utf8_encode($post['salida']),
                'importe'=>utf8_encode($post['importe']),
                'id_sitio'=> utf8_encode($post['id_sitio']),
                'id_proyecto'=>utf8_encode($post['id_proyecto'])
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    }// END INSERT Consumos TAG

    public function GetSpecificTag($table,$wh,$id){
        
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT * FROM $table WHERE $wh like '%{$id}%'");
            $row = $qry->fetchAll();
            $db->closeConnection();
            return $row;
        }
        catch (Exception $e) {
        
            echo $e;
        
        }
    }


    public function GetpaginationTagSpf($table,$id,$offset,$no_of_records_per_page){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT t.id, t.concesionaria, t.fecha, t.tag, t.entrada, t.salida, t.importe,t.id_sitio,t.id_proyecto,
                        s.id_cliente, s.nombre, s.cliente, st.id_tipoproyecto, st.status_proyecto, st.status_cliente, st.operador, 
                        tp.nombre_proyecto
                        FROM tag t
                        LEFT JOIN sitios s ON s.id = t.id_sitio
                        LEFT JOIN sitios_tipoproyecto st ON st.id = t.id_proyecto
                        LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                        WHERE t.tag like '%{$id}%' ORDER BY t.fecha ASC LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }// CONSULTA TAG


    public function proyectosActuales(){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT tis.id, tis.id_sitio, tis.id_tipoproyecto, tp.id as idp, tp.nombre_proyecto, s.nombre, 
                        s.id_cliente
                        FROM sitios_tipoproyecto tis
                        LEFT JOIN tipo_proyecto tp on tis.id_tipoproyecto= tp.id 
                        LEFT JOIN sitios s on s.id = tis.id_sitio ORDER BY s.nombre ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }  
    }


    public function GetTagSitio($id,$sitio){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT t.id, t.concesionaria, t.fecha, t.tag, t.entrada, t.salida, t.importe,t.id_sitio,t.id_proyecto,
                        s.id_cliente, s.nombre, s.cliente,st.id_tipoproyecto, st.status_proyecto, st.status_cliente, st.operador, 
                        tp.nombre_proyecto
                        FROM tag t
                        LEFT JOIN sitios s ON s.id = t.id_sitio
                        LEFT JOIN sitios_tipoproyecto st ON st.id = t.id_proyecto
                        LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                        WHERE t.tag like '%{$id}%' And t.id_sitio = ? ORDER BY t.fecha",array($sitio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por Sitio
    

    public function GetTagSitioPaginator($table,$offset,$no_of_records_per_page,$id,$sitio){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT t.id, t.concesionaria, t.fecha, t.tag, t.entrada, t.salida, t.importe,t.id_sitio,t.id_proyecto,
                        s.id_cliente, s.nombre, s.cliente,st.id_tipoproyecto, st.status_proyecto, st.status_cliente, st.operador, 
                        tp.nombre_proyecto
                        FROM tag t
                        LEFT JOIN sitios s ON s.id = t.id_sitio
                        LEFT JOIN sitios_tipoproyecto st ON st.id = t.id_proyecto
                        LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                        WHERE t.tag like '%{$id}%' And t.id_sitio = ? 
                        ORDER BY t.fecha LIMIT $offset,$no_of_records_per_page",array($sitio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por Sitio 


     public function GetTagProyecto($id,$proyecto){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT t.id, t.concesionaria, t.fecha, t.tag, t.entrada, t.salida, t.importe,t.id_sitio,t.id_proyecto,
                        s.id_cliente, s.nombre, s.cliente,st.id_tipoproyecto, st.status_proyecto, st.status_cliente, st.operador, 
                        tp.nombre_proyecto
                        FROM tag t
                        LEFT JOIN sitios s ON s.id = t.id_sitio
                        LEFT JOIN sitios_tipoproyecto st ON st.id = t.id_proyecto
                        LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                        WHERE t.tag like '%{$id}%' And t.id_proyecto = ? ORDER BY t.fecha",array($proyecto));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por Proyecto
    

    public function GetTagProyectoPaginator($table,$offset,$no_of_records_per_page,$id,$proyecto){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT t.id, t.concesionaria, t.fecha, t.tag, t.entrada, t.salida, t.importe,t.id_sitio,t.id_proyecto,
                        s.id_cliente, s.nombre, s.cliente,st.id_tipoproyecto, st.status_proyecto, st.status_cliente, st.operador, 
                        tp.nombre_proyecto
                        FROM tag t
                        LEFT JOIN sitios s ON s.id = t.id_sitio
                        LEFT JOIN sitios_tipoproyecto st ON st.id = t.id_proyecto
                        LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                        WHERE t.tag like '%{$id}%' And t.id_proyecto = ? ORDER BY t.fecha 
                        LIMIT $offset,$no_of_records_per_page",array($proyecto));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por Proyecto 


    public function GetTagMes($id,$mes,$year){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT t.id, t.concesionaria, t.fecha, t.tag, t.entrada, t.salida, t.importe,t.id_sitio,t.id_proyecto,
                        s.id_cliente, s.nombre, s.cliente,st.id_tipoproyecto, st.status_proyecto, st.status_cliente, st.operador, 
                        tp.nombre_proyecto,
                        YEAR(DATE(CONCAT(SUBSTRING(t.fecha,7,4),'-',SUBSTRING(t.fecha,4,2), '-',SUBSTRING(t.fecha,1,2)))) AS AÑO,
                        MONTH(DATE(CONCAT(SUBSTRING(t.fecha,7,4),'-',SUBSTRING(t.fecha,4,2),'-',SUBSTRING(t.fecha,1,2)))) AS MES,
                        DAY(DATE(CONCAT(SUBSTRING(t.fecha,7,4),'-',SUBSTRING(t.fecha,4,2),'-', SUBSTRING(t.fecha,1,2)))) AS DIA
                        FROM tag t
                        LEFT JOIN sitios s ON s.id = t.id_sitio
                        LEFT JOIN sitios_tipoproyecto st ON st.id = t.id_proyecto
                        LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                        HAVING t.tag like '%{$id}%' And MES = ? And AÑO = $year ORDER BY t.fecha",array($mes));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor por Mes
    

    public function GetTagMesPaginator($table,$offset,$no_of_records_per_page,$id,$mes,$year){
        
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT t.id, t.concesionaria, t.fecha, t.tag, t.entrada, t.salida, t.importe,t.id_sitio,t.id_proyecto,
                        s.id_cliente, s.nombre, s.cliente, st.id_tipoproyecto, st.status_proyecto, st.status_cliente, st.operador, 
                        tp.nombre_proyecto,
                        YEAR(DATE(CONCAT(SUBSTRING(t.fecha,7,4),'-', SUBSTRING(t.fecha,4,2), '-', SUBSTRING(t.fecha,1,2)))) AS AÑO,
                        MONTH(DATE(CONCAT(SUBSTRING(t.fecha,7,4),'-', SUBSTRING(t.fecha,4,2),'-', SUBSTRING(t.fecha,1,2)))) AS MES,
                        DAY(DATE(CONCAT(SUBSTRING(t.fecha,7,4), '-', SUBSTRING(t.fecha,4,2), '-', SUBSTRING(t.fecha,1,2)))) AS DIA
                        FROM tag t
                        LEFT JOIN sitios s ON s.id = t.id_sitio
                        LEFT JOIN sitios_tipoproyecto st ON st.id = t.id_proyecto
                        LEFT JOIN tipo_proyecto tp ON tp.id = st.id_tipoproyecto
                        HAVING t.tag like '%{$id}%' And MES = ? And AÑO = $year ORDER BY t.fecha 
                        LIMIT $offset,$no_of_records_per_page",array($mes));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    }   //Buscardor en Paginacion por Mes 



    public function sitiosproyectoexcel(){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT s.id, s.id_cliente,s.Idgps, s.nombre, s.cliente, s.direccion, 
                        s.ciudad, s.estado, s.region, s.estructura, s.altura, s.edificio, s.tipo_sitio, s.latitude, 
                        s.longitude, p.id as id_proyecto, p.id_tipoproyecto,  tp.nombre_proyecto
                        FROM sitios s
                        LEFT JOIN sitios_tipoproyecto p on p.id_sitio = s.id
                        LEFT JOIN tipo_proyecto tp ON tp.id = p.id_tipoproyecto
                        ORDER BY s.id ASC");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }
        catch (Exception $e){
        
            echo $e;
        
        }
    } 

} 