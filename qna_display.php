<?php
    require('database/ChatRooms.php');
    include("get_nama.php");
    include("cek_qchoosen.php");
//    // panggil fungsi enkripsi
    include("crypt.php");

    $chat_object = new ChatRooms;

    $chat_data = $chat_object->get_all_chat_data();

    $uri_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    $hasilHash = mycrypt("decrypt", $uri_path);
    $arrayHasil = explode("&", $hasilHash);
    $arr_sesi_id = explode("=",$arrayHasil[0]);
    $sesi_id = $arr_sesi_id[1];
//    var_dump($_GET);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Display QnA</title>

        <script src="api.js"></script>
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
        <!-- cdn script-->
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="http://parsleyjs.org/dist/parsley.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
        <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
        <script src="chat.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/davidshimjs-qrcodejs@0.0.2/qrcode.min.js" integrity="sha256-xUHvBjJ4hahBW8qN9gceFBibSFUzbe9PNttUvehITzY=" crossorigin="anonymous"></script>
        <!-- moment Js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment-with-locales.min.js"></script>
        <!-- Custom styles for this template -->
        <link href="./css-js/styleDisplay.css" rel="stylesheet">
        <!-- Bootstrap Icon -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">

    </head>
    <body style="background-color: #ffffff;max-height: 100vh">
        <!-- QnA  -->
        <div class="container pb-5 vh-100 position-relative">
            <div class="d-flex mb-4 pt-4 justify-content-center">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="./assets/Logo QnA.svg" class="img-fluid text-center" width="14%" alt="...">
                    <h2 class="align-middle fw-bold mb-0 ps-3 ">QnA</h2>
                </div>
                <!--<button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>
                <button id="btn-test" class="btn btn-primary" data-bs-target="#carouselExampleControls" data-bs-slide="next">test</button>-->
            </div>

            <!-- Modal QR COde-->
            <div class="modal fade" id="modal-qrcode" data-bs-keyboard="true" tabindex="-1" aria-labelledby="modal-create-label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered justify-content-center">
                    <div class="modal-content py-2 px-4" style="width: auto">
                        <div class="modal-header border-0 pb-0">
                            <h6 class="modal-title fw-bold " id="staticBackdropLabel" >QR Code Sesi <span id="kode-sesi-modal" class="text-uppercase"></span>
                            </h6>
                        </div>
                        <div class="modal-body pb-0">
                            <div id="qrcode2" ></div>
                        </div>
                        <div class="modal-footer border-0 pt-3">
                            <button id="btn-tutup" class="btn btn-cancel border border-1 rounded-3 py-2 px-3 me-0 text-muted fw-semibold float-end"  title="Tutup gambar" style="font-size: .875em">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card text white  border rounded-3 p-5 mt-3" style="background-color: white; width: 100%;">
                <div id="carouselExampleControls" class="carousel carousel-dark slide h-100" data-bs-interval="false" >
                    <div class="carousel-inner" id="qna_display">
                        <?php
                            if ((cek_qchoosen($sesi_id)) == "2"){
                                echo '<div class="carousel-item active">
                                    <div class="container  px-5" >
                                    <h3 class="card-title text-dark mx-3 px-5">
                                    Belum ada pertanyaan.
                                    </h3>
                                    <hr class=" mt-5 mx-5 ">
                                    <h3 class=" mx-3 px-5 fw-bold">silahkan menunggu</h3S>
                                </div>
                                </div>';
                            } else {
                                echo '<div class="carousel-item active">
                                        <div class="container  px-5" >
                                            <h3 class="card-title text-dark mx-3 px-5">Pertanyaan pertama ada di samping.</h3>
                                            <hr class=" mt-5 mx-5 ">
                                            <h3 class=" mx-3 px-5 fw-bold">Silahkan digeser.</h3S>
                                        </div>
                                    </div>';
                                $panjang1 = sizeof($chat_data)-1;

                                for($x = 0; $x <= $panjang1; $x++){
                                    $nama_peserta1 = get_nama($chat_data[$x]["id_pengirim"]);

                                    if ($chat_data[$x]["id_chat"] == $sesi_id && ($chat_data[$x]["status"]==1 || $chat_data[$x]["status"]==4)){
                                        echo '<div id="carousel-item-'.$chat_data[$x]["id_message"].'" class="carousel-item">
                                            <div class="container px-5" >
                                                <h3 class="card-title text-dark mx-3 px-5">
                                                '.$chat_data[$x]["pesan"].'
                                                </h3>
                                                <hr class=" mt-5 mx-5 ">
                                                <h3 id="nama-cust-'.$chat_data[$x]["id_message"].'" class=" mx-3 px-5 fw-bold">
                                                    '.$nama_peserta1.'
                                                </h3>
                                            </div>
                                        </div>';
                                    }
                                }
                            }
                        ?>
                    </div>
                    <button class="carousel-control-prev position-absolute start-0" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next position-absolute end-0" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <!-- LAGI NGUTEKNGUTEK INI OKE-->
            <div class="align-items-center align-content-center align-self-center text-end">
                <p id="nama-sesi" class="card-title fw-bold mb-0"></p>
                <p id="kode-sesi" class="mb-0 small text-uppercase"></p>
                <p id="date-time" class="mb-0 small"></p>
            </div>
            <button id="btn-qrcode" class="ms-3 btn border border-1 p-2">
                <div id="qrcode" ></div>
            </button>
        </div>



        <?php
            echo "<input type='hidden' name='login_id_sesi' id='login_id_sesi' value='".$sesi_id."'/>";
            echo "<input type='hidden' name='login_id_ticket' id='login_id_ticket' value='".$sesi_id."'/>";
            echo "<input type='hidden' name='uri_path' id='uri_path' value='".$uri_path."'/>";
        ?>

        <script>
            moment.locale('id');
            console.log(moment(Date.now()).fromNow());
            // $('#btn-test').click(function () {
            //     let active_class = $('#qna_display').find('.active').attr('id')
            //     console.log($('#carousel-item-1156').index())
            //     $('#nama-cust-1156').append(`
            //         <span id="badge-baru" class="small ms-2 badge bg-primary text-primary bg-opacity-10" style="height: fit-content;">
            //             Terbaru
            //         </span>`)
            //     // $('#carouselExampleControls').carousel('next')
            // })
        </script>

        <!-- qr code generator-->
        <script>
            let encrypted_url = $('#uri_path').val()

            qrcode = new QRCode(document.getElementById("qrcode"), {
                text: "http://localhost:8081/lumintu_qna/index_user.php?"+encrypted_url,
                width: 40,
                height: 40,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
            qrcode = new QRCode(document.getElementById("qrcode2"), {
                text: "http://localhost:8081/lumintu_qna/index_user.php?"+encrypted_url,
                width: 400,
                height: 400,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });

            // button tutup
            $("body").on("click", "#btn-qrcode", function() {
                $('#modal-qrcode').modal('show');
            })
            // button tutup
            $("body").on("click", "#btn-tutup", function() {
                $('#modal-qrcode').modal('hide');
            })
        </script>

        <script>
            // var id_tiket = $('#login_id_ticket').val();
            // console.log(id_tiket)
            // var id_tiket_session = $('#login_id_sesi').val();
            // $.ajax({
            //     url: kel1_api+'/items/ticket?fields=ticket_id,ticket_type,ticket_x_session.session_id.*,ticket_x_day.day_id.*&filter[ticket_id]='+id_tiket,
            //     type: 'GET',
            //     dataType: 'json',
            //     success: function(data, textStatus, xhr) { //callback - pengganti promise
            //         // data.data.map(item => {
            //             console.log(data.data[0].ticket_x_session[id_tiket_session-1].session_id.start_time)
            //             let nama = data.data[0].ticket_x_session[id_tiket_session-1].session_id.session_desc
            //             let time_start = new Date(data.data[0].ticket_x_session[id_tiket_session-1].session_id.start_time)
            //             let time_finish = new Date(data.data[0].ticket_x_session[id_tiket_session-1].session_id.finish_time)
            //
            //             let day = moment(time_start).format('dddd')
            //             let time_begin = moment(time_start).format('HH:mm')
            //             let time_end = moment(time_finish).format('HH:mm')
            //             let date = moment(time_start).format('LL')
            //
            //             // $('#2436587').text(day+", "+date+" | "+time_begin+" - "+time_end+" WIB")
            //
            //             $('#nama_sesi').text(nama)
            //             $('#date').text(day+", "+date)
            //             $('#date-time').text(day+", "+date+" | "+time_begin+" - "+time_end+" WIB")
            //
            //         // })
            //     },
            //     error: function(xhr, textStatus, errorThrown) {
            //         console.log('Error in Database');
            //     }
            // })
            $.ajax({
                url: './get_events.php',
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


                            $('p#nama-sesi').text(nama_event)
                            $('#date-time').text(day + ", " + date + ' | '+ time_begin + " - " + time_end + " WIB")
                            $('p#kode-sesi').text("# "+data[i].unique_code)
                            $('#kode-sesi-modal').text("# "+data[i].unique_code)

                        }
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(textStatus);
                }
            })
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
            $(document).ready(function(){
                var port = '8082'
                // var conn = new WebSocket('ws://localhost:'+port);
                var conn = new WebSocket('ws://0.tcp.ap.ngrok.io:17289');
                conn.onopen = function(e) {
                    console.log("Connection established!");
                };

                conn.onmessage = function(e) {
                    console.log(e.data);

                    var sesi_id1 = $('#login_id_sesi').val();

                    var data1 = JSON.parse(e.data);
                    console.log(data1)

                    if(data1.asal === 'admin')
                    {
                        $.ajax({
                            url: './get_nama_participant.php',
                            type: 'POST',
                            data: {
                                id_participant: data1.userId,
                            },
                            success: function(data, textStatus, xhr) {
                                let list_data = ''
                                let dataResult = JSON.parse(data)
                                let nama = dataResult.nama

                                if( data1.sesiId === sesi_id1 )
                                {
                                    list_data =
                                        `<div id="carousel-item-${data1.mId}" class="carousel-item">
                                            <div class="container  px-5" >
                                                <h3 class="card-title text-dark mx-3 px-5">${escapeHtml(data1.msg)}</h3>
                                                <hr class=" mt-5 mx-5 ">
                                                <h3 id="nama-cust-${data1.mId}" class=" mx-3 px-5 fw-bold">${nama}</h3S>
                                            </div>
                                        </div>`
                                }

                                $('#qna_display').append(list_data);
                            },
                            complete: function (data) {
                                // $('#carouselExampleControls').carousel($('#carousel-item-'+data1.mId).index())

                                setTimeout(function () {
                                    $('#carousel-item-'+data1.mId).parent().parent().parent().css({
                                        "background-color" : 'rgba(25,135,84,0.1)',
                                    });
                                    $('#nama-cust-'+data1.mId).append(`<span id="badge-baru" class="small ms-2 badge bg-primary text-primary bg-opacity-10" style="height: fit-content;">Terbaru</span>`)
                                },500)

                                setTimeout(function () {
                                    $('#carousel-item-'+data1.mId).parent().parent().parent().css({
                                        "background-color" : 'white',
                                    });
                                    console.log("ganti warna")
                                },1500)
                            }
                        })
                    }
                    else if(data1.asal === 'admin-terpilih')
                    {
                        let id_active = 'carousel-item-'+data1.mId
                        console.log(id_active)
                        if($('#carouselExampleControls').find('.active').attr('id') === id_active) {
                            $('#carouselExampleControls').carousel('next')
                        }
                        $('#carousel-item-' + data1.mId).remove();
                    }
                };

            });

        </script>


    </body>
</html>