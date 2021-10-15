<?php

require_once("CamaloonPluginController.php");

class CamaloonConnectController extends CamaloonPluginController
{
    public function initContent()
    {
        parent::initContent();
        $connected = false;

        $this->renderTemplate('connect', array(
            'title' => 'Camaloon Print on Demand',
            'connectUrl' => $this->context->link->getAdminLink(Camaloon::CONNECT_CONTROLLER),
            'disconnectUrl' => $this->context->link->getAdminLink(Camaloon::CONNECT_CONTROLLER),
            'connectImgUrl' => $this->module->getPathUri() . 'views/img/camaloon-homepage.svg',
            'connected' => $connected
        ));


    }
    public function setMedia($isNewTheme = false)
    {
        $this->addCSS($this->module->getLocalPath() . 'views/css/connect.css');
        parent::setMedia($isNewTheme);
    }
}
