<?php

class ParsersStorage
{
    private array $parsers = [];
    public function addParser(&$parser)
    {
        $this->parsers[] = $parser;
    }
    public function parse()
    {
        if (!empty($this->parsers))
        {
            foreach ($this->parsers as $parser)
            {
                $parser->parse();
            }
        }
    }
    public function getParsers()
    {
        return $this->parsers;
    }
}