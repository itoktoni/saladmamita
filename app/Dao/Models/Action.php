<?php

namespace App\Dao\Models;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $table = 'core_actions';
    protected $primaryKey = 'action_code';
    protected $fillable = [
        'action_code',
        'action_name',
        'action_description',
        'action_link',
        'action_controller',
        'action_function',
        'action_sort',
        'action_enable',
        'action_visible',
    ];
    protected $casts = [
        'action_enable'   => 'boolean',
        'action_visible'   => 'boolean',
    ];

    public $timestamps = false;

    public $incrementing = false;
    public $rules = [
        'action_code' => 'required|unique:core_actions',
        'action_name' => 'required|min:3',
    ];

    public $searching = 'action_name';

    public $datatable = [
        'action_code'           => [true    => 'Code'],
        'action_name'           => [true    => 'Name'],
        'action_link'           => [false   => 'Link'],
        'action_controller'     => [true    => 'Controller'],
        'action_function'       => [false    => 'Function'],
        'action_visible'        => [true   => 'Visible'],
        'action_enable'        => [false   => 'Enable'],
    ];

    public $status    = [
        '1' => ['Show', 'info'],
        '0' => ['Hide', 'default'],
    ];

    protected $appends = ['active'];
    public function getActiveAttribute($value)
    {
        return $this->action_visible;
    }
}
