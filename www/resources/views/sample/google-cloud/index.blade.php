 
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
            <div>
                <a href={{ route('sample.google-cloud.upload-display') }}>
                    <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">GCS Upload</h2>
                </a>
            </div>
            <div>
                <a href="/sample/gc-storage/show">
                    <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">GCS Show</h2>
                </a>
            </div>
            <div>
                <a href="/sample/gc-storage/delete">
                    <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">GCS delete</h2>
                </a>
            </div>
    </body>
</html>