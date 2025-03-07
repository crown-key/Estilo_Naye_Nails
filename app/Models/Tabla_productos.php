<?php

namespace App\Models;

use CodeIgniter\Model;

class Tabla_productos extends Model
{
    protected $table      = 'productos';
    protected $primaryKey = 'id_producto';
    protected $returnType = 'object';
    protected $allowedFields = [
        'estatus_producto', 'id_producto', 'nombre_producto', 'descripcion', 'cantidad'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    protected $createdField  = 'creacion';
    protected $updatedField  = 'actualizacion';
    protected $deletedField  = 'eliminacion';

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

    public function existe_producto($nombre = NULL)
    {
        $resultado = $this
            ->select('nombre_producto, eliminacion')
            ->where('nombre_producto', $nombre)
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

    public function existe_producto_excepto_actual($nombre = NULL, $id_producto = 0)
    {
        $resultado = $this
            ->select('id_producto, nombre_producto, eliminacion')
            ->where('nombre_producto', $nombre)
            ->withDeleted()
            ->first();
        $opcion = -1;
        if ($resultado != NULL) {
            if ($resultado->id_producto == $id_producto) {
                $opcion = -1;
            } else {
                if ($resultado->eliminacion == null) {
                    $opcion = 2;
                } else {
                    $opcion = -100;
                }
            }
        }
        return $opcion;
    } //end existe_producto_excepto_actual
}//End Model productos
