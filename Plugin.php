<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * OneAction apis：
 * 1. 支持 post 远程发布文章
 * @package OneAction
 * @author gogobody
 * @version 1.0.0
 * @link https://blog.gogobody.cn
 */

require(__DIR__ . DIRECTORY_SEPARATOR . "Action.php");

class OnePost_Plugin extends Widget_Archive implements Typecho_Plugin_Interface
{

    public static function activate()
    {
        // register apis
        // action method url : /action/oneapi
        Helper::addAction('oneapi', 'OnePost_Action');
    }

    public static function deactivate()
    {
        Helper::removeAction('oneapi');

    }

    public static function config(Typecho_Widget_Helper_Form $form)
    {

        /* for post article */
        $pattern = '1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLOMNOPQRSTUVWXYZ';
        for($i=0;$i<26;$i++)
        {
            $signkey .= $pattern[mt_rand(0,35)];    //生成php随机数
        }
        echo '<a href=\'https://github.com/gogobody/onecircle\' target=_blank>使用说明</a>';
        $username = new Typecho_Widget_Helper_Form_Element_Text("username", NULL, _t(''), _t('以下是对post article 的参数设置:<br> username(发送文章的账户名)'));
        $form->addInput($username);
        $password = new Typecho_Widget_Helper_Form_Element_Text('password', NULL, _t(''), _t('password'));
        $form->addInput($password);
        $key = new Typecho_Widget_Helper_Form_Element_Text('sign', NULL, _t($signkey), _t('sign(post验证参数)'));
        $form->addInput($key);
        /* end */
    }

    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
        // TODO: Implement personalConfig() method.
    }
}