<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
?>

<div class="container <?php echo $params->get( 'moduleclass_sfx'); ?>">
  <div class="clearfix">
    <h2 class="m-b-50 m-t-30"><span style="font-family: Fredoka One; color: #6ec8bf;"><?php echo $params->get( 'modtitle' ); ?></span></h2>
    <?php if($params->get( 'descid' )){ 
				$desc = modNewsFlashjSeblodHelper::getDescription($params->get( 'descid' ));
				echo $desc->wysiwyg_text;
			?>
  </div>
  <?php } ?>
  <div class="row gutter-10">
    <?php for($i=0; $i < 4; $i++){ 
		if(!$list[$i]){
			continue;
		}
		?>
    <div class="col-sm-3 col-xs-6">
      <?php modNewsFlashjSeblodHelper::renderItem($list[$i], $params, $access); ?>
    </div>
    <?php }; ?>
  </div>
  <div class="row gutter-10">
    <?php for($i=$i; $i < 7; $i++){ 
		if(!$list[$i]){
			continue;
		}
		?>
    <div class="col-sm-4 col-xs-6">
      <?php modNewsFlashjSeblodHelper::renderItem($list[$i], $params, $access); ?>
    </div>
    <?php }; ?>
  </div>
</div>
