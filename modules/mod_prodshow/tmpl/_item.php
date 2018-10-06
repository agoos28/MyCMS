<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$img = $item->rawcontent->imagex;
$img = explode('/',$img[0]);
$cartimg = $img[0].'/'.$img[1].'/'.$img[2].'/_thumb3/'.$img[3];
//echo'<pre>';print_r($item);die();
$imghov = $item->rawcontent->pr_img_hov;
$imghov = explode('/',$imghov);
$imghov = $imghov[0].'/'.$imghov[1].'/'.$imghov[2].'/_thumb1/'.$imghov[3];
$options = json_decode($item->options);
//print_r($options);
//print_r($item->key % 2);
if($item->key % 2 == 0){
	$pull = 'pull-right';
}else{
	$pull = '';
}

?>
<?php if($item->key == 0){ ?>

<div class="first-display row no-margin pos-relative background-contain" 
		style="background-image: url('<?php echo $item->rawcontent->imagex[0]; ?>'); background-position: 100% 50%;
    background-color: <?php echo $item->rawcontent->color_bg; ?>;"> <?php echo $item->editlink; ?>
  <div class="col-md-6 col-sm-6 col-xs-12 no-padding autocolor">
    <div class="full-width padding-80" >
      <div class="lead text-w-300 buywrap">
        <h3 class="m-b-20"><?php echo $item->title; ?></h3>
        <div><?php echo $item->rawcontent->pr_subtitle; ?></div>
        <?php if(count($options) > 1){ ?>
        <div class="sizewrap p-b-20">
          <select style="width: 280px;" name="size" class="size btn">
            <option value="" selected="selected">--<?php echo $item->rawcontent->pr_opt_label;?>--</option>
            <?php foreach($options as $opt){ ?>
            <?php if((int)$opt->pr_stock <= 0){ ?>
            <option disabled="disabled" value=""><?php echo $opt->pr_option; ?> <?php echo JText::_( 'OUT_OF_STOCK' ); ?></option>
            <?php }else{ ?>
            <option value="<?php echo $opt->pr_option; ?>"><?php echo $opt->pr_option; ?></option>
            <?php } ?>
            <?php $opt = ''; ?>
            <?php } ?>
          </select>
           </div> 
        <?php }else{ ?>
        <input type="hidden" name="size" class="size" value="<?php echo $options[0]->pr_option; ?>" />
        <?php } ?>
        <?php if($item->price > 0){?>
					<?php if($item->stock > 0){?>
          <a class="btn btn-default btn-lg rounded cancel hidden"><?php echo JText::_( 'CANCEL' ); ?></a>
          <a class="addcart btn btn-lg btn-dark-red rounded autocolor" style="background-color: <?php echo $item->rawcontent->color_btn; ?>" 
          data-id="<?php echo $item->id; ?>"
          data-title="<?php echo $item->rawcontent->pr_title; ?>"
          data-thumb="<?php echo $cartimg; ?>"
          data-price="<?php echo $item->rawcontent->pr_price; ?>">Pesan Sekarang</a>
          <?php }else{ ?>
          <a href="<?php echo $item->linkOn;?>" class="btn btn-lg btn-dark-red rounded disable"> <?php echo JText::_( 'OUT_OF_STOCK' ); ?> <?php echo $item->stock; ?> </a>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php }else{ ?>
<div class="row no-margin pos-relative"> <?php echo $item->editlink; ?>
  <div class="col-sm-6 no-padding square <?php echo $pull; ?>">
    <div class="background-cover parent-size-absolute" style="background-image: url('<?php echo $item->rawcontent->imagex[0]; ?>');">
    	<img class="visible-xs" src="<?php echo $item->rawcontent->imagex[0]; ?>" />
    </div>
  </div>
  <div class="col-sm-6 no-padding square autocolor" style="background-color: <?php echo $item->rawcontent->color_bg; ?>" >
    <div class=" middlecenter p-l-100 p-r-100 full-width" style="color: <?php echo $item->rawcontent->color_text; ?>">
      <div class="lead buywrap">
        <h2 class="m-b-20"><?php echo $item->title; ?></h2>
        <div class="m-b-30"> <?php echo $item->rawcontent->pr_subtitle; ?> </div>
        <?php if(count($options) > 1){ ?>
        <div class="sizewrap p-b-20">
          <select style="width: 280px;" name="size" class="size btn">
            <option value="" selected="selected">--<?php echo $item->rawcontent->pr_opt_label;?>--</option>
            <?php foreach($options as $opt){ ?>
            <?php if((int)$opt->pr_stock <= 0){ ?>
            <option disabled="disabled" value=""><?php echo $opt->pr_option; ?> <?php echo JText::_( 'OUT_OF_STOCK' ); ?></option>
            <?php }else{ ?>
            <option value="<?php echo $opt->pr_option; ?>"><?php echo $opt->pr_option; ?></option>
            <?php } ?>
            <?php $opt = ''; ?>
            <?php } ?>
          </select>
           </div> 
        <?php }else{ ?>
        <input type="hidden" name="size" class="size" value="<?php echo $options[0]->pr_option; ?>" />
        <?php } ?>
        <?php if($item->price > 0){?>
					<?php if($item->stock > 0){?>
          <a class="btn btn-default btn-lg rounded cancel hidden"><?php echo JText::_( 'CANCEL' ); ?></a>
          <a class="addcart btn btn-lg btn-dark-red rounded autocolor" style="background-color: <?php echo $item->rawcontent->color_btn; ?>" 
          data-id="<?php echo $item->id; ?>"
          data-title="<?php echo $item->rawcontent->pr_title; ?>"
          data-thumb="<?php echo $cartimg; ?>"
          data-price="<?php echo $item->rawcontent->pr_price; ?>">Pesan Sekarang</a>
          <?php }else{ ?>
          <a href="<?php echo $item->linkOn;?>" class="btn btn-lg btn-dark-red rounded disable"> <?php echo JText::_( 'OUT_OF_STOCK' ); ?> <?php echo $item->stock; ?> </a>
          <?php } ?>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
<?php } ?>
