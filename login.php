<?php 
    session_start();
    require_once 'src/Config.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>Daily | Entrar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo getUrlFull('assets/images/favicon.ico'); ?>">

    <!-- Icons CSS -->
    <link href="<?php echo getUrlFull('assets/css/icons.min.css'); ?>" rel="stylesheet" type="text/css" />

    <!-- App CSS -->
    <link href="<?php echo getUrlFull('assets/css/app.min.css'); ?>" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <!-- Config js -->
    <script src="<?php echo getUrlFull('assets/js/config.js'); ?>"></script>
</head>
<body class="authentication-bg">
    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col p-4">
                                    <div class="mx-auto">
                                        <a href="index.html">
                                            <img src="<?php echo getUrlFull('assets/images/logo-dark.png'); ?>" alt="" height="24" />
                                        </a>
                                    </div>

                                    <!-- <h6 class="h5 mb-0 mt-3">Welcome back!</h6> -->
                                    <p class="text-muted mt-1 mb-4">Sistema de gerenciamento de tarefas.</p>

                                    <!-- Exibir mensagens de sucesso e erro da sessão -->
                                    <?php if (isset($_SESSION['error']) && $_SESSION['error']['status'] === true): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Erro!</strong> <?php echo htmlspecialchars($_SESSION['error']['message']); ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <?php unset($_SESSION['error']); ?>
                                    <?php endif; ?>

                                    <?php if (isset($_SESSION['success']) && $_SESSION['success']['status'] === true): ?>
                                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                                            <strong>Sucesso!</strong> <?php echo htmlspecialchars($_SESSION['success']['message']); ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        <?php unset($_SESSION['success']); ?>
                                    <?php endif; ?>

                                    <form action="authenticate.php" method="post" id="formLogin" name="formLogin" class="authentication-form">
                                        <div class="mb-3">
                                            <label class="form-label">E-mail</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="mail"></i>
                                                </span>
                                                <input type="email" class="form-control" id="email" name="email" value="bruno@teste.com" placeholder="hello@coderthemes.com" />
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Senha</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="lock"></i>
                                                </span>
                                                <input type="password" class="form-control" id="password" name="password" value="1234" placeholder="Digite sua senha">
                                            </div>
                                            <div id="passwordError" class="text-danger mt-2" style="display: none; font-size: 0.875rem;"></div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                                <label class="form-check-label" for="checkbox-signin">Lembrar minha senha</label>
                                                <a href="<?php echo getUrlFull('pages-recoverpw.html'); ?>" class="float-end text-muted text-unline-dashed ms-1">Esqueceu sua senha?</a>
                                            </div>
                                        </div>

                                        <div class="mb-3 text-center d-grid">
                                            <button class="btn btn-primary fw-semibold text-uppercase" type="submit">Entrar</button>
                                        </div>
                                    </form>
                                    <!-- <div class="py-3 text-center"><span class="fs-16 fw-bold">OR</span></div>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <a href="" class="btn btn-white mb-2 mb-sm-0"><i class='uil uil-google icon-google me-2'></i>With Google</a>
                                            <a href="" class="btn btn-white mb-2 mb-sm-0"><i class='uil uil-facebook me-2 icon-fb'></i>With Facebook</a>
                                        </div>
                                    </div> -->
                                </div>
                                <!-- <div class="col-lg-6 d-none d-md-inline-block">
                                    <div class="auth-page-sidebar">
                                        <div class="overlay"></div>
                                        <div class="auth-user-testimonial">
                                            <p class="fs-24 fw-bold text-white mb-1">I simply love it!</p>
                                            <p class="lead">"It's a elegent templete. I love it very much!"</p>
                                            <p>- Admin User</p>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                            
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Não tenho um conta? <a href="signup.php" class="text-primary fw-semibold">Cadastre-se!</a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <!-- Vendor js -->
    <script src="<?php echo getUrlFull('assets/js/vendor.min.js'); ?>"></script>

    <!-- App js -->
    <script src="<?php echo getUrlFull('assets/js/app.js'); ?>"></script>

    <script>
        // Função de validação
        function validarFormulario() {
            // Limpar mensagens de erro anteriores
            document.getElementById('passwordError').style.display = 'none';
            document.getElementById('passwordError').textContent = '';
            
            // Obter valores dos campos
            const email    = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            
            let isValid = true;
            
            // Validar e-mail
            if (email === '') {
                document.getElementById('passwordError').textContent = 'Campo e-mail é obrigatório!';
                document.getElementById('passwordError').style.display = 'block';
                isValid = false;
            } else {
                // Validar formato de e-mail
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    document.getElementById('passwordError').textContent = 'E-mail inválido!';
                    document.getElementById('passwordError').style.display = 'block';
                    isValid = false;
                }
            }
            
            // Validar senha
            if (password === '') {
                document.getElementById('passwordError').textContent = 'A senha é obrigatório!';
                document.getElementById('passwordError').style.display = 'block';
                isValid = false;
            } else if (password.length < 4) {
                document.getElementById('passwordError').textContent = 'A senha deve ter no mínimo 4 caracteres.';
                document.getElementById('passwordError').style.display = 'block';
                isValid = false;
            }
            
            return isValid;
        }
        
        // Adicionar evento ao formulário
        document.getElementById('formLogin').addEventListener('submit', function(event) {
            event.preventDefault(); // Impede o envio padrão do formulário
            
            // Validar formulário
            if (validarFormulario()) {
                this.submit(); // Envia o formulário manualmente
            }
        });
    </script>
</body>
</html>