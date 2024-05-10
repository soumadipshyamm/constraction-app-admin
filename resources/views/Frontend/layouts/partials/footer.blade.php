<footer>
    <div class="container">

        <div class="row">
            <div class="col col-md-6">
                @php
                    $contactDetails = contactDetails();
                @endphp
                <div class="logo">
                    <a href="">
                        <img src="assets/images/logo.svg" alt="">
                    </a>
                </div>
                <p>{{ $contactDetails?->description ?? '' }}</p>

                <div class="social-menu">
                    <ul>
                        <li><a href="{{ $contactDetails?->facebook_link ?? '' }}" target="_blank"><i
                                    class="fa-brands fa-facebook-f"></i></a>
                        </li>
                        <li><a href="{{ $contactDetails?->twitter_link ?? '' }}" target="_blank"><i
                                    class="fa-brands fa-twitter"></i></a>
                        </li>
                        <li><a href="{{ $contactDetails?->instagram_link ?? '' }}" target="_blank"><i
                                    class="fa-brands fa-instagram"></i></a>
                        </li>
                        <li><a href="{{ $contactDetails?->linkedin_link ?? '' }}" target="_blank"><i
                                    class="fa-brands fa-linkedin-in"></i></a>
                        </li>
                    </ul>
                </div>
            </div>

            @php
                $datas = getAllMenu();
                //print_r($datas);
            @endphp
            <div class="col col-md-3">
                <h3>Link</h3>
                <ul class="quick-links">
                    @if ($datas)
                        @foreach ($datas as $key => $data)
                            @if ($data->position == 'footer')
                                {{-- {{ $data->type }} --}}
                                @if ($data->type == 'internal')
                                    {{-- {{ $data->site_page}} --}}
                                    @php
                                        $uuid = getPageDetails('uuid', $data->site_page);
                                        $slug = getPageDetails('slug', $data->site_page);
                                    @endphp
                                    @if (!empty($uuid) && !empty($slug))
                                        <li class="nav-hover"><a
                                                href="{{ route('page', [$slug, $uuid]) }}">{{ $data->lable }}</a> </li>
                                    @endif
                                @else
                                    <li class="nav-hover">
                                        <a class="openNewTabButton" href="{{ $data->site_page }}"
                                            target="_blank">{{ $data->lable }}</a>
                                    </li>
                                @endif
                            @endif
                        @endforeach
                    @endif
                </ul>

            </div>
            <div class="col col-md-3">
                <h3>Contact</h3>
                <ul class="contact-details">
                    <li><a href="tel:{{ $contactDetails?->ph_no ?? '' }}">+{{ $contactDetails?->ph_no ?? '' }} </a>
                    </li>
                    <li><a href="mailto:{{ $contactDetails?->email ?? '' }}">{{ $contactDetails?->email ?? '' }}</a>
                    </li>
                    <li>{{ $contactDetails?->address ?? '' }}</li>
                </ul>
            </div>
        </div>
    </div>
    <p class="copyright">
        Copyright 2019 All Right Reserved
    </p>
</footer>
