<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\Player;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    public function index()
    {
        $players = Player::with('role')->get(); // Precarica i ruoli per evitare errori null
        $players = Player::paginate(10);
        return view('players.index', compact('players'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('players.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        Player::create(array_merge($data, [
            'raid_participations' => 0,
            'priority_points' => 0,
            'rare_drops_system' => 0,
            'super_rare_drops_system' => 0,
            'kept_rare_drop' => 0,
            'kept_super_rare_drop' => 0,
            'redistributed_rare_drop' => 0,
            'redistributed_super_rare_drop' => 0,
            'received_rare_drop' => 0,
            'received_super_rare_drop' => 0,
            'total_rare_dropped' => 0,
            'total_rare_system' => 0,
            'total_rare_distributed' => 0,
            'priority' => 0,
        ]));

        return redirect()->route('players.index')->with('success', 'Giocatore creato con successo.');
    }

    public function edit(Player $player)
    {
        $roles = Role::all();
        return view('players.edit', compact('player', 'roles'));
    }

    public function update(Request $request, Player $player)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
            'raid_participations' => 'integer|min:0',
            'priority_points' => 'integer|min:0',
            'rare_drops_system' => 'integer|min:0',
            'super_rare_drops_system' => 'integer|min:0',
            'kept_rare_drop' => 'integer|min:0',
            'kept_super_rare_drop' => 'integer|min:0',
            'redistributed_rare_drop' => 'integer|min:0',
            'redistributed_super_rare_drop' => 'integer|min:0',
            'received_rare_drop' => 'integer|min:0',
            'received_super_rare_drop' => 'integer|min:0',
        ]);

        $player->update($data);
        $player->calculateDerivedFields();
        $player->save();

        return redirect()->route('players.index')->with('success', 'Giocatore modificato con successo.');
    }

    public function destroy(Player $player)
    {

        $player->delete();

        return redirect()->route('players.index')->with('success', 'Giocatore eliminato con successo.');
    }

    public function show(Player $player)
    {
        return view('players.show', compact('player'));
    }

    public function add(Player $player)
    {
        return view('players.add', compact('player'));
    }

    public function storeAdd(Request $request, Player $player)
    {
        // Validiamo i dati in arrivo
        $data = $request->validate([
            'raid_participations' => 'integer',
            'rare_drops_system' => 'integer',
            'super_rare_drops_system' => 'integer',
            'kept_rare_drop' => 'integer',
            'kept_super_rare_drop' => 'integer',
            'redistributed_rare_drop' => 'integer',
            'redistributed_super_rare_drop' => 'integer',
            'received_rare_drop' => 'integer',
            'received_super_rare_drop' => 'integer',
        ]);

        // Incremento/Decremento dei valori esistenti
        $player->raid_participations += $data['raid_participations'];
        $player->rare_drops_system += $data['rare_drops_system'];
        $player->super_rare_drops_system += $data['super_rare_drops_system'];
        $player->kept_rare_drop += $data['kept_rare_drop'];
        $player->kept_super_rare_drop += $data['kept_super_rare_drop'];
        $player->redistributed_rare_drop += $data['redistributed_rare_drop'];
        $player->redistributed_super_rare_drop += $data['redistributed_super_rare_drop'];
        $player->received_rare_drop += $data['received_rare_drop'];
        $player->received_super_rare_drop += $data['received_super_rare_drop'];

        // Eseguiamo i calcoli dinamici (ad esempio, aggiornamento della priorità)
        $player->calculateDerivedFields();
        $player->save();

        return redirect()->route('players.index')->with('success', 'Valori aggiornati con successo.');
    }

    public function assignPointsPage()
        {
            $players = Player::all();
            return view('players.assignPoints', compact('players'));
        }

        // Gestisce l'assegnazione dei punti raid
    public function assignPoints(Request $request)
    {
            $selectedPlayers = $request->input('selected_players', []);
            $raidPoints = (int) $request->input('raid_points', 0);

            // Incrementa i punti raid per i giocatori selezionati
            Player::whereIn('id', $selectedPlayers)->increment('raid_participations', $raidPoints);

            return redirect()->route('players.index')->with('success', 'Punti raid assegnati con successo ai giocatori selezionati.');
    }

}