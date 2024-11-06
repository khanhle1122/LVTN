<x-app-layout>
    <x-slot name="header" >
         <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             {{ __('Tìm kiếm') }}
         </h2>

    </x-slot>
    <div class="py-12">
        <div class="  mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="h2">Kết quả tìm kiếm cho từ khóa: "{{ $query }}"</div>

                    
                    @if($projects->isNotEmpty())
                        <h3>Dự án</h3>
                        <ul>
                            @foreach($projects as $project)
                                <li>{{ $project->projectName }} - {{ $project->projectCode }}</li>
                            @endforeach
                        </ul>
                    
                    @endif

                    
                    @if($users->isNotEmpty())
                    <h3>Người dùng</h3>
                        <ul>
                            @foreach($users as $user)
                                <li>{{ $user->name }} - {{ $user->email }}</li>
                            @endforeach
                        </ul>
                    
                    @endif

                
                    @if($files->isNotEmpty())
                        <h3>Đối tác</h3>
                        <ul>
                            @foreach($files as $file)
                                <li>{{ $file->fileName }} - {{ $file->fileName }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>Không tìm thấy.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>