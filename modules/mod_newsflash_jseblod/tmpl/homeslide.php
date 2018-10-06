<?php defined('_JEXEC') or die('Restricted access'); ?>
<div class="container fullwidth home-slider testimony-slider" style="width: 100%;"> 
<div class="lead">
<h2>
	Testimonial
</h2>
</div>
<ul class="bxslider2">
<?php for ($i = 0, $n = count($list); $i < $n; $i ++) : ?>
	<li class="item"><?php modNewsFlashjSeblodHelper::renderItem($list[$i], $params, $access); ?></li>
<?php endfor; ?>
	</ul>
  <a id="slider-next2" class="left carousel-control"></a>
  <a id="slider-prev2"  class="right carousel-control"></a>
</div>
<script type="text/javascript">
var bx2
$(document).ready(function(){
  bx2 = $('.bxslider2').bxSlider({
		maxSlides: 1,
		adaptiveHeight: true,
		prevSelector: '#slider-next2',
		nextSelector: '#slider-prev2',
		prevText: '<span class="fa fa-angle-left " aria-hidden="true"></span>',
  	nextText: '<span class="fa fa-angle-right " aria-hidden="true"></span>'
	});
})
$(window).resize(function(){
	bx2.reloadSlider()
})
</script> 