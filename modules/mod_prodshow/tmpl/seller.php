<?php defined('_JEXEC') or die('Restricted access'); 

?>
<div class="<?php echo $params->get( 'moduleclass_sfx'); ?>" data-animation="fadeInUp">
	
    <?php if($params->get( 'descid' )){ 
		$desc = modProdShowHelper::getDescription($params->get( 'descid' ));
	?>
    	<div class="row" style="margin-bottom: 60px; position: relative;">
        	<?php echo $desc->edit; ?>
        	<div class="col-lg-6 col-md-6 col-sm-12" style=" margin-bottom: 25px;">
            <h3 style="margin-bottom: 15px;"><?php echo $desc->title; ?></h3>
            <?php echo $desc->wysiwyg_text; ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
            <img style="width: 100%; height: auto;" src="<?php echo $desc->md_image; ?>" />
            </div>
        </div>
    <?php } ?>
    
    <div class="product_c">
        <div class="row">
		<?php foreach ($list as $item){ ?>
			 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"><?php modProdShowHelper::renderItem($item, $params, $access); ?></div>
        <?php } ?>
        </div>
    </div>
    <?php if($params->get( 'custom_link' )){ ?>
    <?php } ?>
</div>