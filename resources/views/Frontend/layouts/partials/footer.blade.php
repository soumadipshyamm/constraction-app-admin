<footer>
    <div class="container">

        <div class="row">
            <div class="col col-md-6">
                @php
                    $contactDetails = contactDetails();
                @endphp
                <div class="logo">
                    <a href="">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="">
                    </a>
                </div>
                <div class="footer-description">
                    <p>{{ $contactDetails?->description ?? '' }}</p>
                </div>
                <div class="social-menu">
                    <ul>
                        @if (isset($contactDetails?->facebook_link))
                            <li><a href="{{ $contactDetails?->facebook_link ?? '' }}" target="_blank"><i
                                        class="fa-brands fa-facebook"></i>
                                </a>
                            </li>
                        @endif
                        @if (isset($contactDetails?->twitter_link))
                            <li><a href="{{ $contactDetails?->twitter_link ?? '' }}" target="_blank"><i
                                        class="fa-brands fa-twitter"></i>
                                </a>
                            </li>
                        @endif
                        @if (isset($contactDetails?->instagram_link))
                            <li><a href="{{ $contactDetails?->instagram_link ?? '' }}" target="_blank"><i
                                        class="fa-brands fa-instagram"></i>
                                </a>
                            </li>
                        @endif
                        @if (isset($contactDetails?->linkedin_link))
                            <li><a href="{{ $contactDetails?->linkedin_link ?? '' }}" target="_blank"><i
                                        class="fa-brands fa-linkedin"></i>
                                </a>
                            </li>
                        @endif
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
                    @if (isset($contactDetails?->ph_no))
                        <li><a href="tel:{{ $contactDetails?->ph_no ?? '' }}">+{{ $contactDetails?->ph_no ?? '' }}
                            </a>
                        </li>
                    @endif
                    <li><a href="mailto:{{ $contactDetails?->email ?? '' }}">{{ $contactDetails?->email ?? '' }}</a>
                    </li>
                    <li>{{ $contactDetails?->address ?? '' }}</li>
                </ul>
            </div>
        </div>
    </div>
    <p class="copyright">
        Koncite is owned and operated by <b>SUSTRIX SOFTWARES PRIVATE LIMITED</b>. <br>All rights reserved © [2025]
        [SUSTRIX
        SOFTWARES PRIVATE LIMITED]
    </p>
</footer>
