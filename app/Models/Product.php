<?php

namespace App\Models;

use App\Traits\TimestampedModel;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use TimestampedModel;

    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'products';

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
        'code', 'brand', 'reference', 'class_name', 'version'
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
    protected $dates = ['created_at', 'edited_at'];

    public function equipments() {
        return $this->hasMany(Equipment::class);
    }


}
