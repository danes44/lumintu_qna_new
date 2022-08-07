
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
    <div id="all_elements">
        <button id="sortTerlama"> sort Terlama</button>
        <button id="sortTerbaru"> sort Terbaru</button>

        <!-- one element -->
        <div class="element">
            <div class="display-number">02</div>
<!--            <div class="year">20-10-2011</div>-->
            <div class="year">2021-11-02 02:25:52</div>
        </div><!-- element -->

        <!-- one element -->
        <div class="element">
            <div class="display-number">03</div>
<!--            <div class="year">22-09-2011</div>-->
            <div class="year">2021-11-02 01:25:52</div>
        </div><!-- element -->

        <!-- one element -->
        <div class="element">
            <div class="display-number">01</div>
<!--            <div class="year">01-12-2011</div>-->
            <div class="year">2021-11-02 20:25:52</div>
        </div><!-- element -->

        <!-- one element -->
        <div class="element">
            <div class="display-number">04</div>
<!--            <div class="year">01-06-2011</div>-->
            <div class="year">2021-12-03 22:11:52</div>
        </div><!-- element -->

        <!-- one element -->
        <div class="element">
            <div class="display-number">05</div>
<!--            <div class="year">01-06-2010</div>-->
            <div class="year">2021-12-03 22:33:52</div>
        </div><!-- element -->
    </div> <!--all_elements-->

    <script>
        $('#sortTerlama').click(function(){
            console.log("AS")
            $('#all_elements .element').sort(sortTerlama).appendTo('#all_elements')
        });

        $('#sortTerbaru').click(function(){
            console.log("DES")
            $('#all_elements .element').sort(sortTerbaru).appendTo('#all_elements')
        });

        function sortTerlama(a, b) {
            let date1 = $(a).find(".year").text()
            date1 = date1.replaceAll(':', '-').replaceAll(' ', '-')
            date1 = date1.split('-')
            console.log(date1)
            date1 = new Date(date1[0], date1[1]-1, date1[2], date1[3], date1[4], date1[5])

            let date2 = $(b).find(".year").text()
            date2 = date2.replaceAll(':', '-').replaceAll(' ', '-')
            date2 = date2.split('-')
            console.log(date1)
            date2 = new Date(date2[0], date2[1]-1, date2[2], date2[3], date2[4], date2[5])

            console.log(date1 + " vs " + date2)
            return date1 - date2;
        }

        function sortTerbaru(a, b) {
            let date1 = $(a).find(".year").text()
            date1 = date1.replaceAll(':', '-').replaceAll(' ', '-')
            date1 = date1.split('-')
            date1 = new Date(date1[0], date1[1]-1, date1[2], date1[3], date1[4], date1[5])

            let date2 = $(b).find(".year").text()
            date2 = date2.replaceAll(':', '-').replaceAll(' ', '-')
            date2 = date2.split('-')
            date2 = new Date(date2[0], date2[1]-1, date2[2], date2[3], date2[4], date2[5])
            console.log(date1 + " vs " + date2)
            return date2 - date1;
        }

    </script>
  </body>
</html>