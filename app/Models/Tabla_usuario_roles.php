<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_usuario_roles extends Model
{
    protected $table      = 'usuario_roles';
    protected $primaryKey = 'id_usuario';
    protected $returnType = 'object';
    protected $allowedFields = [
        'id_usuario',
        'id_rol'
    ];
    protected $useTimestamps = false;
    protected $useSoftDeletes = false;

   //protected $createdField  = 'creacion';
    //protected $updatedField  = 'actualizacion';
    //protected $deletedField  = 'eliminacion';

    public function login($email = NULL, $password = NULL)
    {
        $resultado = $this
            ->select('estatus_usuario, id_usuario, nombre_usuario, ap_paterno_usuario,
                        ap_materno_usuario, sexo_usuario, email_usuario, imagen_usuario,
                        usuarios.id_rol AS clave_rol, rol AS nombre_rol')
            ->join('roles', 'usuarios.id_rol = roles.id_rol')
            ->where('email_usuario', $email)
            ->where('password_usuario', $password)
            ->first();
        return $resultado;
    } //end login

    public function datatable_usuarios($id_usuario_actual = 0, $rol_actual = 0)
    {
        if ($rol_actual == ROL_SUPERADMIN['clave']) {
            $resultado = $this
                ->select('id_usuario, estatus_usuario, nombre_usuario, ap_paterno_usuario, ap_materno_usuario,
                            sexo_usuario, email_usuario, imagen_usuario, rol, usuarios.eliminacion')
                ->join('roles', 'usuarios.id_rol = roles.id_rol')
                ->where('id_usuario !=', $id_usuario_actual)
                ->orderBy('nombre_usuario', 'ASC')
                ->withDeleted()
                ->findAll();
        } //end if el rol actual es superadmin
        else {
            $resultado = $this
                ->select('id_usuario, estatus_usuario, nombre_usuario, ap_paterno_usuario, ap_materno_usuario,
                            sexo_usuario, email_usuario, imagen_usuario, rol')
                ->join('roles', 'usuarios.id_rol = roles.id_rol')
                ->where('id_usuario !=', $id_usuario_actual)
                ->where('roles.id_rol !=', ROL_SUPERADMIN['clave'])
                ->where('roles.id_rol !=', ROL_ADMIN['clave'])
                ->orderBy('nombre_usuario', 'ASC')
                ->findAll();
        } //end else el rol actual es superadmin
        return $resultado;
    } //end datatable_usuarios

    public function existe_email($email = NULL)
    {
        $resultado = $this
            ->select('email_usuario, eliminacion')
            ->where('email_usuario', $email)
            ->withDeleted()
            ->first();
        $opcion = -1;
        if ($resultado != NULL) {
            if ($resultado->eliminacion == null) {
                $opcion = 2;
            } //end if email no eliminado
            else {
                $opcion = -100;
            } //end else
        } //end if existe registro

        return $opcion;
    } //end existe_email

}//End Model usuarios
