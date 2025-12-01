@props(['user', 'showText' => true, 'dotSize' => 'w-2.5 h-2.5'])

<div {{ $attributes->merge(['class' => 'flex items-center gap-2']) }}>
    @if($user->isOnline())
        <span class="{{ $dotSize }} rounded-full bg-green-500 animate-pulse"></span>
        @if($showText)
            <span class="text-sm text-green-600 font-medium">{{ $user->lastSeenText() }}</span>
        @endif
    @elseif($user->wasRecentlyOnline())
        <span class="{{ $dotSize }} rounded-full bg-yellow-500"></span>
        @if($showText)
            <span class="text-sm text-gray-600">{{ $user->lastSeenText() }}</span>
        @endif
    @else
        <span class="{{ $dotSize }} rounded-full bg-gray-400"></span>
        @if($showText)
            <span class="text-sm text-gray-500">{{ $user->lastSeenText() }}</span>
        @endif
    @endif
</div>
