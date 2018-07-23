<?php
namespace app\admin\controller;
use think\Controller;
class Banner extends Controller
{
    //首页图列表信息
    public function lst()
    {
        if(request()->isPost()){
            $data=input('post.');
            foreach ($data['sort'] as $k => $v) {
                db('banner')->where('id','=',$k)->update(['sort'=>$v]);//修改排序
            }
            $this->success('排序成功！');
        }
    	$bannerRes=db('banner')->where('status','=',1)->order('sort DESC')->paginate(3);
    	$this->assign([
    		'bannerRes'=>$bannerRes,
    		]);
        return view('list');
    }

    //添加banner轮播图信息
    public function add()
    {
    	if(request()->isPost()){
    		$data=input('post.');
    		if($_FILES['img_src']['tmp_name']){
    			 $file = request()->file('img_src');
    			 if($file){
			        $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads' . DS . 'banners');
			        if($info){
			            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                         $bannerSrc=date("Ymd").'/'.$info->getFilename();
			             $data['img_src']=$bannerSrc;
			        }else{
			            // 上传失败获取错误信息
			            echo $file->getError();
			        }
			    }
    		}else{
    			$this->error('未上传图片！');
    		}
    		$add=db('banner')->insert($data);
    		if($add){
    			$this->success('添加成功！','lst');
    		}else{
    			$this->error('添加失败！');
    		}
    		return;
    	}
        return view();
    }
  
    //编辑首页图信息
    public function edit()
    {
        // dump(config('view_replace_str.__uploads__')); die;
        $id=input('id');
        if(request()->isPost()){
            $data=input('post.');
            if($_FILES['img_src']['tmp_name']){
                 $file = request()->file('img_src');
                 if($file){
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads' . DS . 'banners');
                    if($info){
                        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                         $data['img_src']=date("Ymd").'/'.$info->getFilename();
                         // 删除原图
                         $oBanners=db('banner')->field('img_src')->find($id);
                         if($oBanners['img_src']){
                            $oImgSrc=UPLOADS.'/banners/'.$oBanners['img_src'];
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
            $save=db('banner')->update($data);
            if($save !== false){
                $this->success('修改成功！','lst');
            }else{
                $this->error('修改失败！');
            }
            return;
        }
        $banners=db('banner')->find($id);
        $this->assign([
            'banners'=>$banners,
            ]);
        return view();
    }

    //删除记录
    public function del($id){
        $banner=db('banner');
        $banners=$banner->field('img_src')->find($id);
        if($banners['img_src']){
            $ImgSrc=UPLOADS.'/banners/'.$banners['img_src'];
            if(file_exists($ImgSrc)){
                @unlink($ImgSrc);
            }
        }
        $del=$banner->delete($id);
        if($del){
            $this->success('删除banner成功！','lst');
        }else{
            $this->error('删除banner失败！');
        }
    }
}
