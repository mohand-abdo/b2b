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
                        <div class="col-md-3">
                            <label for="inputName" class="control-label"> العميل</label>
                            <select required wire:model="live_client" name="client" class="form-control">
                                <option value="">اختر العميل</option>
                                @foreach ($client as $tree)
                                    <option value="{{$tree->tree4_code}}">{{$tree->tree4_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label for="inputName" class="control-label"> &nbsp;</label>
                            <a class="modal-effect btn btn-primary btn-block" data-effect="effect-super-scaled"
                                data-toggle="modal" href="#modaldemo8"><i class="fa fa-plus"></i></a>
                        </div>
                        <div class="col">
                            <label> الحساب</label>
                            <select wire:model="live_bank_and_safe" required name="bank_and_safe" class="form-control">
                                <option value="">اختر الحساب</option>
    
                                @foreach ($bank_and_safe as $tree)
                                    <option value="{{$tree->tree4_code}}">{{$tree->tree4_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label>  الإجمالي</label>
                            <input class="form-control"  value="{{number_format($total)}}" id="total" disabled >
                        </div>
                        <div class="col">
                            <label for="inputName" class="control-label">السيارة</label>
                            <select class="form-control" required wire:model="car">
                                <option value="">اختر السيارة</option>
                                @foreach ($cars as $item)
                                <option value="{{$item->id}}">{{$item->type}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label> نوع الدفع </label>
                            <select wire:model="pay_type" name="pay_type" class="form-control">
                                <option value=""> اختر نوع الدفع</option>
                                <option value="1">نقدي</option>
                                <option value="2">اَجل</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-2">
                            <label for="exampleTextarea"> الضريبة</label>
                            <input  name="vat_value" value="{{ $vat_value }}" class="form-control"  disabled>
                        </div>
                        <div class="col-md-1">
                            <label for="inputName" class="control-label"> &nbsp;</label>
                            <a class="modal-effect btn btn-primary btn-block" data-effect="effect-super-scaled"
                                data-toggle="modal" href="#vat"><i class="fa fa-edit"></i></a>
                        </div>
                        <div class="col-md-2">
                            <label for="exampleTextarea"> قيمة الضريبة</label>
                            <input value="{{number_format($value) }}" name="value"  class="form-control" disabled>
                        </div>
                        <div class="col-md-2">
                            <label for="exampleTextarea">الاجمالي شامل الضريبة</label>
                            <input value="{{number_format($endtotal) }}"  name="endtotal"  disabled class="form-control" >
                        </div>
                        <div class="col-md-1">
                            <label for="exampleTextarea">الخصم</label>
                            <input wire:model="discount"  name="discount" class="form-control">
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
                                <label for="inputName" class="control-label">الرحلة من</label>
                                <select class="form-control" required wire:model="travel">
                                    <option value="">اختر الرحلة</option>
                                    @foreach ($travels as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="inputName" class="control-label">الي </label>
                                <select class="form-control" required wire:model="to">
                                    <option value="">اختر الرحلة</option>
                                    @foreach ($travels as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label for="inputName" class="control-label"> السعر</label>
                                <input required wire:model="price" name="price" type="number" placeholder=" السعر"
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
                    @if ($root->count() > 0)
                    <table class="table table-hover mb-0 text-md-nowrap">
                        <thead>
                            <tr>
                                <th>متسلسل</th>
                                <th>الرحلة</th>
                                <th>السيارة</th>
                                <th>السعر</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($root as $item)
                            <tr>
                                <th scope="row">{{$id++}}</th>
                                @if(isset($item->travels->name))
                                <td>{{$item->travels->name}}</td>
                                @endif
                                @if(isset($item->travels_to->name))
                                <td>{{$item->travels_to->name}}</td>
                                @endif
                                <td>{{number_format((int)$item->price)}}</td>
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