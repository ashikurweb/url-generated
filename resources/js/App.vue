<template>
  <div class="min-h-screen font-sans selection:bg-indigo-100 selection:text-indigo-700 transition-colors duration-500">
    <div class="min-h-screen bg-[#fcfcfc] dark:bg-[#080a11] text-slate-900 dark:text-slate-100 transition-colors duration-500">
      <!-- Header/Navigation -->
      <nav class="sticky top-0 z-40 bg-white/70 dark:bg-slate-900/70 backdrop-blur-md border-b border-slate-100 dark:border-slate-800/50 transition-colors">
        <div class="max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-12">
          <div class="flex justify-between items-center h-16">
            <div class="flex items-center space-x-3">
              <a href="/" class="flex items-center gap-3">
                <img :src="logo" alt="LinkFlow Logo" class="h-10 w-auto object-contain" />
              </a>
            </div>
            
            <div class="flex items-center space-x-3">
              <!-- Dark Mode Toggle -->
              <button 
                @click="toggleTheme" 
                class="p-2 rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all duration-200"
                title="Toggle Theme"
              >
                <svg v-if="!isDark" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
              </button>

              <button
                @click="openModal"
                class="inline-flex items-center space-x-2 px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-all duration-200 active:scale-95 shadow-sm"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>New Link</span>
              </button>
            </div>
          </div>
        </div>
      </nav>

      <main class="max-w-[1440px] mx-auto px-6 sm:px-10 lg:px-12 py-12">
        <!-- Welcome Header -->
        <div class="mb-10">
          <h2 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-1">
            Dashboard
          </h2>
          <p class="text-slate-500 dark:text-slate-400 font-medium text-sm">
            Overview of your shortened link assets and engagement metrics.
          </p>
        </div>

        <!-- Modern Glass Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
          <!-- Active Links -->
          <div class="group relative overflow-hidden bg-white/60 dark:bg-slate-900/40 backdrop-blur-2xl border border-white/20 dark:border-slate-800/50 rounded-[3rem] p-8 shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 hover:scale-[1.01]">
            <div class="absolute inset-0 bg-gradient-to-br from-indigo-500/5 via-transparent to-transparent opacity-100"></div>
            <div class="relative flex items-start justify-between">
              <div class="card-icon-float w-24 h-24 bg-indigo-500/10 dark:bg-indigo-500/20 text-indigo-600 dark:text-indigo-400 rounded-3xl flex items-center justify-center backdrop-blur-md border border-indigo-500/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
              </div>
              <div class="flex flex-col items-end">
                <span class="mb-4 text-[10px] font-black text-indigo-500 dark:text-indigo-400 uppercase tracking-widest bg-indigo-50 dark:bg-indigo-900/30 px-4 py-1.5 rounded-full border border-indigo-500/10">Active Now</span>
                <div class="text-right">
                  <dd class="text-7xl font-black text-slate-900 dark:text-white tracking-tighter leading-none tabular-nums">{{ Math.round(displayMetrics.count) }}</dd>
                  <dt class="mt-2 text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.25em]">Shortened Links</dt>
                </div>
              </div>
            </div>
          </div>

          <!-- Total Engagement -->
          <div class="group relative overflow-hidden bg-white/60 dark:bg-slate-900/40 backdrop-blur-2xl border border-white/20 dark:border-slate-800/50 rounded-[3rem] p-8 shadow-2xl hover:shadow-emerald-500/10 transition-all duration-500 hover:scale-[1.01]">
            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 via-transparent to-transparent opacity-100"></div>
            <div class="relative flex items-start justify-between">
              <div class="card-icon-float w-24 h-24 bg-emerald-500/10 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 rounded-3xl flex items-center justify-center backdrop-blur-md border border-emerald-500/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </div>
              <div class="flex flex-col items-end">
                <span class="mb-4 text-[10px] font-black text-emerald-500 dark:text-emerald-400 uppercase tracking-widest bg-emerald-50 dark:bg-emerald-900/30 px-4 py-1.5 rounded-full border border-emerald-500/10">Global Reach</span>
                <div class="text-right">
                  <dd class="text-7xl font-black text-slate-900 dark:text-white tracking-tighter leading-none tabular-nums">{{ Math.round(displayMetrics.clicks) }}</dd>
                  <dt class="mt-2 text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.25em]">Total Engagement</dt>
                </div>
              </div>
            </div>
          </div>

          <!-- Efficiency/Top Perform -->
          <div class="group relative overflow-hidden bg-white/60 dark:bg-slate-900/40 backdrop-blur-2xl border border-white/20 dark:border-slate-800/50 rounded-[3rem] p-8 shadow-2xl hover:shadow-amber-500/10 transition-all duration-500 hover:scale-[1.01]">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/5 via-transparent to-transparent opacity-100"></div>
            <div class="relative flex items-start justify-between">
              <div class="card-icon-float w-24 h-24 bg-amber-500/10 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-3xl flex items-center justify-center backdrop-blur-md border border-amber-500/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
              </div>
              <div class="flex flex-col items-end">
                <span class="mb-4 text-[10px] font-black text-amber-500 dark:text-amber-400 uppercase tracking-widest bg-amber-50 dark:bg-amber-900/30 px-4 py-1.5 rounded-full border border-amber-500/10">Top Perform: {{ topPerformingLink }}</span>
                <div class="text-right">
                  <dd class="text-7xl font-black text-slate-900 dark:text-white tracking-tighter leading-none tabular-nums">{{ displayMetrics.efficiency.toFixed(1) }}%</dd>
                  <dt class="mt-2 text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.25em]">Efficiency Index</dt>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Clean Data Table -->
        <div class="bg-white dark:bg-slate-900/50 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm overflow-hidden">
          <div class="px-6 py-4 border-b border-slate-50 dark:border-slate-800/50 flex items-center justify-between bg-slate-50/30 dark:bg-transparent">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white">Recent Links</h3>
            <span class="text-[10px] font-bold bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 px-2 py-0.5 rounded-md">
              {{ activeLinks }} LIVE
            </span>
          </div>
          
          <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
              <thead>
                <tr class="text-slate-400 dark:text-slate-500 border-b border-slate-50 dark:border-slate-800/50">
                  <th class="px-4 py-4 text-[10px] font-bold uppercase tracking-wider pl-6">Sl</th>
                  <th class="px-4 py-4 text-[10px] font-bold uppercase tracking-wider font-mono">url_id</th>
                  <th class="px-4 py-4 text-[10px] font-bold uppercase tracking-wider font-mono">long_url</th>
                  <th class="px-4 py-4 text-[10px] font-bold uppercase tracking-wider">generated_short_url</th>
                  <th class="px-4 py-4 text-[10px] font-bold uppercase tracking-wider font-mono">uid</th>
                  <th class="px-4 py-4 text-[10px] font-bold uppercase tracking-wider">status</th>
                  <th class="px-4 py-4 text-[10px] font-bold uppercase tracking-wider font-mono">expires_at</th>
                  <th class="px-4 py-4 text-[10px] font-bold uppercase tracking-wider text-right pr-8">action</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-slate-50 dark:divide-slate-800/40">
                <tr v-for="(url, index) in urls" :key="url.id" class="group hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                  <td class="px-4 py-5 pl-6 text-[11px] font-bold text-slate-400 dark:text-slate-500">
                    {{ (pagination.current_page - 1) * pagination.per_page + index + 1 }}
                  </td>
                  <td class="px-4 py-5">
                    <span class="text-[13px] font-semibold text-indigo-600 dark:text-indigo-400 font-mono">{{ url.url_id }}</span>
                  </td>
                  <td class="px-4 py-5">
                    <div class="max-w-[150px] sm:max-w-xs">
                      <div class="text-sm font-semibold text-slate-900 dark:text-slate-100 truncate" :title="url.long_url">
                        {{ url.long_url }}
                      </div>
                      <div class="text-[10px] text-slate-400 dark:text-slate-500 font-medium truncate mt-0.5" v-if="url.description">{{ url.description }}</div>
                    </div>
                  </td>
                  <td class="px-4 py-5">
                    <div class="flex items-center space-x-2">
                      <span class="text-[12px] font-medium text-slate-600 dark:text-slate-400 font-mono truncate max-w-[120px]">{{ getShortUrl(url.url_id) }}</span>
                      <button @click="copyToClipboard(getShortUrl(url.url_id))" class="p-1.5 text-slate-300 hover:text-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-md transition-colors" title="Copy">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                        </svg>
                      </button>
                    </div>
                  </td>
                  <td class="px-4 py-5">
                    <span class="text-[11px] font-medium text-slate-400 dark:text-slate-500 font-mono">{{ url.uid }}</span>
                  </td>
                  <td class="px-4 py-5">
                    <button 
                      @click="toggleEnabled(url)"
                      :class="[
                        url.is_enabled ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400',
                        'px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase transition-colors'
                      ]"
                    >
                      {{ url.is_enabled ? 'Active' : 'Paused' }}
                    </button>
                  </td>
                  <td class="px-4 py-5">
                    <span class="text-[11px] font-medium text-slate-400 dark:text-slate-500 font-mono">
                      {{ url.expires_at ? formatDate(url.expires_at) : 'Never' }}
                    </span>
                  </td>
                  <td class="px-4 py-5 text-right pr-8">
                    <div class="flex items-center justify-end space-x-2">
                      <button @click="openPreview(url)" class="p-1.5 text-slate-300 hover:text-indigo-500 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-md transition-colors" title="Live Preview">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                      </button>
                      <button @click="openEditModal(url)" class="p-1.5 text-slate-300 hover:text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded-md transition-colors" title="Edit">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                      </button>
                      <button @click="deleteUrl(url.id)" class="p-1.5 text-slate-300 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 rounded-md transition-colors" title="Delete">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                      </button>
                    </div>
                  </td>
                </tr>
                <tr v-if="urls.length === 0">
                  <td colspan="8" class="px-6 py-24 text-center">
                    <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                      <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800/50 rounded-full flex items-center justify-center mb-4 text-slate-300 dark:text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                        </svg>
                      </div>
                      <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1">No links yet</h4>
                      <p class="text-xs text-slate-400 dark:text-slate-500 font-medium leading-relaxed">Create your first shortened link to see analytics here.</p>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination Controls -->
          <div v-if="pagination.last_page > 1" class="px-6 py-4 bg-slate-50/30 dark:bg-slate-800/20 border-t border-slate-50 dark:border-slate-800/50 flex items-center justify-between">
            <p class="text-[11px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
              Showing {{ (pagination.current_page - 1) * pagination.per_page + 1 }} to {{ Math.min(pagination.current_page * pagination.per_page, pagination.total) }} of {{ pagination.total }} entries
            </p>
            <div class="flex items-center space-x-2">
              <button 
                @click="fetchUrls(pagination.current_page - 1)" 
                :disabled="pagination.current_page === 1"
                class="p-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 disabled:opacity-40 disabled:cursor-not-allowed transition-all"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
              </button>
              <div class="flex items-center space-x-1">
                <template v-for="page in pagination.last_page" :key="page">
                  <button 
                    v-if="Math.abs(page - pagination.current_page) < 3 || page === 1 || page === pagination.last_page"
                    @click="fetchUrls(page)"
                    :class="[
                      pagination.current_page === page 
                        ? 'bg-indigo-600 text-white border-indigo-600' 
                        : 'bg-white dark:bg-slate-800 border-slate-100 dark:border-slate-700 text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700',
                      'w-8 h-8 rounded-lg text-xs font-bold border transition-all'
                    ]"
                  >
                    {{ page }}
                  </button>
                  <span v-else-if="Math.abs(page - pagination.current_page) === 3" class="text-slate-400 px-1">...</span>
                </template>
              </div>
              <button 
                @click="fetchUrls(pagination.current_page + 1)" 
                :disabled="pagination.current_page === pagination.last_page"
                class="p-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700 disabled:opacity-40 disabled:cursor-not-allowed transition-all"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </main>

      <!-- Minimalist Modal -->
      <Teleport to="body">
        <div v-if="showModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
          <div class="fixed inset-0 bg-slate-900/20 dark:bg-black/40 backdrop-blur-[2px] transition-opacity duration-300" @click="showModal = false"></div>

          <div class="relative bg-white dark:bg-slate-900 w-full max-w-lg rounded-[1.5rem] p-8 shadow-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300">
            <div class="mb-8">
              <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-1">Create Short Link</h3>
              <p class="text-xs text-slate-400 dark:text-slate-500 font-medium">Configure your destination and custom slug.</p>
            </div>

            <form @submit.prevent="createUrl" class="space-y-5">
              <div class="space-y-1.5">
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 ml-0.5">Destination URL</label>
                <input 
                  v-model="form.long_url" 
                  type="url" 
                  required 
                  class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all duration-200 text-sm font-medium text-slate-900 dark:text-white placeholder:text-slate-300 dark:placeholder:text-slate-600"
                  placeholder="https://example.com/very-long-url"
                >
                <p v-if="errors.long_url" class="text-[10px] font-bold text-rose-500 mt-1 ml-1">{{ errors.long_url[0] }}</p>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1.5">
                  <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 ml-0.5">Custom ID (Optional)</label>
                  <input 
                    v-model="form.url_id" 
                    type="text" 
                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all duration-200 text-sm font-semibold text-slate-900 dark:text-white placeholder:text-slate-300 dark:placeholder:text-slate-600"
                    placeholder="flash-sale"
                  >
                </div>
                <div class="space-y-1.5">
                  <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 ml-0.5">Expires At</label>
                  <input 
                    v-model="form.expires_at" 
                    type="datetime-local" 
                    class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all duration-200 text-sm font-medium text-slate-900 dark:text-white"
                  >
                </div>
              </div>

              <div class="space-y-1.5">
                <label class="block text-[10px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 ml-0.5">Description</label>
                <textarea 
                  v-model="form.description" 
                  rows="2"
                  class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 rounded-xl focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all duration-200 text-sm font-medium text-slate-900 dark:text-white placeholder:text-slate-300 dark:placeholder:text-slate-600 resize-none"
                  placeholder="Campaign or purpose notes..."
                ></textarea>
              </div>

              <div class="flex items-center space-x-3 pt-2">
                <button
                  type="button"
                  @click="showModal = false"
                  class="flex-1 py-3 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-sm font-bold rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-all duration-200"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  :disabled="loading"
                  class="flex-[2] py-3 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 transition-all duration-200 shadow-sm disabled:opacity-50 active:scale-95"
                >
                  {{ loading ? 'Creating...' : 'Generate link' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </Teleport>

      <!-- Edit URL Modal -->
      <Teleport to="body">
        <div v-if="showEditModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
          <div class="fixed inset-0 bg-slate-900/40 dark:bg-black/80 backdrop-blur-md transition-opacity duration-300" @click="showEditModal = false"></div>

          <div class="relative bg-white dark:bg-slate-900 w-full max-w-lg rounded-[2.5rem] p-8 shadow-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300">
            <div class="mb-8">
              <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-2">Edit Short Link</h3>
              <p class="text-xs text-slate-400 dark:text-slate-500 font-bold uppercase tracking-widest">Update your destination and configuration.</p>
            </div>

            <form @submit.prevent="updateUrl" class="space-y-6">
              <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Destination URL</label>
                <input 
                  v-model="editingUrl.long_url"
                  type="url" 
                  placeholder="https://example.com/very-long-link"
                  class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all dark:text-white text-sm font-medium"
                >
                <p v-if="errors.long_url" class="text-[10px] font-bold text-rose-500 mt-1 ml-1">{{ errors.long_url[0] }}</p>
              </div>

              <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                  <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Custom Slug</label>
                  <input 
                    v-model="editingUrl.url_id"
                    type="text" 
                    placeholder="my-link"
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all dark:text-white text-sm font-mono font-medium lowercase"
                  >
                  <p v-if="errors.url_id" class="text-[10px] font-bold text-rose-500 mt-1 ml-1">{{ errors.url_id[0] }}</p>
                </div>

                <div class="space-y-2">
                  <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Expires At</label>
                  <input 
                    v-model="editingUrl.expires_at"
                    type="datetime-local" 
                    class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all dark:text-white text-sm font-medium h-[54px]"
                  >
                </div>
              </div>

              <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest ml-1">Description (Optional)</label>
                <textarea 
                  v-model="editingUrl.description"
                  rows="2"
                  placeholder="What is this link for?"
                  class="w-full px-5 py-4 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800 rounded-2xl focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none transition-all dark:text-white text-sm font-medium resize-none"
                ></textarea>
              </div>

              <div class="flex items-center space-x-3 pt-4">
                <button 
                  type="button" 
                  @click="showEditModal = false"
                  class="flex-1 py-4 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-all duration-200"
                >
                  Cancel
                </button>
                <button 
                  type="submit" 
                  :disabled="loading"
                  class="flex-[2] py-4 bg-indigo-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-indigo-700 transition-all duration-200 shadow-xl shadow-indigo-500/20 disabled:opacity-50 active:scale-[0.98]"
                >
                  {{ loading ? 'Saving...' : 'Save Changes' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </Teleport>

      <!-- Delete Confirmation Modal -->
      <Teleport to="body">
        <div v-if="showDeleteModal" class="fixed inset-0 z-[120] flex items-center justify-center p-4">
          <div class="fixed inset-0 bg-slate-900/40 dark:bg-black/60 backdrop-blur-sm transition-opacity duration-300" @click="showDeleteModal = false"></div>

          <div class="relative bg-white dark:bg-slate-900 w-full max-w-sm rounded-2xl p-6 shadow-2xl border border-slate-100 dark:border-slate-800 transform transition-all duration-300 scale-100 opacity-100 text-center">
            <div class="w-12 h-12 bg-rose-50 dark:bg-rose-900/20 text-rose-600 dark:text-rose-400 rounded-full flex items-center justify-center mx-auto mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
            </div>
            <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2">Are you sure?</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mb-6">This action cannot be undone. This link will be permanently deleted from our database.</p>
            
            <div class="flex items-center space-x-3">
              <button
                @click="showDeleteModal = false"
                class="flex-1 py-2.5 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-bold rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-all duration-200"
              >
                No, Cancel
              </button>
              <button
                @click="confirmDelete"
                class="flex-1 py-2.5 bg-rose-600 text-white text-xs font-bold rounded-xl hover:bg-rose-700 transition-all duration-200 shadow-sm overflow-hidden group relative"
              >
                <span class="relative z-10">Yes, Delete</span>
                <div class="absolute inset-0 bg-rose-500 opacity-0 group-hover:opacity-100 transition-opacity"></div>
              </button>
            </div>
          </div>
        </div>
      </Teleport>

      <!-- Live Preview Modal -->
      <Teleport to="body">
        <div v-if="showPreviewModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4">
          <div class="fixed inset-0 bg-slate-900/40 dark:bg-black/80 backdrop-blur-md transition-opacity duration-300" @click="showPreviewModal = false"></div>

          <div class="relative bg-white dark:bg-slate-900 w-full max-w-lg rounded-[2.5rem] p-8 shadow-2xl border border-slate-100 dark:border-slate-800 transition-all duration-300 transform scale-100 opacity-100">
            <div class="absolute top-6 right-6">
              <button @click="showPreviewModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>

            <div class="text-center mb-8">
              <div class="w-20 h-20 bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 rounded-[1.5rem] flex items-center justify-center mx-auto mb-6 shadow-lg shadow-indigo-500/10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
              </div>
              <h3 class="text-2xl font-black text-slate-900 dark:text-white mb-2">Ready to Redirect?</h3>
              <p class="text-sm text-slate-500 dark:text-slate-400 font-medium max-w-xs mx-auto">You remain in control. Review the destination before proceeding live.</p>
            </div>

            <div class="space-y-4 bg-slate-50 dark:bg-slate-800/30 rounded-2xl p-6 border border-slate-100 dark:border-slate-800/50 mb-8">
              <div class="flex items-start justify-between group">
                <div class="min-w-0 flex-1 mr-4">
                  <p class="text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider mb-1">Destination URL</p>
                  <p class="text-sm font-semibold text-slate-700 dark:text-slate-200 truncate font-mono select-all">{{ previewUrl.long_url }}</p>
                </div>
                <button @click="copyToClipboard(previewUrl.long_url)" class="text-slate-300 hover:text-indigo-500 transition-colors" title="Copy">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                  </svg>
                </button>
              </div>
              <div class="w-full h-px bg-slate-200 dark:bg-slate-700/50"></div>
              <div class="flex items-start justify-between">
                <div>
                  <p class="text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider mb-1">Short Link</p>
                  <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400 font-mono">{{ getShortUrl(previewUrl.url_id) }}</p>
                </div>
                <div class="text-right">
                  <p class="text-[10px] uppercase font-bold text-slate-400 dark:text-slate-500 tracking-wider mb-1">Total Clicks</p>
                  <p class="text-sm font-black text-slate-900 dark:text-white tabular-nums">{{ previewUrl.click_count || 0 }}</p>
                </div>
              </div>
            </div>

            <div class="flex gap-4">
               <button 
                @click="showPreviewModal = false"
                class="flex-1 py-4 bg-white dark:bg-slate-800 text-slate-500 dark:text-slate-400 text-xs font-black uppercase tracking-widest rounded-2xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition-all duration-200"
              >
                Close
              </button>
              <a 
                :href="getShortUrl(previewUrl.url_id)" 
                target="_blank"
                class="flex-[2] py-4 bg-indigo-600 text-white text-xs font-black uppercase tracking-widest rounded-2xl hover:bg-indigo-700 transition-all duration-200 shadow-xl shadow-indigo-500/20 text-center flex items-center justify-center gap-2 group"
                @click="showPreviewModal = false"
              >
                <span>Visit Live Link</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
              </a>
            </div>
          </div>
        </div>
      </Teleport>

      <!-- Minimal Toast -->
      <div v-if="toast" class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[110] animate-in fade-in slide-in-from-bottom-2 duration-300">
        <div class="bg-slate-900 dark:bg-white text-white dark:text-slate-900 px-6 py-3 rounded-xl shadow-xl flex items-center space-x-2 border border-slate-800 dark:border-slate-200">
          <span class="text-xs font-bold">{{ toast }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, nextTick, watch } from 'vue';
import axios from 'axios';
import gsap from 'gsap';
import logo from '../images/linkflow_logo.png';

// State
const urls = ref([]);
const displayMetrics = ref({
  count: 0,
  clicks: 0,
  efficiency: 0
});
const pagination = ref({
  current_page: 1,
  last_page: 1,
  total: 0,
  per_page: 10
});
const showModal = ref(false);
const loading = ref(false);
const toast = ref('');
const errors = ref({});
const isDark = ref(localStorage.getItem('theme') === 'dark');
const showDeleteModal = ref(false);
const urlIdToDelete = ref(null);
const showEditModal = ref(false);
const editingUrl = ref(null);
const showPreviewModal = ref(false);
const previewUrl = ref({});

const form = ref({
  long_url: '',
  url_id: '',
  description: '',
  expires_at: ''
});

// Theme Management
const toggleTheme = () => {
  isDark.value = !isDark.value;
  localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
  if (isDark.value) {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
};

// Computed
const totalClicks = computed(() => {
  return urls.value.reduce((acc, url) => acc + (url.click_count || 0), 0);
});

const activeLinks = computed(() => {
  return urls.value.filter(url => url.is_enabled).length;
});

const efficiencyIndex = computed(() => {
  if (urls.value.length === 0) return '0.0';
  const engagementCount = urls.value.filter(u => u.click_count > 0).length;
  return ((engagementCount / urls.value.length) * 100).toFixed(1);
});

const topPerformingLink = computed(() => {
  if (urls.value.length === 0) return 'NONE';
  const top = [...urls.value].sort((a, b) => (b.click_count || 0) - (a.click_count || 0))[0];
  return top && top.click_count > 0 ? top.url_id : 'NEW';
});

// Utility Functions
const showToast = (message) => {
  toast.value = message;
  setTimeout(() => {
    toast.value = '';
  }, 3000);
};

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  const date = new Date(dateStr);
  const day = date.getDate();
  const monthNames = ["jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec"];
  const month = monthNames[date.getMonth()];
  const year = date.getFullYear();
  
  let hours = date.getHours();
  const minutes = date.getMinutes().toString().padStart(2, '0');
  const ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12; // true 0 becomes 12
  
  return `${day} ${month} ${year} ${hours}:${minutes} ${ampm}`;
};

const getShortUrl = (code) => {
  return window.location.origin + '/?url_id=' + code;
};

const copyToClipboard = (text) => {
  if (navigator.clipboard && window.isSecureContext) {
    navigator.clipboard.writeText(text);
    showToast('Copied to clipboard!');
  } else {
    // Fallback for non-secure contexts or older browsers
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.position = "fixed";
    textArea.style.left = "-999999px";
    textArea.style.top = "-999999px";
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    try {
      document.execCommand('copy');
      showToast('Copied to clipboard!');
    } catch (err) {
      console.error('Fallback copy failed', err);
      showToast('Failed to copy');
    }
    document.body.removeChild(textArea);
  }
};

// API Actions
const fetchUrls = async (page = 1) => {
  try {
    const response = await axios.get(`/api/urls?page=${page}`);
    urls.value = response.data.data;
    pagination.value = {
      current_page: response.data.current_page,
      last_page: response.data.last_page,
      total: response.data.total,
      per_page: response.data.per_page
    };
    // Re-trigger table animation on data change
    nextTick(() => {
      gsap.fromTo("table tbody tr", 
        { y: 20, opacity: 0 },
        { y: 0, opacity: 1, duration: 0.4, stagger: 0.05, ease: "power2.out", clearProps: "all" }
      );
    });
  } catch (error) {
    console.error('Error fetching URLs:', error);
    showToast('Failed to load URLs');
  }
};

const createUrl = async () => {
  loading.value = true;
  errors.value = {};
  try {
    const response = await axios.post('/api/urls', form.value);
    urls.value.unshift(response.data);
    showModal.value = false;
    form.value = { long_url: '', url_id: '', description: '', expires_at: '' };
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
    if (index !== -1) {
      urls.value[index] = response.data;
    }
    showToast(`URL ${url.is_enabled ? 'disabled' : 'enabled'} successfully`);
  } catch (error) {
    showToast('Error updating URL');
  }
};

const openEditModal = (url) => {
  editingUrl.value = { ...url }; 
  
  // Format expires_at for datetime-local input (YYYY-MM-DDTHH:mm)
  if (editingUrl.value.expires_at) {
    const date = new Date(editingUrl.value.expires_at);
    if (!isNaN(date.getTime())) {
      const pad = (n) => n.toString().padStart(2, '0');
      const formatted = `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
      editingUrl.value.expires_at = formatted;
    }
  }
  
  showEditModal.value = true;
};

const updateUrl = async () => {
  loading.value = true;
  errors.value = {};
  try {
    const response = await axios.put(`/api/urls/${editingUrl.value.id}`, editingUrl.value);
    const index = urls.value.findIndex(u => u.id === editingUrl.value.id);
    if (index !== -1) {
      urls.value[index] = response.data;
    }
    showToast('URL updated successfully');
    showEditModal.value = false;
  } catch (error) {
    if (error.response?.status === 422) {
      errors.value = error.response.data.errors;
    } else {
      showToast('Error updating URL');
    }
  } finally {
    loading.value = false;
  }
};

const deleteUrl = (id) => {
  urlIdToDelete.value = id;
  showDeleteModal.value = true;
};

const confirmDelete = async () => {
  if (!urlIdToDelete.value) return;
  try {
    await axios.delete(`/api/urls/${urlIdToDelete.value}`);
    urls.value = urls.value.filter(url => url.id !== urlIdToDelete.value);
    showToast('URL deleted successfully');
    showDeleteModal.value = false;
    urlIdToDelete.value = null;
  } catch (error) {
    showToast('Error deleting URL');
  }
};

const openModal = () => {
  errors.value = {};
  showModal.value = true;
};

const openPreview = (url) => {
  previewUrl.value = url;
  showPreviewModal.value = true;
};

onMounted(() => {
  fetchUrls();
  if (isDark.value) {
    document.documentElement.classList.add('dark');
  }

  // Icon Floating Animation
  gsap.to(".card-icon-float", {
    y: -8,
    duration: 2,
    repeat: -1,
    yoyo: true,
    ease: "sine.inOut",
    stagger: 0.2
  });
});

// Watchers for Number Animations
watch(urls, (newVal) => {
  gsap.to(displayMetrics.value, {
    count: newVal.length,
    duration: 1.5,
    ease: "power2.out"
  });
});

watch(totalClicks, (newVal) => {
  gsap.to(displayMetrics.value, {
    clicks: newVal,
    duration: 1.5,
    ease: "power2.out"
  });
});

watch(efficiencyIndex, (newVal) => {
  gsap.to(displayMetrics.value, {
    efficiency: parseFloat(newVal),
    duration: 1.5,
    ease: "power2.out"
  });
});
</script>

<style>
/* Custom transitions for Tailwind v4 */
.dark {
  color-scheme: dark;
}
</style>
