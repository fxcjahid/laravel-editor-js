@php
    $classes = '';
    if ($data['data']->stretched) {
        $classes .= ' image--stretched';
    }
    if ($data['data']->withBorder) {
        $classes .= ' image--bordered';
    }
    if ($data['data']->withBackground) {
        $classes .= ' image--backgrounded';
    }
    
    $id = $data['id'];
    $tunes = $data['tunes']->alignment->alignment;
    $class = implode(' ', [$tunes, $classes]);
    
@endphp

<figure id="{{ $id }}"
        @class($class)>
    <img src="{{ $data['data']->file->url }}"
         alt="{{ $data['data']->caption ?: '' }}">
    @if (!empty($data['data']->caption))
        <caption class="image-caption">
            {{ $data['data']->caption }}
        </caption>
    @endif
</figure>
