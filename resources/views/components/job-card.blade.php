<div class="p-5">
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
</div>
