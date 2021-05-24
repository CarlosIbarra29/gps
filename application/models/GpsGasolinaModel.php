<?php

class Application_Model_GpsGasolinaModel extends Zend_Db_Table_Abstract{
    protected $_name = 'add_gasolina';
    protected $_primary = 'id';

    public function insertcontrolgasolina($post,$table,$name_sitio,$name_per,$id_responsable,$placas){
        try {
            $row = $this->createRow();
            $row->id_sitios = $post['sitio'];
            $row->name_sitio = $name_sitio;
            $row->id_responsable = $id_responsable;
            $row->name_responsable = $name_per;
            $row->fecha_requerida = $post['fecha'];
            $row->id_vehiculo = $post['vehiculo'];
            $row->placas= $placas;
            $row->estacion = $post['estacion'];
            $row->forma_pago = $post['forma_pago'];
            $row->importe = $post['importe'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT GASOLINA CONTROL

    public function inserttarjetaefecticard($post,$table,$hoy,$personal){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'no_tarjeta'=>$post['no_tarjeta'],
                'id_responsable'=>$post['personal'],
                'name_responsable'=>$personal,
                'fecha_asignacion'=>$hoy,
                'vigencia'=>$post['vigencia']
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT USER

    public function updatepersonalefecticard($post,$table,$hoy,$personal){
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_responsable = ?, name_responsable = ?, fecha_asignacion =? WHERE id = ?",array(
                $post['responsable'],
                $personal,
                $hoy,
                $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER


    public function updategasolinacontrol($post,$table,$name_sitio,$name_per,$placas){
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET importe = ?, id_sitios = ?, name_sitio = ?, id_responsable = ?, name_responsable = ?, fecha_requerida = ?, id_vehiculo = ?, placas =?, estacion  = ?, forma_pago = ? WHERE id = ?",array(
                $post['importe'],
                $post['sitio'],
                $name_sitio,
                $post['responsable'],
                $name_per,
                $post['fecha'],
                $post['vehiculo'],
                $plascas,
                $post['estacion'],
                $post['forma_pago'],
                $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER


    public function updategasolinacontroldos($post,$table,$odometro,$bomba,$ticket,$id_tarjeta,$nombre_tarjeta){
    	$paso = 1; 
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET id_proyecto = ?, step_gasolina = ?, consumo = ?, odometro_inicial = ?, odometro_final = ?, odometro_file= ?, bomba_file = ?, ticket_file = ?, id_tarjeta = ?, tarjeta = ? WHERE id = ?",array(
                $post['proyecto'],
                $paso,
                $post['consumo'],
                $post['inicial'],
                $post['final'],
                $odometro,
                $bomba,
                $ticket,
                $id_tarjeta,
                $nombre_tarjeta,
                $post['ids']));
            $db->closeConnection();              
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER


    public function updateauditoria($post,$table,$hoy, $name_auditor){
            try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET status_gasolina = ?, name_auditoria = ?, fecha_auditoria = ?, comentario =?  WHERE id = ?",array(
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
    }// END UPDATE USER

    // public function updatepersonalefecticard($table,$post){
    //     $paso = 1; 
    //         try {
    //         $db = Zend_Db_Table::getDefaultAdapter();
    //         $qry = $db->query("UPDATE $table SET status_efecticard = ?, id_efecticard = ? WHERE id = ?",array(
    //             $paso,
    //             $post['no_tarjeta'],
    //             $post['personal']));
    //         $db->closeConnection();              
    //         return $qry;
    //     } 
    //     catch (Exception $e) {
    //         echo $e;
    //     }
    // }// END UPDATE USER


    public function getstepuno(){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT g.id, g.id_sitios, g.name_sitio, g.id_proyecto, g.id_responsable, g.name_responsable, 
                g.fecha_requerida, g.id_vehiculo, g.estacion,  g.forma_pago, g.step_gasolina, g.consumo
				FROM add_gasolina g 
                WHERE g.step_gasolina = 0;");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getstepunopaginator($offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT g.id, g.id_sitios, g.name_sitio, g.id_proyecto, g.id_responsable, g.name_responsable,
                g.fecha_requerida, g.id_vehiculo, g.estacion,  g.forma_pago, g.step_gasolina, g.consumo
				FROM add_gasolina g 
                WHERE g.step_gasolina = 0 LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR

    public function getprocesogasolina($estado){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT g.id, g.id_sitios, g.name_sitio, g.id_proyecto, g.id_responsable, g.name_responsable, 
                g.fecha_requerida, g.id_vehiculo, g.estacion,  g.forma_pago, g.step_gasolina, g.consumo, g.status_gasolina, 
                g.tarjeta, g.placas, v.marca, v.modelo, v.submarca, g.importe, g.tarjeta
                FROM add_gasolina g 
                INNER JOIN vehiculos v on v.id_vehiculos = g.id_vehiculo
                WHERE g.step_gasolina = 1 and g.status_gasolina = ?", array($estado));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getprocesogasolinasitio($estado,$nombre){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT g.id, g.id_sitios, g.name_sitio, g.id_proyecto, g.id_responsable, g.name_responsable, 
                g.fecha_requerida, g.id_vehiculo, g.estacion,  g.forma_pago, g.step_gasolina, g.importe, g.consumo, 
                g.status_gasolina FROM add_gasolina g 
                WHERE g.step_gasolina = 1 AND name_sitio like '%{$nombre}%' and g.status_gasolina = ? ", array($estado));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getprocesogasolinaresponsable($estado,$nombre){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT g.id, g.id_sitios, g.name_sitio, g.id_proyecto, g.id_responsable, g.name_responsable, 
                g.fecha_requerida, g.id_vehiculo, g.estacion,  g.forma_pago, g.step_gasolina, g.importe, g.consumo, 
                g.status_gasolina FROM add_gasolina g 
                WHERE g.step_gasolina = 1 
                AND name_responsable like '%{$nombre}%' and g.status_gasolina = ? ", array($estado));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getprocesogasolinaplacas($estado,$nombre){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT g.id, g.id_sitios, g.name_sitio, g.id_proyecto, g.id_responsable, g.name_responsable, 
                g.fecha_requerida, g.id_vehiculo, g.placas, g.estacion,  g.forma_pago, g.step_gasolina, g.importe,g.consumo, 
                g.status_gasolina FROM add_gasolina g 
                WHERE g.step_gasolina = 1 AND g.placas like '%{$nombre}%' and g.status_gasolina = ? ", array($estado));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getprocesogasolinatarjeta($estado,$nombre){ 
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT g.id, g.id_sitios, g.name_sitio, g.id_proyecto, g.id_responsable, g.name_responsable, 
                g.fecha_requerida, g.id_vehiculo, g.placas, g.estacion,  g.forma_pago, g.step_gasolina, g.importe,g.consumo, 
                g.status_gasolina, g.id_tarjeta FROM add_gasolina g 
                WHERE g.step_gasolina = 1 AND g.id_tarjeta = ? and g.status_gasolina = ? ", array($nombre,$estado));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getprocesopaginator($offset,$no_of_records_per_page,$estado){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT g.id, g.id_sitios, g.name_sitio, g.id_proyecto, g.id_responsable, g.name_responsable, 
                g.fecha_requerida, g.id_vehiculo, g.estacion, g.forma_pago, g.importe, g.step_gasolina, g.consumo, 
                g.status_gasolina, g.id_vehiculo, g.tarjeta, v.placas
                FROM add_gasolina g 
                LEFT JOIN vehiculos v on g.id_vehiculo = v.id_vehiculos 
                WHERE g.step_gasolina = 1 and g.status_gasolina = ? LIMIT $offset,$no_of_records_per_page",array($estado));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR

    public function getprocesopaginatorsitio($offset,$no_of_records_per_page,$estado,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT g.id, g.id_sitios, g.name_sitio, g.id_proyecto, g.id_responsable, g.name_responsable, 
                g.fecha_requerida, g.id_vehiculo, g.estacion, g.forma_pago, g.importe, g.step_gasolina, g.consumo, 
                g.status_gasolina, g.id_vehiculo, v.placas
                FROM add_gasolina g 
                LEFT JOIN vehiculos v on g.id_vehiculo = v.id_vehiculos 
                WHERE g.step_gasolina = 1 AND name_sitio like '%{$nombre}%' and g.status_gasolina = ? LIMIT $offset,$no_of_records_per_page",array($estado));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR

    public function getprocesopaginatorresponsable($offset,$no_of_records_per_page,$estado,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT g.id, g.id_sitios, g.name_sitio, g.id_proyecto, g.id_responsable, g.name_responsable, 
                g.fecha_requerida, g.id_vehiculo, g.estacion, g.forma_pago, g.importe, g.step_gasolina, g.consumo, 
                g.status_gasolina, g.id_vehiculo, v.placas
                FROM add_gasolina g 
                LEFT JOIN vehiculos v on g.id_vehiculo = v.id_vehiculos 
                WHERE g.step_gasolina = 1 AND name_responsable like '%{$nombre}%' and g.status_gasolina = ? LIMIT $offset,$no_of_records_per_page",array($estado));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR

    public function getprocesopaginatorplacas($offset,$no_of_records_per_page,$estado,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT g.id, g.id_sitios, g.name_sitio, g.id_proyecto, g.id_responsable, g.name_responsable, 
                g.fecha_requerida, g.id_vehiculo,g.placas, g.estacion, g.forma_pago, g.importe, g.step_gasolina, g.consumo, 
                g.status_gasolina, g.id_vehiculo, v.placas
                FROM add_gasolina g 
                LEFT JOIN vehiculos v on g.id_vehiculo = v.id_vehiculos 
                WHERE g.step_gasolina = 1 AND g.placas like '%{$nombre}%' and g.status_gasolina = ? LIMIT $offset,$no_of_records_per_page",array($estado));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR

    public function getprocesopaginatortarjeta($offset,$no_of_records_per_page,$estado,$nombre){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT g.id, g.id_sitios, g.name_sitio, g.id_proyecto, g.id_responsable, g.name_responsable, 
                g.fecha_requerida, g.id_vehiculo,g.placas, g.estacion, g.forma_pago, g.importe, g.step_gasolina, g.consumo, 
                g.status_gasolina, g.id_tarjeta, v.placas
                FROM add_gasolina g 
                LEFT JOIN vehiculos v on g.id_vehiculo = v.id_vehiculos 
                WHERE g.step_gasolina = 1 AND g.id_tarjeta = ? and g.status_gasolina = ? LIMIT $offset,$no_of_records_per_page",array($nombre,$estado));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR

    public function getefecticardpaginator($offset,$no_of_records_per_page){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT t.id, t.no_tarjeta,t.id_responsable, t.status_tarjeta, t.fecha_asignacion, t.vigencia,
                p.nombre, p.apellido_pa, p.apellido_ma
                FROM tarjeta_efecticard t
                LEFT JOIN personal_campo p on t.id_responsable = p.id LIMIT $offset,$no_of_records_per_page");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR


    public function getinfoindex($year,$month){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ad.id,ad.id_sitios, ad.name_sitio, ad.id_proyecto, ad.id_responsable, 
                ad.name_responsable, ad.fecha_requerida, ad.id_vehiculo, ad.placas, ad.estacion, ad.forma_pago,ad.importe, 
                ad.step_gasolina, ad.consumo, ad.odometro_inicial, ad.odometro_final, ad.id_tarjeta, ad.tarjeta, 
                Month(date(ad.fecha_requerida)) as mes ,YEAR(date(ad.fecha_requerida)) as years 
                FROM add_gasolina ad having mes = $month AND years = $year");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR

    public function getinfoindexsitio($year,$month, $sitio){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT ad.id,ad.id_sitios, ad.name_sitio, ad.id_proyecto, ad.id_responsable, 
                ad.name_responsable, ad.fecha_requerida, ad.id_vehiculo, ad.placas, ad.estacion, ad.forma_pago,ad.importe, 
                ad.step_gasolina, ad.consumo, ad.odometro_inicial, ad.odometro_final, ad.id_tarjeta, ad.tarjeta, 
                Month(date(ad.fecha_requerida)) as mes ,YEAR(date(ad.fecha_requerida)) as years 
                FROM add_gasolina ad having mes = $month AND years = $year AND ad.id_proyecto = $sitio");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET INFO TO PAGINATOR

}