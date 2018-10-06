<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$raw = $item->rawcontent;
$img = $raw->imagex[0];
$img = explode('/',$img);
$img = $img[0].'/'.$img[1].'/'.$img[2].'/_thumb3/'.$img[3];
$options = $raw->pr_options;
//echo'<pre>';print_r($options);echo'</pre>';
?>

<div id="additem<?php echo $item->id; ?>" class="padding-15 cartadd_item">
  <label class="checkbox-inline ">
    <input class="cartadd" type="checkbox" data-id="<?php echo $item->id; ?>" data-title="<?php echo htmlentities($item->title);?>" data-thumb="<?php echo $img; ?>" data-price="<?php echo $item->price; ?>" data-size="<?php echo $raw->pr_options[0]['pr_option'];?>" />
    <?php echo $item->title;?> </label>
  <ul id="<?php echo $item->id; ?>" class="hidden">
    <li class="media"> <a href="<?php echo $item->linkOn; ?>" class="pull-left"><img src="<?php echo $img; ?>" class="thumbnail media-object" draggable="false"></a>
      <div class="media-body p-t-15">
        <h5 class="m-b-5"><a href="<?php echo $item->linkOn; ?>"><?php echo $item->title;?></a></h5>
        <?php if(count($options) > 1){ ?>
        <div class="sizewrap p-b-5 p-t-5" style="display: block;">
          <select style="width: 100%;" name="size[]" class="size form-control txtbox" disabled="disabled">
          	<option value="">--<?php echo $raw->pr_opt_label;?>--</option>
            <?php foreach($options as $opt){ $opt = (object) $opt;?>
            <?php if((int)$opt->pr_stock <= 0){ ?>
            <option disabled="disabled" value=""><?php echo $opt->pr_option; ?> <?php echo JText::_( 'OUT_OF_STOCK' ); ?></option>
            <?php }else{ ?>
            <option value="<?php echo $opt->pr_option; ?>" <?php if($opt->pr_option == $item->size){echo 'selected="selected"';}; ?> data-stock="<?php echo $opt->pr_stock; ?>"><?php echo $opt->pr_option; ?></option>
            <?php } ?>
            <?php $opt = ''; ?>
            <?php } ?>
          </select>
           </div> 
        <?php }else{ ?>
        <input type="hidden" name="size[]" class="size" value="<?php echo $options[0]->pr_option; ?>" />
        <?php } ?>
        <a href="#" class="del_btn delbag" data-id="<?php echo $item->id;?>">Remove</a> </div>
    </li>
    <li class="text-center">
      <div class="price text-bold m-t-10">
      	<?php if(trim($raw->pr_old_price)){ ?>
        <div class="old-price" data-hemat="<?php echo $item->price - $raw->pr_old_price;?>">Rp. <span><?php echo number_format($raw->pr_old_price, 0, '', '.'); ?></span></div>
        <?php } ?>
        Rp. <span><?php echo number_format($item->price, 0, '', '.'); ?></span> </div>
    </li>
    <li class="p-t-40 text-center">
      <div class="plusminus-container">
        <div class="plusminus"> <a class="minus_btn"><i class="fa fa-minus"></i></a>
          <input data-prodprice="<?php echo $item->price; ?>" class="txtbox prodcount" id="<?php echo $item->id;?>" name="prodcount[<?php echo $item->id;?>]" value="1" data-max="<?php echo $raw->pr_options[0]['pr_stock'];?>" readonly type="text">
          <a class="plus_btn"><i class="fa fa-plus"></i></a> </div>
        <div class="text-center text-red text-small text-w-500"><?php echo $raw->pr_options[0]['pr_unit'];?></div>
      </div>
    </li>
    <li class="p-t-45 text-right">
      <div class="price text-bold">Rp. <span class="subtot"><?php echo number_format($item->price, 0, '', '.'); ?></span></div>
    </li>
  </ul>
</div>