<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index() { return view('submit-claim.index', ['items' => Claim::latest()->get()]); }
    public function store(Request $request) { Claim::create($request->validate(['name' => 'required|string|max:255'])); return back(); }
    public function update(Request $request, Claim $submit_claim) { $submit_claim->update($request->validate(['name' => 'required|string|max:255'])); return back(); }
    public function destroy(Claim $submit_claim) { $submit_claim->delete(); return back(); }
}
