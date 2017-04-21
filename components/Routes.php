<?php

return array(

    'csv' => 'NewsController/actionCsv',
    
    'parser' => 'ParserController/actionFiftyNews',
    'add' => 'ParserController/actionIndex',
    
    'news/([0-9]+)' => 'NewsController/actionIndex/$1',
    
    'index.php' => 'SiteController/actionIndex',
    '' => 'SiteController/actionIndex',
    
);
