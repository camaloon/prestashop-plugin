<?php

require_once("CamaloonPluginController.php");

class CamaloonHomeController extends CamaloonPluginController
{
    public function initContent()
    {
        parent::initContent();

        // $this->addCSS(_PS_ADMIN_DIR_ . '/themes/new-theme/public/theme.css');
        // $this->addCSS($this->getCssPath('home.css'));

        $this->renderTemplate('home', array(
            'title' => 'Camaloon Print on Demand',
            'connectUrl' => $this->context->link->getAdminLink(Camaloon::CONNECT_CONTROLLER),
            'disconnectUrl' => $this->context->link->getAdminLink(Camaloon::CONNECT_CONTROLLER)
        ));
    }
}
