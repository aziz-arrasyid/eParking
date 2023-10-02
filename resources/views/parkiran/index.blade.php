baa
{{ $tes }}
<br><br>
@foreach ($History as $history)
    {{ $history->no_plat }}<br>
    {{ $history->transport->jenisKendaraan }}<br>
    {{ $history->transport->hargaParkir }}<br>
    {{ $history->status }}<br>
    {{ $history->jukir->name }}<br>
@endforeach
