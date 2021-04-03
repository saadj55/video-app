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
                                {{$video->title}} || Convert Status --> {{$video->convert_status == 0 ? 'In progress' : 'Converted'}}
                            <video width="{{$video->videoMeta->width}}" height="{{$video->videoMeta->height}}" poster="{{url('storage/thumbnails/' .$video->thumbnail)}}" controls>
                                <source src="{{url('storage/uploads/' . $video->filename)}}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</x-app-layout>
