<?php

declare(strict_types = 1);


use Convert\ToJson;
use Convert\FromJson;

class Article
{
    // This line allows the class to be converted to Json
    use ToJson;

    // This line allows the class to be instantiated from Json
    use FromJson;

    private int $id;

    private string $title;

    private string $text;

    public function __construct(int $id, string $title, string $text)
    {
        $this->id = $id;
        $this->title = $title;
        $this->text = $text;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }
}