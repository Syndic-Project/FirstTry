<?php

namespace App\Http\Controllers;

use App\Mail\QR;
use Carbon\Carbon;
use App\Models\Locateur;
use App\Models\Appartement;
use Illuminate\Http\Request;
use App\Models\confirm_logment;
use App\Models\Residence;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Generator;

class LocateurController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $info_loc = DB::table('locateurs')
            ->join('confirm_logments', 'confirm_logments.id_Locateur', '=', 'locateurs.id')
            ->get(['locateurs.id as locId', 'nom as nom', 'prenom as prenom', 'email  as email']);
        return view('Client/AddLocateur', [
            'appartements' => Appartement::doesnthave('confirmLogments')->get(),
            'locateurs' => $info_loc,
            'Confirmid' =>  Confirm_logment::all(),
            'residenceNom' =>  Residence::first()->nom_residence,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(
        //     $request->request
        // );
        $locateur = new Locateur();
        $locateur->nom = $request->input('nom');
        $locateur->prenom = $request->input('prenom');
        $locateur->CIN = $request->input('cin');
        $locateur->Tel = $request->input('telephone');
        $locateur->Nbr_Invite = $request->input('nbrCompagnon');
        $locateur->email = $request->input('email');
        $locateur->save();

        $base64_image = $request->codeQr;
        if (preg_match('/^data:image\/(\w+);base64,/', $base64_image)) {
            $data = substr($base64_image, strpos($base64_image, ',') + 1);
            $data = base64_decode($data);
            $nomFichier = "QrCode_" . $locateur->id . '_' . date('Y-m-d') . '.png';
            Storage::disk('local')->put("public/" . $nomFichier, $data, 'public');
        }
        $confirm = new confirm_logment();
        $confirm->Accorder = 1;
        $confirm->id_Locateur = $locateur->id;
        $confirm->id_Appartement = $request->input('id_appartement');
        $confirm->DateD = $request->input('dateDebut');
        $confirm->DateF = $request->input('dateFin');
        $confirm->Qrimage = $nomFichier;
        $confirm->save();

        return json_encode('enregistré avec succée');
    }

    public static function generateQR($id_locateur)
    {
        // $info_loc = DB::table('locateurs')
        //     ->join('confirm_logments', 'confirm_logments.id_Locateur', '=', 'locateurs.id')
        //     ->join('appartements', 'appartements.id', '=', 'confirm_logments.id_Appartement')
        //     ->where("locateurs.id", "=", $id_locateur)
        //     ->get(["locateurs.nom", "locateurs.prenom", "locateurs.Nbr_Invite", "confirm_logments.DateD", "confirm_logments.DateF", "appartements.nom as nomAppartement"])
        //     ->first();
        // setlocale(LC_TIME, 'French');
        // $datedebut = Carbon::parse($info_loc->DateD)->formatLocalized('%d %B %Y');
        // $datefin = Carbon::parse($info_loc->DateF)->formatLocalized('%d %B %Y');
        // return (new Generator())->size(200)->generate("Le locateur $info_loc->nom $info_loc->prenom \n(accompagné de ses $info_loc->Nbr_Invite compagnons) \na effectivement loué l'appartement : $info_loc->nomAppartement \nentre le " . $datedebut . " et le " . utf8_encode($datefin));

        return Confirm_logment::where('id_Locateur', $id_locateur)->orderBy('created_at', 'desc')->first()->Qrimage;
    }

    public static function EmailInfo(Request $request, $id)
    {
        // $locateur = Securite::findOrFail($id);
        $locateur = new Locateur();
        $locateur->nom = $request->input('nom');
        $locateur->prenom = $request->input('prenom');
        $locateur->CIN = $request->input('cin');
        $locateur->Tel = $request->input('Tel');
        $locateur->Nbr_Invite = $request->input('nbr');
        $locateur->email = $request->input('email');
        $locateur->save();
        $confirm = new confirm_logment();
        $confirm->Accorder = 1;
        $confirm->id_Locateur = $locateur->id;
        $confirm->id_Appartement = $request->input('id_appartement');
        $confirm->DateD = $request->input('dated');
        $confirm->DateF = $request->input('datef');


        // if ($request->hasFile('Q')) {
        //     $image = $request->file('preuve');
        //     $image->move(public_path() . '/assets/uploads/', $image->getClientOriginalName());
        //     $recu->img = $image->getClientOriginalName();
        // }

        $confirm->save();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
