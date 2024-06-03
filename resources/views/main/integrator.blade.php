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
    <div class="container ">
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
            <div class="col-11 mx-auto mt-5">
                <div class="card shadow new-color rounded">
                    <div class="card-header new-bg ">
                        <h3 class="float float-end">جدول المقسطين</h3>
                        <button type="button" class="btn btn-light new-color rounded float float-start"  data-bs-toggle="modal" data-bs-target="#Add">اضافة مقسط</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">الاسم المقسط</th>
                                    <th scope="col"> الاسم المضيف</th>
                                    <th scope="col">عدد المشتريات</th>
                                    <th scope="col">تاريخ اخر تسديد</th>
                                    <th scope="col">العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($integrator as $item)
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ DB::table('users')->find($item->user_id)->name}}</td>
                                            <td>{{ $item->countOfShop() }}</td>
                                            <td>{{ $item->created_at }}</td>
                                            <td >
                                                @php
                                                    $key = Hash::make($item->id);
                                                @endphp
                                                <a href="{{ route("showDetails",["id"=>$item->id]) }}" class="ms-2"><i class="bi bi-eye-fill text-info"></i></a>
                                                <a class="me-2"><i class="bi bi-bag-plus-fill text-success" data-bs-toggle="modal" data-bs-target="#pay{{ $item->id }}"></i></a>
                                                <a href="{{ route("editIntegrator",["id"=>$item->id]) }}" class="me-2"><i class="bi bi-pencil-fill text-warning"></i></a>
                                                <a class="me-2" data-bs-toggle="modal" data-bs-target="#del{{ $item->id }}"><i class="bi bi-trash-fill text-danger"></i></a>
                                            </td>
                                        </tr>

                                            <!-- pay Modal -->
                                            <div class="modal fade new-text" id="pay{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route("pay",["id"=> $item->id]) }}" method="post">
                                                            @csrf
                                                            @method("post")
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlInput1" class="form-label">الاسم الحاجة</label>
                                                                <input name="name" type="text"  value="{{ old("name") }}" class="form-control @error('name') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="ادخل اسم الحاجة">
                                                                @error('name')
                                                                <small class="text-danger">
                                                                    {{ $message }}
                                                                </small>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlInput1" class="form-label">نوع الحاجة</label>
                                                                <select class="form-control" name="cate_id">
                                                                    @foreach ($categories as $category)
                                                                        <option style="background-color:#88c6a5" value="{{ $category->id }}">{{ $category->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('cate_id')
                                                                <small class="text-danger">
                                                                    {{ $message }}
                                                                </small>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlInput1" class="form-label">سعر الحاجة</label>
                                                                <input name="price" type="number"  value="{{ old("price") }}" class="form-control @error('price') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="ادخل سعر الحاجة">
                                                                @error('price')
                                                                <small class="text-danger">
                                                                    {{ $message }}
                                                                </small>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="exampleFormControlInput1" class="form-label">الدفعة الاولة</label>
                                                                <input name="firstPayment" type="number"  value="{{ old("firstPayment") }}" class="form-control @error('firstPayment') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="ادخل الدفعة الاولى">
                                                                @error('firstPayment')
                                                                <small class="text-danger">
                                                                    {{ $message }}
                                                                </small>
                                                                @enderror
                                                            </div>

                                                            <div class="mb-3">
                                                                <button class="form-control btn new-bg fs-5 fw-bold" type="submit"> حفظ </button>
                                                            </div>

                                                        </form>
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
                                                                <form class="d-inline" action="{{ route("deleteIntegrator",["id"=>$item->id]) }}" method="post">
                                                                    @csrf
                                                                    @method("delete")
                                                                    <input type="hidden" name="key" value="{{ $key }}">
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

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer new-bg">
                        <div>
                            <a href="{{ route("home") }}" class="btn btn-light fs-5 new-color rounded">الرجوع</a>
                        </div>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade new-text" id="Add" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close text-danger" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route("addIntegrator") }}" method="post">
                                @csrf
                                @method("post")
                                <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">الاسم</label>
                                    <input name="name" type="text"  value="{{ old("name") }}" class="form-control @error('name') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="ادخل اسم النستخدم">
                                    @error('name')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>

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
    <script src="{{ asset("js/bootstrap.bundle.js") }}" ></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  -->
</body>
</html>
