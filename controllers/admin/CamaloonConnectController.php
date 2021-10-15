<?php

require_once("CamaloonPluginController.php");

class CamaloonConnectController extends CamaloonPluginController
{
    public function initContent()
    {
        parent::initContent();

        $this->renderTemplate('connect', array(
            'title' => 'Camaloon Print on Demand',
            'connectUrl' => $this->context->link->getAdminLink(Camaloon::CONNECT_CONTROLLER),
            'disconnectUrl' => $this->context->link->getAdminLink(Camaloon::CONNECT_CONTROLLER)
        ));
    }
}
