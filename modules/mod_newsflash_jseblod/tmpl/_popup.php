<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
$raw = $item->rawcontent
?>
<?php // echo $item->text; ?>

<!-- Modal -->
<div id="modal_<?php echo $item->id; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header partition-red">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?php echo $item->title; ?></h4>
      </div>
      <div class="modal-body">
        <?php echo $raw->prom_desc; ?>
        <?php 
				//if($raw->prom_module){
				$document = JFactory::getDocument();
				$renderer = $document->loadRenderer('module');
				$module = JModuleHelper::getModule('mod_newsletter',$raw->prom_module);
				//$module->params = $module->params;
    		$module->params = "layout=full\r\npromo_id=".$item->id;
				echo $renderer->render($module);
				//}
				?>
      </div>
      
    </div>

  </div>
</div>
<div class="hide">
<button type="button" class="btn btn-info btn-lg promo_button" data-toggle="modal" data-target="#modal_<?php echo $item->id; ?>">Open Promo</button>
</div>
<script type="text/javascript">
$(window).load(function(){
	if(!readCookie('promopop')){
		setTimeout(function(){
			$('.promo_button').trigger( "click" )
		}, 5000)
		createCookie('promopop', 1, 1)
	}
	$('#newsletter').find('#email').focus(function(e){
		e.preventDefault()
		$('.promo_button').trigger( "click" )
	})
})
</script>