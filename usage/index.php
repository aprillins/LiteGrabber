<?php namespace Aprillins\LiteGrabber\Usage;

require __DIR__.'/../vendor/autoload.php';

use Aprillins\LiteGrabber\LiteGrabber;

?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
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
    
        //$title = $liteGrabber->query($query);
        /*var_dump($title);
        echo $title->item(1)->nodeValue;*/
        $result = $liteGrabber->getResult();
        print_r($result);

        //ALDOVEGA
        $liteGrabber->initGrabber('http://www.aldovega.com');
        //$liteGrabber->clearQuery();
        $query = $liteGrabber->p(['class' => 'pr hci lh0'], true)->img()->atSrc()->getQuery();
        var_dump($query);

        print_r($liteGrabber->getResult());
    ?>
</body>
</html>