<?php

namespace tasks\models;

class Users extends \lithium\data\Model {
    
    /**
     * Performs a basic authorization check for a whitelisted user
     * based on a client_id and client_secret values
     *
     * @param array $data   The client_id and client_secret values
     * @return bool    Whether the supplied values match a whitelisted user
     */
    public static function auth($data = []) {
        $conditions = $data + [
            'client_id' => 'forbidden',
            'client_secret' => false
        ];
        $count = self::find('count', ['conditions' => [
            'client_id' => $conditions['client_id'],
            'client_secret' => $conditions['client_secret']
        ]]);
        return $count > 0 ? true : false;
    }
}

?>