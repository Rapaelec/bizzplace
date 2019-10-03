<!-- Modal Generate Carte Gift -->
<div class="modal fade" id="addDeliveryManOfOrders" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form id="formUpdate" name="formUpdate">
      {{ csrf_field() }}
    <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Nos livreurs disponibles</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          <table class="table table-default" id="datatableOne" style="border: none;">
            <thead>
             <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Téléphone</th>
                <th>Localité</th>
                <th>Poids</th>
                <th>Distance</th>
                <th>Montant</th>
                <th>Votre choix</th>
             </tr>
            </thead>
            <tbody>
              @foreach ($deliverymanVendors->deliverymans as $deliveryman)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $deliveryman->name }}</td>
                <td>{{ $deliveryman->phone }}</td>
                <td>{{ $deliveryman->place_of_residence }}</td>
                <td>{{ $deliveryman->command_weight }} g</td>
                <td>{{ $deliveryman->distance }} km</td>
                <td>{{ $deliveryman->delivery_price }} &euro;</td>
                <td>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="ChoiceDeliverymans" id="ChoiceDeliverymans" value="{{ $deliveryman->id }}">
                </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="updateCheckout(event)">Valider</button>
          </div>
  </form>
    </div>
</div>
