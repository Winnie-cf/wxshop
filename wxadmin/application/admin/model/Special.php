<?php
namespace app\admin\model;
use think\Model;
class Special extends Model
{
    protected $field=true;
	protected static function init()
    {
        Special::afterDelete(function ($special) {
            $specialId=$special->id;
            db('goods_spe')->where(array('spe_id'=>$specialId))->delete();
        });
    }
    
}
