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
       //  请求当前栏目数据
       this.getCateInfo();
       //请求当前栏目子分类
       this.getSonCates();

     },
     //获取所有的顶级栏目
     getTopCates: function () {
       var url = app.globalData.domain + 'cate/get_top_cate';
       var params = {};
       util.wxRequest(url, params, data => {
        //  console.log(data);
         this.setData({
           topCate: data
         })
       }, data => { }, data => { });
     },
     //获取当前栏目信息
     getCateInfo: function () {
       var startCateId = this.data.startCateId
       var url = app.globalData.domain + 'cate/get_cate_info';
       var params = { id: startCateId };
       util.wxRequest(url, params, data => {
        //  console.log(data);
         this.setData({
           cates: data
         })
       }, data => { }, data => { });
     },
     //  请求当前栏目子分类数据
     getSonCates: function () {
       var startCateId = this.data.startCateId
       var url = app.globalData.domain + 'cate/get_son_cates';
       var params = { pid: startCateId };
       util.wxRequest(url, params, data => {
        //  console.log(data);
         this.setData({
           sonCates: data
         })
       }, data => { }, data => { });
     },
  /**
   * 切换顶级栏目高亮状态并获取数据
   */
     changeid: function (e) {
       var that = this
       var curId = e.target.dataset.id;
       that.setData({ startCateId: curId });
       //  请求当前栏目数据
       this.getCateInfo();
       //  请求当前栏目子栏目数据
       this.getSonCates();
     },
     //点击跳转到商品列表页
     goodslist: function (e) {
       var cid = e.currentTarget.dataset.cid;
       wx.navigateTo({
         url: '../goodslist/goodslist?cid=' + cid
       })
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