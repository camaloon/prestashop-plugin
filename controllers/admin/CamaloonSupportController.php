<?php

require_once("CamaloonPluginController.php");

class CamaloonSupportController extends CamaloonPluginController
{
    public function initContent()
    {
        parent::initContent();

        // $this->addCSS(_PS_ADMIN_DIR_ . '/themes/new-theme/public/theme.css');
        // $this->addCSS($this->getCssPath('home.css'));

        $this->renderTemplate('support', array(
            'title' => 'Support'
        ));
    }
}
