<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <title>Daily | Cadastrar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="https://coderthemes.com/shreyu/assets/images/favicon.ico">

    <!-- Icons CSS -->
    <link href="https://coderthemes.com/shreyu/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <!-- App CSS -->
    <link href="https://coderthemes.com/shreyu/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <!-- Config js -->
    <script src="https://coderthemes.com/shreyu/assets/js/config.js"></script>
</head>

<body class="authentication-bg">
    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-6 p-4">
                                    <div class="mx-auto">
                                        <a href="index.html">
                                            <img src="https://coderthemes.com/shreyu/assets/images/logo-dark.png" alt="" height="24" />
                                        </a>
                                    </div>

                                    <!-- <h6 class="h5 mb-0 mt-3">Create your account</h6> -->
                                    <p class="text-muted mt-1 mb-4">Crie sua conta gratuitamente e comece a utilizar os melhores recurso de gestão de tarefas.</p>

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
                                        <?php unset($_SESSION['form_data']); ?>
                                    <?php endif; ?>

                                    <form action="registerNewAccount.php" method="post" id="formSignUp" name="formSignUp" class="authentication-form">
                                        <div class="mb-3">
                                            <label class="form-label">Nome</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="user"></i>
                                                </span>
                                                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : ''; ?>" placeholder="Digite seu nome">
                                            </div>
                                            <div id="nameError" class="text-danger mt-2" style="display: none; font-size: 0.875rem;"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">E-mail</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="mail"></i>
                                                </span>
                                                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>" placeholder="antoniosilva@gmail.com">
                                            </div>
                                            <div id="emailError" class="text-danger mt-2" style="display: none; font-size: 0.875rem;"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Senha</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="lock"></i>
                                                </span>
                                                <input type="password" class="form-control" id="password" name="password" value="" placeholder="Digite sua senha">
                                            </div>
                                            <div id="passwordError" class="text-danger mt-2" style="display: none; font-size: 0.875rem;"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Confirmar Senha</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="icon-dual" data-feather="lock"></i>
                                                </span>
                                                <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" value="" placeholder="Confirme sua senha">
                                            </div>
                                            <div id="passwordConfirmError" class="text-danger mt-2" style="display: none; font-size: 0.875rem;"></div>
                                        </div>

                                        <!-- <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkbox-signup" checked>
                                                <label class="form-check-label" for="checkbox-signup">
                                                    I accept <a href="javascript: void(0);">Terms and Conditions</a>
                                                </label>
                                            </div>
                                        </div> -->

                                        <div class="mb-3 text-center d-grid">
                                            <button class="btn btn-primary fw-semibold text-uppercase" type="submit">Cadastrar</button>
                                        </div>
                                    </form>
                                    
                                </div>
                                <div class="col-lg-6 d-none d-lg-inline-block">
                                    <div class="auth-page-sidebar">
                                        <div class="overlay"></div>
                                        <div class="auth-user-testimonial">
                                            <!-- <p class="fs-24 fw-bold text-white mb-1">I simply love it!</p>
                                            <p class="lead">"It's a elegent templete. I love it very much!"</p>
                                            <p>- Admin User</p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">Já possui uma conta? <a href="login.php" class="text-primary fw-bold">Entre</a></p>
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
    <script src="https://coderthemes.com/shreyu/assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="https://coderthemes.com/shreyu/assets/js/app.js"></script>
    
    <script>
        // Função de validação
        function validarFormulario() {
            // Limpar mensagens de erro anteriores
            document.getElementById('nameError').style.display = 'none';
            document.getElementById('nameError').textContent = '';
            document.getElementById('emailError').style.display = 'none';
            document.getElementById('emailError').textContent = '';
            document.getElementById('passwordError').style.display = 'none';
            document.getElementById('passwordError').textContent = '';
            document.getElementById('passwordConfirmError').style.display = 'none';
            document.getElementById('passwordConfirmError').textContent = '';
            
            // Obter valores dos campos
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const passwordConfirm = document.getElementById('passwordConfirm').value.trim();
            
            let isValid = true;
            
            // Validar nome
            if (name === '') {
                document.getElementById('nameError').textContent = 'O nome é obrigatório';
                document.getElementById('nameError').style.display = 'block';
                isValid = false;
            } else if (name.length < 3) {
                document.getElementById('nameError').textContent = 'O nome deve ter no mínimo 3 caracteres';
                document.getElementById('nameError').style.display = 'block';
                isValid = false;
            }
            
            // Validar e-mail
            if (email === '') {
                document.getElementById('emailError').textContent = 'O e-mail é obrigatório';
                document.getElementById('emailError').style.display = 'block';
                isValid = false;
            } else {
                // Validar formato de e-mail
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(email)) {
                    document.getElementById('emailError').textContent = 'E-mail inválido';
                    document.getElementById('emailError').style.display = 'block';
                    isValid = false;
                }
            }
            
            // Validar senha
            if (password === '') {
                document.getElementById('passwordError').textContent = 'A senha é obrigatória';
                document.getElementById('passwordError').style.display = 'block';
                isValid = false;
            } else if (password.length < 4) {
                document.getElementById('passwordError').textContent = 'A senha deve ter no mínimo 4 caracteres';
                document.getElementById('passwordError').style.display = 'block';
                isValid = false;
            }
            
            // Validar confirmação de senha
            if (passwordConfirm === '') {
                document.getElementById('passwordConfirmError').textContent = 'A confirmação de senha é obrigatória';
                document.getElementById('passwordConfirmError').style.display = 'block';
                isValid = false;
            } else if (password !== passwordConfirm) {
                document.getElementById('passwordConfirmError').textContent = 'As senhas não correspondem';
                document.getElementById('passwordConfirmError').style.display = 'block';
                isValid = false;
            }
            
            return isValid;
        }
        
        // Adicionar evento ao formulário
        document.getElementById('formSignUp').addEventListener('submit', function(event) {
            event.preventDefault(); // Impede o envio padrão do formulário
            
            // Validar formulário
            if (validarFormulario()) {
                this.submit(); // Envia o formulário manualmente
            }
        });
    </script>
</body>
</html>