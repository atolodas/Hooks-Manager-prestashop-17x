<?php
/**
 *  2018 Nextpointer.gr
 *
 *  NOTICE OF LICENSE
 *
 *  @author    Evanggelos L. Goritsas <vgoritsas@gmail.com>
 *  @copyright 2018 Nextpointer.gr
 *  @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *  @version   1.0.0
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class Np_hooksmanager extends Module
{

    public function __construct()
    {
        $this->name = 'np_hooksmanager';
        $this->tab = 'administration';
        $this->version = '1.0.0';
        $this->author = 'Evanggelos L. Goritsas';
        $this->need_instance = 0;

        $this->bootstrap = true;
        parent::__construct();

        $this->displayName = $this->l('Hooks manager');
        $this->description = $this->l('Manage hooks. Add and Remove any hook you want. ');

        $this->ps_versions_compliancy = array('min' => '1.7', 'max' => _PS_VERSION_);
    }


    public function install()
    {
       
		$this->adminInstall();
        return parent::install();
    }

    public function uninstall()
    {
   
		$this->adminUnistall();
        return parent::uninstall();
    }

	
	
    private function adminInstall(){
        if($idTab = Tab::getIdFromClassName('AdminParentThemes')){
            $tab = new Tab();
            $tab->class_name ='AdminHooksManager';
            $tab->module = $this->name;
            $tab->id_parent = $idTab;
            $languages = Language::getLanguages(false);
            foreach ($languages as $language) {
                $tab->name[$language['id_lang']] =  'Hooks Manager';
            }

           $tab->save();
        }

        return true;
    }


    private function adminUnistall(){
        $idFromClassName = Tab::getIdFromClassName('AdminHooksManager');
        $tab = new Tab($idFromClassName);
        $tab->delete();
    }
   
   

   
}
