<?php
/**
* @package    modtemplate
* @author     agoos28
* @copyright  bebas
* @license    bebas
**/

//no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once (dirname (dirname ( __FILE__ )) . "/helper.php");

?>

<div class="newsletter">
  <div class="emailbox lead">
    <form method="post" id="newsletter" action="<?php echo JURI::current(); ?>">
      <h2><?php echo $params->get( 'module_desc' ) ?></h2>
      <div class="info"></div>
      <div class="input-group">
        <input id="email" class="txtbox nw_mail mailcheck" type="text" name="email" value="" placeholder="your@email.com"  />
        <span class="input-group-btn"> <a onclick="$('#newsletter').submit()" class="btn btn-light-green"><?php echo JText::_('SUBSCRIBE') ?></a> </span> </div>
      <input type="hidden" name="newsletter" value="1" />
      <input id="ajax" type="hidden" name="ajax" value="1" />
    </form>
  </div>
</div>
<script type="text/javascript">
function isValidEmailAddress(emailAddress) {
		var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
		return pattern.test(emailAddress);
	};
	$(document).ready(function() {
		$('#newsletter').submit(function(e){
			e.preventDefault()
			var th = $(this)
			var value = th.serialize()
			
			if(th.find('#email').val()){
				if(!isValidEmailAddress(th.find('#email').val())){
					$('.info').addClass('error').text('<?php echo JText::_('INVALID_EMAIL') ?>')
					return false
				}
			}else{
				$('.info').addClass('error').html('<?php echo JText::_('ENTER_EMAIL') ?>')
				return false
			}
			$('button').text('<?php echo JText::_('SENDING') ?>')
			$.post(th.attr('action'),value,function(data){
				var respond = '<div>'+data+'</div>'
				respond = $(respond).find('#respond').html()
				if(respond == 'OK'){
					$('.info').html('<?php echo JText::_('THANK_YOU'); ?>')
				}else{
					$('.info').addClass('error').html(respond)
				}
			})
		})
	});
	</script>