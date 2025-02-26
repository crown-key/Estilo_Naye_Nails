<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $titulo_pag ?></title>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="<?= base_url(RECURSOS_IMG . '/sin-fondo.png') ?>" type="image/x-icon">
    <link href="<?= base_url(RECURSOS_PANEL_PLUGINS . '/toastr/dist/build/toastr.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url(RECURSOS_PANEL_PLUGINS . '/toastr/dist/build/toastr_manager.css'); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url(RECURSOS_CSS . '/principal.css') ?>">
</head>

<body class="bg-primario">
    <div class="font-Outfit max-sm:px-4">
        <div class="min-h-screen flex flex-col items-center justify-center">
            <div class="bg-white grid md:grid-cols-2 items-center gap-4 max-md:gap-8 max-w-6xl max-md:max-w-lg w-full p-4 m-4 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] rounded-md">
                <div class="md:max-w-md w-full px-4 py-4">
                    <?= form_open('validar_usuario', ['id' => 'form-login', 'class' => 'form-horizontal mt-4 pt-4 needs-validation']) ?>

                    <div class="mb-4">
                        <a href="<?= route_to('usuario_login') ?>" class="text-letra text-lg font-semibold relative pb-1 after:absolute after:left-1/2 after:-bottom-0.5 after:w-0 after:h-[2px] after:bg-letra after:transition-all after:duration-300 hover:after:w-full hover:after:left-0">
                            &#8592; Volver al incio de sesión
                        </a>
                    </div>

                    <div class="mb-12">
                        <h3 class="text-letra text-3xl font-extrabold">Recuperar contraseña</h3>
                        <p class="text-lg mt-2 text-gray-800">Te enviaremos indicaciones</p>
                    </div>

                    <div class="form-floating mb-3">
                        <label for="tb-email" class="text-gray-800 text-lg block mb-2">Correo:</label>
                        <div class="relative flex items-center">
                            <?php
                            $parametros = [
                                'type' => 'email',
                                'class' => 'w-full text-gray-800 text-sm border-b border-gray-300 focus:border-hover pl-2 pr-8 py-3 outline-none',
                                'id' => 'tb-email',
                                'name' => 'email',
                                'placeholder' => 'Ingrese su correo',
                                'required' => ''
                            ];
                            echo form_input($parametros);
                            ?>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-[18px] h-[18px] absolute right-2" viewBox="0 0 682.667 682.667">
                                <defs>
                                    <clipPath id="a" clipPathUnits="userSpaceOnUse">
                                        <path d="M0 512h512V0H0Z" data-original="#000000"></path>
                                    </clipPath>
                                </defs>
                                <g clip-path="url(#a)" transform="matrix(1.33 0 0 -1.33 0 682.667)">
                                    <path fill="none" stroke-miterlimit="10" stroke-width="40" d="M452 444H60c-22.091 0-40-17.909-40-40v-39.446l212.127-157.782c14.17-10.54 33.576-10.54 47.746 0L492 364.554V404c0 22.091-17.909 40-40 40Z" data-original="#000000"></path>
                                    <path d="M472 274.9V107.999c0-11.027-8.972-20-20-20H60c-11.028 0-20 8.973-20 20V274.9L0 304.652V107.999c0-33.084 26.916-60 60-60h392c33.084 0 60 26.916 60 60v196.653Z" data-original="#000000"></path>
                                </g>
                            </svg>
                        </div>
                    </div>

                    <div class="form-floating mb-3">
                        
                        <div class="relative flex items-center">
                           
                            
                            
                        </div>
                    </div>

                    

                    <div class="form-group text-center mt-4 mb-3">
                        <button class="w-full shadow-xl py-2.5 px-4 text-lg tracking-wide rounded-md text-white bg-letra hover:bg-hover focus:outline-none" type="submit">
                            Enviar
                        </button>
                        <br>
                    </div>

                    <?= form_close() ?>

                </div>

                <div class="w-full h-full flex items-center bg-letra rounded-xl p-8">
                    <img src="<?= base_url(RECURSOS_IMG . '/login-2.png'); ?>" class="w-full aspect-[12/12] border-4 border-white rounded-lg object-contain" alt="login-image" />
                </div>
            </div>
        </div>
    </div>

    <script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/jquery/dist/jquery.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/bootstrap/dist/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url(RECURSOS_PANEL_PLUGINS . '/toastr/dist/build/toastr.min.js'); ?>"></script>
    <script src="<?= base_url(RECURSOS_PANEL_JS . "/specifics/login.js") ?>"></script>
    <script src="<?= base_url(RECURSOS_JS . '/usuarios/login.js') ?>"></script>

    <?= mostrar_mensaje(); ?>
</body>

</html>