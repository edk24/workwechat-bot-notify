<?php

namespace yuxiaobo;

class WorkWechatBotNotify
{
    protected $key = '';
    protected $httpClient;

    /**
     * @param string $key 从webhook地址中获得
     */
    public function __construct(string $key)
    {
        $this->key = $key;
        $this->httpClient = new \GuzzleHttp\Client();
    }

    /**
     * 文件上传 (文件大小要求在 5b~20MB 之间, 有效期保存 3 天)
     *
     * @return string mediaId
     */
    public function uploadFile(mixed $path)
    {
        $type = gettype($path);

        if ($type == 'string') {
            $f = fopen($path, 'r');
        } else if ($type == 'resource') {
            $f = $path;
        }

        $url = sprintf('https://qyapi.weixin.qq.com/cgi-bin/webhook/upload_media?key=%s&type=file', $this->key);
        $response = $this->httpClient->post($url, ['multipart' => [
            [
                'name'     => 'file_name',
                'contents' => $f
            ]
        ]]);

        $body = json_decode($response->getBody()->getContents(), true);
        if (isset($body['errcode']) && $body['errcode'] != 0) {
            throw new \RuntimeException($body['errmsg']);
        }
       
        return $body['media_id'];
    }


    /**
     * 发送文件消息
     *
     * @param string $mediaId 文件ID, 请通过 uploadFile 上传获得
     * @return void
     * @throws RuntimeException
     */
    public function sendFile(string $mediaId)
    {
        $this->send([
            'msgtype'       => 'file',
            'file'          => [
                'media_id'      => $mediaId
            ]
        ]);
    }


    /**
     * 发送文本消息
     *
     * @param string $content 内容
     * @param array $mentionedList 欲艾特人用户名数组, 如: ['edk24', 'all']
     * @param array $mentionedMobileList 欲艾特人手机号, 如: ['18311548014', 'all']
     * @return void
     * @throws RuntimeException
     */
    public function sendText(string $content, array $mentionedList = [], array $mentionedMobileList = [])
    {
        $this->send([
            'msgtype'       => 'text',
            'text'          => [
                'content'               => $content,
                'mentioned_list'        => $mentionedList,
                'mentioned_mobile_list' => $mentionedMobileList
            ]
        ]);
    }


    /**
     * 发送 News 卡片
     *
     * @param string $title 标题
     * @param string $description 摘要
     * @param string $url 地址
     * @param string $picurl 图片
     * @return void
     * @throws RuntimeException
     */
    public function sendNews(string $title, string $description, string $url, string $picurl = '')
    {
        $this->send([
            'msgtype'       => 'news',
            'news'          => [
                'articles'  => [
                    [
                        'title'         => $title,
                        'description'   => $description,
                        'url'           => $url,
                        'picurl'        => $picurl
                    ]
                ]
            ]
        ]);
    }


    /**
     * 发送图片
     *
     * @param mixed $path 文件路径或者文件资源
     * @return void
     * @throws RuntimeException
     */
    public function sendImage(mixed $path)
    {
        $type = gettype($path);

        if ($type == 'string') {
            $f = fopen($path, 'r');
        } else if ($type == 'resource') {
            $f = $path;
        }

        // 移动文件头
        rewind($f);
        // 读取文件
        $data = '';
        while (!feof($f)) {
            $data .= fgets($f);
        }
        fclose($f);

        $this->send([
            'msgtype'       => 'image',
            'image'         => [
                'base64'        => base64_encode($data),
                'md5'           => md5($data)
            ]
        ]);
    }


    /**
     * 发送 Markdown 消息
     *
     * @param string $content
     * @return void
     * @throws RuntimeException
     */
    public function sendMarkdown(string $content)
    {
        $this->send([
            'msgtype'       => 'markdown',
            'markdown'          => [
                'content'               => $content,
            ]
        ]);
    }

    /**
     * 发送消息 (自定义)
     *
     * @param array $body
     * @return array
     * @throws RuntimeException
     */
    public function send(array $body): array
    {
        $url = sprintf('https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=%s', $this->key);
        $response = $this->httpClient->post($url, array(
            'json'  => $body
        ));

        $body = json_decode($response->getBody()->getContents(), true);
        if (isset($body['errcode']) && $body['errcode'] != 0) {
            throw new \RuntimeException($body['errmsg']);
        }

        return $body;
    }
}