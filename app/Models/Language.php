<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Language extends Model
{
  protected $fillable = [
    'name',
    'locale',
    'language_code',
    'text_direction',
    'flag',
    'status',
    'sort_order',
    'is_default',
  ];

  // Varsayılan dil
  public static function default()
  {
    return self::where('is_default', true)->first();
  }

  // Aktif diller
  public static function activeLanguages()
  {
    return self::where('status', true)->orderBy('sort_order')->get();
  }

  // Veri doğrulama
  public static function validate($data)
  {
    return Validator::make($data, [
      'name' => 'required|string|unique:languages,name',
      'locale' => 'required|string|unique:languages,locale',
      'language_code' => 'required|string|size:2|unique:languages,language_code',
      'text_direction' => 'required|in:ltr,rtl',
      'flag' => 'required|string',
      'status' => 'required|boolean',
      'sort_order' => 'integer',
      'is_default' => 'boolean',
    ]);
  }
}
