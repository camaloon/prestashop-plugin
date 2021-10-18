<?php

require_once("CamaloonPluginController.php");

class CamaloonStatusController extends CamaloonPluginController
{
    public function initContent()
    {
        parent::initContent();

        $this->renderTemplate('status', array(
            'title' => 'Status'
        ));
    }
}
