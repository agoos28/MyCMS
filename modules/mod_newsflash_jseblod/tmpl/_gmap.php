<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 

$raw = $item->rawcontent;

?>
<?php
$ps = json_decode(html_entity_decode($raw->lc_map));

?>
<?php 
if(JRequest::getVar('layout') == 'form'){ ?>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDu-rZIRL6bsp4oj_8kL6dGQ6zu_ljo1tk "></script>
<script type="text/javascript" src="<?php echo JURI::base() . 'templates/blank_j15/js/gmap3.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo JURI::base() . 'templates/blank_j15/js/jquery.autocomplete.js'; ?>"></script>
<div class="g_panel" style="margin-bottom: 10px;"><input id="searchTextField" type="text" size="50" placeholder="Search Address" style="text-align: left;width:357px;direction: ltr;"></div>
<div id="gmap" style="min-width: 500px;"></div>
<style>
      #gmap{
        border: 1px dashed #C0C0C0;
        width: 100%;
        height: 300px;
      }
    </style>
<script type="text/javascript">
function updateForm(position){
	var pos = {'H': position.lat(), 'L':position.lng()}
	jQuery('input[name="lc_map"]').val(JSON.stringify(pos))
}
jQuery(window).load(function(e) {
	var curloc
	if(jQuery('input[name="lc_map"]').val().trim()){
		curloc = jQuery.parseJSON(jQuery('input[name="lc_map"]').val())
		curloc = [curloc.H, curloc.L]
	}else{
		curloc = [-6.174176983010685, 106.82818221976049 ]
	}

	jQuery("#searchTextField").val('')
	jQuery('#gmap').gmap3({ 
		map:{
			options:{
				zoom: 12,
				center: curloc,
				mapTypeControlOptions: { 
					mapTypeIds: [google.maps.MapTypeId.ROADMAP, 
								google.maps.MapTypeId.SATELLITE,
								google.maps.MapTypeId.HYBRID,
								google.maps.MapTypeId.TERRAIN]
				  }
			},
			events:{
				rightclick:function(map, event){
					addMarker(event.latLng)
				}
		  	}
		},
		marker:{
			values:[
				{latLng:curloc},
			],
			options:{
				draggable: true
			},
			events: {
				dragend: function(marker, event, context){
					updateForm(marker.position)
				}
			}
		}
		
	  }
	);
	jQuery("#searchTextField").autocomplete({
		source: function() {
			jQuery("#gmap").gmap3({
				getaddress: {
					address: jQuery(this).val(),
					callback: function(results){
						if (!results) return;
						jQuery("#searchTextField").autocomplete("display", results, false);
					}
				}
			});
		},
		cb:{
			cast: function(item){
				return item.formatted_address;
			},
			select: function(item) {
				jQuery("#gmap").gmap3({
					clear: "marker",
					marker: {
						latLng: item.geometry.location,
						options:{
							draggable: true
						},
						events: {
							dragend: function(marker, event, context){
								updateForm(marker.position)
							}
						}
					},
					map:{
						options: {
							center: item.geometry.location,
						}
					}
				});
			}
		}
	})
	.focus();
	jQuery('#gmap').on("contextmenu",function(){
       return false;
    }); 
});
</script>  	
<?php }else{ ?>
	<?php 
	$poss = json_decode(html_entity_decode($raw->lc_map));
	$img = explode('/', $raw->lc_photo);
	$thumb = JURI::base().$img[0].'/'.$img[1].'/_thumb1/'.$img[2];
	$spec = explode(',',strip_tags($raw->cov_media_info));
	$specs = '<strong class="small">Dimension</strong><br />'.$raw->cov_size.'<div class="line line-xm"></div>';
	for($s=0;$s < count($spec); $s++){
		$spec[$s] = explode(':',$spec[$s]);
		$specs .= '<strong class="small">'.$spec[$s][0].'</strong><br />'.$spec[$s][1].'<div class="line line-xm"></div>';
	}
	$data = '{title:"'.$item->title.'", url: "'.$item->linkOn.'", loc: "'.$poss->H.','.$poss->L.'", thumb: "'.$thumb.'", desc: "'.$raw->lc_map_desc.'", spec: "'.htmlentities($specs).'"}';
	echo '{latLng:['.$poss->H.','.$poss->L.'], data: '.$data.', id: '.$item->id.', tag: "'.$item->catalias.'", options:{icon: "'.JURI::base().'images/map-locator.png"}},';
	?>
<?php } ?>