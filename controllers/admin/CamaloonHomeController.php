<?php

require_once("CamaloonPluginController.php");

class CamaloonHomeController extends CamaloonPluginController
{
    public function initContent()
    {
        parent::initContent();

        $this->renderTemplate($this->l('home'), array(
            'title' => $this->l('Camaloon Print on Demand')
        ));
    }
}
