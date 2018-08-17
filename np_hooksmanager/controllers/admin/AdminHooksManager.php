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



class AdminHooksManagerController extends ModuleAdminController
{

    public function __construct()
    {
        $this->context = Context::getContext();
        $this->table = 'hook';
        $this->className = 'Hook';

        $this->lang = false;
        $this->bootstrap = true;
        $this->deleted = true;
        $this->explicitSelect = true;

        $this->addRowAction('edit');
        $this->addRowAction('delete');

        $this->allow_export= true;


        if (!Tools::getValue('realedit')) {
            $this->deleted = false;
        }

        $this->bootstrap = true;

        parent::__construct();

        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'icon' => 'icon-trash',
                'confirm' => $this->l('Delete selected items?')
            ),
        );

        $this->fields_list = array(
            'id_hook' => array(
                'title' => $this->l('Id'),
                'align' => 'center',
                'width' => 30
            ),
            'name' => array(
                'title' => $this->l('Name'),
                'width' => 'center',
            ),
            'title' => array(
                'title' => $this->l('Title'),
                'width' => 500,

            ),
            'description' => array(
                'title' => $this->l('Description'),
                'width' => 'center'
            ),

        );
    }



    public function renderForm()
    {

        if (!($obj = $this->loadObject(true)))
            return;

        $idShop = Context::getContext()->shop->id;

        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Add new Hook'),
            ),
            'input' => array(

                array(
                    'type' => 'text',
                    'label' => $this->l('Hook Name:'),
                    'name' => 'name',
                    'required' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Hook Title'),
                    'name' => 'title',

                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Hook Description'),
                    'name' => 'description',
                ),

                array(
                    'type' => 'switch',
                    'label' => $this->l('Visibility'),
                    'name' => 'position',
                    'class' => 'fixed-width-lg',
                    'required' => false,
                    'values' => array(
                        array(
                            'id' => 'active_on',
                            'value' => 1,
                            'label' => $this->l('Enabled')
                        ),
                        array(
                            'id' => 'active_off',
                            'value' => 0,
                            'label' => $this->l('Disabled')
                        )
                    ),
                ),

            ),
            'submit' => array('title' => $this->l('Save')),
        );
        $this->fields_value = array('id_shop' => $idShop);

        return parent::renderForm();
    }

    public function processAdd()
    {
        if (Tools::isSubmit('submitAdd'.$this->table)) {
            $hook_name = trim(Tools::getValue('name'));

            if ($this->checkIfHookAlreadyExistInDatabase($hook_name)) {
                $this->errors[] = $this->trans('The hook name already exist', array(), 'Admin.Catalog.Notification');
            }

            $this->validateRules();
        }

        parent::processAdd();
    }

    public function processUpdate(){
        parent::processUpdate();
    }


    private function checkIfHookAlreadyExistInDatabase($hook_name){
        $sql = 'SELECT COUNT(*) FROM `'._DB_PREFIX_.'hook` WHERE `name`="'.pSQL($hook_name).'"';
        return (Db::getInstance()->getValue($sql) > 0 ) ? true : false;
    }








}