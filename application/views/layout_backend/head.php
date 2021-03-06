<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<title><?php echo $title;?></title>
	<link rel="icon" href="<?php echo base_url();?>assets/img/logo/logo.png" type="image/png" sizes="16x16">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/materialize.min.css">	
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/custom.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/pace.min.css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">	 
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/swal.css">	
	<script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="<?php echo base_url();?>assets/js/jquery-2.1.4.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/pace.js"></script>
    <script src="<?php echo base_url();?>assets/js/swal.js"></script>
    <!-- bxSlider CSS file -->
	<link href="<?php echo base_url();?>assets/css/bxslider.css" rel="stylesheet" />

	<!-- tinymce js -->
	<script src="<?php echo base_url();?>assets/js/tinymce/tinymce.dev.js"></script>
	<script src="<?php echo base_url();?>assets/js/tinymce/plugins/table/plugin.dev.js"></script>
	<script src="<?php echo base_url();?>assets/js/tinymce/plugins/paste/plugin.dev.js"></script>
	<script src="<?php echo base_url();?>assets/js/tinymce/plugins/spellchecker/plugin.dev.js"></script>
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/materialize-tags.css">
<!-- cdn for modernizr, if you haven't included it already -->
	<script src="http://cdn.jsdelivr.net/webshim/1.12.4/extras/modernizr-custom.js"></script>
	<!-- polyfiller file to detect and load polyfills -->
	<script src="http://cdn.jsdelivr.net/webshim/1.12.4/polyfiller.js"></script>
	<script>
	  webshims.setOptions('waitReady', false);
	  webshims.setOptions('forms-ext', {types: 'date'});
	  webshims.polyfill('forms forms-ext');
	</script>
    <script>
	    paceOptions = {
	      elements: true
	    };	    
	</script>  

</head>
<?php 
	$level = $user['admin'];
	if ($level === '-9') {
		echo '<script>	
			$(document).ready(function(){
				var tot_peralatan = 0;
				$.getJSON( "'.base_url().'api/all/ads/kategori-count/1", function( data ) {
					tot_peralatan += data.count;				 	
					$(" #count_peralatan").html(tot_peralatan);

					var tot_paket = 0;
					$.getJSON( "'.base_url().'api/all/ads/kategori-count/2", function( data ) {
						tot_paket += data.count;				 	
						$(" #count_paket").html(tot_paket);				
						$(" #total_iklan").html(parseInt(tot_peralatan) + parseInt(tot_paket));								
					});					
				});								
			});				
	</script>';
	}elseif ($level === '1') {
		echo '<script>	
			$(document).ready(function(){
				var tot_peralatan = 0;
				$.getJSON( "'.base_url().'api/user/ads/kategori-count/1", function( data ) {
					tot_peralatan += data.count;				 	
					$(" #count_peralatan").html(tot_peralatan);

					var tot_paket = 0;
					$.getJSON( "'.base_url().'api/user/ads/kategori-count/2", function( data ) {
						tot_paket += data.count;				 	
						$(" #count_paket").html(tot_paket);				
						$(" #total_iklan").html(parseInt(tot_peralatan) + parseInt(tot_paket));
						console.log(parseInt(tot_peralatan) + parseInt(tot_paket));								
					});					
				});								
			});				
	</script>';
	}
?>