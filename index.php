<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width" />
  <title>Undian Hadiah RPJ</title>

  <link rel="stylesheet" href="css/normalize.css" />
  <link rel="stylesheet" href="css/foundation.css" />
  <script src="js/vendor/custom.modernizr.js"></script>
  <script src="js/jquery-latest.min.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    #values {
      position: relative;
      font-size: 400%;
      text-align: center;
      margin: 0 auto;
      z-index: 0;
    }

    .name {
      overflow: hidden;
      display: block;
    }

    #names {
      display: none;
      padding: 5px;
    }

    #namesbox {
      min-height: 400px;
      font-size: 32px;
      color: #333;
      resize: none;
      border: 1px solid #F39C12;
    }

    .extra {
      font-size: 16px;
      margin-top: 20px;
    }

    #result1 {
      background: #000;
      color: #fbe34b;
      padding: 20px;
      z-index: 10;
      margin-top: -150px;
    }

    /* body {
      background: #ffff url(img/bg.jpg) no-repeat center center fixed;
    } */

    #varnote {
      font-size: 40px;
      text-align: center;
      padding: 30px;
    }

    .copyright {
      font-size: 11px;
      font-family: Tahoma;
      color: #9B59B6;
    }
  </style>

</head>

<body onload="reset();" style="background: url(img/bg.jpg) no-repeat center center fixed; 
  -webkit-background-size: contain;
  -moz-background-size: contain;
  -o-background-size: contain;
  background-size: contain;">
  <div style="margin: 20px;">
    <center><strong style="font-size: 50px; color: #ffff;" id="demo"></strong></center>
  </div>
  <div class="full-head" >
    <div class="row">
      <div class="large-12 columns" repeat-x center top;z-index:20;">
        <ul class="button-group even-2">
          <li><button class="button" id="list" onclick="namelist();">Daftar Nomor Undian</button></li>
          <li><button class="success button" id="go" onclick="go();">Undi Sekarang</button></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="large-12 columns">
      <h3 style="text-align:center;margin-top:30px;" id="headline">Saksikan siaran langsng undian My RPJ</h3>

      

      <div id="popdown">
        <div id="names" class="inbox"><textarea name="namesbox" id="namesbox"></textarea></div>
      </div>

      <div id="values"></div>


    </div>
  </div>
  <?php
  $tayang = $_GET['tayang'];
  ?>
  <script>
    // Mengatur waktu akhir perhitungan mundur
    var countDownDate = "<?= $tayang ?>";

    // Memperbarui hitungan mundur setiap 1 detik
    var x = setInterval(function() {

      // Untuk mendapatkan tanggal dan waktu hari ini
      var now = new Date().getTime();

      // Temukan jarak antara sekarang dan tanggal hitung mundur
      var distance = countDownDate - now;

      // Perhitungan waktu untuk hari, jam, menit dan detik
      var days = Math.floor(distance / (1000 * 60 * 60 * 24));
      var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((distance % (1000 * 60)) / 1000);

      // Keluarkan hasil dalam elemen dengan id = "demo"
      document.getElementById("demo").innerHTML = days + "d " + hours + "h " +
        minutes + "m " + seconds + "s ";

      // Jika hitungan mundur selesai, tulis beberapa teks 
      if (distance < 0) {
        clearInterval(x);
        document.getElementById("demo").innerHTML = "Berlangsung";
      }
    }, 1000);
  </script>
  <?php require('inc/config.php');
  $kupon_id = $_GET['kupon_id'];
  // var_dump('1231');
  // die;
  $sql = mysqli_query($conn, "SELECT `Undian`.`id`, `Undian`.`kupon_id` AS `kuponId`, `Undian`.`customer_id` AS `customerId`, `Undian`.`undian_number` AS `undianNumber`, `Undian`.`createdAt`, `Undian`.`updatedAt`, `kupon`.`id` AS `kupon.id`, `kupon`.`nama` AS `kupon.nama`, `kupon`.`keterangan` AS `kupon.keterangan`, `kupon`.`kode` AS `kupon.kode`, `customer`.`id` AS `customer.id`, `customer`.`nama` AS `customer.nama` FROM `undians` AS `Undian` LEFT OUTER JOIN `kupons` AS `kupon` ON `Undian`.`kupon_id` = `kupon`.`id` LEFT OUTER JOIN `users` AS `customer` ON `Undian`.`customer_id` = `customer`.`id` where `Undian`.`kupon_id` = $kupon_id ORDER BY `Undian`.`id`");
  $nama = [];
  while ($data = mysqli_fetch_array($sql)) {
    $nama[] = $data['undianNumber'];
  }
  ?>


  <script>
    var javaScriptVar = <?php echo json_encode($nama); ?>;
    console.log(javaScriptVar);

    document.write('<script src=' +
      ('__proto__' in {} ? 'js/vendor/zepto' : 'js/vendor/jquery') +
      '.js><\/script>')
  </script>

  <script src="js/foundation.min.js"></script>
  <script>
    $(document).foundation();
  </script>

  <script>
    var text;

    function reset() {
      // re-enable go button
      setTimeout("$('#go').removeAttr('disabled')", 11005);
      var namesbreak = "";
      if (gup('names') != "") {
        var names = gup('names');
        namesbreak = names.replace(/101/g, '\n');
        namesbreak = namesbreak.replace(/%20/g, ' ');
      } else {
        var names = new Array(javaScriptVar.join('\n'));
        for (var i in names) {
          name = names[i];
          if (name == "" || typeof(name) == undefined) {} else {
            namesbreak = namesbreak + name + "\n";
          }
        }
      }
      $("#namesbox").val(namesbreak);
    }

    function gup(para) {
      para = para.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
      var regexS = "[\\?&]" + para + "=([^&#]*)";
      var regex = new RegExp(regexS);
      var results = regex.exec(window.location.href);
      if (results == null)
        return "";
      else
        return results[1];
    }

    function randOrd() {
      return (Math.round(Math.random()) - 0.5);
    }

    function save() {
      $("#varnote").hide();
      $("#popdown").show();
      $("#values").hide();
      $("div").remove("#result1");
      savenames = $("#namesbox").val();
      savenames = savenames.replace(/\n\r?/g, '101');
      $('#headline').fadeOut();
      $('#headline').text('The name list is saved and updated.').fadeIn();
      $("#names").show();
      $('#namesbox').attr('disabled', 'disabled');
    }

    function namelist() {
      $("#varnote").hide();
      $('#namesbox').removeAttr('disabled', 'disabled');
      $('#headline').text('Daftar Nomor Undian');
      $("#popdown").show();
      $("#values").hide();
      $("#names").show();
      $('body').css({
        "overflow-y": "visible"
      });
    }

    // does the actual animation
    function go() {
      $("#varnote").hide();
      $('body').css({
        "overflow-y": "hidden"
      });
      $('#go').attr('disabled', 'disabled');
      $('#list').attr('disabled', 'disabled');
      $('#save').attr('disabled', 'disabled');
      $('#headline').slideUp();
      $('#namesbox').slideDown();

      var count = 1;
      count = 1;
      $("div").remove("#result1");
      names = $("#namesbox").val();
      if (document.all) { // IE
        names = names.split("\n");
      } else { //Mozilla
        names = names.split("\n");
      }
      $("#values").show();
      $(".name").show();
      $("#popdown").hide();
      $("div").remove(".name");
      $("div").remove(".extra");
      $("#playback").html("");
      newtop = names.length * 200 * -1;
      //$('#values').css({top: -300});
      $('#values').css({
        top: +newtop
      });
      names.sort(randOrd);
      var fruits = new Array("apple", "pear", "orange", "banana");
      //console.log(fruits);
      //console.log(names);
      //alert(newtop);
      for (var i in names) {
        if (names[i] == "" || typeof(names[i]) == undefined) {
          count = count - 1;
        } else {
          name = names[i];
          //console.log(name);
          $('#values').append(`<div value=${name} id=result${count} class=name>${name}</div>`);
        }
        count = count + 1;
      }
      for (var i in names) {
        if (names[i] == "" || typeof(names[i]) == undefined) {} else {
          name = names[i];
          $('#values').append('<div class=name>' + name + '</div>');
        }
        count = count + 1;
      }
      for (var i in names) {
        if (names[i] == "" || typeof(names[i]) == undefined) {} else {
          name = names[i];
          $('#values').append('<div class=name>' + name + '</div>');
        }
        count = count + 1;
      }
      text = $('#result1').text()
      $('#values').animate({
        top: '+176'
      }, names.length * 100);

      // make it stand out
      setTimeout("standout(text)", names.length * 100);
      setTimeout("$('#playback').hide('slow')", 11005);
      console.log(names.length);
    }

    function standout(text) {
      console.log($("result1").val());
      $('#result1').removeClass('name');
      $('.name').animate({
        opacity: .25
      });
      $('#result1').animate({
        height: '+=60px'
      });
      $('#result1').append('<div class="extra"><a class="small alert button" href="#" onClick="removevictim();">Konfirmasi Pemenang</a></div>');
      $('#go').removeAttr('disabled', 'disabled');
      $('#list').removeAttr('disabled', 'disabled');
      $('#save').removeAttr('disabled', 'disabled');
      $('#headline').text('Found the Winner!');
      $('#headline').slideDown();
    }

    function removevictim() {
      // Removing victim from array and UI
      // names = names.filter(function(){ return true});
      // Rewriting namesbox contents
      var nameupdated = "";
      for (var i in names) {
        name = names[i];
        if (name == "" || name == text || typeof(name) == undefined) {} else {
          nameupdated = nameupdated + "\n" + name;
        }
      }
      var cookieValue = document.getElementById('result1').getAttribute('value');
      $.ajax({
        type: "POST",
        dataType: "json",
        contentType: "application/json; charset=utf-8",
        url: "http://localhost:3000/pemenang-undian",
        data: '{"undianNumber":' + cookieValue + ',"kuponId":"<?= $kupon_id ?>"}',
        success: function(Record) {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Pemenang telah di konfirmasi',
            showConfirmButton: false,
            timer: 15000
          })
          console.log(Record);
        },
        Error: function(textMsg) {
          console.log(textMsg);
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Pemenang telah di konfirmasi',
            showConfirmButton: false,
            timer: 15000
          })
        }
      });
      console.log(cookieValue);
      // $('#namesbox').val("");
      // $('#namesbox').val(nameupdated);
      // $('#result1').html("Removed");
      // $('#result1').fadeOut(1000, function() {
      //   $("div").remove("#result1");
      // });
      // $("div").remove(".name");
      // $("div").remove(".extra");
      // $('#headline').text('OK, done! Let\'s see who is next? Just click "GO!" button for next roll.');
    }
  </script>

</body>

</html>