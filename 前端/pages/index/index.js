const util = require('../../utils/util.js');
//获取应用实例
// var app = getApp();
Page({
  data: {
    hidden: true,
    windowHeight: "",
    windowWidth: "",
    // tab切换
    currentTab: 0,
    headline:[],
    headline_page:1,
    voices:[],
    voices_page:1,
    movies:[],
    movies_page:1,
  },
  /*页面初始化*/
  onLoad: function(options){
    var that=this;
    this.loading();
    that.get_headline(that.data.headline_page);
    that.get_voices(that.data.voices_page);
    that.get_movies(that.data.movies_page);
  },
  onShow: function (e) {
    wx.getSystemInfo({
      success: (res) => {
        this.setData({
          windowHeight: res.windowHeight,
          windowWidth: res.windowWidth
        })
      }
    })
  },
  pullDownRefresh: function (e) {
    // console.log("下拉刷新");;
    // var that = this;
    // if (that.data.currentTab == 0) {
    //   that.data.headline=[];
    //   that.data.headline_page= 1;
    //   var index = that.data.headline_page;
    //   console.log("上拉加载更多");
    //   that.loading();
    //   that.get_headline(index);      //更新头条数据
    // }
    // else if (that.data.currentTab == 1) {
    //   that.data.movies = [];
    //   that.data.movies = 1;
    //   var index = that.data.movies_page;    //更新TED数据
    //   that.loading();
    //   that.get_movies(index);
    // }
    // else {
    //   that.data.voices = [];
    //   that.datavoices = 1;
    //   var index = that.data.voices_page;
    //   that.loading();
    //   that.get_voices(index);      //更新音频数据
    // }
  },
  pullUpLoad: function (e) {
    var that=this;
    if (that.data.currentTab==0){
      that.data.headline_page +=1;
      var index=that.data.headline_page;
      console.log("上拉加载更多");
      that.loading();
      that.get_headline(index);      //更新头条数据
    }
    else if (that.data.currentTab==1){
      that.data.movies_page += 1;
      var index = that.data.movies_page;    //更新TED数据
      that.loading();
      that.get_movies(index);
    }
    else {
      that.data.voices_page += 1;
      var index = that.data.voices_page;
      that.loading();
      that.get_voices(index);      //更新音频数据
    }
  },
  bind_swich:function(e){
    var that = this;
    that.setData({
      currentTab:e.detail.current
    });
  },
  swich: function (e) {
    var that = this;
    //console.log(e);
    var current=e.target.dataset.current;
    //console.log(current);
    if (that.data.currentTab == current){
      return false;
    }
    else{
      that.setData({
        currentTab: current,
      })
    }
    // this.loading();
    // this.getTypeData(app.page); //如果一次开始加载好了就不用再加载
  },
  //获取数据的函数
  get_headline: function (index) {
    var post_data={page:index};
    var that = this;
    util.AJAX("get_headline",post_data,function(res){
      // console.log(res.data.data);
      var data = res.data.data;
      var headline_temp=that.data.headline;    //获取headline的数据
      that.setData({
        headline: headline_temp.concat(data),
      });
    })
    if (index < 10) {                           //获取一头啊随机的数据
      post_data['page'] = Math.floor(Math.random() * 30 + 10);
      var title = Math.floor(Math.random()*6) + 1;
      util.AJAX("get_headline", post_data, function (res) {
        var data = res.data.data[title];
        if (data){
          var headline_temp = that.data.headline;
          that.setData({
            headline: headline_temp.concat(data),
          });
        }
      })
    }
    wx.hideToast();
    // console.log(that.data.headline);
  },
  get_voices: function (index){
    var post_data = { page: index };
    var that = this;
    util.AJAX("get_voices", post_data, function (res) {
      //console.log(res.data.data);
      var data = res.data.data;
      var voices_temp = that.data.voices;    //获取音频列表的数据
      that.setData({
        voices: voices_temp.concat(data),
      });
      console.log(that.data.voices);
    })
    wx.hideToast();
  },
  get_movies: function(index){
    var post_data = { page: index };
    var that = this;
    util.AJAX("get_movies", post_data, function (res) {
      // console.log(res.data.data);
      var data = res.data.data;
      var movies_temp = that.data.movies;    //获取视频列表的数据
      that.setData({
        movies: movies_temp.concat(data),
      });
      console.log(that.data.movies);
    })
    if (index < 10) {                           //获取一头啊随机的数据
      post_data['page'] = Math.floor(Math.random() * 30 + 10);
      var title = Math.floor(Math.random() * 8) + 1;
      util.AJAX("get_movies", post_data, function (res) {
        var data = res.data.data[title];
        if(data){
          var movies_temp = that.data.headline;
          that.setData({
            headline:movies_temp.concat(data),
          })
        }
      })
    }
    wx.hideToast();
  },
  onPullDownRefresh: function () {
    var that = this;
    if (that.data.currentTab == 0) {
      that.data.headline_page += 1;
      that.data.headline = [];
      var index = that.data.headline_page;
      console.log("上拉加载更多");
      that.loading();
      that.get_headline(index);      //更新头条数据
    }
    else if (that.data.currentTab == 1) {
      that.data.movies_page += 1;
      that.data.movies = [];
      var index = that.data.movies_page;    //更新TED数据
      that.loading();
      that.get_movies(index);
    }
    else {
      that.data.voices_page += 1;
      that.data.voices = [];
      var index = that.data.voices_page;
      that.loading();
      that.get_voices(index);      //更新音频数据
    }
    wx.stopPullDownRefresh();
  }, 
  loading: function () {
    wx.showToast({
      title: '加载中',
      icon: 'loading',
      duration: 20000
    })
  },
})
