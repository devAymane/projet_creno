<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un créneau') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg">

                <div class="p-6">

                    <h3 class="text-lg font-semibold mb-6">
                        Nouveau créneau
                    </h3>

                    @if ($errors->any())
                        <div class="mb-6 p-4 bg-red-100 text-red-800 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form
                        action="{{ route('creneaux.store') }}"
                        method="POST"
                    >

                        @csrf

                        {{-- Date --}}
                        <div class="mb-4">

                            <label
                                for="date"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Date
                            </label>

                            <input
                                type="date"
                                id="date"
                                name="date"
                                value="{{ old('date') }}"
                                min="{{ date('Y-m-d') }}"
                                required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                        </div>

                        {{-- Heure --}}
                        <div class="mb-4">

                            <label
                                for="heure_debut"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Heure de début
                            </label>

                            <input
                                type="time"
                                id="heure_debut"
                                name="heure_debut"
                                value="{{ old('heure_debut') }}"
                                required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                        </div>

                        {{-- Durée --}}
                        <div class="mb-6">

                            <label
                                for="duree"
                                class="block text-sm font-medium text-gray-700 mb-2"
                            >
                                Durée (minutes)
                            </label>

                            <input
                                type="number"
                                id="duree"
                                name="duree"
                                value="{{ old('duree', 30) }}"
                                min="1"
                                required
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                            >

                        </div>

{{-- Buttons --}}
<div style="display: flex; gap: 15px; align-items: center; margin-top: 20px;">

    <button
        type="submit"
        style="
            background-color: #2563eb;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        "
    >
        Créer le créneau
    </button>

    <a
        href="{{ route('creneaux.index') }}"
        style="
            color: #374151;
            text-decoration: none;
            font-size: 16px;
        "
    >
        Annuler
    </a>

</div>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</x-app-layout>