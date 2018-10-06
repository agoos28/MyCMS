	<?php // @version $Id: default_results.php 9718 2007-12-20 22:35:36Z eddieajau $
defined('_JEXEC') or die('Restricted access');
?>
<div id="search_result_ajax">
<?php if (count($this->results)){ ?>
	<?php $start = $this->pagination->limitstart + 1; ?>
	<ul class="media-list <?php echo $this->params->get('pageclass_sfx') ?>" start="<?php echo  $start ?>">
  
		<?php foreach ($this->results as $result){ 
		$img = explode('/',$result->image);
		$img = $img[0].'/'.$img[1].'/'.$img[2].'/_thumb1/'.$img[3];
		
		?>
        	<li class="media">
            	<?php if($result->sectionid == 2 || $result->image == true){ ?>
                <a class="pull-left" href="<?php echo $result->href; ?>"><img class="img-thumbnail" src="<?php echo JURI::base().$img; ?>" />
								</a>
                <div class="media-body">
                	<h5 class="media-heading"><a href="<?php echo $result->href; ?>"><?php echo $result->title; ?></a></h5>
                  <p><?php echo strip_tags($result->text); ?></p>
                </div>
                </a>
                <?php }else{ ?>
                <a href="<?php echo $result->href; ?>">
                	<h5><?php echo $result->title; ?></h5>
                    <p><?php echo strip_tags($result->text); ?></p>
                </a>
                <?php } ?>
            </li>
		<?php }; ?>
    </ul>
	<?php echo $this->pagination->getPagesLinks(); ?>
</div>
<?php };?>
</div>

