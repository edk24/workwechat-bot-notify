<?php

namespace yuxiaobo\tests;

use yuxiaobo\WorkWechatBotNotify;

use PHPUnit\Framework\TestCase;

define('ROOT_PATH', dirname(__DIR__));
$env = parse_ini_file('./.env');

class NotifyTest extends TestCase
{

    // 发送文本测试
    public function testSendText()
    {
        global $env;
        try {
            $notify = new WorkWechatBotNotify($env['key']);

            $notify->sendText('这是一个测试', [], ['18311548014']);

            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
        
    }


    // 发送 markdown 测试
    public function testSendMarkdown()
    {
        try {
            $notify = new WorkWechatBotNotify($env['key']);

            $notify->sendMarkdown("# 这是一个`Markdown`测试\n> 111");

            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
    }


    // 发送图片测试
    public function testSendImage()
    {
        try {
            $notify = new WorkWechatBotNotify($env['key']);

            // 文件资源
            $notify->sendImage(fopen(ROOT_PATH . '/tests/test.jpeg', 'r'));
            // 文件路径
            // $notify->sendImage(ROOT_PATH . '/tests/test.jpeg');
            $this->assertTrue(true);
        } catch(\Exception $e) {
            $this->assertTrue(false);
        }
    }

    // 发送 News 消息
    public function testSendNews()
    {
        try {
            $notify = new WorkWechatBotNotify($env['key']);
            $notify->sendNews('中秋节礼品领取', '欢度中秋佳节', 'doc.edk24.com', 'http://res.mail.qq.com/node/ww/wwopenmng/images/independent/doc/test_pic_msg1.png');
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
        
    }

    // 发送文件
    public function testSendFile()
    {
        try {
            $notify = new WorkWechatBotNotify($env['key']);

            $mediaId = $notify->uploadFile(fopen(ROOT_PATH . '/tests/test.jpeg', 'r'));
            $notify->sendFile($mediaId);
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
    }

}