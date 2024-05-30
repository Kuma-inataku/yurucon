 
<html>
    <body>
        @if (session('message'))
            <div class="message" style="background-color: greenyellow">
                {{ session('message') }}
            </div>
            @endif
        <h1>GoogleCloudStorage Upload</h1>
            <div>
                <form action="/sample/gc-storage/upload" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="file">
                    <button type="submit">Upload</button>
                </form>
            </div>
    </body>
</html>