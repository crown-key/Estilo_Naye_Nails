<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_productos extends Model{
    protected $table      = 'productos';
    protected $primaryKey = 'id_producto';
    protected $returnType = 'object';
    protected $allowedFields = ['id_producto', 'nombre_producto', 'descripcion', 'cantidad', 'eliminacion'];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';


    /*public function login($id_producto = NULL)
    {
        $resultado = $this
            ->select('id_producto, nombre_producto, descripcion, cantidad')
            ->where('id_producto', $id_producto)
            ->first();
        return $resultado;
    } //end login*/

    public function obtener_producto($id_producto = 0)
    {
        $resultado = $this
            ->select('id_producto, nombre_producto, descripcion, cantidad')
            ->where('id_producto', $id_producto)
            ->first();
        return $resultado;
    } //end obtener_producto

    public function datatable_productos()
    {
        $resultado = $this
            ->select('id_producto, estatus_producto, nombre_producto, descripcion, cantidad, eliminacion')
            ->orderBy('nombre_producto', 'ASC')
            ->withDeleted()
            ->findAll();
        return $resultado;
    } //end datatable_productos

    public function existe_producto($id_producto = NULL)
    {
        $resultado = $this
            ->select('id_producto, eliminacion')
            ->where('id_producto', $id_producto)
            ->withDeleted()
            ->first();
        $opcion = -1;
        if ($resultado != NULL) {
            if ($resultado->eliminacion == null) {
                $opcion = 2;
            } else {
                $opcion = -100;
            }
        }
        return $opcion;
    } //end existe_producto

    
}//End Model productos
