<?php
/**
 * Account Block Module
 * Adds an account block to the displayNav2 hook
 */

if (!defined('_PS_VERSION_')) {
    exit;
}

class AccountBlock extends Module
{
    public function __construct()
    {
        $this->name = 'accountblock';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'dewwwe';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->trans('Account Block', [], 'Modules.Accountblock.Admin');
        $this->description = $this->trans('Adds an account block with login form or account links in the displayNav2 hook', [], 'Modules.Accountblock.Admin');
        $this->confirmUninstall = $this->trans('Are you sure you want to uninstall this module?', [], 'Modules.Accountblock.Admin');
    }

    public function install()
    {
        return parent::install() &&
            $this->registerHook('displayNav2') &&
            $this->registerHook('header');
    }

    public function uninstall()
    {
        return parent::uninstall();
    }

    /**
     * Use new translation system
     */
    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    public function hookHeader($params)
    {
        // Add CSS and JS files
        $this->context->controller->addCSS($this->_path . 'views/css/accountblock.css');
        $this->context->controller->addJS($this->_path . 'views/js/accountblock.js');
    }

    public function hookDisplayNav2($params)
    {
        $customer = $this->context->customer;
        $isLoggedIn = $customer->isLogged();
        
        if ($isLoggedIn) {
            // Customer is logged in - show account links
            $this->context->smarty->assign(array(
                'customer_name' => $customer->firstname . ' ' . substr($customer->lastname, 0, 1) . '.',
                'is_logged_in' => true,
                'account_url' => $this->context->link->getPageLink('my-account'),
                'orders_url' => $this->context->link->getPageLink('history'),
                'addresses_url' => $this->context->link->getPageLink('addresses'),
                'identity_url' => $this->context->link->getPageLink('identity'),
                'logout_url' => $this->context->link->getPageLink('index', true, null, 'mylogout'),
                'wishlist_url' => $this->context->link->getModuleLink('blockwishlist', 'lists', array(), true),
            ));
        } else {
            // Customer is not logged in - show login form
            $this->context->smarty->assign(array(
                'is_logged_in' => false,
                'login_url' => $this->context->link->getPageLink('authentication'),
                'register_url' => $this->context->link->getPageLink('authentication', true, null, 'create_account=1'),
                'authentication_url' => $this->context->link->getPageLink('authentication', true),
            ));
        }

        return $this->display(__FILE__, 'accountblock.tpl');
    }

}