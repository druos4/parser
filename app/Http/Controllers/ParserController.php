<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Sunra\PhpSimple\HtmlDomParser;
use Carbon\Carbon;

class ParserController extends Controller
{
    public static function parseGoods($config,$sourse){
        date_default_timezone_set('Europe/Kiev');
        $arrUrls = [];
        //наполняем список ссылок на товары с каждой категории
        foreach($config['categories'] as $category){
            $res = self::getCategoryLinks($category, $config['countParse'],$config['settings']['productCategoryClassHref']);
            $arrUrls = array_merge($arrUrls, $res);
        }
        $countUpdate = 0;
        $countParse = 0;
        if(count($arrUrls) > 0){
            foreach($arrUrls as $link){
                $countParse++;
                //получаем/обновляем товар по указанной ссылке на его страницу
                if(self::getProduct($link,$config,$sourse)){
                    $countUpdate++;
                }
            }
        }

        echo 'parsed = '.$countParse.' | updated = '.$countUpdate;
    }

    public static function getCategoryLinks($category, $countItems, $linkClass, $page = 1, $counter = 0){
        $result = [];
        $find = false;
        if($page > 1){
            $url = $category.='page_'.$page;
        } else {
            $url = $category;
        }
        $html = HtmlDomParser::file_get_html($url);
        foreach($html->find($linkClass) as $element){
            if($counter < $countItems){
                $counter++;
                $result[] = $element->href;
                $find = true;//метка, что все еще есть товары в выборке
            }
        }
        //если с одной страницы категории собрано ссылок на товары меньше чем требуется - проход по следующим страницам категории
        if($countItems > $counter && $find){
            $page++;
            $result = array_merge($result,self::getCategoryLinks($category, $countItems, $linkClass, $page, $counter));
        }

        return $result;
    }

    public static function getProduct($link, $config, $sourse){
        $data = [];
        $mytime = Carbon::now();

        $url = $config['mainUrl'].$link;
        $data = ['sourse' => $sourse,
            'updated_at' => $mytime->toDateTimeString()];
        $html = HtmlDomParser::file_get_html($url);

        $data['title'] = $html->find($config['settings']['productTitle'], 0)->plaintext;
        $data['vendor'] = substr($data['title'],0,strpos($data['title'],' '));

        $code = explode(' ',$html->find($config['settings']['productCode'], 0)->plaintext);
        $data['code'] = $code[1];

        $price = $html->find($config['settings']['productPrice'], 0)->innertext;
        $price = substr($price,0,strpos($price,'<'));
        $data['price'] = str_replace(' ','',$price);
        if(strpos($data['title'],'(') !== false && strpos($data['title'],')') !== false){
            $data['color'] = substr($data['title'],strpos($data['title'],'(')+1,strpos($data['title'],')')-strpos($data['title'],'(')-1);
        }

        $params = $html->find('.characteristics', 0)->innertext;
        if(strpos($params,'Объем встроенной памяти') !== false){
            $p = strpos($params,'Объем встроенной памяти');
            $size = substr($params,$p);
            $p = strpos($size,'item__value');
            $size = substr($size,$p+13);
            $p = strpos($size,'</div>');
            $data['memory'] = substr($size,0,$p);
        }

        if(strpos($params,'Размер экрана') !== false){
            $p = strpos($params,'Размер экрана');
            $size = substr($params,$p);
            $p = strpos($size,'item__value');
            $size = substr($size,$p+13);
            $p = strpos($size,'</div>');
            $data['size'] = substr($size,0,$p);
        }

        if(isset($data['title']) && $data['title'] != '' && $data['code'] != ''){
            $id = self::checkProductExist($data);
            if($id !== false){
                DB::table('parser')->where('id','=',$id)->update($data);
            } else {
                $data['created_at'] = $mytime->toDateTimeString();
                DB::table('parser')->insert($data);
            }
            return true;
        } else {
            return false;
        }
    }

    public static function checkProductExist($data){
        $res = DB::table('parser')->select('id')->where('code','=',$data['code'])->where('sourse','=',$data['sourse'])->first();
        if(isset($res->id) && $res->id > 0){
            return $res->id;
        } else {
            return false;
        }
    }
}
