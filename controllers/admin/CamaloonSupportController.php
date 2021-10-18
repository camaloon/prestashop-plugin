<?php

require_once("CamaloonPluginController.php");

class CamaloonSupportController extends CamaloonPluginController
{
    public function initContent()
    {
        parent::initContent();

        $this->renderTemplate('support', array(
            'title' => 'Support'
        ));
    }
}
