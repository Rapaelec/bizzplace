@extends('layout.master')

@section('title', 'Services')

@section('headertxt', 'Gestions des services')

@section('content')
<div class="seller-dashboard-content-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card dashboard-content-wrapper card-default gray-bg">
        <div class="card-header">
            GESTIONS SERVICES
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
                    <form action="{{route('vendor.service.store')}}" method="post" enctype="multipart/form-data">
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
                      </div>
                      <div class="row">
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
                            <input type="text" class="form-control" name="nom" id="nom">
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
                            <input type="text" class="form-control" name="ville" id="ville">
                        </div>
                        </div> <!--row-->
                        <div class="row mt-2">
                        <div class="col-md-4">
                         <label for="departement" class="col-form-label">Departement<span class="text-danger"> **</span></label>
                         <input type="text" class="form-control" name="departement" id="departement"> 
                        </div>
                        <div class="col-md-4">
                            <label for="rue" class="col-form-label">Nom de la rue<span class="text-danger"> **</span></label>
                            <input type="text" name="rue" id="rue" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="cod_postal" class="col-form-label">Code postal<span class="text-danger"> **</span></label>
                            <input type="text" name="cod_postal" id="cod_postal" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                          <label for="site_prest" class="col-form-label">Site du prestataire<span class="text-danger"> **</span></label>
                          <input type="text" name="site_prest" id="site_prest" class="form-control" placeholder="http://www.bizzplace.fr">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                          <label for="site_prest_racv" class="col-form-label">Site RACV du prestataire<span class="text-danger"> **</span></label>
                          <input type="text" name="site_prest_racv" id="site_prest_racv" class="form-control" placeholder="http://www.bizzplace.racv.fr">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                          <label for="keywords" class="col-form-label">Mot clé<span class="text-danger"> (Optionnel)</span></label>
                          <input type="text" name="keywords" id="keywords" class="form-control" placeholder="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                         <label for="description" class="col-form-label">Description<span class="text-danger"> **</span></label>
                         <textarea class="form-control  nicEdit-main" name="description" id="description" rows="8px"> </textarea>
                        </div>
                    </div>
                    <div class="row mt-5">
                         <div class="col-md-12">
                             <button type="submit" class="btn btn-block btn-primary">ENREGISTRER</button>
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