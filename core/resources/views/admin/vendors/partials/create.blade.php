<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">AJOUTER VOTRE VENDEUR</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('admin.vendor.register')}}" method="post" class="login-form">
        {{csrf_field()}}
        <div class="modal-body">
          <div class="row">
          <div class="col-md-6">
            <div class="form-group">
            <label>Nom boutique <span class="text-danger">**</span></label>
                 <input type="text" name="shop_name" class="form-control" value="{{old('shop_name')}}" placeholder="Le nom par defaut sera bizzplace si vous ne spécifiez rien !">
                  @if ($errors->has('shop_name'))
                       <p class="text-danger">{{$errors->first('shop_name')}}</p>
                  @endif
                </div>
            </div>
            <div class="col-md-6">
              <div class="form-group">
              <label>Email <span class="text-danger">**</span></label>
                 <input type="email" name="email" class="form-control" value="{{old('email')}}" placeholder="Email">
                  @if ($errors->has('email'))
                   <p class="text-danger">{{$errors->first('email')}}</p>
                  @endif
              </div>
            </div>
           
          </div>
          <div class="row">
             <div class="col-md-6">
                <div class="form-group">
                <label>Téléphone <span class="text-danger">**</span></label>
                 <input type="text" name="phone" class="form-control" value="{{old('phone')}}" placeholder="Entrer votre numéro de téléphone">
                 @if ($errors->has('phone'))
                   <p class="text-danger">{{$errors->first('phone')}}</p>
                 @endif
                </div>
             </div>
             <div class="col-md-6">
                <div class="form-group">
                <label>Mot de passe <span class="text-danger">**</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Entrer votre mot de passe">
                     @if ($errors->has('password'))
                      <p class="text-danger">{{$errors->first('password')}}</p>
                     @endif
                </div>
             </div>
         </div>
         <div class="row">
             <div class="col-md-6">
                <div class="form-group">
                <label>Rôle <span class="text-danger">**</span></label>
                 <select name="role" class="form-control role">
                     <option value="vendeur_bizzplace">vendeur bizzplace</option>
                 </select>
                </div>
             </div>
             <div class="col-md-6">
                <div class="form-group">
                <label>Confirmer mot de passe <span class="text-danger">**</span></label>
                  <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmer le mot de passe">
                </div>
             </div>
         </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">ENREGISTRER</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">FERMER</button>
        </div>
    </form>
    </div>
  </div>
</div>