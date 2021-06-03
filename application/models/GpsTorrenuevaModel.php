<?php

class Application_Model_GpsTorrenuevaModel extends Zend_Db_Table_Abstract{
    protected $_name = 'torre_nuevafile';
    protected $_primary = 'id';
    public function inserttorrenuevafile($post,$table){
        try {
            $row = $this->createRow();
            $row->id_sitio = $post['id_sitio'];
            $row->proyecto = $post['proyecto'];
            $row->sitio = $post['sitio'];
            $res = $row->save();              
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT TORRE NUEVA FILE

    public function insertdocdostorrenueva($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitio'=>$post['id_sitio'],
                'proyecto'=>$post['proyecto'],
                'sitio'=>$post['sitio']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT DOCUMENTOS TORRE NUEVA DOS

    public function insertavancetorrenueva($post,$table){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitiotipo'=>$post['sitio']); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT DOCUMENTOS TORRE NUEVA DOS


    public function insertcomentarioavance($post,$table,$nombre_user,$hoy){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitiotipo'=>$post['sitio'],
                'comentario'=>$post['comentario'],
                'user_comentario'=>$nombre_user,
                'fecha_comentario'=>$hoy
            ); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT DOCUMENTOS TORRE NUEVA DOS



    public function insertdescripcioncambios($post,$table,$hoy,$dato){
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $datasave = array(
                'id_sitio'=>$post['id_sitio'],
                'proyecto_id'=>$post['proyecto'],
                'sitio'=>$post['sitio'],
                'version'=>$post['version'],
                'descripcion'=>$post['des_cambio'],
                'fecha'=>$hoy,
                'usuario'=>$dato); 
            $res = $db->insert($table, $datasave);
            $db->closeConnection();               
            return $res;
        } catch (Exception $e) {
            echo $e;
        }
    }// END INSERT DESCRIPCION DE CAMBIOS



    public function getexist($id,$proyecto,$sitio){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT  tn.id, tn.id_sitio, tn.proyecto, tn.sitio, tn.torre_file, tn.torre_status, 
                        tn.user_torre, tn.fecha_torre,tn.simentacion_file, tn.simentacion_status, 
                        tn.fecha_simentacion, tn.user_simentacion,tn.calculo_file,tn.calculo_status, 
                        tn.fecha_calculo, tn.user_calculo, tn.staad_status, tn.staad_file, tn.fecha_saad,
                        tn.user_staad,tn.mecanica_status, tn.mecanica_file, tn.fecha_mecanica, 
                        tn.user_mecanica, tn.acero_file, tn.acero_status, tn.fecha_acero, tn.user_acero, 
                        tn.tornilleria_file,tn.tornilleria_status,tn.fecha_tornilleria, tn.user_tornilleria,
                        tn.galvanizado_file,tn.galvanizado_status,tn.fecha_galvanizado, tn.user_galvanizado,
                        tn.verticalidad_file, tn.verticalidad_status, tn.fecha_verticalidad, 
                        tn.user_verticalidad, tn.tension_file, tn.tension_status, tn.fecha_tension, 
                        tn.user_tension, tn.foto_file, tn.foto_status, tn.fecha_foto, tn.user_foto, 
                        tn.tor_file, tn.tor_status, tn.fecha_tor, tn.user_tor, tn.pesoacero_file, 
                        tn.pesoacero_status, tn.fecha_pesoacero, tn.user_pesoacero, tn.torrepdf_file, 
                        tn.torrepdf_status, tn.fecha_torrepdf,tn.user_torrepdf,tn.torredwg_file, 
                        tn.torredwg_status,tn.fecha_torredwg,tn.user_dwg, tn.modelotorre_status, 
                        tn.modelotorre_file, tn.fecha_torrenueva,tn.user_torrenueva,tn.colloapp,tn.fecha_colloapp,
                        tn.user_colloapp, tn.colloapp_status
                        FROM torre_nuevafile tn 
                        WHERE tn.id_sitio = ? and tn.proyecto =? and tn.sitio = ?",array($id,$proyecto,$sitio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } 


    public function getexistinfodos($id,$proyecto,$sitio){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT tn.id, tn.id_sitio, tn.proyecto, tn.sitio, tn.velocidad, tn.terreno, 
                        tn.rugosidad, tn.topography, tn.estructura, tn.mar_asnm, tn.temp, tn.carga
                        FROM detalle_torrenueva tn 
                        WHERE tn.id_sitio = ? and tn.proyecto =? and tn.sitio = ?",array($id,$proyecto,$sitio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function refreshtorre($post,$table,$id_torrenueva,$urldb){
        $torre_status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET torre_file = ?, torre_status = ? WHERE id = ?",array(
                $urldb,
                $torre_status,
                $id_torrenueva));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function refreshtorrenuevados($post,$table,$id){
        $torre_status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET velocidad = ?, terreno = ?, rugosidad = ?,topography = ?, estructura= ?, mar_asnm =?, temp = ?, carga =? WHERE id = ?",array(
                $post['velocidad'],
                $post['terreno'],
                $post['rugosidad'],
                $post['topography'],
                $post['estructura'],
                $post['mar_asnm'],
                $post['temp'],
                $post['carga'],
                $id));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE INFO 2 TORRE NUEVA

    public function refreshsimentacion($post,$table,$id_torrenueva,$urldb){
        $torre_status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET simentacion_file = ?, simentacion_status = ? WHERE id = ?",array(
                $urldb,
                $torre_status,
                $id_torrenueva));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function refreshmemoria($post,$table,$id_torrenueva,$urldb){
        $torre_status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET calculo_file = ?, calculo_status = ? WHERE id = ?",array(
                $urldb,
                $torre_status,
                $id_torrenueva));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function refresstaad($post,$table,$id_torrenueva,$urldb){
        $torre_status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET staad_file = ?, staad_status = ? WHERE id = ?",array(
                $urldb,
                $torre_status,
                $id_torrenueva));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER


    public function udpateavancetorre($post,$table,$total_suministro,$user_suministro,$fecha_suministro,$status_suministro,$total_corte,$user_corte,$fecha_corte,$status_corte,$total_soldadura,$user_soldadura,$fecha_soldadura,$status_soldadura,$total_galvanizado,$user_galvanizado,$fecha_galvanizado,$status_galvanizado,$hoy,$nombre_user,$id_sol){
        $torre_status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET suministro_materiales = ?, user_suministro = ?, fecha_suministro =?, status_suministro =?, corte =?, user_corte =?, fecha_corte= ?, status_corte= ?, soldadura =?, user_soldadura =?, fecha_soldadura =?, status_soldadura=?, galvanizado= ?, user_galvanizado=?, fecha_galvanizado=?, status_galvanizado =? WHERE id = ?",array(
                $total_suministro,
                $user_suministro,
                $user_suministro,
                $status_suministro,
                $total_corte,
                $user_corte,
                $fecha_corte,
                $status_corte,
                $total_soldadura,
                $user_soldadura,
                $fecha_soldadura,
                $status_soldadura,
                $total_galvanizado,
                $user_galvanizado,
                $fecha_galvanizado,
                $status_galvanizado,
                $id_sol
            ));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function refresmecanica($post,$table,$id_torrenueva,$urldb){
        $torre_status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET mecanica_file = ?, mecanica_status = ? WHERE id = ?",array(
                $urldb,
                $torre_status,
                $id_torrenueva));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }// END UPDATE USER

    public function refreshfiletorrenueva($post,$table,$id_torrenueva,$urldb,$nombre_file,$torre_status, $fecha_user, $user_file, $hoy, $user){
        $status = 1;
        try {
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("UPDATE $table SET $nombre_file=?, $torre_status=?, $fecha_user=?, $user_file=? WHERE id = ?",array(
                $urldb,
                $status,
                $hoy,
                $user,
                $id_torrenueva));
            $db->closeConnection();               
            return $qry;
        } 
        catch (Exception $e) {
            echo $e;
        }
    }

    public function gettorre_nuevacambios($id,$proyecto,$sitio){  
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT tc.id, tc.id_sitio, tc.proyecto_id, tc.sitio, tc.sitio, tc.version, 
                        tc.descripcion, tc.fecha, tc.usuario 
                        FROM torre_nuevacambios tc 
                        WHERE tc.id_sitio =? AND tc.proyecto_id=? AND tc.sitio = ?;",array($id,$proyecto,$sitio));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getdocumentaciontorre(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT t.id_sitio,s.id_cliente,s.nombre,s.altura, e.nombre_estructura, t.proyecto, 
                        t.sitio, t.torre_file, t.torre_status, t.user_torre, t.fecha_torre, t.simentacion_file, 
                        t.simentacion_status, t.fecha_simentacion, t.user_simentacion ,t.calculo_file, 
                        t.calculo_status, t.fecha_calculo, t.user_calculo, t.staad_file,t.staad_status,t.fecha_saad,
                        t.user_staad, t.modelotorre_file, t.modelotorre_status, t.mecanica_file, t.fecha_torrenueva,
                        t.user_torrenueva, t.mecanica_status, t.fecha_mecanica, t.user_mecanica, t.acero_file, 
                        t.acero_status, t.fecha_acero, t.user_acero, t.tornilleria_file, t.fecha_tornilleria, 
                        t.user_tornilleria, t.galvanizado_file,t.galvanizado_status, t.fecha_galvanizado, 
                        t.user_galvanizado,t.verticalidad_file, t.verticalidad_status, t.fecha_verticalidad, 
                        t.user_verticalidad, t.tension_file, t.tension_status, t.fecha_tension, t.user_tension, 
                        t.foto_file, t.foto_status, t.fecha_foto, t.user_foto,t.tor_file, t.tor_status, t.fecha_tor,
                        t.user_tor, t.pesoacero_file, t.pesoacero_status, t.fecha_pesoacero, t.user_pesoacero, 
                        t.torrepdf_file, t.torrepdf_status, t.user_dwg, t.fecha_torrepdf, t.user_torrepdf, 
                        t.torredwg_file, t.torredwg_status,t.fecha_torredwg
                        FROM torre_nuevafile t
                        INNER JOIN sitios s on t.id_sitio= s.id
                        INNER JOIN estructura_sitio e on e.id= s.estructura;");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getfactoresdiseno(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT dt.id_sitio,s.id_cliente,s.nombre,s.altura,e.nombre_estructura, 
                        dt.sitio as id_proyecto, dt.velocidad,dt.terreno, dt.rugosidad, dt.topography, 
                        dt.estructura, dt.mar_asnm, dt.temp, dt.carga, sp.nombre_status as status_gps, 
                        sc.nombre_status as status_cliente,ta.suministro_materiales, ta.corte, ta.soldadura, 
                        ta.galvanizado
                        FROM detalle_torrenueva dt
                        LEFT JOIN sitios s on s.id = dt.id_sitio
                        LEFT JOIN estructura_sitio e on e.id= s.estructura
                        LEFT JOIN sitios_tipoproyecto st on st.id = dt.sitio
                        LEFT JOIN status_proyecto sp on sp.id = st.status_proyecto
                        LEFT JOIN status_cliente sc on sc.id = st.status_cliente
                        LEFT JOIN torrenueva_avances ta on ta.id_sitiotipo = dt.sitio");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }

    public function getbitacoracambios(){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT t.id_sitio, s.nombre, s.altura, e.nombre_estructura, t.version, t.descripcion, 
                        t.fecha,t.usuario
                        FROM torre_nuevacambios t
                        INNER JOIN sitios s on s.id = t.id_sitio
                        INNER JOIN estructura_sitio e on e.id = s.estructura");
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    }


}