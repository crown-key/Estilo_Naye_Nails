<?php namespace App\Controllers\Panel;
use App\Controllers\BaseController;
use App\Libraries\Permisos;

class Producto_nuevo extends BaseController{
	private $permitido = true;

	public function __construct(){
		$session = session();
		if(!Permisos::is_rol_permitido(TAREA_PRODUCTO_NUEVO, isset($session->rol_actual['clave']) ? $session->rol_actual['clave'] : -1)) {
			$this->permitido = false;
		}//end if rol no permitido
		else{
			$session->tarea_actual = TAREA_PRODUCTO_NUEVO;
		}//end else rol permitido
	}//end constructor

	public function index(){
		if($this->permitido){
			return $this->crear_vista("panel/producto_nuevo", $this->cargar_datos());
		}//end if rol permitido
		else{
			mensaje('No tienes permisos para acceder a esta sección.', DANGER_ALERT, '¡Acceso no autorizado!');
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
		$datos['nombre_pagina'] = 'Nuevo producto';
		//Cargar modelos
		$tabla_producto = new \App\Models\Tabla_productos;
		$datos['producto'] = $tabla_producto->obtener_producto($session->rol_actual['clave']);

		//Breadcrumb
		$navegacion = array(
							array(
                          		'tarea' => 'Producto',
                          		'href' => route_to('administracion_productos'),
								'extra' => ''
                        	),
							array(
                          		'tarea' => 'Nuevo producto',
                          		'href' => '#'
                        	)
                      );
    	$datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Nuevo producto');

		return $datos;
	}//end cargar_datos

	

	private function crear_vista($nombre_vista, $contenido = array()){
		$contenido['menu'] = crear_menu_panel();
		return view($nombre_vista, $contenido);
	}//end crear_vista

	public function registrar_producto(){
		if($this->permitido){
			if($this->request->getPost('nombre_producto') == NULL){
				mensaje("Debe ingresar el nombre del producto", WARNING_ALERT, "¡No se pudo registrar!");
				return $this->index();
			}//end if no existe sexo seleccionado
			$tabla_producto = new \App\Models\Tabla_productos;
			$producto = array();
			$producto['nombre_producto'] = $this->request->getPost('nombre_producto');
			$producto['descripcion'] = $this->request->getPost('descripcion');
			$producto['estatus_producto'] = ESTATUS_HABILITADO;
			$producto['cantidad'] = $this->request->getPost('cantidad');
			
			$producto['id_rol'] = $this->request->getPost('rol');
		    $opcion = $tabla_producto->existe_producto($producto ['nombre_producto']);
			if($opcion == 2 || $opcion == -100){
				if($opcion == 2){
					mensaje("El producto proporcionado ya está registrado.", WARNING_ALERT, "¡Registrado!");
				}//end if correo en uso
				if($opcion == -100){
					mensaje("El producto proporcionado se encuentra en el historial de eliminados.", WARNING_ALERT, "¡Producto eliminado!");
				}//end if correo eliminado
				return $this->index();
			}//end if existe el email
			else{
				/*if(!empty($this->request->getFile('imagen_perfil')) && $this->request->getFile('imagen_perfil')->getSize() > 0){
					helper('upload_files');
					$archivo = $this->request->getFile('imagen_perfil');
					$usuario['imagen_usuario'] = upload_image($archivo, '', IMG_DIR_USUARIOS, 512, 512, 2097152);
				}//end if existe imagen*/
				if($tabla_producto->insert($producto) > 0){
					//$this->enviar_registro_usuario($usuario['email_usuario'], $usuario, $this->request->getPost('confirm_password'));
					mensaje("El usuario ha sido registrado exitosamente.", SUCCESS_ALERT, "¡Registro exitoso!");
					return redirect()->to(route_to('administracion_productos'));
				}//end if inserta el usuario
				else{
					mensaje("Hubo un error al registrar el producto. Intente nuevamente, por favor", DANGER_ALERT, "¡Error al registrar!");
					return $this->index();
				}//end else inserta el usuario
			}//end else existe email
		}//end if es un usuario permitido
		else{
			return $this->index();
		}//end else es un usuario permitido
	}//end registrar

}//End Class Usuario_nuevo
