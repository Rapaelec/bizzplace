@extends('layout.profilemaster')

@section('title', 'Gestions employés')

@section('headertxt', 'Employés')

@push('styles')
<style media="screen">
  li.page-item {
      display: inline-block;
  }

  ul.pagination {
      width: 100%;
  }
  .order-track-page-content {
    padding: 0px;
  }
  .order-track-page-content .track-order-form-wrapper {
    margin: 0px 0 25px 0;
  }
</style>
@endpush

@section('content')

    <div class="row">
      <div class="col-md-12">
        @if(count($errors)>0)
        <div class="alert alert-warning" role="alert">
          <ul>
            @foreach ($errors->all() as $error)
               <li> {{ $error }} </li>
            @endforeach
          </ul>
          </div>
        @endif
        @if($message = Session::get('message'))
        <div class="alert alert-success" role="alert">
            <ul>
              <li> {{ $message }} </li>
            </ul>
        </div>
        @endif
        <div class="order-track-page-content">
          <div class="track-order-form-wrapper"><!-- track order form -->
            <form method="post" action="{{ route('user.employees.import') }}" enctype="multipart/form-data">
             {{ csrf_field() }}
              <input type="file" class="form-control select_file" name="select_file">
              <br>
              <button type="submit" class="btn btn-primary"><i class="fas fa-file-import"></i> Importer vos employés</button>
              <a href="{{ route('user.employees.export') }}" class="btn btn-primary">Exporter au format Excel</a>
              <a href="{{ route('user.exemple.export') }}" class="btn btn-info">Télécharger le fichier exemple</a>
            </form>
          </div><!-- //. track order form -->
        </div>
      </div>
      <div class="col-md-12">
        <div class="seller-product-wrapper">
            <div class="seller-panel">
                <div class="sellers-product-inner">
                    <div class="bottom-content">
                        <table class="table table-default" id="datatableOne">
                            <thead>
                                <tr>
                                    <th>Matricule</th>
                                    <th>Nom </th>
                                    <th>Prénom</th>
                                    <th>Téléphone</th>
                                    <th>Email</th>
                                    <th>Carte</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($employees as $employee)
                              <?php $i = 0  ?>
                              <tr>
                                <td>{{ $employee->matricule }}</td>
                                <td>{{ $employee->nom }}</td>
                                <td>{{ $employee->prenom }}</td>
                                <td>{{ $employee->telephone }}</td>
                                <td>{{ $employee->email }}</td>
                                @foreach ($employee->cartgifts as $employe_cartgift)
                                @isset($employe_cartgift->employee_id)
                                <?php $i = 1  ?>
                                <td><i class="fas fa-check text-success" data-toggle="tooltip" data-placement="top" title="Possède déjà une carte privilège" ></i></td>
                                @endif
                                @endforeach
                                @if($i == 0)
                                <td><i class="fas fa-times-circle text-danger" data-toggle="tooltip" data-placement="top" title="Ne possède pas de carte privilège"></i></td>
                                @endif
                                <td>
                                <a class="btn btn-success" data-toggle="tooltip" data-id="{{ $employee->id }}" onclick="AddNumCard(event,{{ $employee->id }})" data-target="#AddNumCard" data-placement="top" title="Attribuer une carte privilège" ><i class="fas fa-address-card"></i></a>
                                <a class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Envoyer la carte privilège" onclick="sendEmailToEmployee(event,{{ $employee->id }})"><i class="fas fa-paper-plane"></i></a>
                                <a class="btn btn-danger" data-toggle="tooltip" data-placement="top" title="Supprimer l'employé(e)" onclick="deleteEmploye(event,{{ $employee->id }})"><i class="fas fa-trash-alt"></i></a>
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    @includeif('user.enterprise.partials.add')
    <br>
@endsection
@push('scripts')
  <script>
    $(document).ready(function() {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
    });
    function deleteEmploye(e, pid) {
      e.preventDefault();
      swal({
        title: "Êtes vous sûre ?",
        text: "Une fois supprimee, vous ne pourrez plus récupérer cet(te) employe(e).",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '{{route('user.employees.delete')}}',
            type: 'POST',
            data: {
              id: pid
            },
            success: function(data) {
              console.log(data);
              if (data.result== "success") {
                  window.location = '{{url()->current()}}';
              }
            }
          });
        }
      });
    }
    function AddNumCard(e, pid) {
      e.preventDefault();
      $.ajax({
        url:'{{ route('user.employees.edit') }}',
        type:'get',
        dataType:'JSON',
        data: {
          id:pid
        },
        success: function(data){
          if(!data.fail){
            $('#matricule').val(data['result'].matricule);
            $('#nom').val(data['result'].nom);
            $('#prenom').val(data['result'].prenom);
            $('#telephone').val(data['result'].telephone);
            $('#email').val(data['result'].email);
            $('#AddNumCard').modal('show');
          }else{
            swal({
             title: "Erreur !!!",
             text: data['result'],
             icon: "warning",
          })
          }
        }
      });
    }
    
    function sendEmailToEmployee(e, pid){
      e.preventDefault();
      swal({
        title: "Êtes vous sûre de vouloir envoyer le message?",
        icon: "info",
        buttons: true,
        successMode: true,
        buttons: {
          cancel: "Annuler", 
          send : {
            text:'Envoyer!',
            value:'send'
          }
          },
      })
      .then((value) =>
      {
        switch (value) {
          case 'send': 
          $.ajax({
          url:'{{ route('sendCartGiftToEmployer') }}',
          method:'POST',
          dataType:'JSON',
          data:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            id:pid
           },
            success: function(data) {
              if(data.send==true){
                swal({
                  title: "etat d'envoi...",
                  text: "Code envoyé avec success !!!",
                  icon: "info",
                })
              }else{
                swal({
                  title: "Oups ...",
                  text: data.message,
                  icon: "warning",
                })
              }
            }
          });
          break;
          default :swal.close();
          break;
        }
      })
    }
  </script>
@endpush
