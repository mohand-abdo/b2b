<div  class ="row">
<div class="col">
    <label> من حساب</label>
     <select wire:model="selectedState" required name="Dain" class="form-control">
                <option value="">اختر حساب </option>
                @foreach ($tree4 as $tree)
                    <option value="{{$tree->tree4_code}}">{{$tree->tree4_name}}</option>
                @endforeach
            </select>
</div>

<div class="col">
    <label for="inputName" class="control-label"> الى حساب</label>
     <select required  name="Madin" class="form-control">
                <option value="" selected>اختر حساب </option>
                @foreach ($tree4_2 as $tree)
                    {{-- @if (!is_null($selectedState)) --}}
                        <option value="{{$tree->tree4_code}}">{{$tree->tree4_name}}</option>
                    {{-- @endif --}}
                @endforeach
            </select>
</div>

</div>



