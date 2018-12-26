<?php namespace App;

use Illuminate\Database\Eloquent\Model;
/**
 * Model that represent a url shortened
*/
class Shorturl extends Model {

    protected $fillable = [];
    protected $hidden = ['pass','id'];
    protected $appends = ['fullUrl', 'shortCode'];

    protected $dates = [];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'pass' => null,
    ];

    public static $rules = [
        // Validation rules
    ];

    //Additional methods
    public function getShortCodeAttribute(){
        return \Helpers::convertIntToBase62Symbol($this->attributes['id']);
    }

    public function setPassAttribute($value) {
        if($value != null){
            $this->attributes['pass'] = hash("sha256",$value);
        }else{
            $this->attributes['pass'] = null;
        }
    }

    public function getPassAttribute() {
        return $this->attributes['pass'];
    }

    public function setUrlAttribute($value) {
        $this->attributes['url'] = base64_encode($value);
    }

    public function getUrlAttribute() {
        return base64_decode($this->attributes['url']);
    }

    public function  getFullUrlAttribute(){
        return env('APP_URL').'/'.$this->getShortCodeAttribute();
    }

    public function statistics()
    {
        return $this->hasMany('App\Statistic');
    }

    public function statisticsSince($time){
        return $this->statistics()->whereDate('created_at', '>=', date('Y-m-d H:i:s', $time));
    }
}
