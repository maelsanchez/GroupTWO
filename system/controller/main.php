<?php

use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\JsonResponse;


namespace GroupTWO\system\controller;

class main
{
    /* @var \phpbb\config\config */
    protected $config;

    /* @var \phpbb\controller\helper */
    protected $helper;

    /* @var \phpbb\language\language */
    protected $language;

    /* @var \phpbb\template\template */
    protected $template;

    /** @var \phpbb\user */
    protected $user;

    /** @var \phpbb\db\driver\driver_interface */
    protected $db;

    /** @var \phpbb\request\request */
    protected $request;

    /** @var \phpbb\config\config */
    protected $phpbb_root_path;

    protected $notification_manager;

    /** @var \phpbb\cache\service */
    protected $cache;

    /** @var \phpbb\event\dispatcher_interface */
    protected $dispatcher;

    /** @var \phpbb\pagination */
    protected $pagination;

    /*Setup the AOM sections ids*/
    const FORUM = 3;

    /**
     * Constructor
     *
     * @param \phpbb\config\config      $config
     * @param \phpbb\controller\helper  $helper
     * @param \phpbb\language\language  $language
     * @param \phpbb\template\template  $template
     * @param \phpbb\user               $user
     */
    public function __construct(\phpbb\config\config $config, \phpbb\controller\helper $helper, \phpbb\language\language $language, \phpbb\template\template $template, \phpbb\user $user, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, $phpbb_root_path, $php_ext, \phpbb\notification\manager $notification_manager, \phpbb\cache\service $cache, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\pagination $pagination)
    {
        $this->config   = $config;
        $this->helper   = $helper;
        $this->language = $language;
        $this->template = $template;
        $this->user = $user;
        $this->db = $db;
        $this->request = $request;
        $this->phpbb_root_path = $phpbb_root_path;
        $this->php_ext = $php_ext;
        $this->notification_manager = $notification_manager;
        $this->cache = $cache;
        $this->dispatcher = $dispatcher;
        $this->pagination = $pagination;
    }

    /**
     * Demo controller for route /demo/{name}
     *
     * @param string $name
     * @throws \phpbb\exception\http_exception
     * @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
     */
    public function handle($e)
    {
        // SQL REQUEST HERE


        $sql_ary = array(
            'images_post'     => $row['post_id'],
            'images_poster'   => $row['poster_id'],
            'images_user'     => $this->user->data['user_id'],
            'images_topic'    => $row['topic_id'],
            'images_id'       => ($row['forum_id'] == self::FORUM)? $images : 1,
            'images_time'     => time(),
            'images_attach'     => ($attach_id > 0)? $attach_id : 0,
            'name'              => $images[$imgs-1],
            'images_url'         => append_sid("{$this->phpbb_root_path}styles/" . rawurlencode($this->user->style['style_path']) . '/theme/images/imgs/' . str_replace(' ','_', $images[$imgs-1]) .'.png'),
            'images'             => ($row['forum_id'] == self::FORUM)? 'image': '',
            'count'             => ($row['forum_id'] == self::FORUM)? '2' : '1',
        );

        $this->notification_manager->add_notifications('GroupTWO.system.notification.type.images', $sql_ary);

        //RESPONSE HERE
    }
}