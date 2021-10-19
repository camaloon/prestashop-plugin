<?php

require_once("CamaloonPluginController.php");

class CamaloonHomeController extends CamaloonPluginController
{
    public function initContent()
    {
        parent::initContent();

        $this->renderTemplate('home', array(
            'title' => 'Camaloon Print on Demand'
        ));
    }
}
