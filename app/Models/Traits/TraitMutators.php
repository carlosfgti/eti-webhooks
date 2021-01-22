<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Storage;

trait TraitMutators
{
    public function getIdAttribute()
    {
        return $this->{$this->primaryKey};
    }

    public function getNameAttribute()
    {
        return $this->nome;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['nome'] = $value;
    }

    public function getUrlAttribute()
    {
        return $this->nome_curto;
    }

    public function setUrlAttribute($value)
    {
        $this->attributes['nome_curto'] = $value;
    }

    public function getDescriptionAttribute()
    {
        return $this->descricao;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['descricao'] = $value;
    }

    public function getAvailableAttribute()
    {
        return $this->disponivel;
    }

    public function setAvailableAttribute($value)
    {
        $this->attributes['disponivel'] = $value;
    }

    public function getImageAttribute()
    {
        // return $this->imagem ? Storage::url($this->imagem) : '';
        return $this->imagem ? $this->getFileUrl($this->imagem) : '';
    }

    public function setImageAttribute($value)
    {
        $this->attributes['imagem'] = $value;
    }

    public function getPriceAttribute()
    {
        return number_format($this->valor, 2, ',', '.');
    }

    public function getOldPriceAttribute()
    {
        return number_format($this->valor_ant, 2, ',', '.');
    }
}
