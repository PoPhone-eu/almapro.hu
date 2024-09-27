<?php

namespace App\Http\Controllers;

use App\Jobs\ParseXmlJob;
use Illuminate\Http\Request;
use App\Services\ProductParser;
use App\Services\XmlParseService;

class SuperadminController extends Controller
{
    public function index()
    {
        dispatch(new ParseXmlJob());
        //XmlParseService::parseXml();
        //new ProductParser();
        return view('superadmin.index');
    }
}
