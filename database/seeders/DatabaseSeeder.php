<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class DatabaseSeeder extends Seeder
{
    /**
     * Planta semillas automaticas.
     */
    public function run(): void
    {
        // Creación de usuarios con roles
        \App\Models\User::factory()->create([
            'name' => 'Administrador',
            'email' => 'admin@memoriacastrense.gob.ve',
            'password' => bcrypt('Password123'),
            'role' => 'administrador',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Publicador',
            'email' => 'publicador@memoriacastrense.gob.ve',
            'password' => bcrypt('Password123'),
            'role' => 'publicador',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Usuario',
            'email' => 'usuario@memoriacastrense.gob.ve',
            'password' => bcrypt('Password123'),
            'role' => 'usuario',
        ]);

        $categorias = [
            [
                'nombre' => 'Fotografías Históricas',
                'descripcion' => 'Material fotográfico de época militar y civil.'
            ],
            [
                'nombre' => 'Documentos Oficiales',
                'descripcion' => 'Actas, oficios, tratados y correspondencia castrense.'
            ],
            [
                'nombre' => 'Condecoraciones y Medallas',
                'descripcion' => 'Registros de honor al mérito e insignias.'
            ],
            [
                'nombre' => 'Mapas Estratégicos',
                'descripcion' => 'Cartografía antigua y planos tácticos.'
            ]
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}
