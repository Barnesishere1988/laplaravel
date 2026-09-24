<div class="relative" x-data="{
    isOpen: false,
    subDropdownOpen: false,
    currentLocale: '{{ app()->getLocale() }}' || localStorage.getItem('locale') || (localStorage.getItem('dir') === 'rtl' ? 'ar' : 'en'),
    languages: [
        {
            id: 'en',
            name: 'English',
            shortName: 'English',
            flag: 'flag-us.svg',
            dir: 'ltr'
        },
        {
            id: 'ar',
            name: 'Arabic (Saudi)',
            shortName: 'Arabic',
            flag: 'flag-sa.svg',
            badge: 'RTL',
            dir: 'rtl'
        },
        {
            id: 'es',
            name: 'Español',
            shortName: 'Español',
            flag: 'flag-es.svg',
            dir: 'ltr'
        },
        {
            id: 'de',
            name: 'Deutsch',
            shortName: 'Deutsch',
            flag: 'flag-de.svg',
            dir: 'ltr'
        }
    ],
    get currentLang() {
        return this.languages.find(l => l.id === this.currentLocale) || this.languages[0];
    },
    toggleDropdown() {
        this.isOpen = !this.isOpen;
        if (!this.isOpen) {
            this.subDropdownOpen = false;
        }
    },
    closeDropdown() {
        this.isOpen = false;
        this.subDropdownOpen = false;
    },
    selectLanguage(lang) {
        this.currentLocale = lang.id;
        const dir = lang.dir || (lang.id === 'ar' ? 'rtl' : 'ltr');
        localStorage.setItem('locale', lang.id);
        localStorage.setItem('dir', dir);
        document.documentElement.setAttribute('dir', dir);
        document.documentElement.setAttribute('lang', lang.id);
        window.location.href = '/locale/' + lang.id;
    }
}" @click.outside="closeDropdown()">
    <!-- User Trigger -->
    <button
        class="flex items-center text-gray-700 dark:text-gray-400"
        type="button"
        @click="toggleDropdown()"
    >
        <span class="mr-3 overflow-hidden rounded-full h-11 w-11 rtl:mr-0 rtl:ml-3">
            <img src="/images/user/owner.png" alt="User" />
        </span>

        <span class="block mr-1 font-medium text-theme-sm rtl:mr-0 rtl:ml-1">{{ auth()->user()->email }}</span>

        <!-- Chevron Down Icon -->
        <svg
            :class="isOpen ? 'rotate-180' : ''"
            class="transition-transform duration-200 stroke-gray-500 group-hover:stroke-gray-700 dark:stroke-gray-400 dark:group-hover:stroke-gray-200"
            width="18"
            height="18"
            viewBox="0 0 18 18"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                d="M4.5 6.75L9 11.25L13.5 6.75"
                stroke="currentColor"
                stroke-width="1.5"
                stroke-linecap="round"
                stroke-linejoin="round"
            />
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute ltr:right-0 rtl:left-0 mt-[17px] flex w-[260px] flex-col rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark z-50"
        style="display: none;"
    >

        <!-- Sign Out -->
        <a
            href="{{ route('signout') }}"
            class="flex items-center w-full gap-3 px-3 py-2 mt-3 font-medium text-gray-700 rounded-lg group text-theme-sm hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-white/5 dark:hover:text-gray-300"
            @click="closeDropdown()"
        >
            <span class="text-gray-500 group-hover:text-gray-700 dark:group-hover:text-gray-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </span>
            Sign out
        </a>
    </div>
</div>
