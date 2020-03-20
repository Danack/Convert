<?php

declare(strict_types = 1);

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/Article.php";

$article = new Article(
    1,
    "Example",
    "This is an example of how to make an object convertible to Json."
);

echo $article->toJson();

// Output is:
// {"id":1,"title":"Example","text":"This is an example of how to make an object convertible to Json."}




