<?php namespace Bocapa\Permissions\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'route_name', 'permitted'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Return the group that owns this permission
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function group()
    {
        return $this->belongsTo('Bocapa\Permissions\Models\Group');
    }
}