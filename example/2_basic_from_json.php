<?php

declare(strict_types = 1);

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/Article.php";

$json = '{"id":1,"title":"Example","text":"This is an example of how to make an object convertible to Json."}';

$article = Article::fromJson($json);

echo "Id is: " . $article->getId() . "\n";
echo "Title is: " . $article->getTitle() . "\n";

// output is:
// Id is: 1
// Title is: Example






