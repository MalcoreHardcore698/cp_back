<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FineTest extends TestCase
{
    use WithFaker;

    public function testExample()
    {
        $this->faker = \Faker\Factory::create('ru_RU');
        $resources = [];
        for ($i = 0; $i < 4; $i++) {
            $resources[] = $this->res($i);
        }
        echo json_encode($resources, JSON_UNESCAPED_UNICODE);
    }

    protected function res(int $id)
    {
        return [
            'fine_id' => $id,
            'title' => [
                'Превышение скорости',
                'Пересечение двойной сплошной',
                'Наезд на разграничительную линию',
                'Парковка в неположенном месте',
            ][$id],
            'date' => [
                '29.06.2019',
                '17.06.2019',
                '15.05.2019',
                '11.04.2019',
            ][$id],
            'sumd' => [
                500,
                2500,
                1500,
                1500,
            ][$id],
            'paid' => [
                false,
                false,
                false,
                true,
            ],
        ];
    }
}
