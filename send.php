<?php
/**
 * Created by PhpStorm.
 * User: zhns_wy
 * Date: 2017/9/25
 * Time: 9:48
 */

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__.'/PHPMailer/Exception.php';
require __DIR__.'/PHPMailer/PHPMailer.php';
require __DIR__.'/PHPMailer/SMTP.php';


class Send
{
    /**
     * 发送者
     * @var array
     */
    private $_emailObject = [
        'email' => 'd0122@aliyun.com',
        'password' => '******',
        'name' => 'dome100@aliyun',
        'smtp_name' => 'aliyun',     # 服务器SMTP
    ];

    /**
     * 接收者
     * @var array
     */
    private $_toEmailObject = [
        ['email'=>'d0***@sina.com','name'=>'d0***@sina'],
        ['email'=>'810702654@qq.com','name'=>'d0***@小贱贱'],
    ];

    /**
     * 运行邮件发送
     */
    public function run()
    {
        $email = $this->_emailObject;
        $toEmail = $this->_toEmailObject;
        $subject = '【Dome100 官方网站发来的注册邮件】';
        $msgHTML = __DIR__.'/index.html';
        $bool = self::send_emailer($email,$toEmail,$subject,$msgHTML);
        print_r('<pre>');
        print_r($bool);
    }


    /**
     * 邮件发送
     * @param $emailObject
     * @param $toEmailObject
     * @param null $CCEmail
     * @param null $BCCEmail
     * @param null $files
     * @param $subject
     * @param $msgHTML
     * @return array
     */
    private static function send_emailer(
        $emailObject,$toEmailObject,$subject,
        $msgHTML, $CCEmail=null,$BCCEmail=null,$files=null)
    {

        $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
        try {
            //Server settings 服务器设置
            # Enable verbose debug output 是否开启debug模式 1 2 都是调试模式
            $mail->SMTPDebug = 0;
            # Set mailer to use SMTP 设置SMTP
            $mail->isSMTP();
            # Specify main and backup SMTP servers  设置SMTP 服务器地址
//            var_dump($mail->getHost($emailObject['smtp_name']));die;
            $mail->Host = $mail->getHost($emailObject['smtp_name']);
            # Enable SMTP authentication  是否需要授权
            $mail->SMTPAuth = true;
            # SMTP username  用户名称
            $mail->Username = $emailObject['email'];
            # SMTP password  用户密码
            $mail->Password = $emailObject['password'];
            # 更改默认编码
            $mail->CharSet = 'utf-8';
//            $mail->SMTPSecure = 'tls';      // Enable TLS encryption, `ssl` also accepted  加密方式
//            $mail->Port = 587;              // TCP port to connect to  使用端口

            //Recipients请求
            # 设置email 地址，名称
            $mail->setFrom($emailObject['email'], $emailObject['name']);
            foreach ($toEmailObject as $toEmail){
                # Add a recipient  接收方地址和名称
                $mail->addAddress($toEmail['email'], $toEmail['name']);
            }
            # 发送方email地址，名称
            $mail->addReplyTo($emailObject['email'], $emailObject['name']);
            # 抄送
            empty($CCEmail) ? '' : $mail->addCC($CCEmail);
            # 密码
            empty($BCCEmail) ? '' : $mail->addBCC($BCCEmail);

            //附件
            if ($files){
                # 添加多个附件
                foreach ($files as $file){
                    # 添加附件
                    $mail->addAttachment($file['file_path'], $file['file_name']);
                }
            }
            /* *
             * 内容
             * $mail->Body    = 'This is the HTML message body <b>in bold!</b>';  # 带HTML邮件格式
             * $mail->AltBody = 'This is the body in plain text for non-HTML mail clients'; # 不带HTML邮件格式
             * $mail->msgHTML(file_get_contents(__DIR__.'/'.$msgHTML)); # 使用html文件
             */
            # Set email format to HTML 是否使用HTML格式
            file_exists($msgHTML) ? $mail->isHTML(true) : $mail->isHTML(false);
            # 邮件主题
            $mail->Subject = $subject;
            # 使用HTML文件
            file_exists($msgHTML) ? $mail->msgHTML(file_get_contents($msgHTML)) : $mail->AltBody = $msgHTML;

            $mail->send();
            return ['status'=>'Success OK '];   # 成功状态
        } catch (Exception $e) {
            return ['status'=>'Mailer Error: ' . $mail->ErrorInfo]; #失败状态
        }
    }



}

$send = new Send();
$send->run();