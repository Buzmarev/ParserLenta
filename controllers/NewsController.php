<?php

class NewsController {
    
    public function actionIndex($id) 
    { 
        $news = News::getSingleNews($id);
        
        if ($news['text'] == NULL) {
            Parser::updateNews($id, $news['url']);
            $news = News::getSingleNews($id);
        }
        
        require_once(ROOT. '/views/news/index.php');
        
        return true;
    }
    
    public function actionCsv()
    {
        News::getCsvNews();
        
        return true;
    }
    
}
