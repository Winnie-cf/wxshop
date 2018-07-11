// pages/welcome/welcome.js
//获取应用实例
const app = getApp()
var total_micro_second = 3;
function count_down(that){
    that.setData({
      time:total_micro_second
    });
    if(total_micro_second<=0){
       wx.switchTab({
         url: '/pages/index/index',
       });
       return;  
    }
    setTimeout(function(){
        total_micro_second--;
        count_down(that);
    },1000);
}
Page({
  /**
   * 页面的初始数据
   */
  data: {
    time:''
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
      count_down(this);
  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {
  
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