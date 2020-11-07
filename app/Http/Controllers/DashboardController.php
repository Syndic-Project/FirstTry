<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Bloc;
use App\Models\Caisse;
use App\Models\Facture;
use App\Models\Immeuble;
use App\Models\Locataire;
use App\Models\Securite;
// use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $TotalAppartementretard = DB::table('locataires')
            ->join('caisses', 'caisses.id_locataire', '=', 'locataires.id')
            ->join('appartements', 'appartements.id', '=', 'caisses.id_Appartement')
            ->where('mois_concerne', '<', $now)
            ->orderBy('mois_concerne', 'desc')
            ->groupBy('mois_concerne')
            ->count('appartements.id');
        $totaldesAppartement = Appartement::count('id');
        //        dd($TotalAppartementretard);

        $PosurcentagedeAppartementNonPaye = $TotalAppartementretard / $totaldesAppartement * 100;
        //alkhir appartement 1 fo9ach khelset
        $derniermoispaye = DB::table('caisses')
            ->where('id_Appartement', '=', 1)
            ->orderBy('mois_concerne', 'desc')->first()->mois_concerne;
        //ch7al raha menchher retard
        $derniermoispaye = Carbon::parse($derniermoispaye)->floorMonth();
        $now = Carbon::now();
        $nbr_de_mois_en_retard = $derniermoispaye->diffInMonths($now);

        //cotisation mensuelle pour une immeuble 1

        $cotisation_mensuelle = DB::table('immeubles')
            ->where('id', '=', 1)
            ->first()->Montant_Cotisation_Mensuelle;

        //credit a paye

        $creadit = $nbr_de_mois_en_retard * $cotisation_mensuelle;


        //total des locataire en retard
        $Totaldeslocataireretard = DB::table('locataires')
            ->join('caisses', 'caisses.id_locataire', '=', 'locataires.id')
            ->where('mois_concerne', '<', $now)
            ->orderBy('mois_concerne', 'desc')
            ->groupBy('mois_concerne')
            ->distinct()
            ->count('locataires.id');

        //total des locataire en avance
        $Totaldeslocataire_en_Avance = DB::table('locataires')
            ->join('caisses', 'caisses.id_locataire', '=', 'locataires.id')
            ->where('mois_concerne', '>', $now)
            ->orderBy('mois_concerne', 'desc')
            ->groupBy('mois_concerne')
            ->distinct()
            ->count('locataires.id');


        //        $blocimapp = DB::table('blocs')
        //            ->join('immeubles', 'immeubles.id_bloc', '=', 'blocs.id')
        //            ->join('appartements', 'appartements.id_Immeuble', '=', 'immeubles.id')
        //            ->get();

        // $this->depenses_secteur_mois();
        return view('index')
            ->with("totalcaisse", Caisse::sum('montant'))
            ->with("totalbloc", Bloc::count('id'))
            ->with("totalappar", Appartement::count('id'))
            ->with("totalLocataire", Locataire::count('id'))
            ->with("totalImmeuble", Immeuble::count('id'))
            ->with("immeubles", Immeuble::all())
            ->with("nbrmoisretard", $nbr_de_mois_en_retard)
            ->with("montantpayeretard", $creadit)
            ->with("totalLocataireenRetard", $Totaldeslocataireretard)
            ->with("totalLocataireenAvance", $Totaldeslocataire_en_Avance)
            ->with("totaldepence", Facture::count('id'))
            ->with("revenueMois", $this->revenue_mois(null)) // opérationnelle
            ->with("totalSecurite", Securite::count('id'));
    }


    public function revenue_mois($annee)
    {
        // possiblité de recevoir revenue_mois avec annéee personnalisé : todo
        $annee = $annee ?? Carbon::now()->format('Y');
        return DB::select("
        select sum(c.montant) as total_mois , c.mois_concerne
        from caisses c
        where SUBSTRING_INDEX(c.mois_concerne,'-',1) = '2020'
        group by c.mois_concerne
        order by  DATE(STR_TO_DATE(CONCAT( SUBSTRING_INDEX(c.mois_concerne,'-',1) , '-' , SUBSTRING_INDEX(c.mois_concerne,'-',-1),'-','1' ),'%Y-%m-%d')) asc,
                STR_TO_DATE(CONCAT( SUBSTRING_INDEX(c.mois_concerne,'-',1) , '-' , SUBSTRING_INDEX(c.mois_concerne,'-',-1),'-','1' ),'%Y-%m-%d') asc
                  ");
    }

    public function depenses_secteur_mois()
    {
        dd(
            Facture::where('id_Type_facture', 1)->get("Montant")->toArray()
        );
    }

    public function pourcentage_appartement_non_paye()
    {
        $now = Carbon::now();
        $TotalAppartementretard = DB::table('locataires')
            ->join('caisses', 'caisses.id_locataire', '=', 'locataires.id')
            ->join('appartements', 'appartements.id', '=', 'caisses.id_Appartement')
            ->where('mois_concerne', '<', $now)
            ->orderBy('mois_concerne', 'desc')
            ->groupBy('mois_concerne')
            ->count('appartements.id');
        $totaldeslocataires = Locataire::count('id');

        $PosurcentagedeAppartementNonPaye = $TotalAppartementretard / $totaldeslocataires * 100;
        return json_encode($PosurcentagedeAppartementNonPaye);
    }
}
