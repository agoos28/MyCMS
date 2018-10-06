<?php defined('_JEXEC') or die('Restricted access');

?>

<div class="container <?php echo $params->get( 'moduleclass_sfx'); ?>">

    <?php if($params->get( 'custom_link' )){ ?>
    <div class="clearfix">
    <h3 style="text-align:center;font-size:24px;color:#eb94b7;padding:0px 0px 55px 0px;"> <a class="btn" href="<?php echo $params->get( 'custom_link' ); ?>"><?php echo $params->get( 'modtitle' ); ?></a> </h3>
    <?php }else{ ?>
    <h2 class="m-b-30 m-t-30 green"><span style="font-family: Fredoka One;"><?php echo $params->get( 'modtitle' ); ?></span></h2>
    <?php } ?>
    <?php if($params->get( 'descid' )){
				$desc = modNewsFlashjSeblodHelper::getDescription($params->get( 'descid' ));
				echo $desc->wysiwyg_text;
			?>
  </div>
  <?php } ?>
  <div class="product_c">
    <div class="row gutter-5">
        <?php for($i=0; $i < count($list); $i++){ ?>
        <div class="col-md-3 col-sm-4 col-xs-6">
          <?php modNewsFlashjSeblodHelper::renderItem($list[$i], $params, $access); ?>
        </div>
        <?php } ?>
    </div>
  </div>
</div>
