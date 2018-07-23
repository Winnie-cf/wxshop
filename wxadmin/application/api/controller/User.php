<?php
namespace app\api\controller;

class User extends Common
{
    public function get_user(){
    	if($this->check_openid()){
    		$openid=input('openid');
            $data['nick_name'] = input('nick_name');
            $data['head_src'] = input('head_src');
    		$user=db('user')->where('openid',$openid)->find();
    		if($user){
                if($user['nick_name']=='' && $data['nick_name']){//第一次登录
                    db('user')->where('openid',$openid)->update($data);
                    $user['nick_name'] = $data['nick_name'];
                    $user['head_src'] = $data['head_src'];
                }
    			$user['token']=$this->restToken($openid);
    			if($user['token']){
    				return json(['status'=>200,'msg'=>'验证成功','data'=>$user]);
    			}else{
    				return json(['status'=>401,'msg'=>'token重置失败']);
    			}
    		}else{
    			return json(['status'=>400,'msg'=>'用户不存在']);
    		}
    	}else{
    		return json(['status'=>401,'msg'=>'登录失败，请重新授权']);
    	}
    }

    public function register(){
        $data['openid']=input('openid');
        $data['token']=getRandChar(32);
        $data['token_time']=time();
        $data['reg_time']=time();
        $user=db('user')->insert($data);
        if($user){
            return json(['status'=>200,'msg'=>'注册成功','data'=>$user]);
        }else{
            return json(['status'=>400,'msg'=>'注册失败']);
        }
    }

}
