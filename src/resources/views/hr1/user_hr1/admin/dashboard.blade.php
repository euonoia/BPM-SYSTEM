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
            <div class="logo-text">Concord : HR1</div>
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
        <div class="p-8 md:p-12" style="width: 100%; max-width: 100%;">
            <div class="mb-16">
                <h1 class="text-6xl font-black text-primary tracking-tighter capitalize mb-6">Dashboard</h1>
                <div class="text-[15px] font-medium text-text-light/80 max-w-4xl leading-relaxed">
                    Hospital Command Center: <span class="text-accent font-black uppercase bg-accent/5 px-3 py-1 rounded-xl">Admin Context</span>.
                </div>
            </div>
            
            <!-- Admin Dashboard Content -->
            <div x-show="activeTab === 'dashboard'" class="space-y-6">
                <div class="main-inner bg-primary text-white p-10 rounded-3xl flex justify-between items-center !w-full !max-w-none">
                    <div>
                        <h2 class="text-3xl font-black mb-2">Concord HR1 : Admin</h2>
                        <p class="text-highlight">Complete overview of recruitment, performance, and system metrics.</p>
                    </div>
                    <i data-lucide="bar-chart-2" class="w-16 h-16 text-highlight opacity-50"></i>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                    <div class="card !w-full group cursor-pointer text-left">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center group-hover:bg-primary/20 transition-colors flex-shrink-0">
                                <i class="bi bi-people text-primary text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <h4 class="text-[10px] font-semibold text-text-light uppercase tracking-wide">Total Applicants</h4>
                                    <span class="text-[10px] text-text-light">Active candidates</span>
                                </div>
                                <div class="text-3xl font-black text-primary" x-text="applicants.length"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card !w-full group cursor-pointer text-left">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center group-hover:bg-green-200 transition-colors flex-shrink-0">
                                <i class="bi bi-check-circle text-green-600 text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <h4 class="text-[10px] font-semibold text-text-light uppercase tracking-wide">Offer Acceptance</h4>
                                    <span class="text-[10px] text-text-light">Acceptance rate</span>
                                </div>
                                <div class="text-3xl font-black text-primary">82%</div>
                            </div>
                        </div>
                    </div>
                    <div class="card !w-full group cursor-pointer text-left">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition-colors flex-shrink-0">
                                <i class="bi bi-clock text-blue-600 text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <h4 class="text-[10px] font-semibold text-text-light uppercase tracking-wide">Avg. Time to Hire</h4>
                                    <span class="text-[10px] text-text-light">Average duration</span>
                                </div>
                                <div class="text-3xl font-black text-primary">18 Days</div>
                            </div>
                        </div>
                    </div>
                    <div class="card !w-full group cursor-pointer text-left">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center group-hover:bg-purple-200 transition-colors flex-shrink-0">
                                <i class="bi bi-award text-purple-600 text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <h4 class="text-[10px] font-semibold text-text-light uppercase tracking-wide">Training Compliance</h4>
                                    <span class="text-[10px] text-text-light">Completion rate</span>
                                </div>
                                <div class="text-3xl font-black text-primary">94%</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Admin Metrics -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="card !w-full group cursor-pointer text-left">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-lg bg-accent/10 flex items-center justify-center group-hover:bg-accent/20 transition-colors flex-shrink-0">
                                <i class="bi bi-briefcase text-accent text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <h4 class="text-[10px] font-semibold text-text-light uppercase tracking-wide">Active Job Postings</h4>
                                    <span class="text-[10px] text-text-light">Open positions</span>
                                </div>
                                <div class="text-3xl font-black text-primary" x-text="jobs.length"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card !w-full group cursor-pointer text-left">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-lg bg-yellow-100 flex items-center justify-center group-hover:bg-yellow-200 transition-colors flex-shrink-0">
                                <i class="bi bi-list-check text-yellow-600 text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <h4 class="text-[10px] font-semibold text-text-light uppercase tracking-wide">Pending Tasks</h4>
                                    <span class="text-[10px] text-text-light">Awaiting action</span>
                                </div>
                                <div class="text-3xl font-black text-primary" x-text="tasks.filter(t => !t.completed).length"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card !w-full group cursor-pointer text-left">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-lg bg-pink-100 flex items-center justify-center group-hover:bg-pink-200 transition-colors flex-shrink-0">
                                <i class="bi bi-trophy text-pink-600 text-lg"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-2">
                                    <h4 class="text-[10px] font-semibold text-text-light uppercase tracking-wide">Recognitions</h4>
                                    <span class="text-[10px] text-text-light">Total awards</span>
                                </div>
                                <div class="text-3xl font-black text-primary" x-text="recognitions.length"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recruitment Performance Chart -->
                <div class="main-inner !w-full !max-w-none">
                    <h3 class="text-xl font-black text-primary mb-6">Recruitment Performance</h3>
                    <div class="h-64">
                        <canvas id="recruitmentChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Applicants Tab -->
            <div x-show="activeTab === 'applicant'" class="main-inner !w-full !max-w-none mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-primary">Applicant Management</h3>
                    <button @click="modalType = 'add-applicant'" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-hover transition-colors flex items-center gap-2">
                        <i class="bi bi-person-plus"></i>
                        <span class="text-sm font-semibold">Add Candidate</span>
                    </button>
                </div>

                <!-- Applicants Table -->
                <div class="overflow-x-auto" x-show="applicants.length">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-3 px-4 text-xs font-black text-accent uppercase tracking-wider">Name</th>
                                <th class="text-left py-3 px-4 text-xs font-black text-accent uppercase tracking-wider">Email</th>
                                <th class="text-left py-3 px-4 text-xs font-black text-accent uppercase tracking-wider">Position</th>
                                <th class="text-left py-3 px-4 text-xs font-black text-accent uppercase tracking-wider">Contact No.</th>
                                <th class="text-left py-3 px-4 text-xs font-black text-accent uppercase tracking-wider">Status</th>
                                <th class="text-center py-3 px-4 text-xs font-black text-accent uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="applicant in applicants" :key="applicant.id">
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="py-4 px-4">
                                        <div class="text-sm font-semibold text-primary" x-text="applicant.name"></div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="text-sm text-text-light" x-text="applicant.email || 'N/A'"></div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="text-sm text-text-light" x-text="applicant.position || 'N/A'"></div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="text-sm text-text-light" x-text="applicant.contact_no || 'N/A'"></div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <select @change="updateApplicantStatus(applicant.id, $event.target.value)" 
                                                :value="applicant.status || 'applied'"
                                                class="text-xs font-semibold px-3 py-1.5 rounded-full border outline-none"
                                                :class="getStatusClass(applicant.status || 'applied')">
                                            <option value="applied">Applied</option>
                                            <option value="evaluating">Evaluating</option>
                                            <option value="interviewing">Interviewing</option>
                                            <option value="offered">Offered</option>
                                            <option value="onboard">Onboard</option>
                                            <option value="rejected">Rejected</option>
                                        </select>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <button @click="viewApplicantProfile(applicant)" 
                                                    class="p-2 text-primary hover:bg-primary/10 rounded-lg transition-colors"
                                                    title="View Profile">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                            <button @click="editApplicant(applicant)" 
                                                    class="p-2 text-accent hover:bg-accent/10 rounded-lg transition-colors"
                                                    title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <div x-show="!applicants.length" class="text-center py-12 text-sm text-text-light">
                    No applicants found. <button @click="modalType = 'add-applicant'" class="text-primary font-semibold hover:underline">Add your first candidate</button>
                </div>
            </div>

            <!-- Recruitment Tab -->
            <div x-show="activeTab === 'recruitment'" class="main-inner !w-full !max-w-none mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-primary">Recruitment Management</h3>
                    <button @click="modalType = 'create-job'" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-hover transition-colors flex items-center gap-2">
                        <i class="bi bi-plus-circle"></i>
                        <span class="text-sm font-semibold">Add Job</span>
                    </button>
                </div>

                <!-- Jobs List -->
                <div class="space-y-4" x-show="jobs.length">
                    <template x-for="job in jobs" :key="job.id">
                        <div class="p-5 bg-white rounded-xl border border-gray-200 hover:border-primary/30 hover:shadow-lg transition-all duration-200">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="text-lg font-semibold text-primary" x-text="job.title"></div>
                                        <span class="text-xs font-semibold px-2 py-1 rounded-full bg-accent/10 text-accent border border-accent/20" x-text="job.type || 'Full-time'"></span>
                                    </div>
                                    <div class="text-sm text-text-light flex items-center gap-2 mb-3">
                                        <i class="bi bi-building text-accent"></i>
                                        <span x-text="job.department"></span>
                                    </div>
                                    <div class="flex items-center gap-4 text-xs text-text-light">
                                        <span><strong class="text-primary">Applications:</strong> <span x-text="job.applications_hr1 ? job.applications_hr1.length : 0"></span></span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button @click="viewJobApplicants(job)" 
                                            class="px-3 py-1.5 text-xs font-semibold bg-primary/10 text-primary rounded-lg hover:bg-primary/20 transition-colors">
                                        View Applicants
                                    </button>
                                    <button @click="deleteJob(job.id)" 
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                            title="Delete Job">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Applicants for this job -->
                            <div x-show="selectedJobId === job.id && job.applications_hr1 && job.applications_hr1.length" 
                                 class="mt-4 pt-4 border-t border-gray-200">
                                <h4 class="text-sm font-semibold text-primary mb-3">Applicants for this position:</h4>
                                <div class="space-y-2">
                                    <template x-for="app in job.applications_hr1" :key="app.id">
                                        <div class="p-3 bg-gray-50 rounded-lg flex items-center justify-between">
                                            <div>
                                                <div class="text-sm font-medium text-primary" x-text="app.applicant?.name || 'Unknown'"></div>
                                                <div class="text-xs text-text-light" x-text="app.applicant?.email || 'N/A'"></div>
                                            </div>
                                            <span class="text-xs font-semibold px-2 py-1 rounded-full bg-primary/10 text-primary" 
                                                  x-text="app.status || 'Applied'"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div x-show="!jobs.length" class="text-center py-12 text-sm text-text-light">
                    No job postings available. <button @click="modalType = 'create-job'" class="text-primary font-semibold hover:underline">Create your first job posting</button>
                </div>
            </div>

            <!-- Onboarding Tab -->
            <div x-show="activeTab === 'onboarding'" class="main-inner !w-full !max-w-none mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-primary">Onboarding Management</h3>
                    <button @click="modalType = 'add-task-set'" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-hover transition-colors flex items-center gap-2">
                        <i class="bi bi-plus-circle"></i>
                        <span class="text-sm font-semibold">Add Task Set</span>
                    </button>
                </div>

                <!-- Job Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-primary mb-2">Select Job</label>
                    <select @change="selectedOnboardingJob = $event.target.value" 
                            class="w-full md:w-64 p-3 bg-bg rounded-xl border border-gray-200 outline-none focus:border-primary">
                        <option value="">All Jobs</option>
                        <template x-for="job in jobs" :key="job.id">
                            <option :value="job.id" x-text="job.title"></option>
                        </template>
                    </select>
                </div>

                <!-- Task Sets -->
                <div class="mb-6" x-show="taskSets.length">
                    <h4 class="text-lg font-semibold text-primary mb-4">Task Sets</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="taskSet in taskSets" :key="taskSet.id">
                            <div class="p-4 bg-white rounded-xl border border-gray-200">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="text-sm font-semibold text-primary" x-text="taskSet.name"></div>
                                    <div class="flex gap-2">
                                        <button @click="editTaskSet(taskSet)" class="p-1.5 text-accent hover:bg-accent/10 rounded">
                                            <i class="bi bi-pencil text-xs"></i>
                                        </button>
                                        <button @click="deleteTaskSet(taskSet.id)" class="p-1.5 text-red-600 hover:bg-red-50 rounded">
                                            <i class="bi bi-trash text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="text-xs text-text-light mb-2">Tasks:</div>
                                <ul class="space-y-1">
                                    <template x-for="task in taskSet.tasks" :key="task.id">
                                        <li class="text-xs text-text-light flex items-center gap-2">
                                            <i class="bi bi-check-circle text-green-600"></i>
                                            <span x-text="task.title"></span>
                                        </li>
                                    </template>
                                </ul>
                                <button @click="assignTaskSetToJob(taskSet.id)" 
                                        class="mt-3 text-xs font-semibold text-primary hover:underline">
                                    Assign to Job
                                </button>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Applicants and Their Tasks -->
                <div x-show="selectedOnboardingJob">
                    <h4 class="text-lg font-semibold text-primary mb-4">Applicants & Remaining Tasks</h4>
                    <div class="space-y-4">
                        <template x-for="applicant in getApplicantsForJob(selectedOnboardingJob)" :key="applicant.id">
                            <div class="p-4 bg-white rounded-xl border border-gray-200">
                                <div class="flex items-center justify-between mb-3">
                                    <div>
                                        <div class="text-sm font-semibold text-primary" x-text="applicant.name"></div>
                                        <div class="text-xs text-text-light" x-text="applicant.email"></div>
                                    </div>
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full bg-primary/10 text-primary" 
                                          x-text="applicant.status"></span>
                                </div>
                                <div class="text-xs font-semibold text-text-light mb-2">Remaining Tasks:</div>
                                <div class="space-y-2">
                                    <template x-for="task in getRemainingTasks(applicant.id)" :key="task.id">
                                        <div class="flex items-center gap-2 text-xs text-text-light">
                                            <i class="bi bi-clock text-yellow-600"></i>
                                            <span x-text="task.title"></span>
                                        </div>
                                    </template>
                                    <div x-show="getRemainingTasks(applicant.id).length === 0" class="text-xs text-green-600 flex items-center gap-2">
                                        <i class="bi bi-check-circle"></i>
                                        <span>All tasks completed</span>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Performance Tab -->
            <div x-show="activeTab === 'performance'" class="main-inner !w-full !max-w-none mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-primary">Performance Assessment Builder</h3>
                    <button @click="modalType = 'create-form'" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-hover transition-colors flex items-center gap-2">
                        <i class="bi bi-plus-circle"></i>
                        <span class="text-sm font-semibold">Create Form</span>
                    </button>
                </div>

                <!-- Question Sets List -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-primary mb-4">Question Sets</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-show="questionSets.length">
                        <template x-for="form in questionSets" :key="form.id">
                            <div class="p-5 bg-white rounded-xl border border-gray-200 hover:border-primary/30 transition-all">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="text-base font-semibold text-primary" x-text="form.title"></div>
                                    <div class="flex gap-2">
                                        <button @click="editForm(form)" class="p-2 text-accent hover:bg-accent/10 rounded-lg">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button @click="deleteForm(form.id)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="text-xs text-text-light mb-3">
                                    <span x-text="form.questions ? form.questions.length : 0"></span> questions
                                </div>
                                <div class="space-y-2">
                                    <template x-for="(question, index) in (form.questions || [])" :key="index">
                                        <div class="text-xs text-text-light p-2 bg-gray-50 rounded">
                                            <span class="font-semibold" x-text="(index + 1) + '.'"></span>
                                            <span x-text="question.text || question"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                    <div x-show="!questionSets.length" class="text-center py-8 text-sm text-text-light">
                        No question sets created yet.
                    </div>
                </div>
            </div>

            <!-- Recognition Tab -->
            <div x-show="activeTab === 'recognition'" class="main-inner !w-full !max-w-none mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-primary">Recognition & Culture</h3>
                    <button @click="modalType = 'add-recognition'" class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-hover transition-colors flex items-center gap-2">
                        <i class="bi bi-trophy"></i>
                        <span class="text-sm font-semibold">Nominate Outstanding</span>
                    </button>
                </div>

                <!-- Recognitions List -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-show="recognitions.length">
                    <template x-for="recognition in recognitions" :key="recognition.id">
                        <div class="p-5 bg-white rounded-xl border border-gray-200 hover:border-primary/30 transition-all">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                                        <i class="bi bi-trophy text-yellow-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-base font-semibold text-primary" x-text="recognition.candidate_name || 'Outstanding Candidate'"></div>
                                        <div class="text-xs text-text-light" x-text="recognition.position || 'N/A'"></div>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <button @click="editRecognition(recognition)" class="p-2 text-accent hover:bg-accent/10 rounded-lg">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button @click="deleteRecognition(recognition.id)" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="text-sm text-text-light mb-2" x-text="recognition.description || 'Recognized for outstanding performance'"></div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-semibold px-2 py-1 rounded-full"
                                      :class="recognition.is_most_outstanding ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700'">
                                    <span x-text="recognition.is_most_outstanding ? '⭐ Most Outstanding' : 'Outstanding'"></span>
                                </span>
                            </div>
                        </div>
                    </template>
                </div>
                <div x-show="!recognitions.length" class="text-center py-12 text-sm text-text-light">
                    No recognitions posted yet.
                </div>
            </div>

            <!-- Profile Tab -->
            <div x-show="activeTab === 'profile'" class="main-inner !w-full !max-w-none mt-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-black text-primary">Admin Profile</h3>
                    <button @click="editingProfile = !editingProfile" 
                            class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary-hover transition-colors flex items-center gap-2">
                        <i :class="editingProfile ? 'bi bi-x' : 'bi bi-pencil'"></i>
                        <span class="text-sm font-semibold" x-text="editingProfile ? 'Cancel' : 'Edit Profile'"></span>
                    </button>
                </div>

                <div class="max-w-2xl">
                    <template x-if="!editingProfile">
                        <div class="space-y-4">
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <label class="text-xs font-semibold text-text-light uppercase tracking-wide">Name</label>
                                <div class="text-base font-semibold text-primary mt-1" x-text="adminProfile.name || 'N/A'"></div>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <label class="text-xs font-semibold text-text-light uppercase tracking-wide">Email</label>
                                <div class="text-base font-semibold text-primary mt-1" x-text="adminProfile.email || 'N/A'"></div>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <label class="text-xs font-semibold text-text-light uppercase tracking-wide">Contact Number</label>
                                <div class="text-base font-semibold text-primary mt-1" x-text="adminProfile.contact_no || 'N/A'"></div>
                            </div>
                            <div class="p-4 bg-gray-50 rounded-xl">
                                <label class="text-xs font-semibold text-text-light uppercase tracking-wide">Date of Employment</label>
                                <div class="text-base font-semibold text-primary mt-1" x-text="adminProfile.date_of_employment || 'N/A'"></div>
                            </div>
                        </div>
                    </template>

                    <template x-if="editingProfile">
                        <form @submit.prevent="updateProfile" class="space-y-4">
                            <div>
                                <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Name</label>
                                <input type="text" x-model="adminProfile.name" 
                                       class="w-full p-3 bg-bg rounded-xl border border-gray-200 outline-none focus:border-primary"
                                       required>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Email</label>
                                <input type="email" x-model="adminProfile.email" 
                                       class="w-full p-3 bg-bg rounded-xl border border-gray-200 outline-none focus:border-primary"
                                       required>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Contact Number</label>
                                <input type="tel" x-model="adminProfile.contact_no" 
                                       class="w-full p-3 bg-bg rounded-xl border border-gray-200 outline-none focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Date of Employment</label>
                                <input type="date" x-model="adminProfile.date_of_employment" 
                                       class="w-full p-3 bg-bg rounded-xl border border-gray-200 outline-none focus:border-primary">
                            </div>
                            <button type="submit" 
                                    class="w-full bg-primary text-white py-3 rounded-xl font-semibold hover:bg-primary-hover transition-colors">
                                Save Changes
                            </button>
                        </form>
                    </template>
                </div>
            </div>
        </div>
    </main>
</div>

@include('hr1.user_hr1.shared.modals')
@include('hr1.user_hr1.admin.partials.modals')
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
        role: 'admin',
        activeTab: 'dashboard',
        sidebarOpen: true,
        modalType: null,
        selectedJob: null,
        selectedJobId: null,
        selectedApplicant: null,
        selectedOnboardingJob: null,
        editingProfile: false,
        editingForm: null,
        editingTaskSet: null,
        editingRecognition: null,
        applicants: @json($applicants ?? []),
        jobs: @json($jobs ?? []),
        recognitions: @json($recognitions ?? []),
        tasks: @json($tasks ?? []),
        taskSets: @json($taskSets ?? []),
        questionSets: @json($questionSets ?? []),
        awardCategories: @json($awardCategories ?? []),
        evalCriteria: @json($evalCriteria ?? []),
        availableModules: @json($availableModules ?? []),
        adminProfile: (() => {
            const profile = @json($adminProfile ?? []);
            return {
                name: profile.name || '',
                email: profile.email || '',
                contact_no: profile.contact_no || '',
                date_of_employment: profile.date_of_employment || ''
            };
        })(),
        
        getStatusClass(status) {
            const classes = {
                'applied': 'bg-blue-50 text-blue-700 border-blue-200',
                'evaluating': 'bg-purple-50 text-purple-700 border-purple-200',
                'interviewing': 'bg-yellow-50 text-yellow-700 border-yellow-200',
                'offered': 'bg-green-50 text-green-700 border-green-200',
                'onboard': 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'rejected': 'bg-red-50 text-red-700 border-red-200'
            };
            return classes[status] || 'bg-gray-50 text-gray-700 border-gray-200';
        },
        
        updateApplicantStatus(id, status) {
            fetch(`/api/hr1/applicants/${id}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status })
            }).then(() => {
                const applicant = this.applicants.find(a => a.id == id);
                if (applicant) applicant.status = status;
            });
        },
        
        viewApplicantProfile(applicant) {
            this.selectedApplicant = applicant;
            this.modalType = 'view-profile';
        },
        
        editApplicant(applicant) {
            this.selectedApplicant = applicant;
            this.modalType = 'edit-applicant';
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
        
        viewJobApplicants(job) {
            this.selectedJobId = this.selectedJobId === job.id ? null : job.id;
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
        
        getApplicantsForJob(jobId) {
            if (!jobId) return [];
            const job = this.jobs.find(j => j.id == jobId);
            if (!job || !job.applications_hr1) return [];
            return job.applications_hr1.map(app => app.applicant).filter(Boolean);
        },
        
        getRemainingTasks(applicantId) {
            // This would need to be implemented based on your data structure
            return [];
        },
        
        assignTaskSetToJob(taskSetId) {
            if (!this.selectedOnboardingJob) {
                alert('Please select a job first');
                return;
            }
            // Implementation needed
        },
        
        editTaskSet(taskSet) {
            this.editingTaskSet = taskSet;
            this.modalType = 'edit-task-set';
        },
        
        deleteTaskSet(id) {
            if (confirm('Delete this task set?')) {
                fetch(`/api/hr1/task-sets/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                }).then(() => {
                    this.taskSets = this.taskSets.filter(ts => ts.id != id);
                });
            }
        },
        
        editForm(form) {
            this.editingForm = form;
            this.modalType = 'edit-form';
        },
        
        deleteForm(id) {
            if (confirm('Delete this form?')) {
                fetch(`/api/hr1/question-sets/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                }).then(() => {
                    this.questionSets = this.questionSets.filter(qs => qs.id != id);
                });
            }
        },
        
        editRecognition(recognition) {
            this.editingRecognition = recognition;
            this.modalType = 'edit-recognition';
        },
        
        deleteRecognition(id) {
            if (confirm('Delete this recognition?')) {
                fetch(`/api/hr1/recognitions/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content }
                }).then(() => {
                    this.recognitions = this.recognitions.filter(r => r.id != id);
                });
            }
        },
        
        updateProfile() {
            fetch('/api/hr1/admin/profile', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(this.adminProfile)
            }).then(() => {
                this.editingProfile = false;
                alert('Profile updated successfully');
            });
        },
        
        updateApplicantInfo() {
            const form = event.target;
            const formData = new FormData(form);
            formData.append('id', this.selectedApplicant.id);
            
            fetch(`/api/hr1/applicants/${this.selectedApplicant.id}`, {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            }).then(() => {
                this.modalType = null;
                alert('Applicant updated successfully');
            });
        },
        
        createTaskSet() {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch('/api/hr1/task-sets', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            }).then(res => res.json()).then(data => {
                this.taskSets.push(data);
                this.modalType = null;
            });
        },
        
        createForm() {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch('/api/hr1/question-sets', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            }).then(res => res.json()).then(data => {
                this.questionSets.push(data);
                this.modalType = null;
            });
        },
        
        createRecognition() {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch('/api/hr1/recognitions', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            }).then(res => res.json()).then(data => {
                this.recognitions.push(data);
                this.modalType = null;
            });
        },
        
        updateRecognition() {
            const form = event.target;
            const formData = new FormData(form);
            formData.append('id', this.editingRecognition.id);
            
            fetch(`/api/hr1/recognitions/${this.editingRecognition.id}`, {
                method: 'PATCH',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData
            }).then(() => {
                this.modalType = null;
                this.editingRecognition = null;
                alert('Recognition updated successfully');
            });
        },
        
        get navItems() {
            return [
                { id: 'dashboard', label: 'Dashboard', icon: 'layout-dashboard' },
                { id: 'applicant', label: 'Applicants', icon: 'users' },
                { id: 'recruitment', label: 'Recruitment', icon: 'briefcase' },
                { id: 'onboarding', label: 'Onboarding', icon: 'user-plus' },
                { id: 'performance', label: 'Performance', icon: 'trending-up' },
                { id: 'recognition', label: 'Recognition', icon: 'award' },
                { id: 'profile', label: 'Profile', icon: 'user-circle' }
            ];
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons();
    
    // Initialize chart
    const ctx = document.getElementById('recruitmentChart');
    if (ctx && typeof Chart !== 'undefined') {
        const jobsData = @json($jobs ?? []);
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: jobsData.map(job => job.title),
                datasets: [{
                    label: 'Applications',
                    data: jobsData.map(job => job.applications_hr1 ? job.applications_hr1.length : 0),
                    backgroundColor: '#1B3C53',
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
});
</script>
@endpush
