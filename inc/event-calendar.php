<?php defined('ABSPATH') or die("No script kiddies please!");
$the_query = new WP_Query(array(
    'posts_per_page' => -1,
    'cat' => 38, // this is the category SLUG,
    'post_status' => 'publish',
));
$lists = array();
$publishdate = array();
$publishdate1 = array();
if ($the_query->have_posts()) {
while ($the_query->have_posts()) : $the_query->the_post();
	$publisheddate = get_the_date();
	$title = get_the_title();
	$permalink = get_the_permalink();
	$ID = get_the_ID();
	$date_val = get_post_meta( $ID, 'dato', true );
	if($date_val != ''){
		$lists[] = array(
		'title' => $title,
		'date' => $publisheddate,
		'dato' => $date_val,
		'id' => $ID,
		'permalink' => $permalink,
	);
	$publishdate[]  = $date_val;
	// Creating timestamp from given date
	$timestamp = strtotime($date_val);
	// Creating new date format from that timestamp
	$new_date = date("d.m.Y", $timestamp);
	$publishdate1[] = $new_date;
	}

endwhile;
wp_reset_query();
}
$booked_dates = implode(',',$publishdate);
$booked_dates1 = implode(',',$publishdate1);
$html_data = '';
?>
<div class="edac-av-calendar-wrap">
<div class="edac-av-calendar edac-calendar"></div><img id="loadergif" src="<?php echo get_stylesheet_directory_uri();?>/images/AjaxLoader.gif"/><div class="event-list-wrapper"><?php
$todaymonth = date('m/d/Y');
$first_day_of_month = strtotime($todaymonth);
$date1 = new DateTime();
$date1->setTimestamp($first_day_of_month);
foreach($publishdate as $dateText){
$dateText1 = strtotime($dateText);
$date2 = new DateTime();
$date2->setTimestamp($dateText1);
	if ($date1->format('Y-m') === $date2->format('Y-m')) {
	        // year and month match
			$postdato = $dateText;
			$timestamp = strtotime($postdato);
			$new_dato = date("m/d/Y", $timestamp); //11/26/2019
			$new_datedato = date("M d, Y", $timestamp); 
			$month = date("M", $timestamp); 
			$day = date("d", $timestamp); 
			$cc_args = array(
			    'posts_per_page'   => -1,
			    'post_type'        => 'post',
			    'cat' => 38,
			    'meta_key'         => 'dato',
			    'meta_value'       => $new_dato
			); $cc_query = new WP_Query( $cc_args );
			if ($cc_query->have_posts()) { while ($cc_query->have_posts()) : $cc_query->the_post();
			$posttitle = get_the_title();
			$html_data = '<div class="calendar-event-list"><div class="list-date">';
			$html_data .= '<span class="list-month">'.$month.'</span>';
			$html_data .= '<span class="list-day">'.$day.'</span>';
			$html_data .= '</div>';
			$html_data .= '<div class="list-info">';
			$html_data .= '<h2 class="event-title"><a href="'.get_the_permalink().'" target="_self">'.$posttitle.'</a></h2>';
			$html_data .= '<span class="dato">'.$new_datedato.'</span></div></div>';
			echo $html_data;
			endwhile;
			wp_reset_query();
			}
	}
}
?></div>
    <div class="edac-hidden-field">
        <input type="hidden" class="edac-dates" value="<?php echo $booked_dates; ?>"/>
        <input type="hidden" class="edac-dates-all" value="<?php echo $booked_dates1; ?>"/>
        <input type="hidden" class="edac-date" data-from-date="2015" data-to-date="2020" data-language="no" />
    </div>
</div>