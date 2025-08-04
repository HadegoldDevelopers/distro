<!-- Logo -->
<a href="#" class="flex items-center text-orange-500 text-2xl font-bold rounded-lg p-2 mb-8">
  <img src="{{ asset('storage/' . $global['site_logo']) }}" alt="Site Logo" class="w-10 h-10 mr-2">
</a>

<nav class="flex-1">
  <ul class="space-y-3">

    <!-- Common Dashboard Link -->
    <li>
      <a href="{{ route('user.dashboard') }}"
         class="flex items-center space-x-3 p-3 rounded-lg transition duration-200 
            {{ request()->routeIs('user.dashboard') ? 'bg-orange-600 text-white font-semibold' : 'text-gray-300 hover:bg-zinc-800 hover:text-white' }}">
        <i class="fas fa-chart-line text-lg"></i>
        <span>{{ __('Dashboard') }}</span>
      </a>
    </li>

    @if(auth()->user()->role === 'label')

      <li>
        <a href="{{ route('music.upload') }}"
           class="flex items-center space-x-3 p-3 rounded-lg transition duration-200 
              {{ request()->routeIs('music.upload') ? 'bg-orange-600 text-white font-semibold' : 'text-gray-300 hover:bg-zinc-800 hover:text-white' }}">
          <i class="fas fa-upload text-lg"></i>
          <span>{{ __('Uploads') }}</span>
        </a>
      </li>

      <li>
        <a href="#"
           class="flex items-center space-x-3 p-3 rounded-lg transition duration-200 
              {{ request()->routeIs('user.analytics') ? 'bg-orange-600 text-white font-semibold' : 'text-gray-300 hover:bg-zinc-800 hover:text-white' }}">
          <i class="fas fa-chart-pie text-lg"></i>
          <span>{{ __('Analytics') }}</span>
        </a>
      </li>

      <li>
        <a href="{{ route('artists.index') }}"
           class="flex items-center space-x-3 p-3 rounded-lg transition duration-200 
              {{ request()->routeIs('artists.index') ? 'bg-orange-600 text-white font-semibold' : 'text-gray-300 hover:bg-zinc-800 hover:text-white' }}">
          <i class="fas fa-users text-lg"></i>
          <span>{{ __('Artists') }}</span>
        </a>
      </li>

      <li>
        <a href="{{ route('user.releases') }}"
           class="flex items-center space-x-3 p-3 rounded-lg transition duration-200 
              {{ request()->routeIs('user.releases') ? 'bg-orange-600 text-white font-semibold' : 'text-gray-300 hover:bg-zinc-800 hover:text-white' }}">
          <i class="fas fa-compact-disc text-lg"></i>
          <span>{{ __('Releases') }}</span>
        </a>
      </li>

      <li>
        <a href="{{ route('payment.index') }}"
           class="flex items-center space-x-3 p-3 rounded-lg transition duration-200 
              {{ request()->routeIs('payment.index') ? 'bg-orange-600 text-white font-semibold' : 'text-gray-300 hover:bg-zinc-800 hover:text-white' }}">
          <i class="fas fa-wallet text-lg"></i>
          <span>{{ __('Payments') }}</span>
        </a>
      </li>

      <li>
        <a href="{{ route('user.settings') }}"
           class="flex items-center space-x-3 p-3 rounded-lg transition duration-200 
              {{ request()->routeIs('user.settings') ? 'bg-orange-600 text-white font-semibold' : 'text-gray-300 hover:bg-zinc-800 hover:text-white' }}">
          <i class="fas fa-cog text-lg"></i>
          <span>{{ __('Settings') }}</span>
        </a>
      </li>

    @elseif(auth()->user()->role === 'artist')

      <li>
        <a href="{{ route('music.upload') }}"
           class="flex items-center space-x-3 p-3 rounded-lg transition duration-200 
              {{ request()->routeIs('music.upload') ? 'bg-orange-600 text-white font-semibold' : 'text-gray-300 hover:bg-zinc-800 hover:text-white' }}">
          <i class="fas fa-upload text-lg"></i>
          <span>{{ __('Upload Track') }}</span>
        </a>
      </li>

      <li>
        <a href="{{ route('user.releases') }}"
           class="flex items-center space-x-3 p-3 rounded-lg transition duration-200 
              {{ request()->routeIs('user.releases') ? 'bg-orange-600 text-white font-semibold' : 'text-gray-300 hover:bg-zinc-800 hover:text-white' }}">
          <i class="fas fa-compact-disc text-lg"></i>
          <span>{{ __('My Releases') }}</span>
        </a>
      </li>

      <li>
        <a href="#"
           class="flex items-center space-x-3 p-3 rounded-lg transition duration-200 
              {{ request()->routeIs('user.analytics') ? 'bg-orange-600 text-white font-semibold' : 'text-gray-300 hover:bg-zinc-800 hover:text-white' }}">
          <i class="fas fa-chart-pie text-lg"></i>
          <span>{{ __('Analytics') }}</span>
        </a>
      </li>

      <li>
        <a href="{{ route('payment.index') }}"
           class="flex items-center space-x-3 p-3 rounded-lg transition duration-200 
              {{ request()->routeIs('payment.index') ? 'bg-orange-600 text-white font-semibold' : 'text-gray-300 hover:bg-zinc-800 hover:text-white' }}">
          <i class="fas fa-wallet text-lg"></i>
          <span>{{ __('Payments') }}</span>
        </a>
      </li>

      <li>
        <a href="{{ route('user.settings') }}"
           class="flex items-center space-x-3 p-3 rounded-lg transition duration-200 
              {{ request()->routeIs('user.settings') ? 'bg-orange-600 text-white font-semibold' : 'text-gray-300 hover:bg-zinc-800 hover:text-white' }}">
          <i class="fas fa-cog text-lg"></i>
          <span>{{ __('Settings') }}</span>
        </a>
      </li>

    @endif
  </ul>
</nav>

<!-- User Profile (bottom of sidebar) -->
<div class="mt-auto pt-6 border-t border-zinc-800">
  <a href="{{ route('profile.edit') }}"
     class="flex items-center space-x-3 p-3 rounded-lg text-gray-300 hover:bg-zinc-800 hover:text-white transition duration-200">
    @if(auth()->user()->user_profileimage)
      <img src="{{ asset('storage/' . auth()->user()->user_profileimage) }}"
           class="w-20 h-20 object-cover rounded-full" alt="Profile Image">
          
    @else
      @php
        $initial = strtoupper(substr(auth()->user()->name, 0, 1));
      @endphp
      <img src="https://placehold.co/80x80/333/fff?text={{ $initial }}"
           class="w-20 h-20 object-cover rounded-full" alt="User Initial">
           
    @endif

    <div>
    <div class="mb-6 flex items-center space-x-2">
    @if(auth()->user()->role === 'label')
        <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-600 text-white text-sm font-semibold">
            Label
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
        </span>
    @elseif(auth()->user()->role === 'artist')
        <span class="inline-flex items-center px-3 py-1 rounded-full bg-gray-700 text-gray-300 text-sm font-semibold">
            Artist
        </span>
    @endif
</div>

      <p class="font-semibold">{{ $user->name }}</p>
      <p class="text-sm text-gray-400">View Profile</p>
    </div>
  </a>

  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button
      class="w-full mt-4 bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
      <i class="fas fa-sign-out-alt mr-2"></i>{{ __('Log Out') }}
    </button>
  </form>
</div>
