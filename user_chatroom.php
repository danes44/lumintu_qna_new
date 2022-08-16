<?php

    require('database/ChatRooms.php');
    include("crypt.php");
    include("get_nama.php");

    $chat_object = new ChatRooms;

    $chat_data = $chat_object->get_all_chat_data();

    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    // $uri_segments = explode('/', $uri_path);
    $hasilHash = mycrypt("decrypt", $uri_path);
    $arrayHasil = explode("&", $hasilHash);
    $peserta_id = explode("=",$arrayHasil[0]);
    $ticket_id = explode("=",$arrayHasil[1]);
    $sesi_id = explode("=",$arrayHasil[2]);

    $nama_peserta = get_nama($peserta_id[1]);
    $i_x_waktu = array();

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
<!--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="css-js/qna/style.css" rel="stylesheet">

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">

<!--    <script src="vendor-front/jquery/jquery.min.js"></script>-->
<!--    <script src="vendor-front/bootstrap/js/bootstrap.bundle.min.js"></script>-->

    <!-- Core plugin JavaScript-->
<!--    <script src="vendor-front/jquery-easing/jquery.easing.min.js"></script>-->
<!---->
<!--    <script type="text/javascript" src="vendor-front/parsley/dist/parsley.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
    <script src="http://parsleyjs.org/dist/parsley.js"></script>
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
                <div id="dropdownProfile" class="dropdown">
                    <button class="small border-0 rounded-pill ms-0 text-white bg-primary fw-bold"
                        style="width: 2rem; height:2rem;" data-bs-toggle="dropdown">
                        <?php
                            $huruf_depan = $nama_peserta[0];
                            echo $huruf_depan;
                        ?>
                    </button>
                    <ul class="dropdown-menu">
                        <li><span class="small dropdown-item-text fw-bold">
                                <?php
                                echo $nama_peserta;
                            ?>
                            </span></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="small dropdown-item justify-content-between" href="#">
                                <i class="bi bi-box-arrow-right me-3"></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>
                <div id="offcanvasProfileContainer">
                    <button id="buttonOffCanvas" class="small border-0 rounded-pill ms-0 text-white bg-primary fw-bold"
                        style="width: 2.2rem; height:2.2rem;" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvasProfile" aria-controls="offcanvasProfile">
                        <?php
                            $huruf_depan = $nama_peserta[0];
                            echo $huruf_depan;
                        ?>
                    </button>
                    <div class="offcanvas offcanvas-bottom border-0 shadow rounded-top" data-bs-backdrop="true"
                        style="height: inherit;" tabindex="-1" id="offcanvasProfile"
                        aria-labelledby="offcanvasProfileLabel">
                        <div class="offcanvas-body">
                            <span class="text-black fw-bold">
                                <?php
                                    echo $nama_peserta;
                                ?>
                            </span>
                            <hr class="text-black">
                            <a class="text-decoration-none text-black justify-content-between" href="#">
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
                        foreach($chat_data as $chat)
                        {
                            $str1 = str_split($chat["waktu_pengiriman"], 10);
                            $jam_pesan = str_split($str1[1], 6);
                            // if id_participant = $chat["id_pengirim"] then
                            // $abc = base64_decode($_GET["id_participant"]);
                            if ($chat["id_pengirim"] == $peserta_id[1] && $chat["id_chat"] == $sesi_id[1]){
                                // simpan id dan waktu ke array
                                $i_x_waktu[$i] = $chat["waktu_pengiriman"];
                                // print element html
                                echo
                                '<div id="container-pesan-'.$i.'" class="mb-3 mx-3 p-3 border border-1 rounded-3">
                                    <p class="mb-0 small ">
                                        '.$chat["pesan"].'
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center mt-3 ">
                                        <p id="jam-pesan-'.$i.'" class="text-black-50 small mb-0 ">
                                            '.$jam_pesan[0].'
                                        </p>
                                        <button id="btn-delete" class="btn bg-danger bg-opacity-10 border-0 rounded-3 py-1 me-0 text-muted"  title="Hapus pertanyaan" style="width: 50px;">
                                            <i class="bi bi-trash3 text-danger "></i>
                                        </button>
                                    </div>
                                </div> ';
                                $i++;
                            }
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
                        <span class="small fw-bold">Tanyakan sesuatu</span>
                    </button>
                </div>

                <form method="post" id="chat_form" data-parsley-errors-container="#validation_error" style="display: none">
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="flex-grow-1 pe-3">
                            <p class="fw-bold pt-2">Apa yang ingin Anda tanyakan?</p>
                            <textarea class="chat-text-area p-0 form-control border-0 me-3 small" id="chat_message"
                                name="chat_message" rows="1" style="overflow-y: hidden !important; font-size: 14px" placeholder="Tulis pertanyaan Anda..." maxlength="400" required></textarea>
                        </div>
                        <div class="text-center align-items-end">
                            <span id="char-counter" class="small text-mute" style="font-size: 12px">400</span>

                        </div>
                    </div>

                    <div id="container-btn" class="d-flex align-items-center py-2">
                        <button class=" small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                            <?php
                                $huruf_depan = $nama_peserta[0];
                                echo $huruf_depan;
                            ?>
                        </button>
                        <p id="nama-peserta-form" class="small align-self-center ms-2 text-truncate mb-0"> <?php echo $nama_peserta; ?> </p>

                        <button id="timer" class="ms-auto btn btn-send px-3 py-2 text-white fw-bold" disabled title="Harap menunggu"  style="background-color: #FF6641; display:none;">
                            <div  class=" spinner-border spinner-border-sm border-3 small" ></div>
                            <span class="fw-normal small ms-2"> Tunggu...</span>
                        </button>
                        <button type="submit" name="send" id="send" class="ms-auto btn btn-send px-3 py-2 text-white small fw-bold" title="Kirim pertanyaan"  style="background-color: #FF6641; ">
                            <span class="small fw-bold">Kirim</span>
                        </button>

                    </div>
                </form>

            </div>
        </div>

    <?php 
        echo "
        <input type='hidden' name='login_user_id' id='login_user_id' value='".$peserta_id[1]."'/>
        <input type='hidden' name='login_id_sesi' id='login_id_sesi' value='".$sesi_id[1]."'/>
        <input type='hidden' name='login_id_ticket' id='login_id_ticket' value='".$ticket_id[1]."'/>";

    ?>


    <!-- moment Js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment-with-locales.min.js"></script>

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

    <!--    autogrow textarea function-->
    <script>
        // function counter characters
        function charCounter() {
            var maxChar = 400
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
        $("#btn-tanya").click(function(){
            $("#chat_form").show();
            $("#container-btn").removeClass('d-flex')
            $("#container-btn").hide()
            charCounter()
        });
        //fungsi close ketika klik luar element
        $(document).mouseup(function(e)
        {
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
            var jam = <?php echo json_encode($i_x_waktu); ?>;

            for(let i=0; i<jam.length; i++){
                let status_jam = moment(jam[i]).fromNow();
                $("#jam-pesan-"+i).text(status_jam)

            }
        }, 60 * 1000);

        var jam = <?php echo json_encode($i_x_waktu); ?>;

        for(let i=0; i<jam.length; i++){
            let status_jam = moment(jam[i]).fromNow();
            $("#jam-pesan-"+i).text(status_jam)

        }
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
        $(document).ready(function () {
            let i = <?php echo $i ?>;
            var conn = new WebSocket('ws://localhost:8082'); //dibuat dinamis
            // var conn = new WebSocket('ws://0.tcp.ngrok.io:14538'); //dibuat dinamis
            conn.onopen = function (e) {
                console.log("Connection established!");
            };

            conn.onmessage = function (e) {
                console.log(e.data);

                var data = JSON.parse(e.data);
                var row_class = '';
                var background_class = '';
                var html_data = '';
                var msg1 = escapeHtml(data.msg);

                if (data.from == 'Me') {
                    html_data = "<div id='container-pesan-<?php echo $i ?>' class='mb-3 mx-3 p-3 border border-1 rounded-3'><p class='mb-0 small'>" + msg1 + "</p><div class='d-flex justify-content-between align-items-center mt-3 '><p id='jam-pesan-<?php echo $i ?>' class='text-black-50 small mb-0'>" + moment().fromNow() + "</p><button id='btn-delete-' class='btn bg-danger bg-opacity-10 rounded-pill py-1 me-0 text-muted'  title='Hapus pertanyaan'><i class='bi bi-trash3 text-danger'></i></button></div></div>"
                }

                $('#messages_area').append(html_data);
                $('html, body').animate({
                    scrollTop: $('#container-pesan-'+i).offset().top - $('html, body').offset().top + $('html, body').scrollTop()
                }, 500);
                $("#chat_message").val("");
            };

            // Proses Pengiriman Pesan
            $('#chat_form').on('submit', function (event) {

                event.preventDefault();

                // if ($('#chat_form').parsley().isValid()) {

                    var user_id = $('#login_user_id').val();
                    var message_id = ''
                    var id_sesi = $('#login_id_sesi').val();
                    var message = $('#chat_message').val();
                    var date = moment().format("YYYY-MM-DD HH:mm:ss")
                    var data = {
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
                // }
            });

        }); 
    </script>
    <script>
        var id_tiket = $('#login_id_ticket').val();
        var id_tiket_session = $('#login_id_sesi').val();
        $.ajax({
            url: kel1_api + '/items/ticket?fields=ticket_id,ticket_type,ticket_x_session.session_id.*,ticket_x_day.day_id.*',
            type: 'GET',
            dataType: 'json',
            success: function (data, textStatus, xhr) { //callback - pengganti promise
                // data.data.map(item => {
                console.log(data.data[id_tiket - 1].ticket_x_session[id_tiket_session - 1].session_id.start_time)
                let nama = data.data[id_tiket - 1].ticket_x_session[id_tiket_session - 1].session_id.session_desc
                let time_start = new Date(data.data[id_tiket - 1].ticket_x_session[id_tiket_session - 1].session_id.start_time)
                let time_finish = new Date(data.data[id_tiket - 1].ticket_x_session[id_tiket_session - 1].session_id.finish_time)

                let day = moment(time_start).format('dddd')
                let time_begin = moment(time_start).format('HH:mm')
                let time_end = moment(time_finish).format('HH:mm')
                let date = moment(time_start).format('LL')

                // $('#24365    87').text(day+", "+date+" | "+time_begin+" - "+time_end+" WIB")

                $('.nama_sesi').text(nama)
                $('#date').text(day + ", " + date)
                $('#time').text(time_begin + " - " + time_end + " WIB")

                // }) 
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log('Error in Database');
            }
        })
    </script>

    <!-- Bootstrap Bundle with Popper -->
<!--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>-->

</body>

</html>