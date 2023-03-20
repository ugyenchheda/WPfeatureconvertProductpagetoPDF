<?php
ob_end_clean();
error_reporting(0);
ob_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>product page</title>
<style>
body{
	padding:30px 140px;
	font-family: 'frutiger-light';
	font-weight: 200;
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
    margin-left:1%;
}
.attr_left p {
    margin: 0px;
    font-size: 16px;
    line-height: 1.2;
}
.icon-part {
    margin-top: 10px;
}
.attr-list {
    width: 33%;
    float: left;
    text-align:center;
}
.att-right {
    border-left: 1px solid #000;
}
.btm-section {
    margin-top: 20px;
    border-top: 1px solid #000;
    padding-top: 20px;
}
.product-text {
    width: 63%;
    float: left;
    border-right: 2px solid #333;
    padding-right: 2%;
}
.product-text h2{margin:0px 0px 0px -10px 0;padding:0px;}
.right-barcode {
    float: left;
    padding-left: 2%;
    margin-bottom: -10px;
}
.attriTxt {
	font-size: 14px;
	font-family: frutiger-light !important;
	line-height: 15px;
	font-weight: 200;
	margin-top: -3px;
}
.sideTxt {
	font-size: 15px;
	font-family: frutiger-light !important;
	line-height: 5px;
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
</style>
</head>
<body>
<div class="site-logo">
	<?php  
	$data_terms = (array) (isset($data['category'][0]) && !empty($data['category'][0]))?$data['category'][0]:array();
	$cat_id =  $data_terms->term_id;
	$child = get_terms( 'producer', array( 'parent' => $cat_id, 'hide_empty' => false) );
	if(empty($child)){
	 $thumbnail_id = get_woocommerce_term_meta( $cat_id, 'palmer_producer_logo_id', true );
	 $producer_image = wp_get_attachment_url( $thumbnail_id);
	}
	else{
	$thumbnail_id = get_woocommerce_term_meta( $cat_id3, 'palmer_producer_logo_id', true );
	$producer_image = wp_get_attachment_url( $thumbnail_id);
	}
	if($producer_image !=''){ ?>
	<img src="<?php echo str_replace( 'https://', 'http://', $producer_image);?>" width="150px" />
<?php } ?>
</div>
<div class="clear"></div>
<!-------------------  top section  -------->
<div class="top-part">
	<div class="product-img">
		<?php //added for Riedel
			 if($data_terms->name=='Riedel'){
			 	$url_img = str_replace( 'https://', 'http://',  $data['image'] );
				 ?>
			 	<img src="<?php echo $url_img ;?>"  width="125"/>
		 <?php }else{ 			
			 	$url_img = str_replace( 'https://', 'http://',  $data['image'] );
		 	?>
		<img src="<?php echo $url_img;?>" height="450px" />
	<?php }
	?>
	</div>
	<div class="porduct-info">
		<div class="product-logo">
			<h1 style="font-size: 35px;"><?php echo $data['title'];?></h1>
		</div>
		<div class="attr">
			<div class="attr_left">
				<?php if($data['attributes']['pa_varetype']):?>
					<p class="myMargin"><span class="sideTxt"><strong>Varetype:</strong></span>
						<span class="sideTxt"><?php echo $data['attributes']['pa_varetype']; ?></span></p>
				<?php endif;  ?>
				<?php if($data['attributes']['pa_land']):?>
					<p class="myMargin"><span class="sideTxt"><strong>Land:</strong></span>
					   <span class="sideTxt"><?php echo $data['attributes']['pa_land']; ?></span></p>
				<?php endif;  ?>
				<?php if($data['attributes']['pa_distrikt']):?>
					<p class="myMargin"><span class="sideTxt"><strong>Distrikt:</strong></span>
					   <span class="sideTxt"><?php echo $data['attributes']['pa_distrikt']; ?></span></p>
				<?php endif;  ?>
				<?php //added for Riedel
				 if($data_terms->name=='Riedel'){ ?>
					 <?php if($data['attributes']['pa_hoyde']):?><br/>
					 <p class="myMargin"><span class="sideTxt"><strong>Høyde:</strong></span>
							<span class="sideTxt"><?php echo $data['attributes']['pa_hoyde']; ?></span></p>
				 <?php endif;  ?>
				<?php } ?>
				<?php if($data['attributes']['pa_volum']):?>
					<p class="myMargin"><span class="sideTxt"><strong>Volum:</strong></span>
					   <span class="sideTxt"><?php echo $data['attributes']['pa_volum']; ?></span></p>
				<?php endif;  ?>
				<?php //added for Riedel
				 if($data_terms->name=='Riedel'){ ?>

					 <?php if($data['attributes']['pa_diameter']):?>
						 <p class="myMargin"><span class="sideTxt"><strong>Diameter:</strong></span>
								<span class="sideTxt"><?php echo $data['attributes']['pa_diameter']; ?></span></p>
					 <?php endif;  ?>

					 <?php if($data['attributes']['pa_serie']):?>
					 <p class="myMargin"><span class="sideTxt"><strong>Serie:</strong></span>
							<span class="sideTxt"><?php echo $data['attributes']['pa_serie']; ?></span></p>
				 <?php endif;  ?>
				<?php } ?>
			</div>
			<div class="attr_left right">
				<?php if(isset($data['attributes']['pa_underdistrikt'])):?>
					<p class="myMargin"><span class="sideTxt"><strong>Underdistrikt:</strong></span>
					   <span class="sideTxt"><?php echo $data['attributes']['pa_underdistrikt']; ?></span></p>
				<?php endif;  ?>
				<?php if(isset($data['attributes']['pa_argang'])):?>
					<p class="myMargin"><span class="sideTxt"><strong>Argang:</strong>
					<span class="sideTxt"></span><?php echo $data['attributes']['pa_argang']; ?></span></p>
				<?php endif;  ?>
				<?php if(isset($data['attributes']['pa_alkohol'])):?>
					<p class="myMargin"><span class="sideTxt"><strong>Alkohol:</strong></span>
					   <span class="sideTxt"><?php echo $data['attributes']['pa_alkohol']; ?></span></p>
				<?php endif;  ?>
				<?php if(isset($data['price'])):?>
					<p class="myMargin"><span class="sideTxt"><strong>Pris:</strong></span>
					   <span class="sideTxt"><?php echo $data['price']; ?></span></p>
				<?php endif;  ?>
			</div>
		</div>
		<div class="icon-part">
			<div class="attr_left">
        		<?php if(isset($data['attributes_images']['pa_fylde_image'])):?>
				<div class="attr-list">
					<p><span class="topTxt">Fylde</span></p>
				    <img src="<?php echo str_replace( 'https://', 'http://', $data['attributes_images']['pa_fylde_image']); ?>"/>
				</div>
      			<?php endif; ?>
        		<?php if(isset($data['attributes_images']['pa_friskhet_image'])):?>
				<div class="attr-list">
					<p><span class="topTxt">Friskhet</span></p>
				    <img src="<?php echo str_replace( 'https://', 'http://', $data['attributes_images']['pa_friskhet_image']); ?>"/>
				</div>
      			<?php endif; ?>
        		<?php if(isset($data['attributes_images']['pa_bitterhet_image'])):?>
				<div class="attr-list">
					<p><span class="topTxt">Bitterhet</span></p>
				    <img src="<?php echo str_replace( 'https://', 'http://',$data['attributes_images']['pa_bitterhet_image']); ?>"/>
				</div>
      			<?php endif; ?>
        		<?php if(isset($data['attributes_images']['pa_garvestoffer_image'])):?>
				<div class="attr-list">
					<p><span class="topTxt">Garvestoffer</span></p>
				    <img src="<?php echo str_replace( 'https://', 'http://', $data['attributes_images']['pa_garvestoffer_image']); ?>"/>
				</div>
      			<?php endif; ?>
        		<?php if(isset($data['attributes_images']['pa_sodme_image'])):?>
				<div class="attr-list">
					<p><span class="topTxt">Sodme</span></p>
				    <img src="<?php echo  str_replace( 'https://', 'http://', $data['attributes_images']['pa_sodme_image']); ?>"/>
				</div>
      			<?php endif; ?>
			</div>
			<div class="att-right attr_left" style="padding-left: 5px;">
        		<?php foreach ($data['passertil_data'] as $key => $value) { ?>
        			<div class="attr-list">
					<p><span class="topTxt"><?php echo $value['name']; ?></span></p>
					<?php if(!empty($value['image'])){ ?>
				    <img src="<?php echo  str_replace( 'https://', 'http://', $value['image']); ?>"/>
					<?php } ?>
				</div>
        		<?php } ?>
			</div>
		</div>
	</div>
</div>
		<!-------------------  bottom section  -------->
		<div class="btm-section">
			<div class="product-text">
				<?php if($data['karakteristikk']):?>
				<strong><span class="sideTxt">Karakteristikk:</span></strong>
				<p class="attriTxt"><?php echo $data['karakteristikk']; ?></p>
				<?php endif;  ?>
				<?php if($data['matretter']):?>
				<strong><span class="sideTxt">Matretter:</span></strong>
				<p class="attriTxt"><?php echo $data['matretter']; ?></p>
				<?php endif;  ?>
			</div>
			<div class="right-barcode">
				<?php if($data['attributes']['pa_sukker']):?>
					<p class="myMargin"><span class="sideTxt"><strong>Sukker:</strong></span>
						<span class="sideTxt"><?php echo $data['attributes']['pa_sukker']; ?></span></p>
				<?php endif;  ?>
				<?php if($data['attributes']['pa_syre']):?>
					<p class="myMargin"><span class="sideTxt"><strong>Syre:</strong></span>
						<span class="sideTxt"><?php echo $data['attributes']['pa_syre']; ?></span></p>
				<?php endif;  ?>
				<?php if($data['attributes']['pa_rastoff']):?>
					<p class="myMargin"><span class="sideTxt"><strong>Råstoff:</strong></span>
						<span class="sideTxt"><?php echo $data['attributes']['pa_rastoff']; ?></span></p>
				<?php endif;  ?>
				<?php if($data['attributes']['pa_produktutvalg']):?>
					<p class="myMargin"><span class="sideTxt"><strong>Produktutvalg:</strong></span>
						<span class="sideTxt"><?php echo $data['attributes']['pa_produktutvalg']; ?> </span></p>
				<?php endif;  ?>
				<?php if($data['attributes']['pa_butikkategori']):?>
					<p class="myMargin"><span class="sideTxt"><strong>Butikkategori:</strong></span>
						<span class="sideTxt"><?php echo $data['attributes']['pa_butikkategori']; ?> </span></p>
				<?php endif;  ?>
				<?php //added for Riedel
				 if($data_terms->name=='Riedel'){ ?>
					 <?php if($data['attributes']['pa_vekturaid']):?>
					 <p class="myMargin"><span class="sideTxt"><strong>Vecturanummer:</strong></span>
							<span class="sideTxt"><?php echo $data['attributes']['pa_vekturaid']; ?></span></p>
				 <?php endif;  ?>
				<?php } ?>
				<?php if($data['attributes']['pa_varenummer']):?>
					<p class="myMargin"><span class="sideTxt"><strong>Varenummer:</strong></span>
						<span class="sideTxt"><?php echo $data['attributes']['pa_varenummer']; ?></span> </p>
				<?php endif;  ?>
				<?php if($data['attributes']['pa_emballasjetype']):?>
					<p class="myMargin"><span class="sideTxt"><strong>Emballasjetype:</strong></span>
						<span class="sideTxt"><?php echo $data['attributes']['pa_emballasjetype']; ?> </span></p>
				<?php endif;  ?>
				<p>
				<?php	//added for Riedel
					 if($data_terms->name!='Riedel'){ ?>

					<span class="sideTxt"><strong>Barcode:</strong></span><?php echo do_shortcode('[yith_render_barcode id="'.$data['id'].'"]'); ?>

				<?php } 	?>
				</p>
			</div>
		<div class="clear"></div>
		</div>
		<!-------------------  footer section  -------->
		<div class="footer">
			<p>© <?php echo date('Y');?> <a href="#">Palmer Group AS</a>. All rights reserved</p>
		</div>
	</div>
</div>

</body>
</html>
<?php


$pdftemplate =ob_get_contents();
if($data['title']=$data['title']){
ob_end_clean();
}else {
ob_end_clean();
}
?>
