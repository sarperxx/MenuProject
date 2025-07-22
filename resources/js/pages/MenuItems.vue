<template>
  <div class="px-4 md:px-8 py-6">
    <h1 class="text-2xl font-bold mb-4">Menu Items</h1>
    <div class="flex flex-wrap items-center gap-2 mb-4">
      <button v-if="user && user.is_admin" class="px-4 py-2 bg-blue-600 text-white rounded" @click="openAddForm">Add Menu Item</button>
      <input v-model="search" @keyup.enter="fetchMenuItems(1)" type="text" placeholder="Search..." class="border rounded px-3 py-2" />
      <button class="px-3 py-2 bg-gray-200 rounded" @click="fetchMenuItems(1)">Search</button>
      <select v-model="categoryFilter" @change="fetchMenuItems(1)" class="border rounded px-3 py-2">
        <option value="">All Categories</option>
        <option v-for="cat in categories" :key="(cat as any).id" :value="(cat as any).id">{{ (cat as any).name }}</option>
      </select>
      <h3>Filter by Allergens</h3>
    <div v-for="allergen in allergens" :key="(allergen as any).id" class="inline-block mr-4">
      <label>
        <input 
          type="checkbox" 
          :value="allergen.id" 
          v-model="includedAllergens"
          @change="fetchMenuItems(1)"
        />
        {{ allergen.name }}
      </label>
    </div>
    </div>
    <div v-if="loading" class="text-center">Loading...</div>
    <div v-if="!loading && items.length === 0" class="text-center">No menu items found.</div> 
    <div v-else>
      <div v-if="items.length === 0">No menu items found.</div>
      <div v-else class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        <div v-for="item in items" :key="(item as any).id" class="border rounded-lg p-3 bg-white shadow-sm flex flex-col items-center">
          <img v-if="item.image" :src="item.image.startsWith('http') ? item.image : $page.props.asset_url + item.image" alt="Image" class="w-24 h-24 object-cover rounded mb-2" />
          <div class="w-full text-center">
            <div class="font-semibold text-lg">{{ (item as any).name }}</div>
            <div class="text-gray-600 text-sm mb-1">{{ (item as any).description }}</div>
            <div v-if="item.category" class="text-xs text-blue-700 font-semibold mb-1">{{ (item.category as any).name }}</div>
            <div class="text-green-700 font-bold text-base mb-2">${{ (item as any).price }}</div>
          </div>
            <div class="text-xs text-red-600 font-semibold mb-1">
            Allergens:
            <span v-if="item.allergens.length === 0">None</span>
            <span v-else>{{ item.allergens.map((a: any) => a.name).join(', ') }}</span>
            </div>
          <div v-if="user && user.is_admin" class="flex gap-2 mt-2">
            <button class="px-3 py-1 bg-yellow-500 text-white rounded" @click="openEditForm(item)">Edit</button>
            <button class="px-3 py-1 bg-red-600 text-white rounded" @click="confirmDelete(item)">Delete</button>
          </div>
        </div>
      </div>
      <!-- Pagination Controls -->
      <div v-if="pagination.last_page > 1" class="flex gap-2 mt-6 justify-center items-center">
        <button :disabled="pagination.current_page === 1" @click="fetchMenuItems(pagination.current_page - 1)" class="px-3 py-1 rounded border" >Prev</button>
        <span>Page {{ pagination.current_page }} of {{ pagination.last_page }}</span>
        <button :disabled="pagination.current_page === pagination.last_page" @click="fetchMenuItems(pagination.current_page + 1)" class="px-3 py-1 rounded border">Next</button>
      </div>
    </div>

    <!-- Add/Edit Menu Item Modal -->
    <div v-if="showForm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
      <div class="bg-white rounded shadow-lg p-6 w-full max-w-md relative">
        <button class="absolute top-2 right-2 text-gray-500 hover:text-black" @click="closeForm">&times;</button>
        <h2 class="text-xl font-bold mb-4">{{ isEdit ? 'Edit' : 'Add' }} Menu Item</h2>
        <form @submit.prevent="submitForm" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="block mb-1 font-medium">Name</label>
            <input v-model="form.name" type="text" class="w-full border rounded px-3 py-2" />
            <div v-if="errors.name" class="text-red-600 text-sm mt-1">{{ errors.name }}</div>
          </div>
          <div class="mb-3">
            <label class="block mb-1 font-medium">Description</label>
            <textarea v-model="form.description" class="w-full border rounded px-3 py-2"></textarea>
            <div v-if="errors.description" class="text-red-600 text-sm mt-1">{{ errors.description }}</div>
          </div>
          <div class="mb-3">
            <label class="block mb-1 font-medium">Price</label>
            <input v-model="form.price" type="number" step="0.01" class="w-full border rounded px-3 py-2" />
            <div v-if="errors.price" class="text-red-600 text-sm mt-1">{{ errors.price }}</div>
          </div>
          <div class="mb-3">
            <label class="block mb-1 font-medium">Category</label>
            <select v-model="form.category_id" class="w-full border rounded px-3 py-2">
              <option value="">Select category</option>
              <option v-for="cat in categories" :key="(cat as any).id" :value="(cat as any).id">{{ (cat as any).name }}</option>
            </select>
            <div v-if="errors.category_id" class="text-red-600 text-sm mt-1">{{ errors.category_id }}</div>
          </div>
          <div class="mb-3">
          <label class="block mb-1 font-medium">Allergens</label>
          <div class="flex flex-wrap gap-2">
            <label
              v-for="allergen in allergens"
              :key="(allergen as any).id"
              class="flex items-center gap-1"
            >
              <input
                type="checkbox"
                :value="allergen.id"
                v-model="form.allergens"
              />
              {{ allergen.name }}
            </label>
          </div>
          <div v-if="errors.allergens" class="text-red-600 text-sm mt-1">{{ errors.allergens }}</div>
        </div>
          <div class="mb-3">
            <label class="block mb-1 font-medium">Image</label>
            <input type="file" @change="onFileChange" accept="image/*" class="w-full border rounded px-3 py-2" />
            <div v-if="form.image && typeof form.image === 'string'" class="mt-2">
              <img :src="form.image.startsWith('http') ? form.image : $page.props.asset_url + form.image" alt="Preview" class="w-20 h-20 object-cover rounded" />
            </div>
            <div v-if="errors.image" class="text-red-600 text-sm mt-1">{{ errors.image }}</div>
          </div>
          <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded" :disabled="submitting">
            {{ submitting ? (isEdit ? 'Saving...' : 'Adding...') : (isEdit ? 'Save Changes' : 'Add Item') }}
          </button>
        </form>
      </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteConfirm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
      <div class="bg-white rounded shadow-lg p-6 w-full max-w-sm relative">
        <button class="absolute top-2 right-2 text-gray-500 hover:text-black" @click="showDeleteConfirm = false">&times;</button>
        <h2 class="text-xl font-bold mb-4">Delete Menu Item</h2>
        <p>Are you sure you want to delete <span class="font-semibold">{{ itemToDelete?.name }}</span>?</p>
        <div class="mt-6 flex justify-end gap-2">
          <button class="px-4 py-2 bg-gray-300 rounded" @click="showDeleteConfirm = false">Cancel</button>
          <button class="px-4 py-2 bg-red-600 text-white rounded" @click="deleteItem" :disabled="deleting">{{ deleting ? 'Deleting...' : 'Delete' }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
import { ref, onMounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

const page = usePage();
interface UserWithAdmin {
  is_admin?: boolean;
  [key: string]: any;
}
const user = page.props.auth?.user as UserWithAdmin | undefined;

const items = ref<any[]>([]);
const loading = ref(true);
const showForm = ref(false);
const isEdit = ref(false);
const submitting = ref(false);
interface MenuItemForm {
  name: string;
  description: string;
  price: string;
  image: string | File;
  category_id: string;
  allergens: number[];
}
const form = ref<MenuItemForm>({
  name: '',
  description: '',
  price: '',
  image: '',
  category_id: '',
  allergens: [],
});
const errors = ref<Record<string, string>>({});
const editId = ref<number|null>(null);

const categories = ref<any[]>([]);
const categoryFilter = ref('');
const includedAllergens = ref<number[]>([])
const allergens = ref<any[]>([])
const showDeleteConfirm = ref(false);
interface MenuItem {
  id: number;
  name: string;
  description: string;
  price: string;
  image: string;
  category_id: string;
  allergens: { id: number; name: string }[];
}
const itemToDelete = ref<MenuItem | null>(null);
const deleting = ref(false);

const search = ref('');
const pagination = ref<any>({
  current_page: 1,
  last_page: 1,
  per_page: 10,
  total: 0,
});

const fetchMenuItems = async (pageNum = 1) => {
  loading.value = true;
  try {
    const params = new URLSearchParams();
    params.append('page', pageNum);
    params.append('per_page', pagination.value.per_page);
    if (search.value) params.append('search', search.value);
    if (categoryFilter.value) params.append('category_id', categoryFilter.value);
    params.append('with', 'allergens,category'); 
    includedAllergens.value.forEach(id => {
    params.append('excluded_allergens[]', id);
});
    const res = await fetch(`/api/menu-items?${params.toString()}`,
      {
        credentials: 'include'
      }
    );
    const data = await res.json();
    items.value = data.data;
    pagination.value.current_page = data.current_page;
    pagination.value.last_page = data.last_page;
    pagination.value.per_page = data.per_page;
    pagination.value.total = data.total;
  } catch (e) {
    items.value = [];
  } finally {
    loading.value = false;
  }
};

const fetchCategories = async () => {
  try {
    const res = await fetch('/api/categories', { credentials: 'include' });
    categories.value = await res.json();
  } catch (e) {
    categories.value = [];
  }
};

const fetchAllergens = async () => {
  try {
    const res = await fetch('/api/allergens', { credentials: 'include' });
    allergens.value = await res.json();
  } catch (e) {
    allergens.value = [];
  }
};


const openAddForm = () => {
  showForm.value = true;
  isEdit.value = false;
  form.value = { name: '', description: '', price: '', image: '', category_id: '', allergens: [] };
  errors.value = {};
  editId.value = null;
};

const openEditForm = (item: MenuItem) => {
  showForm.value = true;
  isEdit.value = true;

  form.value = {
    name: item.name,
    description: item.description,
    price: item.price,
    image: item.image,
    category_id: item.category_id || '',
    allergens: item.allergens?.map(a => a.id) || [], // ✅ BU SATIRI EKLE
  };

  errors.value = {};
  editId.value = item.id;
};

const closeForm = () => {
  showForm.value = false;
  form.value = { name: '', description: '', price: '', image: '', category_id: '', allergens: [] };
  errors.value = {};
  editId.value = null;
};

const onFileChange = (e) => {
  const file = e.target.files[0];
  if (file) {
    form.value.image = file;
  }
};

// Helper to get a cookie value by name
function getCookie(name: string) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) return decodeURIComponent(parts.pop().split(';').shift());
  return '';
}

// Track if CSRF cookie has been set
const csrfReady = ref(false);
const ensureCsrf = async () => {
  if (!csrfReady.value) {
    await fetch('/sanctum/csrf-cookie', { credentials: 'include' });
    csrfReady.value = true;
  }
};

const submitForm = async () => {
  submitting.value = true;
  errors.value = {};
  try {
    await ensureCsrf(); // Ensure CSRF cookie is set before POST/PUT
    let res;
    const formData = new FormData();
    formData.append('name', String(form.value.name ?? ''));
    formData.append('description', String(form.value.description ?? ''));
    formData.append('price', String(form.value.price ?? ''));
    formData.append('category_id', String(form.value.category_id ?? ''));
    (form.value.allergens || []).forEach(id => {
      formData.append('allergens[]', (id !== undefined && id !== null) ? String(id) : '');
    });
    if (form.value.image && typeof form.value.image === 'object' && 'name' in form.value.image && 'size' in form.value.image && 'type' in form.value.image) {
      formData.append('image', form.value.image);
    } else if (typeof form.value.image === 'string' && form.value.image) {
      formData.append('image', form.value.image);
    }
    if (isEdit.value && editId.value) {
      res = await fetch(`/api/menu-items/${editId.value}`, {
        method: 'POST', // Use POST with _method=PUT for Laravel
        headers: {
          'Accept': 'application/json',
          'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
        },
        body: (() => { formData.append('_method', 'PUT'); return formData; })(),
        credentials: 'include',
      });
    } else {
      res = await fetch('/api/menu-items', {
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
        },
        body: formData,
        credentials: 'include',
      });
    }
    if (res.ok) {
      closeForm();
      await fetchMenuItems();
    } else if (res.status === 422) {
      const data = await res.json();
      errors.value = data.errors || {};
    } else {
      alert('Failed to save menu item.');
    }
  } catch (e) {
    alert('Failed to save menu item.');
  } finally {
    submitting.value = false;
  }
};

const confirmDelete = (item: any) => {
  itemToDelete.value = item;
  showDeleteConfirm.value = true;
};

const deleteItem = async () => {
  if (!itemToDelete.value) return;
  deleting.value = true;
  try {
    await ensureCsrf(); // Ensure CSRF cookie is set before DELETE
    const res = await fetch(`/api/menu-items/${itemToDelete.value.id}`, {
      method: 'DELETE',
      headers: {
        'Accept': 'application/json',
        'X-XSRF-TOKEN': getCookie('XSRF-TOKEN')
      },
      credentials: 'include',
    });
    if (res.ok) {
      showDeleteConfirm.value = false;
      itemToDelete.value = null;
      await fetchMenuItems();
    } else {
      alert('Failed to delete menu item.');
    }
  } catch (e) {
    alert('Failed to delete menu item.');
  } finally {
    deleting.value = false;
  }
};

onMounted(() => {
  fetchMenuItems(1);
  fetchCategories();
  fetchAllergens(); 
});
</script>

<style scoped>
</style>  