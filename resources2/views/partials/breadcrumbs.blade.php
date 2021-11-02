<div class="breadcrumbs-wrap">
    @if (request()->is('about-us'))
    <h1 class="breadcrumb-title">Who We are?</h1>
    @elseif (request()->is('faqs'))
    <h1 class="breadcrumb-title">FAQs</h1>
    @elseif (request()->is('contact'))
    <h1 class="breadcrumb-title">Get in Touch</h1>
    @endif

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            @if (request()->is('about-us'))
            <li class="breadcrumb-item active" aria-current="page">About Us</li>
            @elseif (request()->is('faqs'))
            <li class="breadcrumb-item active" aria-current="page">FAQs</li>
            @elseif (request()->is('contact'))
            <li class="breadcrumb-item active" aria-current="page">Contact</li>
            @endif
        </ol>
    </nav>
</div>
