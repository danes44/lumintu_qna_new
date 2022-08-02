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
    </head>
    <body>
        <div class="container d-flex  my-auto min-vh-100" style="">
            <div class="card rounded-3 border-0 shadow-lg mx-auto align-self-center h-100" style="">
                <div class="d-flex">
                    <div class="flex-shrink-1">
                        <img src="../assets/loginThumbnail.svg" class=" rounded-start" style="object-fit: cover; min-height: 470px;">
                    </div>
                    <div class="w-100 align-self-center">
                        <div class="card-body rounded-3 mx-5 px-0 py-0 d-flex justify-content-between flex-column">
                            <img src="../assets/Logo QnA.svg" style="height: 50px;">
                            <h2 class="card-title fw-bold text-center pt-3 pb-3" >Admin Login</h2>
                            <form action="login.php" method="post" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label username ">Username</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput1" name="user" placeholder="Masukan Username" required/>
                                    <div class="invalid-feedback">Username harus terisi</div>
                                </div>
                                <div class="mb-5">
                                    <label for="exampleFormControlInput2" class="form-label email ">Password</label>
                                    <input type="password" class="form-control" id="exampleFormControlInput2" name="pass" placeholder="Masukan Password" required />
                                    <div class="invalid-feedback">Password harus terisi</div>
                                </div>
                                <div class="mb-3 mt-5 sticky-bottom ">
                                  <button id="btn-login" type="submit" class="btn text-white text-center" name="login" style="background-color: #FF6641; width:100%;">
                                      <b>Login </b>
                                  </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        // if ($("#"))
        // $("#btn-login")

        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
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
        })()
        </script>
    </body>
</html>