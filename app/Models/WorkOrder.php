<?php
namespace App\Models;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class WorkOrder extends Eloquent {
    protected $connection = 'mongodb';
    protected $collection = 'workorder';
    protected $primaryKey = 'woid';
}
