@extends('layouts.app')
@section("content")
    <main class="container">
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

            @if($showTable)
            <div class="col-12 mx-auto mt-5">
                <div class="card shadow new-color rounded">
                    <div class="card-header new-bg ">
                        <h3 class="float float-end">جدول الموظفين</h3>
                        <p wire:click='showAddform' class="btn btn-light new-color rounded float float-start" >اضافة موظف</p>
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
                                                <button class="mx-2 btn" wire:click='showDeleteMessage({{ $staff->id }})'><i class="bi bi-trash-fill text-danger"></i></button>
                                            </td>
                                        </tr>
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

            </div>
            @elseif($addForm)
                <div class="col-lg-10 mx-auto my-5">
                    <div class="card shadow new-color rounded">
                        <div class="card-header new-bg ">
                            <h3 class="float float-end">اضافة موظف</h3>
                        </div>
                        <div class="card-body">
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

                @elseif($deleteMessage)

                    <div class="col-lg-10">
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

            @endif
        </div>
    </main>

@endsection
