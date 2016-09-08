<?php

namespace tasks\controllers;

use tasks\extensions\service\Rest;
use tasks\models\Items;
use tasks\models\Users;

class ItemsController extends \lithium\action\Controller {
    
    /**
     * Returns all tasks with proper access credentials
     *
     * @return object    Response object as JSON with HTTP status code
     */
    public function index() {
        if (!Users::auth($this->request->query)) {
            return $this->deny(401);
        }
        return $this->json(Items::index());
    }
    
    /**
     * Creates and saves new or existing tasks on proper credential check
     *
     * @return object    Response object as JSON with HTTP status code
     */
    public function update() {
        $data = $this->request->data;
        $method = strtoupper($this->request->method) == 'POST' ? 'post' : 'edit';
        
        if (!Users::auth($data)) {
            return $this->deny(401);
        }
        extract(Items::{$method}($data));
        return $status != 200 ? $this->deny($status) : $this->json($item);
    }
    
    /**
     * Deletes existing task on proper credential check
     *
     * @return object    Response object as JSON with HTTP status code
     */
    public function delete() {
        $query = $this->request->query;
        $status = !isset($query['id']) ? 404 : 304;
        $status = !Users::auth($query) ? 401 : $status;
        
        if ($status != 304) {
            return $this->deny($status);
        }
        $item = Items::findById($query['id']);
        $status = empty($item) ? 304 : 200;
        $status = !$item->delete() ? 304 : 200;
        return $status != 200 ? $this->deny($status) : $this->json(['id' => $query['id']]);
    }
    
    /**
     * Return a denied response with matching error code and message
     *
     * @return object    Response object as JSON with HTTP error code
     */
    public function deny($status = 400) {
        $json = ['message' => Rest::status($status)];
        return $this->render(compact('json', 'status'));
    }
    
    /**
     * Returns a JSON response object with appropriate HTTP status
     *
     * @return object    Response object as JSON
     */
    public function json($data = [], $status = 200) {
        return $this->render(['json' => $data] + compact('status'));
    }
}

?>