<?php
    session_start();
    require('database/ChatRooms.php');
    include("crypt.php");
    include("get_nama.php");

    if(isset($_SESSION['is_login_user'])) {
        $chat_object = new ChatRooms;

        $chat_data = $chat_object->get_all_chat_data();

        $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
        // $uri_segments = explode('/', $uri_path);
        $hasilHash = mycrypt("decrypt", $uri_path);
        $arrayHasil = explode("&", $hasilHash);
        $peserta_id = explode("=", $arrayHasil[0]);
        //    $ticket_id = explode("=",$arrayHasil[1]);
        $sesi_id = explode("=", $arrayHasil[1]);
        $nama_peserta = get_nama($peserta_id[1]);
        $email = get_email($peserta_id[1]);
        $i_x_waktu = array();
//        var_dump($hasilHash);

    }
    else{
        echo $_SESSION['is_login_user'];
        echo "<script>document.location.href='index_user.php';</script>";
    }


//    echo $date->format('Y-m-d H:i:s');
?>

<!Doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User QnA</title>

    <script src="api.js"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css-js/qna/style.css" rel="stylesheet">

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">

    <!-- moment Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment-with-locales.min.js"></script>
    <!-- Jquery-->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <!-- Parsley -->
<!--    <script src="http://parsleyjs.org/dist/parsley.js"></script>-->
    <!-- Popper & Bootstrap JS-->
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

</head>

<body style="overflow-y: overlay">
        <!-- sidebar -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasInfo" aria-labelledby="offcanvasInfoLabel">
            <div class="offcanvas-header justify-content-start ">
                <button type="button" class="btn-close my-0 me-0" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body text-center">
                <p class="align-middle fs-1 fw-bold mb-4 ">QnA</p>
                <img src="assets/Logo QnA.svg" class="img-fluid text-center" width="35%" alt="...">
                <p id="nama_sesi" class="nama_sesi text-truncate  fw-bold mb-0 mt-4">Webinar Pengenalan Diri </p>
                <p class="e mt-1">Lumintu Event</p>
                <p id="date" class="fw-bold mb-0 mt-4"></p>
                <p id="time" class="mt-1"></p>
            </div>
        </div>

        <!-- navbar -->
        <div id="navbar" class="border-0 fixed-top px-3 py-2 text-dark border-bottom" style="background-color: #FFFFFF;">
            <div class="d-flex align-items-center justify-content-between">
                <button class="btn fs-3 p-0 me-0" data-bs-toggle="offcanvas" data-bs-target="#offcanvasInfo"
                    aria-controls="offcanvasInfo">
                    <i class="bi bi-list text-black"></i>
                </button>
                <p id="nama_sesi" class="nama_sesi small text-truncate fw-bold mb-0" style="max-width: 246px;">memuat...</p>
                <!-- layar besar -->
                <div id="dropdownProfile" class="dropdown">
                    <button class="small border-0 rounded-pill ms-0 text-white bg-primary fw-bold"
                        style="width: 2rem; height:2rem;" data-bs-toggle="dropdown">
                        <span class="avatar"><?php $huruf_depan = $nama_peserta[0];echo $huruf_depan;?></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="min-width: max-content">
                        <li class="d-flex justify-content-between ">
                            <span class="nama-user small dropdown-item-text align-self-center fw-bold"><?php echo $nama_peserta; ?></span>
                            <a href="#" class="small btn-edit-profil align-self-center border-0 bg-transparent text-decoration-none me-3">
                                Edit
                            </a>
                        </li>
                        <li>
                            <span class="email-user dropdown-item-text text-muted small pt-0"><?php echo $email;?></span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="btn-logout small dropdown-item justify-content-between" role="button" href="logoutUser.php?id_session=<?php echo $sesi_id[1];?>" onclick="return confirm('Apakah anda yakin ingin keluar ?')">
                                <i class="bi bi-box-arrow-right me-3"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- layar kecil -->
                <div id="offcanvasProfileContainer">
                    <button id="buttonOffCanvas" class="small border-0 rounded-pill ms-0 text-white bg-primary fw-bold"
                        style="width: 2.2rem; height:2.2rem;" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasProfile" aria-controls="offcanvasProfile">
                        <span class="avatar"><?php echo $huruf_depan;?></span>
                    </button>
                    <div class="offcanvas offcanvas-bottom border-0 shadow rounded-top" data-bs-backdrop="true"
                        style="height: inherit;" tabindex="-1" id="offcanvasProfile"
                        aria-labelledby="offcanvasProfileLabel">
                        <div class="offcanvas-body">
                            <div class="d-flex justify-content-between">
                                <span class="nama-user text-black fw-bold"><?php echo $nama_peserta;?></span>
                                <button class="small btn-edit-profil border-0 bg-transparent">
                                    Edit
                                </button>
                            </div>
                            <span class="email-user text-black small"><?php echo $email;?></span>
                            <hr class="text-black">
                            <a class="btn-logout text-decoration-none text-black justify-content-between" role="button" href="logoutUser.php?id_session=<?php echo $sesi_id[1];?>" onclick="return confirm('Apakah anda yakin ingin keluar ?')">
                                <i class="bi bi-box-arrow-right  me-3"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!--  list pertanyaan -->
        <div id="conversation-container" class="container px-3 position-absolute start-50 translate-middle-x " style="max-width: 540px;">
            <div id="conversation" class="position-absolute start-50 translate-middle-x w-100" style="overflow: overlay; ">
                <div class="mt-3" id="messages_area" style="margin-bottom: 6.5rem !important;">
                    <?php
                        $i = 0;
                        $total = count((array)$chat_data);

                        if($total !== 0) {
                            foreach ($chat_data as $chat) {

                                if ($chat["status"] !== '99') {
                                    $str1 = str_split($chat["waktu_pengiriman"], 10);
                                    $jam_pesan = str_split($str1[1], 6);
                                    // if id_participant = $chat["id_pengirim"] then
                                    // $abc = base64_decode($_GET["id_participant"]);
                                    if ($chat["id_pengirim"] == $peserta_id[1] && $chat["id_chat"] == $sesi_id[1]) {
                                        // simpan id dan waktu ke array
                                        $i_x_waktu[$i] = $chat["waktu_pengiriman"];
                                        // print element html
                                        echo
                                            '<div id="container-pesan-' .$chat["id_message"]. '" class="mb-3 mx-3 p-3 border border-1 rounded-3">
                                                <p class="mb-0 small pertanyaan">
                                                    ' . $chat["pesan"] . '
                                                </p>
                                                <div class="d-flex justify-content-between align-items-center mt-3 ">
                                                    <p id="jam-pesan-'. $i .'" class="text-black-50 small mb-0 ">
                                                        ' . $jam_pesan[0] . '
                                                    </p>
                                                    <p class="waktu-kirim d-none" id="waktu_pengiriman_'. $i .'" >'.$chat["waktu_pengiriman"].'</p>
                                                    <button id="btn-delete-' . $chat["id_message"] . '" class="btn btn-delete bg-danger bg-opacity-10 border-0 rounded-3 py-1 me-0 text-muted"  title="Hapus pertanyaan" style="width: 50px;">
                                                        <i class="bi bi-trash3 text-danger "></i>
                                                    </button>
                                                </div>
                                            </div> ';
                                        $i++;
                                    }
                                }
                            }
                        }
                        else{
                            echo '
                                <div id="empty-state" class="d-flex justify-content-center align-items-center" style="height: calc(100vh - 200px)">
                                     <img src="./assets/note.svg" class="text-muted  float-end" alt="Kosong" height="200px" >
                                     <div class="align-self-center ms-5">
                                         <h1 class="text-muted fw-bold">Ooops...</h1>
                                         <p class="mb-0 text-muted small">Belum ada pertanyaan yang bisa ditampilkan</p>
                                         <p class="mb-0 text-muted small">Silakan <a id="btn-tanya-kosong" href="#" class="fw-bold text-decoration-none" style="color: #FF6641">tanyakan sesuatu</a></p>
                                     </div>
                                </div>';
                        }
                    ?>
                </div>
            </div>

        </div>

        <div id="footer-container" class="fixed-bottom mx-auto" style="z-index: 1020;max-width: 540px;">

            <div id="conversation-footer" class="mb-3 mx-3 bg-white border border-1 shadow rounded-3 px-3 py-2 "
                style="">
                <div id="container-btn" class="d-flex justify-content-between align-items-center py-2" >
                    <p class="mb-0 small">Apa yang ingin Anda tanyakan?</p>

                    <button id="btn-tanya" class="btn rounded-lg text-white px-3 py-2" title="Tanyakan sesuatu"  style="background: #FF6641 ;">
                        <span class="small fw-bold">Tanya</span>
                    </button>
                </div>

                <form method="post" id="chat_form" style="display: none">
                    <div class="d-flex justify-content-between align-items-end mb-3">
                        <div class="flex-grow-1 pe-3">
                            <p class="fw-bold pt-2">Apa yang ingin Anda tanyakan?</p>
                            <textarea class="chat-text-area p-0 form-control border-0 bg-light me-3 p-2 small" id="chat_message"
                                name="chat_message" rows="1" style="overflow-y: hidden !important; font-size: 14px" placeholder="Tulis pertanyaan Anda..." maxlength="200" required></textarea>
                        </div>
                        <div class="text-center align-items-end">
                            <span id="char-counter" class="small text-mute" style="font-size: 12px">200</span>
                        </div>
                    </div>

                    <div id="container-btn" class="d-flex align-items-center py-2">
                        <!-- layar besar -->
                        <div id="dropdown-as" class="dropup me-auto" >
                            <div class="d-flex" data-bs-toggle="dropdown">
                                <div id="as-peserta" class="">
                                    <button class="small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                        <span class="avatar"><?php echo $huruf_depan; ?></span>
                                    </button>
                                    <a id="nama-peserta-form-dropdown" class="small nama-user align-self-center ms-2 text-truncate mb-0 dropdown-toggle text-decoration-none text-black"><?php echo $nama_peserta; ?></a>
                                </div>
                                <div id="as-anonim" class="d-none">
                                    <button class="small border-0 rounded-pill ms-0 text-black bg-secondary bg-opacity-10 fw-bold" style="width: 2rem; height:2rem;" disabled>
                                        <i class="bi bi-person"></i>
                                    </button>
                                    <a id="anonim" class="small align-self-center ms-2 text-truncate mb-0 dropdown-toggle text-decoration-none text-black">
                                        Anonim
                                    </a>
                                </div>
                            </div>
                            <ul class="dropdown-menu">
                                <li class="pb-2">
                                    <a id="btn-as-peserta" class="small dropdown-item justify-content-between">
                                        <button class="me-3 small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                            <span class="avatar"><?php echo $huruf_depan; ?></span>
                                        </button>
                                        Tetap sebagai <span class="nama-user fw-bold"><?php echo $nama_peserta; ?></span>
                                    </a>
                                </li>
                                <li class="">
                                    <a id="btn-as-anonim" class="small dropdown-item justify-content-between">
                                        <button class="me-3 small border-0 rounded-pill ms-0 text-black bg-secondary bg-opacity-10 fw-bold" style="width: 2rem; height:2rem;" disabled>
                                            <i class="bi bi-person"></i>
                                        </button>
                                        Sebagai <b>anonim</b>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- layar kecil -->
                        <div id="offcanvasAsContainer" class="me-auto ">
                            <div id="as-peserta-offcanvas" class="" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-as" aria-controls="offcanvas-as">
                                <button id="btn-offcanvas-as" class="small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                    <span class="avatar"><?php echo $huruf_depan; ?></span>
                                </button>
                                <a id="nama-peserta-form-offcanvas" class="nama-user small align-self-center ms-2 text-truncate mb-0 dropdown-toggle text-decoration-none text-black"><?php echo $nama_peserta; ?></a>
                            </div>
                            <div id="as-anonim-offcanvas" class="d-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-as" aria-controls="offcanvas-as">
                                <button class="small border-0 rounded-pill ms-0 text-black bg-secondary bg-opacity-10 fw-bold" style="width: 2rem; height:2rem;" disabled>
                                    <i class="bi bi-person"></i>
                                </button>
                                <a id="anonim" class="small align-self-center ms-2 text-truncate mb-0 dropdown-toggle text-decoration-none text-black">
                                    Anonim
                                </a>
                            </div>
                            <div id="offcanvas-as" class="offcanvas offcanvas-bottom border-0 shadow rounded-top" data-bs-backdrop="true" style="height: auto;" tabindex="-1" aria-labelledby="offcanvasAsLabel">
                                <div class="offcanvas-body d-grid gap-2">
                                    <a id="btn-as-peserta-offcanvas" class="small text-decoration-none text-black">
                                        <button class="me-3 small border-0 rounded-pill ms-0 text-white bg-primary fw-bold " style="width: 2rem; height:2rem;" disabled>
                                            <span class="avatar"><?php echo $huruf_depan; ?></span>
                                        </button>
                                        Tetap sebagai <span class="nama-user fw-bold "><?php echo $nama_peserta; ?></span>
                                    </a>
                                    <a id="btn-as-anonim-offcanvas" class="small text-decoration-none mt-4 text-black">
                                        <button class="me-3 small border-0 rounded-pill ms-0 text-black bg-secondary bg-opacity-10 fw-bold" style="width: 2rem; height:2rem;" disabled>
                                            <i class="bi bi-person"></i>
                                        </button>
                                        Sebagai <b>anonim</b>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <button id="timer" class=" btn btn-send px-3 py-2 text-white fw-bold" disabled title="Harap menunggu"  style="background-color: #FF6641; display:none;">
                            <div  class=" spinner-border spinner-border-sm border-3 small" ></div>
                            <span class="fw-normal small ms-2"> Tunggu...</span>
                        </button>
                        <button type="submit" name="send" id="send" class=" btn btn-send px-3 py-2 text-white small fw-bold" title="Kirim pertanyaan"  style="background-color: #FF6641; ">
                            <span class="small fw-bold">Kirim</span>
                        </button>

                    </div>
                </form>

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
                        <p class="small text-muted">Pertanyaan Anda akan dihapus dari daftar pertanyaan. Setelah dihapus, Anda <b>tidak dapat</b> mengembalikannya.</p>
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
            <!--toast edit-->
            <div id="toast-edit-profil" class="toast align-items-center text-success border-1 border-success" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e8f3ee">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-3"></i>
                        Berhasil mengubah profil.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast create-->
            <div id="toast-create" class="toast align-items-center text-success border-1 border-success" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e8f3ee">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-3"></i>
                        Berhasil membuat pertanyaan baru.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast edit-->
            <div id="toast-edit" class="toast align-items-center text-success border-1 border-success" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e8f3ee">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-3"></i>
                        Berhasil mengubah pertanyaan.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast delete-->
            <div id="toast-delete" class="toast align-items-center text-success border-1 border-success" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e8f3ee">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-3"></i>
                        Berhasil menghapus pertanyaan.
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

        <!-- Modal Edit Profil-->
         <div class="modal fade" id="modal-edit-profil" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-edit-label" aria-hidden="true">
             <div class="modal-dialog modal-dialog-centered">
                 <div class="modal-content px-4">
                     <div class="modal-header justify-content-center border-0">
                         <h5 class="modal-title fw-bold" id="staticBackdropLabel">Edit Profil</h5>
                     </div>
                     <div class="modal-body mb-5">
                         <div class="position-relative">
                             <label for="input-nama-edit" class="form-label nama small">Nama</label>
                             <input type="text" class="form-control form-control-sm" id="input-nama-edit" name="input-nama-edit" placeholder="John Doe" required/>
                             <div class="invalid-tooltip end-0">Nama tidak valid</div>
                         </div>
                         <div class="mt-3 position-relative">
                             <label for="input-email-edit" class="form-label email small">Email</label>
                             <input type="email" class="form-control form-control-sm" id="input-email-edit" name="input-email-edit" placeholder="john@example.com" required/>
                             <div class="invalid-tooltip end-0">Email tidak valid</div>
                         </div>
                     </div>
                     <div class="modal-footer border-0">
                         <button id="btn-save-profil" class="btn btn-save border-0 rounded-3 py-2 px-3 me-0 text-white fw-bold"  title="Simpan perubahan"  style="background-color: #FF6641;font-size: .875em">
                             Simpan
                         </button>

                         <button id="btn-cancel" class="btn btn-cancel border border-1 rounded-3 py-2 px-3 me-0 text-muted fw-semibold"  title="Batalkan perubahan" style="font-size: .875em">
                             Batal
                         </button>
                     </div>
                 </div>
             </div>
         </div>

        <!-- Modal Edit-->
       <!-- <div class="modal fade" id="modal-edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-edit-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title fw-bold " id="staticBackdropLabel">Edit Pertanyaan</h5>
                    </div>
                    <div class="modal-body ">
                        <textarea id="input-edit" type="text" class="form-control border border-1 py-2 px-3 rounded-start" style="height:200px;font-size: .875em;resize: none" maxlength="200" required></textarea>
                    </div>
                    <div class="modal-footer border-0">
                        <span id="char-counter" class="small text-mute me-auto" style="font-size: 12px">200</span>

                        <button id="btn-save" class="btn btn-save border-0 rounded-3 py-2 px-3 me-0 text-white fw-bold"  title="Simpan perubahan"  style="background-color: #FF6641;font-size: .875em">
                            Simpan
                        </button>

                        <button id="btn-cancel" class="btn btn-cancel border border-1 rounded-3 py-2 px-3 me-0 text-muted fw-semibold"  title="Batalkan perubahan" style="font-size: .875em">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>-->

        <?php
        echo "
        <input type='hidden' name='login_user_id' id='login_user_id' value='".$peserta_id[1]."'/>
        <input type='hidden' name='login_id_sesi' id='login_id_sesi' value='".$sesi_id[1]."'/>
        ";

    ?>

    <script>
        // $(window).load(function() {
        //     $("html, body").animate({ scrollTop: $(document).height() }, 1000);
        // });
        moment.locale('id'); //set timezone to Indonesia
        console.log(moment(Date.now()).fromNow());
        console.log(moment().format('LT'))
        console.log(moment('2022-07-01 15:25:05').fromNow())
        //console.log(<?php //echo $i; ?>//)
        //get url from current page
        //console.log("<?php
        //    if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
        //        $url = "https://";
        //    else
        //        $url = "http://";
        //    // Append the host(domain name, ip) to the URL.
        //    $url.= $_SERVER['HTTP_HOST'];
        //
        //    // Append the requested resource location to the URL
        //    $url.= $_SERVER['REQUEST_URI'];
        //
        //    echo $url;  ?>//")
    </script>

    <!-- fungsi ganti background letter avatar-->
    <script>
        let warna = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e", "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50", "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6", "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d"];

        let warna2 = ["rgba(26,188,156,0.1)", "rgba(46,204,113,0.1)", "rgba(52,152,219,0.1)", "rgba(155,89,182,0.1)", "rgba(52,73,94,0.01)", "rgba(22,160,133,0.1)", "rgba(39,174,96,0.1)", "rgba(41,128,185,0.1)", "rgba(142,68,173,0.1)", "rgba(44,62,80,0.1)", "rgba(241,196,15,0.01)", "rgba(230,126,34,0.1)", "rgba(231,76,60,0.1)", "rgba(236,240,241,0.1)", "rgba(149,165,166,0.1)", "rgba(243,156,18,0.1)", "rgba(211,84,0,0.1)", "rgba(192,57,43,0.1)", "rgba(189,195,199,0.1)", "rgba(127,140,141,0.1)"];

        function ubahWarnaAvatar() {
            $(".avatar").parent().removeClass('bg-primary');

            if($('#nama-peserta-form-dropdown').text()==='Anonim'){
                $('.avatar').html('<i class="bi bi-person"></i>')
                $(".avatar").parent().css({"background-color": '#f0f1f2'});
                $(".avatar").css({"color": '#1b1b1b'});
            }

            $(".avatar:contains('Q'), .avatar:contains('W'), .avatar:contains('N'), .avatar:contains('M')").parent().css({"background-color": warna[0]});
            $(".avatar:contains('E'), .avatar:contains('R')").parent().css({"background-color": warna[1]});
            $(".avatar:contains('T'), .avatar:contains('Y')").parent().css({"background-color": warna[2]});
            $(".avatar:contains('U'), .avatar:contains('I')").parent().css({"background-color": warna[3]});
            $(".avatar:contains('O'), .avatar:contains('P')").parent().css({"background-color": warna[4]});
            $(".avatar:contains('D'), .avatar:contains('F'), .avatar:contains('V'), .avatar:contains('B')").parent().css({"background-color": warna[7]});
            $(".avatar:contains('G'), .avatar:contains('H')").parent().css({"background-color": warna[16]});
            $(".avatar:contains('J'), .avatar:contains('K')").parent().css({"background-color": warna[8]});
            $(".avatar:contains('L'), .avatar:contains('Z')").parent().css({"background-color": warna[12]});
            $(".avatar:contains('X'), .avatar:contains('C'), .avatar:contains('A'), .avatar:contains('S')").parent().css({"background-color": warna[11]});
        }
        $(document).ready(function() {
            ubahWarnaAvatar();
        })
    </script>

        <!-- pengiriman pertanyaan-->
    <script>
        function escapeHtml(text) {
            return text
                .replace(/&/g, "&'';")
                .replace(/</g, "<'")
                .replace(/>/g, ">'")
                .replace(/"/g, "''")
                .replace(/'/g, "'");
        }

        // Koneksi Websocket
        let i = <?php echo $i ?>;
        let user_id = $('#login_user_id').val();;
        // var conn = new WebSocket('ws://localhost:8082'); //dibuat dinamis
        var conn = new WebSocket('ws://0.tcp.ap.ngrok.io:17379'); //dibuat dinamis
        conn.onopen = function (e) {
            console.log("Connection established!");
        };

        conn.onmessage = function (e) {
            console.log(e.data);
            let data = JSON.parse(e.data);
            let row_class = '';
            let background_class = '';
            let html_data = '';

            if(data.asal === 'user') {
                let msg1 = escapeHtml(data.msg);

                if (data.from == 'Me') {
                    html_data = "<div id='container-pesan-" + data.mId + "' class='mb-3 mx-3 p-3 border border-1 rounded-3'><p class='mb-0 small'>" + msg1 + "</p><div class='d-flex justify-content-between align-items-center mt-3 '><p id='jam-pesan-" + i + "' class='text-black-50 small mb-0'>" + moment().fromNow() + "'</p><p class='waktu-kirim d-none' id='waktu_pengiriman_" + i + "'>" + data.date + "</p><button id='btn-delete-" + data.mId + "' class='btn btn-delete bg-danger bg-opacity-10 border-0 rounded-3 py-1 me-0 text-muted'  title='Hapus pertanyaan' style='width: 50px;'><i class='bi bi-trash3 text-danger'></i></button></div></div>"
                }

                jam_i[jam_i.length] = data.date

                $('#messages_area').append(html_data);
                $('html, body').animate({
                    scrollTop: $('#container-pesan-' + data.mId).offset().top - $('html, body').offset().top + $('html, body').scrollTop()
                }, 500);
                $("#chat_message").val("");
                i = i + 1;
            }
            else if(data.asal === 'admin-edit'){
                let idm = data.mId
                let message = data.msg

                $('#container-pesan-'+idm).children('p.pertanyaan').text(message)
            }
            else if(data.asal === 'user-delete'){
                console.log(data.mId)
                $("#container-pesan-"+data.mId).remove()
            }
        };

        // Proses Pengiriman Pesan
        $('#chat_form').on('submit', function (event) {

            event.preventDefault();

            // if ($('#chat_form').parsley().isValid()) {

            let message_id = ''
            let id_sesi = $('#login_id_sesi').val();
            let message = $('#chat_message').val();
            let date = moment().format("YYYY-MM-DD HH:mm:ss")
            let data = {
                asal: 'user',
                userId: user_id,
                mId: message_id,
                msg: message,
                sesiId: id_sesi,
                date: date
            };
            conn.send(JSON.stringify(data));

            $("#chat_message").css('height', 'calc(1.5em + 0.75rem + 2px)');
            $("#chat_form").hide();
            $("#container-btn").addClass('d-flex').show()

            //show toast
            $('#toast-create').show()
            setTimeout(function () {
                $('#toast-create').hide()
            },5000)


            // }
        });
    </script>

    <!-- function buttons-->
    <script>
        // button logout
        $("body").on("click", ".btn-logout", function() {

        })
        // button cancel
        $("body").on("click", ".btn-cancel", function() {
            $('#modal-edit-profil').modal('hide');
            $('#modal-delete').modal('hide');
        })

        // button delete
        $("body").on("click", ".btn-delete", function() {
            let id_button = ''
            let id_numb = ''
            let idm = ''
            // get id event
            id_button = $(this).attr('id')
            id_numb = id_button.split("-")
            idm = id_numb[2]
            console.log(id_button)

            let cust_message = $.trim($('#container-pesan-'+idm).children('.pertanyaan').text());
            console.log(cust_message)
            $('#modal-delete').modal('show');

            $("body").on("click", "#btn-confirm", function() {
                $.ajax({
                    url: "./delete_messages.php",
                    type: 'POST',
                    cache: false,
                    dataType: 'json',
                    data: {
                        id_message: idm,
                    },
                    success: function (data, textStatus, xhr) {
                        console.log(data)

                        $("#timer-confirm").show();
                        $("#btn-confirm").hide();
                        setTimeout(function () {
                            $("#timer-confirm").hide();
                            $("#btn-confirm").show();
                        }, 2000)
                        setTimeout(function () {
                            $('#toast-delete').show()
                        }, 2500)
                        setTimeout(function () {
                            $('#toast-delete').hide()
                            $('#modal-delete').modal('hide');
                            // window.location.reload();
                        }, 3500)
                    },
                    error: function (textStatus, xhr, errorThrown) {
                        console.log(xhr)
                    },
                    complete: function (data) {
                        // Proses Pengiriman Pesan
                        let id_sesi = $('#login_id_sesi').val();
                        let dataWebsocket = {
                            asal: 'user-delete',
                            mId: idm,
                            msg: cust_message,
                            date: moment().format('YYYY-MM-DD HH:mm:ss'),
                        };
                        conn.send(JSON.stringify(dataWebsocket));
                    }
                })
            })
        })

        // button dropdown
        $("body").on("click", "#btn-as-peserta,#btn-as-peserta-offcanvas", function() {
            user_id = $('#login_user_id').val();
            //dropdown
            $('#as-anonim').addClass('d-none');
            $('#as-peserta').removeClass('d-none');
            //offcanvas
            $('#as-anonim-offcanvas').addClass('d-none');
            $('#as-peserta-offcanvas').removeClass('d-none');
            console.log(user_id)
            $('#offcanvas-as').offcanvas('hide')
        })
        $("body").on("click", "#btn-as-anonim, #btn-as-anonim-offcanvas", function() {
            user_id = 0;
            //dropdown
            $('#as-anonim').removeClass('d-none');
            $('#as-peserta').addClass('d-none');
            //offcanvas
            $('#as-anonim-offcanvas').removeClass('d-none');
            $('#as-peserta-offcanvas').addClass('d-none');
            console.log(user_id)
            $('#offcanvas-as').offcanvas('hide')
        })

        // fungsi edit
        let id_user = $('#login_user_id').val()
        if(id_user === '0'){
            $(".btn-edit-profil").hide()
            $("#dropdown-as").children().attr('data-bs-toggle',"")
            $("#nama-peserta-form-dropdown").removeClass('dropdown-toggle')
            $("#nama-peserta-form-dropdown").css({"cursor": 'auto'})

            $("#as-peserta-offcanvas").attr('data-bs-toggle',"")
            $("#nama-peserta-form-offcanvas").removeClass('dropdown-toggle')
        }
        else{
            $(".btn-edit-profil").show()
            $("#dropdown-as").children().attr('data-bs-toggle',"dropdown")
            $("#as-peserta-offcanvas").attr('data-bs-toggle',"offcanvas")
        }

        $("body").on("click", ".btn-edit-profil", function() {
            $('#modal-edit-profil').modal('show');
            let nama = '';
            let email = '';

            $("#input-input-nama-edit, #input-email-edit").on('keyup', function(e) {
                if($('#input-input-nama-edit').val() !== '' && $('#input-email-edit').val() !== ''){
                    $('#btn-save-profil').removeAttr('disabled')
                }
                else{
                    $('#btn-save-profil').attr('disabled','true')
                }
            });

            $.ajax({
                url: "./get_participant_by_id.php",
                type: "POST",
                cache: false,
                dataType: 'json',
                data:{
                    id_participant: id_user
                },
                success: function(data){
                    console.log(data)
                    if(data.statusCode == 200) {
                        nama = data.data.nama
                        email = data.data.email

                        $('#input-nama-edit').val(nama)
                        $('#input-email-edit').val(email)

                        // fungsi save edit
                        $("body").on("click", "#btn-save-profil", function() {
                            let nama_edited = $.trim($('#input-nama-edit').val())
                            let email_edited = $.trim($('#input-email-edit').val())

                            console.log(nama_edited + ' vs '+ nama)
                            console.log(email_edited+ ' vs '+ email)

                            if(nama === nama_edited && email === email_edited){
                                $('#modal-edit-profil').modal('hide');
                            }
                            else{
                                $.ajax({
                                    url: "./update_participants.php",
                                    type: "POST",
                                    cache: false,
                                    data:{
                                        id_participant: id_user,
                                        nama : nama_edited,
                                        email: email_edited,
                                    },
                                    success: function(dataResult){
                                        console.log(this.data)
                                        var dataResult = JSON.parse(dataResult);
                                        if(dataResult.statusCode===200){
                                            console.log('Data updated successfully ! '+nama_edited+' apa');

                                            $('.nama-user').text(nama_edited);
                                            $('.avatar').text(nama_edited.charAt(0));
                                            ubahWarnaAvatar();
                                        }
                                    },
                                    error: function (xhr, ajaxOptions, thrownError) {
                                        console.log(xhr.status);
                                        console.log(thrownError);
                                    }
                                });

                                //show toast
                                setTimeout(function () {
                                    $('#toast-edit-profil').show()
                                    $('#modal-edit-profil').modal('hide');
                                },500)

                                setTimeout(function () {
                                    $('#toast-edit-profil').hide()
                                },4000)

                                // Proses Pengiriman Pesan
                                let data = {
                                    asal: 'user-profil',
                                    userId: id_user,
                                    namaUser: nama_edited,
                                    date: moment().format('YYYY-MM-DD HH:mm:ss'),
                                };
                                conn.send(JSON.stringify(data));

                            }
                        })
                    }
                    else if(data.statusCode == 201){
                        console.log(data)
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });

        })

        // fungsi edit
        // let edit_idm = 0
        // $("body").on("click", ".btn-edit", function() {
        //     $('#modal-edit').modal('show');
        //
        //     let id_element = $(this).attr('id');
        //     let id_numb = id_element.split("-");
        //     edit_idm = id_numb[2]
        //     let parent_element = $('#container-pesan-'+edit_idm);
        //
        //     // get message
        //     let cust_message = $.trim($('#pesan-'+edit_idm).clone().children().remove().end().text());
        //
        //     $('#input-edit').val(cust_message)
        //     charCounter()
        // })
        // // fungsi save edit
        // $("body").on("click", ".btn-save", function() {
        //     // get message
        //     let cust_message = $.trim($('#pesan-'+edit_idm).clone().children().remove().end().text());
        //     let edited_message = $.trim($('#input-edit').val())
        //
        //     console.log(edited_message + ' edit '+ edit_idm)
        //     console.log(cust_message+ ' asli '+ edit_idm)
        //
        //     if(cust_message === edited_message){
        //         $('#input-edit').val('')
        //         $('#modal-edit').modal('hide');
        //     }
        //     else{
        //         $('#pesan-'+edit_idm).text(edited_message);
        //
        //         if($('#pesan-'+edit_idm).children().hasClass('badge-edited') === false) {
        //             $('#pesan-' + edit_idm).append(`<span class="badge-edited small mb-0 text-muted"> (edited)</span>`)
        //         }
        //         console.log("xhr.status");
        //         $.ajax({
        //             url: "../update_messages.php",
        //             type: "POST",
        //             cache: false,
        //             data:{
        //                 id_message: edit_idm,
        //                 pesan : edited_message,
        //                 is_edited: 2,
        //             },
        //             success: function(dataResult){
        //                 console.log(this.data)
        //                 var dataResult = JSON.parse(dataResult);
        //                 if(dataResult.statusCode===200){
        //                     console.log('Data updated successfully ! '+edit_idm+' apa');
        //                 }
        //             },
        //             error: function (xhr, ajaxOptions, thrownError) {
        //                 console.log(xhr.status);
        //                 console.log(thrownError);
        //             }
        //         });
        //
        //         //show toast
        //         setTimeout(function () {
        //             $('#toast-edit').show()
        //             $('#modal-edit').modal('hide');
        //         },500)
        //
        //         setTimeout(function () {
        //             $('#toast-edit').hide()
        //         },4000)
        //
        //         // Proses Pengiriman Pesan
        //         // var id_sesi = $('#login_id_sesi').val();
        //         // var data = {
        //         //     asal: 'admin-terpilih',
        //         //     userId: id_user,
        //         //     mId: idm,
        //         //     msg: cust_message,
        //         //     sesiId: id_sesi,
        //         //     date: jam_pesan_hidden,
        //         // };
        //         // conn.send(JSON.stringify(data));
        //
        //     }
        // })
    </script>

    <!-- autogrow textarea function-->
    <script>
        // function counter characters
        function charCounter() {
            var maxChar = 200
            var count = $("#chat_message").val().length
            var remaining = maxChar - count
            $("#char-counter").text(remaining)
        }
        // function autogrow
        $("#chat_message").on('keyup', function(e) {
            let t = $("#chat_message");
            if (t.val().trim() == "") {
                t.css('height', 'calc(1.5em + 0.75rem + 2px)');
            } else {
                t.css('height', '0.1px');
                t.css('height', t[0].scrollHeight);
            }
            charCounter()
        });
    </script>

    <!-- function display form -->  
    <script>
        $("#btn-tanya, #btn-tanya-kosong").click(function(){
            $("#chat_form").show();
            $("#container-btn").removeClass('d-flex')
            $("#container-btn").hide()
            charCounter()
        });
        //fungsi close ketika klik luar element
        $(document).mouseup(function(e){
            var container = $("#chat_form");

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0)
            {
                container.hide();
                $("#container-btn").addClass('d-flex').show()
            }
        });

    </script>

    <!-- function olah tanggal -->
    <script>
        setInterval(function() {
            setFormatJam()
            console.log("formatted")
        }, 60 * 500);

        let jam_i = <?php echo json_encode($i_x_waktu); ?>;

        function setFormatJam() {
            // console.log(jam_i)
            for(let i=0; i<jam_i.length; i++){
                let status_jam_i = moment(jam_i[i]).fromNow();
                $("#jam-pesan-"+i).text(status_jam_i)
                // console.log($("#jam-pesan-"+i).attr('id') +' '+i)
            }
        }
        setFormatJam()
    </script>

    <!-- function hitung tinggi navbar dan footer -->
    <script>
        var navbar = $("#navbar").outerHeight().toString()
        var footer = $("#footer-container").outerHeight().toString()

        // set value css
        $("#conversation-container").css({
            "top": navbar + "px",
            "bottom": footer + "px"
        })
    </script>

    <!-- function mencegah spamming -->
    <script type="text/javascript">
        $(document).ready(function () {
            $("#send").click(function () {
                $("#send").hide();
                $("#timer").show();
            });
        });

        $(document).ready(function () {
            $("#send").click(function () {
                var detik = 4;
                //var pesann = '<img src="../lumintu_qna/assets/btnSend.svg">';
                var pesann = 'wait';
                function hitung() {
                    var to = setTimeout(hitung, 1000);
                    // var peringatan ='style = "color: red"';
                    // $('#timer').html('<p align="center" '+peringatan+'>'+pesann+'</p>');

                    detik--;
                    if (detik <0) {
                        clearTimeout(to);
                        detik = 10;
                        $("#timer").hide();
                        $("#send").show();
                    }
                }
                hitung();
            });
        });
    </script>

    <!-- get data waktu event-->
    <script>
        // var id_tiket = $('#login_id_ticket').val();
        // var id_tiket_session = $('#login_id_sesi').val();
        // $.ajax({
        //     url: kel1_api + '/items/ticket?fields=ticket_id,ticket_type,ticket_x_session.session_id.*,ticket_x_day.day_id.*',
        //     type: 'GET',
        //     dataType: 'json',
        //     success: function (data, textStatus, xhr) { //callback - pengganti promise
        //         // data.data.map(item => {
        //         console.log(data.data[id_tiket - 1].ticket_x_session[id_tiket_session - 1].session_id.start_time)
        //         let nama = data.data[id_tiket - 1].ticket_x_session[id_tiket_session - 1].session_id.session_desc
        //         let time_start = new Date(data.data[id_tiket - 1].ticket_x_session[id_tiket_session - 1].session_id.start_time)
        //         let time_finish = new Date(data.data[id_tiket - 1].ticket_x_session[id_tiket_session - 1].session_id.finish_time)
        //
        //         let day = moment(time_start).format('dddd')
        //         let time_begin = moment(time_start).format('HH:mm')
        //         let time_end = moment(time_finish).format('HH:mm')
        //         let date = moment(time_start).format('LL')
        //
        //         // $('#24365    87').text(day+", "+date+" | "+time_begin+" - "+time_end+" WIB")
        //
        //         $('.nama_sesi').text(nama)
        //         $('#date').text(day + ", " + date)
        //         $('#time').text(time_begin + " - " + time_end + " WIB")
        //
        //         // })
        //     },
        //     error: function (xhr, textStatus, errorThrown) {
        //         console.log('Error in Database');
        //     }
        // })
        $.ajax({
            url: './get_events_user.php',
            type: 'GET',
            dataType: 'json',
            success: function(data, textStatus, xhr) {
                let html_data = ""

                console.log(data)
                for(var i = 0; i < data.length; i++){
                    if (data[i].id_event === $('#login_id_sesi').val())
                    {
                        console.log(data[i].id_event)
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

                        $('p#nama_sesi').text(nama_event)
                        $('p#date').text(day + ", " + date)
                        $('p#time').text(time_begin + " - " + time_end + " WIB")

                    }
                }
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        })
    </script>

</body>

</html>