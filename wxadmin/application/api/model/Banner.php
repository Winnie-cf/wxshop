<?php
namespace app\api\model;
use think\Model;
class Banner extends Model
{
    public function getImgSrcAttr($value){
        return config('queue.baseurl').$value;
    }
    
}
