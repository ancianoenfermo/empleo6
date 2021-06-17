<nav class="bg-gray-800">

    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
            <!-- Mobile menu button-->
            <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                <button type="button"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
                    aria-controls="mobile-menu" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <!--
              Icon when menu is closed.

              Heroicon name: outline/menu

              Menu open: "hidden", Menu closed: "block"
            -->
                    <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!--
              Icon when menu is open.

              Heroicon name: outline/x

              Menu open: "block", Menu closed: "hidden"
            -->
                    <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            {{-- Logo y menu --}}
            <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
                {{-- Logotipo --}}
                <div class="flex-shrink-0 flex items-center">
                    <img class="block lg:hidden h-8 w-auto"
                        src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow">
                    <img class="hidden lg:block h-8 w-auto"
                        src="https://tailwindui.com/img/logos/workflow-logo-indigo-500-mark-white-text.svg"
                        alt="Workflow">
                </div>
                {{-- Menu Lg --}}
                <div class="hidden sm:block sm:ml-6">
                    <div class="flex space-x-4">
                        <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                        <span class="bg-gray-900 text-white px-3 py-2 text-sm font-medium">
                            Titulo
                        </span>

                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- AUTONOMIAS --}}
    <form method="GET" action="{{route('getJobs')}}">
        <div class="relative inline-flex">
            <div class="form-group row text-gray-500 mt-5">
                <div>
                    <select name="autonomia" class="form-control w-full bg-white-500 h-8 text-xs  rounded-lg">
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
        </div>

        {{-- PROVINCIAS --}}
        <div class="relative inline-flex">
            <div class="form-group row text-gray-500 mt-5">
                <div>
                    <select name="provincia" class="form-control w-full bg-white-500 h-8 text-xs  rounded-lg">
                        @if(isset($selectedAutonomia))
                            <option value="" href="{{ route('getJobs'). '/' . $selectedAutonomia}}">Todas las Provincias</option>
                        @else
                            <option value="" href="{{ route('getJobs')}}">Todas las Provincias</option>
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
            </div>
        </div>
        {{-- LOCALIDADES --}}
        <div class="relative inline-flex">
            <div class="form-group row text-gray-500 mt-5">
                <div>
                    <select name="localidad" class="form-control w-full bg-white-500 h-8 text-xs  rounded-lg">
                        @if(isset($selectedProvincia))
                            <option value="" href="{{ route('getJobs'). '/' . $selectedAutonomia . '/'. $selectedProvincia}}">Todas las Localidades</option>
                        @else
                            <option value="" href="{{ route('getJobs')}}">Todas las Localidades</option>
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
            </div>
        </div>
    </form>



    <br><br>
    <!-- Mobile menu, show/hide based on menu state. -->
    <div class="sm:hidden" id="mobile-menu">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="#" class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium"
                aria-current="page">Dashboard</a>

            <a href="#"
                class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Team</a>

            <a href="#"
                class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Projects</a>

            <a href="#"
                class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Calendar</a>
        </div>
    </div>
</nav>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).on('change', 'select.form-control', function() {
        let get_val = event.target.selectedOptions[0].getAttribute("href");
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



{{--
<div class="relative inline-flex">
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
        </div>

--}}
