// pages/goodslist/goodslist.js
const util = require('../../utils/util.js');
const app = getApp();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    goodslist: [
      {
        thumb: "/img/index/g1.png",
        title: "圆领T-Shirt",
        price: 99,
        collect: 0
      },
      {
        thumb: "/img/index/g2.png",
        title: "蓝色条纹衬衫",
        price: 80,
        collect: 1
      },
      {
        thumb: "/img/index/g3.png",
        title: "时尚花裙子",
        price: 200,
        collect: 1
      },
      {
        thumb: "/img/index/g4.png",
        title: "绿色T-Shirt",
        price: 900,
        collect: 0
      },
      {
        thumb: "/img/index/g1.png",
        title: "圆领T-Shirt",
        price: 99,
        collect: 0
      },
      {
        thumb: "/img/index/g2.png",
        title: "蓝色条纹衬衫",
        price: 80,
        collect: 1
      }
    ]
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