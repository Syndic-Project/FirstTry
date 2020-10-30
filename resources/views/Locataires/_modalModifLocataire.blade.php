@foreach ($locataires as $locataire)
    <div id="modalModifLocataire{{$locataire->id}}" class="modal fade" tabindex="-1" role="dialog"
        aria-labelledby="modalModifLocataire{{$locataire->id}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalModifLocataire{{$locataire->id}}">Nouveau Locataire</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" action="{{route('Locataire.update',$locataire->id) }}" >
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <div class="container">
                            <br />
                            <div class="row justify-content-start">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nomModif">Nom</label>
                                        <input type="text" required class="form-control" id="nomModif" name="nomModif" value="{{$locataire->nom}}"/>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prenomModif">Prénom</label>
                                        <input type="text" required class="form-control" id="prenomModif" name="prenomModif" value="{{$locataire->prenom}}" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cinModif">CIN</label>
                                        <input type="text" required class="form-control" id="cinModif" name="cinModif" value="{{$locataire->CIN}}" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="emailModif">Email</label>
                                        <input type="email" required class="form-control" id="emailModif" name="emailModif"  value="{{$locataire->email}}" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="telModif">Téléphone</label>
                                        <input type="text" required class="form-control" id="telModif" name="telModif" value="{{$locataire->Tel}}"  />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mdpModif">Mot de Passe</label>
                                        <input style="font-style: oblique;" type="text" class="form-control" id="mdpModif"
                                            name="mdpModif" value="************" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="mdpConfirmModif">Confirmez le Mot de Passe</label>
                                        <input style="font-style: oblique;" type="text" class="form-control"
                                            id="mdpConfirmModif" name="mdpConfirmModif"  value="************"/>
                                    </div>
                                </div>

                                <div class="container">
                                    <div class="row">

                                        <div class="col-md-6">
                                            <select name="" id="autocomplete" class="autocomplete form-control form-control-sm">
                                                <option value="">test1</option>
                                                <option value="">test2</option>
                                                <option value="">test3</option>
                                                <option value="">test4</option>
                                                <option value="">test5</option>
                                            </select>

                                            {{-- <p class="mb-1 font-weight-bold text-muted">Les locaux affectés</p>
                                            <div class="form-group">
                                                <select id="liste1Modif" class="form-control" name="non_affecter[]" multiple="">
                                                    @foreach($appartements as $app )
                                                    <option class="items" value="{{$app->id}}">{{$app->nom}}</option>
                                                    @endforeach
                                                </select>
                                            </div> --}}
                                        </div>
                                        <div class="col-md-6" id="selected">
                                            {{-- <div class="form-group">
                                                <p class="mb-1 font-weight-bold text-muted mt-3 mt-md-0">Les locaux
                                                    affectés</p>
                                                <div class="form-group">
                                                    <select id="liste2Modif" class="form-control" name="Affecter[]" multiple="">
                                                        <option class="items" value=""></option>
                                                    </select>
                                                </div>
                                            </div> --}}
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach