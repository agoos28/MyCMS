<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$raw = $item->rawcontent;
$img = $raw->bl_img;
$img = explode('/',$img);
$img = $img[0].'/'.$img[1].'/'.$img[2].'/_thumb2/'.$img[3];
?>
<div class="item col-md-4 col-sm-6 col-xs-12">
	<div class="thumbnail no-border"> <a class="block m-b-30" href="<?php echo $item->linkOn;?>"><img class="" src="<?php echo $img; ?>" /></a>
    <div class="caption lead no-padding">
      <h4 class="text-w-500 m-b-5"><a class="text-dark" href="<?php echo $item->linkOn;?>"><?php echo $item->title;?></a></h4>
      <div class="m-b-20 text-small"><?php echo JHtml::_('date',$item->created);?></div>
      <p class="m-b-30"> <?php echo $raw->bl_desc; ?> </p>
      <a href="<?php echo $item->linkOn;?>" class="btn btn-lg btn-dark-blue rounded text-white m-r-40 m-r-xs-20" style="background-color: #004358;">Baca Selengkapnya</a>
    </div>
  </div>
</div>