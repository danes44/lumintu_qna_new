<?php
    session_start();

    if (!isset($_SESSION['is_login'])) {
        echo "<script>document.location.href='index.php';</script>";
        die();
    }
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
        <!-- Bootstrap CSS -->
<!--        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous"/>-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">

        <!-- Custom styles for this template -->
        <link href="../style.css" rel="stylesheet">
    </head>

    <body style="background-color: #FFFFFF;">
        <!--<div class="container"></div>-->
        <div class="container " style="height: auto;width: auto;margin-bottom: 30px;margin-top: 30px;position: relative;padding-bottom: 20px;">
            <div class="mx-3 d-flex justify-content-between align-self-center align-content-center align-items-center">
                <a class="text-decoration-none text-black fw-bold align-content-center " role="button" href="logout.php" onclick="return confirm('Apakah anda yakin ingin keluar ?')">
                    <i class="bi bi-box-arrow-left me-3 "></i>Sign Out
                </a>
                <h3 class="fw-bold mb-0 flex-grow-1 text-center">Daftar QnA Event</h3>
                <img src="../assets/Logo QnA.svg" class="img-fluid " width="40px" alt="..." style="margin-right: 10px;"/>
            </div>

            <div class="container">
                <div id="list_sesi" class="row mb-1 mt-5">
                </div>
            </div>
        </div>
        <script>
            var id_tiket = 1;
            var id_tiket_session = 1;
            $.ajax({
                url: kel1_api+'/items/ticket?fields=ticket_id,ticket_type,ticket_x_session.session_id.*&filter[ticket_id]=4',
                type: 'GET',
                dataType: 'json',
                // dataType: 'jsonp',
                // headers: {
                //     'Access-Control-Allow-Origin': '*',
                // },
                success: function(data, textStatus, xhr) {

                    let html_data = ""
                    console.log(data.data)
                    for(var i = 0; i < data.data.length; i++){
                        for(var j = 0; j < data.data[i].ticket_x_session.length; j++){
                            console.log(data.data[i].ticket_x_session[j].session_id.session_desc)
                            let nama_event = data.data[i].ticket_x_session[j].session_id.session_desc
                            let id_session = data.data[i].ticket_x_session[j].session_id.session_id
                            let time_start = new Date(data.data[i].ticket_x_session[j].session_id.start_time)
                            let time_finish = new Date(data.data[i].ticket_x_session[j].session_id.finish_time)
                            let day = moment(time_start).format('dddd')
                            let time_begin = moment(time_start).format('LT')
                            let time_end = moment(time_finish).format('LT')
                            let date = moment(time_start).format('LL')
                            let button_chat = ""
                            let warna = ""
                            let jam = 60 * 60 * 1000
                            let eventbenar = new Date(time_start - jam)
                            // jika waktu mulai masih blm lewat : beda sejam
                            // 25/10/2021 16:11 <= 01/12/2021 09:00
                            if( new Date('2021-12-01T18:00:00') >= eventbenar ){
                                button_chat += "Segera dalam 1 Jam"
                                warna += "primary"
                            } else { //

                                // jika waktu mulai sudah lewat tapi waktu finish belum
                                if( new Date() < time_start && new Date() < time_finish) {
                                    button_chat += "Segera";
                                    warna += "warning"
                                } else if (new Date() > time_start && new Date() < time_finish) {
                                    button_chat += "Berjalan"
                                    warna += "success"
                                } else { // jika waktu mulai dan waktu finish sudah lewat
                                    button_chat += "Selesai"
                                    warna += "secondary disabled"
                                }
                                // button_chat += "Beda"
                            }

                            html_data += '<div class="mb-4 col-lg-3 col-md-6 col-sm-12 card-group">' +
                                            '<div class="card border-1" style="background-color:#ffffff;">' +
                                                '<img src="../assets/event1.jpg" class="card-img-top" alt="..." style="height: 140px; width=30px; object-fit: cover">' +
                                                '<div class="card-body">' +
                                                    '<span class="badge bg-'+ warna +' bg-opacity-10 text-'+ warna +' mb-3">' + button_chat + '</span>' +
                                                    '<h6 class="card-title fw-bold">' + nama_event + '</h6>' +
                                                    '<p class="card-text"><small>' + day + ', ' + date + '<br>' + time_begin + ' - ' + time_end + '</small></p>' +
                                                '</div>'+
                                                '<div class="card-footer border-0 mb-3 d-grid" style="background-color:transparent"> '+
                                                    '<a id="btn-masuk" href="../database/RoomChats.php?id_session='+ id_session +'" class="text-decoration-none text-black fw-bold small stretched-link">Masuk sesi<i class="bi bi-arrow-right ms-2"></i></a>' +
                                                '</div>' +
                                            '</div>' +

                                        '</div>';
                        }
                    }
                    document.getElementById("list_sesi").innerHTML = html_data;
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(textStatus);
                }
            })
        </script>
        <!-- moment Js -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment-with-locales.min.js"></script>
        <script>
            moment.locale('id');
            console.log(moment(Date.now()).fromNow());
        </script>

    </body>
</html>