<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImmeuble;
use App\Models\Bloc;
use App\Models\Immeuble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class ImmeubleController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //        Bloc::with('immeuble')->get()

        // DB::connection()->enableQueryLog();



        $bloc_immeuble = DB::table('immeubles')
            ->join('blocs', 'immeubles.id_bloc', '=', 'blocs.id')->get(['immeubles.*', 'blocs.nom_bloc']);

        return view('Immeubles/Addimeuble')
            ->with('bloc_immeuble', $bloc_immeuble)
            ->with("blocs", Bloc::all())
            ->with("immeubles", Immeuble::all());
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreImmeuble $request)
    {
        //validateur = voir store immeuble


        //premiere methode pour ajouter dans la db
        $immeuble = new Immeuble();
        $immeuble->id_bloc = $request->input('bloc');
        $immeuble->Nom_Immeuble = $request->input('nom');
        $immeuble->Montant_Cotisation_Mensuelle = $request->input('cotisation');
        $immeuble->Montant_Disponible_En_Caisse = $request->input('caisse');
        $immeuble->save();

        return redirect('/syndic/Appartements');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $immeuble = Immeuble::findOrFail($id);
        $bloc = Bloc::all();

        return view('immeubles.edit', [
            'immeuble' => $immeuble,
            "blocs" => $bloc
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $immeuble = Immeuble::findOrFail($id);

        $immeuble->id_bloc = $request->input('bloc');
        $immeuble->Nom_Immeuble = $request->input('nom');
        $immeuble->Montant_Cotisation_Mensuelle = $request->input('cotisation');
        $immeuble->Montant_Disponible_En_Caisse = $request->input('caisse');
        $immeuble->save();

        Session::flash('message', "Les données ont été mise à jour avec succées");
        Session::flash('alert-class', 'alert-success');

        // Session::flash('message', "Erreur lors de la mise à jour des données ");
        // Session::flash('alert-class', 'alert-danger');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Immeuble::destroy($id);

        return redirect('/syndic/Immeuble');
    }
}
