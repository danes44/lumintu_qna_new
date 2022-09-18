<?php
    // panggil fungsi enkripsi
    include("crypt.php");

    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    $sesi_id = '';
    if (empty($uri_path)){
        $uri_path = '';
    }
    else{
        $hasilHash = mycrypt("decrypt", $uri_path);
        $arrayHasil = explode("&", $hasilHash);
        $arr_sesi_id = explode("=",$arrayHasil[0]);
        $sesi_id = $arr_sesi_id[1];
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Masuk Event</title>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

        <!-- Custom styles for this template -->
        <link href="./css-js/styleLoginUser.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">

        <!-- Script API-->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>

        <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
    </head>
    <body style="background-image: url('./assets/background-daftar.png'); height: 100%; background-size: cover; background-position: center;">
        <div class="container min-vh-100 position-relative" style="">
            <!-- isi unique code-->
            <div id="container-unique-code" class="card position-absolute top-50 start-50 translate-middle rounded-3 border-0 shadow-lg " style="width: 350px;">
                <div class="card-body rounded-3 mx-5 px-0 pb-4 py-5">
                    <div class="d-flex align-items-center justify-content-center">
                        <h2 class="card-title fw-bold text-center pb-3 mb-0" >Masuk Event</h2>
                    </div>

                    <form id="form-unique-code" action="" method="post" class="needs-validation" novalidate>
                        <div class="mt-3 position-relative">
                            <label for="input-kode-sesi" class="form-label kode-sesi ">Kode Sesi</label>
                            <div class="position-relative">
                                <span class="position-absolute top-50 start-0 translate-middle-y ms-3" id="hashtag">#</span>
                                <input type="text" class="form-control text-uppercase" id="input-kode-sesi" name="input-kode-sesi" placeholder="c3o23s" maxlength="6" required style="padding-left: 2.2rem"/>
                            </div>
                            <div class="invalid-tooltip end-0">Kode sesi tidak valid</div>
                        </div>
                        <div class="mt-5 mb-3">
                            <button id="btn-masuk-event" type="submit" class="btn rounded-3 text-white text-center" name="login" style="background-color: #FF6641; width:100%;">
                                <b>Masuk</b>
                            </button>
                            <button id="timer-masuk" class="btn rounded-3 text-white text-center" disabled title="Harap menunggu"  style="background-color: #FF6641; width:100%;display: none">
                                <div  class=" spinner-border spinner-border-sm border-3 small" ></div>
                                <span class="fw-normal small ms-2"> Tunggu...</span>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
            <!-- isi profil-->
            <div id="container-profil" class="card position-absolute top-50 start-50 translate-middle rounded-3 border-0 shadow-lg d-none" style="width: 350px;">
                <div class="card-body rounded-3 mx-5 px-0 pb-4 py-5">
                    <div class="d-flex align-items-center justify-content-center position-relative">
                        <button id="btn-kembali" class="position-absolute start-0 fw-bold text-decoration-none text-black border-0 rounded my-0 p-0 bg-transparent" role="button" title="Kembali">
                            <i class="bi bi-arrow-left me-1"></i>
                        </button>
                        <h2 class="flex-fill card-title fw-bold text-center mb-0 ms-3" >Profil</h2>
                    </div>

                    <form id="form-login" action="" method="post" class="needs-validation" novalidate>
                        <div class="mt-3 position-relative">
                            <label for="input-nama" class="form-label nama ">Nama</label>
                            <input type="text" class="form-control" id="input-nama" name="input-nama" placeholder="John Doe" required/>
                            <div class="invalid-tooltip end-0">Nama tidak valid</div>
                        </div>
                        <div class="mt-3 position-relative">
                            <label for="input-email" class="form-label email ">Email</label>
                            <input type="email" class="form-control" id="input-email" name="input-email" placeholder="john@example.com" required/>
                            <div class="invalid-tooltip end-0">Email tidak valid</div>
                        </div>
                        <div class="mt-5 mb-3">
                            <button id="btn-login" type="submit" class="btn text-white text-center" name="login" style="background-color: #FF6641; width:100%;">
                              <b>Simpan</b>
                            </button>
                            <button id="timer-login" class="btn rounded-3 text-white text-center" disabled title="Harap menunggu"  style="background-color: #FF6641; width:100%;display: none">
                                <div  class=" spinner-border spinner-border-sm border-3 small" ></div>
                                <span class="fw-normal small ms-2"> Tunggu...</span>
                            </button>

                            <p class="mb-0 mt-1 small">Atau lanjutkan <a id="btn-anonim" href="#" class="text-decoration-none fw-bold">sebagai anonim</a></p>
                        </div>
                    </form>

                </div>
            </div>

        </div>

        <!-- Toast -->
        <div id="container-toast" class="toast-container bottom-0 end-0 p-3">
            <!--toast berhasil login-->
            <div id="toast-success-login" class="toast align-items-center text-success border-1 border-success" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e8f3ee">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-3"></i>
                        Berhasil masuk ke sesi Q&A.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast berhasil sesi-->
            <div id="toast-success" class="toast align-items-center text-success border-1 border-success" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e8f3ee">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-3"></i>
                        Berhasil menemukan ke sesi.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast gagal tidak ditemukan sesi-->
            <div id="toast-failed" class="toast align-items-center text-danger border-1 border-danger" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #fbeaec">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-circle me-3"></i>
                        Sesi tidak ditemukan.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <?php
        echo "<input type='hidden' name='login_id_sesi' id='login_id_sesi' value='".$sesi_id."'/>";
            echo "<input type='hidden' name='uri_path' id='uri_path' value='".$uri_path."'/>";
        ?>

        <script>
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

        <!-- buttons function-->
        <script>
            let uri_path = $('#uri_path').val()
            let id_sesi = $('#login_id_sesi').val()
            if(uri_path !== ''){
                $.ajax({
                    url: './get_events_by_id.php',
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    data:{
                        id_sesi : id_sesi,
                    },
                    success: function (data, textStatus, xhr) {
                        console.log(data)
                        if(data.statusCode == 200) {
                            kode_sesi = data.data.unique_code
                            console.log(kode_sesi)
                            $('#input-kode-sesi').val(kode_sesi)
                        }
                        else if(data.statusCode == 201){
                            console.log(data)
                        }
                    },
                    error: function (textStatus, xhr, errorThrown) {
                        console.log(xhr)
                    },
                })
            }

            $("body").on("click", '#btn-kembali', function() {
                $("#container-unique-code").removeClass('d-none');
                $("#container-profil").addClass('d-none');
            })

            // button submit event
            $("form#form-unique-code").on('submit', function (e) {
                e.preventDefault();

                let actionUrl = './get_events_by_code.php';
                let unique_code= $('#input-kode-sesi').val();
                console.log(unique_code)

                $.ajax({
                    url: './get_events_by_code.php',
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    data: {
                        unique_code: unique_code,
                    },
                    success: function (data, textStatus, xhr) {
                        console.log(data)
                        if(data.statusCode == 200) {
                            id_sesi = data.data.id_event
                            console.log(id_sesi)

                            $("#timer-masuk").show();
                            $("#btn-masuk-event").hide();
                            setTimeout(function () {
                                $("#timer-masuk").hide();
                                $("#btn-masuk-event").show();

                                $("#container-unique-code").addClass('d-none');
                                $("#container-profil").removeClass('d-none');
                            }, 2000)
                            setTimeout(function () {
                                $('#toast-success').show()
                            }, 2500)
                            setTimeout(function () {
                                $('#toast-success').hide()
                                // window.location.reload();
                            }, 4500)
                        }
                        else if(data.statusCode == 201){
                            $("#timer-masuk").show();
                            $("#btn-masuk-event").hide();
                            setTimeout(function () {
                                $("#timer-masuk").hide();
                                $("#btn-masuk-event").show();
                            }, 2000)
                            setTimeout(function () {
                                $('#toast-failed').show()
                            }, 2500)
                            setTimeout(function () {
                                $('#toast-failed').hide()
                                // window.location.reload();
                            }, 4500)
                        }
                    },
                    error: function (textStatus, xhr, errorThrown) {
                        console.log(xhr)
                        $("#timer-masuk").show();
                        $("#btn-masuk-event").hide();
                        setTimeout(function () {
                            $("#timer-masuk").hide();
                            $("#btn-masuk-event").show();
                        }, 2000)
                        setTimeout(function () {
                            $('#toast-failed').show()
                        }, 2500)
                        setTimeout(function () {
                            $('#toast-failed').hide()
                            // window.location.reload();
                        }, 4500)
                    },
                })
                return false;
            })

            // button submit event
            $("form#form-login").on('submit', function (e) {
                e.preventDefault();

                let actionUrl = './login_user.php';
                let unique_code= $('#input-kode-sesi').val();
                console.log(unique_code)

                $.ajax({
                    url: actionUrl,
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    data: {
                        id_sesi: id_sesi,
                        input_nama: $('#input-nama').val(),
                        input_email: $('#input-email').val()
                    },
                    success: function (data, textStatus, xhr) {
                        console.log(data)
                        if(data.statusCode == 200) {
                            $("#timer-login").show();
                            $("#btn-login").hide();
                            setTimeout(function () {
                                $("#timer-login").hide();
                                $("#btn-login").show();
                            }, 2000)
                            setTimeout(function () {
                                $('#toast-success-login').show()
                            }, 2500)
                            setTimeout(function () {
                                $('#toast-success-login').hide()
                                // window.location.reload();
                                let location = 'user_chatroom.php?'+data.hasilHash
                                document.location.href=location
                            }, 4500)
                        }
                        else if(data.statusCode == 201){
                            $("#timer-login").show();
                            $("#btn-login").hide();
                            setTimeout(function () {
                                $("#timer-login").hide();
                                $("#btn-login").show();
                            }, 2000)
                            setTimeout(function () {
                                $('#toast-failed').show()
                            }, 2500)
                            setTimeout(function () {
                                $('#toast-failed').hide()
                                // window.location.reload();
                            }, 4500)
                        }
                    },
                    error: function (textStatus, xhr, errorThrown) {
                        console.log(errorThrown)

                        $("#timer-login").show();
                        $("#btn-login").hide();
                        setTimeout(function () {
                            $("#timer-login").hide();
                            $("#btn-login").show();
                        }, 2000)
                        setTimeout(function () {
                            $('#toast-failed').show()
                        }, 2500)
                        setTimeout(function () {
                            $('#toast-failed').hide()
                            // window.location.reload();
                        }, 4500)
                    },
                })
            })

            // button anonim
            $("body").on("click", '#btn-anonim', function(e) {
                $.ajax({
                    url: './login_user.php',
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    data: {
                        id_sesi: id_sesi,
                        input_nama: 'Anonim',
                        input_email: 'Anonim'
                    },
                    success: function (data, textStatus, xhr) {
                        console.log(data)
                        if(data.statusCode == 200) {
                            // $("#timer-login").show();
                            // $("#btn-login").hide();
                            // setTimeout(function () {
                            //     $("#timer-login").hide();
                            //     $("#btn-login").show();
                            // }, 2000)
                            // setTimeout(function () {
                            //     $('#toast-success-login').show()
                            // }, 2500)
                            // setTimeout(function () {
                            //     $('#toast-success-login').hide()
                            //     // window.location.reload();
                                let location = 'user_chatroom.php?'+data.hasilHash
                                document.location.href=location
                            // }, 4500)
                        }
                        else if(data.statusCode == 201){
                            // $("#timer-login").show();
                            // $("#btn-login").hide();
                            // setTimeout(function () {
                            //     $("#timer-login").hide();
                            //     $("#btn-login").show();
                            // }, 2000)
                            // setTimeout(function () {
                                $('#toast-failed').show()
                            // }, 2500)
                            setTimeout(function () {
                                $('#toast-failed').hide()
                                // window.location.reload();
                            }, 4500)
                        }
                    },
                    error: function (textStatus, xhr, errorThrown) {
                        console.log(errorThrown)

                        // $("#timer-login").show();
                        // $("#btn-login").hide();
                        // setTimeout(function () {
                        //     $("#timer-login").hide();
                        //     $("#btn-login").show();
                        // }, 2000)
                        // setTimeout(function () {
                            $('#toast-failed').show()
                        // }, 2500)
                        setTimeout(function () {
                            $('#toast-failed').hide()
                            // window.location.reload();
                        }, 4500)
                    },
                })
            })
        </script>
    </body>
</html>