<?php include("./config/dbConnection.php") ?>
<?php
  $his_numcard = null;
  if (isset($_GET["his_numcard"])) {
    $his_numcard = $_GET["his_numcard"];
?>
<?php include("index template/head.php") ?>
<body id="page-top"><!--/ Section Portfolio Star /-->
<section id="work" class="portfolio-mf sect-pt4 route">
  <div class="container">
    <div class="row">
      <div class="col-sm-12">
        <div class="title-box text-center">
          <?php
            $sql_history = $conn->prepare("SELECT * FROM tb_history where his_numcard = '$his_numcard'");
            $sql_history->execute();
            $result_history = $sql_history->fetchAll();
            foreach($result_history as $row_history) {
          ?>
          <h4 class="title-a"><?php echo $row_history['his_numcard']; ?></h4>
          <!-- <p class="subtitle-a"></p> -->
          <?php
              $useragent = $_SERVER['HTTP_USER_AGENT'];
              if(preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
              {
                $width1="35%";
                $width2="65%";
              }else{
                $width1="15%";
                $width2="85%";
              }
          ?>
          <style> 
            table, th, td 
            { 
              border:0px solid black; 
              line-height: 30px;
            } 
          </style>
          <table style="width:100%" class="text-left">
            <tr>
              <td width="<?=$width1?>"><b>ประเภท: </b></td>
              <td width="<?=$width2?>"><?php echo $row_history['his_type']; ?></td>
            </tr>
            <tr>
              <td width="<?=$width1?>"><b>ชื่อพระ: </b></td>
              <td width="<?=$width2?>"><?php echo $row_history['his_nameproduct']; ?></td>
            </tr>
            <tr>
              <td width="<?=$width1?>"><b>จังหวัด: </b></td>
              <td width="<?=$width2?>"><?php echo $row_history['his_province']; ?></td>
            </tr>
            <tr>
              <td width="<?=$width1?>"><b>เจ้าของพระ: </b></td>
              <td width="<?=$width2?>"><?php echo $row_history['his_owner']; ?></td>
            </tr>
            <tr>
              <td width="<?=$width1?>"><b>ราคาประเมิน: </b></td>
              <td width="<?=$width2?>"><?php if($row_history['his_price']==""){echo "";}else{echo number_format($row_history['his_price'],0);}; ?></td>
            </tr>
            <tr>
              <td width="<?=$width1?>"><b>เบอร์โทรศัพท์: </b></td>
              <td width="<?=$width2?>"><?php echo $row_history['his_tel']; ?></td>
            </tr>
            <tr>
              <td width="<?=$width1?>"><b>รายละเอียด: </b></td>
              <td width="<?=$width2?>"><?php echo $row_history['his_detailproduct']; ?></td>
            </tr>
          </table>
          <?php } ?>
          <div class="line-mf"></div>
        </div>
      </div>
    </div>
    <div class="demo-gallery">
      <ul id="lightgallery">
        <?php	
            $sql_image = $conn->prepare("select * from tb_history 
              left join tb_image on tb_image.his_code=tb_history.his_code 
              where tb_history.his_numcard = '$his_numcard'
              and tb_image.images != ''
              and tb_image.image_sort between 1 and 9");
            $sql_image->execute();
            $result_image = $sql_image->fetchAll();
            if(count($result_image) > 0){
              foreach($result_image as $row_image) {
                $images = 'a/page/add_card_image/upimg-port/'. $row_image['images'];
                $output .=  "
                <li data-responsive='".$images."' data-src='".$images."'
                  data-sub-html='<h2><font color=yellow>".$row_image["detail1"]."</font></h2><p><h3><font color=white>".$row_image["detail3"]."</font></h3></p>'>
                  <a href='' >
                    <div class='work-img work-box'>
                      <img src='".$images."'  class='img-fluid' style='width:500px;height:262px;'>
                      <div class='work-content'>
                        <div class='row'>
                          <div class='col-sm-9'>
                            <h2 class='w-title'>".$row_image["detail1"]."</h2>
                            <div class='w-more'>
                              <span class='w-ctegory'>".$row_image["detail2"]."</span> / <span class='w-date'>".$row_image["detail3"]."</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                </li>";
              }
              echo $output;
            }else{
              echo "<h3 style='text-align:center'>No Image found</h3>";
            }
        ?>
      </ul>
    </div>

  </div>
</section>
<!--/ Section Portfolio End /-->
  <?php include("index template/script.php") ?>
  <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>
  <div id="preloader"></div>

  <style>
    .small {
      font-size: 11px;
      color: #999;
      display: block;
      margin-top: -10px
    }

    .cont {
      text-align: center;
    }

    .demo-gallery>ul {
      margin-bottom: 0;
      padding-left: 15px;
    }

    .demo-gallery>ul>li {
      margin-bottom: 15px;
      width: 100;
      display: inline-block;
      margin-right: 10px;
      list-style: outside none none;
    }

    .demo-gallery>ul>li a {
      border: 3px solid #FFF;
      border-radius: 3px;
      display: block;
      overflow: hidden;
      position: relative;
      float: left;
    }

    .demo-gallery>ul>li a:hover .demo-gallery-poster>img {
      opacity: 1;
    }

    .demo-gallery>ul>li a .demo-gallery-poster {
      background-color: rgba(0, 0, 0, 0.1);
      bottom: 0;
      left: 0;
      position: absolute;
      right: 0;
      top: 0;
      -webkit-transition: background-color 0.15s ease 0s;
      -o-transition: background-color 0.15s ease 0s;
      transition: background-color 0.15s ease 0s;
    }

    .demo-gallery>ul>li a .demo-gallery-poster>img {
      left: 50%;
      margin-left: -10px;
      margin-top: -10px;
      opacity: 0;
      position: absolute;
      top: 50%;
      -webkit-transition: opacity 0.3s ease 0s;
      -o-transition: opacity 0.3s ease 0s;
      transition: opacity 0.3s ease 0s;
    }

    .demo-gallery>ul>li a:hover .demo-gallery-poster {
      background-color: rgba(0, 0, 0, 0.5);
    }

    .demo-gallery .justified-gallery>a>img {
      -webkit-transition: -webkit-transform 0.15s ease 0s;
      -moz-transition: -moz-transform 0.15s ease 0s;
      -o-transition: -o-transform 0.15s ease 0s;
      transition: transform 0.15s ease 0s;
      -webkit-transform: scale3d(1, 1, 1);
      transform: scale3d(1, 1, 1);
      height: 100%;
      width: 100%;
    }

    .demo-gallery .justified-gallery>a:hover>img {
      -webkit-transform: scale3d(1.1, 1.1, 1.1);
      transform: scale3d(1.1, 1.1, 1.1);
    }

    .demo-gallery .justified-gallery>a:hover .demo-gallery-poster>img {
      opacity: 1;
    }

    .demo-gallery .justified-gallery>a .demo-gallery-poster {
      background-color: rgba(0, 0, 0, 0.1);
      bottom: 0;
      left: 0;
      position: absolute;
      right: 0;
      top: 0;
      -webkit-transition: background-color 0.15s ease 0s;
      -o-transition: background-color 0.15s ease 0s;
      transition: background-color 0.15s ease 0s;
    }

    .demo-gallery .justified-gallery>a .demo-gallery-poster>img {
      left: 50%;
      margin-left: -10px;
      margin-top: -10px;
      opacity: 0;
      position: absolute;
      top: 50%;
      -webkit-transition: opacity 0.3s ease 0s;
      -o-transition: opacity 0.3s ease 0s;
      transition: opacity 0.3s ease 0s;
    }

    .demo-gallery .justified-gallery>a:hover .demo-gallery-poster {
      background-color: rgba(0, 0, 0, 0.5);
    }

    .demo-gallery .video .demo-gallery-poster img {
      height: 48px;
      margin-left: -24px;
      margin-top: -24px;
      opacity: 0.8;
      width: 48px;
    }

    .demo-gallery.dark>ul>li a {
      border: 3px solid #04070a;
    }
  </style>
  <script>
    window.console = window.console || function (t) {};
  </script>
  <script>
    if (document.location.search.match(/type=embed/gi)) {
      window.parent.postMessage("resize", "*");
    }
  </script>
  <div class="cont">
    <div>
      <div class="demo-gallery">
        <ul id="lightgallery">

        </ul>
      </div>
    </div>
  </div>
  <script src="https://cpwebassets.codepen.io/assets/common/stopExecutionOnTimeout-157cd5b220a5c80d4ff8e0e70ac069bffd87a61252088146915e8726e5d9f147.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/picturefill/2.3.1/picturefill.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lightgallery/1.6.14/js/lightgallery-all.min.js"></script>
  <script id="rendered-js">
    $(document).ready(() => {
      $("#lightgallery").lightGallery({
        pager: true
      });

    });
    //# sourceURL=pen.js
  </script>

</body>

</html>
<?php } ?>