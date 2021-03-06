<?php


class OnePost_Action extends Widget_Abstract_Contents implements Widget_Interface_Do
{

    public function action()
    {
        // this action is for /action/oneapi
        $request = Typecho_Request::getInstance();

        if ($request->isPost()) {
            $funcs = $request->get("route");
            if ($funcs == "postarticle") {
                $this->postArticle();
            }
        }
//        header("HTTP/1.1 404 OK");
        echo "unhandled params";
    }

    public function postArticle()
    {
        $options = Typecho_Widget::widget('Widget_Options')->plugin('OnePost');
        $request = Typecho_Request::getInstance();
        $title = $request->get('title');
        $text = $request->get('text');
        $key = $request->get('sign');
        $articleType = $request->get('articleType');
        $categoryMid = $request->get('categorymid');
        $signkey = $options->sign;
//        $mid = $options->mid;
        if ($key != $signkey) {
            die("验证失败");
        }
        // login user auth
        if ($request->get('username')) {
            $user = $request->get('username');
            $password = $request->get('password');
        } else {
            $user = $options->username;
            $password = $options->password;
        }
        if (!$this->user->hasLogin()) {
            if (!$this->user->login($user, $password, true)) { //使用特定的账号登陆
                die('登录失败');
            }
        }
        //填充文章的相关字段信息。
        $request->setParams(
            array(
                'title' => $title,
                'text' => $text,
                'fieldNames' => array('articleType'),
                'fieldTypes' => array('str'),
                'fieldValues' => array($articleType),
                'cid' => '',
                'do' => 'publish',
                'markdown' => '1',
                'date' => '',
                'category' => array($categoryMid),
                'tags' => '',
                'visibility' => 'publish',
                'password' => '',
                'allowComment' => '1',
                'allowPing' => '1',
                'allowFeed' => '1',
                'trackback' => '',
            )
        );
        //设置token，绕过安全限制
        $security = $this->widget('Widget_Security');
        $request->setParam('_', $security->getToken($this->request->getReferer()));
        //设置时区，否则文章的发布时间会查8H
        date_default_timezone_set('PRC');

        //执行添加文章操作
        $widgetName = 'Widget_Contents_Post_Edit';
        $reflectionWidget = new ReflectionClass($widgetName);

        if ($reflectionWidget->implementsInterface('Widget_Interface_Do')) {
            $this->widget($widgetName)->action();
            echo 'Successful';
        } else {
            echo 'error';
        }
    }
}