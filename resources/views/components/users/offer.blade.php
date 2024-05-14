<div class="coupon offer">
    <div class="header">


        <img src="{{path($offer->img)}}" alt="{{$offer->title}}"
             title="{{$offer->name}}">

        <div class="shop">
            <div class="shop_name">{{$offer->title}}</div>

        </div>
    </div>

    <div class="prices">
        <span class="after"> {{$offer->after}} {{getCountry()["curancy"]}} </span>

        @if($offer->before != null)
            <span class="before"> {{$offer->before}}  {{getCountry()["curancy"]}}</span>
        @endif
    </div>

    <div style="display: flex;align-items: center;justify-content: center">
        <img class="offer_shop" src="{{path($offer->shop->img)}}" alt="{{$offer->shop->name}}">
        <a onclick="copyOffer('{{$offer->code}}')" class="w-100" href="{{$offer->link}}" target="_blank">
            <button> {{trans("words.go_offer")}} </button></a>
    </div>


</div>