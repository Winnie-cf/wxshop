   // pages/cate/cate.js
const util = require('../../utils/util.js');
const app = getApp();
   Page({

     /*   *
      * 页面的初始数据
      */
     data: {
       topCate: [],
       cates: [],
       sonCates: [],
       startCateId: 1
     },

     /**   
      * 生命周期函数--监听页面加载
      */
     onLoad: function(options) {
       // 请求顶级栏目数据
       this.getTopCates();

     },
     //获取所有的顶级栏目
     getTopCates: function () {
       var url = app.globalData.domain + 'cate/get_top_cate';
       var params = {};
       util.wxRequest(url, params, data => {
         // console.log(data);
         this.setData({
           topCate: data
         })
       }, data => { }, data => { });
     },

     /**
      * 生命周期函数--监听页面初次渲染完成
      */
     onReady: function() {

     },

     /**
      * 生命周期函数--监听页面显示
      */
     onShow: function() {

     },

     /**
      * 生命周期函数--监听页面隐藏
      */
     onHide: function() {

     },

     /**
      * 生命周期函数--监听页面卸载
      */
     onUnload: function() {

     },

     /**
      * 页面相关事件处理函数--监听用户下拉动作
      */
     onPullDownRefresh: function() {

     },

     /**
      * 页面上拉触底事件的处理函数
      */
     onReachBottom: function() {

     },

     /**
      * 用户点击右上角分享
      */
     onShareAppMessage: function() {

     }
   })