// pages/goods/goods.js
const util = require('../../utils/util.js');
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    imgUrls: [
      '/img/index/a1.png',
      '/img/index/a2.png',
      'http://img06.tooopen.com/images/20160818/tooopen_sy_175833047715.jpg'
    ],
    indicatorDots: true,
    autoplay: true,
    interval: 5000,
    duration: 1000,
    minusStatus: 'disabled',
    num: 1,
    currentab: 0
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
  
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
  },
  //点击切换标题样式
  clicktab:function(e){
    if(this.data.currentab == e.target.dataset.current){
      return false;
    }else{
      this.setData({
        currentab:e.target.dataset.current
      })
    }
  },

//点击减购买量
  bindMinus:function(){
    var num=this.data.num;
    var minusStatus;
    if(num > 1){
      num--;
    }
    if(num <= 1){
      minusStatus = 'disabled';
    }else{
      minusStatus = '';
    }
    this.setData({
      num:num,
      minusStatus:minusStatus
    })
  },

  //点击增加购买量
  bindPlus:function(){
    var num = this.data.num;
    var minusStatus;
     num++;
     if (num <= 1) {
       minusStatus = 'disabled';
     } else {
       minusStatus = '';
     }
    this.setData({
      num: num,
      minusStatus: minusStatus
    })
  },
  //手动修改购买量
  bindmanual:function(e){
    var num = e.detail.value;
    this.setData({
      num:num
    })
  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {
  
  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {
  
  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {
  
  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {
  
  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {
  
  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {
  
  }
})