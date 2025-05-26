<!--
ETML
Auteur: Maël Gétain
Date: 21.05.2025
Description: Page d'inventaire des pièces LEGO
-->
@include('components.head')
@php
$error = 0;
@endphp
<main class="flex-grow">
    <!-- Résultats -->
    @foreach($inventory as $item => $value)
    <div class="w-[800px] mb-3 overflow-hidden transform transition-transform duration-500 hover:-translate-y-2 shadow-xl">
        <div class="w-full h-full mx-auto p-6 bg-white rounded-[20px] shadow-md">
            <ul class="divide-y divide-gray-200">

                <div class="flex flex-col">
                    <h3 class="text-xl font-bold text-primary mb-6">{{$value['name']}} - {{$value['class']}}</h3>
                    @foreach($value['pieces'] as $val)
                    @if($item == $id)
                        @if(isset($scanned) && isset($scanned[$val['id']]) && $scanned[$val['id']] == $val['quantite'])
                        <li class="flex items-center p-4 bg-green-100 hover:bg-gray-50 border-b border-[#C7C7CC] transition-colors duration-150 ease-in-out mb-2">
                            <div class="flex items-center justify-center">
                                <span class="text-primary font-bold">{{$val['numero']}} - {{$val['couleur']}}</span>
                            </div>
                            <div class="ml-4 flex-grow">
                                <p class="text-lg font-medium text-primary">{{$val['description']}}</p>
                            </div>
                            <div class="flex items-center gap-x-4">
                                <p class="text-primary">{{$val['quantite']}}x</p>
                            </div>
                        </li>
                        @elseif(isset($scanned[$val['id']]) && $scanned[$val['id']] != $val['quantite'])
                        <li class="flex items-center p-4 bg-red-100 hover:bg-gray-50 border-b border-[#C7C7CC] transition-colors duration-150 ease-in-out mb-2">
                            <div class="flex items-center justify-center">
                                <span class="text-primary font-bold">{{$val['numero']}} - {{$val['couleur']}}</span>
                            </div>
                            <div class="ml-4 flex-grow">
                                <p class="text-lg font-medium text-primary">{{$val['description']}}</p>
                            </div>
                            <div class="flex items-center gap-x-4">
                                <p class="text-primary">{{$scanned[$val['id']]}} sur {{$val['quantite']}} !!</p>
                            </div>
                        </li>
                        @php
                            $error = 1;
                        @endphp
                        @else
                        <li class="flex items-center p-4 bg-red-100 hover:bg-gray-50 border-b border-[#C7C7CC] transition-colors duration-150 ease-in-out mb-2">
                            <div class="flex items-center justify-center">
                                <span class="text-primary font-bold">{{$val['numero']}} - {{$val['couleur']}}</span>
                            </div>
                            <div class="ml-4 flex-grow">
                                <p class="text-lg font-medium text-primary">{{$val['description']}}</p>
                            </div>
                            <div class="flex items-center gap-x-4">
                                <p class="text-primary">0x</p>
                            </div>
                        </li>
                        @php
                            $error = 1;
                        @endphp
                        @endif
                    @else
                        <li class="flex items-center p-4 hover:bg-gray-50 border-b border-[#C7C7CC] transition-colors duration-150 ease-in-out mb-2">
                            <div class="flex items-center justify-center">
                                <span class="text-primary font-bold">{{$val['numero']}} - {{$val['couleur']}}</span>
                            </div>
                            <div class="ml-4 flex-grow">
                                <p class="text-lg font-medium text-primary">{{$val['description']}}</p>
                            </div>
                            <div class="flex items-center gap-x-4">
                                <p class="text-primary">{{$val['quantite']}}x</p>
                            </div>
                        </li>
                    @endif
                    @endforeach
                    @if($error == 0 && $item == $id)
                    <a href="{{url('delete/'. $item)}}" class="flex-end ml-auto">
                        <button type="button" class="w-[200px] h-[40px] text-white bg-button font-medium text-sm text-center rounded-[10px] flex-end ml-auto mt-[40px]">
                            Finaliser
                        </button>
                    </a>
                    @else
                    <a href="{{url('verify/'. $item)}}" class="flex-end ml-auto">
                        <button type="button" class="w-[200px] h-[40px] text-white bg-button font-medium text-sm text-center rounded-[10px] flex-end ml-auto mt-[40px]">
                            Retourner
                        </button>
                    </a>
                    @endif
                </div>
            </ul>
        </div>
    </div>
    @endforeach
</main>

<div class="mt-[30px] mb-[33px]">
    <p class="text-primary bottom-[10px]">Maël Gétain - TPI</p>
</div>
</body>

</html>