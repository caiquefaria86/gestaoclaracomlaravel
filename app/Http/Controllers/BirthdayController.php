<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Birthday;

class BirthdayController extends Controller
{

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // dd($request);
        $data = $request->all();

        $birthday = new Birthday();
        $birthday->client_id    = $data['clientId'];
        $birthday->name         = $data['name'];
        $birthday->birthday         = $data['birthday'];
        $birthday->relationship         = $data['relationship'];
        $birthday->save();

        return back()->with('success', 'Adicionado com sucesso!');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($birthdayId)
    {
        // dd($birthdayId);
        $setBt = Birthday::find($birthdayId);
        $setBt->delete();

        return back()->with('success', 'Deletado com sucesso');
    }
}
