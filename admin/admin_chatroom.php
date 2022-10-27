<?php
    session_start();

    require('../database/ChatRooms.php');
    include('../get_nama.php');
    // panggil fungsi enkripsi
    include("../crypt.php");

    if (!isset($_SESSION['is_login'])) {
      echo "<script>document.location.href='index.php';</script>";
      die();
    }

    $chat_object = new ChatRooms;
    $chat_data = $chat_object->get_all_chat_data();

    $i_x_waktu = array();
    $j_x_waktu = array();
    $k_x_waktu = array();
    $l_x_waktu = array();

    $status_all = 0;
    $status_live = 1;

    //encrypt id sesi
    $hasil_hash_id = mycrypt("encrypt", "id_session=".$_GET["id_session"]);
//    var_dump($_GET['id_session']);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin QnA</title>

        <!-- Script API -->
        <script src="../api.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
        <script src="http://parsleyjs.org/dist/parsley.js"></script>
        <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>

        <!-- moment Js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment-with-locales.min.js"></script>

        <!-- Bootstrap CSS -->
        <!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

        <!-- Custom styles for this template -->
        <link href="../css-js/style.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
    </head>

    <body>
        <!-- Toast -->
        <div id="container-toast" class="toast-container bottom-0 end-0 p-3">
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
            <!-- toast new-->
            <div id="toast-new" class="toast align-items-center text-primary border-1 border-primary" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e6f0ff">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-bell me-3"></i>
                        Ada pertanyaan baru.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!-- toast edit-->
            <div id="toast-edit" class="toast align-items-center text-success border-1 border-success" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e8f3ee">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-3"></i>
                        Berhasil mengubah pertanyaan.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast_accept-->
            <div id="toast-accept" class="toast align-items-center text-primary border-1 border-primary" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e6f0ff">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-circle me-3"></i>
                        Pertanyaan lolos untuk presentasi.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast_decline-->
            <div id="toast-decline" class="toast align-items-center text-primary border-1 border-primary" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e6f0ff">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-x-circle me-3"></i>
                        Pertanyaan ditolak untuk presentasi.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast_revert-->
            <div id="toast-revert" class="toast align-items-center text-success border-1 border-success" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e8f3ee">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-3"></i>
                        Pertanyaan berhasil dikembalikan.
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast_answer-->
            <div id="toast-answer" class="toast align-items-center text-success border-1 border-success" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e8f3ee">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-3"></i>
                        Berhasil ditandai sebagai "terjawab".
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast_love-->
            <div id="toast-love" class="toast align-items-center text-success border-1 border-success" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e8f3ee">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle me-3"></i>
                        Berhasil ditandai sebagai "favorit".
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <div id="toast-unlove" class="toast align-items-center text-danger border-1 border-danger" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #fbeaec">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-circle me-3"></i>
                        Pertanyaan tidak lagi "favorit".
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <!--toast-presentasi-->
            <div id="toast-presentasi" class="toast align-items-center text-primary border-1 border-primary" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e6f0ff">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-circle me-3"></i>
                        Pertanyaan dipresentasikan
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
            <div id="toast-presentasi-hide" class="toast align-items-center text-danger border-1 border-danger" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #fbeaec">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-circle me-3"></i>
                        Pertanyaan tidak lagi dipresentasikan
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
        </div>

        <!-- Pertanyaan2 -->
        <div class="container pt-4 px-0">
            <div class="d-flex justify-content-between position-relative mb-4">
                <div class="d-flex justify-content-start align-items-center ">
                    <a id="btn-kembali" class="fw-bold text-decoration-none text-black border-0 rounded my-0 p-0 bg-transparent" role="button" href="dashboard_admin.php" onclick="return confirm('Apakah anda yakin ingin keluar ?')">
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>
                <div class=" align-items-center text-center position-absolute top-50 start-50 translate-middle">
                    <p id="event-name" class="fw-bold mb-0"></p>
                    <h6 id="date-time" class="mb-0"></h6>
                </div>
                <div class="d-flex justify-content-start align-items-center">
                    <button id="btn-catatan" class="btn btn-sm me-3 my-0 p-2 px-3 rounded bg-opacity-10 me-2 fw-semibold" title="Lihat Daftar Catatan" style="background-color: rgba(255,102,65,0.1); color:#FF6641">
                        <i class="bi bi-chat-left-dots"></i>
                    </button>
                    <div class="dropdown">
                        <a id="btn-share" class="btn btn-sm dropdown-toggle fw-semibold text-decoration-none rounded my-0 p-2 px-3 bg-opacity-10 me-3" style="background-color: rgba(255,102,65,0.1); color:#FF6641" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-share me-1 small"></i>
                            Bagikan
                        </a>
                        <ul class="dropdown-menu mt-2 shadow">
                            <li>
                                <p class="text-muted small ms-3 my-2">Peserta</p>
                            </li>
                            <li>
                                <a id="btn-user" class="text-black text-decoration-none dropdown-item small py-2" href="../index_user.php?<?php echo $hasil_hash_id ; ?>" target="_blank">
                                    <i class="bi bi-phone me-4"></i>
                                    Buka halaman peserta
                                </a>
                            </li>
                            <li>
                                <a id="btn-copy-link-peserta" class="btn-copy-link text-black text-decoration-none dropdown-item small py-2" href="#">
                                    <i class="bi bi-files me-4"></i>
                                    Salin link halaman peserta
                                </a>
                            </li>
                            <li>
                                <p class="text-muted small ms-3 my-2">Moderator</p>
                            </li>
                            <li>
                                <a id="btn-user" class="text-black text-decoration-none dropdown-item small py-2" href="../moderator/dashboard_moderator.php?<?php echo $hasil_hash_id ; ?>" target="_blank">
                                    <i class="bi bi-person-video3 me-4"></i>
                                    Buka halaman moderator
                                </a>
                            </li>
                            <li>
                                <a id="btn-copy-link-moderator" class="btn-copy-link text-black text-decoration-none dropdown-item small py-2" href="#">
                                    <i class="bi bi-files me-4"></i>
                                    Salin link halaman moderator
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown">
                        <a id="btn-display" class="btn btn-sm dropdown-toggle fw-bold text-decoration-none text-white border-0 rounded my-0 p-2 px-3 bg-opacity-10" style="background-color: #FF6641" data-bs-toggle="dropdown">
                            <i class="bi bi-easel me-1"></i>
                            Presentasi
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mt-2 shadow">
                            <li>
                                <div class="dropdown-item small py-2">
                                    <a id="btn-display-here" class=" text-black text-decoration-none " href="../qna_display.php?<?php echo $hasil_hash_id ; ?>">
                                        <i class="bi bi-fullscreen me-4"></i>
                                        Presentasi pada halaman ini
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown-item small py-2">
                                    <a id="btn-display-newtab" class=" text-black text-decoration-none" href="../qna_display.php?<?php echo $hasil_hash_id ; ?>" target="_blank">
                                        <i class="bi bi-box-arrow-up-right me-4"></i>
                                        Presentasi pada tab baru
                                    </a>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <div class="dropdown-item small py-2">
                                    <div class="form-check form-switch">
                                        <input id="navigasi-presentasi" name="navigasi-presentasi" class="form-check-input me-3" type="checkbox" role="switch" checked>
                                        <label class="form-check-label" for="navigasi-presentasi ">
                                            Navigasi presentasi
                                            <i class="ms-2 bi bi-question-circle" style="font-size: .8em" title="Navigasi untuk menampilkan pertanyaan selanjutnya atau pertanyaan sebelumnya pada halaman presentasi"></i>
                                        </label>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row pt-1" >
                <div class="col-6">
                    <div class="d-flex align-items-center mb-2">
                        <h5 class="fw-bold mb-0" title="Daftar pertanyaan yang perlu di pilih">Semua Pertanyaan </h5>
                        <i class="ms-2 bi bi-question-circle" style="font-size: .8em" title="Daftar pertanyaan yang perlu di pilih"></i>
                        <h6 id="jumlah-pertanyaan" class="ms-auto mb-0"></h6>
                        <h6 id="jumlah-pertanyaan-ditolak-terjawab" class="ms-auto d-none mb-0"></h6>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <input type="text" id="search-pertanyaan" class="form-control border border-1 border-end-0 px-2 rounded-start" placeholder="Cari pertanyaan..." aria-label="Cari pertanyaan..." aria-describedby="search-addon" style="background-color: white;" >
                        <button class="input-group-text border border-1 border-start-0 rounded-end " disabled id="search-addon" style="background-color: white; ">
                            <span id="badge-terbaru" class="me-1 badge bg-primary rounded-pill text-primary bg-opacity-10 d-none" style="height: fit-content; font-size: .8em">Terbaru
                            </span>
                            <span id="badge-terjawab" class="me-1 badge bg-primary rounded-pill text-primary bg-opacity-10 d-none" style="height: fit-content; font-size: .8em">Terjawab
                            </span>
                            <span id="badge-ditolak" class="me-1 badge bg-primary rounded-pill text-primary bg-opacity-10 d-none" style="height: fit-content; font-size: .8em">Ditolak
                            </span>
                            <i class="ms-2 bi bi-search"></i>
                        </button>
                        <div class="dropdown">
                            <button class="input-group-text py-2 border border-1 rounded ms-3" data-bs-toggle="dropdown" id="btn-filter" style="background-color: white; ">
                              <i class="bi bi-filter"></i>
                            </button>
                            <ul class="dropdown-menu shadow">
                                <li>
                                    <p class="text-muted small ms-2 mb-2">Urutkan dari yang</p>
                                </li>
                                <li>
                                    <div class="dropdown-item small">
                                        <input class="form-check-input" type="radio" name="radio-filter" id="radio-terbaru" value="terbaru" >
                                        <label class="form-check-label ms-2"  for="radio-terbaru">
                                            Terbaru
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-item small">
                                        <input class="form-check-input" type="radio" name="radio-filter" id="radio-terlama" value="terlama" checked>
                                        <label class="form-check-label ms-2" for="radio-terlama">
                                              Terlama (Default)
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <p class="text-muted small ms-2 my-2">Filter</p>
                                </li>
                                <li>
                                    <div class="dropdown-item small">
                                        <input class="form-check-input" type="checkbox" name="checkbox-terjawab" id="checkbox-terjawab">
                                        <label class="form-check-label ms-2" for="checkbox-terjawab">
                                            Terjawab
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-item small">
                                        <input class="form-check-input" type="checkbox" name="checkbox-ditolak" id="checkbox-ditolak">
                                        <label class="form-check-label ms-2" for="checkbox-ditolak">
                                            Ditolak
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- semua pertanyaan -->
                    <div class="border border-1 rounded-3 sortable list-pertanyaan" id="container-pesan" style="height: calc(100vh - 210px); overflow-y: overlay;">
                        <?php
                            $i = 0;
                            $last = count($chat_data);

                            foreach($chat_data as $chat)
                            {
                                $str1 = str_split($chat["waktu_pengiriman"], 10);
                                $jam_pesan = str_split($str1[1], 6);

                                if ($chat["id_chat"] == $_GET["id_session"] && ($chat["status"]==0 )){
                                    $nama_peserta = get_nama($chat["id_pengirim"]);
                                    $id = $chat["id_message"];
                                    $huruf_depan = $nama_peserta[0];

                                    $i_x_waktu[$i] = $chat["waktu_pengiriman"];

                                    echo '
                                        <div id="container-pesan-'.$chat["id_message"].'" class="p-3 pesan border-top border-bottom">
                                            <div class="d-flex">
                                                <p id="pesan-'.$chat["id_message"].'" class="mb-0 small isi-pesan flex-grow-1">
                                                    '.$chat["pesan"].'
                                                </p>
                                            </div>
                        
                                            <div class="card-footer bg-transparent">
                                                <div class="d-flex justify-content-between align-items-center mt-3 ">
                                                    <div class="d-flex align-items-center ">
                                                        <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                                            <span>'.$huruf_depan.'</span>
                                                        </button>
                                                        <div id="container-nama-waktu-'.$chat["id_message"].'" class="small align-self-center ms-2">
                                                            <p id="nama-peserta-form-'.$chat["id_pengirim"].'" class="nama text-truncate fw-bold mb-0">'.$nama_peserta.' </p>
                                                            <p id="jam-pesan-i'.$i.'" class="jam text-black-50 small mb-0 ">
                                                                '.$jam_pesan[0].'
                                                            </p>
                                                            <p class="waktu-kirim d-none" id="waktu_pengiriman_i_'. $i .'" >'.$chat["waktu_pengiriman"].'</p>
                                                        </div>
                                                    </div>
                                                    
                                                    <div id="container-btn-'.$chat["id_message"].'">
                                                        <button id="btn-accept-'. $i .'" class="btn btn-accept bg-success bg-opacity-10 border-0 rounded-3 py-1 me-0 text-muted"  title="Setujui pertanyaan"  style="width: 50px;">
                                                            <i class="bi bi-check-lg text-success "></i>
                                                        </button>
                                                        
                                                        <button id="btn-decline-'.$i.'" class="btn btn-decline bg-danger bg-opacity-10 border-0 rounded-3 py-1 me-0 text-muted"  title="Tolak pertanyaan"  style="width: 50px;">
                                                            <i class="bi bi-x-lg text-danger "></i>
                                                        </button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>                                  
                                        ';
                                    $i++;
                                }
                            }
                        ?>
                    </div>

                    <!-- Modal Edit-->
                    <!--<div class="modal fade" id="modal-edit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-edit-label" aria-hidden="true">
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

                    <!-- Pertanyaan terjawab dan ditolak-->
                    <div class="border border-1 rounded-3 sortable list-pertanyaan d-none" id="container-pesan-ditolak-terjawab" style="height: calc(100vh - 210px); overflow-y: overlay;">
                        <?php
                        $k = 0;
                        $last = count($chat_data);

                        foreach($chat_data as $chat)
                        {
                            $str1 = str_split($chat["waktu_pengiriman"], 10);
                            $jam_pesan = str_split($str1[1], 6);

                            if ($chat["id_chat"] == $_GET["id_session"] && ($chat["status"]==2 || $chat["status"]==3)){
                                $nama_peserta = get_nama($chat["id_pengirim"]);
                                $id = $chat["id_message"];
                                $huruf_depan = $nama_peserta[0];

                                $k_x_waktu[$k] = $chat["waktu_pengiriman"];

                                echo '
                                        <div id="container-pesan-ditolak-terjawab-'.$chat["id_message"].'" class="p-3 pesan-ditolak-terjawab border-top border-bottom ">
                                            <div class="d-flex">
                                                <p id="pesan-ditolak-terjawab-'.$chat["id_message"].'" class="mb-0 small isi-pesan flex-grow-1">
                                                    '.$chat["pesan"].'
                                                </p>
                                            </div>
                        
                                            <div class="card-footer bg-transparent">
                                                <div class="d-flex justify-content-between align-items-center mt-3 ">
                                                    <div class="d-flex align-items-center ">
                                                        <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                                            <span>'.$huruf_depan.'</span>
                                                        </button>
                                                        <div id="container-nama-waktu-'.$chat["id_message"].'" class="small align-self-center ms-2">
                                                            <p id="nama-peserta-form-'.$chat["id_pengirim"].'" class="nama text-truncate fw-bold mb-0">'.$nama_peserta.' </p>
                                                            <p id="jam-pesan-k'.$k.'" class="jam text-black-50 small mb-0 ">
                                                                '.$jam_pesan[0].'
                                                            </p>
                                                            <p class="waktu-kirim d-none" id="waktu_pengiriman_k_'. $k .'" >'.$chat["waktu_pengiriman"].'</p>
                                                        </div>
                                                        ';
                                                        if($chat["status"]==2){
                                                            echo '<i class="bi bi-patch-check text-success ms-2 align-self-end" title="Pertanyaan Terjawab"></i>';
                                                        }
                                                        else{
                                                            echo '<i class="bi bi-file-earmark-x text-danger ms-2 align-self-end" title="Pertanyaan Ditolak"></i>';
                                                        }
                                                        echo '
                                                    </div>
                                                    
                                                    <div id="container-btn-'.$chat["id_message"].'">
                                                        <button id="btn-revert-'.$k.'" class="btn btn-revert bg-transparent border-0 rounded-3 py-1 px-1 me-0 text-muted"  title="Batal hapus pertanyaan">
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                        </button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>';
                                $k++;
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="col-6">
                    <div class="d-flex align-items-center mb-2">
                        <h5 class="fw-bold mb-0" title="Daftar pertanyaan yang tertampil di presentasi">
                            Pertanyaan Aktif
                        </h5>
                        <i class="ms-2 bi bi-question-circle" style="font-size: .8em" title="Daftar pertanyaan yang tertampil di presentasi"></i>
                        <span class="ms-2 badge rounded-pill text-bg-danger"><i class="bi bi-circle-fill me-2 blink" style="font-size: 0.8em"></i>Live</span>
                        <h6 id="jumlah-pertanyaan-terpilih" class="ms-auto mb-0"></h6>
                        <h6 id="jumlah-pertanyaan-favorit" class="ms-auto mb-0 d-none"></h6>
                    </div>
                    <div class="input-group input-group-sm mb-3">
                        <input type="text" id="search-pertanyaan-terpilih" class="form-control border border-1 border-end-0 px-2 rounded-start" placeholder="Cari pertanyaan..." aria-label="Cari pertanyaan..." aria-describedby="search-addon-terpilih" style="background-color: white; border-radius: .5rem 0 0 .5rem;">
                        <button class="input-group-text border border-1 border-start-0 rounded-end" disabled id="search-addon-terpilih" style="background-color: white; ">
                            <span id="badge-terbaru-live" class="me-1 badge bg-primary rounded-pill text-primary bg-opacity-10 d-none" style="height: fit-content; font-size: .8em">Terbaru
                            </span>
                            <span id="badge-favorit" class="me-1 badge bg-primary rounded-pill text-primary bg-opacity-10 d-none" style="height: fit-content; font-size: .8em">Favorit
                            </span>
                            <i class="ms-2 bi bi-search"></i>
                        </button>
                        <div class="dropdown">
                            <button class="input-group-text py-2 border border-1 rounded ms-3" data-bs-toggle="dropdown" id="btn-filter-live" style="background-color: white; ">
                                <i class="bi bi-filter"></i>
                            </button>
                            <ul class="dropdown-menu shadow">
                                <li>
                                    <p class="text-muted small ms-2 mb-2">Urutkan dari yang</p>
                                </li>
                                <li>
                                    <div class="dropdown-item small">
                                        <input class="form-check-input" type="radio" name="radio-filter-live" id="radio-terbaru-live" value="terbaru">
                                        <label class="form-check-label ms-2"  for="radio-terbaru-live">
                                            Terbaru
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <div class="dropdown-item small">
                                        <input class="form-check-input" type="radio" name="radio-filter-live" id="radio-terlama-live" value="terlama" checked>
                                        <label class="form-check-label ms-2" for="radio-terlama-live">
                                            Terlama (Default)
                                        </label>
                                    </div>
                                </li>
                                <li>
                                    <p class="text-muted small ms-2 my-2">Filter</p>
                                </li>
                                <li>
                                    <div class="dropdown-item small">
                                        <input class="form-check-input" type="checkbox" name="checkbox-favorit-live" id="checkbox-favorit-live">
                                        <label class="form-check-label ms-2" for="checkbox-favorit-live">
                                            Favorit
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- pesan terpilih-->
                    <div class="border border-1 rounded-3 sortable list-pertanyaan" id="container-pesan-terpilih" style="height: calc(100vh - 210px); overflow-y: overlay;">
                      <?php
                        $j = 0;
                        $last = count($chat_data);
                        foreach($chat_data as $chat){
                            $str1 = str_split($chat["waktu_pengiriman"], 10);
                            $jam_pesan = str_split($str1[1], 6);

                            if ($chat["id_chat"] == $_GET["id_session"] && ($chat["status"]==1 || $chat["status"]==4 || $chat["status"]==5 || $chat["status"]==6)){
                                $nama_peserta = get_nama($chat["id_pengirim"]);
                                $id = $chat["id_message"];
                                $huruf_depan = $nama_peserta[0];
                                $j_x_waktu[$j] = $chat["waktu_pengiriman"];

                                echo '
                                    <div id="container-pesan-'.$chat["id_message"].'" class="p-3 pesan-terpilih ';
                                    if($chat["status"]==5 || $chat["status"]==6){
                                        echo 'border border-2 border-orange';
                                    }
                                    else{
                                        echo 'border-top border-bottom';
                                    }
                                    echo ' " ';
                                    if($chat["status"]==4 || $chat["status"]==6){
                                        echo 'style="background-color:rgba(255,65,123,0.1)"';
                                    }
                                    echo '>
                                        <div class="d-flex">
                                            <p id="pesan-'.$chat["id_message"].'" class="mb-0 small isi-pesan flex-grow-1">'.$chat["pesan"].'
                                            </p>
                                        </div>
                                        ';
                                        /*if($chat["id_note"]!=null){
                                            echo '<p id="note-'.$chat["id_note"].'" class="note mt-2 small text-muted">'.$chat["isi_note"].'</p>';
                                        }*/
                                        echo '                        
                                        <div class="card-footer bg-transparent">
                                            <div class="d-flex justify-content-between align-items-center mt-3 ">
                                                <div class="d-flex align-items-center ">
                                                    <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                                        <span>'.$huruf_depan.'</span>
                                                    </button>
                                                    <div id="container-nama-waktu-'.$chat["id_message"].'" class="small align-self-center ms-2">
                                                        <p id="nama-peserta-form-'.$chat["id_pengirim"].'" class="nama text-truncate fw-bold mb-0">'.$nama_peserta.'</p>
                                                        <p id="jam-pesan-j'.$j.'" class="jam text-black-50 small mb-0 ">'.$jam_pesan[0].'</p>
                                                        
                                                        <p class="waktu-kirim d-none" id="waktu_pengiriman_j_'. $j .'" >'.$chat["waktu_pengiriman"].'</p>
                                                        
                                                    </div>
                                                </div>
                                            
                                                <div id="container-btn-'.$chat["id_message"]. '" class="container-btn">
                                                    <button id="btn-revert-'.$j.'" class="btn btn-revert-terpilih bg-transparent border-0 rounded-3 py-1 px-1 me-0 text-muted"  title="Batal pilih pertanyaan">
                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                                    </button>
                                                    <button id="btn-love-'.$j.'" class="btn btn-love text-danger bg-transparent border-0 rounded-3 py-1 px-1 ms-1"  title="Favoritkan pertanyaan" style="color: #FF417B">
                                                        ';
                                                        if($chat["status"]==4 || $chat["status"]==6){
                                                            echo '<i class="bi bi-heart-fill" ></i>';
                                                        }
                                                        else{
                                                            echo '<i class="bi bi-heart" ></i>';
                                                        }
                                                        echo '
                                                    </button>
                                                    <button id="btn-presentasi-'.$j.'" class="btn btn-presentasi bg-transparent border-0 rounded-3 py-1 px-1 ms-1 bg-opacity-10" style="color: #FF6641" title="Tampilkan di presentasi">
                                                        ';
                                                        if($chat["status"]==5 || $chat["status"]==6){
                                                            echo '<i class="bi bi-easel-fill me-1"></i>';
                                                        }
                                                        else{
                                                            echo '<i class="bi bi-easel me-1"></i>';
                                                        }
                                                        echo '
                                                    </button>                              
                                                    <button id="btn-terjawab-'.$j.'" class="btn btn-terjawab bg-success border-0 rounded-3 py-1 px-3 ms-2"  title="Tandai sebagai terjawab" >
                                                        <i class="bi bi-check-lg text-white"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                $j++;
                            }
                        }
                      ?>
                    </div>

                    <!-- pesan favorit-->
                    <div class="border border-1 rounded-3 sortable list-pertanyaan d-none" id="container-pesan-favorit" style="height: calc(100vh - 210px); overflow-y: overlay;">
                        <?php
                        $l = 0;
                        $last = count($chat_data);
                        foreach($chat_data as $chat){
                            $str1 = str_split($chat["waktu_pengiriman"], 10);
                            $jam_pesan = str_split($str1[1], 6);

                            if ($chat["id_chat"] == $_GET["id_session"] && ($chat["status"]==4 || $chat["status"]==6)){
                                $nama_peserta = get_nama($chat["id_pengirim"]);
                                $id = $chat["id_message"];
                                $huruf_depan = $nama_peserta[0];
                                $l_x_waktu[$l] = $chat["waktu_pengiriman"];

                                echo '
                                    <div id="container-pesan-favorit-'.$chat["id_message"].'" class="p-3 pesan-favorit ';
                                    if($chat["status"]==6){
                                        echo 'border border-2 border-orange';
                                    }
                                    else{
                                        echo 'border-top border-bottom';
                                    }
                                    echo ' " style="background-color:rgba(255,65,123,0.1)"> 
                                        <div class="d-flex">
                                            <p id="pesan-'.$chat["id_message"].'" class="mb-0 small isi-pesan flex-grow-1">'.$chat["pesan"].'
                                            </p>
                                        </div>
                        
                                        <div class="card-footer bg-transparent">
                                            <div class="d-flex justify-content-between align-items-center mt-3 ">
                                                <div class="d-flex align-items-center ">
                                                    <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                                        <span>'.$huruf_depan.'</span>
                                                    </button>
                                                    <div id="container-nama-waktu-'.$chat["id_message"].'" class="small align-self-center ms-2">
                                                        <p id="nama-peserta-form-'.$chat["id_pengirim"].'" class="nama text-truncate fw-bold mb-0">'.$nama_peserta.'</p>
                                                        <p id="jam-pesan-l'.$l.'" class="jam text-black-50 small mb-0 ">'.$jam_pesan[0].'</p>
                                                        
                                                        <p class="waktu-kirim d-none" id="waktu_pengiriman_l_'. $l .'" >'.$chat["waktu_pengiriman"].'</p>
                                                        
                                                    </div>
                                                </div>
                                            
                                                <div id="container-btn-'.$chat["id_message"]. '" class="container-btn">
                                                    <button id="btn-revert-'.$l.'" class="btn btn-revert-terpilih bg-transparent border-0 rounded-3 py-1 px-1 me-0 text-muted"  title="Batal pilih pertanyaan">
                                                        <i class="bi bi-arrow-counterclockwise"></i>
                                                    </button>
                                                    <button id="btn-love-'.$l.'" class="btn btn-love text-danger bg-transparent border-0 rounded-3 py-1 px-1 ms-1"  title="Favoritkan pertanyaan" style="color: #FF417B">
                                                        <i class="bi bi-heart-fill" ></i>
                                                    </button>
                                                    <button id="btn-presentasi-'.$j.'" class="btn btn-presentasi bg-transparent border-0 rounded-3 py-1 px-1 ms-1 bg-opacity-10" style="color: #FF6641" title="Tampilkan di presentasi">
                                                        ';
                                                        if($chat["status"]==6){
                                                            echo '<i class="bi bi-easel-fill me-1"></i>';
                                                        }
                                                        else{
                                                            echo '<i class="bi bi-easel me-1"></i>';
                                                        }
                                                        echo '
                                                    </button> 
                                                    <button id="btn-terjawab-'.$l.'" class="btn btn-terjawab bg-success border-0 rounded-3 py-1 px-3 ms-1"  title="Tandai sebagai terjawab" >
                                                        <i class="bi bi-check-lg text-white"></i>
                                                    </button>                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                                $l++;
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Modal Catatan-->
            <div class="modal fade" id="modal-catatan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-catatan-label" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content p-4">
                        <div class="modal-header border-0 position-relative">
                            <h5 class="modal-title fw-bold text-center position-absolute top-50 start-50 translate-middle" id="staticBackdropLabel">Catatan Kepada Moderator</h5>
                            <button id="btn-cancel-catatan" class="btn btn-close border-0 rounded-3 py-2 px-3 me-0 text-muted fw-semibold "  title="Batalkan perubahan" style="font-size: .875em"></button>
                        </div>
                        <div class="modal-body row">
                            <div class="col-6">
                                <p class="mb-2">Daftar Catatan</p>
                                <div class="border border-1 rounded-3 list-pesan-note" id="container-pesan-note" style="height: calc(100vh - 270px); overflow-y: overlay;">

                                </div>
                            </div>
                            <div class="col-6 ">
                                <label for="input-note" class="mb-2">Pesan</label>
                                <div class="position-relative">
                                    <textarea id="input-note" type="text" class="form-control border border-1 py-2 px-3 rounded-start" style="height:200px;font-size: .875em;resize: none" maxlength="400" required></textarea>
                                    <span id="char-counter-note" class="mb-2 me-3 small text-mute position-absolute bottom-0 end-0" style="font-size: 12px">400</span>
                                </div>
                                <button id="btn-kirim" class="btn btn-kirim border-0 rounded-3 py-2 px-3 float-end mt-3 text-white fw-bold"  title="Kirim catatan"  style="background-color: #FF6641;font-size: .875em" disabled>
                                    Kirim
                                </button>
                                <button id="timer-kirim" class="btn timer-kirim border-0 rounded-3 py-2 px-3 float-end mt-3 text-white fw-bold" disabled title="Harap menunggu"  style="background-color: #FF6641;display:none;  font-size: .875em">
                                    <span  class=" spinner-border spinner-border-sm border-3 small" ></span>
                                    <span class="fw-normal ms-2"> Tunggu...</span>
                                </button>
                            </div>
                        </div>
                    </div>
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
                        <p class="small text-muted">Pesan Anda akan dihapus dari daftar pesan admin. Setelah dihapus, Anda <b>tidak dapat</b> mengembalikannya.</p>
                    </div>
                    <div class="modal-footer border-0 pt-0 px-3 justify-content-between">
                        <button id="btn-confirm" type="submit" class="btn btn-confirm border-0 rounded-3 py-2 ms-0 me-0 text-white fw-bold btn-danger flex-fill"  title="Simpan perubahan"  style="font-size: .875em">
                            Hapus
                        </button>
                        <button id="timer-confirm" class="btn-confirm border-0 rounded-3 py-2 me-0 ms-0 text-white fw-bold bg-danger bg-opacity-50 flex-fill" disabled title="Harap menunggu"  style="display:none;">
                            <div  class=" spinner-border spinner-border-sm border-3 small" style="--bs-spinner-width: 0.8rem;--bs-spinner-height: 0.8rem;"></div>
                            <span class="fw-normal small ms-2"> Tunggu...</span>
                        </button>

                        <button id="btn-cancel-delete" type="reset" class="btn btn-cancel border border-1 rounded-3 py-2 px-3 me-0 ms-3 text-muted fw-semibold flex-fill"  title="Batalkan hapus sesi" style="font-size: .875em">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <?php
            echo "<input type='hidden' name='login_id_sesi' id='login_id_sesi' value='".$_GET["id_session"]."'/>";
            echo "<input type='hidden' name='login_id_admin' id='login_id_admin' value='".$_SESSION['id_admin']."'/>";
        ?>

        <script>
            moment.locale('id'); //set timezone to Indonesia
            console.log(moment(Date.now()).fromNow());
            console.log(moment().format('LT'))
            console.log(moment('2022-07-01 15:25:05').fromNow())

            /* Keterangan Status */
            // 0 = belum di accept/ditolak
            // 1 = sudah di acc
            // 2 = sudah dijawab
            // 3 = ditolak
            // 4 = favorit
            // 5 = dipresentasikan
            // 6 = favorit + dipresentasikan
            // 99 = dihapus
        </script>

        <!-- fungsi note-->
        <script>
            let n = 0;
            let n_x_waktu = [];
            function get_note() {
                $.ajax({
                    url: '../get_pesan_admin.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data1, textStatus, xhr) {
                        let list_data = ''
                        console.log(data1)
                        let sesi_id = $('#login_id_sesi').val();
                        let admin_id = $('#login_id_admin').val();

                        for (let i=0;i<data1.length;i++) {
                            console.log(data1[i].is_deleted == 0)
                            if( data1[i].id_event == sesi_id && data1[i].is_deleted == 0 && data1[i].id_admin == admin_id)
                            {
                                console.log(data1[i])
                                list_data =
                                    `
                                     <div id="container-pesan-note-${data1[i].id_pesan}" class="p-3 note border-top border-bottom">
                                        <div class="d-flex">
                                            <p id="note-${data1[i].id_pesan}" class="mb-0 small isi-note flex-grow-1">
                                                ${data1[i].isi_pesan}
                                            </p>
                                        </div>

                                        <div class="card-footer bg-transparent">
                                            <div class="d-flex justify-content-between align-items-center mt-3 ">
                                                <div class="d-flex align-items-center ">
                                                    <div id="container-nama-waktu-note" class="small align-self-center">
                                                        <p id="jam-note-n${n}" class="jam-note text-black-50 small mb-0 ">${moment(data1[i].date).fromNow()}</p>
                                                        <p class="waktu-kirim d-none" id="waktu_pengiriman_n_${n}">${data1[i].date}</p>
                                                    </div>
                                                </div>

                                                <div id="container-btn-note-${data1[i].id_pesan}">
                                                    <button id="btn-delete-note-${data1[i].id_pesan}" class="btn btn-delete-note bg-danger bg-opacity-10 border-0 rounded-3 py-1 px-3 me-0 text-muted" title="Hapus pesan">
                                                        <i class="bi bi-trash3 text-danger "></i>
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    `

                                $('#container-pesan-note').append(list_data);
                                n_x_waktu.push(data1[i].date);
                                n=n+1
                            }
                        }


                    },
                    complete: function (data) {
                    },
                    error: function(data, textStatus, xhr){
                        console.log(xhr)
                    }
                })
            }
            get_note()

            $("body").on("click", "#btn-catatan", function() {
                $('#modal-catatan').modal('show');

                let maxChar = 400
                let count = 0
                let remaining = 0

                $("#input-note").on('keyup', function(e) {
                    count = $("#input-note").val().length
                    remaining = maxChar - count
                    $("#char-counter-note").text(remaining)

                    if($('#input-note').val() !== ''){
                        $('#btn-kirim').removeAttr('disabled')
                    }
                    else{
                        $('#btn-kirim').attr('disabled','true')
                    }
                });
            })
            // fungsi kirim pesan
            $("body").on("click", "#btn-kirim", function() {
                // get message
                let isi_pesan = $.trim($('#input-note').val())

                console.log(isi_pesan)

                $.ajax({
                    url: "../insert_pesan_admin.php",
                    type: "POST",
                    cache: false,
                    data:{
                        isi_pesan: isi_pesan,
                        id_event : $('#login_id_sesi').val(),
                        id_admin : $('#login_id_admin').val(),
                    },
                    success: function(dataResult){
                        console.log(this.data)
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode===200){
                            console.log('Data updated successfully ! '+dataResult.id);
                            let elements=
                                `
                                <div id="container-pesan-note-${dataResult.id}" class="p-3 note border-top border-bottom">
                                    <div class="d-flex">
                                        <p id="note-${dataResult.id}" class="mb-0 small isi-note flex-grow-1">
                                            ${escapeHtml(isi_pesan)}
                                        </p>
                                    </div>

                                    <div class="card-footer bg-transparent">
                                        <div class="d-flex justify-content-between align-items-center mt-3 ">
                                            <div class="d-flex align-items-center ">
                                                <div id="container-nama-waktu-note" class="small align-self-center">
                                                    <p id="jam-note-n${n}" class="jam-note text-black-50 small mb-0 ">${moment().fromNow()}</p>
                                                    <p class="waktu-kirim d-none" id="waktu_pengiriman_n_${n}">${moment().format('YYYY-MM-DD HH:mm:ss')}</p>
                                                </div>
                                            </div>

                                            <div id="container-btn-note-${dataResult.id}">
                                                <button id="btn-delete-note-${dataResult.id}" class="btn btn-delete-note bg-danger bg-opacity-10 border-0 rounded-3 py-1 px-3 me-0 text-muted" title="Hapus pesan">
                                                    <i class="bi bi-trash3 text-danger "></i>
                                                </button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                `

                            $("#container-pesan-note").append(elements);
                            n_x_waktu.push(moment().format('YYYY-MM-DD HH:mm:ss'));
                            n=n+1

                            // Proses Pengiriman Pesan   TERAKHIR NGEDIT INI YAAA
                            let id_sesi = $('#login_id_sesi').val();
                            let data = {
                                asal: 'admin-note',
                                mId: dataResult.id,
                                msg: isi_pesan,
                                sesiId: id_sesi,
                                date: moment().format('YYYY-MM-DD HH:mm:ss'),
                            };
                            conn.send(JSON.stringify(data));
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    }
                });

                $("#timer-kirim").show();
                $("#btn-kirim").hide();
                $('#input-note').val('')
                // $('#toast-create').show()
                setTimeout(function () {
                    $("#timer-kirim").hide();
                    $("#btn-kirim").show();

                    // $('#toast-create').hide()
                }, 3000)

            })

            // button delete
            $("body").on("click", ".btn-delete-note", function() {
                let id_button = ''
                let id_numb = ''
                let idm = ''
                // get id event
                id_button = $(this).attr('id')
                id_numb = id_button.split("-")
                idm = id_numb[3]
                console.log(id_button)

                // let cust_message = $.trim($('#container-pesan-'+idm).children('.pertanyaan').text());
                // console.log(cust_message)
                $('#modal-delete').modal('show');
                $('#modal-catatan').modal('hide');

                $("body").on("click", "#btn-cancel-delete", function() {
                    $('#modal-delete').modal('hide');
                    $('#modal-catatan').modal('show');
                    id_button = ''
                    id_numb = ''
                    idm = ''
                })

                $("body").on("click", "#btn-confirm", function() {
                    $.ajax({
                        url: "../delete_pesan_admin.php",
                        type: 'POST',
                        cache: false,
                        dataType: 'json',
                        data: {
                            id_pesan_admin: idm,
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

                                $('#container-pesan-note-'+idm).remove()
                                $('#modal-delete').modal('hide');
                                $('#modal-catatan').modal('show');
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
                                asal: 'admin-note-delete',
                                sesiId: id_sesi,
                                msg: idm,
                                date: moment().format('YYYY-MM-DD HH:mm:ss'),
                            };
                            conn.send(JSON.stringify(dataWebsocket));
                        }
                    })
                })
            })

            // fungsi cancel note
            $("body").on("click", "#btn-cancel-catatan", function() {
                $('#input-note').val('')
                $('#modal-catatan').modal('hide');
            })

        </script>

        <!-- fungsi copy-->
        <script>
            $("body").on("click", ".btn-copy-link", function() {
                let pathname = window.location.pathname; // Returns path only (/path/example.html)
                let url      = window.location.href;     // Returns full URL (https://example.com/path/example.html)
                let origin   = window.location.origin;   // Returns base URL (https://example.com)
                let pathname_arr = pathname.split('/')
                console.log(pathname_arr)

                /* Get the text field */
                let copyText = '';
                console.log($(this).attr('id'))
                if($(this).attr('id') === 'btn-copy-link-moderator'){
                    copyText = '/moderator/dashboard_moderator.php?<?php echo $hasil_hash_id; ?>';
                }
                else if($(this).attr('id') === 'btn-copy-link-peserta') {
                    copyText = '/index_user.php?<?php echo $hasil_hash_id; ?>';
                }
                /* Copy the text inside the text field */
                navigator.clipboard.writeText(origin + "/" + pathname_arr[1] + copyText);

                $('#toast-copy').show()
                setTimeout(function () {
                    $('#toast-copy').hide()
                }, 3000)
            })
        </script>

        <!-- fungsi on/off navigasi presentasi-->
        <script>
            let navigasi = 'on';
            $('input:checkbox[name="navigasi-presentasi"]').change(function() {
                if ($(this).is(":checked") === true) {
                    console.log('true Check')
                    navigasi = 'on';
                    console.log(navigasi)
                } else {
                    navigasi = 'off';
                    console.log(navigasi)
                }
                // Proses Pengiriman Pesan
                let id_sesi = $('#login_id_sesi').val();
                let data = {
                    asal: 'admin-navigasi',
                    sesiId: id_sesi,
                    msg: navigasi,
                    date: moment().format('YYYY-MM-DD HH:mm:ss'),
                };
                conn.send(JSON.stringify(data));
            });
        </script>

        <!-- fungsi ganti background letter avatar-->
        <script>
            let warna = ["#1abc9c", "#2ecc71", "#3498db", "#9b59b6",
                "#34495e", "#16a085", "#27ae60", "#2980b9",
                "#8e44ad", "#2c3e50", "#f1c40f",
                "#e67e22", "#e74c3c", "#ecf0f1",
                "#95a5a6", "#f39c12", "#d35400", "#c0392b",
                "#bdc3c7", "#7f8c8d"];

            let warna2 = ["rgba(26,188,156,0.1)", "rgba(46,204,113,0.1)", "rgba(52,152,219,0.1)", "rgba(155,89,182,0.1)", "rgba(52,73,94,0.1)", "rgba(22,160,133,0.1)", "rgba(39,174,96,0.1)", "rgba(41,128,185,0.1)", "rgba(142,68,173,0.1)", "rgba(44,62,80,0.1)", "rgba(241,196,15,0.1)", "rgba(230,126,34,0.1)", "rgba(231,76,60,0.1)", "rgba(236,240,241,0.1)", "rgba(149,165,166,0.1)", "rgba(243,156,18,0.1)", "rgba(211,84,0,0.1)", "rgba(192,57,43,0.1)", "rgba(189,195,199,0.1)", "rgba(127,140,141,0.1)"];

            function ubahWarnaAvatar() {
                $(".avatar").removeClass('bg-primary');
                $(".avatar").removeClass('text-white');

                $(".avatar").siblings().children('.nama:contains("Anonim")').parent().siblings().children().html('<i class="bi bi-person"></i>')
                $(".avatar").siblings().children('.nama:contains("Anonim")').parent().siblings().css({"background-color": '#f0f1f2'});
                $(".avatar").siblings().children('.nama:contains("Anonim")').parent().siblings().children().css({"color": '#1b1b1b'});

                $(".avatar>span:contains('Q'), .avatar>span:contains('W'), .avatar>span:contains('N'), .avatar>span:contains('M'), .avatar>span:contains('1'), .avatar>span:contains('2'), .avatar>span:contains('n'), .avatar>span:contains('m')").parent().css({"background-color": warna2[0], "color": warna[0]});
                $(".avatar>span:contains('E'), .avatar>span:contains('R'), .avatar>span:contains('e'), .avatar>span:contains('r')").parent().css({"background-color": warna2[1], "color": warna[1]});
                $(".avatar>span:contains('T'), .avatar>span:contains('Y'), .avatar>span:contains('t'), .avatar>span:contains('y')").parent().css({"background-color": warna2[2], "color": warna[2]});
                $(".avatar>span:contains('U'), .avatar>span:contains('I'), .avatar>span:contains('u'), .avatar>span:contains('i')").parent().css({"background-color": warna2[3], "color": warna[3]});
                $(".avatar>span:contains('O'), .avatar>span:contains('P'), .avatar>span:contains('o'), .avatar>span:contains('p')").parent().css({"background-color": warna2[4], "color": warna[4]});
                $(".avatar>span:contains('D'), .avatar>span:contains('F'), .avatar>span:contains('V'), .avatar>span:contains('B'), .avatar>span:contains('d'), .avatar>span:contains('f'), .avatar>span:contains('v'), .avatar>span:contains('b')").parent().css({"background-color": warna2[7], "color": warna[7]});
                $(".avatar>span:contains('G'), .avatar>span:contains('H'), .avatar>span:contains('g'), .avatar>span:contains('h')").parent().css({"background-color": warna2[16], "color": warna[16]});
                $(".avatar>span:contains('J'), .avatar>span:contains('K'), .avatar>span:contains('j'), .avatar>span:contains('k')").parent().css({"background-color": warna2[8], "color": warna[8]});
                $(".avatar>span:contains('L'), .avatar>span:contains('Z'), .avatar>span:contains('l'), .avatar>span:contains('z')").parent().css({"background-color": warna2[12], "color": warna[12]});
                $(".avatar>span:contains('X'), .avatar>span:contains('C'), .avatar>span:contains('A'), .avatar>span:contains('S'), .avatar>span:contains('x'), .avatar>span:contains('c'), .avatar>span:contains('a'), .avatar>span:contains('s')").parent().css({"background-color": warna2[11], "color": warna[11]});

                // $(".avatar>span:contains('Q'), .avatar>span:contains('W'), .avatar>span:contains('N'), .avatar>span:contains('M')").parent().css({"background-color": '#1abc9c'});
                // $(".avatar > span:contains('E'), .avatar > span:contains('R')").parent().css({"background-color": '#2ecc71'});
                // $(".avatar > span:contains('T'), .avatar > span:contains('Y')").parent().css({"background-color": '#3498db'});
                // $(".avatar>span:contains('U'), .avatar>span:contains('I')").parent().css({"background-color": '#9b59b6'});
                // $(".avatar > span:contains('O'), .avatar > span:contains('P')").parent().css({"background-color": '#34495e'});
                // $(".avatar>span:contains('D'), .avatar>span:contains('F'), .avatar > span:contains('V'), .avatar > span:contains('B')").parent().css({"background-color": '#2980b9'});
                // $(".avatar > span:contains('G'), .avatar > span:contains('H')").parent().css({"background-color": '#8e44ad'});
                // $(".avatar > span:contains('J'), .avatar > span:contains('K')").parent().css({"background-color": '#f1c40f'});
                // $(".avatar>span:contains('L'), .avatar>span:contains('Z')").parent().css({"background-color": '#e67e22'});
                // $(".avatar > span:contains('X'), .avatar > span:contains('C'), .avatar > span:contains('A'), .avatar > span:contains('S')").parent().css({"background-color": '#e74c3c'});
            }
            $(document).ready(function() {
                ubahWarnaAvatar();
            })
        </script>

        <!-- fungsi close toast-->
        <script>
            $("body").on("click", '.btn-close-toast', function() {
                let element = $(this).parent().parent().attr('id')
                $('#'+element).hide()
            })
        </script>

        <!-- function olah tanggal -->
        <script>
            setInterval(function() {
                setFormatJam()
                console.log("formatted")
            }, 60 * 500);

            var jam_i = <?php echo json_encode($i_x_waktu); ?>;
            var jam_j = <?php echo json_encode($j_x_waktu); ?>;
            var jam_k = <?php echo json_encode($k_x_waktu); ?>;
            var jam_l = <?php echo json_encode($l_x_waktu); ?>;
            let jam_n = n_x_waktu;

            function setFormatJam() {
                console.log(jam_n)
                for(let i=0; i<jam_i.length; i++){
                    let status_jam_i = moment(jam_i[i]).fromNow();
                    $("#jam-pesan-i"+i).text(status_jam_i)
                }
                for(let j=0; j<jam_j.length; j++){
                    let status_jam_j = moment(jam_j[j]).fromNow();
                    $("#jam-pesan-j"+j).text(status_jam_j)
                }
                for(let k=0; k<jam_k.length; k++){
                    let status_jam_k = moment(jam_k[k]).fromNow();
                    $("#jam-pesan-k"+k).text(status_jam_k)
                }
                for(let l=0; l<jam_l.length; l++){
                    let status_jam_l = moment(jam_l[l]).fromNow();
                    $("#jam-pesan-l"+l).text(status_jam_l)
                }
                for(let n=0; n<jam_n.length; n++){
                    let status_jam_n = moment(jam_n[n]).fromNow();
                    $("#jam-note-n"+n).text(status_jam_n)
                }
            }
            setFormatJam()
        </script>

        <!-- filtering -->
        <script>
            // fungsi sort tanggal dari lama -> baru
            function sortTerlama(a, b) {
                let date1 = $(a).find(".waktu-kirim").text()

                date1 = date1.replaceAll(':', '-').replaceAll(' ', '-')
                date1 = date1.split('-')
                date1 = new Date(date1[0], date1[1]-1, date1[2], date1[3], date1[4], date1[5])

                let date2 = $(b).find(".waktu-kirim").text()

                date2 = date2.replaceAll(':', '-').replaceAll(' ', '-')
                date2 = date2.split('-')
                date2 = new Date(date2[0], date2[1]-1, date2[2], date2[3], date2[4], date2[5])

                return date1 - date2;
            }

            // fungsi sort tanggal dari baru -> lama
            function sortTerbaru(a, b) {
                let date1 = $(a).find(".waktu-kirim").text()
                console.log(date1)
                date1 = date1.replaceAll(':', '-').replaceAll(' ', '-')
                date1 = date1.split('-')
                date1 = new Date(date1[0], date1[1]-1, date1[2], date1[3], date1[4], date1[5])

                let date2 = $(b).find(".waktu-kirim").text()
                date2 = date2.replaceAll(':', '-').replaceAll(' ', '-')
                date2 = date2.split('-')
                date2 = new Date(date2[0], date2[1]-1, date2[2], date2[3], date2[4], date2[5])

                return date2 - date1;
            }

            //fungsi dijalankan supaya filter terbaru menjadi default
            $('#container-pesan .pesan').sort(sortTerlama).appendTo('#container-pesan')

            //fungsi dijalankan supaya filter terbaru menjadi default (live)
            $('#container-pesan-terpilih .pesan-terpilih').sort(sortTerlama).appendTo('#container-pesan-terpilih')

            //fungsi filter terbaru (semua)
            $('input:radio[name="radio-filter"]').change(function() {
                console.log($(this).val())
                if ($(this).val() === 'terbaru') {
                    $('#container-pesan .pesan').sort(sortTerbaru).appendTo('#container-pesan')
                    // show badge
                    $('#badge-terbaru').removeClass('d-none')
                } else {
                    $('#container-pesan .pesan').sort(sortTerlama).appendTo('#container-pesan')
                    // show badge
                    $('#badge-terbaru').addClass('d-none')
                }
            });

            //fungsi filter terbaru (live)
            $('input:radio[name="radio-filter-live"]').change(function() {
                console.log($(this).val())
                if ($(this).val() === 'terbaru') {
                    $('#container-pesan-terpilih .pesan-terpilih').sort(sortTerbaru).appendTo('#container-pesan-terpilih')
                    // show badge
                    $('#badge-terbaru-live').removeClass('d-none')
                } else {
                    $('#container-pesan-terpilih .pesan-terpilih').sort(sortTerlama).appendTo('#container-pesan-terpilih')
                    // hide badge
                    $('#badge-terbaru-live').addClass('d-none')
                }
            });

            // fungsi filter TERJAWAB
            $('input:checkbox[name="checkbox-terjawab"]').change(function() {
                if ($(this).is(":checked") === true) {
                    console.log('true terjawab 1')
                    // show pertanyaan ditolak terjawab - hide pertanyaan all
                    $('#container-pesan-ditolak-terjawab').removeClass('d-none')
                    $('#container-pesan').addClass('d-none')
                    $('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').find('.bi-patch-check').parent().parent().parent().parent().show() //show yang terjawab

                    // show jumlah pertanyaan ditolak terjawab - hide jumlah pertanyaan all
                    $('#jumlah-pertanyaan-ditolak-terjawab').removeClass('d-none')
                    $('#jumlah-pertanyaan').addClass('d-none')

                    if ($('input:checkbox[name="checkbox-ditolak"]').is(":checked") === true) {
                        $('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').find('.bi-file-earmark-x').parent().parent().parent().parent().show() //show yang ditolak
                        // hitung semua pertanyaan
                        $('#jumlah-pertanyaan-ditolak-terjawab').text("Jumlah : " +$('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').length)
                        console.log('true terjawab 21')
                    }
                    else{
                        $('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').find('.bi-file-earmark-x').parent().parent().parent().parent().hide() //hide yang ditolak
                        // hitung ulang pertanyaan yang punya icon terjawab
                        $('#jumlah-pertanyaan-ditolak-terjawab').text("Jumlah : " +$('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').find('.bi-patch-check').length)
                        console.log('true terjawab 22')
                    }

                    // show badge
                    $('#badge-terjawab').removeClass('d-none')
                    // reset search
                    $("#search-pertanyaan").val('')
                } else {
                    console.log('else')
                    if ($('input:checkbox[name="checkbox-ditolak"]').is(":checked") === false) {
                        // show pertanyaan all - hide pertanyaan ditolak terjawab
                        $('#container-pesan-ditolak-terjawab').addClass('d-none')
                        $('#container-pesan').removeClass('d-none')
                        // show jumlah pertanyaan ditolak terjawab - hide jumlah pertanyaan all
                        $('#jumlah-pertanyaan-ditolak-terjawab').addClass('d-none')
                        $('#jumlah-pertanyaan').removeClass('d-none')
                        // reset search
                        $("#search-pertanyaan").val('')
                        console.log('else 1')
                    }
                    else{
                        $('#jumlah-pertanyaan-ditolak-terjawab').text("Jumlah : " +$('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').find('.bi-file-earmark-x').length)
                        $('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').find('.bi-file-earmark-x').parent().parent().parent().parent().show() //show yang ditolak
                        console.log('else 2')
                    }
                    //hide yang terjawab
                    $('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').find('.bi-patch-check').parent().parent().parent().parent().hide()
                    // hide badge
                    $('#badge-terjawab').addClass('d-none')
                }
            });
            // fungsi filter DITOLAK
            $('input:checkbox[name="checkbox-ditolak"]').change(function() {
                if ($(this).is(":checked") === true) {
                    console.log('true ditolak 1')
                    // show pertanyaan ditolak terjawab - hide pertanyaan all
                    $('#container-pesan-ditolak-terjawab').removeClass('d-none')
                    $('#container-pesan').addClass('d-none')
                    $('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').find('.bi-file-earmark-x').parent().parent().parent().parent().show() //show yang ditolak

                    // show jumlah pertanyaan ditolak terjawab - hide jumlah pertanyaan all
                    $('#jumlah-pertanyaan-ditolak-terjawab').removeClass('d-none')
                    $('#jumlah-pertanyaan').addClass('d-none')

                    if ($('input:checkbox[name="checkbox-terjawab"]').is(":checked") === true) {
                        $('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').find('.bi-patch-check').parent().parent().parent().parent().show() //show yang terjawab
                        // hitung semua pertanyaan
                        $('#jumlah-pertanyaan-ditolak-terjawab').text("Jumlah : " +$('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').length)
                        console.log('true ditolak 21')
                    }
                    else{
                        $('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').find('.bi-patch-check').parent().parent().parent().parent().hide() //hide yang terjawab
                        // hitung ulang pertanyaan yang punya icon ditolak
                        $('#jumlah-pertanyaan-ditolak-terjawab').text("Jumlah : " +$('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').find('.bi-file-earmark-x').length)
                        console.log('true ditolak 22')
                    }

                    // show badge
                    $('#badge-ditolak').removeClass('d-none')
                    // reset search
                    $("#search-pertanyaan").val('')
                } else {
                    console.log('else')
                    if ($('input:checkbox[name="checkbox-terjawab"]').is(":checked") === false) {
                        // show pertanyaan all - hide pertanyaan ditolak terjawab
                        $('#container-pesan-ditolak-terjawab').addClass('d-none')
                        $('#container-pesan').removeClass('d-none')
                        // show jumlah pertanyaan ditolak terjawab - hide jumlah pertanyaan all
                        $('#jumlah-pertanyaan-ditolak-terjawab').addClass('d-none')
                        $('#jumlah-pertanyaan').removeClass('d-none')
                        // reset search
                        $("#search-pertanyaan").val('')
                        console.log('else 1')
                    }
                    else{
                        $('#jumlah-pertanyaan-ditolak-terjawab').text("Jumlah : " +$('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').find('.bi-patch-check').length)
                        $('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').find('.bi-patch-check').parent().parent().parent().parent().show() //show yang terjawab
                        console.log('else 2')
                    }
                    //hide yang ditolak
                    $('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').find('.bi-file-earmark-x').parent().parent().parent().parent().hide()
                    // hide badge
                    $('#badge-ditolak').addClass('d-none')
                }
            });

            // fungsi filter favorit
            $('input:checkbox[name="checkbox-favorit-live"]').change(function() {
                if ($(this).is(":checked") === true) {
                    console.log('true Check')
                    // show pertanyaan ditolak terjawab - hide pertanyaan all
                    $('#container-pesan-favorit').removeClass('d-none')
                    $('#container-pesan-terpilih').addClass('d-none')
                    // show jumlah pertanyaan ditolak terjawab - hide jumlah pertanyaan all
                    $('#jumlah-pertanyaan-favorit').removeClass('d-none')
                    $('#jumlah-pertanyaan-terpilih').addClass('d-none')
                    // show badge
                    $('#badge-favorit').removeClass('d-none')
                    // reset search
                    $("#search-pertanyaan-terpilih").val('')
                }
                else {
                    console.log('else')
                    // show pertanyaan all - hide pertanyaan ditolak terjawab
                    $('#container-pesan-favorit').addClass('d-none')
                    $('#container-pesan-terpilih').removeClass('d-none')
                    // show jumlah pertanyaan ditolak terjawab - hide jumlah pertanyaan all
                    $('#jumlah-pertanyaan-favorit').addClass('d-none')
                    $('#jumlah-pertanyaan-terpilih').removeClass('d-none')
                    // hide badge
                    $('#badge-favorit').addClass('d-none')
                    // reset search
                    $("#search-pertanyaan-terpilih").val('')
                }
            });
        </script>

        <!--    counter jumlah pertanyaan-->
        <script>
            function counter() {
                $('#jumlah-pertanyaan').text("Jumlah : " + $('#container-pesan .pesan').length)
                $('#jumlah-pertanyaan-terpilih').text("Jumlah : " +$('#container-pesan-terpilih .pesan-terpilih').length)
                $('#jumlah-pertanyaan-ditolak-terjawab').text("Jumlah : " +$('#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab').length)
                $('#jumlah-pertanyaan-favorit').text("Jumlah : " +$('#container-pesan-favorit .pesan-favorit').length)
            }
            counter()
        </script>
        <script>
            function charCounter() {
                let maxChar = 200
                let count = $("#input-edit").val().length
                let remaining = maxChar - count

                $("#char-counter").text(remaining)
            }

            // function char counter dinamis
            $("#input-edit").on('keyup', function(e) {
                charCounter()
            });
        </script>

        <!-- tampilin pertanyaan -->
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
            var port = '8082'
            // var conn = new WebSocket('ws://localhost:'+port);
            var conn = new WebSocket('ws://0.tcp.ap.ngrok.io:12834');
            conn.onopen = function(e) {
                console.log("Connection established!");
            };
            let i= <?php echo $i; ?>;
            $(document).ready(function(){
                conn.onmessage = function(e) {
                    console.log("websocket:" +e.data);

                    var sesi_id1 = $('#login_id_sesi').val();
                    var data1 = JSON.parse(e.data);

                    console.log(data1)

                    if(data1.asal === 'user'){
                        console.log(data1.userId)
                        $.ajax({
                            url: '../get_nama_participant.php',
                            type: 'POST',
                            data: {
                                id_participant: data1.userId,
                            },
                            success: function(data, textStatus, xhr) {
                                let list_data = ''
                                let dataResult = JSON.parse(data)
                                let nama = dataResult.nama
                                // let nama_temp = nama.replaceAll(' ', '-')
                                // nama_temp = nama.split("-")
                                let nama_depan = nama.charAt(0)
                                // var nama = data.customer_name
                                // let nama_depan = Array.from(nama)[0]

                                if( data1.sesiId === sesi_id1 )
                                {
                                    list_data =
                                    `<div id="container-pesan-${data1.mId}" class="p-3 pesan border-top border-bottom">
                                        <div class="d-flex">
                                            <p id="pesan-${data1.mId}" class="mb-0 small isi-pesan flex-grow-1">${escapeHtml(data1.msg)}</p>
                                        </div>

                                        <div class="card-footer bg-transparent">
                                            <div class="d-flex justify-content-between align-items-center mt-3 ">
                                                <div class="d-flex align-items-center ">
                                                    <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                                        <span>${nama_depan}</span>
                                                    </button>
                                                    <div id="container-nama-waktu-${data1.mId}" class="small align-self-center ms-2">
                                                        <p id="nama-peserta-form-${data1.userId}" class="nama text-truncate fw-bold mb-0">${nama}</p>
                                                        <p id="jam-pesan-i${i}" class="jam text-black-50 small mb-0 ">${moment(data1.date).fromNow()}</p>
                                                        <p class="waktu-kirim d-none" id="waktu_pengiriman_i_${i}">${data1.date}</p>
                                                    </div>
                                                </div>
                                                <div id="container-btn-${data1.mId}">
                                                    <button id="btn-accept-${i}" class="btn btn-accept bg-success  bg-opacity-10 border-0 rounded-3 py-1 me-0 text-muted" title="Setujui pertanyaan"  style="width: 50px;">
                                                        <i class="bi bi-check-lg text-success "></i>
                                                    </button>
                                                    <button id="btn-decline-${i}" class="btn btn-decline bg-danger bg-opacity-10 border-0 rounded-3 py-1 me-0 text-muted"  title="Tolak pertanyaan"  style="width: 50px;">
                                                        <i class="bi bi-x-lg text-danger "></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`

                                    $('#container-pesan').append(list_data);
                                    i=i+1
                                }


                            },
                            complete: function (data) {
                                if( data1.sesiId === sesi_id1 ) {
                                    $('#badge-baru').remove()
                                    ubahWarnaAvatar();

                                    jam_i[jam_i.length] = data1.date
                                    if ($('#radio-terbaru').is(':checked')) {
                                        $('#container-pesan .pesan').sort(sortTerbaru).appendTo('#container-pesan')
                                    } else if ($('#radio-terlama').is(':checked')) {
                                        $('#container-pesan .pesan').sort(sortTerlama).appendTo('#container-pesan')
                                    }

                                    setTimeout(function() {
                                        setFormatJam()
                                        counter()
                                        //scroll ke pesan terbaru
                                        $('#container-pesan').animate({
                                            scrollTop: $('#container-pesan-'+data1.mId).offset().top - $('#container-pesan').offset().top + $('#container-pesan').scrollTop()
                                        }, 500);
                                    }, 100);

                                    setTimeout(function () {
                                        $('#container-pesan-'+data1.mId).css({
                                            "background-color" : 'rgba(25,135,84,0.1)',
                                        });

                                        $('#pesan-'+data1.mId).parent().append(`<span id="badge-baru" class="badge bg-primary text-primary bg-opacity-10" style="height: fit-content;">Baru</span>`)

                                    },500)

                                    setTimeout(function () {
                                        $('#container-pesan-'+data1.mId).css({
                                            "background-color" : 'white',
                                        });
                                        console.log("ganti warna")
                                    },1500)

                                    //show toast
                                    $('#toast-new').show()
                                    setTimeout(function () {
                                        $('#toast-new').hide()
                                    },5000)
                                }
                            },
                            error: function(data, textStatus, xhr){
                                console.log(xhr)
                            }
                        })

                    }
                    else if(data1.asal === 'user-delete'){
                        $('#container-pesan-'+data1.mId).remove()
                        counter()
                    }
                    else if(data1.asal === 'user-profil'){
                        console.log(data1.userId + ' '+ data1.namaUser)
                        $("p#nama-peserta-form-"+data1.userId).text(data1.namaUser)
                        $("p#nama-peserta-form-"+data1.userId).parent().siblings('.avatar').children().text(data1.namaUser.charAt(0))
                        ubahWarnaAvatar();
                    }
                    else if(data1.asal === 'moderator-terpilih'){
                        console.log(data1)
                        $('#container-btn-'+data1.mId).children('.btn-terjawab').click()
                        counter()
                    }
                    else if(data1.asal === 'moderator-presentasi'){
                        console.log(data1)
                        $('#container-btn-'+data1.mId).children('.btn-presentasi').click()
                        counter()
                    }
                    else if(data1.asal === 'moderator-favorit'){
                        console.log(data1)
                        $('#container-btn-'+data1.mId).children('.btn-love').click()
                        counter()
                    }
                };

            });

        </script>

        <!-- function search pertanyaan   -->
        <script>
            //search question pool
            $("#search-pertanyaan").on("keyup", function() {
                let value = $(this).val().toLowerCase();

                if ($('#checkbox-terjawab').is(":checked") === true) {
                    console.log('true search')
                    $("#container-pesan-ditolak-terjawab .pesan-ditolak-terjawab .isi-pesan").filter(function() {
                        $(this).parent().parent().toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                } else {
                    console.log('else search')
                    $("#container-pesan .pesan .isi-pesan").filter(function() {
                        $(this).parent().parent().toggle($(this).text().toLowerCase().indexOf(value) > -1)
                    });
                }
                counter()
            });

            //search selected question pool
            $("#search-pertanyaan-terpilih").on("keyup", function() {
                var value = $(this).val().toLowerCase();

                $("#container-pesan-terpilih .pesan-terpilih .isi-pesan").filter(function() {
                    $(this).parent().parent().toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
                counter()
            });
        </script>

        <!-- get data events-->
        <script>
            //get events data waktu
            // var id_tiket = 1;
            // var id_tiket_session = 1;
            //
            // $.ajax({
            //     url: kel1_api+'/items/ticket?fields=ticket_id,ticket_type,ticket_x_session.session_id.*,ticket_x_day.day_id.*',
            //     type: 'GET',
            //     dataType: 'json',
            //     success: function(data, textStatus, xhr) {
            //             let nama = data.data[id_tiket-1].ticket_x_session[id_tiket_session-1].session_id.session_desc
            //             let time_start = new Date(data.data[id_tiket-1].ticket_x_session[id_tiket_session-1].session_id.start_time)
            //             let time_finish = new Date(data.data[id_tiket-1].ticket_x_session[id_tiket_session-1].session_id.finish_time)
            //
            //             let day = moment(time_start).format('dddd')
            //             let time_begin = moment(time_start).format('HH:mm')
            //             let time_end = moment(time_finish).format('HH:mm')
            //             let date = moment(time_start).format('LL')
            //
            //             $('#event-name').text(nama)
            //             $('#date-time').text(day+", "+date+" | "+time_begin+" - "+time_end+" WIB")
            //             // $('#time').text(time_begin+" - "+time_end)
            //     },
            //     error: function(xhr, textStatus, errorThrown) {
            //         console.log('Error in Database');
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

                            $('p#event-name').text(nama_event+" #"+data[i].unique_code.toUpperCase())
                            $('#date-time').text(day + ", " + date + ' | '+ time_begin + " - " + time_end + " WIB")

                        }
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(textStatus);
                }
            })
        </script>

        <!-- fungsi pindah pertanyaan   -->
        <script>
            //fungsi button accept
            let j= <?php echo $j; ?>;
            $("body").on("click", '.btn-accept', function() {
                $('#badge-baru').remove()

                let id_element = $(this).parent().attr('id');
                let id_numb = id_element.split("-");
                let idm = id_numb[2]
                console.log($('#container-pesan-'+idm))

                let parent_element = $('#container-pesan-'+idm);

                $.ajax({
                    url: "../update.php",
                    type: "POST",
                    cache: false,
                    data:{
                        status: '1',
                        id_message: idm,
                    },
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            console.log('Data updated successfully ! '+idm+' apa');
                        }
                    }
                });

                // get id user
                let id_user_element = $('#container-nama-waktu-'+idm).children('p.nama').attr('id');
                let id_user_arr = id_user_element.split("-");
                let id_user = id_user_arr[3];
                console.log(id_user)

                // get nama user dan message
                var cust_name = $('#nama-peserta-form-'+id_user).text();
                let cust_nama_depan = Array.from(cust_name)[0];
                let cust_message = $.trim($('#pesan-'+idm).clone().children().remove().end().text());

                // get jam pesan
                let element_i = $('#container-btn-'+idm).children('.btn-accept').attr('id')
                let id_i = element_i.split("-");
                let jam_pesan = $('#jam-pesan-i'+id_i[2]).text();
                let jam_pesan_hidden = $('#waktu_pengiriman_i_'+id_i[2]).text();

                console.log(jam_pesan_hidden + j)

                let elements=
                    `<div id="container-pesan-${idm}" class="p-3 pesan-terpilih border-top border-bottom ">
                        <div class="d-flex">
                            <p id="pesan-${idm}" class="mb-0 small isi-pesan flex-grow-1">
                                ${cust_message}
                            </p>
                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between align-items-center mt-3 ">
                                <div class="d-flex align-items-center ">
                                    <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                        <span>${cust_nama_depan}</span>
                                    </button>
                                    <div id="container-nama-waktu-${idm}" class="small align-self-center ms-2">
                                        <p id="nama-peserta-form-${id_user}" class="nama text-truncate fw-bold mb-0">${cust_name}</p>
                                        <p id="jam-pesan-j${j}" class="jam text-black-50 small mb-0 ">
                                            ${jam_pesan}
                                        </p>
                                        <p class="waktu-kirim d-none" id="waktu_pengiriman_j_${j}">${jam_pesan_hidden}</p>
                                    </div>
                                </div>

                                <div id="container-btn-${idm}" class="container-btn">
                                    <button id="btn-revert-${j}" class="btn btn-revert-terpilih bg-transparent border-0 rounded-3 py-1 px-1 me-0 text-muted"  title="Batal pilih pertanyaan">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                    <button id="btn-love-${j}" class="btn btn-love bg-transparent border-0 rounded-3 py-1 px-1 ms-1"  title="Favoritkan pertanyaan" style="color: #FF417B">
                                        <i class="bi bi-heart" ></i>
                                    </button>
                                    <button id="btn-presentasi-${j}" class="btn btn-presentasi bg-transparent border-0 rounded-3 py-1 px-1 ms-1 bg-opacity-10" style="color: #FF6641" title="Tampilkan di presentasi"><i class="bi bi-easel me-1"></i>
                                    </button>
                                    <button id="btn-terjawab-${j}" class="btn btn-terjawab bg-success border-0 rounded-3 py-1 px-3 ms-1"  title="Tandai sebagai terjawab" >
                                        <i class="bi bi-check-lg text-white"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>`

                $("#container-pesan-terpilih").append(elements);
                console.log("udah pindah"+$('#container-pesan-'+idm).parent().attr('id'))

                ubahWarnaAvatar();

                jam_j[jam_j.length] = jam_pesan_hidden

                if( $('#radio-terbaru-live').is(':checked') ){
                    $('#container-pesan-terpilih .pesan-terpilih').sort(sortTerbaru).appendTo('#container-pesan-terpilih')
                    console.log("terbaru")
                }
                else if ($('#radio-terlama-live').is(':checked')){
                    $('#container-pesan-terpilih .pesan-terpilih').sort(sortTerlama).appendTo('#container-pesan-terpilih')
                    console.log("terlama")
                }

                parent_element.remove()

                setTimeout(function() {
                    setFormatJam()
                    counter()
                    //scroll ke pesan terbaru
                    $('#container-pesan-terpilih').animate({
                        scrollTop: $('#container-pesan-'+idm).offset().top - $('#container-pesan-terpilih').offset().top + $('#container-pesan-terpilih').scrollTop()
                    }, 500);
                }, 100);

                setTimeout(function () {
                    $('#container-pesan-'+idm).css({
                        "background-color" : 'rgba(25,135,84,0.1)',
                    });

                    $('#pesan-'+idm).parent().append(`<span id="badge-baru" class="badge bg-primary text-primary bg-opacity-10" style="height: fit-content;">Baru</span>`)

                    // nambah badge edited
                    // $.ajax({
                    //     url: "../get_is_edited_messages.php",
                    //     type: 'POST',
                    //     cache: false,
                    //     dataType: 'json',
                    //     data:{
                    //         id_message: idm,
                    //     },
                    //     success: function(data, textStatus, xhr) {
                    //         console.log(typeof data[0].is_edited)
                    //         if( data[0].is_edited === '1' ){
                    //             console.log(data[0].is_edited)
                    //             if($('#pesan-'+idm).children().hasClass('badge-edited') === false) {
                    //                 $('#pesan-' + idm).append(`<span class="badge-edited small mb-0 text-muted"> (edited)</span>`)
                    //             }
                    //         }
                    //     }
                    // })
                },500)

                setTimeout(function () {
                    $('#container-pesan-'+idm).css({
                        "background-color" : 'white',
                    });
                    console.log("ganti warna")
                },1500)

                //show toast
                $('#toast-accept').show()
                setTimeout(function () {
                    $('#toast-accept').hide()
                },5000)

                j=j+1;
                // Proses Pengiriman Pesan
                let id_sesi = $('#login_id_sesi').val();
                let data = {
                    asal: 'admin',
                    userId: id_user,
                    mId: idm,
                    msg: cust_message,
                    sesiId: id_sesi,
                    date: jam_pesan_hidden,
                };
                conn.send(JSON.stringify(data));
            })

            //fungsi button decline
            let k= <?php echo $k; ?>;
            $("body").on("click", '.btn-decline', function() {
                $('#badge-baru').remove()

                let id_element = $(this).parent().attr('id');
                let id_numb = id_element.split("-");
                let idm = id_numb[2]
                console.log($('#container-pesan-ditolak-terjawab-'+idm).parent().attr('class'))

                let parent_element = $('#container-pesan-'+idm);

                $.ajax({
                    url: "../update.php",
                    type: "POST",
                    cache: false,
                    data:{
                        status: '3',
                        id_message: idm,
                    },
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            console.log('Data updated successfully ! '+idm+' apa');
                        }
                    }
                });

                // get id user
                let id_user_element = $('#container-nama-waktu-'+idm).children('p.nama').attr('id');
                let id_user_arr = id_user_element.split("-");
                let id_user = id_user_arr[3];
                console.log(id_user)

                // get nama user dan message
                var cust_name = $('#nama-peserta-form-'+id_user).text();
                let cust_nama_depan = Array.from(cust_name)[0];
                let cust_message = $.trim($('#pesan-'+idm).clone().children().remove().end().text());

                // get jam pesan
                let element_k = $('#container-btn-'+idm).children('.btn-decline').attr('id')
                let id_k = element_k.split("-");
                let jam_pesan = $('#jam-pesan-i'+id_k[2]).text();
                let jam_pesan_hidden = $('#waktu_pengiriman_i_'+id_k[2]).text();

                console.log(id_k[2])

                let elements=
                    `<div id="container-pesan-ditolak-terjawab-${idm}" class="p-3 pesan-ditolak-terjawab border-top border-bottom ">
                        <div class="d-flex">
                            <p id="pesan-ditolak-terjawab-${idm}" class="mb-0 small isi-pesan flex-grow-1">
                                ${cust_message}
                            </p>

                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between align-items-center mt-3 ">
                                <div class="d-flex align-items-center ">
                                    <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                        <span>${cust_nama_depan}</span>
                                    </button>
                                    <div id="container-nama-waktu-${idm}" class="small align-self-center ms-2">
                                        <p id="nama-peserta-form-${id_user}" class="nama text-truncate fw-bold mb-0">${cust_name}</p>
                                        <p id="jam-pesan-k${k}" class="jam text-black-50 small mb-0 ">
                                            ${jam_pesan}
                                        </p>
                                        <p class="waktu-kirim d-none" id="waktu_pengiriman_k_${k}">${jam_pesan_hidden}</p>
                                    </div>
                                    <i class="bi bi-file-earmark-x text-danger ms-2 align-self-end" title="Pertanyaan Ditolak"></i>
                                </div>

                                <div id="container-btn-${idm}">
                                    <button id="btn-revert-${k}" class="btn btn-revert bg-transparent border-0 rounded-3 py-1 px-1 me-0 text-muted"  title="Batal pilih pertanyaan">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>`

                console.log("udah pindah")
                $("#container-pesan-ditolak-terjawab").append(elements);

                ubahWarnaAvatar();

                jam_k[jam_k.length] = jam_pesan_hidden

                parent_element.remove()

                setTimeout(function() {
                    setFormatJam()
                    counter()
                    // scroll ke pesan terbaru
                    $('#container-pesan-ditolak-terjawab').animate({
                        scrollTop: $('#container-pesan-ditolak-terjawab-'+idm).offset().top - $('#container-pesan-ditolak-terjawab').offset().top + $('#container-pesan-ditolak-terjawab').scrollTop()
                    }, 500);
                    //
                }, 100);

                setTimeout(function () {
                    $('#container-pesan-ditolak-terjawab-'+idm).css({
                        "background-color" : 'rgba(25,135,84,0.1)',
                    });
                    $('#pesan-ditolak-terjawab-'+idm).parent().append(`<span id="badge-baru" class="badge bg-primary text-primary bg-opacity-10" style="height: fit-content;">Baru</span>`)

                    // nambah badge edited
                    // $.ajax({
                    //     url: "../get_is_edited_messages.php",
                    //     type: 'POST',
                    //     cache: false,
                    //     dataType: 'json',
                    //     data:{
                    //         id_message: idm,
                    //     },
                    //     success: function(data, textStatus, xhr) {
                    //         console.log(typeof data[0].is_edited)
                    //         if( data[0].is_edited === '1' ){
                    //             console.log(data[0].is_edited)
                    //             if($('#pesan-'+idm).children().hasClass('badge-edited') === false) {
                    //                 $('#pesan-' + idm).append(`<span class="badge-edited small mb-0 text-muted"> (edited)</span>`)
                    //             }
                    //         }
                    //     }
                    // })
                },500)

                setTimeout(function () {
                    $('#container-pesan-ditolak-terjawab-'+idm).css({
                        "background-color" : 'white',
                    });
                    console.log("ganti warna")
                },1500)

                //show toast
                $('#toast-decline').show()
                setTimeout(function () {
                    $('#toast-decline').hide()
                },5000)

                k=k+1;
            })

            //fungsi button terjawab
            $("body").on("click", ".btn-terjawab", function() {
                $('#badge-baru').remove()

                let id_element = $(this).parent().attr('id');
                let id_numb = id_element.split("-");
                let idm = id_numb[2]

                let parent_element = $('#container-pesan-'+idm);

                $.ajax({
                    url: "../update.php",
                    type: "POST",
                    cache: false,
                    data:{
                        status: '2',
                        id_message: idm,
                    },
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            console.log('Data updated successfully ! '+idm+' apa');
                        }
                    }
                });

                // get id user
                let id_user_element = $('#container-nama-waktu-'+idm).children('p.nama').attr('id');
                let id_user_arr = id_user_element.split("-");
                let id_user = id_user_arr[3];
                console.log(id_user)

                // get nama user dan message
                var cust_name = $('#nama-peserta-form-'+id_user).text();
                let cust_nama_depan = Array.from(cust_name)[0];
                let cust_message = $.trim($('#pesan-'+idm).clone().children().remove().end().text());

                // get jam pesan
                let element_k = $('#container-btn-'+idm).children('.btn-terjawab').attr('id')
                let id_k = element_k.split("-");
                let jam_pesan = $('#jam-pesan-j'+id_k[2]).text();
                let jam_pesan_hidden = $('#waktu_pengiriman_j_'+id_k[2]).text();

                console.log(id_k[2])

                let elements=
                    `<div id="container-pesan-ditolak-terjawab-${idm}" class="p-3 pesan-ditolak-terjawab border-top border-bottom ">
                        <div class="d-flex">
                            <p id="pesan-ditolak-terjawab-${idm}" class="mb-0 small isi-pesan flex-grow-1">
                                ${cust_message}
                            </p>

                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between align-items-center mt-3 ">
                                <div class="d-flex align-items-center ">
                                    <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                        <span>${cust_nama_depan}</span>
                                    </button>
                                    <div id="container-nama-waktu-${idm}" class="small align-self-center ms-2">
                                        <p id="nama-peserta-form-${id_user}" class="nama text-truncate fw-bold mb-0">${cust_name}</p>
                                        <p id="jam-pesan-k${k}" class="jam text-black-50 small mb-0 ">
                                            ${jam_pesan}
                                        </p>
                                        <p class="waktu-kirim d-none" id="waktu_pengiriman_k_${k}">${jam_pesan_hidden}</p>
                                    </div>
                                    <i class="bi bi-patch-check text-success ms-2 align-self-end" title="Pertanyaan Terjawab"></i>
                                </div>

                                <div id="container-btn-${idm}">
                                    <button id="btn-revert-${k}" class="btn btn-revert bg-transparent border-0 rounded-3 py-1 px-1 me-0 text-muted"  title="Batal pilih pertanyaan">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>`

                console.log("udah pindah")
                $("#container-pesan-ditolak-terjawab").append(elements);

                ubahWarnaAvatar();

                jam_k[jam_k.length] = jam_pesan_hidden

                parent_element.remove()

                setTimeout(function() {
                    setFormatJam()
                    counter()
                    // scroll ke pesan terbaru
                    $('#container-pesan-ditolak-terjawab').animate({
                        scrollTop: $('#container-pesan-ditolak-terjawab-'+idm).offset().top - $('#container-pesan-ditolak-terjawab').offset().top + $('#container-pesan-ditolak-terjawab').scrollTop()
                    }, 500);
                    //
                }, 100);

                setTimeout(function () {
                    $('#container-pesan-ditolak-terjawab-'+idm).css({
                        "background-color" : 'rgba(25,135,84,0.1)',
                    });
                    $('#pesan-ditolak-terjawab-'+idm).parent().append(`<span id="badge-baru" class="badge bg-primary text-primary bg-opacity-10" style="height: fit-content;">Baru</span>`)

                    // nambah badge edited
                    // $.ajax({
                    //     url: "../get_is_edited_messages.php",
                    //     type: 'POST',
                    //     cache: false,
                    //     dataType: 'json',
                    //     data:{
                    //         id_message: idm,
                    //     },
                    //     success: function(data, textStatus, xhr) {
                    //         console.log(typeof data[0].is_edited)
                    //         if( data[0].is_edited === '1' ){
                    //             console.log(data[0].is_edited)
                    //             if($('#pesan-'+idm).children().hasClass('badge-edited') === false) {
                    //                 $('#pesan-' + idm).append(`<span class="badge-edited small mb-0 text-muted"> (edited)</span>`)
                    //             }
                    //         }
                    //     }
                    // })
                },500)

                setTimeout(function () {
                    $('#container-pesan-ditolak-terjawab-'+idm).css({
                        "background-color" : 'white',
                    });
                    console.log("ganti warna")
                },1500)

                //show toast
                $('#toast-answer').show()
                setTimeout(function () {
                    $('#toast-answer').hide()
                },5000)

                k=k+1;
                // Proses Pengiriman Pesan
                var id_sesi = $('#login_id_sesi').val();
                var data = {
                    asal: 'admin-terpilih',
                    userId: id_user,
                    mId: idm,
                    msg: cust_message,
                    sesiId: id_sesi,
                    date: jam_pesan_hidden,
                };
                conn.send(JSON.stringify(data));
            })

            //fungsi revert pertanyaan dari terpilih ke awal
            $("body").on("click", ".btn-revert-terpilih", function() {
                $('#badge-baru').remove()

                let id_element = $(this).parent().attr('id');
                let id_numb = id_element.split("-");
                let idm = id_numb[2]

                let parent_element = $('#container-pesan-'+idm);

                $.ajax({
                    url: "../update.php",
                    type: "POST",
                    cache: false,
                    data:{
                        status: '0',
                        id_message: idm,
                    },
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            console.log('Data updated successfully ! '+idm+' apa');
                        }
                    }
                });

                // get id user
                let id_user_element = $('#container-nama-waktu-'+idm).children('p.nama').attr('id');
                let id_user_arr = id_user_element.split("-");
                let id_user = id_user_arr[3];
                console.log(id_user)

                // get nama user dan message
                let cust_name = $('#nama-peserta-form-'+id_user).text();
                let cust_nama_depan = Array.from(cust_name)[0];
                let cust_message = $.trim($('#pesan-'+idm).clone().children().remove().end().text());

                // get jam pesan
                let element_j = $('#container-btn-'+idm).children('.btn-revert-terpilih').attr('id')
                let id_j = element_j.split("-");
                let jam_pesan = $('#jam-pesan-j'+id_j[2]).text();
                let jam_pesan_hidden = $('#waktu_pengiriman_j_'+id_j[2]).text();

                console.log(id_j[2])

                let elements=
                    `<div id="container-pesan-${idm}" class="p-3 pesan border-top border-bottom">
                        <div class="d-flex">
                            <p id="pesan-${idm}" class="mb-0 small isi-pesan flex-grow-1">${cust_message}</p>
                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between align-items-center mt-3 ">
                                <div class="d-flex align-items-center ">
                                    <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                        <span>${cust_nama_depan}</span>
                                    </button>
                                    <div id="container-nama-waktu-${idm}" class="small align-self-center ms-2">
                                        <p id="nama-peserta-form-${id_user}" class="nama text-truncate fw-bold mb-0">${cust_name}</p>
                                        <p id="jam-pesan-i${i}" class="jam text-black-50 small mb-0 ">${jam_pesan}</p>
                                        <p class="waktu-kirim d-none" id="waktu_pengiriman_i_${i}">${jam_pesan_hidden}</p>
                                    </div>
                                </div>
                                <div id="container-btn-${idm}">
                                    <button id="btn-accept-${i}" class="btn btn-accept bg-success  bg-opacity-10 border-0 rounded-3 py-1 me-0 text-muted" title="Setujui pertanyaan"  style="width: 50px;">
                                        <i class="bi bi-check-lg text-success "></i>
                                    </button>
                                    <button id="btn-decline-${i}" class="btn btn-decline bg-danger bg-opacity-10 border-0 rounded-3 py-1 me-0 text-muted"  title="Tolak pertanyaan"  style="width: 50px;">
                                        <i class="bi bi-x-lg text-danger "></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>`

                console.log("udah pindah")
                $("#container-pesan").append(elements);

                ubahWarnaAvatar();

                jam_i[jam_i.length] = jam_pesan_hidden

                parent_element.remove()

                setTimeout(function() {
                    setFormatJam()
                    counter()
                    // scroll ke pesan terbaru
                    $('#container-pesan').animate({
                        scrollTop: $('#container-pesan-'+idm).offset().top - $('#container-pesan').offset().top + $('#container-pesan').scrollTop()
                    }, 500);
                    //
                }, 100);

                setTimeout(function () {
                    $('#container-pesan-'+idm).css({
                        "background-color" : 'rgba(25,135,84,0.1)',
                    });
                    $('#pesan-'+idm).parent().append(`<span id="badge-baru" class="badge bg-primary text-primary bg-opacity-10" style="height: fit-content;">Baru</span>`)

                    // nambah badge edited
                    // $.ajax({
                    //     url: "../get_is_edited_messages.php",
                    //     type: 'POST',
                    //     cache: false,
                    //     dataType: 'json',
                    //     data:{
                    //         id_message: idm,
                    //     },
                    //     success: function(data, textStatus, xhr) {
                    //         console.log(typeof data[0].is_edited)
                    //         if( data[0].is_edited === '1' ){
                    //             console.log(data[0].is_edited)
                    //             if($('#pesan-'+idm).children().hasClass('badge-edited') === false) {
                    //                 $('#pesan-' + idm).append(`<span class="badge-edited small mb-0 text-muted"> (edited)</span>`)
                    //             }
                    //         }
                    //     }
                    // })
                },500)

                setTimeout(function () {
                    $('#container-pesan-'+idm).css({
                        "background-color" : 'white',
                    });
                    console.log("ganti warna")
                },1500)

                //show toast
                $('#toast-revert').show()
                setTimeout(function () {
                    $('#toast-revert').hide()
                },5000)

                i=i+1;
                // Proses Pengiriman Pesan
                var id_sesi = $('#login_id_sesi').val();
                var data = {
                    asal: 'admin-terpilih',
                    userId: id_user,
                    mId: idm,
                    msg: cust_message,
                    sesiId: id_sesi,
                    date: jam_pesan_hidden,
                };
                conn.send(JSON.stringify(data));
            })

            //fungsi revert pertanyaan dari ditolak/terjawab ke awal
            $("body").on("click", ".btn-revert", function() {
                $('#badge-baru').remove()

                let id_element = $(this).parent().attr('id');
                let id_numb = id_element.split("-");
                let idm = id_numb[2]

                let parent_element = $('#container-pesan-ditolak-terjawab-'+idm);

                // get id user
                let id_user_element = $('#container-nama-waktu-'+idm).children('p.nama').attr('id');
                let id_user_arr = id_user_element.split("-");
                let id_user = id_user_arr[3];
                console.log(id_user)

                // get nama user dan message
                let cust_name = $('#nama-peserta-form-'+id_user).text();
                let cust_nama_depan = Array.from(cust_name)[0];
                let cust_message = $('#pesan-ditolak-terjawab-'+idm).text();

                // get jam pesan
                let element_j = $('#container-btn-'+idm).children('.btn-revert').attr('id')
                let id_j = element_j.split("-");
                let jam_pesan = $('#jam-pesan-k'+id_j[2]).text();
                let jam_pesan_hidden = $('#waktu_pengiriman_k_'+id_j[2]).text();

                console.log(id_j[2])

                let elements=
                    `<div id="container-pesan-${idm}" class="p-3 pesan border-top border-bottom">
                        <div class="d-flex">
                            <p id="pesan-${idm}" class="mb-0 small isi-pesan flex-grow-1">${cust_message}</p>
                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between align-items-center mt-3 ">
                                <div class="d-flex align-items-center ">
                                    <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                        <span>${cust_nama_depan}</span>
                                    </button>
                                    <div id="container-nama-waktu-${idm}" class="small align-self-center ms-2">
                                        <p id="nama-peserta-form-${id_user}" class="nama text-truncate fw-bold mb-0">${cust_name}</p>
                                        <p id="jam-pesan-i${i}" class="jam text-black-50 small mb-0 ">${jam_pesan}</p>
                                        <p class="waktu-kirim d-none" id="waktu_pengiriman_i_${i}">${jam_pesan_hidden}</p>
                                    </div>
                                </div>
                                <div id="container-btn-${idm}">
                                    <button id="btn-accept-${i}" class="btn btn-accept bg-success  bg-opacity-10 border-0 rounded-3 py-1 me-0 text-muted" title="Setujui pertanyaan"  style="width: 50px;">
                                        <i class="bi bi-check-lg text-success "></i>
                                    </button>
                                    <button id="btn-decline-${i}" class="btn btn-decline bg-danger bg-opacity-10 border-0 rounded-3 py-1 me-0 text-muted"  title="Tolak pertanyaan"  style="width: 50px;">
                                        <i class="bi bi-x-lg text-danger "></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>`

                let element_terjawab = `
                    <div id="container-pesan-${idm}" class="p-3 pesan-terpilih border-top border-bottom ">
                        <div class="d-flex">
                            <p id="pesan-${idm}" class="mb-0 small isi-pesan flex-grow-1">
                                ${cust_message}
                            </p>

                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between align-items-center mt-3 ">
                                <div class="d-flex align-items-center ">
                                    <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                        <span>${cust_nama_depan}</span>
                                    </button>
                                    <div id="container-nama-waktu-${idm}" class="small align-self-center ms-2">
                                        <p id="nama-peserta-form-${id_user}" class="nama text-truncate fw-bold mb-0">${cust_name}</p>
                                        <p id="jam-pesan-j${j}" class="jam text-black-50 small mb-0 ">
                                            ${jam_pesan}
                                        </p>
                                        <p class="waktu-kirim d-none" id="waktu_pengiriman_j_${j}">${jam_pesan_hidden}</p>
                                    </div>
                                </div>

                                <div id="container-btn-${idm}" class="container-btn">
                                    <button id="btn-revert-${j}" class="btn btn-revert-terpilih bg-transparent border-0 rounded-3 py-1 px-1 me-0 text-muted"  title="Batal pilih pertanyaan">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                    <button id="btn-love-${j}" class="btn btn-love bg-transparent border-0 rounded-3 py-1 px-1 ms-1"  title="Favoritkan pertanyaan" style="color: #FF417B">
                                        <i class="bi bi-heart" ></i>
                                    </button>
                                    <button id="btn-presentasi-${j}" class="btn btn-presentasi bg-transparent border-0 rounded-3 py-1 px-1 ms-1 bg-opacity-10" style="color: #FF6641" title="Tampilkan di presentasi"><i class="bi bi-easel me-1"></i>
                                    </button>
                                    <button id="btn-terjawab-${j}" class="btn btn-terjawab bg-success border-0 rounded-3 py-1 px-3 ms-1"  title="Tandai sebagai terjawab" >
                                        <i class="bi bi-check-lg text-white"></i>
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>`

                console.log("udah pindah")
                if($('#container-nama-waktu-'+idm).siblings('.bi').attr('title') === 'Pertanyaan Ditolak') {
                    $.ajax({
                        url: "../update.php",
                        type: "POST",
                        cache: false,
                        data:{
                            status: '0',
                            id_message: idm,
                        },
                        success: function(dataResult){
                            var dataResult = JSON.parse(dataResult);
                            if(dataResult.statusCode==200){
                                console.log('Data updated successfully ! '+idm+' apa');
                            }
                        }
                    });

                    $("#container-pesan").append(elements);

                    ubahWarnaAvatar();
                    jam_i[jam_i.length] = jam_pesan_hidden

                    setTimeout(function() {
                        setFormatJam()
                        counter()
                        // scroll ke pesan terbaru
                        $('#container-pesan').animate({
                            scrollTop: $('#container-pesan-'+idm).offset().top - $('#container-pesan').offset().top + $('#container-pesan').scrollTop()
                        }, 500);
                        //
                    }, 100);
                    parent_element.remove()
                    i=i+1;

                }
                else {
                    $.ajax({
                        url: "../update.php",
                        type: "POST",
                        cache: false,
                        data:{
                            status: '1',
                            id_message: idm,
                        },
                        success: function(dataResult){
                            var dataResult = JSON.parse(dataResult);
                            if(dataResult.statusCode==200){
                                console.log('Data updated successfully ! '+idm+' apa');
                            }
                        }
                    });

                    $("#container-pesan-terpilih").append(element_terjawab);
                    ubahWarnaAvatar();
                    jam_j[jam_j.length] = jam_pesan_hidden

                    setTimeout(function() {
                        setFormatJam()
                        counter()
                        // scroll ke pesan terbaru
                        $('#container-pesan-terpilih').animate({
                            scrollTop: $('#container-pesan-'+idm).offset().top - $('#container-pesan-terpilih').offset().top + $('#container-pesan-terpilih').scrollTop()
                        }, 500);
                        //
                    }, 100);
                    parent_element.remove()
                    j=j+1;

                    // Proses Pengiriman Pesan
                    let id_sesi = $('#login_id_sesi').val();
                    let data = {
                        asal: 'admin',
                        userId: id_user,
                        mId: idm,
                        msg: cust_message,
                        sesiId: id_sesi,
                        date: jam_pesan_hidden,
                    };
                    conn.send(JSON.stringify(data));
                }

                setTimeout(function () {
                    $('#container-pesan-'+idm).css({
                        "background-color" : 'rgba(25,135,84,0.1)',
                    });
                    $('#pesan-'+idm).parent().append(`<span id="badge-baru" class="badge bg-primary text-primary bg-opacity-10" style="height: fit-content;">Baru</span>`)

                    // nambah badge edited
                    // $.ajax({
                    //     url: "../get_is_edited_messages.php",
                    //     type: 'POST',
                    //     cache: false,
                    //     dataType: 'json',
                    //     data:{
                    //         id_message: idm,
                    //     },
                    //     success: function(data, textStatus, xhr) {
                    //         console.log(typeof data[0].is_edited)
                    //         if( data[0].is_edited === '1' ){
                    //             console.log(data[0].is_edited)
                    //             if($('#pesan-'+idm).children().hasClass('badge-edited') === false) {
                    //                 $('#pesan-' + idm).append(`<span class="badge-edited small mb-0 text-muted"> (edited)</span>`)
                    //             }
                    //         }
                    //     }
                    // })
                },500)

                setTimeout(function () {
                    $('#container-pesan-'+idm).css({
                        "background-color" : 'white',
                    });
                    console.log("ganti warna")
                },1500)

                //show toast
                $('#toast-revert').show()
                setTimeout(function () {
                    $('#toast-revert').hide()
                },5000)
            })

            //fungsi favorit pertanyaan
            let l= <?php echo $l; ?>;
            $("body").on("click", ".btn-love", function() {
                let id_element = $(this).parent().attr('id');
                let id_numb = id_element.split("-");
                let idm = id_numb[2]

                let parent_element = $('#container-pesan-favorit-'+idm);

                // get id user
                let id_user_element = $('#container-nama-waktu-'+idm).children('p.nama').attr('id');
                let id_user_arr = id_user_element.split("-");
                let id_user = id_user_arr[3];
                console.log(id_user)

                // get nama user dan message
                let cust_name = $('#nama-peserta-form-'+id_user).text();
                let cust_nama_depan = Array.from(cust_name)[0];
                let cust_message = $.trim($('#pesan-'+idm).clone().children().remove().end().text());

                // get jam pesan
                let element_j = $('#container-btn-'+idm).children('.btn-love').attr('id')
                console.log(element_j + ' '+ idm)
                let id_j = element_j.split("-");
                let jam_pesan = $('#jam-pesan-j'+id_j[2]).text();
                let jam_pesan_hidden = $('#waktu_pengiriman_j_'+id_j[2]).text();

                console.log(id_j[2])

                let element_icon= `<i class="bi bi-heart"></i>`;
                let element_icon_fill= `<i class="bi bi-heart-fill"></i>`;
                let element = `
                    <div id="container-pesan-favorit-${idm}" class="p-3 pesan-favorit border-top border-bottom " style="background-color:rgba(255,65,123,0.1)">
                        <div class="d-flex">
                            <p id="pesan-${idm}" class="mb-0 small isi-pesan flex-grow-1">${cust_message}</p>
                        </div>

                        <div class="card-footer bg-transparent">
                            <div class="d-flex justify-content-between align-items-center mt-3 ">
                                <div class="d-flex align-items-center ">
                                    <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                        <span>${cust_nama_depan}</span>
                                    </button>
                                    <div id="container-nama-waktu-'${idm}" class="small align-self-center ms-2">
                                        <p id="nama-peserta-form-${id_user}" class="nama text-truncate fw-bold mb-0">${cust_name}</p>
                                        <p id="jam-pesan-l${l}" class="jam text-black-50 small mb-0 ">${jam_pesan}</p>
                                        <p class="waktu-kirim d-none" id="waktu_pengiriman_l_${l}" >${jam_pesan_hidden}</p>
                                    </div>
                                </div>

                                <div id="container-btn-${idm}" class="container-btn">
                                    <button id="btn-revert-${l}" class="btn btn-revert-terpilih bg-transparent border-0 rounded-3 py-1 px-1 me-0 text-muted"  title="Batal pilih pertanyaan">
                                        <i class="bi bi-arrow-counterclockwise"></i>
                                    </button>
                                    <button id="btn-love-${l}" class="btn btn-love text-danger bg-transparent border-0 rounded-3 py-1 px-1 ms-1"  title="Favoritkan pertanyaan" style="color: #FF417B">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                    <button id="btn-presentasi-${l}" class="btn btn-presentasi bg-transparent border-0 rounded-3 py-1 px-1 ms-1 bg-opacity-10" style="color: #FF6641" title="Tampilkan di presentasi"><i class="bi bi-easel me-1"></i>
                                    </button>
                                    <button id="btn-terjawab-${l}" class="btn btn-terjawab bg-success border-0 rounded-3 py-1 px-3 ms-1"  title="Tandai sebagai terjawab" >
                                        <i class="bi bi-check-lg text-white"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `

                let status_pesan = 4;

                if($(this).children().hasClass('bi-heart-fill'))
                {
                    $('#container-pesan-' + idm).css({
                        "background-color": 'white',
                    });
                    $('#btn-love-' + id_j[2]).children('.bi-heart-fill').remove()
                    $('#btn-love-' + id_j[2]).append(element_icon)
                    console.log('false')
                    console.log($('#btn-love-' + id_j[2]).children())

                    $("#container-pesan-favorit-"+ idm).remove();
                    //show toast
                    setTimeout(function () {
                        // $('#toast-unlove').hide()
                        $('#toast-unlove').show()
                    },500)
                    setTimeout(function () {
                        $('#toast-unlove').hide()
                    },5000)

                    status_pesan = 1;
                }
                else
                {
                    if($(this).parent().children('.btn-presentasi').children().hasClass('bi-easel-fill')){
                        status_pesan = 6
                    }

                    $('#container-pesan-' + idm).css({
                        "background-color": 'rgba(255,65,123,0.1)',
                    });
                    console.log($('#btn-love-' + id_j[2]).children('.bi-heart-fill'))
                    $('#btn-love-' + id_j[2]).children('.bi-heart').remove()
                    $('#btn-love-' + id_j[2]).append(element_icon_fill)

                    $("#container-pesan-favorit").append(element);

                    ubahWarnaAvatar();

                    jam_l[jam_l.length] = jam_pesan_hidden
                    //show toast
                    setTimeout(function () {
                        $('#toast-love').show()
                    },500)
                    setTimeout(function () {
                        $('#toast-love').hide()
                    },5000)

                    l=l+1;
                }

                console.log(status_pesan)

                $.ajax({
                    url: "../update.php",
                    type: "POST",
                    cache: false,
                    data:{
                        status: status_pesan,
                        id_message: idm,
                    },
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            console.log('Data updated successfully ! '+idm+' apa');
                        }
                    }
                });

                // nambah badge edited
                // $.ajax({
                //     url: "../get_is_edited_messages.php",
                //     type: 'POST',
                //     cache: false,
                //     dataType: 'json',
                //     data:{
                //         id_message: idm,
                //     },
                //     success: function(data, textStatus, xhr) {
                //         console.log(typeof data[0].is_edited)
                //         if( data[0].is_edited === '1' ){
                //             console.log(data[0].is_edited)
                //             if($('#pesan-'+idm).children().hasClass('badge-edited') === false) {
                //                 $('#pesan-' + idm).append(`<span class="badge-edited small mb-0 text-muted"> (edited)</span>`)
                //             }
                //             else if($('#container-pesan-favorit-'+ idm).find('#pesan-' + idm).children().hasClass('badge-edited') === false){
                //                 $('#container-pesan-favorit-'+ idm).find('#pesan-' + idm).append(`<span class="badge-edited small mb-0 text-muted"> (edited)</span>`)
                //             }
                //         }
                //     }
                // })

                // jam_i[jam_i.length] = jam_pesan_hidden
                // parent_element.remove()
                // i=i+1;
                // Proses Pengiriman Pesan
                // var id_sesi = $('#login_id_sesi').val();
                // var data = {
                //     asal: 'admin-terpilih',
                //     userId: id_user,
                //     mId: idm,
                //     msg: cust_message,
                //     sesiId: id_sesi,
                //     date: jam_pesan_hidden,
                // };
                // conn.send(JSON.stringify(data));
            })

            //fungsi presentasi pertanyaan
            $("body").on("click", ".btn-presentasi", function() {
                let id_element = $(this).parent().attr('id');
                let id_numb = id_element.split("-");
                let idm = id_numb[2]

                let parent_element = $('#container-pesan-terpilih-'+idm);

                // get id user
                let id_user_element = $('#container-nama-waktu-'+idm).children('p.nama').attr('id');
                let id_user_arr = id_user_element.split("-");
                let id_user = id_user_arr[3];
                console.log(id_user)

                // get nama user dan message
                let cust_name = $('#nama-peserta-form-'+id_user).text();
                let cust_nama_depan = Array.from(cust_name)[0];
                let cust_message = $.trim($('#pesan-'+idm).clone().children().remove().end().text());

                // get jam pesan
                let element_j = $('#container-btn-'+idm).children('.btn-presentasi').attr('id')
                let id_j = element_j.split("-");
                let jam_pesan = $('#jam-pesan-j'+id_j[2]).text();
                let jam_pesan_hidden = $('#waktu_pengiriman_j_'+id_j[2]).text();

                console.log(id_j[2])

                let element_icon= `<i class="bi bi-easel me-1"></i>`;
                let element_icon_fill= `<i class="bi bi-easel-fill me-1"></i>`;
                // let element = `
                //     <div id="container-pesan-favorit-${idm}" class="p-3 pesan-favorit border-top border-bottom " style="background-color:rgba(255,65,123,0.1)">
                //         <div class="d-flex">
                //             <p id="pesan-${idm}" class="mb-0 small isi-pesan flex-grow-1">${cust_message}</p>
                //         </div>
                //
                //         <div class="card-footer bg-transparent">
                //             <div class="d-flex justify-content-between align-items-center mt-3 ">
                //                 <div class="d-flex align-items-center ">
                //                     <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                //                         <span>${cust_nama_depan}</span>
                //                     </button>
                //                     <div id="container-nama-waktu-'${idm}" class="small align-self-center ms-2">
                //                         <p id="nama-peserta-form-${id_user}" class="nama text-truncate fw-bold mb-0">${cust_name}</p>
                //                         <p id="jam-pesan-l${l}" class="jam text-black-50 small mb-0 ">${jam_pesan}</p>
                //                         <p class="waktu-kirim d-none" id="waktu_pengiriman_l_${l}" >${jam_pesan_hidden}</p>
                //                     </div>
                //                 </div>
                //
                //                 <div id="container-btn-${idm}" class="container-btn">
                //                     <button id="btn-revert-${l}" class="btn btn-revert-terpilih bg-transparent border-0 rounded-3 py-1 px-1 me-0 text-muted"  title="Batal pilih pertanyaan">
                //                         <i class="bi bi-arrow-counterclockwise"></i>
                //                     </button>
                //                     <button id="btn-love-${l}" class="btn btn-love text-danger bg-transparent border-0 rounded-3 py-1 px-1 ms-1"  title="Favoritkan pertanyaan" style="color: #FF417B">
                //                         <i class="bi bi-heart-fill"></i>
                //                     </button>
                //                     <button id="btn-terjawab-${l}" class="btn btn-terjawab bg-success border-0 rounded-3 py-1 px-3 ms-1"  title="Tandai sebagai terjawab" >
                //                         <i class="bi bi-check-lg text-white"></i>
                //                     </button>
                //                 </div>
                //             </div>
                //         </div>
                //     </div>
                // `

                let status_pesan = 5;

                if($('.btn-presentasi').find('.bi-easel-fill').length > 0){ /*sudah dipresentasi*/
                    let id_presentasi = $('.btn-presentasi').find('.bi-easel-fill').parent().attr('id')
                    let id_parent = $('.btn-presentasi').find('.bi-easel-fill').parent().parent().attr('id')
                    let idp = id_parent.split("-");

                    if($('.btn-presentasi').find('.bi-easel-fill').parent().siblings('.btn-love').children().hasClass('bi-heart-fill')){ //apakah favorit pada button itu
                        status_pesan = 4;
                        $('#container-pesan-favorit-'+idp[2]).addClass('border-top')
                        $('#container-pesan-favorit-'+idp[2]).addClass('border-bottom')
                        $('#container-pesan-favorit-'+idp[2]).removeClass('border')
                        $('#container-pesan-favorit-'+idp[2]).removeClass('border-2')
                        $('#container-pesan-favorit-'+idp[2]).removeClass('border-orange')
                        //ganti icon
                        $('#container-pesan-favorit-'+idp[2]).find('.bi-easel-fill').remove()
                        $('#container-pesan-favorit-'+idp[2]).find('.btn-presentasi').append(element_icon)
                    }
                    else{
                        status_pesan = 1;
                    }

                    //ganti icon
                    $('.btn-presentasi').find('.bi-easel-fill').remove()
                    $('#' + id_presentasi).append(element_icon)

                    //hilangin border kalo dipresentasi
                    $('#container-pesan-'+idp[2]).addClass('border-top')
                    $('#container-pesan-'+idp[2]).addClass('border-bottom')
                    $('#container-pesan-'+idp[2]).removeClass('border')
                    $('#container-pesan-'+idp[2]).removeClass('border-2')
                    $('#container-pesan-'+idp[2]).removeClass('border-orange')
                    console.log(idp)

                    $.ajax({
                        url: "../update.php",
                        type: "POST",
                        cache: false,
                        data:{
                            status: status_pesan,
                            id_message: idp[2],
                        },
                        success: function(data){
                            let dataResult = JSON.parse(data);
                            if(dataResult.statusCode==200){
                                console.log(idp+' sudah tidak dipresentasi');
                            }
                        }
                    });
                }


                if($('#btn-presentasi-' + id_j[2]).siblings('.btn-love').children().hasClass('bi-heart-fill')){
                    status_pesan = 6;

                    //nambah border kalo dipresentasi
                    $('#container-pesan-favorit-'+idm).removeClass('border-top')
                    $('#container-pesan-favorit-'+idm).removeClass('border-bottom')
                    $('#container-pesan-favorit-'+idm).addClass('border')
                    $('#container-pesan-favorit-'+idm).addClass('border-2')
                    $('#container-pesan-favorit-'+idm).addClass('border-orange')

                    //ganti icon
                    $('#container-pesan-favorit-'+idm).find('.bi-easel').remove()
                    $('#container-pesan-favorit-'+idm).find('.btn-presentasi').append(element_icon_fill)
                }
                else {
                   status_pesan = 5;
                }

                //nambah border kalo dipresentasi
                $('#container-pesan-'+idm).removeClass('border-top')
                $('#container-pesan-'+idm).removeClass('border-bottom')
                $('#container-pesan-'+idm).addClass('border')
                $('#container-pesan-'+idm).addClass('border-2')
                $('#container-pesan-'+idm).addClass('border-orange')

                //ganti icon
                console.log($('#btn-presentasi-' + id_j[2]).children())
                $('#btn-presentasi-' + id_j[2]).children('.bi-easel').remove()
                $('#btn-presentasi-' + id_j[2]).append(element_icon_fill)

                //show toast
                setTimeout(function () {
                    $('#toast-presentasi').show()
                },500)
                setTimeout(function () {
                    $('#toast-presentasi').hide()
                },5000)

                // if($(this).children().hasClass('bi-easel-fill')==false)
                // {
                    // if($(this).children().hasClass('bi-heart-fill')){
                    //     status_pesan = 4;
                    // }
                    //
                    // $('#btn-presentasi-' + id_j[2]).children('.bi-easel-fill').remove()
                    // $('#btn-presentasi-' + id_j[2]).append(element_icon)
                    //
                    // //show toast
                    // setTimeout(function () {
                    //     // $('#toast-unlove').hide()
                    //     $('#toast-presentasi-hide').show()
                    // },500)
                    // setTimeout(function () {
                    //     $('#toast-presentasi-hide').hide()
                    // },5000)
                    //
                    // status_pesan = 1;
                // }
                // else
                // {
                //     if($(this).children().hasClass('bi-heart-fill')){
                //         status_pesan = 6;
                //     }
                //     $('#container-pesan-'+idm).removeClass('border-top')
                //     $('#container-pesan-'+idm).removeClass('border-bottom')
                //     $('#container-pesan-'+idm).addClass('border')
                //     $('#container-pesan-'+idm).addClass('border-2')
                //     $('#container-pesan-'+idm).addClass('border-orange')
                //
                //     console.log($('#btn-presentasi-' + id_j[2]).children())
                //     $('#btn-presentasi-' + id_j[2]).children('.bi-easel').remove()
                //     $('#btn-presentasi-' + id_j[2]).append(element_icon_fill)
                //
                //     //show toast
                //     setTimeout(function () {
                //         // $('#toast-love').hide()
                //         $('#toast-presentasi').show()
                //     },500)
                //     setTimeout(function () {
                //         $('#toast-presentasi').hide()
                //     },5000)
                // }

                console.log(status_pesan)
                /* nambah badge dipresentasikan dan */

                $.ajax({
                    url: "../update.php",
                    type: "POST",
                    cache: false,
                    data:{
                        status: status_pesan,
                        id_message: idm,
                    },
                    success: function(data){
                        let dataResult = JSON.parse(data);
                        if(dataResult.statusCode==200){
                            console.log(idm+' dipresentasikan');
                        }
                    }
                });

                // jam_i[jam_i.length] = jam_pesan_hidden
                // parent_element.remove()
                // i=i+1;

                // Proses Pengiriman Pesan
                var id_sesi = $('#login_id_sesi').val();
                var data = {
                    asal: 'admin-presentasi',
                    userId: id_user,
                    mId: idm,
                    msg: cust_message,
                    sesiId: id_sesi,
                    status: status_pesan.toString(),
                    date: jam_pesan_hidden,
                };
                conn.send(JSON.stringify(data));
            })



            // fungsi edit
            /*let edit_idm = 0
            $("body").on("click", ".btn-edit", function() {
                $('#modal-edit').modal('show');

                let id_element = $(this).attr('id');
                let id_numb = id_element.split("-");
                edit_idm = id_numb[2]
                let parent_element = $('#container-pesan-'+edit_idm);

                // get id user
                // let id_user_element = $('#container-nama-waktu-'+edit_idm).children('p.nama').attr('id');
                // let id_user_arr = id_user_element.split("-");
                // let id_user = id_user_arr[3];
                // console.log(edit_idm)

                // get message
                let cust_message = $.trim($('#pesan-'+edit_idm).clone().children().remove().end().text());

                // get jam pesan
                // let element_i = $('#container-btn-'+edit_idm).children('.btn-accept').attr('id')
                // let id_i = element_i.split("-");
                // console.log(id_i[2])

                $('#input-edit').val(cust_message)
                charCounter()

                $("#input-edit").on('keyup', function(e) {
                    if($('#input-edit').val() !== ''){
                        $('.btn-save').removeAttr('disabled')
                    }
                    else{
                        $('.btn-save').attr('disabled','true')
                    }
                });
            })
            // fungsi save edit
            $("body").on("click", ".btn-save", function() {
                // get message
                let cust_message = $.trim($('#pesan-'+edit_idm).clone().children().remove().end().text());
                let edited_message = $.trim($('#input-edit').val())

                console.log(edited_message + ' edit '+ edit_idm)
                console.log(cust_message+ ' asli '+ edit_idm)

                if(cust_message === edited_message){
                    $('#input-edit').val('')
                    $('#modal-edit').modal('hide');
                }
                else{
                $('#pesan-'+edit_idm).text(edited_message);

                if($('#pesan-'+edit_idm).children().hasClass('badge-edited') === false) {
                    $('#pesan-' + edit_idm).append(`<span class="badge-edited small mb-0 text-muted"> (edited)</span>`)
                }
                console.log("xhr.status");
                $.ajax({
                    url: "../update_messages.php",
                    type: "POST",
                    cache: false,
                    data:{
                        id_message: edit_idm,
                        pesan : edited_message,
                        is_edited: 1,
                    },
                    success: function(dataResult){
                        console.log(this.data)
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode===200){
                            console.log('Data updated successfully ! '+edit_idm+' apa');
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    }
                });

                //show toast
                setTimeout(function () {
                    $('#toast-edit').show()
                    $('#modal-edit').modal('hide');
                },500)

                setTimeout(function () {
                    $('#toast-edit').hide()
                },4000)

                // Proses Pengiriman Pesan
                let id_sesi = $('#login_id_sesi').val();
                let data = {
                    asal: 'admin-edit',
                    mId: edit_idm,
                    msg: edited_message,
                    sesiId: id_sesi,
                    date: moment().format('YYYY-MM-DD HH:mm:ss'),
                };
                conn.send(JSON.stringify(data));

                }
            })
            // fungsi cancel edit
            $("body").on("click", ".btn-cancel", function() {
                $('#input-edit').val('')
                $('#modal-edit').modal('hide');
            })*/
        </script>

        <!--    function sortable-->
        <script>
            // $("document").ready(function() {
            //     $("#container-pesan, #container-pesan-terpilih" ).sortable({
            //         revert: true,
            //         connectWith: ".sortable",
            //         cursor: "move",
            //         handle: ".bi-grip-vertical",
            //         start: function(e, ui) {
            //             // creates a temporary attribute on the element with the old index
            //             $(this).attr('data-previndex', ui.item.index());
            //             console.log('apa ini :'+ui.item.attr('id'));
            //         },
            //         update: function(e, ui) {
            //             // gets the new and old index then removes the temporary attribute
            //             var newIndex = ui.item.index();
            //             var oldIndex = $(this).attr('data-previndex');
            //             console.log('new : '+newIndex);
            //             console.log('old : '+oldIndex);
            //             $(this).removeAttr('data-previndex');
            //             // $.ajax({
            //             //     url: "../update.php",
            //             //     type: "POST",
            //             //     cache: false,
            //             //     data:{
            //             //         status: '1',
            //             //         id_message: idm,
            //             //     },
            //             //     success: function(dataResult){
            //             //         var dataResult = JSON.parse(dataResult);
            //             //         if(dataResult.statusCode==200){
            //             //             console.log('Data updated successfully ! '+idm+' apa');
            //             //         }
            //             //         status_sort == 0
            //             //     }
            //             // });
            //             console.log("udah pindah "+ui.item.attr('id'))
            //             counter()
            //         }
            //     }).disableSelection();
            //
            //     $( "#container-pesan-terpilih" ).on( "sortreceive", function( event, ui ) {
            //         console.log('apa ini :'+$(this).children().attr('id'));
            //     } );
            //
            //     // $(".pesan").draggable({
            //     //     connectToSortable: ".sortable",
            //     //     revert: true,
            //     //     cursor: "move",
            //     //     handle: "i",
            //     //     helpers: "original"
            //     // });
            //     // $(".pesan-terpilih").draggable({
            //     //     connectToSortable: ".sortable",
            //     //     revert: true,
            //     //     cursor: "move",
            //     //     handle: "i",
            //     //     helpers: "original"
            //     // });
            //     //
            //     // $("#container-pesan, #container-pesan-terpilih").droppable({
            //     //     accept: '.pesan, .pesan-terpilih',
            //     //     drop: function(event, ui) {
            //     //         $(this).append($(ui.draggable));
            //     //     }
            //     // });
            // });

            // function allowDrop(ev) {
            //     ev.preventDefault();
            // }
            //
            // function drag(ev) {
            //     ev.dataTransfer.setData("text", ev.target.id);
            // }
            //
            // function drop(ev) {
            //     ev.preventDefault();
            //     var data = ev.dataTransfer.getData("text");
            //     ev.target.appendChild(document.getElementById(data));
            // }
        </script>

    </body>
</html>