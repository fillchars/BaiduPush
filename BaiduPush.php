<?php

namespace Baidupush;

class BaiduPush
{
    const ADD = 'urls';
    const UPDATE = 'update';
    const DELETE = 'del';
    protected $api = 'http://data.zz.baidu.com/%s?site=%s&token=%s';
    protected $site;
    protected $token;
    protected $entry = array(); // 待新增，更新，或删除条目

    public function __construct($site, $token, array $entry)
    {
        $this->site = $site;
        $this->token = $token;
        $this->entry = $entry;
    }

    /**
     * 推送数据
     */
    public function pushAdd()
    {
        $addApi = sprintf($this->api, self::ADD, $this->site, $this->token);
        return $this->action($addApi);
    }

    /**
     * 更新数据
     */
    public function pushUpdate()
    {
        $updateApi = sprintf($this->api, self::UPDATE, $this->site, $this->token);
        return $this->action($updateApi);
    }

    /**
     * 删除数据
     */
    public function pushDel()
    {
        $delApi = sprintf($this->api, self::DELETE, $this->site, $this->token);
        return $this->action($delApi);
    }

    /**
     * @param $api 推送、更新与删除的API
     * @return $result json
     */
    protected function action($api)
    {
        $ch = curl_init();
        $options =  array(
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $this->entry),
            CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
        );
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        return $result;
    }

}