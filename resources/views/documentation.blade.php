<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('API Key Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Your API Key</h3>

                    <!-- Display the API key if it exists -->
                    @if(Auth::user()->api_key)
                        <p class="mb-4">
                            <strong>API Key:</strong> <span class="text-gray-600">{{ Auth::user()->api_key }}</span>
                        </p>
                    @else
                        <p class="mb-4 text-red-500">You don't have an API key yet.</p>
                    @endif

                    <!-- Button to regenerate API key -->
                    <form action="{{ route('user.api-key.regenerate') }}" method="POST">
                        @csrf
                        <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ __('Generate / Regenerate API Key') }}
                        </x-button>
                    </form>

                    <!-- Optional information -->
                    <p class="mt-4 text-sm text-gray-600">
                        Note: When you regenerate your API key, your previous key will no longer work.
                    </p>

                    <!-- Flash message -->
                    @if (session('success'))
                        <div id="log-message" class="mt-4 p-4 bg-green-100 text-green-700">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>
            </div>
            <div class="mt-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Movie API</h3>

                    <p class="mb-4">Use the form below to test the API. You can fetch a movie by its ID using the URL: 
                        <br><code>localhost:8000/api/movies/{id}?api_key={api_key}</code>
                    </p>

                    <form id="apiTestForm">
                        <label for="movie_id" class="block mb-2 font-semibold">Movie ID</label>
                        <input type="text" id="movie_id" name="movie_id" class="border rounded p-2 mb-4 w-full" placeholder="Enter movie ID">

                        <label for="api_key" class="block mb-2 font-semibold">API Key</label>
                        <input type="text" id="api_key" name="api_key" value="{{ Auth::user()->api_key }}" class="border rounded p-2 mb-4 w-full" readonly>

                        <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="button" onclick="fetchMovie()">
                            {{ __('Try API') }}
                        </x-button>
                        <!-- Clear Button -->
                        <x-button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" type="button" onclick="document.getElementById('movieApiResponse').style.display = 'none';">
                            {{ __('Clear') }}
                        </x-button>
                    </form>

                    <!-- Display the API response -->
                    <div id="movieApiResponse" class="mt-4 p-4 bg-gray-100 border rounded" style="display: none;"></div>
                </div>
            </div>
            <div class="mt-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Serie API</h3>

                    <p class="mb-4">Use the form below to test the API. You can fetch a movie by its ID using the URL: 
                        <br><code>localhost:8000/api/series/{id}?api_key={api_key}</code>
                    </p>

                    <form id="apiTestForm">
                        <label for="serie_id" class="block mb-2 font-semibold">Serie ID</label>
                        <input type="text" id="serie_id" name="serie_id" class="border rounded p-2 mb-4 w-full" placeholder="Enter movie ID">

                        <label for="api_key" class="block mb-2 font-semibold">API Key</label>
                        <input type="text" id="api_key" name="api_key" value="{{ Auth::user()->api_key }}" class="border rounded p-2 mb-4 w-full" readonly>

                        <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="button" onclick="fetchSeries()">
                            {{ __('Try API') }}
                        </x-button>
                        <!-- Clear Button -->
                        <x-button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" type="button" onclick="document.getElementById('serieApiResponse').style.display = 'none';">
                            {{ __('Clear') }}
                        </x-button>
                    </form>

                    <!-- Display the API response -->
                    <div id="serieApiResponse" class="mt-4 p-4 bg-gray-100 border rounded" style="display: none;"></div>
                </div>
            </div>
            <div class="mt-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Casts API</h3>

                    <p class="mb-4">Use the form below to test the API. You can fetch a movie by its ID using the URL: 
                        <br><code>localhost:8000/api/casts/{id}?api_key={api_key}</code>
                    </p>

                    <form id="apiTestForm">
                        <label for="cast_id" class="block mb-2 font-semibold">Cast ID</label>
                        <input type="text" id="cast_id" name="cast_id" class="border rounded p-2 mb-4 w-full" placeholder="Enter movie ID">

                        <label for="api_key" class="block mb-2 font-semibold">API Key</label>
                        <input type="text" id="api_key" name="api_key" value="{{ Auth::user()->api_key }}" class="border rounded p-2 mb-4 w-full" readonly>

                        <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="button" onclick="fetchCasts()">
                            {{ __('Try API') }}
                        </x-button>
                        <!-- Clear Button -->
                        <x-button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" type="button" onclick="document.getElementById('castApiResponse').style.display = 'none'; ">
                            {{ __('Clear') }}
                        </x-button>
                    </form>

                    <!-- Display the API response -->
                    <div id="castApiResponse" class="mt-4 p-4 bg-gray-100 border rounded" style="display: none;"></div>
                </div>
            </div>
            <div class="mt-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Companies API</h3>

                    <p class="mb-4">Use the form below to test the API. You can fetch a movie by its ID using the URL: 
                        <br><code>localhost:8000/api/companies/{id}?api_key={api_key}</code>
                    </p>

                    <form id="apiTestForm">
                        <label for="company_id" class="block mb-2 font-semibold">Company ID</label>
                        <input type="text" id="company_id" name="company_id" class="border rounded p-2 mb-4 w-full" placeholder="Enter movie ID">

                        <label for="api_key" class="block mb-2 font-semibold">API Key</label>
                        <input type="text" id="api_key" name="api_key" value="{{ Auth::user()->api_key }}" class="border rounded p-2 mb-4 w-full" readonly>

                        <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="button" onclick="fetchCompanies()">
                            {{ __('Try API') }}
                        </x-button>
                        <!-- Clear Button -->
                        <x-button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" type="button" onclick="document.getElementById('companyApiResponse').style.display = 'none';">
                            {{ __('Clear') }}
                        </x-button>
                    </form>

                    <!-- Display the API response -->
                    <div id="companyApiResponse" class="mt-4 p-4 bg-gray-100 border rounded" style="display: none;"></div>
                </div>
            </div>
            <!-- <div class="mt-4 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Genre API</h3>

                    <p class="mb-4">Use the form below to test the API. You can fetch a movie by its ID using the URL: 
                        <br><code>localhost:8000/api/genres/{id}?api_key={api_key}</code>
                    </p>

                    <form id="apiTestForm">
                        <label for="genre_id" class="block mb-2 font-semibold">Genre ID</label>
                        <input type="text" id="genre_id" name="genre_id" class="border rounded p-2 mb-4 w-full" placeholder="Enter movie ID">

                        <label for="api_key" class="block mb-2 font-semibold">API Key</label>
                        <input type="text" id="api_key" name="api_key" value="{{ Auth::user()->api_key }}" class="border rounded p-2 mb-4 w-full" readonly>

                        <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="button" onclick="fetchGenres()">
                            {{ __('Try API') }}
                        </x-button>
                        <x-button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" type="button" onclick="clearForm()">
                            {{ __('Clear') }}
                        </x-button>
                    </form>

                    <div id="gnereApiResponse" class="mt-4 p-4 bg-gray-100 border rounded" style="display: none;"></div>
                </div>
            </div> -->
        </div>
    </div>
    <script>
        function fetchMovie() {
            let movieId = document.getElementById('movie_id').value;
            if (!movieId) {
                alert('Please enter a movie ID.');
                return;
            }
            let apiKey = document.getElementById('api_key').value;
            if (!apiKey) {
                alert('Please enter an API key.');
                return;
            }
            let apiUrl = `http://localhost:8000/api/movies/${movieId}?api_key=${apiKey}`;
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    let apiResponse = document.getElementById('movieApiResponse');
                    apiResponse.style.display = 'block';
                    apiResponse.innerHTML = `<pre style="white-space: pre warp; word-warp: break-word; text-wrap: pretty;">${JSON.stringify(data, null, 2)}</pre>`;
                })
                .catch(error => {
                    let apiResponse = document.getElementById('movieApiResponse');
                    apiResponse.style.display = 'block';
                    apiResponse.innerHTML = `<pre>Error: ${error}</pre>`;
                });
        };
        function fetchSeries(){
            let seriesId = document.getElementById('serie_id').value;
            if (!seriesId) {
                alert('Please enter a series ID.');
                return;
            }
            let apiKey = document.getElementById('api_key').value;
            if (!apiKey) {
                alert('Please enter an API key.');
                return;
            }
            let apiUrl = `http://localhost:8000/api/series/${seriesId}?api_key=${apiKey}`;
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    let apiResponse = document.getElementById('serieApiResponse');
                    apiResponse.style.display = 'block';
                    apiResponse.innerHTML = `<pre style="white-space: pre warp; word-warp: break-word; text-wrap: pretty;">${JSON.stringify(data, null, 2)}</pre>`;
                })
                .catch(error => {
                    let apiResponse = document.getElementById('serieApiResponse');
                    apiResponse.style.display = 'block';
                    apiResponse.innerHTML = `<pre>Error: ${error}</pre>`;
                });
        };
        function fetchCasts(){
            let castsId = document.getElementById('cast_id').value;
            if (!castsId) {
                alert('Please enter a casts ID.');
                return;
            }
            let apiKey = document.getElementById('api_key').value;
            if (!apiKey) {
                alert('Please enter an API key.');
                return;
            }
            let apiUrl = `http://localhost:8000/api/casts/${castsId}?api_key=${apiKey}`;
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    let apiResponse = document.getElementById('castApiResponse');
                    apiResponse.style.display = 'block';
                    apiResponse.innerHTML = `<pre style="white-space: pre warp; word-warp: break-word; text-wrap: pretty;">${JSON.stringify(data, null, 2)}</pre>`;
                })
                .catch(error => {
                    let apiResponse = document.getElementById('castApiResponse');
                    apiResponse.style.display = 'block';
                    apiResponse.innerHTML = `<pre>Error: ${error}</pre>`;
                });
        };
        function fetchCompanies(){
            let companiesId = document.getElementById('company_id').value;
            if (!companiesId) {
                alert('Please enter a companies ID.');
                return;
            }
            let apiKey = document.getElementById('api_key').value;
            if (!apiKey) {
                alert('Please enter an API key.');
                return;
            }
            let apiUrl = `http://localhost:8000/api/companies/${companiesId}?api_key=${apiKey}`;
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    let apiResponse = document.getElementById('companyApiResponse');
                    apiResponse.style.display = 'block';
                    apiResponse.innerHTML = `<pre style="white-space: pre warp; word-warp: break-word; text-wrap: pretty;">${JSON.stringify(data, null, 2)}</pre>`;
                })
                .catch(error => {
                    let apiResponse = document.getElementById('companyApiResponse');
                    apiResponse.style.display = 'block';
                    apiResponse.innerHTML = `<pre>Error: ${error}</pre>`;
                });
        };
        function fetchGenres(){
            let genresId = document.getElementById('genre_id').value;
            if (!genresId) {
                alert('Please enter a genres ID.');
                return;
            }
            let apiKey = document.getElementById('api_key').value;
            if (!apiKey) {
                alert('Please enter an API key.');
                return;
            }
            let apiUrl = `http://localhost:8000/api/genres/${genresId}?api_key=${apiKey}`;
            fetch(apiUrl)
                .then(response => response.json())
                .then(data => {
                    let apiResponse = document.getElementById('genreApiResponse');
                    apiResponse.style.display = 'block';
                    apiResponse.innerHTML = `<pre style="white-space: pre warp; word-warp: break-word; text-wrap: pretty;">${JSON.stringify(data, null, 2)}</pre>`;
                })
                .catch(error => {
                    let apiResponse = document.getElementById('genreApiResponse');
                    apiResponse.style.display = 'block';
                    apiResponse.innerHTML = `<pre>Error: ${error}</pre>`;
                });
        };

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                document.getElementById('log-message').style.display = 'none';
            }, 3000);
        });
    </script>
</x-app-layout>