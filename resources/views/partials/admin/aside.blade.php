<aside class="w-64 bg-white shadow-md px-6 py-8 hidden md:block sticky top-0 h-screen overflow-y-auto">
  <h2 class="text-2xl font-bold text-indigo-700 mb-8">Admin Panel</h2>

  <nav class="space-y-4" aria-label="Sidebar navigation">
    <!-- Dashboard -->
    <a href="{{ route('admin.dashboard') }}"
       class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition
              {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
      <i class="fa fa-home mr-3"></i>
      Dashboard
    </a>

    <!-- Users Submenu -->
    <div x-data="{ open: {{ request()->routeIs('admin.labels.*') ? 'true' : 'false' }} }" class="space-y-1">
      <button @click="open = !open"
              class="flex items-center justify-between w-full px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700
                     transition {{ request()->routeIs('admin.labels.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
        <span class="flex items-center">
          <i class="fa fa-user mr-3"></i> Users
        </span>
        <i :class="open ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
      </button>
      <div x-show="open" x-cloak class="pl-10 mt-1 space-y-1">
        <a href="{{ route('admin.labels.all') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition
                  {{ request()->routeIs('admin.labels.all') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
          Labels
        </a>
        <a href="{{ route('admin.labels.artists') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition
                  {{ request()->routeIs('admin.labels.artists') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
          Artists
        </a>
      </div>
    </div>

    <!-- Pricing & Commissions -->
    <a href="{{ route('admin.pricing.plans') }}"
       class="flex items-center px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition
              {{ request()->routeIs('pricing.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
      <i class="fa fa-tags mr-3"></i> Pricing & Commissions
    </a>

    <!-- Music Releases Dropdown -->
    <div x-data="{ open: {{ request()->routeIs('admin.releases.*') ? 'true' : 'false' }} }" class="space-y-1">
      <button @click="open = !open"
              class="flex items-center justify-between w-full px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700
                     transition {{ request()->routeIs('admin.releases.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
        <span class="flex items-center">
          <i class="fa fa-compact-disc mr-3"></i> Music Releases
        </span>
        <i :class="open ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
      </button>
      <div x-show="open" x-cloak class="pl-10 mt-1 space-y-1">
        <a href="{{ route('admin.releases.all') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          All Releases
        </a>
        <a href="{{ route('admin.releases.pending') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          Pending Releases
        </a>
        <a href="{{ route('admin.releases.approved') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          Approved Releases
        </a>
        <a href="{{ route('admin.releases.reject') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          Rejected Releases
        </a>
      </div>
    </div>

    <!-- Royalties & Payments Dropdown -->
    <div x-data="{ open: {{ request()->routeIs('admin.royalties.*') ? 'true' : 'false' }} }" class="space-y-1">
      <button @click="open = !open"
              class="flex items-center justify-between w-full px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700
                     transition {{ request()->routeIs('admin.royalties.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
        <span class="flex items-center">
          <i class="fa fa-dollar-sign mr-3"></i> Royalties & Payments
        </span>
        <i :class="open ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
      </button>
      <div x-show="open" x-cloak class="pl-10 mt-1 space-y-1">
        <a href="{{ route('admin.royalties.reports') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition
                  {{ request()->routeIs('admin.royalties.reports') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
          Royalty Overview
        </a>
        <a href="{{ route('admin.royalties.reports.streams') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition
                  {{ request()->routeIs('admin.royalties.reports.streams') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
          Streams Report
        </a>
        <a href="{{ route('admin.royalties.reports.earnings') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition
                  {{ request()->routeIs('admin.royalties.reports.earnings') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
          Earnings Report
        </a>
        <a href="{{ route('admin.royalties.reports.royalties') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition
                  {{ request()->routeIs('admin.royalties.reports.royalties') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
          Royalties Report
        </a>
        <a href="{{ route('admin.royalties.payouts') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition
                  {{ request()->routeIs('admin.royalties.payouts') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
          Payout Requests
        </a>
      </div>
    </div>

    <!-- Analytics & Reports Dropdown -->
    <div x-data="{ open: {{ request()->routeIs('admin.analytics.*') ? 'true' : 'false' }} }" class="space-y-1">
      <button @click="open = !open"
              class="flex items-center justify-between w-full px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700
                     transition {{ request()->routeIs('admin.analytics.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
        <span class="flex items-center">
          <i class="fa fa-chart-bar mr-3"></i> Analytics & Reports
        </span>
        <i :class="open ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
      </button>
      <div x-show="open" x-cloak class="pl-10 mt-1 space-y-1">
        <a href="{{ route('admin.analytics.streaming') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          Streaming Stats
        </a>
        <a href="{{ route('admin.analytics.revenue') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          Revenue Reports
        </a>
        <a href="{{ route('admin.analytics.growth') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          User Growth
        </a>
        <a href="{{ route('admin.analytics.export') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          Export Reports
        </a>
      </div>
    </div>

    <!-- Support Dropdown -->
    <div x-data="{ open: {{ request()->routeIs('admin.support.*') ? 'true' : 'false' }} }" class="space-y-1">
      <button @click="open = !open"
              class="flex items-center justify-between w-full px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700
                     transition {{ request()->routeIs('admin.support.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
        <span class="flex items-center">
          <i class="fa fa-life-ring mr-3"></i> Support
        </span>
        <i :class="open ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
      </button>
      <div x-show="open" x-cloak class="pl-10 mt-1 space-y-1">
        <a href="{{ route('admin.support.tickets') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          Tickets
        </a>
        <a href="{{ route('admin.support.kb') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          Knowledge Base
        </a>
        <a href="{{ route('admin.support.feedback') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          Customer Feedback
        </a>
        <a href="{{ route('admin.support.faq') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          FAQ
        </a>
      </div>
    </div>

    <!-- Settings Dropdown -->
    <div x-data="{ open: {{ request()->routeIs('admin.settings.*') ? 'true' : 'false' }} }" class="space-y-1">
      <button @click="open = !open"
              class="flex items-center justify-between w-full px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700
                     transition {{ request()->routeIs('admin.settings.*') ? 'bg-indigo-100 text-indigo-700 font-semibold' : '' }}">
        <span class="flex items-center">
          <i class="fa fa-cog mr-3"></i> Settings
        </span>
        <i :class="open ? 'fa fa-chevron-up' : 'fa fa-chevron-down'"></i>
      </button>
      <div x-show="open" x-cloak class="pl-10 mt-1 space-y-1">
        <a href="{{ route('admin.settings.general') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          General Settings
        </a>
        <a href="{{ route('admin.settings.payment') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          Payment Gateway
        </a>
        <a href="{{ route('admin.settings.integrations') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          Integrations
        </a>
        <a href="{{ route('admin.settings.security') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          Security
        </a>
        <a href="{{ route('admin.settings.site_content') }}"
           class="block px-4 py-2 rounded-lg text-gray-700 hover:bg-indigo-100 hover:text-indigo-700 transition">
          Site Content
        </a>
      </div>
    </div>

    <!-- Logout -->
    <form action="{{ route('admin.logout') }}" method="POST" class="pt-6">
      @csrf
      <button type="submit"
              class="flex items-center w-full px-4 py-2 rounded-lg text-red-600 hover:bg-red-100 hover:text-red-700 transition">
        <i class="fa fa-sign-out-alt mr-3"></i>
        Logout
      </button>
    </form>
  </nav>
</aside>
