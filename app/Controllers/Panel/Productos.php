<?php namespace App\Controllers\Panel;
use App\Controllers\BaseController;
use App\Libraries\Permisos;

class Productos extends BaseController{
	private $permitido = true;

	public function __construct(){
		$session = session();
		if(!Permisos::is_rol_permitido(TAREA_PRODUCTOS, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
			$this->permitido = false;
		}//end if rol no permitido
		else{
			$session->tarea_actual = TAREA_PRODUCTOS;
		}//end else rol permitido
	}//end constructor

	public function index(){
		if($this->permitido){
			return $this->crear_vista("panel/productos", $this->cargar_datos());
		}//end if rol permitido
		else{
			mensaje('No tienes permisos para acceder a esta sección.', DANGER_ALERT, '¡Acceso No Autorizado!');
			return redirect()->to(route_to('login'));
		}//end else rol no permitido
	}//end index

	private function cargar_datos(){
		//======================================================================
		//==========================DATOS FUNDAMENTALES=========================
		//======================================================================
		$datos = array();
		$session = session();
		$datos['nombre_completo_usuario'] = $session->nombre_completo_usuario;
		$datos['email_usuario'] = $session->email_usuario;
		$datos['imagen_usuario'] = ($session->imagen_usuario == NULL ?
									($session->sexo_usuario == SEXO_MASCULINO ? 'no-image-m.png' : 'no-image-f.png') :
									$session->imagen_usuario);
		//======================================================================
		//========================DATOS PROPIOS CONTROLLER======================
		//======================================================================
		$datos['nombre_pagina'] = 'Productos';

		//Cargar modelos
		$tabla_productos = new \App\Models\Tabla_productos();
		$datos['productos'] = $tabla_productos->datatable_productos($session->id_producto, $session->rol_actual['clave']);

		//Breadcrumb
		$navegacion = array(
							array(
                          		'tarea' => 'Productos',
                          		'href' => '#'
                        	)
                      );
    	$datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Productos');

		return $datos;
	}//end cargar_datos

	


	private function crear_vista($nombre_vista, $contenido = array()){
		$contenido['menu'] = crear_menu_panel();
		return view($nombre_vista, $contenido);
	}//end crear_vista

	

	public function eliminar() {
		if($this->permitido){
			$tabla_productos = new \App\Models\Tabla_productos;
			if($tabla_productos->delete($this->request->getPost('id_producto'))) {
				mensaje("El producto ha sido eliminado exitosamente", SUCCESS_ALERT, "¡Producto eliminado!");
				return $this->response->setJSON(['error' => 0]);
			}//end if elimina
			else {
				mensaje("Hubo un error al eliminar el producto, intenta nuevamente", DANGER_ALERT, "¡Error al eliminar!");
				return $this->response->setJSON(['error' => 1]);
			}//end else
		}//end if es un usuario permitido
		else{
			mensaje("Hubo un error al eliminar el producto, intenta nuevamente", DANGER_ALERT, "¡Error al eliminar!");
			return $this->response->setJSON(['error' => 1]);
		}//end else es un usuario permitido
    }//end eliminar

	public function recuperar_producto() {
		if($this->permitido && (session()->rol_actual['clave'] == ROL_SUPERADMIN['clave'])){
			$mensaje = array();
			$tabla_productos = new \App\Models\Tabla_productos;
			if($tabla_productos->update($this->request->getPost('id'), array('eliminacion' => NULL))) {
				$mensaje['mensaje'] = 'El producto se encuentra de nuevo en los registros de la base de datos.';
				$mensaje['tipo_mensaje'] = SUCCESS_ALERT;
				$mensaje['titulo'] = '¡Registro recuperado!';

				$acciones = array();
				$acciones[] = 'window.location = "./administracion_productos";';

				mensaje("El producto ha sido recuperado exitosamente", SUCCESS_ALERT, "¡Producto recuperado!");
				return $this->response->setJSON(['error' => 0, 'mensaje' => $mensaje, 'actions' => $acciones]);
			}//end if se recupera el registro
			else {
				$mensaje['mensaje'] = 'Hubo un error al intentar recuperar el registro, checa tu conexión a internet o intente nuevamente, por favor.';
				$mensaje['tipo_mensaje'] = DANGER_ALERT;
				$mensaje['titulo'] = '¡Error al recuperar el registro!';

				$acciones = array();
				mensaje("Hubo un error al intentar recuperar el producto, intente de nuevo, por favor.", DANGER_ALERT, "¡Producto no recuperado!");
				return $this->response->setJSON(['error' => -1, 'mensaje' => $mensaje, 'actions' => $acciones]);
			}//end else se recupera el registro
		}//end if es un usuario permitido
		else{
			return $this->response->setJSON(['error' => -1, 'mensaje' => array(), 'actions' => array()]);
		}//end else es un usuario permitido
	}//end recuperar_usuario

	public function actualizar_producto()
{
    if ($this->permitido) {
        $tabla_productos = new \App\Models\Tabla_productos;
        $id_producto = $this->request->getPost('id_producto');
        
        $producto = [
            'actualizacion' => fecha_actual(),
            'nombre_producto' => $this->request->getPost('nombre_producto'),
            'descripcion' => $this->request->getPost('descripcion'),
            'cantidad' => $this->request->getPost('cantidad'),
        ];
        
        if ($tabla_productos->update($id_producto, $producto)) {
            mensaje("El producto se ha actualizado exitosamente.", SUCCESS_ALERT, "¡Producto actualizado!");
            return redirect()->to(route_to('administracion_productos'));
        } else {
            mensaje("Hubo un error al actualizar el producto. Intente de nuevo, por favor.", ERROR_ALERT, "¡Producto no actualizado!");
            return redirect()->to(route_to('administracion_productos'));
        }
    } else {
        mensaje("No tienes permisos para actualizar el producto.", ERROR_ALERT, "¡Acceso denegado!");
        return $this->response->setJSON(['error' => 1]);
    }
}

}//End Class Usuarios
