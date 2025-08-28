<!doctype html>
<html><body>
<p>Ціна змінилася для оголошення:</p>
<p><a href="{{ $url }}">{{ $url }}</a></p>
<p>Стара ціна: {{ $old ?? '—' }}</p>
<p>Нова ціна: {{ $new }}</p>
</body></html>