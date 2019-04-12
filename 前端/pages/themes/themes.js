

const util = require( '../../utils/util.js' );

Page( {
    data:{
        text_list:[],
        data_title:[],
        winWidth:0,
        winHeight:0,
        opacity_data:0.2,                            //悬浮按钮透明度
        translate:false,
        tran_imgsrc:'../../static/chinese_english.png'
    },
    onLoad: function( options ) {
        // 页面初始化 options为页面跳转所带来的参数
        var that = this, Id = options.id;
        var post_data={id:Id};
        that.setData({
          data_title:options,
        });
        // 请求精选数据
        util.AJAX( "get_text" , post_data,function( res ) {
          for (var i = 0; i < res.data.data.length; i++) {
            res.data.data[i]['display'] = "none";     //初始隐藏中文翻译  
            res.data.data[i]["id"] = i;
          };
            // 重新写入数据
          console.log(res.data);
          that.setData({
            text_list: res.data,
          });
        });
        wx.getSystemInfo({
          success: function (res) {
            that.setData({
              winWidth: res.windowWidth,
              winHeight: res.windowHeight
            });
          }
        });

    },
    dispalychage: function (e) {                //点击了文章段落触发中文显示与隐藏
      var that = this;
      //console.log(e);
      var index = parseInt(e.currentTarget.dataset.id);
      var list = that.data.text_list;
      if (list.data[index].display == "none") {
        list.data[index].display = "flex";
      }
      else {
        list.data[index].display = "none";
      }
      that.setData({
        text_list: list,
      });
      //console.log(list);
    },
    show_chinese:function(e){                //点击悬浮按钮显示全部中文翻译。
      var that = this;
      var list = that.data.text_list;
      //console.log(list.data.length);
      if (that.data.translate == false){
        for (var i = 0; i < list.data.length; i++) {
          list.data[i].display = "flex";
        }
        that.data.translate = true;
        that.setData({
          text_list: list,
          tran_imgsrc: '../../static/english_chinese.png',
        })
      }
      else{
        for(var i=0; i < list.data.length; i++){
          list.data[i].display = "none";
        }
        that.data.translate = false;
        that.setData({
          text_list: list,
          tran_imgsrc:'../../static/chinese_english.png',
        })
      }
    },
    
    onReady: function(options) {
        // 页面渲染完成
        wx.setNavigationBarTitle( {
            title: "爱语吧"
        })
    },
    onShow: function() {
        // 页面显示
    },
    onHide: function() {
        // 页面隐藏
    },
    onUnload: function() {
        // 页面关闭
    }
})