<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
if(JRequest::getVar('layout') == 'form'){ 
	modNewsFlashjSeblodHelper::renderItem($list[0], $params, $access);
}else{ ?>
<style>
.container.textcontent{
	display: none;
}
.addresses li{
	margin-bottom: 5px;
	font-size: 13px;
	line-height: 1.3;
}
</style>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDu-rZIRL6bsp4oj_8kL6dGQ6zu_ljo1tk "></script>
<script type="text/javascript" src="<?php echo JURI::base() . 'templates/blank_j15/js/gmap3.min.js'; ?>"></script>

<div class="container">
    <div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
            <div id="gmap" style="height: 500px; margin-bottom: 30px;"></div> 
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
        <h3>Our Stores</h3>
        <div style="height: 20px;"></div>
		<div class="row">
        <?php for($i=0;$i < count($list);$i++){ 
        	$it = modNewsFlashjSeblodHelper::getRawContent($list[$i]->introtext); ?>
			<div class="col-md-4 col-sm-6 col-xs-12">
            <h5 style="margin-bottom: 10px;"><strong style="color: #000;"><?php echo $it->lc_name; ?></strong></h5><ul class="addresses"><li><?php echo str_replace('<br />','</li><li>',$it->lc_address); ?></li></ul>
            <div style="height: 20px;"></div>
			</div>
        <?php } ?>
		</div>
        </div>
        
        
        
        
        
    </div>
    
<script type="text/javascript">
$(document).ready(function(e) {
	google.maps.controlStyle = 'azteca'
	jQuery('#gmap').gmap3({ 
	map:{
		options:{
			zoom: 12,
			zoomControl: true,
			ZoomControlOptions: {
				position: google.maps.ControlPosition.LEFT_CENTER
			},
			mapTypeControl: true,
			mapTypeControlOptions: { 
				mapTypeIds: [google.maps.MapTypeId.ROADMAP, 
							google.maps.MapTypeId.SATELLITE,
							google.maps.MapTypeId.HYBRID,
							google.maps.MapTypeId.TERRAIN],
				position: google.maps.ControlPosition.RIGHT_TOP,
				style: google.maps.MapTypeControlStyle.VERTICAL_BAR
			},
			scrollwheel: false,
			disableDoubleClickZoom: true,
			navigationControl: true,
			scaleControl: true
		}
	},
	marker:{
		values:[
			<?php 
			for($i=0; $i < count($list); $i++){
				modNewsFlashjSeblodHelper::renderItem($list[$i], $params, $access); 
			}
			?>
		],
		options:{
			draggable: false
		},
		events: {
			mouseover: function(marker, event, context){
				var infowindow = $(this).gmap3({get:{name:"infowindow"}});
				if (infowindow){
					infowindow.close();
				}
				$(this).gmap3({
					infowindow:{
						anchor: marker, 
						options: {content: '<div class="gmappop" style="max-width: 300px;"><p style="margin-left: 0px"><strong style="text-transform:uppercase;">'+context.data.title+'</strong><br />'+context.data.desc+'<br /><a target="_blank" href="https://www.google.com/maps/dir/Current+Location/'+context.data.loc+'"></p></div>'}
					}
				});
			},
			mouseout: function(){
				
			},
			click: function(marker, event, context){
				var desc = $("<div />").html(context.data.spec).text()
				var html = '<div class="clearfix img-wrapper"><a href="'+context.data.url+'"><img src="'+context.data.thumb+'"/></a></div><div class="col-xs-7 col-xxs-12"><h5>'+context.data.title+'</h5>'+context.data.desc+'<br /><a class="button button-mini" href="'+context.data.url+'">More</a><a class="button button-mini" target="_blank" href="'+context.data.url+'?act=mockup">Create Mockup</a></div><div class="col-xs-5 hidden-xxs">'+desc+'</div>'
				//window.location.href = context.data.url
				$('.covdesc').fadeIn()
				$('.covdesc .wrapper').fadeOut(function(){
					$('.covdesc .wrapper').html(html)
					setTimeout(function(){
						$('.covdesc .wrapper').fadeIn()
					}, 100)
				})
			}
		}
	},
	autofit:{maxZoom: 17}
  },
  'autofit'
);
});
$(window).load(function(){
	 $('#gmap').gmap3({trigger:"resize"});
})
</script>
</div>
<div style="height: 90px;"></div>

<?php } ?>
