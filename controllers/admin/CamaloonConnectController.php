<?php

require_once("CamaloonPluginController.php");

class CamaloonConnectController extends CamaloonPluginController
{
    public function initContent()
    {
        parent::initContent();

        $this->renderTemplate('connect', array(
            'title' => 'Connect your store',
        ));
    }
}
