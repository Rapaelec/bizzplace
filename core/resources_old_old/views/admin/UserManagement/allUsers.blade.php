@extends('admin.layout.master')


@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Gestion de tous les utilisateurs </h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($users) == 0)
          <div class="tile">
            <h3 class="tile-title float-left">Liste des utilisateurs</h3>
            <div class="float-right icon-btn">
               <form method="GET" class="form-inline" action="{{route('admin.allUsersSearchResult')}}">
                  <input type="text" name="term" class="form-control" placeholder="Search by username">
                  <button class="btn btn-outline btn-circle  green" type="submit"><i
                     class="fa fa-search"></i></button>
               </form>
            </div>
            <p style="clear:both;margin:0px;"></p>
            <h2 class="text-center">AUCUN UTILISATEUR TROUVÉ</h2>
          </div>
          @else
          <div class="tile">
             <h3 class="tile-title float-left">Liste des utilisateurs</h3>
             <div class="float-right icon-btn">
                <form method="GET" class="form-inline" action="{{route('admin.allUsersSearchResult')}}">
                   <input type="text" name="term" class="form-control" placeholder="Search by username">
                   <button class="btn btn-outline btn-circle  green" type="submit"><i
                      class="fa fa-search"></i></button>
                </form>
             </div>
             <div class="table-responsive">
                <table class="table">
                   <thead>
                      <tr>
                         <th scope="col">Nom</th>
                         <th scope="col">Email</th>
                         <th scope="col">nom utilisateur</th>
                         <th scope="col">Mobile</th>
                         <th scope="col">Details</th>
                      </tr>
                   </thead>
                   <tbody>
                     @foreach ($users as $user)
                     <tr>
                        <td data-label="Name">{{$user->first_name}}</td>
                        <td data-label="Email">{{$user->email}}</td>
                        <td data-label="Username"><a target="_blank" href="{{route('admin.userDetails', $user->id)}}">{{$user->username}}</a></td>
                        <td data-label="Mobile">{{$user->phone}}</td>
                        <td  data-label="Details">
                           <a href="{{route('admin.userDetails', $user->id)}}"
                              class="btn btn-outline-primary ">
                           <i class="fa fa-eye"></i> Consulter </a>
                        </td>
                     </tr>
                     @endforeach
                   </tbody>
                </table>
             </div>
             <div class="text-center">
               {{$users->appends(['term' => $term])->links()}}
             </div>
          </div>
          @endif
        </div>
     </div>
  </main>
@endsection
