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
        $this->total_rare_system = $this->kept_rare_drop + $this->kept_super_rare_drop;
        $this->total_rare_distributed = $this->redistributed_rare_drop + $this->redistributed_super_rare_drop;

        // Calcolo della Priorità
        $this->priority = $this->priority_points
            - $this->kept_rare_drop
            - ($this->kept_super_rare_drop * 2)
            + $this->received_rare_drop
            + ($this->received_super_rare_drop * 2)
            + $this->redistributed_rare_drop
            + ($this->redistributed_super_rare_drop * 2);

        // Aggiungi 1 punto priorità per ogni 30 raid partecipati
        $this->priority += intdiv($this->raid_participations, 28);
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