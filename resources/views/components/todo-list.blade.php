
<div class="rounded-xl border border-gray-200 bg-white p-5
            dark:border-gray-800 dark:bg-gray-900">

    <h2 class="mb-5 text-xl font-semibold
               text-gray-800 dark:text-white">
        Todo Liste
    </h2>

    @if (session('success'))
        <div class="mb-4 rounded bg-green-100 p-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded bg-red-100 p-3 text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Nur Administratoren dürfen Aufgaben erstellen -->

    @if (auth()->user()->is_admin)

        <form action="{{ route('todos.store') }}"
              method="POST"
              class="mb-5 flex gap-3">

            @csrf

            <input
                type="text"
                name="beschreibung"
                placeholder="Neue Aufgabe eingeben..."
                required
                class="w-full rounded-lg border
                       border-gray-300 px-4 py-2
                       dark:border-gray-700
                       dark:bg-gray-800 dark:text-white"
            >

            <button
                type="submit"
                class="rounded-lg bg-brand-500 px-5 py-2
                       text-white hover:bg-brand-600"
            >
                Hinzufügen
            </button>

        </form>

    @endif

    <!-- Aufgaben anzeigen -->

    @forelse ($todos as $todo)

        <div class="flex items-center justify-between
                    border-b border-gray-200 py-4
                    dark:border-gray-800">

            <div class="flex items-center gap-3">

                @if (auth()->user()->is_admin)

                    <form
                        action="{{ route('todos.update', $todo) }}"
                        method="POST"
                    >

                        @csrf
                        @method('PATCH')

                        <input
                            type="hidden"
                            name="is_done"
                            value="{{ $todo->is_done ? 0 : 1 }}"
                        >

                        <input
                            type="checkbox"
                            {{ $todo->is_done ? 'checked' : '' }}
                            onchange="this.form.submit()"
                            class="h-5 w-5 rounded
                                   text-brand-500"
                        >

                    </form>

                @else

                    <input
                        type="checkbox"
                        {{ $todo->is_done ? 'checked' : '' }}
                        disabled
                        class="h-5 w-5 rounded"
                    >

                @endif

                <span class="{{ $todo->is_done
                    ? 'text-gray-400 line-through'
                    : 'text-gray-800 dark:text-white' }}">

                    {{ $todo->beschreibung }}

                </span>

            </div>

            
            @if (auth()->user()->is_admin)

                <div x-data="{ editing: false }"
                    class="flex items-center gap-3">

                    <!-- Bearbeiten -->

                    <button
                        type="button"
                        @click="editing = true"
                        class="text-brand-500 hover:text-brand-600"
                    >
                        Bearbeiten
                    </button>

                    <!-- Löschen -->

                    <form
                        action="{{ route('todos.destroy', $todo) }}"
                        method="POST"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            onclick="return confirm('Aufgabe löschen?')"
                            class="text-red-500 hover:text-red-700"
                        >
                            Löschen
                        </button>
                    </form>

                    <!-- Modal -->

                    <template x-teleport="body">

                        <div
                            x-show="editing"
                            x-cloak
                            @keydown.escape.window="editing = false"
                            class="fixed inset-0 z-[99999] flex
                                items-center justify-center p-4"
                        >

                            <!-- Dunkler Hintergrund -->

                            <div
                                class="absolute inset-0 bg-black/70"
                                @click="editing = false"
                            ></div>

                            <!-- Modal-Inhalt -->

                            <div
                                class="relative z-10 w-full max-w-xl
                                    rounded-2xl border border-gray-200
                                    bg-white p-6 shadow-xl
                                    dark:border-gray-800
                                    dark:bg-gray-900"
                            >

                                <h3
                                    class="mb-5 text-xl font-semibold
                                        text-gray-800 dark:text-white"
                                >
                                    Aufgabe bearbeiten
                                </h3>

                                <form
                                    action="{{ route('todos.update', $todo) }}"
                                    method="POST"
                                >

                                    @csrf
                                    @method('PATCH')

                                    <label
                                        class="mb-2 block text-sm font-medium
                                            text-gray-700 dark:text-gray-300"
                                    >
                                        Beschreibung
                                    </label>

                                    <textarea
                                        name="beschreibung"
                                        rows="4"
                                        maxlength="1000"
                                        required
                                        class="w-full rounded-lg border
                                            border-gray-300 bg-white
                                            px-4 py-3 text-gray-800
                                            outline-none
                                            focus:border-brand-500
                                            dark:border-gray-700
                                            dark:bg-gray-800
                                            dark:text-white"
                                    >{{ $todo->beschreibung }}</textarea>

                                    <div class="mt-6 flex justify-end gap-3">

                                        <button
                                            type="button"
                                            @click="editing = false"
                                            class="rounded-lg border
                                                border-gray-300 px-5 py-2.5
                                                text-gray-700
                                                hover:bg-gray-100
                                                dark:border-gray-700
                                                dark:text-gray-300
                                                dark:hover:bg-gray-800"
                                        >
                                            Abbrechen
                                        </button>

                                        <button
                                            type="submit"
                                            class="rounded-lg bg-brand-500
                                                px-5 py-2.5 text-white
                                                hover:bg-brand-600"
                                        >
                                            Speichern
                                        </button>

                                    </div>

                                </form>

                            </div>

                        </div>

                    </template>

                </div>

            @endif

        </div>

    @empty

        <p class="py-5 text-gray-500">
            Keine Aufgaben vorhanden.
        </p>

    @endforelse

</div>