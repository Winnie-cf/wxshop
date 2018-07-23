<?php
namespace app\admin\controller;
use think\Controller;
class Goods extends Controller
{
    public function getgoodss(){
        $goodsRes=db('goods')->field('img_src,link_url')->where('status','=',1)->order('sort DESC')->limit(3)->select();
        return json($goodsRes);
    }

    public function lst()
    {
    	$goodsRes=db('goods')->field('g.*,c.cate_name')->alias('g')->join('cate c',"g.cate_id = c.id")->order('id DESC')->paginate(10);
    	$this->assign([
    		'goodsRes'=>$goodsRes,
    		]);
        return view('list');
    }

    public function add()
    {
    	if(request()->isPost()){
    		$data=input('post.');
            //缩略图
    		if($_FILES['thumb']['tmp_name']){
    			 $file = request()->file('thumb');
    			 if($file){
			        $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
			        if($info){
			            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                         $thumb=date("Ymd").'/'.$info->getFilename();
			             $data['thumb']=$thumb;
			        }else{
			            // 上传失败获取错误信息
			            echo $file->getError();
			        }
			    }
    		}else{
    			$this->error('未上传缩略图！');
    		}
            //详情图
            if($_FILES['des_img']['tmp_name']){
                 $file = request()->file('des_img');
                 if($file){
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
                    if($info){
                        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                         $desImg=date("Ymd").'/'.$info->getFilename();
                         $data['des_img']=$desImg;
                    }else{
                        // 上传失败获取错误信息
                        echo $file->getError();
                    }
                }
            }else{
                $this->error('未上传详情图！');
            }
    		$add=model('goods')->save($data);
    		if($add){
    			$this->success('添加商品成功！','lst');
    		}else{
    			$this->error('添加商品失败！');
    		}
    		return;
    	}
        //获取专题信息
        $speRes=db('special')->select();
        //获取商品分类
        $cateRes=model('cate')->cateTree();
        $this->assign([
            'cateRes'=>$cateRes,
            'speRes'=>$speRes,
            ]);
        return view();
    }

    public function edit()
    {
        // dump(config('view_replace_str.__uploads__')); die;
        $id=input('id');
        //商品基本信息
        $goodsInfo=db('goods')->find($id);
        //处理修改
        if(request()->isPost()){
            $data=input('post.');
            //缩略图
            if($_FILES['thumb']['tmp_name']){
                 $file = request()->file('thumb');
                 if($file){
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
                    if($info){
                        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                         $thumb=date("Ymd").'/'.$info->getFilename();
                         $data['thumb']=$thumb;
                         //删除旧的缩略图
                         $this->imgDel($goodsInfo['thumb']);
                    }else{
                        // 上传失败获取错误信息
                        echo $file->getError();
                    }
                }
            }
            //详情图
            if($_FILES['des_img']['tmp_name']){
                 $file = request()->file('des_img');
                 if($file){
                    $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads');
                    if($info){
                        // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                         $desImg=date("Ymd").'/'.$info->getFilename();
                         $data['des_img']=$desImg;
                         //删除旧的详情图
                         $this->imgDel($goodsInfo['des_img']);
                    }else{
                        // 上传失败获取错误信息
                        echo $file->getError();
                    }
                }
            }
            $save=model('goods')->update($data);
            if($save !== false){
                $this->success('修改商品成功！','lst');
            }else{
                $this->error('修改商品失败！');
            }
            return;
        }
        //商品相册信息
        $photoRes=db('photos')->where(array('goods_id'=>$id))->select();
        //无限级分类信息
        $cateRes=model('cate')->cateTree();
        //获取专题信息
        $speRes=db('special')->select();
        //获取所属专题
        $goodsSpes=array();
        $_goodsSpes=db('goods_spe')->where(array('goods_id'=>$id))->select();
        foreach ($_goodsSpes as $k => $v) {
            $goodsSpes[]=$v['spe_id'];
        }
        $this->assign([
            'cateRes'=>$cateRes,
            'goodsInfo'=>$goodsInfo,
            'photoRes'=>$photoRes,
            'speRes'=>$speRes,
            'goodsSpes'=>$goodsSpes,
            ]);
        return view();
    }

    public function del($id){
        $goods=model('goods');
        $goodsInfo=$goods->field('thumb,des_img')->find($id);
        $this->imgDel($goodsInfo['des_img']);//删除详情图
        $this->imgDel($goodsInfo['thumb']);//删除缩略图
        $del=$goods::destroy($id);
        if($del){
            $this->success('删除商品成功！','lst');
        }else{
            $this->error('删除商品失败！');
        }
    }

    //异步删除相册图片
    public function delPhoto(){
        $id=input('id');
        $photo=db('photos');
        $photos=$photo->find($id);
        $photoSrc='photo'.DS.$photos['img_src'];
        $this->imgDel($photoSrc);
        $del=$photo->delete($id);
        if($del){
            return ['status'=>0,'msg'=>'删除相册成功！'];
        }else{
            return ['status'=>1,'msg'=>'删除相册失败！'];
        }
    }

    public function imgDel($name){
        $imgSrc=UPLOADS.'/'.$name;
        if(file_exists($imgSrc)){
            @unlink($imgSrc);
        }
    }

}
