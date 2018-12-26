<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model {

    protected $fillable = ['ip', 'browser' , 'os', 'type_device', 'country'];
    protected $dates = [];

    public static $rules = [
        // Validation rules
    ];

    // Relationships

}
