@extends('staff.staff_dashboard')
@section('staff')

<div class="page-content">
    <div class="row">
        <div class="col-md-3 ">

            <div class="card ">
                <div class="card body ">
                    <div class="m-3">
                        <h3>Thông tin của bạn</h3>
                        <div class="mt-3">
                            <div><span class="h6">Tên:</span> {{ Auth::user()->name }}</div>
                            <div><span class="h6">Mã:</span> {{ Auth::user()->usercode }}</div>
                            <div><span class="h6">Email:</span> {{ Auth::user()->email }}</div>
                            <div><span class="h6">số điện thoại:</span> {{ Auth::user()->phone }}</div>
                            <div><span class="h6">Địa chỉ:</span> {{ Auth::user()->address }}</div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7 ">

            <div class="card ">
                <div class="card body ">
                    <div class="m-3">
                        <h3>Danh sách công việc</h3>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    @endsection