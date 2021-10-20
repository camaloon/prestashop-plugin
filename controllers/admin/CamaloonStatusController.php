<?php

require_once("CamaloonPluginController.php");

class CamaloonStatusController extends CamaloonPluginController
{
    public function initContent()
    {
        parent::initContent();
        $this->checksService = Camaloon::getService(Camaloon\services\CamaloonChecksService::class);

        $this->addCSS($this->module->getLocalPath() . 'views/css/status.css');
        $this->renderTemplate($this->l('status'), array(
            'title' => $this->l('Status'),
            'items' => $this->checksService->camaloon_getChecklistItems()
        ));
    }
}
