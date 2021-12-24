<?php

namespace App\Traits;

use App\Models\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @method languageCode
 * @property Translatable languageCode
 * @method findByLanguageCodeAndId
 */
trait Translatable
{
    /**
     * @param Builder $builder
     * @param integer $id
     * @return Builder
     * @static
     */
    public function scopeLanguageCodeAllAndId(Builder $builder, int $id , string $columnName = 'name') : Builder
    {
        return  $builder->select("{$this->table}.*","translation.*")
            ->where($this->table.'.id', '=', $id)->whereNotNull('translation.'.$columnName)
            ->join($this->translationTableName.' as translation', $this->table.'.id', '=', 'translation'.'.'.$this->translationFkName)
            ->groupBy("translation.{$this->translationFkName}");
    }

    /**
     * @param Builder $builder
     * @return Builder
     * @static
     */
    public function scopeLanguageCodeAll(Builder $builder, string $columnName = 'name') : Builder
    {
        $code = Language::select('id')->get();
        return  $builder->
        select("{$this->table}.*","translation.*")->whereNotNull('translation.'.$columnName)->
        join($this->translationTableName.' as translation',
            $this->table.'.id',
            '=',
            'translation'.'.'.$this->translationFkName)
            ->groupBy("translation.{$this->translationFkName}");

    }

    /**
     * @param Builder $builder
     * @param string  $code
     * @return Builder
     * @static
     */
    public function scopeLanguageCode( Builder $builder, string $column = 'name' ) : Builder
    {
        $code = app()->getLocale();
        foreach (Language::where('is_default', '=',false)->get() as $lang){
            if(\Request::segment(1) == "{$lang->code}"){
                if(session()->get('locale')){
                    $locale = session()->get('locale') ?? $lang->code;
                    app()->setLocale($locale);
                    $code = $locale;
                } else {
                    app()->setLocale($lang->code);
                    $code = $lang->code;
                }
            }
        }

        return $builder
            ->join($this->translationTableName.' as translation',
                $this->table.'.id',
                '=',
                'translation'.'.'.$this->translationFkName)
            ->where('translation'.'.language_id','=',function (\Illuminate\Database\Query\Builder $builder) use ($code){
                $builder->from(Language::TABLE_NAME)->select('id')->where('code','=',$code);
            })->whereNotNull('translation.'.$column);
    }

    /**
     * @param Builder $builder
     * @param int $id
     * @return Builder
     * @static
     */
    public function scopeFindByLanguageCodeAndId( Builder $builder, int $modelId ) : Model
    {
        $code = app()->getLocale();
        foreach (Language::where('is_default', '=',false)->get() as $lang){
            if(\Request::segment(1) == "{$lang->code}"){
                if(session()->get('locale')){
                    $locale = session()->get('locale') ?? $lang->code;
                    app()->setLocale($locale);
                    $code = $locale;
                } else {
                    app()->setLocale($lang->code);
                    $code = $lang->code;
                }
                //                app()->setLocale($lang->code);
            }
        }

        return $builder
            ->where($this->table.'.id','=',$modelId)
            ->join($this->translationTableName.' as translation',
                $this->table.'.id',
                '=',
                'translation'.'.'.$this->translationFkName)
            ->where('translation'.'.language_id','=',function (\Illuminate\Database\Query\Builder $builder) use ($code){
                $builder->from(Language::TABLE_NAME)->select('id')->where('code','=',$code);
            })->first();

        //        ->whereNotNull('translation.name')
    }

    /**
     * @param Builder $builder
     * @param int $id
     * @return Builder
     * @static
     */
    public function scopeFindByLanguageCodeAndSlug( Builder $builder, string $slug ) : Model
    {
        $code = app()->getLocale();

        foreach (Language::where('is_default', '=',false)->get() as $lang){
            if(\Request::segment(1) == "{$lang->code}"){
                if(session()->get('locale')){
                    $locale = session()->get('locale') ?? $lang->code;
                    app()->setLocale($locale);
                    $code = $locale;
                } else {
                    app()->setLocale($lang->code);
                    $code = $lang->code;
                }
                //                app()->setLocale($lang->code);
            }
        }

        return $builder
            ->where('slug', '=', $slug )
            ->join($this->translationTableName.' as translation',
                $this->table.'.id',
                '=',
                'translation'.'.'.$this->translationFkName)
            ->where('translation'.'.language_id','=',function (\Illuminate\Database\Query\Builder $builder) use ($code){
                $builder->from(Language::TABLE_NAME)->select('id')->where('code','=',$code);
            })->first();

        //        ->whereNotNull('translation.name')
    }

}
