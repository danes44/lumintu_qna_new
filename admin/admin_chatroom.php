<?php
  session_start();

  require('../database/ChatRooms.php');
  include('../get_nama.php');


  if (!isset($_SESSION['is_login'])) {
      echo "<script>document.location.href='index.php';</script>";
      die();
  }

  $chat_object = new ChatRooms;

  $chat_data = $chat_object->get_all_chat_data();
//  foreach ($chat_data as $chat){
//      $str1 = str_split($chat["waktu_pengiriman"], 10);
//      echo $str1;
//  }
//    var_dump($chat_data);
    $i_x_waktu = array();
    $j_x_waktu = array();
    $k_x_waktu = array();
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">

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
    <div class="container py-4">
      <div class="d-flex justify-content-between mb-4">
        <div class="d-flex justify-content-start align-items-center">
            <img src="../assets/Logo QnA.svg" class="img-fluid text-center" width="14%" alt="...">
            <h2 class="align-middle fw-bold mb-0 ps-3 ">Dashboard</h2>
        </div>
        <div class="align-items-center text-end">
            <p id="event-name" class="fw-bold mb-0" style="font-size: 1.6rem;"></p>
            <h6 class="fst-italic mt-0 mb-1">Lumintu Event</h6>
            <h6 id="date-time" class="mb-0"></h6>
        </div>
      </div>

      <div class="d-flex justify-content-between mb-4">
        <div class="d-flex justify-content-start align-items-center">
            <a id="btn-kembali" class="fw-bold text-decoration-none text-black border-0 rounded my-0 p-0 bg-transparent" role="button" href="dashboard_admin.php" onclick="return confirm('Apakah anda yakin ingin keluar ?')">
                <i class="bi bi-arrow-left me-1"></i>
                Kembali
            </a>
        </div>
        <div class="d-flex justify-content-start align-items-center">
            <a id="btn-display" class="fw-bold text-decoration-none text-white border-0 rounded my-0 p-2 bg-opacity-10" style="background-color: #FF6641" role="button" href="../qna_display.php?id_session=<?php echo $_GET["id_session"] ; ?>" target="_blank">
                <i class="bi bi-easel me-1"></i>
                Presentasi
            </a>
        </div>
        <!--<div class="d-flex justify-content-start align-items-center">
          <a class="btn btn-outline-light border-2" role="button" href="logout.php" onclick="return confirm('Apakah anda yakin ingin keluar ?')"><b>Logout</b></a>
        </div>-->
      </div>
        
      <div class="row pt-3" >
        <div class="col-6">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Daftar Pertanyaan (perlu ditinjau)</h5>
            <h6 id="jumlah-pertanyaan"></h6>
          </div>
          <div class="input-group mb-3">
            <input type="text" id="search-pertanyaan" class="form-control border border-1 border-end-0 py-2 px-3 rounded-start" placeholder="Cari pertanyaan..." aria-label="Cari pertanyaan..." aria-describedby="search-addon" style="background-color: white;" >
            <button class="input-group-text py-2 border border-1 border-start-0 rounded-end " disabled id="search-addon" style="background-color: white; ">
                <i class="bi bi-search"></i>
            </button>
            <div class="dropdown">
                <button class="input-group-text py-2 border border-1 rounded ms-3" data-bs-toggle="dropdown" id="btn-filter" style="background-color: white; ">
                  <i class="bi bi-filter"></i>
                </button>
                <ul class="dropdown-menu ">
                  <li>
                      <p class="text-muted small ms-2 mb-2">Urutkan</p>
                  </li>
                  <li>
                      <div class="dropdown-item small">
                          <input class="form-check-input" type="radio" name="radio-filter" id="radio-terbaru" value="terbaru" checked>
                          <label class="form-check-label ms-2"  for="radio-terbaru">
                              Terbaru
                          </label>
                      </div>
                  </li>
                  <li>
                      <div class="dropdown-item small">
                          <input class="form-check-input" type="radio" name="radio-filter" id="radio-terlama" value="terlama">
                          <label class="form-check-label ms-2" for="radio-terlama">
                              Terlama
                          </label>
                      </div>
                  </li>
                  <li>
                      <p class="text-muted small ms-2 my-2">Filter</p>
                  </li>
                  <li>
                      <div class="dropdown-item small">
                          <input class="form-check-input" type="checkbox" id="checkbox-terjawab">
                          <label class="form-check-label ms-2" for="checkbox-terjawab">
                              Terjawab
                          </label>
                      </div>
                  </li>
                </ul>
            </div>
          </div>

<!--          <div class="accordion accordion-flush border border-1 text-black rounded" id="accordionFlushExample"  style="max-height: 560px; overflow-y: auto;">-->
            <div class="border border-1 rounded-3 sortable list-pertanyaan" id="container-pesan" style="max-height: 560px; overflow-y: overlay;">
                <?php
                    $i = 0;
                    $last = count($chat_data);
                    foreach($chat_data as $chat)
                    {
                        $str1 = str_split($chat["waktu_pengiriman"], 10);
                        $jam_pesan = str_split($str1[1], 6);
                        if ($chat["id_chat"] == $_GET["id_session"] && $chat["status"]==0){
                            $nama_peserta = get_nama($chat["id_pengirim"]);
                            $id = $chat["id_message"];
                            $huruf_depan = $nama_peserta[0];

                            $i_x_waktu[$i] = $chat["waktu_pengiriman"];

                            echo '
                                <div id="container-pesan-'.$chat["id_message"].'" class="p-3 pesan border-top border-bottom ">
                                    <div class="d-flex">
                                        <p class="mb-0 small isi-pesan flex-grow-1">
                                            '.$chat["pesan"].'
                                        </p>
                                        <div class="dropdown">
                                        <button id="btn-options" class="bg-transparent border-0" data-bs-toggle="dropdown" style="height: fit-content">
                                                <i class="bi bi-three-dots text-muted"></i>
                                        </button>    
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button id="btn-edit-'.$chat["id_message"].'" class="dropdown-item small btn-edit" type="button">
                                                    <i class="bi bi-pencil me-3 text-primary"></i>Edit
                                                </button>
                                            </li>
                                            <li>
                                                <button id="btn-hapus-'.$chat["id_message"].'" class="dropdown-item small btn-hapus" type="button">
                                                    <i class="bi bi-trash3 me-3 text-danger"></i>Hapus
                                                </button>
                                            </li>
                                        </ul> 
                                    </div>
                                    </div>
                
                                    <div class="card-footer bg-transparent">
                                        <div class="d-flex justify-content-between align-items-center mt-3 ">
                                            <div class="d-flex align-items-center ">
                                                <button class=" small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                                    '.$huruf_depan.'
                                                </button>
                                                <div class="small align-self-center ms-2">
                                                    <p id="nama-peserta-form" class="text-truncate fw-bold mb-0"> '.$nama_peserta.' </p>
                                                    <p id="jam-pesan-i'.$i.'" class="jam text-black-50 small mb-0 ">
                                                        '.$jam_pesan[0].'
                                                    </p>
                                                    <p class="waktu-kirim d-none" id="waktu_pengiriman_'. $i .'" >'.$chat["waktu_pengiriman"].'</p>
                                                </div>
                                            </div>
                                            
                                            <div>
                                                <button id="btn-accept" class="btn bg-success bg-opacity-10 border-0 rounded-3 py-1 me-0 text-muted"  title="Setujui pertanyaan" data-bs-toggle="tooltip" style="width: 50px;">
                                                    <i class="bi bi-check-lg text-success "></i>
                                                </button>
                                                
                                                <button id="btn-delete" class="btn bg-danger bg-opacity-10 border-0 rounded-3 py-1 me-0 text-muted"  title="Tolak pertanyaan" data-bs-toggle="tooltip" style="width: 50px;">
                                                    <i class="bi bi-x-lg text-danger "></i>
                                                </button>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>';
                            $i++;
                        }
                    }
                ?>
            </div>
        </div>

        <div class="col-6">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold">Daftar Pertanyaan Terpilih (Live)</h5>
                <h6 id="jumlah-pertanyaan-terpilih"></h6>
            </div>
            <div class="input-group mb-3">
                <input type="text" id="search-pertanyaan-terpilih" class="form-control border border-1 border-end-0 py-2 px-3 rounded-start" placeholder="Cari pertanyaan..." aria-label="Cari pertanyaan..." aria-describedby="search-addon" style="background-color: white; border-radius: .5rem 0 0 .5rem;">
                <button class="input-group-text py-2 border border-1 border-start-0 rounded-end" disabled id="search-addon" style="background-color: white; ">
                    <i class="bi bi-search"></i>
                </button>
                <div class="dropdown">
                    <button class="input-group-text py-2 border border-1 rounded ms-3" data-bs-toggle="dropdown" id="btn-filter-live" style="background-color: white; ">
                        <i class="bi bi-filter"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <p class="text-muted small ms-2 mb-2">Urutkan</p>
                        </li>
                        <li>
                            <div class="dropdown-item small">
                                <input class="form-check-input" type="radio" name="radio-filter-live" id="radio-terbaru-live" value="terbaru" checked>
                                <label class="form-check-label ms-2"  for="radio-terbaru-live">
                                    Terbaru
                                </label>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown-item small">
                                <input class="form-check-input" type="radio" name="radio-filter-live" id="radio-terlama-live" value="terlama">
                                <label class="form-check-label ms-2" for="radio-terlama-live">
                                    Terlama
                                </label>
                            </div>
                        </li>
                        <li>
                            <p class="text-muted small ms-2 my-2">Filter</p>
                        </li>
                        <li>
                            <div class="dropdown-item small">
                                <input class="form-check-input" type="checkbox" id="checkbox-favorit-live">
                                <label class="form-check-label ms-2" for="checkbox-favorit-live">
                                    Favorit
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

<!--            <div class="accordion accordion-flush border border-1 text-black text-black rounded" id="accordionFlush-choose" style="max-height: 560px; overflow-y: auto;">-->
            <div class="border border-1 rounded-3 sortable list-pertanyaan" id="container-pesan-terpilih" style="max-height: 560px; overflow-y: overlay;">
              <?php
                $j = 0;
                $last = count($chat_data);
                foreach($chat_data as $chat){
                    $str1 = str_split($chat["waktu_pengiriman"], 10);
                    $jam_pesan = str_split($str1[1], 6);

                    if ($chat["id_chat"] == $_GET["id_session"] && $chat["status"]==1){
                        $nama_peserta = get_nama($chat["id_pengirim"]);
                        $id = $chat["id_message"];
                        $huruf_depan = $nama_peserta[0];
                        $j_x_waktu[$j] = $chat["waktu_pengiriman"];

                        echo '
                            <div id="container-pesan-'.$chat["id_message"].'" class="p-3 pesan-terpilih border-top border-bottom ">
                                <div class="d-flex">
                                    <p class="mb-0 small isi-pesan flex-grow-1">
                                        '.$chat["pesan"].'
                                    </p>
                                    <div class="dropdown">
                                        <button id="btn-options-live" class="bg-transparent border-0" data-bs-toggle="dropdown" style="height: fit-content">
                                                <i class="bi bi-three-dots text-muted"></i>
                                        </button>    
                                        <ul class="dropdown-menu">
                                            <li>
                                                <button id="btn-edit-'.$chat["id_message"].'" class="dropdown-item small btn-edit" type="button">
                                                    <i class="bi bi-pencil me-3 text-primary"></i>Edit
                                                </button>
                                            </li>
                                            <li>
                                                <button id="btn-hapus-'.$chat["id_message"].'" class="dropdown-item small btn-hapus" type="button">
                                                    <i class="bi bi-trash3 me-3 text-danger"></i>Hapus
                                                </button>
                                            </li>
                                        </ul> 
                                    </div>
                                </div>
                
                                    <div class="card-footer bg-transparent">
                                        <div class="d-flex justify-content-between align-items-center mt-3 ">
                                            <div class="d-flex align-items-center ">
                                            <button class=" small border-0 rounded-pill ms-0 text-white bg-primary fw-bold" style="width: 2rem; height:2rem;" disabled>
                                                '.$huruf_depan.'
                                            </button>
                                            <div class="small align-self-center ms-2">
                                                <p id="nama-peserta-form" class="text-truncate fw-bold mb-0"> '.$nama_peserta.' </p>
                                                <p id="jam-pesan-j'.$j.'" class="jam text-black-50 small mb-0 ">
                                                    '.$jam_pesan[0].'
                                                </p>
                                                
                                                <p class="waktu-kirim d-none" id="waktu_pengiriman_'. $j .'" >'.$chat["waktu_pengiriman"].'</p>
                                                
                                            </div>
                                        </div>
                                        
                                        <div class="">
                                            <button id="btn-revert-'.$chat["id_message"]. '" class="btn btn-revert bg-transparent border-0 rounded-3 py-1 px-1 me-0 text-muted" data-bs-toggle="tooltip" title="Batal pilih pertanyaan">
                                                <i class="bi bi-arrow-counterclockwise"></i>
                                            </button>
                                            <button id="btn-love-'.$chat["id_message"]. '" class="btn btn-love bg-transparent border-0 rounded-3 py-1 px-1 ms-1" data-bs-toggle="tooltip" title="Favoritkan pertanyaan" style="color: #FF417B">
                                                <i class="bi bi-heart" ></i>
                                            </button>
                                            <button id="btn-terjawab-' .$chat["id_message"]. '" class="btn btn-terjawab bg-success border-0 rounded-3 py-1 px-3 ms-1" data-bs-toggle="tooltip" title="Tandai sebagai terjawab" >
                                                <i class="bi bi-check-lg text-white"></i>
                                            </button>                                        
                                        </div>
                                    </div>
                                </div>
                                
                            </div>';
                            $j++;

                        /*echo '
                            <div class="accordion-item rounded" id="accordion-item-'.$chat["id_message"].'">
                                <h3 class="accordion-header" id="heading-'.$chat["id_message"].'">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-'.$chat["id_message"].'" aria-expanded="false" aria-controls="flush-'.$chat["id_message"].'"">
                                    <div class="align-items-center " style="width: 90%!important;">
                                      <span class="fw-bold mb-2">'.$nama_peserta.'</span>
                                      <div class="small text-truncate mt-2">'.$chat["pesan"].'</div>
                                    </div>
                                  </button>
                                </h3>
                                <div id="flush-'.$chat["id_message"].'" class="accordion-collapse collapse" aria-labelledby="heading-'.$chat["id_message"].'" data-bs-parent="#accordionFlush">
                                  <div class="accordion-body">
                                    <p>'.$chat["pesan"].'</p>
                                    <div class="d-grid gap-2">
                                      <button type="submit" class="btn btn-outline-danger d-block btn-delete">Hapus</button>
                                      <button type="submit" class="btn btn-outline-success d-block btn-done">Selesai Jawab</button>
                                    </div>
                                  </div>
                                </div>
                            </div>';*/

                    }
                }
              ?>
            </div>
<!--            </div>-->
        </div>
      </div>

      <div class="row pt-5">
        <div class="col-6">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold">Daftar Pertanyaan Terjawab</h5>
            <h6 id="jumlah-pertanyaan-terjawab"></h6>
          </div>
          <div class="input-group mb-3">
            <input type="text" id="search-accordion-answered" class="form-control border-0 py-2 px-3 rounded-start" placeholder="Cari pertanyaan..." aria-label="Cari pertanyaan..." aria-describedby="search-addon" style="background-color: white; border-radius: .5rem 0 0 .5rem;"> 
            <button class="input-group-text py-2 border-0 rounded-end" id="search-addon" style="background-color: white; ">
              <i class="bi bi-search"></i>
            </button>
            <button class="input-group-text py-2 border-0 rounded ms-3"  id="filter-btn" style="background-color: white; ">
              <i class="bi bi-sort-alpha-down"style="font-size: 20px;"></i>
            </button>
          </div>

          <div class="accordion accordion-flush shadow-lg text-black rounded-top" id="accordionFlush-answered" >
              <div class="accordion-item rounded" id="accordion-item-1">
                  <h3 class="accordion-header" id="heading-1">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-1" aria-expanded="false" aria-controls="flush-1">
                  <div class="align-items-center " style="width: 90%!important;">
                      <span class="fw-bold mb-2">Mina Rofida</span>
                      <div class="small text-truncate mt-2">Admin, saya ingin bertanya. Saya Mina. Peserta dengan id 9. Bagaimana ya cara untuk menjadi percaya diri ? karena saya belakangan ini sulit percaya diri. Saya ingin menjadi percaya diri, dan bisa berbicara dengan orang banyak.</div>
                  </div>
                  </button>
                  </h3>
                  <div id="flush-1" class="accordion-collapse collapse" aria-labelledby="heading-1" data-bs-parent="#accordionFlush">
                  <div class="accordion-body">
                      <p>Admin, saya ingin bertanya. Saya Mina. Peserta dengan id 9. Bagaimana ya cara untuk menjadi percaya diri ? karena saya belakangan ini sulit percaya diri. Saya ingin menjadi percaya diri, dan bisa berbicara dengan orang banyak.</p>
                      <div class="d-grid gap-2">
                          <button type="submit" class="btn btn-outline-danger d-block btn-delete-terjawab">Hapus</button>
                      </div>
                  </div>
              </div>
            </div>
            <?php
              /*foreach($chat_data as $chat)
              {
                  $str1 = str_split($chat["waktu_pengiriman"], 10);
                  $jam_pesan = str_split($str1[1], 6);
                  if ($chat["id_chat"] == $_GET["id_session"] && $chat["status"]==2){
                      $nama_peserta = get_nama($chat["id_pengirim"]);
                      $id = $chat["id_message"];
                      echo '<div class="accordion-item rounded" id="accordion-item-'.$chat["id_message"].'">
                                <h3 class="accordion-header" id="heading-'.$chat["id_message"].'">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-'.$chat["id_message"].'"" aria-expanded="false" aria-controls="flush-'.$chat["id_message"].'"">
                                    <div class="align-items-center " style="width: 90%!important;">
                                      <span class="fw-bold mb-2">'.$nama_peserta.'</span>
                                      <div class="small text-truncate mt-2">'.$chat["pesan"].'</div>
                                    </div>
                                  </button>
                                </h3>
                                <div id="flush-'.$chat["id_message"].'" class="accordion-collapse collapse" aria-labelledby="heading-'.$chat["id_message"].'"" data-bs-parent="#accordionFlush">
                                  <div class="accordion-body">
                                    <p>'.$chat["pesan"].'</p>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-outline-danger d-block btn-delete-terjawab">Hapus</button>
                                    </div>
                                  </div>
                                </div>
                          </div>';
                }
              }*/
            ?>
          </div>
        </div>
          
        <?php 
          echo "<input type='hidden' name='login_id_sesi' id='login_id_sesi' value='".$_GET["id_session"]."'/>";
        ?>

      </div>
    </div>

    <script>
        moment.locale('id'); //set timezone to Indonesia
        console.log(moment(Date.now()).fromNow());
        console.log(moment().format('LT'))
        console.log(moment('2022-07-01 15:25:05').fromNow())

        //initialize tooltips
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>

    <!-- function olah tanggal -->
    <script>
        setInterval(function() {
            setFormatJam()
        }, 60 * 1000);

        function setFormatJam() {
            var jam_i = <?php echo json_encode($i_x_waktu); ?>;
            var jam_j = <?php echo json_encode($j_x_waktu); ?>;

            for(let i=0; i<jam_i.length; i++){
                let status_jam_i = moment(jam_i[i]).fromNow();
                $("#jam-pesan-i"+i).text(status_jam_i)
            }
            for(let j=0; j<jam_j.length; j++){
                let status_jam_j = moment(jam_j[j]).fromNow();
                $("#jam-pesan-j"+j).text(status_jam_j)
            }
        }
        setFormatJam()
    </script>


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
        $('#container-pesan .pesan').sort(sortTerbaru).appendTo('#container-pesan')

        //fungsi dijalankan supaya filter terbaru menjadi default (live)
        $('#container-pesan-terpilih .pesan-terpilih').sort(sortTerbaru).appendTo('#container-pesan-terpilih')

        //fungsi filter terbaru (semua)
        $('input:radio[name="radio-filter"]').change(function() {
            console.log($(this).val())
            if ($(this).val() === 'terbaru') {
                $('#container-pesan .pesan').sort(sortTerbaru).appendTo('#container-pesan')
            } else {
                $('#container-pesan .pesan').sort(sortTerlama).appendTo('#container-pesan')
            }
        });

        //fungsi filter terbaru (live)
        $('input:radio[name="radio-filter-live"]').change(function() {
            console.log($(this).val())
            if ($(this).val() === 'terbaru') {
                $('#container-pesan-terpilih .pesan-terpilih').sort(sortTerbaru).appendTo('#container-pesan-terpilih')
            } else {
                $('#container-pesan-terpilih .pesan-terpilih').sort(sortTerlama).appendTo('#container-pesan-terpilih')
            }
        });

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

    <!--    counter jumlah pertanyaan-->
    <script>
        function counter() {
            $('#jumlah-pertanyaan').text("Jumlah : " + $('#container-pesan .pesan').length)
            $('#jumlah-pertanyaan-terpilih').text("Jumlah : " +$('#container-pesan-terpilih .pesan-terpilih').length)
            $('#jumlah-pertanyaan-terjawab').text("Jumlah : " +$('#accordionFlush-answered .accordion-item').length)
        }
        counter()
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
            var conn = new WebSocket('ws://localhost:'+port);
            // var conn = new WebSocket('ws://0.tcp.ngrok.io:14538);
            conn.onopen = function(e) {
                console.log("Connection established!");
            };

            conn.onmessage = function(e) {
                console.log("TESTETETETES" +e.data);

                var sesi_id1 = $('#login_id_sesi').val();

                var data1 = JSON.parse(e.data);

                $.ajax({  
                    url: kel1_api+'/items/customer?fields=customer_id,customer_name&filter[customer_id]='+data1.userId,  
                    type: 'GET',  
                    //Authorization Header
                    // beforeSend: function (xhr) {
                    //     xhr.setRequestHeader('Authorization', 'Bearer tokencoba');
                    // },
                    dataType: 'json',  
                    success: function(data, textStatus, xhr) { 
                      var list_data = ''

                      var nama = data.data[0].customer_name 

                      if( data1.sesiId == sesi_id1 )
                      {
                          list_data = '<div class="accordion-item rounded-top" id="accordion-item-'+data1.mId+'"><h3 class="accordion-header" id="heading-'+data1.mId+'"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-'+data1.mId+'a'+'"" aria-expanded="false" aria-controls="flush-'+data1.mId+'a'+'""><div class="align-items-center " style="width: 90%!important;"><span class="fw-bold mb-2">'+nama+'</span><div class="small text-truncate mt-2">'+escapeHtml(data1.msg)+'</div></div></button></h3><div id="flush-'+data1.mId+'a'+'" class="accordion-collapse collapse" aria-labelledby="heading-'+data1.mId+'a'+'"" data-bs-parent="#accordionFlush"><div class="accordion-body"><p>'+data1.msg+'</p><div class="d-grid gap-2"><button type="button" class="btn btn-outline-primary btn-choose">Pilih</button></div></div></div></div>'
                      }

                      $('#accordionFlushExample').append(list_data);
                    }
                })  
            };

        });
          
    </script>

    <!-- function search pertanyaan   -->
    <script>
        //search question pool
        $("#search-pertanyaan").on("keyup", function() {
            var value = $(this).val().toLowerCase();

            $("#container-pesan .pesan .isi-pesan").filter(function() {
                $(this).parent().parent().toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
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

        //search answered question pool
        $("#search-accordion-answered").on("keyup", function() {
            var value = $(this).val().toLowerCase();

            $("#accordionFlush-answered .accordion-item").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
            counter()
        });
    </script>
    
    <script>
      //dapet data dari url untuk dapet ID tiketnya
      var id_tiket = 1;
      var id_tiket_session = 1;

      var arr_customers = []
      var arr_all = []
      var arr_sorted = []
      var arr_temp = []
      var arr_choose = []
      var arr_answered = []
      var status_sort = 0

      getDataCustomer()


      $.ajax({
        url: kel1_api+'/items/ticket?fields=ticket_id,ticket_type,ticket_x_session.session_id.*,ticket_x_day.day_id.*',
        type: 'GET',
        dataType: 'json',
        success: function(data, textStatus, xhr) {
                let nama = data.data[id_tiket-1].ticket_x_session[id_tiket_session-1].session_id.session_desc
                let time_start = new Date(data.data[id_tiket-1].ticket_x_session[id_tiket_session-1].session_id.start_time)
                let time_finish = new Date(data.data[id_tiket-1].ticket_x_session[id_tiket_session-1].session_id.finish_time)

                let day = moment(time_start).format('dddd')
                let time_begin = moment(time_start).format('HH:mm')
                let time_end = moment(time_finish).format('HH:mm')
                let date = moment(time_start).format('LL')

                $('#event-name').text(nama)
                $('#date-time').text(day+", "+date+" | "+time_begin+" - "+time_end+" WIB")
                // $('#time').text(time_begin+" - "+time_end)
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log('Error in Database');
        }
      })

      // get data dari API customer
      function getDataCustomer() {
          arr_customers.length = 0
          arr_all.length = 0
          $.ajax({
              url: kel1_api+'/items/customer/',
              type: 'GET',
              dataType: 'json',
              success: function(data, textStatus, xhr) {
                for(var i = 0; i < data.data.length; i++){
                    // console.log(data.data[i].customer_name)
                    arr_customers.push({
                        id : data.data[i].customer_id,
                        name : data.data[i].customer_name ,

                    });
                }
                console.log(arr_customers)
              },
              error: function(xhr, textStatus, errorThrown) {
                  console.log(errorThrown);
              }

          }).done(function (){
              getMessagesDatabase()
          })

      }

      function getMessagesDatabase() {
          console.log(arr_all)
          $.ajax({
              url: '../get_messages.php',
              type: 'GET',
              dataType: 'json',
              success: function (data, textStatus, xhr) {
                  console.log(data.length)
                  for (var i = 0; i < data.length; i++) {
                      // match data berdasarkan id pengirim/nama pengirim (ini belum)
                      for (var j = 0; j < arr_customers.length; j++) {

                          if (arr_customers[j].id == data[i].id_pengirim) {
                              arr_all.push({
                                  id_pesan: data[i].id_message,
                                  id_chat: data[i].id_chat,
                                  id_pengirim: data[i].id_pengirim,
                                  nama: arr_customers[j].name,
                                  pesan: data[i].pesan,
                                  status: data[i].status,
                                  waktu_pengiriman: data[i].waktu_pengiriman,
                              });
                              console.log("masuk sini")
                          }
                      }
                  }

              },
              error: function (xhr, textStatus, errorThrown) {
                  console.log(errorThrown + " " + xhr + " " + textStatus);
              }
          })
      }
    </script>

    <!-- fungsi pindah pertanyaan   -->
    <script>
        //fungsi pindah accordion ke section terpilih
        $("body").on("click", '.btn-choose', function() {
            var id_accordion_header = $(this).parent().parent().parent().siblings().attr('id');
            var id_numb = id_accordion_header.split("-");
            var idm = id_numb[1]
            console.log(idm)

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
                    status_sort == 0
                }
            });
            var cust_name = $(this).parent().parent().parent().siblings().children().children().children('span').text()
            var cust_message = escapeHtml($(this).parent().parent().parent().siblings().children().children().children('div').text())
            var parent_element = $(this).parent().parent().parent().parent().attr('id')

            //get customer id number
            var id_customer = $(this).parent().parent().parent().siblings().children().children()

            var id_accordion = $(this).parent().parent().parent().attr('id')

            console.log("mau pindah")
            let elements=`<div class="accordion-item rounded" id="${parent_element}">
                        <h3 class="accordion-header" id="heading-${id_numb[1]}-choose">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-${id_numb[1]}-choose" aria-expanded="false" aria-controls="flush-${id_numb[1]}-choose">
                            <div class="align-items-center " style="width: 90%!important;">
                              <span id="${id_numb[1]}" class="fw-bold mb-2">${cust_name}</span>
                              <div class="small text-truncate mt-2">${cust_message}</div>
                              </div>
                          </button>
                        </h3>
                        <div id="flush-${id_numb[1]}-choose" class="accordion-collapse collapse" aria-labelledby="heading-${id_numb[1]}-choose" data-bs-parent="#accordionFlush-choose">
                          <div class="accordion-body">
                            <p>${cust_message}</p>
                            <div class="d-grid gap-2">
                              <input type="hidden" id="isi_pesan1" value="${id_numb[1]}"/>
                              <button type="button" id="btn-delete" class="btn btn-outline-danger d-block btn-delete">Hapus</button>
                              <button type="button" class="btn btn-outline-success d-block btn-done">Selesai Jawab</button>
                            </div>
                          </div>
                        </div>
                      </div>`

            console.log("udah pindah")
            console.log(parent_element)
            $("#accordionFlush-choose").append(elements);
            $("#"+parent_element).remove()
            counter()

            // Proses Pengiriman Pesan
            $('#messages_area').scrollTop($('#messages_area').height());
            $('#chat_form').on('submit', function (event) {

                event.preventDefault();

                if ($('#chat_form').parsley().isValid()) {
                    var user_id = $('#login_user_id').val();
                    var message_id = ''
                    var id_sesi = $('#login_id_sesi').val();
                    var message = $('#chat_message').val();
                    var data = {
                        userId: user_id,
                        mId: message_id,
                        msg: message,
                        sesiId: id_sesi
                    };
                    conn.send(JSON.stringify(data));

                    $("#chat_message").css('height', 'calc(1.5em + 0.75rem + 2px)');
                    $("#chat_form").hide();
                    $("#container-btn").addClass('d-flex').show()
                }
            });
        })

        //fungsi pindah accordion ke section awal
        $("body").on("click", ".btn-delete", function() {
            var id_accordion_header = $(this).parent().parent().parent().siblings().attr('id')
            var id_numb = id_accordion_header.split("-")
            var idm = id_numb[1]
            console.log(idm)

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

            var cust_name = $(this).parent().parent().parent().siblings().children().children().children('span').text()
            var cust_message = escapeHtml($(this).parent().parent().parent().siblings().children().children().children('div').text())
            var parent_element = $(this).parent().parent().parent().parent().attr('id')

            //get id accordion header number
            var id_accordion_header = $(this).parent().parent().parent().siblings().attr('id')
            var id_numb = id_accordion_header.split("-")

            //get customer id number
            var id_customer = $(this).parent().parent().parent().siblings().children().children()

            var id_accordion = $(this).parent().parent().parent().attr('id')
            console.log("mau pindah")

            $("#"+parent_element).remove()
            let elements=`<div class="accordion-item rounded" id="${parent_element}">
                        <h3 class="accordion-header" id="heading-${id_numb[1]}">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-${id_numb[1]}" aria-expanded="false" aria-controls="flush-${id_numb[1]}">
                            <div class="align-items-center " style="width: 90%!important;">
                              <span class="fw-bold mb-2" id="${id_customer}">${cust_name}</span>
                              <div class="small text-truncate mt-2">${cust_message}</div>
                            </div>
                          </button>
                        </h3>
                        <div id="flush-${id_numb[1]}" class="accordion-collapse collapse" aria-labelledby="heading-${id_numb[1]}" data-bs-parent="#accordionFlush">
                          <div class="accordion-body">
                            <p>${cust_message}</p>
                            <div class="d-grid gap-2">
                              <input type="hidden" id="isi_pesan" value="${id_numb[1]}"/>
                              <button type="button" class="btn btn-outline-primary btn-choose">Pilih</button>
                            </div>
                          </div>
                        </div>
                      </div>`

            console.log("udah pindah")
            $("#accordionFlushExample").append(elements);
            counter()
        })

        //fungsi pindah accordion ke section dipilih dari terjawab
        $("body").on("click", ".btn-delete-terjawab", function() {
            var id_accordion_header = $(this).parent().parent().parent().siblings().attr('id');
            var id_numb = id_accordion_header.split("-");
            var idm = id_numb[1]
            console.log(idm)


            var cust_name = $(this).parent().parent().parent().siblings().children().children().children('span').text()
            var cust_message = escapeHtml($(this).parent().parent().parent().siblings().children().children().children('div').text())
            var parent_element = $(this).parent().parent().parent().parent().attr('id')

            // //get id accordion header number
            // var id_accordion_header = $(this).parent().parent().parent().siblings().attr('id')
            // var id_numb = id_accordion_header.split("-")

            //get customer id number
            var id_customer = $(this).parent().parent().parent().siblings().children().children()

            var id_accordion = $(this).parent().parent().parent().attr('id')

            console.log("mau pindah")
            let elements=`<div class="accordion-item rounded" id="${parent_element}">
                        <h3 class="accordion-header" id="heading-${id_numb[1]}-choose">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-${id_numb[1]}-choose" aria-expanded="false" aria-controls="flush-${id_numb[1]}-choose">
                            <div class="align-items-center " style="width: 90%!important;">
                              <span id="${id_numb[1]}" class="fw-bold mb-2">${cust_name}</span>
                              <div class="small text-truncate mt-2">${cust_message}</div>
                              </div>
                          </button>
                        </h3>
                        <div id="flush-${id_numb[1]}-choose" class="accordion-collapse collapse" aria-labelledby="heading-${id_numb[1]}-choose" data-bs-parent="#accordionFlush-choose">
                          <div class="accordion-body">
                            <p>${cust_message}</p>
                            <div class="d-grid gap-2">
                              <input type="hidden" id="isi_pesan1" value="${id_numb[1]}"/>
                              <button type="button" id="btn-delete" class="btn btn-outline-danger d-block btn-delete">Hapus</button>
                              <button type="button" class="btn btn-outline-success d-block btn-done">Selesai Jawab</button>
                            </div>
                          </div>
                        </div>
                      </div>`

            console.log("udah pindah")
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
            $("#"+parent_element).remove()
            $("#accordionFlush-choose").append(elements);
            counter()
        })

        //fungsi pindah accordion ke section terjawab
        $("body").on("click", ".btn-done", function() {
            var id_accordion_header = $(this).parent().parent().parent().siblings().attr('id')
            var id_numb = id_accordion_header.split("-")
            var idm = id_numb[1]
            console.log(idm)

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
            var cust_name = $(this).parent().parent().parent().siblings().children().children().children('span').text()
            var cust_message = escapeHtml($(this).parent().parent().parent().siblings().children().children().children('div').text())
            var parent_element = $(this).parent().parent().parent().parent().attr('id')

            // //get id accordion header number
            // var id_accordion_header = $(this).parent().parent().parent().siblings().attr('id')
            // var id_numb = id_accordion_header.split("-")

            //get customer id number
            var id_customer = $(this).parent().parent().parent().siblings().children().children()

            var id_accordion = $(this).parent().parent().parent().attr('id')
            console.log(parent_element)

            $("#"+parent_element).remove()
            let elements=`<div class="accordion-item rounded" id="${parent_element}">
                        <h3 class="accordion-header" id="heading-${id_numb[1]}-answered">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-${id_numb[1]}-answered" aria-expanded="false" aria-controls="flush-${id_numb[1]}-answered">
                            <div class="align-items-center " style="width: 90%!important;">
                              <span id="${id_numb[1]}" class="fw-bold mb-2">${cust_name}</span>
                              <div class="small text-truncate mt-2">${cust_message}</div>
                              </div>
                          </button>
                          </h3>
                        <div id="flush-${id_numb[1]}-answered" class="accordion-collapse collapse" aria-labelledby="heading-${id_numb[1]}-answered" data-bs-parent="#accordionFlush-answered">
                          <div class="accordion-body">
                            <p>${cust_message}</p>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-outline-danger d-block btn-delete-terjawab">Hapus</button>
                            </div>
                          </div>
                        </div>
                      </div>`

            $("#accordionFlush-answered").append(elements);
            counter()
        })

    </script>

  </body>
</html>