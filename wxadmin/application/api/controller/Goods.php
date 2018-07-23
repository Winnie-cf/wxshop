<?php
namespace app\api\controller;

class Goods extends Common
{
	// 获取分类下的商品信息
    public function get_goods(){
        $cid=input('cid');
        $page=input('page',1);
        $config=['page'=>$page,'list_rows'=>4];
        $goodsRes=model('goods')->field('id,goods_name,thumb,shop_price')->where('cate_id','=',$cid)->order('id DESC')->paginate(null,false,$config);
        return json(['code'=>200,'msg'=>'success','goods'=>$goodsRes]);
    }

    //获取商品详情接口
    public function get_goods_info(){
    	$id=input('id');
    	$goodsInfo=model('goods')->find($id);//商品基本信息
    	if(!$goodsInfo){
    		$goods=['status'=>400,'msg'=>'error'];
    	}else{
    		if($goodsInfo['des_img']){
    			$img=imagecreatefrompng($goodsInfo['des_img']);
    			$goodsInfo['des_img_height']=imagesy($img);
    		}else{
    			$goodsInfo['des_img_height']=0;
    		}
    		$goodsImgs=model('photos')->where('goods_id',$id)->select();
    		$goods=['status'=>200,'msg'=>'success','goodsInfo'=>$goodsInfo,'goodsImgs'=>$goodsImgs];
    	}
    	return json($goods);
    }

    //商品收藏
    public function addCollect(){
        if($this->checkToken()){
            $collectObj = db('collect');
            $openid = input('openid'); 
            $goodId = input('goodsId');
            $uid = $this->getUserId($openid);
            $collect = $collectObj->where(array('goods_id'=>$goodId, 'uid'=>$uid))->find();
            if($collect){
                $collectObj->where(array('goods_id'=>$goodId, 'uid'=>$uid))->delete();
                return json(['code'=>200, 'status'=>-1, 'msg'=>'已取消']);
            }else{
                $collectObj->insert(['goods_id'=>$goodId, 'uid'=>$uid]);
                return json(['code'=>200, 'status'=>1, 'msg'=>'已收藏']);
            }
        }else{
            return json(['code'=>400, 'msg'=>'重新登录']);
        }
    }

    //判断商品是否已被当前用户收藏
    public function doCollect(){
        $collectObj = db('collect');
        $openid = input('openid'); 
        $goodId = input('goodsId');
        $uid = $this->getUserId($openid);
        $collect = $collectObj->where(array('goods_id'=>$goodId, 'uid'=>$uid))->find();
        if($collect){
            return json(['status'=>1]);
        }else{
            return json(['status'=>-1]);
        }
    }


}
