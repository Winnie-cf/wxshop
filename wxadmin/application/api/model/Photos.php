<?php
namespace app\api\model;
use think\Model;
class Photos extends Model
{
    public function getImgSrcAttr($value){
        return config('queue.photourl').$value;
    }
    
}
