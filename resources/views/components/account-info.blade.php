
@php
    $user = auth()->user();

    $inputClass = 'w-full rounded-lg border ' .
        'border-gray-300 bg-transparent px-4 py-3 ' .
        'text-gray-800 outline-none ' .
        'focus:border-brand-500 ' .
        'dark:border-gray-700 dark:text-white';

    $buttonClass = 'rounded-lg bg-brand-500 ' .
        'px-5 py-2.5 text-white ' .
        'hover:bg-brand-600';
@endphp

<div class="space-y-6">

    <h1 class="text-2xl font-semibold
               text-gray-800 dark:text-white">
        Mein Account
    </h1>

    @if (session('success'))
        <div class="rounded-lg bg-green-100 p-4
                    text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="rounded-lg bg-red-100 p-4
                    text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Profilbild -->

    <div class="rounded-xl border border-gray-200
                bg-white p-6 dark:border-gray-800
                dark:bg-gray-900">

        <h2 class="mb-5 text-lg font-semibold
                   text-gray-800 dark:text-white">
            Profilbild
        </h2>

        <div class="mb-5 flex items-center gap-5">

            @if ($user->user_image)

                <img
                    src="{{ asset(
                        'storage/avatars/' .
                        $user->user_image
                    ) }}"
                    alt="Profilbild"
                    class="h-20 w-20 rounded-full
                           object-cover"
                >

            @else

                <div class="flex h-20 w-20 items-center
                            justify-center rounded-full
                            bg-gray-100 text-gray-500
                            dark:bg-gray-800">

                    Kein Bild

                </div>

            @endif

            <div>
                <p class="font-medium text-gray-800
                          dark:text-white">
                    {{ $user->fname }}
                    {{ $user->lname }}
                </p>

                <p class="text-sm text-gray-500">
                    {{ $user->email }}
                </p>
            </div>

        </div>

        <form
            action="{{ route('account.image.update') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            <input
                type="file"
                name="user_image"
                accept=".jpg,.jpeg,.png,.webp"
                required
                class="{{ $inputClass }}"
            >

            <p class="mt-2 text-sm text-gray-500">
                JPG, PNG oder WEBP.
                Maximale Dateigröße: 2 MB.
            </p>

            <div class="mt-4">

                <button
                    type="submit"
                    class="{{ $buttonClass }}"
                >
                    Profilbild speichern
                </button>

            </div>

        </form>

        @if ($user->user_image)

            <form
                action="{{ route('account.image.delete') }}"
                method="POST"
                class="mt-4"
            >

                @csrf
                @method('DELETE')

                <button
                    type="submit"
                    onclick="return confirm(
                        'Profilbild wirklich löschen?'
                    )"
                    class="text-red-500
                           hover:text-red-600"
                >
                    Profilbild löschen
                </button>

            </form>

        @endif

    </div>

    <!-- Accountinformationen -->

    <div class="rounded-xl border border-gray-200
                bg-white p-6 dark:border-gray-800
                dark:bg-gray-900">

        <h2 class="mb-5 text-lg font-semibold
                   text-gray-800 dark:text-white">
            Account Information
        </h2>

        <form
            action="{{ route('account.update') }}"
            method="POST"
            class="space-y-4"
        >

            @csrf
            @method('PATCH')

            <div>
                <label class="mb-2 block text-sm
                              text-gray-700
                              dark:text-gray-300">
                    Vorname
                </label>

                <input
                    type="text"
                    name="fname"
                    value="{{ old(
                        'fname',
                        $user->fname
                    ) }}"
                    required
                    class="{{ $inputClass }}"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm
                              text-gray-700
                              dark:text-gray-300">
                    Nachname
                </label>

                <input
                    type="text"
                    name="lname"
                    value="{{ old(
                        'lname',
                        $user->lname
                    ) }}"
                    required
                    class="{{ $inputClass }}"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm
                              text-gray-700
                              dark:text-gray-300">
                    E-Mail-Adresse
                </label>

                <input
                    type="email"
                    name="email"
                    value="{{ old(
                        'email',
                        $user->email
                    ) }}"
                    required
                    class="{{ $inputClass }}"
                >
            </div>

            <div class="flex justify-end">

                <button
                    type="submit"
                    class="{{ $buttonClass }}"
                >
                    Änderungen speichern
                </button>

            </div>

        </form>

    </div>

    <!-- Passwort ändern -->

    <div class="rounded-xl border border-gray-200
                bg-white p-6 dark:border-gray-800
                dark:bg-gray-900">

        <h2 class="mb-5 text-lg font-semibold
                   text-gray-800 dark:text-white">
            Passwort ändern
        </h2>

        <form
            action="{{ route(
                'account.password.update'
            ) }}"
            method="POST"
            class="space-y-4"
        >

            @csrf
            @method('PATCH')

            <div>
                <label class="mb-2 block text-sm
                              text-gray-700
                              dark:text-gray-300">
                    Aktuelles Passwort
                </label>

                <input
                    type="password"
                    name="current_password"
                    autocomplete="current-password"
                    required
                    class="{{ $inputClass }}"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm
                              text-gray-700
                              dark:text-gray-300">
                    Neues Passwort
                </label>

                <input
                    type="password"
                    name="password"
                    autocomplete="new-password"
                    minlength="8"
                    required
                    class="{{ $inputClass }}"
                >
            </div>

            <div>
                <label class="mb-2 block text-sm
                              text-gray-700
                              dark:text-gray-300">
                    Neues Passwort bestätigen
                </label>

                <input
                    type="password"
                    name="password_confirmation"
                    autocomplete="new-password"
                    minlength="8"
                    required
                    class="{{ $inputClass }}"
                >
            </div>

            <div class="flex justify-end">

                <button
                    type="submit"
                    class="{{ $buttonClass }}"
                >
                    Passwort ändern
                </button>

            </div>

        </form>

    </div>

</div>