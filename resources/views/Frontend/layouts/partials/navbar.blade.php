<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col col-md-2">
                <a href="" class="brand-logo">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="">
                </a>
            </div>
            <div class="col col-md-7">
                @php
                $datas=getAllMenu();
                @endphp
                <div class="stellarnav">
                    <ul>
                        {{-- <li class="nav-hover active"><a href="{{ route('home') }}">Home</a></li> --}}
                        {{-- <li class="nav-hover"><a href="{{ route('product') }}">Product</a></li>
                        <li class="nav-hover"><a href="#">Blog </a></li>
                        <li class="nav-hover"><a href="{{ route('about') }}">About Us</a> </li> --}}
                        {{-- {{ getAllMenu() }} --}}
                        @foreach($datas as $key => $data)
                        @if($data->position=='header')
                        {{-- {{ $data->type }} --}}
                        @if($data->type=='internal')
                        {{-- {{ $data->site_page}} --}}
                        @php
                        $uuid=getPageDetails('uuid',$data->site_page);
                        $slug=getPageDetails('slug',$data->site_page);
                        @endphp
                        @if(!empty($uuid) && !empty($slug))
                        <li class="nav-hover"><a href="{{ route('page',[$slug]) }}">{{ $data->lable }}</a> </li>
                        {{-- <li class="nav-hover"><a href="{{ route('page',[$slug,$uuid]) }}">{{ $data->lable }}</a> </li> --}}
                        @endif
                        @else
                        <li class="nav-hover"><a href="{{  $data->site_page }}" >{{ $data->lable }}</a> </li>
                        {{-- <li class="nav-hover"><a href="{{  $data->site_page }}" target="_blank">{{ $data->lable }}</a> </li> --}}
                        @endif
                        @endif
                        @endforeach
                        <li class="nav-hover"><a href="{{route('contactUs')}}">Contact Us</a></li>
                    </ul>
                </div><!-- .stellarnav -->
            </div>
            <div class="col col-md-3">
                <a href="{{ route('company.login') }}" class="login">Login</a>
            </div>
        </div>
    </div>
</header>
