<template>
  <div class="px-4 md:px-8 py-6">
    <h1 class="text-2xl font-bold mb-4">Menu Items</h1>
    <div class="flex flex-wrap items-center gap-2 mb-4">
      <button v-if="user && user.is_admin" class="px-4 py-2 bg-blue-600 text-white rounded" @click="openAddForm">Add Menu Item</button>
      <!-- You can add search, filter, etc. here if you want -->
    </div>
    <div v-if="!props.items.data.length" class="text-center">No menu items found.</div>
    <div v-else class="grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
      <div v-for="item in props.items.data" :key="item.id" class="border rounded-lg p-3 bg-white shadow-sm flex flex-col items-center">
        <img v-if="item.image" :src="item.image" alt="Image" class="w-24 h-24 object-cover rounded mb-2" />
        <div class="w-full text-center">
          <div class="font-semibold text-lg">{{ item.name }}</div>
          <div class="text-gray-600 text-sm mb-1">{{ item.description }}</div>
          <div v-if="item.category" class="text-xs text-blue-700 font-semibold mb-1">{{ item.category.name }}</div>
          <div class="text-green-700 font-bold text-base mb-2">{{ item.price }}₺</div>
        </div>
        <div class="text-xs text-red-600 font-semibold mb-1">
          Allergens:
          <span v-if="!item.allergens.length">None</span>
          <span v-else>{{ item.allergens.map((a: any) => a.name).join(', ') }}</span>
        </div>
        <div v-if="user && user.is_admin" class="flex gap-2 mt-2">
          <button class="px-3 py-1 bg-yellow-500 text-white rounded" @click="openEditForm(item)">Edit</button>
          <button class="px-3 py-1 bg-red-600 text-white rounded" @click="confirmDelete(item)">Delete</button>
        </div>
      </div>
    </div>
    <!-- Pagination Controls -->
    <div v-if="props.items.last_page > 1" class="flex gap-2 mt-6 justify-center items-center">
      <button :disabled="props.items.current_page === 1" @click="$inertia.get(route('admin.menu-items'), { page: props.items.current_page - 1 })" class="px-3 py-1 rounded border">Prev</button>
      <span>Page {{ props.items.current_page }} of {{ props.items.last_page }}</span>
      <button :disabled="props.items.current_page === props.items.last_page" @click="$inertia.get(route('admin.menu-items'), { page: props.items.current_page + 1 })" class="px-3 py-1 rounded border">Next</button>
    </div>
    <!-- Add/Edit Menu Item Modal -->
    <div v-if="showForm" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 z-50">
      <div class="bg-white rounded shadow-lg p-6 w-full max-w-md relative">
        <button class="absolute top-2 right-2 text-gray-500 hover:text-black" @click="closeForm">&times;</button>
        <h2 class="text-xl font-bold mb-4">{{ isEdit ? 'Edit' : 'Add' }} Menu Item</h2>
        <form @submit.prevent="submitForm" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="block mb-1 font-medium">Menu</label>
            <select v-model="selectedMenuId" class="w-full border rounded px-3 py-2">
              <option value="">Select menu</option>
              <option v-for="menu in props.menus" :key="menu.id" :value="menu.id">{{ menu.name }}</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="block mb-1 font-medium">Category</label>
            <select v-model="form.category_id" class="w-full border rounded px-3 py-2">
              <option value="">Select category</option>
              <option v-for="cat in categoriesForSelectedMenu" :key="cat.id" :value="cat.id">{{ cat.name }}</option>
            </select>
            <div v-if="errors.category_id" class="text-red-600 text-sm mt-1">{{ errors.category_id }}</div>
          </div>
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
            <label class="block mb-1 font-medium">Allergens</label>
            <div class="flex flex-wrap gap-2">
              <label v-for="allergen in props.allergens" :key="allergen.id" class="flex items-center gap-1">
                <input type="checkbox" :value="allergen.id" v-model="form.allergens" />
                {{ allergen.name }}
              </label>
            </div>
            <div v-if="errors.allergens" class="text-red-600 text-sm mt-1">{{ errors.allergens }}</div>
          </div>
          <div class="mb-3">
            <label class="block mb-1 font-medium">Image</label>
            <input type="file" @change="onFileChange" accept="image/*" class="w-full border rounded px-3 py-2" />
            <div v-if="form.image && typeof form.image === 'string'" class="mt-2">
              <img :src="form.image" alt="Preview" class="w-20 h-20 object-cover rounded" />
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
import { ref, computed, defineProps } from 'vue';
import { useForm, router } from '@inertiajs/vue3';

interface Category {
  id: number;
  name: string;
  menu_ids: number[];
}
interface Menu {
  id: number;
  name: string;
  categories?: Category[];
}
interface Allergen {
  id: number;
  name: string;
}
interface MenuItem {
  id: number;
  name: string;
  description: string;
  price: string;
  image: string;
  category_id: string;
  allergens: { id: number; name: string }[];
  category?: Category;
}
interface ItemsPagination {
  data: MenuItem[];
  current_page: number;
  last_page: number;
}

const props = defineProps({
  menus: { type: Array as () => Menu[], default: () => [] },
  categories: { type: Array as () => Category[], default: () => [] },
  allergens: { type: Array as () => Allergen[], default: () => [] },
  items: { type: Object as () => ItemsPagination, default: () => ({ data: [], current_page: 1, last_page: 1 }) },
  user: { type: Object as () => { is_admin: boolean }, default: () => ({ is_admin: false }) },
});

const user = props.user || {};
const showForm = ref(false);
const isEdit = ref(false);
const showDeleteConfirm = ref(false);
const editId = ref<number|null>(null);
const itemToDelete = ref<MenuItem|null>(null);
const errors = ref<Record<string, string>>({});
const submitting = ref(false);
const deleting = ref(false);
const selectedMenuId = ref('');

const form = useForm({
  name: '',
  description: '',
  price: '',
  image: '',
  category_id: '',
  allergens: [] as number[],
});

const categoriesForSelectedMenu = computed(() => {
  if (!selectedMenuId.value) return [];
  return (props.categories || []).filter((cat: any) => Array.isArray(cat.menu_ids) && cat.menu_ids.includes(Number(selectedMenuId.value)));
});

const openAddForm = () => {
  showForm.value = true;
  isEdit.value = false;
  form.reset();
  errors.value = {};
  editId.value = null;
  selectedMenuId.value = '';
};

const openEditForm = (item: MenuItem) => {
  showForm.value = true;
  isEdit.value = true;
  form.name = item.name;
  form.description = item.description;
  form.price = item.price;
  form.image = item.image;
  form.category_id = item.category_id || '';
  form.allergens = item.allergens?.map((a: any) => a.id) || [];
  errors.value = {};
  editId.value = item.id;
  const cat = (props.categories || []).find((c: any) => c.id == item.category_id);
  if (cat && Array.isArray(cat.menu_ids) && cat.menu_ids.length > 0) {
    selectedMenuId.value = String(cat.menu_ids[0]);
  } else {
    selectedMenuId.value = '';
  }
};

const closeForm = () => {
  showForm.value = false;
  form.reset();
  errors.value = {};
  editId.value = null;
};

const onFileChange = (e: Event) => {
  const file = (e.target as HTMLInputElement).files?.[0];
  if (file) {
    form.image = file as any;
  }
};

const submitForm = () => {
  submitting.value = true;
  errors.value = {};
  if (isEdit.value && editId.value) {
    form.transform(data => ({ ...data, _method: 'put' })).post(route('menu-items.update', editId.value), {
      preserveScroll: true,
      onSuccess: () => { closeForm(); },
      onError: (err) => { errors.value = err; },
      forceFormData: true,
      onFinish: () => { submitting.value = false; },
    });
  } else {
    form.post(route('menu-items.store'), {
      preserveScroll: true,
      onSuccess: () => { closeForm(); },
      onError: (err) => { errors.value = err; },
      forceFormData: true,
      onFinish: () => { submitting.value = false; },
    });
  }
};

const confirmDelete = (item: MenuItem) => {
  itemToDelete.value = item;
  showDeleteConfirm.value = true;
};

const deleteItem = () => {
  if (!itemToDelete.value) return;
  deleting.value = true;
  router.delete(route('menu-items.destroy', itemToDelete.value.id), {
    preserveScroll: true,
    onSuccess: () => { showDeleteConfirm.value = false; itemToDelete.value = null; },
    onFinish: () => { deleting.value = false; },
  });
};
</script>

<style scoped>
</style>  