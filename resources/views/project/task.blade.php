<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dự án') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="  mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                 <div class="p-6 text-gray-900 d-flex justify-content-between">
                     <div></div>
                     @include('project.partials.project-search')
                 </div>
                <div class="p-6 text-gray-900 row">
                    <div class="col-3">@include('project.task.detail-project')</div>
                    <div class="col">@include('project.task.all-task')</div>
                </div>
                
            </div>
        </div>
    </div>
    <script>
        // Lấy giá trị ngày từ data attribute
        const startDate = document.querySelector('.date-container').getAttribute('data-start-date');
        const endDate = document.querySelector('.date-container').getAttribute('data-end-date');
    
        // Hàm định dạng ngày theo d/m/Y
        function formatDate(dateString) {
            const date = new Date(dateString); // Chuyển đổi chuỗi thành đối tượng Date
            const day = String(date.getDate()).padStart(2, '0'); // Lấy ngày (dd)
            const month = String(date.getMonth() + 1).padStart(2, '0'); // Lấy tháng (mm)
            const year = date.getFullYear(); // Lấy năm (yyyy)
            
            return `${day}/${month}/${year}`; // Trả về chuỗi ngày theo d/m/Y
        }
    
        // Hiển thị ngày đã định dạng trong HTML
        document.querySelector('.date-container').innerHTML = 'Từ ' + formatDate(startDate) + ' Đến ' + formatDate(endDate);
    </script>
</x-app-layout>