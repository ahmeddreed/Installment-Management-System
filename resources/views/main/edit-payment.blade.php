<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="{{ asset("css/bootstrap.min1.css") }}" rel="stylesheet">
    <link href="{{ asset("css/style.css") }}" rel="stylesheet">

    <title>Home</title>
  </head>

  <body dir="rtl">
    <div class="contianer ">
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

            <div class="col-6 mx-auto mt-5">
                <div class="card shadow rounded">
                    <div class="card-header new-bg p-3">
                        <h3 class="text-center">تعديل البيانات</h3>
                    </div>
                    <div class="card-body new-color">
                        @php
                            $paymentId = Hash::make($payment->id);
                        @endphp
                        <form action="{{ route("updatePayment",["paymentId"=> $payment->id]) }}" method="post">
                            @csrf
                            @method("put")
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">المدفوع</label>
                                <input name="paymentValue" type="text"  value="{{ $payment->pay }}" class="form-control @error('paymentValue') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="ادخل اسم الحاجة">
                                @error('paymentValue')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            <input type="hidden" name="hashPaymentId" value="{{ $paymentId }}">
                            <div class="mb-3">
                                <button class="form-control btn new-bg fs-5 fw-bold" type="submit"> حفظ </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer new-bg">
                        <div>
                             {{-- @php
                                 $inte_id = DB::table("shoppings")->find($payment->shop_id)->id;
                             @endphp --}}
                            <a href="{{ route("showDetails",["id"=>$inte_id]) }}" class="btn btn-light fs-5 new-color rounded">الرجوع</a>
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
