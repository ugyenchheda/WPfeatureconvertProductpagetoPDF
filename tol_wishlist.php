<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: https://developer.wordpress.org/themes/basics/template-hierarchy/
 * Template Name: wishlist
 * @package storefront
 */

get_header(); ?>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<?php echo do_shortcode('[basel_wishlist]', true);?>
<div class="clear"></div>
<div class="container">
    <div class="btn_wrap">
        <div class="col-md-6">
            <h3 class="fav-list">Smakeskjema:</h3>
            <div class="form-group downloadpdf">
                <form action="<?php echo home_url('/pdf'); ?>" method="post">
                    <div class="form-group downloadpdf">
                        <input type="hidden" name="pl_without_banner" value='yes'>
                        <input type="submit" class="btn btn-default" value="Smakeskjema uten forside" name="submited">
                    </div>
                </form>
                <div class="form-group downloadpdf">
                    <button type="button" class="btn printBtn" data-toggle="modal" data-target="#myModal">
                        Smakeskjema Med forside
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <h3 class="fav-list">Produktark:</h3>
            <form action="<?php echo home_url('/pdf'); ?>" method="post">
                <div class="form-group downloadpdf">
                    <input type="hidden" name="wishlistpd_withoutbanner" value='yes'>
                    <input type="submit" class="btn btn-default" value="Produktark Uten forside" name="submited">
                </div>
            </form>
            <div class="form-group downloadpdf">
                <button type="button" class="btn printBtn" data-toggle="modal" data-target="#Produktark">
                        Produktark Med forside
                    </button>
            </div>
        </div>
        <div style="height:50px;clear:both;width:100%;"></div>
    </div>
</div>
<div class="modal fade product_view" id="Produktark">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                Last opp ditt eget bannerbilde og informasjon til pdf
                <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
            </div>
            <div class="modal-body">
                <div class="row">
              
                    <form action="<?php echo home_url('/pdf'); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group downloadpdf">
            <input type="file" name="fileToUpload" accept="image/*" class="fileToUpload">   <br/>
            <input type="hidden" name="imgpth"  class="imgpth"> <br/>
            <textarea name="text" placeholder="Legg til informasjon ..."></textarea>
            <input type="hidden" name="wishlistpd_withbanner" value='yes'>
            <input type="submit" class="btn btn-default" value="Produktark Med forside" name="submited">



                    </div>


    <script>

    jQuery(".fileToUpload").change(function(){
            readURL(this);
        });

    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    jQuery('.imgpth').attr('value', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

</script>

                </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade product_view" id="myModal">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
		Last opp ditt eget bannerbilde og informasjon til pdf
            <a href="#" data-dismiss="modal" class="class pull-right"><span class="glyphicon glyphicon-remove"></span></a>
        </div>
        <div class="modal-body">
            <div class="row">
            	<form action="<?php echo home_url('/pdf'); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group downloadpdf">
            <input type="file" name="fileToUpload" accept="image/*" class="fileToUpload">	<br/>
            <input type="hidden" name="imgpth"  class="imgpth">	<br/>
            <textarea name="text" placeholder="Legg til informasjon ..."></textarea>
            <input type="hidden" name="wishlistpl_withbanner" value='yes'>
            <input type="submit" class="btn btn-default" value="Smakeskjema Med forside" name="submited">



					</div>


    <script>

    jQuery(".fileToUpload").change(function(){
            readURL(this);
        });

    function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    jQuery('.imgpth').attr('value', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

</script>

				</form>
             </div>
        </div>
    </div>
</div>
</div>

<style type="text/css" media="screen">
.modal-content {
    margin-top: 100px;
}
input#fileToUpload {
    margin: 10px auto -10px auto;
}
.modal-header {
    min-height: 16.43px;
    padding: 15px;
    border-bottom: 1px solid #e5e5e5;
    text-align: center;
    font-size: 20px;
    color: #820303;
    font-family: Karma,Arial, Helvetica, sans-serif;
}
.modal-body {
    position: relative;
    padding: 15px 50px;
}
textarea {
    margin-bottom: 25px;
}
.downloadpdf button.btn.printBtn:hover, .downloadpdf button.btn.printBtn:focus {
    color: #fff;
}
.woocommerce-MyAccount-content {
    width: 100% !important;
}
.form-group.downloadpdf {
    margin-top: 25px;
}
.btn_wrap {
    border-top: 2px solid #d1d1d1;
}
button.btn {
    background: #ececec;
    border-radius: 0px !important;
    padding: 7px 23px;
}
	html { margin-top: 32px !important; }
	* html body { margin-top: 32px !important; }
	@media screen and ( max-width: 782px ) {
		html { margin-top: 46px !important; }
		* html body { margin-top: 46px !important; }
	}
	.modal.in .modal-dialog {
    z-index: 9999 !important;
}
  .site-content {
  margin-top: 110px !important;
  }
	.wishHeader {
	    background: #efefef;
    padding: 12px;
    overflow: hidden;
	}
	.bgStyle {
	background: #7f202a;
    color: #fff;    ;
    border-radius: 50%;
	}
.wishblock {
    padding: 15px 1px 15px 1px;
    border-bottom: 1px solid #dbdbdb;
    overflow: hidden;
    cursor: move;
}
.bgStyle:hover {
    background: white;
    color: #ff0000;
}
.thumbImg {
    height: 64px;
    background: #efefef;
	}
	.productName {
	    color: #9B448F;
    font-size: 16px;
	}
.priceStyle {
color: #5d5d5d;
    font-size: 16px;
	font-weight: bold;
	}
  .bgStyle {
    background: #7f202a;
    color: #fff;
    border-radius: 50%;
    padding: 4px 5px;
}
  /*@media only screen and (max-width: 900px) {
  .wishHeader {
    display: none !important;
}
}*/
</style>
<?php get_footer(); ?>
