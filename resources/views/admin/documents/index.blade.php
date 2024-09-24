@extends('layouts.adminapp')

@section('content')
    <div class="container">

        <div>
            <div>
                <div
                    class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="text-lg font-medium mr-auto mt-5">
                        Dokumentumok
                    </h2>
                </div>

                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                        <div class="hidden md:block mx-auto text-slate-500"></div>
                        <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                            @if (auth()->user()->email == 'klp7311@gmail.com')
                                <a href="{{ route('legaldocuments.create') }}"
                                    class="button text-black bg-theme-1 shadow-md mr-2">Dokumentum hozzáadása</a>
                            @endif
                        </div>
                    </div>
                    <!-- BEGIN: Data List -->
                    <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                        <table class="table table-report -mt-2">
                            <thead>
                                <tr>
                                    <th class="whitespace-nowrap">Sorrend</th>
                                    <th class="whitespace-nowrap">Cím</th>
                                    <th class="whitespace-nowrap">Státusz</th>
                                    <th class="text-center whitespace-nowrap">MŰVELETEK</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($documents as $item)
                                    <tr class="intro-x">
                                        <td>{{ $item->order }}</td>
                                        <td>{{ $item->title }}</td>
                                        <td>
                                            {{ $item->status == true ? 'Aktív' : 'Inaktív' }}
                                        </td>
                                        <td class="table-report__action w-56">
                                            <div class="flex">
                                                <a class="btn btn-success flex items-center mr-3 cursor-pointer text-white"
                                                    href="{{ route('legaldocuments.edit', $item->id) }}">
                                                    @include('partials.icons.show-icon')
                                                    <label class="ml-2  cursor-pointer">Szerkeszt</label> </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- END: Data List -->
                </div>

            </div>

        </div>


    </div>
@endsection
