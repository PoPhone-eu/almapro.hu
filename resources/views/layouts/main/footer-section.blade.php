<!-- Footer HTML -->
<footer>
    <div class="footer-menu">
        <div class="footer-menu-column">
            <h1>MENÜ</h1>
            <a href="#">iPhone</a>
            <a href="#">iPad</a>
            <a href="#">Apple Watch</a>
            <a href="#">MacBook</a>
            <a href="#">iMac</a>
            <a href="#">Kiegészítők</a>
        </div>
        <div class="footer-menu-column">
            <h1>HASZNOS</h1>
            @php
                $documents = \App\Models\LegalDocument::where('is_active', 1)->orderBy('order', 'asc')->get();
            @endphp
            @foreach ($documents as $item)
                <a href="/documents/{{ $item->slug }}">{{ $item->title }}</a>
            @endforeach
            <div class="copyright-row">
                <img class="szivecske" src="/img/szivecske.png">
                <div class="copyright">
                    Copyright 2023 © almapro.hu
                </div>
            </div>

        </div>
        <div class="footer-menu-column">
            <h1>KAPCSOLAT</h1>
            <p>+36 30 259-6788</p>
            <p>info@almapro.hu</p>
            <div class="social-icons">
                <div class="social-icon facebook">
                    <svg class="_1" width="39" height="38" viewBox="0 0 39 38" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19.5005 0C8.73092 0 0 8.50705 0 19.0005C0 29.494 8.73092 38.001 19.5005 38.001C30.2701 38.001 39.0011 29.494 39.0011 19.0005C39 8.50705 30.2701 0 19.5005 0ZM25.9404 21.2564H21.4099V32.8521H15.9373V21.2564H11.3962V16.5562H15.9373V14.8392C15.9373 8.48554 18.6562 5.14787 24.4201 5.14787C26.1854 5.14787 26.628 5.42242 27.5985 5.64883V10.3009C26.5113 10.1124 26.2075 10.0171 25.0814 10.0171C23.7419 10.0171 23.0343 10.3818 22.3835 11.1092C21.7327 11.8375 21.4088 13.0997 21.4088 14.8955V16.5562H27.6038L25.9394 21.2564H25.9404Z"
                            fill="#F9F9F9"></path>
                    </svg>
                </div>
                <div class="social-icon insta">
                    <div class="_12">
                        <svg class="group" width="40" height="39" viewBox="0 0 40 39" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M28.741 8.1001H11.2606C9.63332 8.1001 8.30908 9.39123 8.30908 10.9778V28.0212C8.30908 29.6078 9.63332 30.8989 11.2606 30.8989H28.741C30.3682 30.8989 31.6925 29.6078 31.6925 28.0212V10.9789C31.6925 9.39228 30.3682 8.10115 28.741 8.10115V8.1001ZM24.7639 24.1446C23.4915 25.3853 21.7995 26.0687 20.0008 26.0687C18.2021 26.0687 16.5101 25.3853 15.2376 24.1446C13.9651 22.904 13.2642 21.2543 13.2642 19.5006C13.2642 17.7468 13.9651 16.0971 15.2376 14.8565C16.5101 13.6158 18.2021 12.9324 20.0008 12.9324C21.7995 12.9324 23.4915 13.6158 24.7639 14.8565C26.0364 16.0971 26.7374 17.7468 26.7374 19.5006C26.7374 21.2543 26.0364 22.905 24.7639 24.1446ZM28.3603 11.5172C27.6464 11.5172 27.0673 10.9526 27.0673 10.2565C27.0673 9.56051 27.6464 8.9959 28.3603 8.9959C29.0742 8.9959 29.6533 9.56051 29.6533 10.2565C29.6533 10.9526 29.0742 11.5172 28.3603 11.5172Z"
                                fill="#F9F9F9"></path>
                            <path
                                d="M20.0005 0C8.95479 0 0 8.73092 0 19.5005C0 30.2701 8.95479 39.0011 20.0005 39.0011C31.0463 39.0011 40.0011 30.2701 40.0011 19.5005C40 8.73092 31.0463 0 20.0005 0ZM33.1286 28.0222C33.1286 30.3816 31.1606 32.3004 28.7407 32.3004H11.2603C8.84048 32.3004 6.87246 30.3816 6.87246 28.0222V10.9788C6.87246 8.61947 8.84048 6.70064 11.2603 6.70064H28.7407C31.1606 6.70064 33.1286 8.61947 33.1286 10.9788V28.0222Z"
                                fill="#F9F9F9"></path>
                            <path
                                d="M20.0004 24.6683C22.9276 24.6683 25.3006 22.3546 25.3006 19.5006C25.3006 16.6465 22.9276 14.3329 20.0004 14.3329C17.0732 14.3329 14.7002 16.6465 14.7002 19.5006C14.7002 22.3546 17.0732 24.6683 20.0004 24.6683Z"
                                fill="#F9F9F9"></path>
                        </svg>
                    </div>
                </div>
                <div class="social-icon youtube">
                    <div class="_12">
                        <svg class="group2" width="40" height="39" viewBox="0 0 40 39" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20.0005 0C8.95479 0 0 8.73092 0 19.5005C0 30.2701 8.95479 39.0011 20.0005 39.0011C31.0463 39.0011 40.0011 30.2701 40.0011 19.5005C40 8.73092 31.0463 0 20.0005 0ZM34.7656 23.6967C34.7656 26.2895 32.6099 28.3902 29.9517 28.3902H10.0493C7.39007 28.3902 5.23549 26.2884 5.23549 23.6967V15.3033C5.23549 12.7105 7.39115 10.6098 10.0493 10.6098H29.9507C32.6099 10.6098 34.7645 12.7116 34.7645 15.3033V23.6967H34.7656Z"
                                fill="#F9F9F9"></path>
                            <path d="M25.3417 19.5005L17.6777 15.1855V23.8145L25.3417 19.5005Z" fill="#F9F9F9"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>