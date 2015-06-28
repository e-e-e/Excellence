<?php
/*** set the content type header ***/
	header("Content-type: text/css");

	$hue = rand(0, 360);
	$light = "hsl({$hue},96%,76%)";
	$dark = "hsl({$hue},95%,44%)";
?>

html, body {
	background-color: <?php $light ?>;
}
div#bg-color {
	width: 100%;
	height: 100%;
	position: fixed;	
	top: 0;
	left: 0;
	z-index:0;
	background: <?php echo $light ?>; /* Old browsers */
	background: -moz-linear-gradient(45deg, <?php echo $light ?> 0%, <?php echo $dark ?> 100%); /* FF3.6+ */
	background: -webkit-gradient(linear, left bottom, right top, color-stop(0%,<?php echo $light ?>), color-stop(100%,<?php echo $dark ?>)); /* Chrome,Safari4+ */
  background: -webkit-linear-gradient(45deg, <?php echo $light ?> 0%,<?php echo $dark ?> 100%); /* Chrome10+,Safari5.1+ */
  background: -o-linear-gradient(45deg, <?php echo $light ?> 0%,<?php echo $dark ?> 100%); /* Opera 11.10+ */
  background: -ms-linear-gradient(45deg, <?php echo $light ?> 0%,<?php echo $dark ?> 100%); /* IE10+ */
  background: linear-gradient(45deg, <?php echo $light ?> 0%,<?php echo $dark ?> 100%); /* W3C */
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='<?php echo $light ?>', endColorstr='<?php echo $dark ?>',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
}