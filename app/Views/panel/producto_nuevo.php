<?= $this->extend("plantilla/panel_base") ?>

<?= $this->section("css") ?>
    <!-- SweetAlert 2 -->
    <link rel="stylesheet" href="<?= base_url(RECURSOS_PANEL_PLUGINS."/sweetalert2/dist/sweetalert2.min.css") ?>">
<?= $this->endSection(); ?>

<?= $this->section("contenido") ?>

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Registrar nuevo producto</h4>
                <h5 class="card-subtitle mb-3 pb-3 border-bottom">Todos los campos marcados con (<font color="red">*</font>) son obligatorios</h5>
                
                <?php
                    $parametros = array('id' => 'formulario-producto-nuevo');
                    echo form_open_multipart('editar_producto', $parametros);
                ?>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Nombre del producto: (<font color="red">*</font>)</label>
                            <div class="form-floating mb-3">
                                <?php
                                    $parametros = array('class' => 'form-control',
                                                        'id' => 'nombre_producto',
                                                        'name' => 'nombre_producto',
                                                        'placeholder' => 'Nombre producto',
                                                        'value' => ''
                                                        );
                                    echo form_input($parametros);
                                ?>
                                <div class="invalid-feedback"></div>
                                <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Nombre</label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Descripcion: (<font color="red">*</font>)</label>
                            <div class="form-floating mb-3">
                                <?php
                                    $parametros = array('class' => 'form-control',
                                                        'id' => 'descripcion',
                                                        'name' => 'descripcion',
                                                        'placeholder' => 'Descripcion',
                                                        'value' => ''
                                                        );
                                    echo form_input($parametros);
                                ?>
                                <div class="invalid-feedback"></div>
                                <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Descripcion</label>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-control-label">Cantidad: (<font color="red">*</font>)</label>
                            <div class="form-floating mb-3">
                                <?php
                                    $parametros = array('class' => 'form-control',
                                                        'id' => 'cantidad',
                                                        'name' => 'cantidad',
                                                        'placeholder' => 'Cantidad',
                                                        'value' => ''
                                                        );
                                    echo form_input($parametros);
                                ?>
                                <div class="invalid-feedback"></div>
                                <label><i data-feather="user" class="feather-sm text-dark fill-white me-2"></i>Cantidad</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            
                            </div>
                        </div>

                    
                        <div class="col-md-4 mb-3">
                            
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-3 mb-3">
                           
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            
                            </div>
                        </div>
                        <div class="col-md-1 mb-3"></div>
                        <div class="col-md-5 mb-3">
                            
                        </div>
                    </div>

                    <div class="text-center">
                        <a type="button" href="<?= route_to('productos') ?>" class="btn btn-danger"><i class="fa fa-times"></i> Cancelar</a>
                        &nbsp;&nbsp;&nbsp;
                        <button class="btn btn-primary" type="submit" id="btn-guardar"><i class="fa fa-lg fa-save"></i> Registrar producto</button>
                    </div>
                <?= form_close() ?>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section("js") ?>
    <!-- Preview Image -->
    <script src="<?php echo base_url(RECURSOS_PANEL_JS."/owns/preview-image.js") ?>"></script>

    <!-- SweetAlert 2 -->
    <script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS."/sweetalert2/dist/sweetalert2.all.min.js") ?>"></script>
    <script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS."/sweetalert2/dist/manager-sweetalert2.js") ?>"></script>

    <!-- jquery-validation Js -->
    <script src="<?php echo base_url(RECURSOS_PANEL_PLUGINS."/jquery-validation/dist/jquery.validate.min.js") ?>"></script>

    <!-- Message Notification -->
    <script src="<?php echo base_url(RECURSOS_PANEL_JS."/owns/message-notification.js") ?>"></script>

    <!-- JS específico -->
    <script src="<?php echo base_url(RECURSOS_PANEL_JS."/specifics/usuario_nuevo.js") ?>"></script>
<?= $this->endSection(); ?>
