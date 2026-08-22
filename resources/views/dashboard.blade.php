<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (auth()->user()->role === 'admin')

                {{-- ========================= --}}
                {{-- DASHBOARD ADMIN --}}
                {{-- ========================= --}}

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                    {{-- Créneaux --}}
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <p class="text-sm text-gray-500">
                            Total créneaux
                        </p>

                        <p class="text-3xl font-bold mt-2">
                            {{ $totalCreneaux }}
                        </p>
                    </div>

                    {{-- Rendez-vous --}}
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <p class="text-sm text-gray-500">
                            Total rendez-vous
                        </p>

                        <p class="text-3xl font-bold mt-2">
                            {{ $totalRendezVous }}
                        </p>
                    </div>

                    {{-- En attente --}}
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <p class="text-sm text-gray-500">
                            En attente
                        </p>

                        <p class="text-3xl font-bold mt-2">
                            {{ $rendezVousEnAttente }}
                        </p>
                    </div>

                    {{-- Confirmés --}}
                    <div class="bg-white p-6 rounded-lg shadow-sm">
                        <p class="text-sm text-gray-500">
                            Confirmés
                        </p>

                        <p class="text-3xl font-bold mt-2">
                            {{ $rendezVousConfirmes }}
                        </p>
                    </div>

                </div>

                {{-- Boutons Admin --}}
                <div class="mt-8 flex gap-4">

                    <a
                        href="{{ route('creneaux.index') }}"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700"
                    >
                        Gérer les créneaux
                    </a>

                    <a
                        href="{{ route('admin.rendezvous.index') }}"
                        class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700"
                    >
                        Gérer les rendez-vous
                    </a>

                </div>

            @else

                {{-- ========================= --}}
                {{-- DASHBOARD CLIENT --}}
                {{-- ========================= --}}

                <div class="bg-white shadow-sm rounded-lg p-6">

                    <h3 class="text-lg font-semibold mb-6">
                        Mes prochains rendez-vous
                    </h3>

                    @if ($prochainsRendezVous->isEmpty())

                        <p class="text-gray-500">
                            Vous n'avez aucun prochain rendez-vous.
                        </p>

                        <a
                            href="{{ route('creneaux.index') }}"
                            class="inline-block mt-4 bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700"
                        >
                            Voir les créneaux
                        </a>

                    @else

                        <div class="space-y-4">

                            @foreach ($prochainsRendezVous as $rdv)

                                <div class="border rounded-lg p-4 flex justify-between items-center">

                                    <div>

                                        <p class="font-semibold">
                                            {{ $rdv->creneau->date->format('d/m/Y') }}
                                        </p>

                                        <p class="text-gray-600">
                                            {{ $rdv->creneau->heure_debut }}
                                            —
                                            {{ $rdv->creneau->duree }} minutes
                                        </p>

                                    </div>

                                    @if ($rdv->statut === 'confirme')

                                        <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-sm">
                                            Confirmé
                                        </span>

                                    @else

                                        <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm">
                                            En attente
                                        </span>

                                    @endif

                                </div>

                            @endforeach

                        </div>

                        <a
                            href="{{ route('rendezvous.index') }}"
                            class="inline-block mt-6 text-blue-600 hover:text-blue-800"
                        >
                            Voir tous mes rendez-vous →
                        </a>

                    @endif

                </div>

            @endif

        </div>

    </div>

</x-app-layout>