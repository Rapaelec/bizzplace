<!-- Modal -->
<div class="modal fade" id="editModal{{$gateway->id}}" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{route('update.gateway')}}" method="post" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editer passerelle</h5>
          <button type="button" class="close float-right" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            {{csrf_field()}}
            <input class="form-control abir_id" value="{{$gateway->id}}" type="hidden" name="id">
            <div class="form-group">
               <div class="fileinput fileinput-new" data-provides="fileinput">
                  <div class="fileinput-new thumbnail" style="width: 200px; height: 200px;">
                     <img src="{{asset('assets/gateway/'.$gateway->id.'.jpg?dummy='.uniqid())}}" alt="*" />
                  </div>
                  <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 200px;"> </div>
                  <div>
                     <span class="btn btn-success btn-file">
                     <span class="fileinput-new"> Changer Logo </span>
                     <span class="fileinput-exists"> Changer </span>
                     <input type="file" name="gateimg"> </span>
                     <a href="javascript:;" class="btn btn-danger fileinput-exists" data-dismiss="fileinput"> supprimer </a>
                  </div>
               </div>
            </div>
            <div class="form-group">
               <div class="row">
                   <div class="col-md-6">
                      <strong>Nom du moyen de payement</strong>
                      <input type="text" value="{{$gateway->name}}" class="form-control" id="name" name="name" >
                   </div>
                   <div class="col-md-6">
                      <strong>Taux</strong>
                      <div class="input-group mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">1 USD=</span>
                        </div>
                        <input name="rate" value="{{$gateway->rate}}" type="text" class="form-control">
                        <div class="input-group-append">
                          <span class="input-group-text">{{$gs->base_curr_text}}</span>
                        </div>
                      </div>
                   </div>
               </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="card mb-3" style="max-width: 18rem;">
                  <div class="card-header bg-primary text-white"><strong>Limite de dépôt</strong></div>
                  <div class="card-body">
                    <strong>Montant minimal</strong>
                    <div class="input-group mb-3">
                      <input value="{{$gateway->minamo}}" type="text" name="minamo" class="form-control" placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">{{$gs->base_curr_text}}</span>
                      </div>
                    </div>
                    <strong>Montant Maximum</strong>
                    <div class="input-group mb-3">
                      <input value="{{$gateway->maxamo}}" type="text" name="maxamo" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">{{$gs->base_curr_text}}</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="card mb-3" style="max-width: 18rem;">
                  <div class="card-header bg-primary text-white"><strong>Frais de dépôt</strong></div>
                  <div class="card-body">
                    <strong>Charge fixe</strong>
                    <div class="input-group mb-3">
                      <input value="{{$gateway->fixed_charge}}" type="text" name="chargefx" class="form-control" placeholder="" aria-label="Recipient's username" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">{{$gs->base_curr_text}}</span>
                      </div>
                    </div>
                    <strong>Charge en pourcentage</strong>
                    <div class="input-group mb-3">
                      <input value="{{$gateway->percent_charge}}" type="text" name="chargepc" class="form-control" placeholder="" aria-label="" aria-describedby="basic-addon2">
                      <div class="input-group-append">
                        <span class="input-group-text" id="basic-addon2">%</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            @if ($gateway->id > 899)
              <div class="form-group">
                 <strong>DÉTAILS DE PAIEMENT</strong>
                 <textarea class="form-control" name="val3" rows="3" cols="80">{!! $gateway->val3 !!}</textarea>
              </div>
            @endif
            @if($gateway->id==101)
            <div class="form-group">
               <strong>PAYPAL BUSINESS EMAIL</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            @elseif($gateway->id==102)
            <div class="form-group">
               <strong>COMPTE PM USD</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>Reponse question sécrète</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==103)
            <div class="form-group">
               <strong>CLE SECRET</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong> CLE PUBLIC</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==104)
            <div class="form-group">
               <strong>Email Marchant </strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>CLE SECRET</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==105)
            <div class="form-group">
               <strong>ID Marchant </strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>CLE Marchant</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            <div class="form-group">
               <strong>Website</strong>
               <input type="text" value="{{$gateway->val3}}" class="form-control" id="val3" name="val3" >
            </div>
            <div class="form-group">
               <strong>type d'industrie</strong>
               <input type="text" value="{{$gateway->val4}}" class="form-control" id="val4" name="val4" >
            </div>
            <div class="form-group">
               <strong>ID Canal </strong>
               <input type="text" value="{{$gateway->val5}}" class="form-control" id="val5" name="val5" >
            </div>
            <div class="form-group">
               <strong>Transaction URL</strong>
               <input type="text" value="{{$gateway->val6}}" class="form-control" id="val6" name="val6" >
            </div>
            <div class="form-group">
               <strong>Transaction Status URL</strong>
               <input type="text" value="{{$gateway->val7}}" class="form-control" id="val7" name="val7" >
            </div>
           @elseif($gateway->id==106)
            <div class="form-group">
               <strong>ID Marchand</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>Secret ID</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==107)
            <div class="form-group">
               <strong>Clé Public</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>Clé Secret</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==108)
            <div class="form-group">
               <strong>Merchant ID</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            @elseif($gateway->id==501)
            <div class="form-group">
               <strong>API CLE</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>XPUB CODE</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==502)
            <div class="form-group">
               <strong>API CLE</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>API PIN</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==503)
            <div class="form-group">
               <strong>API CLE</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>API PIN</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==504)
            <div class="form-group">
               <strong>API CLE</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>API PIN</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==505)
            <div class="form-group">
               <strong>CLE PUBLIC</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>CLE PRIVEE</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==506)
            <div class="form-group">
               <strong>CLE PUBLIC</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>CLE PRIVEE</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==507)
            <div class="form-group">
               <strong>Public  CLE</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>Private CLE</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==508)
            <div class="form-group">
               <strong>Public  CLE</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>Private CLE</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==509)
            <div class="form-group">
               <strong>Public  CLE</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>Private CLE</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==510)
            <div class="form-group">
               <strong>Public  CLE</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>Private CLE</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @elseif($gateway->id==513)
            <div class="form-group">
               <strong>API Key</strong>
               <input type="text" value="{{$gateway->val1}}" class="form-control" id="val1" name="val1" >
            </div>
            <div class="form-group">
               <strong>API ID</strong>
               <input type="text" value="{{$gateway->val2}}" class="form-control" id="val2" name="val2" >
            </div>
            @endif

            <div class="form-group">
               <strong>Status</strong>
               <select class="form-control" name="status">
               <option value="1" {{$gateway->status==1?'selected':''}}>Activer</option>
               <option value="0" {{$gateway->status==0?'selected':''}}>Desactiver</option>
               </select>
            </div>
        </div>
        <div class="modal-footer">
          <input type="submit" class="btn btn-primary" value="UPDATE">
        </div>
      </form>
    </div>
  </div>
</div>
