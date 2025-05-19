@include('components.head')
        <main class="flex-grow">
            <!-- Résultats -->
             @foreach($inventory as $item => $value)
            <div class="w-[800px] mb-3 overflow-hidden transform transition-transform duration-500 hover:-translate-y-2 shadow-xl">
                <div class="w-full h-full mx-auto p-6 bg-white rounded-[20px] shadow-md">
                    <ul class="divide-y divide-gray-200">
                        
                        <div class="flex flex-col">
                                <h3 class="text-xl font-bold text-[#0A2472] mb-6">{{$item}}</h3>
                                @foreach($value as $val)
                                <li class="flex items-center p-4 hover:bg-gray-50 border-b border-[#C7C7CC] transition-colors duration-150 ease-in-out mb-2">
                                    <div class="flex items-center justify-center">
                                        <span class="text-[#0A2472] font-bold">{{$val->pie_numero}} - {{$val->pie_couleur}}</span>
                                    </div>
                                    <div class="ml-4 flex-grow">
                                        <p class="text-lg font-medium text-[#0A2472]">{{$val->pie_description}}</p>
                                    </div>
                                    <div class="flex items-center gap-x-4">
                                        <p class="text-[#0A2472]">{{$val->pos_quantite}}x</p>
                                    </div>
                                </li>
                                @endforeach
                                <a href="{{url('verify/'. $val->ele_id)}}" class="flex-end ml-auto">
                                <button type="button" class="w-[200px] h-[40px] text-white bg-[#0E6BA8] font-medium text-sm text-center rounded-[10px] flex-end ml-auto mt-[40px]">
                                    Retourner
                                </button>
                                </a>
                        </div>
                    </ul>
                </div>
            </div>
            @endforeach
        </main>
        
        <div class="mt-[30px] mb-[33px]">
            <p class="text-[#0A2472] bottom-[10px]">Maël Gétain - TPI</p>
        </div>
    </body>
</html>