<?php // @version $Id: default.php 9506 2007-12-08 21:00:27Z willebil $
defined('_JEXEC') or die('Restricted access');
$cparams = JComponentHelper::getParams ('com_media');
?>


<?php if ($this->params->get('show_page_title')) : ?>

<?php endif; ?>
<div class="container">
<?php if ($this->params->def('show_categories', 1) && count($this->categories)) : ?>
<div class="row">
	
	<?php foreach ($this->categories as $category) :
		$raw = $this->getRawContent($category->raw);
		$thumb = basename($raw->prod_cat_img);
		if (!$this->params->get('show_empty_categories') && !$category->numitems) :
			continue;
		endif; 
		if($this->params->get('pageclass_sfx') == 'video'){
		?>
        <div class="col-lg-4 col-md-4 col-sm-6">
        <div style="margin-bottom: 30px;" class="main_box">
            <div class="box_1">
            <a href="<?php echo $category->link; ?>?layout=blog" class="category">
                <img src="images/category/<?php echo $category->id.'/'.$thumb; ?>" alt="<?php echo $raw->category_title; ?>">
            </a>
            </div>
            <div class="desc">
                <h3 style="color: rgb(33, 183, 240);"><?php echo $raw->category_title; ?></h3>
                <p><?php echo $raw->hws_subtitle; ?></p>
            </div>
        </div>
        </div>
        <?php }
		if($this->params->get('pageclass_sfx') == 'how-we-style'){
			if($raw->hws_imgx){
				preg_match_all('#\|\|hws_imgx\|\|(.*?)\|\|/hws_imgx\|\|#s',$raw->hws_imgx,$slideimg);
				$slideimg = $slideimg[1];
			}
			?>
        	<div class="container hws" style="position: relative; padding-bottom: 50px;">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12 ttl">
                        <h3><a href="<?php echo $category->link; ?>?layout=blog" class="category"><?php echo $raw->category_title; ?></a></h3>
                        <p><?php echo $raw->hws_subtitle; ?></p>
                        <div style="font-size: 14px; letter-spacing: normal; padding-right: 10px; text-transform: none; font-weight: normal;"><?php echo $raw->wysiwyg_description; ?>
                        
                        <div class="hidden-sm hidden-xs" ><a href="<?php echo $category->link; ?>?layout=blog" class="category">View Catalog</a>
                        </div>
                        </div>
                        
                    </div>
                    <div class="col-lg-8 col-md-12 col-sm-12 desc">
                    	<a class="thumbnail" href="<?php echo $category->link; ?>?layout=blog" class="category"><img style="width: 100%;" src="<?php echo JURI::base().$slideimg[0]; ?>" /></a>
                    </div>
                </div>
            </div>
        <?php } ?>
	<?php endforeach; ?>
    <div style="height: 50px;"></div>
</div>
</div>
<?php endif;
