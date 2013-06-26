<?php
/**
 * Answer and Win 
 *
 * @category   	Front Office Features
 * @author     	Vincent G. vinvin.me
 * @copyright  	2013 Vinvin
 * @version   	1.0	
 * @link       	http://www.vinvin.me
 * @since      	File available since Release 1.0
*/


// Security
if (!defined('_PS_VERSION_'))
	exit;
	
// Checking compatibility with older PrestaShop and fixing it
if (!defined('_MYSQL_ENGINE_'))
	define('_MYSQL_ENGINE_', 'MyISAM');

// Loading Models
require_once(_PS_MODULE_DIR_ . 'AnswerAndWin/models/Question.php');

class AnswerAndWin extends Module
{			
  public function __construct()
  {  		  	
	  $this->name = 'Answer And Win';
	  $this->tab = 'front_office_features';
	  $this->version = '1.4';
	  $this->ps_versions_compliancy['min'] = '1.5.0.1'; 
		$this->author = 'Vincent G.';
		$this->need_instance = 0;
	
	  parent::__construct();
	
		$this->displayName = $this->l('Answer And Win');
	  $this->description = $this->l('Ask questions and offer a voucher ');
	  	  
		$this->confirmUninstall = $this->l('Are you sure you want to delete this module ?');
	  
// 	  if ($this->active && Configuration::get('EXAMPLE_CONF') == '')
// 			$this->warning = $this->l('You have to configure your module');
  }
  

	public function install()
	{
		// Install SQL
		include(dirname(__FILE__).'/sql/install.php');
		foreach ($sql as $s)
			if (!Db::getInstance()->execute($s))
				return false;
								
// 		// Install Tabs
		$parent_tab = new Tab();
		$parent_tab->name = 'Questions and Win';
		$parent_tab->class_name = 'AdminMainExample';
		$parent_tab->id_parent = 2;
		$parent_tab->module = $this->name;
		$parent_tab->add();
		
		
		$tab = new Tab();
		$tab->name = 'Questions and Win ';
		$tab->class_name = 'AdminExample';
		$tab->id_parent = $parent_tab->id;
		$tab->module = $this->name;
		$tab->add();
		
		
		//Init
		Configuration::updateValue('EXAMPLE_CONF', '');	
		
		// Install Module  
   	return parent::install()
		&& $this->registerHook('displayRightColumn') && $this->registerHook('displayLeftColumn') ;					
  }    
  
  public function uninstall()
	{
		// Uninstall SQL
		include(dirname(__FILE__).'/sql/uninstall.php');
		foreach ($sql as $s)
			if (!Db::getInstance()->execute($s))
				return false;
				
		Configuration::deleteByName('EXAMPLE_CONF');

		// Uninstall Tabs
		$tab = new Tab((int)Tab::getIdFromClassName('AdminExample'));
		$tab->delete(); 
	  $tab = new Tab((int)Tab::getIdFromClassName('AdminMainExample'));
	  $tab->delete();
		
		// Uninstall Module
		if (!parent::uninstall() ||
		    !$this->unregisterHook('displayRightColumn')
		    || !$this->unregisterHook('displayLeftColumn'))
			return false;

		return true;
	}
	
	public function getContent()
	{
		return $this->processForm().$this->displayForm();
	}
	
	private function processForm()
	{
		$output = '';
		if (Tools::isSubmit('submit'.ucfirst($this->name)))
		{
			$EXAMPLE_CONF = Tools::getValue('EXAMPLE_CONF');
			
			Configuration::updateValue('EXAMPLE_CONF', $EXAMPLE_CONF);
			
			$output .= $this->displayConfirmation($this->l('Settings updated'));
		}
		
		return $output;
	}
	
	public function displayForm()
	{		
		if(isset($errors))
			$this->context->smarty->assign('errors', $errors);
		
		//$this->context->smarty->assign('request_uri', $this-);
		$this->context->smarty->assign('request_uri', Tools::safeOutput($_SERVER['REQUEST_URI']));
		$this->context->smarty->assign('path', $this->_path);
		$this->context->smarty->assign('EXAMPLE_CONF', pSQL(Tools::getValue('EXAMPLE_CONF', Configuration::get('EXAMPLE_CONF'))));
		$this->context->smarty->assign('submitName', 'submit'.ucfirst($this->name));
		
		return $this->display(__FILE__, 'views/templates/admin/configure.tpl');
	}
	
	public function hookDisplayLeftColumn($params)
	{
	  return $this->hookDisplayRightColumn($params);
	}
	public function hookDisplayRightColumn($params)
	{
		
		return $this->display(__FILE__, 'foWin.tpl');
	}
}
