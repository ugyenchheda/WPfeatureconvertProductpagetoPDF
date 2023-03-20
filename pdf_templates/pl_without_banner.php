<?php
ob_end_clean();
error_reporting(0);
ob_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title></title>

<style>
.col-md-1 {
  width: 8%;
  float: left;
  padding: 20px 10px 0px 10px;

}
.col-md-4 {
  width: 55%;
  float: left;
  
  padding: 0px 20px 0px 10px;
    margin: 30px 0px 0px 0px;
}
.col-md-2 {
  width: 25%;
  float: left;
  border-left: 1px solid #000;
  padding-left: 20px;
  padding-top:20px;
  padding-bottom: 20px;
}
.sideStyle {
font-family: arial;
padding-left: 10px;
padding-bottom: 0px;
padding-top: 0px;
}
li {
  list-style: none;
  border-bottom: 1px solid #000;
  padding-bottom:40px;
}
.imgHeight {
max-height: 50px;
}
.col-md-6 {
  width: 50%;
  float: left;

}
.textRight {
  text-align: right;
  padding-right:15px;
}
.textLeft {
  text-align: left;
  padding-left:15px;
}
.footerTxt {
  font-family: frutiger-light; 
  font-size: 14px; 
  line-height: 16px; 
  margin-top:0px; 
  margin-bottom: 1px;
}
.footerLogo {
   width:175px;
   margin-top:-10px;

}
.attriTitle {
  font-family:frutiger-light;
  font-size:14px;
  padding:0px;
  margin:0px;
  line-height:15px;
}
.headerMain {
  text-decoration:none;
  color:#ca504b;
  font-size:16px;
  font-family: 'bodi';
  margin-top:2px;
  margin-bottom: -10px;

}
.upCase {
  text-transform: uppercase;
}
</style>
</head>
  <body>  
    <div class="site-content" role="main">
    <div class="container">
        <?php
        global $wpdb;
        $user = $_COOKIE['gd_favuser'];
        $results = $wpdb->get_results( "SELECT * FROM `wp_globdig_wishlist` WHERE `user_id` = '".$user."' ORDER BY `glob_order` ASC", OBJECT );
     
       if($results){
          echo '<ul id="sortable">';
            foreach ($results as $key => $value) {
                        $result1 = $wpdb->get_results( "SELECT * FROM
                                            palmer_live.wpmd_41_postmeta where post_id = $value->product_id
                                            and meta_key like 'produksjonsmetode' order by meta_id desc limit 1", OBJECT );                       
                       $data = product_data_pdf( $value->product_id );                     
                        ?>
                     <li class="wishblock">
                        <div class="col-md-1 text-center imgHeight" >
                          <?php if(isset($data['image']) && !empty($data['image'])):?>
                            <img src="<?php echo   str_replace( 'https://', 'http://', $data['image']);?>">
                          <?php endif;  ?>
                        </div>
                        <div class="col-md-4">
                          <?php if(isset($data['attributes']['pa_produsent'])):?>
                          <p class="attriTitle upCase"><?php echo $data['attributes']['pa_produsent']; ?></p>
                          <?php endif;  ?>
                          <?php if(isset($data['title'])):?>
                          <p class="headerMain">
                            <b><?php echo $data['title'];?></b>
                          </p>
                          <?php endif;  ?>
                          <?php if(isset($data['attributes']['pa_rastoff'])):?>
                          <p class="attriTitle">
                            <?php echo $data['attributes']['pa_rastoff']; ?>
                          </p>
                          <?php endif;  ?>
                          <?php if(isset($data['produksjonsmetode'])):?>
                          <p class="attriTitle">
                            <?php echo $data['produksjonsmetode']; ?>
                          </p>
                          <?php endif;  ?>
                        </div>
                        <div class="col-md-2 priceStyle">
                          <?php if(isset($data['attributes']['pa_varenummer'])):?>
                           <p class="attriTitle"><strong> Vinmonopol nr:</strong> <?php echo $data['attributes']['pa_varenummer']; ?></p>
                          <?php endif;  ?>
                          <?php if(isset($data['price'])):?>
                            <p class="attriTitle"><strong>Vinmonopol Pris:</strong> <?php echo $data['price']; ?></p> 
                          <?php endif;  ?>
                          <?php if(isset($data['attributes']['pa_vekturaid'])):?>
                            <p class="attriTitle"><strong>Vectura nr:</strong>  <?php echo $data['attributes']['pa_vekturaid']; ?></p>
                          <?php endif;  ?>
                          <?php if(isset($data['attributes']['pa_vecturapris'])):?>
                            <p class="attriTitle"><span class="sideTxt"><strong>Vectura Pris:</strong></span><span class="sideTxt"><?php echo $data['attributes']['pa_vecturapris']; ?></span></p>
                          <?php endif;  ?>
                          <?php if(isset($data['attributes']['pa_volum'])):?>
                          <p class="attriTitle"><strong>Volum:</strong>  <?php echo $data['attributes']['pa_volum']; ?></p>
                          <?php endif;  ?>
                          <?php echo do_shortcode('[yith_render_barcode id="'.$data['id'].'" protocol="EAN13"]'); ?>
                        </div>
                    </li>
          <?php } 
          echo '<ul>';
        } ?>   

                     

       
        <div style="height:20px"></div>
        <div class="col-md-6 text-right;">
          <div class="textRight">
            <p class="footerTxt"><b>Palmer Group</b></p>
            <p class="footerTxt">Strandveien 55, 1366 Lysaker</p>
            <p class="footerTxt">Telefon: 24 11 56 70</p>
            <p class="footerTxt">Web: www.palmer.no</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="textLeft">
          <img class="footerLogo" src="http://newpalmer.indexportal.no/wp-content/uploads/2019/10/palmerwine.png">
          </div>
        </div>

    </div>
</div>
  </body>
</html>

<?php

$pdftemplate =ob_get_contents();
ob_end_clean();
?>
