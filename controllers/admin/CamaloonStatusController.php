<?php

require_once("CamaloonPluginController.php");

class CamaloonStatusController extends CamaloonPluginController
{
    public function initContent()
    {
        parent::initContent();

        // $this->addCSS(_PS_ADMIN_DIR_ . '/themes/new-theme/public/theme.css');
        // $this->addCSS($this->getCssPath('home.css'));

        $this->renderTemplate('status', array(
            'title' => 'Status'
        ));
    }
}
