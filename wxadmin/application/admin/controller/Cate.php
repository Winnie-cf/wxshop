<?php
namespace app\admin\controller;
use think\Controller;
class Cate extends Controller
{

    public function lst(){
        if(request()->isPost()){
            $data=input('post.');
            foreach ($data['sort'] as $k => $v) {
                db('cate')->where('id','=',$k)->update(['sort'=>$v]);
            }
            $this->success('排序成功！');
            return;
        }
        $cateRes=model('cate')->cateTree();
        $this->assign('cateRes',$cateRes);
        return view('list');
    }

    public function add()
    {
        if(request()->isPost()){
            $data=input('post.');
            if($_FILES['thumb']['tmp_name']){
                 $file = request()->file('thumb');
                 if($file){
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
                    if($info){
                        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                         $thumbSrc=date("Ymd").'/'.$info->getFilename();
                         $data['thumb']=$thumbSrc;
                    }else{
                        // 上传失败获取错误信息
                        echo $file->getError();
                    }
                }
            }else{
                $this->error('未上传图片！');
            }
            $add=db('cate')->insert($data);
            if($add){
                $this->success('添加栏目成功！','lst');
            }else{
                $this->error('添加栏目失败！');
            }
            return;
        }
        $cateRes=model('cate')->cateTree();
        $this->assign('cateRes',$cateRes);
        return view();
    }

    public function edit()
    {
        $id=input('id');
        if(request()->isPost()){
            $data=input('post.');
            if($_FILES['thumb']['tmp_name']){
                 $file = request()->file('thumb');
                 if($file){
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
                    if($info){
                        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                         $thumbSrc=date("Ymd").'/'.$info->getFilename();
                         $data['thumb']=$thumbSrc;
                         // 删除原图
                         $ocates=db('cate')->field('thumb')->find($id);
                         if($ocates['thumb']){
                            $oImgSrc=UPLOADS.'/'.$ocates['thumb'];
                            if(file_exists($oImgSrc)){
                                @unlink($oImgSrc);
                            }
                         }
                    }else{
                        // 上传失败获取错误信息
                        echo $file->getError();
                    }
                }
            }
            $save=db('cate')->update($data);
            if($save !== false){
                $this->success('修改栏目成功！','lst');
            }else{
                $this->error('修改栏目失败！');
            }
            return;
        }
        // 当前栏目信息
        $cates=db('cate')->find($id);
        // 无限级分类
        $cateRes=model('cate')->cateTree();
        $this->assign([
            'cateRes'=>$cateRes,
            'cates'=>$cates
            ]);
        return view();
    }


    public function del($id){
        // 获取当前栏目及其子栏目的id
        $sonIds=array();
        $sonIds=model('cate')->getChildren($id);
        $sonIds[]=intval($id);
        // 删除这些栏目下的商品信息及商品图片信息

        // 循环删除
        $cate=db('cate');
        foreach ($sonIds as $k => $v) {
            $cates=$cate->field('thumb')->find($v);
            $thumbSrc=UPLOADS.'/'.$cates['thumb'];
            if(file_exists($thumbSrc)){
                @unlink($thumbSrc);
            }
            $del=$cate->delete($v);
            if($del){
                $goods=model('goods');
                $goods::destroy(['cate_id' =>$v]);
            }
        }
        $this->success('删除栏目成功！');
    }
}
