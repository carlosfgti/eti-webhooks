<?php

namespace App\Models;

use App\Models\Traits\TraitMutators;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    use TraitMutators, HasFactory;

    protected $table = 'especializacoes';

    protected $primaryKey = 'id_especializacao';

    protected $fillable = [
        'nome',
        'nome_curto',
        'imagem',
        'descricao',
        'preco_parcela',
        'preco_total',
        'qtd_horas_certificado',
        'identificador_hotmart',
        'video',
        'disponivel',
        'data_liberacao',
        'titulo_chamada',
        'imagem_social',
        'cor_landing',
        'link_compra',
        'msg_comprar',
        'valor_ant',
        'valor',
        'total_parcelas',
    ];

    /**
     * get bonus course
     */
    public function bonus()
    {
        return $this->belongsToMany(self::class, 'especializacoes_extras', $this->primaryKey, 'id_espe_bonus');
    }
}
