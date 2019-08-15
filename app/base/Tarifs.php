<?php

namespace Base;

require_once __DIR__.'/../../core/Query.php';
require_once __DIR__.'/../../core/Base.php';

class Tarifs extends \Base {    
    
    public function getTarifs($user_id, $service_id)
    {
        $sql = "WITH _tar AS(
            SELECT t.tarif_group_id tgi
            FROM services s
            INNER JOIN tarifs t ON t.id=s.tarif_id
            WHERE s.user_id=?uid AND s.id=?sid
        )
        SELECT id, title, price, link, speed, pay_period
        FROM tarifs t
        INNER JOIN _tar ON t.tarif_group_id=_tar.tgi
        ORDER BY id"; 
        
        $query = \Query::instance ($sql,[
            'uid' => (int) $user_id,
            'sid' => (int) $service_id,
        ]);

        $result = \Db::query($query);
        
        $data = \Db::_assoc($result);
                
        return $data;
    }
    
    public function checkTarif($tarif_id)
    {
        $sql = "SELECT count(*) FROM tarifs WHERE id = ?tid"; 
        
        $query = \Query::instance ($sql,[
            'tid' => (int) $tarif_id,
        ]);
                
        $result = \Db::query($query);
        
        $data = \Db::_result($result);
                        
        return $data;
    }
}