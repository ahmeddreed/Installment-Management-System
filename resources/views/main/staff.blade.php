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
            <div class="col-12 mx-auto mt-5">
                <div class="card shadow new-color rounded">
                    <div class="card-header new-bg ">
                        <h3 class="float float-end">جدول الموظفين</h3>
                        <button type="button" class="btn btn-light new-color rounded float float-start" data-bs-toggle="modal" data-bs-target="#Add">اضافة موظف</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">الاسم</th>
                                    <th scope="col">الايميل</th>
                                    <th scope="col">الصلاحية</th>
                                    <th scope="col">تاريخ الاضافة</th>
                                    <th scope="col">العمليات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $num =1;
                                    @endphp
                                    @foreach ( $staffs as $staff)
                                        <tr>
                                            <th scope="row">{{ $num++ }}</th>
                                            <td>{{ $staff->name }}</td>
                                            <td>{{ $staff->email }}</td>
                                            <td>{{ ($staff->role_id == 1?"مدير":"موظف") }}</td>
                                            <td>{{ $staff->created_at }}</td>
                                            <td>
                                                @php
                                                    $key = Hash::make($staff->id);
                                                @endphp
                                                <a data-bs-toggle="modal" data-bs-target="#del{{ $staff->id }}" class="me-2"><i class="bi bi-trash-fill text-danger"></i></a>
                                            </td>
                                        </tr>

                                        {{-- delete modal --}}
                                        <div class="modal fade new-text" id="del{{ $staff->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                            <form class="d-inline" action="{{ route("deleteStaff",["id"=>$staff->id]) }}" method="post">
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
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer new-bg">
                        <div class="d-flex justify-content-center new-color">
                            {{ $staffs->links() }}
                        </div>

                        <a href="{{ route("home") }}" class="btn btn-light fs-5 new-color rounded">الرجوع</a>
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
                            <form action="{{ route("addStaff") }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('post')
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
                                    <label for="exampleFormControlInput1" class="form-label">البريد الالكتروني</label>
                                    <input name="email" type="email" value="{{ old("email") }}" class="form-control  @error('email') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="البريد الالكتروني">
                                    @error('email')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                    </div>

                                    @if(auth()->user()->role_id == 1)
                                    <div class="mb-3">
                                    <select class="form-control">
                                        @foreach ($roles as $role)
                                            <option style="background-color:#88c6a5" value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    @endif

                                  <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">الرمز السري</label>
                                    <input name="password" type="password"  value="{{ old("password") }}" class="form-control  @error('password') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="الرمز السري">
                                    @error('password')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>

                                  <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">اعادة كتابة الرمز السري</label>
                                    <input name="c_password" type="password" value="{{ old("c_password") }}" class="form-control @error('c_password') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="اعادة كتابة الرمز السري">
                                    @error('c_password')
                                    <small class="text-danger">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>
                                  <div class="mb-3">
                                    <label for="exampleFormControlInput1" class="form-label">الصورة الشخصية</label>
                                    <input name="img" type="file" value="{{ old("img") }}" class="form-control @error('img') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="اعادة كتابة الرمز السري">
                                    @error('img')
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
