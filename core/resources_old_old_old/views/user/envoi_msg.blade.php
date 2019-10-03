@extends('layout.profilemaster')

@section('title', 'envoi message')

@section('headertxt', 'envoi message')

@push('nicedit-scripts')
  <script src="{{asset('assets/nic-edit/nicEdit.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
      new nicEditor({iconsPath : '{{asset('assets/nic-edit/nicEditorIcons.gif')}}', fullPanel : true}).panelInstance('message');
    });
  </script>
@endpush

@section('content')
    <hr>
    <div class="col-md-12">
     <div class="seller-product-wrapper">
     <div class="seller-panel">
        <div class="sellers-product-inner">
           <div class="bottom-content">
           <main class="app-content">
        <div class="app-title">
        </div>
     <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header bg-primary">
                    <h4 style="color:white;"><i class="fa fa-envelope"></i> ENVOYER VOTRE EMAIL</h4>
                  </div>
                  <div class="card-body">
                    <form class="" action="{{ route('sendenvoi_msg') }}" method="post">
                      {{ csrf_field() }}
                      <input type="hidden" name="vendorID" value="{{ $vendor->id }}">
                      <div class="row">
                        <div class="col-md-12">
                          <label for=""><strong>SUJET</strong></label>
                          <input type="text" class="form-control" name="subject" value="">
                        </div>
                      </div><br>
                      <div class="row">
                        <div class="col-md-12">
                          <label for=""><strong>MESSAGE </strong></label>
                          <textarea id="message" name="message" rows="8" style="width:100%;"></textarea>
                        </div>
                      </div><br>
                      <button class="btn btn-block btn-primary" type="submit" name="button">ENVOYER</button>
                    </form>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
     </div>
  </main>
                    </div>
                </div>
            </div>
        </div>
      </div>
    <br>
@endsection
