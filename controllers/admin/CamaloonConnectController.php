<?php

require_once("BaseCamaloonAdminController.php");

class CamaloonConnectController extends BaseCamaloonAdminController
{
    public function initContent()
    {
        parent::initContent();
        $this->context->smarty->assign(array());
        $this->setTemplate('connect.tpl');
    }

    public function setMedia($isNewTheme = false)
    {
        $this->addCSS($this->module->getLocalPath() . 'views/css/connect.css');
        parent::setMedia($isNewTheme);
    }
}
