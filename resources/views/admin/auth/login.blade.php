<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
  <form method="POST" action="{{ route('admin.login.submit') }}" class="bg-white p-8 rounded shadow w-96">
    @csrf
    <h2 class="text-2xl font-bold mb-6 text-center text-indigo-600">Admin Login</h2>

    @if($errors->any())
    <div class="mb-4 text-red-600 text-sm">
      {{ $errors->first() }}
    </div>
  @endif

    <div class="mb-4">
      <label class="block mb-1 font-semibold">Email</label>
      <input type="email" name="email" required class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
    </div>

    <div class="mb-6">
      <label class="block mb-1 font-semibold">Password</label>
      <input type="password" name="password" required
        class="w-full px-4 py-2 border rounded focus:outline-none focus:ring">
    </div>

    <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
      Login
    </button>
  </form>
</body>

</html>