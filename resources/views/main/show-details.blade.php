<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="{{ asset("css/bootstrap.min1.css") }}" rel="stylesheet">
    <link href="{{ asset("css/style.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Home</title>
  </head>

  <body dir="rtl">
    <div class="container">
        <div class="row">
            {{-- the alert message --}}
            <div class="col-lg-8 col-md-6 mx-auto mt-5">
                @if(Session::has("msg_s"))
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        {{ Session::get("msg_s") }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                @elseif(Session::has("msg_e"))
                <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
                    {{ Session::get("msg_e") }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
            </div>

            <div class="col-8 mx-auto mt-5">
                <div class="card shadow rounded">
                    <div class="card-header new-bg p-3">
                        <h3 class="text-center">معلومات المقسط</h3>
                    </div>
                    <div class="card-body new-color">
                        <div class="row fs-5">
                            <div class="col-6 p-2">
                                <span>الاسم المقسط </span> : <span>{{ $integrator->name }} </span>
                            </div>
                            <div class="col-6 p-2">
                                <span>الاسم المضيف</span> : <span>{{  DB::table('users')->find($integrator->user_id)->name }} </span>
                            </div>
                            <div class="col-6 p-2">
                                <span>عدد مشترياتة </span> : <span>{{ $integrator->countOfShop() }} </span>
                            </div>
                            <div class="col-6 p-2">
                                <span>المبلغ الكلي</span> : <span>{{ $integrator->countOfTheAllCost() }}</span>
                            </div>
                            <div class="col-6 p-2">
                                <span>تاريخ اخر تسديد </span> : <span>{{ $integrator->lastDate() }} </span>
                            </div>
                            <div class="col-6 p-2">
                                <span> المبلغ المتبقي </span> : <span>{{ $integrator->costOfTheRest() }} </span>
                            </div>
                            @if ($integrator->countOfShop() != 0)
                                <div class="col-6 p-2">
                                    @php
                                        $costOfTheRest = $integrator->costOfTheRest();
                                    @endphp
                                    <span> هل مستوفي القسط </span> : <span class="{{ ($costOfTheRest == 0 ?"text-success":"text-danger") }}">{{ ($costOfTheRest == 0 ? "مستوفي" : "غير مستوفي" )}} </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-12 mx-auto my-5">
                <div class="card shadow new-color rounded">
                    <div class="card-header new-bg ">
                        <h3 class="float float-end">المشتريات</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">الاسم الحاجة</th>
                                    <th scope="col">اسم المقسط</th>
                                    <th scope="col">اسم المضيف</th>
                                    <th scope="col">الحالة</th>
                                    @if ($integrator->costOfTheRest() != 0)
                                        <th scope="col">الحالة الدفع</th>
                                    @endif
                                    <th scope="col"> نوع الفئة </th>
                                    <th scope="col">السعر الاصلي</th>
                                    <th scope="col">سعر بعد الضريبة </th>
                                    <th scope="col">نسبة الضريبة</th>
                                    <th scope="col">التفاصيل</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $num =1;
                                    @endphp
                                    @foreach ( $shopping as $item)
                                        <tr>
                                            <th >{{ $num++ }}</th>
                                            <td>{{ $item->name }}</td>
                                            <td>{{  DB::table('integrators')->find($item->inte_id)->name}}</td>
                                            <td>{{  DB::table('users')->find($item->user_id)->name }}</td>
                                            <td class="{{ ($item->getTheRest() > 0 ? "text-warning" : "text-success") }}">{{ ($item->getTheRest() > 0 ? "غير مكمل " : "مكتمل التسديد") }}  </td>
                                            @if ($integrator->costOfTheRest() != 0)
                                                <td class="{{ ($item->endDate() > 30 ? "text-danger" : "text-success") }}">{{ ($item->endDate() > 30 ?"لم يدفع ":"دافع") }}  </td>
                                            @endif
                                            <td>{{  DB::table('categories')->find($item->cate_id)->name }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>{{ $item->priceAfterTax }}</td>
                                            <td>{{ $item->tax }}</td>
                                            <td>
                                                @if($item->getTheRest() > 0)
                                                    <a data-bs-toggle="modal" data-bs-target="#get{{ $item->id }}" class="btn text-success "><i class="bi bi-currency-dollar "></i></a>
                                                @endif
                                                <a  data-bs-toggle="modal" data-bs-target="#show{{ $item->id }}" class="btn text-info"><i class="bi bi-eye-fill text-info"></i></a>
                                                <a href="{{ route("editPay",["id"=>$item->id]) }}" class="me-2"><i class="bi bi-pencil-fill text-warning"></i></a>
                                                <a data-bs-toggle="modal" data-bs-target="#del{{ $item->id }}" class="me-2"><i class="bi bi-trash-fill text-danger"></i></a>
                                            </td>
                                        </tr>

                                        {{-- show data modal --}}
                                        <div class="modal fade new-text" id="show{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card shadow new-color rounded">
                                                        <div class="card-header new-bg ">
                                                            <h3 class="float float-end">المدفوعات و المتبقيات</h3>
                                                        </div>
                                                        <div class="card-body mx-auto">
                                                            <div class="row fs-5">
                                                                <div class="col-lg-2 mx-auto">المدفوعات</div>
                                                                <div class="col-lg-2 mx-auto">المتبقي</div>
                                                                <div class="col-lg-2 mx-auto">اسم المضيف</div>
                                                                <div class="col-lg-2 mx-auto">تاريخ</div>
                                                                @if($item->getTheRest() > 0)
                                                                    <div class="col-lg-2 mx-auto">العمليات</div>
                                                                @else
                                                                    <div class="col-lg-2 mx-auto">
                                                                    </div>
                                                                @endif

                                                                <hr class="bg-new my-2"/>
                                                                @php
                                                                    $payments=DB::table('payment_of_premia')->where("shop_id",$item->id)->get();
                                                                @endphp
                                                                @foreach ($payments as $payment)

                                                                <div class="col-lg-2 mx-auto">{{ $payment->pay }}</div>
                                                                <div class="col-lg-2 mx-auto">{{ $payment->theRest }}</div>
                                                                <div class="col-lg-2 mx-auto">{{ DB::table('users')->find($payment->user_id)->name}}</div>
                                                                <div class="col-lg-2 mx-auto">{{ $payment->created_at}}</div>
                                                                @if($item->getTheRest() > 0 && $item->getLastIdOfPayment() == $payment->id)
                                                                    <div class="col-lg-2 mx-auto">
                                                                        <a href="{{ route("editpayment",["paymentId"=>$payment->id]) }}" class=""><i class="bi bi-pencil-fill text-warning"></i></a>
                                                                    </div>
                                                                @else
                                                                <div class="col-lg-2 mx-auto">
                                                                </div>
                                                                 @endif
                                                                <hr class="bg-new my-2"/>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            </div>
                                        </div>



                                        {{-- delete modal --}}
                                        <div class="modal fade new-text" id="del{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card shadow new-color rounded">
                                                        <div class="card-header bg-danger ">
                                                            <h3 class="float float-end text-light">هل تريد حذف هذا العنصر</h3>
                                                        </div>
                                                        <div class="card-body mx-auto">
                                                            <h4 class="text-center text-danger">في حالة حذفت هذا العنصر من الممكن اليحذف معه العناصر المرتبطة بيه ايضا</h4>
                                                            <form class="" action="{{ route("deleteShop",["id"=>$item->id]) }}" method="post">
                                                                @csrf
                                                                @method("delete")
                                                                <div class="d-grid gap-2 col-4 mx-auto my-5">
                                                                    <button class="btn btn-danger text-light" type="submit"><i class="bi bi-trash-fill"></i></button>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            </div>
                                        </div>


                                        {{-- add paynent modal --}}
                                        <div class="modal fade new-text" id="get{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header new-bg p-3 ">
                                                    <a type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></a>
                                                </div>
                                                <div class="modal-body">
                                                    @php
                                                        $hash_id = Hash::make($item->id);
                                                    @endphp
                                                    <div class="col-6 mx-auto mt-5">
                                                        <div class="card shadow rounded">
                                                            <div class="card-body new-color">
                                                                <h3 class="text-center d-flex justify-content-center">دفع القسط</h3>

                                                                <form action="{{ route("getPayment",["id"=>$item->id]) }}" method="post">
                                                                    @csrf
                                                                    @method("post")
                                                                    <div class="mb-3">
                                                                        <label for="exampleFormControlInput1" class="form-label">المدفوع</label>
                                                                        <input name="paymentValue" type="number" class="form-control @error('paymentValue') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="ادخل اسم الحاجة">
                                                                        @error('paymentValue')
                                                                        <small class="text-danger">
                                                                            {{ $message }}
                                                                        </small>
                                                                        @enderror
                                                                    </div>
                                                                    <input type="hidden" name="payment_id" value="{{ $hash_id }}">
                                                                    <div class="mb-3">
                                                                        <button class="form-control btn new-bg fs-5 fw-bold" type="submit"> حفظ </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer new-bg">
                        <div>
                            <a href="{{ route("IntegratorTable") }}" class="btn btn-light fs-5 new-color rounded">الرجوع</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
  <script src="{{ asset("js/bootstrap.bundle.js") }}" ></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  -->
</body>
</html>
