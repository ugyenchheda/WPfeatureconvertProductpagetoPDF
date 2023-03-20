<?php

/*Template Name: pdf */

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_POST["single_product"]) && $_POST["product_id"] ):

	$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
	$fontDirs = $defaultConfig['fontDir'];
	$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
	$fontData = $defaultFontConfig['fontdata'];

	$mpdf = new \Mpdf\Mpdf([
	    'fontDir' => array_merge($fontDirs, [
	        dirname( __FILE__ ). '/fonts',
	    ]),
	    'fontdata' => $fontData + [
	        'frutiger' => [
	            'R' => 'Frutiger-Normal.ttf',
	            'I' => 'FrutigerObl-Normal.ttf',
	            'L' => 'frutiger-light.ttf',
	            'B' => 'Frutiger-Bold.ttf',
	        ],
	     	'frutiger-light' => [
	             'R' => "frutiger-light.ttf",
	            'I' => 'FrutigerObl-Normal.ttf',
	            'L' => 'frutiger-light.ttf',
	            'B' => 'Frutiger-Bold.ttf',
	        ],
	        'bodi' => [
	            'R' => 'BOD_I.ttf',
	            'B' => 'BOD_BI.ttf',
	        ]
	    ],
	    'default_font' => 'frutiger-light'
	]);

	$mpdf->SetDisplayMode(100);
	$pid = $_POST["product_id"];
	$data = product_data_pdf( $pid );
	include('pdf_templates/product_single.php');
	$html =  $pdftemplate;
	if($pid=='26011'){
		$mpdf->img_dpi = 96;
	}
	$mpdf->WriteHTML($html);
	$mpdf->showImageErrors = true;
	$mpdf->Output( ''.$data['title'].'.pdf', 'D');
endif;




if(isset($_POST["pl_without_banner"]) && $_POST["submited"] ):
	$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
	$fontDirs = $defaultConfig['fontDir'];
	$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
	$fontData = $defaultFontConfig['fontdata'];
	$mpdf = new \Mpdf\Mpdf([
	    'fontDir' => array_merge($fontDirs, [
	        dirname( __FILE__ ). '/fonts',
	    ]),
	    'fontdata' => $fontData + [
	        'frutiger' => [
	            'R' => 'Frutiger-Normal.ttf',
	            'I' => 'FrutigerObl-Normal.ttf',
	            'L' => 'frutiger-light.ttf',
	            'B' => 'Frutiger-Bold.ttf',
	        ],
	     	'frutiger-light' => [
	             'R' => "frutiger-light.ttf",
	            'I' => 'FrutigerObl-Normal.ttf',
	            'L' => 'frutiger-light.ttf',
	            'B' => 'Frutiger-Bold.ttf',
	        ],
	        'bodi' => [
	            'R' => 'BOD_I.ttf',
	            'B' => 'BOD_BI.ttf',
	        ]
	    ],
	    'default_font' => 'frutiger-light'
	]);

	$mpdf->SetDisplayMode(100);

	include('pdf_templates/pl_without_banner.php');
	$html =  $pdftemplate;


	$mpdf->WriteHTML($html);
	$mpdf->Output( 'Wishlist.pdf', 'D');

endif;

if(isset($_POST["wishlistpd_withoutbanner"]) && $_POST["submited"] ):
	$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
	$fontDirs = $defaultConfig['fontDir'];
	$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
	$fontData = $defaultFontConfig['fontdata'];
	$mpdf = new \Mpdf\Mpdf([
	    'fontDir' => array_merge($fontDirs, [
	        dirname( __FILE__ ). '/fonts',
	    ]),
	    'fontdata' => $fontData + [
	        'frutiger' => [
	            'R' => 'Frutiger-Normal.ttf',
	            'I' => 'FrutigerObl-Normal.ttf',
	            'L' => 'frutiger-light.ttf',
	            'B' => 'Frutiger-Bold.ttf',
	        ],
	     	'frutiger-light' => [
	             'R' => "frutiger-light.ttf",
	            'I' => 'FrutigerObl-Normal.ttf',
	            'L' => 'frutiger-light.ttf',
	            'B' => 'Frutiger-Bold.ttf',
	        ],
	        'bodi' => [
	            'R' => 'BOD_I.ttf',
	            'B' => 'BOD_BI.ttf',
	        ]
	    ],
	    'default_font' => 'frutiger-light'
	]);

	$mpdf->SetDisplayMode(100);

	include('pdf_templates/pd_without_banner.php');
	$html =  $pdftemplate;
	$mpdf->WriteHTML($html);
	$mpdf->Output( 'Wishlist.pdf', 'D');

endif;
if(isset($_POST["wishlistpd_withbanner"]) && $_POST["submited"] ):


	$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
	$fontDirs = $defaultConfig['fontDir'];
	$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
	$fontData = $defaultFontConfig['fontdata'];
	$mpdf = new \Mpdf\Mpdf([
	    'fontDir' => array_merge($fontDirs, [
	        dirname( __FILE__ ). '/fonts',
	    ]),
	    'fontdata' => $fontData + [
	        'frutiger' => [
	            'R' => 'Frutiger-Normal.ttf',
	            'I' => 'FrutigerObl-Normal.ttf',
	            'L' => 'frutiger-light.ttf',
	            'B' => 'Frutiger-Bold.ttf',
	        ],
	     	'frutiger-light' => [
	             'R' => "frutiger-light.ttf",
	            'I' => 'FrutigerObl-Normal.ttf',
	            'L' => 'frutiger-light.ttf',
	            'B' => 'Frutiger-Bold.ttf',
	        ],
	        'bodi' => [
	            'R' => 'BOD_I.ttf',
	            'B' => 'BOD_BI.ttf',
	        ]
	    ],
	    'default_font' => 'frutiger-light'
	]);

	$mpdf->SetDisplayMode(100);

	include('pdf_templates/pd_with_banner.php');
	$html =  $pdftemplate;


	$mpdf->WriteHTML($html);
	$mpdf->Output( 'Wishlist.pdf', 'D');

endif;
if(isset($_POST["wishlistpl_withbanner"]) && $_POST["submited"] ):
	$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
	$fontDirs = $defaultConfig['fontDir'];
	$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
	$fontData = $defaultFontConfig['fontdata'];
	$mpdf = new \Mpdf\Mpdf([
	    'fontDir' => array_merge($fontDirs, [
	        dirname( __FILE__ ). '/fonts',
	    ]),
	    'fontdata' => $fontData + [
	        'frutiger' => [
	            'R' => 'Frutiger-Normal.ttf',
	            'I' => 'FrutigerObl-Normal.ttf',
	            'L' => 'frutiger-light.ttf',
	            'B' => 'Frutiger-Bold.ttf',
	        ],
	     	'frutiger-light' => [
	             'R' => "frutiger-light.ttf",
	            'I' => 'FrutigerObl-Normal.ttf',
	            'L' => 'frutiger-light.ttf',
	            'B' => 'Frutiger-Bold.ttf',
	        ],
	        'bodi' => [
	            'R' => 'BOD_I.ttf',
	            'B' => 'BOD_BI.ttf',
	        ]
	    ],
	    'default_font' => 'frutiger-light'
	]);

	$mpdf->SetDisplayMode(100);

	include('pdf_templates/pl_with_banner.php');
	$html =  $pdftemplate;


	$mpdf->WriteHTML($html);
	$mpdf->Output( 'Wishlist.pdf', 'D');

endif;
if(isset($_POST["wishlistpl_withoutbanner"]) && $_POST["submited"] ):
	$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
	$fontDirs = $defaultConfig['fontDir'];
	$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
	$fontData = $defaultFontConfig['fontdata'];
	$mpdf = new \Mpdf\Mpdf([
	    'fontDir' => array_merge($fontDirs, [
	        dirname( __FILE__ ). '/fonts',
	    ]),
	    'fontdata' => $fontData + [
	        'frutiger' => [
	            'R' => 'Frutiger-Normal.ttf',
	            'I' => 'FrutigerObl-Normal.ttf',
	            'L' => 'frutiger-light.ttf',
	            'B' => 'Frutiger-Bold.ttf',
	        ],
	     	'frutiger-light' => [
	             'R' => "frutiger-light.ttf",
	            'I' => 'FrutigerObl-Normal.ttf',
	            'L' => 'frutiger-light.ttf',
	            'B' => 'Frutiger-Bold.ttf',
	        ],
	        'bodi' => [
	            'R' => 'BOD_I.ttf',
	            'B' => 'BOD_BI.ttf',
	        ]
	    ],
	    'default_font' => 'frutiger-light'
	]);

	$mpdf->SetDisplayMode(100);

	include('pdf_templates/pl_without_banner.php');
	$html =  $pdftemplate;


	$mpdf->WriteHTML($html);
	$mpdf->Output( 'Wishlist.pdf', 'D');

endif;

?>
