<?php

use ModuleAdminController;

class CamaloonPluginController extends ModuleAdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->bootstrap = true;

        $this->smarty = $this->context->smarty;
    }

    protected function renderTemplate($templateName, $params = array())
    {
        $this->smarty->assign($params);

        $templateName .= '.tpl';

        $this->content .= $this->smarty->fetch($this->getTemplatePath() . $templateName);

        $this->smarty->assign('content', $this->content);
    }

    protected function getCssPath($filename)
    {
        return $this->module->getLocalPath() . 'views/css/' . $filename;
    }
}
