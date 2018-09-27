<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>會議名稱: {{ $meeting->title }}</h2>
        <div><b>開會時間:</b> {{ $meeting->scheduled_time }}</div>
        <div><b>會議發起人:</b> {{ $meeting->owner }}</div>
        <div><b>會議描述:</b> {{ $meeting->description }}</div>
        <div>請記得參加喔喔!!</div>
        <div>更詳細訊息或請假請至:</b> <a href="{{ $url }}">{{ $url }}</a></div>
    </body>
</html>