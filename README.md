# Kuaidi

目前市场上的快递接口开发程度非常低，此接口封装了快递100的接口方法，不用申请即可免费获取物流信息。

## 安装
```shell
composer require jiangxianli/kuaidi
```

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

      //㊉快递状态 string
      $state = $kuaidi->getState();
  
  
  ```
## License

MIT

