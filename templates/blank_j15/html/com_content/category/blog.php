<?php // @version $Id: blog.php 9722 2007-12-21 16:55:15Z mtk $
defined('_JEXEC') or die('Restricted access');
$cparams = JComponentHelper::getParams ('com_media');
$user = JFactory::getUser();
$categories = $this->get( 'Siblings' );
$raw = $this->get('RawContent');

$section = $this->get( 'Category' );
$brands = $this->get( 'Brands' );
$min = $this->get( 'Min' );
$max = $this->get( 'Max' );
$metadesc = '';
$metakey = $this->params->get('page_title');
function filters($name = null, $value = null, $text = null){
	$currenturl = JURI::getInstance()->toString();
	if(JRequest::getVar($name) == $value){
		$current = 'class="current"';
	}else{
		$current = '';
	}
	$url = explode('?',$currenturl);
	if(count($url) <= 1){
		$urlres = $currenturl.'?'.$name.'='.$value;
	}else{
		$filters = explode('&', $url[1]);
		if(count($filters) <= 1){
			$filter = explode('=', $filters[0]);
			if($filter[0] == $name){
				if($value == 'reset'){
					$urlres = str_replace($filter[0].'='.$filter[1],'', $currenturl);
				}else{
					$urlres = str_replace($filter[0].'='.$filter[1],$filter[0].'='.$value, $currenturl);
				}
			}else{
				if($value == 'reset'){
					$urlres = $currenturl;
				}else{
					$urlres = $currenturl.'&'.$name.'='.$value;
				}
			}
		}else{
			$urlres = $url[0];
			$p = 0;
			foreach($filters as $filter){
				if($p == 0){
					$sep = '?';
				}else{
					$sep = '&';
				}
				$filter = explode('=', $filter);
				if($filter[0] == $name){
					if($value == 'reset'){
						$urlres .= '';
						$p = $p - 1;
					}else{
						$urlres .= $sep.$filter[0].'='.$value;
					}
					$exist = 1;
				}else{
					$urlres .= $sep.$filter[0].'='.$filter[1];
				}
				$p++;
			}
			if(!$exist){
				$addup = '&'.$name.'='.$value;
			}
		}
	}
	return '<a '.$current.' href="'.$urlres.$addup.'">'.$text.'</a>';
}
?>

<?php if ($this->category->sectionid == 12) : ?>
 <?php 
	if($user->usertype == 'Super Administrator'){ ?>
		<div class="container" style="position: relative;">
		<?php echo '<a style="z-index:3;" class="btn btn-xs btn-red btn-edit" href="index.php?option=com_cckjseblod&view=type&layout=form&typeid=28&cckid='.$this->category->id.'">edit</a>'; ?> 
        </div>
	<?php }
	?>
	
	<?php echo $this->category->description; ?>
<?php endif; ?>

<div class="container productlisting no-padding m-t-30">
   <?php if ($this->category->sectionid == 2) : 
		$filters = JRequest::getVar('filters');
	?>
   <form id="productFilter" method="get">
		 <div class="row m-t-30 m-b-30">
			<div class="col-sm-12 text-right">
				<label class="checkbox-inline">
				<input name="filters[gender_boy]" value="boy" type="checkbox" id="availableOnly" class="chkbox icheckbox_minimal" <?php if($filters['gender_boy']){echo 'checked=checked';}?> />
				Boy stuff</label>
				<label class="checkbox-inline">
				<input name="filters[gender_girl]" value="girl" type="checkbox" id="availableOnly" class="chkbox icheckbox_minimal" <?php if($filters['gender_girl']){echo 'checked=checked';}?> />
				Girl stuff</label>
				<label class="checkbox-inline">
				<input name="available" value="true" type="checkbox" id="availableOnly" class="chkbox icheckbox_minimal" <?php if(JRequest::getVar('available')){echo 'checked=checked';}?> />
				Show only ready items</label>
			</div>
		</div>
	</form>
<?php endif; ?>
    <div class="product_c <?php echo $this->params->get('pageclass_sfx'); ?>">
        <div class="view-grid row" data-limit="<?php echo $this->pagination->limitstart; ?>">
            <?php $i = $this->pagination->limitstart; ?>
        		<?php if($this->total < 1){ ?>
           		<div class="m-t-50 m-b-50">
							<h1 style="font-family: Fredoka One;text-align:center;font-size:50px;font-weight:400;color:#ed117d ;padding:0px 0px 10px 0px;">Oops..</h1>
								<h2 style="text-align:center;font-size:24px;color:#6ec8bf;padding:0px 0px 55px 0px;">Sorry, no product to show</h2>
							</div>
           <?php } ?>
            <?php $introcount = 12;
            if ($introcount) :
                $colcount = 1;
                if ($colcount == 0) :
                    $colcount = 1;
                endif;
                $rowcount = (int) $introcount / $colcount;
                $ii = 0;
                for ($y = 0; $y < $rowcount && $i < $this->total; $y++) : ?>
                    	
                        <?php for ($z = 0; $z < $colcount && $ii < $introcount && $i < $this->total; $z++, $i++, $ii++) : ?>
                        <!--asd-->
                            <?php $this->item =& $this->getItem($i, $this->params);
                            echo $this->loadTemplate('item'); ?>
                        <?php endfor; ?>
                <?php endfor;
            endif; ?>
        </div>
    </div>
	<?php if ($this->pagination->get('pages.total') > 1) : ?>
    <?php if ($this->params->def('show_pagination_results', 1)) : ?>
      <?php echo $this->pagination->getPagesLinks(); ?>
    <?php endif; ?>
  <?php endif; ?>
</div>
<?php 
$doc =& JFactory::getDocument();
$metadesc =  $this->params->get('page_title');
//$doc->setMetaData( 'description',  $metadesc);
//$doc->setMetaData( 'keywords',  $metakey);
//$doc->setBuffer('Baju Anak Branded Kategori '.$this->params->get('page_title'), 'seotitle', 'value');
?>
