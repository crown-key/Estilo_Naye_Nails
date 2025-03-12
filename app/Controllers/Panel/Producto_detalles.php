<?php
namespace App\Controllers\Panel;
use App\Controllers\BaseController;
use App\Libraries\Permisos;

/*class Producto_detalles extends BaseController{
	private $permitido = true;

	public function __construct(){
		$session = session();
		if(!Permisos::is_rol_permitido(TAREA_PRODUCTO_DETALLES, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
			$this->permitido = false;
		}//end if rol no permitido
		else{
			$session->tarea_actual = TAREA_PRODUCTO_DETALLES;
		}//end else rol permitido
	}//end constructor

	public function index($id_producto = 0){
		if($this->permitido){
			$tabla_productos = new \App\Models\Tabla_productos;
			$producto = $tabla_productos->obtener_producto($id_producto);
			if($producto == NULL){
				mensaje('No se encuentra el producto proporcionado.', WARNING_ALERT, '¡Producto no encontrado!');
				return redirect()->to(route_to('administracion_productos'));
			}//end if no existe el producto
			else{
				
					return $this->crear_vista("panel/producto_detalles", $this->cargar_datos($producto));
				
			}//end else no existe
		}//end if producto permitido
		else{
			mensaje('No tienes permisos para acceder a esta sección.', DANGER_ALERT, '¡Acceso no autorizado!');
			return redirect()->to(route_to('login'));
		}//end else rol no permitido
	}//end index

	private function cargar_datos($producto = NULL){
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
		$datos['nombre_pagina'] = 'Detalles usuario';
		//Cargar modelos
		$tabla_roles = new \App\Models\Tabla_roles;
		$datos['roles'] = $tabla_roles->obtener_roles($session->rol_actual['clave']);
		$datos['producto'] = $producto;

		//Breadcrumb
		$navegacion = array(
							array(
                          		'tarea' => 'Productos',
                          		'href' => route_to('administracion_productos'),
								'extra' => ''
                        	),
							array(
                          		'tarea' => 'Detalles producto',
                          		'href' => '#'
                        	)
                      );
    	$datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Detalles del producto:');

		return $datos;
	}//end cargar_datos

	private function crear_vista($nombre_vista, $contenido = array()){
		$contenido['menu'] = crear_menu_panel();
		return view($nombre_vista, $contenido);
	}//end crear_vista

	
   
    
	public function editar_producto(){
		if($this->permitido){
			$id_producto = $this->request->getPost('id_producto');

			if($this->request->getPost('nombre_producto') == NULL){
				mensaje("Debes poner un nombre", DANGER_ALERT, "¡No se pudo registrar!");
				return $this->index($id_producto);
			}//end if no existe sexo seleccionado
			$tabla_productos = new \App\Models\Tabla_productos;
			$producto = array();
			$producto['nombre_producto'] = $this->request->getPost('nombre_producto');
			$producto['descripcion'] = $this->request->getPost('descripcion');
			$producto['cantidad'] = $this->request->getPost('cantidad');
			$opcion = $tabla_productos->existe_producto($producto['nombre_producto']);
			if($opcion == 2 || $opcion == -100){
				if($opcion == 2){
					mensaje("El producto proporcionado ya está registrado", WARNING_ALERT, "¡Ya registrado!");
				}//end if correo en uso
				if($opcion == -100){
					mensaje("El correo proporcionado se encuentra en el histórico de productos eliminados", WARNING_ALERT, "¡Producto en uso!");
				}//end if correo eliminado
				return $this->index($id_producto);
			}//end if existe el email
			else {
					if($tabla_productos->update($id_producto, $producto)){
					mensaje("El producto ha sido actualizado exitosamente", SUCCESS_ALERT, "¡Actualización exitosa!");
					return redirect()->to(route_to('detalles_producto', $id_producto));
				}//end if actualiza el usuario
				else{
					mensaje("Hubo un error al actualizar al usuario. Intente nuevamente, por favor", DANGER_ALERT, "¡Error al actualizar!");
					return redirect()->to(route_to('detalles_producto', $id_producto));
				}//end else actualiza el usuario
			}//end else existe email
		}//end if es un usuario permitido
		else{
			return $this->index();
		}//end else es un usuario permitido
	}//end editar*/

///End Class Usuario_detalles



class Producto_detalles extends BaseController {
    private $permitido = true;

    public function __construct() {
        $session = session();
        if (!isset($session->rol_actual['clave'])) {
            $this->permitido = false;
        }
    }
    public function index($id_producto = 0){
		$id_producto = intval($id_producto); // Convierte a entero

		if($this->permitido){
			$tabla_productos = new \App\Models\Tabla_productos;
			$producto = $tabla_productos->obtener_producto($id_producto);
			if($producto == NULL){
				mensaje('No se encuentra el producto proporcionado.', WARNING_ALERT, '¡Producto no encontrado!');
				return redirect()->to(route_to('administracion_productos'));
			}//end if no existe el producto
			else{
			return $this->crear_vista("panel/producto_detalles", $this->cargar_datos($producto));
			}//end else no existe
		}//end if producto permitido
		else{
			mensaje('No tienes permisos para acceder a esta sección.', DANGER_ALERT, '¡Acceso no autorizado!');
			return redirect()->to(route_to('login'));
		}//end else rol no permitido
	}//end index 

	private function cargar_datos($producto = NULL){
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
		$datos['nombre_pagina'] = 'Detalles usuario';
		//Cargar modelos
		$tabla_roles = new \App\Models\Tabla_roles;
		$datos['roles'] = $tabla_roles->obtener_roles($session->rol_actual['clave']);
		$datos['producto'] = $producto;

		//Breadcrumb
		$navegacion = array(
							array(
                          		'tarea' => 'Productos',
                          		'href' => route_to('administracion_productos'),
								'extra' => ''
                        	),
							array(
                          		'tarea' => 'Detalles producto',
                          		'href' => '#'
                        	)
                      );
    	$datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Detalles del producto:');

		return $datos;
	}//end cargar_datos

	private function crear_vista($nombre_vista, $contenido = array()){
		$contenido['menu'] = crear_menu_panel();
		return view($nombre_vista, $contenido);
	}//end crear_vista

	

    public function editar_producto() {
        if ($this->permitido) {
            $id_producto = $this->request->getPost('id_producto');

            if (!$id_producto) {
                mensaje("ID de producto no válido", DANGER_ALERT, "¡Error!");
                return redirect()->to(route_to('administracion_productos'));
            }

            $nombre_producto = $this->request->getPost('nombre_producto');
            if (!$nombre_producto) {
                mensaje("Debes poner un nombre", DANGER_ALERT, "¡No se pudo actualizar!");
                return $this->index($id_producto);
            }

            $descripcion = $this->request->getPost('descripcion');
            $cantidad = $this->request->getPost('cantidad');

            $tabla_productos = new \App\Models\Tabla_productos();

            // Verifica si el nombre ya existe en otro producto
            $existe = $tabla_productos->where('nombre_producto', $nombre_producto)
                                      ->where('id_producto !=', $id_producto)
                                      ->countAllResults();

            if ($existe > 0) {
                mensaje("El nombre de producto ya está en uso", WARNING_ALERT, "¡Ya registrado!");
                return $this->index($id_producto);
            }

            $producto = [
                'nombre_producto' => $nombre_producto,
                'descripcion' => $descripcion,
                'cantidad' => $cantidad,
            ];

            if ($tabla_productos->update($id_producto, $producto)) {
                mensaje("El producto ha sido actualizado exitosamente", SUCCESS_ALERT, "¡Actualización exitosa!");
                return redirect()->to(route_to('administracion_productos', $id_producto));
            } else {
                mensaje("Error al actualizar el producto. Intente nuevamente", DANGER_ALERT, "¡Error!");
                return redirect()->to(route_to('administracion_productos', $id_producto));
            }
        } else {
            mensaje("No tienes permisos para editar este producto", DANGER_ALERT, "¡Acceso denegado!");
            return redirect()->to(route_to('login'));
        }
    }
}

