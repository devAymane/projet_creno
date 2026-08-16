<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestion des rendez-vous
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Error --}}
            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-6">
                        Tous les rendez-vous
                    </h3>

                    @if ($rendezVous->isEmpty())

                        <p class="text-gray-500">
                            Aucun rendez-vous.
                        </p>

                    @else

                        <div class="overflow-x-auto">

                            <table class="min-w-full divide-y divide-gray-200">

                                <thead class="bg-gray-50">

                                    <tr>

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Client
                                        </th>

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

                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">
                                            Actions
                                        </th>

                                    </tr>

                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200">

                                    @foreach ($rendezVous as $rdv)

                                        <tr>

                                            {{-- Client --}}
                                            <td class="px-6 py-4">
                                                <div class="font-medium">
                                                    {{ $rdv->user->name }}
                                                </div>

                                                <div class="text-sm text-gray-500">
                                                    {{ $rdv->user->email }}
                                                </div>
                                            </td>

                                            {{-- Date --}}
                                            <td class="px-6 py-4">
                                                {{ $rdv->creneau->date->format('d/m/Y') }}
                                            </td>

                                            {{-- Heure --}}
                                            <td class="px-6 py-4">
                                                {{ $rdv->creneau->heure_debut }}
                                            </td>

                                            {{-- Durée --}}
                                            <td class="px-6 py-4">
                                                {{ $rdv->creneau->duree }} minutes
                                            </td>

                                            {{-- Statut --}}
                                            <td class="px-6 py-4">

                                                @if ($rdv->statut === 'en_attente')

                                                    <span class="text-yellow-600 font-semibold">
                                                        En attente
                                                    </span>

                                                @elseif ($rdv->statut === 'confirme')

                                                    <span class="text-green-600 font-semibold">
                                                        Confirmé
                                                    </span>

                                                @else

                                                    <span class="text-red-600 font-semibold">
                                                        Annulé
                                                    </span>

                                                @endif

                                            </td>

                                            {{-- Actions --}}
                                            <td class="px-6 py-4">

                                                <div class="flex gap-3">

                                                    @if ($rdv->statut === 'en_attente')

                                                        <form
                                                            action="{{ route('admin.rendezvous.confirmer', $rdv) }}"
                                                            method="POST"
                                                        >
                                                            @csrf
                                                            @method('PATCH')

                                                            <button
                                                                type="submit"
                                                                class="text-green-600 hover:text-green-800"
                                                            >
                                                                Confirmer
                                                            </button>
                                                        </form>

                                                        <form
                                                            action="{{ route('admin.rendezvous.annuler', $rdv) }}"
                                                            method="POST"
                                                        >
                                                            @csrf
                                                            @method('PATCH')

                                                            <button
                                                                type="submit"
                                                                class="text-red-600 hover:text-red-800"
                                                            >
                                                                Annuler
                                                            </button>
                                                        </form>

                                                    @else

                                                        <span class="text-gray-400">
                                                            Aucune action
                                                        </span>

                                                    @endif

                                                </div>

                                            </td>

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