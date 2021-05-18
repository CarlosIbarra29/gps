<?php

class Application_Model_GpsPersonalModel extends Zend_Db_Table_Abstract{

    public function getpersonalcuadrilla($offset,$no_of_records_per_page,$id){
        try{
            $db = Zend_Db_Table::getDefaultAdapter();
            $qry = $db->query("SELECT pc.id, pc.nombre, pc. apellido_pa, pc.apellido_ma, pc.imagen, pc.curp, pc.puesto,
                                pc.status_expediente, pc.telefono, pc.email_personal, pc.nss, pc.rfc, pc.dia_pago, 
                                pc.hora_pago, pc.status_personal, pc.fecha_personal, pc.status_cuadrilla, 
                                pc.tipo_proyectopersonal, pc.sitio_tipoproyectopersonal, pc. id_sitiopersonal, 
                                pc.name_sitio,pc.delete_status ,pp.id as idpuesto, pp.nombre as name_puesto,  
                                pc.status_operativo , pc.status_campo, tp.nombre_proyecto
                                FROM personal_campo pc 
                                LEFT JOIN puestos_personal pp on pc.puesto = pp.id 
                                LEFT JOIN tipo_proyecto tp on tp.id = pc.tipo_proyectopersonal 
                                WHERE pc.status_campo = ?
                                LIMIT $offset,$no_of_records_per_page",array($id));
            $row = $qry->fetchAll();
            return $row;
            $db->closeConnection();
        }catch (Exception $e){
            echo $e;
        }
    } //END GET PAGINATOR PERSONAL

}