@include('components.head')
            <!-- Formulaire de devinage -->
            <div class="w-[800px] h-[340px] mb-8 overflow-hidden transform transition-transform duration-500 hover:-translate-y-2 shadow-xl">
                <form method="POST" action="{{route('submit')}}" accept-charset="UTF-8" enctype="multipart/form-data" class="w-full h-full mx-auto p-6 bg-white rounded-[20px] ">
                    @csrf
                    <div class="mb-4 flex justify-between">
                        <div class="flex flex-col">
                            <label for="name" class="mb-2 font-medium text-[#0A2472]">Nom de l'élève</label>
                            <input type="input" name="name" id="name" class="w-[350px] h-[50px] bg-[#F2F2F7] rounded-[20px]" >
                        </div>
                        <div class="flex flex-col">
                            <label for="name" class="mb-2 font-medium text-[#0A2472]">Classe</label>
                            <input type="input" name="class" id="class" class="w-[350px] h-[50px] bg-[#F2F2F7] rounded-[20px]" >
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
                                <h3 class="text-xl font-bold text-[#0A2472] mb-6">{{$name}} - {{$class}}</h3>
                                <li class="flex items-center p-4 hover:bg-gray-50 border-b border-[#C7C7CC] transition-colors duration-150 ease-in-out mb-2">
                                    <div class="flex items-center justify-center">
                                        <span class="text-[#0A2472] font-bold">#</span>
                                    </div>
                                    <div class="ml-4 flex-grow">
                                        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">{{var_dump($val)}}</p>
                                    </div>
                                    <div class="flex items-center gap-x-4">
                                        <button><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus-icon lucide-minus"><path d="M5 12h14"/></svg></button>
                                        <button><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg></button>
                                    </div>
                                </li>
                                <div id="newContainer">
                                </div>
                                <button type="button" class="text-white bg-[#0E6BA8] font-medium rounded-full text-sm p-2.5 text-center ml-auto" id="addButton">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                </button>
                        </div>
                        
                    </ul>
                </div>
            </div>
            <button class="flex justify-center items-center rounded-[10px] w-[200px] h-[40px] text-white font-semibold bg-[#0E6BA8]">
                Inventorier
            </button>
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
                
    </script>
</html>
