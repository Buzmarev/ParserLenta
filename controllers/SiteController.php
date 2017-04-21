<?php

class SiteController {
    
    public function actionIndex() 
    { 
        $news_list = News::getNewsList();

        require_once(ROOT. '/views/site/index.php');
        
        return true;
    }
    
}
