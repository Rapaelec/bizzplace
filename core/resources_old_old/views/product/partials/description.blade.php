<div class="row">
  <div class="col-md-12">
    <div class="card">
      <div class="card-header base-bg">
        <h4 class="title no-margin white-txt">Description Produit</h4>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            {!!$product->description!!}
          </div>
        </div>

        <div class="card bg-light py-3 px-3">
           <div class="row">
             <div class="col-md-4 text-center">
                 <div class="card">
                     <div class="card-header base-bg">
                       <h4 class="text-white mb-0">
                         <i class="fa fa-map-marker"></i>
                         Frais de livraison dans la ville
                       </h4> 
                     </div>
                     <div class="card-body text-left">
                       <ul>
                         <li>
                           <i class="fa fa-check-circle base-txt"></i> Paiement à la livraison - <strong>{{$gs->in_cash_on_delivery}} {{$gs->base_curr_text}}</strong>
                         </li>
                         <li>
                           <i class="fa fa-check-circle base-txt"></i> Si vous payez une avance, les frais de livraison - <strong>{{$gs->in_advanced}} {{$gs->base_curr_text}}</strong>
                         </li>
                       </ul> 
                     </div>
                 </div>
             </div>
             <div class="col-md-4 text-center">
                 <div class="card">
                     <div class="card-header base-bg">
                       <h4 class="text-white mb-0">
                         <i class="fa fa-map-marker"></i>
                         Frais de livraison autour de la ville<!-- {{$gs->main_city}} -->
                       </h4> 
                     </div>
                     <div class="card-body text-left">
                       <ul>
                         <li>
                           <i class="fa fa-check-circle base-txt"></i> Paiement à la livraison- <strong>{{$gs->around_cash_on_delivery}} {{$gs->base_curr_text}}</strong>
                         </li>
                         <li>
                           <i class="fa fa-check-circle base-txt"></i> Si vous payez une avance, les frais de livraison - <strong>{{$gs->around_advanced}} {{$gs->base_curr_text}}</strong>
                         </li>
                       </ul> 
                     </div>
                 </div>
             </div>
             <div class="col-md-4 text-center">
                 <div class="card">
                     <div class="card-header base-bg">
                       <h4 class="text-white mb-0">
                         <i class="fa fa-map-marker"></i>
                         Autres Lieux
                       </h4> 
                     </div>
                     <div class="card-body text-left">
                       <ul>
                         <li>
                           <i class="fa fa-check-circle base-txt"></i> Paiement à la livraison - <strong>{{$gs->world_cash_on_delivery}} {{$gs->base_curr_text}}</strong>
                         </li>
                         <li>
                           <i class="fa fa-check-circle base-txt"></i> Si vous payez une avance, les frais de livraison - <strong>{{$gs->world_advanced}} {{$gs->base_curr_text}}</strong>
                         </li>
                       </ul>

                     </div>
                 </div> 
                 
             </div>
           </div>
        </div>

        <div class="row refund_policy">
            <div class="col-md-12">
                <h3 class="base-txt"><i class="fa fa-check-circle"></i> Politique de remboursement</h3>
                <div class="">{!! $gs->refund_policy !!}</div>
            </div>
        </div>

        <div class="row replacement_policy">
            <div class="col-md-12">
                <h3 class="base-txt"><i class="fa fa-check-circle"></i> Politique de remplacement</h3>
                <div class="">{!! $gs->replacement_policy !!}</div>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>
