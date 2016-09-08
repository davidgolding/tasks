<?php

namespace tasks\models;

class Items extends \lithium\data\Model {
    
    public static function index() {
        $items = self::all();
        return $items->data();
    }
    
    /**
     * Saves a new task item to the data source
     *
     * @param array $data    The new task item to create
     * @return array    Status code and item values that were saved
     */
    public static function post($data = []) {
        $status = 422; //unprocessable entity status code

        if (empty($data) || !array_key_exists('title', $data)) {
            return compact('status');
        }
        $item = self::create(['title' => $data['title']]);
        $status = $item->save() ? 200 : 304; //not modified code
        
        return compact('status') + ['item' => $item->data()];
    }
    
    /**
     * Updates an existing task item with user-submitted data
     *
     * @param array $data    The task item and its new values to update
     * @return array    Status code and updated item values
     */
    public static function edit($data = []) {
        $status = 422; //unprocessable entity status code

        if (self::_keys($data) === false) {
            return compact('status');
        }
        $item = self::findById($data['id'], ['limit' => 1]);
        $status = empty($item) ? 304 : 200; //not modified status code
        
        if ($status != 200) {
            return compact('status');
        }
        $status = $item->save($data) ? 200 : 304;
        return compact('status') + ['item' => $item->data()];
    }
    
    /**
     * Ensures all keys required for updating a task item
     * are present
     *
     * @param array $data    User-submitted edit data
     * @return bool    False if missing required keys
     */
    protected static function _keys($data) {
        $required = ['id', 'title', 'completed'];
        $pass = true;
        
        foreach ($required as $key) {
            if (!array_key_exists($key, $data)) {
                $pass = false;
                break;
            }
        }
        return $pass;
    }
}

?>