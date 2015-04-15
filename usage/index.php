<?php namespace Aprillins\LiteGrabber\Usage;

require __DIR__.'/../vendor/autoload.php';

use Aprillins\LiteGrabber\LiteGrabber;

?>
<!doctype html>
<html>
<head>
    <title>Lite Grabber Usage Example</title>
</head>
<body>
    <?php
        $liteGrabber = new LiteGrabber('http://www.collections.com/php-packages/aprillins/litegrabber/samplepage/sample-2.html', false);
        $query = $liteGrabber
            ->article([], true)
            ->h2(['class' => 'post-title'])
            ->a()
            ->getQuery();
        
        //$query = '//article/h2/a';
        $title = $liteGrabber->query($query);
        var_dump($title);
        echo $title->item(1)->nodeValue;
        $liteGrabber->clearQuery();
        $query = $liteGrabber->div(['class' => 'carousel-inner'], true)->div()->img()->atSrc()->getQuery();
        $src = $liteGrabber->execute($query);
        var_dump($query);
        var_dump($src->item(1)->nodeValue);
        /*$title = $liteGrabber->xPathObj->query('//h2');
        
        if($title->length > 0){
            echo $title->item(0)->nodeValue;
        }
*/
        //var_dump($liteGrabber->div(['class' => 'post-header'], true)->img(['yes'=>'no'])->div()->getQuery());

    ?>
</body>
</html>

<?php

?>