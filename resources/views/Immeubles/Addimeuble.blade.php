@extends('Layouts/appLayout')

@section('style')
    <link href="{{ asset('assets/css/addlocataire.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('css')

@endsection

@section('content')

    <div class="content-page">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row mt-0">
                            <h5 class="col-8 font-size-16 mb-3">Liste des Securite.</h5>
                            <div class="col-4">
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-outline-success btn-lg" style="font-weight: bolder;"
                                            data-toggle="modal"
                                            data-target="#modalAjoutImmeuble">
                                        <i class="fas fa-plus-square"></i>
                                        Ajouter une Immeuble
                                    </button>
                                </div>
                            </div>
                        </div>
                        <hr>


                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h5 class="font-size-16 mb-1 mt-0">Fiche des paiements.</h5>
                                        <table id="immeubles-datatable" class="table nowrap">
                                            <thead>
                                            <tr>
                                                <th class="text-center">Immeuble</th>
                                                <th class="text-center">Bloc</th>
                                                <th class="text-center">Caisse</th>
                                                <th class="text-center">Cotisation</th>
                                                <th class="text-center"></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($bloc_immeuble as $imm)
                                                {{-- @for ($i = 0; $i < 100; $i++) --}}
                                                <tr>
                                                    <td class="text-center"> {{ $imm->Nom_Immeuble }}</td>
                                                    <td class="text-center">{{ $imm->nom_bloc }}</td>

                                                    <td class="text-center">{{ $imm->Montant_Disponible_En_Caisse }}
                                                    </td>
                                                    <td class="text-center">{{ $imm->Montant_Cotisation_Mensuelle }}
                                                    </td>

                                                    <td>

                                                        <form class="needs-validation" novalidate method="POST"
                                                              action="{{ route('immeubles.destroy',['immeuble'=>$imm->id])}}">
                                                            @method('DELETE')
                                                            @csrf
                                                            <a

                                                                href="{{route('immeubles.edit',['immeuble'=>$imm->id])}}"

                                                               class="edit btn btn-success btn-sm">Edit</a>

                                                            <button class="delete btn btn-danger btn-sm" type="submit">
                                                                Delete
                                                            </button>

                                                        </form>
                                                    </td>
                                                </tr>

                                                {{--
                                            @endfor --}}
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="modalAjoutImmeuble" class="modal fade" tabindex="-1" role="dialog"
             aria-labelledby="modalAjoutImmeubleLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAjoutImmeubleLabel">Nouvelle Immeuble</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="needs-validation" novalidate method="POST" action="{{ route('immeubles.store') }}">
                            @csrf

                            @include('Immeubles.layout')
                            <button type="submit" class="btn btn-block btn-purple btn-lg ">ENREGISTRER et Passer aux
                                Appartements <i class="fa fa-arrow-right"></i></button>

                        </form>

                    </div>

                </div>
            </div>

        </div>





        @endsection

        @section('script')
            <script src="{{ url('assets/js/addlocataire.js') }}"></script>
            <script src="{{ url('assets/libs/parsleyjs/parsley.min.js') }}"></script>
            <script>
                $("#immeubles-datatable").DataTable({
                    lengthMenu: [
                        [10, 25, 50, -1],
                        ['10 lignes', '25 lignes', '50 lignes', 'afficher tous']
                    ],

                    "language": {
                        buttons: {
                            pageLength: {
                                _: "Afficher %d éléments",
                                '-1': "Tout afficher"
                            }
                        },
                        paginate: {
                            previous: "<i class='uil uil-angle-left'>",
                            next: "<i class='uil uil-angle-right'>"
                        },
                        "lengthMenu": "Afficher _MENU_ par Pages",
                        "zeroRecords": "Aucune données disponibles ...",
                        "info": "Total : _TOTAL_ Locataires",
                        "infoEmpty": "Pas de données disponibles ...",
                        "infoFiltered": "(filtré depuis _MAX_ lignes)",
                        "sSearch": "Rechercher"
                    },
                    drawCallback: function () {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded")

                    }
                });

            </script>
    @endsection


    @section('script-bottom')
        <!-- Validation init js-->
            <script src="{{ URL::asset('assets/js/pages/form-validation.init.js') }}"></script>
@endsection
