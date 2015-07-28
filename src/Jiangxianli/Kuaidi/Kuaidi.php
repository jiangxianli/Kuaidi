<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 15/7/28
 * Time: 10:57
 */

namespace Jiangxianli\Kuaidi;


class Kuaidi {

    private $data ;
    private $company_code ;
    private $logistic_num;
    private $status = 200 ;
    private $message = '';
    private $state = -1 ;

    public function __construct($company_code,$logistic_num){

        $this->company_code = $company_code;
        $this->logistic_num = $logistic_num;

    }

    /**
     * 无key方式访问
     * @return $this
     */
    public function logisticWithoutKey(){

        $temp = mt_rand() / mt_getrandmax();

        $url = 'http://www.kuaidi100.com/query?type='.$this->company_code.'&postid='.$this->logistic_num.'&id=1&valicode=&temp='.$temp;

        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/".self::randomIp()." Safari/536.11");

        $res = curl_exec($ch);
        curl_close($ch);

        $this->data = json_decode($res,true);

        if(is_array($this->data) && array_key_exists('status',$this->data)){

            $this->status = $this->data['status'];
        }

        if(is_array($this->data) && array_key_exists('message',$this->data)){

            $this->message = $this->data['message'];
        }

        if(is_array($this->data) && array_key_exists('state',$this->data)){

            $this->state = $this->data['state'];
        }

        return $this;

    }

    /**
     * 获取完整的数据信息
     * @return mixed
     */
    public function getData(){

        return $this->data;
    }

    /**
     * 获取物流信息
     * @return array
     */
    public function getLogisticInfo(){

        if(array_key_exists('data',$this->data)){

            return $this->data['data'];
        }
        return [];
    }

    /**
     * 是否已签收
     * @return bool
     */
    public function isChecked(){

        if(is_array($this->data) && array_key_exists('ischeck',$this->data)){

            return $this->data['ischeck'] ==  1 ;
        }

        return false;
    }

    /**
     * 最新更新时间
     */
    public function latestUpdateTime(){

        if(is_array($this->data) && array_key_exists('updatetime',$this->data)){

            return $this->data['updatetime']  ;
        }

        return null;

    }

    /**
     * 获取最新的一条物流信息
     * @return null
     */
    public function latestLogisticInfo(){

        $data = self::getLogisticInfo();

        if(isset($data) &&  is_array($data)){

            return $data[0];
        }

        return null;

    }

    /**
     * 接口获取状态
     * @return bool
     */
    public function getStatus(){

        return $this->status == 200 ;
    }

    /**
     * 获取消息
     * @return string
     */
    public function getMessage(){

        return $this->message;
    }

    /**
     *最常用的快递列表
     */
    public function getCompanyCodeList(){

        return array(

            'zhongtong' =>'中通快递',

            'yuantong' =>'圆通速递',

            'shentong' =>'申通快递',

            'yunda' =>'韵达快递',

            'shunfeng' =>'顺丰速运',

            'tiantian' =>'天天快递',

            'ems' =>'EMS',

            'zhaijisong' =>'宅急送',

            'suer' =>'速尔快递',

            'rufengda' =>'如风达',

            'quanfengkuaidi' =>'全峰快递',

            'debangwuliu' =>'德邦',

            'aae' =>'AAE全球专递',

            'aramex' =>'Aramex',

            'huitongkuaidi' =>'百世汇通',

            'youzhengguonei' =>'包裹信件',

            'bpost' =>'比利时邮政',

            'dhl' =>'DHL中国件',

            'fedex' =>'FedEx国际件',

            'vancl' =>'凡客配送',

            'fanyukuaidi' =>'凡宇快递',

            'fedexcn' =>'Fedex',

            'fedexus' =>'FedEx美国件',

            'guotongkuaidi' =>'国通快递',

            'koreapost' =>'韩国邮政',

            'jiajiwuliu' =>'佳吉快运',

            'jd' =>'京东快递',

            'canpost' =>'加拿大邮政',

            'jiayunmeiwuliu' =>'加运美',

            'jialidatong' =>'嘉里大通',

            'jinguangsudikuaijian' =>'京广速递',

            'kuayue' =>'跨越速递',

            'kuaijiesudi' =>'快捷速递',

            'minbangsudi' =>'民邦速递',

            'minghangkuaidi' =>'民航快递',

            'ocs' =>'OCS',

            'quanyikuaidi' =>'全一快递',

            'quanchenkuaidi' =>'全晨快递',

            'japanposten' =>'日本邮政',

            'shenganwuliu' =>'圣安物流',

            'shenghuiwuliu' => '盛辉物流',

            'tnt' =>'TNT',

            'ups' =>'UPS',

            'usps' =>'USPS',

            'wanxiangwuliu' =>'万象物流',

            'xinbangwuliu' =>'新邦物流',

            'xinfengwuliu' =>'信丰物流',

            'youshuwuliu' =>'优速物流',

            'yuanchengwuliu' =>'远成物流',

            'ytkd' =>'运通中港快递',

            'ztky' =>'中铁物流',

            'zengyisudi' =>'增益速递',
        );
    }

    /**
     * 快递状态
     * @return string
     */
    public function getState(){
        switch($this->state){
            case '0':
                return '运送中';
            case '1':
                return '已揽件';
            case '2':
                return '寄送故障';
            case '3':
                return '签收成功';
            case '4':
                return '已退签';
            case '5':
                return '派件中';
            case '6':
                return '退回中';
            default:
                return '无';

        }
//        0：在途，即货物处于运输过程中；
//        1：揽件，货物已由快递公司揽收并且产生了第一条跟踪信息；
//        2：疑难，货物寄送过程出了问题；
//        3：签收，收件人已签收；
//        4：退签，即货物由于用户拒签、超区等原因退回，而且发件人已经签收；
//        5：派件，即快递正在进行同城派件；
//        6：退回，货物正处于退回发件人的途中；
    }




    /**
     * 获取国内随机IP地址
     * 注：适用于32位操作系统
     */
    protected  function randomIp(){

        $ip_long = array(
            array('607649792', '608174079'), //36.56.0.0-36.63.255.255
            array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
            array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
            array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
            array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
            array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
            array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
            array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
            array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
            array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
        );
        $rand_key = mt_rand(0, 9);
        $ip       = long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
        return $ip;
    }



} 