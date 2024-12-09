<div class="row">

    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('invoices.store') }}" method="post" enctype="multipart/form-data"
                    autocomplete="off">
                    {{ csrf_field() }}
                    {{-- 1 --}}
                    <p style="color: red">{{$erorr_2}}</p>
                    <div class="row">
                        {{-- <div class="col-md-2">
                            <label> الرقم</label>
                            <input class="form-control" value="{{$total}}" readonly>
                        </div> --}}
                        <div class="col-md-2">
                            <label> التاريخ</label>
                            <input class="form-control" wire:model="date" value="{{$date}}" name="date" required>

                        </div>
                        <div class="col-md-4">
                            <label> السائق</label>
                            <select wire:model="driver" required name="driver" class="form-control">
                                <option value="">اختر السائق</option>
                                @foreach ($drivers as $driver)
                                    <option value="{{$driver->tree4_code}}">{{$driver->tree4_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label for="inputName" class="control-label"> &nbsp;</label>
                            <a class="modal-effect btn btn-primary btn-block" data-effect="effect-super-scaled"
                                data-toggle="modal" href="#modaldemo8"><i class="fa fa-plus"></i></a>
                        </div>
                        <div class="col">
                            <label> السيارة</label>
                            <select wire:model="car" required name="car" class="form-control">
                                <option value="">اختر السيارة</option>
                                @foreach ($cars as $car)
                                    <option value="{{$car->id}}">{{$car->type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label for="inputName" class="control-label"> &nbsp;</label>
                            <a class="modal-effect btn btn-primary btn-block" data-effect="effect-super-scaled"
                                data-toggle="modal" href="#modaldemo7"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="exampleTextarea">  الرحلة متجهة </label>
                            <select wire:model="from" required name="from" class="form-control">
                                <option value="">اختر الرحلة</option>
                                @foreach ($travels as $travel)
                                    <option value="{{$travel->id}}">{{$travel->name}}</option>
                                @endforeach
                            </select>
                        </div>
                       
                        <div class="col-md-3">
                            <label for="exampleTextarea">الي</label>
                            <select wire:model="to" required name="to" class="form-control">
                                <option value="">اختر الرحلة</option>
                                @foreach ($travels as $travel)
                                <option value="{{$travel->id}}">{{$travel->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label for="inputName" class="control-label"> &nbsp;</label>
                            <a class="modal-effect btn btn-primary btn-block" data-effect="effect-super-scaled"
                                data-toggle="modal" href="#modaldemo6"><i class="fa fa-plus"></i></a>
                        </div>
                        <div class="col">
                            <label for="exampleTextarea">ملاحظات</label>
                            <input wire:model="Statement" name="Statement"  class="form-control">
                            {{--  <textarea class="form-control" wire:model="Statement" name="Statement" rows="3"></textarea>  --}}
                        </div>
                    </div>
                </br>

                    {{-- 2 --}}
                    <p style="color: red">{{$erorr}}</p>
                    <div class="row">
                        <form action="" method="POST">
                            @csrf
                            <div class="col-md-4">
                                <label for="inputName" class="control-label"> إسم الراكب</label>
                                <input required wire:model="name" name="name" type="text" placeholder=" إسم الراكب"
                                class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label for="inputName" class="control-label">جنسية الراكب</label>
                                <input required wire:model="nationalty" name="nationalty" type="text" placeholder=" جنسية الراكب"
                                    class="form-control">
                            </div>

                            <div class="col-md-2">
                                <label for="inputName" class="control-label">  رقم الهوية / جواز</label>
                                <input required wire:model="passport" name="passport" type="text" placeholder=" رقم الهوية"
                                    class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label for="inputName" class="control-label">  رقم الجوال </label>
                                <input required wire:model="phone" name="phone" type="number" placeholder=" رقم الجوال"
                                    class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label for="inputName" class="control-label"> &nbsp;</label>
                                <button type="submit" onclick="event.preventDefault()" wire:click="add()"
                                    class="btn btn-primary btn-block"> <i class="fa fa-plus"> </i></i></button>
                            </div>
                        </form>
                    </div>
                    </br>
                    @if ($Passenger->count() > 0)
                    <table class="table table-hover mb-0 text-md-nowrap">
                        <thead>
                            <tr>
                                <th>متسلسل</th>
                                <th>إسم الراكب</th>
                                <th>جنسية الراكب</th>
                                <th>رقم الهوية / جواز</th>
                                <th>رقم الجوال</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($Passenger as $item)
                            <tr>
                                <th scope="row">{{$id++}}</th>
                                <td>{{$item->name}}</td>
                                <td>{{$item->nationalty}}</td>
                                <td>{{$item->passport}}</td>
                                <td>{{$item->phone}}</td>
                                <td>
                                    <button class="btn btn-danger" wire:click="deletItem({{$item->id}})"><i
                                            class="fa fa-trash"></i> </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p>لا يوجد بيانات حاليا</p>
                    @endif
                    <br>

                    <div class="d-flex justify-content-center">
                        <button onclick="event.preventDefault()" wire:click="add_purchase()" class="btn btn-primary">حفظ
                            البيانات</button>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>