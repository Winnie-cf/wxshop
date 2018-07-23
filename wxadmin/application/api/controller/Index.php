<?php
namespace app\api\controller;

class Index
{
    public function getBanners(){
        $bannerRes=model('banner')->field('img_src,link_url')->where('status','=',1)->order('sort DESC')->limit(3)->select();
        return json($bannerRes);
    }

}
