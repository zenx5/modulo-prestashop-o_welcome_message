<?php
	

	if(!defined('_PS_VERSION_')) {
		exit;
	}	


	if( ! defined('ACTIVE_MODULE_FD') ){
		include_once 'classModuleFD.php';
	}
	
	class o_welcome_message extends ModuleFD{

		public $hooks = array();
		public $child = null;

		public function __construct(){
			$this->name = 'o_welcome_message';
			$this->tab = 'front_office_features';
			$this->version = '1.0.0';
			$this->author = 'Octavio Martinez';
			$this->need_instance = 0;
			$this->ps_versions_compliancy = [
				'min' => '1.6',
				'max' => _PS_VERSION_
			];
			$this->bootstrap = true;
			parent::__construct();
			
			$this->displayName = 'Welcome Message';
			$this->description = 'Muestra dos mensajes de bienvenida en el home';
			$this->confirmUninstall = 'Are you sure you want to Uninstall?';

			if(!Configuration::get('MYMODULE_NAME')) {
				$this->warning = 'No name provided';
			}
			
			$this->hooks[] = array('displayHome','1');
			$this->hooks[] = array('displayWrapperBottom','1');

		
		}


		/******************
		**** INSTALL ******
		*******************/

		public function install(){
			//$this->installTab();
			
			if(Shop::isFeatureActive()) {
				Shop::setContext(Shop::CONTEXT_ALL);
			}
			return parent::install() && $this->addHooks($this->hooks);
		}

		public function uninstall(){
			//$this->uninstallTab();
			return parent::uninstall() && $this->addHooks($this->hooks, false);
		}

		/****************
		**** HOOKS ******
		*****************/

		public function hookDisplayHome(){
			$this->context->smarty->assign([
				'id' => 1,
				'caption' => Configuration::get('caption_top'),
				'style_caption' => Configuration::get('style_top'),
				'hideable' => Configuration::get('hideable_top'),
				'message' => Configuration::get('top'),
			]);
			return $this->display(__FILE__,'views/templates/hook/message.tpl');
		}

		public function hookDisplayWrapperBottom(){
			$this->context->smarty->assign([
				'id' => 2,
				'caption' => Configuration::get('caption_bottom'),
				'style_caption' => Configuration::get('style_bottom'),
				'hideable' => Configuration::get('hideable_bottom'),
				'message' => Configuration::get('bottom'),
			]);
			return $this->display(__FILE__,'views/templates/hook/message.tpl');
		}

		/************************
		**** CONFIGURATION ******
		************************/

		public function getContent(){
			$output = null;
			if(Tools::isSubmit('submit')) {
				if(Configuration::updateValue('top', Tools::getValue('top'), true )&&
				Configuration::updateValue('hideable_top', Tools::getValue('hideable_top'))&&
				Configuration::updateValue('caption_top', Tools::getValue('caption_top'))&&
				Configuration::updateValue('style_top', Tools::getValue('style_top'))&&
				Configuration::updateValue('bottom', Tools::getValue('bottom'), true)&&
				Configuration::updateValue('hideable_bottom', Tools::getValue('hideable_bottom'))&&
				Configuration::updateValue('caption_bottom', Tools::getValue('hideable_bottom'))&& //Tools::getValue('caption_bottom')
				Configuration::updateValue('style_bottom', Tools::getValue('style_bottom'))){
					$output .= $this->displayConfirmation('Se actualizo la Configuracion del Modulo');
				}
			}
			return $output.$this->displayForm();
		}

		public function displayForm(){
			$lang = new Language((int)Configuration::get('PS_LANG_DEFAULT'));
			
			$inputs = array(
				array(
					'type' => 'textarea',
					'label' => $this->l('Mensaje superior'),
					'name' => 'top',
					'cols' => 60,
					'rows' => 20,
					'autoload_rte' => true,
					'required' => false,
				),
				array(
					'type' => 'checkbox',
					'label' => $this->l('Ocultable'),
					'name' => 'hideable_top',
					'values' => array(
						'query' => array(
							array( 'id' => 'active', 'name' => 'Activar', 'val' => 1),
						),
						'id' => 'id',
						'name' => 'name'
					),
					'required' => false,
				),
				array(
					'type' => 'text',
					'label' => $this->l('Texto del Boton'),
					'name' => 'caption_top',
					'size' => 100,
					'required' => false,
				),
				array(
					'type' => 'select',
					'label' => $this->l('Estilo del Boton'),
					'name' => 'style_top',
					'options' => array(
						'query' => array(
							array('id' => 'btn-primary', 'name' => 'Primary'),
							array('id' => 'btn-secondary', 'name' => 'Secondary'),
							array('id' => 'btn-success', 'name' => 'Success'),
							array('id' => 'btn-danger', 'name' => 'Danger'),
							array('id' => 'btn-warning', 'name' => 'Warning'),
							array('id' => 'btn-info', 'name' => 'Info'),
							array('id' => 'btn-light', 'name' => 'Light'),
							array('id' => 'btn-dark', 'name' => 'Dark'),
							array('id' => 'btn-white', 'name' => 'White'),
						),
						'id' => 'id',
						'name' => 'name',
					),
					'required' => false,
				),
				array(
					'type' => 'textarea',
					'label' => $this->l('Mensaje superior'),
					'name' => 'bottom',
					'cols' => 60,
					'rows' => 20,
					'autoload_rte' => true,
					'required' => false,
				),
				array(
					'type' => 'checkbox',
					'label' => $this->l('Ocultable'),
					'name' => 'hideable_bottom',
					'values' => array(
						'query' => array(
							array( 'id' => 'active', 'name' => 'Activar', 'val' => 1),
						),
						'id' => 'id',
						'name' => 'name'
					),
					'required' => false,
				),
				array(
					'type' => 'text',
					'label' => $this->l('Texto del Boton'),
					'name' => 'caption_bottom',
					'size' => 100,
					'required' => false,
				),
				array(
					'type' => 'select',
					'label' => $this->l('Estilo del Boton'),
					'name' => 'style_bottom',
					'options' => array(
						'query' => array(
							array('id' => 'btn-primary', 'name' => 'Primary'),
							array('id' => 'btn-secondary', 'name' => 'Secondary'),
							array('id' => 'btn-success', 'name' => 'Success'),
							array('id' => 'btn-danger', 'name' => 'Danger'),
							array('id' => 'btn-warning', 'name' => 'Warning'),
							array('id' => 'btn-info', 'name' => 'Info'),
							array('id' => 'btn-light', 'name' => 'Light'),
							array('id' => 'btn-dark', 'name' => 'Dark'),
							array('id' => 'btn-white', 'name' => 'White'),
						),
						'id' => 'id',
						'name' => 'name',
					),
					'required' => false,
				),
			);

			$fields_form = array(
				'form' => array(
		            'legend' => array(
						'title' => 'Titulo',
						'icon' => 'icon-cogs'
		            ),
		            'input' => $inputs, 
		            'submit' => array(
		                'name' => 'submit',
		                'title' => $this->trans('Save', array(), 'Admin.Actions')
		            ),
		        ),
        	);

        	$helper = new HelperForm();
	        $helper->module = $this;
	        $helper->table = $this->name;
	        $helper->token = Tools::getAdminTokenLite('AdminModules');
	        $helper->currentIndex = $this->getModuleConfigurationPageLink();
	        
	        $helper->default_form_language = $lang->id;
	        
	        $helper->title = $this->displayName;
	        $helper->show_toolbar = false;
	        $helper->toolbar_scroll = false;
	        
	        $helper->submit_action = 'submit';
	        

			$helper->identifier = $this->identifier;


	        $helper->tpl_vars = array(
	            'languages' => $this->context->controller->getLanguages(),
	            'id_language' => $this->context->language->id,    
	            'fields_value' => array( 
	            	'top' => Configuration::get('top'),
	            	'hideable_top' => Configuration::get('hideable_top'),
	            	'caption_top' => Configuration::get('caption_top'),
	            	'style_top' => Configuration::get('style_top'),
	            	'bottom' => Configuration::get('bottom'),
	            	'hideable_bottom' => 'hideable_bottom_active',//Configuration::get('hideable_bottom'),
	            	'caption_bottom' => Configuration::get('caption_bottom'),
	            	'style_bottom' => Configuration::get('style_bottom'),
	            )
	        );

	        return $helper->generateForm(array($fields_form));
		}


		/**************
		**** TABS ******
		***************/
		private function installTab(){
			return true;
			/*
			$response = true;

			$subTab = new Tab();
			$subTab->active = 1;
			$subTab->name = array();
			$subTab->class_name = 'OscLinkTab';
			$subTab->icon = 'menu';
			foreach (Language::getLanguages() as $lang) {
				$subTab->name[$lang['id_lang']] = 'Subcategories Cards';
			}

			$subTab->id_parent = (int)Tab::getIdFromClassName('AdminCatalog');
			$subTab->module = $this->name;
			$response &= $subTab->add();

			return $response;*/
		}

		private function uninstallTab(){
			return true;
			/*$response = true;
			$tab_id = (int)Tab::getIdFromClassName('OscLinkTab');
			if(!$tab_id){
				return true;
			}

			$tab = new Tab($tab_id);
			$response &= $tab->delete();
			return $response;*/
		}
	}
		