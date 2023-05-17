


<script src="https://cdn.tailwindcss.com"></script>

<!-- component -->
<!-- component -->
<style>@import url(https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.min.css);</style>
<div class="min-w-screen min-h-screen bg-blue-100 flex items-center p-5 lg:p-20 overflow-hidden relative">
    <div class="flex-1 min-h-full min-w-full rounded-3xl bg-white shadow-xl p-10 lg:p-20 text-gray-800 relative md:flex items-center text-center md:text-left">
        <div class="w-full md:w-1/2">
            <div class="mb-10 lg:mb-20">
                <h1 class="font-black uppercase text-3xl lg:text-2xl text-black-500 mb-10">WISATO PARK</h1>
            </div>
            <div class="mb-10 md:mb-20 text-gray-600 font-light">
                <h1 class="font-black uppercase text-3xl lg:text-5xl text-red-500 mb-10">403 Access Denied!</h1>
				<p>You do not have permission to access this page.</p>
                <p>Please contact the administrator for assistance.</p>
            </div>
            <div class="mb-20 md:mb-0">
				@if(Auth::user()->hasRole('client'))
				
				<a href="/maps" class="text-lg font-light outline-none focus:outline-none transform transition-all hover:scale-110 text-red-500 hover:text-red-600"><i class="mdi mdi-arrow-left mr-2"></i>Go Back</a>			
				@else
				<a href="/home" class="text-lg font-light outline-none focus:outline-none transform transition-all hover:scale-110 text-red-500 hover:text-red-600"><i class="mdi mdi-arrow-left mr-2"></i>Go Back</a>				
				
				@endif

            </div>
        </div>
        <div class="w-full md:w-1/2 text-center">
            <img src="{{ asset('img/403.png') }}" class="w-full max-w-lg lg:max-w-full mx-auto" />
            <a href="http://www.onedustry-technologies.com/" target="_blank" class="text-xs text-gray-300">
				Business vector created by onedustry technologies - http://www.onedustry-technologies.com/</a>
			</div>
    </div>
    <div class="w-64 md:w-96 h-96 md:h-full bg-blue-200 bg-opacity-30 absolute -top-64 md:-top-96 right-20 md:right-32 rounded-full pointer-events-none -rotate-45 transform"></div>
    <div class="w-96 h-full bg-yellow-200 bg-opacity-20 absolute -bottom-96 right-64 rounded-full pointer-events-none -rotate-45 transform"></div>
</div>

<!-- BUY ME A BEER AND HELP SUPPORT OPEN-SOURCE RESOURCES -->
<div class="flex items-end justify-end fixed bottom-0 right-0 mb-4 mr-4 z-10">
    <div>
        <a title="Buy me a beer" href="https://www.linkedin.com/company/onedustry-technologies/about/" target="_blank" class="block w-16 h-16 rounded-full transition-all shadow hover:shadow-lg transform hover:scale-110 hover:rotate-12">
            <img class="object-cover object-center w-full h-full rounded-full" src="https://media.licdn.com/dms/image/D4E0BAQGR3XDUW2nK5A/company-logo_200_200/0/1683988114539?e=1692230400&v=beta&t=HFBbczwAIMGIQ3oulJTlcYl7nKCF5z3e1A44qdWoXTc"/>
        </a>
    </div>
</div>