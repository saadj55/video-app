<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Videos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        @if(!$videos)
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="p-6 bg-white border-b border-gray-200">
                        <a href="{{route('upload')}}">Click here</a> to upload some videos.
                    </div>
                </div>
            </div>
        @else
            @foreach($videos as $video)
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                        <div class="p-6 bg-white border-b border-gray-200">
                                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">{{$video->title}} <span class="inline-block rounded-full text-white px-2 py-1 text-xs font-bold mb-3 mr-3 {{$video->convert_status == 0 ? 'bg-yellow-500' : 'bg-green-500'}}">{{$video->convert_status == 0 ? 'Conversion In Progress' : 'Converted'}}</span></h2>
                            <video width="{{$video->videoMeta->width}}" height="{{$video->videoMeta->height}}" poster="{{url('storage/thumbnails/' .$video->thumbnail)}}" controls>
                                <source src="{{url('storage/uploads/' . $video->filename)}}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
                {{ $videos->links() }}
            </div>
    </div>
</x-app-layout>
