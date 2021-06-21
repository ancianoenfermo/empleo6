<header class="bg-gray-800">
    <div class="flex">
        <div class="flex flex-col items-center justify-center ml-10">
            <div class="mt-5">
                <img class="block lg:hidden h-8 w-auto"
                    src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow">
                <img class="hidden lg:block h-8 w-auto"
                    src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg" alt="Workflow">
            </div>

        </div>
        <div class="flex flex-col flex-1 text-center justify-end ">
            <span class="text-white text-right mt-10 mr-10">Ofertas publidas en los últimos 30 días</span>
           <h1 class="text-2xl font-semibold text-white">{{$titleH1}}</h1>
        </div>
    </div>
    <div>
        <nav>
            {{-- AUTONOMIAS --}}
            <form class="flex justify-center space-x-8 text-sm mt-10 " method="GET" action="{{ route('getJobs') }}">
                <div class="form-group row text-gray-500 mt-5">
                    <label class="text-white ml-2" for="">Autonomia</label>
                    <select name="autonomia" class="form-control w-full bg-white-500 h-8 rounded-lg">
                        <option value="" href="{{ route('getJobs') }}">Todas las Autonomías</option>
                        @foreach ($autonomias as $autonomia)
                            <option value="{{ $autonomia->id }}"
                                href="{{ route('getJobs') . '/' . $autonomia->slug }}" @isset($selectedAutonomia) @if ($autonomia->slug == $selectedAutonomia) selected="selected" @endif @endisset>
                                {{ $autonomia->name }}
                            </option>
                        @endforeach
                    </select>
                </div>


                {{-- PROVINCIAS --}}

                <div class="form-group row text-gray-500 mt-5">
                    <label class="text-white ml-2" for="">Provincia</label>
                    <select name="provincia" class="form-control w-full bg-white-500 h-8  rounded-lg">
                        @if (isset($selectedAutonomia))
                            <option value="" href="{{ route('getJobs') . '/' . $selectedAutonomia }}">Todas las
                                Provincias</option>
                        @else
                            <option value="" href="{{ route('getJobs') }}">Todas las Provincias</option>
                        @endif
                        @isset($provincias)
                            @foreach ($provincias as $provincia)
                                <option value="{{ $provincia->id }}"
                                    href="{{ route('getJobs') . '/' . $selectedAutonomia . '/' . $provincia->slug }}"
                                    @isset($selectedProvincia) @if ($provincia->slug == $selectedProvincia) selected="selected" @endif @endisset>
                                    {{ $provincia->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>

                {{-- LOCALIDADES --}}

                <div class="form-group row text-gray-500 mt-5">
                    <label class="text-white ml-2" for="">Localidad</label>
                    <select name="localidad" class="form-control w-full bg-white-500 h-8 rounded-lg">
                        @if (isset($selectedProvincia))
                            <option value=""
                                href="{{ route('getJobs') . '/' . $selectedAutonomia . '/' . $selectedProvincia }}">
                                Todas las Localidades</option>
                        @else
                            <option value="" href="{{ route('getJobs') }}">Todas las Localidades</option>
                        @endif

                        @isset($localidades)
                            @foreach ($localidades as $localidad)
                                <option value="{{ $localidad->id }}"
                                    href="{{ route('getJobs') . '/' . $selectedAutonomia . '/' . $selectedProvincia . '/' . $localidad->slug }}"
                                    @isset($selectedLocalidad) @if ($localidad->slug == $selectedLocalidad) selected="selected" @endif @endisset>
                                    {{ $localidad->name }}
                                </option>
                            @endforeach
                        @endisset
                    </select>
                </div>
                {{-- TIPO DE TRABAJO --}}

                <div class="form-group row text-gray-500 mt-5">
                    <label class="text-white ml-2" for="">Tipo de trabajo</label>
                    <select name="tipo" class="form-control w-full bg-white-500 h-8 rounded-lg">
                            <option value="" >Todos los Trabajos</option>
                            <option value="1" href="{{url()->current()}}?discapacidad=1"
                                @isset($parametro) @if ($parametro == 'discapacidad' ) selected="selected" @endif @endisset
                                 >Con discapacidad</option>
                            <option value="2" href="{{url()->current()}}?practicas=1">En prácticas</option>
                            <option value="3" href="{{url()->current()}}?teletrabajo=1" >Teletrabajo</option>
                    </select>
                </div>

            </form>
        </nav>
        <br>
    </div>
</header>





<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).on('change', 'select.form-control', function() {
        let get_val = event.target.selectedOptions[0].getAttribute("href");
        if (!get_val) {
            alert('hola')
        }


        /*get_val = get_val + '/?dist=valor';
        console.log(get_val);
        */
        window.location.href = get_val;
    });

</script>

{{-- $(document).on('change', 'select.form-control', function() {
        var url = $('select.form-control option[value="' + $(this).val() + '"]').attr("href")
        window.location.href = url;
    });


$(function() {
        $("#changeAutonomia").on('change', function() {
            var url = $('#changeAutonomia option[value="' + $(this).val() + '"]').attr("href")
            urlfull = url;
            window.location.href = url;
        })

        $("#changeProvincia").on('change', function() {
            var url = $('#changeAutonomia option[value="' + $(this).val() + '"]').attr("href")
            alert(urlfull);
            window.location.href = url;
        })
    }); --}}



{{-- <div class="relative inline-flex">
            <div class="form-group row text-gray-500 mt-5">
                <div>
                    <select name="autonomia" class="form-control w-full bg-white-500 h-8 text-xs  rounded-lg"
                    onchange="javascript:this.form.submit()">
                        <option value="" href="{{ route('getJobs') }}">Todas las Autonomías</option>
                        @foreach ($autonomias as $autonomia)
                            <option value="{{ $autonomia->id }}" href="{{ route('getJobs') . '/' . $autonomia->slug }}"
                                @isset($selectedAutonomia) @if ($autonomia->slug == $selectedAutonomia) selected="selected" @endif @endisset>
                                {{ $autonomia->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div> --}}
