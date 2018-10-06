<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$img = $item->rawcontent->pr_img;
$img = explode('/',$img);
$img = $img[0].'/'.$img[1].'/'.$img[2].'/_thumb1/'.$img[3];
?>

<div class="main_box">
	<div class="box_1">
    	<img alt="<?php echo $item->rawcontent->pr_title ?>"  src="<?php echo $img; ?>" width="259" height="200"  />
		<div class="overlay">
            <a class="addcart btn cart_btn_1" href="<?php echo JURI::base(); ?>cart?addcart=<?php echo $item->id ?>" 
				data-id="<?php echo $item->id; ?>"
				data-title="<?php echo $item->rawcontent->pr_title; ?>"
				data-thumb="<?php echo $img; ?>"
				data-price="<?php echo $item->rawcontent->pr_price; ?>"
			>Beli</a>
        	<a class="btn info_btn" href="<?php echo $item->linkOn;?>">Lihat</a>
        </div>
	</div>
	<div class="desc">
  		<h5><?php echo $item->rawcontent->pr_title ?></h5>
		<p><?php echo $item->cat_title ?></p>
		<div class="price">Rp. <?php echo number_format($item->rawcontent->pr_price, 0, '', '.'); ?></div>
	</div>
</div>