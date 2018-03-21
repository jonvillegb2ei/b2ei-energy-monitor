<?php

namespace App\Models;

use App\Traits\TimestampedModel;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'logs';

    /**
     * The table primary key.
     *
     * @var string
     */
    protected $primaryKey = 'id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'variable_id', 'value'
    ];

    /**
     * Model is timestamped
     *
     * @var string
     */
    public $timestamps = true;

    /**
     * Date columns.
     *
     * @var string
     */
    protected $dates = ['created_at'];



    public function variable() {
        return $this->belongsTo(Variable::class);
    }

}
