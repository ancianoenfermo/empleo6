<div class="relative inline-flex">
    <div class="form-group row text-gray-500 mt-5">
        <div>
            <select class="form-control w-full bg-white-500 h-8 text-xs  rounded-lg">
                <option value="">Todas las Autonomías</option>
                @foreach ($datas as $data)
                    <option value="{{ $data->id }}">{{ $data->name }}</option>
                @endforeach
            </select>
        </div>

    </div>
</div>
