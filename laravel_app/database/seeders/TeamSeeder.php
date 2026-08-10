<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'email' => 'denis@romanicompliance.com',
                'name' => 'Denis Gabriel Romani Seminario',
                'role' => 'admin',
                'title' => 'Director General',
                'bio' => "Abogado especialista en compliance corporativo y ALA/CFT. Máster en Derecho Penal por la Pontificia Universidad Católica del Perú (PUCP). Máster en Cumplimiento Normativo Penal por la Universidad de Castilla-La Mancha (UCLM), España. Más de 15 años de experiencia en investigación financiera, prevención LA/FT y compliance corporativo.\n\nLidera la dirección estratégica del estudio y la supervisión de todos los proyectos de consultoría. Responsable del diseño de programas de cumplimiento, auditorías internas y la representación institucional de Romani Compliance ante entidades reguladoras y clientes corporativos.",
                'photo' => 'team/denis-romani.png',
                'credentials' => 'PUCP, UCLM, ISO 37001:2021, Compliance Officer',
                'linkedin_url' => 'https://www.linkedin.com/in/denis-gabriel-romani-seminario-239637109/',
                'team_rank' => 'director',
                'team_order' => 1,
            ],
            [
                'email' => 'omaroliden1@gmail.com',
                'name' => 'Ángel Omar Oliden Pacherrez',
                'role' => 'admin',
                'title' => 'Asistente Legal',
                'bio' => 'Apoyo en la elaboración de documentación normativa, investigación jurídica en materia de compliance y prevención LA/FT, redacción de informes legales, revisión de contratos y asistencia en el diseño de manuales de prevención y matrices de riesgo para los clientes del estudio.',
                'photo' => 'team/omar-oliden.png',
                'linkedin_url' => 'https://www.linkedin.com/in/angel-omar-oliden-pacherrez-086b12187/',
                'team_rank' => 'associate',
                'team_order' => 2,
            ],
            [
                'email' => 'carrascomontañokyra@gmail.com',
                'name' => 'Kyra Alejandra Carrasco Montaño',
                'role' => 'student',
                'title' => 'Asistente Legal',
                'bio' => 'Soporte en la gestión documental del área de compliance, seguimiento de expedientes regulatorios, coordinación con entidades supervisoras, apoyo en la elaboración de políticas internas de prevención y asistencia en los programas de capacitación del estudio.',
                'photo' => 'team/kyra-carrasco.png',
                'linkedin_url' => 'https://www.linkedin.com/in/kyra-alejandra-carrasco-monta%C3%B1o-derecho?originalSubdomain=pe',
                'team_rank' => 'associate',
                'team_order' => 3,
            ],
        ];

        foreach ($members as $data) {
            $email = $data['email'];
            unset($data['email']);

            $user = User::where('email', $email)->first();

            $data['slug'] = Str::slug($data['name']);
            $data['is_team_member'] = true;

            if ($user) {
                // Preserve an existing real login role (e.g. Omar is already an admin via Google).
                unset($data['role']);
                $user->update($data);
            } else {
                $data['role'] = $data['role'] ?? 'student';
                User::create(array_merge(['email' => $email], $data));
            }
        }

        $this->command?->info('Equipo sembrado: '.count($members).' integrantes.');
    }
}
