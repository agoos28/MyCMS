<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
jimport( 'joomla.filter.filteroutput' );
$raw = $item->rawcontent;
$img = explode('/',$raw->bl_img);
$img = $img[0].'/'.$img[1].'/'.$img[2].'/_thumb3/'.$img[3];
?>

<li class="item"> <a class="post_img m-b-30 block" style="height: auto; width: auto;" href="<?php echo $item->linkOn;?>"><img alt="<?php echo $item->title;?> photo" src="<?php echo $img; ?>" style="width: 100%; height: auto;"></a>
  <div class="lead">
    <h3 class="text-w-400 m-b-20 text-dark"><a class="text-dark" href="<?php echo $item->linkOn;?>"><?php echo $item->title;?></a></h3>
    <p class="m-b-30"><?php echo $raw->bl_desc; ?></p>
    <p class="small text-w-300">
      <?php echo JHtml::_('date',$item->created);?></p>
  </div>
</li>
