@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'test-sm test-danger']) }}>
        @foreach ((array) $messages as $message)
            <li>{{ $message }}</li>
        @endforeach
    </ul>
@endif
