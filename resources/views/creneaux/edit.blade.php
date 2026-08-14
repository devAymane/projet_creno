<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le créneau
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-6">
                        Modifier le créneau
                    </h3>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('creneaux.update', $creneau) }}" method="POST">

                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="date">Date</label>

                            <input
                                type="date"
                                id="date"
                                name="date"
                                value="{{ old('date', $creneau->date->format('Y-m-d')) }}"
                                min="{{ date('Y-m-d') }}"
                                required
                                class="w-full border-gray-300 rounded-lg shadow-sm"
                            >
                        </div>

                        <div class="mb-4">
                            <label for="heure_debut">Heure de début</label>

                            <input
                                type="time"
                                id="heure_debut"
                                name="heure_debut"
                                value="{{ old('heure_debut', $creneau->heure_debut) }}"
                                required
                                class="w-full border-gray-300 rounded-lg shadow-sm"
                            >
                        </div>

                        <div class="mb-6">
                            <label for="duree">Durée (minutes)</label>

                            <input
                                type="number"
                                id="duree"
                                name="duree"
                                value="{{ old('duree', $creneau->duree) }}"
                                min="15"
                                max="480"
                                required
                                class="w-full border-gray-300 rounded-lg shadow-sm"
                            >
                        </div>

                        <div style="display:flex; gap:15px; align-items:center;">

                            <button
                                type="submit"
                                style="background:#2563eb;color:white;padding:10px 20px;border:0;border-radius:6px;cursor:pointer;"
                            >
                                Enregistrer
                            </button>

                            <a href="{{ route('creneaux.index') }}">
                                Annuler
                            </a>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>