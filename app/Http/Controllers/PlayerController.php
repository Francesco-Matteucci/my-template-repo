<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerController extends Controller
{
    public function index(Request $request)
{
    // Recupera i parametri di ricerca e ordinamento dalla query string
    $search = $request->input('search');
    $sortBy = $request->input('sort_by', 'name'); // Valore predefinito per il sorting: 'name'
    $sortOrder = $request->input('sort_order', 'asc'); // Valore predefinito per l'ordine: 'asc'

    // Costruisce la query di base con il caricamento del ruolo
    $query = Player::with('role');

    // Se esiste un parametro di ricerca, applica il filtro
    if ($search) {
        $query->where('name', 'LIKE', '%' . $search . '%');
    }

    // Applica l'ordinamento alla query
    $allowedSorts = ['name', 'raid_participations', 'priority'];
    if (in_array($sortBy, $allowedSorts)) {
        $query->orderBy($sortBy, $sortOrder);
    }

    // Paginazione dei risultati
    $players = $query->paginate(10);

    // Passa i parametri alla vista per mantenere lo stato di ricerca e ordinamento
    return view('players.index', compact('players', 'search', 'sortBy', 'sortOrder'));
}

public function search(Request $request)
{
    if ($request->ajax()) {
        $search = $request->input('search');
        $players = Player::with('role')
            ->where('name', 'LIKE', '%' . $search . '%')
            ->orderBy('name', 'asc')
            ->get();
        return response()->json(['players' => $players]);
    }

    return response()->json(['message' => 'Metodo non consentito.'], 405);
}

    public function create()
    {
        // Verifica che l'utente sia admin
        if (!Auth::user()->is_admin) {
            return redirect()->route('players.index')->with('error', 'Non sei autorizzato.');
        }

        $roles = Role::all();
        return view('players.create', compact('roles'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('players.index')->with('error', 'Non sei autorizzato.');
        }

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
        if (!Auth::user()->is_admin) {
            return redirect()->route('players.index')->with('error', 'Non sei autorizzato.');
        }

        $roles = Role::all();
        return view('players.edit', compact('player', 'roles'));
    }

    public function update(Request $request, Player $player)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('players.index')->with('error', 'Non sei autorizzato.');
        }

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
        if (!Auth::user()->is_admin) {
            return redirect()->route('players.index')->with('error', 'Non sei autorizzato.');
        }

        $player->delete();
        return redirect()->route('players.index')->with('success', 'Giocatore eliminato con successo.');
    }

    public function show(Player $player)
    {
        return view('players.show', compact('player'));
    }

    public function add(Player $player)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('players.index')->with('error', 'Non sei autorizzato.');
        }

        return view('players.add', compact('player'));
    }

    public function storeAdd(Request $request, Player $player)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('players.index')->with('error', 'Non sei autorizzato.');
        }

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

        $player->raid_participations += $data['raid_participations'];
        $player->rare_drops_system += $data['rare_drops_system'];
        $player->super_rare_drops_system += $data['super_rare_drops_system'];
        $player->kept_rare_drop += $data['kept_rare_drop'];
        $player->kept_super_rare_drop += $data['kept_super_rare_drop'];
        $player->redistributed_rare_drop += $data['redistributed_rare_drop'];
        $player->redistributed_super_rare_drop += $data['redistributed_super_rare_drop'];
        $player->received_rare_drop += $data['received_rare_drop'];
        $player->received_super_rare_drop += $data['received_super_rare_drop'];

        $player->calculateDerivedFields();
        $player->save();

        return redirect()->route('players.index')->with('success', 'Valori aggiornati con successo.');
    }

    public function incrementRaidForm()
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('players.index')->with('error', 'Non sei autorizzato.');
        }

        $players = Player::with('role')->get();
        return view('players.incrementRaidForm', compact('players'));
    }

    public function incrementRaid(Request $request)
    {
        if (!Auth::user()->is_admin) {
            return redirect()->route('players.index')->with('error', 'Non sei autorizzato.');
        }

        $data = $request->validate([
            'selected_players' => 'required|array',
            'increment_value' => 'required|integer|min:1',
        ]);

        $selectedPlayers = $data['selected_players'];
        $incrementValue = $data['increment_value'];

        Player::whereIn('id', $selectedPlayers)->increment('raid_participations', $incrementValue);

        $playersToUpdate = Player::whereIn('id', $selectedPlayers)->get();
        foreach ($playersToUpdate as $player) {
            $player->calculateDerivedFields();
            $player->save();
        }

        return redirect()->route('players.index')->with('success', 'Raid partecipati aggiornati con successo per i giocatori selezionati.');
    }

    public function cavallopatia()
    {
        // Verifica se l'utente è admin
        if (!auth()->user() || !auth()->user()->is_admin) {
            abort(403, 'Accesso negato');
        }

        $players = Player::all(); // Recuperiamo tutti i giocatori
        return view('players.cavallopatia', compact('players'));
    }

    public function showRaidRules()
    {
        return view('players.regolamentoRaid');
    }

    public function filter(Request $request)
{
    $playerIds = $request->input('player_ids', []);

    // Ottieni i giocatori con gli ID specificati, inclusi i ruoli
    $players = Player::with('role')->whereIn('id', $playerIds)->get();

    return response()->json(['players' => $players]);
}

}