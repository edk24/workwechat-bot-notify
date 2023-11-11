# 企业微信机器人通知SDK

## 安装

```bash
composer require yuxiaobo/workwechat-bot-notify
```

## 如何使用

### 发送文本消息

```php
$notify = new WorkWechatBotNotify($_ENV['key']);
$notify->sendText('这是一个测试', [], ['18311548014']);
```

### 发送 Markdown 消息

```php
$notify = new WorkWechatBotNotify($_ENV['key']);
$notify->sendMarkdown("# 这是一个`Markdown`测试\n> 111");
```


### 发送图片消息

```php
$notify = new WorkWechatBotNotify($_ENV['key']);

// 文件资源
$notify->sendImage(fopen(ROOT_PATH . '/tests/test.jpeg', 'r'));
// 或文件路径
// $notify->sendImage(ROOT_PATH . '/tests/test.jpeg');
```

### 发送 News 卡片

```php
$notify = new WorkWechatBotNotify($_ENV['key']);
$notify->sendNews('中秋节礼品领取', '欢度中秋佳节', 'doc.edk24.com', 'http://res.mail.qq.com/node/ww/wwopenmng/images/independent/doc/test_pic_msg1.png');
```

### 发送文件

```php
$notify = new WorkWechatBotNotify($_ENV['key']);
$mediaId = $notify->uploadFile(fopen(ROOT_PATH . '/tests/test.jpeg', 'r'));
$notify->sendFile($mediaId);
```


## 其他说明

### 单元测试

复制 `.env.example` 到 `.env` 并配置 `key`

```bash
$ composer test
PHPUnit 9.6.13 by Sebastian Bergmann and contributors.

.....                                                               5 / 5 (100%)

Time: 00:02.138, Memory: 6.00 MB

OK (5 tests, 5 assertions)
```
