<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documentos';
    protected $primaryKey = 'idDocumentos';
    protected $fillable = ['DocPrueba','Documento','Fecha','idCONTRATO','TypeDocum','TypePrue',"idUSUARIO","rep_url"];
    public $timestamps = false;
    protected $hidden = [
        'Documento',
        'Preview',
        'DocPrueba',
        'PreviewSimple',
        'DocumentoSimple'

    ];

}
