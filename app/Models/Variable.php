<?php

namespace App\Models;

use App\Traits\TimestampedModel;
use Illuminate\Database\Eloquent\Model;

class Variable extends Model
{
    use TimestampedModel;

    public const type_float = 'float';
    public const type_int = 'int';
    public const type_boolean = 'boolean';

    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'variables';

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
        'equipment_id', 'name', 'value', 'unite', 'type', 'log_expiration'
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

    /**
     * Date columns.
     *
     * @var string
     */
    protected $appends = ['printable_name', 'printable_value'];


    public function logs() {
        return $this->hasMany(Log::class);
    }

    public function equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function getPrintableNameAttribute() {
        return ucfirst(str_replace('_', ' ', $this->name));
    }

    public function getPrintableValueAttribute() {
        if ($this->type == 'float') return round($this->value, 2).' '.$this->unite;
        else if ($this->type == 'int') return (int)$this->value.' '.$this->unite;
        else if ($this->type == 'boolean') {
            if (str_contains($this->unite, '|'))
                [$true, $false] = explode('|',$this->unite);
            else if (str_contains($this->unite, '/'))
                [$true, $false] = explode('/',$this->unite);
            else [$true, $false] = ['true', 'false'];
            return (int)$this->value === 1 ? $true : $false;
        } else return $this->value.' '.$this->unite;
    }

}
