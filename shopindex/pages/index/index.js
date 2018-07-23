////index.js
const util = require('../../utils/util.js');
//获取应用实例
const app = getApp()

Page({
  data: {
    imgUrls: [],
    
    goodslist: [//
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
      }
    ],
    indicatorDots: true,
    autoplay: true,
    interval: 5000,
    duration: 1000,
    motto: 'Hello World',
    userInfo: {},
    hasUserInfo: false,
    canIUse: wx.canIUse('button.open-type.getUserInfo')
  },
  //事件处理函数
  bindViewTap: function() {
    wx.navigateTo({
      url: '../logs/logs'
    })
  },
  onLoad: function () {
    //获取首页图信息
    this.loadIndex();
  },
  //首页数据获取
  loadIndex: function () {
    var url = app.globalData.domain + 'index/getBanners';
    var params = {};
    util.wxRequest(url, params, data => {
      console.log(data);
      this.setData({
        imgUrls: data
      })
    }, data => { }, data => { });
  }
 
  
})
