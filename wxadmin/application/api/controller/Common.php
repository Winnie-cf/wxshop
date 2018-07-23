<?php
namespace app\api\controller;
use think\Controller;
class Common extends Controller
{
    public function check_openid(){
    	$appid=config('appid');
    	$secret=config('secret');
    	$grant_type='authorization_code';
    	$openid=input('openid');
    	$js_code=input('code');
    	$url='https://api.weixin.qq.com/sns/jscode2session';
    	$data=[
    		'appid'=>$appid,
    		'secret'=>$secret,
    		'js_code'=>$js_code,
    		'grant_type'=>'authorization_code'
    	];
    	$res=httpRequest($url,'POST',$data);
    	return json($res);
    	if($obj->openid == $openid){
    		return true;
    	}else{
    		return false;
    	}
    }

    public function restToken($openid){
        $data['token']=getRandChar(32);
        $data['token_time']=time();
        $res=db('user')->where('openid',$openid)->update($data);
        if($res){
            return $data['token'];
        }else{
            return false;
        }
    }

    //验证token的有效性
    public function checkToken(){
        $openid = input('openid');
        $token = input('token');
        $user = db('user')->where(array('openid'=>$openid, 'token'=>$token))->find();
        if($user){
            if((time()-$user['token_time']) > 7200){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }

    //获取用户id
    public function getUserId($openid){
        $userId = db('user')->where('openid',$openid)->value('id');
        return $userId;
    }
}
