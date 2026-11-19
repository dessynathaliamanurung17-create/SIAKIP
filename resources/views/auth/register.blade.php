<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            <ul class="list-disc ps-5">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <!-- NIM -->
        <div class="mt-4">
            <x-input-label for="nim" value="NIM" />
            <x-text-input id="nim" class="block mt-1 w-full" type="text" name="nim" :value="old('nim')" required />
            <x-input-error :messages="$errors->get('nim')" class="mt-2" />
        </div>

        <!--jurusan-->
        <div class="mt-4">
            <x-input-label for="jurusan" value="Jurusan" />
            <x-text-input id="jurusan" class="block mt-1 w-full" type="text" name="jurusan" :value="old('jurusan')" required />
            <x-input-error :messages="$errors->get('jurusan')" class="mt-2" />
        </div>

        <!--program studi-->
        <div class="mt-4">
            <x-input-label for="program_studi" value="Program Studi" />
            <x-text-input id="program_studi" class="block mt-1 w-full" type="text" name="program_studi" :value="old('program_studi')" required />
            <x-input-error :messages="$errors->get('program_studi')" class="mt-2" />
        </div>

        <!--No Hp-->
        <div class="mt-4">
            <x-input-label for="no_hp" value="No. HP" />
            <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" :value="old('no_hp')" />
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
        </div>


        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                type="password"
                name="password"
                required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                type="password"
                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

</x-guest-layout>
