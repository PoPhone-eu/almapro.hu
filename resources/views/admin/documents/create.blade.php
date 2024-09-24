@extends('layouts.adminapp')

@section('content')
    <div class="container">
        <!-- Include stylesheet -->
        <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.5/dist/quill.snow.css" rel="stylesheet" />
        <div>
            <div>
                <div
                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <a href="{{ route('legaldocuments.index') }}"
                        class="btn btn-primary flex items-center mr-3 cursor-pointer text-white">
                        Vissza
                    </a>
                </div>
                <div
                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="text-lg font-medium mr-auto mt-5">
                        Dokumentum hozzáadása
                    </h2>
                </div>
                <form action="{{ route('legaldocuments.store') }}" method="post">
                    @csrf
                    <!-- BEGIN: input tex: title -->
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label>Cím</label>
                        <input type="text" class="input w-full border mt-2" placeholder="Cím" name="title" required>
                        @error('title')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- BEGIN: input number: order - default value zero -->
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label>Sorrend</label>
                        <input type="number" class="input w-full border mt-2" placeholder="Sorrend" name="order"
                            style="width: 120px;" value="0" required>
                        @error('order')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- BEGIN: input tex: status -->
                    <div class="intro-y col-span-12 sm:col-span-6">
                        <label>Státusz</label>
                        <select class="input w-full border mt-2" name="is_active" style="width: 120px;">
                            <option value="1">Aktív</option>
                            <option value="0">Inaktív</option>
                        </select>
                        @error('status')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- BEGIN: textarea: body with quill editor -->
                    <textarea id="body" name="body" class="hidden"></textarea>
                    <div class="intro-y col-span-12">
                        <label>Leírás</label>
                        <div class="editor" id="editor"></div>
                        @error('body')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror

                    </div>

                    <!-- BEGIN: submit button -->
                    <div class="intro-y col-span-12 flex items-center justify-center sm:justify-start mt-5">
                        <button type="submit"
                            class="btn btn-primary flex items-center mr-3 cursor-pointer text-white">Mentés</button>
                    </div>
                </form>
            </div>

            <!-- Include the Quill library -->
            <script src="https://cdn.jsdelivr.net/npm/quill@2.0.0-rc.5/dist/quill.js"></script>

            <!-- Initialize Quill editor -->
            <script>
                const quill = new Quill('#editor', {
                    theme: 'snow'
                });
                quill.on('text-change', function() {
                    document.getElementById("body").value = quill.root.innerHTML;
                });
            </script>
        </div>
    </div>
@endsection
