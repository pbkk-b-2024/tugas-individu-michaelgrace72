<x-app-layout>
 <form action="{{ route('admin.companies.store')}}" method="POST">
  @csrf
  <div class="border-b border-gray-900/10 pb-12">
      <h2 class="text-base font-semibold leading-7 text-gray-900">Add Companies</h2>
      <p class="mt-1 text-sm leading-6 text-gray-600"></p>

        <div class="sm:col-span-3">
          <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900">TMDB ID</label>
          <div class="mt-2">
            <input value="{{ request('TMDBID')}}" type="text" name="TMDBID" id="tmdb_id" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
          </div>
        </div>
  </div>
<div class="mt-6 flex items-center justify-end gap-x-6">
    <a href="{{ route('admin.companies.index')}}" type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
  </div>
</form>
</x-app-layout>