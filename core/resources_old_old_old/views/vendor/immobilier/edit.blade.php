@extends('layout.master')

@section('title', 'Immobiliers')

@section('headertxt', 'Gestion des Immobiliers')
@push('nicedit-scripts')
  <script src="{{asset('assets/nic-edit/nicEdit.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
      new nicEditor({iconsPath : '{{asset('assets/nic-edit/nicEditorIcons.gif')}}', fullPanel : true}).panelInstance('desc');
    });
  </script>
@endpush

@section('content')
<div class="seller-dashboard-content-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card dashboard-content-wrapper card-default gray-bg">
        <div class="card-header">
        <div class="row">
                <div class="col-md-9">
                GESTIONS IMMOBILIERS
                </div>
                <div class="col-md-2">
                    <a href="{{ route('vendor.categorie',strTolower($categoris->name)) }}" class="btn btn-outline-info text-white font-weight-bold mr-5">Liste Service</a>
                </div>
        </div>
            
        </div>
        <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
             <ul>
                @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
                @endforeach
             </ul>
            </div>
        @endif
         <div class="row">
           <div class="col-md-12">
            <div class="tile">
              <div class="tile-body">
                  <h3></h3>
                    <form action="{{route('vendor.immobilier.update',$immobiliers->id)}}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group margin-bottom-20">
                        <label for="" class="sec-txt">Aperçu des images<span> **</span></label>
                        <div class="">
                         <table class="table table-striped" id="imgtable">
                         </table>
                        </div>
                        <div class="form-group">
                         <label class="btn base-bg txt-white" style="width:200px;color:white;cursor:pointer;">
                           <input id="imgs" style="display:none;" type="file" name="images[]" class="form-control" multiple="multiple"/>
                           <i class="fa fa-plus"></i> Ajouter une photo
                         </label>
                         <p class="no-margin"><small class="text-danger">Maximum 5 images, peuvent être téléchargées</small></p>
                         <p id="errpreimg" class="em no-margin text-danger"></p>
                        </div>
                        </div>
                       <div class="form-group">
                      <div class="row">
                      <div class="col-md-4">
                            <label for="nom" class="col-form-label">Type Offre<span class="text-danger"> **</span></label>
                            <select name="type_offre" id="type_offre" class="form-control">
                                <option value="{{ $immobiliers->type_offre=='vente' ? 'vente' : 'vente'}}">Vente</option>
                                <option value="{{ $immobiliers->type_offre=='location' ? 'location' :'vente' }}">Location</option>
                            </select>
                      </div>
                          
                      </div>
                      <div class="row">
                      <div class="col-md-4">
                              <label for="nom" class="col-form-label">Prix (En &euro;)<span class="text-danger"> **</span></label>
                              <input type="text" name="prix" id="prix" class="form-control" value="{{ $immobiliers->prix }}">
                      </div>
                      <div class="col-md-4">
                            <label for="categorie" class="col-form-label">Catégorie <span class="text-danger"> **</span></label>
                            <select name="categorie" id="categorie" class="form-control">
                                <option value="{{ $categoris->id }}">{{ $categoris->name }}</option>
                            </select>
                      </div>
                      <div class="col-md-4">
                            <label for="subcate_id" class="col-form-label">Sous catégorie<span class="text-danger"> **</span></label>
                            <select name="subcate_id" id="subcate_id" class="form-control">
                                @foreach($subcats as $subcat)
                                 <option value="{{ $subcat->id }}">{{ $subcat->name }}</option>
                                @endforeach
                            </select>
                      </div>
                      </div>
                       <div class="row">
                        <div class="col-md-4">
                            <label for="nom" class="col-form-label">Nom <span class="text-danger"> **</span></label>
                            <input type="text" class="form-control" name="nom" id="nom" value="{{ $immobiliers->nom }}">
                        </div>
                        <div class="col-md-4">
                            <label for="pays" class="col-form-label">Pays <span class="text-danger"> **</span></label>
                            <select class="form-control" name="pays" id="pays">
                              @foreach($countries as $country)
                              <option value="{{ $country }}">{{ $country }}</option>
                              @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="ville" class="col-form-label">Ville <span class="text-danger"> **</span></label>
                            <input type="text" class="form-control" name="ville" id="ville" value="{{ $immobiliers->ville }}">
                        </div>
                        </div> <!--row-->
                        <div class="row mt-2">
                        <div class="col-md-4">
                         <label for="departement" class="col-form-label">Departement<span class="text-danger"> **</span></label>
                         <input type="text" class="form-control" name="departement" id="departement" value="{{ $immobiliers->departement }}"> 
                        </div>
                        <div class="col-md-4">
                            <label for="piece" class="col-form-label">Nombre de pièces<span class="text-danger"> **</span></label>
                            <input type="text" name="piece" id="piece" class="form-control" value="{{ $immobiliers->piece }}">
                        </div>
                        <div class="col-md-4">
                            <label for="charges" class="col-form-label">Charges <span class="text-danger"> (Optionnel)</span></label>
                            <input type="text" name="charge" id="charge" class="form-control" value="{{ $immobiliers->charge }}">
                        </div>
                     </div>
                     <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="chambre" class="col-form-label">Nombre de chambre(s) <span class="text-danger"> **</span></label>
                            <input type="text" class="form-control" name="chambre" id="chambre" value="{{ $immobiliers->chambre }}">
                        </div>
                        <div class="col-md-4">
                            <label for="terrain" class="col-form-label">Superficie terrain (en m<sup>2</sup>)<span class="text-danger"> **</span></label>
                            <input type="text" class="form-control" name="terrain" id="terrain" value="{{ $immobiliers->terrain }}">
                        </div>
                        <div class="col-md-4">
                            <label for="surface" class="col-form-label">Surface (en m<sup>2</sup>)<span class="text-danger"> **</span></label>
                            <input type="text" class="form-control" name="surface" id="surface" value="{{ $immobiliers->surface }}">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                         <label for="etage" class="col-form-label">Etage <span class="text-danger"> (Optionnel)</span></label>
                         <input type="text" class="form-control" name="etage" id="etage" value="{{ $immobiliers->etage }}"> 
                        </div>
                        <div class="col-md-4">
                         <label for="autre_info" class="col-form-label">Information complémentaire<span class="text-danger"> (Optionnel)</span></label>
                         <input type="text" class="form-control" name="autre_info" id="autre_info" value="{{ $immobiliers->autre_info }}" placeholder="piscine,jardin,jacouzzi..."> 
                        </div>
                        <div class="col-md-4">
                         <label for="salle_de_bain" class="col-form-label">Nombre de salle de bain<span class="text-danger"> **</span></label>
                         <input type="text" class="form-control" name="salle_de_bain" id="salle_de_bain" value="{{ $immobiliers->salle_de_bain }}"> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="etat" class="col-form-label">Etat de la maison<span class="text-danger"> **</span></label>
                            <select name="etat" id="etat" class="form-control">
                                <option>Sélectionner l'état de la maison</option>
                                <option value="bon">{{ $immobiliers->etat=='bon' ? 'bon' :'bon' }}</option>
                                <option value="moyen">{{ $immobiliers->etat=='moyen' ? 'moyen' :'moyen' }}</option>
                                <option value="mauvais">{{ $immobiliers->etat=='mauvais' ? 'mauvais' :'mauvais' }}</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                         <label for="chauffage" class="col-form-label">Chauffage<span class="text-danger"> **</span></label>
                         <select name="chauffage" id="chauffage" class="form-control">
                             <option value="{{ $immobiliers->chauffage=='oui' ? 'oui' : 'oui' }}">oui</option>
                             <option value="{{ $immobiliers->chauffage=='non' ? 'non' : 'non' }}">non</option>
                         </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                         <label for="description" class="col-form-label">Description<span class="text-danger"> **</span></label>
                         <textarea class="form-control  nicEdit-main" name="description" id="description" rows="8px">{{ $immobiliers->description }}</textarea>
                        </div>
                    </div>
                    <div class="row mt-5">
                         <div class="col-md-12">
                             <button type="submit" class="btn btn-block btn-primary">MISE A JOUR</button>
                         </div>
                     </div>
                    </div>
                    </form>
                </div>
              </div>
           </div>
         </div>
        </div>
      </div>
     </div>
   </div>
  </div>
</div> 
@endsection
@section('preimgscripts')
  <script>
    var el = 0;
    var imgs = [];

    $(document).on('change', '#imgs', function(e) {
        if (this.files.length && imgs.length < 5) {
          el++;
          $("#imgtable").append('<tr class="trcl" id="tr'+(el-1)+'"><td><img class="preimgs"></td><td><button class="rmvbtn btn btn-danger" type="button" onclick="rmvimg('+(el-1)+')"><i class="fa fa-times"></i></button></td></tr>');
          var file = this.files[0];
          var reader = new FileReader();

          reader.onload = function(e) {
              var data = e.target.result;

              document.getElementsByClassName('preimgs')[el-1].setAttribute('src', data);
              document.getElementsByClassName('preimgs')[el-1].setAttribute('style', 'width:150px');
          };

          reader.readAsDataURL(file);
          imgs.push(file);
          console.log(imgs);
        }

    });

    function rmvimg(index) {
        $("#tr"+index).remove();
        imgs.splice(index, 1);
        console.log(imgs);
        var trcl = document.getElementsByClassName('trcl');
        var rmvbtn = document.getElementsByClassName('rmvbtn');
        for(el=0; el<trcl.length; el++) {
            trcl[el].setAttribute('id', 'tr'+el);
            rmvbtn[el].setAttribute('onclick', 'rmvimg('+el+')');
        }
    }
</script>
@endsection