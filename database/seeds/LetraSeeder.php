<?php

use Illuminate\Database\Seeder;

class LetraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('letras')->insert([
            [
                'dedicacion_id' => '2',
                'nombre' => 'A - PROBETAS/MAQUETAS',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'B - FORMACIÓN',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'C - CALIBRACIONES/PREPARACIÓN DE MATERIAL',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'D - OTROS (NO IMPUTABLES A PROYECTO ALGUNO)',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'E - REUNIONES (NO DE PROYECTO)',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'F - AUDITORÍAS AL S.G.C.',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'G - CONTROL ECONÓMICO',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'H - OFERTAS',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'I - SEGUIMIENTO SUMINISTRADORES (NO IMPUTABLE A PROYECTO ALGUNO)',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'J - ASAMBLEAS',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '3',
                'nombre' => 'K - BAJA/MITIGACIÓN',
                'descripcion' => 'NP'
            ],
            [
                'dedicacion_id' => '3',
                'nombre' => 'L - PERMISOS PARA MÉDICOS',
                'descripcion' => 'NP'
            ],
            [
                'dedicacion_id' => '3',
                'nombre' => 'M - SALIDAS (ASUNTOS PROPIOS)',
                'descripcion' => 'NP'
            ],
            [
                'dedicacion_id' => '3',
                'nombre' => 'N - VACACIONES',
                'descripcion' => 'NP'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'O - CALIDAD PRODUCTO: Otros',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'P - SQA: Otros',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'Q - PROCESOS ESPECIALES - SOLDADURA: Otros',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'R - PROCESOS ESPECIALES - PINTURA: Otros',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'S - PROCESOS ESPECIALES - ADHESIVADO: Otros',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'T - PROCESOS ESPECIALES - CRIMPADO: Otros',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'U - PROCESOS ESPECIALES - PARES DE APRIETE: Otros',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '4',
                'nombre' => 'V - SERVICIOS A OTROS DEPARTAMENTOS',
                'descripcion' => 'SAT'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'V - RECONOCIMIENTO MÉDICO CAF',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'X - HOMOLOGACIONES: Otros',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '3',
                'nombre' => 'Y - HORAS RECUPERADAS/DE LIBRE DISPOSICIÓN',
                'descripcion' => 'NP'
            ],
            [
                'dedicacion_id' => '3',
                'nombre' => 'Z - PARO/HUELGA',
                'descripcion' => 'NP'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'AA - PROCESOS ESPECIALES - REMACHADO: Otros',
                'descripcion' => 'GG'
            ],
            [
                'dedicacion_id' => '2',
                'nombre' => 'AB - REVISIÓN GUÍAS DE DISEÑO',
                'descripcion' => 'GG'
            ]
        ]);

    }
}
