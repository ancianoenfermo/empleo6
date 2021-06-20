<div class="flex justify-start mb-6">
    <div class="w-full">
        <div class="flex">

            <div class="flex flex-col flex-1 ml-4 bg-gray-50 border-gray-400 p-2 mt-2 rounded-sm shadow-lg ">


                <div class="-mt-5 text-start">
                    <span class="p-1 text-xs font-bold mb-6  bg-gray-200 rounded">{{ $job->dateHumana }}</span>
                    @isset($job->discapacidad)
                        <span style="padding-top: 0.2em; padding-bottom: 0.2rem"
                            class="space-x-1 text-xs px-2 ml-5 bg-green-50 border border-bg-green-900 text-green-800 rounded-full">
                            Discapacidad
                        </span>
                    @endisset

                    @isset($job->practicas)
                        <span style="padding-top: 0.2em; padding-bottom: 0.2rem"
                            class="space-x-1 text-xs px-2 ml-5 bg-red-50 border border-bg-red-900 text-red-800 rounded-full">
                            Prácticas
                        </span>
                    @endisset
                    @isset($job->teletrabajo)
                        <span style="padding-top: 0.2em; padding-bottom: 0.2rem"
                            class="space-x-1 text-xs px-2 ml-5 bg-indigo-50 border border-bg-indigo-900 text-indigo-800 rounded-full">
                            Teletrabajo
                        </span>
                    @endisset
                    @isset($job->ett)
                        <span style="padding-top: 0.2em; padding-bottom: 0.2rem"
                            class="mb-2 inline-flex items-center space-x-1 text-xs px-2 ml-5 bg-blue-50 border border-bg-blue-900 text-blue-800 rounded-full">
                            ETT
                        </span>
                    @endisset


                </div>

                <div class="mt-1 ml-5 pt-2">
                    <div class="flex font-sans">
                        <p class="font-semibold">{{ $job->localidad }}</p>
                        @if ($job->provincia != $job->localidad)
                            <p class="ml-2">( {{ $job->provincia }} )</p>
                        @endif
                        <div class="ml-10">
                        </div>
                    </div>
                    <h3 class="ml-5 font-sans text-xl font-semibold ">{{ $job->title }}</h3>

                    <p class="ml-5 font-sans">{{ $job->excerpt }}</p>
                    <div class="mt-2 border-t-2">
                        <div class="mt-2">
                            @isset($job->contrato)
                                <span
                                    class="mr-4 items-center justify-center px-2 py-1 text-xs font-bold leading-none text-black">
                                    <strong>Contrato:</strong>
                                    <span class="px-1 font-semibold">{{ $job->contrato }}</span>
                                </span>
                            @endisset
                            @isset($job->jornada)
                                <span
                                    class="mr-4 items-center justify-center px-2 py-1 text-xs font-bold leading-none text-black ">
                                    <strong>Jornada:</strong>
                                    <span class="px-1 font-semibold">{{ $job->jornada }}</span>
                                </span>
                            @endisset
                            @isset($job->salario)
                                <span
                                    class="mr-4 items-center justify-center px-2 py-1 text-xs font-bold leading-none text-black">
                                    <strong>Salario:</strong>
                                    <span class="px-1 font-semibold">{{ $job->salario }}</span>
                                </span>
                            @endisset
                            @isset($job->vacantes)
                                <span
                                    class="mr-4 items-center justify-center px-2 py-1 text-xs font-bold leading-none text-black">
                                    <strong>Vacantes:</strong>
                                    <span class="px-1 font-semibold">{{ $job->vacantes }}</span>
                                </span>
                            @endisset
                            @isset($job->experiencia)
                                <span
                                    class="mr-4 items-center justify-center px-2 py-1 text-xs font-bold leading-none text-black ">
                                    <strong>Experiencia:</strong>
                                    <span class="px-1 font-semibold">Requerida</span>
                                </span>
                            @endisset


                        </div>
                    </div>
                </div>

            </div>

            <div class="flex flex-col ml-4 justify-center ">

                <div class="items-center">
                        <span class=" font-sans text-xs">
                            Publicado el {{ Carbon\Carbon::parse($job->datePosted)->format('d-m-Y') }}
                        </span>
                        <span>
                            <img class="mx-auto" src="{{ 'storage/logo_images/' . $job->logo }}">
                        </span>

                        <button
                            class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-1 px-2 border-b-4 border-blue-700 hover:border-blue-500 rounded"
                            onclick="window.open('{{ $job->JobUrl }}')">
                            <i class="fas fa-glasses"></i>
                            <span class="ml-2 text-sm">Ir a la oferta</span>
                        </button>

                </div>
            </div>


        </div>
    </div>

</div>



{{-- <div class="p-5">
    <!--Card 1-->
    <div class=" w-full lg:max-w-full border-4 border-gray-400 rounded-lg">

            <div
                class="ml-5 mt-2 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-indigo-100 bg-indigo-700 rounded">
                {{ $job->dateHumana }}
            </div>
            <div class=" bg-white  p-4 flex flex-col justify-between leading-normal">
                <div class="mb-8">
                    <p class="text-sm text-gray-600 flex items-center">

                        Members only
                    </p>
                    <div class="text-gray-900 font-bold text-xl mb-2 ">{{ $job->title }}</div>
                    <p class="text-gray-700 text-base w-full ">{{ $job->excerpt }}</p>
                </div>

            </div>

    </div>
</div> --}}
