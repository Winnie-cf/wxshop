<?php
namespace app\admin\model;
use think\Model;
class Cate extends Model
{

    public function cateTree(){
    	$cateRes=self::order('sort DESC')->select();
    	return $this->_sort($cateRes);
    }

    private function _sort($cateRes,$pid=0,$level=0){
    	static $arr=array();
    	foreach ($cateRes as $k => $v) {
    		if($v['pid']==$pid){
    			$v['level']=$level;
    			$arr[]=$v;
    			$this->_sort($cateRes,$v['id'],$level+1);
    		}
    	}
    	return $arr;
    }

    // 获取子栏目
    public function getChildren($id){
        $data=self::select();
        return $this->_getChildren($data,$id);
    }

    private function _getChildren($data,$id){
        static $arr=array();
        foreach ($data as $k => $v) {
            if($v['pid']==$id){
                $arr[]=$v['id'];
                $this->_getChildren($data,$v['id']);
            }
        }
        return $arr;
    }
    
}
