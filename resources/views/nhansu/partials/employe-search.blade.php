<section>
    <form action="{{ route('users.search') }}" method="GET">
        <div class="input-group mb-3">
            <input type="text" name="query" class="form-controls rounded-start" placeholder="Search">
            <button class="btn btn-dark" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>
    </form>
    {{-- @if(isset($users) && $users->isNotEmpty())
    <table class="table">
        <thead>
            <tr>
                <th>Tên</th>
                <th>Email</th>
                <th>Mã nhân viên</th>
                <th>Chức vụ</th>
                <th>Quyền truy cập</th>
            </tr>
        </thead>
        <tbody>
            @foreach($nhansu as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->usercode }}</td>
                    <td>{{ $user->position }}</td>
                    <td>{{ $user->role }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>Không tìm thấy nhân viên nào.</p>
@endif --}}

</section>