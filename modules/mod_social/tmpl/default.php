<?php
/**
* @package    modtemplate
* @author     agoos28
* @copyright  bebas
* @license    bebas
**/

//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

$nowtime = (int) time();
$lasttimefetch = (int) JFile::read($modulepath.'/timer.txt');
if($lasttimefetch + 216000 < $nowtime){
	$getnew = 1;
}else{
	$getnew = 0;
}
//print_r($lasttimefetch.' '.time());die();

?>

<div class="mod_social rmod">
	<?php if($params->get('mode')){ ?>
    	<div style="height: 30px;"></div>
    <?php } ?>
	<div class="title clearfix">
	<h3 class="modtitle"><div><a class="btn" target="_blank" style="padding: 5px 30px 11px;" href="https://instagram.com/lunahabit/"><span class="fa fa-instagram" style="font-size: 22px; transform: translate(0px, 3px);-webkit-transform: translate(0px, 3px);"></span> @LunaHabit</a></div></h3>
</div>
    	<div id="insta" class="feeds container">
        	<?php 
			if($getnew){
				$instagram = new Instagram(array(
				  'apiKey'      => '194f54f4fbab4ce89f008105c1d237e8',
				  'apiSecret'   => 'a75fbe11fd804243bc4787e0e1ef16a5',
				  'apiCallback' => 'http://lunahabit.com'
				));
				$user = $instagram->getUser('1549713170');
				$result = $instagram->getUserMedia('1549713170',18);
				//echo'<pre>';print_r($result);echo'<pre>';
				
				if($result){
					JFile::write($modulepath.'/instagram.json', json_encode($result));
					JFile::write($modulepath.'/instagramuser.json', json_encode($user));
					JFile::write($modulepath.'/timer.txt', time());
				}else{
					$result =  json_decode(JFile::read($modulepath.'/instagram.json'));
					$user =  json_decode(JFile::read($modulepath.'/instagramuser.json'));
				}
			}else{
				$result =  json_decode(JFile::read($modulepath.'/instagram.json'));
				$user =  json_decode(JFile::read($modulepath.'/instagramuser.json'));
			}
			?>
				<div class="row">
				<?php
				if($params->get('mode')){
					for($s=0;$s < 9;$s++){ ?>
						<div class="col-lg-4 col-md-4 col-sm-2 cols-xs-2">
                   <?php echo '<a class="thumbnail fancybox-iframe fancybox.iframe" href="'.$result->data[$s]->link.'embed"><img class="" src="'.$result->data[$s]->images->low_resolution->url.'"/></a>'; ?>
                 </div>
					<?php }
				}else{
                foreach($result->data as $data){ ?>
                <div class="col-lg-4 col-md-4 col-sm-2 cols-xs-2">
                   <?php echo '<a class="thumbnail fancybox-iframe fancybox.iframe" href="'.$data->link.'embed"><img class="" src="'.$data->images->low_resolution->url.'"/></a>'; ?>
                 </div>
                <?php }} ?>
            	</div>
                <div style="height: 30px;"></div>
        </div>
</div>
