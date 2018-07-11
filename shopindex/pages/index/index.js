//index.js
//获取应用实例
const app = getApp()

Page({
  data: {
    imgUrls: [
      '/img/index/a1.png',
      '/img/index/a2.png',
      'http://img06.tooopen.com/images/20160818/tooopen_sy_175833047715.jpg'
    ],
    
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
    if (app.globalData.userInfo) {
      this.setData({
        userInfo: app.globalData.userInfo,
        hasUserInfo: true
      })
    } else if (this.data.canIUse){
      // 由于 getUserInfo 是网络请求，可能会在 Page.onLoad 之后才返回
      // 所以此处加入 callback 以防止这种情况
      app.userInfoReadyCallback = res => {
        this.setData({
          userInfo: res.userInfo,
          hasUserInfo: true
        })
      }
    } else {
      // 在没有 open-type=getUserInfo 版本的兼容处理
      wx.getUserInfo({
        success: res => {
          app.globalData.userInfo = res.userInfo
          this.setData({
            userInfo: res.userInfo,
            hasUserInfo: true
          })
        }
      })
    }
  },
  getUserInfo: function(e) {
    console.log(e)
    app.globalData.userInfo = e.detail.userInfo
    this.setData({
      userInfo: e.detail.userInfo,
      hasUserInfo: true
    })
  }
})
