<?php

namespace Base;

class Service extends \Base {    
    
    public function checkService($service_id)
    {
        $sql = "SELECT count(*) FROM services WHERE id = ?sid"; 
        
        $query = \Query::instance ($sql,[
            'sid' => (int) $service_id,
        ]);
                
        $result = \Db::query($query);
        
        $data = \Db::_result($result);
                        
        return $data;
    }
    
    public function updateService($user_id, $service_id, $tarif_id)
    {
        $sql = "UPDATE services s 
        SET user_id=?uid, tarif_id=?tid, payday=(now()+ INTERVAL '1 mon'*t.pay_period)::date
        FROM tarifs t 
        WHERE s.id=?sid AND t.id=?tid"; 
        
        $query = \Query::instance ($sql,[
            'sid' => (int) $service_id,
            'uid' => (int) $user_id,
            'tid' => (int) $tarif_id,
        ]);
                
        \Db::query($query);
    }
}