<?php // @version $Id: blog.php 9722 2007-12-21 16:55:15Z mtk $
defined('_JEXEC') or die('Restricted access');
$cparams = JComponentHelper::getParams ('com_media');
$categories = $this->get( 'Siblings' );

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


<?php if ($this->params->get('show_page_title')) : ?>
<div class="title clearfix">
	<h2><?php echo $this->escape($this->params->get('page_title')); ?></h2>
</div>
<?php endif; ?>
<div class="row">
<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
    <div style="margin-top: 0;" class="product_c <?php echo $this->params->get('pageclass_sfx'); ?>">
        <div class="row view-grid animated fadeInUp" data-animation="fadeInUp">
            <?php $i = $this->pagination->limitstart; ?>
        
            <?php $introcount = 20;
            if ($introcount) :
                $colcount = 1;
                if ($colcount == 0) :
                    $colcount = 1;
                endif;
                $rowcount = (int) $introcount / $colcount;
                $ii = 0;
                for ($y = 0; $y < $rowcount && $i < $this->total; $y++) : ?>
                    
                        <?php for ($z = 0; $z < $colcount && $ii < $introcount && $i < $this->total; $z++, $i++, $ii++) : ?>
                            <?php $this->item =& $this->getItem($i, $this->params);
                            echo $this->loadTemplate('item'); ?>
                        <?php endfor; ?>
                        
                    
                <?php endfor;
            endif; ?>
        </div>
    </div>
    <?php if ($this->pagination->get('pages.total') > 1) : ?>
	<?php if ($this->params->def('show_pagination_results', 1)) : ?>
    <div class="page_c clearfix red5 pagination">
	<?php echo $this->pagination->getPagesLinks(); ?>
    </div>
	<?php endif; ?>
	<?php endif; ?>
</div>
<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 ">
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
          <a style="margin-top: 10px;" href="<?php echo JURI::getInstance()->toString(); ?>" class="findprice btn">Cari Harga</a>
        </div>
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
    	<div class="side_box side_box_1 red5">
        <h5><a href="#" class="tgl_btn">Kategori Lainnya</a></h5>
        <ul class="tgl_c">
        <?php foreach($categories as $cat){ ?>
        	<?php $metakey .= ', '.$cat->title; 
			$cat->link = JRoute::_( ContentHelperRoute::getCategoryRoute( $cat->id, $cat->section ) );
			?> 
        	<li><a href="<?php echo $cat->link; ?>"><?php echo $cat->title; ?></a></li>
		<?php } ?>
        </ul>
      </div>
      
      <div class="side_box side_box_1 red5">
        <h5><a href="#" class="tgl_btn">Gender</a></h5>
        <ul class="tgl_c">
          <li><?php echo filters('gender','laki-laki','Laki-laki'); ?></li>
          <li><?php echo filters('gender','perempuan','Perempuan'); ?></li>
          <li><?php echo filters('gender','reset','Semua Gender'); ?></li>
        </ul>
      </div>
      
      <div class="side_box side_box_1 red5">
        <h5><a href="#" class="tgl_btn">Merek</a></h5>
        <ul class="tgl_c">
			<?php foreach($brands as $brand){ ?>
            <li><?php echo filters('brand',$brand,strtoupper($brand)); ?></li>
            <?php } ?>
            <li><?php echo filters('brand','reset','SEMUA MEREK'); ?></li>
        </ul>
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
<div class="pgwrap">
	<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
		<?php if( $this->pagination->get('pages.total') > 1 ) : ?>
		
			<?php echo $this->pagination->getPagesCounter(); ?>
		
		<?php endif; ?>
		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			<?php echo $this->pagination->getPagesLinks(); ?>
		<?php endif; ?>
	<?php endif; ?>
</div>
<?php 
$doc =& JFactory::getDocument();
$metadesc =  'Toko Online Baju Anak Branded kami menjual berbagai macam '.$this->params->get('page_title').' untuk laki-laki atau perempuan.';
$doc->setMetaData( 'description',  $metadesc);
$doc->setMetaData( 'keywords',  $metakey);
$doc->setBuffer('Baju Anak Branded Kategori '.$this->params->get('page_title'), 'seotitle', 'value');
?>
