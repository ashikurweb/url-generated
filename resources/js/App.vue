<template>
  <div class="min-h-screen bg-slate-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="md:flex md:items-center md:justify-between mb-8">
        <div class="flex-1 min-w-0">
          <h1 class="text-3xl font-bold leading-7 text-slate-900 sm:text-4xl sm:truncate tracking-tight">
            URL Shortener
          </h1>
          <p class="mt-1 text-sm text-slate-500">
            Manage and track your shortened URLs.
          </p>
        </div>
        <div class="mt-4 flex md:mt-0 md:ml-4">
          <button
            @click="showModal = true"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
          >
            Create Short URL
          </button>
        </div>
      </div>

      <!-- Dashboard Stats -->
      <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200 p-6">
          <dt class="text-sm font-medium text-slate-500 truncate">Total Links</dt>
          <dd class="mt-1 text-3xl font-bold text-slate-900">{{ urls.length }}</dd>
        </div>
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200 p-6">
          <dt class="text-sm font-medium text-slate-500 truncate">Total Clicks</dt>
          <dd class="mt-1 text-3xl font-bold text-slate-900">{{ totalClicks }}</dd>
        </div>
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-slate-200 p-6">
          <dt class="text-sm font-medium text-slate-500 truncate">Active Links</dt>
          <dd class="mt-1 text-3xl font-bold text-green-600">{{ activeLinks }}</dd>
        </div>
      </div>

      <!-- Table Section -->
      <div class="bg-white shadow-sm rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
              <tr>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Main URL</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Short URL</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Clicks</th>
                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
              <tr v-for="url in urls" :key="url.id" class="hover:bg-slate-50 transition-colors duration-150">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm text-slate-900 font-medium max-w-xs truncate" :title="url.original_url">
                    {{ url.original_url }}
                  </div>
                  <div class="text-xs text-slate-500" v-if="url.description">{{ url.description }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center space-x-2">
                    <span class="text-sm font-mono text-indigo-600 font-semibold">{{ getShortUrl(url.short_code) }}</span>
                    <button @click="copyToClipboard(getShortUrl(url.short_code))" class="text-slate-400 hover:text-indigo-600 p-1 rounded-md hover:bg-indigo-50 transition-all duration-200" title="Copy">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                      </svg>
                    </button>
                    <a :href="'/' + url.short_code" target="_blank" class="text-slate-400 hover:text-indigo-600 p-1 rounded-md hover:bg-indigo-50 transition-all duration-200">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                      </svg>
                    </a>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    {{ url.clicks }} clicks
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <button 
                    @click="toggleEnabled(url)"
                    :class="[
                      url.is_enabled ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-slate-100 text-slate-800 hover:bg-slate-200',
                      'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors duration-200'
                    ]"
                  >
                    {{ url.is_enabled ? 'Enabled' : 'Disabled' }}
                  </button>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  <button @click="deleteUrl(url.id)" class="text-red-400 hover:text-red-700 p-1 rounded-md hover:bg-red-50 transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </button>
                </td>
              </tr>
              <tr v-if="urls.length === 0">
                <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                  <div class="flex flex-col items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    <span class="text-lg font-medium text-slate-900">No URLs found</span>
                    <p class="mt-1">Get started by creating your first shortened URL.</p>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Create Modal -->
    <div v-if="showModal" class="fixed inset-0 z-10 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-slate-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <div class="inline-block align-bottom bg-white rounded-2xl px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6 border border-slate-200">
          <div>
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
              </svg>
            </div>
            <div class="mt-3 text-center sm:mt-5">
              <h3 class="text-xl leading-6 font-bold text-slate-900" id="modal-title">
                Create Short URL
              </h3>
            </div>
          </div>
          <form @submit.prevent="createUrl" class="mt-6 space-y-4">
            <div>
              <label for="original_url" class="block text-sm font-semibold text-slate-700">Original URL</label>
              <input 
                v-model="form.original_url" 
                type="url" 
                id="original_url" 
                required 
                class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border"
                placeholder="https://example.com/very-long-url"
              >
              <p v-if="errors.original_url" class="mt-1 text-sm text-red-600">{{ errors.original_url[0] }}</p>
            </div>
            <div>
              <label for="short_code" class="block text-sm font-semibold text-slate-700">Short Code (Optional)</label>
              <input 
                v-model="form.short_code" 
                type="text" 
                id="short_code" 
                class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border"
                placeholder="my-custom-url"
              >
              <p v-if="errors.short_code" class="mt-1 text-sm text-red-600">{{ errors.short_code[0] }}</p>
            </div>
            <div>
              <label for="description" class="block text-sm font-semibold text-slate-700">Description (Optional)</label>
              <input 
                v-model="form.description" 
                type="text" 
                id="description" 
                class="mt-1 block w-full border-slate-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm p-2.5 border"
                placeholder="Product page link"
              >
            </div>
            <div class="mt-5 sm:mt-6 sm:grid sm:grid-cols-2 sm:gap-3 sm:flow-row-dense">
              <button
                type="submit"
                :disabled="loading"
                class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:col-start-2 sm:text-sm transition-all duration-200 disabled:opacity-50"
              >
                {{ loading ? 'Creating...' : 'Create' }}
              </button>
              <button
                type="button"
                @click="showModal = false"
                class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:col-start-1 sm:text-sm transition-all duration-200"
              >
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <!-- Toast (Simple implementation) -->
    <div v-if="toast" class="fixed bottom-5 right-5 bg-slate-900 text-white px-6 py-3 rounded-xl shadow-2xl transition-all duration-300 transform translate-y-0 z-50 flex items-center space-x-2">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
      <span>{{ toast }}</span>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const urls = ref([]);
const showModal = ref(false);
const loading = ref(false);
const toast = ref('');
const errors = ref({});

const form = ref({
  original_url: '',
  short_code: '',
  description: ''
});

const totalClicks = computed(() => {
  return urls.value.reduce((acc, url) => acc + url.clicks, 0);
});

const activeLinks = computed(() => {
  return urls.value.filter(url => url.is_enabled).length;
});

const fetchUrls = async () => {
  try {
    const response = await axios.get('/api/urls');
    urls.value = response.data;
  } catch (error) {
    console.error('Error fetching URLs:', error);
  }
};

const createUrl = async () => {
  loading.value = true;
  errors.value = {};
  try {
    const response = await axios.post('/api/urls', form.value);
    urls.value.unshift(response.data);
    showModal.value = false;
    form.value = { original_url: '', short_code: '', description: '' };
    showToast('Short URL created successfully!');
  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors;
    } else {
      showToast('Error creating URL');
    }
  } finally {
    loading.value = false;
  }
};

const toggleEnabled = async (url) => {
  try {
    const response = await axios.patch(`/api/urls/${url.id}`, {
      is_enabled: !url.is_enabled
    });
    const index = urls.value.findIndex(u => u.id === url.id);
    urls.value[index] = response.data;
    showToast(`URL ${url.is_enabled ? 'disabled' : 'enabled'} successfully`);
  } catch (error) {
    showToast('Error updating URL');
  }
};

const deleteUrl = async (id) => {
  if (!confirm('Are you sure you want to delete this URL?')) return;
  try {
    await axios.delete(`/api/urls/${id}`);
    urls.value = urls.value.filter(url => url.id !== id);
    showToast('URL deleted successfully');
  } catch (error) {
    showToast('Error deleting URL');
  }
};

const copyToClipboard = (text) => {
  navigator.clipboard.writeText(text);
  showToast('Copied to clipboard!');
};

const showToast = (message) => {
  toast.value = message;
  setTimeout(() => {
    toast.value = '';
  }, 3000);
};

const getShortUrl = (code) => {
  return window.location.origin + '/' + code;
};

onMounted(fetchUrls);
</script>

<style>
/* Custom transitions for Tailwind v4 if needed, 
   but v4 has great built-in utilities */
</style>
