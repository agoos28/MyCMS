<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?php echo modNewsFlashjSeblodHelper::truncate($item->text, $params->get( 'truncate' ), ''); ?>
<a class="fa fa-arrow-circle-right" href="<?php echo $item->linkOn;?>"></a>