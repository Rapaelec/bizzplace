<div class="container">
  <nav class="navbar navbar-expand-lg mb-5" style="border-radius:5px;background-color:#388385;color:aliceblue">
  <a class="navbar-brand" href="#"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
    <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link txt" href="{{route('user.search',App\Category::where('true_name','SERVICES')->first()->id)}}" style="font-weight:bold">ANNUAIRE <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link txt" href="{{route('user.search',App\Category::where('true_name','PRODUITS')->first()->id)}}" style="font-weight:bold">PRODUITS & SERVICES</a>
      </li>
      <li class="nav-item">
        <a class="nav-link txt" href="{{route('user.search',App\Category::where('true_name','IMMOBILIERS')->first()->id)}}" style="font-weight:bold">IMMOBILIERS</a>
      </li>
      <li class="nav-item">
        <a class="nav-link txt" href="{{route('user.search',App\Category::where('true_name','EMPLOIS')->first()->id)}}" style="font-weight:bold">EMPLOI</a>
      </li>
      <li class="nav-item">
        <a class="nav-link txt" href="{{ route('user.search',App\Category::where('true_name','EVENEMENTS')->first()->id)}}" style="font-weight:bold">EVENEMENT</a>
      </li>
    </ul>
  </div>
  </nav>
  </div>