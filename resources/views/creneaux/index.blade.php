<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Créneaux disponibles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success message --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error message --}}
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">

                    <div class="flex justify-between items-center mb-6">

                        <h3 class="text-lg font-semibold">
                            Liste des créneaux
                        </h3>

                        @if (auth()->user()->role === 'admin')
                            <a
                                href="{{ route('creneaux.create') }}"
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700"
                            >
                                + Ajouter un créneau
                            </a>
                        @endif

                    </div>

                    @if ($creneaux->isEmpty())

                        <p class="text-gray-500">
                            Aucun créneau disponible.
                        </p>

                    @else

                        <div class="overflow-x-auto">

                            <table class="min-w-full divide-y divide-gray-200">

                                <thead class="bg-gray-50">

                                    <tr>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Date
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Heure
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Durée
                                        </th>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Statut
                                        </th>

                                        @if (auth()->user()->role === 'admin')
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                                Actions
                                            </th>
                                        @endif

                                    </tr>

                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200">

                                    @foreach ($creneaux as $creneau)

                                        <tr>

                                            <td class="px-6 py-4">
                                                {{ $creneau->date->format('d/m/Y') }}
                                            </td>

                                            <td class="px-6 py-4">
                                                {{ $creneau->heure_debut }}
                                            </td>

                                            <td class="px-6 py-4">
                                                {{ $creneau->duree }} minutes
                                            </td>

                                            <td class="px-6 py-4">

                                                @if ($creneau->rendezVous)
                                                    <span class="text-red-600 font-semibold">
                                                        Réservé
                                                    </span>
                                                @else
                                                    <span class="text-green-600 font-semibold">
                                                        Disponible
                                                    </span>
                                                @endif

                                            </td>

                                            @if (auth()->user()->role === 'admin')

                                                <td class="px-6 py-4">

                                                    <div class="flex gap-2">

                                                        <a
                                                            href="{{ route('creneaux.edit', $creneau) }}"
                                                            class="text-blue-600 hover:text-blue-800"
                                                        >
                                                            Modifier
                                                        </a>

                                                        @if (!$creneau->rendezVous)

                                                            <form
                                                                action="{{ route('creneaux.destroy', $creneau) }}"
                                                                method="POST"
                                                            >

                                                                @csrf
                                                                @method('DELETE')

                                                                <button
                                                                    type="submit"
                                                                    class="text-red-600 hover:text-red-800"
                                                                    onclick="return confirm('Voulez-vous vraiment supprimer ce créneau ?')"
                                                                >
                                                                    Supprimer
                                                                </button>

                                                            </form>

                                                        @endif

                                                    </div>

                                                </td>

                                            @endif

                                        </tr>

                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    @endif

                </div>

            </div>

        </div>
    </div>

</x-app-layout>