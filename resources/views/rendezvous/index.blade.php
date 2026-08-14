<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes rendez-vous
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Messages --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                @if ($rendezVous->isEmpty())

                    <p class="text-gray-600">
                        Aucun rendez-vous.
                    </p>

                @else

                    <table class="min-w-full">

                        <thead>
                            <tr class="border-b">
                                <th class="text-left p-3">Date</th>
                                <th class="text-left p-3">Heure</th>
                                <th class="text-left p-3">Durée</th>
                                <th class="text-left p-3">Statut</th>
                                <th class="text-left p-3">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($rendezVous as $rdv)

                                <tr class="border-b">

                                    <td class="p-3">
                                        {{ $rdv->creneau->date->format('d/m/Y') }}
                                    </td>

                                    <td class="p-3">
                                        {{ $rdv->creneau->heure_debut }}
                                    </td>

                                    <td class="p-3">
                                        {{ $rdv->creneau->duree }} minutes
                                    </td>

                                    <td class="p-3">
                                        {{ $rdv->statut }}
                                    </td>

                                    <td class="p-3">

                                        @if ($rdv->statut !== 'annule')

                                            <form
                                                action="{{ route('rendezvous.destroy', $rdv) }}"
                                                method="POST"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    style="
                                                        background:#dc2626;
                                                        color:white;
                                                        padding:8px 14px;
                                                        border:0;
                                                        border-radius:5px;
                                                        cursor:pointer;
                                                    "
                                                >
                                                    Annuler
                                                </button>

                                            </form>

                                        @else

                                            <span class="text-gray-500">
                                                Annulé
                                            </span>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                @endif

            </div>

        </div>
    </div>

</x-app-layout>
