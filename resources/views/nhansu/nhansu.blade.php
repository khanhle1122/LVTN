<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('nhân sự') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="  mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 d-flex justify-content-between">
                    @include('nhansu.partials.employe-create')
                    @include('nhansu.partials.employe-search')
                </div>
                <div class="p-6 text-gray-900">
                    
                    @if(isset($nhansu) && $nhansu->isNotEmpty())
                    
                    @include('nhansu.partials.employe-info')
                    @else
                        <p>Không tìm thấy nhân viên <span class="h">{{ $query }}</span>.</p>
                    @endif
                </div>
                <div class="p-6 text-gray-900 ms-5 row">
                    
                    <div class="col-3"></div>
                    <div class="d-flex col ms-5 mt-4">
                        {{ $nhansu->links('pagination::bootstrap-5')  }}
                    </div>
                </div>
                </div>
               
                
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var selectedClass = 'active';
            
            // Function to remove the active class from all items
            function removeActiveClass() {
                $('#myList .list-group-item').removeClass(selectedClass);
            }
    
            // Function to update item information
            function updateItemInfo(info) {
                $('#itemInfo').html(info); // Use .html() instead of .text() to render HTML content
            }
    
            // Handle click on list items
            $('#myList .list-group-item').on('click', function() {
                removeActiveClass();
                $(this).addClass(selectedClass);
                updateItemInfo($(this).data('info'));
            });
    
            // Handle keydown events for up and down arrow keys
            $(document).on('keydown', function(e) {
                var current = $('#myList .list-group-item.' + selectedClass);
                if (e.key === "ArrowDown") {
                    var next = current.next('.list-group-item');
                    if (next.length) {
                        removeActiveClass();
                        next.addClass(selectedClass);
                        updateItemInfo(next.data('info'));
                    }
                } else if (e.key === "ArrowUp") {
                    var prev = current.prev('.list-group-item');
                    if (prev.length) {
                        removeActiveClass();
                        prev.addClass(selectedClass);
                        updateItemInfo(prev.data('info'));
                    }
                }
            });
    
            // Initialize the first item as selected
            $('#myList .list-group-item').first().addClass(selectedClass);
            updateItemInfo($('#myList .list-group-item').first().data('info'));
        });
    </script>
</x-app-layout>
