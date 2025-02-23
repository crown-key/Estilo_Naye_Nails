<?php
namespace App\Libraries;

class Permisos {

    public static function is_rol_permitido($clave_tarea = '', $clave_rol = -1){
        $permiso = FALSE;
        switch($clave_rol) {

            case ROL_SUPERADMIN['clave']:
                $permiso = in_array($clave_tarea, PERMISOS_SUPERADMIN);
            break;

            case ROL_ADMIN['clave']:
                $permiso = in_array($clave_tarea, PERMISOS_ADMIN);
            break;

            case ROL_TRABAJADOR['clave']:
                $permiso = in_array($clave_tarea, PERMISOS_TRABAJADOR);
            break;
            
            default:
                $permiso = FALSE;
            break;
        }//end switch clave_rol
        return $permiso;
    }//end is_rol_permitido

}//End class Permisos
