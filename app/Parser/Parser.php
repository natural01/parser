<?php

interface Parser
{
    public function requestAPI($url, $method, $data = false);
    public function parse();
}