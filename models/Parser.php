<?php

class Parser {
    
    public static function getFiftyNews()
    {
        $rss = 'https://lenta.ru/rss';
        
        $xmlstr = file_get_contents($rss);
        
        $xml = new SimpleXMLElement($xmlstr);
        
        $db = DB::getConnection();
            
        $sql = 'INSERT INTO news (description, url, title, pubdate) '
                . 'VALUES (:des, :url, :title, :pubdate)';
            
        for ($i = 49; $i >= 0; $i--) {

            $des = strval($xml -> channel -> item[$i] -> description);
            $url = strval($xml -> channel -> item[$i] -> link);
            $title = strval($xml -> channel -> item[$i] -> title);
            $pubdate = strtotime(strval($xml -> channel -> item[$i] -> pubDate));

            $result = $db ->prepare($sql);
            $result -> bindParam(':des', $des, PDO::PARAM_STR);
            $result -> bindParam(':url', $url, PDO::PARAM_STR);
            $result -> bindParam(':title', $title, PDO::PARAM_STR);
            $result -> bindParam(':pubdate', $pubdate, PDO::PARAM_STR);
            
            $result ->execute();
        }
        return true;
    }
    
    public static function getLastNews()
    {
        $db = DB::getConnection();
        
        $result = $db -> query('SELECT url, pubdate FROM news '
                               . 'ORDER BY id DESC '
                               . 'LIMIT 1');
        $result ->setFetchMode(PDO::FETCH_ASSOC);
        $last_news = $result -> fetch();
        
        return $last_news;
    }
    
    public static function getMoreNews()
    {
        $rss = 'https://lenta.ru/rss';
        
        $xmlstr = file_get_contents($rss);
        
        $xml = new SimpleXMLElement($xmlstr);
        
        $db = DB::getConnection();
            
        $sql = 'INSERT INTO news (description, url, title, pubdate) '
                . 'VALUES (:des, :url, :title, :pubdate)';
            
        $last_news = Parser::getLastNews();
        
        for ($i = 199; $i >= 0; $i--) {
            
            $pubdate = strtotime(strval($xml -> channel -> item[$i] -> pubDate));
            $url = strval($xml -> channel -> item[$i] -> link);

            if ($pubdate >= $last_news['pubdate']) {
                $des = strval($xml -> channel -> item[$i] -> description);
                $title = strval($xml -> channel -> item[$i] -> title);

                $result = $db ->prepare($sql);
                $result -> bindParam(':des', $des, PDO::PARAM_STR);
                $result -> bindParam(':url', $url, PDO::PARAM_STR);
                $result -> bindParam(':title', $title, PDO::PARAM_STR);
                $result -> bindParam(':pubdate', $pubdate, PDO::PARAM_STR);

                $result ->execute();
            } 
        }
        return true;
    }
    
    public static function updateNews($id, $url)
    {
        include_once(ROOT. '/components/simple_html_dom.php');
        
        $html = file_get_html($url);
            
        $image = $html->find('img[class=g-picture]', 0) -> src;
        
        $text = array();
        foreach ($html->find('p') as $element) {
            $text[] = strval($element);
        }
        $text_json = json_encode($text);
        
        $html -> clear();
        unset($html);
        
        $db = Db::getConnection();
        
        $sql = "UPDATE news
            SET 
                image = :image, 
                text = :text_json
            WHERE id = :id";
        
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':image', $image, PDO::PARAM_STR);
        $result->bindParam(':text_json', $text_json, PDO::PARAM_STR);
        
        $result->execute();
    }
    
}
