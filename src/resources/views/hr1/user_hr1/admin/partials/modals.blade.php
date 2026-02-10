<!-- View Applicant Profile Modal -->
<div x-show="modalType === 'view-profile'" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
    <div class="absolute inset-0 bg-primary/40 backdrop-blur-md" @click="modalType = null"></div>
    <div class="relative bg-white w-full max-w-2xl rounded-[2.5rem] shadow-2xl overflow-hidden">
        <div class="p-8 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-2xl font-black text-primary tracking-tight">Applicant Profile</h3>
            <button @click="modalType = null" class="p-2 hover:bg-bg rounded-full transition-colors"><i data-lucide="x" class="w-6 h-6"></i></button>
        </div>
        <div class="p-8 max-h-[85vh] overflow-y-auto" x-show="selectedApplicant">
            <div class="space-y-4">
                <div class="p-4 bg-gray-50 rounded-xl">
                    <label class="text-xs font-semibold text-text-light uppercase tracking-wide">Name</label>
                    <div class="text-base font-semibold text-primary mt-1" x-text="selectedApplicant?.name || 'N/A'"></div>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <label class="text-xs font-semibold text-text-light uppercase tracking-wide">Email</label>
                    <div class="text-base font-semibold text-primary mt-1" x-text="selectedApplicant?.email || 'N/A'"></div>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <label class="text-xs font-semibold text-text-light uppercase tracking-wide">Password</label>
                    <div class="text-base font-semibold text-primary mt-1" x-text="selectedApplicant?.password ? '••••••••' : 'N/A'"></div>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <label class="text-xs font-semibold text-text-light uppercase tracking-wide">Position</label>
                    <div class="text-base font-semibold text-primary mt-1" x-text="selectedApplicant?.position || 'N/A'"></div>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <label class="text-xs font-semibold text-text-light uppercase tracking-wide">Status</label>
                    <div class="text-base font-semibold text-primary mt-1" x-text="selectedApplicant?.status || 'N/A'"></div>
                </div>
                <div class="p-4 bg-gray-50 rounded-xl">
                    <label class="text-xs font-semibold text-text-light uppercase tracking-wide">Contact Number</label>
                    <div class="text-base font-semibold text-primary mt-1" x-text="selectedApplicant?.contact_no || 'N/A'"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Applicant Modal -->
<div x-show="modalType === 'edit-applicant'" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
    <div class="absolute inset-0 bg-primary/40 backdrop-blur-md" @click="modalType = null"></div>
    <div class="relative bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl overflow-hidden">
        <div class="p-8 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-2xl font-black text-primary tracking-tight">Edit Applicant</h3>
            <button @click="modalType = null" class="p-2 hover:bg-bg rounded-full transition-colors"><i data-lucide="x" class="w-6 h-6"></i></button>
        </div>
        <div class="p-8 max-h-[85vh] overflow-y-auto">
            <form @submit.prevent="updateApplicantInfo" class="space-y-6" x-show="selectedApplicant">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Name</label>
                        <input type="text" x-model="selectedApplicant.name" 
                               class="w-full p-4 bg-bg rounded-2xl outline-none font-bold text-sm" required>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Email</label>
                        <input type="email" x-model="selectedApplicant.email" 
                               class="w-full p-4 bg-bg rounded-2xl outline-none font-bold text-sm" required>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Password</label>
                        <input type="password" x-model="selectedApplicant.password" 
                               class="w-full p-4 bg-bg rounded-2xl outline-none font-bold text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Contact Number</label>
                        <input type="tel" x-model="selectedApplicant.contact_no" 
                               class="w-full p-4 bg-bg rounded-2xl outline-none font-bold text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Position</label>
                    <input type="text" x-model="selectedApplicant.position" 
                           class="w-full p-4 bg-bg rounded-2xl outline-none font-bold text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Status</label>
                    <select x-model="selectedApplicant.status" 
                            class="w-full p-4 bg-bg rounded-2xl outline-none font-bold text-sm">
                        <option value="applied">Applied</option>
                        <option value="evaluating">Evaluating</option>
                        <option value="interviewing">Interviewing</option>
                        <option value="offered">Offered</option>
                        <option value="onboard">Onboard</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase shadow-xl">Update Applicant</button>
            </form>
        </div>
    </div>
</div>

<!-- Add Task Set Modal -->
<div x-show="modalType === 'add-task-set'" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
    <div class="absolute inset-0 bg-primary/40 backdrop-blur-md" @click="modalType = null"></div>
    <div class="relative bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl overflow-hidden">
        <div class="p-8 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-2xl font-black text-primary tracking-tight">Create Task Set</h3>
            <button @click="modalType = null" class="p-2 hover:bg-bg rounded-full transition-colors"><i data-lucide="x" class="w-6 h-6"></i></button>
        </div>
        <div class="p-8 max-h-[85vh] overflow-y-auto">
            <form @submit.prevent="createTaskSet" class="space-y-6">
                <div>
                    <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Task Set Name</label>
                    <input type="text" name="name" required placeholder="e.g., Medical License Requirements" 
                           class="w-full p-4 bg-bg rounded-2xl outline-none font-bold text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Tasks</label>
                    <div class="space-y-3" x-data="{ newTasks: [] }" x-init="newTasks = []">
                        <template x-for="(task, index) in newTasks" :key="index">
                            <div class="flex gap-2">
                                <input type="text" :name="'tasks[' + index + ']'" 
                                       x-model="task.title"
                                       placeholder="Task title" 
                                       class="flex-1 p-3 bg-bg rounded-xl outline-none font-bold text-sm">
                                <button type="button" @click="newTasks.splice(index, 1)" 
                                        class="p-3 text-red-600 hover:bg-red-50 rounded-xl">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="newTasks.push({title: ''})" 
                                class="w-full p-3 border-2 border-dashed border-gray-300 rounded-xl text-text-light hover:border-primary transition-colors">
                            <i class="bi bi-plus-circle"></i> Add Task
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase shadow-xl">Create Task Set</button>
            </form>
        </div>
    </div>
</div>

<!-- Create Form/Question Builder Modal -->
<div x-show="modalType === 'create-form'" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
    <div class="absolute inset-0 bg-primary/40 backdrop-blur-md" @click="modalType = null"></div>
    <div class="relative bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl overflow-hidden">
        <div class="p-8 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-2xl font-black text-primary tracking-tight">Create Assessment Form</h3>
            <button @click="modalType = null" class="p-2 hover:bg-bg rounded-full transition-colors"><i data-lucide="x" class="w-6 h-6"></i></button>
        </div>
        <div class="p-8 max-h-[85vh] overflow-y-auto">
            <form @submit.prevent="createForm" class="space-y-6">
                <div>
                    <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Form Title</label>
                    <input type="text" name="title" required placeholder="e.g., Technical Skills Assessment" 
                           class="w-full p-4 bg-bg rounded-2xl outline-none font-bold text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Questions</label>
                    <div class="space-y-3" x-data="{ newQuestions: [] }" x-init="newQuestions = []">
                        <template x-for="(question, index) in newQuestions" :key="index">
                            <div class="flex gap-2">
                                <input type="text" :name="'questions[' + index + '][text]'" 
                                       x-model="question.text"
                                       placeholder="Question text" 
                                       class="flex-1 p-3 bg-bg rounded-xl outline-none font-bold text-sm">
                                <select :name="'questions[' + index + '][type]'" x-model="question.type" class="p-3 bg-bg rounded-xl outline-none font-bold text-sm">
                                    <option value="text">Text</option>
                                    <option value="multiple-choice">Multiple Choice</option>
                                    <option value="rating">Rating</option>
                                </select>
                                <button type="button" @click="newQuestions.splice(index, 1)" 
                                        class="p-3 text-red-600 hover:bg-red-50 rounded-xl">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </template>
                        <button type="button" @click="newQuestions.push({text: '', type: 'text'})" 
                                class="w-full p-3 border-2 border-dashed border-gray-300 rounded-xl text-text-light hover:border-primary transition-colors">
                            <i class="bi bi-plus-circle"></i> Add Question
                        </button>
                    </div>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase shadow-xl">Create Form</button>
            </form>
        </div>
    </div>
</div>

<!-- Add Recognition Modal -->
<div x-show="modalType === 'add-recognition'" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
    <div class="absolute inset-0 bg-primary/40 backdrop-blur-md" @click="modalType = null"></div>
    <div class="relative bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl overflow-hidden">
        <div class="p-8 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-2xl font-black text-primary tracking-tight">Nominate Outstanding Candidate</h3>
            <button @click="modalType = null" class="p-2 hover:bg-bg rounded-full transition-colors"><i data-lucide="x" class="w-6 h-6"></i></button>
        </div>
        <div class="p-8 max-h-[85vh] overflow-y-auto">
            <form @submit.prevent="createRecognition" class="space-y-6">
                <div>
                    <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Candidate Name</label>
                    <select name="candidate_id" required class="w-full p-4 bg-bg rounded-2xl outline-none font-bold text-sm">
                        <option value="">Select Candidate</option>
                        <template x-for="applicant in applicants" :key="applicant.id">
                            <option :value="applicant.id" x-text="applicant.name"></option>
                        </template>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Position</label>
                    <input type="text" name="position" placeholder="Candidate position" 
                           class="w-full p-4 bg-bg rounded-2xl outline-none font-bold text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Description</label>
                    <textarea name="description" rows="4" placeholder="Why is this candidate outstanding?" 
                              class="w-full p-4 bg-bg rounded-2xl outline-none font-bold text-sm"></textarea>
                </div>
                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_most_outstanding" value="1" 
                               class="w-4 h-4 text-primary rounded">
                        <span class="text-sm font-semibold text-primary">Mark as Most Outstanding</span>
                    </label>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase shadow-xl">Post Recognition</button>
            </form>
        </div>
    </div>
</div>

<!-- Edit Recognition Modal -->
<div x-show="modalType === 'edit-recognition'" class="fixed inset-0 z-[100] flex items-center justify-center p-4" style="display: none;">
    <div class="absolute inset-0 bg-primary/40 backdrop-blur-md" @click="modalType = null"></div>
    <div class="relative bg-white w-full max-w-4xl rounded-[2.5rem] shadow-2xl overflow-hidden">
        <div class="p-8 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-2xl font-black text-primary tracking-tight">Edit Recognition</h3>
            <button @click="modalType = null" class="p-2 hover:bg-bg rounded-full transition-colors"><i data-lucide="x" class="w-6 h-6"></i></button>
        </div>
        <div class="p-8 max-h-[85vh] overflow-y-auto" x-show="editingRecognition">
            <form @submit.prevent="updateRecognition" class="space-y-6">
                <div>
                    <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Candidate Name</label>
                    <input type="text" x-model="editingRecognition.candidate_name" 
                           class="w-full p-4 bg-bg rounded-2xl outline-none font-bold text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Position</label>
                    <input type="text" x-model="editingRecognition.position" 
                           class="w-full p-4 bg-bg rounded-2xl outline-none font-bold text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-text-light uppercase tracking-wide mb-2">Description</label>
                    <textarea x-model="editingRecognition.description" rows="4" 
                              class="w-full p-4 bg-bg rounded-2xl outline-none font-bold text-sm"></textarea>
                </div>
                <div>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" x-model="editingRecognition.is_most_outstanding" 
                               class="w-4 h-4 text-primary rounded">
                        <span class="text-sm font-semibold text-primary">Mark as Most Outstanding</span>
                    </label>
                </div>
                <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xs uppercase shadow-xl">Update Recognition</button>
            </form>
        </div>
    </div>
</div>

