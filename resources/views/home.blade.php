@include('components.head')
            <!-- Formulaire de devinage -->
            <div class="w-[800px] h-[340px] mb-8 overflow-hidden transform transition-transform duration-500 hover:-translate-y-2 shadow-xl">
                <form method="POST" action="{{route('submit')}}" accept-charset="UTF-8" enctype="multipart/form-data" class="w-full h-full mx-auto p-6 bg-white rounded-[20px] ">
                    @csrf
                    <div class="mb-4 flex justify-between">
                        <div class="flex flex-col">
                            <label for="name" class="mb-2 font-medium text-[#0A2472]">Nom de l'élève</label>
                            <input type="input" name="name" id="name" class="w-[350px] h-[50px] bg-[#F2F2F7] rounded-[20px] indent-4" >
                        </div>
                        <div class="flex flex-col">
                            <label for="name" class="mb-2 font-medium text-[#0A2472]">Classe</label>
                            <input type="input" name="class" id="class" class="w-[350px] h-[50px] bg-[#F2F2F7] rounded-[20px] indent-4" >
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="flex flex-col">
                            <label for="image" class="flex justify-center items-center w-[750px] h-[130px] bg-[#F2F2F7] text-[#8E8E93] rounded-[20px] border-2 border-dashed border-[#0E6BA8]">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-icon lucide-image p-1"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                                Déposer un fichier ou cliquer pour prendre une photo
                            </label>
                            <input type="file" name="image" id="image" class="hidden" accept="image/*">
                        </div>
                    </div>
                    <div class="w-full flex justify-center h-[40px]">
                        <button type="submit" class="rounded-[10px] font-semibold bg-[#0E6BA8] text-white w-[200px]">
                            Valider
                        </button>
                    </div>
                </form>
            </div>
    
            <!-- Résultats -->
            <div class="w-[800px] mb-3 overflow-hidden transform transition-transform duration-500 hover:-translate-y-2 shadow-xl">
                <div class="w-full h-full mx-auto p-6 bg-white rounded-[20px] shadow-md">
                    <ul class="divide-y divide-gray-200">
                        
                        <div class="flex flex-col">
                            @if(is_array($val))
                                <h3 class="text-xl font-bold text-[#0A2472] mb-6">{{$name}} - {{$class}}</h3>
                                @foreach($val['results'] as $item)
                                <li class="flex items-center p-4 hover:bg-gray-50 border-b border-[#C7C7CC] transition-colors duration-150 ease-in-out mb-2">
                                    <div class="flex items-center justify-center">
                                        <span class="text-[#0A2472] text-lg font-bold">{{$item['label']}}</span>
                                    </div>
                                    <div class="ml-4 flex-grow">
                                        <p class="font-medium text-[#0A2472] text-gray-900 dark:text-gray-100">{{$desc[$item['label']]}}</p>
                                    </div>
                                    <div class="flex items-center gap-x-4">
                                        <button class="text-[#0A2472] minus-btn" id="{{$item['label']}}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus-icon lucide-minus"><path d="M5 12h14"/></svg></button>
                                        <p class="text-[#0A2472] font-bold" id="content-{{$item['label']}}">{{print(array_search($item['label'],$num))}}</p>
                                        <button class="text-[#0A2472] plus-btn" id="{{$item['label']}}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg></button>
                                    </div>
                                </li>
                                @endforeach
                                <div id="newContainer">
                                </div>
                                <button type="button" class="text-white bg-[#0E6BA8] font-medium rounded-full text-sm p-2.5 text-center ml-auto" id="addButton">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                </button>
                            @else
                                <h3 class="flex justify-center text-xl font-bold text-[#8E8E93] mb-6">Aucune pièce scannées</h3>
                                <label class=" flex justify-center text-[#8E8E93]">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-frown-icon lucide-frown"><circle cx="12" cy="12" r="10"/><path d="M16 16s-1.5-2-4-2-4 2-4 2"/><line x1="9" x2="9.01" y1="9" y2="9"/><line x1="15" x2="15.01" y1="9" y2="9"/></svg>
                                </label>
                            @endif
                        </div>
                        
                    </ul>
                </div>
            </div>
            @if(is_array($val))
            <button class="flex justify-center items-center rounded-[10px] w-[200px] h-[40px] text-white font-semibold bg-[#0E6BA8]">
                Inventorier
            </button>
            @endif
            <div class="mt-[30px]">
                <p class="text-[#0A2472]">Maël Gétain - TPI</p>
            </div>
    </body>
    <script>
        document.getElementById('addButton').addEventListener('click', function() {
            var oldInput = document.getElementById('newInput');
            if (oldInput) {
                oldInput.setAttribute('id', 'oldInput');
            }
            const newContainer = document.getElementById('newContainer');
            newContainer.innerHTML += `
            <li class="flex items-center p-4 hover:bg-gray-50 border-b border-[#C7C7CC] transition-colors duration-150 ease-in-out mb-2">
                <div class="flex items-center justify-center">
                    <input type="text" id="newInput"/>
                </div>
                <div class="ml-4 flex-grow">
                    <p class="text-lg font-medium text-gray-900 dark:text-gray-100">description</p>
                </div>
                <div class="flex items-center gap-x-4">
                    <button><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus-icon lucide-minus"><path d="M5 12h14"/></svg></button>
                    <button><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg></button>
                </div>
            </li>
            `;
            var input = document.getElementById('newInput');
            input.focus();
            input.select();
        });
        

        document.querySelectorAll('.plus-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                updatePieceCount(this.id, 1);
            });
        });

        document.querySelectorAll('.minus-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                updatePieceCount(this.id, -1);
            });
        });
        /*csrf token is not same as cookie*/
        function updatePieceCount(label, delta) {
            fetch('/update-piece-count', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ label: label, delta: delta })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    document.getElementById('content-' + label).textContent = data.count;
                }
            });
        }

    </script>
</html>
