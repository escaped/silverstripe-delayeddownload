# DelayedDownload module

## Maintainer Contact

  * Alexander Frenzel <alex[at]relatedworks[dot]com>

## Requirements

  * SilverStripe 2.4.x

## Documentation

  This modules provides a controller for the typical "Your download starts automatically in some seconds".
  
  In addition there is an htaccess file included which prevents hotlinking. Of course this is no perfect protection!
  Probably you won't need to use $File.DelayedDownloadURL instead of $File.URL if you use the hotlinking protection.
  
## Installation Instructions

  * Extract to your silverstripe folder
  * modify and copy the htaccess if needed
  
### .htaccess

  * You need to modify the htaccess file: Just replace YOURDOMAIN.TLD
  * As you can see there are serveral exception for hotlinking. The following "users" won't get redirected:
    * Visitors of your homepage 
    * Some popular Crawlers
  * you can adjust those exceptions to fit your needs
  
  * copy the modified htaccess file to the directory you want to protect, e.g. /assets/Downloads/.htaccess
  * this will redirect every file request within this directory to the DelayedDownload-Controller if no exception is matched
 