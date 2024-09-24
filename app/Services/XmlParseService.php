<?php

namespace App\Services;

use App\Services\ProductParser;
use App\Services\CategoryParser;
use App\Services\ProductParserTemp;

class XmlParseService
{
    public static function parseXml()
    {
        //new CategoryParser();
        //new ProductParser();
        new ProductParserTemp();
        return;
    }
}
