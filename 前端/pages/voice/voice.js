const util = require('../../utils/util.js');

Page({
  data: {
    text_list: [],
    data_title: [],
    src:[],
    poster:[],
    name:"",
    author:"",
    value:"0",
    winWidth: 0,
    winHeight: 0,
    delay:0,                         
    audioAction: {
      method: 'pause',
    },
    opacity_data: 0.1,                            //悬浮按钮透明度
    translate: false,
    tran_imgsrc: '../../static/chinese_english.png',
    play_imgsrc:'../../static/play.png',
    play_flag:false,
  },
  onLoad: function (options) {
    // 页面初始化 options为页面跳转所带来的参数
    var that = this;
    var post_data=[];
    post_data['id'] = options.id;
    post_data['type'] = options.type;
    if(options.type == "song"){
      options.title_cn="音乐";
    }
    //console.log(options);
    that.setData({
      data_title: options,
      src:that.options.Sound,
      poster:that.options.PIC,
    });
    // 请求精选数据
    util.AJAX("get_voice_text", post_data, function (res) {

      // 重新写入数据
      for (var i = 0; i < res.data.data.length; i++) {
        res.data.data[i]['color'] = "block";         //初始化字体颜色  
        res.data.data[i]['display'] = "none";     //初始隐藏中文翻译  
        res.data.data[i]["id"] = i;
      }
      that.setData({
        text_list: res.data,
        name:res.data.title.Title_cn,
        author:res.data.title.Type,
      });
      if(res.data.title.Type=="song"){
        that.setData({
          name:res.data.title.Title,
        });
      }
      //console.log(res.data);
    });
    wx.getSystemInfo({
      success: function (res) {
        that.setData({
          winWidth: res.windowWidth,
          winHeight: res.windowHeight,
        });
      }
    });

  }, 
  dispalychage:function(e){                //点击了文章段落触发中文显示与隐藏
    var that=this;
    //console.log(e);
    var index = parseInt(e.currentTarget.dataset.id);
    var list = that.data.text_list;
    //console.log(index);
    if (list.data[index].display == "none"){
      list.data[index].display = "flex";
    }
    else{
      list.data[index].display = "none";
    }
    that.setData({
      text_list:list,
    });
    //console.log(list);
  },
  audioPlayed: function (e) {              //当音频开始播放就触发
    //console.log(e);
    var that = this;
    if (that.data.play_flag == false) {
      that.playAudio();
      that.setData({
        play_imgsrc: '../../static/pause.png',
        play_flag: true,
      })
    }
  },
  audioTimeUpdated: function (e) {            //当播放进度发生改变触发
    //console.log(e);
    var that=this;
    var currentTime = e.detail.currentTime;
    that.data.delay += 1;
    that.duration = e.detail.duration;
    var list=that.data.text_list;
    for(var i=0;i<list.data.length;i++){        //用于让字体段落颜色跟随播放时间变化
      list.data[i]['color'] = "black";
      var time=parseFloat(list.data[i]['EndTiming']);
      if(time > currentTime){
        list.data[i]['color'] = "red";
        break;
      }
    }
    that.setData({
      text_list:list,
    });
    if(that.data.delay > 5){                      //用于延时更新进度条
      var current_value = currentTime/that.duration*100;
      that.setData({
        value: current_value,
      });
      that.data.delay = 0;
    }
  },
  playAudio: function () {               //播放音频
    this.setData({
      audioAction: {
        method: 'play'
      }
    });
  },
  pauseAudio: function () {               //暂停音频
    this.setData({
      audioAction: {
        method: 'pause'
      }
    });
  },

  timeSliderChanged: function (e) {
    var that=this;
    that.data.delay = 0;
    if (!this.duration){
      that.playAudio();
    }
    var time = this.duration * e.detail.value / 100;
    var list = that.data.text_list;
    for (var i = 0; i < list.data.length; i++) {        //将段落颜色重置
      list.data[i]['color'] = "black";
    };
    this.setData({
      audioAction: {
        method: 'setCurrentTime',
        data: time
      },
      text_list:list,
    });
  },
  show_chinese: function (e) {                //点击悬浮按钮显示全部中文翻译。
    var that = this;
    var list = that.data.text_list;
    //console.log(list.data.length);
    if (that.data.translate == false) {
      for (var i = 0; i < list.data.length; i++) {
        list.data[i].display = "flex";
      }
      that.data.translate = true;
      that.setData({
        text_list: list,
        tran_imgsrc: '../../static/english_chinese.png',
      })
    }
    else {
      for (var i = 0; i < list.data.length; i++) {
        list.data[i].display = "none";
      }
      that.data.translate = false;
      that.setData({
        text_list: list,
        tran_imgsrc: '../../static/chinese_english.png',
      })
    }
  },
  play_pause:function(){
    var that = this;
    if(that.data.play_flag == false){
      that.playAudio();
      that.setData({
        play_imgsrc:'../../static/pause.png',
        play_flag:true,
      })
    }
    else{
      that.pauseAudio();
      that.setData({
        play_imgsrc:'../../static/play.png',
        play_flag:false,
      })
    }
  },
  onReady: function (options) {
    // 页面渲染完成
    wx.setNavigationBarTitle({
      title: "爱语吧"
    })
  },
  onShow: function () {
    // 页面显示
  },
  onHide: function () {
    // 页面隐藏
  },
  onUnload: function () {
    // 页面关闭
  }
})