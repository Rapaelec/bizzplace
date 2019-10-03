@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Gestion des utilisateurs interdits</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($bannedUsers) == 0)
            <div class="tile">
              <h3 class="tile-title float-left">Liste des utilisateurs bannis</h3>
              <div class="float-right icon-btn">
                <form method="GET" class="form-inline" action="{{route('admin.bannedUsersSearchResult')}}">
                   <input type="text" name="term" class="form-control" placeholder="Search by username">
                   <button class="btn btn-outline btn-circle  green" type="submit"><i
                      class="fa fa-search"></i></button>
                </form>
              </div>
              <p style="clear:both;margin:0px;"></p>
              <h2 class="text-center">AUCUN UTILISATEUR INTERDIT TROUVÉ</h2>
            </div>
          @else
            <div class="tile">
               <h3 class="tile-title float-left">Liste des utilisateurs bannis</h3>
               <div class="float-right icon-btn">
                 <form method="GET" class="form-inline" action="{{route('admin.bannedUsersSearchResult')}}">
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
                           <th scope="col">Nom utilisateur</th>
                           <th scope="col">Mobile</th>
                           <th scope="col">Details</th>
                        </tr>
                     </thead>
                     <tbody>
                       @foreach ($bannedUsers as $bannedUser)
                         <tr>
                            <td data-label="Nom">{{$bannedUser->first_name}}</td>
                            <td data-label="Email">{{$bannedUser->email}}</td>
                            <td data-label="Nom utlisateur"><a target="_blank" href="{{route('admin.userDetails', $bannedUser->id)}}">{{$bannedUser->username}}</a></td>
                            <td data-label="Mobile">{{$bannedUser->phone}}</td>
                            <td  data-label="Details">
                               <a href="{{route('admin.empDetails', $bannedUser->id)}}"
                                  class="btn btn-outline-primary ">
                               <i class="fa fa-eye"></i> Consulter </a>
                            </td>
                         </tr>
                       @endforeach
                     </tbody>
                  </table>
               </div>
               <div class="text-center">
                 {{$bannedUsers->appends(['term' => $term])->links()}}
               </div>
            </div>
          @endif
        </div>
     </div>
  </main>
@endsection
