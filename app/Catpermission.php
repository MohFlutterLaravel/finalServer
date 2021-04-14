<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catpermission extends Model
{
  protected $fillable = ['name'];
  protected $guarded = ['id'];
  /**
   * Get the permissions for the blog catpermission.
   */
  public function permissions()
  {
      return $this->hasMany('Spatie\Permission\Models\Permission');
  }
}
