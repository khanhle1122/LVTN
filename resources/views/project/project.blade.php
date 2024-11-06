<x-app-layout>
       <x-slot name="header" >
        
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dự án') }}
            </h2>
           
       </x-slot>
   
       <div class="py-12">
           <div class="  mx-auto sm:px-6 lg:px-8">
               <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 d-flex justify-content-between">
                        @include('project.partials.add-project')
                        @include('project.partials.project-search')
                    </div>
                    
                   <div class="p-6 text-gray-900">
                        @include('project.partials.project-all')
                       
                   </div>
                   <div class="p-6 text-gray-900 ms-5 row">
                    
                    <div class="col-3"></div>
                    <div class="d-flex col ms-5 mt-4">
                        {{ $project->links('pagination::bootstrap-5')  }}
                    </div>
                </div>
                   
               </div>
           </div>
       </div>
       
   </x-app-layout>