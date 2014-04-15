doofinder-opencart
==================

Plugin to configure the [Doofinder](http://www.doofinder.com) search service in a OpenCart 1.5.6.1 store easier than from scratch.

# Quick & Dirty Install & Configuration Guide

## Install

 * Get the latest package from [here] (https://github.com/doofinder/doofinder-opencart/releases)
 * Unzip / Untar the package. You'll find this README file and an "upload" folder
 * Upload the contents of the local "upload" folder to the remote "upload" folder of your opencart setup.
 
## Configuration

### The Data Feed

 Doofinder needs your product information available through a data feed to be accessed through a public URL from your store.
 
 * Go to _admin/extensions/product feeds_ section of your opencart admin page. You will see the "Doofinder" product feed in the listing.
 * If for the first time, Click on "install"
 * Click on "edit". You can configure there how you want your product data to be exported through the product feed. You can also see there the urls of the doofinder product feed that your open cart site is serving.
 
 
### The Doofinder Script

 Whenever you want in any page of your site that the searchbox is responsive to user input, you'll need certain script to be included in that page. You need to generate it and to make sure it's located in any page you want the results layer to work on.
 
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
 
#### and then put it in your opencart site

 * Go to your _admin/modules/doofinder_ section of your opencart admin page. Paste the code obtained in the previous step.
 * In that same page, you can add the module to whichever layout of your opencart site you want.
 


 



