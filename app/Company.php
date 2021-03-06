<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Company
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string $address
 * @property int $phone
 * @property string $email
 * @property string $website
 * @property string $logo
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereWebsite($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Employee[] $employees
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Company whereLogo($value)
 */
class Company extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'website',
        'logo',
    ];
    protected $attributes = [
        'logo' => 'noimg.png',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class,'companyid');
    }

}
