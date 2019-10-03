<!-- Modal send mail -->
<div class="modal fade" id="sendMessageVendor" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="" action="{{ route('sendenvoi_msg') }}" method="post">
    <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">FORMULAIRE MESSAGE</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              {{csrf_field()}}
            <input type="hidden" name="email_vendor" class="email_vendor" value="{{ $product->vendor->email}}">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Nom<span style="color:red">*</span></strong>
                     <input type="text" class="form-control" id="nom_client" required name="nom_client" placeholder="Votre nom" >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                        <strong>Email <span style="color:red">*</span></strong>
                        <input type="email" class="form-control" id="adress_email" name="adress_email" placeholder="Votre Email">
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                       <strong>Téléphone <span style="color:red">*</span></strong>
                       <input type="text" class="form-control" id="phone_client" name="phone_client" placeholder="Votre numéro de téléphone">
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Sujet<span style="color:red">*</span></strong>
                     <input type="text" class="form-control" id="subject_client" name="subject_client" placeholder="Sujet email">
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Message<span style="color:red">*</span></strong>
                     <textarea class="form-control" rows="5" id="message_client" name="message_client" placeholder="message"></textarea>
                    </div>
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">ENVOYER MESSAGE</button>
          </div>
      </form>
    </div>
</div>