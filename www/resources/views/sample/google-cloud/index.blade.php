 
<html>
    <body>
        @if (session('message'))
            <div class="message" style="background-color: greenyellow">
                {{ session('message') }}
            </div>
            @endif
        <h1>GoogleCloudStorage</h1>
            <div>
                <a href="/sample/gc-storage/upload-test">
                    <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">GCS Upload test</h2>
                </a>
            </div>
    </body>
</html>