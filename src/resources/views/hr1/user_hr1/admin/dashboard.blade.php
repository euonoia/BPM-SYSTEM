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
                                <div class="text-3xl font-black text-primary" x-text="analytics.totalApplicants || applicants.length"></div>
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
                                <div class="text-3xl font-black text-primary" x-text="(analytics.offerAcceptanceRate || 0) + '%'"></div>
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
                                <div class="text-3xl font-black text-primary" x-text="(analytics.avgTimeToHire || 0) + ' Days'"></div>
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
                                <div class="text-3xl font-black text-primary" x-text="(analytics.trainingCompliance || 0) + '%'"></div>
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
                                <div class="text-3xl font-black text-primary" x-text="analytics.totalJobs || jobs.length"></div>
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
                                <div class="text-3xl font-black text-primary" x-text="analytics.pendingTasks || tasks.filter(t => !t.completed).length"></div>
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
                                <div class="text-3xl font-black text-primary" x-text="analytics.totalRecognitions || recognitions.length"></div>
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

                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" 
                               x-model="applicantSearchQuery" 
                               @input="filterApplicants()"
                               placeholder="Search by name, email, position, contact no., or status..." 
                               class="w-full p-4 bg-bg rounded-xl border border-gray-200 outline-none focus:border-primary pl-12">
                        <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-text-light"></i>
                    </div>
                </div>

                <!-- Applicants Table -->
                <div class="overflow-x-auto" x-show="filteredApplicants.length">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="text-left py-3 px-4 text-xs font-black text-accent uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        Name
                                        <button @click="sortApplicants('name')" class="text-text-light hover:text-primary">
                                            <i class="bi bi-arrow-down-up text-xs"></i>
                                        </button>
                                    </div>
                                </th>
                                <th class="text-left py-3 px-4 text-xs font-black text-accent uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        Email
                                        <button @click="sortApplicants('email')" class="text-text-light hover:text-primary">
                                            <i class="bi bi-arrow-down-up text-xs"></i>
                                        </button>
                                    </div>
                                </th>
                                <th class="text-left py-3 px-4 text-xs font-black text-accent uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        Position
                                        <button @click="sortApplicants('position')" class="text-text-light hover:text-primary">
                                            <i class="bi bi-arrow-down-up text-xs"></i>
                                        </button>
                                    </div>
                                </th>
                                <th class="text-left py-3 px-4 text-xs font-black text-accent uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        Contact No.
                                        <button @click="sortApplicants('contact_no')" class="text-text-light hover:text-primary">
                                            <i class="bi bi-arrow-down-up text-xs"></i>
                                        </button>
                                    </div>
                                </th>
                                <th class="text-left py-3 px-4 text-xs font-black text-accent uppercase tracking-wider">
                                    <div class="flex items-center gap-2">
                                        Status
                                        <button @click="sortApplicants('status')" class="text-text-light hover:text-primary">
                                            <i class="bi bi-arrow-down-up text-xs"></i>
                                        </button>
                                    </div>
                                </th>
                                <th class="text-center py-3 px-4 text-xs font-black text-accent uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="applicant in filteredApplicants" :key="applicant.id">
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
                <div x-show="!filteredApplicants.length" class="text-center py-12 text-sm text-text-light">
                    <span x-show="applicantSearchQuery">No applicants found matching your search.</span>
                    <span x-show="!applicantSearchQuery">No applicants found. <button @click="modalType = 'add-applicant'" class="text-primary font-semibold hover:underline">Add your first candidate</button></span>
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

                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" 
                               x-model="jobSearchQuery" 
                               @input="filterJobs()"
                               placeholder="Search by job title, department, type, or candidate name..." 
                               class="w-full p-4 bg-bg rounded-xl border border-gray-200 outline-none focus:border-primary pl-12">
                        <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-text-light"></i>
                    </div>
                </div>

                <!-- Jobs List -->
                <div class="space-y-4" x-show="filteredJobs.length">
                    <template x-for="job in filteredJobs" :key="job.id">
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
                                    <button @click="editJob(job)" 
                                            class="px-3 py-1.5 text-xs font-semibold bg-accent/10 text-accent rounded-lg hover:bg-accent/20 transition-colors">
                                        Edit
                                    </button>
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
                                                <div class="text-sm font-medium text-primary" x-text="app.user?.name || 'Unknown'"></div>
                                                <div class="text-xs text-text-light" x-text="app.user?.email || 'N/A'"></div>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="text-xs font-semibold px-2 py-1 rounded-full bg-primary/10 text-primary" 
                                                      x-text="app.status || 'Applied'"></span>
                                                <button @click="viewJobApplicantProfile(app.user)" 
                                                        class="p-1.5 text-primary hover:bg-primary/10 rounded-lg transition-colors"
                                                        title="View Profile">
                                                    <i class="bi bi-eye text-xs"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div x-show="!filteredJobs.length" class="text-center py-12 text-sm text-text-light">
                    <span x-show="jobSearchQuery">No jobs found matching your search.</span>
                    <span x-show="!jobSearchQuery">No job postings available. <button @click="modalType = 'create-job'" class="text-primary font-semibold hover:underline">Create your first job posting</button></span>
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

                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" 
                               x-model="taskSetSearchQuery" 
                               @input="filterTaskSets()"
                               placeholder="Search task sets..." 
                               class="w-full p-4 bg-bg rounded-xl border border-gray-200 outline-none focus:border-primary pl-12">
                        <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-text-light"></i>
                    </div>
                </div>

                <!-- Job Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-semibold text-primary mb-2">Select Job</label>
                    <select @change="selectedOnboardingJob = $event.target.value" 
                            class="w-full p-3 bg-bg rounded-xl border border-gray-200 outline-none focus:border-primary">
                        <option value="">All Jobs</option>
                        <template x-for="job in jobs" :key="job.id">
                            <option :value="job.id" x-text="job.title"></option>
                        </template>
                    </select>
                </div>

                <!-- Task Sets -->
                <div class="mb-6" x-show="filteredTaskSets.length">
                    <h4 class="text-lg font-semibold text-primary mb-4">Task Sets</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="taskSet in filteredTaskSets" :key="taskSet.id">
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

                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" 
                               x-model="questionSetSearchQuery" 
                               @input="filterQuestionSets()"
                               placeholder="Search forms/question sets..." 
                               class="w-full p-4 bg-bg rounded-xl border border-gray-200 outline-none focus:border-primary pl-12">
                        <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-text-light"></i>
                    </div>
                </div>

                <!-- Question Sets List -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-primary mb-4">Question Sets</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-show="filteredQuestionSets.length">
                        <template x-for="form in filteredQuestionSets" :key="form.id">
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
                    <div x-show="!filteredQuestionSets.length" class="text-center py-8 text-sm text-text-light">
                        <span x-show="questionSetSearchQuery">No question sets found matching your search.</span>
                        <span x-show="!questionSetSearchQuery">No question sets created yet.</span>
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

                <!-- Search Bar -->
                <div class="mb-6">
                    <div class="relative">
                        <input type="text" 
                               x-model="recognitionSearchQuery" 
                               @input="filterRecognitions()"
                               placeholder="Search recognitions by candidate, reason, or award type..." 
                               class="w-full p-4 bg-bg rounded-xl border border-gray-200 outline-none focus:border-primary pl-12">
                        <i class="bi bi-search absolute left-4 top-1/2 transform -translate-y-1/2 text-text-light"></i>
                    </div>
                </div>

                <!-- Recognitions List -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-show="filteredRecognitions.length">
                    <template x-for="recognition in filteredRecognitions" :key="recognition.id">
                        <div class="p-5 bg-white rounded-xl border border-gray-200 hover:border-primary/30 transition-all">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                                        <i class="bi bi-trophy text-yellow-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-base font-semibold text-primary" x-text="recognition.to || 'Outstanding Candidate'"></div>
                                        <div class="text-xs text-text-light" x-text="recognition.award_type || 'N/A'"></div>
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
                            <!-- Profile Picture -->
                            <div class="flex items-start gap-6 mb-6">
                                <div class="flex-shrink-0">
                                    <div class="w-32 h-32 rounded-full bg-primary/10 flex items-center justify-center overflow-hidden border-4 border-primary/20">
                                        <img x-show="adminProfile.profile_picture" 
                                             :src="adminProfile.profile_picture" 
                                             :alt="adminProfile.name"
                                             class="w-full h-full object-cover">
                                        <i x-show="!adminProfile.profile_picture" class="bi bi-person-circle text-6xl text-primary/50"></i>
                                    </div>
                                </div>
                                <div class="flex-1 pt-4">
                                    <h4 class="text-2xl font-black text-primary mb-1" x-text="adminProfile.name || 'Admin User'"></h4>
                                    <p class="text-sm text-text-light" x-text="adminProfile.email || 'admin@example.com'"></p>
                                </div>
                            </div>
                            
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
                            <!-- Profile Picture Upload -->
                            <div class="mb-6">
                                <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Profile Picture</label>
                                <div class="flex items-center gap-4">
                                    <div class="w-24 h-24 rounded-full bg-primary/10 flex items-center justify-center overflow-hidden border-4 border-primary/20 flex-shrink-0">
                                        <img x-show="adminProfile.profile_picture" 
                                             :src="adminProfile.profile_picture" 
                                             :alt="adminProfile.name"
                                             class="w-full h-full object-cover">
                                        <i x-show="!adminProfile.profile_picture" class="bi bi-person-circle text-4xl text-primary/50"></i>
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" 
                                               @change="handleProfilePictureChange($event)"
                                               accept="image/*"
                                               class="text-sm w-full p-2 bg-bg rounded-xl border border-gray-200 outline-none focus:border-primary">
                                        <p class="text-xs text-text-light mt-1">Upload a profile picture (JPG, PNG, max 2MB)</p>
                                    </div>
                                </div>
                            </div>
                            
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
        editingApplicant: false,
        selectedJob: null,
        applicants: @json($applicants ?? []),
        filteredApplicants: @json($applicants ?? []),
        applicantSearchQuery: '',
        applicantSortField: 'name',
        applicantSortDirection: 'asc',
        jobs: @json($jobs ?? []),
        filteredJobs: @json($jobs ?? []),
        jobSearchQuery: '',
        recognitions: @json($recognitions ?? []),
        filteredRecognitions: @json($recognitions ?? []),
        recognitionSearchQuery: '',
        tasks: @json($tasks ?? []),
        taskSets: @json($taskSets ?? []),
        filteredTaskSets: @json($taskSets ?? []),
        taskSetSearchQuery: '',
        questionSets: @json($questionSets ?? []),
        filteredQuestionSets: @json($questionSets ?? []),
        questionSetSearchQuery: '',
        awardCategories: @json($awardCategories ?? []),
        evalCriteria: @json($evalCriteria ?? []),
        availableModules: @json($availableModules ?? []),
        onboardingCandidates: @json($onboardingCandidates ?? []),
        analytics: @json($analytics ?? []),
        adminProfile: (() => {
            const profile = @json($adminProfile ?? []);
            return {
                name: profile.name || '',
                email: profile.email || '',
                contact_no: profile.contact_no || '',
                date_of_employment: profile.date_of_employment || '',
                profile_picture: profile.profile_picture || ''
            };
        })(),
        
        getStatusClass(status) {
            const classes = {
                'applied': 'bg-blue-50 text-blue-700 border-blue-200',
                'Applied': 'bg-blue-50 text-blue-700 border-blue-200',
                'evaluating': 'bg-purple-50 text-purple-700 border-purple-200',
                'Evaluation': 'bg-purple-50 text-purple-700 border-purple-200',
                'interviewing': 'bg-yellow-50 text-yellow-700 border-yellow-200',
                'Interviewing': 'bg-yellow-50 text-yellow-700 border-yellow-200',
                'offered': 'bg-green-50 text-green-700 border-green-200',
                'Offer': 'bg-green-50 text-green-700 border-green-200',
                'onboard': 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'Onboarding': 'bg-emerald-50 text-emerald-700 border-emerald-200',
                'rejected': 'bg-red-50 text-red-700 border-red-200',
                'Rejected': 'bg-red-50 text-red-700 border-red-200'
            };
            return classes[status] || 'bg-gray-50 text-gray-700 border-gray-200';
        },
        
        filterApplicants() {
            const query = this.applicantSearchQuery.toLowerCase();
            if (!query) {
                this.filteredApplicants = [...this.applicants];
                return;
            }
            this.filteredApplicants = this.applicants.filter(applicant => 
                (applicant.name || '').toLowerCase().includes(query) ||
                (applicant.email || '').toLowerCase().includes(query) ||
                (applicant.position || '').toLowerCase().includes(query) ||
                (applicant.contact_no || '').toLowerCase().includes(query) ||
                (applicant.status || '').toLowerCase().includes(query)
            );
            this.sortApplicants(this.applicantSortField);
        },
        
        sortApplicants(field) {
            if (this.applicantSortField === field) {
                this.applicantSortDirection = this.applicantSortDirection === 'asc' ? 'desc' : 'asc';
            } else {
                this.applicantSortField = field;
                this.applicantSortDirection = 'asc';
            }
            
            this.filteredApplicants.sort((a, b) => {
                const aVal = (a[field] || '').toString().toLowerCase();
                const bVal = (b[field] || '').toString().toLowerCase();
                if (this.applicantSortDirection === 'asc') {
                    return aVal.localeCompare(bVal);
                } else {
                    return bVal.localeCompare(aVal);
                }
            });
        },
        
        filterJobs() {
            const query = this.jobSearchQuery.toLowerCase();
            if (!query) {
                this.filteredJobs = [...this.jobs];
                return;
            }
            this.filteredJobs = this.jobs.filter(job => 
                (job.title || '').toLowerCase().includes(query) ||
                (job.department || '').toLowerCase().includes(query) ||
                (job.type || '').toLowerCase().includes(query) ||
                (job.applications_hr1 || []).some(app => 
                    (app.user?.name || '').toLowerCase().includes(query) ||
                    (app.user?.email || '').toLowerCase().includes(query)
                )
            );
        },
        
        filterTaskSets() {
            const query = this.taskSetSearchQuery.toLowerCase();
            if (!query) {
                this.filteredTaskSets = [...this.taskSets];
                return;
            }
            this.filteredTaskSets = this.taskSets.filter(ts => 
                (ts.name || '').toLowerCase().includes(query) ||
                (ts.description || '').toLowerCase().includes(query)
            );
        },
        
        filterQuestionSets() {
            const query = this.questionSetSearchQuery.toLowerCase();
            if (!query) {
                this.filteredQuestionSets = [...this.questionSets];
                return;
            }
            this.filteredQuestionSets = this.questionSets.filter(qs => 
                (qs.title || '').toLowerCase().includes(query) ||
                (qs.description || '').toLowerCase().includes(query)
            );
        },
        
        filterRecognitions() {
            const query = this.recognitionSearchQuery.toLowerCase();
            if (!query) {
                this.filteredRecognitions = [...this.recognitions];
                return;
            }
            this.filteredRecognitions = this.recognitions.filter(rec => 
                (rec.to || '').toLowerCase().includes(query) ||
                (rec.from || '').toLowerCase().includes(query) ||
                (rec.reason || '').toLowerCase().includes(query) ||
                (rec.award_type || '').toLowerCase().includes(query)
            );
        },
        
        updateApplicantStatus(id, status) {
            // Map status values
            const statusMap = {
                'applied': 'Applied',
                'evaluating': 'Evaluation',
                'interviewing': 'Interviewing',
                'offered': 'Offer',
                'onboard': 'Onboarding',
                'rejected': 'Rejected'
            };
            const mappedStatus = statusMap[status] || status;
            
            fetch(`/api/hr1/applicants/${id}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: mappedStatus })
            }).then(res => res.json()).then(data => {
                const applicant = this.applicants.find(a => a.id == id);
                if (applicant) {
                    applicant.status = mappedStatus;
                    this.filterApplicants();
                }
            }).catch(err => {
                console.error('Error updating status:', err);
                alert('Failed to update status');
            });
        },
        
        viewApplicantProfile(applicant) {
            this.selectedApplicant = applicant;
            this.modalType = 'view-profile';
        },
        
        
        addApplicant() {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch('/api/hr1/applicants', {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            }).then(res => {
                if (!res.ok) throw new Error('Failed to add applicant');
                return res.json();
            }).then(data => {
                this.applicants.push(data);
                this.filterApplicants();
                this.modalType = null;
                form.reset();
                alert('Candidate added successfully!');
            }).catch(err => {
                console.error('Error adding applicant:', err);
                alert('Failed to add candidate. Please try again.');
            });
        },
        
        viewJobApplicants(job) {
            this.selectedJobId = this.selectedJobId === job.id ? null : job.id;
        },
        
        deleteJob(id) {
            if (confirm('Delete this job posting?')) {
                fetch(`/api/hr1/jobs/${id}`, {
                    method: 'DELETE',
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                }).then(res => {
                    if (!res.ok) throw new Error('Failed to delete job');
                    this.jobs = this.jobs.filter(j => j.id != id);
                    this.filterJobs();
                    alert('Job deleted successfully!');
                }).catch(err => {
                    console.error('Error deleting job:', err);
                    alert('Failed to delete job. Please try again.');
                });
            }
        },
        
        createJob() {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch('/api/hr1/jobs', {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            }).then(res => {
                if (!res.ok) throw new Error('Failed to create job');
                return res.json();
            }).then(data => {
                this.jobs.push(data);
                this.filterJobs();
                this.modalType = null;
                form.reset();
                alert('Job posted successfully!');
            }).catch(err => {
                console.error('Error creating job:', err);
                alert('Failed to create job. Please try again.');
            });
        },
        
        editJob(job) {
            this.selectedJob = { ...job };
            this.modalType = 'edit-job';
        },
        
        updateJob() {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch(`/api/hr1/jobs/${this.selectedJob.id}`, {
                method: 'PATCH',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            }).then(res => {
                if (!res.ok) throw new Error('Failed to update job');
                return res.json();
            }).then(data => {
                const index = this.jobs.findIndex(j => j.id == data.id);
                if (index !== -1) {
                    this.jobs[index] = data;
                    this.filterJobs();
                }
                this.modalType = null;
                alert('Job updated successfully!');
            }).catch(err => {
                console.error('Error updating job:', err);
                alert('Failed to update job. Please try again.');
            });
        },
        
        getApplicantsForJob(jobId) {
            if (!jobId) return this.onboardingCandidates;
            const job = this.jobs.find(j => j.id == jobId);
            if (!job || !job.applications_hr1) return this.onboardingCandidates;
            return job.applications_hr1
                .filter(app => app.user && (app.status === 'Onboarding' || app.status === 'Offer'))
                .map(app => app.user)
                .filter(Boolean);
        },
        
        viewJobApplicantProfile(applicant) {
            this.selectedApplicant = applicant;
            this.modalType = 'view-profile';
        },
        
        getRemainingTasks(applicantId) {
            // Get tasks for this applicant from applicant_tasks_hr1 table
            // This would need to be fetched from the backend
            // For now, return empty array - will be populated when backend is ready
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
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                }).then(res => {
                    if (!res.ok) throw new Error('Failed to delete task set');
                    this.taskSets = this.taskSets.filter(ts => ts.id != id);
                    this.filterTaskSets();
                    alert('Task set deleted successfully!');
                }).catch(err => {
                    console.error('Error deleting task set:', err);
                    alert('Failed to delete task set. Please try again.');
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
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                }).then(res => {
                    if (!res.ok) throw new Error('Failed to delete form');
                    this.questionSets = this.questionSets.filter(qs => qs.id != id);
                    this.filterQuestionSets();
                    alert('Form deleted successfully!');
                }).catch(err => {
                    console.error('Error deleting form:', err);
                    alert('Failed to delete form. Please try again.');
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
                    headers: { 
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                }).then(res => {
                    if (!res.ok) throw new Error('Failed to delete recognition');
                    this.recognitions = this.recognitions.filter(r => r.id != id);
                    this.filterRecognitions();
                    alert('Recognition deleted successfully!');
                }).catch(err => {
                    console.error('Error deleting recognition:', err);
                    alert('Failed to delete recognition. Please try again.');
                });
            }
        },
        
        handleProfilePictureChange(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.adminProfile.profile_picture = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        
        updateProfile() {
            const formData = new FormData();
            formData.append('name', this.adminProfile.name);
            formData.append('email', this.adminProfile.email);
            formData.append('contact_no', this.adminProfile.contact_no);
            formData.append('date_of_employment', this.adminProfile.date_of_employment);
            
            // If profile picture is a data URL, convert it to file
            if (this.adminProfile.profile_picture && this.adminProfile.profile_picture.startsWith('data:')) {
                // For now, just send the data URL. In production, upload to server first
                formData.append('profile_picture', this.adminProfile.profile_picture);
            }
            
            fetch('/api/hr1/admin/profile', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            }).then(res => {
                if (!res.ok) throw new Error('Failed to update profile');
                return res.json();
            }).then(data => {
                this.adminProfile = { ...this.adminProfile, ...data };
                this.editingProfile = false;
                alert('Profile updated successfully');
            }).catch(err => {
                console.error('Error updating profile:', err);
                alert('Failed to update profile. Please try again.');
            });
        },
        
        updateApplicantInfo() {
            if (!this.selectedApplicant || !this.editingApplicant) {
                alert('Please click Edit button first');
                return;
            }
            
            const form = event.target;
            const formData = new FormData(form);
            
            // Map status if needed
            if (formData.get('status')) {
                const statusMap = {
                    'applied': 'Applied',
                    'evaluating': 'Evaluation',
                    'interviewing': 'Interviewing',
                    'offered': 'Offer',
                    'onboard': 'Onboarding',
                    'rejected': 'Rejected'
                };
                const status = formData.get('status');
                formData.set('status', statusMap[status] || status);
            }
            
            fetch(`/api/hr1/applicants/${this.selectedApplicant.id}`, {
                method: 'PATCH',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            }).then(res => {
                if (!res.ok) throw new Error('Failed to update applicant');
                return res.json();
            }).then(data => {
                const index = this.applicants.findIndex(a => a.id == data.id);
                if (index !== -1) {
                    this.applicants[index] = data;
                    this.filterApplicants();
                }
                this.modalType = null;
                this.editingApplicant = false;
                alert('Applicant updated successfully');
            }).catch(err => {
                console.error('Error updating applicant:', err);
                alert('Failed to update applicant. Please try again.');
            });
        },
        
        editApplicant(applicant) {
            this.selectedApplicant = { ...applicant };
            this.editingApplicant = true;
            this.modalType = 'edit-applicant';
        },
        
        createTaskSet() {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch('/api/hr1/task-sets', {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            }).then(res => {
                if (!res.ok) throw new Error('Failed to create task set');
                return res.json();
            }).then(data => {
                this.taskSets.push(data);
                this.filterTaskSets();
                this.modalType = null;
                form.reset();
                alert('Task set created successfully!');
            }).catch(err => {
                console.error('Error creating task set:', err);
                alert('Failed to create task set. Please try again.');
            });
        },
        
        updateTaskSet() {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch(`/api/hr1/task-sets/${this.editingTaskSet.id}`, {
                method: 'PATCH',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            }).then(res => {
                if (!res.ok) throw new Error('Failed to update task set');
                return res.json();
            }).then(data => {
                const index = this.taskSets.findIndex(ts => ts.id == data.id);
                if (index !== -1) {
                    this.taskSets[index] = data;
                    this.filterTaskSets();
                }
                this.modalType = null;
                this.editingTaskSet = null;
                alert('Task set updated successfully!');
            }).catch(err => {
                console.error('Error updating task set:', err);
                alert('Failed to update task set. Please try again.');
            });
        },
        
        createForm() {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch('/api/hr1/question-sets', {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            }).then(res => {
                if (!res.ok) throw new Error('Failed to create form');
                return res.json();
            }).then(data => {
                this.questionSets.push(data);
                this.filterQuestionSets();
                this.modalType = null;
                form.reset();
                alert('Form created successfully!');
            }).catch(err => {
                console.error('Error creating form:', err);
                alert('Failed to create form. Please try again.');
            });
        },
        
        updateForm() {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch(`/api/hr1/question-sets/${this.editingForm.id}`, {
                method: 'PATCH',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            }).then(res => {
                if (!res.ok) throw new Error('Failed to update form');
                return res.json();
            }).then(data => {
                const index = this.questionSets.findIndex(qs => qs.id == data.id);
                if (index !== -1) {
                    this.questionSets[index] = data;
                    this.filterQuestionSets();
                }
                this.modalType = null;
                this.editingForm = null;
                alert('Form updated successfully!');
            }).catch(err => {
                console.error('Error updating form:', err);
                alert('Failed to update form. Please try again.');
            });
        },
        
        createRecognition() {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch('/api/hr1/recognitions', {
                method: 'POST',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            }).then(res => {
                if (!res.ok) throw new Error('Failed to create recognition');
                return res.json();
            }).then(data => {
                this.recognitions.push(data);
                this.filterRecognitions();
                this.modalType = null;
                form.reset();
                alert('Recognition posted successfully!');
            }).catch(err => {
                console.error('Error creating recognition:', err);
                alert('Failed to post recognition. Please try again.');
            });
        },
        
        updateRecognition() {
            const form = event.target;
            const formData = new FormData(form);
            
            fetch(`/api/hr1/recognitions/${this.editingRecognition.id}`, {
                method: 'PATCH',
                headers: { 
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: formData
            }).then(res => {
                if (!res.ok) throw new Error('Failed to update recognition');
                return res.json();
            }).then(data => {
                const index = this.recognitions.findIndex(r => r.id == data.id);
                if (index !== -1) {
                    this.recognitions[index] = data;
                    this.filterRecognitions();
                }
                this.modalType = null;
                this.editingRecognition = null;
                alert('Recognition updated successfully!');
            }).catch(err => {
                console.error('Error updating recognition:', err);
                alert('Failed to update recognition. Please try again.');
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
