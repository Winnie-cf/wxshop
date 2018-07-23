<?php
namespace app\admin\model;
use think\Model;
class Goods extends Model
{
    protected $field=true;
	protected static function init()
    {
        Goods::afterInsert(function ($goods) {
            $data=input('post.');
        	$goodsId=$goods->id;
        	//上传商品相册
        	if($_FILES['photo']){
				$goods->upload($goodsId);
        	}
            if(isset($data['spe'])){
                foreach ($data['spe'] as $k => $v) {
                    db('goods_spe')->insert(['goods_id'=>$goodsId,'spe_id'=>$v]);
                }
            }
        });

        Goods::beforeUpdate(function ($goods) {
            $data=input('post.');
        	$goodsId=$goods->id;
        	if($_FILES['photo']){
				$goods->upload($goodsId);
        	}
            if(isset($data['spe'])){
                db('goods_spe')->where(array('goods_id'=>$goodsId))->delete();
                foreach ($data['spe'] as $k => $v) {
                    db('goods_spe')->insert(['goods_id'=>$goodsId,'spe_id'=>$v]);
                }
            }else{
                db('goods_spe')->where(array('goods_id'=>$goodsId))->delete();
            }
        });

        Goods::afterDelete(function ($goods) {
            $goodsId=$goods->id;
            //处理中间表记录
            db('goods_spe')->where(array('goods_id'=>$goodsId))->delete();
            //处理商品相册
            //商品相册删除
            $photoArr=db('photos')->where(array('goods_id'=>$goodsId))->select();
            if($photoArr){
                foreach ($photoArr as $k => $v) {
                    $photoSrc='photo'.DS.$v['img_src'];
                    $this->imgDel($photoSrc);//删除商品相册，商品相册保存在了photo文件夹中
                }  
                //删除记录
                $delPhotos=db('photos')->where(array('goods_id'=>$goodsId))->delete();
            }
        });
    }

    //多文件上传
    public function upload($goodsId){
	    // 获取表单上传文件
	    $files = request()->file('photo');
	    $photos=db('photos');
	    foreach($files as $file){
	        // 移动到框架应用根目录/public/uploads/ 目录下
	        $info = $file->move(ROOT_PATH . 'public' . DS . 'static' . DS . 'uploads' . DS . 'photo');
	        if($info){
	            $imgSrc=date("Ymd").'/'.$info->getFilename();
	            $photos->insert(['goods_id'=>$goodsId,'img_src'=>$imgSrc]);
	        }else{
	            // 上传失败获取错误信息
	            echo $file->getError();
	        }    
	    }
	}
    
}
