<div class="item_review_content">
    <h4 class="title">{{$services->vendor->shop_name}}</h4>
    <ul class="product-specification"><!-- product specification -->
        <li>
            <div class="single-spec"><!-- single specification -->
                <span class="heading">Email</span>
                <span class="details">{{$services->vendor->email}}</span>
            </div>
        </li>
        <li>
            <div class="single-spec"><!-- single specification -->
                <span class="heading">Téléphone</span>
                <span class="details">{{$services->vendor->phone}}</span>
            </div>
        </li>
        <li>
            <div class="single-spec"><!-- single specification -->
                <span class="heading">Adresse</span>
                <span class="details">{{ $services->vendor->address}}</span>
            </div>
        </li>
        <li>
            <div class="single-spec"><!-- single specification -->
                <span class="heading">Code Zip </span>
                <span class="details">{{$services->vendor->zip_code}}</span>
            </div>
        </li>
    </ul><!-- //.product specification -->
</div>
