<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php
$item		= $list[0];
?>
<div class="<?php echo $params->get( 'moduleclass_sfx'); ?>">
    <h4>About Store</h4>
    <div>
    <?php modNewsFlashjSeblodHelper::renderItem($item, $params, $access); ?>
    </div>
</div>