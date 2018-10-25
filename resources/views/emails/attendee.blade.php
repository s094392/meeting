<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>會議名稱: {{ $attendee->title }}</h2>
        <div><b>參加者:</b> {{ $attendee->getUsernameAttribute() }}</div>
        <div><b>參加狀態:</b> {{ $attendee->getStatus() }}</div>
        @if ($attendee->absent_reason)
            <div><b>請假理由:</b> {{ $attendee->absent_reason }}</div>
        @else
            @if ($attendee->late_reason)
                <div><b>遲到理由:</b> {{ $attendee->late_reason }}</div>
            @endif
            @if ($attendee->leave_early_reason)
                <div><b>早退理由:</b> {{ $attendee->leave_early_reason }}</div>
            @endif
        @endif
        {{ $url = url('/') . '/detail/' . $meeting->id . '/properties' }}
        <div>更詳細訊息請至:</b> <a href="{{ $url }}">{{ $url }}</a></div>
    </body>
</html>
