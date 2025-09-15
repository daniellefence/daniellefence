<x-app-layout>
<div class="bg-gradient-to-r from-white to-brand-cream/20">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-gray-900">Financing Options</h1>
        
        <div class="mt-8 prose max-w-none">
            <p class="text-lg text-gray-600">We offer flexible financing options to help you get the fence you need today.</p>
            
            <div class="mt-12 grid gap-8 md:grid-cols-2">
                <div class="rounded-lg bg-gradient-to-br from-gray-50 to-brand-cream/30 p-8 ">
                    <h3 class="text-xl font-semibold text-gray-900">0% Interest for 12 Months</h3>
                    <p class="mt-2 text-gray-600">Qualified buyers can enjoy 0% interest for 12 months on purchases over $1,000.</p>
                    <ul class="mt-4 space-y-2 text-gray-600">
                        <li>• No prepayment penalties</li>
                        <li>• Quick approval process</li>
                        <li>• Flexible payment terms</li>
                    </ul>
                </div>
                
                <div class="rounded-lg bg-gradient-to-br from-gray-50 to-brand-cream/30 p-8 ">
                    <h3 class="text-xl font-semibold text-gray-900">Extended Terms Available</h3>
                    <p class="mt-2 text-gray-600">Longer-term financing options for larger projects with competitive rates.</p>
                    <ul class="mt-4 space-y-2 text-gray-600">
                        <li>• Terms up to 60 months</li>
                        <li>• Fixed interest rates</li>
                        <li>• No hidden fees</li>
                    </ul>
                </div>
            </div>
            
            <div class="mt-12 rounded-lg bg-blue-50 p-8">
                <h2 class="text-2xl font-semibold text-gray-900">Apply Today</h2>
                <p class="mt-4 text-gray-600">Get pre-approved in minutes with our simple online application.</p>
                <a href="{{ route('quote.request') }}" class="mt-6 inline-flex items-center rounded-md bg-blue-600 px-6 py-3 text-base font-medium text-white hover:bg-blue-700">
                    Start Application
                </a>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
