<?php

class BaseCamaloonAdminController extends ModuleAdminController
    {
        public function __construct()
        {
            parent::__construct();
            $this->bootstrap = true;
        }

        public function init()
        {
            parent::init();
            $this->context->smarty->assign(
                array(
                    'connectUrl' => '',
                    'disconnectUrl' => '',
                    'connectImgUrl' => $this->module->getPathUri() . 'views/img/camaloon-homepage.svg'
                )
        );
        }
    }