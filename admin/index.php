<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login Admin</title>
        <!-- Bootstrap CSS -->
<!--        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous" />-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    </head>
    <body>
<!--        <div class="e" style="">-->
            <div class="card rounded-3 border-0 shadow-lg position-absolute top-50 start-50 translate-middle" style="width: max-content">
                <div class="d-flex">
                    <div class="flex-shrink-1">
                        <img src="../assets/loginThumbnail.svg" class=" rounded-start" style="object-fit: cover; min-height: 600px;">
                    </div>
                    <div class="align-self-center">
                        <!-- Login -->
                        <div id="form-login" class="card-body rounded-3 mx-5 px-0 py-0 d-flex justify-content-between flex-column" >
                            <img src="../assets/Logo QnA.svg" style="height: 50px;">
                            <h2 class="card-title fw-bold text-center pt-3 pb-3" >Admin Login</h2>
                            <form action="login.php" method="post" class="needs-validation" novalidate>
                                <div class="mb-3 position-relative">
                                    <label for="exampleFormControlInput1" class="form-label username ">Username</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" name="user" placeholder="Masukan Username" required/>
                                    <div class="invalid-tooltip end-0">Username harus terisi</div>
                                </div>
                                <div class="mb-5 position-relative">
                                    <label for="exampleFormControlInput2" class="form-label email ">Password</label>
                                    <input type="password" class="form-control" id="exampleFormControlInput2" name="pass" placeholder="Masukan Password" required />
                                    <div class="invalid-tooltip end-0">Password harus terisi</div>
                                </div>
                                <div class="mb-3 mt-5 ">
                                    <button id="btn-login" type="submit" class="btn text-white text-center" name="login" style="background-color: #FF6641; width:100%;">
                                        <b>Login </b>
                                    </button>
                                    <p class="small mb-0 mt-1">Belum punya akun? <a id="btn-buat-akun" href="#" class="text-primary text-decoration-none">Buat akun</a></p>
                                </div>
                            </form>
                        </div>
                        <!-- Register -->
                        <div id="form-register" class="card-body rounded-3 mx-5 px-0 py-0 d-flex justify-content-between flex-column d-none">
                            <img src="../assets/Logo QnA.svg" style="height: 50px;">
                            <h2 class="card-title fw-bold text-center pt-3 pb-3" >Admin Register</h2>
                            <form method="post" class="needs-validation" novalidate>
                                <div class="mb-3 position-relative">
                                    <label for="input-username" class="form-label username ">Username</label>
                                    <input type="text" class="form-control" id="input-username" name="user" placeholder="johndoe123" required/>
                                    <div class="invalid-tooltip end-0">Username harus terisi</div>
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="input-email" class="form-label username ">Email</label>
                                    <input type="email" class="form-control" id="input-email" name="email" placeholder="john.doe@gmail.com" required/>
                                    <div id="tooltip-email" class="invalid-tooltip end-0">Email harus terisi</div>
                                    <div id="tooltip-email2" class="invalid-tooltip end-0" style="display: none">Email harus mengandung @ dan domain (cth: example@domain.com)</div>
                                </div>
                                <div class="mb-5 position-relative">
                                    <label for="input-password" class="form-label email ">Password</label>
                                    <input type="password" class="form-control" id="input-password" name="pass" placeholder="*********" required />
                                    <div class="invalid-tooltip end-0">Password harus terisi</div>
                                </div>
                                <div class="mb-3 mt-5 ">
                                    <button id="btn-register" type="submit" class="btn text-white text-center" name="register" style="background-color: #FF6641; width:100%;" disabled>
                                        <b>Register</b>
                                    </button>
                                    <p class="small mb-0 mt-1">Sudah punya akun? <a id="btn-masuk-akun" href="#" class="text-primary text-decoration-none">Masuk akun</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
<!--        </div>-->

        <script>
        // if ($("#"))
        $("body").on("click", '#btn-buat-akun', function() {
            $('#form-login').addClass('d-none')
            $('#form-register').removeClass('d-none')


        })

        $("body").on("click", '#btn-masuk-akun', function() {
            $('#form-login').removeClass('d-none')
            $('#form-register').addClass('d-none')
        })

        $("#input-username").on('keyup', function(e) {
            if($('#input-username').val()!='' && $('#input-email').val()!='' && $('#input-password').val()!=''){
                $('#btn-register').removeAttr('disabled')
            }
        });
        $("#input-email").on('keyup', function(e) {
            if($('#input-username').val()!='' && $('#input-email').val()!='' && $('#input-password').val()!=''){
                $('#btn-register').removeAttr('disabled')
            }
        });
        $("#input-password").on('keyup', function(e) {
            if($('#input-username').val()!='' && $('#input-email').val()!='' && $('#input-password').val()!=''){

                let regexEmail = /^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;

                if(regexEmail.test($('#input-email').val())) {
                    $('#tooltip-email2').hide()
                    $('#btn-register').removeAttr('disabled')
                }
                else{
                    $('#tooltip-email2').show()
                    $('#input-email').addClass('is-invalid')
                    $('#tooltip-email').hide()
                }
            }
        });


        // Example starter JavaScript for disabling form submissions if there are invalid fields
        $(function () {
          'use strict'
          // Fetch all the forms we want to apply custom Bootstrap validation styles to
          var forms = document.querySelectorAll('.needs-validation')
          // Loop over them and prevent submission
          Array.prototype.slice.call(forms)
            .forEach(function (form) {
              form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                  event.preventDefault()
                  event.stopPropagation()
                }
                form.classList.add('was-validated')
              }, false)
            })
        })
        </script>
    </body>
</html>