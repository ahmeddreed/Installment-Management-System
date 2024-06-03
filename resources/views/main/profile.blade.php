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
            <div class="col-7 mx-auto my-5">
                <div class="card shadow rounded">
                    <div class="card-header new-bg p-3">
                        <h3 class="text-center">المعلومات الشخصية</h3>
                    </div>
                    <div class="card-body new-color mb-5">
                        <form action="{{ route("editUserData") }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('put')
                            <div class="row">
                               <div class="mb-3 col-4 mx-auto">
                                <div class="card shadow">
                                    <div class="card-body"><img src="{{ asset("imageUser/".$myData->img) }}" alt="" class="card-img-top"></div>
                                </div>
                              </div>
                              <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">الاسم</label>
                                <input name="name" type="text"  value="{{ $myData->name }}" class="form-control @error('name') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="ادخل اسم النستخدم">
                                @error('name')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                              <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">البريد الالكتروني</label>
                                <input name="email" type="email" value="{{ $myData->email }}" class="form-control  @error('email') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="البريد الالكتروني">
                                @error('email')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">الصورة الشخصية</label>
                                <input name="img" type="file" value="{{ $myData->img }}" class="form-control @error('img') is-invalid  @enderror" id="exampleFormControlInput1" placeholder="اعادة كتابة الرمز السري">
                                @error('img')
                                <small class="text-danger">
                                    {{ $message }}
                                </small>
                                @enderror
                            </div>

                                <div class="mb-3 col-12 ">
                                  <button class="form-control btn new-bg fs-5 fw-bold" type="submit"> حفظ </button>
                                </div>
                              </div>
                          </form>
                    </div>
                    <div class="card-footer new-bg">
                        <div>
                            <a href="{{ route("home") }}" class="btn btn-light fs-5 new-color rounded float float-end">الرجوع</a>
                        </div>
                        <div>
                            <a href="{{ route("password") }}" class="btn btn-light fs-5 new-color rounded float float-start ">تغيير الرمز</a>
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
