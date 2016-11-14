doofinder-opencart
==================

Plugin to configure the [Doofinder](http://www.doofinder.com) search service in a OpenCart 1.5.x or 2.3.x store easier than from scratch.

# Quick & Dirty Install & Configuration Guide

## Install

 * Get the latest package for your opencart version from [here] (https://github.com/doofinder/doofinder-opencart/releases)
   - If your opencart is `1.5.x`, fetch the latest `v1.x.y` tarball
   - If your opencart is `2.3.x`, fetch the latest `v2.x.y` tarball
 * Unzip / Untar the package. You'll find this README file and an "upload" folder
 * Upload the contents of the "upload" folder to the remote folder of your opencart setup. If you need more info about how to install third party modules in opencart check [this article](http://docs.opencart.com/display/opencart/Installing+3rd+party+modules).
 
## Configuration

### The Data Feed

 Doofinder needs your product information available through a data feed to be accessed through a public URL from your store.
 
 * Go to _extensions/product feeds_ section of your opencart admin page. You will see the "Doofinder" product feed in the listing.
 * If for the first time, Click on "install"
 * Click on "edit". You can configure there how you want your product data to be exported through the product feed. You can also see there the urls of the doofinder product feed that your open cart site is serving. There is one for each one of your site's currency and language.
 
 
### The Doofinder Script

 Whenever you want in any page of your site that the searchbox is responsive to user input, you'll need certain script to be included in that page. You need to generate it and to make sure it's located in any page you want the results layer to work on. 
 
 If your site can be served in several languages and currencies, you'll need to use a search engine for each one of those, and generate a different script for each.
 
#### Obtain the script ...

 * Go to the "Configuration" section of your doofinder's control panel, access to the "Installation Scripts" tab.
 * Check "doofinder layer" and click on the "get the script" button.
 * You will obtain something like this:
```
    <script type="text/javascript">
        var doofinder_script ='//d3chj0zb5zcn0g.cloudfront.net/media/js/doofinder-3.latest.min.js';
        (function(d,t){
            var f=d.createElement(t),s=d.getElementsByTagName(t)[0];f.async=1;
                f.src=('https:'==location.protocol?'https:':'http:')+doofinder_script;
                s.parentNode.insertBefore(f,s)}(document,'script')
        );
        if(!doofinder){var doofinder={};}
        doofinder.options = {
            lang: 'en',
            hashid: 'fffff22da41abxxxxxxxxxx35daaaaaa',
            queryInput: '#search input',
            width: 535,
            dleft: -112,
            dtop: 84,
            marginBottom: 0
        }
    </script>
```
 * The obtained script will be available from now on in your doofinder control panel.
 * Remember you have to do this for every search engine you may have defined for the different language/currency combinations you may have available in your site.
 
#### and then put it in your opencart site

 * In Opencart 1.5.x
   - Go to your _admin/modules/doofinder_ section of your opencart admin page.
   - Paste the code obtained in the previous step. You'll find a text box for each combination of language/currency your site has available. 
   -  In that same page, you can add the module to whichever layout of your opencart site you want.
 * In Opencart 2.3.x
   - Go to your _extensions/modules_ and select `Doofinder Script`
   - Paste the code obtained in the previous step. You'll find a text box for each combination of language/currency your site has available. 
   -  Then go to _layouts_ section to specify where you want the `Doofinder Script` module to display the script.
 


 



