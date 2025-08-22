<x-layouts.app :title="'Ajouter un livre'">
    <div class="container">
        <h1>Ajouter un livre</h1>

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li style="color:red">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="uploadForm" action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="dropZone"
                class="border-2 border-dashed border-gray-300 p-12 text-center cursor-pointer rounded-lg transition-colors duration-200">
                Glissez-déposez votre fichier EPUB ici ou cliquez pour sélectionner
            </div>

            <input type="file" name="epub" id="fileInput" style="display:none;" accept=".epub" multiple>
            <div id="fileList" style="margin-top:10px;"></div>
            <br>
            <div>
                <p>Ajouter une description</p>
                <textarea class="w-full p-4 border border-gray-300 rounded-md resize-none" name="description" id="descr" rows="5"></textarea>
            </div>
            <button
                class="inline-block m-auto mt-4 lg:mt-8 px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:bg-gray-200 hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                type="submit">Ajouter le livre</button>
        </form>
    </div>

<script>
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const fileList = document.getElementById('fileList');

    const highlight = () => dropZone.style.backgroundColor = '#f0f0f0';
    const unhighlight = () => dropZone.style.backgroundColor = '';

    const updateFileList = () => {
        if (fileInput.files.length === 0) {
            fileList.textContent = '';
        } else if (fileInput.files.length === 1) {
            fileList.textContent = fileInput.files[0].name;
        } else {
            fileList.textContent = `${fileInput.files.length} fichiers sélectionnés`;
        }
    };

    dropZone.addEventListener('click', () => fileInput.click());

    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
        highlight();
    });

    dropZone.addEventListener('dragleave', e => {
        e.preventDefault();
        unhighlight();
    });

    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        unhighlight();

        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const dataTransfer = new DataTransfer();
            for (let i = 0; i < files.length; i++) {
                dataTransfer.items.add(files[i]);
            }
            fileInput.files = dataTransfer.files;
            updateFileList();
        }
    });

    fileInput.addEventListener('change', updateFileList);
</script>
</x-layouts.app>
