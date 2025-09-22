<x-app-layout>
    <!-- Hero Section -->
    <x-modern-hero
        title="Join Our Team"
        subtitle="Grow Your Career • Build Something Great"
        description="Join Central Florida's premier fencing company. We're looking for dedicated professionals who share our commitment to quality and customer service."
        :background-image="Vite::asset('resources/images/careers-hero.webp')"
        cta="View Open Positions"
        :cta-url="'#open-positions'"
        />

    <!-- Careers Content -->
    <x-modern-section spacing="py-20 md:py-28">
        <livewire:careers/>
    </x-modern-section>

    <!-- Benefits Section -->
    <x-modern-section background="bg-brand-light-100" spacing="py-20 md:py-28">
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold text-brand-neutral-900 mb-6">
                Why Work at Danielle Fence?
            </h2>
            <p class="text-xl text-brand-neutral-700 max-w-3xl mx-auto">
                Join a family-owned company with nearly 50 years of success and growth opportunities.
            </p>
        </div>

        <x-modern-grid columns="3">
            <x-modern-card
                title="Competitive Benefits"
                description="Health insurance, retirement plans, paid time off, and performance-based bonuses. We invest in our team members' success."
                aos="fade-up" delay="100">
                <div class="w-12 h-12 bg-brand-primary-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-brand-primary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </x-modern-card>

            <x-modern-card
                title="Career Growth"
                description="Professional development opportunities, skills training, and clear advancement paths within our growing organization."
                aos="fade-up" delay="200">
                <div class="w-12 h-12 bg-brand-secondary-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-brand-secondary-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </x-modern-card>

            <x-modern-card
                title="Stable Employment"
                description="Work for an established, family-owned company with consistent growth and job security in an essential industry."
                aos="fade-up" delay="300">
                <div class="w-12 h-12 bg-brand-accent-100 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-brand-accent-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </x-modern-card>
        </x-modern-grid>
    </x-modern-section>

    <!-- Application CTA -->
    <x-modern-cta
        title="Ready to Start Your Career?"
        description="Take the first step toward joining Central Florida's premier fencing company. We're always looking for talented individuals to join our growing team."
        button-text="Apply Now"
        :button-url="route('apply')"
        secondary-text="Call (863) 425-3182"
        secondary-url="tel:863-425-3182"
        :pattern="true" />
</x-app-layout>
