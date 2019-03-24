<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Sunra\PhpSimple\HtmlDomParser;
use App\Http\Controllers\ParserController as Parser;

class ParseGoods extends Command
{
    protected $signature = 'parseGoods';

    protected $description = 'Parse goods from site';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $sourse = 'citrus';
        $config = config('parser.'.$sourse);
        Parser::parseGoods($config,$sourse);
    }
}
