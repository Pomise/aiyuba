<?php
namespace app\index\controller;



	class Aiyuba{
		public  static $header = array(
				"Accept: application/json, text/javascript, */*; q=0.01",
				"Accept-Encoding:gzip, deflate",
				"Accept-Language:zh-CN,zh;q=0.9",
				"Cache-Control:max-age=0",
				"Connection:keep-alive",
				//"Content-Length:68",               //要根据具体请求而定义，可以不用
				"Content-Type:application/x-www-form-urlencoded; charset=UTF-8",
				"Host:cms.iyuba.com",
				"Origin:http://www.iyuba.com",
				//"Referer:http://www.iyuba.com/",
				"User-Agent:Mozilla/5.0 (Windows NT 10.0; …) Gecko/20100101 Firefox/60.0",);
		public function index(){
			return "this is index aiyuba index";
		}
		//获取头条列表
		public function get_headline(){
			$ch = curl_init();
			$url = "http://cms.iyuba.com/dataapi/jsp/getTitle.jsp";
			$post_data = array(
				"format" => "json",
				"page" => "1",
				"total" => "6",
				"type" => "news",
				"sign" => "",
			);
			if(isset($_POST['page']) and ($_POST['page'] != "1" )){
				$post_data['page'] = $_POST['page'];
				$post_data['total'] = "10";
			}
			$time = time() + 3600*8;
			$days = (string)floor($time/86400);
			$type = "news";
			$temp = "iyuba".$days.$type;                           //解析爱语吧关于ajax生成的js代码的出来的sign的计算公式
			$referer = "http://www.iyuba.com/";
			$user_agent = "Mozilla/5.0 (Windows NT 10.0; …) Gecko/20100101 Firefox/60.0";
			$post_data['sign'] = (string)md5($temp);
			//$cookie = "JSESSIONID=CEA68843FEF8287600A…54B; Path=/dataapi/; HttpOnly";

			//curl_setopt($ch, CURLOPT_HTTPGET, true);
			curl_setopt($ch,CURLOPT_URL,$url);     //设置网页访问的url
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);  //设置User-Agent
			curl_setopt ($ch, CURLOPT_REFERER, $referer);        //设置referfer
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);   //执行后不直接打印出来
			//curl_setopt($ch,CURLOPT_HTTPHEADER,self::$header); //设置header信息
			curl_setopt($ch, CURLOPT_HEADER, false); //返回response头部信息
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);   //允许你查看请求header
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch, CURLOPT_TIMEOUT,10);   //只需要设置一个秒的数量就可以  
			curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($post_data));
			//curl_setopt($ch, CURLOPT_COOKIE, $cookie); 
			$data = curl_exec($ch);
			//var_dump(curl_getinfo($ch));
			curl_close($ch);
			//echo time();
			//echo $post_data['sign'];
			echo $data;
		}
		//获取头条内容
		public function get_text(){
			$ch = curl_init();
			$url = "http://cms.iyuba.com/dataapi/jsp/getText.jsp";
			$post_data = array(
				"id" => "62075",
				"type" => "news",
				"format" => "json",
				"sign" => "",
			);
			
			$time = time() + 3600*8;
			$days = (string)floor($time/86400);
			$type = "news";
			if(isset($_POST['id'])){
				$post_data['id'] = $_POST['id'];
			}
			else{
				var_dump($_POST);
			}
			$temp = "iyuba".$days.(string)$post_data['id']."news";                           //解析爱语吧关于ajax生成的js代码的出来的sign的计算公式
			$referer = "http://www.iyuba.com/newdetail.jsp?type=news&id=62077&name=%E8%8B%B1%E8%AF%AD%E5%A4%B4%E6%9D%A1";
			$user_agent = "Mozilla/5.0 (Windows NT 10.0; …) Gecko/20100101 Firefox/60.0";
			$post_data['sign'] = (string)md5($temp);
			//$cookie = "JSESSIONID=CEA68843FEF8287600A…54B; Path=/dataapi/; HttpOnly";

			//curl_setopt($ch, CURLOPT_HTTPGET, true);
			curl_setopt($ch,CURLOPT_URL,$url);     //设置网页访问的url
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);  //设置User-Agent
			curl_setopt($ch, CURLOPT_REFERER, $referer);        //设置referfer
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);   //执行后不直接打印出来
			curl_setopt($ch,CURLOPT_HTTPHEADER,self::$header); //设置header信息
			curl_setopt($ch, CURLOPT_HEADER, false); //返回response头部信息
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);   //允许你查看请求header
			curl_setopt($ch, CURLOPT_TIMEOUT,5);   //只需要设置一个秒的数量就可以  
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($post_data));
			//curl_setopt($ch, CURLOPT_COOKIE, $cookie); 
			$data = curl_exec($ch);
			//var_dump(curl_getinfo($ch));
			curl_close($ch);
			//echo time();
			//echo $post_data['sign'];
			//echo http_build_query($post_data);
			echo $data;

		}
		//获取音频列表
		public function get_voices(){
			$ch = curl_init();
			$url = "http://cms.iyuba.com/dataapi/jsp/getTitle.jsp";
			$post_data = array(
				"format" => "json",
				"page" => "1",
				"total" => "4",
				"type" => "voa,csvoa,song",
				"sign" => "",
			);
			if(isset($_POST['page']) and ($_POST['page'] != "1" )){
				$post_data['page'] = $_POST['page'];
				$post_data['total'] = "10";
			}
			$time = time() + 3600*8;
			$days = (string)floor($time/86400);
			$type = "voa,csvoa,song";
			$temp = "iyuba".$days.$type;                           //解析爱语吧关于ajax生成的js代码的出来的sign的计算公式
			$referer = "http://www.iyuba.com/new.jsp?type=voa,csvoa,song";
			$user_agent = "Mozilla/5.0 (Windows NT 10.0; …) Gecko/20100101 Firefox/60.0";
			$post_data['sign'] = (string)md5($temp);
			//$cookie = "JSESSIONID=CEA68843FEF8287600A…54B; Path=/dataapi/; HttpOnly";

			//curl_setopt($ch, CURLOPT_HTTPGET, true);
			curl_setopt($ch,CURLOPT_URL,$url);     //设置网页访问的url
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);  //设置User-Agent
			curl_setopt ($ch, CURLOPT_REFERER, $referer);        //设置referfer
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);   //执行后不直接打印出来
			//curl_setopt($ch,CURLOPT_HTTPHEADER,self::$header); //设置header信息
			curl_setopt($ch, CURLOPT_HEADER, false); //返回response头部信息
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);   //允许你查看请求header
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch, CURLOPT_TIMEOUT,10);   //只需要设置一个秒的数量就可以  
			curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($post_data));
			//curl_setopt($ch, CURLOPT_COOKIE, $cookie); 
			$data = curl_exec($ch);
			//var_dump(curl_getinfo($ch));
			curl_close($ch);
			//echo time();
			//echo $post_data['sign'];
			echo $data;
		}
		//获取音频内容
		public function get_voice_text(){
			$ch = curl_init();
			$url = "http://cms.iyuba.com/dataapi/jsp/getText.jsp";
			$post_data = array(
				"id" => "6688",
				"type" => "voa",
				"format" => "json",
				"sign" => "",
			);
			
			$time = time() + 3600*8;
			$days = (string)floor($time/86400);
			if((isset($_POST['id']))){
				$post_data['id'] = $_POST['id'];
				$post_data['type'] = $_POST['type'];
			}
			else{
				var_dump($_POST);
			}
			$temp = "iyuba".$days.(string)$post_data['id'].(string)$post_data['type'];                           //解析爱语吧关于ajax生成的js代码的出来的sign的计算公式
			$referer = "http://www.iyuba.com/new.jsp?type=voa,csvoa,song";
			$user_agent = "Mozilla/5.0 (Windows NT 10.0; …) Gecko/20100101 Firefox/60.0";
			$post_data['sign'] = (string)md5($temp);
			//$cookie = "JSESSIONID=CEA68843FEF8287600A…54B; Path=/dataapi/; HttpOnly";

			//curl_setopt($ch, CURLOPT_HTTPGET, true);
			curl_setopt($ch,CURLOPT_URL,$url);     //设置网页访问的url
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);  //设置User-Agent
			curl_setopt($ch, CURLOPT_REFERER, $referer);        //设置referfer
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);   //执行后不直接打印出来
			curl_setopt($ch,CURLOPT_HTTPHEADER,self::$header); //设置header信息
			curl_setopt($ch, CURLOPT_HEADER, false); //返回response头部信息
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);   //允许你查看请求header
			curl_setopt($ch, CURLOPT_TIMEOUT,5);   //只需要设置一个秒的数量就可以  
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($post_data));
			//curl_setopt($ch, CURLOPT_COOKIE, $cookie); 
			$data = curl_exec($ch);
			//var_dump(curl_getinfo($ch));
			curl_close($ch);
			//echo time();
			echo $data;

		}
		//获取视频列表
		public function get_movies(){
			$ch = curl_init();
			$url = "http://cms.iyuba.com/dataapi/jsp/getTitle.jsp";
			$post_data = array(
				"format" => "json",
				"page" => "1",
				"total" => "4",
				"type" => "voavideo,ted,meiyu",
				"sign" => "",
			);
			if(isset($_POST['page']) and ($_POST['page'] != "1" )){
				$post_data['page'] = $_POST['page'];
			}
			$time = time() + 3600*8;
			$days = (string)floor($time/86400);
			$type = "voavideo,ted,meiyu";
			$temp = "iyuba".$days.$type;                           //解析爱语吧关于ajax生成的js代码的出来的sign的计算公式
			$referer = "http://www.iyuba.com/new.jsp?type=voavideo,ted,meiyu";
			$user_agent = "Mozilla/5.0 (Windows NT 10.0; …) Gecko/20100101 Firefox/60.0";
			$post_data['sign'] = (string)md5($temp);
			//$cookie = "JSESSIONID=CEA68843FEF8287600A…54B; Path=/dataapi/; HttpOnly";

			//curl_setopt($ch, CURLOPT_HTTPGET, true);
			curl_setopt($ch,CURLOPT_URL,$url);     //设置网页访问的url
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);  //设置User-Agent
			curl_setopt ($ch, CURLOPT_REFERER, $referer);        //设置referfer
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);   //执行后不直接打印出来
			//curl_setopt($ch,CURLOPT_HTTPHEADER,self::$header); //设置header信息
			curl_setopt($ch, CURLOPT_HEADER, false); //返回response头部信息
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);   //允许你查看请求header
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch, CURLOPT_TIMEOUT,10);   //只需要设置一个秒的数量就可以  
			curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($post_data));
			//curl_setopt($ch, CURLOPT_COOKIE, $cookie); 
			$data = curl_exec($ch);
			//var_dump(curl_getinfo($ch));
			curl_close($ch);
			//echo time();
			//echo $post_data['sign'];
			echo $data;
		}
		public function get_movie_text(){
			$ch = curl_init();
			$url = "http://cms.iyuba.com/dataapi/jsp/getText.jsp";
			$post_data = array(
				"id" => "9269",
				"type" => "voavideo",
				"format" => "json",
				"sign" => "",
			);
			
			$time = time() + 3600*8;
			$days = (string)floor($time/86400);
			if((isset($_POST['id']))){
				$post_data['id'] = $_POST['id'];
				$post_data['type'] = $_POST['type'];
			}
			else{
				var_dump($_POST);
			}
			$temp = "iyuba".$days.(string)$post_data['id'].(string)$post_data['type'];                           //解析爱语吧关于ajax生成的js代码的出来的sign的计算公式
			$referer = "http://www.iyuba.com/new.jsp?type=voa,csvoa,song";
			$user_agent = "Mozilla/5.0 (Windows NT 10.0; …) Gecko/20100101 Firefox/60.0";
			$post_data['sign'] = (string)md5($temp);
			//$cookie = "JSESSIONID=CEA68843FEF8287600A…54B; Path=/dataapi/; HttpOnly";

			//curl_setopt($ch, CURLOPT_HTTPGET, true);
			curl_setopt($ch,CURLOPT_URL,$url);     //设置网页访问的url
			curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);  //设置User-Agent
			curl_setopt($ch, CURLOPT_REFERER, $referer);        //设置referfer
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);   //执行后不直接打印出来
			curl_setopt($ch,CURLOPT_HTTPHEADER,self::$header); //设置header信息
			curl_setopt($ch, CURLOPT_HEADER, false); //返回response头部信息
			curl_setopt($ch, CURLINFO_HEADER_OUT, true);   //允许你查看请求header
			curl_setopt($ch, CURLOPT_TIMEOUT,5);   //只需要设置一个秒的数量就可以  
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($post_data));
			//curl_setopt($ch, CURLOPT_COOKIE, $cookie); 
			$data = curl_exec($ch);
			//var_dump(curl_getinfo($ch));
			curl_close($ch);
			//echo time();
			echo $data;

		}
	}

