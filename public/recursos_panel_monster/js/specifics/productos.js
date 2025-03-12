// DATATABLE
// =================================================================
let basic_table = instantiateBasicDatatable();


// BOTONES OPCIONES
// =================================================================

$(document).on('click', '.eliminar-producto', function() {
    let url = './administracion_productos';
    eliminar("./eliminar_producto", $(this).attr('id'), '¿Estás seguro de eliminar este producto?', 'Esta acción es permanente', url);
});//end onclick eliminar



$(document).on('click', '.recover-producto', function() {
    let titulo = '¿Deseas recuperar a este producto?';
    let texto = 'Al recuperar este producto volverá a estar disponible en la base de datos del sistema y podrá ser visualizado en el panel. ¿Estás seguro de restaurar este producto?';
    let texto_confirmar = 'Sí, restaurar el producto';
    let texto_cancelar = 'Cancelar';
    let opciones_form = ['./recuperar_producto', 'POST'];
	let data = new FormData();
	data.append('id', $(this).attr('id').split('_')[1]);
    mensaje_confirmacion_texto_propio(titulo, texto, texto_confirmar, texto_cancelar, opciones_form, data);
});//end onclick recover-user




