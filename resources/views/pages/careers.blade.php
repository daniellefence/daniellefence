<x-app-layout>
    <x-slot name="title">Careers - Join Our Team | Danielle Fence & Outdoor Living</x-slot>
    <x-slot name="description">Join Central Florida's premier fencing company. Explore career opportunities with competitive benefits, growth potential, and a family-owned company with nearly 50 years of success.</x-slot>

    <x-page-heading subheading="Build your career with Central Florida's premier fencing company. We're looking for dedicated professionals who share our commitment to quality and exceptional service.">
        Join Our Growing Team
    </x-page-heading>

    <!-- Why Work Here Section -->
    <section class="py-16 lg:py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-slate-900 mb-6">
                    Why Choose <span class="text-outdoor-primary">Danielle Fence?</span>
                </h2>
                <p class="text-xl text-slate-600 max-w-3xl mx-auto">
                    Join a family-owned company with nearly 50 years of success, growth opportunities, and a commitment to excellence.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Competitive Benefits -->
                <div class="perspective-card">
                    <div class="perspective-card-inner bg-white rounded-2xl p-8 shadow-lg">
                        <div class="w-16 h-16 bg-outdoor-primary/10 rounded-xl flex items-center justify-center mb-6">
                            <i class="fa-solid fa-hand-holding-dollar text-2xl text-outdoor-primary"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Competitive Benefits</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Health insurance, retirement plans, paid time off, and performance-based bonuses. We invest in our team members' success.
                        </p>
                    </div>
                </div>

                <!-- Career Growth -->
                <div class="perspective-card">
                    <div class="perspective-card-inner bg-white rounded-2xl p-8 shadow-lg">
                        <div class="w-16 h-16 bg-outdoor-secondary/10 rounded-xl flex items-center justify-center mb-6">
                            <i class="fa-solid fa-chart-line text-2xl text-outdoor-secondary"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Career Growth</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Professional development opportunities, skills training, and clear advancement paths within our growing organization.
                        </p>
                    </div>
                </div>

                <!-- Stable Employment -->
                <div class="perspective-card">
                    <div class="perspective-card-inner bg-white rounded-2xl p-8 shadow-lg">
                        <div class="w-16 h-16 bg-green-100 rounded-xl flex items-center justify-center mb-6">
                            <i class="fa-solid fa-shield-check text-2xl text-green-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Job Security</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Work for an established, family-owned company with consistent growth and job security in an essential industry.
                        </p>
                    </div>
                </div>

                <!-- Great Culture -->
                <div class="perspective-card">
                    <div class="perspective-card-inner bg-white rounded-2xl p-8 shadow-lg">
                        <div class="w-16 h-16 bg-blue-100 rounded-xl flex items-center justify-center mb-6">
                            <i class="fa-solid fa-people-group text-2xl text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Great Culture</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Join a family-oriented team that values collaboration, respect, and making a positive impact in our community.
                        </p>
                    </div>
                </div>

                <!-- Local Impact -->
                <div class="perspective-card">
                    <div class="perspective-card-inner bg-white rounded-2xl p-8 shadow-lg">
                        <div class="w-16 h-16 bg-purple-100 rounded-xl flex items-center justify-center mb-6">
                            <i class="fa-solid fa-heart text-2xl text-purple-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Local Impact</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Help Central Florida families create beautiful, secure outdoor spaces while building lasting relationships in your community.
                        </p>
                    </div>
                </div>

                <!-- Professional Tools -->
                <div class="perspective-card">
                    <div class="perspective-card-inner bg-white rounded-2xl p-8 shadow-lg">
                        <div class="w-16 h-16 bg-orange-100 rounded-xl flex items-center justify-center mb-6">
                            <i class="fa-solid fa-tools text-2xl text-orange-600"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-900 mb-4">Professional Tools</h3>
                        <p class="text-slate-600 leading-relaxed">
                            Work with quality materials, modern equipment, and the latest industry tools to deliver exceptional results.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Open Positions Section -->
    <section id="open-positions" class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <livewire:careers/>
        </div>
    </section>

    <!-- Company Culture Section -->
    <section class="py-16 lg:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-2 lg:gap-16 lg:items-center">
                <div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-slate-900 mb-6">
                        Life at <span class="text-outdoor-primary">Danielle Fence</span>
                    </h2>
                    <p class="text-lg text-slate-600 mb-8 leading-relaxed">
                        We're more than just a fencing company – we're a family. Our team members enjoy a supportive work environment where everyone's contributions are valued and recognized.
                    </p>

                    <div class="space-y-6">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-outdoor-primary/10 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-clock text-outdoor-primary"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-slate-900">Work-Life Balance</h3>
                                <p class="text-slate-600">Competitive schedules that respect your personal time and family commitments.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-outdoor-secondary/10 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-graduation-cap text-outdoor-secondary"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-slate-900">Continuous Learning</h3>
                                <p class="text-slate-600">Ongoing training and development to help you grow your skills and advance your career.</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                    <i class="fa-solid fa-handshake text-green-600"></i>
                                </div>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-slate-900">Team Support</h3>
                                <p class="text-slate-600">Collaborative environment where team members support each other's success.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-12 lg:mt-0">
                    <img src="{{ Vite::asset('resources/images/careers.jpg') }}" alt="Danielle Fence team at work" class="w-full h-auto rounded-2xl shadow-xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Application CTA -->
    <section class="py-16 lg:py-24 bg-outdoor-primary">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">
                Ready to Join Our Team?
            </h2>
            <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
                Take the first step toward building your career with Central Florida's premier fencing company. We're always looking for talented individuals to join our growing family.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('apply') }}" class="inline-flex items-center justify-center px-8 py-4 bg-outdoor-secondary text-white font-semibold text-lg rounded-xl hover:bg-outdoor-secondary/90 transition-all duration-300 shadow-lg hover:shadow-xl">
                    <i class="fa-solid fa-file-user mr-2"></i>
                    Apply Now
                </a>
                <a href="tel:863-425-3182" class="inline-flex items-center justify-center px-8 py-4 bg-white text-outdoor-primary font-semibold text-lg rounded-xl hover:bg-gray-50 transition-all duration-300 shadow-lg hover:shadow-xl">
                    <i class="fa-solid fa-phone mr-2"></i>
                    Call (863) 425-3182
                </a>
            </div>

            <p class="text-white/70 text-sm mt-6">
                Questions? Contact our HR Department at ext. 1215 or HR@daniellefence.net
            </p>
        </div>
    </section>

    <!-- Perspective Card CSS -->
    <style>
    .perspective-card {
        perspective: 1000px;
    }

    .perspective-card-inner {
        transform-style: preserve-3d;
        transition: transform 0.6s;
    }

    .perspective-card:hover .perspective-card-inner {
        transform: rotateY(10deg) rotateX(10deg);
    }

    @media (prefers-reduced-motion: reduce) {
        .perspective-card:hover .perspective-card-inner {
            transform: none;
        }
    }
    </style>

</x-app-layout>