# Convert

A lightweight library for making it easier to convert objects to and from arrays, and to and from Json.

[![Actions Status](https://github.com/Danack/Convert/workflows/Tests/badge.svg)](https://github.com/Danack/Convert/actions)

# Design goals

The library was designed to make it as simple as possible to make your data be convertible to Json for simple cases, and then be easy to customise how the objects are converted for more advanced cases.


# Example

After adding the `Convert\ToJson` trait to an object, you can call `toJson` to convert the object to Json.

```
<?php

$article = new Article(
    1,
    "Example",
    "This is an example of how to make an object convertible to Json."
);

echo $article->toJson();

// Output is:
// {"id":1,"title":"Example","text":"This is an example of how to make an object convertible to Json."}
```

After adding the `Convert\FromJson` trait to a class, you can call `fromJson` statically, to create an instance.

```
<?php

$json = '{"id":1,"title":"Example","text":"This is an example of how to make an object convertible to Json."}';

$article = Article::fromJson($json);

echo "Id is: " . $article->getId() . "\n";
echo "Title is: " . $article->getTitle() . "\n";

// output is:
// Id is: 1
// Title is: Example

```

# Installation

```composer require danack/convert```

## Tests

We have several tools that are run to improve code quality. Please run `sh runTests.sh` to run them all locally, or `sh runTestsInContainer.sh` to run them in a container. 

Pull requests should have full unit test coverage.
