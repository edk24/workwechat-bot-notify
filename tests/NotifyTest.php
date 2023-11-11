<?php

namespace yuxiaobo\tests;

// require_once __DIR__ . '/../vendor/autoload.php';
use yuxiaobo\WorkWechatBotNotify;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Dotenv\Dotenv;

define("ROOT_PATH", dirname(__DIR__) . "/");

$env = new Dotenv();
$env->load(ROOT_PATH . '/.env');

class NotifyTest extends TestCase
{

    // 发送文本测试
    public function testSendText()
    {
        try {
            $notify = new WorkWechatBotNotify($_ENV['key']);

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
            $notify = new WorkWechatBotNotify($_ENV['key']);

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
            $notify = new WorkWechatBotNotify($_ENV['key']);

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
            $notify = new WorkWechatBotNotify($_ENV['key']);
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
            $notify = new WorkWechatBotNotify($_ENV['key']);

            $mediaId = $notify->uploadFile(fopen(ROOT_PATH . '/tests/test.jpeg', 'r'));
            $notify->sendFile($mediaId);
            $this->assertTrue(true);
        } catch (\Exception $e) {
            $this->assertTrue(false);
        }
    }

}