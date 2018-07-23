<?php
namespace app\api\controller;

class Cart extends Common
{
    public function addToCart(){
    	if($this->checkToken()){
    		$openid = input('openid');
    		$uid = $this->getUserId($openid);
    		$goodsNum = input('goodsNum');
    		$goodsId = input('goodsId');
    		if($uid){
    			$goodsInfo = db('goods')->find($goodsId);
    			if($goodsInfo['stock_num'] > $goodsNum){
    				//先判断当前商品是否已经被加入购物车，如果没有，写入一条新的数据，如果已经存在，则只增加商品购买数量即可
    				$goodsCart = db('cart')->where(array('uid'=>$uid, 'goods_id'=>$goodsId))->find();
    				if($goodsCart){
    					//记录已经存在，只需增加商品数量即可
    					 db('cart')->where(array('uid'=>$uid, 'goods_id'=>$goodsId))->setInc('goods_num', $goodsNum);
    					 return json(['code'=>200, 'msg'=>'加入购物车成功']);
    				}else{
    					//未加入购物车则写入整条记录
    					$data['uid'] = $uid;
    					// $data['goods_name'] = $goodsInfo['goods_name'];
    					// $data['price'] = $goodsInfo['shop_price'];
    					$data['goods_num'] = $goodsNum;
    					$data['goods_id'] = $goodsId;
    					db('cart')->insert($data);
    					return json(['code'=>200, 'msg'=>'加入购物车成功']);
    				}
    			}else{
    				return json(['code'=>401, 'msg'=>'商品库存不足']);
    			}
    		}else{
    			return json(['code'=>400, 'msg'=>'请重新登录']);
    		}
    	}else{
    		return json(['code'=>400, 'msg'=>'请重新登录']);
    	}
    }

    //获取购物车数据列表
    public function cartList(){
    	if($this->checkToken()){
    		$openid = input('openid');
    		$uid = $this->getUserId($openid);
    		if($uid){
    			$cartList = db('cart')->where('uid',$uid)->order('id DESC')->select();
    			if($cartList){
    				foreach ($cartList as $k => $v) {
    					$goodsInfo = model('Goods')->field('thumb,goods_name,shop_price')->find($v['goods_id']);
    					$goodsInfo = $goodsInfo->toArray();
    					$cartList[$k] = array_merge($goodsInfo, $v);
    				}
    				return json(['code'=>200,'data'=>$cartList, 'msg'=>'数据获取成功']);
    			}else{
    				return json(['code'=>400, 'msg'=>'购物车为空']);
    			}
    		}else{
    			return json(['code'=>400, 'msg'=>'请重新登录']);
    		}
    	}else{
    		return json(['code'=>400, 'msg'=>'请重新登录']);
    	}
    }

}
