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
    <div class="container mb-5">
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
            <div class="col-12 mx-auto mt-3 new-bg p-3">
                <h3 class=" fw-bold text-center">
                    نظام ادارة الاقساط
                </h3>
            </div>
            <div class="col-lg-3 col-md-5 col-10 mx-auto mt-5">
                <div class="card shadow new-color rounded">
                    <div class="card-body">
                        <img src="{{ asset("img/profile.png") }}" alt="" class="card-img-top">
                        <div class="mt-3 text-center ">
                            <a href="{{ route("profile") }}" class=" btn new-bg fs-5">الملف الشخصي</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-5 col-10 mx-auto mt-5">
                <div class="card shadow new-color rounded">
                    <div class="card-body">
                        <img src="{{ asset("img/staff.png") }}" alt="" class="card-img-top">
                        <div class="mt-3 text-center ">
                            <a href="{{ route("staffTable") }}" class=" btn new-bg fs-5">الموظفين</a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-5 col-10 mx-auto mt-5">
                <div class="card shadow new-color rounded">
                    <div class="card-body">
                        <img src="{{ asset("img/role.png") }}" alt="" class="card-img-top">
                        <div class="mt-3 text-center ">
                            <a href="{{ route("roleTable") }}" class=" btn new-bg fs-5">الصلاحيات</a>
                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-5 col-10 mx-auto mt-5">
                <div class="card shadow new-color rounded">
                    <div class="card-body">
                        <img src="{{ asset("img/categories.png") }}" alt="" class="card-img-top">
                        <div class="mt-3 text-center ">
                            <a href="{{route("CategoryTable")}}" class=" btn new-bg fs-5">الفئات</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-5 col-10 mx-auto mt-5">
                <div class="card shadow new-color rounded">
                    <div class="card-body">
                        <img src="{{ asset("img/group.png") }}" alt="" class="card-img-top">
                        <div class="mt-3 text-center ">
                            <a href="{{ route("IntegratorTable") }}" class=" btn new-bg fs-5"> المقسطين </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-5 col-10 mx-auto mt-5">
                <div class="card shadow new-color rounded">
                    <div class="card-body">
                        <img src="{{ asset("img/dashboard.png") }}" alt="" class="card-img-top">
                        <div class="mt-3 text-center ">
                            <a href="information.html" class=" btn new-bg fs-5">معلومات النظام</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-md-5 col-10 mx-auto mt-5">
                <div class="card shadow new-color rounded">
                    <div class="card-body">
                        <img src="{{ asset("img/logout.png") }}" alt="" class="card-img-top">
                        <div class="mt-3 text-center ">
                            <a href="{{ route("logout") }}" class=" btn new-bg fs-5">تسجيل الخروج</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <script src="{{ asset("js/bootstrap.bundle.js")}}" ></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
  -->
</body>
</html>
