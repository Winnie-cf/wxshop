<?php
namespace app\api\model;
use think\Model;
class Goods extends Model
{
    public function getThumbAttr($value){
        return config('queue.baseurl').$value;
    }
    public function getDesImgAttr($value){
        return config('queue.baseurl').$value;
    }
    
}
