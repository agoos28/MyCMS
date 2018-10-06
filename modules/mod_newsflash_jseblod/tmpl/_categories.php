<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$raw = $item->rawcontent;
$desc = modNewsFlashjSeblodHelper::truncate($raw->wysiwyg_description);
$link = JURI::base().'product/'.$item->id.'-'.$item->alias;
$img = $raw->prod_cat_img;
$img = explode('/',$img);
$img = $img[0].'/'.$img[1].'/'.$img[2].'/_thumb1/'.$img[3];
?>
<?php echo modNewsFlashjSeblodHelper::getCatedit($item->id); ?>
<a href="<?php echo $link;?>" class="block vc_column-inner m-b-30 m-b-sm-10">
  <div class="wpb_wrapper">
    <div class="welcome-img "><img alt="<?php echo $item->title;?>" src="<?php echo $raw->prod_cat_img; ?>">
      <div class="welcome-content" style="background-color:rgba(110,200,191, .9);">
        <div class="svg-overlay" style="color:rgba(110,200,191, .9);">
          <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 500 250" enable-background="new 0 0 500 250" xml:space="preserve" preserveAspectRatio="none">
            <path d="M250,246.5c-97.85,0-186.344-40.044-250-104.633V250h500V141.867C436.344,206.456,347.85,246.5,250,246.5z"></path>
          </svg>
        </div>
        <i style="font-size: 40px;" class="<?php echo $raw->icon_class; ?>"></i>
        <h4><?php echo $item->title;?></h4>
        <p><?php echo strip_tags($desc);?></p>
      </div>
    </div>
  </div>
</a>
