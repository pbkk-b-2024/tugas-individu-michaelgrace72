<x-app-layout>
<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
<div class="bg-white p-8 rounded-md w-full">
	<div class=" flex items-center justify-between pb-6">
		<div>
			<h2 class="text-gray-600 font-semibold">Products Oder</h2>
			<span class="text-xs">All products item</span>
		</div>
		<div class="flex items-center justify-between">
			<div class="flex bg-gray-50 items-center p-2 rounded-md">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
					fill="currentColor">
					<path fill-rule="evenodd"
						d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
						clip-rule="evenodd" />
				</svg>
				<input class="bg-gray-50 outline-none ml-1 block " type="text" name="" id="" placeholder="search...">
          </div>
				<div class="lg:ml-40 ml-10 space-x-8">
					<form action="{{ route('admin.companies.create')}}">
            <x-button>Add Company</x-button>
					</form>
				</div>
			</div>
		</div>
		<div>
			<div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
				<div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
					<table class="min-w-full leading-normal">
						<thead>
							<tr>
								<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
									TMDB ID
								</th>
								<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Name
								</th>
								<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                  Origin Country
								</th>
								<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
									Logo
								</th>
								<th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
									Manage
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($companies as $company)
							
							<tr>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<div class="flex items-center ml-3">
												<p class="text-gray-900 whitespace-no-wrap">
												{{ $company->tmdb_id }}	
												</p>
									</div>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-900 whitespace-no-wrap">
									{{ $company->name}}</p>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<p class="text-gray-900 whitespace-no-wrap">
									{{ $company->origin_country }}	
									</p>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<img class="w-20 h-28 border-slate-700 rounded hover:shadow-slate-600 hover:scale-110 text-gray-900 whitespace-no-wrap" src="https://image.tmdb.org/t/p/w500{{ $company->logo_path}}">
									</img>
								</td>
								<td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
									<a  href="" class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight rounded-full hover:bg-green-500">
										<span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
										<button class="relative">Edit</button>
									</a>
									<form id="" action="" method="POST" class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight rounded-full hover:bg-red-500" onsubmit="return confirm('are you sure?')">
										@csrf
										@method('DELETE')

										<span aria-hidden class="absolute inset-0 bg-red-200 opacity-50  rounded-full "></span>
										<button onclick="" class="relative ">Delete</button>
									</form>
								</td>
							</tr>@endforeach
						
						</tbody>
					</table>
					<div class="px-5 py-5 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between          ">
						<span class="text-xs xs:text-sm text-gray-900">
							{{ $companies->onEachSide(1)->links() }}
                        </span>
						<div class="inline-flex mt-2 xs:mt-0">
						</div>
					</div>
					
				</div>
	@if (session('success'))
		<div id="log-message" class="alert alert-success bg-green-200 rounded px-3 py-1 text-green-900 font-semibold">
			{{ session('success') }}
		</div>
	@elseif(session('error'))
		<div id="log-message" class="alert alert-success bg-red-200 rounded px-3 py-1 text-red-900 font-semibold">
			{{ session('error') }}
		</div>
	@endif
	<script>
		document.addEventListener('DOMContentLoaded', (event) => {
			setTimeout(() => {
				document.getElementById('log-message').style.display = 'none';
			}, 3000);
		});
	</script>
			</div>
		</div>
	</div></div>


</x-app-layout>