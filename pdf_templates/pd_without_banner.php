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
body{
  padding:30px 140px;
  font-family: 'frutiger-light';
  font-weight: 200;
}
.clear{
	width:100;clear:both;display:block;
}
.site-logo{
	height:50px;
}
.site-logo img {
      float: right;
    width:200px;

}
.site-logo {float:right;width:100%;text-align:right;}
.clear {
    clear: both;
    display: block;
    width: 100%;
}
.product-img {
	margin-top:30px;	
    float: left;
    width: 30%;
    text-align: center;
}
.porduct-info {
    float: left;
    width: 70%;
}
.product-logo {
    text-align: center;
    padding-bottom:20px;
}
.product-logo h1{
  margin:0px;
  padding:0px;
  line-height:1.2;
  font-family: 'bodi';
  font-size: 30px;
}
.attr_left {
    width: 48%;
    float: left;    
}
.attr_left p {
    margin: 0px;
    font-size: 16px;
    line-height: 1.2;
}
.icon-part {
    margin-top: 25px;
}
.attr-list {
    width: 33%;
    float: left;
    text-align:center;
}
.attr-list p{
	padding-bottom:10px;
}
.att-right {
    border-left: 1px solid #000;
    padding-left:2%;
    margin-left:2%;
}

.btm-section {
    margin-top: 30px;
    border-top: 1px solid #000;
    padding-top: 30px;
    margin-bottom:26px;
}
.product-text {
    width: 63%;
    float: left;    
    padding-right: 2%;
}
.product-text h2{margin:0px 0px 0px -10px 0;padding:0px;}

.right-barcode {
    float: left;
    padding-left: 2%;
    margin-bottom: -10px;
    border-left: 1px solid #333;
}

p.attriTxt {
  font-size: 14px;
  font-family: frutiger-light !important;
  line-height: 15px !important;
  font-weight: 200;
  margin-top: -3px;
}
.sideTxt {
  font-size: 15px;
  font-family: frutiger-light !important;
  line-height: 5px !important;
  font-weight: 200;
  margin-top: -5px;
}
.topTxt {
  font-size: 14px;
  font-family: frutiger-light !important;
  line-height: 5px;
  font-weight: 200;
  margin-top: -5px;
}
.right-barcode p {
    font-size: 16px;
    margin: 0px;
    line-height: 1.2;
}
.footer {
    text-align: center;
    background: #000;
    padding: 10px 0px;
    margin: 50px 0px 20px 0px;
    color: #fff;
}
.footer a {
    color: #e1e1e1;
}
.myMargin {
  margin-top:-10px !important;
}
.pull-right {
  float: right;
}
h1 {
  font-size: 30px;
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

</style>
</head>
  <body>  
    
<div class="site-content" role="main">
	<div class="container">
  
        <?php
        global $wpdb;
        $user = $_COOKIE['gd_favuser'];
		$results = $wpdb->get_results( "SELECT * FROM `wp_globdig_wishlist` WHERE `user_id` = '".$user."' ORDER BY `glob_order` ASC", OBJECT );	
			
    //  $postId = $value->product_id;
       if($results){          
            foreach ($results as $key => $value) { 
               $data = product_data_pdf( $value->product_id ); 
               ?> 


		<div class="site-logo">
		  <!-- <img src="< ?php echo $data['first_parent_image'];?>" width="150px" /> -->
		</div>
		<div class="clear"></div>
	<!-------------------  top section  -------->
		<div class="top-part">
			<?php if(isset($data['image']) && !empty($data['image'])):?>
				<div class="product-img">
					<img src="<?php echo str_replace( 'https://', 'http://', $data['image']);?>" height="450px" />
				</div>
		  	<?php endif;  ?> 
		  <div class="porduct-info">
		    <div class="product-logo">
		      <h1 style="font-size: 35px;"><?php echo $data['title'];?></h1>
			  <?php if(isset($data['category_image']) && !empty($data['category_image'])):?>
		      	<img src="<?php echo str_replace( 'https://', 'http://', $data['category_image']);?>" height="150px"/>
			  <?php endif;  ?>
		    </div>
		    <div class="attr">
		      <div class="attr_left">
		        <?php if(isset($data['attributes']['pa_varetype'])):?>
		          <p class="myMargin"><span class="sideTxt"><strong>Varetype:</strong></span>
		            <span class="sideTxt"><?php echo $data['attributes']['pa_varetype']; ?></span></p>
		        <?php endif;  ?>
		        <?php if(isset($data['attributes']['pa_argang'])):?>
		          <p class="myMargin"><span class="sideTxt"><strong>Årgang:</strong>
		          <span class="sideTxt"></span><?php echo $data['attributes']['pa_argang']; ?></span></p>
		        <?php endif;  ?>
		        <?php if(isset($data['attributes']['pa_land'])):?>
		          <p class="myMargin"><span class="sideTxt"><strong>Land:</strong></span>
		             <span class="sideTxt"><?php echo $data['attributes']['pa_land']; ?></span></p>
		        <?php endif;  ?>
		        <?php if(isset($data['attributes']['pa_distrikt'])):?>
		          <p class="myMargin"><span class="sideTxt"><strong>Distrikt:</strong></span>
		             <span class="sideTxt"><?php echo $data['attributes']['pa_distrikt']; ?></span></p>
		        <?php endif;  ?>
		        <?php if(isset($data['attributes']['pa_underdistrikt'])):?>
		          <p class="myMargin"><span class="sideTxt"><strong>Underdistrikt:</strong></span>
		             <span class="sideTxt"><?php echo $data['attributes']['pa_underdistrikt']; ?></span></p>
		        <?php endif;  ?>
			 </div>
		      <div class="attr_left right">
				<?php if(isset($data['attributes']['pa_volum'])):?>
		          <p class="myMargin"><span class="sideTxt"><strong>Volum:</strong></span>
		             <span class="sideTxt"><?php echo $data['attributes']['pa_volum']; ?></span></p>
		        <?php endif;  ?>
		        <?php if(isset($data['attributes']['pa_alkohol'])):?>
		          <p class="myMargin"><span class="sideTxt"><strong>Alkohol:</strong></span>
		             <span class="sideTxt"><?php echo $data['attributes']['pa_alkohol']; ?></span></p>
		        <?php endif;  ?>
		        <?php if(isset($data['price'])):?>
		          <p class="myMargin"><span class="sideTxt"><strong>Vinmonopolpris:</strong></span>
		             <span class="sideTxt"><?php echo $data['price']; ?></span></p>
		        <?php endif;  ?>
		        <?php if(isset($data['attributes']['pa_vecturapris'])):?>
		          <p class="myMargin"><span class="sideTxt"><strong>Vectura Pris:</strong></span>
		             <span class="sideTxt"><?php echo $data['attributes']['pa_vecturapris']; ?></span></p>
		        <?php endif;  ?>


		      </div>
		    </div>
		    <div class="icon-part">
		      <div class="attr_left">
		            <?php if(isset($data['attributes_images']['pa_fylde_image'])):?>
		        <div class="attr-list">
		          <p><span class="topTxt">Fylde</span></p>
		            <img src="<?php echo str_replace( 'https://', 'http://',  $data['attributes_images']['pa_fylde_image']); ?>" height="50px"/>
		        </div>
		            <?php endif; ?>
		            <?php if(isset($data['attributes_images']['pa_friskhet_image'])):?>
		        <div class="attr-list">
		          <p><span class="topTxt">Friskhet</span></p>
		            <img src="<?php echo str_replace( 'https://', 'http://',  $data['attributes_images']['pa_friskhet_image']); ?>" height="50px"/>
		        </div>
		            <?php endif; ?>
		            <?php if(isset($data['attributes_images']['pa_bitterhet_image'])):?>
		        <div class="attr-list">
		          <p><span class="topTxt">Bitterhet</span></p>
		            <img src="<?php echo str_replace( 'https://', 'http://',  $data['attributes_images']['pa_bitterhet_image']); ?>" height="50px"/>
		        </div>
		            <?php endif; ?>
		            <?php if(isset($data['attributes_images']['pa_garvestoffer_image'])):?>
		        <div class="attr-list">
		          <p><span class="topTxt">Garvestoffer</span></p>
		            <img src="<?php echo str_replace( 'https://', 'http://',  $data['attributes_images']['pa_garvestoffer_image']); ?>" height="50px"/>
		        </div>
		            <?php endif; ?>
		            <?php if(isset($data['attributes_images']['pa_sodme_image'])):?>
		        <div class="attr-list">
		          <p><span class="topTxt">Sodme</span></p>
		            <img src="<?php echo str_replace( 'https://', 'http://',  $data['attributes_images']['pa_sodme_image']); ?>" height="50px"/>
		        </div>
		            <?php endif; ?>
		      </div>
		      <div class="att-right attr_left ">
		            <?php foreach ($data['passertil_data'] as $key => $value) { ?>
		              <div class="attr-list">
		          <p><span class="topTxt"><?php echo $value['name']; ?></span></p>
		            <img src="<?php echo str_replace( 'https://', 'http://',  $value['image']); ?>" height="60px"/>
		        </div>
		            <?php } ?>
		      </div>
		    </div>
		  </div>
		</div>
    <!-------------------  bottom section  -------->
	    <div class="btm-section">
			<div class="product-text">
				<div class="text-part">      	
					<?php if(isset($data['karakteristikk'])):?>
					<strong><span class="sideTxt">Karakteristikk:</span></strong>
					<p class="attriTxt"><?php echo $data['karakteristikk']; ?></p>
					<?php endif;  ?>
				</div>
				<div class="text-part"> 
					<?php if(isset($data['matretter'])):?>
					<strong><span class="sideTxt">Matretter:</span></strong>
					<p class="attriTxt"><?php echo $data['matretter']; ?></p>
					<?php endif;  ?>	    
				</div>
			</div>
			<div class="right-barcode">
				<?php if(isset($data['attributes']['pa_sukker'])):?>
				  <p class="myMargin"><span class="sideTxt"><strong>Sukker:</strong></span>
				    <span class="sideTxt"><?php echo $data['attributes']['pa_sukker']; ?></span></p>
				<?php endif;  ?>
				<?php if(isset($data['attributes']['pa_syre'])):?>
				  <p class="myMargin"><span class="sideTxt"><strong>Syre:</strong></span>
				    <span class="sideTxt"><?php echo $data['attributes']['pa_syre']; ?></span></p>
				<?php endif;  ?>
				<?php if(isset($data['attributes']['pa_rastoff'])):?>
				  <p class="myMargin"><span class="sideTxt"><strong>Råstoff:</strong></span>
				    <span class="sideTxt"><?php echo $data['attributes']['pa_rastoff']; ?></span></p>
				<?php endif;  ?>
				<?php if(isset($data['attributes']['pa_produktutvalg'])):?>
				  <p class="myMargin"><span class="sideTxt"><strong>Produktutvalg:</strong></span>
				    <span class="sideTxt"><?php echo $data['attributes']['pa_produktutvalg']; ?> </span></p>
				<?php endif;  ?>
				<?php if(isset($data['attributes']['pa_butikkategori'])):?>
				  <p class="myMargin"><span class="sideTxt"><strong>Butikkategori:</strong></span>
				    <span class="sideTxt"><?php echo $data['attributes']['pa_butikkategori']; ?> </span></p>
				<?php endif;  ?>
				<?php if(isset($data['attributes']['pa_varenummer'])):?>
				  <p class="myMargin"><span class="sideTxt"><strong>Vinmonopolnummer:</strong></span>
				    <span class="sideTxt"><?php echo $data['attributes']['pa_varenummer']; ?></span> </p>
				<?php endif;  ?>
				<?php if(isset($data['attributes']['pa_vekturaid'])):?>
				  <p class="myMargin"><span class="sideTxt"><strong>Vecturanr:</strong></span>
				    <span class="sideTxt"><?php echo $data['attributes']['pa_vekturaid']; ?></span> </p>
				<?php endif;  ?>
				<?php if(isset($data['attributes']['pa_emballasjetype'])):?>
				  <p class="myMargin"><span class="sideTxt"><strong>Emballasjetype:</strong></span>
				    <span class="sideTxt"><?php echo $data['attributes']['pa_emballasjetype']; ?> </span></p>
				<?php endif;  ?>
				<p class="bar_code"><?php echo do_shortcode('[yith_render_barcode id="'.$data['id'].'"]'); ?></p>
			</div>
			<div class="clear"></div>
		</div>
  
  </div>
</div>

<?php } }?>
                      
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
