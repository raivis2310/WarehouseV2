<?php

namespace Warehouse\Models;

use Carbon\Carbon;
class Product {
    public $id;
    public $name;
    public $creationDate;
    public $lastUpdated;
    public $amount;

    public function __construct($id, $name, $amount) {
        $this->id = $id;
        $this->name = $name;
        $this->amount = $amount;
        $this->creationDate = date(Carbon::now()->toDateTimeString());
        $this->lastUpdated = date(Carbon::now()->toDateTimeString());
    }

    public function updateAmount($amount) {
        $this->amount = $amount;
        $this->lastUpdated = date(Carbon::now()->toDateTimeString());
    }
}
