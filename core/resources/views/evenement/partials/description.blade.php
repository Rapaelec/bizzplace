<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header base-bg">
        <h4 class="title no-margin white-txt">Description de l'évènement</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <h3 class="font-weight-bold">A propos de l'évènement</h3>
            <hr>
            <div class="row">
              <div class="col-md-2">
                <span class="font-weight-bold">Enseigne :</span>
              </div>
                <div class="col-md-6">
                  {{ $evenements->enseigne }}
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <span class="font-weight-bold">Type :</span>
                </div>
                <div class="col-md-6">
                    {{$evenements->subcategory->name}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <span class="font-weight-bold">Pays :</span>
                </div>
                <div class="col-md-6">
                    {{$evenements->pays}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <span class="font-weight-bold">Departement :</span>
                </div>
                <div class="col-md-6">
                    {{$evenements->departement}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <span class="font-weight-bold">Ville :</span>
                </div>
                <div class="col-md-6">
                    {{$evenements->ville}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <span class="font-weight-bold">Nom de l'annonceur :</span>
                </div>
                <div class="col-md-6">
                    {{ $evenements->vendor->shop_name}}
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-2">
                    <span class="font-weight-bold">Description :</span>
                </div>
                <div class="col-md-6">
                    {!!$evenements->description!!}
                </div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
