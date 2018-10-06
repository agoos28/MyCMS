<?php
// @version $Id: default.php 9477 2007-12-05 19:35:52Z tsai146 $
defined('_JEXEC') or die('Restricted access'); 
?>

<div class="panel menu_c search_menu">
<div class="panel-heading partition-purple">
    <h4 class="panel-title"><?php echo JText::_('SEARCH'); ?></h4>
  </div>
<div class="panel-body">
    <form action="index.php"  method="post" class="search_box form-horizontal">
    <div class="input-group">
      <input class="form-control" placeholder="Search" name="searchword" id="searchword" type="search">
      <span class="input-group-btn">
      <a class="search_now btn btn-purple" href="#"><i class="fa fa-search"></i></a>
      </span>
    </div>
    <input type="hidden" name="option" value="com_search" />
    <input type="hidden" name="task"   value="search" />
  </form>
  
  <div class="search_loader text-center"><img src="<?php echo JURI::base(); ?>images/ellipsis.gif" /></div>
  <div class="search_result_list"></div>
 </div>
</div>
<script type="text/javascript">

	var searchTimout
	$('.search_now').click(function(e){
		e.preventDefault()
		$('.search_box').submit()
	}) 
	$('#searchword').keyup(function(){
		if($(this).val().length < 2){
			return
		}
		clearTimeout(searchTimout)
		searchTimout = setTimeout(function(){
			$('.search_box').submit()
		}, 1000)
	})

	$('.search_box').submit(function(e){
		e.preventDefault()
		var th = $(this)
		var data = th.serialize()
		var url = baseUrl+'search?searchword='+th.find('input#searchword').val()+'&ordering=&searchphrase=all'
		$('.search_loader').show()
		$.get(url,function(respond){
			var html = $(respond).find('#search_result_ajax').html()
			
			if(!$(respond).find('#search_result_ajax').find('li').length){
				html = '<h5 style="text-align:center;padding: 15px;">No result found!</h5>'
			}
			$('.search_result_list').html(html).show()
			$('.search_loader').hide()
		}, 'html')
		
	})
</script>

