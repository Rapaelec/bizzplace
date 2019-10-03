<!DOCTYPE html>
<html lang="en">
<head>
  @includeif('layout.partials.head')
  @stack('styles')

</head>

<body>
    <div id="app">
      @includeif('layout.partials.gennavbar')

      @includeif('layout.partials.genheader')

      <div class="container">
        <div class="row py-5">
          <div class="col-md-3">
            <div class="card" style="width: 100%;">
              <div class="user-sidebar">
                <div class="card-header base-bg">
                  <h4 class="white-txt no-margin">Mon compte</h4>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><a class="sidebar-links @if(request()->path()=='profile') active @endif" href="{{route('user.profile')}}">Profile</a></li>
                  <li class="list-group-item"><a class="sidebar-links @if(request()->path()=='wishlist') active @endif" href="{{-- route('user.wishlist')--}}">Mes Favoris</a></li>
                  <li class="list-group-item"><a class="sidebar-links @if(request()->path()=='orders') active @endif" href="{{route('user.orders')}}">Commandes</a></li>
                  <li class="list-group-item"><a class="sidebar-links @if(request()->path()=='list_professional') active @endif" href="{{route('user.professional')}}">Professionels</a></li>
                  <li class="list-group-item"><a class="sidebar-links @if(request()->path()=='shipping') active @endif" href="{{route('user.shipping')}}">Adresse de livraison</a></li>
                  <li class="list-group-item"><a class="sidebar-links @if(request()->path()=='billing') active @endif" href="{{route('user.billing')}}">Adresse de facturation</a></li>
                  <li class="list-group-item"><a class="sidebar-links @if(request()->path()=='changepassword') active @endif" href="{{route('user.changepassword')}}">Changer mot de passe</a></li>
                  @if(Auth::check() and Auth::user()->reason_social!=null)
                  <li class="list-group-item"><a class="sidebar-links @if(request()->path()=='employees') active @endif" href="{{route('user.employees')}}">Gestion des salariés</a></li>
                  {{-- <li class="list-group-item"><a class="sidebar-links @if(request()->path()=='changepassword') active @endif" href="{{route('user.changepassword')}}">Achéter des cartes KDO ou Privilège</a></li> --}}
                  {{-- <li class="list-group-item"><a class="sidebar-links @if(request()->path()=='changepassword') active @endif" href="{{route('user.privilege_cards.list')}}">Gestion de vos cartes</a></li> --}}
                  @endif
                  <li class="list-group-item"><a class="sidebar-links" href="{{route('user.logout')}}">Déconnexion</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-9">
            @yield('content')
          </div>
        </div>
      </div>
    </div>

    @includeif('layout.partials.footer')

    @includeif('layout.partials.preloader_bt')

    @includeif('layout.partials.scripts')

    @stack('scripts')

</body>
