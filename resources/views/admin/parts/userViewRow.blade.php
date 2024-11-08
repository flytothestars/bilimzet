<tr class="row">
    @if(!empty($header))
        <th class="col-4">{{ $key }}</th>
        <th class="col-8">{{ $value }}</th>
    @else
        <td class="col-4">{{ $key }}</td>
        <td class="col-8">
            @if(!empty($value))
                {{ $value }}
            @elseif(!empty($fileUrl))
                <a target="_blank" href="{{ $fileUrl }}">файл</a>
            @endif
        </td>
    @endif
</tr>
