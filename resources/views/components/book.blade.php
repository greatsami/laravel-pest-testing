@props(['book'])
<div class="bg-slate-100 p-6 rounded flex justify-between items-center">
    <div>
        <h2 class="font-bold text-xl text-slate-800">{{ $book->title }}</h2>
        <div class="text-slate-600 text-sm">{{ $book->author }}</div>
    </div>
    @isset($links)
        <div>
            <a href="/books/{{ $book->id }}/edit" class="text-blue-500 text-sm">Edit</a>
        </div>
    @endisset
</div>

