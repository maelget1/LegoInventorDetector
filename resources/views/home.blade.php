<!--
ETML
Auteur: Maël Gétain
Date: 21.05.2025
Description: Page d'accueil mais aussi de scan de pièces LEGO
-->
@include('components.head')
@include('sweetalert2::index')

@php
$num = session('num', []);
$val = session('val', []);
$newId = session('id', $id);
@endphp
<!-- Formulaire de scan -->
<div class="w-[800px] h-[340px] mb-8 overflow-hidden transform transition-transform duration-500 hover:-translate-y-2 shadow-xl">
    <form method="POST" action="{{route('submit')}}" accept-charset="UTF-8" enctype="multipart/form-data" class="w-full h-full mx-auto p-6 bg-white rounded-[20px]">
        @csrf
        <div class="mb-4 flex justify-between">
            @if($newId === 0)
            <div class="flex flex-col">
                <label for="name" class="mb-2 font-medium text-[#0A2472]">Nom de l'élève</label>
                <input type="input" name="name" id="name" class="w-[350px] h-[50px] bg-[#F2F2F7] rounded-[20px] indent-4">
            </div>
            <div class="flex flex-col">
                <label for="class" class="mb-2 font-medium text-[#0A2472]">Classe</label>
                <input type="input" name="class" id="class" class="w-[350px] h-[50px] bg-[#F2F2F7] rounded-[20px] indent-4">
            </div>
            <input type="hidden" name="id" id="id" value="{{$id}}">
            @else
            <div class="flex flex-col">
                <label for="name" class="mb-2 font-medium text-[#0A2472]">Nom de l'élève</label>
                <input type="text" name="name" id="name" value="{{$name}}" class="w-[350px] h-[50px] bg-[#F2F2F7] rounded-[20px] indent-4" readonly>
            </div>
            <div class="flex flex-col">
                <label for="class" class="mb-2 font-medium text-[#0A2472]">Classe</label>
                <input type="text" name="class" id="class" value="{{$class}}" class="w-[350px] h-[50px] bg-[#F2F2F7] rounded-[20px] indent-4" readonly>
            </div>
            <input type="hidden" name="id" id="id" value="{{$id}}">
            @endif
        </div>
        <div class="mb-4">
            <div class="flex flex-col">
                <label for="image" class="flex justify-center items-center w-[750px] h-[130px] bg-[#F2F2F7] text-[#8E8E93] rounded-[20px] border-2 border-dashed border-[#0E6BA8]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-image-icon lucide-image p-1">
                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                        <circle cx="9" cy="9" r="2" />
                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                    </svg>
                    Déposer un fichier ou cliquer pour prendre une photo
                </label>
                <input type="file" name="image" id="image" class="hidden" accept="image/*" onchange="changeText()" capture="environment" required>
            </div>
        </div>
        <div class="w-full flex justify-center h-[40px]">
            @if($newId === 0)
            <button type="submit" class="rounded-[10px] font-semibold bg-[#0E6BA8] text-white w-[200px]">
                Valider
            </button>
            @else
            <button type="submit" class="rounded-[10px] font-semibold bg-[#0E6BA8] text-white w-[200px]">
                Valider le retour
            </button>
            @endif
        </div>
    </form>
</div>

<!-- Résultats -->
<div class="w-[800px] mb-3 overflow-hidden transform transition-transform duration-500 hover:-translate-y-2 shadow-xl">
    <div class="w-full h-full mx-auto p-6 bg-white rounded-[20px] shadow-md">
        <ul class="divide-y divide-gray-200">

            <div class="flex flex-col">
                @if(is_array($val) && is_array($desc))
                <h3 class="text-xl font-bold text-[#0A2472] mb-6">{{$name}} - {{$class}}</h3>
                @foreach($val['results'] as $item)
                <li class="flex items-center p-4 hover:bg-gray-50 border-b border-[#C7C7CC] transition-colors duration-150 ease-in-out mb-2" id="li-{{$item['label']}}">
                    <div class="flex items-center justify-center">
                        <span class="text-[#0A2472] text-lg font-bold">{{$item['label']}}</span>
                    </div>
                    <div class="ml-4 flex-grow">
                        <p class="font-medium text-[#0A2472]">{{$desc[$item['label']]}}</p>
                    </div>
                    <div class="flex items-center gap-x-4">
                        <button class="text-[#0A2472] bin_btn" id="bin_{{$item['label']}}" onclick="remove(this.id)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2">
                                <path d="M3 6h18" />
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                <line x1="10" x2="10" y1="11" y2="17" />
                                <line x1="14" x2="14" y1="11" y2="17" />
                            </svg></button>
                        <button class="text-[#0A2472] minus-btn hidden" id="min_{{$item['label']}}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus-icon lucide-minus">
                                <path d="M5 12h14" />
                            </svg></button>
                        <p class="text-[#0A2472] font-bold" id="content-{{$item['label']}}">{{$num[$item['label']]}}</p>
                        <button class="text-[#0A2472] plus-btn" id="add_{{$item['label']}}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus">
                                <path d="M5 12h14" />
                                <path d="M12 5v14" />
                            </svg></button>
                    </div>
                </li>
                @endforeach
                <div id="newContainer">
                </div>
                <button type="button" class="text-white bg-[#0E6BA8] font-medium rounded-full text-sm p-2.5 text-center ml-auto" id="addButton">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus">
                        <path d="M5 12h14" />
                        <path d="M12 5v14" />
                    </svg>
                </button>
                @else
                <h3 class="flex justify-center text-xl font-bold text-[#8E8E93] mb-6">Aucune pièce scannée</h3>
                <label class=" flex justify-center text-[#8E8E93]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="96" height="96" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-frown-icon lucide-frown">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M16 16s-1.5-2-4-2-4 2-4 2" />
                        <line x1="9" x2="9.01" y1="9" y2="9" />
                        <line x1="15" x2="15.01" y1="9" y2="9" />
                    </svg>
                </label>
                @endif
            </div>

        </ul>
    </div>
</div>
@if(is_array($val))
@if($newId !== 0)
<form method="POST" action="{{route('check')}}" accept-charset="UTF-8">
    @csrf
    <input type="hidden" name="id" value="{{$id}}">
    <button class="flex justify-center items-center rounded-[10px] w-[200px] h-[40px] text-white font-semibold bg-[#0E6BA8]">
        Vérifier
    </button>
</form>
@else
<form method="POST" action="{{route('inventory')}}" accept-charset="UTF-8">
    @csrf
    <input type="hidden" name="name" value="{{$name}}">
    <input type="hidden" name="class" value="{{$class}}">
    <button class="flex justify-center items-center rounded-[10px] w-[200px] h-[40px] text-white font-semibold bg-[#0E6BA8]">
        Inventorier
    </button>
</form>
@endif
@endif
<div class="mt-[30px]">
    <p class="text-[#0A2472]">Maël Gétain - TPI</p>
</div>
<script>
    var count = 0;

    function remove(id) {
        let token = '{{ csrf_token() }}';
        let label = id.split('_')[1];
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
        $.ajax({
            type: 'POST',
            url: '/remove-item',
            data: {
                label: label,
            },
            success: function(response) {
                document.getElementById('li-' + label).remove();
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        })
    }


    document.getElementById('addButton').addEventListener('click', function() {
        const newContainer = document.getElementById('newContainer');
        newContainer.innerHTML += `
            <li class="flex items-center p-4 hover:bg-gray-50 border-b border-[#C7C7CC] transition-colors duration-150 ease-in-out mb-2" id="li-` + count + `">
                <div class="flex items-center justify-center" id="div-` + count + `">
                    <input type="text" id="` + count + `" onchange="searchDescription(this.id)" list="o-` + count + `"/>
                    <datalist id="o-` + count + `">
                        @foreach($bricks as $val)
                            <option value="{{$val}}">{{$val}}</option>
                        @endforeach
                    </datalist>
                </div>
                <div class="ml-4 flex-grow">
                    <p class="font-medium text-[#0A2472]" id="` + count + `-desc">description</p>
                </div>
                <div class="flex items-center gap-x-4 hidden" id="p-` + count + `">
                        <button class="text-[#0A2472] bin_btn" id="b1-` + count + `" onclick="remove(this.id)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2">
                                <path d="M3 6h18" />
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                <line x1="10" x2="10" y1="11" y2="17" />
                                <line x1="14" x2="14" y1="11" y2="17" />
                            </svg></button>
                        <button class="text-[#0A2472] minus-btn hidden" id="b2-` + count + `"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus-icon lucide-minus">
                                <path d="M5 12h14" />
                            </svg></button>
                        <p class="text-[#0A2472] font-bold" id="content-` + count + `">1</p>
                        <button class="text-[#0A2472] plus-btn" id="b3-` + count + `"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus-icon lucide-plus">
                                <path d="M5 12h14" />
                                <path d="M12 5v14" />
                            </svg></button>
                    </div>
            </li>
            `;
        var input = document.getElementById(count);
        input.focus();
        input.select();
    });
    if (document.getElementById(count)) {

        // Récupère la liste entière des options
        let options = Array.from(document.querySelectorAll('#o-' + count + ' option')).map((option) => option.value);

        document.getElementById(count).addEventListener('input', function() {
            const hint = this.value.toLowerCase();
            // Récupère les options qui contiennent la partie écrite (hint)
            const suggestions = options.filter((option) => option.toLowerCase().includes(hint));

            console.log(suggestions);
        });
    }



    document.querySelectorAll('.plus-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let val = this.id.split('_')[1];
            updatePieceCount(val, 1);
        });
    });

    document.querySelectorAll('.minus-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let val = this.id.split('_')[1];
            updatePieceCount(val, -1);
        });
    });


    function updateButtons(input) {
        // Get the latest added buttons only
        const latestInput = document.getElementById('add_' + input);
        const latestMinus = document.getElementById('min_' + input);

        if (latestInput) {
            latestInput.addEventListener('click', function() {
                let val = this.id.split('_')[1];
                updatePieceCount(val, 1);
            });
        }

        if (latestMinus) {
            latestMinus.addEventListener('click', function() {
                let val = this.id.split('_')[1];
                updatePieceCount(val, -1);
            });
        }
    }

    /*csrf token is not same as cookie*/
    function updatePieceCount(label, delta) {
        let token = '{{ csrf_token() }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
        $.ajax({
            type: 'POST',
            url: '/update-piece-count',
            data: {
                label: label,
                delta: delta,
            },
            success: function(response) {
                // Update the counter
                const counter = document.getElementById('content-' + label);
                const newValue = parseInt(counter.textContent) + delta;
                counter.textContent = newValue;

                // Get both button versions
                const minusBtn = document.getElementById('min_' + label);
                const binBtn = document.getElementById('bin_' + label);

                // Show/hide appropriate button based on count
                if (newValue > 1) {
                    minusBtn.classList.remove('hidden');
                    binBtn.classList.add('hidden');
                } else {
                    minusBtn.classList.add('hidden');
                    binBtn.classList.remove('hidden');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        })
    }

    function searchDescription(id) {
        var input = document.getElementById(id).value;
        let token = '{{ csrf_token() }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
        $.ajax({
            type: 'POST',
            url: '/search-description',
            data: {
                input: input,
            },
            success: function(response) {
                // Update the description
                const description = document.getElementById(id + '-desc');
                description.textContent = response.description;
                document.getElementById('div-' + id).innerHTML = `
                <span class="text-[#0A2472] text-lg font-bold">` + input + `</span>
                `;
                document.getElementById('p-' + id).classList.remove('hidden');
                document.getElementById('b1-' + id).setAttribute('id', 'bin_' + input);
                document.getElementById('b2-' + id).setAttribute('id', 'min_' + input);
                document.getElementById('b3-' + id).setAttribute('id', 'add_' + input);
                document.getElementById('content-' + id).setAttribute('id', 'content-' + input);
                document.getElementById('li-' + id).setAttribute('id', 'li-' + input);
                addItem(input);
                count++;
                updateButtons(input);
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        })
    }

    function addItem(input) {
        let token = '{{ csrf_token() }}';
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': token
            }
        });
        $.ajax({
            type: 'POST',
            url: '/add-item',
            data: {
                input: input,
            },
            success: function(response) {
                //rien de spécial
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);
            }
        })
    }

    function changeText() {
        const label = document.querySelector('label[for="image"]');
        label.textContent = "Une image a bien été ajoutée";
    }

</script>
</body>

</html>