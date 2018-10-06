<?php defined('_JEXEC') or die('Restricted access'); ?>
<div class="<?php echo $params->get( 'moduleclass_sfx'); ?>" data-animation="fadeInUp">
	<div class="clearfix">
    <?php if($params->get( 'custom_link' )){ ?>
    	<h3><a href="<?php echo $params->get( 'custom_link' ); ?>"><?php echo $params->get( 'modtitle' ); ?> <span class="fa fa-arrow-circle-right" style="font-size: 22px;"></span></a></h3>
    <?php }else{ ?>
		<h3><?php echo $params->get( 'modtitle' ); ?></h3>
	<?php } ?>
    </div>
    <div class="carosel product_c">
        <div class="row">
            <div>
                <ul class="bxcarousel">
                    <?php foreach ($list as $item) : ?>
                        <li><?php modNewsFlashjSeblodHelper::renderItem($item, $params, $access); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>