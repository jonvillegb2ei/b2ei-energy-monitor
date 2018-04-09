<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Log
 *
 * @property int $id
 * @property int $variable_id
 * @property float $value
 * @property \Carbon\Carbon $created_at
 * @property-read \App\Models\Variable $variable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Log whereVariableId($value)
 */
	class Log extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $code
 * @property string $brand
 * @property string $reference
 * @property string $class_name
 * @property float $version
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Equipment[] $equipments
 * @property-read mixed $created_since
 * @property-read mixed $updated_since
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereClassName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereVersion($value)
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Variable
 *
 * @property int $id
 * @property int $equipment_id
 * @property string $name
 * @property float $value
 * @property string $unite
 * @property int $log
 * @property string $type
 * @property int $log_expiration
 * @property int $log_interval
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Equipment $equipment
 * @property-read mixed $created_since
 * @property-read mixed $printable_name
 * @property-read mixed $printable_value
 * @property-read mixed $updated_since
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Log[] $logs
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variable whereEquipmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variable whereLog($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variable whereLogExpiration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variable whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variable whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variable whereUnite($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Variable whereValue($value)
 */
	class Variable extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $lastname
 * @property string $firstname
 * @property string $email
 * @property bool $administrator
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $created_since
 * @property-read mixed $fullname
 * @property-read mixed $updated_since
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAdministrator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Equipment
 *
 * @property int $id
 * @property string $name
 * @property string|null $comment
 * @property string $localisation
 * @property int $product_id
 * @property string $address_ip
 * @property int $port
 * @property int $slave
 * @property array $data
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $created_since
 * @property-read mixed $updated_since
 * @property-read mixed $widget_variables
 * @property-read \App\Models\Product $product
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Variable[] $variables
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereAddressIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereLocalisation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment wherePort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereSlave($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Equipment whereUpdatedAt($value)
 */
	class Equipment extends \Eloquent {}
}

