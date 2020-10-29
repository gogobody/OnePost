# OnePost
typecho 远程 post 发布文件接口插件

## 使用方法：
上传启用插件，然后在设置里配置默认发布的用户，建议用户权限为编辑
使用随机的sign 或者设置您独有的sign

## 通过post发表文章：

请求URL：  

你的网址/action/oneapi  

请求方式：

POST  

## 参数
参数：

|参数名|必选|类型|说明|
|:----    |:---|:----- |-----   |
|route |  是  |    string   |    值为 postarticle   |
|sign |  是  |    string   |    验证密钥 (后台设置的)  |
|title |  是  |    string   |    标题   |
|text |  是  |    string   |    正文   |
|articleType |  否  |    string   |    onecircle主题专用字段（没有不用配置）   |
|categorymid |  否  |    string   |   分类mid     |
|fieldnames |  否  |    反序列化数组   |    自定义字段名   |
|fieldtypes |  否  |    反序列化数组   |    自定义字段类型，一般为str   |
|fieldvalues |  否  |    反序列化数组   |    自定义字段内容   |


## 例子
php  
```
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "http://typecho/action/oneapi",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => array('route' => 'postarticle','sign' => '2ge8ddqphlts2ofhrx0t32j6qp','title' => '测试title','text' => 'content text','articleType' => 'default','categorymid' => '1'),
  CURLOPT_HTTPHEADER => array(
    "Content-Type: application/x-www-form-urlencoded",
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

```


jquery  
```
var form = new FormData();
form.append("route", "postarticle");
form.append("sign", "2ge8ddqphlts2ofhrx0t32j6qp");
form.append("title", "测试title");
form.append("text", "content text");
form.append("articleType", "default");
form.append("categorymid", "1");

var settings = {
  "url": "http://typecho/action/oneapi",
  "method": "POST",
  "timeout": 0,
  "headers": {
    "Content-Type": "application/x-www-form-urlencoded",
  },
  "processData": false,
  "mimeType": "multipart/form-data",
  "contentType": false,
  "data": form
};

$.ajax(settings).done(function (response) {
  console.log(response);
});
```
