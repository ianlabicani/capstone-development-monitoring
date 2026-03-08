{{-- AI-Powered Insights with Glowing Effect --}}
<style>
    @keyframes heartbeat {
        0%, 100% { transform: scale(1); }
        25% { transform: scale(1.05); }
        50% { transform: scale(1.1); }
    }
    @keyframes glow {
        0%, 100% { box-shadow: 0 0 20px rgba(234, 88, 12, 0.5), 0 0 40px rgba(234, 88, 12, 0.3); }
        50% { box-shadow: 0 0 30px rgba(234, 88, 12, 0.8), 0 0 60px rgba(234, 88, 12, 0.5); }
    }
    .heartbeat { animation: heartbeat 1.5s ease-in-out infinite; }
    .glow-card { animation: glow 2s ease-in-out infinite; }
</style>

<section class="py-12 sm:py-16 bg-white">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl bg-gradient-to-br from-orange-50 to-orange-100 ring-1 ring-orange-200 p-8 md:p-12 glow-card">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div>
                    <div class="inline-flex items-center rounded-full bg-orange-200 px-4 py-1 text-sm font-semibold text-orange-800 mb-4">
                        <i class="fas fa-brain mr-2"></i> AI-Powered
                    </div>
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900 mb-4">AI-Powered Commit Analysis</h2>
                    <p class="text-lg text-slate-700 mb-6">Describe your project in plain text, and our AI generates user stories automatically. The system then tracks which stories are covered by your commits — revealing development gaps at a glance.</p>
                    <div class="space-y-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-file-alt text-orange-600 mt-1 flex-shrink-0"></i>
                            <div>
                                <p class="font-semibold text-slate-900">Describe Your Project</p>
                                <p class="text-sm text-slate-600">Provide a plaintext description of your project directly in the platform</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-brain text-orange-600 mt-1 flex-shrink-0"></i>
                            <div>
                                <p class="font-semibold text-slate-900">AI-Generated User Stories</p>
                                <p class="text-sm text-slate-600">AI automatically generates user stories from your project description</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-chart-line text-orange-600 mt-1 flex-shrink-0"></i>
                            <div>
                                <p class="font-semibold text-slate-900">Gap Detection</p>
                                <p class="text-sm text-slate-600">Automatically identifies which stories have commits and which don't</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-center">
                    <div class="relative w-full max-w-sm">
                        <div class="absolute inset-0 bg-gradient-to-br from-orange-400 to-orange-600 rounded-2xl blur-lg opacity-40 heartbeat"></div>
                        <div class="relative bg-white rounded-2xl ring-1 ring-orange-200 p-6 text-center">
                            <i class="fas fa-brain text-6xl text-orange-600 mb-4 block heartbeat"></i>
                            <p class="text-slate-900 font-semibold mb-2">AI Analysis Engine</p>
                            <p class="text-sm text-slate-600">Powered by Gemini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
