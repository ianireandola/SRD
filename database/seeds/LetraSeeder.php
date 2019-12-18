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
                'identificador' => 'A',
                'nombre' => 'PROBETAS/MAQUETAS'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'B',
                'nombre' => 'FORMACIÓN'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'C', 
                'nombre' => 'CALIBRACIONES/PREPARACIÓN DE MATERIAL'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'D',
                'nombre' => 'OTROS (NO IMPUTABLES A PROYECTO ALGUNO)'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'E',
                'nombre' => 'REUNIONES (NO DE PROYECTO)'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'F', 
                'nombre' => 'AUDITORÍAS AL S.G.C.'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'G', 
                'nombre' => 'CONTROL ECONÓMICO'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'H', 
                'nombre' => 'OFERTAS'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'I',
                'nombre' => 'SEGUIMIENTO SUMINISTRADORES (NO IMPUTABLE A PROYECTO ALGUNO)'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'J',
                'nombre' => 'ASAMBLEAS'
            ],
            [
                'dedicacion_id' => '3',
                'identificador' => 'K',
                'nombre' => 'BAJA/MITIGACIÓN'
            ],
            [
                'dedicacion_id' => '3',
                'identificador' => 'L',
                'nombre' => 'PERMISOS PARA MÉDICOS'
            ],
            [
                'dedicacion_id' => '3',
                'identificador' => 'M', 
                'nombre' => 'SALIDAS (ASUNTOS PROPIOS)'
            ],
            [
                'dedicacion_id' => '3',
                'identificador' => 'N', 
                'nombre' => 'VACACIONES'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'O',
                'nombre' => 'CALIDAD PRODUCTO: Otros'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'P',
                'nombre' => 'SQA: Otros'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'Q', 
                'nombre' => 'PROCESOS ESPECIALES - SOLDADURA: Otros'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'R',
                'nombre' => 'PROCESOS ESPECIALES - PINTURA: Otros'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'S',
                'nombre' => 'PROCESOS ESPECIALES - ADHESIVADO: Otros'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'T',
                'nombre' => 'PROCESOS ESPECIALES - CRIMPADO: Otros'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'U', 
                'nombre' => 'PROCESOS ESPECIALES - PARES DE APRIETE: Otros'
            ],
            [
                'dedicacion_id' => '4',
                'identificador' => 'V', 
                'nombre' => 'SERVICIOS A OTROS DEPARTAMENTOS'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'W', 
                'nombre' => 'RECONOCIMIENTO MÉDICO CAF'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'X',
                'nombre' => 'HOMOLOGACIONES: Otros'
            ],
            [
                'dedicacion_id' => '3',
                'identificador' => 'Y',
                'nombre' => 'HORAS RECUPERADAS/DE LIBRE DISPOSICIÓN'
            ],
            [
                'dedicacion_id' => '3',
                'identificador' => 'Z',
                'nombre' => 'PARO/HUELGA'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'AA',
                'nombre' => 'PROCESOS ESPECIALES - REMACHADO: Otros'
            ],
            [
                'dedicacion_id' => '2',
                'identificador' => 'AB',
                'nombre' => 'REVISIÓN GUÍAS DE DISEÑO'
            ]
        ]);

    }
}
