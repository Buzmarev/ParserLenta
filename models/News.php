<?php

class News {
    
    public static function getNewsList()
    {
        $db = DB::getConnection();
        
        $news_list = array();
        $result = $db -> query('SELECT id, description, url, title, pubdate FROM news '
                               . 'ORDER BY id ASC');
        
        for ($i = 0; $row = $result -> fetch(); $i++) {
            $news_list[$i]['id'] = $row['id'];
            $news_list[$i]['description'] = $row['description'];
            $news_list[$i]['url'] = $row['url'];
            $news_list[$i]['title'] = $row['title'];
            $news_list[$i]['pubdate'] = $row['pubdate'];
        }
        
        return $news_list;
    }
    
    public static function getSingleNews($id)
    {
        $db = DB::getConnection();

        $result = $db -> query("SELECT image, url, title, pubdate, text FROM news "
                               . "WHERE id = $id ");
        $result ->setFetchMode(PDO::FETCH_ASSOC);
        
        return $result -> fetch();           
    }
    
    public static function getCsvNews()
    {
        date_default_timezone_set('Europe/Moscow');
        $time = time() - (60 * 60 * 24);
        
        $db = DB::getConnection();
        
        $list = array();
        $result = $db -> query("SELECT url, title, pubdate FROM news "
                               . "WHERE pubdate > $time");
        
        for ($i = 0; $row = $result -> fetch(); $i++) {
            $list[] = [$row['title'], date('Y-m-d H:i', $row['pubdate']), $row['url']];
        }

        $file = 'file.csv';
        $fp = fopen($file, 'w');
        foreach ($list as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);

        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
        }
        unlink($file);

        return true; 
    }
    
}
