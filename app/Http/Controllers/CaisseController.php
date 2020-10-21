<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Immeuble;
use Illuminate\Http\Request;
use App\Models\Caisse;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Date;

class CaisseController extends Controller
{
    public static function getCaisseByAppartement(Request $request)
    {
        $id_appartement = $request->id_appartement;
        return Caisse::where('id_appartement', $id_appartement)->get()->toJson();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Caisses/AddCaisse', [
            'immeubles' => Immeuble::all(),
            'appartements' => Appartement::all(),
        ]);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $paiement = Caisse::where('id', $request->caisseHidden)->first();
        $paiement->Date_Paiment = new DateTime();
        $paiement->save();

        $paiement_prochain = new Caisse();
        $paiement_prochain->id_Appartement = $paiement->id_Appartement;
        $paiement_prochain->id_Locataire = $paiement->id_Locataire;
        $paiement_prochain->montant = $paiement->appartement->immeuble->Montant_Cotisation_Mensuelle;
        $paiement_prochain->mois_concerne =  explode('-', $paiement->mois_concerne)[1] == 12 ?
            ((int) explode('-', $paiement->mois_concerne)[0] + 1) . '-1' :
            explode('-', $paiement->mois_concerne)[0] . '-' . ((int)explode('-', $paiement->mois_concerne)[1] + 1);
        $paiement_prochain->save();

        return \redirect("Caisse");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
