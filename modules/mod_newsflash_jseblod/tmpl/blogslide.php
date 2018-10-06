<?php defined('_JEXEC') or die('Restricted access'); ?>
<div class="<?php echo $params->get('moduleclass_sfx'); ?> p-t-80 p-t-xs-0">
  <div class="blog_blk red5 clearfix no-overflow">
  <div class="flexslider slidebanner"> 
    <ul class="slides">
  <?php for ($i = 0, $n = count($list); $i < $n; $i ++) : ?>
    <?php modNewsFlashjSeblodHelper::renderItem($list[$i], $params, $access); ?>
  <?php endfor; ?>
    </ul>
  </div>
  
  <script>
  $(document).ready(function(e) {
    $('.slidebanner').flexslider({
        animation: 'slide',
        slideshowSpeed: 7000,
        animationSpeed: 600,
        directionNav: true
      })
  })
  </script>
  </div>
</div>