<?php // @version $Id: blog.php 9722 2007-12-21 16:55:15Z mtk $
defined('_JEXEC') or die('Restricted access');
$cparams = JComponentHelper::getParams ('com_media');
//echo'<pre>';print_r(JURI::current());die();
$categories = $this->get( 'Categories' );
$section = $this->get( 'Section' );
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
<?php if ($this->params->get('show_page_title')) : ?>
<?php endif; ?>
<div id="content" class="blog p-t-0 <?php echo $this->params->get('pageclass_sfx'); ?>">
<div class="container m-t-30">
<?php 
    $modules =& JModuleHelper::getModules('blog-top');
    foreach ($modules as $module)
    {
    echo JModuleHelper::renderModule($module);
    } 
    ?>
<div class="<?php echo $this->params->get('pageclass_sfx'); ?>-listing">
    
      <?php $i = $this->pagination->limitstart; ?>
      <?php $introcount = $this->params->get('num_intro_articles');
            if ($introcount) :
                $colcount = $this->params->get('num_columns');
                if ($colcount == 0) :
                    $colcount = 1;
                endif;
                $rowcount = (int) $introcount / $colcount;
                $ii = 0;
                for ($y = 0; $y < $rowcount && $i < $this->total; $y++) : ?>
                <div class="<?php if ($this->params->get('num_columns') > 1){ echo 'row'; } ?>">
      <?php for ($z = 0; $z < $colcount && $ii < $introcount && $i < $this->total; $z++, $i++, $ii++) : ?>
      <?php $this->item =& $this->getItem($i, $this->params);
                            echo $this->loadTemplate('item'); ?>
      <?php endfor; ?>
      </div>
      <?php endfor;
            endif; ?>

  <?php if ($this->pagination->get('pages.total') > 1) : ?>
  <?php if ($this->params->def('show_pagination_results', 1)) : ?>
  <?php echo $this->pagination->getPagesLinks(); ?>
  <?php endif; ?>
  <?php endif; ?>
</div>
<div class="main-left col-lg-3 col-md-3 col-sm-4 col-xs-12 hidden">
	<?php if ($this->params->get('content_type') == 23) : ?>
  <div class="sidebar sidebar_1 ">
    <div class="side_box">
      <h5><a href="#" class="tgl_btn">Cari Harga</a></h5>
      <div class="price tgl_c">
        <div class="clearfix">
          <input type="text" id="lprice" name="lprice" class="txtbox" value="<?php echo number_format(JRequest::getVar('min', $min), 0, '', '.') ?>">
          <span class="to">s/d</span>
          <input type="text" id="hprice" name="hprice" class="txtbox" value="<?php echo number_format(JRequest::getVar('max', $max), 0, '', '.') ?>">
        </div>
        <div class="price_bar">
          <div id="slider"></div>
        </div>
        <a style="margin-top: 10px;" href="<?php echo JURI::getInstance()->toString(); ?>" class="findprice btn">Cari Harga</a> </div>
      <script>
			$(document).ready(function(e) { 
			var curUrl =  removeParam('min', '<?php echo JURI::getInstance()->toString(); ?>')
			curUrl =  removeParam('max', curUrl)
			$( "#slider" ).slider({
					range: true,
					step: 1000,
					min: <?php echo $min ?>,
					max: <?php echo $max ?>,
					values: [<?php echo JRequest::getVar('min', $min) ?>,<?php echo JRequest::getVar('max', $max) ?>],
					slide: function( event, ui ) {
					$( "#lprice" ).val(addCommas(ui.values[ 0 ]))
					$( "#hprice" ).val(addCommas(ui.values[ 1 ]))
					if(curUrl.search('\\?') > 0){
						$('.findprice').attr('href',curUrl+'&min='+ui.values[ 0 ]+'&max='+ui.values[ 1 ])
					}else{
						$('.findprice').attr('href',curUrl+'?min='+ui.values[ 0 ]+'&max='+ui.values[ 1 ])
					}
					}
				});
			});
			</script> 
    </div>
    <?php endif; ?>
    <div class="list-group">
    	<div class="list-group-item">
      	<h5><?php echo $section->title; ?> Categories</h5>
      </div>
      <?php foreach($categories as $cat){ ?>
        <?php $metakey .= ', '.$cat->title; ?>
        <a class="list-group-item" href="<?php echo $cat->link; ?>"><?php echo $cat->title; ?></a>
        <?php } ?>
    </div>
    <?php 
    $modules =& JModuleHelper::getModules('mainleft');
    foreach ($modules as $module)
    {
    echo JModuleHelper::renderModule($module);
    } 
    ?>
  </div>
</div>
</div>
</div>
<?php 
$doc =& JFactory::getDocument();
$metadesc =  '';
//$doc->setMetaData( 'description',  $metadesc);
//$doc->setMetaData( 'keywords',  $metakey);
//$doc->setBuffer('Baju Anak Branded Kategori '.$this->params->get('page_title'), 'seotitle', 'value');
?>
