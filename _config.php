<?php

// extend File to get a special download URL
DataObject::add_extension('File', 'FileDownloadURL');

// add the download URL
Director::addRules(100, array(
    'download' => 'DownloadController'
));