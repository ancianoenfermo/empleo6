<div class="grid grid-cols-12 gap-2 mt-10">

    {{-- LATERAL IZQUIERDO --}}
    <div class="col-span-1 flex-col items-center mx-auto">

        <p class="p-1 text-xs mb-2  bg-gray-200 rounded">{{ $job->dateHumana }}</p>

        @isset($job->discapacidad)
            <span style="padding-top: 0.2em; padding-bottom: 0.2rem"
                class="space-x-1 text-xs px-2  bg-green-50 border border-bg-green-900 text-green-800 rounded-full">
                Discapacidad
            </span>
        @endisset

        @isset($job->practicas)
            <span style="padding-top: 0.2em; padding-bottom: 0.2rem"
                class="space-x-1 text-xs px-2  bg-red-50 border border-bg-red-900 text-red-800 rounded-full">
                Prácticas
            </span>
        @endisset
        @isset($job->teletrabajo)
            <span style="padding-top: 0.2em; padding-bottom: 0.2rem"
                class="space-x-1 text-xs px-2  bg-indigo-50 border border-bg-indigo-900 text-indigo-800 rounded-full">
                Teletrabajo
            </span>
        @endisset
    </div>
    {{-- CENTRO (CARD) --}}
    <div class="col-span-9 shadow rounded-md bg-white  flex-col flex-1 pl-4">

        <h3 class="font-sans text-xl font-semibold ">{{ $job->title }}</h3>
        <p class="font-semibold inline-block">{{ $job->localidad }}</p>
        @if ($job->provincia != $job->localidad)
            <p class="ml-1 inline-block">( {{ $job->provincia }} )</p>
        @endif
        <p class="mt-2">{{ $job->excerpt }}</p>
        <div class="mt-2 mb-2">

            @isset($job->contrato)
                <span class="mr-4 items-center justify-center px-2 py-1 text-xs font-bold leading-none text-black">
                    <strong>Contrato:</strong>
                    <span class="px-1 font-semibold">{{ $job->contrato }}</span>
                </span>
            @endisset
            @isset($job->jornada)
                <span class="mr-4 items-center justify-center px-2 py-1 text-xs font-bold leading-none text-black ">
                    <strong>Jornada:</strong>
                    <span class="px-1 font-semibold">{{ $job->jornada }}</span>
                </span>
            @endisset
            @isset($job->salario)
                <span class="mr-4 items-center justify-center px-2 py-1 text-xs font-bold leading-none text-black">
                    <strong>Salario:</strong>
                    <span class="px-1 font-semibold">{{ $job->salario }}</span>
                </span>
            @endisset
            @isset($job->vacantes)
                <span class="mr-4 items-center justify-center px-2 py-1 text-xs font-bold leading-none text-black">
                    <strong>Vacantes:</strong>
                    <span class="px-1 font-semibold">{{ $job->vacantes }}</span>
                </span>
            @endisset
            @isset($job->experiencia)
                <span class="mr-4 items-center justify-center px-2 py-1 text-xs font-bold leading-none text-black ">
                    <strong>Experiencia:</strong>
                    <span class="px-1 font-semibold">Requerida</span>
                </span>
            @endisset

        </div>

    </div>
    {{-- LATERAL DERECHO (FUENTE) --}}
    <div class="col-span-2 items-center mx-auto my-auto ">
        <span class=" font-sans text-xs">
            Publicado el {{ Carbon\Carbon::parse($job->datePosted)->format('d-m-Y') }}
        </span>
        <span>
            <img class="mx-auto" src="{{ 'storage/logo_images/' . $job->logo }}">
        </span>

        <button
            class="bg-blue-500 hover:bg-blue-400 text-white font-bold px-2 mt-3 border-b-4 border-blue-700 hover:border-blue-500 rounded"
            onclick="window.open('{{ $job->JobUrl }}')">
            <i class="fas fa-glasses"></i>
            <span class="ml-2 text-sm">Ir a la oferta</span>
        </button>

    </div>
</div>
