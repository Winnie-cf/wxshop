<?php
namespace app\api\model;
use think\Model;
class Cate extends Model
{
    public function getThumbAttr($value){
        return config('queue.baseurl').$value;
    }
    
}
