<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>

            <table class="bg-white overflow-hidden shadow-sm sm:rounded-lg" style="margin-top: 20px;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cars as $key => $car)
                    <tr>
                        <td>{{ $key++ }}</td>
                        <td>{{ $car->name }}</td>
                        <td>{{ $car->price }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</x-app-layout>
