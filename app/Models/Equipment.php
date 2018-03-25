<?php

namespace App\Models;

use App\Traits\TimestampedModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Contracts\Equipment as EquipmentInterface;

class Equipment extends Model implements EquipmentInterface
{
    use TimestampedModel;

    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'equipments';

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
        'name', 'comment', 'localisation', 'product_id', 'address_ip', 'slave', 'data'
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
    protected $casts = [
        'data' => 'array'
    ];

    /**
     * Date columns.
     *
     * @var string
     */
    protected $appends  = [
        'widgetVariables', 'brand', 'reference'
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function variables() {
        return $this->hasMany(Variable::class);
    }


    public function newFromBuilder($attributes = array(), $connection = null)
    {
        $attrs = (array)$attributes;
        $product = Product::find($attrs['product_id']);
        if ($product instanceof Product) {
            $class = $product->class_name;
            if (class_exists($class)) {
                $instance = new $class;
                if ($instance instanceof Equipment) {
                    $instance->exists = true;
                    $instance->setRawAttributes($attrs, true);
                    return $instance;
                }
            }
        }
        return parent::newFromBuilder($attributes);
    }

    public function createVariables()
    {
        return null;
    }

    public function getWidgetVariablesAttribute() {
        return collect([]);
    }

    public function createVariable(string $name, string $unite, int $log_expiration, string $type = 'float')
    {
        $variable = Variable::where('equipment_id', $this->id)->where('name', $name)->first();
        if (is_null($variable)) {
            $variable = Variable::create([
                'equipment_id' => $this->id,
                'name' => $name,
                'unite' => $unite,
                'type' => $type,
                'log_expiration' => $log_expiration,
            ]);
        }
        if ($variable->log_expiration != $log_expiration) {
            $variable->log_expiration = $log_expiration;
            $variable->save();
        }
        return $variable;
    }

    public function updateVariables(array $entries)
    {
        foreach($entries as $name => $value) {
            $this->updateVariable($name, $value);
        }
    }


    public function updateVariable(string $name, float $value)
    {
        return Variable::where('equipment_id', $this->id)->where('name', $name)->update([
            'value' => $value
        ]);
    }

    /**
     * Execute the test command.
     *
     * @return null
     */
    public function refresh()
    {
        return null;
    }

    /**
     * Execute the test command.
     *
     * @return null
     */
    public function getCharts()
    {
        return collect([]);
    }


    /**
     * Execute the test command.
     *
     * @return null
     */
    public function test()
    {
        return 'No test provided for this equipment.';
    }


    public function getReferenceAttribute() {
        try {
            return $this->product->reference;
        } catch(\Exception $error) {
            return '';
        }
    }

    public function getBrandAttribute() {
        try {
            return $this->product->brand;
        } catch(\Exception $error) {
            return '';
        }
    }

    public function getPictureUrlAttribute() {
        return url('/images/product/NSX.png'); // TO DO
    }

}
