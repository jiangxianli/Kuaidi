# Kuaidi for Laravel

目前市场上的快递接口开发程度非常低，此接口封装了快递100的接口方法，不用申请即可免费获取物流信息。

## 安装

环境要求：PHP     >= 5.4.0
          Laravel >= 4.2.0
1. 在composer.json中添加"jiangxianli/kuaidi":"dev-master".

  ```json
  "require": {
  	  "laravel/framework": "4.2.*",
  	  "..."
  	  "jiangxianli/kuaidi": "dev-master"
  },
  
  ```

2. 在app.php中添加'Jiangxianli\Kuaidi\KuaidiServiceProvider'， 并设置别名'Kuaidi'            => 'Jiangxianli\Kuaidis\Kuaidi'

  ```php
  <?php

  'providers' => array(

		'Illuminate\Foundation\Providers\ArtisanServiceProvider',
		......
		'Jiangxianli\Kuaidi\KuaidiServiceProvider',

	),
  'aliases' => array(
		'App'               => 'Illuminate\Support\Facades\App',
		......
		'Kuaidi'            => 'Jiangxianli\Kuaidis\Kuaidi',

	),
  ...
  ```
3.composer update -VVV


## 使用

  ```php
  <?php
  
      //实例化  Kuaidi（快递公司代码，物流单号）
      $kuaidi = new \Jiangxianli\Kuaidi\Kuaidi('huitongkuaidi','70025206275751');
  
      //㊀发送请求  Kuaidi
      $kuaidi = $kuaidi->logisticWithoutKey();
  
      //㊁快递公司代码 Array
      $companys = $kuaidi->getCompanyCodeList();
  
      /**********以下所有方法需在㊀后执行***********/
  
      //㊂完整物流信息 Array
      $data = $kuaidi->getData();
  
      //㊃物流转运信息 Array
      $logisticInfo = $kuaidi->getLogisticInfo();
  
      //㊄最新一条物流信息 Array
      $latestLogisticInfo = $kuaidi->latestLogisticInfo();
  
      //㊅请求状态 bool
      $status = $kuaidi->getStatus();
  
      //㊆错误信息 string
      $message = $kuaidi->getMessage();
  
      //㊇是否已经签收
      $ischeck = $kuaidi->isChecked();
  
      //㊈最新更新时间 string (Y-m-d H:i:s)
      $latestUpdateTime = $kuaidi->latestUpdateTime();
  
  
  ```
## License

MIT

