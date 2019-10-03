<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header base-bg">
        <h4 class="title no-margin white-txt">Description du service</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            {!!  $services->description!=null ? $services->description : "Aucune description n'a été trouvée" !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
