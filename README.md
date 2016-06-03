# Socialize
Social buttons for IonizeCMS.

Add social buttons (share, like) to your IonizeCMS website using this module. You can use "normal" or "simple" functions to add the buttons.

**Credits:** To "trk", the original creator of the very first sharing buttons for IonizeCMS (https://github.com/trk/Sociallike). This is a modificacion of that original module, but with some improvements and the "simple" sharing functions.

## Usage
It shall be used inside a ```<ion:page>``` or ```<ion:page:article>``` tag:

```html
<ion:page>
  <ion:socialize>
  	<ion:whatsapp_share_simple />
  </ion:socialize>
</ion:page>
```

Syntax:

 * socialize
  * twitter_share
  * twitter_share_simple
  * facebook_share
  * facebook_share_simple
  * googleplus_share_simple
  * whatsapp_share_simple

Common parameters:
  * url: The URL to share. Can be "base_url" for website base URL, "current_url" (i hope i don't need to explain what it does), "element_url" for <ion:page> url or <ion:article> url, or a custom URL. Default value is "current_url".
  * label: The URL label.  Default: Share on *.
  * class: The link class. Default: *-share-btn (whatsapp-share-btn).
  * render: Whether or not render the full link, or just return the link parameters (href, class, data-* params, etc). Default: TRUE.
  
Per-function parameters:
  * Twitter
    * title: Intro text for the tweet. Default: Article or Page title.
    * via: The related twitter account. Default: none;
  * Facebook
    * title: The facebook message. Default: Article or Page title.
  * Whatsapp
    * text: The message before the URL. Default: Article or Page title.

Module is not completed and the only tested and fully working 100% customizable functions are the "_simple" ones.

## Examples

### Simple share example
```html
<ion:page>
  <ion:socialize>
	  	<ion:whatsapp_share_simple   class="socialize-whatsapp"    label="" />
  		<ion:twitter_share_simple    class="socialize-twitter"     label="" via=""/>
  		<ion:facebook_share_simple   class="socialize-facebook"    label="" />
  		<ion:googleplus_share_simple class="socialize-google-plus" label="" />
  	</div>
  </ion:socialize>
</ion:page>
```

### Custom simple share example (just generate the link parameters, but dont create the entire ```<a>``` tag)
```html
<ion:page>
  <ion:socialize>
	  	<div>
	  	  <a <ion:whatsapp_share_simple   class="socialize-whatsapp"    label="" render="false" />>
	  	    <i class="fa fa-whatsapp"></i>
	  	  </a>
	  	</div>
  		<div>
  		  <a <ion:twitter_share_simple    class="socialize-twitter"     label="" render="false" via=""/>>
  		    <i class="fa fa-twitter"></i>
  		  </a>
  		</div>
  		<div>
  		  <a <ion:facebook_share_simple   class="socialize-facebook"    label="" render="false" />>
  		    <i class="fa fa-facebook"></i>
  		  </a>
  		</div>
  		<div>
  		  <a <ion:googleplus_share_simple class="socialize-google-plus" label="" render="false" />>
  		    <i class="fa fa-google-plus"></i>
  		  </a>
  		</div>
  	</div>
  </ion:socialize>
</ion:page>
```
