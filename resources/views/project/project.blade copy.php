<x-app-layout>
       <x-slot name="header">
           <h2 class="font-semibold text-xl text-gray-800 leading-tight">
               {{ __('Dự án') }}
           </h2>
       </x-slot>
   
       <div class="py-12">
           <div class="  mx-auto sm:px-6 lg:px-8">
               <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        @include('project.partials.add-project')
                        
                    </div>
                   <div class="p-6 text-gray-900">
                       @include('project.partials.project-rapt')
                       
                   </div>
                   <div class="p-6 text-gray-900">
                        @include('project.partials.all-project')
                    
                    </div>
               </div>
           </div>
       </div>
       
   </x-app-layout>