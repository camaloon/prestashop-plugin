<?php

require_once("BaseCamaloonAdminController.php");

class CamaloonConnectController extends BaseCamaloonAdminController
{
    public function initContent()
    {
        parent::initContent();
        $this->context->smarty->assign(array());
        $this->setTemplate('support.tpl');
    }
}
