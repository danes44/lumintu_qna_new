<?php
    session_start();

    if (!isset($_SESSION['is_login'])) {
        echo "<script>document.location.href='index.php';</script>";
        die();
    }

//    var_dump($_SESSION);
//    $bytes = random_bytes(3);
//    var_dump(bin2hex($bytes));
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Dashboard Admin</title>

        <script src="../api.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- moment Js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment-with-locales.min.js"></script>
        <!-- bootstrap js-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
        <!-- bootstrap css-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">

        <!-- Custom styles for this template -->
        <link href="../style.css" rel="stylesheet">
    </head>

    <body>
        <!--<div class="container"></div>-->
        <div class="container " style="height: auto;width: auto;margin-bottom: 30px;margin-top: 30px;position: relative;padding-bottom: 20px;">
            <div class="mx-3 d-flex justify-content-between align-self-center align-content-center align-items-center">
                <a id="btn-signout" class="text-decoration-none text-black fw-bold align-content-center " role="button" href="logout.php" onclick="return confirm('Apakah anda yakin ingin keluar ?')">
                    <i class="bi bi-box-arrow-left me-3 "></i>Sign Out
                </a>
                <div class="d-flex">
                    <img src="../assets/Logo QnA.svg" class="img-fluid " width="40px" alt="..." style="margin-right: 10px;"/>
                    <h3 class="fw-bold mb-0 flex-grow-1 text-center">Daftar Sesi</h3>
                </div>
                <a id="btn-tambah" class="btn fw-bold text-decoration-none text-white border-0 rounded my-0 p-2 bg-opacity-10" style="background-color: #FF6641" role="button">
                    <i class="bi bi-plus-lg me-1"></i>
                    Sesi Baru
                </a>
            </div>

            <div class="container">
                <div id="list_sesi" class="row mb-1 mt-5">

                </div>
            </div>
        </div>

        <!-- Modal Create-->
        <div class="modal fade" id="modal-create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-create-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content  px-4">
                    <!--Buat Sesi-->
                    <form id="form-sesi" action="" method="post" class="needs-validation mb-0" novalidate>
                        <div class="modal-header justify-content-center border-0">
                            <h5 class="modal-title fw-bold " id="staticBackdropLabel">Buat Sesi</h5>
                        </div>
                        <div class="modal-body">
                                <div class="mb-3 row g-0">
                                    <div class="col-12 position-relative">
                                        <label for="input-nama-event" class="form-label input-nama-event small">Nama Event</label>
                                        <input type="text" class="form-control form-control-sm" id="input-nama-event" name="input-nama-pembicara" placeholder="Nama event Anda" required/>
                                        <div class="invalid-tooltip end-0">Nama event harus terisi</div>
                                    </div>
                                </div>
                                <!--<div class="mb-3 row g-0">
                                    <div class="col-12 position-relative">
                                        <label for="input-nama-pembicara" class="form-label input-nama-pembicara small">Pembicara</label>
                                        <input type="text" class="form-control form-control-sm" id="input-nama-pembicara" name="input-nama-pembicara" placeholder="Nama pembicara event" required/>
                                        <div class="invalid-tooltip">Nama pembicara harus terisi</div>
                                    </div>
                                </div>-->
                                <div class="mb-3 row">
                                    <div class="col-6 position-relative">
                                        <label for="input-kode-sesi" class="form-label input-kode-sesi small">Kode Sesi</label>
                                        <div class="input-group">
                                            <input id="input-kode-sesi" type="text" class="form-control form-control-sm position-relative border-end-0"  name="input-kode-sesi" readonly disabled/>
                                            <button id="btn-copy" class="btn btn-copy btn-sm fw-bold input-group-text border-start-0 border-end-0 ps-2"  title="Salin text" type="button" style="background-color: #e9ecef; border: 1px solid #ced4da">
                                                <i class="bi bi-clipboard"></i>
                                            </button>
                                            <button id="btn-regenerate" class="btn btn-regenerate btn-sm fw-bold input-group-text border-start-0 "  title="Generate ulang" type="button" style="background-color: #e9ecef; border: 1px solid #ced4da">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-6 position-relative">
                                        <label for="input-gambar" class="form-label small">Gambar Sesi</label>
                                        <input class="form-control form-control-sm" id="input-gambar" type="file" name="input-gambar" required>
                                        <div class="invalid-tooltip end-0">Gambar harus diisi</div>
                                    </div>
                                </div>
                                <div class="mb-5 row">
                                    <div class="col-6 position-relative">
                                        <label for="input-mulai" class="form-label input-mulai small">Waktu Mulai</label>
                                        <input type="datetime-local" class="form-control form-control-sm" id="input-mulai" name="input-mulai" required/>
                                        <div class="invalid-tooltip end-0">Waktu mulai harus terisi</div>
                                    </div>
                                    <div class="col-6 position-relative">
                                        <label for="input-selesai" class="form-label input-selesai small">Waktu Selesai</label>
                                        <input type="datetime-local" class="form-control form-control-sm" id="input-selesai" name="input-selesai" required/>
                                        <div class="invalid-tooltip end-0">Waktu selesai harus terisi</div>
                                    </div>
                                </div>

                        </div>
                        <div class="modal-footer border-0 px-3">
                            <button id="btn-save" type="submit" class="btn btn-save border-0 rounded-3 py-2 px-3 me-0 text-white fw-bold"  title="Simpan perubahan"  style="background-color: #FF6641;font-size: .875em">
                                Buat
                            </button>
                            <button id="timer-save" class="btn btn-save border-0 rounded-3 py-2 px-3 me-0 text-white fw-bold" disabled title="Harap menunggu"  style="background-color: #FF6641; display:none;">
                                <div  class=" spinner-border spinner-border-sm border-3 small" ></div>
                                <span class="fw-normal small ms-2"> Tunggu...</span>
                            </button>

                            <button id="btn-cancel" type="reset" class="btn btn-cancel border border-1 rounded-3 py-2 px-3 me-0 text-muted fw-semibold"  title="Batalkan perubahan" style="font-size: .875em">
                                Batal
                            </button>
                        </div>
                    </form>
                    <!--Edit Sesi-->
                    <form id="form-sesi-edit" action="" method="post" class="needs-validation mb-0 d-none" novalidate>
                        <div class="modal-header justify-content-center border-0">
                            <h5 class="modal-title fw-bold " id="staticBackdropLabel">Edit Sesi</h5>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3 row g-0">
                                <div class="col-12 position-relative">
                                    <label for="input-nama-event-edit" class="form-label input-nama-event-edit small">Nama Event</label>
                                    <input type="text" class="form-control form-control-sm" id="input-nama-event-edit" name="input-nama-pembicara-edit" placeholder="Nama event Anda" required/>
                                    <div class="invalid-tooltip end-0">Nama event harus terisi</div>
                                </div>
                            </div>
                            <!--<div class="mb-3 row g-0">
                                <div class="col-12 position-relative">
                                    <label for="input-nama-pembicara" class="form-label input-nama-pembicara small">Pembicara</label>
                                    <input type="text" class="form-control form-control-sm" id="input-nama-pembicara" name="input-nama-pembicara" placeholder="Nama pembicara event" required/>
                                    <div class="invalid-tooltip">Nama pembicara harus terisi</div>
                                </div>
                            </div>-->
                            <div class="mb-3 row">
                                <div class="col-6 position-relative">
                                    <label for="input-kode-sesi-edit" class="form-label input-kode-sesi-edit small">Kode Sesi</label>
                                    <div class="input-group">
                                        <input id="input-kode-sesi-edit" type="text" class="form-control form-control-sm position-relative border-end-0"  name="input-kode-sesi-edit" readonly disabled/>
                                        <button id="btn-copy-edit" class="btn btn-copy-edit btn-sm fw-bold input-group-text border-start-0 border-end-0 ps-2"  title="Salin text" type="button" style="background-color: #e9ecef; border: 1px solid #ced4da">
                                            <i class="bi bi-clipboard"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6 position-relative">
                                    <label for="input-gambar-edit" class="form-label small">Gambar Sesi</label>
                                    <input class="form-control form-control-sm" id="input-gambar-edit" type="file" name="input-gambar-edit">
                                </div>
                            </div>
                            <div class="mb-5 row">
                                <div class="col-6 position-relative">
                                    <label for="input-mulai-edit" class="form-label input-mulai-edit small">Waktu Mulai</label>
                                    <input type="datetime-local" class="form-control form-control-sm" id="input-mulai-edit" name="input-mulai-edit" required/>
                                    <div class="invalid-tooltip end-0">Waktu mulai harus terisi</div>
                                </div>
                                <div class="col-6 position-relative">
                                    <label for="input-selesai-edit" class="form-label input-selesai-edit small">Waktu Selesai</label>
                                    <input type="datetime-local" class="form-control form-control-sm" id="input-selesai-edit" name="input-selesai-edit" required/>
                                    <div class="invalid-tooltip end-0">Waktu selesai harus terisi</div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer border-0 px-3">
                            <button id="btn-save-edit" type="submit" class="btn btn-save border-0 rounded-3 py-2 px-3 me-0 text-white fw-bold"  title="Simpan perubahan"  style="background-color: #FF6641;font-size: .875em">
                                Simpan Perubahan
                            </button>
                            <button id="timer-save-edit" class="btn btn-save border-0 rounded-3 py-2 px-3 me-0 text-white fw-bold" disabled title="Harap menunggu"  style="background-color: #FF6641; display:none;">
                                <div  class=" spinner-border spinner-border-sm border-3 small" ></div>
                                <span class="fw-normal small ms-2"> Tunggu...</span>
                            </button>

                            <button id="btn-cancel-edit" type="reset" class="btn btn-cancel border border-1 rounded-3 py-2 px-3 me-0 text-muted fw-semibold"  title="Batalkan perubahan" style="font-size: .875em">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Delete-->
        <div class="modal fade" id="modal-delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-create-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered justify-content-center">
                <div class="modal-content py-2 px-4" style="width: auto">
                    <div class="modal-header border-0 pb-0">
                        <h6 class="modal-title fw-bold " id="staticBackdropLabel" >Apakah Anda yakin?</h6>
                    </div>
                    <div class="modal-body pb-0">
                        <p class="small text-muted">Sesi Anda akan dihapus dari daftar sesi. Setelah dihapus, Anda <b>tidak dapat</b> mengembalikannya.</p>
                    </div>
                    <div class="modal-footer border-0 pt-0 px-3 justify-content-between">
                        <button id="btn-confirm" type="submit" class="btn btn-confirm border-0 rounded-3 py-2 ms-0 me-0 text-white fw-bold btn-danger flex-fill"  title="Simpan perubahan"  style="font-size: .875em">
                            Hapus
                        </button>
                        <button id="timer-confirm" class="btn-confirm border-0 rounded-3 py-2 me-0 ms-0 text-white fw-bold bg-danger bg-opacity-50 flex-fill" disabled title="Harap menunggu"  style="display:none;">
                            <div  class=" spinner-border spinner-border-sm border-3 small" style="--bs-spinner-width: 0.8rem;--bs-spinner-height: 0.8rem;"></div>
                            <span class="fw-normal small ms-2"> Tunggu...</span>
                        </button>

                        <button id="btn-cancel" type="reset" class="btn btn-cancel border border-1 rounded-3 py-2 px-3 me-0 ms-3 text-muted fw-semibold flex-fill"  title="Batalkan hapus sesi" style="font-size: .875em">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toast -->
        <div id="container-toast" class="toast-container fixed-bottom ms-auto p-3" style="z-index: 2000">
            <!--toast copy-->
            <div id="toast-copy" class="toast align-items-center text-success border-1 border-success" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e8f3ee">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-3"></i>
                        Berhasil menyalin ke <em>clipboard</em>.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast create-->
            <div id="toast-create" class="toast align-items-center text-success border-1 border-success" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e8f3ee">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-3"></i>
                        Berhasil membuat sesi baru.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast create-->
            <div id="toast-edit" class="toast align-items-center text-success border-1 border-success" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e8f3ee">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-3"></i>
                        Berhasil mengubah sesi.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast create-->
            <div id="toast-delete" class="toast align-items-center text-success border-1 border-success" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e8f3ee">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-3"></i>
                        Berhasil menghapus sesi.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast error failed upload-->
            <div id="toast-failed-upload" class="toast align-items-center text-danger border-1 border-danger" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #fbeaec">
                <div class="d-flex">
                    <div id="text-error-upload" class="toast-body">
                        <i class="bi bi-x-circle me-3"></i>
                        Error
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>

        </div>

        <?php
        echo "<input type='hidden' name='login_id_admin' id='login_id_admin' value='".$_SESSION["id_admin"]."'/>";
        ?>

        <script>
            moment.locale('id');
            let test = moment().format('YYYY-MM-DDTHH:mm:ss');
            console.log(test);
            console.log($('#login_id_admin').val())
        </script>

        <!-- fungsi close toast-->
        <script>
            $("body").on("click", '.btn-close-toast', function() {
                let element = $(this).parent().parent().attr('id')
                $('#'+element).hide()
            })
        </script>

        <!-- handling modal create dan edit-->
        <script>
            $('#input-kode-sesi').val(generateId(6))
            // generate id
            function generateId(length) {
                var result           = '';
                var characters       = 'abcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for ( var i = 0; i < length; i++ ) {
                    result += characters.charAt(Math.floor(Math.random() *
                        charactersLength));
                }
                return result;
            }

            // handle tanggal mulai-selesai
            let mulai = $("#input-mulai")
            let selesai = $("#input-selesai")
            mulai.attr({
                "min" : moment().format('YYYY-MM-DDTHH:mm')
            });
            selesai.attr('disabled','true')
            mulai.change(function(){
                if(mulai.val() !== '') {
                    selesai.removeAttr( "disabled" )

                    if(mulai.val() > selesai.val()){ // kalau mulai > selesai
                        selesai.attr({
                            "min": moment(mulai.val()).format('YYYY-MM-DDTHH:mm'),
                            "max": moment(mulai.val()).add(7, 'd').format('YYYY-MM-DDTHH:mm')
                        });

                        selesai.val(moment(mulai.val()).add(5, 'h').format('YYYY-MM-DDTHH:mm'))
                    }
                    else if(mulai.val() < selesai.val() && mulai.val() <=moment(selesai.val()).subtract(7, 'd').format('YYYY-MM-DDTHH:mm')){ // kalau interval mulai ke selesai > 7 hari
                        console.log('masuk')
                        selesai.attr({
                            "min": moment(mulai.val()).format('YYYY-MM-DDTHH:mm'),
                            "max": moment(mulai.val()).add(7, 'd').format('YYYY-MM-DDTHH:mm')
                        });

                        selesai.val(moment(mulai.val()).add(5, 'h').format('YYYY-MM-DDTHH:mm'))
                    }
                    else{
                        selesai.attr({
                            "min": moment(mulai.val()).format('YYYY-MM-DDTHH:mm'),
                            "max": moment(mulai.val()).add(7, 'd').format('YYYY-MM-DDTHH:mm')
                        });
                    }
                }
            })

            $("body").on("click", "#btn-regenerate", function() {
                let id_unique = generateId(6)
                $('#input-kode-sesi').val(id_unique)
            })

            $("body").on("click", "#btn-copy", function() {
                /* Get the text field */
                let copyText = $("#input-kode-sesi").val();

                /* Select the text field */
                // copyText.select();
                // copyText.setSelectionRange(0, 99999); /* For mobile devices */

                /* Copy the text inside the text field */
                navigator.clipboard.writeText(copyText);

                /* Alert the copied text */
                // counter_toast_copy = counter_toast_copy+1
                // $('#container-toast').append(element_copy)
                // $('#toast-copy').attr('id','toast-copy-'+counter_toast_copy)
                // console.log( $('#toast-copy').attr('id'))
                // $('#toast-copy-'+counter_toast_copy).show()
                // setTimeout(function () {
                //     $('#toast-copy-'+counter_toast_copy).remove()
                // }, 3000)
                $('#toast-copy').show()
                setTimeout(function () {
                    $('#toast-copy').hide()
                }, 3000)
            })

            $("body").on("click", "#btn-tambah", function() {
                $('#modal-create').modal('show');
                $('#input-kode-sesi').val(generateId(6))
            })

            $("body").on("click", ".btn-cancel", function() {
                $('#modal-create').modal('hide');
                $('#modal-delete').modal('hide');
                $('#form-sesi').removeClass('was-validated')
            })

            $("form#form-sesi").on('submit', function (e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.

                let formData = new FormData( $("form#form-sesi")[0]);
                let actionUrl = '../database/upload.php';

                let id_admin= $('#login_id_admin').val();
                let nama_event= $('#input-nama-event').val();
                let event_mulai= $('#input-mulai').val();
                let event_berakhir= $('#input-selesai').val();
                let unique_code= $('#input-kode-sesi').val();

                if( id_admin && nama_event && event_mulai && event_berakhir && unique_code) {
                    $.ajax({
                        type: "POST",
                        url: actionUrl,
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function (data) {
                            console.log(data); // show response from the php script.
                            let dataResult = JSON.parse(data);
                            if (dataResult.statusCode === 200) {
                                console.log(dataResult)

                                $.ajax({
                                    url: "../insert_events.php",
                                    type: 'POST',
                                    cache: false,
                                    dataType: 'json',
                                    data: {
                                        id_image: dataResult.lastId,
                                        id_admin: $('#login_id_admin').val(),
                                        nama_event: $('#input-nama-event').val(),
                                        event_mulai: $('#input-mulai').val(),
                                        event_berakhir: $('#input-selesai').val(),
                                        unique_code: $('#input-kode-sesi').val(),
                                    },
                                    success: function (data, textStatus, xhr) {
                                        // $.ajax({
                                        //     url: "../insert_pembicara.php",
                                        //     type: 'POST',
                                        //     cache: false,
                                        //     dataType: 'json',
                                        //     data:{
                                        //         id_image: dataResult.lastId,
                                        //         id_admin: $('#login_id_admin').val(),
                                        //         nama_event: $('#input-nama-event').val(),
                                        //         event_mulai: $('#input-mulai').val(),
                                        //         event_berakhir: $('#input-selesai').val(),
                                        //         unique_code: $('#input-kode-sesi').val(),
                                        //     },
                                        //     success: function(data, textStatus, xhr) {
                                        //
                                        //     },
                                        //     error: function (textStatus, xhr) {
                                        //
                                        //     }
                                        // })
                                        console.log(data)

                                        $("#timer-save").show();
                                        $("#btn-save").hide();

                                        $('#toast-create').show()
                                        setTimeout(function () {
                                            $("#timer-save").hide();
                                            $("#btn-save").show();

                                            $('#toast-create').hide()

                                            $('#modal-create').modal('hide');
                                            $('#form-sesi-edit').removeClass('was-validated')

                                            window.location.reload();
                                        }, 3000)
                                    },
                                    error: function (textStatus, xhr, errorThrown) {
                                        console.log(xhr)
                                    }
                                })
                            } else {
                                console.log(dataResult);
                                $('#text-error-upload').text(dataResult.statusMessage).prepend(`<i class="bi bi-x-circle me-3"></i>`)
                                $('#toast-failed-upload').show()
                                setTimeout(function () {
                                    $('#toast-failed-upload').hide()
                                }, 3000)

                            }
                        }
                    });
                }
                else{
                    e.preventDefault();
                }

            });

            // edit
            $("body").on("click", ".btn-edit", function() {
                $('#form-sesi-edit').removeClass('d-none')
                $('#form-sesi').addClass('d-none')
                $('#modal-create').modal('show');
                // get id event
                let id_button = $(this).attr('id')
                let id_numb = id_button.split("-")
                let ide = id_numb[2]
                // image
                let image_name = $('#image_'+ide).val()
                let id_image = $('#id_image_'+ide).val()
                // nama event
                let event_name = $.trim($('#nama-event-'+ide).clone().children().remove().end().text())
                // waktu
                let mulai = $('#mulai_'+ide).val()
                let selesai = $('#selesai_'+ide).val()
                // kode
                let kode = $('#unique_code_'+ide).val()
                // bind data to input data
                $('#input-nama-event-edit').val(event_name)
                $('#input-mulai-edit').val(mulai)
                $('#input-selesai-edit').val(selesai)
                $('#input-kode-sesi-edit').val(kode)

                // handling submit perubahan
                $("form#form-sesi-edit").on('submit', function (e) {
                    e.preventDefault(); // avoid to execute the actual submit of the form.
                    let formData = new FormData( $("form#form-sesi-edit")[0]);
                    let actionUrl = '../database/upload.php';
                    let idImageLast = ''

                    console.log(formData.entries())

                    function updateEvents(lastId) {
                        $.ajax({
                            url: "../update_events.php",
                            type: 'POST',
                            cache: false,
                            dataType: 'json',
                            data:{
                                id_admin: $('#login_id_admin').val(),
                                id_image: lastId,
                                id_event: ide,
                                nama_event: $('#input-nama-event-edit').val(),
                                event_mulai: $('#input-mulai-edit').val(),
                                event_berakhir: $('#input-selesai-edit').val(),
                                unique_code: $('#input-kode-sesi-edit').val(),
                            },
                            success: function(data, textStatus, xhr) {
                                console.log(data)
                                $("#timer-save-edit").show();
                                $("#btn-save-edit").hide();

                                $('#toast-edit').show()
                                setTimeout(function () {
                                    $("#timer-save-edit").hide();
                                    $("#btn-save-edit").show();

                                    $('#toast-edit').hide()
                                }, 3000)
                                setTimeout(function () {
                                    $('#modal-create').modal('hide');
                                    $('#form-sesi-edit').addClass('d-none')
                                    $('#form-sesi').removeClass('d-none')
                                    $('#form-sesi-edit').removeClass('was-validated')

                                    window.location.reload();
                                },3500)
                            },
                            error: function (textStatus, xhr, errorThrown) {
                                console.log(xhr)
                            },
                            complete: function (data) {
                            }
                        })
                    }

                    if ($('#input-gambar-edit').val() !== '') {
                        $.ajax({
                            type: "POST",
                            url: actionUrl,
                            data: formData,
                            contentType: false,
                            cache: false,
                            processData: false,
                            success: function (data) {
                                console.log(data); // show response from the php script.
                                let dataResult = JSON.parse(data);
                                if (dataResult.statusCode === 200) {
                                    console.log(dataResult)
                                    idImageLast = dataResult.lastId
                                    console.log(idImageLast);

                                    updateEvents(idImageLast);
                                } else {
                                    console.log(dataResult);
                                    $('#text-error-upload').text(dataResult.statusMessage).prepend(`<i class="bi bi-x-circle me-3"></i>`)
                                    $('#toast-failed-upload').show()
                                    setTimeout(function () {
                                        $('#toast-failed-upload').hide()
                                    }, 3000)
                                }
                            }

                        });
                    }
                    else{
                        updateEvents('');
                    }


                });
            })

            $("body").on("click", "#btn-cancel-edit", function() {
                $('#form-sesi-edit').addClass('d-none')
                $('#form-sesi').removeClass('d-none')
                $('#modal-create').modal('hide');
                $('#form-sesi-edit').removeClass('was-validated')
            })

            // delete
            $("body").on("click", ".btn-delete", function() {
                let id_button = ''
                let id_numb = ''
                let ide = ''
                // get id event
                id_button = $(this).attr('id')
                id_numb = id_button.split("-")
                ide = id_numb[2]

                $('#modal-delete').modal('show');

                $("body").on("click", "#btn-confirm", function() {
                    $.ajax({
                        url: "../delete_events.php",
                        type: 'POST',
                        cache: false,
                        dataType: 'json',
                        data: {
                            id_admin: $('#login_id_admin').val(),
                            id_event: ide,
                        },
                        success: function (data, textStatus, xhr) {
                            console.log(data)

                            $('#toast-delete').show()
                            $("#timer-confirm").show();
                            $("#btn-confirm").hide();
                            setTimeout(function () {
                                $('#toast-delete').hide()
                                $("#timer-confirm").hide();
                                $("#btn-confirm").show();
                            }, 3000)
                            setTimeout(function () {
                                $('#modal-delete').modal('hide');
                                window.location.reload();
                            }, 3500)
                        },
                        error: function (textStatus, xhr, errorThrown) {
                            console.log(xhr)
                        },
                        complete: function (data) {
                        }
                    })
                })
            })


        </script>

        <!-- handle execption form-->
        <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function () {
                'use strict'
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                let forms = document.querySelectorAll('.needs-validation')
                // Loop over them and prevent submission
                Array.prototype.slice.call(forms)
                    .forEach(function (form) {
                        form.addEventListener('submit', function (event) {
                            if (!form.checkValidity()) {
                                console.log(form.checkValidity())
                                event.preventDefault()
                                event.stopPropagation()
                            }
                            form.classList.add('was-validated')
                        }, false)
                    })
            })()
        </script>

        <!-- handle list sesi-->
        <script>
            var id_tiket = 1;
            var id_tiket_session = 1;
            // $.ajax({
            //     url: kel1_api+'/items/ticket?fields=ticket_id,ticket_type,ticket_x_session.session_id.*&filter[ticket_id]=4',
            //     type: 'GET',
            //     dataType: 'json',
            //     // dataType: 'jsonp',
            //     // headers: {
            //     //     'Access-Control-Allow-Origin': '*',
            //     // },
            //     success: function(data, textStatus, xhr) {
            //
            //         let html_data = ""
            //         console.log(data.data)
            //         for(var i = 0; i < data.data.length; i++){
            //             for(var j = 0; j < data.data[i].ticket_x_session.length; j++){
            //                 console.log(data.data[i].ticket_x_session[j].session_id.session_desc)
            //
            //                 let nama_event = data.data[i].ticket_x_session[j].session_id.session_desc
            //                 let id_session = data.data[i].ticket_x_session[j].session_id.session_id
            //                 let time_start = new Date(data.data[i].ticket_x_session[j].session_id.start_time)
            //                 let time_finish = new Date(data.data[i].ticket_x_session[j].session_id.finish_time)
            //
            //                 let day = moment(time_start).format('dddd')
            //                 let time_begin = moment(time_start).format('LT')
            //                 let time_end = moment(time_finish).format('LT')
            //                 let date = moment(time_start).format('LL')
            //                 console.log(moment(new Date(time_start)).format('LT'))
            //                 let button_chat = ""
            //                 let warna = ""
            //                 let jam = 60 * 60 * 1000
            //                 let eventbenar = new Date(time_start - jam)
            //                 console.log(eventbenar)
            //                 // jika waktu mulai masih blm lewat : beda sejam
            //                 // 25/10/2021 16:11 <= 01/12/2021 09:00
            //                 if( new Date('2021-12-01T18:00:00') >= eventbenar ){
            //                     button_chat += "Segera dalam 1 Jam"
            //                     warna += "primary"
            //                 } else { //
            //
            //                     // jika waktu mulai sudah lewat tapi waktu finish belum
            //                     if( new Date() < time_start && new Date() < time_finish) {
            //                         button_chat += "Segera";
            //                         warna += "warning"
            //                     } else if (new Date() >= time_start && new Date() <= time_finish) {
            //                         button_chat += "Berjalan"
            //                         warna += "success"
            //                     } else { // jika waktu mulai dan waktu finish sudah lewat
            //                         button_chat += "Selesai"
            //                         warna += "secondary disabled"
            //                     }
            //                     // button_chat += "Beda"
            //                 }
            //
            //                 html_data += '<div class="mb-4 col-lg-3 col-md-6 col-sm-12 card-group">' +
            //                                 '<div class="card border-1" style="background-color:#ffffff;">' +
            //                                     '<img src="../assets/event1.jpg" class="card-img-top" alt="..." style="height: 140px; width=30px; object-fit: cover">' +
            //                                     '<div class="card-body">' +
            //                                         '<span class="badge bg-'+ warna +' bg-opacity-10 text-'+ warna +' mb-3">' + button_chat + '</span>' +
            //                                         '<h6 class="card-title fw-bold">' + nama_event + '</h6>' +
            //                                         '<p class="card-text"><small>' + day + ', ' + date + '<br>' + time_begin + ' - ' + time_end + '</small></p>' +
            //                                     '</div>'+
            //                                     '<div class="card-footer border-0 mb-3 d-grid" style="background-color:transparent"> '+
            //                                         '<a id="btn-masuk" href="../database/RoomChats.php?id_session='+ id_session +'" class="text-decoration-none text-black fw-bold small stretched-link">Masuk sesi<i class="bi bi-arrow-right ms-2"></i></a>' +
            //                                     '</div>' +
            //                                 '</div>' +
            //
            //                             '</div>';
            //             }
            //         }
            //         document.getElementById("list_sesi").innerHTML = html_data;
            //     },
            //     error: function(xhr, textStatus, errorThrown) {
            //         console.log(textStatus);
            //     }
            // })

            $.ajax({
                url: '../get_events.php',
                type: 'GET',
                dataType: 'json',
                // dataType: 'jsonp',
                // headers: {
                //     'Access-Control-Allow-Origin': '*',
                // },
                success: function(data, textStatus, xhr) {
                    let html_data = ""

                    console.log(data)
                    if (data.length>0){
                        for(var i = 0; i < data.length; i++){
                            console.log(data[i].is_deleted)
                            if (data[i].is_deleted != 1)
                            {
                                let id_session = data[i].id_event
                                let images = data[i].photo_name

                                let nama_event = data[i].nama_event
                                let time_start = new Date(data[i].event_mulai)
                                let time_finish = new Date(data[i].event_berakhir)
                                console.log(moment(new Date(time_start)).format('LT'))

                                let day = moment(time_start).format('dddd')
                                let time_begin = moment(time_start).format('LT')
                                let time_end = moment(time_finish).format('LT')
                                let date = moment(time_start).format('LL')
                                console.log(day + ' ' + date + ' ' + time_begin + ' ' + time_end)

                                let button_chat = ""
                                let warna = ""

                                let jam = 60 * 60 * 1000
                                let eventbenar = new Date(time_start - jam)
                                console.log(eventbenar)
                                console.log(new Date('2021-12-01T09:00:00') === eventbenar)
                                let current_time = new Date('2021-12-01T11:00:00')
                                // jika waktu mulai masih blm lewat : beda sejam
                                // 25/10/2021 16:11 <= 01/12/2021 09:00
                                // if( new Date('2021-12-01T09:00:00') === eventbenar ){
                                //     button_chat += "Segera dalam 1 Jam"
                                //     warna += "primary"
                                // }
                                // else {
                                // jika waktu mulai sudah lewat tapi waktu finish belum
                                if (current_time < time_start && current_time < time_finish) {
                                    if (current_time >= eventbenar) {
                                        button_chat += "Sesaat lagi"
                                        warna += "warning"
                                    } else {
                                        button_chat += "Segera";
                                        warna += "primary"
                                    }
                                } else if (current_time >= time_start && current_time <= time_finish) {
                                    button_chat += "Sedang berjalan"
                                    warna += "success"
                                } else { // jika waktu mulai dan waktu finish sudah lewat
                                    button_chat += "Selesai"
                                    warna += "secondary disabled"
                                }
                                // button_chat += "Beda"
                                // }

                                html_data += `
                                <div class="mb-4 col-lg-3 col-md-6 col-sm-12 card-group">
                                    <div class="card border-1" style="background-color:#ffffff;">
                                        <img src="../img/${images}" class="card-img-top" alt="..." style="height: 140px; width=30px; object-fit: cover">
                                        <!--hidden-->
                                        <input type='hidden' id='image_${id_session}' name='image_${id_session}' value='${images}'/>
                                        <input type='hidden' id='id_image_${id_session}' name='id_image_${id_session}' value='${data[i].id_image}'/>
                                        <input type='hidden' id='unique_code_${id_session}' name='unique_code_${id_session}' value='${data[i].unique_code}'/>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <span class="badge bg-${warna} bg-opacity-10 py-2 px-2 text-${warna} mb-3">${button_chat}</span>
                                                <div class="dropdown" style="z-index: 100">
                                                    <button id="btn-options" class="bg-transparent border-0" data-bs-toggle="dropdown" style="height: fit-content">
                                                        <i class="bi bi-three-dots-vertical text-muted"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <button id="btn-edit-${id_session}" class="dropdown-item small btn-edit" type="button">
                                                                <i class="bi bi-pencil me-3 text-primary"></i>Edit
                                                            </button>
                                                        </li>
                                                        <li>
                                                            <button id="btn-delete-${id_session}" class="dropdown-item small btn-delete" type="button">
                                                                <i class="bi bi-trash3 me-3 text-danger"></i>Delete
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <h6 id="nama-event-${id_session}" class="card-title fw-bold">${nama_event}</h6>
                                            <p class="card-text">
                                                <small>${day}, ${date}<br>${time_begin} - ${time_end} WIB</small>
                                                <!--hidden-->
                                                <input type='hidden' id='mulai_${id_session}' name='mulai_${id_session}' value='${data[i].event_mulai}'/>
                                                <input type='hidden' id='selesai_${id_session}' name='selesai_${id_session}' value='${data[i].event_berakhir}'/>
                                            </p>
                                        </div>
                                        <div class="card-footer border-0 mb-3 d-grid" style="background-color:transparent">
                                            <a id="btn-masuk" href="../database/RoomChats.php?id_session=${id_session}" class="text-decoration-none text-black fw-bold small stretched-link">
                                                Masuk sesi
                                                <i class="bi bi-arrow-right ms-2"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>`;
                            }
                        }
                    }
                    else{
                        html_data = `
                        <div id="empty-state" class="d-flex justify-content-center align-items-center" style="height: calc(100vh - 200px)">
                            <img src="../assets/empty.svg" class="text-muted  float-end" alt="Kosong" height="300px" >
                            <div class="align-self-center ms-5">
                                <h1 class="text-muted fw-bold">Ooops...</h1>
                                <p class="mb-0 text-muted">Belum ada sesi yang bisa ditampilkan</p>
                                <p class="mb-0 text-muted">Silakan <a href="#">buat sesi</a></p>
                            </div>
                        </div>`
                    }
                    document.getElementById("list_sesi").innerHTML = html_data;
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(textStatus);
                }
            })
        </script>

    </body>
</html>