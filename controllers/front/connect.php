<?php

class CamaloonConnectModuleFrontController extends ModuleFrontController
{
    public function __construct()
    {
        parent::__construct();

        $this->connectService = Camaloon::getService(Camaloon\services\ConnectService::class);
        $this->webserviceService = Camaloon::getService(Camaloon\services\WebserviceService::class);
    }

    public function postProcess()
    {
        $data = file_get_contents("php://input");
        $data = json_decode($data);

        $apiKey = $data->api_key;

        fwrite(STDOUT, "\n\n\n\n" . file_get_contents("php://input") . "\n\n\n\n");

        Configuration::updateValue(Camaloon::CONFIG_API_KEY, $apiKey);
        Configuration::updateValue(Camaloon::CONFIG_IS_FIRST_CONNECTION, true);

        $this->ajaxDie('');
    }
}
