<?php
namespace app\api\controller;

class Cate
{
	// 获取顶级分类接口
    public function get_top_cate(){
        $topCateRes=db('cate')->field('id,cate_name')->where('pid','=',0)->order('sort DESC')->select();
        return json($topCateRes);
    }

    // 当前栏目信息接口
    public function get_cate_info($id){
        $cates=model('cate')->field('id,cate_name,thumb')->find($id);
        return json($cates);
    }

    // 获取二级子栏目接口
    public function get_son_cates($pid){
        $sonCateRes=model('cate')->field('id,cate_name,thumb')->field('id,cate_name,thumb')->where('pid','=',$pid)->order('sort DESC')->select();
        return json($sonCateRes);
    }

    //获取同级的所有二级分类
    public function get_cates($cid){
        $cate=model('cate');
        $cateinfo=$cate->field('id,pid,description,cate_name')->find($cid);
        $topId=$cateinfo['pid'];//顶级分类的id
        $topCateinfo=$cate->field('id,description')->find($topId);
        $cates=$cate->field('id,cate_name')->where('pid',$topId)->select();
        return json(['cates'=>$cates,'description'=>$topCateinfo['description']]);
    }

}
