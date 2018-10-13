<?php
/**
*
* @package phpBB Extension - Board magic
* @copyright (c) 2018 Solidjeuh - https://www.muziekpromo.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace solidjeuh\boardmagic\event;

/**
* @ignore
*/
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
* Event listener
*/
class listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;
	/** @var \phpbb\template\template */
	protected $template;

	/**
	* Constructor
	*
	* @param \phpbb\config\config		$config
	* @param \phpbb\template\template	$template
	*
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\template\template $template)
	{
		$this->config = $config;
		$this->template = $template;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.user_setup'		=> 'load_language_on_setup',
			'core.page_footer'		=> 'page_footer',
		);
	}

	public function load_language_on_setup($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'solidjeuh/boardmagic',
			'lang_set' => 'common',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}

	public function page_footer($event)
	{
		$start_date = @gmdate('Y', $this->config['board_startdate']);
		$this->template->assign_vars(array(
			'L_COPYRIGHT_YEAR'			=> $start_date,
		));
	}
}
