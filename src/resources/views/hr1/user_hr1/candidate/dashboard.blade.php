@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-[#f8fafc]" x-data="dashboard()">
    @include('user_hr1.shared.sidebar')
    @include('user_hr1.shared.header')

    <main :class="`flex-1 transition-all duration-500 overflow-x-hidden ${sidebarOpen ? 'ml-[280px]' : 'ml-[100px]'}`">
        <div class="p-8 md:p-16 max-w-[1600px] mx-auto">
            <div class="mb-16">
                <h1 class="text-6xl font-black text-primary tracking-tighter capitalize mb-6">Dashboard</h1>
                <div class="text-[15px] font-medium text-text-light/80 max-w-4xl leading-relaxed">
                    Hospital Command Center: <span class="text-accent font-black uppercase bg-accent/5 px-3 py-1 rounded-xl">Candidate Context</span>.
                </div>
            </div>
            
            <!-- Candidate Dashboard Content -->
            <div class="space-y-6">
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
        </div>
    </main>
</div>

@include('user_hr1.shared.modals')
@endsection

@push('scripts')
<script>
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
        }
        
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

