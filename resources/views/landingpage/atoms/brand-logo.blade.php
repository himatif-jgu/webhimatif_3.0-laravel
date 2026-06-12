@props([
    'class' => '',
    'image' => 'assets/landing/images/logo-himatif-jgu.png',
])

<a href="{{ route('home') }}" class="{{ $class }}" aria-label="Go to HIMATIF home">
    <img src="{{ asset($image) }}" alt="HIMATIF JGU">
</a>
