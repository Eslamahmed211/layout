<div class="coupon">
    <div class="header">

        <a href="/{{getLocale()}}/store/{{$coupon->shop->slug}}">

            <img src="{{path($coupon->shop->img)}}" alt="{{$coupon->shop->name}}" title="{{$coupon->shop->name}}">
        </a>
        <div class="shop">
            <p class="shop_name">{{$coupon->shop->name}}</p>
            <p class="shop_category">
                @foreach($coupon->shop->categories as $category)
                    {{$category->name }} @if(!$loop->last)
                        -
                    @endif
                @endforeach
            </p>
        </div>
    </div>

    <div class="title">
        {{$coupon->title}}
    </div>

    @if($coupon->code != null)
        <button data-dis="{{$coupon->dis}}" data-id="{{$coupon->id}}" data-link="{{$coupon->link}}"
                data-code="{{$coupon->code}}" type="button"
                onclick="showCoupon(this)"
                data-bs-toggle="modal"
                data-bs-target="#couponModal">
            {{trans('words.showCoupon')}}
        </button>
    @else
        <a class="w-100" href="{{$coupon->link}}" target="_blank">
            <button> {{trans("words.go_offer")}} </button>
        </a>
    @endif

</div>


