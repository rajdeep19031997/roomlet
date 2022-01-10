<div class="socials mb-3 pb-2 border-bottom w-100">
    <span>{{ $title }}:</span>
    <ul>
        <li>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}&title={{ $description }}" target="_blank" title="{{ __('Share on Facebook') }}"><i class="fab fa-facebook-f"></i></a>
        </li>
        <!-- <li>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&summary={{ rawurldecode($description) }}&source=Linkedin" title="{{ __('Share on Linkedin') }}" target="_blank"><i class="fab fa-linkedin-in"></i></a>
        </li> -->
        <!-- <li>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ $description }}" target="_blank" title="{{ __('Share on Twitter') }}"><i class="fab fa-twitter"></i></a>
        </li> -->
        <li>
            <a href="https://api.whatsapp.com/send?text={{urlencode(url()->current())}}" target="_blank" title="{{ __('Share on Whatsapp') }}"><i class="fab fa-whatsapp"></i></a>
        </li>
        <li>
            <a href="https://www.instagram.com/?url={{urlencode(url()->current())}}" target="_blank" title="{{ __('Share on Instagram') }}"><i class="fab fa-instagram"></i></a>
        </li>
        <li>
            <a href="https://telegram.me/share/url?url={{urlencode(url()->current())}}&text={{$description}}" target="_blank" title="{{ __('Share on Telegram') }}"><i class="fab fa-telegram"></i></a>
        </li>
    </ul>
</div>
