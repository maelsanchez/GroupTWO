<?php
/**
 *
 * Topic/Post Reactions. An extension for the phpBB 3.2.0 Forum Software package.
 * @author Steve <http://www.steven-clark.online/phpBB3-Extensions/>
 * @copyright (c) phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace GroupTWO\system\notification\type;

/**
 * Topic/Post Reactions. Notification class.
 */
class images extends \phpbb\notification\type\base
{

	/**
	 * Get notification type name
	 *
	 * @return string
	 */
	public function get_type()
	{
		return 'GroupTWO.system.notification.type.images';
	}

	//Thanks rxu = https://www.phpbb.com/community/viewtopic.php?f=461&t=2259916&p=13718356&hilit=notification_option#p13718356
	public static $notification_option = array(
		'lang'	=> 'NOTIFICATION_TYPE_GROUPTWO_IMAGES',
/*		'group'	=> 'NOTIFICATION_GROUP_POSTING',*/
	);

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\user_loader */
	protected $user_loader;

	/** @var \phpbb\config\config */
	protected $config;


	public function set_config(\phpbb\config\config $config)
	{
		$this->config = $config;
	}

	public function set_user_loader(\phpbb\user_loader $user_loader)
	{
		$this->user_loader = $user_loader;
	}

	public function set_controller_helper(\phpbb\controller\helper $helper)
	{
		$this->helper = $helper;
	}

	/**
	 * Is this type available to the current user (defines whether or not it will be shown in the UCP Edit notification options)
	 *
	 * @return bool True/False whether or not this is available to the user
	 */
	public function is_available()
	{
		//$this->auth->acl_get('u_disable_reactions')
		return true;
	}

	/**
	 * Get the id of the notification
	 *
	 * @param array $data The type specific data
	 *
	 * @return int Id of the notification
	 */
	public static function get_item_id($data)
	{
		return $data['images_id'];
	}

	/**
	 * Get the id of the parent
	 *
	 * @param array $data The type specific data
	 *
	 * @return int Id of the parent
	 */
	public static function get_item_parent_id($data)
	{
		return $data['images_post'];
	}

	/**
	 * Find the users who want to receive notifications
	 *
	 * @param array $data The type specific data
	 * @param array $options Options for finding users for notification
	 * 		ignore_users => array of users and user types that should not receive notifications from this type because they've already been notified
	 * 						e.g.: array(2 => array(''), 3 => array('', 'email'), ...)
	 *
	 * @return array
	 */
	public function find_users_for_notification($data, $options = array())
	{
		$options = array_merge(array(
			'ignore_users'		=> array(),
		), $options);

		$users = array($data['images_poster']);

		if (empty($users))
		{
			return array();
		}

		return $this->check_user_notification_options($users, $options);
	}

	/**
	 * Users needed to query before this notification can be displayed
	 *
	 * @return array Array of user_ids
	 */
	public function users_to_query()
	{
		return array($this->get_data('images_user'));
	}

	/**
	* Get the user's avatar
	*/
 	public function get_avatar()
	{
		return $this->user_loader->get_avatar($this->get_data('images_user'), true, true);
	}

 	/**
	 * Get the HTML formatted title of this notification
	 *
	 * @return string
	 */
	public function get_title()
	{
		return '<img src="'. $this->get_data('images_url') .'" class="images-notification" /> A user has sent you a "' . $this->get_data('name') .'" '. $this->get_data('images') ' (+' . $this->get_data('images') .')';
	}

	/**
	 * Get the url to this item
	 *
	 * @return string URL
	 */
	public function get_url()
	{
		$post_id = $this->get_data('images_post');
		$post_url = append_sid("{$this->phpbb_root_path}viewtopic.{$this->php_ext}?p=$post_id#p$post_id");

		return $post_url;
	}

	/**
	 * Get email template
	 *
	 * @return string|bool
	 */
	public function get_email_template()
	{
		/*return '@steve_postreactions/reaction_added';*/
		return false;
	}

	/**
	 * Get email template variables
	 *
	 * @return array
	 */
	public function get_email_template_variables()
	{
		return array();
		/*$post_id = $this->get_data('post_id');
		$post_url = generate_board_url() . '/' . "viewtopic.{$this->php_ext}?p=$post_id#p$post_id";

		$user_data = $this->user_loader->get_username($this->get_data('user_id'), 'username');

		return array(
			'POST_SUBJECT'		=> htmlspecialchars_decode(censor_text($this->get_data('post_subject'))),
			'REACTION'			=> htmlspecialchars_decode($this->get_data('reaction_type_title')),
			'REACTION_USER'		=> htmlspecialchars_decode($user_data),
			'U_VIEW_POST'		=> $post_url,
		);*/
	}

	/**
	 * Function for preparing the data for insertion in an SQL query
	 * (The service handles insertion)
	 *
	 * @param array $data The type specific data
	 * @param array $pre_create_data Data from pre_create_insert_array()
	 *
	 * @return array Array of data ready to be inserted into the database
	 */
	public function create_insert_array($data, $pre_create_data = array())
	{
		$this->set_data('user_id', $data['images_user']);
		$this->set_data('topic_id', $data['images_topic']);
		$this->set_data('images_id', $data['images_attach']);
		$this->set_data('post_id', $data['images_post']);
		$this->set_data('poster_id', $data['images_poster']);
		$this->set_data('attach_id', $data['images_attach']);

		parent::create_insert_array($data, $pre_create_data);
	}
}