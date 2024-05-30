 
<html>
    <body>
        <h1>GoogleCloudStorage show</h1>
            <div>
                @foreach ($objects as $object)
                <ul>
                    {{-- @dump($object) --}}
                    {{-- @dump($object->info()) --}}
                    <li class="text-gray-900 dark:text-white">name：{{ $object->name() }}</li>
                    <li class="text-gray-900 dark:text-white">img：<img src="https://storage.cloud.google.com/yurucon_develop/lCkvG1TbFwoqITCTxamIRNBGKR7UU28oeY7gYHOe.png" alt=""></li>
                </ul>
                <hr>
                @endforeach
                img: <img src="https://storage.cloud.google.com/yurucon_develop/lCkvG1TbFwoqITCTxamIRNBGKR7UU28oeY7gYHOe.png" alt="">
                <a href="https://storage.cloud.google.com/yurucon_develop/lCkvG1TbFwoqITCTxamIRNBGKR7UU28oeY7gYHOe.png">image</a>
            </div>
    </body>
</html>