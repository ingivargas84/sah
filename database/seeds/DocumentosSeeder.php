<?php

use Illuminate\Database\Seeder;
use App\documentos;

class DocumentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documentos = new documentos();
        $documentos->documentos = 'Factura';
        $documentos->save();

        $documentos = new documentos();
        $documentos->documentos = 'Factura cambiaría';
        $documentos->save();

        $documentos = new documentos();
        $documentos->documentos = 'Recibo';
        $documentos->save();

        $documentos = new documentos();
        $documentos->documentos = 'Vale';
        $documentos->save();

        $documentos = new documentos();
        $documentos->documentos = 'Nota de crédito';
        $documentos->save();

        $documentos = new documentos();
        $documentos->documentos = 'Nota de débito';
        $documentos->save();
    }
}