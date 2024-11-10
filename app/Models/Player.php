<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'role_id', 'raid_participations', 'priority_points',
        'rare_drops_system', 'super_rare_drops_system', 'kept_rare_drop',
        'kept_super_rare_drop', 'redistributed_rare_drop', 'redistributed_super_rare_drop',
        'received_rare_drop', 'received_super_rare_drop', 'total_rare_dropped',
        'total_rare_system', 'total_rare_distributed', 'priority'
    ];

    public function calculateDerivedFields()
{
    // Calcolo Totale Oggetti Droppati
    $this->total_rare_dropped = $this->rare_drops_system + $this->super_rare_drops_system;

    // Calcolo Totale Oggetti Mantenuti
    $this->total_rare_system = $this->kept_rare_drop + $this->kept_super_rare_drop;

    // Calcolo Totale Oggetti Distribuiti
    $this->total_rare_distributed = $this->redistributed_rare_drop + $this->redistributed_super_rare_drop;

    // Calcolo della Priorità partendo dai punti di priorità base
    $this->priority = $this->priority_points;

    // Sottrazione dei punti in base agli oggetti mantenuti
    $this->priority -= $this->kept_rare_drop; // -1 punto per ogni raro mantenuto
    $this->priority -= $this->kept_super_rare_drop * 2; // -2 punti per ogni super raro mantenuto

    // Sottrazione dei punti per gli oggetti ricevuti (come da tua logica)
    $this->priority -= $this->received_rare_drop; // -1 punto per ogni raro ricevuto
    $this->priority -= $this->received_super_rare_drop * 2; // -2 punti per ogni super raro ricevuto

    // Aggiunta dei punti per gli oggetti redistribuiti
    $this->priority += $this->redistributed_rare_drop; // +1 punto per ogni raro redistribuito
    $this->priority += $this->redistributed_super_rare_drop * 2; // +2 punti per ogni super raro redistribuito

    // Aggiunta dei punti per ogni 30 raid partecipati
    $this->priority += intdiv($this->raid_participations, 30);
}

    protected static function booted()
    {
        static::saving(function ($player) {
            $player->calculateDerivedFields();
        });
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}