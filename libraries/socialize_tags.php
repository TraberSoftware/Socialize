<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Socialize_Tags extends TagManager {

	public static $ci = NULL;
	public static $lang = NULL;
	public static $tag_definitions = array
		(
		"socialize:twitter_share"  => "twitter_share",
		"socialize:facebook_share" => "facebook_share",
		"socialize:facebook_like"  => "facebook_like",
		"socialize:google_plus"    => "googleplus",
		"socialize:whatsapp_share" => "whatsapp_share",
		
		/**
		 * Simple share buttons (no-js)
		 */
		"socialize:twitter_share_simple"    => "twitter_share_simple",
		"socialize:facebook_share_simple"   => "facebook_share_simple",
		"socialize:facebook_like_simple"    => "facebook_like_simple",
		"socialize:googleplus_share_simple" => "googleplus_share_simple",
		"socialize:whatsapp_share_simple"   => "whatsapp_share_simple",
	);
	
	public static $facebook_share_url    = 'https://www.facebook.com/sharer/sharer.php';
	public static $twitter_share_url     = 'https://www.twitter.com/intent/tweet';
	public static $google_plus_share_url = 'https://plus.google.com/share';

	/**
	 * If need load a model use this function
	 * 	@usage :
	 * 		self::load_model('your_model_name', 'your_model_short_name');
	 */
	protected static function load_model($model_name, $new_name = '') {

		if (!isset(self::$ci->{$new_name}))
			self::$ci->load->model($model_name, $new_name, true);
	}

	/**
	 * @usage :
	 * 		<ion:socialize>
	 * 			........
	 * 		</ion:socialize>
	 */
	public static function index(FTL_Binding $tag) {
		self::$ci = &get_instance();
		self::$lang = Settings::get_lang();

		return $tag->expand();
	}
	/**
	 * @usage :
	 * 		<ion:socialize>
	 * 			<ion:googleplus_share_simple class="[*]" url="[base_url|current_url|*]" label="[*]" render="true|false" />
	 * 		</ion:socialize>
	 * 	
	 */
	public static function googleplus_share_simple($tag) {
		$url = self::get_url($tag);
		$render     = self::get_param($tag, 'render', TRUE);
		$label      = self::get_param($tag, 'label', 'Share on Facebook');
		$link_class = self::get_param($tag, 'class', 'facebook-share-btn');

		/**
		 * We encode the URL data to be able to build a URL with another URL inside
		 */
		$url   = urlencode($url);

		return
			($render ? '<a' . " " : '') . 
			'href="'.self::$google_plus_share_url.'?' . 
				'url='.$url  . '"' . " " . 
			'class="'.$link_class.'"' . " " .
			'rel="nofollow"' . " " . 
			'onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=350,width=480\');return false;"' . " " . 
			'target="_blank"' . 
			($render ? 
				'>' . 
				$label . 
				'</a>'
				: ''
			);
	}
	
	/**
	 * @usage :
	 * 		<ion:socialize>
	 * 			<ion:facebook_share_simple class="[*]" url="[base_url|current_url|*]" label="[*]" title="[*]" render="true|false" />
	 * 		</ion:socialize>
	 */
	public static function facebook_share_simple($tag){
		$url = self::get_url($tag);
		$render     = self::get_param($tag, 'render', TRUE);
		$label      = self::get_param($tag, 'label', 'Share on Facebook');
		$link_class = self::get_param($tag, 'class', 'facebook-share-btn');
		$title      = self::get_param($tag, 'title', '');
		if(empty($title)){
			$title  = self::get_page_title($tag);
		}
		/**
		 * We encode the URL data to be able to build a URL with another URL inside
		 */
		$url   = urlencode($url);
		$title = urlencode($title);

		return
			($render ? '<a' . " " : '') . 
			'href="'.self::$facebook_share_url.'?' . 
				'u='.$url  . "&" . 
				't='.$title. '"' . " " .  
			'class="'.$link_class.'"' . " " .
			'rel="nofollow"' . " " . 
			'onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600\');return false;"' . " " . 
			'target="_blank"' . 
			($render ? 
				'>' . 
				$label . 
				'</a>'
				: ''
			);
	}
	
		/**
	 * @usage :
	 * 		<ion:socialize>
	 * 			<ion:twitter_share_simple via="[*]" class="[*]" url="[base_url|current_url|*]" label="[*]" text="[*]" render="true|false" />
	 * 		</ion:socialize>
	 */
	public static function twitter_share_simple($tag) {
		$url = self::get_url($tag);
		$render     = self::get_param($tag, 'render', TRUE);
		$label      = self::get_param($tag, 'label', 'Share on Twitter');
		$link_class = self::get_param($tag, 'class', 'twitter-share-btn');
		$title      = self::get_param($tag, 'title', '');
		$via        = self::get_param($tag, 'via', '');
		if(empty($title)){
			$title  = self::get_page_title($tag);
		}
		if(!empty($via)){
			if(strpos($via, "@") === 0){
				$via = substr($via, 1);
			}
		}
		
		$tweet = $title . "\r\n\r\n" . $url . (!empty($via) ? (" [Via " . $via . "]") : '');
		/**
		 * We encode the Tweet to be able to build a URL with another URL inside
		 */
		$tweet = urlencode($tweet);
		$url   = urlencode($url);
		$title = urlencode($title);

		return
			($render ? '<a' . " " : '') . 
			'href="'.self::$twitter_share_url.'?' . 
				'url='.$url. '&' . 
				'text='.$title . '&' .
				'via=' .$via . '"' . " " . 
			'class="'.$link_class.'"' . " " .
			'rel="nofollow"' . " " . 
			'onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600\');return false;"' . " " . 
			'target="_blank"' . 
			($render ? 
				'>' . 
				$label . 
				'</a>'
				: ''
			);

		
		return
			($render ? '<a' . " " : '') . 
			'href="'.self::$twitter_share_url.'?' . 
				'status='.$tweet. '"' . " " . 
			'class="'.$link_class.'"' . " " .
			'rel="nofollow"' . " " . 
			'onclick="javascript:window.open(this.href, \'\', \'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600\');return false;"' . " " . 
			'target="_blank"' . 
			($render ? 
				'>' . 
				$label . 
				'</a>'
				: ''
			);
	}

	/**
	 * @usage :
	 * 		<ion:socialize>
	 * 			<ion:whatsapp_share_simple class="[*]" url="[base_url|current_url|*]" label="[*]" text="[*]" render="true|false" />
	 * 		</ion:socialize>
	 */
	public static function whatsapp_share_simple($tag) {
		$url = self::get_url($tag);
		$render     = self::get_param($tag, 'render', TRUE);
		$label      = self::get_param($tag, 'label', 'Share on Whatsapp');
		$link_class = self::get_param($tag, 'class', 'whatsapp-share-btn');
		$title      = self::get_param($tag, 'text', '');
		if(empty($title)){
			$title = self::get_page_title($tag);
		}
		$text = 
			urlencode(
				self::get_page_title($tag) . 
				":" .
				PHP_EOL . PHP_EOL . 
				$url);
				
		/**
		 * Whatsapp message text
		 */
		$text = !empty($tag->getAttribute('text')) ? urlencode($tag->getAttribute('text')) : '';
		if(empty($text)){
			$text = urlencode(self::get_page_title($tag) . ":" . PHP_EOL . PHP_EOL . $url);
		}

		return
			($render ? '<a' . " " : '') . 
			'href="whatsapp://send?text=' .
				$text . '"' . " " .
			'data-action="share/whatsapp/share"' . " " .
			'data-text="' . $text . '"' . " " .
			'data-href="' . $url . '"' . " " .
			'class="'.$link_class.'"' . " " .
			($render ? 
				'>' . 
				$label . 
				'</a>'
				: ''
			);
	}

	/**
	 * @usage :
	 * 		<ion:socialize>
	 * 			<ion:google_plus size="null(for standart), small, medium, tall" annotation="null(for standart), none, inline" width="300" url="base_url" js="true/false" />
	 * 		</ion:socialize>
	 * 	
	 */
	public static function googleplus_old($tag) {
		// Parameters for Size : null(for standart), small, medium, tall
		$size = (!empty($tag->getAttribute('size'))) ? ' size="' . $tag->getAttribute('size') . '"' : '';
		// Parameters for annotation : null(for standart), none, inline
		$annotation = (!empty($tag->getAttribute('annotation'))) ? ' annotation="' . $tag->getAttribute('annotation') . '"' : '';
		// Width of your share button (if you set annotation option : inline)
		$width = (!empty($tag->getAttribute('width'))) ? 'width="' . $tag->getAttribute('width') . '"' : '';
		// If you type "base_url" will share the website url. if url is empty will share current url
		$url = self::get_url($tag);

		$google_plus = '<g:plusone' . $size . $annotation . $width . $url . '></g:plusone>';
		$js = (!empty($tag->getAttribute('js')) && $tag->getAttribute('js') == 'false') ? FALSE : TRUE;
		if ($js === TRUE)
			$google_plus .= 
				'<script type="text/javascript">
					window.___gcfg = {lang: \'' . self::$lang . '\'};
					(function() {
						var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
						po.src = "https://apis.google.com/js/plusone.js";
						var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
					})();
				</script>';

		return $google_plus;
	}
	
	/**
	 * @usage :
	 * 		<ion:socialize>
	 * 			<ion:facebook send="false" layout="button_count" width="450" show-faces="false" action="recommend" colorscheme="dark" js="true/false" />
	 * 		</ion:socialize>
	 */
	public static function facebook_share($tag) {

		/**
		 * Parameters for Send : true, false
		 * specifies whether to include a Send button with the Like button. This only works with the XFBML version.
		 * */
		$send = (!empty($tag->getAttribute('send'))) ? ' data-send="' . $tag->getAttribute('send') . '"' : '';

		/**
		 * Parameters for Layout :
		 * 	standard,
		 * 		(displays social text to the right of the button and friends'
		 * 		 profile photos below. Minimum width: 225 pixels.
		 * 		 Minimum increases by 40px if action is 'recommend'
		 * 		 by and increases by 60px if send is 'true'.
		 * 		 Default width: 450 pixels. Height: 35 pixels (without photos) or 80 pixels (with photos).)
		 * 	button_count,
		 * 		(displays the total number of likes to the right of the button.
		 * 		 Minimum width: 90 pixels. Default width: 90 pixels. Height: 20 pixels.)
		 * 	box_count,
		 * 		(displays the total number of likes above the button. Minimum width: 55 pixels. Default width: 55 pixels. Height: 65 pixels.)
		 * */
		$layout = (!empty($tag->getAttribute('layout'))) ? ' data-layout="' . $tag->getAttribute('layout') . '"' : '';

		// Parameters for Width : the width of the Like button
		$width = (!empty($tag->getAttribute('width'))) ? ' data-width="' . $tag->getAttribute('width') . '"' : '';

		/**
		 * Parameters for Show Faces : true, false
		 * 		specifies whether to display profile photos below the button (standard layout only)
		 * */
		$show_faces = (!empty($tag->getAttribute('show_faces'))) ? ' data-show-faces="' . $tag->getAttribute('show_faces') . '"' : '';

		/**
		 * Parameters for Action : null(for like option), recommend
		 * 		the verb to display on the button.
		 * */
		$action = (!empty($tag->getAttribute('action'))) ? ' data-action="' . $tag->getAttribute('action') . '"' : '';

		/**
		 * Parameters for Font : arial, lucida grande, segoe ui, tahoma, trebuchet ms, verdana
		 * 		the font to display in the button.
		 * */
		$font = (!empty($tag->getAttribute('font'))) ? ' data-font="' . $tag->getAttribute('font') . '"' : '';

		/**
		 * Parameters for Color Scheme : null(light(default style)), dark
		 * 		the color scheme for the like button.
		 */
		$colorscheme = (!empty($tag->getAttribute('colorscheme'))) ? ' data-colorscheme="' . $tag->getAttribute('colorscheme') . '"' : '';

		/**
		 * Parameters for Color Scheme : base_url, null (for current url)
		 * */
		$url = self::get_url($tag);

		$lang_upper = (self::$lang == 'en') ? 'US' : strtoupper(self::$lang);
		$lang = self::$lang . '_' . $lang_upper;

		$facebook = '<div class="fb-like"' . $send . $layout . $width . $show_faces . $action . $font . $colorscheme . $url . '></div>';

		$js = (!empty($tag->getAttribute('js')) && $tag->getAttribute('js') == 'false') ? FALSE : TRUE;
		if ($js === TRUE)
			$facebook .= 
				'<div id="fb-root"></div>
				<script>
					(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
						  if (d.getElementById(id)) return;
						  js = d.createElement(s); js.id = id;
						  js.src = "//connect.facebook.net/' . $lang . '/all.js#xfbml=1";
						  fjs.parentNode.insertBefore(js, fjs);
						}(document, \'script\', \'facebook-jssdk\'));
				</script>';

		return $facebook;
	}

	/**
	 * @usage :
	 * 		<ion:socialize>
	 * 			<ion:twitter_share via="your_twitter_name" text="Your page title" related="account1,account2,account3" count="vertical" size="" url="base_url" js="true/false" />
	 * 		</ion:socialize>
	 */
	public static function twitter_share($tag) {

		$url = self::get_url($tag);
		/**
		 * Parameters for Via : If you want share via a twitter account type user name or leave it blank
		 * 		Screen name of the user to attribute the Tweet to
		 */
		$via = (!empty($tag->getAttribute('via'))) ? ' data-via="' . $tag->getAttribute('via') . '"' : '';

		/**
		 * Default Tweet text
		 */
		$text = (!empty($tag->getAttribute('text'))) ? ' data-text="' . $tag->getAttribute('text') . '"' : '';

		/**
		 * Parameters for Related : account1,account2,account3
		 * 		Related accounts
		 * */
		$related = (!empty($tag->getAttribute('related'))) ? ' data-related="' . $tag->getAttribute('related') . '"' : '';

		/**
		 * Parameters for Count : null(Default Style), none, horizontal, vertical
		 * 		Count box position
		 * */
		$count = (!empty($tag->getAttribute('count'))) ? ' data-count="' . $tag->getAttribute('count') . '"' : '';

		/**
		 * Parameters for Size : null(medium Default Style), large
		 */
		$size = (!empty($tag->getAttribute('size'))) ? ' data-size="' . $tag->getAttribute('size') . '"' : '';

		$twitter = '<a href="https://twitter.com/share"' . " " .
				'class="twitter-share-button"' . " " .
				$via .
				$text .
				$related .
				$count .
				$size .
				$url .
				'data-lang="' . self::$lang . '"' .
				'>' .
				'Twitter' .
				'</a>';


		$js = (!empty($tag->getAttribute('js')) && $tag->getAttribute('js') == 'false') ? FALSE : TRUE;
		if ($js === TRUE)
			$twitter .= 
				'<script>
					!function(d,s,id){
					var js,fjs=d.getElementsByTagName(s)[0];
					if(!d.getElementById(id)){
						js=d.createElement(s);
						js.id=id;js.src="//platform.twitter.com/widgets.js";
						fjs.parentNode.insertBefore(js,fjs);
					}}(document,"script","twitter-wjs");
				</script>';
		return $twitter;
	}

	/**
	 * @usage :
	 * 		<ion:socialize>
	 * 			<ion:js google_plus="true/false" facebook="true/false" twitter="true/false" whatsapp="true/false" />
	 * 		</ion:socialize>
	 */
	public static function js($tag) {

		$google_plus = (!empty($tag->getAttribute('google_plus')) && $tag->getAttribute('google_plus') == 'true') ? TRUE : FALSE;
		$facebook = (!empty($tag->getAttribute('facebook')) && $tag->getAttribute('facebook') == 'true') ? TRUE : FALSE;
		$twitter = (!empty($tag->getAttribute('twitter')) && $tag->getAttribute('twitter') == 'true') ? TRUE : FALSE;
		$whatsapp = (!empty($tag->getAttribute('whatsapp')) && $tag->getAttribute('whatsapp') == 'true') ? TRUE : FALSE;

		$lang_upper = (self::$lang == 'en') ? 'US' : strtoupper(self::$lang);
		$fb_lang = self::$lang . '_' . $lang_upper;

		$js = '';

		if ($google_plus != FALSE || $facebook != FALSE || $twitter != FALSE) {
			if ($facebook === TRUE)
				$js .= '<div id="fb-root"></div>';

			$js .= '<script type="text/javascript">';

			if ($google_plus === TRUE)
				$js .= 'window.___gcfg = {lang: \'' . self::$lang . '\'};
							(function() {
								var po = document.createElement(\'script\'); po.type = \'text/javascript\'; po.async = true;
								po.src = "https://apis.google.com/js/plusone.js";
								var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(po, s);
							})();';
			if ($facebook === TRUE)
				$js .= '(function(d, s, id) {
						  var js, fjs = d.getElementsByTagName(s)[0];
							  if (d.getElementById(id)) return;
							  js = d.createElement(s); js.id = id;
							  js.src = "//connect.facebook.net/' . $fb_lang . '/all.js#xfbml=1";
							  fjs.parentNode.insertBefore(js, fjs);
							}(document, \'script\', \'facebook-jssdk\'));';
			if ($twitter === TRUE)
				$js .= '!function(d,s,id){
							var js,fjs=d.getElementsByTagName(s)[0];
							if(!d.getElementById(id)){
								js=d.createElement(s);
								js.id=id;js.src="//platform.twitter.com/widgets.js";
								fjs.parentNode.insertBefore(js,fjs);
							}}(document,"script","twitter-wjs");';
			if ($whatsapp === TRUE)
				$js .= '(function(){"use strict";var root=this,WASHAREBTN=function(){this.buttons=[],this.isIos===!0&&this.cntLdd(window,this.crBtn)};WASHAREBTN.prototype.isIos=navigator.userAgent.match(/Android|iPhone/i)&&!navigator.userAgent.match(/iPod|iPad/i)?!0:!1,WASHAREBTN.prototype.cntLdd=function(win,fn){var done=!1,top=!0,doc=win.document,root=doc.documentElement,add=doc.addEventListener?"addEventListener":"attachEvent",rem=doc.addEventListener?"removeEventListener":"detachEvent",pre=doc.addEventListener?"":"on",init=function(e){("readystatechange"!==e.type||"complete"===doc.readyState)&&(("load"===e.type?win:doc)[rem](pre+e.type,init,!1),!done&&(done=!0)&&fn.call(win,e.type||e))},poll=function(){try{root.doScroll("left")}catch(e){return void setTimeout(poll,50)}init("poll")};if("complete"===doc.readyState)fn.call(win,"lazy");else{if(doc.createEventObject&&root.doScroll){try{top=!win.frameElement}catch(e){}top&&poll()}doc[add](pre+"DOMContentLoaded",init,!1),doc[add](pre+"readystatechange",init,!1),win[add](pre+"load",init,!1)}},WASHAREBTN.prototype.addStyling=function(){var s=document.createElement("style"),c="body,html{padding:0;margin:0;height:100%;width:100%}.wa_btn{background-image:url(data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4NCjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+DQo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkViZW5lXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB3aWR0aD0iMTZweCIgaGVpZ2h0PSIxNnB4IiB2aWV3Qm94PSIwIDAgMTYgMTYiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDE2IDE2IiB4bWw6c3BhY2U9InByZXNlcnZlIj4NCjxnPg0KCTxnPg0KCQk8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZmlsbD0iI0ZGRkZGRiIgZD0iTTguMTI5LDAuOTQ1Yy0zLjc5NSwwLTYuODcyLDMuMDc3LTYuODcyLDYuODczDQoJCQljMCwxLjI5OCwwLjM2LDIuNTEyLDAuOTg2LDMuNTQ5bC0xLjI0LDMuNjg4bDMuODA1LTEuMjE5YzAuOTg0LDAuNTQ0LDIuMTE2LDAuODU0LDMuMzIxLDAuODU0YzMuNzk1LDAsNi44NzEtMy4wNzUsNi44NzEtNi44NzENCgkJCVMxMS45MjQsMC45NDUsOC4xMjksMC45NDV6IE04LjEyOSwxMy41MzhjLTEuMTYyLDAtMi4yNDQtMC4zNDgtMy4xNDctMC45NDZsLTIuMTk4LDAuNzA1bDAuNzE1LTIuMTI0DQoJCQljLTAuNjg2LTAuOTQ0LTEuMDktMi4xMDMtMS4wOS0zLjM1NGMwLTMuMTU1LDIuNTY2LTUuNzIyLDUuNzIxLTUuNzIyczUuNzIxLDIuNTY2LDUuNzIxLDUuNzIyUzExLjI4MywxMy41MzgsOC4xMjksMTMuNTM4eg0KCQkJIE0xMS4zNTIsOS4zNzljLTAuMTc0LTAuMDk0LTEuMDItMC41NS0xLjE3OC0wLjYxNUMxMC4wMTQsOC43LDkuODk4LDguNjY2LDkuNzc1LDguODM3QzkuNjUyLDkuMDA3LDkuMzAxLDkuMzksOS4xOTMsOS41MDUNCgkJCUM5LjA4OCw5LjYxNyw4Ljk4NCw5LjYyOSw4LjgxMiw5LjUzM2MtMC4xNzEtMC4wOTYtMC43My0wLjMtMS4zNzgtMC45MjNjLTAuNTA0LTAuNDg0LTAuODM0LTEuMDcyLTAuOTMtMS4yNTINCgkJCWMtMC4wOTUtMC4xOCwwLTAuMjcxLDAuMDkxLTAuMzU0QzYuNjc3LDYuOTI4LDYuNzc4LDYuODA1LDYuODcsNi43MDZjMC4wOTEtMC4xLDAuMTI0LTAuMTcxLDAuMTg3LTAuMjg2DQoJCQljMC4wNjItMC4xMTUsMC4wMzgtMC4yMTgtMC4wMDMtMC4zMDhDNy4wMTIsNi4wMjMsNi42OTQsNS4xNDYsNi41NjEsNC43OUM2LjQyOCw0LjQzNCw2LjI4LDQuNDg2LDYuMTc3LDQuNDgyDQoJCQlDNi4wNzUsNC40NzksNS45NTgsNC40NTksNS44NDEsNC40NTZDNS43MjQsNC40NTEsNS41MzMsNC40ODcsNS4zNjYsNC42NTdjLTAuMTY3LDAuMTctMC42MzcsMC41NzYtMC42NjksMS40MzkNCgkJCXMwLjU2NSwxLjcyMiwwLjY0OCwxLjg0MWMwLjA4NCwwLjEyMSwxLjE0LDEuOTkxLDIuODk3LDIuNzYyYzEuNzU2LDAuNzcsMS43NjYsMC41MzQsMi4wODgsMC41MTgNCgkJCWMwLjMyMi0wLjAxOCwxLjA1NS0wLjM4NiwxLjIxNS0wLjc4OWMwLjE2Mi0wLjQwNSwwLjE3Ni0wLjc1NSwwLjEzNS0wLjgzMUMxMS42MzksOS41MjEsMTEuNTIzLDkuNDc1LDExLjM1Miw5LjM3OXoiLz4NCgk8L2c+DQo8L2c+DQo8L3N2Zz4NCg==);border:1px solid rgba(0,0,0,.1);display:inline-block!important;position:relative;font-family:Arial,sans-serif;letter-spacing:.4px;cursor:pointer;font-weight:400;text-transform:none;color:#fff;border-radius:2px;background-color:#5cbe4a;background-repeat:no-repeat;line-height:1.2;text-decoration:none;text-align:left}.wa_btn_s{font-size:12px;background-size:16px;background-position:5px 2px;padding:3px 6px 3px 25px}.wa_btn_m{font-size:16px;background-size:20px;background-position:4px 2px;padding:4px 6px 4px 30px}.wa_btn_l{font-size:16px;background-size:20px;background-position:5px 5px;padding:8px 6px 8px 30px}";return s.type="text/css",s.styleSheet?s.styleSheet.cssText=c:s.appendChild(document.createTextNode(c)),s},WASHAREBTN.prototype.setButtonAttributes=function(b){var url=b.getAttribute("data-href"),text="?text="+encodeURIComponent(b.getAttribute("data-text"))+(b.getAttribute("data-text")?"%20":"");return text+=encodeURIComponent(url?url:document.URL),b.setAttribute("target","_top"),b.setAttribute("href",b.getAttribute("href")+text),b.setAttribute("onclick","window.parent."+b.getAttribute("onclick")),b},WASHAREBTN.prototype.setIframeAttributes=function(b){var i=document.createElement("iframe");return i.width=1,i.height=1,i.button=b,i.style.border=0,i.style.overflow="hidden",i.border=0,i.setAttribute("scrolling","no"),i.addEventListener("load",root.WASHAREBTN.iFrameOnload()),i},WASHAREBTN.prototype.iFrameOnload=function(){return function(){this.contentDocument.body.appendChild(this.button),this.contentDocument.getElementsByTagName("head")[0].appendChild(root.WASHAREBTN.addStyling());var meta=document.createElement("meta");meta.setAttribute("charset","utf-8"),this.contentDocument.getElementsByTagName("head")[0].appendChild(meta),this.width=Math.ceil(this.contentDocument.getElementsByTagName("a")[0].getBoundingClientRect().width),this.height=Math.ceil(this.contentDocument.getElementsByTagName("a")[0].getBoundingClientRect().height)}},WASHAREBTN.prototype.crBtn=function(){for(var b=[].slice.call(document.querySelectorAll(".wa_btn")),iframes=[],i=0;i<b.length;i++)root.WASHAREBTN.buttons.push(b[i]),b[i]=root.WASHAREBTN.setButtonAttributes(b[i]),iframes[i]=root.WASHAREBTN.setIframeAttributes(b[i]),b[i].parentNode.insertBefore(iframes[i],b[i])},root.WASHAREBTN=new WASHAREBTN}).call(this);';

			$js .= '</script>';
		}

		return $js;
	}

	public static function get_url($tag) {
		$url = (!empty($tag->getAttribute('url'))) ? $tag->getAttribute('url') : FALSE;

		$url_regexp = '/^http(s)?\:\/\//i';
		if (preg_match($url_regexp, $url)) {
			// URL itself is an URL
			return $url_regexp;
		}

		// Is not an URL, lets generate one
		switch ($url) {
			case 'base_url':
				return base_url();
			case 'current_url':
			default:
				return current_url();
		}
	}
	
	public static function get_page_title($tag){
		$article = $tag->getParent('article');
		if(!empty($article)){ // Current page is an article
			$article_data =& $article->getData();
			return $article_data['title'];
		}
		
		$page = $tag->getParent('page');
		if(!empty($page)){ // Current page is a page
			$page_data =& $page->getData();
			return $page_data['title'];
		}
	}
	
	public static function get_param($tag, $param, $default = ''){
		return ($tag->getAttribute($param) !== NULL) ? $tag->getAttribute($param) : $default;
	}
}
