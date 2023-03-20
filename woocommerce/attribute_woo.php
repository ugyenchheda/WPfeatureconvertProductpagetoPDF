<?php
		global $product;
    $attributes = $product->get_attributes();


		foreach ( $attributes as $attribute ) :

		if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) 	{continue;}


		$values = wc_get_product_terms( $product->get_id(), $attribute['name'], array( 'fields' => 'names' ) );
		$att_val = apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );



		//if( empty( $att_val ) ){	continue;}


		 if(wc_attribute_label( $attribute['name'] ) == 'varenummer'){
			 $varenummer = wc_attribute_label( $attribute['name'] );
			 $varenummer_val = $att_val;
			 }
       elseif(wc_attribute_label( $attribute['name'] ) == 'vinhusetID'){
			 $vinhusetid = wc_attribute_label( $attribute['name'] );
			 $vinhusetid_val = trim(strip_tags($att_val));
			}
			elseif(wc_attribute_label( $attribute['name'] ) == 'varenavn'){
			 $varenavn = wc_attribute_label( $attribute['name'] );
			 $varenavn_val = $att_val;
			}
			elseif(wc_attribute_label( $attribute['name'] ) == 'vand'){
			 $land = wc_attribute_label( $attribute['name'] );
			 $land_val = $att_val;
			}
			 elseif(wc_attribute_label( $attribute['name'] ) == 'distrikt'){
			 $distrikt = wc_attribute_label( $attribute['name'] );
			 $distrikt_val = $att_val;
			}
			elseif(wc_attribute_label( $attribute['name'] ) == 'underdistrikt'){
			 $underdistrikt = wc_attribute_label( $attribute['name'] );
			 $underdistrikt_val = $att_val;
			}
			elseif(wc_attribute_label( $attribute['name'] ) == 'karakteristikk'){
			 $karakteristikk = wc_attribute_label( $attribute['name'] );
			// $karakteristikk_val = $att_val;
			}
			elseif(wc_attribute_label( $attribute['name'] ) == 'volum'){
			 $volum = wc_attribute_label( $attribute['name'] );
			 $volum_val = $att_val;
			}
			elseif(wc_attribute_label( $attribute['name'] ) == 'diameter'){
			 $diameter = wc_attribute_label( $attribute['name'] );
			 $diameter_val = $att_val;
			}
      			elseif(wc_attribute_label( $attribute['name'] ) == 'barcode'){
			 $barcode = wc_attribute_label( $attribute['name'] );
			 $barcode_val = $att_val;
			}
			elseif(wc_attribute_label( $attribute['name'] ) == 'argang'){
			 $argang = wc_attribute_label( $attribute['name'] );
			 $argang_val = $att_val;
			}
			 elseif(wc_attribute_label( $attribute['name'] ) == 'serie'){
			 $serie = wc_attribute_label( $attribute['name'] );
			 $serie_val = $att_val;
			}
			 elseif(wc_attribute_label( $attribute['name'] ) == 'prisleie'){
			 $prisleie = wc_attribute_label( $attribute['name'] );
			 $prisleie_val = $att_val;
			}
			 elseif(wc_attribute_label( $attribute['name'] ) == 'hoyde'){
			 $hoyde = wc_attribute_label( $attribute['name'] );
			 $hoyde_val = $att_val;
			}
			elseif(wc_attribute_label( $attribute['name'] ) == 'alkohol'){
			 $alkohol = wc_attribute_label( $attribute['name'] );
			 $alkohol_val = $att_val;
			}
			elseif(wc_attribute_label( $attribute['name'] ) == 'beskrivelse'){
			 $beskrivelse = wc_attribute_label( $attribute['name'] );
			 $beskrivelse_val = $att_val;
			}
			elseif(wc_attribute_label( $attribute['name'] ) == 'gammel pris'){
			 $gammelpris = wc_attribute_label( $attribute['name'] );
			 $gammelpris_val = $att_val;
			}

		/*Sukker and Syre added section*/
		elseif(wc_attribute_label( $attribute['name'] ) == 'sukker'){
			 $sukker = wc_attribute_label( $attribute['name'] );
			 $sukker_val = trim(strip_tags($att_val));
			}
	elseif(wc_attribute_label( $attribute['name'] ) == 'syre'){
			 $syre = wc_attribute_label( $attribute['name'] );
			 $syre_val = trim(strip_tags($att_val));
			}
	/*Metode and Rastoff field*/
		elseif(wc_attribute_label( $attribute['name'] ) == 'metode'){
			 $metode = wc_attribute_label( $attribute['name'] );
			 $metode_val = trim(strip_tags($att_val));
			}
	elseif(wc_attribute_label( $attribute['name'] ) == 'rastoff'){
			 $rastoff = wc_attribute_label( $attribute['name'] );
			 $rastoff_val = trim(strip_tags($att_val));
			}

		/*Product field*/
		elseif(wc_attribute_label( $attribute['name'] ) == 'produktutvalg'){
			 $produktutvalg = wc_attribute_label( $attribute['name'] );
			 $produktutvalg_val = trim(strip_tags($att_val));
			}

		elseif(wc_attribute_label( $attribute['name'] ) == 'butikkategori'){
			 $butikkategori = wc_attribute_label( $attribute['name'] );
			 $butikkategori_val = trim(strip_tags($att_val));
			}
		elseif(wc_attribute_label( $attribute['name'] ) == 'varetype'){
			 $varetype = wc_attribute_label( $attribute['name'] );
			 $varetype_val = trim(strip_tags($att_val));
			}
			/* vare url ko lagi*/
			elseif(wc_attribute_label( $attribute['name'] ) == 'vareurl'){
			 $vareurl = wc_attribute_label( $attribute['name'] );
			 $vareurl_val = trim(strip_tags($att_val));
			}
		elseif(wc_attribute_label( $attribute['name'] ) == 'emballasjetype'){
			 $emballasjetype = wc_attribute_label( $attribute['name'] );
			 $emballasjetype_val = trim(strip_tags($att_val));
			}
		elseif(wc_attribute_label( $attribute['name'] ) == 'information'){
			 $information = wc_attribute_label( $attribute['name'] );
			 $information_val = trim(strip_tags($att_val));
			}
			/*
			elseif(wc_attribute_label( $attribute['name'] ) == 'pris'){
			 $pris = wc_attribute_label( $attribute['name'] );
			 $pris_val = $att_val;
			}
			*/
			elseif(wc_attribute_label( $attribute['name'] ) == 'passertil01'){
			 $passertil01_val = trim(strip_tags($att_val));
			 $passertil_val = explode(",", $passertil01_val);
			 $passertil01_img1 = ''; $passertil01_img2 = ''; $passertil01_img3 = '';
			$i = 1; $j = 1;
			 foreach($passertil_val as $passertil){
				 $passertil = ucfirst(trim(strip_tags($passertil)));

				$v = 'passertil01_img'.$i;
				if($passertil=='Fisk'){ $$v = '<img class="img-responsive" src="'.get_stylesheet_directory_uri().'/images/food/Fisk.png">';  }
				elseif($passertil=='Aperitiff' || $passertil=='Aperitiff/avec'){  $$v  = '<img class="img-responsive" src="'.get_stylesheet_directory_uri().'/images/food/aperitiff.png">'; }
				elseif($passertil=='Dessert'){  $$v  = '<img class="img-responsive" src="'.get_stylesheet_directory_uri().'/images/food/dessert.png">';}
				elseif($passertil=='Ost'){ $$v  = '<img class="img-responsive" src="'.get_stylesheet_directory_uri().'/images/food/ost.png">'; }
				elseif($passertil=='Skalldyr' ){ $$v  = '<img class="img-responsive" src="'.get_stylesheet_directory_uri().'/images/food/skalldyr.png">'; }
				elseif($passertil=='Svinekjøtt'){  $$v  = '<img class="img-responsive" src="'.get_stylesheet_directory_uri().'/images/food/svinekjott.png">'; }
				elseif($passertil=='Grønnsaker'){ $$v  = '<img class="img-responsive" src="'.get_stylesheet_directory_uri().'/images/food/gronnsaker.png">'; }
				elseif($passertil=='Storvilt'){  $$v  = '<img class="img-responsive" src="'.get_stylesheet_directory_uri().'/images/food/storvilt.png">'; }
				elseif($passertil=='Kake'){ $$v = '<img class="img-responsive" src="'.get_stylesheet_directory_uri().'/images/food/dessert.png">'; }
				elseif($passertil=='Lyst kjøtt'){ $$v  = '<img class="img-responsive" src="'.get_stylesheet_directory_uri().'/images/food/lystkjott.png">'; }
				elseif($passertil=='Lam og sau'){  $$v  = '<img class="img-responsive" src="'.get_stylesheet_directory_uri().'/images/food/lamsau.png">'; }
				elseif($passertil=='Frukt'){  $$v  = '<img class="img-responsive" src="'.get_stylesheet_directory_uri().'/images/food/frukt.png">'; }
				elseif($passertil=='Storfe'){  $$v  = '<img class="img-responsive" src="'.get_stylesheet_directory_uri().'/images/food/storferodtkjott.png">'; }
				elseif($passertil=='Småvilt og fugl'){ $$v  = '<img class="img-responsive" src="'.get_stylesheet_directory_uri().'/images/food/småvilt.png">'; }

				/*
				if($passertil=='Fisk'){ $$v = '<img class="img-responsive" src="'.content_url().'/uploads/2016/09/Fisk-1.png">';  }
				elseif($passertil=='Aperitiff' || $passertil=='Aperitiff/avec'){  $$v  = '<img class="img-responsive" src="'.content_url().'/uploads/2016/09/aperitiff.png">'; }
				elseif($passertil=='Dessert'){  $$v  = '<img class="img-responsive" src="'.content_url().'/uploads/2016/09/dessert.png">';}
				elseif($passertil=='Ost'){ $$v  = '<img class="img-responsive" src="'.content_url().'/uploads/2016/09/ost.png">'; }
				elseif($passertil=='Skalldyr' ){ $$v  = '<img class="img-responsive" src="'.content_url().'/uploads/2016/09/skalldyr.png">'; }
				elseif($passertil=='Svinekjøtt'){  $$v  = '<img class="img-responsive" src="'.content_url().'/uploads/2016/09/svinekjott.png">'; }
				elseif($passertil=='Grønnsaker'){ $$v  = '<img class="img-responsive" src="'.content_url().'/uploads/2016/09/gronnsaker.png">'; }
				elseif($passertil=='Storvilt'){  $$v  = '<img class="img-responsive" src="'.content_url().'/uploads/2016/09/storvilt.png">'; }
				elseif($passertil=='Kake'){ $$v = '<img class="img-responsive" src="'.content_url().'/uploads/2016/09/dessert.png">'; }
				elseif($passertil=='Lyst kjøtt'){ $$v  = '<img class="img-responsive" src="'.content_url().'/uploads/2016/09/lystkjott.png">'; }
				elseif($passertil=='Lam og sau'){  $$v  = '<img class="img-responsive" src="'.content_url().'/uploads/2016/09/lamsau.png">'; }
				elseif($passertil=='Frukt'){  $$v  = '<img class="img-responsive" src="'.content_url().'/uploads/2016/09/frukt.png">'; }
				elseif($passertil=='Storfe'){  $$v  = '<img class="img-responsive" src="'.content_url().'/uploads/2016/09/storferodtkjott.png">'; }
				elseif($passertil=='Småvilt og fugl'){ $$v  = '<img class="img-responsive" src="'.content_url().'/uploads/2016/09/småvilt.png">'; }
				*/

				$i++;
				$k = 'passertil'.$j;
				 $$k = $passertil;
				 $j++;
				}

			}


			elseif(wc_attribute_label( $attribute['name'] ) == 'fylde'){
			 $fylde = wc_attribute_label( $attribute['name'] );
			 $fylde_val = $att_val;
			}
			elseif(wc_attribute_label( $attribute['name'] ) == 'friskhet'){
			 $friskhet = wc_attribute_label( $attribute['name'] );
			 $friskhet_val = $att_val;
			}
			elseif(wc_attribute_label( $attribute['name'] ) == 'garvestoffer'){
			 $garvestoffer = wc_attribute_label( $attribute['name'] );
			 $garvestoffer_val = $att_val;
			}
			elseif(wc_attribute_label( $attribute['name'] ) == 'bitterhet'){
			 $bitterhet = wc_attribute_label( $attribute['name'] );
			 $bitterhet_val = $att_val;
			}
			elseif(wc_attribute_label( $attribute['name'] ) == 'sodme'){
			 $sodme = wc_attribute_label( $attribute['name'] );
			 $sodme_val = $att_val;
			}

			/*  Attribute Visible for Logged In User */
			elseif(wc_attribute_label( $attribute['name'] ) == 'vekturaID'){
			 $vekturaid = wc_attribute_label( $attribute['name'] );
			 $vekturaid_val = $att_val;
			}

			endforeach;

/*
*	All Custom Fields for products
*  get all custom fields, loop through them and load the field object to create a label => value markup
*/

// $fields = get_fields();

// if( $fields )
// {
// 	foreach( $fields as $field_name => $value )
// 	{
// 		// get_field_object( $field_name, $post_id, $options )
// 		// - $value has already been loaded for us, no point to load it again in the get_field_object function
// 		$field = get_field_object($field_name, false, array('load_value' => false));
//     if($field_name == 'karakteristikk'){
//       //echo '<h3>' . $field_name . '</h3>';
//           $karakteristikk_val = $value;
//         }
// 		 if($field_name == 'produksjonsmetode'){
//       //echo '<h3>' . $field_name . '</h3>';
//           $produksjonsmetode_val = $value;
//         }

// 		 if($field_name == 'matretter'){
//       //echo '<h3>' . $field_name . '</h3>';
//           $matretter_val = $value;
//         }

// 	}
// }

?>
