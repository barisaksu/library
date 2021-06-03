<x-app-layout>
    <x-slot name="header">Yazarlar</x-slot>
    <x-section>
        <div class="md:w-2/3 lg:w-1/2 mx-auto">
            <x-flash-message/>
            <div class="text-right mb-3">
                <a href="{{route('author.create')}}">
                    <x-button>Yazar Ekle</x-button>
                </a>
            </div>
            <x-table :columns="['ID','Ad','Soyad','İşlem']">
                @foreach($authors as $author)
                    <tr>
                        <x-column>{{$author->id}}</x-column>
                        <x-column>{{$author->name}}</x-column>
                        <x-column>{{$author->surname}}</x-column>
                        <x-column>
                            <a href="{{route('author.edit',$author->id)}}">
                                <x-button>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </x-button>
                            </a>
                        </x-column>
                    </tr>
                @endforeach
            </x-table>
            <div class="mt-3">
                {{ $authors->links() }}
            </div>
        </div>
    </x-section>
</x-app-layout>
