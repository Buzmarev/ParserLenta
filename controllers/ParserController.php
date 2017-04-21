<?php

class ParserController {
    
    public function actionIndex() 
    { 
        if (Parser::getMoreNews()) {
            $news_list = News::getNewsList();
            
            require_once(ROOT. '/views/site/index.php');
        }
        
        return true;
    }
    
    public function actionFiftyNews()
    {
        if (Parser::getFiftyNews()) {
            $news_list = News::getNewsList();

            require_once(ROOT. '/views/site/index.php');
        }

        return true;
    }
    
}
