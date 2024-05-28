 
<html>
    <body>
        <h1>ZoomMT一覧</h1>
            @foreach ($meetings as $meeting)
            <ul>
                <li class="text-gray-900 dark:text-white">MT名：{{ $meeting->topic }}</li>
                <li class="text-gray-900 dark:text-white">開始時間 ：{{ $meeting->start_time }}</li>
                <li class="text-gray-900 dark:text-white">MT時間：{{ $meeting->duration }}</li>
                <li class="text-gray-900 dark:text-white"><a href="{{ $meeting->join_url }}">URL</a></li>
            </ul>
            <hr>
            @endforeach
    </body>
</html>