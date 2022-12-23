@php
    $withHeadings = $data['data']->withHeadings;
    $content = $data['data']->content;
@endphp


<table class="table">
    @foreach ($content as $row)
        <tr>
            @php
                $tag = $loop->first && $withHeadings ? 'th' : 'td';
            @endphp

            @foreach ($row as $cell)
                <{{ $tag }}> {{ $cell }} </{{ $tag }}>
            @endforeach
        </tr>
    @endforeach
</table>
