<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
?>
<div class="catthumbs border-top border-dark p-t-30">
  <div class="row">
    <?php foreach ($list as $item) : ?>
        <?php modNewsFlashjSeblodHelper::renderItem($item, $params, $access); ?>
    <?php endforeach; ?>
  </div>
</div>