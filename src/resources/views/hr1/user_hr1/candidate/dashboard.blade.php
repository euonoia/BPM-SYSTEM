@extends('hr1.layouts.app')

@section('content')
<div x-data="dashboard()" style="display: flex; min-height: 100vh;">
    <!-- Mobile Topbar -->
    <div class="topbar">
        <button class="menu-toggle" @click="document.querySelector('.sidebar').classList.toggle('show')">
            ☰
        </button>
        <div class="title">MedCore HR1</div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" 
         id="sidebar"
         x-init="
            // Desktop hover collapse
            $el.addEventListener('mouseenter', () => {
                if (window.innerWidth > 768 && $el.classList.contains('collapsed')) {
                    $el.classList.remove('collapsed');
                }
            });
            $el.addEventListener('mouseleave', () => {
                if (window.innerWidth > 768) {
                    $el.classList.add('collapsed');
                }
            });
            // Default collapsed on desktop
            if (window.innerWidth > 768) {
                $el.classList.add('collapsed');
            }
            // Auto-close on mobile
            document.addEventListener('click', (e) => {
                const toggle = document.querySelector('.menu-toggle');
                if (!$el.contains(e.target) && toggle && !toggle.contains(e.target)) {
                    $el.classList.remove('show');
                }
            });
         ">
        <div class="logo">
            <img src="{{ asset('images/hr1/logo.png') }}" alt="HR1 Logo" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <div style="display:none; width: 60px; height: 60px; background: var(--accent); border-radius: 10px; margin: 0 auto 8px; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 24px;">HR1</div>
            <div class="logo-text">MedCore HR1</div>
        </div>

        <nav>
            <template x-for="item in navItems" :key="item.id">
                <a href="#" 
                   @click.prevent="activeTab = item.id" 
                   :class="{ 'active': activeTab === item.id }"
                   class="nav-link">
                    <i :class="getIconClass(item.icon)"></i>
                    <span x-text="item.label"></span>
                    <span class="tooltip" x-text="item.label"></span>
                </a>
            </template>
        </nav>
    </div>

    <main class="main-content">
        <div class="p-8 md:p-16 max-w-[1600px] mx-auto" style="width: 100%;">
            <div class="mb-16">
                <h1 class="text-6xl font-black text-primary tracking-tighter capitalize mb-6">Dashboard</h1>
                <div class="text-[15px] font-medium text-text-light/80 max-w-4xl leading-relaxed">
                    Hospital Command Center: <span class="text-accent font-black uppercase bg-accent/5 px-3 py-1 rounded-xl">Candidate Context</span>.
                </div>
            </div>
            
            <!-- Candidate Dashboard Content -->
            <div x-show="activeTab === 'dashboard'" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="card !w-full">
                        <h4 class="text-[10px] font-black text-accent uppercase tracking-widest mb-1">Open Positions</h4>
                        <div class="text-3xl font-black text-primary" x-text="jobs.length"></div>
                    </div>
                    <div class="card !w-full">
                        <h4 class="text-[10px] font-black text-accent uppercase tracking-widest mb-1">Pending Tasks</h4>
                        <div class="text-3xl font-black text-primary" x-text="tasks.filter(t => !t.completed).length"></div>
                    </div>
                    <div class="card !w-full">
                        <h4 class="text-[10px] font-black text-accent uppercase tracking-widest mb-1">Completed Tasks</h4>
                        <div class="text-3xl font-black text-primary" x-text="tasks.filter(t => t.completed).length"></div>
                    </div>
                    <div class="card !w-full">
                        <h4 class="text-[10px] font-black text-accent uppercase tracking-widest mb-1">Assessment %</h4>
                        <div class="text-3xl font-black text-primary">65%</div>
                    </div>
                </div>

                <!-- Live Application Journey -->
                <div class="main-inner !w-full !max-w-none">
                    <h3 class="text-xl font-black text-primary mb-6">Live Application Journey</h3>
                    <div class="flex gap-4">
                        <template x-for="app in myApplications" :key="app.id">
                            <div class="p-4 bg-bg rounded-2xl flex-1 border border-gray-100">
                                <div class="text-xs font-black uppercase text-accent mb-2" x-text="app.jobTitle"></div>
                                <div class="flex items-center gap-2">
                                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-primary" style="width: 60%"></div>
                                    </div>
                                    <span class="text-[10px] font-bold text-primary" x-text="app.status"></span>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- My Applications Tab -->
            <div x-show="activeTab === 'my-application'" class="main-inner !w-full !max-w-none mt-8">
                <h3 class="text-xl font-black text-primary mb-6">My Applications</h3>
                <div class="flex flex-col gap-4" x-show="myApplications.length">
                    <template x-for="app in myApplications" :key="app.id">
                        <div class="p-4 bg-bg rounded-2xl border border-gray-100 flex justify-between items-center">
                            <div>
                                <div class="text-sm font-black text-accent" x-text="app.jobTitle"></div>
                                <div class="text-xs text-text-light" x-text="app.status"></div>
                            </div>
                            <span class="text-[10px] font-bold text-primary uppercase bg-primary/5 px-3 py-1 rounded-full">
                                In Progress
                            </span>
                        </div>
                    </template>
                </div>
                <div x-show="!myApplications.length" class="text-sm text-text-light">
                    You have no active applications yet.
                </div>
            </div>

            <!-- Jobs Tab -->
            <div x-show="activeTab === 'recruitment'" class="main-inner !w-full !max-w-none mt-8">
                <h3 class="text-xl font-black text-primary mb-6">Available Jobs</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-show="jobs.length">
                    <template x-for="job in jobs" :key="job.id">
                        <div class="p-4 bg-bg rounded-2xl border border-gray-100 flex flex-col gap-2">
                            <div class="text-sm font-black text-accent" x-text="job.title"></div>
                            <div class="text-xs text-text-light" x-text="job.department"></div>
                            <button class="mt-2 text-xs font-bold text-primary uppercase bg-primary/5 px-3 py-1 rounded-full"
                                    @click="openApplyModal(job)">
                                Apply
                            </button>
                        </div>
                    </template>
                </div>
                <div x-show="!jobs.length" class="text-sm text-text-light">
                    No open positions are available right now.
                </div>
            </div>

            <!-- Tasks Tab -->
            <div x-show="activeTab === 'onboarding'" class="main-inner !w-full !max-w-none mt-8">
                <h3 class="text-xl font-black text-primary mb-6">Onboarding Tasks</h3>
                <div class="flex flex-col gap-3" x-show="tasks.length">
                    <template x-for="task in tasks" :key="task.id">
                        <div class="p-3 bg-bg rounded-xl border border-gray-100 flex justify-between items-center">
                            <div>
                                <div class="text-sm font-medium text-primary" x-text="task.title"></div>
                                <div class="text-xs text-text-light" x-text="task.category"></div>
                            </div>
                            <span class="text-[10px] font-bold uppercase px-3 py-1 rounded-full"
                                  :class="task.completed ? 'bg-green-50 text-green-700' : 'bg-yellow-50 text-yellow-700'">
                                <span x-text="task.completed ? 'Completed' : 'Pending'"></span>
                            </span>
                        </div>
                    </template>
                </div>
                <div x-show="!tasks.length" class="text-sm text-text-light">
                    You have no onboarding tasks assigned yet.
                </div>
            </div>

            <!-- Other Tabs Placeholders -->
            <div x-show="activeTab === 'performance'" class="main-inner !w-full !max-w-none mt-8">
                <h3 class="text-xl font-black text-primary mb-2">Self Assessment</h3>
                <p class="text-sm text-text-light">Self assessment tools will appear here.</p>
            </div>

            <div x-show="activeTab === 'recognition'" class="main-inner !w-full !max-w-none mt-8">
                <h3 class="text-xl font-black text-primary mb-2">Culture & Recognition</h3>
                <p class="text-sm text-text-light">Culture and recognition features will appear here.</p>
            </div>

            <div x-show="activeTab === 'profile'" class="main-inner !w-full !max-w-none mt-8">
                <h3 class="text-xl font-black text-primary mb-2">Profile</h3>
                <p class="text-sm text-text-light">Your profile details will appear here.</p>
            </div>
        </div>
    </main>
</div>

@include('hr1.user_hr1.shared.modals')
@endsection

@push('scripts')
<script>
// Make getIconClass available globally
window.getIconClass = function(iconName) {
    const iconMap = {
        'layout-dashboard': 'bi bi-house-door',
        'users': 'bi bi-people',
        'briefcase': 'bi bi-briefcase',
        'user-plus': 'bi bi-person-plus',
        'trending-up': 'bi bi-graph-up',
        'award': 'bi bi-trophy',
        'user-circle': 'bi bi-person-circle',
        'clipboard-list': 'bi bi-clipboard-check',
        'check-square': 'bi bi-check-square',
        'target': 'bi bi-bullseye',
        'star': 'bi bi-star'
    };
    return iconMap[iconName] || 'bi bi-circle';
};

function dashboard() {
    return {
        role: 'candidate',
        activeTab: 'dashboard',
        sidebarOpen: true,
        modalType: null,
        selectedJob: null,
        selectedApplicant: null,
        applicants: @json($applicants ?? []),
        jobs: @json($jobs ?? []),
        recognitions: @json($recognitions ?? []),
        tasks: @json($tasks ?? []),
        awardCategories: @json($awardCategories ?? []),
        evalCriteria: @json($evalCriteria ?? []),
        availableModules: @json($availableModules ?? []),
        
        get myApplications() {
            return this.applicants[0]?.applications_hr1 || [];
        },
        
        submitApplication() {
            const form = event.target;
            const formData = new FormData(form);
            formData.append('job_id', this.selectedJob.id);
            
            fetch('/api/hr1/applications', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            }).then(() => {
                alert('Application submitted with documents!');
                this.modalType = null;
            });
        },
        
        addApplicant() {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch('/api/hr1/applicants', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            }).then(res => res.json()).then(data => {
                this.applicants.push(data);
                this.modalType = null;
            });
        },
        
        createJob() {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch('/api/hr1/jobs', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            }).then(res => res.json()).then(data => {
                this.jobs.push(data);
                this.modalType = null;
            });
        },
        
        updateStatus(id, status) {
            fetch(`/api/hr1/applicants/${id}/status`, {
                method: 'PATCH',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({ status })
            }).then(() => {
                const applicant = this.applicants.find(a => a.id == id);
                if (applicant) applicant.status = status;
            });
        },
        
        deleteJob(id) {
            if (confirm('Delete this job posting?')) {
                fetch(`/api/hr1/jobs/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                }).then(() => {
                    this.jobs = this.jobs.filter(j => j.id != id);
                });
            }
        },
        
        get navItems() {
            return [
                { id: 'dashboard', label: 'Dashboard', icon: 'layout-dashboard' },
                { id: 'my-application', label: 'My Apps', icon: 'clipboard-list' },
                { id: 'recruitment', label: 'Jobs', icon: 'briefcase' },
                { id: 'onboarding', label: 'Tasks', icon: 'check-square' },
                { id: 'performance', label: 'Self Assessment', icon: 'target' },
                { id: 'recognition', label: 'Culture', icon: 'star' },
                { id: 'profile', label: 'Profile', icon: 'user-circle' }
            ];
        },
        
        openApplyModal(job) {
            this.selectedJob = job;
            this.modalType = 'apply';
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
});
</script>
@endpush

