<?php
namespace App\Controllers\Panel;
use App\Controllers\BaseController;
use App\Libraries\Permisos;

class Producto_detalles extends BaseController{
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
				mensaje('No se encuentra el producto propocionado.', WARNING_ALERT, '¡Producto no encontrado!');
				return redirect()->to(route_to('administracion_productos'));
			}//end if no existe el usuario
			else{
				$session = session();
				if($session->rol_actual['clave'] != ROL_SUPERADMIN['clave'] && $producto->id_rol == ROL_SUPERADMIN['clave'] ||
				  ($producto->id_producto == $session->id_producto || $session->rol_actual['clave'] == $producto->id_rol)){
					mensaje('No se tienen permisos para acceder a este registro.', WARNING_ALERT, '¡Acceso no autorizado!');
					return redirect()->to(route_to('administracion_productos'));
				}//end if es un usuario que quiere editar su propio user O si es un usuario distinto del superadmin O si es un usuario cuyo rol es igual al del rol que quiere editar
				else{
					return $this->crear_vista("panel/producto_detalles", $this->cargar_datos($producto));
				}//end else
			}//end else no existe el usuario
		}//end if rol permitido
		else{
			mensaje('No tienes permisos para acceder a esta sección.', DANGER_ALERT, '¡Acceso no autorizado!');
			return redirect()->to(route_to('login'));
		}//end else rol no permitido
	}//end index

	private function cargar_datos($usuario = NULL){
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
		$datos['nombre_pagina'] = 'Detalles producto';
		//Cargar modelos
		$tabla_productos= new \App\Models\Tabla_productos;
		$datos['producto'] = $tabla_productos->obtener_producto($session->rol_actual['clave']);
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
    	$datos['breadcrumb'] = breadcrumb_panel($navegacion, 'Detalles del producto: <b>'. $producto->nombre_producto.' ');

		return $datos;
	}//end cargar_datos

	private function crear_vista($nombre_vista, $contenido = array()){
		$contenido['menu'] = crear_menu_panel();
		return view($nombre_vista, $contenido);
	}//end crear_vista

	public function editar_producto() {
        if ($this->permitido) {
            $id_producto = $this->request->getPost('id_producto');
    
            // Validación: El nombre del producto es obligatorio
            if ($this->request->getPost('nombre_producto') == NULL) {
                mensaje("Debes poner un nombre", DANGER_ALERT, "¡No se pudo actualizar!");
                return $this->index($id_producto);
            }
    
            // Obtener instancia del modelo
            $tabla_productos = new \App\Models\Tabla_productos;
    
            // Crear array con los datos a actualizar
            $producto = [
                'nombre_producto' => $this->request->getPost('nombre_producto'),
                'descripcion' => $this->request->getPost('descripcion'),
                'cantidad' => $this->request->getPost('cantidad')
            ];
    
            // Actualizar producto en la base de datos
            if ($tabla_productos->update($id_producto, $producto)) {
                mensaje("El producto ha sido actualizado exitosamente", SUCCESS_ALERT, "¡Actualización exitosa!");
                return redirect()->to(route_to('detalles_producto', $id_producto));
            } else {
                mensaje("Hubo un error al actualizar el producto. Intente nuevamente, por favor", DANGER_ALERT, "¡Error al actualizar!");
                return redirect()->to(route_to('detalles_producto', $id_producto));
            }
        } else {
            mensaje('No tienes permisos para editar este producto.', DANGER_ALERT, '¡Acceso no autorizado!');
            return redirect()->to(route_to('login'));
        }
    }
    
	/*public function editar_producto(){
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
			$producto['cantidad'] = $this->request->getPost('');
			
			if($this->request->getPost('confirm_password') != ''){
				$usuario['password_usuario'] = hash('sha256', $this->request->getPost('confirm_password'));
			}//end if cambia password
			$opcion = $tabla_usuarios->existe_email_excepto_actual($usuario['email_usuario'], $id_usuario);
			if($opcion == 2 || $opcion == -100){
				if($opcion == 2){
					mensaje("El correo proporcionado ya está siendo usado por otro usuario", WARNING_ALERT, "¡Correo en uso!");
				}//end if correo en uso
				if($opcion == -100){
					mensaje("El correo proporcionado se encuentra en el histórico de correos eliminados", WARNING_ALERT, "¡Correo en uso!");
				}//end if correo eliminado
				return $this->index($id_usuario);
			}//end if existe el email
			else{
				if(!empty($this->request->getFile('imagen_perfil')) && $this->request->getFile('imagen_perfil')->getSize() > 0){
					helper('upload_files');
					$archivo = $this->request->getFile('imagen_perfil');

					$usuario_in_db = $tabla_usuarios->select('imagen_usuario')->find($id_usuario);
					if($usuario_in_db->imagen_usuario != NULL){
						erase_file($usuario_in_db->imagen_usuario, IMG_DIR_USUARIOS);
					}//end if se debe eliminar imagen

					$usuario['imagen_usuario'] = upload_image($archivo, '', IMG_DIR_USUARIOS, 512, 512, 2097152);
				}//end if existe imagen
				if($tabla_usuarios->update($id_usuario, $usuario)){
					$pass = '';
					
					if ($this->request->getPost('confirm_password') != '') {
						$pass = $this->request->getPost('confirm_password');
					}//end 

					$this->enviar_editar_usuario($usuario['email_usuario'], $usuario, $pass);
					mensaje("El usuario ha sido actualizado exitosamente", SUCCESS_ALERT, "¡Actualización exitosa!");
					return redirect()->to(route_to('detalles_usuario', $id_usuario));
				}//end if actualiza el usuario
				else{
					mensaje("Hubo un error al actualizar al usuario. Intente nuevamente, por favor", DANGER_ALERT, "¡Error al actualizar!");
					return redirect()->to(route_to('detalles_usuario', $id_usuario));
				}//end else actualiza el usuario
			}//end else existe email
		}//end if es un usuario permitido
		else{
			return $this->index();
		}//end else es un usuario permitido
	}//end editar*/

}//End Class Usuario_detalles
