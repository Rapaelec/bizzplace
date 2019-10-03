<div class="item_review_content">
    <h4 class="title">{{$evenements->vendor->shop_name}}</h4>
    <ul class="product-specification"><!-- product specification -->
        <li>
            <div class="single-spec"><!-- single specification -->
                <span class="heading">Email</span>
                <span class="details">{{$evenements->email}}</span>
            </div>
        </li>
        <li>
            <div class="single-spec"><!-- single specification -->
                <span class="heading">Téléphone</span>
                <span class="details">{{$evenements->telephone}}</span>
            </div>
        </li>
        <li>
            <div class="single-spec"><!-- single specification -->
                <span class="heading">Adresse</span>
                <span class="details">{{ $evenements->vendor->address}}</span>
            </div>
        </li>
        <li>
            <div class="single-spec"><!-- single specification -->
                <span class="heading">Code Zip </span>
                <span class="details">{{$evenements->vendor->zip_code}}</span>
            </div>
        </li>
        <li>
            <div class="single-spec"><!-- single specification -->
                <span class="heading">Numéro siret</span>
                <span class="details">{{$evenements->siret }}</span>
            </div>
        </li>
        <li>
            <div class="single-spec"><!-- single specification -->
                <span class="heading">Rue</span>
                <span class="details">{{$evenements->rue }}</span>
            </div>
        </li>
        <li>
            <div class="single-spec"><!-- single specification -->
                <span class="heading">Code postal</span>
                <span class="details">{{$evenements->cod_postal }}</span>
            </div>
        </li>
    </ul><!-- //.product specification -->
</div>
