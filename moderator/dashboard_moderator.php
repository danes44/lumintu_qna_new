<?php
    session_start();

    require('../database/ChatRooms.php');
    include('../get_nama.php');
    // panggil fungsi enkripsi
    include("../crypt.php");

//    if (!isset($_SESSION['is_login'])) {
//      echo "<script>document.location.href='index.php';</script>";
//      die();
//    }

    $chat_object = new ChatRooms;
    $chat_data = $chat_object->get_all_chat_data();

    $i_x_waktu = array();
    $j_x_waktu = array();
    $k_x_waktu = array();
    $l_x_waktu = array();

    $status_all = 0;
    $status_live = 1;

    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    $hasilHash = mycrypt("decrypt", $uri_path);
    $arrayHasil = explode("&", $hasilHash);
    $arr_sesi_id = explode("=",$arrayHasil[0]);
    $sesi_id = $arr_sesi_id[1];
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
        <link href="../css-js/styleModerator.css" rel="stylesheet">

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
    </head>

    <body>
        <!-- Toast -->
        <div id="container-toast" class="toast-container position-fixed top-0 end-0 p-3 mt-5">
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
            <div id="toast-pesan-admin" class="toast align-items-center text-primary border-1 border-primary" role="alert" aria-live="assertive" aria-atomic="true" style="background-color: #e6f0ff">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-circle me-3"></i>
                        Ada pesan baru dari Admin
                    </div>
                    <button type="button" class="btn-close btn-close-toast me-2 m-auto" aria-label="Close"></button>
                </div>
            </div>
        </div>

        <!-- sidebar -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasInfo" aria-labelledby="offcanvasInfoLabel">
            <div class="offcanvas-header justify-content-start ">
                <button type="button" class="btn-close my-0 me-0" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body px-0 text-center">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="../assets/Logo QnA.svg" class="img-fluid text-center" width="20%" alt="...">
                    <p class="align-middle fs-1 fw-bold ms-2 mb-0">QnA</p>
                </div>
                <p id="event-name-offcanvas" class="text-truncate fw-bold mb-0 mt-4"></p>
                <p id="date" class=" mb-0 mt-4"></p>
                <p id="time" class="mb-0 mt-2"></p>
                <hr class="mt-5 mb-0">
                <div class="list-group">
                    <a id="sidebar-pertanyaan" href="#" class="list-group-item list-group-item-action active border-0 py-3 rounded-0">
                        <div class="d-flex w-100 align-items-center">
                            <i class="bi bi-question-octagon me-3"></i>
                            <p class="mb-0 me-auto fw-semibold">Pertanyaan</p>
                            <span id="badge-pertanyaan" class="badge bg-primary rounded-pill" style="display: none">
                                <i class="bi bi-exclamation" style="font-size: 1rem;"></i>
                            </span>
                        </div>
                    </a>
                    <a id="sidebar-pesan-admin" href="#" class="list-group-item list-group-item-action border-0 py-3 rounded-0">
                        <div class="d-flex w-100 align-items-center">
                            <i class="bi bi-chat-left-dots me-3"></i>
                            <p class="mb-0 me-auto fw-semibold">Pesan Admin</p>
                            <span id="badge-pesan-admin" class="badge bg-primary rounded-pill" style="display: none">
                                <i class="bi bi-exclamation" style="font-size: 1rem;"></i>
                            </span>
                        </div>
                    </a>
                    <a id="sidebar-catatan" href="#" class="list-group-item list-group-item-action border-0 py-3 rounded-0">
                        <div class="d-flex w-100 align-items-center">
                            <i class="bi bi-sticky me-3"></i>
                            <p class="mb-0 me-auto fw-semibold">Catatan</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- navbar -->
        <div id="navbar" class="border-0 fixed-top px-3 py-2 text-dark border-bottom" style="background-color: #FFFFFF;">
            <div class="d-flex align-items-center justify-content-between position-relative">
                <button class="btn border-0 fs-3 p-0 me-0" data-bs-toggle="offcanvas" data-bs-target="#offcanvasInfo"
                        aria-controls="offcanvasInfo">
                    <i class="bi bi-list text-black"></i>
                </button>
                <div class="position-absolute start-50 translate-middle-x text-center small">
                    <p id="event-name-navbar" class="text-truncate fw-bold mb-0"></p>
                    <p id="event-code" class="text-truncate mb-0 small"></p>
                </div>
                <div class="d-flex align-items-center">
                    <button class="small border-0 rounded-pill ms-0 text-white fw-bold" style="width: 2rem; height: 2rem; background-color: rgb(240, 241, 242);" disabled>
                        <span class="moderator-avatar" style="color: rgb(27, 27, 27);"><i class="bi bi-person"></i></span>
                    </button>
                    <p id="moderator" class="ms-2 fw-bold mb-0 small">Moderator</p>
                </div>
            </div>
        </div>

        <!--  list pertanyaan -->
        <div id="conversation-container" class="container g-0 position-absolute start-50 translate-middle-x px-3" style="max-width: 540px;margin-top: 70px">
            <div class="d-flex align-items-center mb-2 mt-3">
                <p class="fw-bold mb-0" data-bs-toggle="tooltip" data-bs-title="Daftar pertanyaan yang tertampil di presentasi">
                    Pertanyaan
                </p>
                <i class="ms-2 bi bi-question-circle" style="font-size: .8em" data-bs-toggle="tooltip" data-bs-title="Daftar pertanyaan yang tertampil di presentasi"></i>
                <span class="ms-2 badge rounded-pill text-bg-danger"><i class="bi bi-circle-fill me-2 blink"></i>Live</span>
                <h6 id="jumlah-pertanyaan-terpilih" class="ms-auto mb-0"></h6>
                <h6 id="jumlah-pertanyaan-favorit" class="ms-auto mb-0 d-none"></h6>
            </div>
            <div class="input-group input-group-sm mb-4" >
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
            <div id="conversation" class="position-absolute start-50 translate-middle-x w-100 pb-4 px-3" style="overflow: overlay; ">
                <!-- pesan terpilih-->
                <div class="rounded-3 sortable list-pertanyaan" id="container-pesan-terpilih" style="overflow-y: overlay;">
                    <?php
                    $j = 0;
                    $last = count($chat_data);
                    foreach($chat_data as $chat){
                        $str1 = str_split($chat["waktu_pengiriman"], 10);
                        $jam_pesan = str_split($str1[1], 6);

                        if ($chat["id_chat"] == $sesi_id && ($chat["status"]==1 || $chat["status"]==4 || $chat["status"]==5 || $chat["status"]==6)){
                            $nama_peserta = get_nama($chat["id_pengirim"]);
                            $id = $chat["id_message"];
                            $huruf_depan = $nama_peserta[0];
                            $j_x_waktu[$j] = $chat["waktu_pengiriman"];

                            echo '
                                <div id="container-pesan-'.$chat["id_message"].'" class="p-4 rounded-3 mb-3 pesan-terpilih ';
                                if($chat["status"]==5 || $chat["status"]==6){
                                    echo 'border border-2 border-orange';
                                }
                                else{
                                    echo 'border border-1';
                                }
                                echo ' " ';
                                if($chat["status"]==4 || $chat["status"]==6){
                                    echo 'style="background-color:rgba(255,65,123,0.1)"';
                                }
                                echo '>
                                    <div class="d-flex">
                                        <p id="pesan-'.$chat["id_message"].'" class="mb-0 isi-pesan flex-grow-1">'.$chat["pesan"].'
                                        ';
                                    if($chat["is_edited"]==1){
                                        echo '<span class="badge-edited small mb-0 text-muted"> (edited)</span>';
                                    }
                                    echo '
                                        </p>
                                    </div>
                    
                                    <div class="card-footer bg-transparent mt-4">
                                        <div class="d-flex justify-content-between align-items-center mt-3 ">
                                            <div class="d-flex align-items-center ">
                                                <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                                    <span>'.$huruf_depan.'</span>
                                                </button>
                                                <div id="container-nama-waktu-'.$chat["id_message"].'" class="small align-self-center ms-2">
                                                    <p id="nama-peserta-form-'.$chat["id_pengirim"].'" class="nama text-truncate fw-bold mb-0" data-bs-toggle="tooltip" data-bs-title="'.$nama_peserta.'" style="max-width: 130px">'.$nama_peserta.'</p>
                                                    <p id="jam-pesan-j'.$j.'" class="jam text-black-50 small mb-0 ">'.$jam_pesan[0].'</p>
                                                    
                                                    <p class="waktu-kirim d-none" id="waktu_pengiriman_j_'. $j .'" >'.$chat["waktu_pengiriman"].'</p>
                                                    
                                                </div>
                                            </div>
                                        
                                            <div id="container-btn-'.$chat["id_message"]. '" class="container-btn">
                                                <button id="btn-love-'.$j.'" class="btn btn-love text-danger bg-transparent border-0 rounded-3 py-1 px-1 ms-1"  data-bs-toggle="tooltip" data-bs-title="Favoritkan pertanyaan" style="color: #FF417B; font-size:1.2rem">
                                                    ';
                                                if($chat["status"]==4 || $chat["status"]==6){
                                                    echo '<i class="bi bi-heart-fill" ></i>';
                                                }
                                                else{
                                                    echo '<i class="bi bi-heart" ></i>';
                                                }
                                                echo '
                                                </button>
                                                <button id="btn-presentasi-'.$j.'" class="btn btn-presentasi bg-transparent border-0 rounded-3 py-1 px-1 ms-1 bg-opacity-10" style="color: #FF6641;font-size:1.2rem" data-bs-toggle="tooltip" data-bs-title="Tampilkan di presentasi">
                                                ';
                                                if($chat["status"]==5 || $chat["status"]==6){
                                                    echo '<i class="bi bi-easel-fill me-1"></i>';
                                                }
                                                else{
                                                    echo '<i class="bi bi-easel me-1"></i>';
                                                }
                                                echo '
                                                </button>                              
                                                <button id="btn-terjawab-'.$j.'" class="btn btn-terjawab bg-success border-0 rounded-3 py-1 px-3 ms-2"  data-bs-toggle="tooltip" data-bs-title="Tandai sebagai terjawab" >
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
                <div class="border border-1 rounded-3 sortable list-pertanyaan d-none" id="container-pesan-favorit" style="overflow-y: overlay;">
                    <?php
                    $l = 0;
                    $last = count($chat_data);
                    foreach($chat_data as $chat){
                        $str1 = str_split($chat["waktu_pengiriman"], 10);
                        $jam_pesan = str_split($str1[1], 6);

                        if ($chat["id_chat"] == $sesi_id && ($chat["status"]==4 || $chat["status"]==6)){
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
                                        ';
                                        if($chat["is_edited"]==1){
                                            echo '<span class="badge-edited small mb-0 text-muted"> (edited)</span>';
                                        }
                                        echo '
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
                                                <button id="btn-love-'.$l.'" class="btn btn-love text-danger bg-transparent border-0 rounded-3 py-1 px-1 ms-1"  data-bs-toggle="tooltip" data-bs-title="Favoritkan pertanyaan" style="color: #FF417B">
                                                    <i class="bi bi-heart-fill" ></i>
                                                </button>
                                                <button id="btn-presentasi-'.$j.'" class="btn btn-presentasi bg-transparent border-0 rounded-3 py-1 px-1 ms-1 bg-opacity-10" style="color: #FF6641" data-bs-toggle="tooltip" data-bs-title="Tampilkan di presentasi">
                                                ';
                                                if($chat["status"]==6){
                                                    echo '<i class="bi bi-easel-fill me-1"></i>';
                                                }
                                                else{
                                                    echo '<i class="bi bi-easel me-1"></i>';
                                                }
                                                echo '
                                                </button> 
                                                <button id="btn-terjawab-'.$l.'" class="btn btn-terjawab bg-success border-0 rounded-3 py-1 px-3 ms-1"  data-bs-toggle="tooltip" data-bs-title="Tandai sebagai terjawab" >
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

        <!--  list pesan admin -->
        <div id="pesan-admin-container" class="container g-0 position-absolute start-50 translate-middle-x px-3" style="max-width: 540px;margin-top: 70px; display: none">
            <div class="d-flex align-items-center mb-2 mt-3">
                <p class="fw-bold mb-0" data-bs-toggle="tooltip" data-bs-title="Daftar pesan dari admin ke moderator">
                    Pesan Admin
                </p>
                <i class="ms-2 bi bi-question-circle" style="font-size: .8em" data-bs-toggle="tooltip" data-bs-title="Daftar pesan dari admin ke moderator"></i>
                <h6 id="jumlah-pesan-admin" class="ms-auto mb-0"></h6>
            </div>
            <div id="pesan-admin" class="position-absolute start-50 translate-middle-x w-100 pb-4 px-3" style="overflow: overlay; ">
                <!-- -->
                <div class="rounded-3 sortable list-pesan-admin" id="container-pesan-admin" style="overflow-y: overlay;">

                </div>
            </div>

        </div>

        <!--  list note -->
        <div id="catatan-container" class="container g-0 position-absolute start-50 translate-middle-x px-3" style="max-width: 540px;margin-top: 70px; display: none">
            <div class="d-flex align-items-center mb-2 mt-3">
                <p class="fw-bold mb-0" data-bs-toggle="tooltip" data-bs-title="Daftar catatan">
                    Catatan
                </p>
                <i class="ms-2 bi bi-question-circle" style="font-size: .8em" data-bs-toggle="tooltip" data-bs-title="Daftar catatan"></i>
            </div>
            <div id="note" class="position-absolute start-50 translate-middle-x w-100 px-3" style="overflow: overlay; padding-bottom: 6.5rem !important;">
                <!-- pesan terpilih-->
                <div class="rounded-3 sortable list-note" id="container-note" style="overflow-y: overlay;">

                </div>
            </div>


        </div>


        <!-- Modal Terjawab-->
        <div class="modal fade" id="modal-terjawab" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-create-label" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered justify-content-center">
                <div class="modal-content py-2 px-4" style="width: auto">
                    <div class="modal-header border-0 pb-0">
                        <h6 class="modal-title fw-bold " id="staticBackdropLabel" >Apakah Anda sudah menjawab pertanyaan?</h6>
                    </div>
                    <div class="modal-body pb-0">
                        <p class="small text-muted">Dengan melakukan ini pertanyaan Anda akan dihapus dari daftar pertanyaan. Setelah dihapus, Anda <b>tidak dapat</b> mengembalikannya.</p>
                    </div>
                    <div class="modal-footer border-0 pt-0 px-3 justify-content-between">
                        <button id="btn-confirm" type="submit" class="btn btn-confirm border-0 rounded-3 py-2 ms-0 me-0 text-white fw-bold btn-success flex-fill"  title="Simpan perubahan"  style="font-size: .875em">
                            Sudah
                        </button>
                        <button id="timer-confirm" class="btn-confirm border-0 rounded-3 py-2 me-0 ms-0 text-white fw-bold bg-success bg-opacity-50 flex-fill" disabled title="Harap menunggu"  style="display:none;">
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


        <div class="fixed-bottom">
            <button id="fab-scroll" class="float-end btn border-0 rounded-circle bg-black bg-opacity-25 shadow mb-3 me-3 fw-bold position-relative" style="height: 60px; width: 60px;"><i class="bi bi-arrow-up text-white" style="font-size: 1.5rem"></i></button>
            <div id="footer-container" class="fixed-bottom mx-auto" style="z-index: 1020;max-width: 540px;display: none">
                <div id="conversation-footer" class="mb-3 mx-3 bg-white border border-1 shadow rounded-3 px-3 py-2 "
                     style="">
                    <div id="container-btn" class="d-flex justify-content-between align-items-center py-2" >
                        <p class="mb-0 small">Apa yang Anda pikirkan?</p>

                        <button id="btn-tanya" class="btn rounded-lg text-white px-3 py-2" title="Tanyakan sesuatu"  style="background: #FF6641 ;">
                            <span class="small fw-bold">Buat</span>
                        </button>
                    </div>

                    <form method="post" id="chat_form" style="display: none">
                        <div class="d-flex justify-content-between align-items-end mb-3">
                            <div class="flex-grow-1 pe-3">
                                <p class="fw-bold pt-2">Apa yang ingin Anda tanyakan?</p>
                                <textarea class="chat-text-area p-0 form-control border-0 bg-light me-3 p-2 small" id="chat_message" name="chat_message" rows="1" style="overflow-y: hidden !important; font-size: 14px" placeholder="Tulis pertanyaan Anda..." maxlength="500" wrap="hard" required></textarea>
                            </div>
                        </div>

                        <div id="container-btn" class="d-flex justify-content-between align-items-center py-2">
                            <span id="char-counter" class="small text-mute" style="font-size: 12px">500</span>
                            <button id="timer" class=" btn btn-send px-3 py-2 text-white fw-bold" disabled title="Harap menunggu"  style="background-color: #FF6641; display:none;">
                                <div  class=" spinner-border spinner-border-sm border-3 small" ></div>
                                <span class="fw-normal small ms-2"> Tunggu...</span>
                            </button>
                            <button type="submit" name="send" id="send" class=" btn btn-send px-3 py-2 text-white small fw-bold" title="Kirim pertanyaan"  style="background-color: #FF6641; " disabled>
                                <span class="small fw-bold">Kirim</span>
                            </button>

                        </div>
                    </form>

                </div>
            </div>
        </div>

        <?php
            echo "<input type='hidden' name='login_id_sesi' id='login_id_sesi' value='".$sesi_id."'/>";
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

        <!-- fungsi tombol sidebar-->
        <script>
            $("body").on("click", "#sidebar-pertanyaan", function() {
                $(this).parent().find('.active').removeClass('active')
                $('#badge-pertanyaan').hide()
                $(this).addClass('active')
                $('#pesan-admin-container').hide();
                $('#conversation-container').show();
                $('#catatan-container').hide();
                $('#footer-container').hide();
            })
            $("body").on("click", "#sidebar-pesan-admin", function() {
                $(this).parent().find('.active').removeClass('active')
                $('#badge-pesan-admin').hide()
                $(this).addClass('active')
                $('#pesan-admin-container').show();
                $('#conversation-container').hide();
                $('#catatan-container').hide();
                $('#footer-container').hide();
            })
            $("body").on("click", "#sidebar-catatan", function() {
                $(this).parent().find('.active').removeClass('active')
                $(this).addClass('active')
                $('#pesan-admin-container').hide();
                $('#conversation-container').hide();
                $('#catatan-container').show();
                $('#footer-container').show();
            })
        </script>

        <!-- fungsi pesan admin & note-->
        <script>
            let p = 0;
            let p_x_waktu = [];
            function get_pesan_admin() {
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
                            if( data1[i].id_event == sesi_id && data1[i].is_deleted == 0)
                            {
                                console.log(data1[i])
                                list_data =
                                    `
                                     <div id="container-pesan-admin-${data1[i].id_pesan}" class="p-4 rounded-3 pesan-admin border border-1 mb-3">
                                        <div class="d-flex">
                                            <p id="pesan-admin-${data1[i].id_pesan}" class="mb-0 isi-pesan-admin flex-grow-1">
                                                ${escapeHtml(data1[i].isi_pesan)}
                                            </p>
                                        </div>

                                        <div class="card-footer bg-transparent">
                                            <div class="d-flex justify-content-between align-items-center mt-3 ">
                                                <div class="d-flex align-items-center ">
                                                    <div id="container-nama-waktu-pesan-admin" class="small align-self-center">
                                                        <p id="jam-pesan-admin-p${p}" class="jam-pesan-admin text-black-50 small mb-0 ">${moment(data1[i].date).fromNow()}</p>
                                                        <p class="waktu-kirim d-none" id="waktu_pengiriman_p_${p}">${data1[i].date}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    `

                                $('#container-pesan-admin').append(list_data);
                                p_x_waktu.push(data1[i].date);
                                p=p+1
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
            get_pesan_admin()

            let n = 0;
            let n_x_waktu = [];
            function get_note() {
                $.ajax({
                    url: '../get_note.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data1, textStatus, xhr) {
                        let list_data = ''
                        console.log(data1)
                        let sesi_id = $('#login_id_sesi').val();
                        let admin_id = $('#login_id_admin').val();

                        for (let i=0;i<data1.length;i++) {
                            console.log(data1[i].is_deleted == 0)
                            if( data1[i].id_event == sesi_id && data1[i].is_deleted == 0)
                            {
                                console.log(data1[i])
                                list_data =
                                    `
                                     <div id="container-note-${data1[i].id_note}" class="p-4 rounded-3 note border border-1 mb-3">
                                        <div class="d-flex">
                                            <p id="note-${data1[i].id_note}" class="mb-0 isi-note flex-grow-1" style="">
                                                ${escapeHtml(data1[i].isi_note)}
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
                                                <div id="container-btn-note-${data1[i].id_note}">
                                                    <button id="btn-delete-note-${data1[i].id_note}" class="btn btn-delete-note bg-danger bg-opacity-10 border-0 rounded-3 py-1 px-3 me-0 text-muted" title="Hapus pesan">
                                                        <i class="bi bi-trash3 text-danger "></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    `

                                $('#container-note').append(list_data);
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

            $("#btn-tanya").click(function(){
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

                if($('#chat_message').val() !== ''){
                    $('#send').removeAttr('disabled')
                }
                else{
                    $('#send').attr('disabled','true')
                }
            });

            // Proses Pengiriman Pesan
            $('#chat_form').on('submit', function (event) {
                event.preventDefault();
                $('#badge-baru').remove()
                // get message
                // let isi_pesan = `<pre id="note-${data1[i].id_note}" class="mb-0 isi-note flex-grow-1" style="">${$('#chat_message').val()}</pre>`
                let isi_pesan = $.trim($('#chat_message').val())

                console.log(isi_pesan)

                $.ajax({
                    url: "../insert_note.php",
                    type: "POST",
                    cache: false,
                    data:{
                        isi_note: isi_pesan,
                        id_event : $('#login_id_sesi').val(),
                    },
                    success: function(dataResult){
                        console.log(this.data)
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode===200){
                            console.log('Data updated successfully ! '+dataResult.id);
                            let elements=
                                `
                                <div id="container-note-${dataResult.id}" class="p-4 rounded-3 note border border-1 mb-3">
                                    <div class="d-flex">
                                        <p id="note-${dataResult.id}" class="mb-0 isi-note flex-grow-1">
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

                            $("#container-note").append(elements);
                            n_x_waktu.push(moment().format('YYYY-MM-DD HH:mm:ss'));
                            n=n+1

                            $("#timer-kirim").show();
                            $("#btn-kirim").hide();

                            $('#chat_message').val('')
                            $("#chat_form").hide();
                            $("#container-btn").addClass('d-flex').show()

                            console.log(dataResult.id)
                            // scroll
                            window.scrollTo(0, $('#container-note-'+dataResult.id).offset().top - $('#container-note').offset().top + $('#container-note').scrollTop());

                            setTimeout(function () {
                                $('#container-note-'+dataResult.id).css({
                                    "background-color" : 'rgba(25,135,84,0.1)',
                                });

                                $('#note-'+dataResult.id).parent().
                                append(`<span id="badge-baru" class="badge bg-primary text-primary bg-opacity-10" style="height: fit-content;">Baru</span>`)
                            },500)

                            setTimeout(function () {
                                $('#container-note-'+dataResult.id).css({
                                    "background-color" : 'white',
                                });
                                console.log("ganti warna")
                            },1500)

                            // $('#toast-create').show()
                            setTimeout(function () {
                                $("#timer-kirim").hide();
                                $("#btn-kirim").show();
                                // $('#toast-create').hide()
                            }, 3000)
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    }

                })


            });
        </script>

        <!-- fungsi scroll to top-->
        <script>
            window.scrollTo(0, 0);
            $('#fab-scroll').css({'display':'none'})
            // When the user scrolls down 20px from the top of the document, show the button
            window.onscroll = function() {scrollFunction()};

            function scrollFunction() {
                if (document.body.scrollTop > 30 || document.documentElement.scrollTop > 30) {
                    $('#fab-scroll').css({'display':'block'})
                } else {
                    $('#fab-scroll').css({'display':'none'})
                }
            }

            $("body").on("click", "#fab-scroll", function() {
                // When the user clicks on the button, scroll to the top of the document
                console.log($('body').offset().top)
                window.scrollTo(0, 0);
            })
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

                $(".avatar>span:contains('Q'), .avatar>span:contains('W'), .avatar>span:contains('N'), .avatar>span:contains('M')").parent().css({"background-color": warna2[0], "color": warna[0]});
                $(".avatar > span:contains('E'), .avatar > span:contains('R')").parent().css({"background-color": warna2[1], "color": warna[1]});
                $(".avatar > span:contains('T'), .avatar > span:contains('Y')").parent().css({"background-color": warna2[2], "color": warna[2]});
                $(".avatar>span:contains('U'), .avatar>span:contains('I')").parent().css({"background-color": warna2[3], "color": warna[3]});
                $(".avatar > span:contains('O'), .avatar > span:contains('P')").parent().css({"background-color": warna2[4], "color": warna[4]});
                $(".avatar>span:contains('D'), .avatar>span:contains('F'), .avatar > span:contains('V'), .avatar > span:contains('B')").parent().css({"background-color": warna2[7], "color": warna[7]});
                $(".avatar > span:contains('G'), .avatar > span:contains('H')").parent().css({"background-color": warna2[16], "color": warna[16]});
                $(".avatar > span:contains('J'), .avatar > span:contains('K')").parent().css({"background-color": warna2[8], "color": warna[8]});
                $(".avatar>span:contains('L'), .avatar>span:contains('Z')").parent().css({"background-color": warna2[12], "color": warna[12]});
                $(".avatar > span:contains('X'), .avatar > span:contains('C'), .avatar > span:contains('A'), .avatar > span:contains('S')").parent().css({"background-color": warna2[11], "color": warna[11]});
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
            let jam_p = p_x_waktu;
            let jam_n = n_x_waktu;

            function setFormatJam() {
                console.log(jam_j)
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
                for(let p=0; p<jam_p.length; p++){
                    let status_jam_p = moment(jam_p[p]).fromNow();
                    $("#jam-pesan-admin-p"+p).text(status_jam_p)
                }
                for(let n=0; n<jam_n.length; n++){
                    let status_jam_n = moment(jam_n[n]).fromNow();
                    $("#jam-pesan-admin-n"+n).text(status_jam_n)
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

            // fungsi filter terjawab-ditolak
            $('input:checkbox[name="checkbox-terjawab"]').change(function() {
                if ($(this).is(":checked") === true) {
                    console.log('true Check')
                    // show pertanyaan ditolak terjawab - hide pertanyaan all
                    $('#container-pesan-ditolak-terjawab').removeClass('d-none')
                    $('#container-pesan').addClass('d-none')
                    // show jumlah pertanyaan ditolak terjawab - hide jumlah pertanyaan all
                    $('#jumlah-pertanyaan-ditolak-terjawab').removeClass('d-none')
                    $('#jumlah-pertanyaan').addClass('d-none')
                    // show badge
                    $('#badge-ditolak-terjawab').removeClass('d-none')
                    // reset search
                    $("#search-pertanyaan").val('')
                } else {
                    console.log('else')
                    // show pertanyaan all - hide pertanyaan ditolak terjawab
                    $('#container-pesan-ditolak-terjawab').addClass('d-none')
                    $('#container-pesan').removeClass('d-none')
                    // show jumlah pertanyaan ditolak terjawab - hide jumlah pertanyaan all
                    $('#jumlah-pertanyaan-ditolak-terjawab').addClass('d-none')
                    $('#jumlah-pertanyaan').removeClass('d-none')
                    // hide badge
                    $('#badge-ditolak-terjawab').addClass('d-none')
                    // reset search
                    $("#search-pertanyaan").val('')
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
                } else {
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
                let maxChar = 500
                let count = $("#chat_message").val().length
                let remaining = maxChar - count

                $("#char-counter").text(remaining)
            }

            // function char counter dinamis
            $("#chat_message").on('keyup', function(e) {
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
            var conn = new WebSocket('ws://0.tcp.ap.ngrok.io:18858');
            conn.onopen = function(e) {
                console.log("Connection established!");
            };
            let j= <?php echo $j; ?>;
            $(document).ready(function(){
                conn.onmessage = function(e) {
                    console.log("websocket:" +e.data);

                    var sesi_id1 = $('#login_id_sesi').val();
                    var data1 = JSON.parse(e.data);

                    console.log(data1)

                    if(data1.asal === 'admin'){
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
                                    $('#badge-pertanyaan').show()
                                    list_data =
                                    `<div id="container-pesan-${data1.mId}" class="p-4 rounded-3 mb-3 pesan-terpilih border border-1">
                                        <div class="d-flex">
                                            <p id="pesan-${data1.mId}" class="mb-0 small isi-pesan flex-grow-1">
                                                ${data1.msg}
                                            </p>
                                        </div>

                                        <div class="card-footer bg-transparent mt-4">
                                            <div class="d-flex justify-content-between align-items-center mt-3 ">
                                                <div class="d-flex align-items-center ">
                                                    <button class="avatar small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled><span>${nama_depan}</span></button>
                                                    <div id="container-nama-waktu-${data1.mId}" class="small align-self-center ms-2">
                                                        <p id="nama-peserta-form-${data1.userId}" class="nama text-truncate fw-bold mb-0">${nama}</p>
                                                        <p id="jam-pesan-j${j}" class="jam text-black-50 small mb-0 ">
                                                            ${moment(data1.date).fromNow()}
                                                        </p>
                                                        <p class="waktu-kirim d-none" id="waktu_pengiriman_j_${j}">${data1.date}</p>
                                                    </div>
                                                </div>

                                                <div id="container-btn-${data1.mId}" class="container-btn">
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

                                    $('#container-pesan-terpilih').append(list_data);
                                    j=j+1
                                }


                            },
                            complete: function (data) {
                                if( data1.sesiId === sesi_id1 ) {
                                    $('#badge-baru').remove()

                                    ubahWarnaAvatar();

                                    jam_j[jam_j.length] = data1.dat
                                    if( $('#radio-terbaru-live').is(':checked') ){
                                        $('#container-pesan-terpilih .pesan-terpilih').sort(sortTerbaru).appendTo('#container-pesan-terpilih')
                                        console.log("terbaru")
                                    }
                                    else if ($('#radio-terlama-live').is(':checked')){
                                        $('#container-pesan-terpilih .pesan-terpilih').sort(sortTerlama).appendTo('#container-pesan-terpilih')
                                        console.log("terlama")
                                    }

                                    setTimeout(function() {
                                        setFormatJam()
                                        counter()
                                        //scroll ke pesan terbaru
                                        $('#container-pesan-terpilih').animate({
                                            scrollTop: $('#container-pesan-'+data1.mId).offset().top - $('#container-pesan-terpilih').offset().top + $('#container-pesan-terpilih').scrollTop()
                                        }, 500);
                                    }, 100);

                                    setTimeout(function () {
                                        $('#container-pesan-'+data1.mId).css({
                                            "background-color" : 'rgba(25,135,84,0.1)',
                                        });

                                        $('#pesan-'+data1.mId).parent().append(`<span id="badge-baru" class="badge bg-primary text-primary bg-opacity-10" style="height: fit-content;">Baru</span>`)

                                        // nambah badge edited
                                        $.ajax({
                                            url: "../get_is_edited_messages.php",
                                            type: 'POST',
                                            cache: false,
                                            dataType: 'json',
                                            data:{
                                                id_message: data1.mId,
                                            },
                                            success: function(data, textStatus, xhr) {
                                                console.log(typeof data[0].is_edited)
                                                if( data[0].is_edited === '1' ){
                                                    console.log(data[0].is_edited)
                                                    if($('#pesan-'+data1.mId).children().hasClass('badge-edited') === false) {
                                                        $('#pesan-' + data1.mId).append(`<span class="badge-edited small mb-0 text-muted"> (edited)</span>`)
                                                    }
                                                }
                                            }
                                        })
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
                    else if(data1.asal === 'user-delete'|| data1.asal === 'admin-terpilih'){
                        $('#container-pesan-'+data1.mId).remove()
                    }
                    else if(data1.asal === 'user-profil'){
                        console.log(data1.userId + ' '+ data1.namaUser)
                        $("p#nama-peserta-form-"+data1.userId).text(data1.namaUser)
                        $("p#nama-peserta-form-"+data1.userId).parent().siblings('.avatar').children().text(data1.namaUser.charAt(0))
                        ubahWarnaAvatar();
                    }
                    else if(data1.asal === 'admin-note'){
                        console.log(data1)

                        if( data1.sesiId === sesi_id1 )
                        {
                            $('#badge-pesan-admin').hide()
                            p=p+1
                            list_data =
                                `
                                 <div id="container-pesan-admin-${data1.mId}" class="p-4 rounded-3 pesan-admin border border-1 mb-3">
                                    <div class="d-flex">
                                        <p id="pesan-admin-${data1.mId}" class="mb-0 isi-pesan-admin flex-grow-1">
                                            ${escapeHtml(data1.msg)}
                                        </p>
                                    </div>

                                    <div class="card-footer bg-transparent">
                                        <div class="d-flex justify-content-between align-items-center mt-3 ">
                                            <div class="d-flex align-items-center ">
                                                <div id="container-nama-waktu-pesan-admin" class="small align-self-center">
                                                    <p id="jam-pesan-admin-p${p}" class="jam-pesan-admin text-black-50 small mb-0 ">${moment(data1.date).fromNow()}</p>
                                                    <p class="waktu-kirim d-none" id="waktu_pengiriman_p_${p}">${data1.date}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `

                            $('#container-pesan-admin').append(list_data);
                            p_x_waktu.push(data1.date);

                            $('#toast-pesan-admin').show()
                            setTimeout(function () {
                                $('#toast-pesan-admin').hide()
                            },5000)
                        }
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
            $.ajax({
                url: '../get_events_public.php',
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

                            $('p#event-name-offcanvas, p#event-name-navbar').text(nama_event)
                            $('p#event-code').text("#"+data[i].unique_code.toUpperCase())
                            $('p#date').text(day + ", " + date)
                            $('p#time').text(time_begin + " - " + time_end + " WIB")

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
            $("body").on("click", ".btn-cancel", function() {
                $('#modal-terjawab').modal('hide');
            })

            //fungsi button terjawab
            $("body").on("click", ".btn-terjawab", function() {
                $('#badge-baru').remove()

                let id_element = $(this).parent().attr('id');
                let id_numb = id_element.split("-");
                let idm = id_numb[2]

                let parent_element = $('#container-pesan-'+idm);

                // $.ajax({
                //     url: "../update.php",
                //     type: "POST",
                //     cache: false,
                //     data:{
                //         status: '2',
                //         id_message: idm,
                //     },
                //     success: function(dataResult){
                //         var dataResult = JSON.parse(dataResult);
                //         if(dataResult.statusCode==200){
                //             console.log('Data updated successfully ! '+idm+' apa');
                //         }
                //     }
                // });

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

                $('#modal-terjawab').modal('show');

                $("body").on("click", "#btn-confirm", function() {
                    console.log(id_k[2])

                    console.log("udah pindah")
                    parent_element.remove()
                    $("#timer-confirm").show();
                    $("#btn-confirm").hide();

                    setTimeout(function () {
                        $("#timer-confirm").hide();
                        $("#btn-confirm").show();
                        $('#toast-answer').show()
                        // Proses Pengiriman Pesan
                        var id_sesi = $('#login_id_sesi').val();
                        var data = {
                            asal: 'moderator-terpilih',
                            userId: id_user,
                            mId: idm,
                            msg: cust_message,
                            sesiId: id_sesi,
                            date: jam_pesan_hidden,
                        };
                        conn.send(JSON.stringify(data));
                    }, 2500)
                    setTimeout(function () {
                        $('#modal-terjawab').modal('hide');
                        // window.location.reload();
                    }, 3500)
                    setTimeout(function () {
                        $('#toast-answer').hide()
                    }, 5000)



                })
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
                                    <button id="btn-love-${l}" class="btn btn-love text-danger bg-transparent border-0 rounded-3 py-1 px-1 ms-1"  data-bs-toggle="tooltip" data-bs-title="Favoritkan pertanyaan" style="color: #FF417B">
                                        <i class="bi bi-heart-fill"></i>
                                    </button>
                                    <button id="btn-presentasi-${l}" class="btn btn-presentasi bg-transparent border-0 rounded-3 py-1 px-1 ms-1 bg-opacity-10" style="color: #FF6641" data-bs-toggle="tooltip" data-bs-title="Tampilkan di presentasi"><i class="bi bi-easel me-1"></i>
                                    </button>
                                    <button id="btn-terjawab-${l}" class="btn btn-terjawab bg-success border-0 rounded-3 py-1 px-3 ms-1"  data-bs-toggle="tooltip" data-bs-title="Tandai sebagai terjawab" >
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

                // update
                // $.ajax({
                //     url: "../update.php",
                //     type: "POST",
                //     cache: false,
                //     data:{
                //         status: status_pesan,
                //         id_message: idm,
                //     },
                //     success: function(dataResult){
                //         var dataResult = JSON.parse(dataResult);
                //         if(dataResult.statusCode==200){
                //             console.log('Data updated successfully ! '+idm+' apa');
                //         }
                //     }
                // });

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
                var id_sesi = $('#login_id_sesi').val();
                var data = {
                    asal: 'moderator-favorit',
                    userId: id_user,
                    mId: idm,
                    msg: cust_message,
                    sesiId: id_sesi,
                    date: jam_pesan_hidden,
                };
                conn.send(JSON.stringify(data));
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

                console.log(status_pesan)
                /* nambah badge dipresentasikan dan */

                // $.ajax({
                //     url: "../update.php",
                //     type: "POST",
                //     cache: false,
                //     data:{
                //         status: status_pesan,
                //         id_message: idm,
                //     },
                //     success: function(data){
                //         let dataResult = JSON.parse(data);
                //         if(dataResult.statusCode==200){
                //             console.log(idm+' dipresentasikan');
                //         }
                //     }
                // });

                // Proses Pengiriman Pesan
                var id_sesi = $('#login_id_sesi').val();
                var data = {
                    asal: 'moderator-presentasi',
                    userId: id_user,
                    mId: idm,
                    msg: cust_message,
                    sesiId: id_sesi,
                    status: status_pesan.toString(),
                    date: jam_pesan_hidden,
                };
                conn.send(JSON.stringify(data));
            })

        </script>

        <!-- enable tooltips bootstrap-->
        <script>
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        </script>

    </body>
</html>