<?php

require_once __DIR__.'/../core/AbstractApi.php';
require_once __DIR__.'/../Db.php';
require_once __DIR__.'/base/Tarifs.php';
require_once __DIR__.'/base/Service.php';

class TestApi extends AbstractApi
{
    /**
     * Метод GET
     * Возвращает тарифы конкретного сервиса
     * /users/{user_id}/services/{service_id}/tarifs
     */
    public function tarifs()
    {
        $result = \Base\Tarifs::getTarifs($this->userId, $this->serviceId);

        $tarifs = [];
        
        if($result){
            foreach ($result as $row) {
                if(!$tarifs){
                    $tarifs = array(
                        'title' => $row['title'],
                        'link'  => $row['link'],
                        'speed' => $row['speed']
                    );
                }

                $new_payday = strtotime('+'.$row['pay_period'].' MONTH', mktime(0,0,0));

                $data[] = array(
                    'ID'            => $row['id'],
                    'title'         => $row['title'],
                    'price'         => $row['price'],
                    'pay_period'    => $row['pay_period'],
                    'new_payday'    => $new_payday,
                    'speed'         => $row['speed'],
                );
            }
        }
        
        if($data){
            $tarifs['tarifs'] = $data;
            $ret = array(
                'result' => 'ok',
                'tarifs' => $tarifs
            );
            return $this->response($ret, 200);
        }
        
        return $this->response(array('result'=>'error', 'message' => 'empty data'), 400);
    }

    /**
     * Метод PUT
     * Обновление тарифа
     * /users/{user_id}/services/{service_id}/tarif
     */
    public function tarif()
    {        
        $tarif_id = $this->requestParams['tarif_id'];
        
        if(!$tarif_id || !\Base\Tarifs::checkTarif($tarif_id)){
            return $this->response(array('result'=>'error', 'message' => 'tarif not found'), 400);
        }
        
        if(!\Base\Service::checkService($this->serviceId)){
            return $this->response(array('result'=>'error', 'message' => 'service not found'), 400);
        }

        \Base\Service::updateService($db, $this->userId, $this->serviceId, $tarif_id);

        return $this->response(array('result'=>'ok'), 200);
    }
}
