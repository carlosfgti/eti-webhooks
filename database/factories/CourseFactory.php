<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->unique()->name;
        return [
            'nome' => $name,
            'nome_curto' => Str::slug($name),
            'imagem' => 'sdfds.jpg',
            'descricao' => $this->faker->sentence(90),
            'preco_parcela' => 10,
            'preco_total' => 10,
            'qtd_horas_certificado' => 10,
            'identificador_hotmart' => date('YmdHis') . uniqid(10),
            'video' => 'vimeo',
            'disponivel' => 'S',
            'data_liberacao' => date('Ymd'),
            'titulo_chamada' => Str::random(10),
            'imagem_social'  => Str::random(10),
            'cor_landing' => '#000',
            'link_compra'  => Str::random(10),
            'msg_comprar'  => Str::random(10),
            'valor_ant' => 10,
            'valor' => 9,
            'total_parcelas' => 12,
        ];
    }
}
